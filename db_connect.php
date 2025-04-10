<?php
$host = "localhost";
$user = "root";
$pass = "";

// 1. Buat koneksi awal ke MySQL tanpa memilih database
$conn = new mysqli($host, $user, $pass);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// 2. Buat database jika belum ada
$sql = "CREATE DATABASE IF NOT EXISTS sinoman";
if ($conn->query($sql) === TRUE) {
    echo "Database 'sinoman' berhasil dipastikan ada.<br>";
} else {
    die("Gagal membuat database: " . $conn->error);
}

// 3. Pilih database sinoman
$conn->select_db("sinoman");

// 4. Buat tabel users jika belum ada
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100),
    nik VARCHAR(20),
    tanggal_lahir DATE,
    alamat TEXT,
    email VARCHAR(100),
    telepon VARCHAR(20),
    username VARCHAR(50) UNIQUE,
    password VARCHAR(255)
)";

if ($conn->query($sql) === TRUE) {
    echo "Tabel 'users' berhasil dipastikan ada.<br>";
} else {
    echo "Gagal membuat tabel: " . $conn->error;
}

$conn->close();
?>
