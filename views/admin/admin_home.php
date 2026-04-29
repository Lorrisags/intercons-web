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

$show_hero = isset($settings['show_hero']) ? $settings['show_hero'] : '1';
$show_stats = isset($settings['show_stats']) ? $settings['show_stats'] : '1';
$show_products = isset($settings['show_products']) ? $settings['show_products'] : '1';
$show_cta = isset($settings['show_cta']) ? $settings['show_cta'] : '1';
?>

<div class="d-flex align-items-center mb-4 pb-2 border-bottom">
    <div class="bg-primary text-white rounded p-2 me-3 shadow-sm"><i class="fas fa-home fa-fw fa-lg"></i></div>
    <div>
        <h3 class="mb-0 fw-bold" style="color: #2c3e50;">Pengaturan Home Page</h3>
        <p class="text-muted mb-0 small">Ubah teks, gambar slider, dan atur visibilitas halaman.</p>
    </div>
</div>

<form id="formAdminHome" enctype="multipart/form-data">
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
                                <label class="form-check-label fw-bold small text-muted mb-0">Banner Utama</label>
                                <input class="form-check-input m-0" type="checkbox" name="show_hero" value="1" <?php echo ($show_hero == '1') ? 'checked' : ''; ?> style="width: 40px; height: 20px; cursor:pointer;">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check form-switch p-3 bg-white border rounded shadow-sm d-flex justify-content-between align-items-center">
                                <label class="form-check-label fw-bold small text-muted mb-0">Angka Statistik</label>
                                <input class="form-check-input m-0" type="checkbox" name="show_stats" value="1" <?php echo ($show_stats == '1') ? 'checked' : ''; ?> style="width: 40px; height: 20px; cursor:pointer;">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check form-switch p-3 bg-white border rounded shadow-sm d-flex justify-content-between align-items-center">
                                <label class="form-check-label fw-bold small text-muted mb-0">Slider Produk</label>
                                <input class="form-check-input m-0" type="checkbox" name="show_products" value="1" <?php echo ($show_products == '1') ? 'checked' : ''; ?> style="width: 40px; height: 20px; cursor:pointer;">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check form-switch p-3 bg-white border rounded shadow-sm d-flex justify-content-between align-items-center">
                                <label class="form-check-label fw-bold small text-muted mb-0">Formulir Kontak</label>
                                <input class="form-check-input m-0" type="checkbox" name="show_cta" value="1" <?php echo ($show_cta == '1') ? 'checked' : ''; ?> style="width: 40px; height: 20px; cursor:pointer;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white py-3 border-bottom-0"><h6 class="fw-bold mb-0 text-primary"><i class="fas fa-images me-2"></i>2. Banner Utama (Hero Section)</h6></div>
                <div class="card-body p-4 bg-light rounded-bottom-3">
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label fw-bold text-muted small">Judul Utama</label><input type="text" class="form-control" name="hero_title" value="<?php echo htmlspecialchars($hero_title); ?>" required></div>
                        <div class="col-md-6"><label class="form-label fw-bold text-muted small">Teks Label Kecil</label><input type="text" class="form-control" name="hero_badge" value="<?php echo htmlspecialchars($hero_badge); ?>" required></div>
                        <div class="col-12"><label class="form-label fw-bold text-muted small">Deskripsi Singkat</label><textarea class="form-control" name="hero_desc" rows="3" required><?php echo htmlspecialchars($hero_desc); ?></textarea></div>
                        
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-muted small">Gambar Slider 1</label>
                            <input type="file" name="hero_img_1" class="form-control mb-2" accept="image/*">
                            <input type="hidden" name="old_hero_img_1" value="<?php echo isset($settings['hero_img_1']) ? $settings['hero_img_1'] : ''; ?>">
                            <?php if(!empty($settings['hero_img_1'])): ?><img src="<?php echo $settings['hero_img_1']; ?>" class="img-thumbnail" style="height: 60px; object-fit: cover;"><?php endif; ?>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-muted small">Gambar Slider 2</label>
                            <input type="file" name="hero_img_2" class="form-control mb-2" accept="image/*">
                            <input type="hidden" name="old_hero_img_2" value="<?php echo isset($settings['hero_img_2']) ? $settings['hero_img_2'] : ''; ?>">
                            <?php if(!empty($settings['hero_img_2'])): ?><img src="<?php echo $settings['hero_img_2']; ?>" class="img-thumbnail" style="height: 60px; object-fit: cover;"><?php endif; ?>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-muted small">Gambar Slider 3</label>
                            <input type="file" name="hero_img_3" class="form-control mb-2" accept="image/*">
                            <input type="hidden" name="old_hero_img_3" value="<?php echo isset($settings['hero_img_3']) ? $settings['hero_img_3'] : ''; ?>">
                            <?php if(!empty($settings['hero_img_3'])): ?><img src="<?php echo $settings['hero_img_3']; ?>" class="img-thumbnail" style="height: 60px; object-fit: cover;"><?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white py-3 border-bottom-0"><h6 class="fw-bold mb-0 text-primary"><i class="fas fa-chart-line me-2"></i>3. Angka Statistik Perusahaan</h6></div>
                <div class="card-body p-4 bg-light rounded-bottom-3">
                    <div class="row g-3">
                        <div class="col-md-3"><label class="form-label fw-bold text-muted small">Produk & Material</label><input type="text" class="form-control fw-bold" name="stat_products" value="<?php echo htmlspecialchars($stat_products); ?>" required></div>
                        <div class="col-md-3"><label class="form-label fw-bold text-muted small">Proyek Selesai</label><input type="text" class="form-control fw-bold" name="stat_projects" value="<?php echo htmlspecialchars($stat_projects); ?>" required></div>
                        <div class="col-md-3"><label class="form-label fw-bold text-muted small">Klien Industri</label><input type="text" class="form-control fw-bold" name="stat_clients" value="<?php echo htmlspecialchars($stat_clients); ?>" required></div>
                        <div class="col-md-3"><label class="form-label fw-bold text-muted small">Penghargaan</label><input type="text" class="form-control fw-bold" name="stat_awards" value="<?php echo htmlspecialchars($stat_awards); ?>" required></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white py-3 border-bottom-0"><h6 class="fw-bold mb-0 text-primary"><i class="fas fa-bullhorn me-2"></i>4. Teks Ajakan (Call to Action)</h6></div>
                <div class="card-body p-4 bg-light rounded-bottom-3">
                    <div class="row g-3">
                        <div class="col-md-12"><label class="form-label fw-bold text-muted small">Judul Call to Action</label><input type="text" class="form-control" name="cta_title" value="<?php echo htmlspecialchars($cta_title); ?>" required></div>
                        <div class="col-12"><label class="form-label fw-bold text-muted small">Deskripsi</label><textarea class="form-control" name="cta_desc" rows="3" required><?php echo htmlspecialchars($cta_desc); ?></textarea></div>
                    </div>
                </div>
            </div>
        </div>

       <div class="col-12">
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-header bg-white py-3 border-bottom-0">
                    <h6 class="fw-bold mb-0 text-primary"><i class="fas fa-box-open me-2"></i>5. Pengaturan Slider Produk (Berjalan)</h6>
                </div>
                <div class="card-body p-4 bg-light rounded-bottom-3">
                    <div id="sliderItemsContainer">
                        <?php 
                        $slider_json = isset($settings['slider_data']) ? $settings['slider_data'] : '[]';
                        $slider_data = json_decode($slider_json, true) ?: [];
                        
                        foreach($slider_data as $index => $item): 
                        ?>
                        <div class="row g-2 mb-3 align-items-center border-bottom pb-3 slider-item">
                            <div class="col-md-3">
                                <label class="form-label small fw-bold text-muted">Nama Produk</label>
                                <input type="text" name="slider_name[]" class="form-control" value="<?php echo htmlspecialchars($item['name']); ?>" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small fw-bold text-muted">Kategori</label>
                                <input type="text" name="slider_category[]" class="form-control" value="<?php echo htmlspecialchars($item['category']); ?>" required>
                            </div>
                            <div class="col-md-5">
                                <label class="form-label small fw-bold text-muted">Gambar Produk (Upload)</label>
                                <div class="d-flex align-items-center gap-2">
                                    <?php if(!empty($item['img'])): ?>
                                        <img src="<?php echo htmlspecialchars($item['img']); ?>" class="img-thumbnail" style="height: 45px; width: 60px; object-fit: cover;">
                                    <?php endif; ?>
                                    <input type="file" name="slider_img[]" class="form-control form-control-sm" accept="image/*">
                                    <input type="hidden" name="old_slider_img[]" value="<?php echo htmlspecialchars($item['img']); ?>">
                                </div>
                            </div>
                            <div class="col-md-1 text-end">
                                <label class="form-label d-block">&nbsp;</label>
                                <button type="button" class="btn btn-danger btn-sm w-100 remove-slider-item"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <button type="button" id="addSliderItem" class="btn btn-outline-primary btn-sm mt-2">
                        <i class="fas fa-plus me-1"></i> Tambah Item Slider
                    </button>
                </div>
            </div>
        </div>

       <button type="submit" id="btnSubmit" class="btn btn-primary fw-bold px-4 shadow-sm py-2">
            <i class="fas fa-save me-2"></i> Simpan Perubahan
       </button>
    </div>
</form>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// --- SCRIPT 1: Menambah dan Menghapus Baris Slider ---
const btnAddSlider = document.getElementById('addSliderItem');
if(btnAddSlider) {
    btnAddSlider.onclick = function() {
        let container = document.getElementById('sliderItemsContainer');
        let newItem = `
            <div class="row g-2 mb-3 align-items-center border-bottom pb-3 slider-item">
                <div class="col-md-3">
                    <input type="text" name="slider_name[]" class="form-control" placeholder="Nama Produk" required>
                </div>
                <div class="col-md-3">
                    <input type="text" name="slider_category[]" class="form-control" placeholder="Kategori" required>
                </div>
                <div class="col-md-5">
                    <input type="file" name="slider_img[]" class="form-control form-control-sm" accept="image/*" required>
                    <input type="hidden" name="old_slider_img[]" value="">
                </div>
                <div class="col-md-1 text-end">
                    <button type="button" class="btn btn-danger btn-sm w-100 remove-slider-item"><i class="fas fa-trash"></i></button>
                </div>
            </div>`;
        container.insertAdjacentHTML('beforeend', newItem);
    };
}

document.addEventListener('click', function(e) {
    if(e.target && e.target.closest('.remove-slider-item')) {
        e.target.closest('.slider-item').remove();
    }
});


// --- SCRIPT 2: Proses Simpan Data (AJAX) ---
document.getElementById('formAdminHome').addEventListener('submit', function(e) {
    e.preventDefault(); 
    
    let formData = new FormData(this);
    let btnSubmit = document.getElementById('btnSubmit');
    let originalText = btnSubmit.innerHTML;
    
    btnSubmit.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Menyimpan...';
    btnSubmit.disabled = true;

    fetch('process_update_home.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if(data.status === 'success') {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: data.message,
                showConfirmButton: false,
                timer: 2000 
            }).then(() => {
                window.location.reload(); // Reload halaman agar gambar baru muncul
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: data.message
            });
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Terjadi kesalahan sistem atau jaringan terputus.'
        });
    })
    .finally(() => {
        btnSubmit.innerHTML = originalText;
        btnSubmit.disabled = false;
    });
});
</script>