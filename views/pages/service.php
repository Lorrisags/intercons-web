<?php
require_once __DIR__ . '/../../config/database.php';
$db = (new Database())->getConnection();

$stmt = $db->prepare("SELECT * FROM services ORDER BY id ASC");
$stmt->execute();
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<section id="services" class="py-5 bg-light" style="min-height: 80vh;">
    <div class="container py-4">
        <div class="text-center mb-5">
            <h2 class="fw-bold" style="color: #003B73;">Layanan Unggulan Kami</h2>
            <div style="height: 4px; width: 60px; background-color: #03A9F4; margin: 0 auto; border-radius: 2px;"></div>
        </div>

        <div class="row g-4">
            <?php if(empty($services)): ?>
                <div class="col-12 text-center py-5">
                    <h5 class="text-muted">Data layanan belum ditambahkan.</h5>
                </div>
            <?php else: ?>
                <?php foreach($services as $s): ?>
                <div class="col-md-4 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm text-center border-bottom border-4 rounded-4 overflow-hidden" style="border-color: #fd7e14 !important; transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-8px)'" onmouseout="this.style.transform='translateY(0)'">
                        
                        <img src="<?php echo htmlspecialchars($s['image_url']); ?>" alt="<?php echo htmlspecialchars($s['title']); ?>" style="width: 100%; height: 220px; object-fit: cover;">
                        
                        <div class="card-body p-4 d-flex flex-column bg-white">
                            <h4 class="fw-bold mb-3" style="color: #005B96;"><?php echo htmlspecialchars($s['title']); ?></h4>
                            <p class="text-muted small mb-4"><?php echo htmlspecialchars($s['short_description']); ?></p>
                            
                            <div class="mt-auto">
                                <a href="?page=service_detail&id=<?php echo $s['id']; ?>" class="btn w-100 fw-bold border-warning text-warning rounded-3 hover-warning" style="transition: 0.3s;">
                                    Read More <i class="fas fa-arrow-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<style>
.hover-warning:hover {
    background-color: #ffc107;
    color: #fff !important;
}
</style>