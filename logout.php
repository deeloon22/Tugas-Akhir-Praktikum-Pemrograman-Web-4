<?php
// logout.php - Proses logout
require_once 'config.php';

// Hapus flag autentikasi (jangan hapus data users/contacts yang disimpan di session)
unset($_SESSION['logged_in'], $_SESSION['username']);

// Regenerate session id untuk mencegah reuse session lama
session_regenerate_id(true);

// Redirect ke login
header('Location: login.php');
exit;
?>