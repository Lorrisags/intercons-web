<?php
/*
 * Path File: /views/admin/admin_team.php
 * Deskripsi: Halaman Admin untuk mengelola data anggota tim.
 */

require_once __DIR__ . '/../../config/database.php';
$db = (new Database())->getConnection();

// Mengambil seluruh data dari tabel teams
$stmt = $db->prepare("SELECT * FROM teams ORDER BY id DESC");
$stmt->execute();
$teams = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="d-flex justify-content-between align-items-center mb-4 bg-white p-4 rounded-4 shadow-sm border-start border-4" style="border-color: #6f42c1 !important;">
    <div>
        <h4 class="mb-1 fw-bold" style="color: #003B73;">Kelola Tim Profesional</h4>
        <p class="text-muted mb-0 small">Tambah, ubah, atau hapus anggota manajemen dan tenaga ahli.</p>
    </div>
    <button class="btn fw-bold text-white shadow-sm px-4" style="background-color: #6f42c1; border-radius: 8px;" data-bs-toggle="modal" data-bs-target="#tambahTimModal">
        <i class="fas fa-plus me-2"></i> Tambah Anggota
    </button>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background-color: #f8f9fa; color: #6f42c1;">
                    <tr>
                        <th class="ps-4 py-3 border-0">Foto</th>
                        <th class="py-3 border-0">Nama Lengkap</th>
                        <th class="py-3 border-0">Jabatan</th>
                        <th class="py-3 border-0">Kategori</th>
                        <th class="text-center py-3 border-0">Aksi</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    <?php if(empty($teams)): ?>
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Belum ada data anggota tim.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($teams as $team): ?>
                        <tr>
                            <td class="ps-4 py-3">
                                <img src="<?php echo htmlspecialchars($team['photo_url'] ? $team['photo_url'] : 'https://via.placeholder.com/100'); ?>" class="rounded-circle shadow-sm" style="width: 50px; height: 50px; object-fit: cover;">
                            </td>
                            <td class="fw-bold text-dark"><?php echo htmlspecialchars($team['name']); ?></td>
                            <td class="text-muted"><?php echo htmlspecialchars($team['position']); ?></td>
                            <td>
                                <?php if($team['category'] == 'Manajemen'): ?>
                                    <span class="badge" style="background-color: #e2d9f3; color: #6f42c1;">Manajemen</span>
                                <?php else: ?>
                                    <span class="badge" style="background-color: #E1F5FE; color: #003B73;">Tenaga Ahli</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-outline-primary rounded-3 me-1 edit-btn" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editTimModal"
                                    data-id="<?php echo $team['id']; ?>"
                                    data-name="<?php echo htmlspecialchars($team['name']); ?>"
                                    data-position="<?php echo htmlspecialchars($team['position']); ?>"
                                    data-category="<?php echo htmlspecialchars($team['category']); ?>"
                                    data-photo="<?php echo htmlspecialchars($team['photo_url']); ?>"
                                    title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger rounded-3" title="Hapus"><i class="fas fa-trash-alt"></i></button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="tambahTimModal" tabindex="-1" aria-labelledby="tambahTimModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg">
            <div class="modal-header border-bottom-0 pt-4 px-4">
                <h5 class="modal-title fw-bold" id="tambahTimModalLabel" style="color: #003B73;">Tambah Anggota Tim</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4">
                <form action="process_add_team.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">Nama Lengkap & Gelar</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small fw-bold">Jabatan</label>
                            <input type="text" name="position" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small fw-bold">Kategori</label>
                            <select name="category" class="form-select" required>
                                <option value="Manajemen">Manajemen</option>
                                <option value="Tenaga Ahli">Tenaga Ahli</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-muted small fw-bold">Upload Foto Profil</label>
                        <input class="form-control" type="file" name="photo" accept="image/*" required>
                    </div>
                    <button type="submit" class="btn w-100 fw-bold text-white py-2 mb-2" style="background-color: #6f42c1; border-radius: 8px;">Simpan Data</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editTimModal" tabindex="-1" aria-labelledby="editTimModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg">
            <div class="modal-header border-bottom-0 pt-4 px-4">
                <h5 class="modal-title fw-bold" id="editTimModalLabel" style="color: #003B73;">Edit Anggota Tim</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4">
                <form action="process_edit_team.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="edit_id">
                    <input type="hidden" name="old_photo" id="edit_old_photo">

                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">Nama Lengkap & Gelar</label>
                        <input type="text" name="name" id="edit_name" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small fw-bold">Jabatan</label>
                            <input type="text" name="position" id="edit_position" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small fw-bold">Kategori</label>
                            <select name="category" id="edit_category" class="form-select" required>
                                <option value="Manajemen">Manajemen</option>
                                <option value="Tenaga Ahli">Tenaga Ahli</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-muted small fw-bold">Ganti Foto (Opsional)</label>
                        <input class="form-control" type="file" name="photo" accept="image/*">
                        <small class="text-muted">Biarkan kosong jika tidak ingin mengganti foto.</small>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 fw-bold text-white py-2 mb-2" style="border-radius: 8px;">Update Data</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const editButtons = document.querySelectorAll('.edit-btn');
    
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Ambil data dari atribut tombol
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            const position = this.getAttribute('data-position');
            const category = this.getAttribute('data-category');
            const oldPhoto = this.getAttribute('data-photo');

            // Masukkan data ke dalam input di form modal edit
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_position').value = position;
            document.getElementById('edit_category').value = category;
            document.getElementById('edit_old_photo').value = oldPhoto;
        });
    });
});
</script>