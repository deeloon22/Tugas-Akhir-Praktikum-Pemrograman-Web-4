<?php
require_once 'config.php';

requireLogin();

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'nama' => trim($_POST['nama'] ?? ''),
        'email' => trim($_POST['email'] ?? ''),
        'telepon' => trim($_POST['telepon'] ?? ''),
        'alamat' => trim($_POST['alamat'] ?? '')
    ];
    
    $errors = validateContact($data);
    
    if (empty($errors)) {
        addContact($data);
        $success = 'Kontak berhasil ditambahkan!';
        
        header('refresh:2;url=index.php');
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kontak - Sistem Manajemen Kontak</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="header-content">
                <h1>📇 Sistem Manajemen Kontak</h1>
                <p class="header-subtitle">Kelola kontak Anda dengan mudah dan praktis</p>
            </div>
        </div>
        
        <!-- Breadcrumb -->
        <div class="breadcrumb">
            <a href="index.php">🏠 Dashboard</a>
            <span>/</span>
            <span>Tambah Kontak</span>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h2>➕ Tambah Kontak Baru</h2>
                <p>Isi form di bawah untuk menambahkan kontak baru ke dalam sistem</p>
            </div>
            
            <?php if ($success): ?>
                <div class="alert success">
                    ✓ <?= htmlspecialchars($success) ?>
                    <br><small>Anda akan dialihkan ke dashboard...</small>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($errors)): ?>
                <div class="alert error">
                    <?php foreach ($errors as $error): ?>
                        ✗ <?= htmlspecialchars($error) ?><br>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" class="contact-form">
                <div class="form-row">
                    <div class="form-group">
                        <label>Nama Lengkap <span class="required">*</span></label>
                        <input type="text" name="nama" required 
                               value="<?= isset($_POST['nama']) ? htmlspecialchars($_POST['nama']) : '' ?>"
                               placeholder="Contoh: Ahmad Rizki">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Email <span class="required">*</span></label>
                        <input type="email" name="email" required 
                               value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>"
                               placeholder="Contoh: ahmad@email.com">
                        <small class="form-hint">Pastikan format email valid</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Nomor Telepon <span class="required">*</span></label>
                        <input type="text" name="telepon" required 
                               value="<?= isset($_POST['telepon']) ? htmlspecialchars($_POST['telepon']) : '' ?>"
                               placeholder="Contoh: 081234567890">
                        <small class="form-hint">Minimal 8 karakter, gunakan angka saja atau dengan simbol +, -, (), spasi</small>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Alamat</label>
                    <textarea name="alamat" rows="4" 
                              placeholder="Contoh: Jl. Merdeka No. 123, Jakarta Pusat"><?= isset($_POST['alamat']) ? htmlspecialchars($_POST['alamat']) : '' ?></textarea>
                    <small class="form-hint">Opsional - bisa dikosongkan</small>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        💾 Simpan Kontak
                    </button>
                    <a href="index.php" class="btn btn-secondary">
                        ← Kembali
                    </a>
                </div>
            </form>
        </div>
        
        <div class="footer">
            <p>© 2024 Sistem Manajemen Kontak | Dibuat dengan ❤️</p>
        </div>
    </div>
</body>
</html>
