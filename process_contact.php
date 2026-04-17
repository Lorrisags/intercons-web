<?php
/* Path File: /process_contact.php */
session_start();
require_once __DIR__ . '/config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = (new Database())->getConnection();

    // Tangkap data yang dikirim dari form
    $company_name = isset($_POST['company_name']) ? trim($_POST['company_name']) : '';
    $contact_name = isset($_POST['contact_name']) ? trim($_POST['contact_name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $service_needed = isset($_POST['service_needed']) ? trim($_POST['service_needed']) : '';
    $details_input = isset($_POST['details']) ? trim($_POST['details']) : '';

    // --- LOGIKA JIKA PESAN DARI FORM BERANDA (HOME) ---
    if (!empty($email)) {
        if (empty($service_needed)) {
            $service_needed = "Permintaan Beranda"; // Default kebutuhan
        }
        // Gabungkan Nama Kontak dan Email ke dalam isi pesan agar terbaca di Admin
        $details = "Nama Kontak: " . $contact_name . "\nEmail: " . $email . "\n\nDetail Kebutuhan:\n" . $details_input;
    } 
    // --- LOGIKA JIKA PESAN DARI FORM CONTACT ---
    else {
        // Biarkan seperti aslinya
        $details = $details_input;
    }

    // Simpan ke database
    $query = "INSERT INTO contact_messages (company_name, service_needed, details) VALUES (:company, :service, :details)";
    $stmt = $db->prepare($query);
    
    $stmt->bindParam(':company', $company_name);
    $stmt->bindParam(':service', $service_needed);
    $stmt->bindParam(':details', $details);

    // Ambil URL halaman tempat pengunjung mengisi form (Kembali ke tempat semula)
    $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php?page=home';

    if ($stmt->execute()) {
        // Tampilkan popup sukses di halaman pengunjung
        $_SESSION['swal_success'] = 'Terima kasih! Pesan Anda berhasil dikirim dan akan segera kami proses.';
        header('Location: ' . $referer);
        exit;
    } else {
        // Tampilkan popup error di halaman pengunjung
        $_SESSION['swal_error'] = 'Maaf, terjadi kesalahan sistem saat mengirim pesan.';
        header('Location: ' . $referer);
        exit;
    }
} else {
    // Jika ada yang iseng mengakses file ini secara langsung via URL
    header("Location: index.php?page=home");
    exit;
}
?>