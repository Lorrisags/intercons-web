<?php
/*
 * Path File: /process_edit_team.php
 * Deskripsi: Menangani update data anggota tim dan pergantian foto.
 */
session_start();
require_once __DIR__ . '/config/database.php';

// Proteksi akses
if(!isset($_SESSION['admin'])) { 
    header('Location: index.php?page=login'); 
    exit; 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = (new Database())->getConnection();

    // Tangkap data dari form
    $id = $_POST['id'];
    $name = $_POST['name'];
    $position = $_POST['position'];
    $category = $_POST['category'];
    $photo_url = $_POST['old_photo']; // Default menggunakan path foto lama

    // --- PROSES UPLOAD FOTO BARU (JIKA ADA) ---
    if(isset($_FILES["photo"]) && $_FILES["photo"]["error"] === 0) {
        $upload_dir = __DIR__ . '/assets/uploads/team/';
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

        $file_name = $_FILES["photo"]["name"];
        $file_tmp = $_FILES["photo"]["tmp_name"];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'jpeg', 'png', 'webp'];

        if(in_array($file_ext, $allowed_ext)) {
            $new_file_name = "team_" . time() . "_" . uniqid() . "." . $file_ext;
            $destination = $upload_dir . $new_file_name;
            
            // Pindahkan file baru
            if(move_uploaded_file($file_tmp, $destination)) {
                $photo_url = 'assets/uploads/team/' . $new_file_name; // Update path foto
                
                // Hapus file foto lama dari folder server agar tidak menumpuk (jika foto lama ada)
                if(!empty($_POST['old_photo'])) {
                    $old_file_path = __DIR__ . '/' . $_POST['old_photo'];
                    if(file_exists($old_file_path)) {
                        unlink($old_file_path);
                    }
                }
            } else {
                echo "<script>alert('Gagal mengupload foto baru.'); window.location.href='index.php?page=admin_team';</script>";
                exit;
            }
        } else {
            echo "<script>alert('Format foto tidak didukung! Gunakan JPG, PNG, atau WEBP.'); window.location.href='index.php?page=admin_team';</script>";
            exit;
        }
    }

    // --- PROSES UPDATE KE DATABASE ---
    $query = "UPDATE teams SET name = :name, position = :position, category = :category, photo_url = :photo_url WHERE id = :id";
    $stmt = $db->prepare($query);
    
    // Bind parameter
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':position', $position);
    $stmt->bindParam(':category', $category);
    $stmt->bindParam(':photo_url', $photo_url);
    $stmt->bindParam(':id', $id);

    if($stmt->execute()) {
         $_SESSION['swal_success'] = 'Anggota tim berhasil diperbarui!';
        header('Location: index.php?page=admin_team');
        exit;
    } else {
        $_SESSION['swal_error'] = 'Terjadi kesalahan saat mengupdate database.';
        header('Location: index.php?page=admin_team');
        exit;
    }
} else {
    header('Location: index.php?page=admin_team');
}
?>