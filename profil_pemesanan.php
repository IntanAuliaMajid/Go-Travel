<?php
// profil_pemesanan.php

// Pastikan session sudah dimulai
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once 'backend/koneksi.php'; // Sesuaikan path koneksi Anda

// Periksa apakah pengguna sudah login dan memiliki data email
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['email'])) {
    // Jika tidak login atau data email tidak ada, jangan tampilkan apa-apa
    echo "<p class='error-message'>Anda harus login untuk melihat riwayat pemesanan.</p>";
    exit();
}

// Mengambil email dari session pengguna yang sedang login
$email_pengunjung = $_SESSION['user']['email'];

// Query untuk mengambil riwayat pemesanan
// Diubah untuk mencari berdasarkan email, bukan id_pengunjung
$sql_pemesanan = "
    SELECT
        p.id_pemesanan,
        p.kode_pemesanan,
        p.tanggal_pemesanan,
        p.jumlah_peserta AS jumlah_tiket,
        p.total_harga,
        p.status_pemesanan,
        pw.nama_paket AS nama_destinasi,
        w.nama_wisata,
        lok.nama_lokasi AS lokasi_wisata,
        -- Query untuk gambar sudah diperbaiki sebelumnya
        (SELECT gp.url_gambar FROM gambar_paket gp WHERE gp.id_paket_wisata = pw.id_paket_wisata ORDER BY gp.is_thumbnail DESC, gp.id_gambar_paket ASC LIMIT 1) AS gambar_url
    FROM
        pemesanan p
    INNER JOIN
        paket_wisata pw ON p.id_paket_wisata = pw.id_paket_wisata
    LEFT JOIN
        wisata w ON pw.id_wisata = w.id_wisata
    LEFT JOIN
        lokasi lok ON w.id_lokasi = lok.id_lokasi
    WHERE
        p.email = ? -- DIUBAH: Mencari berdasarkan email
    ORDER BY
        p.tanggal_pemesanan DESC
";

$stmt_pemesanan = $conn->prepare($sql_pemesanan);

if ($stmt_pemesanan === false) {
    echo "<p class='error-message'>Error dalam menyiapkan query: " . htmlspecialchars($conn->error) . "</p>";
    $conn->close();
    exit();
}

// DIUBAH: Mengikat parameter email (string 's') bukan id_pengunjung (integer 'i')
$stmt_pemesanan->bind_param("s", $email_pengunjung);
$stmt_pemesanan->execute();
$result_pemesanan = $stmt_pemesanan->get_result();
$conn->close(); // Tutup koneksi setelah data diambil

?>

<h3 class="section-title">Riwayat Pemesanan</h3>

<?php if ($result_pemesanan->num_rows > 0): ?>
    <div class="booking-list">
        <?php while ($booking = $result_pemesanan->fetch_assoc()): ?>
            <div class="booking-item" id="booking-item-<?php echo htmlspecialchars($booking['id_pemesanan']); ?>">
                <img src="<?php
                    // Penyesuaian path gambar dari database (misal dari 'uploads/paket/')
                    $image_path_from_db = $booking['gambar_url'];
                    $final_image_url = 'img/default_package.jpg'; // Default fallback

                    if (!empty($image_path_from_db)) {
                        if (strpos($image_path_from_db, 'http') === 0) {
                             $final_image_url = $image_path_from_db; // URL lengkap
                        } else if (strpos($image_path_from_db, '../') === 0) {
                            $final_image_url = str_replace('../', '', $image_path_from_db);
                        } else if (strpos($image_path_from_db, 'uploads/paket/') !== 0) {
                            // Jika path hanya nama file, tambahkan prefix folder
                            $final_image_url = 'uploads/paket/' . $image_path_from_db;
                        } else {
                            $final_image_url = $image_path_from_db;
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
                                $status_class = 'status-pending';
                                $status_text = 'Menunggu Pembayaran';
                                break;
                            case 'confirmed':
                            case 'settlement':
                            case 'capture':
                                $status_class = 'status-confirmed';
                                $status_text = 'Terkonfirmasi';
                                break;
                            case 'cancelled':
                            case 'expire':
                            case 'deny':
                                $status_class = 'status-cancelled';
                                $status_text = 'Dibatalkan/Gagal';
                                break;
                            case 'completed':
                                $status_class = 'status-completed';
                                $status_text = 'Selesai';
                                break;
                            default:
                                $status_class = 'status-info';
                                $status_text = ucfirst($booking['status_pemesanan']);
                                break;
                        }
                    ?>
                    <span class="booking-status <?php echo $status_class; ?>"><?php echo $status_text; ?></span>

                    <div class="booking-actions">
                        <button class="btn btn-sm btn-info view-detail-btn" data-id-pemesanan="<?php echo htmlspecialchars($booking['id_pemesanan']); ?>">
                            <i class="fas fa-info-circle"></i> Detail
                        </button>
                        <?php if (in_array(strtolower($booking['status_pemesanan']), ['pending'])): ?>
                            <button class="btn btn-sm btn-danger cancel-booking-btn" data-id-pemesanan="<?php echo htmlspecialchars($booking['id_pemesanan']); ?>">
                                <i class="fas fa-times-circle"></i> Batalkan
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
<?php else: ?>
    <div class="no-booking-history">
        <i class="fas fa-box-open"></i>
        <p>Anda belum memiliki riwayat pemesanan.</p>
        <a href="paket_wisata.php" class="btn-primary">Lihat Paket Wisata</a>
    </div>
<?php endif; ?>


<div id="bookingDetailModal" class="modal" style="display:none;">
    <div class="modal-content">
        <span class="close-button">&times;</span>
        <h3>Detail Pemesanan <span id="modal-kode-pemesanan"></span></h3>
        <div id="modal-body-content">
            <p>Loading...</p>
        </div>
    </div>
</div>

<style>
    /* Style untuk pesan jika tidak ada riwayat */
    .no-booking-history {
        text-align: center;
        padding: 50px 20px;
        background-color: #f9f9f9;
        border: 1px dashed #ddd;
        border-radius: 8px;
    }
    .no-booking-history i {
        font-size: 48px;
        color: #ccc;
        margin-bottom: 1rem;
    }
    .no-booking-history p {
        font-size: 1.1rem;
        color: #777;
        margin-bottom: 1.5rem;
    }
    .no-booking-history .btn-primary {
        text-decoration: none;
        background-color: #2c7a51;
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
        transition: background-color 0.3s;
    }
    .no-booking-history .btn-primary:hover {
        background-color: #1e5a3a;
    }

    /* CSS Tambahan untuk Tombol dan Modal */
    .booking-actions {
        margin-top: 1rem;
        display: flex;
        gap: 10px;
    }
    .btn.btn-sm {
        padding: 0.5rem 1rem;
        border-radius: 5px;
        font-size: 0.9rem;
        cursor: pointer;
        transition: background-color 0.3s;
        border: none;
    }
    .btn-info { background-color: #17a2b8; color: white; }
    .btn-info:hover { background-color: #138496; }
    .btn-danger { background-color: #dc3545; color: white; }
    .btn-danger:hover { background-color: #c82333; }

    /* Modal Styles */
    .modal {
        display: none; position: fixed; z-index: 1000; left: 0;
        top: 0; width: 100%; height: 100%; overflow: auto;
        background-color: rgba(0,0,0,0.4); backdrop-filter: blur(5px);
    }
    .modal-content {
        background-color: #fefefe; margin: 5% auto; padding: 20px;
        border: 1px solid #888; border-radius: 10px; width: 80%;
        max-width: 700px; position: relative; box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }
    .close-button {
        color: #aaa; float: right; font-size: 28px; font-weight: bold;
    }
    .close-button:hover, .close-button:focus {
        color: black; text-decoration: none; cursor: pointer;
    }
    #modal-body-content p { margin-bottom: 0.5rem; }
    #modal-body-content strong { color: #333; }
</style>

<script>
// SCRIPT ANDA TETAP SAMA, TIDAK PERLU DIUBAH
document.addEventListener('DOMContentLoaded', function() {
    const viewDetailButtons = document.querySelectorAll('.view-detail-btn');
    const cancelBookingButtons = document.querySelectorAll('.cancel-booking-btn');
    const modal = document.getElementById('bookingDetailModal');
    const closeButton = modal.querySelector('.close-button');
    const modalBodyContent = document.getElementById('modal-body-content');
    const modalKodePemesanan = document.getElementById('modal-kode-pemesanan');

    function showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.textContent = message;
        document.body.appendChild(notification);
        setTimeout(() => { notification.classList.add('show'); }, 10);
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => {
                if (document.body.contains(notification)) {
                    document.body.removeChild(notification);
                }
            }, 400);
        }, 3000);
    }

    viewDetailButtons.forEach(button => {
        button.addEventListener('click', function() {
            const idPemesanan = this.dataset.idPemesanan;
            modal.style.display = 'block';
            modalBodyContent.innerHTML = '<p>Loading detail pemesanan...</p>';
            modalKodePemesanan.textContent = '';
            fetch('backend/fetch_booking_detail.php?id=' + idPemesanan)
                .then(response => {
                    if (!response.ok) { throw new Error('Network response was not ok'); }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        const booking = data.booking;
                        const participants = data.participants;
                        modalKodePemesanan.textContent = booking.kode_pemesanan;
                        let detailHtml = `
                            <p><strong>Nama Paket:</strong> ${booking.nama_paket}</p>
                            <p><strong>Destinasi Wisata:</strong> ${booking.nama_wisata} (${booking.lokasi_wisata})</p>
                            <p><strong>Tanggal Keberangkatan:</strong> ${booking.tanggal_keberangkatan || 'Belum ditentukan'}</p>
                            <p><strong>Jumlah Peserta:</strong> ${booking.jumlah_peserta} orang</p>
                            <p><strong>Total Harga:</strong> Rp${new Intl.NumberFormat('id-ID').format(booking.total_harga)}</p>
                            <p><strong>Status Pemesanan:</strong> <span class="booking-status ${booking.status_class}">${booking.status_text}</span></p>
                            <p><strong>Tanggal Pemesanan:</strong> ${booking.tanggal_pemesanan}</p>
                            <p><strong>Metode Pembayaran:</strong> ${booking.payment_method || 'Belum dipilih'}</p>
                            ${booking.catatan_tambahan ? `<p><strong>Catatan Tambahan:</strong> ${booking.catatan_tambahan}</p>` : ''}
                        `;
                        if (participants && participants.length > 0) {
                            detailHtml += '<h4>Detail Peserta:</h4><ul>';
                            participants.forEach(p => {
                                detailHtml += `<li><strong>Nama:</strong> ${p.nama_lengkap}, <strong>No KTP:</strong> ${p.no_ktp}, <strong>Tgl Lahir:</strong> ${p.tanggal_lahir}, <strong>Jenis Kelamin:</strong> ${p.jenis_kelamin}</li>`;
                            });
                            detailHtml += '</ul>';
                        }
                        modalBodyContent.innerHTML = detailHtml;
                    } else {
                        modalBodyContent.innerHTML = '<p style="color:red;">' + (data.message || 'Gagal memuat detail pemesanan.') + '</p>';
                    }
                })
                .catch(error => {
                    console.error('Error fetching booking detail:', error);
                    modalBodyContent.innerHTML = '<p style="color:red;">Terjadi kesalahan jaringan saat memuat detail.</p>';
                });
        });
    });

    cancelBookingButtons.forEach(button => {
        button.addEventListener('click', function() {
            const idPemesanan = this.dataset.idPemesanan;
            if (confirm('Apakah Anda yakin ingin membatalkan pemesanan ini?')) {
                fetch('backend/cancel_booking.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded', },
                    body: 'id_pemesanan=' + idPemesanan
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification(data.message, 'success');
                        const bookingItem = document.getElementById('booking-item-' + idPemesanan);
                        if (bookingItem) { bookingItem.remove(); }
                    } else {
                        showNotification(data.message || 'Gagal membatalkan pemesanan.', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error canceling booking:', error);
                    showNotification('Terjadi kesalahan jaringan saat membatalkan pemesanan.', 'error');
                });
            }
        });
    });

    closeButton.addEventListener('click', () => { modal.style.display = 'none'; });
    window.addEventListener('click', (event) => {
        if (event.target == modal) { modal.style.display = 'none'; }
    });
});
</script>