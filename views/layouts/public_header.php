<?php
/*
 * Path File: /views/layouts/public_header.php
 * Deskripsi: Template bagian atas (Header & Navbar) untuk halaman pengunjung.
 */

require_once __DIR__ . '/../../config/database.php';
$db_conn = (new Database())->getConnection();

// Mengambil pengaturan menu dari database secara aman
$menu_settings = [];
if ($db_conn) {
    try {
        $stmt_menu = $db_conn->prepare("SELECT setting_key, setting_value FROM settings WHERE setting_key LIKE 'menu_%'");
        $stmt_menu->execute();
        while ($row = $stmt_menu->fetch(PDO::FETCH_ASSOC)) {
            $menu_settings[$row['setting_key']] = $row['setting_value'];
        }
    } catch (PDOException $e) {}
}

// Fungsi pembantu untuk mengambil label atau status (Dilindungi agar tidak error)
if (!function_exists('getMenu')) {
    function getMenu($key, $type, $default) {
        global $menu_settings;
        return isset($menu_settings["menu_{$key}_{$type}"]) ? $menu_settings["menu_{$key}_{$type}"] : $default;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intercons - Industrial Service</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { 
            --primary: #003B73;
            --secondary: #005B96;
            --accent: #03A9F4;
            --text-light: #E1F5FE;
            --text-dark: #333333;
        }
        body { font-family: 'Segoe UI', Tahoma, sans-serif; color: var(--text-dark); padding-top: 76px; }
        
        .navbar { background-color: #ffffff; padding: 1rem 2rem; border-bottom: 1px solid #eee; }
        .navbar-brand { color: var(--primary) !important; font-weight: 800; text-transform: uppercase; font-size: 1.4rem; }
        .navbar-brand i { color: var(--accent); margin-right: 8px; }
        
        .nav-link { color: #333333 !important; margin: 0 10px; transition: 0.3s; font-weight: 600; font-size: 0.95rem; }
        .nav-link:hover { color: var(--accent) !important; }
        .dropdown-item { font-weight: 500; padding: 10px 20px; }
    </style>
</head>
<body>

<!-- Navbar Dinamis -->
<nav class="navbar navbar-expand-lg fixed-top shadow-sm">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center" href="?page=home">
            <i class="fas fa-layer-group fa-lg"></i> Intercons
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav align-items-center">
                
                <?php if(getMenu('home', 'show', '1') == '1'): ?>
                    <li class="nav-item"><a class="nav-link" href="?page=home"><?php echo htmlspecialchars(getMenu('home', 'label', 'Home')); ?></a></li>
                <?php endif; ?>

                <?php if(getMenu('about', 'show', '1') == '1'): ?>
                    <li class="nav-item"><a class="nav-link" href="?page=about"><?php echo htmlspecialchars(getMenu('about', 'label', 'About')); ?></a></li>
                <?php endif; ?>
                
                <?php if(getMenu('page', 'show', '1') == '1'): ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php echo htmlspecialchars(getMenu('page', 'label', 'Page')); ?>
                    </a>
                    <ul class="dropdown-menu border-0 shadow-sm mt-2" aria-labelledby="navbarDropdown">
                        <?php if(getMenu('gallery', 'show', '1') == '1'): ?>
                            <li><a class="dropdown-item" href="?page=gallery"><?php echo htmlspecialchars(getMenu('gallery', 'label', 'Gallery')); ?></a></li>
                        <?php endif; ?>
                        <?php if(getMenu('team', 'show', '1') == '1'): ?>
                            <li><a class="dropdown-item" href="?page=team"><?php echo htmlspecialchars(getMenu('team', 'label', 'Team')); ?></a></li>
                        <?php endif; ?>
                        <?php if(getMenu('career', 'show', '1') == '1'): ?>
                            <li><a class="dropdown-item" href="?page=experience"><?php echo htmlspecialchars(getMenu('career', 'label', 'Experience')); ?></a></li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>
                
                <?php if(getMenu('service', 'show', '1') == '1'): ?>
                    <li class="nav-item"><a class="nav-link" href="?page=service"><?php echo htmlspecialchars(getMenu('service', 'label', 'Service')); ?></a></li>
                <?php endif; ?>

                <?php if(getMenu('product', 'show', '1') == '1'): ?>
                    <li class="nav-item"><a class="nav-link" href="?page=products"><?php echo htmlspecialchars(getMenu('product', 'label', 'Product Catalogue')); ?></a></li>
                <?php endif; ?>

                <?php if(getMenu('contact', 'show', '1') == '1'): ?>
                    <li class="nav-item"><a class="nav-link" href="?page=contact"><?php echo htmlspecialchars(getMenu('contact', 'label', 'Contact')); ?></a></li>
                <?php endif; ?>

                <!-- Tombol Akses Admin Panel (Selalu mengarah ke Form Login) -->
                <li class="nav-item ms-lg-3 mt-2 mt-lg-0">
                    <a href="?page=login" class="btn btn-outline-primary btn-sm fw-bold px-3 shadow-sm" style="border-radius: 20px;">
                        <i class="fas fa-sign-in-alt me-1"></i> Login Admin
                    </a>
                </li>

            </ul>
        </div>
    </div>
</nav>