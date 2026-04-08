<?php
/*
 * Path File: /views/admin/admin_products.php
 * Deskripsi: Halaman Admin untuk mengelola data produk (CRUD).
 */
?>
<!-- Header Kelola Produk -->
<div class="d-flex justify-content-between align-items-center mb-4 bg-white p-4 rounded-4 shadow-sm border-start border-4" style="border-color: #00BFFF !important;">
    <div>
        <h4 class="mb-1 fw-bold" style="color: #003B73;">Kelola Data Produk</h4>
        <p class="text-muted mb-0 small">Tambah, ubah, atau hapus katalog produk dan material.</p>
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
                        <th class="ps-4 py-3 border-0">ID</th>
                        <th class="py-3 border-0">Foto</th>
                        <th class="py-3 border-0">Nama Produk</th>
                        <th class="py-3 border-0">Kategori</th>
                        <th class="py-3 border-0">Harga / Estimasi</th>
                        <th class="text-center py-3 border-0">Aksi</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    <!-- Contoh Data 1 -->
                    <tr>
                        <td class="ps-4 py-3 text-muted fw-bold">#PRD-001</td>
                        <td>
                            <img src="https://images.unsplash.com/photo-1621905252507-b35492cc74b4?w=100&h=100&fit=crop" class="rounded-3 shadow-sm" style="width: 50px; height: 50px; object-fit: cover;">
                        </td>
                        <td class="fw-bold text-dark">Industrial Gate Valve</td>
                        <td><span class="badge" style="background-color: #E1F5FE; color: #003B73;">Mechanical</span></td>
                        <td class="text-muted">Hubungi Sales</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-outline-primary rounded-3 me-1" title="Edit"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-sm btn-outline-danger rounded-3" title="Hapus"><i class="fas fa-trash-alt"></i></button>
                        </td>
                    </tr>
                    <!-- Contoh Data 2 -->
                    <tr>
                        <td class="ps-4 py-3 text-muted fw-bold">#PRD-002</td>
                        <td>
                            <img src="https://images.unsplash.com/photo-1544724569-5f546fd6f2b6?w=100&h=100&fit=crop" class="rounded-3 shadow-sm" style="width: 50px; height: 50px; object-fit: cover;">
                        </td>
                        <td class="fw-bold text-dark">Control Panel 3 Phase</td>
                        <td><span class="badge" style="background-color: #E1F5FE; color: #003B73;">Electrical</span></td>
                        <td class="text-muted">Hubungi Sales</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-outline-primary rounded-3 me-1" title="Edit"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-sm btn-outline-danger rounded-3" title="Hapus"><i class="fas fa-trash-alt"></i></button>
                        </td>
                    </tr>
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
            <div class="modal-body px-4">
                <form action="process_add_product.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">Nama Produk</label>
                        <input type="text" class="form-control" placeholder="Masukkan nama produk" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">Kategori</label>
                        <select class="form-select" required>
                            <option value="">Pilih Kategori</option>
                            <option value="Mechanical">Mechanical</option>
                            <option value="Electrical">Electrical</option>
                            <option value="Material">Material</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">Deskripsi Singkat</label>
                        <textarea class="form-control" rows="3" placeholder="Deskripsi produk..." required></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-muted small fw-bold">Upload Foto (Opsional)</label>
                        <input class="form-control" type="file">
                    </div>
                    <button type="submit" class="btn w-100 fw-bold text-white py-2 mb-2" style="background-color: #005B96; border-radius: 8px;">Simpan Produk</button>
                </form>
            </div>
        </div>
    </div>
</div>