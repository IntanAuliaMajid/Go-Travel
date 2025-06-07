<?php
// profil_pengaturan.php - Konten untuk tab "Pengaturan Akun"
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<h3 class="section-title">Pengaturan Akun</h3>
<form class="profile-form" id="passwordForm">
    <input type="hidden" name="action" value="update_password">
    <div class="form-group">
        <label for="currentPassword">Password Saat Ini</label>
        <input type="password" id="currentPassword" name="current_password" required>
    </div>
    
    <div class="form-group">
        <label for="newPassword">Password Baru</label>
        <input type="password" id="newPassword" name="new_password" required>
    </div>
    
    <div class="form-group">
        <label for="confirmPassword">Konfirmasi Password Baru</label>
        <input type="password" id="confirmPassword" name="confirm_password" required>
    </div>
    
    <div class="form-group">
        <label>
            <input type="checkbox" checked style="width:20px;"> Terima notifikasi email
        </label>
    </div>
    
    <div class="form-actions">
        <button type="reset" class="btn btn-secondary">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
    </div>
</form>