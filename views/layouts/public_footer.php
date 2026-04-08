<?php
/*
 * Path File: /views/layouts/public_footer.php
 * Deskripsi: Template bagian bawah (Footer & pemanggilan Script JS) untuk halaman pengunjung.
 */
?>
<footer style="background-color: var(--primary); color: var(--text-light); padding: 50px 0 20px; margin-top: 50px;">
    <div class="container">
        <div class="row g-4">
             <div class="col-lg-6">
                <h5 class="text-white fw-bold mb-3">Intercons</h5>
                <p>Mitra strategis Anda dalam rekayasa mekanikal, elektrikal, dan konstruksi sipil. Kami membangun masa depan industri yang lebih baik.</p>
             </div>
             <div class="col-lg-6 text-lg-end">
                <h5 class="text-white fw-bold mb-3">Kontak Kami</h5>
                <p class="mb-1"><i class="fas fa-map-marker-alt me-2"></i> Jl. Industri Raya No. 123, Jakarta</p>
                <p class="mb-1"><i class="fas fa-phone me-2"></i> +62 21 5555 8888</p>
                <p><i class="fas fa-envelope me-2"></i> info@intercons.co.id</p>
             </div>
        </div>
        <hr class="border-secondary mt-4 mb-4">
        <div class="text-center">
            <p class="mb-0">&copy; <?php echo date("Y"); ?> Intercons. All rights reserved.</p>
        </div>
    </div>
</footer>

<!-- Bootstrap JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>