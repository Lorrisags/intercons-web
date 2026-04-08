<?php
/* Path File: /process_contact.php */
session_start();
require_once __DIR__ . '/config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = (new Database())->getConnection();

    // Tangkap data dari form
    $company_name = $_POST['company_name'];
    $service_needed = $_POST['service_needed'];
    $details = $_POST['details'];

    // Simpan ke database
    $query = "INSERT INTO contact_messages (company_name, service_needed, details) VALUES (:company, :service, :details)";
    $stmt = $db->prepare($query);
    
    $stmt->bindParam(':company', $company_name);
    $stmt->bindParam(':service', $service_needed);
    $stmt->bindParam(':details', $details);

    if ($stmt->execute()) {
        // Jika sukses, kembalikan ke home dengan pesan sukses
        echo "<script>
            alert('Terima kasih! Permintaan Anda berhasil dikirim. Tim kami akan segera menghubungi Anda.');
            window.location.href='index.php?page=home';
        </script>";
    } else {
        echo "<script>
            alert('Maaf, terjadi kesalahan sistem. Silakan coba lagi nanti.');
            window.location.href='index.php?page=home';
        </script>";
    }
} else {
    header("Location: index.php?page=home");
}
?>