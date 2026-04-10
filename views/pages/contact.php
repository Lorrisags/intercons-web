<?php
/*
 * Path File: /views/pages/contact.php
 * Deskripsi: Halaman informasi kontak dan formulir pesan PT Intercons.
 */

// Memanggil koneksi database
require_once __DIR__ . '/../../config/database.php';
$db = (new Database())->getConnection();

// Mengambil data dari tabel settings (Sama seperti halaman About)
$query = "SELECT setting_key, setting_value FROM settings";
$stmt = $db->prepare($query);
$stmt->execute();

$settings = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $settings[$row['setting_key']] = $row['setting_value'];
}

$about_address = isset($settings['about_address']) ? $settings['about_address'] : 'Jl. Industri Raya No. 123, Surabaya, Jawa Timur, Indonesia';
$about_contact = isset($settings['about_contact']) ? $settings['about_contact'] : "+62 31 5555 8888\ninfo@intercons.co.id";

// Memecah teks kontak menjadi Telepon (baris 1) dan Email (baris 2)
$contact_parts = explode("\n", str_replace("\r", "", $about_contact));
$phone = isset($contact_parts[0]) ? trim($contact_parts[0]) : '';
$email = isset($contact_parts[1]) ? trim($contact_parts[1]) : '';
?>
<div class="container-fluid" style="background-color: #003B73; padding: 140px 0 60px 0; background-image: url('https://www.transparenttextures.com/patterns/cubes.png');">
    <div class="container text-center">
        <h1 class="fw-bold text-white mb-2" style="letter-spacing: 1px;">Hubungi Kami</h1>
        <p style="color: #00BFFF; font-size: 1.1rem;"><i class="fas fa-headset me-2"></i>Tim kami siap membantu dan menjawab pertanyaan Anda</p>
    </div>
</div>

<section class="py-5 bg-light" style="min-height: 60vh;">
    <div class="container py-4">
        
        <div class="row g-5">
            <div class="col-lg-5">
                <h3 class="fw-bold mb-4" style="color: #003B73;">Informasi Kontak</h3>
                <p class="text-muted mb-5">Apakah Anda memiliki pertanyaan mengenai layanan kami, butuh penawaran harga, atau ingin mendiskusikan proyek industri Anda? Jangan ragu untuk menghubungi kami melalui detail di bawah ini.</p>
                
                <div class="d-flex mb-4 align-items-center p-3 bg-white rounded shadow-sm border-start border-4" style="border-color: #00BFFF !important;">
                    <div class="me-4">
                        <div class="d-flex align-items-center justify-content-center rounded-circle" style="width: 50px; height: 50px; background-color: #E1F5FE;">
                            <i class="fas fa-map-marker-alt fa-lg" style="color: #005B96;"></i>
                        </div>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1" style="color: #003B73;">Alamat Kantor Pusat</h6>
                        <p class="text-muted mb-0 small"><?php echo nl2br(htmlspecialchars($about_address)); ?></p>
                    </div>
                </div>

                <div class="d-flex mb-4 align-items-center p-3 bg-white rounded shadow-sm border-start border-4" style="border-color: #03A9F4 !important;">
                    <div class="me-4">
                        <div class="d-flex align-items-center justify-content-center rounded-circle" style="width: 50px; height: 50px; background-color: #E1F5FE;">
                            <i class="fas fa-phone-alt fa-lg" style="color: #005B96;"></i>
                        </div>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1" style="color: #003B73;">Telepon</h6>
                        <p class="text-muted mb-0 small"><?php echo htmlspecialchars($phone); ?></p>
                    </div>
                </div>

                <div class="d-flex mb-4 align-items-center p-3 bg-white rounded shadow-sm border-start border-4" style="border-color: #005B96 !important;">
                    <div class="me-4">
                        <div class="d-flex align-items-center justify-content-center rounded-circle" style="width: 50px; height: 50px; background-color: #E1F5FE;">
                            <i class="fas fa-envelope fa-lg" style="color: #005B96;"></i>
                        </div>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1" style="color: #003B73;">Email</h6>
                        <p class="text-muted mb-0 small"><?php echo htmlspecialchars($email); ?></p>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="card border-0 shadow-sm p-4 p-md-5 rounded-4 border-top border-4" style="border-color: #003B73 !important;">
                    <h4 class="fw-bold mb-4" style="color: #003B73;">Kirim Pesan Langsung</h4>
                    <form action="process_contact.php" method="POST">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-muted small">Nama Lengkap</label>
                                <input type="text" name="company_name" class="form-control form-control-lg border-info" style="font-size: 0.95rem;" placeholder="Masukkan nama Anda" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-muted small">Layanan Terkait</label>
                                <input type="text" name="service_needed" class="form-control form-control-lg border-info" style="font-size: 0.95rem;" placeholder="Contoh: Info Produk" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold text-muted small">Isi Pesan</label>
                                <textarea name="details" class="form-control border-info" rows="5" placeholder="Tuliskan pesan atau pertanyaan Anda di sini..." required></textarea>
                            </div>
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-lg w-100 fw-bold shadow-sm text-white" style="background-color: #005B96; border-radius: 8px;">
                                    Kirim Pesan <i class="fas fa-paper-plane ms-2"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
    </div>
</section>