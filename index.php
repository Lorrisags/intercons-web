<?php
/*
 * Path File: /index.php
 * Deskripsi: File utama (Front Controller) yang mengatur routing ke seluruh halaman website.
 */
session_start();

// Menangkap parameter 'page' dari URL (contoh: domain.com/index.php?page=admin)
// Jika kosong, default ke 'home'
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// --- ROUTING SEDERHANA ---
switch ($page) {
    // ==========================================
    // HALAMAN PUBLIK (PENGUNJUNG)
    // ==========================================
    case 'home':
        require_once 'views/layouts/public_header.php';
        require_once 'views/pages/home.php';
        require_once 'views/layouts/public_footer.php';
        break;

    case 'about':
        require_once 'views/layouts/public_header.php';
        // Memuat file about_section yang sudah Anda miliki
        require_once 'views/pages/about_section.php'; 
        require_once 'views/layouts/public_footer.php';
        break;

    case 'service':
        require_once 'views/layouts/public_header.php';
        require_once 'views/pages/service.php';
        require_once 'views/layouts/public_footer.php';
        break;

    case 'products':
        require_once 'views/layouts/public_header.php';
        require_once 'views/pages/products.php';
        require_once 'views/layouts/public_footer.php';
        break;

    case 'contact':
        require_once 'views/layouts/public_header.php';
        require_once 'views/pages/contact.php';
        require_once 'views/layouts/public_footer.php';
        break;

    // --- Sub-menu dari Dropdown "Page" ---
    case 'gallery':
        require_once 'views/layouts/public_header.php';
        require_once 'views/pages/gallery.php';
        require_once 'views/layouts/public_footer.php';
        break;

    case 'team':
        require_once 'views/layouts/public_header.php';
        require_once 'views/pages/team.php';
        require_once 'views/layouts/public_footer.php';
        break;

    case 'experience':
        require_once 'views/layouts/public_header.php';
        require_once 'views/pages/career.php';
        require_once 'views/layouts/public_footer.php';
        break;


    // ==========================================
    // HALAMAN AUTENTIKASI (LOGIN & LOGOUT)
    // ==========================================
    case 'login':
        // Halaman login tidak butuh header/footer public
        require_once 'views/auth/login.php';
        break;

    case 'logout':
        require_once 'views/auth/logout.php';
        break;


    // ==========================================
    // HALAMAN ADMIN PANEL
    // ==========================================
    case 'admin':
        // KEAMANAN: Cek sesi login. Jika belum login, tendang ke halaman login!
        if(!isset($_SESSION['admin'])) { 
            header('Location: ?page=login'); 
            exit; 
        }
        
        require_once 'views/layouts/admin_header.php';
        require_once 'views/admin/dashboard.php';
        require_once 'views/layouts/admin_footer.php';
        break;

    case 'admin_products':
        // KEAMANAN: Cek sesi login
        if(!isset($_SESSION['admin'])) { 
            header('Location: ?page=login'); 
            exit; 
        }
        
        require_once 'views/layouts/admin_header.php';
        require_once 'views/admin/products.php';
        require_once 'views/layouts/admin_footer.php';
        break;

    // ==========================================
    // JIKA URL TIDAK COCOK DENGAN APA PUN
    // ==========================================
    default:
        // Menampilkan halaman 404
        require_once 'views/layouts/public_header.php';
        echo "<div class='container text-center' style='padding: 150px 0; min-height: 70vh;'>
                <h1 class='display-1 fw-bold text-danger'>404</h1>
                <h2>Halaman Tidak Ditemukan</h2>
                <p class='text-muted'>Maaf, halaman yang Anda cari tidak tersedia atau URL salah.</p>
                <a href='?page=home' class='btn btn-primary mt-3'>Kembali ke Home</a>
              </div>";
        require_once 'views/layouts/public_footer.php';
        break;
        case 'admin_home':
        if(!isset($_SESSION['admin'])) { header('Location: ?page=login'); exit; }
        
        require_once 'views/layouts/admin_header.php';
        require_once 'views/admin/admin_home.php';
        require_once 'views/layouts/admin_footer.php';
        break;
        case 'admin_about':
        if(!isset($_SESSION['admin'])) { header('Location: ?page=login'); exit; }
        
        require_once 'views/layouts/admin_header.php';
        require_once 'views/admin/admin_about.php';
        require_once 'views/layouts/admin_footer.php';
        break;
        case 'admin_gallery':
        if(!isset($_SESSION['admin'])) { header('Location: ?page=login'); exit; }
        
        require_once 'views/layouts/admin_header.php';
        require_once 'views/admin/admin_gallery.php';
        require_once 'views/layouts/admin_footer.php';
        break;
        case 'admin_settings':
        // Cek Sesi Login
        if(!isset($_SESSION['admin'])) { header('Location: ?page=login'); exit; }
        
        require_once 'views/layouts/admin_header.php';
        require_once 'views/admin/admin_settings.php';
        require_once 'views/layouts/admin_footer.php';
        break;
}
?> 