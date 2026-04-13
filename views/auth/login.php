<?php
/*
 * Path File: /views/auth/login.php
 * Deskripsi: Halaman login tunggal untuk masuk ke panel Administrator.
 */
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Intercons</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #001f3f 0%, #005B96 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .login-card {
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 15px 30px rgba(0,0,0,0.3);
            overflow: hidden;
            width: 100%;
            max-width: 900px;
        }
        .login-bg {
            background: url('https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80') center/cover;
            min-height: 100%;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="login-card row g-0">
                <!-- Sisi Gambar Kiri -->
                <div class="col-md-6 d-none d-md-block position-relative">
                    <div class="login-bg"></div>
                    <div class="position-absolute w-100 h-100 top-0 start-0" style="background-color: rgba(0, 59, 115, 0.7);"></div>
                    <div class="position-absolute top-50 start-50 translate-middle text-center w-100 px-4">
                       <div class="d-flex align-items-center justify-content-center mb-3">
    <img src="assets/uploads/gallery/intercons.png" alt="Logo PT Intercons" style="height: 55px; margin-right: 15px;">
    <h2 class="text-white fw-bold mb-0">PT.INTERCONS</h2>
</div>
                        <p class="text-white-50">Sistem Manajemen Portal Informasi & Layanan Industri.</p>
                    </div>
                </div>
                
                <!-- Sisi Form Kanan -->
                <div class="col-md-6 p-5">
                    <div class="text-center mb-4">
                        <h3 class="fw-bold" style="color: #003B73;">Admin Login</h3>
                        <p class="text-muted small">Silakan masukkan kredensial Anda.</p>
                    </div>
                    
                    <form action="process_login.php" method="POST">
                        <div class="form-floating mb-3">
                            <!-- Ditambahkan name="username" agar bisa ditangkap oleh PHP -->
                            <input type="text" name="username" class="form-control bg-light border-0" id="floatingInput" placeholder="Username" required>
                            <label for="floatingInput" class="text-muted"><i class="fas fa-user me-2"></i>Username</label>
                        </div>
                        <div class="form-floating mb-4">
                            <!-- Ditambahkan name="password" agar bisa ditangkap oleh PHP -->
                            <input type="password" name="password" class="form-control bg-light border-0" id="floatingPassword" placeholder="Password" required>
                            <label for="floatingPassword" class="text-muted"><i class="fas fa-lock me-2"></i>Password</label>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="rememberMe">
                                <label class="form-check-label text-muted small" for="rememberMe">Ingat Saya</label>
                            </div>
                            <a href="?page=home" class="text-decoration-none small fw-bold" style="color: #03A9F4;">Kembali ke Website</a>
                        </div>
                        
                        <button class="btn w-100 py-3 text-white fw-bold" type="submit" style="background-color: #005B96; border-radius: 8px;">
                            Masuk ke Panel <i class="fas fa-sign-in-alt ms-2"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>