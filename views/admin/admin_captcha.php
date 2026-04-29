<?php
/* Path: views/admin/admin_captcha.php */
require_once __DIR__ . '/../../config/database.php';
$db = (new Database())->getConnection();

// Ambil data dari tabel settings
$stmt = $db->query("SELECT setting_key, setting_value FROM settings WHERE setting_key LIKE 'captcha_%'");
$settings = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $settings[$row['setting_key']] = $row['setting_value'];
}

// Fallback nilai default
$captcha_active = isset($settings['captcha_active']) ? $settings['captcha_active'] : '0';
$captcha_site_key = isset($settings['captcha_site_key']) ? $settings['captcha_site_key'] : '';
$captcha_secret_key = isset($settings['captcha_secret_key']) ? $settings['captcha_secret_key'] : '';
?>

<div class="d-flex justify-content-between align-items-center mb-4 bg-white p-4 rounded-4 shadow-sm border-start border-4" style="border-color: #10b981 !important;">
    <div>
        <h4 class="mb-1 fw-bold" style="color: #0f172a;">Pengaturan Keamanan Captcha</h4>
        <p class="text-muted mb-0 small">Integrasikan Google reCAPTCHA v2 untuk melindungi form kontak & subscriber dari bot spam.</p>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 mb-5">
    <div class="card-body p-4">
        
        <div class="alert alert-info border-0 rounded-3 small">
            <i class="fas fa-info-circle me-2"></i> Belum punya API Key? Anda bisa mendaftar secara gratis di <a href="https://www.google.com/recaptcha/admin/create" target="_blank" class="fw-bold text-info text-decoration-none">Google reCAPTCHA Admin Console</a>. Pilih jenis <strong>reCAPTCHA v2 ("I'm not a robot" Checkbox)</strong>.
        </div>

        <form action="process_update_captcha.php" method="POST">
            
            <div class="mb-4 p-3 bg-light rounded border d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fw-bold mb-1">Status reCAPTCHA</h6>
                    <small class="text-muted">Aktifkan untuk menampilkan verifikasi "Saya bukan robot" pada form di website.</small>
                </div>
                <div class="form-check form-switch fs-4 mb-0">
                    <input class="form-check-input" type="checkbox" name="captcha_active" value="1" <?= ($captcha_active == '1') ? 'checked' : ''; ?> style="cursor:pointer;">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label text-muted small fw-bold">Site Key</label>
                <input type="text" class="form-control font-monospace" name="captcha_site_key" value="<?= htmlspecialchars($captcha_site_key); ?>" placeholder="Masukkan Site Key dari Google...">
            </div>
            
            <div class="mb-4">
                <label class="form-label text-muted small fw-bold">Secret Key</label>
                <input type="password" class="form-control font-monospace" name="captcha_secret_key" value="<?= htmlspecialchars($captcha_secret_key); ?>" placeholder="Masukkan Secret Key dari Google...">
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-primary px-4 fw-bold rounded-pill shadow-sm">
                    <i class="fas fa-save me-2"></i> Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>
</div>