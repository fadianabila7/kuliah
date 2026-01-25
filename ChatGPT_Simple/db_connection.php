<?php
// Koneksi ke database
$host = 'localhost:3308';
$user = 'root';
$password = ''; // Ganti sesuai dengan password database Anda
$dbname = 'db_chatgpt';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
