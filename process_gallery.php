<?php
/*
 * Path File: /process_gallery.php
 * Deskripsi: Menangani tambah dan hapus gambar dari galeri DAN dari tampilan bergeser (slider).
 */
session_start();
require_once __DIR__ . '/config/database.php';

if(!isset($_SESSION['admin'])) { 
    header('Location: index.php?page=login'); 
    exit; 
}

$db = (new Database())->getConnection();
$action = isset($_GET['action']) ? $_GET['action'] : '';

// ==========================================
// FUNGSI BANTUAN (HELPER)
// ==========================================
function getDataFromJson($db, $key) {
    $stmt = $db->prepare("SELECT setting_value FROM settings WHERE setting_key = :key");
    $stmt->execute([':key' => $key]);
    $json = $stmt->fetchColumn();
    return $json ? json_decode($json, true) : [];
}

function saveDataToJson($db, $key, $array_data) {
    $json = json_encode($array_data);
    $stmt = $db->prepare("SELECT setting_key FROM settings WHERE setting_key = :key");
    $stmt->execute([':key' => $key]);
    if($stmt->rowCount() > 0) {
        $upd = $db->prepare("UPDATE settings SET setting_value = :val WHERE setting_key = :key");
        $upd->execute([':val' => $json, ':key' => $key]);
    } else {
        $ins = $db->prepare("INSERT INTO settings (setting_key, setting_value) VALUES (:key, :val)");
        $ins->execute([':key' => $key, ':val' => $json]);
    }
}

// ==========================================
// AKSI UNTUK TAB GALERI PROYEK
// ==========================================
$galleries = getDataFromJson($db, 'gallery_data');

if ($action === 'add') {
    if(isset($_FILES["image"]) && $_FILES["image"]["error"] === 0) {
        $upload_dir = __DIR__ . '/assets/uploads/gallery/';
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

        $file_ext = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
        if(in_array($file_ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
            $unique_id = uniqid();
            $new_file_name = "gal_" . $unique_id . "." . $file_ext;
            
            if(move_uploaded_file($_FILES["image"]["tmp_name"], $upload_dir . $new_file_name)) {
                array_unshift($galleries, [
                    'id'    => $unique_id,
                    'img'   => 'assets/uploads/gallery/' . $new_file_name,
                    'title' => $_POST['title'],
                    'loc'   => $_POST['loc']
                ]);
                saveDataToJson($db, 'gallery_data', $galleries);
                $_SESSION['swal_success'] = 'Foto Galeri berhasil ditambahkan!';
    header('Location: index.php?page=admin_gallery');
    exit;
            }
        }
    }
} 
elseif ($action === 'delete' && isset($_GET['id'])) {
    $id_to_delete = $_GET['id'];
    $new_galleries = [];
    foreach($galleries as $item) {
        if($item['id'] === $id_to_delete) {
            $file_path = __DIR__ . '/' . $item['img'];
            if(file_exists($file_path)) unlink($file_path);
        } else {
            $new_galleries[] = $item;
        }
    }
    saveDataToJson($db, 'gallery_data', $new_galleries);
    $_SESSION['swal_success'] = 'Foto Galeri berhasil dihapus!';
    header('Location: index.php?page=admin_gallery');
    exit;
}

// ==========================================
// AKSI UNTUK TAB TAMPILAN BERGESER (SLIDER)
// ==========================================
$sliders = getDataFromJson($db, 'slider_data');

if ($action === 'add_slider') {
    if(isset($_FILES["image"]) && $_FILES["image"]["error"] === 0) {
        $upload_dir = __DIR__ . '/assets/uploads/sliders/';
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

        $file_ext = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
        if(in_array($file_ext, ['jpg', 'jpeg', 'png', 'webp'])) {
            $unique_id = uniqid();
            $new_file_name = "slide_" . $unique_id . "." . $file_ext;
            
            if(move_uploaded_file($_FILES["image"]["tmp_name"], $upload_dir . $new_file_name)) {
                array_unshift($sliders, [
                    'id'       => $unique_id,
                    'img'      => 'assets/uploads/sliders/' . $new_file_name,
                    'name'     => $_POST['name'],
                    'category' => $_POST['category']
                ]);
                saveDataToJson($db, 'slider_data', $sliders);
                $_SESSION['swal_success'] = 'Item Tampilan Bergeser berhasil ditambahkan!';
                header('Location: index.php?page=admin_gallery&tab=slider');
                exit;
            }
        }
    }
} 
elseif ($action === 'delete_slider' && isset($_GET['id'])) {
    $id_to_delete = $_GET['id'];
    $new_sliders = [];
    foreach($sliders as $item) {
        if($item['id'] === $id_to_delete) {
            $file_path = __DIR__ . '/' . $item['img'];
            if(file_exists($file_path)) unlink($file_path);
        } else {
            $new_sliders[] = $item;
        }
    }
    saveDataToJson($db, 'slider_data', $new_sliders);
    $_SESSION['swal_success'] = 'Item Tampilan Bergeser berhasil dihapus!';
    header('Location: index.php?page=admin_gallery&tab=slider');
    exit;
}

header('Location: index.php?page=admin_gallery');
?>