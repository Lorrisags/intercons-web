<?php
/*
 * Path File: /process_add_team.php
 * Deskripsi: Menangani upload foto dan menyimpan data tim ke database.
 */
session_start();
require_once __DIR__ . '/config/database.php';

// Cek apakah admin sudah login
if(!isset($_SESSION['admin'])) { 
    header('Location: index.php?page=login'); 
    exit; 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = (new Database())->getConnection();

    // Tangkap data teks dari form
    $name = $_POST['name'];
    $position = $_POST['position'];
    $category = $_POST['category'];
    $photo_url = null;

    // Tentukan folder untuk menyimpan gambar
    $upload_dir = __DIR__ . '/assets/uploads/team/';
    // Jika folder belum ada, buat otomatis
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // --- PROSES UPLOAD FOTO ---
    if(isset($_FILES["photo"]) && $_FILES["photo"]["error"] === 0) {
        $file_name = $_FILES["photo"]["name"];
        $file_tmp = $_FILES["photo"]["tmp_name"];
        
        // Cek ekstensi file
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'jpeg', 'png', 'webp'];

        if(in_array($file_ext, $allowed_ext)) {
            // Buat nama file unik agar tidak bentrok
            $new_file_name = "team_" . time() . "_" . uniqid() . "." . $file_ext;
            $destination = $upload_dir . $new_file_name;
            
            // Pindahkan file ke folder assets
            if(move_uploaded_file($file_tmp, $destination)) {
                $photo_url = 'assets/uploads/team/' . $new_file_name;
            } else {
                echo "<script>alert('Gagal mengupload file ke server.'); window.location.href='index.php?page=admin_team';</script>";
                exit;
            }
        } else {
            echo "<script>alert('Format foto tidak didukung! Gunakan JPG, PNG, atau WEBP.'); window.location.href='index.php?page=admin_team';</script>";
            exit;
        }
    } else {
        echo "<script>alert('Foto wajib diupload!'); window.location.href='index.php?page=admin_team';</script>";
        exit;
    }

    // --- PROSES SIMPAN KE DATABASE ---
    $query = "INSERT INTO teams (name, position, category, photo_url) VALUES (:name, :position, :category, :photo_url)";
    $stmt = $db->prepare($query);
    
    // Bind parameter untuk mencegah SQL Injection
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':position', $position);
    $stmt->bindParam(':category', $category);
    $stmt->bindParam(':photo_url', $photo_url);

    if($stmt->execute()) {
        echo "<script>
            alert('Anggota tim berhasil ditambahkan!');
            window.location.href='index.php?page=admin_team';
        </script>";
    } else {
        echo "<script>
            alert('Terjadi kesalahan saat menyimpan ke database.');
            window.location.href='index.php?page=admin_team';
        </script>";
    }
} else {
    // Jika diakses langsung tanpa lewat form
    header('Location: index.php?page=admin_team');
}
?>