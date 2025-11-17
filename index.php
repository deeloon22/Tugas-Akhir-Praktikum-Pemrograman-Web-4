<?php
// index.php - Halaman utama
require_once 'config.php';

// [PERBAIKAN] Tambahkan ini agar yang belum login ditendang ke halaman login
requireLogin(); 

// Ambil keyword pencarian
$search = $_GET['search'] ?? '';
$contacts = searchContacts($search);
$totalContacts = count(getContacts());
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Kontak</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="header-content">
                <h1>📇 Sistem Manajemen Kontak</h1>
                <p class="header-subtitle">Kelola kontak Anda dengan mudah dan praktis</p>
            </div>
            <div style="margin-top: 15px;">
                <small>Login sebagai: <strong><?= htmlspecialchars($_SESSION['username'] ?? 'User') ?></strong></small>
                <span style="margin: 0 10px;">|</span>
                <a href="logout.php" style="color: #ef476f; text-decoration: none; font-weight: bold;">Logout ➔</a>
            </div>
        </div>
        
        <div class="stats-card">
            <div class="stat-item">
                <div class="stat-icon">📊</div>
                <div class="stat-info">
                    <h3><?= $totalContacts ?></h3>
                    <p>Total Kontak</p>
                </div>
            </div>
            <div class="stat-item">
                <a href="add_contact.php" class="btn btn-primary">
                    ➕ Tambah Kontak Baru
                </a>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h2>📋 Daftar Kontak</h2>
            </div>
            
            <div class="search-box">
                <form method="GET" action="">
                    <input type="text" name="search" placeholder="Cari kontak berdasarkan nama, email, atau telepon..." 
                           value="<?= htmlspecialchars($search) ?>">
                </form>
                <?php if ($search): ?>
                    <div class="search-result">
                        Ditemukan <strong><?= count($contacts) ?></strong> kontak untuk kata kunci "<strong><?= htmlspecialchars($search) ?></strong>"
                        <a href="index.php" class="btn-link">✖ Clear</a>
                    </div>
                <?php endif; ?>
            </div>
            
            <?php if (empty($contacts)): ?>
                <div class="empty-state">
                    <div style="font-size: 60px; margin-bottom: 20px;">📭</div>
                    <h3><?= $search ? 'Tidak ada hasil' : 'Belum ada kontak' ?></h3>
                    <p>
                        <?= $search ? 'Coba kata kunci lain atau hapus filter pencarian' : 'Mulai tambahkan kontak baru dengan klik tombol di atas' ?>
                    </p>
                    <?php if (!$search): ?>
                        <a href="add_contact.php" class="btn btn-primary">➕ Tambah Kontak Pertama</a>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <div class="contacts-grid">
                    <?php foreach ($contacts as $contact): ?>
                        <div class="contact-item">
                            <div class="contact-header">
                                <h3><?= htmlspecialchars($contact['nama']) ?></h3>
                            </div>
                            <div class="contact-body">
                                <p>
                                    <span class="icon">📧</span>
                                    <strong>Email:</strong><br>
                                    <?= htmlspecialchars($contact['email']) ?>
                                </p>
                                <p>
                                    <span class="icon">📱</span>
                                    <strong>Telepon:</strong><br>
                                    <?= htmlspecialchars($contact['telepon']) ?>
                                </p>
                                <?php if (!empty($contact['alamat'])): ?>
                                    <p>
                                        <span class="icon">📍</span>
                                        <strong>Alamat:</strong><br>
                                        <?= nl2br(htmlspecialchars($contact['alamat'])) ?>
                                    </p>
                                <?php endif; ?>
                                <p class="contact-date">
                                    <small>📅 Ditambahkan: <?= date('d/m/Y H:i', strtotime($contact['created_at'])) ?></small>
                                </p>
                            </div>
                            <div class="contact-actions">
                                <a href="edit_contact.php?id=<?= $contact['id'] ?>" class="btn btn-secondary">
                                    ✏️ Edit
                                </a>
                                <a href="delete_contact.php?id=<?= $contact['id'] ?>" class="btn btn-danger" 
                                   onclick="return confirm('⚠️ Yakin ingin menghapus kontak \'<?= htmlspecialchars($contact['nama']) ?>\'?')">
                                    🗑️ Hapus
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="footer">
            <p>© 2024 Sistem Manajemen Kontak | Dibuat dengan ❤️</p>
        </div>
    </div>
</body>
</html>