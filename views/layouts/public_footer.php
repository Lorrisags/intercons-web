<?php
/*
 * Path File: /views/layouts/public_footer.php
 * Deskripsi: Template bagian bawah (Footer & pemanggilan Script JS) untuk halaman pengunjung.
 */

// --- TAMBAHAN KODE PHP UNTUK MENGAMBIL DATA FOOTER DARI DATABASE ---
// Pastikan variabel koneksi dari public_header.php bisa diakses di sini
global $db_conn;

$footer_settings = [];
if ($db_conn) {
    try {
        $stmt = $db_conn->query("SELECT setting_key, setting_value FROM settings WHERE setting_key IN ('footer_desc', 'contact_address', 'contact_phone', 'contact_email')");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $footer_settings[$row['setting_key']] = $row['setting_value'];
        }
    } catch (PDOException $e) {
        // Mengabaikan error jika tabel/kolom belum siap agar web tidak error
    }
}

// Set nilai default jika data belum disetting di admin panel
$desc = isset($footer_settings['footer_desc']) ? $footer_settings['footer_desc'] : 'Mitra strategis Anda dalam rekayasa mekanikal, elektrikal, dan konstruksi sipil. Kami membangun masa depan industri yang lebih baik.';
$alamat = isset($footer_settings['contact_address']) ? $footer_settings['contact_address'] : 'Jl. Industri Raya No. 123, Jakarta';
$telp = isset($footer_settings['contact_phone']) ? $footer_settings['contact_phone'] : '+62 21 5555 8888';
$email = isset($footer_settings['contact_email']) ? $footer_settings['contact_email'] : 'info@intercons.co.id';
// -------------------------------------------------------------------
?>
<footer style="background-color: var(--primary); color: var(--text-light); padding: 50px 0 20px; margin-top: 50px;">
    <div class="container">
        <div class="row g-4">
             <div class="col-lg-6">
                <h5 class="text-white fw-bold mb-3">Intercons</h5>
                <p><?= htmlspecialchars($desc); ?></p>
             </div>
             <div class="col-lg-6 text-lg-end">
                <h5 class="text-white fw-bold mb-3">Kontak Kami</h5>
                <p class="mb-1"><i class="fas fa-map-marker-alt me-2"></i> <?= htmlspecialchars($alamat); ?></p>
                <p class="mb-1"><i class="fas fa-phone me-2"></i> <?= htmlspecialchars($telp); ?></p>
                <p><i class="fas fa-envelope me-2"></i> <?= htmlspecialchars($email); ?></p>
             </div>
        </div>
        <hr class="border-secondary mt-4 mb-4">
        <div class="text-center">
            <p class="mb-0">&copy; <?php echo date("Y"); ?> Intercons. All rights reserved.</p>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if(isset($_SESSION['swal_success'])): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '<?php echo $_SESSION['swal_success']; ?>',
            timer: 4000,
            showConfirmButton: false
        });
    });
</script>
<?php unset($_SESSION['swal_success']); endif; ?>

<?php if(isset($_SESSION['swal_error'])): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '<?php echo $_SESSION['swal_error']; ?>'
        });
    });
</script>
<?php unset($_SESSION['swal_error']); endif; ?>

</body>
</html>