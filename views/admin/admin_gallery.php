<?php
/*
 * Path File: /views/admin/admin_gallery.php
 * Deskripsi: Halaman Admin untuk menambah dan menghapus foto Galeri (Unlimited Dinamis).
 */

require_once __DIR__ . '/../../config/database.php';
$db = (new Database())->getConnection();

// Mengambil data galeri (format JSON) dari tabel settings
$stmt = $db->prepare("SELECT setting_value FROM settings WHERE setting_key = 'gallery_data'");
$stmt->execute();
$gallery_json = $stmt->fetchColumn();

// Decode JSON menjadi array PHP. Jika kosong, siapkan array kosong.
$galleries = $gallery_json ? json_decode($gallery_json, true) : [];
?>
<div class="d-flex align-items-center mb-4 pb-2 border-bottom">
    <div class="bg-primary text-white rounded p-2 me-3 shadow-sm">
        <i class="fas fa-camera-retro fa-fw fa-lg"></i>
    </div>
    <div>
        <h3 class="mb-0 fw-bold" style="color: #2c3e50;">Manajemen Galeri Foto</h3>
        <p class="text-muted mb-0 small">Tambahkan foto baru atau hapus foto lama dari portofolio Anda.</p>
    </div>
</div>

<div class="row g-4 mb-5">
    
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-3 h-100 border-top border-4" style="border-color: #28a745 !important;">
            <div class="card-header bg-white fw-bold py-3 text-success">
                <i class="fas fa-plus-circle me-2"></i> Tambah Foto Baru
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
                        <i class="fas fa-upload me-2"></i> Unggah & Simpan
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-3 border-top border-4" style="border-color: #003B73 !important;">
            <div class="card-header bg-white fw-bold py-3 text-primary d-flex justify-content-between align-items-center">
                <span><i class="fas fa-images me-2"></i> Koleksi Galeri Saat Ini (<?php echo count($galleries); ?> Foto)</span>
            </div>
            <div class="card-body bg-light p-4">
                
                <?php if(empty($galleries)): ?>
                    <div class="alert alert-warning text-center border-0 shadow-sm">
                        <i class="fas fa-exclamation-triangle fa-2x mb-2 text-warning"></i>
                        <p class="mb-0">Belum ada foto di galeri. Silakan tambahkan foto melalui form di sebelah kiri.</p>
                    </div>
                <?php else: ?>
                    <div class="row g-3">
                        <?php foreach($galleries as $item): ?>
                        <div class="col-md-6 col-xl-4">
                            <div class="card h-100 border-0 shadow-sm overflow-hidden position-relative group-hover">
                                <img src="<?php echo htmlspecialchars($item['img']); ?>" class="card-img-top bg-dark" style="height: 140px; object-fit: cover;" alt="Gallery Image">
                                <div class="card-body p-2 text-center">
                                    <h6 class="fw-bold mb-0 text-truncate" style="font-size: 0.85rem; color: #003B73;" title="<?php echo htmlspecialchars($item['title']); ?>">
                                        <?php echo htmlspecialchars($item['title']); ?>
                                    </h6>
                                    <small class="text-muted" style="font-size: 0.75rem;"><?php echo htmlspecialchars($item['loc']); ?></small>
                                </div>
                                <a href="process_gallery.php?action=delete&id=<?php echo $item['id']; ?>" class="position-absolute top-0 end-0 m-2 btn btn-sm btn-danger shadow" onclick="return confirm('Apakah Anda yakin ingin menghapus foto ini secara permanen?');" title="Hapus Foto">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>

</div>