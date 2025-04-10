<?php
session_start();
include 'db_connect.php'; // koneksi database, bisa dipakai cek login
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SINOMAN - Sistem Informasi Antrean Omah Transparan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        header {
            position: fixed; /* Make header fixed */
            top: 0;
            left: 0;
            right: 0; /* Make sure it spans the full width */
            z-index: 1000; /* Ensure it is on top of other content */
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8fafc;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        .queue-animation {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        .nav-link {
            position: relative;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: white;
            transition: width 0.3s ease;
        }
        
        .nav-link:hover::after {
            width: 100%;
        }
        
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }
        
        .modal-content {
            background-color: white;
            padding: 2rem;
            border-radius: 0.5rem;
            width: 90%;
            max-width: 400px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            transform: translateY(-50px);
            opacity: 0;
            transition: all 0.3s ease;
        }
        
        .modal.active {
            display: flex;
        }
        
        .modal.active .modal-content {
            transform: translateY(0);
            opacity: 1;
        }
        
        .input-group {
            position: relative;
            margin-bottom: 1.5rem;
        }
        
        .input-group input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            outline: none;
            transition: all 0.2s ease;
        }
        
        .input-group input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        
        .input-group label {
            position: absolute;
            left: 0.75rem;
            top: 0.75rem;
            color: #6b7280;
            transition: all 0.2s ease;
            pointer-events: none;
            background-color: white;
            padding: 0 0.25rem;
        }
        
        .input-group input:focus + label,
        .input-group input:not(:placeholder-shown) + label {
            transform: translateY(-1.5rem) scale(0.85);
            color: #3b82f6;
        }
        
        .social-login-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem;
            border-radius: 0.375rem;
            border: 1px solid #d1d5db;
            background-color: white;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .social-login-btn:hover {
            background-color: #f9fafb;
        }
        
        .social-login-btn.google {
            color: #db4437;
        }
        
        .social-login-btn.facebook {
            color: #4267B2;
        }
        
        .divider {
            display: flex;
            align-items: center;
            margin: 1.5rem 0;
        }
        
        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background-color: #e5e7eb;
        }
        
        .divider-text {
            padding: 0 1rem;
            color: #6b7280;
            font-size: 0.875rem;
        }
        
        .user-dropdown {
            display: none;
            position: absolute;
            right: 0;
            top: 100%;
            background-color: white;
            min-width: 200px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            border-radius: 0.5rem;
            z-index: 50;
            padding: 0.5rem 0;
        }
        
        .user-dropdown.active {
            display: block;
        }
        
        .user-dropdown a {
            display: block;
            padding: 0.5rem 1rem;
            color: #4b5563;
            transition: all 0.2s ease;
        }
        
        .user-dropdown a:hover {
            background-color: #f3f4f6;
            color: #1f2937;
        }

        /* Queue Result Styles */
        .queue-result {
            display: none;
            background-color: #3b82f6;
            padding: 1.5rem;
            border-radius: 0.5rem;
            margin-top: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .queue-result.active {
            display: block;
        }

        .queue-position {
            font-size: 2rem;
            font-weight: bold;
            color: #ffffff;
            text-align: center;
            margin: 1rem 0;
        }

        /* Registration Modal */
        .registration-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .registration-modal.active {
            display: flex;
        }

        .registration-content {
            background-color: white;
            padding: 2rem;
            border-radius: 0.5rem;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            transform: translateY(-50px);
            opacity: 0;
            transition: all 0.3s ease;
            max-height: 90vh;
            overflow-y: auto;
        }

        .registration-modal.active .registration-content {
            transform: translateY(0);
            opacity: 1;
        }

        .form-step {
            display: none;
        }

        .form-step.active {
            display: block;
        }

        .step-indicator {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2rem;
            position: relative;
        }

        .step-indicator::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 2px;
            background-color: #e5e7eb;
            z-index: 1;
            transform: translateY(-50%);
        }

        .step {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6b7280;
            font-weight: bold;
            position: relative;
            z-index: 2;
        }

        .step.active {
            background-color: #3b82f6;
            color: white;
        }

        .step.completed {
            background-color: #10b981;
            color: white;
        }

            /* Image Carousel Styles */
            .carousel-container {
            position: relative;
            width: 100%;
            max-width: 940px;
            margin: 0 auto;
            overflow: hidden;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .carousel {
            display: flex;
            transition: transform 0.5s ease-in-out;
            height: 600px;
        }

        .carousel-slide {
            min-width: 100%;
            position: relative;
        }

        .carousel-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .carousel-caption {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.6);
            color: white;
            padding: 20px;
            text-align: center;
        }

        .carousel-caption h3 {
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        .carousel-caption p {
            font-size: 1rem;
        }

        .carousel-nav {
            position: absolute;
            top: 50%;
            width: 100%;
            display: flex;
            justify-content: space-between;
            transform: translateY(-50%);
            z-index: 10;
        }

        .carousel-nav button {
            background: rgba(255, 255, 255, 0.5);
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin: 0 20px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .carousel-nav button:hover {
            background: rgba(255, 255, 255, 0.8);
        }

        .carousel-indicators {
            position: absolute;
            bottom: 20px;
            left: 0;
            right: 0;
            display: flex;
            justify-content: center;
            gap: 10px;
            z-index: 10;
        }

        .carousel-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .carousel-indicator.active {
            background: white;
            transform: scale(1.2);
        }

        @media (max-width: 768px) {
            .carousel {
                height: 300px;
            }
            
            .carousel-caption h3 {
                font-size: 1.2rem;
            }
            
            .carousel-caption p {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <!-- Header/Navigation -->
    <header class="gradient-bg text-white shadow-lg">
        <div class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-2">
                    <img  src="sinoman.png" alt="logo sinoman" class="h-10">
                </div>
                <nav class="hidden md:flex space-x-8">
                    <a href="#home" class="nav-link">Beranda</a>
                    <a href="#features" class="nav-link">Fitur</a>
                    <a href="#about" class="nav-link">Tentang</a>
                    <a href="#queue" class="nav-link">Cek Antrian</a>
                    <a href="#contact" class="nav-link">Kontak</a>
                </nav>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <button id="loginButton" class="bg-white text-blue-600 px-4 py-2 rounded-full font-medium hover:bg-blue-50 transition">
                            <i class="fas fa-sign-in-alt mr-2"></i>Masuk
                        </button>
                        <div id="userDropdown" class="user-dropdown">
                            <a href="pengaturan.html" class="flex items-center">
                                <i class="fas fa-cog mr-2"></i> Pengaturan
                            </a>
                            <div class="border-t border-gray-200 my-1"></div>
                            <a href="#" id="logoutButton" class="flex items-center text-red-500">
                                <i class="fas fa-sign-out-alt mr-2"></i> Keluar
                            </a>
                        </div>
                    </div>
                    <button class="md:hidden text-white">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Login Modal -->
<div id="loginModal" class="modal">
    <div class="modal-content">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Masuk ke SINOMAN</h2>
            <button id="closeModal" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <form id="loginForm">
            <div class="input-group">
                <input type="text" id="username" name="username" placeholder=" " required>
                <label for="username">Nama Pengguna atau Email</label>
            </div>

            <div class="input-group">
                <input type="password" id="password" name="password" placeholder=" " required>
                <label for="password">Kata Sandi</label>
            </div>

            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center">
                    <input type="checkbox" id="remember" class="mr-2">
                    <label for="remember" class="text-sm text-gray-600">Ingat saya</label>
                </div>
                <a href="#" class="text-sm text-blue-600 hover:underline">Lupa kata sandi?</a>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg font-medium hover:bg-blue-700 transition mb-4">
                Masuk
            </button>

            <div class="text-center text-sm text-gray-600 mb-4">
                Belum punya akun? <a href="#" id="showRegistration" class="text-blue-600 hover:underline">Daftar sekarang</a>
            </div>
        </form>
    </div>
</div>

    <!-- Registration Modal -->
    <div id="registrationModal" class="registration-modal">
        <div class="registration-content">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Pendaftaran Akun SINOMAN</h2>
                <button id="closeRegistration" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="step-indicator">
                <div class="step active" id="step1">1</div>
                <div class="step" id="step2">2</div>
                <div class="step" id="step3">3</div>
            </div>

            <form id="registrationForm" action="register.php" method="post">
                <!-- Step 1: Personal Information -->
                <div class="form-step active" id="formStep1">
                    <h3 class="text-lg font-semibold mb-4">Informasi Pribadi</h3>
                    
                    <div class="input-group mb-4">
                        <input type="text" id="fullName" name="fullName" placeholder=" " required>
                        <label for="fullName">Nama Lengkap</label>
                    </div>
                    
                    <div class="input-group mb-4">
                        <input type="text" id="nik" name="nik" placeholder=" " required>
                        <label for="nik">NIK</label>
                    </div>
                    
                    <div class="input-group mb-4">
                        <input type="date" id="birthDate" name="birthDate" placeholder=" " required>
                        <label for="birthDate">Tanggal Lahir</label>
                    </div>
                    
                    <div class="input-group mb-4">
                        <input type="text" id="address" name="address" placeholder=" " required>
                        <label for="address">Alamat</label>
                    </div>
                    
                    <div class="flex justify-end">
                        <button type="button" class="next-step bg-blue-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-blue-700 transition">
                            Selanjutnya <i class="fas fa-arrow-right ml-2"></i>
                        </button>
                    </div>
                </div>
            
                <!-- Step 2: Account Information -->
                <div class="form-step" id="formStep2">
                    <h3 class="text-lg font-semibold mb-4">Informasi Akun</h3>
                    
                    <div class="input-group mb-4">
                        <input type="email" id="email" name="email" placeholder=" " required>
                        <label for="email">Email</label>
                    </div>
                    
                    <div class="input-group mb-4">
                        <input type="text" id="phone" name="phone" placeholder=" " required>
                        <label for="phone">Nomor Telepon</label>
                    </div>
                    
                    <div class="input-group mb-4">
                        <input type="text" id="usernameReg" name="username" placeholder=" " required>
                        <label for="usernameReg">Nama Pengguna</label>
                    </div>
                    
                    <div class="input-group mb-4">
                        <input type="password" id="passwordReg" name="password" placeholder=" " required>
                        <label for="passwordReg">Kata Sandi</label>
                    </div>
                    
                    <div class="input-group mb-4">
                        <input type="password" id="confirmPassword" name="confirmPassword" placeholder=" " required>
                        <label for="confirmPassword">Konfirmasi Kata Sandi</label>
                    </div>
                    
                    <div class="flex justify-between">
                        <button type="button" class="prev-step bg-gray-300 text-gray-800 px-4 py-2 rounded-lg font-medium hover:bg-gray-400 transition">
                            <i class="fas fa-arrow-left mr-2"></i> Sebelumnya
                        </button>
                        <button type="button" class="next-step bg-blue-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-blue-700 transition">
                            Selanjutnya <i class="fas fa-arrow-right ml-2"></i>
                        </button>
                    </div>
                </div>
            
                <!-- Step 3: Confirmation -->
                <div class="form-step" id="formStep3">
                    <h3 class="text-lg font-semibold mb-4">Konfirmasi Data</h3>
                    
                    <div class="bg-gray-50 p-4 rounded-lg mb-4">
                        <h4 class="font-medium mb-2">Informasi Pribadi</h4>
                        <p id="confirmFullName"></p>
                        <p id="confirmNik"></p>
                        <p id="confirmBirthDate"></p>
                        <p id="confirmAddress"></p>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg mb-4">
                        <h4 class="font-medium mb-2">Informasi Akun</h4>
                        <p id="confirmEmail"></p>
                        <p id="confirmPhone"></p>
                        <p id="confirmUsername"></p>
                    </div>
                    
                    <div class="flex items-center mb-4">
                        <input type="checkbox" id="agreeTerms" name="agreeTerms" class="mr-2" required>
                        <label for="agreeTerms" class="text-sm">Saya menyetujui <a href="#" class="text-blue-600 hover:underline">Syarat dan Ketentuan</a> yang berlaku</label>
                    </div>
                    
                    <div class="flex justify-between">
                        <button type="button" class="prev-step bg-gray-300 text-gray-800 px-4 py-2 rounded-lg font-medium hover:bg-gray-400 transition">
                            <i class="fas fa-arrow-left mr-2"></i> Sebelumnya
                        </button>
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-green-700 transition">
                            <i class="fas fa-check mr-2"></i> Daftar Sekarang
                        </button>
                    </div>
                </div>
            </form>            
        </div>
    </div>

    <!-- Ganti bagian Hero Section dengan ini -->
        <section id="home" class="relative py-16 md:py-24 text-white">
            <!-- Background Image -->
                <div class="absolute inset-0 z-0">
                <img src="background.png" 
                    alt="Background Perumahan" 
                    class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-blue-900 opacity-70"></div>
                </div>
    
    <!-- Konten -->
    <div class="container mx-auto px-4 flex flex-col md:flex-row items-center relative z-10">
        <div class="md:w-1/2 mb-10 md:mb-0">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">Sistem Informasi Antrean Omah Transparan</h1>
            <p class="text-xl mb-8">Solusi terintegrasi dan transparan untuk sistem antrian perumahan bagi masyarakat berpenghasilan rendah (MBR).</p>
            <div class="flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-4">
                <button id="registerNowButton" class="bg-white text-blue-600 px-6 py-3 rounded-full font-bold hover:bg-blue-50 transition flex items-center justify-center">
                  <i class="fas fa-user-plus mr-2"></i> Daftar Sekarang
                </button>
                <div class="bg-yellow-400 text-gray-800 px-6 py-3 rounded-lg shadow-lg font-bold flex items-center queue-animation">
                  <i class="fas fa-users mr-2"></i> 1.245 Antrian
                </div>
            </div>
        </div>
    </div>
</section>

    <!-- Features Section -->
    <section id="features" class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Fitur Unggulan SINOMAN</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Sistem yang dirancang khusus untuk memberikan kemudahan dan transparansi dalam proses antrian perumahan MBR.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="feature-card bg-gray-50 p-8 rounded-xl transition duration-300 hover:shadow-md">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-user-edit text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Pendaftaran Online</h3>
                    <p class="text-gray-600">Daftar secara online dengan mudah, lengkapi data pribadi, unggah dokumen, dan pilih lokasi perumahan yang diinginkan.</p>
                </div>
                
                <!-- Feature 2 -->
                <div class="feature-card bg-gray-50 p-8 rounded-xl transition duration-300 hover:shadow-md">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-list-ol text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Manajemen Antrian</h3>
                    <p class="text-gray-600">Sistem mengurutkan calon penghuni berdasarkan kriteria seperti status ekonomi dan prioritas keluarga secara adil.</p>
                </div>
                
                <!-- Feature 3 -->
                <div class="feature-card bg-gray-50 p-8 rounded-xl transition duration-300 hover:shadow-md">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-chart-line text-purple-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Transparansi Data</h3>
                    <p class="text-gray-600">Pantau posisi antrian secara real-time melalui dashboard yang interaktif dan mudah dipahami.</p>
                </div>
                
                <!-- Feature 4 -->
                <div class="feature-card bg-gray-50 p-8 rounded-xl transition duration-300 hover:shadow-md">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-check-circle text-red-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Verifikasi Otomatis</h3>
                    <p class="text-gray-600">Terintegrasi dengan database pemerintah untuk memverifikasi data calon penghuni secara otomatis dan akurat.</p>
                </div>
                
                <!-- Feature 5 -->
                <div class="feature-card bg-gray-50 p-8 rounded-xl transition duration-300 hover:shadow-md">
                    <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-bell text-yellow-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Notifikasi</h3>
                    <p class="text-gray-600">Dapatkan pemberitahuan tentang perkembangan antrian, jadwal verifikasi, dan informasi penting lainnya.</p>
                </div>
                
                <!-- Feature 6 -->
                <div class="feature-card bg-gray-50 p-8 rounded-xl transition duration-300 hover:shadow-md">
                    <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-headset text-indigo-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Pengaduan & Bantuan</h3>
                    <p class="text-gray-600">Fitur pengaduan dan pusat bantuan online untuk memastikan Anda mendapatkan dukungan yang dibutuhkan.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-16 bg-gray-50">
        <div class="container mx-auto px-4 flex flex-col md:flex-row items-center">
            <div class="md:w-1/2 mb-10 md:mb-0 md:pr-10">
                <img src="rumah 3.png" alt="Perumahan MBR" class="rounded-lg shadow-lg w-full">
            </div>
            <div class="md:w-1/2">
                <h2 class="text-3xl font-bold text-gray-800 mb-6">Tentang SINOMAN</h2>
                <p class="text-gray-600 mb-4">SINOMAN (Sistem Informasi Antrean Omah Transparan) adalah aplikasi yang dirancang untuk menyediakan solusi terintegrasi dan transparan dalam sistem antrian perumahan (housing queue), khususnya bagi masyarakat berpenghasilan rendah (MBR).</p>
                <p class="text-gray-600 mb-6">Dengan sistem yang adil dan terbuka, SINOMAN bertujuan untuk mempermudah proses mendapatkan rumah layak huni bagi masyarakat yang membutuhkan.</p>
                
                <div class="flex flex-wrap gap-4">
                    <div class="flex items-center bg-white px-4 py-2 rounded-lg shadow-sm">
                        <i class="fas fa-check-circle text-green-500 mr-2"></i>
                        <span>Proses Transparan</span>
                    </div>
                    <div class="flex items-center bg-white px-4 py-2 rounded-lg shadow-sm">
                        <i class="fas fa-check-circle text-green-500 mr-2"></i>
                        <span>Sistem yang Adil</span>
                    </div>
                    <div class="flex items-center bg-white px-4 py-2 rounded-lg shadow-sm">
                        <i class="fas fa-check-circle text-green-500 mr-2"></i>
                        <span>Terintegrasi dengan Pemerintah</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Queue Check Section -->
    <section id="queue" class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl p-8 text-white shadow-lg">
                <h2 class="text-2xl font-bold mb-6">Cek Posisi Antrian Anda</h2>
                <p class="mb-8">Masukkan nomor pendaftaran atau NIK Anda untuk memeriksa posisi antrian saat ini.</p>
                
                <div class="flex flex-col md:flex-row gap-4">
                    <input type="text" id="queueNumber" placeholder="Nomor Pendaftaran / NIK" class="flex-grow px-4 py-3 rounded-lg text-gray-800">
                    <button id="checkQueue" class="bg-yellow-400 text-gray-800 px-6 py-3 rounded-lg font-bold hover:bg-yellow-300 transition flex items-center justify-center">
                        <i class="fas fa-search mr-2"></i> Cek Sekarang
                    </button>
                </div>
                
                <div id="queueResult" class="queue-result">
                    <h3 class="text-lg font-semibold mb-2">Status Antrian Anda</h3>
                    <p id="queueNumberDisplay" class="text-sm opacity-80"></p>
                    <div class="queue-position" id="queuePosition"></div>
                    <p class="text-center">Total antrian saat ini: <span id="totalQueue">1,245</span> orang</p>
                    <div class="mt-4 bg-white bg-opacity-20 p-3 rounded-lg">
                        <p class="text-sm">Estimasi waktu tunggu: <span id="waitTime">3-6 bulan</span></p>
                    </div>
                </div>
                
                <div class="mt-8 bg-white bg-opacity-20 p-4 rounded-lg">
                    <h3 class="font-bold mb-2">Status Antrian Terkini</h3>
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm">Total Pendaftar</p>
                            <p class="text-xl font-bold">3,245</p>
                        </div>
                        <div>
                            <p class="text-sm">Dalam Proses</p>
                            <p class="text-xl font-bold">1,128</p>
                        </div>
                        <div>
                            <p class="text-sm">Terverifikasi</p>
                            <p class="text-xl font-bold">876</p>
                        </div>
                        <div>
                            <p class="text-sm">Diterima</p>
                            <p class="text-xl font-bold">542</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

       <!-- Image Carousel Section -->
       <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Galeri Perumahan MBR</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Lihat contoh perumahan yang telah dibangun untuk masyarakat berpenghasilan rendah</p>
            </div>
            
            <div class="carousel-container">
                <div class="carousel" id="carousel">
                    <div class="carousel-slide">
                        <img src="rumah 1.png" alt="Perumahan MBR 1">
                        <div class="carousel-caption">
                            <h3>Perumahan MBR Tipe 36</h3>
                            <p>Perumahan dengan luas bangunan 36m² yang nyaman dan terjangkau</p>
                        </div>
                    </div>
                    <div class="carousel-slide">
                        <img src="rumah 2.png" alt="Perumahan MBR 2">
                        <div class="carousel-caption">
                            <h3>Kawasan Perumahan MBR</h3>
                            <p>Lingkungan yang asri dengan fasilitas umum yang memadai</p>
                        </div>
                    </div>
                    <div class="carousel-slide">
                        <img src="rumah 4.png" alt="Perumahan MBR 3">
                        <div class="carousel-caption">
                            <h3>Interior Rumah MBR</h3>
                            <p>Desain interior yang fungsional untuk keluarga kecil</p>
                        </div>
                    </div>
                </div>
                
                <div class="carousel-nav">
                    <button id="prevBtn"><i class="fas fa-chevron-left"></i></button>
                    <button id="nextBtn"><i class="fas fa-chevron-right"></i></button>
                </div>
                
                <div class="carousel-indicators">
                    <div class="carousel-indicator active" data-slide="0"></div>
                    <div class="carousel-indicator" data-slide="1"></div>
                    <div class="carousel-indicator" data-slide="2"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Hubungi Kami</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Kantor Pelayanan</h3>
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <i class="fas fa-map-marker-alt text-blue-600 mt-1 mr-4"></i>
                                <div>
                                    <h4 class="font-medium">Alamat</h4>
                                    <p class="text-gray-600">Jl. Laksda Adisucipto No.66, Demangan Baru, Caturtunggal, Kec. Depok, Kabupaten Sleman, Daerah Istimewa Yogyakarta 55281</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <i class="fas fa-phone-alt text-blue-600 mt-1 mr-4"></i>
                                <div>
                                    <h4 class="font-medium">Telepon</h4>
                                    <p class="text-gray-600">(021) 1234-5678</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <i class="fas fa-envelope text-blue-600 mt-1 mr-4"></i>
                                <div>
                                    <h4 class="font-medium">Email</h4>
                                    <p class="text-gray-600">info@sinoman.go.id</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <i class="fas fa-clock text-blue-600 mt-1 mr-4"></i>
                                <div>
                                    <h4 class="font-medium">Jam Operasional</h4>
                                    <p class="text-gray-600">Senin-Jumat: 08.00-16.00 WIB</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-8">
                            <h3 class="text-xl font-bold text-gray-800 mb-4">Media Sosial</h3>
                            <div class="flex space-x-4">
                                <a href="https://www.facebook.com/share/1BddpaYc9n/?mibextid=wwXIfr" class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 hover:bg-blue-200">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="https://www.youtube.com/@KRSSeJaTi" class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-red-400 hover:bg-blue-200">
                                    <i class="fab fa-youtube"></i>
                                </a>
                                <a href="https://www.instagram.com/krs_jawa3?igsh=MTQzbmNsZ3FrNXJhcA==" class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-pink-600 hover:bg-blue-200">
                                    <i class="fab fa-instagram"></i>
                                </a>
                                <a href="https://api.whatsapp.com/send/?phone=%2B6282137191145&text&type=phone_number&app_absent=0" class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-green-500 hover:bg-blue-200">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Kirim Pesan</h3>
                        <form class="space-y-4">
                            <div>
                                <label for="name" class="block text-gray-700 mb-1">Nama Lengkap</label>
                                <input type="text" id="name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label for="email" class="block text-gray-700 mb-1">Email</label>
                                <input type="email" id="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label for="subject" class="block text-gray-700 mb-1">Subjek</label>
                                <input type="text" id="subject" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label for="message" class="block text-gray-700 mb-1">Pesan</label>
                                <textarea id="message" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                            </div>
                            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-blue-700 transition">
                                <i class="fas fa-paper-plane mr-2"></i> Kirim Pesan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto">
                <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Pertanyaan yang Sering Diajukan</h2>
                
                <div class="space-y-4">
                    <!-- FAQ 1 -->
                    <div class="bg-white p-5 rounded-xl shadow-sm">
                        <button class="flex justify-between items-center w-full text-left font-medium text-gray-800">
                            <span>Bagaimana cara mendaftar di SINOMAN?</span>
                            <i class="fas fa-chevron-down text-blue-600 transition-transform duration-300"></i>
                        </button>
                        <div class="mt-3 text-gray-600 hidden">
                            <p>Anda dapat mendaftar melalui website ini dengan mengklik tombol "Daftar Sekarang" di bagian atas halaman. Isi formulir pendaftaran dengan data yang valid dan lengkapi dokumen pendukung yang diperlukan.</p>
                        </div>
                    </div>
                    
                    <!-- FAQ 2 -->
                    <div class="bg-white p-5 rounded-xl shadow-sm">
                        <button class="flex justify-between items-center w-full text-left font-medium text-gray-800">
                            <span>Dokumen apa saja yang diperlukan untuk pendaftaran?</span>
                            <i class="fas fa-chevron-down text-blue-600 transition-transform duration-300"></i>
                        </button>
                        <div class="mt-3 text-gray-600 hidden">
                            <p>Dokumen yang diperlukan antara lain:</p>
                            <ul class="list-disc pl-5 mt-2 space-y-1">
                                <li>Fotokopi KTP</li>
                                <li>Fotokopi Kartu Keluarga</li>
                                <li>Surat keterangan tidak mampu dari kelurahan</li>
                                <li>Slip gaji atau surat keterangan penghasilan</li>
                                <li>Dokumen pendukung lainnya sesuai persyaratan</li>
                            </ul>
                        </div>
                    </div>
                    
                    <!-- FAQ 3 -->
                    <div class="bg-white p-5 rounded-xl shadow-sm">
                        <button class="flex justify-between items-center w-full text-left font-medium text-gray-800">
                            <span>Berapa lama waktu tunggu untuk mendapatkan rumah?</span>
                            <i class="fas fa-chevron-down text-blue-600 transition-transform duration-300"></i>
                        </button>
                        <div class="mt-3 text-gray-600 hidden">
                            <p>Waktu tunggu bervariasi tergantung pada ketersediaan unit perumahan dan jumlah pendaftar. Rata-rata waktu tunggu adalah 1-2 tahun. Anda dapat memantau posisi antrian Anda melalui dashboard setelah mendaftar.</p>
                        </div>
                    </div>
                    
                    <!-- FAQ 4 -->
                    <div class="bg-white p-5 rounded-xl shadow-sm">
                        <button class="flex justify-between items-center w-full text-left font-medium text-gray-800">
                            <span>Bagaimana jika data saya tidak valid saat verifikasi?</span>
                            <i class="fas fa-chevron-down text-blue-600 transition-transform duration-300"></i>
                        </button>
                        <div class="mt-3 text-gray-600 hidden">
                            <p>Sistem akan mengirimkan notifikasi jika ditemukan ketidaksesuaian data. Anda dapat memperbaiki dan mengunggah ulang dokumen yang diperlukan dalam waktu 14 hari kerja. Jika melebihi batas waktu, pendaftaran Anda akan dibatalkan.</p>
                        </div>
                    </div>
                    
                    <!-- FAQ 5 -->
                    <div class="bg-white p-5 rounded-xl shadow-sm">
                        <button class="flex justify-between items-center w-full text-left font-medium text-gray-800">
                            <span>Apakah ada biaya pendaftaran?</span>
                            <i class="fas fa-chevron-down text-blue-600 transition-transform duration-300"></i>
                        </button>
                        <div class="mt-3 text-gray-600 hidden">
                            <p>Pendaftaran di SINOMAN tidak dikenakan biaya sama sekali. Waspadalah terhadap pihak yang meminta biaya dengan mengatasnamakan SINOMAN.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-blue-600 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <img  src="sinoman.png" alt="logo sinoman" class="h-20">
                    </div>
                    <p class="text-white-400">Sistem Informasi Antrean Omah Transparan untuk masyarakat berpenghasilan rendah.</p>
                </div>
                
                <div>
                    <h4 class="text-lg font-bold mb-4">Tautan Cepat</h4>
                    <ul class="space-y-2">
                        <li><a href="#home" class="text-white-400 hover:text-white transition">Beranda</a></li>
                        <li><a href="#features" class="text-white-400 hover:text-white transition">Fitur</a></li>
                        <li><a href="#about" class="text-white-400 hover:text-white transition">Tentang</a></li>
                        <li><a href="#queue" class="text-white-400 hover:text-white transition">Cek Antrian</a></li>
                        <li><a href="#contact" class="text-white-400 hover:text-white transition">Kontak</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-lg font-bold mb-4">Dokumen</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-white-400 hover:text-white transition">Syarat dan Ketentuan</a></li>
                        <li><a href="#" class="text-white-400 hover:text-white transition">Kebijakan Privasi</a></li>
                        <li><a href="#" class="text-white-400 hover:text-white transition">Panduan Pengguna</a></li>
                        <li><a href="#" class="text-white-400 hover:text-white transition">FAQ</a></li>
                    </ul>
                </div>
                </div>
            </div>
            
            <div class="border-t border-gray-700 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-white-400 mb-4 md:mb-0">© 2023 SINOMAN. Hak Cipta Dilindungi.</p>
                <div class="flex space-x-6">
                    <a href="#" class="text-white-400 hover:text-white transition"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-white-400 hover:text-white transition"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-white-400 hover:text-white transition"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button id="backToTop" class="fixed bottom-8 right-8 bg-blue-600 text-white w-12 h-12 rounded-full shadow-lg flex items-center justify-center opacity-0 invisible transition-all duration-300">
        <i class="fas fa-arrow-up"></i>
    </button>

    <script>
    // Login System
    const loginButton = document.getElementById('loginButton');
    const loginModal = document.getElementById('loginModal');
    const closeModal = document.getElementById('closeModal');
    const loginForm = document.getElementById('loginForm');
    const userDropdown = document.getElementById('userDropdown');
    const logoutButton = document.getElementById('logoutButton');

    // Check if user is logged in from localStorage
    let isLoggedIn = localStorage.getItem('isLoggedIn') === 'true';

    // Update UI based on login status
    function updateLoginStatus() {
        if (isLoggedIn) {
            loginButton.innerHTML = '<i class="fas fa-user-circle mr-2"></i>Akun Saya';
            loginButton.classList.remove('bg-white', 'text-blue-600');
            loginButton.classList.add('bg-blue-700', 'text-white');
        } else {
            loginButton.innerHTML = '<i class="fas fa-sign-in-alt mr-2"></i>Masuk';
            loginButton.classList.remove('bg-blue-700', 'text-white');
            loginButton.classList.add('bg-white', 'text-blue-600');
        }
    }

    // Initialize
    updateLoginStatus();

    // Toggle login modal
    loginButton.addEventListener('click', function (e) {
        if (isLoggedIn) {
            // Toggle dropdown if logged in
            userDropdown.classList.toggle('active');
        } else {
            // Show login modal if not logged in
            loginModal.classList.add('active');
            setTimeout(() => {
                document.querySelector('.modal-content').style.transform = 'translateY(0)';
                document.querySelector('.modal-content').style.opacity = '1';
            }, 10);
        }
    });

    // Close modal
    closeModal.addEventListener('click', function () {
        loginModal.classList.remove('active');
        document.querySelector('.modal-content').style.transform = 'translateY(-50px)';
        document.querySelector('.modal-content').style.opacity = '0';
    });

    // Login form submission
    loginForm.addEventListener('submit', function (e) {
        e.preventDefault();

        const username = document.getElementById('username').value.trim();
        const password = document.getElementById('password').value;

        fetch('login.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `username=${encodeURIComponent(username)}&password=${encodeURIComponent(password)}`
        })
            .then(res => {
                if (!res.ok) throw res;
                return res.text();
            })
            .then(response => {
                if (response === 'login_success') {
                    isLoggedIn = true;
                    localStorage.setItem('isLoggedIn', 'true');
                    updateLoginStatus();
                    loginModal.classList.remove('active');
                    alert('Login berhasil! Selamat datang kembali.');
                } else {
                    alert(response); // misalnya: "Akun belum terdaftar", "Password salah"
                }
            })
            .catch(async (err) => {
                const message = await err.text();
                alert(message || 'Terjadi kesalahan saat login.');
            });
    });
        
        // Logout
        logoutButton.addEventListener('click', function() {
            isLoggedIn = false;
            localStorage.setItem('isLoggedIn', 'false');
            updateLoginStatus();
            userDropdown.classList.remove('active');
            alert('Anda telah keluar dari sistem.');
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.relative') && userDropdown.classList.contains('active')) {
                userDropdown.classList.remove('active');
            }
        });

        // Queue Check System
        const checkQueueButton = document.getElementById('checkQueue');
        const queueNumberInput = document.getElementById('queueNumber');
        const queueResult = document.getElementById('queueResult');
        const queueNumberDisplay = document.getElementById('queueNumberDisplay');
        const queuePosition = document.getElementById('queuePosition');
        const totalQueue = document.getElementById('totalQueue');
        const waitTime = document.getElementById('waitTime');

        // Dummy queue positions
        const dummyQueues = {
            '111': 10,
            '222': 31,
            '333': 5
        };

        checkQueueButton.addEventListener('click', function() {
            const queueNumber = queueNumberInput.value.trim();
            
            if (!queueNumber) {
                alert('Silakan masukkan nomor pendaftaran atau NIK Anda.');
                return;
            }
            
            // Check if the input matches any dummy queue
            if (dummyQueues.hasOwnProperty(queueNumber)) {
                queueNumberDisplay.textContent = `Nomor Pendaftaran: ${queueNumber}`;
                queuePosition.textContent = dummyQueues[queueNumber];
                
                // Set different wait times based on position
                if (dummyQueues[queueNumber] <= 10) {
                    waitTime.textContent = '1-2 bulan';
                } else if (dummyQueues[queueNumber] <= 30) {
                    waitTime.textContent = '3-5 bulan';
                } else {
                    waitTime.textContent = '6-12 bulan';
                }
                
                queueResult.classList.add('active');
            } else {
                alert('Nomor pendaftaran/NIK tidak ditemukan. Pastikan Anda telah mendaftar.');
                queueResult.classList.remove('active');
            }
        });

        // Registration System
        const registerNowButton = document.getElementById('registerNowButton');
        const registrationModal = document.getElementById('registrationModal');
        const closeRegistration = document.getElementById('closeRegistration');
        const showRegistration = document.getElementById('showRegistration');
        const registrationForm = document.getElementById('registrationForm');
        
        // Open registration modal
        registerNowButton.addEventListener('click', function() {
            registrationModal.classList.add('active');
            setTimeout(() => {
                document.querySelector('.registration-content').style.transform = 'translateY(0)';
                document.querySelector('.registration-content').style.opacity = '1';
            }, 10);
        });
        
        // Also from login modal
        showRegistration.addEventListener('click', function(e) {
            e.preventDefault();
            loginModal.classList.remove('active');
            registrationModal.classList.add('active');
            setTimeout(() => {
                document.querySelector('.registration-content').style.transform = 'translateY(0)';
                document.querySelector('.registration-content').style.opacity = '1';
            }, 10);
        });
        
        // Close registration modal
        closeRegistration.addEventListener('click', function() {
            registrationModal.classList.remove('active');
            document.querySelector('.registration-content').style.transform = 'translateY(-50px)';
            document.querySelector('.registration-content').style.opacity = '0';
        });
        
        // Multi-step form functionality
        const formSteps = document.querySelectorAll('.form-step');
        const steps = document.querySelectorAll('.step');
        const nextButtons = document.querySelectorAll('.next-step');
        const prevButtons = document.querySelectorAll('.prev-step');
        let currentStep = 0;
        
        // Initialize form steps
        function showStep(stepIndex) {
            formSteps.forEach((step, index) => {
                if (index === stepIndex) {
                    step.classList.add('active');
                    steps[index].classList.add('active');
                    
                    // Mark previous steps as completed
                    for (let i = 0; i < index; i++) {
                        steps[i].classList.remove('active');
                        steps[i].classList.add('completed');
                    }
                    
                    // Reset future steps
                    for (let i = index + 1; i < steps.length; i++) {
                        steps[i].classList.remove('active', 'completed');
                    }
                } else {
                    step.classList.remove('active');
                }
            });
        }
        
        // Next button click
        nextButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Validate current step before proceeding
                if (validateStep(currentStep)) {
                    if (currentStep < formSteps.length - 1) {
                        currentStep++;
                        showStep(currentStep);
                        
                        // Update confirmation data on last step
                        if (currentStep === 2) {
                            updateConfirmationData();
                        }
                    }
                }
            });
        });
        
        // Previous button click
        prevButtons.forEach(button => {
            button.addEventListener('click', function() {
                if (currentStep > 0) {
                    currentStep--;
                    showStep(currentStep);
                }
            });
        });
        
        // Simple validation for each step
        function validateStep(stepIndex) {
            let isValid = true;
            
            if (stepIndex === 0) {
                const fullName = document.getElementById('fullName').value;
                const nik = document.getElementById('nik').value;
                const birthDate = document.getElementById('birthDate').value;
                const address = document.getElementById('address').value;
                
                if (!fullName || !nik || !birthDate || !address) {
                    alert('Silakan lengkapi semua informasi pribadi.');
                    isValid = false;
                } else if (nik.length !== 16) {
                    alert('NIK harus terdiri dari 16 digit.');
                    isValid = false;
                }
            } else if (stepIndex === 1) {
                const email = document.getElementById('email').value;
                const phone = document.getElementById('phone').value;
                const username = document.getElementById('usernameReg').value;
                const password = document.getElementById('passwordReg').value;
                const confirmPassword = document.getElementById('confirmPassword').value;
                
                if (!email || !phone || !username || !password || !confirmPassword) {
                    alert('Silakan lengkapi semua informasi akun.');
                    isValid = false;
                } else if (password !== confirmPassword) {
                    alert('Kata sandi dan konfirmasi kata sandi tidak cocok.');
                    isValid = false;
                } else if (password.length < 6) {
                    alert('Kata sandi harus terdiri dari minimal 6 karakter.');
                    isValid = false;
                }
            }
            
            return isValid;
        }
        
        // Update confirmation data
        function updateConfirmationData() {
            document.getElementById('confirmFullName').textContent = document.getElementById('fullName').value;
            document.getElementById('confirmNik').textContent = document.getElementById('nik').value;
            document.getElementById('confirmBirthDate').textContent = document.getElementById('birthDate').value;
            document.getElementById('confirmAddress').textContent = document.getElementById('address').value;
            document.getElementById('confirmEmail').textContent = document.getElementById('email').value;
            document.getElementById('confirmPhone').textContent = document.getElementById('phone').value;
            document.getElementById('confirmUsername').textContent = document.getElementById('usernameReg').value;
        }
        
        // Form submission (menggunakan fetch ke Java backend)
        registrationForm.addEventListener('submit', function(e) {
            e.preventDefault();
    
            // Check if terms are agreed
            if (!document.getElementById('agreeTerms').checked) {
                alert('Anda harus menyetujui syarat dan ketentuan untuk melanjutkan.');
                return;
            }

            const formData = new FormData(registrationForm);

            fetch('register.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.text())
            .then(data => {
                alert(data); // Menampilkan respon dari register.php

            // Tutup modal dan reset form
            registrationModal.classList.remove('active');
            registrationForm.reset();
            currentStep = 0;
            showStep(currentStep);

            // Simpan status login
            isLoggedIn = true;
            localStorage.setItem('isLoggedIn', 'true');
            updateLoginStatus();
        })
        .catch(error => {
            alert('Terjadi kesalahan saat mengirim data. Silakan coba lagi.');
            console.error(error);
        });
    });

        // FAQ Accordion
        document.querySelectorAll('.bg-white button').forEach(button => {
            button.addEventListener('click', () => {
                const content = button.nextElementSibling;
                const icon = button.querySelector('i');
                
                if (content.classList.contains('hidden')) {
                    content.classList.remove('hidden');
                    icon.classList.remove('fa-chevron-down');
                    icon.classList.add('fa-chevron-up');
                } else {
                    content.classList.add('hidden');
                    icon.classList.remove('fa-chevron-up');
                    icon.classList.add('fa-chevron-down');
                }
            });
        });
        
        // Back to Top Button
        const backToTopButton = document.getElementById('backToTop');
        
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                backToTopButton.classList.remove('opacity-0', 'invisible');
                backToTopButton.classList.add('opacity-100', 'visible');
            } else {
                backToTopButton.classList.remove('opacity-100', 'visible');
                backToTopButton.classList.add('opacity-0', 'invisible');
            }
        });
        
        backToTopButton.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
        
        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });

            });
        });
        // Image Carousel Functionality
        const carousel = document.getElementById('carousel');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const indicators = document.querySelectorAll('.carousel-indicator');
        let currentSlide = 0;
        const slideCount = document.querySelectorAll('.carousel-slide').length;
        let autoSlideInterval;

        // Function to go to a specific slide
        function goToSlide(index) {
            if (index < 0) {
                index = slideCount - 1;
            } else if (index >= slideCount) {
                index = 0;
            }
            
            currentSlide = index;
            carousel.style.transform = `translateX(-${currentSlide * 100}%)`;
            
            // Update indicators
            indicators.forEach((indicator, i) => {
                if (i === currentSlide) {
                    indicator.classList.add('active');
                } else {
                    indicator.classList.remove('active');
                }
            });
        }

        // Next slide
        function nextSlide() {
            goToSlide(currentSlide + 1);
        }

        // Previous slide
        function prevSlide() {
            goToSlide(currentSlide - 1);
        }

        // Start auto sliding
        function startAutoSlide() {
            autoSlideInterval = setInterval(nextSlide, 5000);
        }

        // Stop auto sliding
        function stopAutoSlide() {
            clearInterval(autoSlideInterval);
        }

        // Event listeners for buttons
        nextBtn.addEventListener('click', () => {
            stopAutoSlide();
            nextSlide();
            startAutoSlide();
        });

        prevBtn.addEventListener('click', () => {
            stopAutoSlide();
            prevSlide();
            startAutoSlide();
        });

        // Event listeners for indicators
        indicators.forEach(indicator => {
            indicator.addEventListener('click', () => {
                stopAutoSlide();
                goToSlide(parseInt(indicator.dataset.slide));
                startAutoSlide();
            });
        });

        // Start auto sliding on page load
        startAutoSlide();

        // Pause auto sliding when mouse is over carousel
        document.querySelector('.carousel-container').addEventListener('mouseenter', stopAutoSlide);
        document.querySelector('.carousel-container').addEventListener('mouseleave', startAutoSlide);

        // Touch events for mobile swipe
        let touchStartX = 0;
        let touchEndX = 0;

        carousel.addEventListener
    </script>
</body>
</html>