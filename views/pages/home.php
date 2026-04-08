<?php
/*
 * Path File: /views/pages/home.php
 * Deskripsi: Konten utama halaman depan (Landing Page). Data sekarang dipanggil dinamis dari database.
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

// Menyiapkan variabel dengan fallback nilai default jika kosong
$hero_title = isset($settings['hero_title']) ? $settings['hero_title'] : 'Your Solution Provider';
$hero_badge = isset($settings['hero_badge']) ? $settings['hero_badge'] : 'Perdagangan & Jasa Industri';
$hero_desc = isset($settings['hero_desc']) ? $settings['hero_desc'] : 'PT Intercons hadir sebagai mitra strategis Anda dalam penyediaan material, peralatan, dan solusi layanan industri terpadu dengan standar kualitas terbaik.';

$stat_products = isset($settings['total_products']) ? $settings['total_products'] : '150+';
$stat_projects = isset($settings['total_projects']) ? $settings['total_projects'] : '450+';
$stat_clients = isset($settings['total_clients']) ? $settings['total_clients'] : '200+';
$stat_awards = isset($settings['awards']) ? $settings['awards'] : '25+';

$cta_title = isset($settings['cta_title']) ? $settings['cta_title'] : 'Mari Diskusikan Kebutuhan Anda';
$cta_desc = isset($settings['cta_desc']) ? $settings['cta_desc'] : 'Tim ahli PT Intercons siap memberikan dukungan penuh untuk pengadaan material dan eksekusi proyek industri Anda dengan standar keselamatan dan kualitas terbaik.';
?>
<!-- Hero Section -->
<section id="home" style="padding-top: 130px; padding-bottom: 120px; background: linear-gradient(135deg, #001f3f 0%, #003B73 100%); color: white;">
    <div class="container">
        <div class="row align-items-center">
            <!-- Kolom Teks Kiri -->
            <div class="col-lg-6 mb-5 mb-lg-0 text-center text-lg-start">
                <span class="badge mb-3 px-3 py-2 rounded-pill shadow-sm" style="background-color: rgba(0, 191, 255, 0.2); color: #00BFFF; border: 1px solid #00BFFF;">
                    <i class="fas fa-industry me-1"></i> <?php echo htmlspecialchars($hero_badge); ?>
                </span>
                <h1 class="display-4 fw-bold mb-4" style="text-transform: uppercase; letter-spacing: 1px; line-height: 1.2;">
                    <?php echo nl2br(htmlspecialchars($hero_title)); ?>
                </h1>
                <p class="lead mb-5" style="color: #E1F5FE; font-size: 1.15rem; font-weight: 300;">
                    <?php echo nl2br(htmlspecialchars($hero_desc)); ?>
                </p>
                <div class="d-flex flex-column flex-sm-row justify-content-center justify-content-lg-start gap-3">
                    <a href="#booking" class="btn btn-lg fw-bold shadow-sm px-4" style="background-color: #00BFFF; color: #001f3f; border-radius: 8px;">
                        Mulai Proyek <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                    <a href="?page=service" class="btn btn-lg fw-bold btn-outline-light px-4" style="border-radius: 8px;">
                        Jelajahi Layanan
                    </a>
                </div>
            </div>
            
            <!-- Kolom Gambar Kanan -->
            <div class="col-lg-6">
                <div class="position-relative">
                    <div class="position-absolute w-100 h-100 rounded-4" style="background-color: #00BFFF; top: -15px; left: 15px; z-index: 0; opacity: 0.8;"></div>
                    <img src="https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Fasilitas Industri PT Intercons" class="img-fluid rounded-4 shadow-lg position-relative" style="z-index: 1; border: 4px solid #ffffff;">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Overview Perusahaan (Stats) -->
<section id="stats" style="margin-top: -50px; position: relative; z-index: 10;">
    <div class="container">
        <div class="bg-white rounded-4 shadow-lg p-2 p-md-4 border-bottom border-4" style="border-color: #00BFFF !important;">
            <div class="row g-0 text-center">
                <div class="col-6 col-md-3 border-end p-3">
                    <h2 class="fw-bold mb-1" style="color: #003B73;"><?php echo htmlspecialchars($stat_products); ?></h2>
                    <p class="text-muted small fw-bold text-uppercase mb-0">Produk & Material</p>
                </div>
                <div class="col-6 col-md-3 border-end-md p-3">
                    <h2 class="fw-bold mb-1" style="color: #003B73;"><?php echo htmlspecialchars($stat_projects); ?></h2>
                    <p class="text-muted small fw-bold text-uppercase mb-0">Proyek Selesai</p>
                </div>
                <div class="col-6 col-md-3 border-end p-3">
                    <h2 class="fw-bold mb-1" style="color: #003B73;"><?php echo htmlspecialchars($stat_clients); ?></h2>
                    <p class="text-muted small fw-bold text-uppercase mb-0">Klien Industri</p>
                </div>
                <div class="col-6 col-md-3 p-3">
                    <h2 class="fw-bold mb-1" style="color: #003B73;"><?php echo htmlspecialchars($stat_awards); ?></h2>
                    <p class="text-muted small fw-bold text-uppercase mb-0">Penghargaan</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Booking Form -->
<section id="booking" class="py-5 mt-4">
    <div class="container py-4">
        <div class="row align-items-stretch bg-white rounded-4 shadow-sm overflow-hidden border" style="border-color: #e0e0e0;">
            <div class="col-lg-5 p-5 text-white" style="background: #005B96;">
                <h2 class="fw-bold mb-4"><?php echo htmlspecialchars($cta_title); ?></h2>
                <p class="mb-4" style="color: #E1F5FE; line-height: 1.8;">
                    <?php echo nl2br(htmlspecialchars($cta_desc)); ?>
                </p>
                <ul class="list-unstyled mb-0 mt-4">
                    <li class="mb-3"><i class="fas fa-check-circle me-3 fa-lg" style="color: #00BFFF;"></i> Konsultasi Teknis Gratis</li>
                    <li class="mb-3"><i class="fas fa-check-circle me-3 fa-lg" style="color: #00BFFF;"></i> Pengadaan Material Cepat</li>
                    <li><i class="fas fa-check-circle me-3 fa-lg" style="color: #00BFFF;"></i> Teknisi & Ahli Bersertifikat</li>
                </ul>
            </div>
            
            <div class="col-lg-7 p-5 bg-light">
                <h3 class="fw-bold mb-4" style="color: #003B73;">Formulir Permintaan</h3>
                <form action="process_contact.php" method="POST">
                    
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">Nama Perusahaan / Instansi</label>
                        <input type="text" name="company_name" class="form-control form-control-lg border-0 shadow-sm" style="font-size: 0.95rem;" placeholder="Masukkan nama perusahaan" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">Kebutuhan Layanan / Produk</label>
                        <select name="service_needed" class="form-select form-select-lg border-0 shadow-sm" style="font-size: 0.95rem;" required>
                            <option value="" selected disabled>-- Pilih Jenis Kebutuhan --</option>
                            <option value="Pengadaan Material & Produk Industri">Pengadaan Material & Produk Industri</option>
                            <option value="Jasa Konstruksi & Sipil">Jasa Konstruksi & Sipil</option>
                            <option value="Layanan Mekanikal & Elektrikal">Layanan Mekanikal & Elektrikal</option>
                            <option value="Konsultasi">Konsultasi Proyek Industri</option>
                        </select>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label text-muted small fw-bold">Jelaskan Detail Kebutuhan Anda</label>
                        <textarea name="details" class="form-control border-0 shadow-sm" rows="4" placeholder="Jelaskan kebutuhan Anda di sini..." required></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-lg w-100 mt-2 shadow fw-bold text-white" style="background-color: #003B73; border-radius: 8px;">
                        Kirim Permintaan Sekarang <i class="fas fa-paper-plane ms-2"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>