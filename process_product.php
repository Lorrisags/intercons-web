<?php
session_start();
require_once __DIR__ . '/config/database.php';
$db = (new Database())->getConnection();

$action = isset($_GET['action']) ? $_GET['action'] : '';

// Buat folder uploads untuk produk jika belum ada
$upload_dir = __DIR__ . '/assets/uploads/products/';
if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

// AKSI TAMBAH PRODUK
if ($action == 'add' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $image_url = '';
    
    // Proses Upload Gambar
    if(isset($_FILES["image"]) && $_FILES["image"]["error"] === 0) {
        $ext = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
        if(in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
            $new_name = "prod_" . time() . "_" . uniqid() . "." . $ext;
            if(move_uploaded_file($_FILES["image"]["tmp_name"], $upload_dir . $new_name)) {
                $image_url = 'assets/uploads/products/' . $new_name;
            }
        }
    }

    $stmt = $db->prepare("INSERT INTO products (name, category, image_url, description) VALUES (?, ?, ?, ?)");
    $stmt->execute([$_POST['name'], $_POST['category'], $image_url, $_POST['description']]);
    
    $_SESSION['swal_success'] = 'Produk berhasil ditambahkan!';
    header('Location: index.php?page=admin_products');
    exit;
}

// AKSI HAPUS PRODUK
if ($action == 'delete') {
    // Cari path gambar
    $stmt = $db->prepare("SELECT image_url FROM products WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $row = $stmt->fetch();
    
    // Hapus file gambar dari server jika itu file lokal (bukan link URL luar)
    if($row && !empty($row['image_url']) && !filter_var($row['image_url'], FILTER_VALIDATE_URL)) {
        $file_path = __DIR__ . '/' . $row['image_url'];
        if(file_exists($file_path)) unlink($file_path);
    }

    // Hapus dari database
    $stmt = $db->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    
    $_SESSION['swal_success'] = 'Produk berhasil dihapus!';
    header('Location: index.php?page=admin_products');
    exit;
}
?>