<?php
/*
 * Path File: /views/pages/about_section.php
 * Deskripsi: Konten halaman About Us yang kini memanggil data dinamis dari database.
 */

// Memanggil koneksi database
require_once __DIR__ . '/../../config/database.php';
$db = (new Database())->getConnection();

// Mengambil data dari tabel settings
$query = "SELECT setting_key, setting_value FROM settings";
$stmt = $db->prepare($query);
$stmt->execute();

$settings = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $settings[$row['setting_key']] = $row['setting_value'];
}

$about_vision = isset($settings['about_vision']) ? $settings['about_vision'] : 'Menjadi perusahaan engineering dan kontraktor terdepan di Indonesia yang memberikan solusi inovatif, efisien, dan berkelanjutan untuk sektor industri nasional maupun internasional.';
$about_mission = isset($settings['about_mission']) ? $settings['about_mission'] : "Menyediakan layanan dan produk berkualitas tinggi yang memenuhi standar keselamatan kerja (HSE).\nMengembangkan sumber daya manusia yang profesional, handal, dan kompeten.\nMembangun kemitraan strategis dengan klien berdasarkan transparansi dan kepercayaan.";
$about_address = isset($settings['about_address']) ? $settings['about_address'] : 'Jl. Industri Raya No. 123, Surabaya, Jawa Timur, Indonesia';
$about_contact = isset($settings['about_contact']) ? $settings['about_contact'] : "+62 31 5555 8888\ninfo@intercons.co.id";
// Mengambil data Layanan (Service) untuk ditampilkan sebagai Badge
$stmt_srv = $db->prepare("SELECT title FROM services ORDER BY id DESC LIMIT 6");
$stmt_srv->execute();
$about_services = $stmt_srv->fetchAll(PDO::FETCH_ASSOC);

// Mengubah baris baru pada misi menjadi elemen <li> untuk list HTML
$mission_array = explode("\n", trim($about_mission));
$mission_html = "";
foreach($mission_array as $mission) {
    if(!empty(trim($mission))) {
        $mission_html .= "<li>" . htmlspecialchars(trim($mission)) . "</li>";
    }
}
?>
<!-- About Section -->
<section id="about" class="py-5 bg-light">
    <div class="container py-4">
        <!-- Judul Section -->
        <div class="text-center mb-5">
            <h2 class="fw-bold" style="color: #003B73;">Tentang Intercons</h2>
            <div style="height: 4px; width: 60px; background-color: #03A9F4; margin: 0 auto; border-radius: 2px;"></div>
        </div>

        <!-- Visi & Misi (Cards) -->
        <div class="row g-4 mb-5">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100 border-start border-4" style="border-color: #03A9F4 !important;">
                    <div class="card-body p-4">
                        <h4 class="fw-bold mb-3" style="color: #003B73;">
                            <i class="fas fa-eye me-2" style="color: #03A9F4;"></i> Visi Kami
                        </h4>
                        <p class="text-muted" style="line-height: 1.8;">
                            <?php echo nl2br(htmlspecialchars($about_vision)); ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100 border-start border-4" style="border-color: #005B96 !important;">
                    <div class="card-body p-4">
                        <h4 class="fw-bold mb-3" style="color: #003B73;">
                            <i class="fas fa-bullseye me-2" style="color: #005B96;"></i> Misi Kami
                        </h4>
                        <ul class="text-muted" style="line-height: 1.8; padding-left: 1.2rem;">
                            <?php echo $mission_html; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informasi Alamat & Produk -->
        <div class="row g-4 mb-5 bg-white p-4 shadow-sm rounded">
            <!-- Kolom Alamat -->
            <div class="col-lg-6 border-end-lg">
                 <h5 class="fw-bold mb-4" style="color: #003B73;">Informasi Kantor Pusat</h5>
                 <div class="d-flex mb-3">
                     <div class="me-3 mt-1"><i class="fas fa-map-marker-alt fa-2x" style="color: #03A9F4;"></i></div>
                     <div>
                         <h6 class="fw-bold mb-1" style="color: #005B96;">Alamat</h6>
                         <p class="text-muted mb-0"><?php echo nl2br(htmlspecialchars($about_address)); ?></p>
                     </div>
                 </div>
                 <div class="d-flex">
                     <div class="me-3 mt-1"><i class="fas fa-phone-alt fa-2x" style="color: #03A9F4;"></i></div>
                     <div>
                         <h6 class="fw-bold mb-1" style="color: #005B96;">Kontak & Email</h6>
                         <p class="text-muted mb-0"><?php echo nl2br(htmlspecialchars($about_contact)); ?></p>
                     </div>
                 </div>
            </div>
            
            <!-- Kolom Produk & Layanan -->
            <div class="col-lg-6 ps-lg-4 mt-4 mt-lg-0">
                 <h5 class="fw-bold mb-4" style="color: #003B73;">Produk & Layanan Kami</h5>
                 <p class="text-muted mb-3">Intercons melayani berbagai kebutuhan industri, meliputi:</p>
                 <div class="d-flex flex-wrap gap-2">
    <?php if(empty($about_services)): ?>
        <span class="badge border p-2" style="color: #003B73; background-color: #E1F5FE;"><i class="fas fa-info-circle me-1"></i> Belum ada layanan</span>
    <?php else: ?>
        <?php foreach($about_services as $srv): ?>
            <span class="badge border p-2" style="color: #003B73; background-color: #E1F5FE;"><i class="fas fa-check-circle me-1"></i> <?php echo htmlspecialchars($srv['title']); ?></span>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
                 <a href="#products" class="btn btn-sm mt-3 fw-bold shadow-sm" style="background-color: #005B96; color: white;">
                     Lihat Katalog Produk <i class="fas fa-arrow-right ms-1"></i>
                 </a>
            </div>
        </div>

        <!-- Newsletter Section -->
        <div class="card border-0 shadow text-white p-4 p-md-5" style="background: linear-gradient(135deg, #003B73, #005B96); border-radius: 15px;">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0 text-center text-lg-start">
                    <h3 class="fw-bold mb-2">Berlangganan Newsletter</h3>
                    <p class="mb-0" style="color: #E1F5FE;">Dapatkan informasi terbaru mengenai produk, penawaran layanan, dan wawasan industri langsung ke inbox Anda.</p>
                </div>
                <div class="col-lg-6">
                    <form action="process_newsletter.php" method="POST" class="d-flex shadow-sm" style="border-radius: 8px; overflow: hidden;">
                        <input type="email" name="email" class="form-control form-control-lg border-0 rounded-0" placeholder="Masukkan alamat email Anda..." required>
                        <button type="submit" class="btn btn-lg fw-bold px-3 px-md-4 rounded-0 text-white" style="background-color: #03A9F4; border: none; white-space: nowrap;">
                            Subscribe <i class="fas fa-paper-plane ms-1"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>