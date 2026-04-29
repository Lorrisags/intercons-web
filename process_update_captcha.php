<?php
/* Path: /process_update_captcha.php */
session_start();
require_once __DIR__ . '/config/database.php';

if (!isset($_SESSION['admin'])) { header('Location: index.php?page=login'); exit; }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = (new Database())->getConnection();

    function saveCaptchaSetting($db, $key, $value) {
        $stmt = $db->prepare("UPDATE settings SET setting_value = :val WHERE setting_key = :key");
        $stmt->execute([':val' => $value, ':key' => $key]);
        
        if ($stmt->rowCount() == 0) {
            $check = $db->prepare("SELECT COUNT(*) FROM settings WHERE setting_key = :key");
            $check->execute([':key' => $key]);
            if($check->fetchColumn() == 0) {
                $ins = $db->prepare("INSERT INTO settings (setting_key, setting_value) VALUES (:key, :val)");
                $ins->execute([':key' => $key, ':val' => $value]);
            }
        }
    }

    try {
        // Jika checkbox mati, nilai POST tidak terkirim, maka set '0'
        $captcha_active = isset($_POST['captcha_active']) ? '1' : '0';
        $site_key = trim($_POST['captcha_site_key']);
        $secret_key = trim($_POST['captcha_secret_key']);

        saveCaptchaSetting($db, 'captcha_active', $captcha_active);
        saveCaptchaSetting($db, 'captcha_site_key', $site_key);
        saveCaptchaSetting($db, 'captcha_secret_key', $secret_key);

        $_SESSION['swal_success'] = 'Pengaturan Keamanan Captcha berhasil disimpan!';
    } catch (PDOException $e) {
        $_SESSION['swal_error'] = 'Gagal menyimpan pengaturan: ' . $e->getMessage();
    }

    header('Location: index.php?page=admin_captcha');
    exit;
} else {
    header('Location: index.php?page=admin_captcha');
    exit;
}
?>