<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<style>
.sidebar {
  width: 240px;
  height: 100vh;
  background: linear-gradient(180deg, #1a2a3a, #2c3e50);
  color: #ecf0f1;
  padding: 0;
  box-sizing: border-box;
  position: fixed;
  top: 0;
  left: 0;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  display: flex;
  flex-direction: column;
  box-shadow: 5px 0 15px rgba(0, 0, 0, 0.2);
  z-index: 1000;
}

.sidebar-header {
  padding: 25px 15px 20px;
  border-bottom: 1px solid rgba(255, 255, 255, 0.1);
  flex-shrink: 0; /* Mencegah header menyusut */
}

.sidebar h2 {
  margin: 0;
  font-size: 24px;
  font-weight: 700;
  text-align: center;
  color: #fff;
  text-shadow: 0 1px 3px rgba(0,0,0,0.3);
}

.sidebar-content {
  flex: 1;
  overflow-y: auto; /* Membuat area ini bisa di-scroll */
  overflow-x: hidden;
  padding: 15px;
}

/* Custom scrollbar untuk webkit browsers */
.sidebar-content::-webkit-scrollbar {
  width: 6px;
}

.sidebar-content::-webkit-scrollbar-track {
  background: rgba(255, 255, 255, 0.1);
  border-radius: 3px;
}

.sidebar-content::-webkit-scrollbar-thumb {
  background: rgba(255, 255, 255, 0.3);
  border-radius: 3px;
}

.sidebar-content::-webkit-scrollbar-thumb:hover {
  background: rgba(255, 255, 255, 0.5);
}

.sidebar nav ul {
  list-style: none;
  padding: 0;
  margin: 0;
}

.sidebar nav ul li {
  margin-bottom: 8px;
}

.sidebar nav ul li a {
  color: #ecf0f1;
  text-decoration: none;
  font-size: 15px;
  display: block;
  padding: 12px 18px;
  border-radius: 8px;
  transition: all 0.35s ease;
  background: rgba(255, 255, 255, 0.05);
  border-left: 3px solid transparent;
  box-shadow: 0 2px 5px rgba(0,0,0,0.05);
  white-space: nowrap; /* Mencegah teks terpotong */
}

.sidebar nav ul li a:hover {
  background: rgba(255, 255, 255, 0.15);
  transform: translateX(5px);
  border-left: 3px solid #16a085;
}

.sidebar nav ul li a.active {
  background: linear-gradient(90deg, #16a085 0%, #1abc9c 100%);
  color: #fff;
  font-weight: 600;
  border-left: 3px solid #fff;
  box-shadow: 0 4px 8px rgba(22, 160, 133, 0.3);
}

.sidebar nav ul li a:active {
  transform: scale(0.98);
}

.sidebar-footer {
  padding: 20px 15px;
  border-top: 1px solid rgba(255, 255, 255, 0.1);
  flex-shrink: 0; /* Mencegah footer menyusut */
}

.sidebar footer {
  font-size: 12px;
  color: #95a5a6;
  text-align: center;
  margin: 0;
}

/* Responsive untuk layar kecil */
@media (max-height: 600px) {
  .sidebar h2 {
    font-size: 20px;
  }
  
  .sidebar-header {
    padding: 15px;
  }
  
  .sidebar nav ul li a {
    padding: 10px 15px;
    font-size: 14px;
  }
  
  .sidebar-footer {
    padding: 15px;
  }
}

/* Toggle button untuk mobile (opsional) */
@media (max-width: 768px) {
  .sidebar {
    transform: translateX(-100%);
    transition: transform 0.3s ease;
  }
  
  .sidebar.active {
    transform: translateX(0);
  }
}
</style>

<div class="sidebar">
  <div class="sidebar-header">
    <h2>Admin Panel</h2>
  </div>
  
  <div class="sidebar-content">
    <nav>
      <ul>
        <li><a href="../newadmin/dashboard.php" class="<?= ($current_page == 'dashboard.php') ? 'active' : '' ?>">Dashboard</a></li>
        <li><a href="../newadmin/pemesanan.php" class="<?= ($current_page == 'pemesanan.php') || ($current_page == 'order_detail.php')  || ($current_page == 'order_edit.php') ? 'active' : '' ?>">Pemesanan</a></li>
        <li><a href="../newadmin/pengguna.php" class="<?= ($current_page == 'pengguna.php') ? 'active' : '' ?>">Pengguna</a></li>
        <li><a href="../newadmin/blog.php" class="<?= ($current_page == 'blog.php') || ($current_page == 'tambah_blog.php') || ($current_page == 'edit_blog.php') ? 'active' : '' ?>">Blog</a></li>
        <li><a href="../newadmin/wisata.php" class="<?= ($current_page == 'wisata.php') || ($current_page == 'tambah_wisata.php') || ($current_page == 'edit_wisata.php') ? 'active' : '' ?>">Wisata</a></li>
        <li><a href="../newadmin/paket_wisata.php" class="<?= ($current_page == 'paket_wisata.php') || ($current_page == 'tambah_paket.php') || ($current_page == 'edit_paket.php')  ? 'active' : '' ?>">Paket Wisata</a></li>
        <li><a href="../newadmin/pertanyaan.php" class="<?= ($current_page == 'pertanyaan.php') ? 'active' : '' ?>">Pertanyaan</a></li>
        <li><a href="../newadmin/pemandu_wisata.php" class="<?= ($current_page == 'pemandu_wisata.php') ? 'active' : '' ?>">Pemandu Wisata</a></li>
        <li><a href="../newadmin/kendaraan.php" class="<?= ($current_page == 'kendaraan.php') || ($current_page == 'edit_kendaraan.php') || ($current_page == 'tambah_kendaraan.php') ? 'active' : '' ?>">Kendaraan</a></li>
        <li><a href="../newadmin/penginapan.php" class="<?= ($current_page == 'penginapan.php') || ($current_page == 'tambah_penginapan.php') || ($current_page == 'edit_penginapan.php') ? 'active' : '' ?>">Penginapan</a></li>
        <li><a href="../newadmin/kuliner.php" class="<?= ($current_page == 'kuliner.php') || ($current_page == 'kuliner.php') ? 'active' : '' ?>">kuliner</a></li>
        <li><a href="../newadmin/galeri.php" class="<?= ($current_page == 'galeri.php') ? 'active' : '' ?>">Galeri</a></li>
        <li><a href="../newadmin/kontak_admin.php" class="<?= ($current_page == 'kontak_admin.php') ? 'active' : '' ?>">Kontak</a></li>
        <li><a href="../backend/log_out.php">Keluar</a></li>
      </ul>
    </nav>
  </div>
  
  <div class="sidebar-footer">
    <footer>&copy; <?= date('Y') ?> Admin Panel</footer>
  </div>
</div>