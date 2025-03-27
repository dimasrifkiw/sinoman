<?php 
session_start(); // Memulai sesi

// Pastikan file konfigurasi database ada
if (file_exists("config.php")) {
    include("config.php");
} else {
    die("<p style='color: red;'>Error: File config.php tidak ditemukan.</p>");
}

$email = "";
$password = "";
$err = "";

// Proses login saat tombol ditekan
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($email == '' || $password == '') {
        $err .= "<li>Silahkan masukkan semua isian</li>";
    } else {
        // Query database untuk mencari pengguna
        $sql1 = "SELECT * FROM member WHERE email = '$email'";
        $q1 = mysqli_query($koneksi, $sql1);
        $n1 = mysqli_num_rows($q1);

        if ($n1 > 0) {
            $r1 = mysqli_fetch_array($q1);

            // Periksa status akun
            if ($r1['status'] != '1') {
                $err .= "<li>Akun yang kamu miliki belum aktif</li>";
            } 
            // Periksa password
            elseif ($r1['password'] != md5($password)) {
                $err .= "<li>Password tidak sesuai</li>";
            } else {
                // Login berhasil, simpan sesi pengguna
                $_SESSION['user_id'] = $r1['id'];
                $_SESSION['user_email'] = $r1['email'];
                
                // Redirect ke halaman dashboard atau index
                header("Location: dashboard.php");
                exit();
            }
        } else {
            $err .= "<li>Akun tidak ditemukan</li>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        /* Gaya dasar halaman */
        body {
            background: #c2b299;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        /* Kotak utama login */
        .login {
            position: relative;
            background: white;
            width: 380px;
            padding: 30px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            border: 2px solid #468ef9;
        }

        /* Avatar */
        .ellipse-1 {
            position: absolute;
            top: -40px;
            left: 50%;
            transform: translateX(-50%);
            background: #a7c2fd;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.3);
        }

        .ellipse-1 img {
            width: 50px;
        }

        /* Judul */
        .login2 {
            font-size: 24px;
            font-weight: bold;
            margin-top: 40px;
            color: black;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        /* Pesan error */
        .error {
            color: red;
            background: #ffdddd;
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
        }

        /* Input Field */
        .input-container {
            margin-top: 20px;
            display: flex;
            align-items: center;
            background: #f0f0f0;
            border-radius: 5px;
            padding: 10px;
            position: relative;
        }

        .input-container img {
            width: 16px;
            margin-right: 10px;
        }

        input {
            width: 100%;
            border: none;
            background: transparent;
            outline: none;
            font-size: 14px;
        }

        /* Tombol Login */
        .login-btn {
            margin-top: 20px;
            background: #468ef9;
            color: white;
            font-size: 16px;
            padding: 10px;
            width: 100%;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .login-btn:hover {
            background: #2563eb;
        }

        /* Remember Me & Forgot Password */
        .options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
            font-size: 14px;
        }

        .checkbox {
            display: flex;
            align-items: center;
        }

        .checkbox input {
            margin-right: 5px;
        }

        .forgot-password {
            color: #468ef9;
            text-decoration: none;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        /* Link Daftar */
        .daftar {
            margin-top: 10px;
            font-size: 14px;
        }

        .daftar a {
            color: #468ef9;
            text-decoration: none;
        }

        .daftar a:hover {
            text-decoration: underline;
        }

        /* Toggle Password */
        .toggle-password {
            position: absolute;
            right: 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <div class="login">
        <!-- Avatar -->
        <div class="ellipse-1">
            <img src="https://upload.wikimedia.org/wikipedia/commons/9/99/Sample_User_Icon.png" alt="User Icon">
        </div>

        <!-- Judul -->
        <div class="login2">LOGIN</div>

        <!-- Tampilkan pesan error jika ada -->
        <?php if ($err): ?>
            <div class="error">
                <ul><?php echo $err; ?></ul>
            </div>
        <?php endif; ?>

        <!-- Form Login -->
        <form action="" method="POST">
            <div class="input-container">
                <img src="https://cdn-icons-png.flaticon.com/512/1077/1077114.png" alt="User Icon">
                <input type="text" name="email" placeholder="Email" value="<?php echo htmlspecialchars($email); ?>">
            </div>

            <div class="input-container">
                <img src="https://cdn-icons-png.flaticon.com/512/565/565655.png" alt="Lock Icon">
                <input type="password" name="password" id="password" placeholder="Password">
                <span class="toggle-password" onclick="togglePassword()">👁</span>
            </div>

            <button type="submit" name="login" class="login-btn">Login</button>

            <div class="options">
                <div class="checkbox">
                    <input type="checkbox">
                    <label>Remember me</label>
                </div>
                <a href="lupapasword.html" class="forgot-password">Lupa password?</a>
            </div>

            <div class="daftar">
                <a href="daftar.html">Daftar</a>
            </div>
        </form>
    </div>

    <script>
        function togglePassword() {
            let passwordField = document.getElementById("password");
            let toggleIcon = document.querySelector(".toggle-password");
            passwordField.type = passwordField.type === "password" ? "text" : "password";
            toggleIcon.textContent = passwordField.type === "password" ? "👁" : "👁‍🗨";
        }
    </script>

</body>
</html>
