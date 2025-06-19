<?php
// profil_pemesanan.php

// Pastikan session sudah dimulai
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Sesuaikan path ke file koneksi.php Anda
require_once 'backend/koneksi.php'; 

// Periksa apakah pengguna sudah login dan memiliki data email
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['email'])) {
    echo "<p>Anda harus login untuk melihat riwayat pemesanan.</p>";
    exit();
}

// Mengambil email dari session pengguna yang sedang login
$email_pengunjung = $_SESSION['user']['email'];

// Query untuk mengambil riwayat pemesanan
$sql_pemesanan = "
    SELECT
        p.id_pemesanan, p.kode_pemesanan, p.tanggal_pemesanan, p.jumlah_peserta AS jumlah_tiket,
        p.total_harga, p.status_pemesanan, pw.nama_paket AS nama_destinasi, w.nama_wisata,
        lok.nama_lokasi AS lokasi_wisata,
        (SELECT gp.url_gambar FROM gambar_paket gp WHERE gp.id_paket_wisata = pw.id_paket_wisata ORDER BY gp.is_thumbnail DESC, gp.id_gambar_paket ASC LIMIT 1) AS gambar_url,
        p.tanggal_keberangkatan, p.payment_method, p.catatan_tambahan
    FROM pemesanan p
    INNER JOIN paket_wisata pw ON p.id_paket_wisata = pw.id_paket_wisata
    LEFT JOIN wisata w ON pw.id_wisata = w.id_wisata
    LEFT JOIN lokasi lok ON w.id_lokasi = lok.id_lokasi
    WHERE p.email = ?
    ORDER BY p.tanggal_pemesanan DESC
";

$stmt_pemesanan = $conn->prepare($sql_pemesanan);

if ($stmt_pemesanan === false) {
    echo "<p>Error dalam menyiapkan query: " . htmlspecialchars($conn->error) . "</p>";
    $conn->close();
    exit();
}

$stmt_pemesanan->bind_param("s", $email_pengunjung);
$stmt_pemesanan->execute();
$result_pemesanan = $stmt_pemesanan->get_result();
$conn->close();
?>

<h3 class="section-title">Riwayat Pemesanan</h3>

<?php if ($result_pemesanan->num_rows > 0): ?>
    <div class="booking-list">
        <?php while ($booking = $result_pemesanan->fetch_assoc()): ?>
            <div class="booking-item" id="booking-item-<?php echo htmlspecialchars($booking['id_pemesanan']); ?>">
                <img src="<?php
                    $image_path_from_db = $booking['gambar_url'];
                    $final_image_url = 'img/default_package.jpg'; // Gambar fallback
                    if (!empty($image_path_from_db)) {
                        // Logika untuk menampilkan gambar dari berbagai kemungkinan path
                        if (strpos($image_path_from_db, 'http') === 0) {
                            $final_image_url = $image_path_from_db;
                        } else {
                            // Hapus ../ jika ada untuk path relatif dari root
                            $cleaned_path = str_replace('../', '', $image_path_from_db);
                            $final_image_url = file_exists($cleaned_path) ? $cleaned_path : 'uploads/paket/' . $cleaned_path;
                        }
                    }
                    echo htmlspecialchars($final_image_url);
                ?>" alt="<?php echo htmlspecialchars($booking['nama_destinasi']); ?>" class="booking-image" onerror="this.onerror=null;this.src='img/default_package.jpg';">

                <div class="booking-details">
                    <h4><?php echo htmlspecialchars($booking['nama_destinasi']); ?></h4>
                    <p>Kode Pemesanan: <strong><?php echo htmlspecialchars($booking['kode_pemesanan']); ?></strong></p>
                    <div class="booking-meta">
                        <span><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($booking['lokasi_wisata'] ?? 'N/A'); ?></span>
                        <span><i class="fas fa-users"></i> Peserta: <?php echo htmlspecialchars($booking['jumlah_tiket']); ?></span>
                        <span><i class="fas fa-calendar-alt"></i> Tgl Pesan: <?php echo date('d M Y', strtotime($booking['tanggal_pemesanan'])); ?></span>
                        <span><i class="fas fa-money-bill-wave"></i> Total: Rp<?php echo number_format($booking['total_harga'], 0, ',', '.'); ?></span>
                    </div>
                    <?php
                        $status_class = '';
                        $status_text = '';
                        switch (strtolower($booking['status_pemesanan'])) {
                            case 'pending':
                                $status_class = 'status-pending'; $status_text = 'Menunggu Pembayaran'; break;
                            case 'confirmed': case 'settlement': case 'capture':
                                $status_class = 'status-confirmed'; $status_text = 'Terkonfirmasi'; break;
                            case 'cancelled': case 'expire': case 'deny':
                                $status_class = 'status-cancelled'; $status_text = 'Dibatalkan/Gagal'; break;
                            case 'completed':
                                $status_class = 'status-completed'; $status_text = 'Selesai'; break;
                            default:
                                $status_class = 'status-info'; $status_text = ucfirst($booking['status_pemesanan']); break;
                        }
                    ?>
                    <span class="booking-status <?php echo $status_class; ?>"><?php echo $status_text; ?></span>

                    <div class="booking-actions" style="margin-top: 1rem; display: flex; gap: 10px;">
                        </button>
                        <?php if (in_array(strtolower($booking['status_pemesanan']), ['pending'])): ?>
                            <button class="btn btn-sm btn-danger cancel-booking-btn" data-id-pemesanan="<?php echo htmlspecialchars($booking['id_pemesanan']); ?>" style="background-color: #dc3545; color: white; border:none; cursor:pointer; padding: 0.5rem 1rem; border-radius:5px;">
                                <i class="fas fa-times-circle"></i> Batalkan
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
<?php else: ?>
    <div class="no-booking-history" style="text-align: center; padding: 50px 20px;">
        <i class="fas fa-box-open" style="font-size: 48px; color: #ccc; margin-bottom: 1rem;"></i>
        <p>Anda belum memiliki riwayat pemesanan.</p>
        <a href="paket_wisata.php" class="btn-primary" style="text-decoration:none; padding: 10px 20px; border-radius: 5px;">Lihat Paket Wisata</a>
    </div>
<?php endif; ?>

<div id="bookingDetailModal" class="modal" style="display:none; position: fixed; z-index: 1001; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.5); backdrop-filter: blur(5px);">
    <div class="modal-content" style="background-color: #fff; margin: 10% auto; padding: 2rem; border-radius: 10px; width: 90%; max-width: 700px; position: relative;">
        <span class="close-button" style="color: #aaa; float: right; font-size: 28px; font-weight: bold; cursor: pointer;">&times;</span>
        <h3>Detail Pemesanan <span id="modal-kode-pemesanan"></span></h3>
        <div id="modal-body-content" style="margin-top: 1.5rem;">
            <p>Loading...</p>
        </div>
    </div>
</div>