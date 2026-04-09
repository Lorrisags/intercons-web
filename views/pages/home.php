<?php
/*
 * Path File: /views/pages/home.php
 * Deskripsi: Halaman Beranda (Home) Publik dengan animasi slider produk ke samping.
 */

require_once __DIR__ . '/../../config/database.php';
$db = (new Database())->getConnection();

// Mengambil data pengaturan (jika ada) untuk teks dinamis
$stmt = $db->prepare("SELECT setting_key, setting_value FROM settings");
$stmt->execute();
$settings = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $settings[$row['setting_key']] = $row['setting_value'];
}

// --- Data Produk untuk Slider Animasi ---
// (Saat ini menggunakan data placeholder, nanti bisa disambungkan ke database tabel produk)
$products = [
    ['img' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80', 'name' => 'Industrial Gate Valve'],
    ['img' => 'https://images.unsplash.com/photo-1504917595217-d4dc5ebe6122?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80', 'name' => 'Heavy Duty Steel Pipe'],
    ['img' => 'https://images.unsplash.com/photo-1513828583688-c52646db42da?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80', 'name' => 'Diesel Gen-Set 500kVA'],
    ['img' => 'https://images.unsplash.com/photo-1581092335397-9583eb92d232?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80', 'name' => 'Control Panel 3 Phase'],
    ['img' => 'https://images.unsplash.com/photo-1530124566582-a618bc2615dc?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80', 'name' => 'Baja Konstruksi H-Beam'],
    ['img' => 'https://images.unsplash.com/photo-1621905251189-08b45d6a269e?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80', 'name' => 'Sistem Perpipaan Migas']
];
// Menggabungkan array 2x agar scroll tidak terputus (Seamless Infinite Scroll)
$slider_items = array_merge($products, $products);
?>

<style>
    /* Animasi Marquee / Slider Berjalan ke Samping */
    @keyframes scrollMarquee {
        0% { transform: translateX(0); }
        /* Menggeser persis 50% dari total lebar karena itemnya diduplikasi */
        100% { transform: translateX(calc(-280px * 6 - 30px * 6)); } 
    }
    
    .product-slider-container {
        overflow: hidden;
        white-space: nowrap;
        position: relative;
        width: 100%;
        padding: 30px 0;
        background: linear-gradient(to bottom, #ffffff, #f8fafc);
    }
    
    .product-slide-track {
        display: inline-flex;
        /* Kecepatan animasi, 30 detik untuk 1 putaran penuh */
        animation: scrollMarquee 30s linear infinite;
    }
    
    /* Pause animasi saat pengunjung menaruh kursor mouse di atasnya */
    .product-slide-track:hover {
        animation-play-state: paused;
    }
    
    .product-card {
        width: 280px;
        margin: 0 15px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.06);
        overflow: hidden;
        white-space: normal; /* Mengembalikan teks agar bisa turun ke bawah */
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
    }
    
    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 10px 25px rgba(0, 59, 115, 0.15);
    }
    
    .product-card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-bottom: 3px solid #03A9F4;
    }
    
    .product-card-body {
        padding: 15px;
        text-align: center;
    }
    
    .product-card-body h6 {
        color: #003B73;
        font-weight: 700;
        margin-bottom: 0;
    }
</style>

<!-- 1. HERO SECTION -->
<div style="background-color: #003B73; padding-top: 130px; padding-bottom: 120px; border-bottom-right-radius: 50px;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <span class="badge rounded-pill mb-3 py-2 px-3" style="background-color: rgba(3, 169, 244, 0.2); color: #03A9F4; border: 1px solid #03A9F4;">
                    <i class="fas fa-industry me-1"></i> Perdagangan & Jasa Industri
                </span>
                <h1 class="display-4 fw-bold text-white mb-3"><?php echo isset($settings['home_title']) ? htmlspecialchars($settings['home_title']) : 'NYUOBAA'; ?></h1>
                <p class="lead text-light mb-4" style="font-size: 1.1rem; opacity: 0.9;">
                    <?php echo isset($settings['home_desc']) ? htmlspecialchars($settings['home_desc']) : 'PT Intercons hadir sebagai mitra strategis Anda dalam penyediaan material, peralatan, dan solusi layanan industri terpadu dengan standar kualitas terbaik.'; ?>
                </p>
                <div class="d-flex gap-3">
                    <a href="#contact" class="btn fw-bold px-4 py-2 text-white shadow" style="background-color: #03A9F4; border-radius: 8px;">
                        Mulai Proyek <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                    <a href="?page=service" class="btn btn-outline-light fw-bold px-4 py-2" style="border-radius: 8px;">
                        Jelajahi Layanan
                    </a>
                </div>
            </div>
            <div class="col-lg-6">
                <img src="https://images.unsplash.com/photo-1581092160562-40aa08e78837?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Industri" class="img-fluid rounded-4 shadow-lg border border-4" style="border-color: rgba(255,255,255,0.1) !important;">
            </div>
        </div>
    </div>
</div>

<!-- 2. STATISTIK KOTAK OVERLAY -->
<div class="container position-relative" style="margin-top: -60px; z-index: 10;">
    <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="row g-0 text-center">
                <div class="col-md-3 col-6 py-4 border-end">
                    <h2 class="fw-bold mb-1" style="color: #005B96;"><?php echo isset($settings['stat1_val']) ? htmlspecialchars($settings['stat1_val']) : '27 jan'; ?></h2>
                    <small class="text-muted fw-bold" style="letter-spacing: 1px; font-size: 0.75rem;">PRODUK & MATERIAL</small>
                </div>
                <div class="col-md-3 col-6 py-4 border-end">
                    <h2 class="fw-bold mb-1" style="color: #005B96;"><?php echo isset($settings['stat2_val']) ? htmlspecialchars($settings['stat2_val']) : '2004'; ?></h2>
                    <small class="text-muted fw-bold" style="letter-spacing: 1px; font-size: 0.75rem;">PROYEK SELESAI</small>
                </div>
                <div class="col-md-3 col-6 py-4 border-end">
                    <h2 class="fw-bold mb-1" style="color: #005B96;"><?php echo isset($settings['stat3_val']) ? htmlspecialchars($settings['stat3_val']) : '20000'; ?></h2>
                    <small class="text-muted fw-bold" style="letter-spacing: 1px; font-size: 0.75rem;">KLIEN INDUSTRI</small>
                </div>
                <div class="col-md-3 col-6 py-4">
                    <h2 class="fw-bold mb-1" style="color: #005B96;"><?php echo isset($settings['stat4_val']) ? htmlspecialchars($settings['stat4_val']) : '15'; ?></h2>
                    <small class="text-muted fw-bold" style="letter-spacing: 1px; font-size: 0.75rem;">PENGHARGAAN</small>
                </div>
            </div>
            <!-- Garis bawah stat -->
            <div style="height: 5px; background: linear-gradient(90deg, #03A9F4, #003B73);"></div>
        </div>
    </div>
</div>

<!-- 3. FITUR BARU: ANIMASI SLIDER PRODUK BERJALAN -->
<section class="pt-5 mt-5">
    <div class="container text-center mb-4">
        <h3 class="fw-bold" style="color: #003B73;">Produk & Material Unggulan</h3>
        <p class="text-muted mb-0">Rangkaian produk berkualitas tinggi yang dihasilkan dan disuplai oleh PT Intercons</p>
    </div>
    
    <!-- Wadah Slider -->
    <div class="product-slider-container shadow-sm border-top border-bottom">
        <div class="product-slide-track">
            <!-- Looping Data Produk -->
            <?php foreach($slider_items as $item): ?>
            <div class="product-card" onclick="window.location.href='?page=products'">
                <img src="<?php echo $item['img']; ?>" alt="<?php echo $item['name']; ?>">
                <div class="product-card-body">
                    <h6><?php echo $item['name']; ?></h6>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    
    <div class="text-center mt-3">
        <small class="text-muted"><i class="fas fa-hand-pointer me-1"></i> Arahkan kursor untuk menjeda, klik untuk melihat katalog lengkap.</small>
    </div>
</section>

<!-- 4. FORMULIR PERMINTAAN & KONTAK -->
<section id="contact" class="py-5 my-5">
    <div class="container">
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="row g-0">
                <div class="col-lg-5 text-white p-5 d-flex flex-column justify-content-center" style="background-color: #005B96;">
                    <h3 class="fw-bold mb-3">Mari Diskusikan Kebutuhan Anda</h3>
                    <p class="mb-4 opacity-75">Tim ahli PT Intercons siap memberikan dukungan penuh untuk mensukseskan proyek industri Anda dari awal hingga akhir.</p>
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px; color: #005B96;">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div>
                            <small class="d-block opacity-75">Telepon</small>
                            <span class="fw-bold">+62 21 5555 8888</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px; color: #005B96;">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>
                            <small class="d-block opacity-75">Email</small>
                            <span class="fw-bold">info@intercons.co.id</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 p-5 bg-white">
                    <h4 class="fw-bold mb-4" style="color: #003B73;">Formulir Permintaan</h4>
                    <form action="#" method="POST">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">Nama Perusahaan / Instansi</label>
                                <input type="text" class="form-control" placeholder="Masukkan nama perusahaan">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">Nama Kontak</label>
                                <input type="text" class="form-control" placeholder="Nama lengkap Anda">
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold text-muted">Email Perusahaan</label>
                                <input type="email" class="form-control" placeholder="email@perusahaan.com">
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold text-muted">Detail Kebutuhan</label>
                                <textarea class="form-control" rows="4" placeholder="Jelaskan spesifikasi material atau layanan yang Anda butuhkan..."></textarea>
                            </div>
                            <div class="col-12 mt-4">
                                <button type="button" class="btn text-white fw-bold px-4 py-2" style="background-color: #03A9F4; border-radius: 8px;">Kirim Permintaan <i class="fas fa-paper-plane ms-2"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>