<?php
// Konfigurasi database
$host     = "localhost";  // Nama host (biasanya "localhost" di XAMPP)
$user     = "root";       // Username database (default "root" di XAMPP)
$password = "";           // Password database (kosong untuk XAMPP)
$database = "sinoman";    // Nama database (pastikan sudah dibuat di phpMyAdmin)

// Membuat koneksi ke database menggunakan MySQLi
$koneksi = mysqli_connect($host, $user, $password, $database);

// Periksa koneksi
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>
