<?php
// edit_contact.php - Halaman edit kontak
require_once 'config.php';

// Pastikan user sudah login
requireLogin();

$errors = [];
$success = '';

// Ambil ID kontak
$id = $_GET['id'] ?? '';

// Cek apakah kontak ada
$contact = getContactById($id);

if (!$contact) {
    header('Location: index.php');
    exit;
}

// Proses update kontak
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'nama' => trim($_POST['nama'] ?? ''),
        'email' => trim($_POST['email'] ?? ''),
        'telepon' => trim($_POST['telepon'] ?? ''),
        'alamat' => trim($_POST['alamat'] ?? '')
    ];
    
    // Validasi
    $errors = validateContact($data);
    
    // Jika tidak ada error, update kontak
    if (empty($errors)) {
        updateContact($id, $data);
        $success = 'Kontak berhasil diperbarui!';
        
        // Update data kontak untuk ditampilkan
        $contact = getContactById($id);
        
        // Redirect ke index setelah 2 detik
        header('refresh:2;url=index.php');
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kontak - Sistem Manajemen Kontak</title>
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
            <span>Edit Kontak</span>
        </div>
        
        <!-- Form Card -->
        <div class="card">
            <div class="card-header">
                <h2>✏️ Edit Kontak</h2>
                <p>Perbarui informasi kontak: <strong><?= htmlspecialchars($contact['nama']) ?></strong></p>
            </div>
            
            <!-- Alert Messages -->
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
            
            <!-- Form -->
            <form method="POST" class="contact-form">
                <div class="form-row">
                    <div class="form-group">
                        <label>Nama Lengkap <span class="required">*</span></label>
                        <input type="text" name="nama" required 
                               value="<?= isset($_POST['nama']) ? htmlspecialchars($_POST['nama']) : htmlspecialchars($contact['nama']) ?>"
                               placeholder="Contoh: Ahmad Rizki">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Email <span class="required">*</span></label>
                        <input type="email" name="email" required 
                               value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : htmlspecialchars($contact['email']) ?>"
                               placeholder="Contoh: ahmad@email.com">
                        <small class="form-hint">Pastikan format email valid</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Nomor Telepon <span class="required">*</span></label>
                        <input type="text" name="telepon" required 
                               value="<?= isset($_POST['telepon']) ? htmlspecialchars($_POST['telepon']) : htmlspecialchars($contact['telepon']) ?>"
                               placeholder="Contoh: 081234567890">
                        <small class="form-hint">Minimal 8 karakter, gunakan angka saja atau dengan simbol +, -, (), spasi</small>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Alamat</label>
                    <textarea name="alamat" rows="4" 
                              placeholder="Contoh: Jl. Merdeka No. 123, Jakarta Pusat"><?= isset($_POST['alamat']) ? htmlspecialchars($_POST['alamat']) : htmlspecialchars($contact['alamat']) ?></textarea>
                    <small class="form-hint">Opsional - bisa dikosongkan</small>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        💾 Simpan Perubahan
                    </button>
                    <a href="index.php" class="btn btn-secondary">
                        ← Batal
                    </a>
                </div>
            </form>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <p>© 2024 Sistem Manajemen Kontak | Dibuat dengan ❤️</p>
        </div>
    </div>
</body>
</html>