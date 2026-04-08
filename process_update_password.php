<?php
/*
 * Path File: /process_update_password.php
 * Deskripsi: Logika untuk memverifikasi password lama dan menyimpan hash password baru.
 * WAJIB DISIMPAN DI FOLDER UTAMA (Sejajar dengan index.php)
 */

// Menyalakan error reporting agar layar tidak blank putih jika ada masalah
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Validasi lokasi file database.php
$db_path = __DIR__ . '/config/database.php';
if (!file_exists($db_path)) {
    die("<h2 style='color:red;'>ERROR LOKASI FILE!</h2>
         <p>Sistem tidak menemukan file <b>config/database.php</b>.</p>
         <p>Ini terjadi karena Anda salah menyimpan file <b>process_update_password.php</b>. <br>
         Pastikan file ini disimpan di <b>FOLDER UTAMA</b> aplikasi Anda (sejajar dengan index.php), <b>BUKAN</b> di dalam folder views/admin/.</p>");
}

require_once $db_path;

// Proteksi: Hanya bisa diakses jika sudah login
if(!isset($_SESSION['admin'])) { 
    header('Location: index.php?page=login'); 
    exit; 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = (new Database())->getConnection();
    
    $username = $_SESSION['admin']; // Ambil username dari sesi yang sedang login
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // 1. Validasi Input: Pastikan password baru dan konfirmasi sama
    if ($new_password !== $confirm_password) {
        echo "<script>
            alert('GAGAL: Password baru dan konfirmasi password tidak cocok!');
            window.location.href='index.php?page=admin_settings';
        </script>";
        exit;
    }

    // 2. Ambil data admin dari database
    $query = "SELECT password FROM admins WHERE username = :username LIMIT 1";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // 3. Verifikasi Password Lama menggunakan Hash
        if (password_verify($old_password, $user['password'])) {
            
            // 4. Jika password lama benar, Enkripsi Password Baru
            $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);
            
            // 5. Simpan Password Baru ke Database
            $updateQuery = "UPDATE admins SET password = :new_pass WHERE username = :username";
            $updateStmt = $db->prepare($updateQuery);
            $updateStmt->bindParam(':new_pass', $hashed_new_password);
            $updateStmt->bindParam(':username', $username);
            
            if ($updateStmt->execute()) {
                echo "<script>
                    alert('BERHASIL: Password Anda telah diperbarui. Ingat password baru Anda!');
                    window.location.href='index.php?page=admin_settings';
                </script>";
            } else {
                echo "<script>
                    alert('ERROR: Gagal mengupdate password di database.');
                    window.location.href='index.php?page=admin_settings';
                </script>";
            }
        } else {
            // Jika password lama yang diketik salah
            echo "<script>
                alert('GAGAL: Password lama yang Anda masukkan SALAH!');
                window.location.href='index.php?page=admin_settings';
            </script>";
        }
    } else {
        echo "<script>alert('User tidak ditemukan.'); window.location.href='index.php?page=admin_settings';</script>";
    }
}
?>