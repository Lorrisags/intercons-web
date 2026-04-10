<?php
/*
 * Path File: /views/admin/admin_products.php
 * Deskripsi: Halaman Admin dinamis untuk mengelola data produk (CRUD).
 * Produk yang dimasukkan di sini akan otomatis muncul di slider animasi Beranda!
 */

require_once __DIR__ . '/../../config/database.php';
$db = (new Database())->getConnection();

// Mengambil seluruh data produk dari tabel
$stmt = $db->prepare("SELECT * FROM products ORDER BY id DESC");
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!-- Header Kelola Produk -->
<div class="d-flex justify-content-between align-items-center mb-4 bg-white p-4 rounded-4 shadow-sm border-start border-4" style="border-color: #00BFFF !important;">
    <div>
        <h4 class="mb-1 fw-bold" style="color: #003B73;">Kelola Data Produk</h4>
        <p class="text-muted mb-0 small">Katalog yang Anda tambahkan di sini akan <b class="text-success">otomatis muncul di Slider Animasi</b> halaman Beranda.</p>
    </div>
    <button class="btn fw-bold text-white shadow-sm px-4" style="background-color: #005B96; border-radius: 8px;" data-bs-toggle="modal" data-bs-target="#tambahProdukModal">
        <i class="fas fa-plus me-2"></i> Tambah Produk
    </button>
</div>

<!-- Tabel Daftar Produk -->
<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background-color: #f8f9fa; color: #005B96;">
                    <tr>
                        <th class="ps-4 py-3 border-0">Foto</th>
                        <th class="py-3 border-0">Nama Produk</th>
                        <th class="py-3 border-0">Kategori</th>
                        <th class="py-3 border-0">Deskripsi Singkat</th>
                        <th class="text-center py-3 border-0">Aksi</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    <?php if(empty($products)): ?>
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="fas fa-box-open fa-3x mb-3 opacity-50"></i>
                                <h5>Belum ada produk</h5>
                                <p>Silakan klik tombol "Tambah Produk" untuk mulai mengisi katalog dan slider Beranda Anda.</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($products as $prod): ?>
                        <tr>
                            <td class="ps-4 py-3">
                                <!-- Jika image URL merupakan link web eksternal (Unsplash) langsung tampilkan, jika lokal tambahkan path -->
                                <img src="<?php echo htmlspecialchars($prod['image_url']); ?>" class="rounded-3 shadow-sm border border-2" style="width: 60px; height: 60px; object-fit: cover; border-color: #E1F5FE !important;">
                            </td>
                            <td class="fw-bold text-dark"><?php echo htmlspecialchars($prod['name']); ?></td>
                            <td><span class="badge" style="background-color: #E1F5FE; color: #003B73;"><?php echo htmlspecialchars($prod['category']); ?></span></td>
                            <td class="text-muted small text-truncate" style="max-width: 250px;"><?php echo htmlspecialchars($prod['description']); ?></td>
                            <td class="text-center">
                                <a href="process_product.php?action=delete&id=<?php echo $prod['id']; ?>" class="btn btn-sm btn-outline-danger rounded-3" onclick="return confirm('Yakin ingin menghapus produk ini secara permanen?');" title="Hapus"><i class="fas fa-trash-alt"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Produk -->
<div class="modal fade" id="tambahProdukModal" tabindex="-1" aria-labelledby="tambahProdukModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg">
            <div class="modal-header border-bottom-0 pt-4 px-4">
                <h5 class="modal-title fw-bold" id="tambahProdukModalLabel" style="color: #003B73;">Tambah Produk Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 pb-4">
                <!-- Arahkan ke file backend process_product.php -->
                <form action="process_product.php?action=add" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">Nama Produk</label>
                        <input type="text" name="name" class="form-control" placeholder="Masukkan nama produk" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">Kategori</label>
                        <select name="category" class="form-select" required>
                            <option value="">Pilih Kategori</option>
                            <option value="Mechanical">Mechanical</option>
                            <option value="Electrical">Electrical</option>
                            <option value="Material">Material</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">Deskripsi Singkat</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Spesifikasi / detail produk..." required></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-muted small fw-bold">Upload Foto (Wajib - Disarankan lanskap)</label>
                        <input class="form-control" type="file" name="image" accept="image/*" required>
                    </div>
                    <button type="submit" class="btn w-100 fw-bold text-white py-2" style="background-color: #005B96; border-radius: 8px;">Simpan & Tampilkan di Beranda</button>
                </form>
            </div>
        </div>
    </div>
</div>