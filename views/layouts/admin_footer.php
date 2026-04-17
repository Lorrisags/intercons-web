<?php
/*
 * Path File: /views/layouts/admin_footer.php
 * Deskripsi: Template bagian bawah untuk panel Admin (menutup tag dan memuat JS).
 */
?>
</div> <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if(isset($_SESSION['swal_success'])): ?>
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '<?php echo $_SESSION['swal_success']; ?>',
        timer: 3000,
        showConfirmButton: false
    });
</script>
<?php unset($_SESSION['swal_success']); endif; ?>

<?php if(isset($_SESSION['swal_error'])): ?>
<script>
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: '<?php echo $_SESSION['swal_error']; ?>'
    });
</script>
<?php unset($_SESSION['swal_error']); endif; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const deleteButtons = document.querySelectorAll('.btn-delete');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault(); // Tahan agar tidak langsung pindah halaman
            const href = this.getAttribute('href'); // Ambil link hapusnya
            
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = href; // Lanjutkan ke link hapus
                }
            })
        });
    });
});
</script>

</body>
</html>