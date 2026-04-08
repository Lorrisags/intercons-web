<?php
/* Path File: /views/admin/admin_experience.php */
require_once __DIR__ . '/../../config/database.php';
$db = (new Database())->getConnection();

$stmt = $db->prepare("SELECT * FROM experiences ORDER BY id DESC");
$stmt->execute();
$experiences = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="d-flex justify-content-between align-items-center mb-4 bg-white p-4 rounded-4 shadow-sm border-start border-4" style="border-color: #28a745 !important;">
    <div>
        <h4 class="mb-1 fw-bold" style="color: #003B73;">Kelola Pengalaman Proyek</h4>
        <p class="text-muted mb-0 small">Tambah, ubah, atau hapus portofolio proyek perusahaan.</p>
    </div>
    <button class="btn fw-bold text-white shadow-sm px-4" style="background-color: #28a745; border-radius: 8px;" data-bs-toggle="modal" data-bs-target="#tambahModal">
        <i class="fas fa-plus me-2"></i> Tambah Proyek
    </button>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background-color: #f8f9fa; color: #28a745;">
                    <tr>
                        <th class="ps-4 py-3 border-0">Foto</th>
                        <th class="py-3 border-0">Nama Proyek</th>
                        <th class="py-3 border-0">Klien</th>
                        <th class="py-3 border-0">Detail Singkat</th>
                        <th class="text-center py-3 border-0">Aksi</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    <?php if(empty($experiences)): ?>
                        <tr><td colspan="5" class="text-center py-4 text-muted">Belum ada data proyek.</td></tr>
                    <?php else: ?>
                        <?php foreach($experiences as $exp): ?>
                        <tr>
                            <td class="ps-4 py-3">
                                <img src="<?php echo htmlspecialchars($exp['image_url'] ? $exp['image_url'] : 'https://via.placeholder.com/100'); ?>" class="rounded-3 shadow-sm" style="width: 60px; height: 60px; object-fit: cover;">
                            </td>
                            <td class="fw-bold text-dark"><?php echo htmlspecialchars($exp['project_name']); ?></td>
                            <td class="text-muted"><span class="badge bg-secondary"><?php echo htmlspecialchars($exp['client_name']); ?></span></td>
                            <td class="text-muted small text-truncate" style="max-width: 200px;"><?php echo htmlspecialchars($exp['details']); ?></td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-outline-primary rounded-3 me-1 edit-btn" 
                                    data-bs-toggle="modal" data-bs-target="#editModal"
                                    data-id="<?php echo $exp['id']; ?>"
                                    data-project="<?php echo htmlspecialchars($exp['project_name']); ?>"
                                    data-client="<?php echo htmlspecialchars($exp['client_name']); ?>"
                                    data-details="<?php echo htmlspecialchars($exp['details']); ?>"
                                    data-image="<?php echo htmlspecialchars($exp['image_url']); ?>" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <a href="process_experience.php?action=delete&id=<?php echo $exp['id']; ?>" class="btn btn-sm btn-outline-danger rounded-3" onclick="return confirm('Yakin ingin menghapus proyek ini?');" title="Hapus"><i class="fas fa-trash-alt"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="tambahModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg">
            <div class="modal-header pt-4 px-4"><h5 class="fw-bold">Tambah Proyek</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body px-4">
                <form action="process_experience.php?action=add" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">Nama Proyek</label>
                        <input type="text" name="project_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">Nama Klien / Perusahaan</label>
                        <input type="text" name="client_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">Detail Proyek</label>
                        <textarea name="details" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-muted small fw-bold">Upload Foto Proyek</label>
                        <input class="form-control" type="file" name="image" accept="image/*" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100 fw-bold py-2 mb-2">Simpan Data</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg">
            <div class="modal-header pt-4 px-4"><h5 class="fw-bold">Edit Proyek</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body px-4">
                <form action="process_experience.php?action=edit" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="edit_id">
                    <input type="hidden" name="old_image" id="edit_old_image">
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">Nama Proyek</label>
                        <input type="text" name="project_name" id="edit_project" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">Nama Klien / Perusahaan</label>
                        <input type="text" name="client_name" id="edit_client" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">Detail Proyek</label>
                        <textarea name="details" id="edit_details" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-muted small fw-bold">Ganti Foto (Opsional)</label>
                        <input class="form-control" type="file" name="image" accept="image/*">
                    </div>
                    <button type="submit" class="btn btn-primary w-100 fw-bold py-2 mb-2">Update Data</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const editBtns = document.querySelectorAll('.edit-btn');
    editBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('edit_id').value = this.getAttribute('data-id');
            document.getElementById('edit_project').value = this.getAttribute('data-project');
            document.getElementById('edit_client').value = this.getAttribute('data-client');
            document.getElementById('edit_details').value = this.getAttribute('data-details');
            document.getElementById('edit_old_image').value = this.getAttribute('data-image');
        });
    });
});
</script>