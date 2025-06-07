<?php
// modals/avatar_modal.php - Modal untuk upload foto profil
// Pastikan variabel $avatar_display_url sudah didefinisikan di profil.php
if (!isset($avatar_display_url)) {
    $avatar_display_url = './uploads/avatars/default_avatar.png';
}
?>
<div id="photoModal" class="photo-modal">
    <div class="photo-modal-content">
        <span class="photo-modal-close" onclick="closePhotoModal()">&times;</span>
        <h3 style="margin-bottom: 1rem; color: #2c7a51;">Ubah Foto Profil</h3>
        
        <img id="photoPreview" src="<?php echo $avatar_display_url; ?>" alt="Preview" class="photo-preview">
        
        <div class="photo-upload-area" onclick="document.getElementById('modalFileInput').click()">
            <div class="upload-icon">
                <i class="fas fa-cloud-upload-alt"></i>
            </div>
            <div class="upload-text">Klik atau seret foto ke sini</div>
            <div class="upload-hint">Format: JPG, PNG, GIF (Maks. 5MB)</div>
        </div>
        
        <input type="file" id="modalFileInput" accept="image/*" style="display: none;">
        
        <div style="margin-top: 1.5rem;">
            <button type="button" class="btn btn-secondary" onclick="closePhotoModal()">Batal</button>
            <button type="button" class="btn btn-primary" id="savePhotoBtn">
                <span id="saveText">Simpan Foto</span>
                <span id="loadingSpinner" class="loading" style="display: none;"></span>
            </button>
        </div>
    </div>
</div>