<?php
/*
 * Path File: /process_update_gallery.php
 * Deskripsi: Menyimpan upload file gambar dan perubahan teks halaman Galeri ke database.
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

    // Tentukan folder untuk menyimpan gambar (Otomatis dibuat jika belum ada)
    $upload_dir = __DIR__ . '/assets/uploads/gallery/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $data_to_save = [];

    // Looping untuk 6 blok galeri
    for($i=1; $i<=6; $i++) {
        
        // 1. PROSES UPLOAD FILE GAMBAR
        if(isset($_FILES["gal_{$i}_img"]) && $_FILES["gal_{$i}_img"]["error"] === 0) {
            $file_tmp = $_FILES["gal_{$i}_img"]["tmp_name"];
            $file_name = $_FILES["gal_{$i}_img"]["name"];
            
            // Ambil ekstensi file (jpg, png, dll)
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            $allowed_ext = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

            // Cek apakah file yang diupload adalah gambar
            if(in_array($file_ext, $allowed_ext)) {
                // Buat nama file baru agar tidak bentrok (contoh: gallery_1_16900000.jpg)
                $new_file_name = "gallery_" . $i . "_" . time() . "." . $file_ext;
                $destination = $upload_dir . $new_file_name;
                
                // Pindahkan file dari memori sementara ke folder assets
                if(move_uploaded_file($file_tmp, $destination)) {
                    // Simpan URL/Path baru ke database
                    $data_to_save["gal_{$i}_img"] = 'assets/uploads/gallery/' . $new_file_name;
                }
            } else {
                echo "<script>alert('Gagal! Format file Foto {$i} tidak didukung (Gunakan JPG, PNG, WEBP).');</script>";
            }
        } else {
            // Jika admin TIDAK memilih file baru, gunakan URL/gambar lama
            if(isset($_POST["old_gal_{$i}_img"])) {
                $data_to_save["gal_{$i}_img"] = $_POST["old_gal_{$i}_img"];
            }
        }

        // 2. AMBIL TEKS JUDUL & LOKASI
        if(isset($_POST["gal_{$i}_title"])) $data_to_save["gal_{$i}_title"] = $_POST["gal_{$i}_title"];
        if(isset($_POST["gal_{$i}_loc"])) $data_to_save["gal_{$i}_loc"] = $_POST["gal_{$i}_loc"];
    }

    // Melakukan proses Insert / Update (Upsert) ke tabel settings
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
        alert('Data Halaman Galeri berhasil disimpan!');
        window.location.href='index.php?page=admin_gallery';
    </script>";
}
?>