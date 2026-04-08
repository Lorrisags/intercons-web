<?php
/*
 * Path File: /views/admin/products.php
 * Deskripsi: Halaman Admin untuk melihat dan mengelola data Katalog Produk.
 */
?>
<!-- Header Halaman -->
<div class="d-flex justify-content-between align-items-center mb-4 bg-white p-3 rounded shadow-sm">
    <h4 class="mb-0 fw-bold" style="color: #0A192F;">Kelola Katalog Produk</h4>
    <button class="btn btn-primary" style="background-color: #0A192F; border: none;">
        <i class="fas fa-plus me-2"></i> Tambah Produk Baru
    </button>
</div>

<!-- Tabel Data Produk -->
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4" width="10%">Gambar</th>
                        <th width="30%">Nama Produk</th>
                        <th width="20%">Kategori</th>
                        <th width="25%">Deskripsi Singkat</th>
                        <th class="text-center" width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data Dummy (Di real-world, di-loop dari Database tabel products) -->
                    <tr>
                        <td class="ps-4">
                            <img src="https://images.unsplash.com/photo-1621905252507-b35492cc74b4?w=100&h=100&fit=crop" class="img-thumbnail rounded" alt="Valve">
                        </td>
                        <td class="fw-bold">Industrial Gate Valve</td>
                        <td><span class="badge bg-secondary">Mechanical</span></td>
                        <td class="text-muted small">Gate valve standar industri tahan karat...</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-warning me-1"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td class="ps-4">
                            <img src="https://images.unsplash.com/photo-1518709268805-4e9042af9f23?w=100&h=100&fit=crop" class="img-thumbnail rounded" alt="Pipe">
                        </td>
                        <td class="fw-bold">Heavy Duty Steel Pipe</td>
                        <td><span class="badge bg-secondary">Material</span></td>
                        <td class="text-muted small">Pipa baja karbon untuk tekanan tinggi...</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-warning me-1"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>