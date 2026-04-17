<?php
/*
 * Path File: /process_update_about.php
 * Deskripsi: Menyimpan perubahan data About Page ke tabel settings.
 */
session_start();
require_once __DIR__ . '/config/database.php';

if(!isset($_SESSION['admin'])) { 
    header('Location: index.php?page=login'); 
    exit; 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $database = new Database();
    $db = $database->getConnection();

    // Menangkap data dari form admin_about
    $data_to_save = [
        'about_vision'  => $_POST['about_vision'],
        'about_mission' => $_POST['about_mission'],
        'about_address' => $_POST['about_address'],
        'about_contact' => $_POST['about_contact']
    ];

    // Melakukan proses Insert / Update ke tabel settings
    foreach ($data_to_save as $key => $value) {
        $check = $db->prepare("SELECT setting_key FROM settings WHERE setting_key = :key");
        $check->bindParam(':key', $key);
        $check->execute();

        if ($check->rowCount() > 0) {
            $update = $db->prepare("UPDATE settings SET setting_value = :value WHERE setting_key = :key");
            $update->bindParam(':value', $value);
            $update->bindParam(':key', $key);
            $update->execute();
        } else {
            $insert = $db->prepare("INSERT INTO settings (setting_key, setting_value) VALUES (:key, :value)");
            $insert->bindParam(':key', $key);
            $insert->bindParam(':value', $value);
            $insert->execute();
        }
    }
// SESUDAHNYA
$_SESSION['swal_success'] = 'Perubahan Halaman About berhasil disimpan ke Database!';
$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php?page=home';
header('Location: index.php?page=admin_about&referer=' . urlencode($referer));
exit;
    
}
?>