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
      max-width: 1200px;
      padding: 0 1rem;
      display: grid;
      grid-template-columns: 300px 1fr;
      gap: 2rem;
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

    .profile-avatar {
      width: 150px;
      height: 150px;
      border-radius: 50%;
      object-fit: cover;
      border: 5px solid #eef7ed;
      margin: 0 auto 1.5rem;
      display: block;
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
    }
  </style>
</head>
<body>
  <?php include 'Komponen/navbar.php'; ?>

  <!-- Profile Content -->
  <div class="container">
    <!-- Sidebar Profil -->
    <div class="profile-sidebar">
      <img src="https://randomuser.me/api/portraits/women/65.jpg" alt="Profil Pengguna" class="profile-avatar">
      <h2 class="profile-name">Sarah Johnson</h2>
      <p class="profile-username">@sarahjohnson</p>
      
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
        <li><a href="#" data-tab="bookings"><i class="fas fa-calendar-alt"></i> Riwayat Booking</a></li>
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
              <input type="text" id="firstName" value="Sarah">
            </div>
            <div class="form-group">
              <label for="lastName">Nama Belakang</label>
              <input type="text" id="lastName" value="Johnson">
            </div>
          </div>
          
          <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" value="sarahjohnson">
          </div>
          
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" value="sarah.johnson@example.com">
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
          <img src="https://www.nativeindonesia.com/foto/2024/07/pantai-tanjung-kodok-1.jpg" alt="Pantai Tanjung Kodok" class="booking-image">
          <div class="booking-details">
            <h4>Pantai Tanjung Kodok</h4>
            <div class="booking-meta">
              <span><i class="fas fa-calendar-alt"></i> 15 Juli 2024</span>
              <span><i class="fas fa-users"></i> 2 Dewasa</span>
              <span><i class="fas fa-tag"></i> Rp100.000</span>
            </div>
            <span class="booking-status status-confirmed">Terkonfirmasi</span>
          </div>
        </div>
        
        <div class="booking-item">
          <img src="https://salsawisata.com/wp-content/uploads/2022/07/Wisata-Bahari-Lamongan.jpg" alt="Wisata Bahari Lamongan" class="booking-image">
          <div class="booking-details">
            <h4>Wisata Bahari Lamongan</h4>
            <div class="booking-meta">
              <span><i class="fas fa-calendar-alt"></i> 22 Juni 2024</span>
              <span><i class="fas fa-users"></i> 4 Dewasa, 2 Anak</span>
              <span><i class="fas fa-tag"></i> Rp350.000</span>
            </div>
            <span class="booking-status status-completed">Selesai</span>
          </div>
        </div>
        
        <div class="booking-item">
          <img src="https://anekatempatwisata.com/wp-content/uploads/2018/04/Taman-Mini-Indonesia-Indah-610x407.jpg" alt="TMII" class="booking-image">
          <div class="booking-details">
            <h4>Taman Mini Indonesia Indah</h4>
            <div class="booking-meta">
              <span><i class="fas fa-calendar-alt"></i> 5 Mei 2024</span>
              <span><i class="fas fa-users"></i> 3 Dewasa</span>
              <span><i class="fas fa-tag"></i> Rp75.000</span>
            </div>
            <span class="booking-status status-cancelled">Dibatalkan</span>
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
            <button class="wishlist-btn btn-view" title="Lihat Detail">
              <i class="fas fa-eye"></i>
            </button>
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
            <button class="wishlist-btn btn-view" title="Lihat Detail">
              <i class="fas fa-eye"></i>
            </button>
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
            <button class="wishlist-btn btn-view" title="Lihat Detail">
              <i class="fas fa-eye"></i>
            </button>
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
              <input type="checkbox" checked> Terima notifikasi email
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

  <?php include 'Komponen/footer.php'; ?>

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
          document.getElementById(tabId).classList.add('active');
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
  </script>

  <style>
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
  </style>
</body>
</html>