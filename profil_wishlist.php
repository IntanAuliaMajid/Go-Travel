<?php
// profil_wishlist.php

// Pastikan session sudah dimulai karena file ini dimuat melalui AJAX
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once 'backend/koneksi.php'; // Sesuaikan path koneksi Anda

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id_pengunjung'])) {
    echo "<p class='error-message'>Anda harus login untuk melihat wishlist.</p>";
    exit();
}

$id_pengunjung = $_SESSION['user']['id_pengunjung'];

// Query untuk mengambil riwayat pemesanan
// Perbaikan: Lakukan JOIN ke tabel 'lokasi' untuk mendapatkan nama_lokasi
$sql_wishlist = "
    SELECT
        wl.wisata_id,
        w.nama_wisata,
        lok.nama_lokasi, -- Ganti w.lokasi dengan lok.nama_lokasi
        (SELECT g.url FROM gambar g WHERE g.wisata_id = w.id_wisata ORDER BY g.id_gambar ASC LIMIT 1) AS wisata_gambar -- Ambil gambar_utama dari tabel gambar
    FROM
        wishlist wl
    JOIN
        wisata w ON wl.wisata_id = w.id_wisata
    JOIN -- Tambahkan JOIN ke tabel lokasi
        lokasi lok ON w.id_lokasi = lok.id_lokasi
    WHERE
        wl.user_id = ?
    ORDER BY
        wl.created_at DESC
";

$stmt_wishlist = $conn->prepare($sql_wishlist);

if ($stmt_wishlist === false) {
    echo "<p class='error-message'>Error dalam menyiapkan query: " . htmlspecialchars($conn->error) . "</p>";
    $conn->close();
    exit();
}

$stmt_wishlist->bind_param("i", $id_pengunjung);
$stmt_wishlist->execute();
$result_wishlist = $stmt_wishlist->get_result();
$conn->close();
?>

<h3 class="section-title">Wishlist Saya</h3>

<?php if ($result_wishlist->num_rows > 0): ?>
    <div class="wishlist-list">
        <?php while ($item = $result_wishlist->fetch_assoc()): ?>
            <div class="wishlist-item">
                <img src="<?php
                    // Penyesuaian path gambar, mirip dengan yang Anda lakukan di wisata.php
                    $image_path_from_db = $item['wisata_gambar'];
                    if (strpos($image_path_from_db, '../') === 0) {
                        $final_image_url = str_replace('../', '', $image_path_from_db);
                    } else {
                        $final_image_url = $image_path_from_db;
                    }
                    echo htmlspecialchars($final_image_url ?: 'img/default_image.jpg');
                ?>" alt="<?php echo htmlspecialchars($item['nama_wisata']); ?>" class="wishlist-image">
                <div class="wishlist-details">
                    <h4><?php echo htmlspecialchars($item['nama_wisata']); ?></h4>
                    <p class="wishlist-location"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($item['nama_lokasi']); ?></p>
                </div>
                <div class="wishlist-actions">
                    <a href="wisata_detail.php?id=<?php echo htmlspecialchars($item['wisata_id']); ?>" class="wishlist-btn btn-view" title="Lihat Detail">
                        <i class="fas fa-eye"></i>
                    </a>
                    <button class="wishlist-btn btn-remove" data-wisata-id="<?php echo htmlspecialchars($item['wisata_id']); ?>" title="Hapus dari Wishlist">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
<?php else: ?>
    <p>Wishlist Anda kosong. <a href="wisata.php">Jelajahi Destinasi Sekarang!</a></p>
<?php endif; ?>

<style>
    /* Tambahan CSS untuk wishlist jika belum ada */
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
</style>