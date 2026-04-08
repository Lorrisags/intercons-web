<?php
/*
 * Path File: /views/admin/admin_settings.php
 * Deskripsi: Halaman Admin untuk pengaturan akun (Ganti Password).
 */

// Pastikan hanya admin yang bisa mengakses
if(!isset($_SESSION['admin'])) { 
    echo "<script>window.location.href='index.php?page=login';</script>";
    exit; 
}
?>
<!-- Header Halaman -->
<div class="d-flex align-items-center mb-4 pb-2 border-bottom">
    <div class="bg-secondary text-white rounded p-2 me-3 shadow-sm">
        <i class="fas fa-cog fa-fw fa-lg"></i>
    </div>
    <div>
        <h3 class="mb-0 fw-bold" style="color: #2c3e50;">Pengaturan Akun</h3>
        <p class="text-muted mb-0 small">Ubah kata sandi (password) untuk keamanan akses Admin Panel.</p>
    </div>
</div>

<div class="row">
    <div class="col-md-6 col-lg-5">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-white py-3 border-bottom-0">
                <h6 class="fw-bold mb-0 text-dark"><i class="fas fa-lock me-2"></i>Ganti Password</h6>
            </div>
            <div class="card-body p-4 bg-light rounded-bottom-3">
                
                <form action="process_update_password.php" method="POST">
                    
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold mb-1">Password Lama</label>
                        <div class="input-group input-group-sm shadow-sm">
                            <span class="input-group-text bg-white border-end-0"><i class="fas fa-key text-muted"></i></span>
                            <input type="password" class="form-control border-start-0" name="old_password" required placeholder="Masukkan password saat ini">
                        </div>
                    </div>
                    
                    <div class="mb-3 mt-4">
                        <label class="form-label text-muted small fw-bold mb-1 text-primary">Password Baru</label>
                        <div class="input-group input-group-sm shadow-sm">
                            <span class="input-group-text bg-white border-end-0"><i class="fas fa-lock text-primary"></i></span>
                            <input type="password" class="form-control border-start-0" name="new_password" required placeholder="Masukkan password baru">
                        </div>
                        <small class="text-muted" style="font-size: 0.7rem;">Gunakan kombinasi huruf dan angka agar lebih aman.</small>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-muted small fw-bold mb-1 text-primary">Konfirmasi Password Baru</label>
                        <div class="input-group input-group-sm shadow-sm">
                            <span class="input-group-text bg-white border-end-0"><i class="fas fa-check-circle text-primary"></i></span>
                            <input type="password" class="form-control border-start-0" name="confirm_password" required placeholder="Ulangi password baru">
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary fw-bold px-4 shadow-sm w-100">
                            <i class="fas fa-save me-2"></i> Update Password
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    
    <!-- Info Box Sebelah Kanan -->
    <div class="col-md-6 col-lg-7 mt-4 mt-md-0">
        <div class="alert alert-info border-0 shadow-sm" role="alert">
            <h6 class="alert-heading fw-bold"><i class="fas fa-info-circle me-2"></i>Informasi Keamanan!</h6>
            <p class="small mb-0 mt-2">Pastikan Anda selalu mengingat password baru yang Anda buat. Sistem menggunakan metode enkripsi <strong>Bcrypt Hash</strong> untuk mengamankan password Anda, sehingga kami tidak dapat memulihkan password jika Anda melupakannya.</p>
            <hr>
            <p class="small mb-0">Sesi Login Anda saat ini: <strong><?php echo $_SESSION['admin']; ?></strong></p>
        </div>
    </div>
</div>