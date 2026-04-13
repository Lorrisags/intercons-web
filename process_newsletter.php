<?php
/* Path File: /process_newsletter.php */
session_start();
require_once __DIR__ . '/config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = (new Database())->getConnection();
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';

    if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Cek apakah email sudah terdaftar sebelumnya
        $check = $db->prepare("SELECT id FROM subscribers WHERE email = :email");
        $check->execute([':email' => $email]);
        
        if ($check->rowCount() > 0) {
            echo "<script>alert('Email ini sudah berlangganan newsletter kami!'); window.history.back();</script>";
        } else {
            // Simpan email ke database
            $stmt = $db->prepare("INSERT INTO subscribers (email) VALUES (:email)");
            if ($stmt->execute([':email' => $email])) {
                echo "<script>alert('Terima kasih telah berlangganan newsletter PT. INTERCONS!'); window.history.back();</script>";
            } else {
                echo "<script>alert('Terjadi kesalahan sistem.'); window.history.back();</script>";
            }
        }
    } else {
        echo "<script>alert('Format email tidak valid!'); window.history.back();</script>";
    }
} else {
    header("Location: index.php?page=home");
}
?>