<?php
/*
 * Path File: /views/auth/logout.php
 * Deskripsi: Skrip untuk menghapus session admin dan mengembalikan ke halaman login.
 */

// Menghapus semua variabel session
session_unset();

// Menghancurkan session
session_destroy();

// Mengarahkan (redirect) kembali ke halaman login
header("Location: ?page=login");
exit();
?>