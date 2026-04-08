<?php
/*
 * Path File: /views/pages/gallery.php
 * Deskripsi: Halaman Galeri Publik yang meloop data JSON tanpa batas.
 */

require_once __DIR__ . '/../../config/database.php';
$db = (new Database())->getConnection();

// Ambil data dari JSON (Sistem Baru)
$stmt = $db->prepare("SELECT setting_value FROM settings WHERE setting_key = 'gallery_data'");
$stmt->execute();
$gallery_json = $stmt->fetchColumn();
$galleries = $gallery_json ? json_decode($gallery_json, true) : [];
?>
<!-- Page Header -->
<div class="container-fluid" style="background-color: #003B73; padding: 140px 0 60px 0; background-image: url('https://www.transparenttextures.com/patterns/cubes.png');">
    <div class="container text-center">
        <h1 class="fw-bold text-white mb-2" style="letter-spacing: 1px;">Galeri Proyek & Fasilitas</h1>
        <p style="color: #00BFFF; font-size: 1.1rem;"><i class="fas fa-camera me-2"></i>Dokumentasi hasil kerja dan fasilitas modern PT Intercons</p>
    </div>
</div>

<!-- Gallery Content -->
<section class="py-5 bg-light" style="min-height: 60vh;">
    <div class="container py-4">
        
        <?php if(empty($galleries)): ?>
            <!-- Jika tidak ada foto sama sekali -->
            <div class="text-center py-5">
                <i class="fas fa-images fa-4x mb-3 text-muted opacity-50"></i>
                <h4 class="text-muted">Koleksi Galeri Sedang Disiapkan</h4>
                <p>Nantikan dokumentasi proyek-proyek terbaru kami di sini.</p>
            </div>
        <?php else: ?>
            <!-- Looping semua foto (Dinamic Grid) -->
            <div class="row g-4">
                <?php foreach($galleries as $item): ?>
                <div class="col-lg-4 col-md-6">
                    <div class="card border-0 shadow-sm overflow-hidden rounded-3 h-100" style="transition: 0.3s; cursor: pointer;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                        <img src="<?php echo htmlspecialchars($item['img']); ?>" class="card-img-top bg-dark" alt="<?php echo htmlspecialchars($item['title']); ?>" style="height: 250px; object-fit: cover;">
                        <div class="card-body text-center p-3">
                            <h6 class="fw-bold mb-1" style="color: #003B73;"><?php echo htmlspecialchars($item['title']); ?></h6>
                            <p class="text-muted small mb-0"><?php echo htmlspecialchars($item['loc']); ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</section>