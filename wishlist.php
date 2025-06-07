<?php
// wishlist.php

include 'Komponen/navbar.php'; // Assuming navbar.php is in Komponen/ and starts the session
include './backend/koneksi.php'; // Pastikan path ini benar

// Tampilkan semua error PHP saat pengembangan
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 1. Cek apakah pengguna sudah login
// Menggunakan 'id_pengunjung' agar konsisten dengan profil.php
if (!isset($_SESSION['user']['id_pengunjung'])) {
    // Jika tidak login, tampilkan pesan dan hentikan eksekusi halaman wishlist lebih lanjut
    echo '
    <section class="wishlist-header" style="height: 40vh;">
        <h1>Wishlist Destinasi Wisata</h1>
        <p>Lihat dan kelola daftar destinasi impian Anda</p>
    </section>
    <section class="container">
        <div class="empty-wishlist" style="padding: 2rem; margin-top: 2rem;">
            <i class="fas fa-exclamation-circle" style="font-size: 3rem; color: #ffc107; margin-bottom: 1rem;"></i>
            <h3>Akses Ditolak</h3>
            <p>Anda harus login terlebih dahulu untuk melihat dan mengelola wishlist Anda.</p>
            <a href="login.php" class="explore-button" style="background-color: #ff6b6b;">Login Sekarang</a>
        </div>
    </section>';
    include 'Komponen/footer.php'; // Assuming footer.php is in Komponen/
    exit; // Hentikan eksekusi sisa halaman
}

$id_pengunjung = (int)$_SESSION['user']['id_pengunjung']; // id_pengunjung from pengunjung table
$wishlist_items = [];
$itemCount = 0;

// 2. Ambil data wishlist dari database
// Perbaikan: Pastikan alias tabel di SELECT sesuai dengan alias di FROM/JOIN.
// Alias tabel `wishlist` adalah `wl`, dan tabel `wisata` adalah `w`.
$sql = "SELECT
    wl.wisata_id, -- Mengambil wisata_id dari tabel wishlist yang di-alias sebagai 'wl'
    w.nama_wisata,
    w.deskripsi_wisata,
    lok.nama_lokasi,
    (SELECT g.url FROM gambar g WHERE g.wisata_id = w.id_wisata ORDER BY g.id_gambar ASC LIMIT 1) AS gambar_url,
    COALESCE(rev_stats.avg_rating, 0) AS rating_rata2,
    COALESCE(rev_stats.review_count, 0) AS jumlah_ulasan
FROM
    wishlist wl -- Menggunakan alias 'wl' untuk tabel wishlist
INNER JOIN
    wisata w ON wl.wisata_id = w.id_wisata -- Menggunakan alias 'w' untuk tabel wisata
INNER JOIN
    lokasi lok ON w.id_lokasi = lok.id_lokasi -- Menggunakan alias 'lok' untuk tabel lokasi
LEFT JOIN
    (SELECT u.id_wisata, AVG(u.rating) AS avg_rating, COUNT(u.id_ulasan) AS review_count FROM ulasan u GROUP BY u.id_wisata) AS rev_stats
    ON w.id_wisata = rev_stats.id_wisata
WHERE
    wl.user_id = ? -- Menggunakan alias 'wl' untuk kolom user_id dari tabel wishlist
ORDER BY
    wl.created_at DESC";

$stmt = mysqli_prepare($conn, $sql);
if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $id_pengunjung);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($result)) {
        $wishlist_items[] = $row;
    }
    mysqli_stmt_close($stmt);
    $itemCount = count($wishlist_items);
} else {
    // Log error secara lebih detail
    error_log("MySQLi prepare error (fetch wishlist): " . mysqli_error($conn));
    // Tampilkan pesan error ke user (hanya saat debugging)
    echo "<p style='color: red;'>Error mengambil data wishlist: " . htmlspecialchars(mysqli_error($conn)) . "</p>";
}
mysqli_close($conn); // Koneksi ditutup setelah data diambil

// Fungsi untuk membuat bintang rating
function generateStars($rating) {
    $rating = round(floatval($rating) * 2) / 2; // Membulatkan rating ke 0.5 terdekat
    $starsHtml = '';
    for ($i = 1; $i <= 5; $i++) {
        if ($rating >= $i) {
            $starsHtml .= '★'; // Bintang penuh
        } elseif ($rating >= $i - 0.5) {
            $starsHtml .= '★'; // Bintang untuk nilai .5 (dianggap penuh untuk display karakter)
        } else {
            $starsHtml .= '☆'; // Bintang kosong
        }
    }
    return $starsHtml;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Wishlist Destinasi Wisata</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        /* Header */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
        }
        .wishlist-header {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),
                        url('https://www.ruparupa.com/blog/wp-content/uploads/2022/03/Jakarta_Batavia_%C2%A9-CEphoto-Uwe-Aranas.jpg') no-repeat center center/cover; /* Gambar latar belakang header */
            height: 60vh; /* Tinggi header */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: #fff;
            padding: 2rem;
            /* margin-top: 20px; Sesuaikan jika navbar absolute/fixed */
        }
        .wishlist-header h1 {
            /* margin-top: 50px; Tidak perlu jika navbar absolute/fixed */
            font-size: 3rem; /* Ukuran font judul header */
            margin-bottom: 1rem;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);
        }
        .wishlist-header p {
            font-size: 1.2rem; /* Ukuran font sub-judul header */
            max-width: 800px;
            margin-bottom: 2rem;
        }
        /* Container */
        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        /* Empty Wishlist State */
        .empty-wishlist {
            text-align: center;
            padding: 4rem 0;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); /* Bayangan untuk kotak wishlist kosong */
        }
        .empty-wishlist i.fa-heart, .empty-wishlist i.far.fa-heart, .empty-wishlist i.fas.fa-exclamation-circle { /* Ikon untuk wishlist kosong atau akses ditolak */
            font-size: 5rem;
            color: #ff6b6b; /* Warna ikon hati */
            margin-bottom: 1.5rem;
        }
        .empty-wishlist i.fas.fa-exclamation-circle { /* Ikon untuk akses ditolak */
            color: #ffc107; /* Warna ikon seru */
        }
        .empty-wishlist h3 {
            font-size: 1.8rem;
            margin-bottom: 1rem;
            color: #333;
        }
        .empty-wishlist p {
            color: #666;
            margin-bottom: 2rem;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }
        .explore-button {
            background-color: #2c7a51; /* Warna tombol jelajahi */
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            cursor: pointer;
            transition: background-color 0.3s;
            text-decoration: none;
            display: inline-block;
            font-size: 1rem;
        }
        .explore-button:hover {
            background-color: #1d5b3a; /* Warna tombol jelajahi saat hover */
        }
        /* Destinations Grid */
        .destinations-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); /* Layout grid responsif untuk kartu destinasi */
            gap: 2rem;
            margin-bottom: 3rem;
        }
        .destination-card {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); /* Bayangan kartu destinasi */
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .destination-card:hover {
            transform: translateY(-10px); /* Efek hover pada kartu destinasi */
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }
        .card-image {
            height: 200px;
            overflow: hidden;
            position: relative;
            background-color: #f0f0f0; /* Placeholder color */
        }
        .card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover; /* Gambar kartu agar mengisi area tanpa distorsi */
            transition: transform 0.5s;
        }
        .destination-card:hover .card-image img {
            transform: scale(1.05); /* Efek zoom pada gambar kartu saat hover */
        }
        .remove-wishlist-btn {
            position: absolute;
            top: 1rem;
            left: 1rem;
            background-color: rgba(255, 255, 255, 0.8); /* Tombol hapus wishlist pada kartu */
            border: none;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 2;
        }
        .remove-wishlist-btn i {
            color: #ff6b6b; /* Warna ikon hati pada tombol hapus */
            font-size: 1.2rem;
            transition: all 0.3s ease;
        }
        .remove-wishlist-btn:hover {
            background-color: white;
        }
        .remove-wishlist-btn:hover i {
            color: #ff5252; /* Warna ikon hati pada tombol hapus saat hover */
            transform: scale(1.1);
        }
        .card-content {
            padding: 1.5rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .card-content h3 {
            margin-bottom: 0.5rem;
            font-size: 1.3rem;
            color: #333;
        }
        .card-location {
            color: #666;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            margin-bottom: 0.75rem;
        }
        .card-location i {
            margin-right: 0.5rem;
            color: #2c7a51; /* Warna ikon lokasi */
        }
        .card-rating {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }
        .card-rating .stars {
            color: #ffc107; /* Warna bintang rating */
            margin-right: 0.5rem;
        }
        .card-rating .count {
            color: #666;
            font-size: 0.9rem;
        }
        .card-description {
            margin-bottom: 1.5rem;
            color: #555;
            font-size: 0.95rem;
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 3; /* Membatasi deskripsi menjadi 3 baris */
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            min-height: calc(0.95rem * 1.5 * 3); /* 3 lines of text */
        }
        .card-meta {
            display: flex;
            justify-content: flex-end; /* Diubah agar tombol "Lihat Detail" rata kanan */
            align-items: center;
            padding-top: 1rem;
            border-top: 1px solid #eee;
            margin-top: auto;
        }
        .card-button {
            background-color: #2c7a51; /* Warna tombol lihat detail */
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        .card-button:hover {
            background-color: #1d5b3a; /* Warna tombol lihat detail saat hover */
        }
        /* Action Buttons */
        .wishlist-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding: 1rem;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1); /* Bayangan untuk bagian aksi wishlist */
        }
        .wishlist-count-display {
            font-weight: bold;
            color: #333;
        }
        .clear-wishlist-btn {
            background-color: #ff6b6b; /* Warna tombol kosongkan wishlist */
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .clear-wishlist-btn:hover {
            background-color: #ff5252; /* Warna tombol kosongkan wishlist saat hover */
        }
        .clear-wishlist-btn:disabled {
            background-color: #ccc; /* Warna tombol kosongkan wishlist saat nonaktif */
            cursor: not-allowed;
        }
        /* Responsive */
        @media (max-width: 768px) {
            .wishlist-header h1 {
                font-size: 2.5rem; /* Ukuran font header responsif */
            }
            .wishlist-actions {
                flex-direction: column; /* Tata letak aksi wishlist responsif */
                gap: 1rem;
                align-items: flex-start;
            }
            .clear-wishlist-btn {
                align-self: flex-end; /* Posisi tombol kosongkan wishlist responsif */
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
            transform: translateY(120px);
            opacity: 0;
            transition: transform 0.4s ease-out, opacity 0.4s ease-out; /* Transisi notifikasi */
            z-index: 1000;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }
        .notification.show {
            transform: translateY(0);
            opacity: 1;
        }
        .notification.success {
            background-color: #2c7a51; /* Warna notifikasi sukses */
        }
        .notification.error {
            background-color: #dc3545; /* Warna notifikasi error */
        }
        .notification.info {
            background-color: #17a2b8; /* Warna notifikasi info */
        }
    </style>
</head>
<body>

    <section class="wishlist-header">
        <h1>Wishlist Destinasi Wisata</h1>
        <p>Lihat dan kelola daftar destinasi impian Anda</p>
    </section>

    <section class="container">
        <?php if (isset($_SESSION['user']['id_pengunjung'])): // Hanya tampilkan jika user login ?>
        <div class="wishlist-actions">
            <div class="wishlist-count-display">
                <i class="fas fa-heart" style="color: #ff6b6b;"></i>
                <span id="wishlist-item-count"><?php echo $itemCount; ?></span> Destinasi dalam wishlist
            </div>
            <button class="clear-wishlist-btn" <?php echo ($itemCount == 0) ? 'disabled' : ''; ?>>
                <i class="fas fa-trash-alt"></i> Kosongkan Wishlist
            </button>
        </div>

        <div class="destinations-grid">
            <?php if ($itemCount > 0): ?>
                <?php foreach ($wishlist_items as $item): ?>
                    <div class="destination-card" data-id="card-<?php echo $item['wisata_id']; ?>">
                        <div class="card-image">
                            <img src="<?php
    $image_path_from_db = $item['gambar_url'];
    // Jika path dimulai dengan '../', ganti dengan './' atau hapus '../'
    // Asumsi folder 'uploads' ada di root proyek
    if (strpos($image_path_from_db, '../') === 0) {
        $final_image_url = str_replace('../', '', $image_path_from_db); // Hapus '../' sepenuhnya
    } else {
        $final_image_url = $image_path_from_db;
    }
    // Tambahkan prefix jika path di DB hanya nama file, tapi query Anda mengambil URL lengkap
    // Jadi mungkin tidak perlu prefix tambahan jika path di DB sudah lengkap.
    // Contoh: 'uploads/wisata/' . $final_image_url;
    
    // Fallback jika gambar_url kosong atau null
    echo htmlspecialchars($final_image_url ?: 'img/default_image.jpg');
?>" alt="<?php echo htmlspecialchars($item['nama_wisata']); ?>" onerror="this.onerror=null;this.src='img/default_image.jpg';">
                            <button class="remove-wishlist-btn" title="Hapus dari wishlist" data-wisata-id="<?php echo $item['wisata_id']; ?>">
                                <i class="fas fa-heart"></i>
                            </button>
                        </div>
                        <div class="card-content">
                            <div>
                                <h3><?php echo htmlspecialchars($item['nama_wisata']); ?></h3>
                                <div class="card-location">
                                    <i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($item['nama_lokasi']); ?>
                                </div>
                                <div class="card-rating">
                                    <div class="stars"><?php echo generateStars($item['rating_rata2']); ?></div>
                                    <div class="count">(<?php echo htmlspecialchars($item['jumlah_ulasan']); ?> ulasan)</div>
                                </div>
                                <div class="card-description">
                                    <?php echo htmlspecialchars(mb_strimwidth($item['deskripsi_wisata'] ?: 'Deskripsi tidak tersedia.', 0, 150, "...")); ?>
                                </div>
                            </div>
                            <div class="card-meta">
                                <a href="detail_destinasi.php?id=<?php echo $item['wisata_id']; ?>" class="card-button">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="empty-wishlist" style="grid-column: 1 / -1;">
                    <i class="far fa-heart"></i>
                    <h3>Wishlist Anda Kosong</h3>
                    <p>Anda belum menambahkan destinasi wisata ke dalam wishlist. Jelajahi destinasi menarik dan tambahkan ke wishlist untuk menyimpannya di sini.</p>
                    <a href="wisata.php" class="explore-button">Jelajahi Destinasi</a>
                </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </section>

    <?php include 'Komponen/footer.php'; ?>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        let currentItemCount = parseInt(document.getElementById('wishlist-item-count')?.textContent || '0');
        const wishlistCountElement = document.getElementById('wishlist-item-count');
        const destinationsGrid = document.querySelector('.destinations-grid');
        const clearWishlistButton = document.querySelector('.clear-wishlist-btn');
        const defaultImagePath = 'img/default_image.jpg'; // Pastikan path ini benar

        function updateWishlistDisplay() {
            if (wishlistCountElement) {
                wishlistCountElement.textContent = currentItemCount;
            }
            if (clearWishlistButton) {
                clearWishlistButton.disabled = currentItemCount === 0;
            }
            if (currentItemCount === 0 && destinationsGrid) {
                // Remove all existing children that are destination cards
                Array.from(destinationsGrid.children).forEach(child => {
                    if (child.classList.contains('destination-card')) {
                        child.remove();
                    }
                });
                // Add the empty wishlist message if it's not already there
                if (!document.querySelector('.empty-wishlist')) {
                    const emptyMessageHtml = `
                        <div class="empty-wishlist" style="grid-column: 1 / -1;">
                            <i class="far fa-heart"></i>
                            <h3>Wishlist Anda Kosong</h3>
                            <p>Anda belum menambahkan destinasi wisata ke dalam wishlist. Jelajahi destinasi menarik dan tambahkan ke wishlist untuk menyimpannya di sini.</p>
                            <a href="wisata.php" class="explore-button">Jelajahi Destinasi</a>
                        </div>`;
                    destinationsGrid.insertAdjacentHTML('beforeend', emptyMessageHtml);
                }
            } else if (currentItemCount > 0 && document.querySelector('.empty-wishlist')) {
                // If there are items, remove the empty wishlist message
                document.querySelector('.empty-wishlist').remove();
            }
        }

        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.textContent = message;
            document.body.appendChild(notification);
            setTimeout(() => {
                notification.classList.add('show');
            }, 10); // Sedikit delay agar transisi CSS bisa berjalan
            setTimeout(() => {
                notification.classList.remove('show');
                setTimeout(() => {
                    if (document.body.contains(notification)) {
                        document.body.removeChild(notification);
                    }
                }, 400); // Waktu untuk transisi fade out
            }, 3000); // Notifikasi hilang setelah 3 detik
        }

        if (destinationsGrid) {
            destinationsGrid.addEventListener('click', function(event) {
                const removeButton = event.target.closest('.remove-wishlist-btn');
                if (removeButton) {
                    const wisataId = removeButton.dataset.wisataId;
                    const cardToRemove = removeButton.closest('.destination-card');
                    if (!wisataId || !cardToRemove) return;

                    fetch('./backend/wishlist_handler.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: `wisata_id=${wisataId}&action=remove` // Menggunakan 'wisata_id' sesuai backend
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success && data.status === 'removed') {
                            cardToRemove.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                            cardToRemove.style.opacity = '0';
                            cardToRemove.style.transform = 'scale(0.9)';
                            setTimeout(() => {
                                cardToRemove.remove();
                                currentItemCount--;
                                updateWishlistDisplay();
                                showNotification('Destinasi berhasil dihapus dari wishlist.', 'success');
                            }, 300); // Tunggu animasi selesai
                        } else {
                            showNotification(data.message || 'Gagal menghapus destinasi.', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error removing item:', error);
                        showNotification('Terjadi kesalahan jaringan saat menghapus.', 'error');
                    });
                }
            });
        }

        if (clearWishlistButton) {
            clearWishlistButton.addEventListener('click', function() {
                if (currentItemCount === 0) {
                    showNotification('Wishlist sudah kosong.', 'info');
                    return;
                }
                if (confirm('Apakah Anda yakin ingin mengosongkan seluruh wishlist?')) {
                    fetch('./backend/proses_clear_wishlist.php', { method: 'POST' })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            currentItemCount = 0; // Set count to 0 immediately
                            updateWishlistDisplay(); // This will clear the grid and show empty message
                            showNotification('Semua destinasi berhasil dihapus dari wishlist.', 'success');
                        } else {
                            showNotification(data.message || 'Gagal mengosongkan wishlist.', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error clearing wishlist:', error);
                        showNotification('Terjadi kesalahan jaringan saat mengosongkan wishlist.', 'error');
                    });
                }
            });
        }

        // Memanggil updateWishlistDisplay saat halaman pertama kali dimuat
        // untuk mengatur status tombol 'Kosongkan Wishlist' dan pesan jika wishlist kosong
        if(document.getElementById('wishlist-item-count')) {
            updateWishlistDisplay();
        }
    });
    </script>
</body>
</html>