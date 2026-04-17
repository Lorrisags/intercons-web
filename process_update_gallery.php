<?php
/*
 * Path File: /process_update_gallery.php
 * Deskripsi: Mengupdate item array JSON Galeri di tabel settings.
 */
session_start();
require_once __DIR__ . '/config/database.php';

if(!isset($_SESSION['admin'])) { 
    header('Location: index.php?page=login'); 
    exit; 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = (new Database())->getConnection();

    $id = $_POST['id'];
    $title = $_POST['title'];
    $loc = $_POST['loc'];
    $old_image = $_POST['old_image'];
    $image_url = $old_image; // Default pakai gambar lama

    $upload_dir = __DIR__ . '/assets/uploads/gallery/';

    // --- PROSES UPLOAD GAMBAR BARU ---
    if(isset($_FILES["image"]) && $_FILES["image"]["error"] === 0) {
        $file_ext = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'jpeg', 'png', 'webp'];

        if(in_array($file_ext, $allowed_ext)) {
            $new_file_name = "gal_" . time() . "_" . uniqid() . "." . $file_ext;
            $destination = $upload_dir . $new_file_name;
            
            if(move_uploaded_file($_FILES["image"]["tmp_name"], $destination)) {
                $image_url = 'assets/uploads/gallery/' . $new_file_name;
                
                // Hapus file lama
                if(!empty($old_image) && file_exists(__DIR__ . '/' . $old_image)) {
                    unlink(__DIR__ . '/' . $old_image);
                }
            } else {
                $_SESSION['swal_error'] = 'Gagal mengupload foto ke server.';
                header('Location: index.php?page=admin_gallery');
                exit;
            }
        } else {
            $_SESSION['swal_error'] = 'Format foto tidak didukung!';
            header('Location: index.php?page=admin_gallery');
            exit;
        }
    }

    // --- PROSES UPDATE JSON KE DATABASE ---
    // 1. Ambil JSON Galeri saat ini
    $stmt = $db->prepare("SELECT setting_value FROM settings WHERE setting_key = 'gallery_data'");
    $stmt->execute();
    $gallery_json = $stmt->fetchColumn();
    
    // 2. Ubah dari JSON String ke bentuk Array PHP
    $galleries = $gallery_json ? json_decode($gallery_json, true) : [];
    
    // 3. Cari item yang mau di-edit dan ubah datanya
    $is_updated = false;
    foreach ($galleries as &$item) {
        if ($item['id'] == $id) {
            $item['title'] = $title;
            $item['loc'] = $loc;
            $item['img'] = $image_url;
            $is_updated = true;
            break;
        }
    }
    
    if ($is_updated) {
        // 4. Kembalikan jadi format JSON dan Simpan ke database
        $new_json = json_encode($galleries);
        $update_stmt = $db->prepare("UPDATE settings SET setting_value = :val WHERE setting_key = 'gallery_data'");
        
        if ($update_stmt->execute([':val' => $new_json])) {
            $_SESSION['swal_success'] = 'Foto Galeri berhasil diperbarui!';
        } else {
            $_SESSION['swal_error'] = 'Terjadi kesalahan saat menyimpan database.';
        }
    } else {
        $_SESSION['swal_error'] = 'Data galeri tidak ditemukan.';
    }

    header('Location: index.php?page=admin_gallery');
    exit;
} else {
    header('Location: index.php?page=admin_gallery');
    exit;
}
?>