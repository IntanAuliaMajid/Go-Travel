<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<style>
  .sidebar {
    width: 240px;
    height: 100vh;
    background: linear-gradient(180deg, #2c3e50, #34495e);
    color: #ecf0f1;
    padding: 20px;
    box-sizing: border-box;
    position: fixed;
    top: 0;
    left: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }

  .sidebar h2 {
    margin: 0 0 30px 0;
    font-size: 22px;
    font-weight: 600;
    text-align: center;
    color: #ecf0f1;
  }

  .sidebar nav ul {
    list-style: none;
    padding: 0;
    margin: 0;
  }

  .sidebar nav ul li {
    margin-bottom: 12px;
  }

  .sidebar nav ul li a {
    color: #ecf0f1;
    text-decoration: none;
    font-size: 15px;
    display: block;
    padding: 10px 15px;
    border-radius: 6px;
    transition: background 0.3s ease, padding-left 0.3s;
  }

  .sidebar nav ul li a:hover {
    background: rgba(236, 240, 241, 0.1);
    padding-left: 20px;
  }

  .sidebar nav ul li a.active {
    background-color: #16a085;
    color: #fff;
    font-weight: bold;
  }

  .sidebar footer {
    font-size: 12px;
    color: #bdc3c7;
    text-align: center;
    margin-top: auto;
    padding-top: 30px;
  }
</style>

<div class="sidebar">
  <div>
    <h2>Admin Panel</h2>
    <nav>
      <ul>
        <li><a href="../newadmin/dashboard.php" class="<?= ($current_page == 'dashboard.php') ? 'active' : '' ?>">Dashboard</a></li>
        <li><a href="../newadmin/pengguna.php" class="<?= ($current_page == 'pengguna.php') ? 'active' : '' ?>">Pengguna</a></li>
        <li><a href="../newadmin/blog.php" class="<?= ($current_page == 'blog.php') || ($current_page == 'tambah_blog.php') ? 'active' : '' ?>">Blog</a></li>
        <li><a href="../newadmin/paket_wisata.php" class="<?= ($current_page == 'paket_wisata.php') || ($current_page == 'tambah_paket.php') ? 'active' : '' ?>">Paket Wisata</a></li>
        <li><a href="../newadmin/pertanyaan.php" class="<?= ($current_page == 'pertanyaan.php') ? 'active' : '' ?>">Pertanyaan</a></li>
        <li><a href="../newadmin/pemandu_wisata.php" class="<?= ($current_page == 'pemandu_wisata.php') ? 'active' : '' ?>">Pemandu Wisata</a></li>
        <li><a href="../newadmin/kendaraan.php" class="<?= ($current_page == 'kendaraan.php') ? 'active' : '' ?>">Kendaraan</a></li>
        <li><a href="../newadmin/penginapan.php" class="<?= ($current_page == 'penginapan.php') || ($current_page == 'tambah_penginapan.php') || ($current_page == 'edit_penginapan.php') ? 'active' : '' ?>">Penginapan</a></li>
        <li><a href="../newadmin/galeri.php" class="<?= ($current_page == 'galeri.php') ? 'active' : '' ?>">Galeri</a></li>
        <li><a href="../newadmin/kontak_admin.php" class="<?= ($current_page == 'kontak_admin.php') ? 'active' : '' ?>">Kontak</a></li>
        <li><a href="/admin/logout.php" >Keluar</a></li>
      </ul>
    </nav>
  </div>
  <footer>&copy; <?= date('Y') ?> Admin Panel</footer>
</div>
