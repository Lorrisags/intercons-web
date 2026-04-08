<?php
/*
 * Path File: /process_gallery.php
 * Deskripsi: Menangani tambah (upload) dan hapus gambar dari galeri.
 */
session_start();
require_once __DIR__ . '/config/database.php';

if(!isset($_SESSION['admin'])) { 
    header('Location: index.php?page=login'); 
    exit; 
}

$db = (new Database())->getConnection();
$action = isset($_GET['action']) ? $_GET['action'] : '';

// 1. Fungsi Mengambil Data Galeri Saat Ini
function getGalleryData($db) {
    $stmt = $db->prepare("SELECT setting_value FROM settings WHERE setting_key = 'gallery_data'");
    $stmt->execute();
    $json = $stmt->fetchColumn();
    return $json ? json_decode($json, true) : [];
}

// 2. Fungsi Menyimpan Data Galeri Baru
function saveGalleryData($db, $array_data) {
    $json = json_encode($array_data);
    $stmt = $db->prepare("SELECT setting_key FROM settings WHERE setting_key = 'gallery_data'");
    $stmt->execute();
    if($stmt->rowCount() > 0) {
        $upd = $db->prepare("UPDATE settings SET setting_value = :val WHERE setting_key = 'gallery_data'");
        $upd->execute([':val' => $json]);
    } else {
        $ins = $db->prepare("INSERT INTO settings (setting_key, setting_value) VALUES ('gallery_data', :val)");
        $ins->execute([':val' => $json]);
    }
}

$galleries = getGalleryData($db);

// --- PROSES TAMBAH FOTO ---
if ($action === 'add') {
    if(isset($_FILES["image"]) && $_FILES["image"]["error"] === 0) {
        $upload_dir = __DIR__ . '/assets/uploads/gallery/';
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

        $file_ext = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if(in_array($file_ext, $allowed_ext)) {
            // Beri nama unik menggunakan ID
            $unique_id = uniqid();
            $new_file_name = "gal_" . $unique_id . "." . $file_ext;
            
            if(move_uploaded_file($_FILES["image"]["tmp_name"], $upload_dir . $new_file_name)) {
                // Masukkan data baru ke urutan PALING ATAS
                $newItem = [
                    'id'    => $unique_id,
                    'img'   => 'assets/uploads/gallery/' . $new_file_name,
                    'title' => $_POST['title'],
                    'loc'   => $_POST['loc']
                ];
                array_unshift($galleries, $newItem);
                saveGalleryData($db, $galleries);
                
                echo "<script>alert('Foto berhasil ditambahkan!'); window.location.href='index.php?page=admin_gallery';</script>";
                exit;
            }
        } else {
            echo "<script>alert('Format file tidak didukung!'); window.location.href='index.php?page=admin_gallery';</script>";
            exit;
        }
    }
} 
// --- PROSES HAPUS FOTO ---
elseif ($action === 'delete' && isset($_GET['id'])) {
    $id_to_delete = $_GET['id'];
    $new_galleries = [];
    
    foreach($galleries as $item) {
        if($item['id'] === $id_to_delete) {
            // Hapus file fisik dari folder server
            $file_path = __DIR__ . '/' . $item['img'];
            if(file_exists($file_path)) {
                unlink($file_path);
            }
        } else {
            // Simpan foto yang TIDAK dihapus
            $new_galleries[] = $item;
        }
    }
    
    // Perbarui database
    saveGalleryData($db, $new_galleries);
    echo "<script>alert('Foto berhasil dihapus!'); window.location.href='index.php?page=admin_gallery';</script>";
    exit;
}

// Fallback jika tidak ada aksi
header('Location: index.php?page=admin_gallery');
?>