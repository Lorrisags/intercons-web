<?php
/*
 * Path File: /views/admin/admin_about.php
 * Deskripsi: Halaman Admin untuk mengelola konten dinamis di halaman About (Tentang Kami).
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

// Menyiapkan variabel dengan fallback nilai default
$about_vision = isset($settings['about_vision']) ? $settings['about_vision'] : 'Menjadi perusahaan engineering dan kontraktor terdepan di Indonesia yang memberikan solusi inovatif, efisien, dan berkelanjutan untuk sektor industri nasional maupun internasional.';
$about_mission = isset($settings['about_mission']) ? $settings['about_mission'] : "Menyediakan layanan dan produk berkualitas tinggi yang memenuhi standar keselamatan kerja (HSE).\nMengembangkan sumber daya manusia yang profesional, handal, dan kompeten.\nMembangun kemitraan strategis dengan klien berdasarkan transparansi dan kepercayaan.";
$about_address = isset($settings['about_address']) ? $settings['about_address'] : 'Jl. Industri Raya No. 123, Surabaya, Jawa Timur, Indonesia';
$about_contact = isset($settings['about_contact']) ? $settings['about_contact'] : "+62 31 5555 8888\ninfo@intercons.co.id";
?>
<!-- Header Halaman -->
<div class="d-flex align-items-center mb-4 pb-2 border-bottom">
    <div class="bg-info text-white rounded p-2 me-3 shadow-sm">
        <i class="fas fa-info-circle fa-fw fa-lg"></i>
    </div>
    <div>
        <h3 class="mb-0 fw-bold" style="color: #2c3e50;">Pengaturan About Page</h3>
        <p class="text-muted mb-0 small">Ubah Visi, Misi, Alamat, dan Kontak Perusahaan.</p>
    </div>
</div>

<form action="process_update_about.php" method="POST">
    <div class="row g-4 mb-5">
        
        <!-- Bagian 1: Visi & Misi -->
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white py-3 border-bottom-0">
                    <h6 class="fw-bold mb-0 text-info"><i class="fas fa-bullseye me-2"></i>1. Visi & Misi Perusahaan</h6>
                </div>
                <div class="card-body p-4 bg-light rounded-bottom-3">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small">Teks Visi Kami</label>
                            <textarea class="form-control" name="about_vision" rows="6" required><?php echo htmlspecialchars($about_vision); ?></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small">Teks Misi Kami (Gunakan Enter untuk baris baru/poin)</label>
                            <textarea class="form-control" name="about_mission" rows="6" required><?php echo htmlspecialchars($about_mission); ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bagian 2: Informasi Kontak & Alamat -->
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white py-3 border-bottom-0">
                    <h6 class="fw-bold mb-0 text-info"><i class="fas fa-map-marker-alt me-2"></i>2. Informasi Kantor Pusat</h6>
                </div>
                <div class="card-body p-4 bg-light rounded-bottom-3">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small">Alamat Lengkap</label>
                            <textarea class="form-control" name="about_address" rows="3" required><?php echo htmlspecialchars($about_address); ?></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small">Nomor Telepon & Email (Gunakan Enter untuk baris baru)</label>
                            <textarea class="form-control" name="about_contact" rows="3" required><?php echo htmlspecialchars($about_contact); ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tombol Simpan -->
        <div class="col-12 text-end mt-2">
            <button type="reset" class="btn btn-light fw-bold me-2 shadow-sm border">Batal</button>
            <button type="submit" class="btn btn-info text-white fw-bold px-4 shadow-sm">
                <i class="fas fa-save me-2"></i> Simpan Perubahan
            </button>
        </div>

    </div>
</form>