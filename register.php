<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "sinoman";

// Koneksi ke database
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    http_response_code(500);
    die("Koneksi gagal: " . $conn->connect_error);
}

// Cek apakah semua data terkirim
if (
    isset($_POST['fullName']) && isset($_POST['nik']) &&
    isset($_POST['birthDate']) && isset($_POST['address']) &&
    isset($_POST['email']) && isset($_POST['phone']) &&
    isset($_POST['username']) && isset($_POST['password'])
) {
    // Ambil data dari POST
    $nama = $_POST['fullName'];
    $nik = $_POST['nik'];
    $tanggal_lahir = $_POST['birthDate'];
    $alamat = $_POST['address'];
    $email = $_POST['email'];
    $telepon = $_POST['phone'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // password di-hash

    // Siapkan dan eksekusi query (menggunakan prepared statement untuk keamanan)
    $stmt = $conn->prepare("INSERT INTO users (nama, nik, tanggal_lahir, alamat, email, telepon, username, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $nama, $nik, $tanggal_lahir, $alamat, $email, $telepon, $username, $password);

    if ($stmt->execute()) {
        echo "Pendaftaran berhasil!";
    } else {
        http_response_code(500);
        echo "Gagal menyimpan data: " . $stmt->error;
    }

    $stmt->close();
} else {
    http_response_code(400);
    echo "Data belum lengkap.";
}

$conn->close();
?>
