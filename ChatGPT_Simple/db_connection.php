<?php
// Koneksi ke database
$host = 'localhost';
$user = 'root';
$password = ''; // Ganti sesuai dengan password database Anda
$dbname = 'chatgpt_simulation';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>