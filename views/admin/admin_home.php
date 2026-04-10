<?php
/* Path File: /views/admin/admin_home.php */
require_once __DIR__ . '/../../config/database.php';
$db = (new Database())->getConnection();

$stmt = $db->prepare("SELECT setting_key, setting_value FROM settings");
$stmt->execute();
$settings = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $settings[$row['setting_key']] = $row['setting_value'];
}

$hero_title = isset($settings['hero_title']) ? $settings['hero_title'] : 'Your Solution Provider';
$hero_badge = isset($settings['hero_badge']) ? $settings['hero_badge'] : 'Perdagangan & Jasa Industri';
$hero_desc = isset($settings['hero_desc']) ? $settings['hero_desc'] : 'PT Intercons hadir sebagai mitra strategis Anda...';
$stat_products = isset($settings['total_products']) ? $settings['total_products'] : '150+';
$stat_projects = isset($settings['total_projects']) ? $settings['total_projects'] : '450+';
$stat_clients = isset($settings['total_clients']) ? $settings['total_clients'] : '200+';
$stat_awards = isset($settings['awards']) ? $settings['awards'] : '25+';
$cta_title = isset($settings['cta_title']) ? $settings['cta_title'] : 'Mari Diskusikan Kebutuhan Anda';
$cta_desc = isset($settings['cta_desc']) ? $settings['cta_desc'] : 'Tim ahli PT Intercons siap memberikan dukungan penuh...';

// Variabel Visibilitas (Default 1 / Tampil)
$show_hero = isset($settings['show_hero']) ? $settings['show_hero'] : '1';
$show_stats = isset($settings['show_stats']) ? $settings['show_stats'] : '1';
$show_products = isset($settings['show_products']) ? $settings['show_products'] : '1';
$show_cta = isset($settings['show_cta']) ? $settings['show_cta'] : '1';
?>

<div class="d-flex align-items-center mb-4 pb-2 border-bottom">
    <div class="bg-primary text-white rounded p-2 me-3 shadow-sm"><i class="fas fa-home fa-fw fa-lg"></i></div>
    <div>
        <h3 class="mb-0 fw-bold" style="color: #2c3e50;">Pengaturan Home Page</h3>
        <p class="text-muted mb-0 small">Ubah teks, statistik, dan atur bagian mana yang ingin ditampilkan ke pengunjung.</p>
    </div>
</div>

<form action="process_update_home.php" method="POST" enctype="multipart/form-data">
    <div class="row g-4 mb-5">
        
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-3 border-start border-4" style="border-color: #ffc107 !important;">
                <div class="card-header bg-white py-3 border-bottom-0">
                    <h6 class="fw-bold mb-0 text-dark"><i class="fas fa-eye me-2 text-warning"></i>1. Tampilkan / Sembunyikan Bagian (Layout Control)</h6>
                </div>
                <div class="card-body p-4 bg-light rounded-bottom-3">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <div class="form-check form-switch p-3 bg-white border rounded shadow-sm d-flex justify-content-between align-items-center">
                                <label class="form-check-label fw-bold small text-muted mb-0" for="showHero">Banner Utama</label>
                                <input class="form-check-input m-0" type="checkbox" role="switch" id="showHero" name="show_hero" value="1" <?php echo ($show_hero == '1') ? 'checked' : ''; ?> style="width: 40px; height: 20px; cursor:pointer;">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check form-switch p-3 bg-white border rounded shadow-sm d-flex justify-content-between align-items-center">
                                <label class="form-check-label fw-bold small text-muted mb-0" for="showStats">Angka Statistik</label>
                                <input class="form-check-input m-0" type="checkbox" role="switch" id="showStats" name="show_stats" value="1" <?php echo ($show_stats == '1') ? 'checked' : ''; ?> style="width: 40px; height: 20px; cursor:pointer;">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check form-switch p-3 bg-white border rounded shadow-sm d-flex justify-content-between align-items-center">
                                <label class="form-check-label fw-bold small text-muted mb-0" for="showProducts">Slider Produk</label>
                                <input class="form-check-input m-0" type="checkbox" role="switch" id="showProducts" name="show_products" value="1" <?php echo ($show_products == '1') ? 'checked' : ''; ?> style="width: 40px; height: 20px; cursor:pointer;">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check form-switch p-3 bg-white border rounded shadow-sm d-flex justify-content-between align-items-center">
                                <label class="form-check-label fw-bold small text-muted mb-0" for="showCta">Formulir Kontak</label>
                                <input class="form-check-input m-0" type="checkbox" role="switch" id="showCta" name="show_cta" value="1" <?php echo ($show_cta == '1') ? 'checked' : ''; ?> style="width: 40px; height: 20px; cursor:pointer;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white py-3 border-bottom-0">
                    <h6 class="fw-bold mb-0 text-primary"><i class="fas fa-image me-2"></i>2. Bagian Banner Utama (Hero Section)</h6>
                </div>
                <div class="card-body p-4 bg-light rounded-bottom-3">
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label fw-bold text-muted small">Judul Utama (Headline)</label><input type="text" class="form-control" name="hero_title" value="<?php echo htmlspecialchars($hero_title); ?>" required></div>
                        <div class="col-md-6"><label class="form-label fw-bold text-muted small">Teks Label Kecil (Badge)</label><input type="text" class="form-control" name="hero_badge" value="<?php echo htmlspecialchars($hero_badge); ?>" required></div>
                        <div class="col-12"><label class="form-label fw-bold text-muted small">Deskripsi Singkat (Sub-headline)</label><textarea class="form-control" name="hero_desc" rows="3" required><?php echo htmlspecialchars($hero_desc); ?></textarea></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white py-3 border-bottom-0"><h6 class="fw-bold mb-0 text-primary"><i class="fas fa-chart-line me-2"></i>3. Angka Statistik Perusahaan (Overview)</h6></div>
                <div class="card-body p-4 bg-light rounded-bottom-3">
                    <div class="row g-3">
                        <div class="col-md-3"><label class="form-label fw-bold text-muted small">Produk & Material</label><input type="text" class="form-control form-control-lg fw-bold" name="stat_products" value="<?php echo htmlspecialchars($stat_products); ?>" required></div>
                        <div class="col-md-3"><label class="form-label fw-bold text-muted small">Proyek Selesai</label><input type="text" class="form-control form-control-lg fw-bold" name="stat_projects" value="<?php echo htmlspecialchars($stat_projects); ?>" required></div>
                        <div class="col-md-3"><label class="form-label fw-bold text-muted small">Klien Industri</label><input type="text" class="form-control form-control-lg fw-bold" name="stat_clients" value="<?php echo htmlspecialchars($stat_clients); ?>" required></div>
                        <div class="col-md-3"><label class="form-label fw-bold text-muted small">Penghargaan</label><input type="text" class="form-control form-control-lg fw-bold" name="stat_awards" value="<?php echo htmlspecialchars($stat_awards); ?>" required></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white py-3 border-bottom-0"><h6 class="fw-bold mb-0 text-primary"><i class="fas fa-bullhorn me-2"></i>4. Teks Ajakan (Form Booking Kiri)</h6></div>
                <div class="card-body p-4 bg-light rounded-bottom-3">
                    <div class="row g-3">
                        <div class="col-md-12"><label class="form-label fw-bold text-muted small">Judul Call to Action</label><input type="text" class="form-control" name="cta_title" value="<?php echo htmlspecialchars($cta_title); ?>" required></div>
                        <div class="col-12"><label class="form-label fw-bold text-muted small">Deskripsi Call to Action</label><textarea class="form-control" name="cta_desc" rows="3" required><?php echo htmlspecialchars($cta_desc); ?></textarea></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 text-end mt-2">
            <button type="submit" class="btn btn-primary fw-bold px-4 shadow-sm"><i class="fas fa-save me-2"></i> Simpan Perubahan</button>
        </div>
    </div>
</form>