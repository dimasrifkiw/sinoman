<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "sinoman";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    http_response_code(500);
    die("Koneksi gagal: " . $conn->connect_error);
}

if (isset($_POST['username']) && isset($_POST['password'])) {
    $input = $_POST['username'];
    $password = $_POST['password'];

    // Cek berdasarkan username atau email
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $input, $input);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            echo "login_success";
        } else {
            http_response_code(401);
            echo "Password salah.";
        }
    } else {
        http_response_code(404);
        echo "Akun belum terdaftar.";
    }

    $stmt->close();
} else {
    http_response_code(400);
    echo "Data tidak lengkap.";
}

$conn->close();
?>
