<?php
/*
 * Path File: /process_update_home.php
 * Deskripsi: Menyimpan perubahan data Home Page ke tabel settings.
 */
session_start();
require_once __DIR__ . '/config/database.php';

// Pastikan hanya admin yang bisa memproses ini
if(!isset($_SESSION['admin'])) { 
    header('Location: index.php?page=login'); 
    exit; 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $database = new Database();
    $db = $database->getConnection();

    // Menangkap data dari form admin_home
    $data_to_save = [
        'hero_title'     => $_POST['hero_title'],
        'hero_badge'     => $_POST['hero_badge'],
        'hero_desc'      => $_POST['hero_desc'],
        'total_products' => $_POST['stat_products'],
        'total_projects' => $_POST['stat_projects'],
        'total_clients'  => $_POST['stat_clients'],
        'awards'         => $_POST['stat_awards'],
        'cta_title'      => $_POST['cta_title'],
        'cta_desc'       => $_POST['cta_desc']
    ];

    // Melakukan proses Insert / Update ke tabel settings (Upsert)
    foreach ($data_to_save as $key => $value) {
        // Cek apakah data sudah ada
        $check = $db->prepare("SELECT setting_key FROM settings WHERE setting_key = :key");
        $check->bindParam(':key', $key);
        $check->execute();

        if ($check->rowCount() > 0) {
            // Update jika sudah ada
            $update = $db->prepare("UPDATE settings SET setting_value = :value WHERE setting_key = :key");
            $update->bindParam(':value', $value);
            $update->bindParam(':key', $key);
            $update->execute();
        } else {
            // Insert jika belum ada
            $insert = $db->prepare("INSERT INTO settings (setting_key, setting_value) VALUES (:key, :value)");
            $insert->bindParam(':key', $key);
            $insert->bindParam(':value', $value);
            $insert->execute();
        }
    }

    // Kembali ke halaman admin home dengan pesan sukses
    echo "<script>
        alert('Perubahan Halaman Beranda berhasil disimpan ke Database!');
        window.location.href='index.php?page=admin_home';
    </script>";
}
?>