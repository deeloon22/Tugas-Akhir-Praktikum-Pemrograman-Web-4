<?php
// delete_contact.php - Proses hapus kontak
require_once 'config.php';

// [PENTING] Cek login dulu
requireLogin();

// Ambil ID kontak
$id = $_GET['id'] ?? '';

// Cek apakah kontak ada
$contact = getContactById($id);

if ($contact) {
    // Hapus kontak
    deleteContact($id);
}

// Redirect ke index
header('Location: index.php');
exit;
?>