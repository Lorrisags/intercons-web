<?php
/* Path: views/admin/admin_footer.php */
require_once __DIR__ . '/../../config/database.php';
$db = (new Database())->getConnection();

// Ambil data dari tabel settings
$stmt = $db->query("SELECT setting_key, setting_value FROM settings");
$settings = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $settings[$row['setting_key']] = $row['setting_value'];
}

// Fallback nilai default jika belum ada di database
$footer_desc = isset($settings['footer_desc']) ? $settings['footer_desc'] : 'Mitra strategis Anda dalam rekayasa mekanikal, elektrikal, dan konstruksi sipil. Kami membangun masa depan industri yang lebih baik.';
$contact_address = isset($settings['contact_address']) ? $settings['contact_address'] : 'Jl. Industri Raya No. 123, Jakarta';
$contact_phone = isset($settings['contact_phone']) ? $settings['contact_phone'] : '+62 21 5555 8888';
$contact_email = isset($settings['contact_email']) ? $settings['contact_email'] : 'info@intercons.co.id';
?>

<div class="d-flex justify-content-between align-items-center mb-4 bg-white p-4 rounded-4 shadow-sm border-start border-4" style="border-color: #003B73 !important;">
    <div>
        <h4 class="mb-1 fw-bold" style="color: #003B73;">Pengaturan Footer</h4>
        <p class="text-muted mb-0 small">Kelola informasi perusahaan dan kontak yang tampil di bagian bawah website.</p>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 mb-5">
    <div class="card-body p-4">
        <form action="process_update_footer.php" method="POST">
            
            <h6 class="fw-bold mb-3">Kolom Kiri (Tentang Perusahaan)</h6>
            <div class="mb-4">
                <label class="form-label text-muted small fw-bold">Deskripsi Singkat</label>
                <textarea class="form-control" name="footer_desc" rows="3" required><?= htmlspecialchars($footer_desc); ?></textarea>
            </div>

            <hr class="mb-4">
            <h6 class="fw-bold mb-3">Kolom Kanan (Kontak Kami)</h6>
            
            <div class="mb-3">
                <label class="form-label text-muted small fw-bold">Alamat Kantor</label>
                <input type="text" class="form-control" name="contact_address" value="<?= htmlspecialchars($contact_address); ?>" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label text-muted small fw-bold">Nomor Telepon</label>
                <input type="text" class="form-control" name="contact_phone" value="<?= htmlspecialchars($contact_phone); ?>" required>
            </div>
            
            <div class="mb-4">
                <label class="form-label text-muted small fw-bold">Email Perusahaan</label>
                <input type="email" class="form-control" name="contact_email" value="<?= htmlspecialchars($contact_email); ?>" required>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-primary px-4 fw-bold rounded-pill">
                    <i class="fas fa-save me-2"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>