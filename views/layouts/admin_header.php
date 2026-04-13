<?php
/*
 * Path File: /views/layouts/admin_header.php
 * Deskripsi: Template bagian atas dan Sidebar modern untuk panel Admin.
 */
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Modern</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts (Inter) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --sidebar-bg: #0f172a;      /* Slate 900 */
            --sidebar-hover: #1e293b;   /* Slate 800 */
            --sidebar-text: #94a3b8;    /* Slate 400 */
            --sidebar-active-bg: #3b82f6; /* Blue 500 */
            --sidebar-active-text: #ffffff;
            --body-bg: #f8fafc;         /* Slate 50 */
        }

        body { 
            background-color: var(--body-bg); 
            display: flex; 
            font-family: 'Inter', sans-serif; 
            overflow-x: hidden;
        }
        
        /* Modern Sidebar */
        .admin-sidebar { 
            width: 280px; 
            background-color: var(--sidebar-bg); 
            color: var(--sidebar-text); 
            height: 100vh; /* Diubah menjadi height tetap agar bisa discroll */
            position: fixed; 
            top: 0;
            left: 0;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
        }

        /* Sidebar Brand/Logo Area (Diubah menjadi Link yang bisa diklik) */
        .sidebar-brand {
            height: 75px;
            min-height: 75px; /* Mencegah logo menyusut */
            display: flex;
            align-items: center;
            padding: 0 1.5rem;
            font-size: 1.25rem;
            font-weight: 700;
            color: white;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            letter-spacing: 0.5px;
            text-decoration: none;
            transition: opacity 0.2s ease;
        }
        .sidebar-brand:hover {
            color: white;
            opacity: 0.85; /* Efek meredup sedikit saat di-hover */
        }

        /* Custom Scrollbar for Sidebar */
        .sidebar-menu-container {
            flex-grow: 1;
            overflow-y: auto; /* Mengaktifkan scroll vertikal */
            padding-bottom: 1rem;
        }
        .sidebar-menu-container::-webkit-scrollbar { width: 5px; }
        .sidebar-menu-container::-webkit-scrollbar-track { background: transparent; }
        .sidebar-menu-container::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }
        .sidebar-menu-container::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.2); }

        /* Menu Section Header */
        .menu-heading {
            padding: 1.5rem 1.5rem 0.5rem 1.5rem;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #64748b;
        }
        
        /* Nav Links (Pill Style) */
        .admin-sidebar a.nav-link { 
            color: var(--sidebar-text); 
            padding: 0.75rem 1rem; 
            margin: 0.25rem 1rem;
            border-radius: 0.5rem; /* Efek membulat (Pill) */
            display: flex; 
            align-items: center;
            justify-content: space-between;
            text-decoration: none; 
            transition: all 0.25s ease;
            font-weight: 500;
            font-size: 0.9rem;
        }
        
        /* Hover State */
        .admin-sidebar a.nav-link:hover { 
            background-color: var(--sidebar-hover); 
            color: #f1f5f9; 
            transform: translateX(3px); /* Sedikit geser ke kanan saat di-hover */
        }

        /* Active State dengan Soft Glow */
        .admin-sidebar a.nav-link.active { 
            background-color: var(--sidebar-active-bg); 
            color: var(--sidebar-active-text); 
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3); /* Efek bercahaya */
        }

        .admin-sidebar .nav-link i.icon-main {
            width: 28px;
            font-size: 1.1rem;
            text-align: center;
            margin-right: 12px;
            transition: color 0.3s ease;
        }

        .admin-sidebar a.nav-link:hover i.icon-main {
            color: var(--sidebar-active-bg);
        }
        .admin-sidebar a.nav-link.active i.icon-main {
            color: white;
        }

        /* Sub-menu styling */
        .collapse .nav-link {
            padding-left: 3.5rem !important;
            font-size: 0.85rem;
            margin-top: 0.1rem;
            margin-bottom: 0.1rem;
            color: #64748b;
        }
        .collapse .nav-link:hover, .collapse .nav-link.active-sub {
            background-color: transparent;
            color: #f8fafc;
            transform: translateX(5px);
        }
        .collapse .nav-link::before {
            content: '';
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background-color: #64748b;
            position: absolute;
            left: 2.2rem;
            transition: all 0.3s;
        }
        .collapse .nav-link:hover::before, .collapse .nav-link.active-sub::before {
            background-color: var(--sidebar-active-bg);
            box-shadow: 0 0 8px var(--sidebar-active-bg);
        }

        /* Dropdown Chevron Animation */
        .nav-link[data-bs-toggle="collapse"] .fa-chevron-right {
            transition: transform 0.3s ease;
            font-size: 0.75rem;
        }
        .nav-link[data-bs-toggle="collapse"][aria-expanded="true"] .fa-chevron-right {
            transform: rotate(90deg);
        }

        /* User Profile Area (Bottom) */
        .sidebar-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            background-color: rgba(0,0,0,0.1);
            margin-top: auto; /* Memastikan footer selalu berada di bagian paling bawah */
        }

        /* Area Konten Utama */
        .admin-content { 
            flex-grow: 1; 
            padding: 2rem 2.5rem; 
            margin-left: 280px; 
            min-height: 100vh;
        }
    </style>
</head>
<body>

<!-- Sidebar Admin -->
<div class="admin-sidebar shadow-lg">
    
    <!-- Brand / Logo (Kini bisa diklik dan kembali ke Dashboard) -->
    <a href="?page=admin" class="sidebar-brand d-flex align-items-center">
    <img src="assets/uploads/gallery/intercons.png" alt="Logo Admin" style="height: 32px; margin-right: 12px;">
    <span style="font-size: 1.1rem; font-weight: 700;">PT.INTERCONS</span>
</a>

    <!-- Menus -->
    <div class="sidebar-menu-container">
        
        <div class="menu-heading">Core</div>
        <!-- Dashboard -->
        <a href="?page=admin" class="nav-link <?php echo ($page == 'admin') ? 'active' : ''; ?>">
            <div class="d-flex align-items-center"><i class="fas fa-home icon-main"></i> Dashboard</div>
        </a>

        <!-- Settings -->
        <a href="#" class="nav-link">
            <div class="d-flex align-items-center"><i class="fas fa-cog icon-main"></i> Settings</div>
        </a>

        
        <div class="menu-heading">Modules</div>

        <?php 
            // Mengecek apakah halaman saat ini adalah bagian dari admin (agar menu terbuka otomatis)
            $isPageSectionActive = (isset($_GET['page']) && strpos($_GET['page'], 'admin_') !== false && $page != 'admin'); 
        ?>
        <a href="#pageSubmenu" data-bs-toggle="collapse" class="nav-link <?php echo !$isPageSectionActive ? 'collapsed' : ''; ?>" aria-expanded="<?php echo $isPageSectionActive ? 'true' : 'false'; ?>">
            <div class="d-flex align-items-center"><i class="far fa-window-maximize icon-main"></i> Page Section</div>
            <i class="fas fa-chevron-right"></i>
        </a>
        <div class="collapse <?php echo $isPageSectionActive ? 'show' : ''; ?>" id="pageSubmenu">
            <a href="?page=admin_home" class="nav-link position-relative <?php echo ($page == 'admin_home') ? 'active-sub text-white' : ''; ?>">Home Page</a>
            <a href="?page=admin_about" class="nav-link position-relative <?php echo ($page == 'admin_about') ? 'active-sub text-white' : ''; ?>">About Page</a>
            <a href="?page=admin_service" class="nav-link position-relative <?php echo ($page == 'admin_service') ? 'active-sub text-white' : ''; ?>">Service Page</a>
            <a href="?page=admin_products" class="nav-link position-relative <?php echo ($page == 'admin_products') ? 'active-sub text-white' : ''; ?>">Products Catalogue</a>
            <a href="?page=admin_gallery" class="nav-link position-relative <?php echo ($page == 'admin_gallery') ? 'active-sub text-white' : ''; ?>">Gallery Page</a>
            <a href="?page=admin_team" class="nav-link position-relative <?php echo ($page == 'admin_team') ? 'active-sub text-white' : ''; ?>">Team Page</a>
            <a href="?page=admin_experience" class="nav-link position-relative <?php echo ($page == 'admin_experience') ? 'active-sub text-white' : ''; ?>">Experience Page</a>
            <a href="?page=admin_contact" class="nav-link position-relative <?php echo ($page == 'admin_contact') ? 'active-sub text-white' : ''; ?>">Contact / Booking</a>
        </div>

        <!-- Captcha Section (Dropdown) -->
        <a href="#captchaSubmenu" data-bs-toggle="collapse" class="nav-link">
            <div class="d-flex align-items-center"><i class="fas fa-shield-alt icon-main"></i> Captcha Section</div>
            <i class="fas fa-chevron-right"></i>
        </a>
        <div class="collapse" id="captchaSubmenu">
            <a href="#" class="nav-link position-relative">Pengaturan Captcha</a>
        </div>

        <!-- Dynamic Pages -->
        <a href="#" class="nav-link">
            <div class="d-flex align-items-center"><i class="fas fa-stream icon-main"></i> Dynamic Pages</div>
        </a>

        <div class="menu-heading">Content</div>

        <!-- News (Dropdown) -->
        <a href="#newsSubmenu" data-bs-toggle="collapse" class="nav-link">
            <div class="d-flex align-items-center"><i class="far fa-newspaper icon-main"></i> News</div>
            <i class="fas fa-chevron-right"></i>
        </a>
        <div class="collapse" id="newsSubmenu">
            <a href="#" class="nav-link position-relative">Semua Berita</a>
            <a href="#" class="nav-link position-relative">Tambah Berita</a>
        
        </div>

        <!-- Event -->
        <a href="#" class="nav-link">
            <div class="d-flex align-items-center"><i class="far fa-calendar-check icon-main"></i> Event</div>
        </a>

        <!-- Subscriber (Dropdown) -->
        <a href="#subscriberSubmenu" data-bs-toggle="collapse" class="nav-link">
    <div class="d-flex align-items-center"><i class="fas fa-envelope-open-text icon-main"></i> Subscriber</div>
    <i class="fas fa-chevron-right"></i>
</a>
<div class="collapse <?php echo ($page == 'admin_subscriber') ? 'show' : ''; ?>" id="subscriberSubmenu">
    <a href="?page=admin_subscriber" class="nav-link position-relative <?php echo ($page == 'admin_subscriber') ? 'active-sub text-white' : ''; ?>">Daftar Subscriber</a>
</div>

        <div class="menu-heading">Media & Components</div>

        <!-- Team Member -->
        <a href="#" class="nav-link">
            <div class="d-flex align-items-center"><i class="fas fa-user-friends icon-main"></i> Team Member</div>
        </a>

        <!-- Slider -->
        <a href="#" class="nav-link">
            <div class="d-flex align-items-center"><i class="far fa-images icon-main"></i> Slider</div>
        </a>

        <!-- Testimonial -->
        <a href="#" class="nav-link">
            <div class="d-flex align-items-center"><i class="far fa-comments icon-main"></i> Testimonial</div>
        </a>

        <!-- Photo Gallery -->
        <a href="#" class="nav-link">
            <div class="d-flex align-items-center"><i class="fas fa-camera-retro icon-main"></i> Photo Gallery</div>
        </a>

        <div class="menu-heading">System</div>

        <!-- Menu -->
        <a href="#" class="nav-link">
            <div class="d-flex align-items-center"><i class="fas fa-bars icon-main"></i> Nav Menu</div>
        </a>

        <!-- Language -->
        <a href="#" class="nav-link">
            <div class="d-flex align-items-center"><i class="fas fa-globe icon-main"></i> Language</div>
        </a>
        
        <!-- Footer Section -->
        <a href="#" class="nav-link">
            <div class="d-flex align-items-center"><i class="fas fa-shoe-prints icon-main"></i> Footer Section</div>
        </a>
        
    </div>

    <!-- Sidebar Footer (Logout/Profile Area) -->
    <div class="sidebar-footer">
        <a href="?page=logout" class="btn w-100 text-start border-0 text-white d-flex align-items-center justify-content-between p-2 rounded-3" style="background-color: rgba(239, 68, 68, 0.1); transition: 0.3s;" onmouseover="this.style.backgroundColor='rgba(239, 68, 68, 0.8)'" onmouseout="this.style.backgroundColor='rgba(239, 68, 68, 0.1)'">
            <div class="d-flex align-items-center">
                <div class="bg-danger rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px;">
                    <i class="fas fa-power-off small"></i>
                </div>
                <span class="fw-bold small">Log Out</span>
            </div>
            <i class="fas fa-sign-out-alt text-danger opacity-50"></i>
        </a>
    </div>

</div>

<!-- Mulai Area Konten Utama -->
<div class="admin-content">