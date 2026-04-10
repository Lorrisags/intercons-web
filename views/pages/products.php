<?php
require_once __DIR__ . '/../../config/database.php';
$db = (new Database())->getConnection();

// Mengambil data produk dari database
$stmt = $db->prepare("SELECT * FROM products ORDER BY id DESC");
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<section id="products" class="py-5" style="min-height: 80vh; background-color: #F8F9FA;">
    <div class="container py-4">
        <div class="text-center mb-5">
            <h2 class="fw-bold" style="color: #003B73;">Katalog Produk</h2>
            <div style="height: 4px; width: 60px; background-color: #03A9F4; margin: 0 auto; border-radius: 2px;"></div>
            <p class="text-muted mt-3">Material dan peralatan industri dengan standar kualitas terbaik.</p>
        </div>

        <div class="d-flex justify-content-center mb-4 gap-2 flex-wrap" id="filter-buttons">
            <button class="btn btn-sm fw-bold px-3 filter-btn active" data-filter="all" style="background-color: #003B73; color: white;">Semua</button>
            <button class="btn btn-sm btn-outline-info fw-bold px-3 filter-btn" data-filter="Mechanical" style="color: #005B96; border-color: #03A9F4;">Mechanical</button>
            <button class="btn btn-sm btn-outline-info fw-bold px-3 filter-btn" data-filter="Electrical" style="color: #005B96; border-color: #03A9F4;">Electrical</button>
            <button class="btn btn-sm btn-outline-info fw-bold px-3 filter-btn" data-filter="Material" style="color: #005B96; border-color: #03A9F4;">Material</button>
        </div>

        <div class="row g-4" id="product-list">
            <?php if(empty($products)): ?>
                <div class="col-12 text-center py-5">
                    <h5 class="text-muted">Katalog produk belum ditambahkan.</h5>
                </div>
            <?php else: ?>
                <?php foreach($products as $prod): ?>
                <div class="col-lg-3 col-md-6 product-item" data-category="<?php echo htmlspecialchars($prod['category']); ?>">
                    <div class="card border-0 shadow-sm h-100 product-card overflow-hidden">
                        
                        <img src="<?php echo htmlspecialchars($prod['image_url'] ? $prod['image_url'] : 'https://via.placeholder.com/400x300'); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($prod['name']); ?>" style="height: 200px; object-fit: cover;">
                        
                        <div class="card-body text-center d-flex flex-column">
                            <span class="badge mb-2 mx-auto" style="background-color: #E1F5FE; color: #003B73; width: fit-content;"><?php echo htmlspecialchars($prod['category']); ?></span>
                            <h6 class="fw-bold" style="color: #005B96;"><?php echo htmlspecialchars($prod['name']); ?></h6>
                            <p class="text-muted small"><?php echo htmlspecialchars($prod['description']); ?></p>
                            
                            <button class="btn btn-sm w-100 fw-bold mt-auto text-white" style="background-color: #03A9F4;" onclick="window.location.href='?page=contact'">Minta Penawaran</button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const productItems = document.querySelectorAll('.product-item');

    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Hapus status aktif dari semua tombol, atur warna kembali ke outline
            filterButtons.forEach(btn => {
                btn.classList.remove('active');
                btn.style.backgroundColor = 'transparent';
                btn.style.color = '#005B96';
            });
            
            // Set tombol yang diklik jadi aktif
            this.classList.add('active');
            this.style.backgroundColor = '#003B73';
            this.style.color = 'white';

            // Ambil filter yang dipilih
            const filterValue = this.getAttribute('data-filter');

            // Sembunyikan/Tampilkan produk
            productItems.forEach(item => {
                if (filterValue === 'all' || item.getAttribute('data-category') === filterValue) {
                    item.style.display = 'block';
                    // Animasi kecil saat muncul
                    item.style.animation = 'fadeIn 0.5s ease';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
});
</script>

<style>
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
.product-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 59, 115, 0.15) !important;
}
</style>