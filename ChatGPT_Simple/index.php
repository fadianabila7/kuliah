<?php

require_once 'db_connection.php';
require_once 'TextProcessor.php';

// Tambahkan riwayat chat
session_start();
if (!isset($_SESSION['chat_history'])) {
    $_SESSION['chat_history'] = [];
}

$response = "";

// Tambahkan logging untuk pertanyaan
$log = [];

// Tambahkan logging ke file log.json
$logFile = 'log.json';

// Pastikan session hanya menyimpan NIM dan nama
if (!isset($_SESSION['user_id'])) {
    echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            const modal = new bootstrap.Modal(document.getElementById("userModal"));
            modal.show();
        });
    </script>';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_SESSION['user_id'])) {
    $nim = $conn->real_escape_string($_POST['nim']);
    $nama = $conn->real_escape_string($_POST['nama']);

    // Simpan data mahasiswa ke database
    $sql = "INSERT INTO users (nim, nama) VALUES ('$nim', '$nama')";
    if ($conn->query($sql)) {
        $_SESSION['user_id'] = $conn->insert_id;
        $_SESSION['nim'] = $nim;
        $_SESSION['nama'] = $nama;
    } else {
        die("Gagal menyimpan data mahasiswa: " . $conn->error);
    }
}

// Tambahkan daftar sapaan
$greetings = ["selamat siang", "selamat sore", "hallo", "halo", "hai"];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id']) && isset($_POST['question'])) {

    $datetime = date('Y-m-d H:i:s');

    $user_id = $_SESSION['user_id'];
    $question = $conn->real_escape_string($_POST['question']);
    $userTokens = TextProcessor::preprocessText($question);
    $log['preprocessed_question'] = $userTokens;
    // Validasi input untuk menangani pertanyaan kosong atau sapaan
    $question = trim($_POST['question']);
    if (empty($question)) {
        $response = "Pertanyaan tidak boleh kosong. Silakan masukkan pertanyaan yang valid.";
    } elseif (in_array(strtolower($question), $greetings)) {
        $response = "Apa yang bisa saya bantu?";
    } else {
        // Ambil semua pertanyaan dari database
        $sql = "SELECT question, answer FROM qa";
        $result = $conn->query($sql);

        $bestMatch = null;
        $highestScore = 0;


        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $score = TextProcessor::calculateTFIDF($userTokens, $row['question']);
                if ($score > $highestScore) {
                    $highestScore = $score;
                    $bestMatch = $row['answer'];
                }
            }
        }

        $log['tfidf_scores'] = $tfidfScores;
        if ($highestScore > 0) {
            $response = $bestMatch;
        } else {
            $response = "Maaf, saya tidak tahu jawabannya. Coba tanyakan yang lain.";
        }
        // Simpan respons ke log
        $log['response'] = $response;
        $log['datetime'] = $datetime;
    }
    // Simpan ke database
    $sql = "INSERT INTO chat_history (user_id, question, answer, created_at) VALUES ('$user_id', '$question', '$response', '$datetime')";
    if (!$conn->query($sql)) {
        die("Gagal menyimpan riwayat chat: " . $conn->error);
    }
    // Simpan log ke file log.json tanpa menghentikan eksekusi
    $logFile = 'log.json';
    $existingLogs = file_exists($logFile) ? json_decode(file_get_contents($logFile), true) : [];
    $existingLogs[] = $log;
    file_put_contents($logFile, json_encode($existingLogs, JSON_PRETTY_PRINT));
}

// Ambil 5 pertanyaan terakhir dari database
$chatHistory = [];
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT question, answer, created_at FROM chat_history WHERE user_id = '$user_id' ORDER BY created_at ASC";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $chatHistory[] = $row;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChatGPT Sederhana</title>
    <!-- Tambahkan Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Tambahkan CSS Eksternal -->
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <!-- Modal untuk memasukkan NIM dan Nama -->
    <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userModalLabel">Masukkan Data Mahasiswa</h5>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nim" class="form-label">NIM</label>
                            <input type="text" class="form-control" id="nim" name="nim" required>
                        </div>
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="chat-container">
        <div class="chat-header">
            <h4>ChatGPT Sederhana</h4>
        </div>
        <div class="chat-body">
            <?php foreach ($chatHistory as $chat): ?>
                <div class="chat-bubble user">
                    <p><strong>[<?php echo $chat['created_at']; ?>]</strong> <?php echo htmlspecialchars($chat['question']); ?></p>
                </div>
                <div class="chat-bubble bot">
                    <p><?php echo htmlspecialchars($chat['answer']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="chat-footer">
            <form method="POST" class="d-flex">
                <input type="text" name="question" class="form-control me-2" placeholder="Ketik pesan..." required>
                <button type="submit" class="btn btn-primary">Kirim</button>
            </form>
        </div>
    </div>

    <!-- Tambahkan Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const chatBody = document.querySelector(".chat-body");
            chatBody.scrollTop = chatBody.scrollHeight;
        });
    </script>
</body>

</html>