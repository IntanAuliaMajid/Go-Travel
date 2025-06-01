<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Profil Pengguna | Wisata Indonesia</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #4E71FF;
      color: #333;
      line-height: 1.6;
    }

    /* Header */
    .profile-header {
      background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), 
                  url('https://images.unsplash.com/photo-1517842645767-c639042777db?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80') no-repeat center center/cover;
      height: 300px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      color: #fff;
      position: relative;
    }

    .profile-header-content {
      position: relative;
      z-index: 2;
    }

    .profile-header h1 {
      font-size: 2.5rem;
      margin-bottom: 0.5rem;
      text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);
    }

    .profile-header p {
      font-size: 1.1rem;
      opacity: 0.9;
    }

    /* Breadcrumb */
    .breadcrumb {
      padding: 1rem;
      background-color: #fff;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    /* Container */
    .container {
      margin-top: 100px;
      max-width: 100%;
      padding: 0 20px;
      display: grid;
      grid-template-columns: 300px 1fr;
    }

    @media (max-width: 992px) {
      .container {
        grid-template-columns: 1fr;
      }
    }

    /* Sidebar Profil */
    .profile-sidebar {
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      padding: 2rem;
      height: fit-content;
    }

    .profile-avatar-container {
      position: relative;
      width: 150px;
      height: 150px;
      margin: 0 auto 1.5rem;
      display: block;
    }

    .profile-avatar {
      width: 100%;
      height: 100%;
      border-radius: 50%;
      object-fit: cover;
      border: 5px solid #eef7ed;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .profile-avatar:hover {
      opacity: 0.8;
    }

    .avatar-upload-overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      opacity: 0;
      transition: opacity 0.3s ease;
      cursor: pointer;
    }

    .avatar-upload-overlay:hover {
      opacity: 1;
    }

    .avatar-upload-overlay i {
      color: white;
      font-size: 1.5rem;
    }

    .avatar-upload-btn {
      position: absolute;
      bottom: 5px;
      right: 5px;
      width: 40px;
      height: 40px;
      background: #2c7a51;
      border: 3px solid #fff;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    }

    .avatar-upload-btn:hover {
      background: #1d5b3a;
      transform: scale(1.1);
    }

    .avatar-upload-btn i {
      color: white;
      font-size: 0.9rem;
    }

    #avatarInput {
      display: none;
    }

    .profile-name {
      text-align: center;
      font-size: 1.5rem;
      margin-bottom: 0.5rem;
      color: #2c7a51;
    }

    .profile-username {
      text-align: center;
      color: #666;
      margin-bottom: 1.5rem;
      font-size: 0.9rem;
    }

    .profile-stats {
      display: flex;
      justify-content: space-around;
      margin-bottom: 2rem;
      text-align: center;
    }

    .stat-item {
      padding: 0.5rem;
    }

    .stat-number {
      font-size: 1.2rem;
      font-weight: bold;
      color: #2c7a51;
    }

    .stat-label {
      font-size: 0.8rem;
      color: #666;
    }

    .profile-menu {
      list-style: none;
      margin-top: 2rem;
    }

    .profile-menu li {
      margin-bottom: 0.5rem;
    }

    .profile-menu a {
      display: block;
      padding: 0.75rem 1rem;
      color: #333;
      text-decoration: none;
      border-radius: 5px;
      transition: all 0.3s;
    }

    .profile-menu a:hover, .profile-menu a.active {
      background-color: #eef7ed;
      color: #2c7a51;
    }

    .profile-menu a i {
      margin-right: 0.5rem;
      width: 20px;
      text-align: center;
    }

    /* Main Content */
    .profile-content {
      margin-left: 20px;
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      padding: 2rem;
    }

    .section-title {
      font-size: 1.5rem;
      margin-bottom: 1.5rem;
      color: #2c7a51;
      padding-bottom: 0.5rem;
      border-bottom: 2px solid #eef7ed;
    }

    /* Form Profil */
    .profile-form .form-group {
      margin-bottom: 1.5rem;
    }

    .profile-form label {
      display: block;
      margin-bottom: 0.5rem;
      font-weight: 500;
    }

    .profile-form input, 
    .profile-form select, 
    .profile-form textarea {
      width: 100%;
      padding: 0.75rem 1rem;
      border: 1px solid #ddd;
      border-radius: 5px;
      font-family: inherit;
      font-size: 1rem;
    }

    .profile-form textarea {
      min-height: 100px;
      resize: vertical;
    }

    .form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 1.5rem;
    }

    @media (max-width: 768px) {
      .form-row {
        grid-template-columns: 1fr;
      }
    }

    .form-actions {
      display: flex;
      justify-content: flex-end;
      margin-top: 2rem;
    }

    .btn {
      padding: 0.75rem 1.5rem;
      border-radius: 5px;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.3s;
      border: none;
      font-size: 1rem;
    }

    .btn-primary {
      background-color: #2c7a51;
      color: white;
    }

    .btn-primary:hover {
      background-color: #1d5b3a;
    }

    .btn-secondary {
      background-color: #f0f0f0;
      color: #333;
      margin-right: 1rem;
    }

    .btn-secondary:hover {
      background-color: #e0e0e0;
    }

    /* Tab Content */
    .tab-content {
      display: none;
    }

    .tab-content.active {
      display: block;
    }

    /* Riwayat Booking */
    .booking-item {
      border-bottom: 1px solid #eee;
      padding: 1.5rem 0;
      display: grid;
      grid-template-columns: 100px 1fr;
      gap: 1.5rem;
    }

    .booking-item:last-child {
      border-bottom: none;
    }

    .booking-image {
      width: 100px;
      height: 80px;
      border-radius: 5px;
      object-fit: cover;
    }

    .booking-details h4 {
      margin-bottom: 0.5rem;
      color: #2c7a51;
    }

    .booking-meta {
      display: flex;
      flex-wrap: wrap;
      gap: 1rem;
      margin-bottom: 0.5rem;
      font-size: 0.9rem;
      color: #666;
    }

    .booking-meta span {
      display: flex;
      align-items: center;
    }

    .booking-meta i {
      margin-right: 0.3rem;
    }

    .booking-status {
      display: inline-block;
      padding: 0.25rem 0.75rem;
      border-radius: 50px;
      font-size: 0.8rem;
      font-weight: 500;
      margin-top: 0.5rem;
    }

    .status-pending {
      background-color: #fff3cd;
      color: #856404;
    }

    .status-confirmed {
      background-color: #d4edda;
      color: #155724;
    }

    .status-cancelled {
      background-color: #f8d7da;
      color: #721c24;
    }

    .status-completed {
      background-color: #d1ecf1;
      color: #0c5460;
    }

    /* Wishlist Item */
    .wishlist-item {
      display: grid;
      grid-template-columns: 100px 1fr auto;
      gap: 1.5rem;
      align-items: center;
      padding: 1.5rem 0;
      border-bottom: 1px solid #eee;
    }

    .wishlist-item:last-child {
      border-bottom: none;
    }

    .wishlist-image {
      width: 100px;
      height: 80px;
      border-radius: 5px;
      object-fit: cover;
    }

    .wishlist-details h4 {
      margin-bottom: 0.5rem;
      color: #2c7a51;
    }

    .wishlist-location {
      display: flex;
      align-items: center;
      color: #666;
      font-size: 0.9rem;
    }

    .wishlist-location i {
      margin-right: 0.5rem;
    }

    .wishlist-actions {
      display: flex;
      gap: 0.5rem;
    }

    .wishlist-btn {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      border: none;
      cursor: pointer;
      transition: all 0.3s;
    }

    .wishlist-btn i {
      font-size: 1rem;
    }

    .btn-remove {
      background-color: #f8d7da;
      color: #721c24;
    }

    .btn-remove:hover {
      background-color: #f5c6cb;
    }

    .btn-view {
      background-color: #d4edda;
      color: #155724;
    }

    .btn-view:hover {
      background-color: #c3e6cb;
    }

    /* Photo Upload Modal */
    .photo-modal {
      display: none;
      position: fixed;
      z-index: 1000;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      backdrop-filter: blur(5px);
      overflow-y: auto; /* scroll jika terlalu tinggi */

    }

    .photo-modal-content {
      background-color: #fff;
      margin: 10% auto;
      padding: 2rem;
      border-radius: 10px;
      width: 90%;
      max-width: 600px;
      text-align: center;
      position: relative;
      overflow-y: auto; /* scroll isi jika melebihi tinggi layar */
    }

    /* Cegah scroll di body */
    .body-no-scroll {
      overflow: hidden;
    }

    .photo-modal-close {
      position: absolute;
      right: 1rem;
      top: 1rem;
      font-size: 1.5rem;
      cursor: pointer;
      color: #666;
    }

    .photo-preview {
      width: 200px;
      height: 200px;
      border-radius: 50%;
      object-fit: cover;
      border: 3px solid #eef7ed;
      margin: 1rem auto;
      display: block;
    }

    .photo-upload-area {
      border: 2px dashed #ddd;
      border-radius: 10px;
      padding: 2rem;
      margin: 1rem 0;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .photo-upload-area:hover {
      border-color: #2c7a51;
      background-color: #f9f9f9;
    }

    .photo-upload-area.dragover {
      border-color: #2c7a51;
      background-color: #eef7ed;
    }

    .upload-icon {
      font-size: 3rem;
      color: #ddd;
      margin-bottom: 1rem;
    }

    .upload-text {
      color: #666;
      margin-bottom: 0.5rem;
    }

    .upload-hint {
      font-size: 0.9rem;
      color: #999;
    }

    /* Loading Animation */
    .loading {
      display: inline-block;
      width: 20px;
      height: 20px;
      border: 3px solid #f3f3f3;
      border-top: 3px solid #2c7a51;
      border-radius: 50%;
      animation: spin 1s linear infinite;
      margin-right: 0.5rem;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    /* Responsive */
    @media (max-width: 768px) {
      .profile-header h1 {
        font-size: 2rem;
      }

      .booking-item, .wishlist-item {
        grid-template-columns: 1fr;
      }

      .booking-image, .wishlist-image {
        width: 100%;
        height: 150px;
      }

      .wishlist-actions {
        justify-content: flex-end;
        margin-top: 1rem;
      }

      .photo-modal-content {
        margin: 5% auto;
        width: 95%;
      }
    }

    /* Notification Styles */
    .notification {
      position: fixed;
      bottom: 20px;
      right: 20px;
      padding: 15px 25px;
      border-radius: 5px;
      color: white;
      font-weight: bold;
      transform: translateY(100px);
      opacity: 0;
      transition: all 0.3s ease;
      z-index: 1000;
    }
    
    .notification.show {
      transform: translateY(0);
      opacity: 1;
    }
    
    .notification.success {
      background-color: #2c7a51;
    }
    
    .notification.error {
      background-color: #dc3545;
    }

    .notification.info {
      background-color: #17a2b8;
    }
  </style>
</head>
<body>
  <?php include 'Komponen/navbar.php'; ?>
  <!-- Profile Content -->
  <div class="container">
    <!-- Sidebar Profil -->
    <div class="profile-sidebar">
      <div class="profile-avatar-container">
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR8EFdqWXeeEQTETKt5_G2XHVLhWH6CtI9ohw&s" alt="Profil Pengguna" class="profile-avatar" id="profileAvatar">
        <div class="avatar-upload-overlay" onclick="openPhotoModal()">
          <i class="fas fa-camera"></i>
        </div>
        <div class="avatar-upload-btn" onclick="openPhotoModal()">
          <i class="fas fa-edit"></i>
        </div>
      </div>
      <input type="file" id="avatarInput" accept="image/*" style="display: none;">
      
      <h2 class="profile-name">Intan Aulia Majid</h2>
      <p class="profile-username">@intanauliamajid</p>
      
      <div class="profile-stats">
        <div class="stat-item">
          <div class="stat-number">12</div>
          <div class="stat-label">Kunjungan</div>
        </div>
        <div class="stat-item">
          <div class="stat-number">8</div>
          <div class="stat-label">Wishlist</div>
        </div>
        <div class="stat-item">
          <div class="stat-number">5</div>
          <div class="stat-label">Ulasan</div>
        </div>
      </div>

      <ul class="profile-menu">
        <li><a href="#" class="active" data-tab="profile"><i class="fas fa-user"></i> Profil Saya</a></li>
        <li><a href="#" data-tab="bookings"><i class="fas fa-calendar-alt"></i> Riwayat Pemesanan</a></li>
        <li><a href="wishlist_page.php" data-tab="wishlist"><i class="fas fa-heart"></i> Wishlist</a></li>
        <li><a href="#" data-tab="reviews"><i class="fas fa-star"></i> Ulasan Saya</a></li>
        <li><a href="#" data-tab="settings"><i class="fas fa-cog"></i> Pengaturan</a></li>
        <li><a href="#"><i class="fas fa-sign-out-alt"></i> Keluar</a></li>
      </ul>
    </div>

    <!-- Main Content -->
    <div class="profile-content">
      <!-- Tab Profil -->
      <div id="profile" class="tab-content active">
        <h3 class="section-title">Informasi Profil</h3>
        <form class="profile-form">
          <div class="form-row">
            <div class="form-group">
              <label for="firstName">Nama Depan</label>
              <input type="text" id="firstName" value="Intan Aulia">
            </div>
            <div class="form-group">
              <label for="lastName">Nama Belakang</label>
              <input type="text" id="lastName" value="Majid">
            </div>
          </div>
          
          <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" value="intanauliamajid" readonly>
          </div>
          
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" value="intanauliamajid@gmail.com">
          </div>
          
          <div class="form-group">
            <label for="phone">Nomor Telepon</label>
            <input type="tel" id="phone" value="+6281234567890">
          </div>
          
          <div class="form-group">
            <label for="bio">Tentang Saya</label>
            <textarea id="bio">Saya seorang pecinta wisata alam dan budaya. Senang menjelajahi tempat-tempat baru di Indonesia.</textarea>
          </div>
          
          <div class="form-actions">
            <button type="button" class="btn btn-secondary">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
          </div>
        </form>
      </div>

      <!-- Tab Riwayat Booking -->
      <div id="bookings" class="tab-content">
        <h3 class="section-title">Riwayat Booking</h3>
        
        <div class="booking-item">
          <img src="https://salsawisata.com/wp-content/uploads/2022/07/Wisata-Bahari-Lamongan.jpg" alt="Wisata Bahari Lamongan" class="booking-image">
          <div class="booking-details">
            <h4>Wisata Bahari Lamongan</h4>
            <div class="booking-meta">
              <span><i class="fas fa-calendar-alt"></i> 22 Juni 2024</span>
              <span><i class="fas fa-user"></i> 1 Dewasa</span>
              <span><i class="fas fa-tag"></i> Rp1.750.000</span>
            </div>
            <span class="booking-status status-completed">Selesai</span>
          </div>
        </div>
      </div>

      <!-- Tab Wishlist -->
      <div id="wishlist" class="tab-content">
        <h3 class="section-title">Destinasi Wishlist</h3>
        
        <div class="wishlist-item">
          <img src="https://www.nativeindonesia.com/foto/2024/07/sunset-di-pantai-lorena.jpg" alt="Pantai Lorena" class="wishlist-image">
          <div class="wishlist-details">
            <h4>Pantai Lorena</h4>
            <div class="wishlist-location">
              <i class="fas fa-map-marker-alt"></i> Lamongan, Jawa Timur
            </div>
          </div>
          <div class="wishlist-actions">
            <a href="wisata_detail.php" style="text-decoration: none;" class="wishlist-btn btn-view" title="Lihat Detail">
              <i class="fas fa-eye"></i>
            </a>
            <button class="wishlist-btn btn-remove" title="Hapus dari Wishlist">
              <i class="fas fa-trash-alt"></i>
            </button>
          </div>
        </div>
        
        <div class="wishlist-item">
          <img src="https://salsawisata.com/wp-content/uploads/2022/07/Indonesian-Islamic-Art-Museum.jpg" alt="Museum Islam" class="wishlist-image">
          <div class="wishlist-details">
            <h4>Indonesian Islamic Art Museum</h4>
            <div class="wishlist-location">
              <i class="fas fa-map-marker-alt"></i> Lamongan, Jawa Timur
            </div>
          </div>
          <div class="wishlist-actions">
            <a href="wisata_detail.php" style="text-decoration: none;" class="wishlist-btn btn-view" title="Lihat Detail">
              <i class="fas fa-eye"></i>
            </a>
            <button class="wishlist-btn btn-remove" title="Hapus dari Wishlist">
              <i class="fas fa-trash-alt"></i>
            </button>
          </div>
        </div>
        
        <div class="wishlist-item">
          <img src="https://anekatempatwisata.com/wp-content/uploads/2018/04/Museum-Nasional-Indonesia-610x610.jpg" alt="Museum Nasional" class="wishlist-image">
          <div class="wishlist-details">
            <h4>Museum Nasional Indonesia</h4>
            <div class="wishlist-location">
              <i class="fas fa-map-marker-alt"></i> Jakarta
            </div>
          </div>
          <div class="wishlist-actions">
            <a href="wisata_detail.php" style="text-decoration: none;" class="wishlist-btn btn-view" title="Lihat Detail">
              <i class="fas fa-eye"></i>
            </a>
            <button class="wishlist-btn btn-remove" title="Hapus dari Wishlist">
              <i class="fas fa-trash-alt"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Tab Ulasan -->
      <div id="reviews" class="tab-content">
        <h3 class="section-title">Ulasan Saya</h3>
        <p style="text-align: center; color: #666; margin-top: 2rem;">Belum ada ulasan</p>
      </div>

      <!-- Tab Pengaturan -->
      <div id="settings" class="tab-content">
        <h3 class="section-title">Pengaturan Akun</h3>
        <form class="profile-form">
          <div class="form-group">
            <label for="currentPassword">Password Saat Ini</label>
            <input type="password" id="currentPassword">
          </div>
          
          <div class="form-group">
            <label for="newPassword">Password Baru</label>
            <input type="password" id="newPassword">
          </div>
          
          <div class="form-group">
            <label for="confirmPassword">Konfirmasi Password Baru</label>
            <input type="password" id="confirmPassword">
          </div>
          
          <div class="form-group">
            <label>
              <input type="checkbox" checked style="width:20px;"> Terima notifikasi email
            </label>
          </div>
          
          <div class="form-actions">
            <button type="button" class="btn btn-secondary">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Photo Upload Modal -->
  <div id="photoModal" class="photo-modal">
    <div class="photo-modal-content">
      <span class="photo-modal-close" onclick="closePhotoModal()">&times;</span>
      <h3 style="margin-bottom: 1rem; color: #2c7a51;">Ubah Foto Profil</h3>
      
      <img id="photoPreview" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR8EFdqWXeeEQTETKt5_G2XHVLhWH6CtI9ohw&s" alt="Preview" class="photo-preview">
      
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
        <button type="button" class="btn btn-primary" id="savePhotoBtn" onclick="savePhoto()">
          <span id="saveText">Simpan Foto</span>
          <span id="loadingSpinner" class="loading" style="display: none;"></span>
        </button>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Tab Navigation
      const tabLinks = document.querySelectorAll('.profile-menu a');
      
      tabLinks.forEach(link => {
        link.addEventListener('click', function(e) {
          e.preventDefault();
          
          // Remove active class from all links and tabs
          tabLinks.forEach(l => l.classList.remove('active'));
          document.querySelectorAll('.tab-content').forEach(tab => {
            tab.classList.remove('active');
          });
          
          // Add active class to clicked link
          this.classList.add('active');
          
          // Show corresponding tab
          const tabId = this.getAttribute('data-tab');
          if (tabId) {
            document.getElementById(tabId).classList.add('active');
          }
        });
      });
      
      // Wishlist Remove Button
      const removeButtons = document.querySelectorAll('.btn-remove');
      removeButtons.forEach(button => {
        button.addEventListener('click', function() {
          const wishlistItem = this.closest('.wishlist-item');
          if (confirm('Apakah Anda yakin ingin menghapus dari wishlist?')) {
            wishlistItem.style.opacity = '0';
            setTimeout(() => {
              wishlistItem.remove();
              showNotification('Destinasi dihapus dari wishlist');
            }, 300);
          }
        });
      });

      // Photo Upload Functionality
      setupPhotoUpload();
      
      // Notification Function
      function showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.textContent = message;
        document.body.appendChild(notification);
        
        setTimeout(() => {
          notification.classList.add('show');
        }, 10);
        
        setTimeout(() => {
          notification.classList.remove('show');
          setTimeout(() => {
            document.body.removeChild(notification);
          }, 300);
        }, 3000);
      }
    });

    // Photo Upload Functions
    function setupPhotoUpload() {
      const modalFileInput = document.getElementById('modalFileInput');
      const photoPreview = document.getElementById('photoPreview');
      const uploadArea = document.querySelector('.photo-upload-area');
      
      // File input change event
      modalFileInput.addEventListener('change', function(e) {
        handleFileSelect(e.target.files[0]);
      });
      
      // Drag and drop functionality
      uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        uploadArea.classList.add('dragover');
      });
      
      uploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        uploadArea.classList.remove('dragover');
      });
      
      uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        uploadArea.classList.remove('dragover');
        const files = e.dataTransfer.files;
        if (files.length > 0) {
          handleFileSelect(files[0]);
        }
      });
    }

    function handleFileSelect(file) {
      if (!file) return;
      
      // Validate file type
      const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
      if (!allowedTypes.includes(file.type)) {
        showNotification('Format file tidak didukung. Gunakan JPG, PNG, atau GIF.', 'error');
        return;
      }
      
      // Validate file size (max 5MB)
      const maxSize = 5 * 1024 * 1024; // 5MB in bytes
      if (file.size > maxSize) {
        showNotification('Ukuran file terlalu besar. Maksimal 5MB.', 'error');
        return;
      }
      
      // Create FileReader to preview image
      const reader = new FileReader();
      reader.onload = function(e) {
        document.getElementById('photoPreview').src = e.target.result;
        showNotification('Foto berhasil dipilih. Klik "Simpan Foto" untuk menyimpan.', 'info');
      };
      reader.readAsDataURL(file);
    }

    function openPhotoModal() {
      const modal = document.getElementById('photoModal');
      const currentAvatar = document.getElementById('profileAvatar').src;
      document.getElementById('photoPreview').src = currentAvatar;
      modal.style.display = 'block';
      document.body.classList.add('body-no-scroll'); // tambahkan ini
    }

    function closePhotoModal() {
      const modal = document.getElementById('photoModal');
      modal.style.display = 'none';
      // Reset file input
      document.getElementById('modalFileInput').value = '';
      document.body.classList.remove('body-no-scroll'); // hapus ini
    }

    function savePhoto() {
      const saveBtn = document.getElementById('savePhotoBtn');
      const saveText = document.getElementById('saveText');
      const loadingSpinner = document.getElementById('loadingSpinner');
      const photoPreview = document.getElementById('photoPreview');
      const profileAvatar = document.getElementById('profileAvatar');
      
      // Show loading state
      saveText.style.display = 'none';
      loadingSpinner.style.display = 'inline-block';
      saveBtn.disabled = true;
      
      // Simulate upload process (replace with actual upload logic)
      setTimeout(() => {
        // Update profile avatar with new photo
        profileAvatar.src = photoPreview.src;
        
        // Hide loading state
        saveText.style.display = 'inline';
        loadingSpinner.style.display = 'none';
        saveBtn.disabled = false;
        
        // Close modal and show success message
        closePhotoModal();
        showNotification('Foto profil berhasil diperbarui!', 'success');
        
        // Here you would normally send the photo to your server
        // Example AJAX call:
        /*
        const formData = new FormData();
        const fileInput = document.getElementById('modalFileInput');
        if (fileInput.files[0]) {
          formData.append('profile_photo', fileInput.files[0]);
          
          fetch('upload_profile_photo.php', {
            method: 'POST',
            body: formData
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              profileAvatar.src = data.photo_url;
              closePhotoModal();
              showNotification('Foto profil berhasil diperbarui!', 'success');
            } else {
              showNotification('Gagal mengupload foto: ' + data.message, 'error');
            }
          })
          .catch(error => {
            showNotification('Terjadi kesalahan saat mengupload foto.', 'error');
          });
        }
        */
      }, 2000); // Simulate 2 second upload time
    }

    // Close modal when clicking outside
    window.addEventListener('click', function(e) {
      const modal = document.getElementById('photoModal');
      if (e.target === modal) {
        closePhotoModal();
      }
    });

    // Notification Function (moved outside DOMContentLoaded for global access)
    function showNotification(message, type = 'success') {
      const notification = document.createElement('div');
      notification.className = `notification ${type}`;
      notification.textContent = message;
      document.body.appendChild(notification);
      
      setTimeout(() => {
        notification.classList.add('show');
      }, 10);
      
      setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => {
          if (document.body.contains(notification)) {
            document.body.removeChild(notification);
          }
        }, 300);
      }, 3000);
    }

    </script>

</body>