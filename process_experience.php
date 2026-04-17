<?php
/*
 * Path File: /process_experience.php
 * Deskripsi: Menangani aksi Tambah, Edit, dan Hapus data Experience (Proyek).
 */
session_start();
require_once __DIR__ . '/config/database.php';

if(!isset($_SESSION['admin'])) { 
    header('Location: index.php?page=login'); 
    exit; 
}

$db = (new Database())->getConnection();
$action = isset($_GET['action']) ? $_GET['action'] : '';
$upload_dir = __DIR__ . '/assets/uploads/experience/';
if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

// --- AKSI TAMBAH ---
if ($action == 'add' && $_SERVER["REQUEST_METHOD"] == "POST") {
    $project_name = $_POST['project_name'];
    $client_name = $_POST['client_name'];
    $details = $_POST['details'];
    $image_url = null;

    if(isset($_FILES["image"]) && $_FILES["image"]["error"] === 0) {
        $ext = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
        if(in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
            $new_name = "exp_" . time() . "_" . uniqid() . "." . $ext;
            if(move_uploaded_file($_FILES["image"]["tmp_name"], $upload_dir . $new_name)) {
                $image_url = 'assets/uploads/experience/' . $new_name;
            }
        }
    }

    $stmt = $db->prepare("INSERT INTO experiences (project_name, client_name, details, image_url) VALUES (:project_name, :client_name, :details, :image_url)");
    $stmt->execute([':project_name' => $project_name, ':client_name' => $client_name, ':details' => $details, ':image_url' => $image_url]);
    
    // PERUBAHAN DI SINI (SUCCESS ADD)
    $_SESSION['swal_success'] = 'Proyek berhasil ditambahkan!';
    header('Location: index.php?page=admin_experience');
    exit;
}

// --- AKSI EDIT ---
elseif ($action == 'edit' && $_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $project_name = $_POST['project_name'];
    $client_name = $_POST['client_name'];
    $details = $_POST['details'];
    $image_url = $_POST['old_image'];

    if(isset($_FILES["image"]) && $_FILES["image"]["error"] === 0) {
        $ext = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
        if(in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
            $new_name = "exp_" . time() . "_" . uniqid() . "." . $ext;
            if(move_uploaded_file($_FILES["image"]["tmp_name"], $upload_dir . $new_name)) {
                $image_url = 'assets/uploads/experience/' . $new_name;
                // Hapus gambar lama
                if(!empty($_POST['old_image']) && file_exists(__DIR__ . '/' . $_POST['old_image'])) {
                    unlink(__DIR__ . '/' . $_POST['old_image']);
                }
            }
        }
    }

    $stmt = $db->prepare("UPDATE experiences SET project_name = :project_name, client_name = :client_name, details = :details, image_url = :image_url WHERE id = :id");
    $stmt->execute([':project_name' => $project_name, ':client_name' => $client_name, ':details' => $details, ':image_url' => $image_url, ':id' => $id]);
    
    // PERUBAHAN DI SINI (SUCCESS EDIT)
    $_SESSION['swal_success'] = 'Data proyek berhasil diupdate!';
    header('Location: index.php?page=admin_experience');
    exit;
}

// --- AKSI HAPUS ---
elseif ($action == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    // Cari URL gambar untuk dihapus
    $stmt = $db->prepare("SELECT image_url FROM experiences WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $row = $stmt->fetch();
    
    if($row && !empty($row['image_url'])) {
        $file_path = __DIR__ . '/' . $row['image_url'];
        if(file_exists($file_path)) unlink($file_path);
    }

    $del = $db->prepare("DELETE FROM experiences WHERE id = :id");
    $del->execute([':id' => $id]);
    
    // PERUBAHAN DI SINI (SUCCESS DELETE)
    $_SESSION['swal_success'] = 'Proyek berhasil dihapus!';
    header('Location: index.php?page=admin_experience');
    exit;
} else {
    // Jika diakses tanpa parameter yang jelas
    header('Location: index.php?page=admin_experience');
    exit;
}
?>