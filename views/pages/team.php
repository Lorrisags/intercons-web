<?php
/*
 * Path File: /views/pages/team.php
 * Deskripsi: Halaman dinamis tentang jajaran manajemen dan tenaga ahli profesional PT Intercons.
 */

require_once __DIR__ . '/../../config/database.php';
$db = (new Database())->getConnection();

// Mengambil data Manajemen
$stmt_man = $db->prepare("SELECT * FROM teams WHERE category = 'Manajemen' ORDER BY id ASC");
$stmt_man->execute();
$manajemen = $stmt_man->fetchAll(PDO::FETCH_ASSOC);

// Mengambil data Tenaga Ahli
$stmt_ahli = $db->prepare("SELECT * FROM teams WHERE category = 'Tenaga Ahli' ORDER BY id ASC");
$stmt_ahli->execute();
$tenaga_ahli = $stmt_ahli->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="container-fluid" style="background-color: #003B73; padding: 140px 0 60px 0; background-image: url('https://www.transparenttextures.com/patterns/cubes.png');">
    <div class="container text-center">
        <h1 class="fw-bold text-white mb-2" style="letter-spacing: 1px;">Tim Profesional Kami</h1>
        <p style="color: #00BFFF; font-size: 1.1rem;"><i class="fas fa-users me-2"></i>Didukung oleh tenaga ahli yang kompeten & bersertifikasi</p>
    </div>
</div>

<section class="py-5 bg-white" style="min-height: 60vh;">
    <div class="container py-4">
        
        <h3 class="fw-bold text-center mb-4" style="color: #003B73;">Jajaran Manajemen</h3>
        
        <?php if(empty($manajemen)): ?>
            <p class="text-center text-muted">Data manajemen belum ditambahkan.</p>
        <?php else: ?>
            <div class="row justify-content-center g-4 mb-5 pb-4 border-bottom">
                <?php foreach($manajemen as $m): ?>
                <div class="col-lg-4 col-md-6">
                    <div class="card border-0 shadow-sm text-center p-4 h-100">
                        <img src="<?php echo htmlspecialchars($m['photo_url'] ? $m['photo_url'] : 'https://via.placeholder.com/150'); ?>" alt="<?php echo htmlspecialchars($m['name']); ?>" class="rounded-circle mx-auto mb-3 border border-4" style="width: 150px; height: 150px; object-fit: cover; border-color: #E1F5FE !important;">
                        <h5 class="fw-bold mb-1" style="color: #003B73;"><?php echo htmlspecialchars($m['name']); ?></h5>
                        <p class="text-muted small mb-3"><?php echo htmlspecialchars($m['position']); ?></p>
                        <div class="d-flex justify-content-center gap-2 mt-auto">
                            <a href="#" class="btn btn-sm btn-outline-info rounded-circle" style="width: 35px; height: 35px;"><i class="fab fa-linkedin-in" style="line-height: 1.5;"></i></a>
                            <a href="#" class="btn btn-sm btn-outline-info rounded-circle" style="width: 35px; height: 35px;"><i class="fas fa-envelope" style="line-height: 1.5;"></i></a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <h3 class="fw-bold text-center mb-4 mt-5" style="color: #003B73;">Tenaga Ahli Utama</h3>
        
        <?php if(empty($tenaga_ahli)): ?>
            <p class="text-center text-muted">Data tenaga ahli belum ditambahkan.</p>
        <?php else: ?>
            <div class="row text-center justify-content-center g-4">
                <?php foreach($tenaga_ahli as $t): ?>
                <div class="col-md-3 col-6">
                    <img src="<?php echo htmlspecialchars($t['photo_url'] ? $t['photo_url'] : 'https://via.placeholder.com/120'); ?>" alt="<?php echo htmlspecialchars($t['name']); ?>" class="rounded-circle mb-3 shadow-sm" style="width: 120px; height: 120px; object-fit: cover;">
                    <h6 class="fw-bold mb-0" style="color: #005B96;"><?php echo htmlspecialchars($t['name']); ?></h6>
                    <p class="text-muted small"><?php echo htmlspecialchars($t['position']); ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</section>