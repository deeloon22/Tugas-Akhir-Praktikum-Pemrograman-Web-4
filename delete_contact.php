<?php
require_once 'config.php';

requireLogin();

$id = $_GET['id'] ?? '';

$contact = getContactById($id);

if ($contact) {
    deleteContact($id);
}

header('Location: index.php');
exit;
?>
