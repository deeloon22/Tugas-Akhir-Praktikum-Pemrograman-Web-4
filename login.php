<?php
// login.php - Halaman login (Updated Design)
require_once 'config.php';

// Jika sudah login, redirect ke index
if (isLoggedIn()) {
    header('Location: index.php');
    exit;
}

$error = '';

// Proses login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    foreach ($_SESSION['users'] as $user) {
        if ($user['username'] === $username && password_verify($password, $user['password'])) {
            $_SESSION['logged_in'] = true;
            $_SESSION['username'] = $username;
            // Regenerate session id on successful login to prevent fixation
            session_regenerate_id(true);
            header('Location: index.php');
            exit;
        }
    }
    $error = 'Username atau password salah!';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Manajemen Kontak</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <div style="font-size: 40px; margin-bottom: 10px;">🔐</div>
            <h2>Welcome Back</h2>
            <p>Masukkan kredensial Anda untuk masuk</p>
        </div>
        
        <?php if ($error): ?>
            <div class="alert error">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" class="login-form">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" required autofocus placeholder="admin">
            </div>
            
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required placeholder="••••••••">
            </div>
            
            <button type="submit" class="btn btn-primary btn-block">
                Masuk
            </button>
        </form>

        <div style="margin-top: 20px; font-size: 12px; color: #888;">
            Default: admin / admin123
        </div>
    </div>
</body>
</html>