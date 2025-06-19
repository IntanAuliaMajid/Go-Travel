<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$current_page = basename($_SERVER['PHP_SELF']);

$is_logged_in = isset($_SESSION['user']);

if ($is_logged_in) {
    $user_data = $_SESSION['user'];

    // Pastikan avatar punya path yang benar.
    // Jika avatar di DB hanya nama file, Anda perlu prefix dengan path folder.
    // Jika sudah full path (misal: ./uploads/avatars/nama_file.png), maka ini cukup.
    // Asumsi: Avatar di sesi sudah punya full path relatif dari root proyek.
    $user_avatar_url = !empty($user_data['avatar']) ? htmlspecialchars($user_data['avatar']) : './uploads/avatars/default_avatar.png';
    
    // Menggunakan nama depan dan belakang untuk tampilan nama lengkap
    $display_name = htmlspecialchars($user_data['nama_depan'] . ' ' . $user_data['nama_belakang']);
    // Menggunakan username jika Anda ingin menampilkannya
    $display_username = htmlspecialchars($user_data['username'] ?? '');

}
?>

<nav id="navbar" class="navbar transparent">
    <div class="container">
        <div class="logo">
            <img src="./GAMBAR/logo.png" alt="Logo">
        </div>

        <ul class="nav-links">
            <li><a href="beranda.php" class="<?php echo ($current_page == 'beranda.php') ? 'active' : ''; ?>">Beranda</a></li>
            <li><a href="wisata.php" class="<?php echo (($current_page == 'wisata.php') || ($current_page == 'wisata_detail.php')) ? 'active' : ''; ?>">Wisata</a></li>
            <li><a href="paket_wisata.php" class="<?php echo (($current_page == 'paket_wisata.php') || ($current_page == 'paket_wisata_detail.php') || ($current_page == 'pembayaran.php') || ($current_page == 'pemesanan.php') || ($current_page == 'pembayaran_konfirmasi.php')) ? 'active' : ''; ?>">Paket Wisata</a></li>
            <li><a href="blog.php" class="<?php echo (($current_page == 'blog.php') || ($current_page == 'blog_detail.php')) ? 'active' : ''; ?>">Blog</a></li>
            <li><a href="kontak.php" class="<?php echo ($current_page == 'kontak.php') ? 'active' : ''; ?>">Kontak</a></li>
            <li><a href="Gallery Page.php" class="<?php echo ($current_page == 'Gallery Page.php') ? 'active' : ''; ?>">Galeri</a></li>
            <li><a href="tour_guide.php" class="<?php echo (($current_page == 'tour_guide.php') || ($current_page == 'tour_guide_detail.php')) ? 'active' : ''; ?>">Pemandu Wisata</a></li>
            <li><a href="kendaraan.php" class="<?php echo (($current_page == 'kendaraan.php') || ($current_page == 'kendaraan_detail.php')) ? 'active' : ''; ?>">Kendaraan</a></li>
            </ul>

        <?php if ($is_logged_in): ?>
            <div class="user-section">
                <div class="user-menu">
                    <div class="user-info" onclick="toggleUserDropdown()">
                        <img src="<?php echo $user_avatar_url; ?>" alt="User Avatar" class="user-avatar">
                        <span class="user-name"><?php echo $display_name; ?></span>
                        <i class="dropdown-arrow">▼</i>
                    </div>
                    <div class="user-dropdown" id="userDropdown">
                        <div class="dropdown-header">
                            <img src="<?php echo $user_avatar_url; ?>" alt="User Avatar" class="dropdown-avatar">
                            <div class="dropdown-info">
                                <span class="dropdown-name"><?php echo $display_name; ?></span>
                                <span class="dropdown-email"><?php echo htmlspecialchars($user_data['email']); ?></span>
                            </div>
                        </div>
                        <hr class="dropdown-divider">
                        <a href="user_dashboard.php" class="dropdown-item">
                            Profil Saya
                        </a>
                        <a href="riwayat_pemesanan.php" class="dropdown-item">
                            Riwayat Pemesanan
                        </a>
                        <a href="wishlist.php" class="dropdown-item">
                            Wishlist
                        </a>
                        <a href="profil.php#profile_pengaturan" class="dropdown-item">
                            Pengaturan
                        </a>
                        <hr class="dropdown-divider">
                        <a href="./backend/logout.php" class="dropdown-item logout">
                            Keluar
                        </a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="auth-buttons">
                <a href="daftar.php" class="btn-outline <?php echo ($current_page == 'daftar.php') ? 'active' : ''; ?>">Daftar</a>
                <a href="login.php" class="btn-solid <?php echo ($current_page == 'login.php') ? 'active' : ''; ?>">Masuk</a>
            </div>
        <?php endif; ?>
    </div>
</nav>

<script src="./JS/beranda.js"></script> <script>
function toggleUserDropdown() {
    const dropdown = document.getElementById('userDropdown');
    dropdown.classList.toggle('show');
}

// Tutup dropdown ketika klik di luar
document.addEventListener('click', function(event) {
    const userMenu = document.querySelector('.user-menu');
    const dropdown = document.getElementById('userDropdown');
    
    // Periksa jika yang diklik bukan bagian dari user-menu (termasuk dropdown itu sendiri)
    if (userMenu && !userMenu.contains(event.target) && dropdown.classList.contains('show')) {
        dropdown.classList.remove('show');
    }
});
</script>

<style>
/* CSS yang sudah ada sebelumnya dari navbar.php */
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

/* Tombol Daftar & Masuk (untuk user belum login) */
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

/* User Section (untuk user sudah login) */
.user-section {
    position: relative;
}

.user-menu {
    position: relative;
}

.user-info {
    display: flex;
    align-items: center;
    gap: 10px;
    cursor: pointer;
    padding: 8px 12px;
    border-radius: 8px;
    transition: background-color 0.3s;
}

.user-info:hover {
    background-color: rgba(30, 64, 175, 0.1);
}

.user-avatar {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #1e40af;
}

.user-name {
    font-weight: 600;
    font-size: 14px;
    color: inherit;
}

.dropdown-arrow {
    font-size: 10px;
    color: inherit;
    transition: transform 0.3s;
}

.user-info:hover .dropdown-arrow {
    transform: rotate(180deg);
}

/* User Dropdown */
.user-dropdown {
    position: absolute;
    top: 100%;
    right: 0;
    margin-top: 8px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    min-width: 280px;
    overflow: hidden;
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: all 0.3s ease;
    z-index: 1001;
}

.user-dropdown.show {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.dropdown-header {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 20px;
    background: linear-gradient(135deg, #1e40af, #3b82f6);
    color: white;
}

.dropdown-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid white;
}

.dropdown-info {
    display: flex;
    flex-direction: column;
}

.dropdown-name {
    font-weight: 700;
    font-size: 16px;
}

.dropdown-email {
    font-size: 13px;
    opacity: 0.9;
    margin-top: 2px;
}

.dropdown-divider {
    border: none;
    height: 1px;
    background: #e5e7eb;
    margin: 0;
}

.dropdown-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 20px;
    color: #374151;
    text-decoration: none;
    transition: background-color 0.3s;
    font-size: 14px;
}

.dropdown-item:hover {
    background-color: #f3f4f6;
}

.dropdown-item.logout {
    color: #dc2626;
}

.dropdown-item.logout:hover {
    background-color: #fef2f2;
}

.dropdown-item .icon {
    font-size: 16px;
    width: 20px;
    text-align: center;
}

/* Responsive */
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

    .auth-buttons, .user-section {
        margin-top: 10px;
    }

    .user-dropdown {
        right: -20px;
        min-width: 260px;
    }
}

/* Dark mode compatibility */
.navbar.scrolled .user-dropdown {
    background: white;
    color: #374151;
}

.navbar.transparent .user-dropdown {
    background: white;
    color: #374151;
}
</style>