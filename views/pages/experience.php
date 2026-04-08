<?php
/* Path File: /views/pages/experience.php */
require_once __DIR__ . '/../../config/database.php';
$db = (new Database())->getConnection();

$stmt = $db->prepare("SELECT * FROM experiences ORDER BY id DESC");
$stmt->execute();
$experiences = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="container-fluid" style="background-color: #003B73; padding: 140px 0 60px 0; background-image: url('https://www.transparenttextures.com/patterns/cubes.png');">
    <div class="container text-center">
        <h1 class="fw-bold text-white mb-2" style="letter-spacing: 1px;">Pengalaman Proyek</h1>
        <p style="color: #00BFFF; font-size: 1.1rem;"><i class="fas fa-hard-hat me-2"></i>Rekam jejak dan portofolio proyek unggulan kami</p>
    </div>
</div>

<section class="py-5 bg-light" style="min-height: 60vh;">
    <div class="container py-4">
        
        <?php if(empty($experiences)): ?>
            <div class="text-center py-5">
                <i class="fas fa-folder-open fa-4x mb-3 text-muted opacity-50"></i>
                <h4 class="text-muted">Portofolio Belum Tersedia</h4>
                <p>Data proyek sedang dalam tahap pembaruan.</p>
            </div>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach($experiences as $exp): ?>
                <div class="col-lg-4 col-md-6">
                    <div class="card border-0 shadow-sm overflow-hidden h-100 rounded-4" style="transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                        <div class="position-relative">
                            <img src="<?php echo htmlspecialchars($exp['image_url'] ? $exp['image_url'] : 'https://via.placeholder.com/400x250'); ?>" class="card-img-top" alt="Project" style="height: 250px; object-fit: cover;">
                            <div class="position-absolute bottom-0 start-0 w-100 p-3" style="background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);">
                                <span class="badge bg-info text-dark fw-bold px-3 py-2"><i class="fas fa-building me-1"></i> <?php echo htmlspecialchars($exp['client_name']); ?></span>
                            </div>
                        </div>
                        <div class="card-body p-4 bg-white">
                            <h5 class="fw-bold mb-3" style="color: #003B73;"><?php echo htmlspecialchars($exp['project_name']); ?></h5>
                            <p class="text-muted small mb-0" style="line-height: 1.6; text-align: justify;">
                                <?php echo nl2br(htmlspecialchars($exp['details'])); ?>
                            </p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</section>