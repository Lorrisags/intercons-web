<?php
/*
 * Path File: /views/admin/dashboard.php
 * Deskripsi: Konten halaman utama Dashboard Admin.
 * Menampilkan statistik dinamis dari database.
 */

require_once __DIR__ . '/../../config/database.php';
$db = (new Database())->getConnection();

// --- 1. Hitung Jumlah Anggota Tim ---
$stmt_team = $db->query("SELECT COUNT(*) FROM teams");
$count_team = $stmt_team->fetchColumn();

// --- 2. Hitung Jumlah Pengalaman/Proyek ---
$stmt_exp = $db->query("SELECT COUNT(*) FROM experiences");
$count_exp = $stmt_exp->fetchColumn();

// --- 3. Hitung Jumlah Layanan (Service) ---
$stmt_srv = $db->query("SELECT COUNT(*) FROM services");
$count_srv = $stmt_srv->fetchColumn();

// --- 4. Hitung Jumlah Katalog Produk ---
$stmt_prod = $db->query("SELECT COUNT(*) FROM products");
$count_prod = $stmt_prod->fetchColumn();

// --- 5. Hitung Jumlah Pesan Kontak Masuk ---
$stmt_msg = $db->query("SELECT COUNT(*) FROM contact_messages");
$count_msg = $stmt_msg->fetchColumn();

// --- 6. Hitung Jumlah Foto Galeri (Dari JSON Settings) ---
$stmt_gal = $db->query("SELECT setting_value FROM settings WHERE setting_key = 'gallery_data'");
$gallery_json = $stmt_gal->fetchColumn();
$galleries = $gallery_json ? json_decode($gallery_json, true) : [];
$count_gal = count($galleries);
?>
<div class="d-flex align-items-center mb-4 pb-2 border-bottom">
    <div class="bg-primary text-white rounded p-2 me-3 shadow-sm">
        <i class="fas fa-th-large fa-fw fa-lg"></i>
    </div>
    <div>
        <h3 class="mb-0 fw-bold" style="color: #2c3e50;">Panel Kendali Konten</h3>
        <p class="text-muted mb-0 small">Kelola seluruh halaman dan fitur website Anda dari sini</p>
    </div>
</div>

<div class="row g-4 mb-5">
    
    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm rounded-3 h-100 position-relative overflow-hidden text-center" style="transition: transform 0.3s; cursor: pointer;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'" onclick="window.location.href='?page=admin_home'">
            <div class="position-absolute top-0 start-0 w-100" style="height: 4px; background-color: #007bff;"></div>
            <div class="card-body p-4">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle shadow-sm mb-3" style="width: 60px; height: 60px; background-color: rgba(0, 123, 255, 0.1); color: #007bff;">
                    <i class="fas fa-home fa-2x"></i>
                </div>
                <h5 class="fw-bold text-dark mb-1">Home</h5>
                <p class="text-muted small mb-3">Kelola Teks Banner & Hero</p>
                <a href="?page=admin_home" class="btn btn-sm w-100 fw-bold text-primary" style="background-color: rgba(0, 123, 255, 0.05); border: 1px solid rgba(0,123,255,0.2);">Kelola Beranda</a>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm rounded-3 h-100 position-relative overflow-hidden text-center" style="transition: transform 0.3s; cursor: pointer;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'" onclick="window.location.href='?page=admin_about'">
            <div class="position-absolute top-0 start-0 w-100" style="height: 4px; background-color: #17a2b8;"></div>
            <div class="card-body p-4">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle shadow-sm mb-3" style="width: 60px; height: 60px; background-color: rgba(23, 162, 184, 0.1); color: #17a2b8;">
                    <i class="fas fa-info-circle fa-2x"></i>
                </div>
                <h5 class="fw-bold text-dark mb-1">About</h5>
                <p class="text-muted small mb-3">Visi, Misi & Profil Perusahaan</p>
                <a href="?page=admin_about" class="btn btn-sm w-100 fw-bold text-info" style="background-color: rgba(23, 162, 184, 0.05); border: 1px solid rgba(23,162,184,0.2);">Kelola Tentang</a>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm rounded-3 h-100 position-relative overflow-hidden text-center" style="transition: transform 0.3s; cursor: pointer;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'" onclick="window.location.href='?page=admin_gallery'">
            <div class="position-absolute top-0 start-0 w-100" style="height: 4px; background-color: #dc3545;"></div>
            <div class="card-body p-4">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle shadow-sm mb-3" style="width: 60px; height: 60px; background-color: rgba(220, 53, 69, 0.1); color: #dc3545;">
                    <i class="fas fa-images fa-2x"></i>
                </div>
                <h5 class="fw-bold text-dark mb-1">Gallery</h5>
                <p class="text-muted small mb-3"><?php echo $count_gal; ?> Foto Dokumentasi Proyek</p>
                <a href="?page=admin_gallery" class="btn btn-sm w-100 fw-bold text-danger" style="background-color: rgba(220, 53, 69, 0.05); border: 1px solid rgba(220,53,69,0.2);">Kelola Galeri</a>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm rounded-3 h-100 position-relative overflow-hidden text-center" style="transition: transform 0.3s; cursor: pointer;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'" onclick="window.location.href='?page=admin_team'">
            <div class="position-absolute top-0 start-0 w-100" style="height: 4px; background-color: #6f42c1;"></div>
            <div class="card-body p-4">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle shadow-sm mb-3" style="width: 60px; height: 60px; background-color: rgba(111, 66, 193, 0.1); color: #6f42c1;">
                    <i class="fas fa-users fa-2x"></i>
                </div>
                <h5 class="fw-bold text-dark mb-1">Team</h5>
                <p class="text-muted small mb-3"><?php echo $count_team; ?> Anggota Manajemen & Ahli</p>
                <a href="?page=admin_team" class="btn btn-sm w-100 fw-bold" style="color: #6f42c1; background-color: rgba(111, 66, 193, 0.05); border: 1px solid rgba(111,66,193,0.2);">Kelola Tim</a>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm rounded-3 h-100 position-relative overflow-hidden text-center" style="transition: transform 0.3s; cursor: pointer;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'" onclick="window.location.href='?page=admin_experience'">
            <div class="position-absolute top-0 start-0 w-100" style="height: 4px; background-color: #28a745;"></div>
            <div class="card-body p-4">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle shadow-sm mb-3" style="width: 60px; height: 60px; background-color: rgba(40, 167, 69, 0.1); color: #28a745;">
                    <i class="fas fa-hard-hat fa-2x"></i>
                </div>
                <h5 class="fw-bold text-dark mb-1">Experience</h5>
                <p class="text-muted small mb-3"><?php echo $count_exp; ?> Portofolio Proyek</p>
                <a href="?page=admin_experience" class="btn btn-sm w-100 fw-bold" style="color: #28a745; background-color: rgba(40, 167, 69, 0.05); border: 1px solid rgba(40,167,69,0.2);">Kelola Proyek</a>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm rounded-3 h-100 position-relative overflow-hidden text-center" style="transition: transform 0.3s; cursor: pointer;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'" onclick="window.location.href='?page=admin_service'">
            <div class="position-absolute top-0 start-0 w-100" style="height: 4px; background-color: #fd7e14;"></div>
            <div class="card-body p-4">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle shadow-sm mb-3" style="width: 60px; height: 60px; background-color: rgba(253, 126, 20, 0.1); color: #fd7e14;">
                    <i class="fas fa-cogs fa-2x"></i>
                </div>
                <h5 class="fw-bold text-dark mb-1">Service</h5>
                <p class="text-muted small mb-3"><?php echo $count_srv; ?> Daftar Layanan Perusahaan</p>
                <a href="?page=admin_service" class="btn btn-sm w-100 fw-bold text-warning" style="background-color: rgba(253, 126, 20, 0.05); border: 1px solid rgba(253,126,20,0.2);">Kelola Layanan</a>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm rounded-3 h-100 position-relative overflow-hidden text-center" style="transition: transform 0.3s; cursor: pointer;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'" onclick="window.location.href='?page=admin_products'">
            <div class="position-absolute top-0 start-0 w-100" style="height: 4px; background-color: #20c997;"></div>
            <div class="card-body p-4">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle shadow-sm mb-3" style="width: 60px; height: 60px; background-color: rgba(32, 201, 151, 0.1); color: #20c997;">
                    <i class="fas fa-box-open fa-2x"></i>
                </div>
                <h5 class="fw-bold text-dark mb-1">Products</h5>
                <p class="text-muted small mb-3"><?php echo $count_prod; ?> Item Katalog Produk</p>
                <a href="?page=admin_products" class="btn btn-sm w-100 fw-bold" style="color: #20c997; background-color: rgba(32, 201, 151, 0.05); border: 1px solid rgba(32,201,151,0.2);">Kelola Produk</a>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm rounded-3 h-100 position-relative overflow-hidden text-center" style="transition: transform 0.3s; cursor: pointer;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'" onclick="window.location.href='?page=admin_contact'">
            <div class="position-absolute top-0 start-0 w-100" style="height: 4px; background-color: #ffc107;"></div>
            <div class="card-body p-4">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle shadow-sm mb-3" style="width: 60px; height: 60px; background-color: rgba(255, 193, 7, 0.1); color: #ffc107;">
                    <i class="fas fa-envelope-open-text fa-2x"></i>
                </div>
                <h5 class="fw-bold text-dark mb-1">Contact</h5>
                <p class="text-muted small mb-3">
                    <?php if($count_msg > 0): ?>
                        <span class="badge bg-danger"><?php echo $count_msg; ?> Pesan Baru</span>
                    <?php else: ?>
                        0 Pesan Baru
                    <?php endif; ?>
                </p>
                <a href="?page=admin_contact" class="btn btn-sm w-100 fw-bold text-dark" style="background-color: rgba(255, 193, 7, 0.1); border: 1px solid rgba(255,193,7,0.3);">Lihat Pesan / Booking</a>
            </div>
        </div>
    </div>

</div>