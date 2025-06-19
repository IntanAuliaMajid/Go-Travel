<?php
// profil.php
session_start();


require_once 'backend/koneksi.php'; // Sesuaikan path jika perlu

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id_pengunjung'])) {
    header("Location: login.php"); // Ganti dengan halaman login Anda
    exit();
}

$user_data = $_SESSION['user'];
$id_pengunjung = $user_data['id_pengunjung'];

// Ambil data profil terbaru dari DB
// Ini penting untuk memastikan data di sesi selalu up-to-date
$stmt_profile = $conn->prepare("SELECT nama_depan, nama_belakang, username, email, no_tlp, deskripsi, avatar FROM pengunjung WHERE id_pengunjung = ?");
$stmt_profile->bind_param("i", $id_pengunjung);
$stmt_profile->execute();
$result_profile = $stmt_profile->get_result();
$user_data_db = $result_profile->fetch_assoc();
$stmt_profile->close();

if (!$user_data_db) {
    // Jika data pengguna tidak ditemukan di DB, mungkin akun dihapus atau ada masalah
    session_destroy();
    header("Location: login.php");
    exit();
}
// Update session dengan data terbaru dari DB
$_SESSION['user'] = array_merge($_SESSION['user'], $user_data_db);
$user_data = $_SESSION['user']; // Gunakan data terbaru yang sudah diperbarui dari DB

// Path default avatar jika avatar kosong atau tidak valid
$default_avatar_local_path = './uploads/avatars/default_avatar.png';
$avatar_display_url = !empty($user_data['avatar']) ? htmlspecialchars($user_data['avatar']) : $default_avatar_local_path;


// Ambil Riwayat Pemesanan (hanya untuk count di sidebar)
$bookings_count = 0;
$sql_bookings_count = "SELECT COUNT(*) FROM pemesanan WHERE email = ?";
$stmt_bookings_count = $conn->prepare($sql_bookings_count);
if ($stmt_bookings_count) {
    $stmt_bookings_count->bind_param("s", $user_data['email']);
    $stmt_bookings_count->execute();
    $stmt_bookings_count->bind_result($bookings_count);
    $stmt_bookings_count->fetch();
    $stmt_bookings_count->close();
}


// Ambil Wishlist (hanya untuk count di sidebar)
$wishlist_count = 0;
$sql_wishlist_count = "SELECT COUNT(*) FROM wishlist WHERE user_id = ?";
$stmt_wishlist_count = $conn->prepare($sql_wishlist_count);
if ($stmt_wishlist_count) {
    $stmt_wishlist_count->bind_param("i", $id_pengunjung);
    $stmt_wishlist_count->execute();
    $stmt_wishlist_count->bind_result($wishlist_count);
    $stmt_wishlist_count->fetch();
    $stmt_wishlist_count->close();
}


// Ambil data Ulasan Saya (hanya untuk count di sidebar)
$reviews_count = 0;
$sql_reviews_count = "SELECT COUNT(*) FROM ulasan WHERE id_pengunjung = ?";
$stmt_reviews_count = $conn->prepare($sql_reviews_count);
if ($stmt_reviews_count) {
    $stmt_reviews_count->bind_param("i", $id_pengunjung);
    $stmt_reviews_count->execute();
    $stmt_reviews_count->bind_result($reviews_count);
    $stmt_reviews_count->fetch();
    $stmt_reviews_count->close();
}

// Menutup koneksi (pastikan tidak ada query lain setelah ini di profil.php ini)
$conn->close();

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Profil Pengguna | Wisata Indonesia</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        /* CSS yang sudah ada sebelumnya dari profil.php */
        /* Anda bisa memindahkan ini ke file CSS eksternal jika ingin lebih rapi */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5; /* Warna latar belakang lebih lembut */
            color: #333;
            line-height: 1.6;
        }

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

        .container {
            margin-top: -100px;
            max-width: 100%;
            padding: 0 20px;
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 20px;
            position: relative;
            z-index: 10;
        }

        @media (max-width: 992px) {
            .container {
                grid-template-columns: 1fr;
                margin-top: -80px;
            }
        }

        .profile-sidebar {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            height: fit-content;
            margin-bottom: 20px;
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
            background: #2c7a51; /* Warna hijau */
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
            background: #1d5b3a; /* Darker green */
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

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

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
            overflow-y: auto;
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
            overflow-y: auto;
        }

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
    <?php include 'Komponen/navbar.php'; // Pastikan path ini benar ?>

    <div class="profile-header">
        <div class="profile-header-content">
            <h1>Profil Saya</h1>
            <p>Kelola informasi akun Anda dan lihat aktivitas terbaru.</p>
        </div>
    </div>

    <div class="container">
        <div class="profile-sidebar">
            <div class="profile-avatar-container">
                <img src="<?php echo $avatar_display_url; ?>" alt="Profil Pengguna" class="profile-avatar" id="profileAvatar">
                <div class="avatar-upload-overlay" onclick="openPhotoModal()">
                    <i class="fas fa-camera"></i>
                </div>
                <div class="avatar-upload-btn" onclick="openPhotoModal()">
                    <i class="fas fa-edit"></i>
                </div>
            </div>
            <input type="file" id="avatarInput" accept="image/*" style="display: none;">

            <h2 class="profile-name"><?php echo htmlspecialchars($user_data['nama_depan'] . ' ' . $user_data['nama_belakang']); ?></h2>
            <p class="profile-username">@<?php echo htmlspecialchars($user_data['username'] ?? 'username'); ?></p>

            <div class="profile-stats">
                <div class="stat-item">
                    <div class="stat-number"><?php echo $bookings_count; ?></div>
                    <div class="stat-label">Pemesanan</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number"><?php echo $wishlist_count; ?></div>
                    <div class="stat-label">Wishlist</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number"><?php echo $reviews_count; ?></div>
                    <div class="stat-label">Ulasan</div>
                </div>
            </div>

            <ul class="profile-menu">
                <li><a href="#" class="active" data-tab="profile_informasi"><i class="fas fa-user"></i> Profil Saya</a></li>
                <li><a href="#" data-tab="profile_pemesanan"><i class="fas fa-calendar-alt"></i> Riwayat Pemesanan</a></li>
                <li><a href="#" data-tab="profile_wishlist"><i class="fas fa-heart"></i> Wishlist</a></li>
                <li><a href="#" data-tab="profile_ulasan"><i class="fas fa-star"></i> Ulasan Saya</a></li>
                <li><a href="#" data-tab="profile_pengaturan"><i class="fas fa-cog"></i> Pengaturan</a></li>
                <li><a href="backend/logout.php"><i class="fas fa-sign-out-alt"></i> Keluar</a></li>
            </ul>
        </div>

        <div class="profile-content">
            <div id="profile_informasi" class="tab-content active">
                <?php include 'profil_informasi.php'; ?>
            </div>
            <div id="profile_pemesanan" class="tab-content">
                </div>
            <div id="profile_wishlist" class="tab-content">
                </div>
            <div id="profile_ulasan" class="tab-content">
                </div>
            <div id="profile_pengaturan" class="tab-content">
                </div>
        </div>
    </div>

    <?php include 'modals/avatar_modal.php'; ?>

    <div id="notification" class="notification"></div>

    <script>
        // Global notification function
        function showNotification(message, type = 'success') {
            const notification = document.getElementById('notification');
            notification.textContent = message;
            notification.className = `notification ${type}`; // Reset classes then add type

            setTimeout(() => {
                notification.classList.add('show');
            }, 10);

            setTimeout(() => {
                notification.classList.remove('show');
            }, 3000);
        }

        document.addEventListener('DOMContentLoaded', function() {
            const tabLinks = document.querySelectorAll('.profile-menu a');
            const profileContentDiv = document.querySelector('.profile-content');

            // Function to load tab content via AJAX
            function loadTabContent(tabId) {
                const urlMap = {
                    'profile_informasi': 'profil_informasi.php',
                    'profile_pemesanan': 'profil_pemesanan.php',
                    'profile_wishlist': 'profil_wishlist.php',
                    'profile_ulasan': 'profil_ulasan.php',
                    'profile_pengaturan': 'profil_pengaturan.php'
                };

                if (urlMap[tabId]) {
                    fetch(urlMap[tabId])
                        .then(response => {
                            if (!response.ok) {
                                // Log the response status and text for debugging
                                console.error(`HTTP error! status: ${response.status}`);
                                return response.text().then(text => { throw new Error(`Network response was not ok: ${text}`); });
                            }
                            return response.text();
                        })
                        .then(html => {
                            // First, hide all tab contents
                            document.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active'));

                            // Find or create the target div and set its content
                            let targetDiv = document.getElementById(tabId);
                            if (!targetDiv) {
                                targetDiv = document.createElement('div');
                                targetDiv.id = tabId;
                                targetDiv.classList.add('tab-content');
                                profileContentDiv.appendChild(targetDiv);
                            }
                            targetDiv.innerHTML = html;
                            targetDiv.classList.add('active'); // Show the active tab

                            // Re-attach event listeners for newly loaded content
                            if (tabId === 'profile_wishlist') {
                                attachWishlistRemoveListeners();
                            }
                            if (tabId === 'profile_informasi') {
                                attachProfileFormListener();
                            }
                             if (tabId === 'profile_pengaturan') {
                                attachPasswordFormListener();
                            }
                            // PERBAIKAN: Panggil fungsi untuk tombol pemesanan
                            if (tabId === 'profile_pemesanan') {
                                attachBookingActionListeners(); 
                            }

                        })
                        .catch(error => {
                            console.error('Error loading tab content:', error);
                            showNotification('Gagal memuat konten. Silakan coba lagi.', 'error');
                        });
                }
            }

            // Tab Navigation Click Handler
            tabLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();

                    tabLinks.forEach(l => l.classList.remove('active'));
                    this.classList.add('active');

                    const tabId = this.getAttribute('data-tab');
                    if (tabId) {
                        loadTabContent(tabId);
                        history.pushState(null, '', `#${tabId}`);
                    }
                });
            });

            // Handle initial tab based on URL hash
            const hash = window.location.hash.substring(1);
            if (hash && document.querySelector(`.profile-menu a[data-tab="${hash}"]`)) {
                document.querySelector(`.profile-menu a[data-tab="${hash}"]`).click();
            } else {
                document.querySelector('.profile-menu a[data-tab="profile_informasi"]').click();
            }

            // Photo Upload Functionality
            setupPhotoUpload();

            // --- Dynamic Event Listeners ---

            function attachProfileFormListener() {
                const profileForm = document.getElementById('profileForm');
                if (profileForm) {
                    profileForm.addEventListener('submit', function(e) {
                        e.preventDefault();
                        const formData = new FormData(this);
                        formData.append('action', 'update_profile');

                        fetch('backend/update_profile.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                showNotification(data.message, 'success');
                                // Update nama di sidebar tanpa reload
                                document.querySelector('.profile-name').textContent = document.getElementById('firstName').value + ' ' + document.getElementById('lastName').value;
                                document.querySelector('.profile-username').textContent = '@' + document.getElementById('username').value;
                            } else {
                                showNotification(data.message, 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showNotification('Terjadi kesalahan saat menyimpan profil.', 'error');
                        });
                    });
                }
            }

            function attachPasswordFormListener() {
                const passwordForm = document.getElementById('passwordForm');
                if (passwordForm) {
                    passwordForm.addEventListener('submit', function(e) {
                        e.preventDefault();
                        const formData = new FormData(this);
                        formData.append('action', 'update_password');

                        fetch('backend/update_profile.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                showNotification(data.message, 'success');
                                this.reset(); // Clear form on success
                            } else {
                                showNotification(data.message, 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showNotification('Terjadi kesalahan saat menyimpan password.', 'error');
                        });
                    });
                }
            }

            function attachWishlistRemoveListeners() {
                const removeButtons = document.querySelectorAll('.wishlist-btn.btn-remove');
                removeButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const wisataId = this.dataset.wisataId; // Get wisata ID from data attribute
                        const wishlistItem = this.closest('.wishlist-item');

                        if (confirm('Apakah Anda yakin ingin menghapus dari wishlist?')) {
                            // Optimistic UI update
                            wishlistItem.style.opacity = '0';
                            setTimeout(() => {
                                wishlistItem.remove();
                            }, 300);

                            const formData = new FormData();
                            formData.append('wisata_id', wisataId);

                            fetch('backend/remove_wishlist.php', {
                                method: 'POST',
                                body: formData
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    showNotification(data.message, 'success');
                                } else {
                                    showNotification(data.message, 'error');
                                    setTimeout(() => loadTabContent('profile_wishlist'), 500); 
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                showNotification('Terjadi kesalahan saat menghapus dari wishlist.', 'error');
                                setTimeout(() => loadTabContent('profile_wishlist'), 500);
                            });
                        }
                    });
                });
            }

            // PERBAIKAN: Fungsi baru untuk event listener di tab pemesanan
            function attachBookingActionListeners() {
                const viewDetailButtons = document.querySelectorAll('.view-detail-btn');
                const cancelBookingButtons = document.querySelectorAll('.cancel-booking-btn');
                const modal = document.getElementById('bookingDetailModal');

                if (!modal) {
                    console.error("Modal detail pemesanan tidak ditemukan!");
                    return;
                }
                
                const closeButton = modal.querySelector('.close-button');
                const modalBodyContent = document.getElementById('modal-body-content');
                const modalKodePemesanan = document.getElementById('modal-kode-pemesanan');

                // Helper function untuk keamanan (mencegah XSS)
                const htmlspecialchars = (str) => {
                    if (typeof str !== 'string') return str;
                    const map = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' };
                    return str.replace(/[&<>"']/g, m => map[m]);
                };

                // Event listener untuk tombol 'Detail'
                viewDetailButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const idPemesanan = this.dataset.idPemesanan;
                        modal.style.display = 'block';
                        modalBodyContent.innerHTML = '<p>Loading detail pemesanan...</p>';
                        modalKodePemesanan.textContent = '';

                        fetch('backend/fetch_booking_detail.php?id=' + idPemesanan)
                            .then(response => response.ok ? response.json() : Promise.reject('Gagal mengambil data'))
                            .then(data => {
                                if (data.success) {
                                    const { booking, participants } = data;
                                    modalKodePemesanan.textContent = booking.kode_pemesanan;
                                    let detailHtml = `<p><strong>Nama Paket:</strong> ${htmlspecialchars(booking.nama_paket)}</p>
                                                    <p><strong>Total Harga:</strong> Rp${new Intl.NumberFormat('id-ID').format(booking.total_harga)}</p>
                                                    <p><strong>Status:</strong> <span class="booking-status ${htmlspecialchars(booking.status_class)}">${htmlspecialchars(booking.status_text)}</span></p>
                                                    // ... tambahkan detail lain sesuai kebutuhan ...`;
                                    modalBodyContent.innerHTML = detailHtml;
                                } else {
                                    modalBodyContent.innerHTML = `<p style="color:red;">${htmlspecialchars(data.message)}</p>`;
                                }
                            })
                            .catch(error => {
                                console.error('Error fetching booking detail:', error);
                                modalBodyContent.innerHTML = '<p style="color:red;">Terjadi kesalahan jaringan.</p>';
                            });
                    });
                });

                // Event listener untuk tombol 'Batalkan'
                cancelBookingButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const idPemesanan = this.dataset.idPemesanan;
                        
                        if (confirm('Apakah Anda yakin ingin membatalkan pemesanan ini?')) {
                            fetch('backend/cancel_booking.php', {
                                method: 'POST',
                                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                                body: 'id_pemesanan=' + encodeURIComponent(idPemesanan)
                            })
                            .then(response => {
                                if (!response.ok) {
                                    // Jika respons bukan JSON, akan ditangkap di .catch
                                    return response.json().then(err => Promise.reject(err));
                                }
                                return response.json();
                            })
                            .then(data => {
                                if (data.success) {
                                    showNotification(data.message, 'success');
                                    const bookingItem = document.getElementById('booking-item-' + idPemesanan);
                                    if (bookingItem) {
                                        bookingItem.style.transition = 'opacity 0.4s ease';
                                        bookingItem.style.opacity = '0';
                                        setTimeout(() => bookingItem.remove(), 400);
                                    }
                                } else {
                                    showNotification(data.message || 'Gagal membatalkan pesanan.', 'error');
                                }
                            })
                            .catch(error => {
                                console.error('Error saat membatalkan pemesanan:', error);
                                const errorMessage = error.message || 'Terjadi kesalahan pada server. Silakan cek log.';
                                showNotification(errorMessage, 'error');
                            });
                        }
                    });
                });
                
                // Event listener untuk modal
                if (closeButton) {
                    closeButton.onclick = () => { modal.style.display = "none"; }
                }
                window.onclick = (event) => {
                    if (event.target == modal) {
                        modal.style.display = "none";
                    }
                }
            }
        });

        // Photo Upload Functions (remain in profil.php as they interact with modal and main avatar)
        function setupPhotoUpload() {
            const modalFileInput = document.getElementById('modalFileInput');
            const photoPreview = document.getElementById('photoPreview');
            const uploadArea = document.querySelector('.photo-upload-area');
            const savePhotoBtn = document.getElementById('savePhotoBtn');
            const saveText = document.getElementById('saveText');
            const loadingSpinner = document.getElementById('loadingSpinner');

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

            // Save photo button click
            savePhotoBtn.addEventListener('click', savePhoto);

            // Function to handle file selection and preview
            function handleFileSelect(file) {
                if (!file) return;

                // Validate file type
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                if (!allowedTypes.includes(file.type)) {
                    showNotification('Format file tidak didukung. Gunakan JPG, PNG, atau GIF.', 'error');
                    // Clear file input to prevent invalid file from being submitted
                    modalFileInput.value = '';
                    return;
                }

                // Validate file size (max 5MB)
                const maxSize = 5 * 1024 * 1024; // 5MB in bytes
                if (file.size > maxSize) {
                    showNotification('Ukuran file terlalu besar. Maksimal 5MB.', 'error');
                    modalFileInput.value = '';
                    return;
                }

                // Create FileReader to preview image
                const reader = new FileReader();
                reader.onload = function(e) {
                    photoPreview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }

            function savePhoto() {
                const fileInput = document.getElementById('modalFileInput');
                const file = fileInput.files[0];

                if (!file) {
                    showNotification('Pilih foto terlebih dahulu.', 'error');
                    return;
                }

                // Show loading state
                saveText.style.display = 'none';
                loadingSpinner.style.display = 'inline-block';
                savePhotoBtn.disabled = true;

                const formData = new FormData();
                formData.append('profile_photo', file);

                fetch('backend/upload_avatar.php', { // Sesuaikan URL
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('profileAvatar').src = data.avatar_url; // Update main avatar
                        closePhotoModal();
                        showNotification(data.message, 'success');
                    } else {
                        showNotification(data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Terjadi kesalahan saat mengupload foto.', 'error');
                })
                .finally(() => {
                    // Hide loading state regardless of success or failure
                    saveText.style.display = 'inline';
                    loadingSpinner.style.display = 'none';
                    savePhotoBtn.disabled = false;
                });
            }
        }

        function openPhotoModal() {
            const modal = document.getElementById('photoModal');
            const currentAvatar = document.getElementById('profileAvatar').src;
            document.getElementById('photoPreview').src = currentAvatar;
            modal.style.display = 'block';
            document.body.classList.add('body-no-scroll');
        }

        function closePhotoModal() {
            const modal = document.getElementById('photoModal');
            modal.style.display = 'none';
            // Reset file input and preview
            document.getElementById('modalFileInput').value = '';
            document.getElementById('photoPreview').src = document.getElementById('profileAvatar').src; // Revert preview to current avatar
            document.body.classList.remove('body-no-scroll');
        }

        // Close modal when clicking outside
        window.addEventListener('click', function(e) {
            const modal = document.getElementById('photoModal');
            if (e.target === modal) {
                closePhotoModal();
            }
        });
    </script>
</body>
</html>