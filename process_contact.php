<?php
/* Path File: /process_contact.php */
session_start();
require_once __DIR__ . '/config/database.php';

// Import class PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load file autoload dari Composer
require __DIR__ . '/vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = (new Database())->getConnection();

    $company_name = isset($_POST['company_name']) ? trim($_POST['company_name']) : '';
    $contact_name = isset($_POST['contact_name']) ? trim($_POST['contact_name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $service_needed = isset($_POST['service_needed']) ? trim($_POST['service_needed']) : '';
    $details_input = isset($_POST['details']) ? trim($_POST['details']) : '';

    // ==========================================
    // LOGIKA PENENTUAN SUMBER FORM & SUBJEK
    // ==========================================
    if (!empty($email)) {
        // Jika ada input email, berarti ini dari FORM BERANDA
        $form_source = "Formulir Permintaan"; 
        
        if (empty($service_needed)) {
            $service_needed = "Permintaan Umum"; 
        }
        $details = "Nama Kontak: " . $contact_name . "\nEmail: " . $email . "\n\nDetail Kebutuhan:\n" . $details_input;
    } else {
        // Jika tidak ada input email, berarti ini dari FORM HALAMAN KONTAK
        $form_source = "Kirim Pesan Langsung"; 
        $details = $details_input;
    }

    // Simpan ke database
    $query = "INSERT INTO contact_messages (company_name, service_needed, details) VALUES (:company, :service, :details)";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':company', $company_name);
    $stmt->bindParam(':service', $service_needed);
    $stmt->bindParam(':details', $details);

    $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php?page=home';

    if ($stmt->execute()) {
        
        // ==========================================
        // EKSEKUSI PENGIRIMAN EMAIL DENGAN PHPMAILER
        // ==========================================
        $mail = new PHPMailer(true);

        try {
            // Konfigurasi Server SMTP
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com'; 
            $mail->SMTPAuth   = true;
            
            // ⚠️ UBAH DUA BARIS INI DENGAN AKUN KAMU
            $mail->Username   = 'sss@gmail.com'; // Email Gmail yang kamu gunakan
            $mail->Password   = 'iiz'; // Paste 16 digit huruf tanpa spasi
            
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;

            // Pengirim & Penerima
            $mail->setFrom('sss@gmail.com', 'Notifikasi Website Intercons'); // Samakan dengan Username
            $mail->addAddress('sad@student', 'Admin Intercons'); // Email perusahaan aslinya
            
            // Agar jika admin menekan "Reply", balasannya langsung masuk ke email klien
            if (!empty($email)) {
                $mail->addReplyTo($email, $contact_name); 
            }

            // Konten Email
            $mail->isHTML(true);
            
            // 🎯 INI DIA SUBJEK DINAMISNYA
            $mail->Subject = '[' . $form_source . '] - ' . $company_name;
            
            // Format HTML Email
            $mail->Body = "
                <div style='font-family: Arial, sans-serif; color: #333;'>
                    <h3 style='color: #003B73;'>Pesan Masuk Baru dari Website</h3>
                    <p><strong>Sumber:</strong> {$form_source}</p>
                    <p><strong>Nama Perusahaan:</strong> {$company_name}</p>
                    <p><strong>Layanan Dibutuhkan:</strong> {$service_needed}</p>
                    <hr style='border: 1px solid #eee;'>
                    <p><strong>Detail Pesan:</strong><br/>" . nl2br($details) . "</p>
                </div>
            ";

            $mail->send();
        } catch (Exception $e) {
            // Biarkan kosong, atau hapus komentar di bawah jika ingin mengecek error email di localhost
            // error_log("Email gagal dikirim: {$mail->ErrorInfo}");
        }
        // ==========================================

        $_SESSION['swal_success'] = 'Terima kasih! Pesan Anda berhasil dikirim dan akan segera kami proses.';
        header('Location: ' . $referer);
        exit;
    } else {
        $_SESSION['swal_error'] = 'Maaf, terjadi kesalahan sistem saat mengirim pesan.';
        header('Location: ' . $referer);
        exit;
    }
} else {
    header("Location: index.php?page=home");
    exit;
}
?>