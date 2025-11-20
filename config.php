<?php
session_start();

if (!isset($_SESSION['users'])) {
    $_SESSION['users'] = [
        ['username' => 'admin', 'password' => password_hash('admin123', PASSWORD_DEFAULT)]
    ];
}

if (!isset($_SESSION['contacts'])) {
    $_SESSION['contacts'] = [];
}

function isLoggedIn() {
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}

function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit;
    }
}

function generateId() {
    return uniqid();
}

function getContacts() {
    return $_SESSION['contacts'] ?? [];
}

function addContact($data) {
    $contact = [
        'id' => generateId(),
        'nama' => $data['nama'],
        'email' => $data['email'],
        'telepon' => $data['telepon'],
        'alamat' => $data['alamat'],
        'created_at' => date('Y-m-d H:i:s')
    ];
    $_SESSION['contacts'][] = $contact;
    return true;
}

function updateContact($id, $data) {
    foreach ($_SESSION['contacts'] as &$contact) {
        if ($contact['id'] === $id) {
            $contact['nama'] = $data['nama'];
            $contact['email'] = $data['email'];
            $contact['telepon'] = $data['telepon'];
            $contact['alamat'] = $data['alamat'];
            return true;
        }
    }
    return false;
}

function deleteContact($id) {
    $_SESSION['contacts'] = array_filter($_SESSION['contacts'], function($contact) use ($id) {
        return $contact['id'] !== $id;
    });
    $_SESSION['contacts'] = array_values($_SESSION['contacts']);
    return true;
}

function getContactById($id) {
    foreach ($_SESSION['contacts'] as $contact) {
        if ($contact['id'] === $id) {
            return $contact;
        }
    }
    return null;
}

function validateContact($data) {
    $errors = [];
    
    if (empty($data['nama'])) {
        $errors[] = 'Nama wajib diisi';
    }
    
    if (empty($data['email'])) {
        $errors[] = 'Email wajib diisi';
    } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Format email tidak valid';
    }
    
    if (empty($data['telepon'])) {
        $errors[] = 'Telepon wajib diisi';
    } elseif (!preg_match('/^[0-9\-\+\(\) ]{8,20}$/', $data['telepon'])) {
        $errors[] = 'Format telepon tidak valid (minimal 8 karakter, hanya angka dan simbol -, +, (), spasi)';
    }
    
    return $errors;
}

function searchContacts($keyword) {
    if (empty($keyword)) {
        return getContacts();
    }
    
    return array_filter(getContacts(), function($contact) use ($keyword) {
        return stripos($contact['nama'], $keyword) !== false ||
               stripos($contact['email'], $keyword) !== false ||
               stripos($contact['telepon'], $keyword) !== false;
    });
}
?>
