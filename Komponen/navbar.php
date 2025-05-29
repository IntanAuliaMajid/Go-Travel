<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<nav id="navbar" class="navbar transparent">
    <div class="container">
        <div class="logo">
            <img src="./GAMBAR/logo.png" alt="Logo">
        </div>

        <ul class="nav-links">
            <li><a href="beranda.php" class="<?php echo ($current_page == 'beranda.php') ? 'active' : ''; ?>">Beranda</a></li>
            <li><a href="wisata.php" class="<?php echo (($current_page == 'wisata.php') || ($current_page == 'wisata_detail.php')) ? 'active' : ''; ?>">Wisata</a></li>
            <li><a href="paket_wisata.php" class="<?php echo (($current_page == 'paket_wisata.php') || ($current_page == 'paket_wisata_detail.php') || ($current_page == 'pembayaran.php')  || ($current_page == 'pemesanan.php') || ($current_page == 'pembayaran_konfirmasi.php')) ? 'active' : ''; ?>">Paket Wisata</a></li>
            <li><a href="blog.php" class="<?php echo (($current_page == 'blog.php') || ($current_page == 'blog_detail.php')) ? 'active' : ''; ?>">Blog</a></li>
            <li><a href="kontak.php" class="<?php echo ($current_page == 'kontak.php') ? 'active' : ''; ?>">Kontak</a></li>
            <li><a href="Gallery Page.php" class="<?php echo ($current_page == 'Gallery Page.php') ? 'active' : ''; ?>">Galeri</a></li>
            <li><a href="tour_guide.php" class="<?php echo ($current_page == 'tour_guide.php')  ? 'active' : ''; ?>">Tour Guide</a></li>
            <li><a href="kuliner.php" class="<?php echo ($current_page == 'kuliner.php')  ? 'active' : ''; ?>">Kuliner</a></li>
            <li><a href="wishlist.php" class="<?php echo ($current_page == 'wishlist.php')  ? 'active' : ''; ?>">Wishlist</a></li>
        </ul>

        <div class="auth-buttons">
            <a href="daftar.php" class="btn-outline <?php echo ($current_page == 'register.php') ? 'active' : ''; ?>">Daftar</a>
            <a href="login.php" class="btn-solid <?php echo ($current_page == 'login.php') ? 'active' : ''; ?>">Masuk</a>
        </div>
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
}

.nav-links a:hover {
    color: #1e40af;
    background-color: rgba(30, 64, 175, 0.1);
}

.nav-links a.active {
    color: #1e40af;
    border-bottom: 2px solid #1e40af;
}

/* Tombol Daftar & Masuk */
.auth-buttons {
    display: flex;
    gap: 12px;
    align-items: center;
}

.btn-outline {
    padding: 8px 16px;
    border: 2px solid #1e40af;
    color: #1e40af;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 600;
    font-size: 14px;
    transition: background-color 0.3s, color 0.3s;
}

.btn-outline:hover {
    background-color: #1e40af;
    color: white;
}

.btn-solid {
    padding: 8px 16px;
    background-color: #1e40af;
    color: white !important;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 600;
    font-size: 14px;
    transition: background-color 0.3s;
}

.btn-solid:hover {
    background-color: #1e3a8a;
}

/* Responsive (opsional) */
@media (max-width: 768px) {
    .navbar .container {
        flex-direction: column;
        align-items: flex-start;
    }

    .nav-links {
        flex-wrap: wrap;
        gap: 15px;
        margin-top: 10px;
    }

    .auth-buttons {
        margin-top: 10px;
    }
}
</style>
