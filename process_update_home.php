<?php
/* Path File: /process_update_home.php */
session_start();
require_once __DIR__ . '/config/database.php';

if(!isset($_SESSION['admin'])) { header('Location: index.php?page=login'); exit; }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = (new Database())->getConnection();

    // Data teks biasa
    $data_to_save = [
        'hero_title' => $_POST['hero_title'],
        'hero_badge' => $_POST['hero_badge'],
        'hero_desc'  => $_POST['hero_desc'],
        'total_products' => $_POST['stat_products'],
        'total_projects' => $_POST['stat_projects'],
        'total_clients'  => $_POST['stat_clients'],
        'awards'         => $_POST['stat_awards'],
        'cta_title'      => $_POST['cta_title'],
        'cta_desc'       => $_POST['cta_desc']
    ];

    // Proses Konversi Gambar ke Base64 (Slider 1, 2, 3)
    for($i=1; $i<=3; $i++) {
        $key = "hero_img_" . $i;
        if(isset($_FILES[$key]) && $_FILES[$key]['error'] === 0) {
            // Membaca file gambar
            $imageData = file_get_contents($_FILES[$key]['tmp_name']);
            // Mengambil tipe mime (misal: image/png)
            $mimeType = $_FILES[$key]['type'];
            // Mengubah ke format data URI Base64
            $base64 = 'data:' . $mimeType . ';base64,' . base64_encode($imageData);
            $data_to_save[$key] = $base64;
        } else {
            // Jika tidak ada upload baru, gunakan data lama dari hidden input
            $data_to_save[$key] = $_POST['old_hero_img_'.$i] ?? '';
        }
    }

    // Simpan/Update ke database
    foreach ($data_to_save as $key => $value) {
        $check = $db->prepare("SELECT setting_key FROM settings WHERE setting_key = :key");
        $check->execute([':key' => $key]);
        if ($check->rowCount() > 0) {
            $stmt = $db->prepare("UPDATE settings SET setting_value = :val WHERE setting_key = :key");
        } else {
            $stmt = $db->prepare("INSERT INTO settings (setting_key, setting_value) VALUES (:key, :val)");
        }
        $stmt->execute([':val' => $value, ':key' => $key]);
    }

    echo "<script>alert('Berhasil disimpan langsung ke Database!'); window.location.href='index.php?page=admin_home';</script>";
}