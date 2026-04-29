<?php
/*
 * Path File: /views/pages/home.php
 * Deskripsi: Halaman Beranda Publik dengan slider animasi otomatis ke samping (Marquee CSS) dan Hero Slider.
 */

global $db_conn;
$captcha_active = '0';
$site_key = '';

if ($db_conn) {
    $stmt_c = $db_conn->query("SELECT setting_key, setting_value FROM settings WHERE setting_key IN ('captcha_active', 'captcha_site_key')");
    while ($row = $stmt_c->fetch(PDO::FETCH_ASSOC)) {
        if($row['setting_key'] == 'captcha_active') $captcha_active = $row['setting_value'];
        if($row['setting_key'] == 'captcha_site_key') $site_key = $row['setting_value'];
    }
}

require_once __DIR__ . '/../../config/database.php';
$db = (new Database())->getConnection();

// 1. Mengambil data pengaturan untuk teks banner dll
$stmt = $db->prepare("SELECT setting_key, setting_value FROM settings");
$stmt->execute();
$settings = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $settings[$row['setting_key']] = $row['setting_value'];
}

// 2. Mengambil data Tampilan Bergeser (Slider) dari settings database
$stmt_slide = $db->prepare("SELECT setting_value FROM settings WHERE setting_key = 'slider_data'");
$stmt_slide->execute();
$slider_json = $stmt_slide->fetchColumn();
$slider_products = $slider_json ? json_decode($slider_json, true) : [];

// Jika admin belum menambahkan di menu Tampilan Bergeser, gunakan data contoh
if (empty($slider_products)) {
    $slider_products = [
        ['img' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?ixlib=rb-4.0.3&w=500&q=80', 'name' => 'Industrial Gate Valve', 'category' => 'Mechanical'],
        ['img' => 'https://images.unsplash.com/photo-1504917595217-d4dc5ebe6122?ixlib=rb-4.0.3&w=500&q=80', 'name' => 'Heavy Duty Steel Pipe', 'category' => 'Material'],
        ['img' => 'https://images.unsplash.com/photo-1513828583688-c52646db42da?ixlib=rb-4.0.3&w=500&q=80', 'name' => 'Diesel Gen-Set 500kVA', 'category' => 'Electrical'],
        ['img' => 'https://images.unsplash.com/photo-1581092335397-9583eb92d232?ixlib=rb-4.0.3&w=500&q=80', 'name' => 'Control Panel 3 Phase', 'category' => 'Electrical']
    ];
}

$count_products = count($slider_products);
// Lebar 1 kartu (280px) + margin kiri kanan (15px + 15px = 30px) = 310px total per kartu
$total_scroll_distance = $count_products * 310;

// Menggabungkan array agar animasi tidak terputus (Seamless Infinite Loop)
$slider_items = array_merge($slider_products, $slider_products, $slider_products, $slider_products);
?>

<style>
    /* Animasi Marquee / Slider Berjalan Otomatis ke Samping */
    @keyframes scrollMarquee {
        0% { transform: translateX(0); }
        100% { transform: translateX(-<?php echo $total_scroll_distance; ?>px); } 
    }
    
    .product-slider-container {
        overflow: hidden;
        white-space: nowrap;
        position: relative;
        width: 100%;
        padding: 30px 0 40px 0;
        background: linear-gradient(to bottom, #ffffff, #f8fafc);
    }
    
    .product-slide-track {
        display: inline-flex;
        animation: scrollMarquee 20s linear infinite;
    }
    
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
        white-space: normal;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
        flex: 0 0 auto;
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
        margin-bottom: 5px;
    }
</style>

<?php
// Mengambil status visibilitas
$show_hero = isset($settings['show_hero']) ? $settings['show_hero'] : '1';
$show_stats = isset($settings['show_stats']) ? $settings['show_stats'] : '1';
$show_products = isset($settings['show_products']) ? $settings['show_products'] : '1';
$show_cta = isset($settings['show_cta']) ? $settings['show_cta'] : '1';
?>

<?php if($show_hero == '1'): ?>
<div style="background-color: #003B73; padding-top: 130px; padding-bottom: 120px; border-bottom-right-radius: 50px;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <span class="badge rounded-pill mb-3 py-2 px-3" style="background-color: rgba(3, 169, 244, 0.2); color: #03A9F4; border: 1px solid #03A9F4;">
                    <i class="fas fa-industry me-1"></i> <?php echo isset($settings['hero_badge']) ? htmlspecialchars($settings['hero_badge']) : ''; ?>
                </span>
                <h1 class="display-4 fw-bold text-white mb-3"><?php echo isset($settings['hero_title']) ? htmlspecialchars($settings['hero_title']) : 'Your Solution Provider'; ?></h1>
                <p class="lead text-light mb-4" style="font-size: 1.1rem; opacity: 0.9;">
                    <?php echo isset($settings['hero_desc']) ? htmlspecialchars($settings['hero_desc']) : ''; ?>
                </p>
                <div class="d-flex gap-3">
                    <a href="#contact" class="btn fw-bold px-4 py-2 text-white shadow" style="background-color: #03A9F4; border-radius: 8px;">Mulai Proyek <i class="fas fa-arrow-right ms-2"></i></a>
                    <a href="?page=service" class="btn btn-outline-light fw-bold px-4 py-2" style="border-radius: 8px;">Jelajahi Layanan</a>
                </div>
            </div>

            <div class="col-lg-6">
                <div id="heroCarousel" class="carousel slide carousel-fade rounded-4 shadow-lg border border-4 overflow-hidden" data-bs-ride="carousel" style="border-color: rgba(255,255,255,0.1) !important;">
                    <div class="carousel-inner">
                        <?php 
                        $slider_found = false;
                        $is_first = true;
                        for($i=1; $i<=3; $i++): 
                            $img_path = isset($settings['hero_img_'.$i]) ? trim($settings['hero_img_'.$i]) : '';
                            if(!empty($img_path)):
                        ?>
                            <div class="carousel-item <?php echo $is_first ? 'active' : ''; ?>" data-bs-interval="3000">
                                <img src="<?php echo htmlspecialchars($img_path); ?>" class="d-block w-100" style="height: 400px; object-fit: cover;">
                            </div>
                        <?php 
                            $is_first = false;
                            $slider_found = true;
                            endif; 
                        endfor; 

                        if(!$slider_found): ?>
                            <div class="carousel-item active">
                                <img src="https://images.unsplash.com/photo-1581092160562-40aa08e78837?w=800" class="d-block w-100" style="height: 400px; object-fit: cover;">
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if($slider_found): ?>
                    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php if($show_stats == '1'): ?>
<div class="container position-relative" style="margin-top: <?php echo ($show_hero == '1') ? '-60px' : '100px'; ?>; z-index: 10;">
    <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="row g-0 text-center">
                <div class="col-md-3 col-6 py-4 border-end"><h2 class="fw-bold mb-1" style="color: #005B96;"><?php echo isset($settings['total_products']) ? htmlspecialchars($settings['total_products']) : '150+'; ?></h2><small class="text-muted fw-bold">PRODUK & MATERIAL</small></div>
                <div class="col-md-3 col-6 py-4 border-end"><h2 class="fw-bold mb-1" style="color: #005B96;"><?php echo isset($settings['total_projects']) ? htmlspecialchars($settings['total_projects']) : '450+'; ?></h2><small class="text-muted fw-bold">PROYEK SELESAI</small></div>
                <div class="col-md-3 col-6 py-4 border-end"><h2 class="fw-bold mb-1" style="color: #005B96;"><?php echo isset($settings['total_clients']) ? htmlspecialchars($settings['total_clients']) : '200+'; ?></h2><small class="text-muted fw-bold">KLIEN INDUSTRI</small></div>
                <div class="col-md-3 col-6 py-4"><h2 class="fw-bold mb-1" style="color: #005B96;"><?php echo isset($settings['awards']) ? htmlspecialchars($settings['awards']) : '25+'; ?></h2><small class="text-muted fw-bold">PENGHARGAAN</small></div>
            </div>
            <div style="height: 5px; background: linear-gradient(90deg, #03A9F4, #003B73);"></div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php if($show_products == '1'): ?>
<section class="<?php echo ($show_hero == '0' && $show_stats == '0') ? 'pt-5 mt-5' : 'pt-5 mt-4'; ?>">
    <div class="container text-center mb-4">
        <h3 class="fw-bold" style="color: #003B73;">Produk & Material Unggulan</h3>
        <p class="text-muted mb-0">Rangkaian produk berkualitas tinggi yang dihasilkan dan disuplai oleh PT Intercons</p>
    </div>
    
    <div class="product-slider-container shadow-sm border-top border-bottom">
        <div class="product-slide-track">
            <?php foreach($slider_items as $item): ?>
            <div class="product-card" onclick="window.location.href='?page=products'">
                <img src="<?php echo htmlspecialchars($item['img']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                <div class="product-card-body">
                    <span class="badge mb-2" style="background-color: #E1F5FE; color: #003B73;"><?php echo htmlspecialchars($item['category']); ?></span>
                    <h6><?php echo htmlspecialchars($item['name']); ?></h6>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="text-center mt-3"><small class="text-muted"><i class="fas fa-mouse-pointer me-1"></i> Arahkan kursor ke gambar untuk menjeda animasi.</small></div>
</section>
<?php endif; ?>

<?php if($show_cta == '1'): ?>
<section id="contact" class="py-5 my-5">
    <div class="container">
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="row g-0">
                <div class="col-lg-5 text-white p-5 d-flex flex-column justify-content-center" style="background-color: #005B96;">
                    <h3 class="fw-bold mb-3"><?php echo isset($settings['cta_title']) ? htmlspecialchars($settings['cta_title']) : 'Mari Diskusikan Kebutuhan Anda'; ?></h3>
                    <p class="mb-4 opacity-75"><?php echo isset($settings['cta_desc']) ? nl2br(htmlspecialchars($settings['cta_desc'])) : ''; ?></p>
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px; color: #005B96;"><i class="fas fa-phone-alt"></i></div>
                        <div><small class="d-block opacity-75">Telepon</small><span class="fw-bold">+62 21 5555 8888</span></div>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px; color: #005B96;"><i class="fas fa-envelope"></i></div>
                        <div><small class="d-block opacity-75">Email</small><span class="fw-bold">info@intercons.co.id</span></div>
                    </div>
                </div>
                <div class="col-lg-7 p-5 bg-white">
                    <h4 class="fw-bold mb-4" style="color: #003B73;">Formulir Permintaan</h4>
                    <form action="process_contact.php" method="POST">
                        <div class="row g-3">
                            <div class="col-md-6"><label class="form-label small fw-bold text-muted">Nama Perusahaan / Instansi</label><input type="text" name="company_name" class="form-control" placeholder="Masukkan nama perusahaan" required></div>
                            <div class="col-md-6"><label class="form-label small fw-bold text-muted">Nama Kontak</label><input type="text" name="contact_name" class="form-control" placeholder="Nama lengkap Anda" required></div>
                            <div class="col-12"><label class="form-label small fw-bold text-muted">Email Perusahaan</label><input type="email" name="email" class="form-control" placeholder="email@perusahaan.com" required></div>
                            <div class="col-12"><label class="form-label small fw-bold text-muted">Detail Kebutuhan</label><textarea name="details" class="form-control" rows="4" placeholder="Jelaskan spesifikasi material atau layanan yang Anda butuhkan..." required></textarea></div>
                            <div class="col-12 mt-4"><button type="submit" class="btn text-white fw-bold px-4 py-2" style="background-color: #03A9F4; border-radius: 8px;">Kirim Permintaan <i class="fas fa-paper-plane ms-2"></i></button></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>