<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<nav id="navbar" class="navbar transparent">
    <div class="container">
        <div class="logo">
            <img src="./GAMBAR/logo.png" alt="Logo">
        </div>
        <ul class="nav-links">
            <li><a href="beranda.php" class="<?php echo ($current_page == 'beranda.php')  ? 'active' : ''; ?>">Beranda</a></li>
            <li><a href="wisata.php" class="<?php echo (($current_page == 'wisata.php') || ($current_page == 'detail_destinasi.php')) ? 'active' : ''; ?>">Wisata</a></li>
            <li><a href="paket_wisata.php" class="<?php echo ($current_page == 'paket_wisata.php') ? 'active' : ''; ?>">Paket Wisata</a></li>
            <li><a href="blog.php" class="<?php echo ($current_page == 'blog.php') ? 'active' : ''; ?>">Blog</a></li>
            <li><a href="kontak.php" class="<?php echo ($current_page == 'kontak.php') ? 'active' : ''; ?>">Kontak</a></li>
            <li><a href="./fuadi/interface17.php" class="<?php echo ($current_page == 'interface17.php') ? 'active' : ''; ?>">Galeri</a></li>
            <li><a href="tour_guide.php" class="<?php echo ($current_page == 'tour_guide.php') ? 'active' : ''; ?>">Tour Guide</a></li>
            <li><a href="pesan_sekarang.php" class="btn <?php echo ($current_page == 'pesan_sekarang.php') ? 'active' : ''; ?>">Pesan Sekarang</a></li>
        </ul>
    </div>
</nav>
<script src="./JS/beranda.js"></script>
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Inter', sans-serif;
}

.navbar {
    position: fixed;
    top: 0;
    width: 100%;
    padding: 15px 30px;
    z-index: 1000;
    transition: background-color 0.4s ease, box-shadow 0.4s ease;
}

.navbar.transparent {
    background-color: transparent;
    color: white;
}

.navbar.scrolled {
    background-color: white;
    color: black;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.navbar .container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    max-width: 1200px;
    margin: 0 auto;
}

.logo img {
    width: 80px;
    height: auto;
}

.nav-links {
    display: flex;
    list-style: none;
    gap: 25px;
    align-items: center;
}

.nav-links a {
    text-decoration: none;
    color: inherit;
    font-weight: 600;
    font-size: 14px;
    transition: color 0.3s;
    padding: 6px 10px;
    /* border-radius: 4px; */
}

.nav-links a:hover {
    color: #1e40af;
    background-color: rgba(30, 64, 175, 0.1);
}

.nav-links a.active {
    color: #1e40af;
    border-bottom: 2px solid #1e40af;
}

.nav-links .btn {
    background-color: #1e40af;
    color: white !important;
    padding: 8px 16px;
    border-radius: 6px;
    font-size: 14px;
    transition: background-color 0.3s;
}

.nav-links .btn:hover {
    background-color: #1e3a8a;
}
</style>

