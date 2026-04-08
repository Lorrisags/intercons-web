<?php
/*
 * Path File: /views/admin/admin_home.php
 * Deskripsi: Halaman Admin untuk mengelola konten dinamis di halaman Home (Beranda).
 */

// Memanggil koneksi database
require_once __DIR__ . '/../../config/database.php';
$db = (new Database())->getConnection();

// Mengambil seluruh data dari tabel settings
$query = "SELECT setting_key, setting_value FROM settings";
$stmt = $db->prepare($query);
$stmt->execute();

$settings = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $settings[$row['setting_key']] = $row['setting_value'];
}

// Menyiapkan variabel default jika data di database masih kosong
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
<!-- Header Halaman -->
<div class="d-flex align-items-center mb-4 pb-2 border-bottom">
    <div class="bg-primary text-white rounded p-2 me-3 shadow-sm">
        <i class="fas fa-home fa-fw fa-lg"></i>
    </div>
    <div>
        <h3 class="mb-0 fw-bold" style="color: #2c3e50;">Pengaturan Home Page</h3>
        <p class="text-muted mb-0 small">Ubah teks, gambar banner, dan data statistik pada halaman utama pengunjung.</p>
    </div>
</div>

<form action="process_update_home.php" method="POST" enctype="multipart/form-data">
    <div class="row g-4 mb-5">
        
        <!-- Bagian 1: Hero Section (Banner Utama) -->
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white py-3 border-bottom-0">
                    <h6 class="fw-bold mb-0 text-primary"><i class="fas fa-image me-2"></i>1. Bagian Banner Utama (Hero Section)</h6>
                </div>
                <div class="card-body p-4 bg-light rounded-bottom-3">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small">Judul Utama (Headline)</label>
                            <input type="text" class="form-control" name="hero_title" value="<?php echo htmlspecialchars($hero_title); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small">Teks Label Kecil (Badge)</label>
                            <input type="text" class="form-control" name="hero_badge" value="<?php echo htmlspecialchars($hero_badge); ?>" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold text-muted small">Deskripsi Singkat (Sub-headline)</label>
                            <textarea class="form-control" name="hero_desc" rows="3" required><?php echo htmlspecialchars($hero_desc); ?></textarea>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label fw-bold text-muted small">Gambar Latar Belakang (Background URL / Upload Baru)</label>
                            <input type="file" class="form-control" name="hero_image">
                            <small class="text-muted mt-1 d-block">Biarkan kosong jika tidak ingin mengubah gambar saat ini.</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bagian 2: Angka Statistik (Overview) -->
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white py-3 border-bottom-0">
                    <h6 class="fw-bold mb-0 text-primary"><i class="fas fa-chart-line me-2"></i>2. Angka Statistik Perusahaan (Overview)</h6>
                </div>
                <div class="card-body p-4 bg-light rounded-bottom-3">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-muted small">Produk & Material</label>
                            <input type="text" class="form-control form-control-lg fw-bold" name="stat_products" value="<?php echo htmlspecialchars($stat_products); ?>" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-muted small">Proyek Selesai</label>
                            <input type="text" class="form-control form-control-lg fw-bold" name="stat_projects" value="<?php echo htmlspecialchars($stat_projects); ?>" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-muted small">Klien Industri</label>
                            <input type="text" class="form-control form-control-lg fw-bold" name="stat_clients" value="<?php echo htmlspecialchars($stat_clients); ?>" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-muted small">Penghargaan</label>
                            <input type="text" class="form-control form-control-lg fw-bold" name="stat_awards" value="<?php echo htmlspecialchars($stat_awards); ?>" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bagian 3: Call to Action (Form Booking) -->
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white py-3 border-bottom-0">
                    <h6 class="fw-bold mb-0 text-primary"><i class="fas fa-bullhorn me-2"></i>3. Teks Ajakan (Form Booking Kiri)</h6>
                </div>
                <div class="card-body p-4 bg-light rounded-bottom-3">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-muted small">Judul Call to Action</label>
                            <input type="text" class="form-control" name="cta_title" value="<?php echo htmlspecialchars($cta_title); ?>" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold text-muted small">Deskripsi Call to Action</label>
                            <textarea class="form-control" name="cta_desc" rows="3" required><?php echo htmlspecialchars($cta_desc); ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tombol Simpan -->
        <div class="col-12 text-end mt-2">
            <button type="reset" class="btn btn-light fw-bold me-2 shadow-sm border">Batal</button>
            <button type="submit" class="btn btn-primary fw-bold px-4 shadow-sm">
                <i class="fas fa-save me-2"></i> Simpan Perubahan
            </button>
        </div>

    </div>
</form>