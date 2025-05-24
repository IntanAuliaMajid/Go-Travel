<!-- /komponen/sidebar.php -->
<style>
  .sidebar {
    width: 220px;
    height: 100vh;
    background-color: #222;
    color: white;
    padding: 20px;
    box-sizing: border-box;
    position: fixed;
    top: 0;
    left: 0;
    font-family: Arial, sans-serif;
  }

  .sidebar h2 {
    margin-top: 0;
    margin-bottom: 20px;
    font-weight: normal;
    font-size: 24px;
  }

  .sidebar nav ul {
    list-style: none;
    padding-left: 0;
  }

  .sidebar nav ul li {
    margin-bottom: 15px;
  }

  .sidebar nav ul li a {
    color: white;
    text-decoration: none;
    font-size: 16px;
    display: block;
    padding: 8px 12px;
    border-radius: 4px;
    transition: background-color 0.3s ease;
  }

  .sidebar nav ul li a:hover {
    background-color: #444;
  }

  .sidebar footer {
    position: absolute;
    bottom: 20px;
    font-size: 12px;
    color: #aaa;
    width: 180px;
  }
</style>

<div class="sidebar">
  <h2>Admin Panel</h2>
  <nav>
    <ul>
      <li><a href="../newadmin/dashboard.php">Dashboard</a></li>
      <li><a href="../newadmin/pengguna.php">Pengguna</a></li>
      <li><a href="../newadmin/blog.php">Blog</a></li>
      <li><a href="../newadmin/paket_wisata.php">Paket Wisata</a></li>
      <li><a href="../newadmin/pertanyaan.php">Pertanyaan</a></li>
      <li><a href="../newadmin/pemandu_wisata.php">Pemandu Wisata</a></li>
      <li><a href="../newadmin/galeri.php">Galeri</a></li>
      <li><a href="/admin/logout.php">Keluar</a></li>
    </ul>
  </nav>
  <footer>&copy; <?= date('Y') ?> Admin Panel</footer>
</div>
