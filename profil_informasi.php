<?php
// profil_informasi.php - Konten untuk tab "Profil Saya"
// File ini akan di-include melalui AJAX, jadi pastikan session sudah dimulai di profil.php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user'])) {
    // Ini seharusnya tidak terjadi jika profil.php sudah memeriksa login
    echo "<p style='text-align: center; color: #dc3545;'>Anda harus login untuk melihat halaman ini.</p>";
    exit();
}

$user_data = $_SESSION['user']; // Gunakan data dari sesi
?>
<h3 class="section-title">Informasi Profil</h3>
<form class="profile-form" id="profileForm">
    <input type="hidden" name="action" value="update_profile">
    <div class="form-row">
        <div class="form-group">
            <label for="firstName">Nama Depan</label>
            <input type="text" id="firstName" name="nama_depan" value="<?php echo htmlspecialchars($user_data['nama_depan']); ?>" required>
        </div>
        <div class="form-group">
            <label for="lastName">Nama Belakang</label>
            <input type="text" id="lastName" name="nama_belakang" value="<?php echo htmlspecialchars($user_data['nama_belakang'] ?? ''); ?>">
        </div>
    </div>
    
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user_data['username'] ?? ''); ?>" readonly>
    </div>
    
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user_data['email']); ?>" required>
    </div>
    
    <div class="form-group">
        <label for="phone">Nomor Telepon</label>
        <input type="tel" id="phone" name="no_tlp" value="<?php echo htmlspecialchars($user_data['no_tlp'] ?? ''); ?>">
    </div>
    
    <div class="form-group">
        <label for="bio">Tentang Saya</label>
        <textarea id="bio" name="deskripsi"><?php echo htmlspecialchars($user_data['deskripsi'] ?? ''); ?></textarea>
    </div>
    
    <div class="form-actions">
        <button type="reset" class="btn btn-secondary">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </div>
</form>