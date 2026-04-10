<?php
/* Path File: /process_update_home.php */
session_start();
require_once __DIR__ . '/config/database.php';

if(!isset($_SESSION['admin'])) { 
    header('Location: index.php?page=login'); 
    exit; 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $database = new Database();
    $db = $database->getConnection();

    // Menangkap data dari form admin_home (Termasuk status Tampilkan/Sembunyikan)
    $data_to_save = [
        'hero_title'     => $_POST['hero_title'],
        'hero_badge'     => $_POST['hero_badge'],
        'hero_desc'      => $_POST['hero_desc'],
        'total_products' => $_POST['stat_products'],
        'total_projects' => $_POST['stat_projects'],
        'total_clients'  => $_POST['stat_clients'],
        'awards'         => $_POST['stat_awards'],
        'cta_title'      => $_POST['cta_title'],
        'cta_desc'       => $_POST['cta_desc'],
        
        // Fitur Visibilitas (Jika dicentang nilainya 1, jika tidak 0)
        'show_hero'      => isset($_POST['show_hero']) ? '1' : '0',
        'show_stats'     => isset($_POST['show_stats']) ? '1' : '0',
        'show_products'  => isset($_POST['show_products']) ? '1' : '0',
        'show_cta'       => isset($_POST['show_cta']) ? '1' : '0'
    ];

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

    echo "<script>
        alert('Perubahan Halaman Beranda berhasil disimpan!');
        window.location.href='index.php?page=admin_home';
    </script>";
}
?>