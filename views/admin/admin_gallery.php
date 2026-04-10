<?php
/*
 * Path File: /views/admin/admin_gallery.php
 * Deskripsi: Halaman Admin untuk mengelola foto Galeri dan Tampilan Bergeser (Slider Beranda).
 */

require_once __DIR__ . '/../../config/database.php';
$db = (new Database())->getConnection();

// --- 1. Ambil Data Galeri Biasa ---
$stmt_gal = $db->prepare("SELECT setting_value FROM settings WHERE setting_key = 'gallery_data'");
$stmt_gal->execute();
$gallery_json = $stmt_gal->fetchColumn();
$galleries = $gallery_json ? json_decode($gallery_json, true) : [];

// --- 2. Ambil Data Tampilan Bergeser (Slider) ---
$stmt_slide = $db->prepare("SELECT setting_value FROM settings WHERE setting_key = 'slider_data'");
$stmt_slide->execute();
$slider_json = $stmt_slide->fetchColumn();
$sliders = $slider_json ? json_decode($slider_json, true) : [];
?>

<div class="d-flex align-items-center mb-4 pb-2 border-bottom">
    <div class="bg-primary text-white rounded p-2 me-3 shadow-sm">
        <i class="fas fa-camera-retro fa-fw fa-lg"></i>
    </div>
    <div>
        <h3 class="mb-0 fw-bold" style="color: #2c3e50;">Manajemen Visual (Galeri & Slider)</h3>
        <p class="text-muted mb-0 small">Kelola foto portofolio galeri dan animasi gambar bergeser di halaman Beranda.</p>
    </div>
</div>

<!-- Navigasi Tabs -->
<ul class="nav nav-tabs mb-4 border-bottom-0" id="galleryTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active fw-bold border-0 shadow-sm me-2 rounded-top-3 text-primary" id="gallery-tab" data-bs-toggle="tab" data-bs-target="#gallery" type="button" role="tab">
            <i class="fas fa-images me-1"></i> Galeri Proyek
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link fw-bold border-0 shadow-sm rounded-top-3 text-primary" id="slider-tab" data-bs-toggle="tab" data-bs-target="#slider" type="button" role="tab">
            <i class="fas fa-exchange-alt me-1"></i> Tampilan Bergeser (Beranda)
        </button>
    </li>
</ul>

<div class="tab-content mb-5" id="galleryTabsContent">
    
    <!-- ============================================== -->
    <!-- TAB 1: GALERI PROYEK                           -->
    <!-- ============================================== -->
    <div class="tab-pane fade show active" id="gallery" role="tabpanel" aria-labelledby="gallery-tab">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-3 h-100 border-top border-4" style="border-color: #28a745 !important;">
                    <div class="card-header bg-white fw-bold py-3 text-success">
                        <i class="fas fa-plus-circle me-2"></i> Tambah Foto Galeri
                    </div>
                    <div class="card-body bg-light">
                        <form action="process_gallery.php?action=add" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label class="form-label text-muted small fw-bold mb-1">Pilih Foto (JPG/PNG)</label>
                                <input type="file" class="form-control form-control-sm" name="image" accept="image/*" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted small fw-bold mb-1">Judul / Nama Proyek</label>
                                <input type="text" class="form-control form-control-sm" name="title" placeholder="Contoh: Instalasi Pipa" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label text-muted small fw-bold mb-1">Lokasi & Tahun</label>
                                <input type="text" class="form-control form-control-sm" name="loc" placeholder="Contoh: Jakarta, 2026" required>
                            </div>
                            <button type="submit" class="btn btn-success fw-bold w-100 shadow-sm">
                                <i class="fas fa-upload me-2"></i> Unggah Galeri
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-3 border-top border-4" style="border-color: #003B73 !important;">
                    <div class="card-header bg-white fw-bold py-3 text-primary">
                        <i class="fas fa-images me-2"></i> Koleksi Galeri Saat Ini (<?php echo count($galleries); ?> Foto)
                    </div>
                    <div class="card-body bg-light p-4">
                        <?php if(empty($galleries)): ?>
                            <div class="alert alert-warning text-center border-0 shadow-sm mb-0">Belum ada foto di galeri.</div>
                        <?php else: ?>
                            <div class="row g-3">
                                <?php foreach($galleries as $item): ?>
                                <div class="col-md-6 col-xl-4">
                                    <div class="card h-100 border-0 shadow-sm overflow-hidden position-relative">
                                        <img src="<?php echo htmlspecialchars($item['img']); ?>" class="card-img-top bg-dark" style="height: 140px; object-fit: cover;" alt="Gallery Image">
                                        <div class="card-body p-2 text-center">
                                            <h6 class="fw-bold mb-0 text-truncate" style="font-size: 0.85rem; color: #003B73;"><?php echo htmlspecialchars($item['title']); ?></h6>
                                            <small class="text-muted" style="font-size: 0.75rem;"><?php echo htmlspecialchars($item['loc']); ?></small>
                                        </div>
                                        <a href="process_gallery.php?action=delete&id=<?php echo $item['id']; ?>" class="position-absolute top-0 end-0 m-2 btn btn-sm btn-danger shadow" onclick="return confirm('Hapus foto galeri ini?');" title="Hapus"><i class="fas fa-trash-alt"></i></a>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================== -->
    <!-- TAB 2: TAMPILAN BERGESER (SLIDER BERANDA)      -->
    <!-- ============================================== -->
    <div class="tab-pane fade" id="slider" role="tabpanel" aria-labelledby="slider-tab">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-3 h-100 border-top border-4" style="border-color: #03A9F4 !important;">
                    <div class="card-header bg-white fw-bold py-3" style="color: #03A9F4;">
                        <i class="fas fa-plus-circle me-2"></i> Tambah Item Tampilan Bergeser
                    </div>
                    <div class="card-body bg-light">
                        <form action="process_gallery.php?action=add_slider" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label class="form-label text-muted small fw-bold mb-1">Pilih Gambar (JPG/PNG)</label>
                                <input type="file" class="form-control form-control-sm" name="image" accept="image/*" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted small fw-bold mb-1">Nama Produk / Material</label>
                                <input type="text" class="form-control form-control-sm" name="name" placeholder="Contoh: Heavy Duty Steel Pipe" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label text-muted small fw-bold mb-1">Kategori Label</label>
                                <select class="form-select form-select-sm" name="category" required>
                                    <option value="Mechanical">Mechanical</option>
                                    <option value="Electrical">Electrical</option>
                                    <option value="Material">Material</option>
                                    <option value="Proyek">Proyek</option>
                                </select>
                            </div>
                            <button type="submit" class="btn fw-bold w-100 shadow-sm text-white" style="background-color: #03A9F4;">
                                <i class="fas fa-upload me-2"></i> Unggah ke Slider
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-3 border-top border-4" style="border-color: #003B73 !important;">
                    <div class="card-header bg-white fw-bold py-3 text-primary">
                        <i class="fas fa-exchange-alt me-2"></i> Daftar Item Tampilan Bergeser (<?php echo count($sliders); ?> Item)
                    </div>
                    <div class="card-body bg-light p-4">
                        <?php if(empty($sliders)): ?>
                            <div class="alert alert-warning text-center border-0 shadow-sm mb-0">Belum ada item di tampilan bergeser. Tampilan default akan digunakan di beranda.</div>
                        <?php else: ?>
                            <div class="row g-3">
                                <?php foreach($sliders as $item): ?>
                                <div class="col-md-6 col-xl-4">
                                    <div class="card h-100 border-0 shadow-sm overflow-hidden position-relative">
                                        <img src="<?php echo htmlspecialchars($item['img']); ?>" class="card-img-top bg-dark" style="height: 140px; object-fit: cover;" alt="Slider Image">
                                        <div class="card-body p-2 text-center">
                                            <span class="badge mb-1" style="background-color: #E1F5FE; color: #003B73; font-size: 0.65rem;"><?php echo htmlspecialchars($item['category']); ?></span>
                                            <h6 class="fw-bold mb-0 text-truncate" style="font-size: 0.85rem; color: #005B96;"><?php echo htmlspecialchars($item['name']); ?></h6>
                                        </div>
                                        <a href="process_gallery.php?action=delete_slider&id=<?php echo $item['id']; ?>" class="position-absolute top-0 end-0 m-2 btn btn-sm btn-danger shadow" onclick="return confirm('Hapus item dari tampilan bergeser?');" title="Hapus"><i class="fas fa-trash-alt"></i></a>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Auto-aktifkan tab Slider jika baru saja mengedit slider -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('tab') === 'slider') {
            var sliderTab = new bootstrap.Tab(document.getElementById('slider-tab'));
            sliderTab.show();
        }
    });
</script>