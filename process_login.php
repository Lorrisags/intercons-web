<?php
/*
 * Path File: /process_login.php (Simpan di folder UTAMA sejajar dengan index.php)
 * Deskripsi: Skrip PHP untuk mengecek kredensial login admin ke Database (Menggunakan sistem Hash/Bcrypt).
 */
session_start();

// Menggunakan __DIR__ agar file config selalu ditemukan dari direktori mana pun skrip ini dipanggil
require_once __DIR__ . '/config/database.php';

// Pastikan form dikirim menggunakan metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Inisialisasi koneksi Database
    $database = new Database();
    $db = $database->getConnection();

    // 1. Cari data admin berdasarkan username saja (JANGAN cocokkan password di SQL)
    $query = "SELECT * FROM admins WHERE username = :username LIMIT 1";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    // 2. Cek apakah username ditemukan
    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // 3. Verifikasi password yang diketik dengan Hash yang ada di database
        if (password_verify($password, $user['password'])) {
            // Buat sesi login
            $_SESSION['admin'] = $user['username'];
            
            // Redirect ke dashboard admin
            header("Location: index.php?page=admin");
            exit();
        } else {
            // Password salah
            echo "<script>
                alert('Password yang Anda masukkan salah!');
                window.location.href='index.php?page=login';
            </script>";
            exit();
        }
    } else {
        // Username tidak ditemukan
        echo "<script>
            alert('Username tidak ditemukan di sistem!');
            window.location.href='index.php?page=login';
        </script>";
        exit();
    }
} else {
    // Jika diakses secara langsung tanpa form POST
    header("Location: index.php?page=login");
    exit();
}
?>