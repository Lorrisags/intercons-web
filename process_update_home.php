<?php
/* Path File: /process_update_home.php */
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
session_start();
require_once __DIR__ . '/config/database.php';

// Wajib: Beritahu sistem bahwa kita mengirim balasan berupa JSON (AJAX)
header('Content-Type: application/json');

if(!isset($_SESSION['admin'])) { 
    echo json_encode(['status' => 'error', 'message' => 'Sesi login berakhir.']);
    exit; 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = (new Database())->getConnection();
    $upload_dir = __DIR__ . '/assets/uploads/sliders/';
    if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

    $data_to_save = [
        'hero_title'     => $_POST['hero_title'] ?? '',
        'hero_badge'     => $_POST['hero_badge'] ?? '',
        'hero_desc'      => $_POST['hero_desc'] ?? '',
        'total_products' => $_POST['stat_products'] ?? '',
        'total_projects' => $_POST['stat_projects'] ?? '',
        'total_clients'  => $_POST['stat_clients'] ?? '',
        'awards'         => $_POST['stat_awards'] ?? '',
        'cta_title'      => $_POST['cta_title'] ?? '',
        'cta_desc'       => $_POST['cta_desc'] ?? '',
        'show_hero'      => isset($_POST['show_hero']) ? '1' : '0',
        'show_stats'     => isset($_POST['show_stats']) ? '1' : '0',
        'show_products'  => isset($_POST['show_products']) ? '1' : '0',
        'show_cta'       => isset($_POST['show_cta']) ? '1' : '0'
    ];

    for($i=1; $i<=3; $i++) {
        $key = "hero_img_" . $i;
        $old_key = "old_" . $key;
        $old_val = $_POST[$old_key] ?? '';

        if(isset($_FILES[$key]) && $_FILES[$key]['error'] === UPLOAD_ERR_OK) {
            $ext = strtolower(pathinfo($_FILES[$key]['name'], PATHINFO_EXTENSION));
            $filename = "hero_" . $i . "_" . time() . "." . $ext;
            
            if(move_uploaded_file($_FILES[$key]['tmp_name'], $upload_dir . $filename)) {
                $data_to_save[$key] = 'assets/uploads/sliders/' . $filename;
                if(!empty($old_val) && file_exists(__DIR__ . '/' . $old_val)) {
                    unlink(__DIR__ . '/' . $old_val);
                }
            } else {
                $data_to_save[$key] = $old_val;
            }
        } else {
            $data_to_save[$key] = $old_val;
        }
    }

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

    // Kirim pesan sukses ke form tanpa reload halaman
    echo json_encode(['status' => 'success', 'message' => 'Perubahan Beranda Berhasil Disimpan!']);
    exit;
}
?>