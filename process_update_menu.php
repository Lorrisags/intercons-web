<?php
/*
 * Path File: /process_update_menu.php
 * Deskripsi: Menyimpan perubahan label dan status visibilitas menu.
 */
session_start();
require_once __DIR__ . '/config/database.php';

if(!isset($_SESSION['admin'])) { 
    header('Location: index.php?page=login'); 
    exit; 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = (new Database())->getConnection();

    $menu_keys = ['home', 'about', 'page', 'gallery', 'team', 'career', 'service', 'product', 'contact'];
    $data_to_save = [];

    foreach ($menu_keys as $key) {
        // Ambil label dari input
        if (isset($_POST["menu_{$key}_label"])) {
            $data_to_save["menu_{$key}_label"] = $_POST["menu_{$key}_label"];
        }
        // Ambil status switch (jika dicentang nilainya '1', jika tidak dicentang maka tidak terkirim, set '0')
        $data_to_save["menu_{$key}_show"] = isset($_POST["menu_{$key}_show"]) ? '1' : '0';
    }

    $is_success = true;

    // Upsert (Insert/Update) ke tabel settings
    foreach ($data_to_save as $key => $value) {
        $check = $db->prepare("SELECT setting_key FROM settings WHERE setting_key = :key");
        $check->bindParam(':key', $key);
        $check->execute();

        if ($check->rowCount() > 0) {
            $update = $db->prepare("UPDATE settings SET setting_value = :value WHERE setting_key = :key");
            $update->bindParam(':value', $value);
            $update->bindParam(':key', $key);
            if(!$update->execute()) $is_success = false;
        } else {
            $insert = $db->prepare("INSERT INTO settings (setting_key, setting_value) VALUES (:key, :value)");
            $insert->bindParam(':key', $key);
            $insert->bindParam(':value', $value);
            if(!$insert->execute()) $is_success = false;
        }
    }

    // --- PERUBAHAN: MENGGUNAKAN FLASH SESSION SWEETALERT ---
    if ($is_success) {
        $_SESSION['swal_success'] = 'Pengaturan Menu berhasil disimpan!';
    } else {
        $_SESSION['swal_error'] = 'Terjadi kesalahan saat menyimpan pengaturan menu.';
    }
    
    header('Location: index.php?page=admin_menu');
    exit;
} else {
    // Jika diakses langsung via URL
    header('Location: index.php?page=admin_menu');
    exit;
}
?>