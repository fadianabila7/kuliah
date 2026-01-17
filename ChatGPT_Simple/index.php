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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_SESSION['user_id'])) {
    $nim = $conn->real_escape_string($_POST['nim']);
    $nama = $conn->real_escape_string($_POST['nama']);

    // Simpan data mahasiswa ke database
    $sql = "INSERT INTO users (nim, nama) VALUES ('$nim', '$nama')";
    if ($conn->query($sql)) {
        $_SESSION['user_id'] = $conn->insert_id;
    } else {
        die("Gagal menyimpan data mahasiswa: " . $conn->error);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $question = $conn->real_escape_string($_POST['question']);
    $userTokens = TextProcessor::preprocessText($question);

    // Simpan hasil preprocessText ke log
    $log['preprocessed_question'] = $userTokens;

    // Validasi input untuk menangani pertanyaan kosong atau tidak relevan
    $question = trim($_POST['question']);
    if (empty($question)) {
        $response = "Pertanyaan tidak boleh kosong. Silakan masukkan pertanyaan yang valid.";
        $log['response'] = $response;
    } else {
        // Ambil semua pertanyaan dari database
        $sql = "SELECT question, answer FROM qa";
        $result = $conn->query($sql);

        $bestMatch = null;
        $highestScore = 0;
        $tfidfScores = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $score = TextProcessor::calculateTFIDF($userTokens, $row['question']);
                $tfidfScores[] = [
                    'db_question' => $row['question'],
                    'tfidf_score' => $score
                ];
                if ($score > $highestScore) {
                    $highestScore = $score;
                    $bestMatch = $row['answer'];
                }
            }
        }

        // Simpan hasil TF-IDF ke log
        $log['tfidf_scores'] = $tfidfScores;

        if ($highestScore > 0) {
            $response = $bestMatch;
        } else {
            $response = "Maaf, saya tidak tahu jawabannya. Coba tanyakan yang lain.";
        }

        // Simpan ke database
        $datetime = date('Y-m-d H:i:s');
        $sql = "INSERT INTO chat_history (user_id, question, answer, created_at) VALUES ('$user_id', '$question', '$response', '$datetime')";
        if (!$conn->query($sql)) {
            die("Gagal menyimpan riwayat chat: " . $conn->error);
        }

        // Simpan ke session dengan waktu
        $_SESSION['chat_history'][] = [
            'question' => $question,
            'answer' => $response,
            'time' => $datetime
        ];

        // Simpan respons ke log
        $log['response'] = $response;
        $log['datetime'] = $datetime;
    }

    // Simpan log ke file log.json tanpa menghentikan eksekusi
    $logFile = 'log.json';
    $existingLogs = file_exists($logFile) ? json_decode(file_get_contents($logFile), true) : [];
    $existingLogs[] = $log;
    file_put_contents($logFile, json_encode($existingLogs, JSON_PRETTY_PRINT));
}

// Personalisasi respons dengan menyapa pengguna
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = "Halo! " . $response;
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
    <div class="chat-container">
        <div class="chat-header">
            <h4>ChatGPT Sederhana</h4>
        </div>
        <div class="chat-body">
            <?php if (!empty($_SESSION['chat_history'])): ?>
                <?php foreach ($_SESSION['chat_history'] as $chat): ?>
                    <div class="chat-bubble user">
                        <p><?php echo htmlspecialchars($chat['question']); ?></p>
                    </div>
                    <div class="chat-bubble bot">
                        <p><?php echo htmlspecialchars($chat['answer']); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
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