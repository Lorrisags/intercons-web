<?php
require_once __DIR__ . '/../../config/database.php';
$db = (new Database())->getConnection();

$stmt = $db->prepare("SELECT * FROM services ORDER BY id DESC");
$stmt->execute();
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="d-flex justify-content-between align-items-center mb-4 bg-white p-4 rounded-4 shadow-sm border-start border-4" style="border-color: #fd7e14 !important;">
    <div>
        <h4 class="mb-1 fw-bold" style="color: #003B73;">Kelola Layanan (Service)</h4>
        <p class="text-muted mb-0 small">Manajemen daftar layanan utama yang ditawarkan perusahaan.</p>
    </div>
    <button class="btn fw-bold text-white shadow-sm px-4" style="background-color: #fd7e14; border-radius: 8px;" data-bs-toggle="modal" data-bs-target="#tambahService">
        <i class="fas fa-plus me-2"></i> Tambah Layanan
    </button>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background-color: #f8f9fa; color: #fd7e14;">
                    <tr>
                        <th class="ps-4 py-3 border-0">Foto</th>
                        <th class="py-3 border-0">Nama Layanan</th>
                        <th class="py-3 border-0">Deskripsi Singkat</th>
                        <th class="text-center py-3 border-0">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($services)): ?>
                        <tr><td colspan="4" class="text-center py-4 text-muted">Belum ada layanan ditambahkan.</td></tr>
                    <?php else: ?>
                        <?php foreach($services as $s): ?>
                        <tr>
                            <td class="ps-4">
                                <img src="<?php echo htmlspecialchars($s['image_url']); ?>" class="rounded-3 shadow-sm" style="width: 60px; height: 60px; object-fit: cover;">
                            </td>
                            <td class="fw-bold"><?php echo htmlspecialchars($s['title']); ?></td>
                            <td class="text-muted small"><?php echo htmlspecialchars($s['short_description']); ?></td>
                            <td class="text-center">
                                <a href="process_service.php?action=delete&id=<?php echo $s['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus layanan ini beserta gambarnya secara permanen?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="tambahService" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <form action="process_service.php?action=add" method="POST" enctype="multipart/form-data">
                <div class="modal-header border-0 pt-4 px-4">
                    <h5 class="fw-bold">Tambah Layanan Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body px-4">
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">Judul Layanan</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">Upload Foto (Wajib)</label>
                        <input type="file" name="image" class="form-control" accept="image/*" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">Deskripsi Singkat</label>
                        <textarea name="short_desc" class="form-control" rows="2" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">Deskripsi Lengkap (Read More)</label>
                        <textarea name="full_desc" class="form-control" rows="5" required></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="submit" class="btn w-100 fw-bold text-white" style="background-color: #fd7e14; border-radius: 8px;">Simpan Layanan</button>
                </div>
            </form>
        </div>
    </div>
</div>