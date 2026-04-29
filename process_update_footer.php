<?php
/* Path: /process_update_footer.php */
session_start();
require_once __DIR__ . '/config/database.php';

if (!isset($_SESSION['admin'])) { header('Location: index.php?page=login'); exit; }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = (new Database())->getConnection();

    // Fungsi kecil untuk update atau insert ke tabel settings
    function saveSetting($db, $key, $value) {
        $stmt = $db->prepare("UPDATE settings SET setting_value = :val WHERE setting_key = :key");
        $stmt->execute([':val' => $value, ':key' => $key]);
        
        // Jika row tidak ada (belum pernah dibuat), maka insert baru
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
        saveSetting($db, 'footer_desc', $_POST['footer_desc']);
        saveSetting($db, 'contact_address', $_POST['contact_address']);
        saveSetting($db, 'contact_phone', $_POST['contact_phone']);
        saveSetting($db, 'contact_email', $_POST['contact_email']);

        $_SESSION['swal_success'] = 'Data footer dan kontak berhasil diperbarui!';
    } catch (PDOException $e) {
        $_SESSION['swal_error'] = 'Gagal menyimpan data: ' . $e->getMessage();
    }

    header('Location: index.php?page=admin_footer');
    exit;
}
?>