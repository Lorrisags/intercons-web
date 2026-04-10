<?php
require_once __DIR__ . '/../../config/database.php';
$db = (new Database())->getConnection();

// Mengambil ID layanan dari URL (?page=service_detail&id=1)
$id = isset($_GET['id']) ? $_GET['id'] : 0;
$stmt = $db->prepare("SELECT * FROM services WHERE id = ?");
$stmt->execute([$id]);
$s = $stmt->fetch();

// Jika data tidak ditemukan, kembali ke halaman service
if(!$s) {
    echo "<script>window.location.href='?page=service';</script>";
    exit;
}
?>
<div class="container-fluid" style="background-color: #003B73; padding: 120px 0 40px 0; background-image: url('https://www.transparenttextures.com/patterns/cubes.png');">
    <div class="container text-center">
        <h1 class="fw-bold text-white mb-2"><?php echo htmlspecialchars($s['title']); ?></h1>
    </div>
</div>

<div class="container py-5 my-3">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <img src="<?php echo htmlspecialchars($s['image_url']); ?>" alt="<?php echo htmlspecialchars($s['title']); ?>" style="width: 100%; height: 400px; object-fit: cover;">
                
                <div class="card-body p-4 p-md-5">
                    <span class="badge bg-warning text-dark mb-3 px-3 py-2"><i class="fas fa-tags me-1"></i> Layanan Kami</span>
                    <h2 class="fw-bold mb-4" style="color: #003B73;"><?php echo htmlspecialchars($s['title']); ?></h2>
                    
                    <div style="line-height: 1.8; text-align: justify; color: #444; font-size: 1.05rem;">
                        <?php echo nl2br(htmlspecialchars($s['full_description'])); ?>
                    </div>
                    
                    <hr class="my-5">
                    
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="?page=service" class="btn btn-outline-primary fw-bold px-4 rounded-3">
                            <i class="fas fa-arrow-left me-2"></i> Kembali ke Layanan
                        </a>
                        <a href="?page=contact" class="btn btn-warning fw-bold px-4 rounded-3 text-dark">
                            Pesan Layanan <i class="fas fa-paper-plane ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>