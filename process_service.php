<?php
session_start();
require_once __DIR__ . '/config/database.php';
$db = (new Database())->getConnection();

$action = isset($_GET['action']) ? $_GET['action'] : '';
$upload_dir = __DIR__ . '/assets/uploads/services/';
if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

if ($action == 'add' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $image_url = '';
    
    // Proses Upload Gambar
    if(isset($_FILES["image"]) && $_FILES["image"]["error"] === 0) {
        $ext = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
        if(in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
            $new_name = "srv_" . time() . "_" . uniqid() . "." . $ext;
            if(move_uploaded_file($_FILES["image"]["tmp_name"], $upload_dir . $new_name)) {
                $image_url = 'assets/uploads/services/' . $new_name;
            }
        }
    }

    $stmt = $db->prepare("INSERT INTO services (title, image_url, short_description, full_description) VALUES (?, ?, ?, ?)");
    $stmt->execute([$_POST['title'], $image_url, $_POST['short_desc'], $_POST['full_desc']]);
    
    $_SESSION['swal_success'] = 'Layanan berhasil ditambahkan!';
    header('Location: index.php?page=admin_service');
    exit;}

if ($action == 'delete') {
    // Hapus file gambar dari folder
    $stmt = $db->prepare("SELECT image_url FROM services WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $row = $stmt->fetch();
    
    if($row && !empty($row['image_url'])) {
        $file_path = __DIR__ . '/' . $row['image_url'];
        if(file_exists($file_path)) unlink($file_path);
    }

    // Hapus dari database
    $stmt = $db->prepare("DELETE FROM services WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    
    $_SESSION['swal_success'] = 'Layanan berhasil dihapus!';
    header('Location: index.php?page=admin_service');
    exit;
}
?>