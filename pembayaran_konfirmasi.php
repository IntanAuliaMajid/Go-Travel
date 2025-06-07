<?php
// session_start(); // Diasumsikan sudah ada di navbar.php
include 'Komponen/navbar.php';
include 'backend/koneksi.php'; 

// Inisialisasi variabel
$order_id_url = null;
$payment_status_url = null;
$transaction_id_url = null;
$payment_method_url = null;

$pemesanan_detail = null;
$pesan_konfirmasi_utama = "Status Pemesanan Anda";
$pesan_konfirmasi_detail = "Informasi detail mengenai pesanan Anda.";
$ikon_konfirmasi = "fas fa-info-circle"; 
$warna_ikon = "#3498db"; // Biru netral
$nama_paket_display = "Paket Wisata"; // Default
$link_lanjutan_satu = "<a href='index.php' class='btn btn-secondary'><i class='fas fa-home'></i> Kembali ke Beranda</a>";
$link_lanjutan_dua = "";


// Ambil parameter dari URL
if (isset($_GET['order_id'])) {
    $order_id_url = mysqli_real_escape_string($conn, $_GET['order_id']);
}
if (isset($_GET['status'])) {
    $payment_status_url = strtolower(mysqli_real_escape_string($conn, $_GET['status']));
}
if (isset($_GET['transaction_id'])) {
    $transaction_id_url = mysqli_real_escape_string($conn, $_GET['transaction_id']);
}
if (isset($_GET['method'])) { 
    $payment_method_url = mysqli_real_escape_string($conn, $_GET['method']);
}


// Jika order_id ada, coba ambil data dari database
if ($order_id_url) {
    $sql_pemesanan = "SELECT p.*, pw.nama_paket, pw.durasi_paket 
                      FROM pemesanan p
                      LEFT JOIN paket_wisata pw ON p.id_paket_wisata = pw.id_paket_wisata
                      WHERE p.kode_pemesanan = '$order_id_url' LIMIT 1";
    $result_pemesanan = mysqli_query($conn, $sql_pemesanan);

    if ($result_pemesanan && mysqli_num_rows($result_pemesanan) > 0) {
        $pemesanan_detail = mysqli_fetch_assoc($result_pemesanan);
        $nama_paket_display = $pemesanan_detail['nama_paket'] ?? $nama_paket_display;
        
        // Gunakan status dari DB jika ada dan valid, jika tidak, gunakan dari URL sebagai fallback
        $status_final_pembayaran = !empty($pemesanan_detail['status_pemesanan']) ? 
            strtolower($pemesanan_detail['status_pemesanan']) : 
            $payment_status_url;

        switch ($status_final_pembayaran) {
            case 'success':
            case 'completed': // Tambahkan status 'completed' sebagai sukses
            case 'settlement': 
                $pesan_konfirmasi_utama = "Pembayaran Berhasil!";
                $pesan_konfirmasi_detail = "Terima kasih! Pembayaran untuk pesanan Anda telah berhasil kami terima. E-voucher dan detail perjalanan akan segera dikirimkan ke email Anda (" . htmlspecialchars($pemesanan_detail['email'] ?? '') . ").";
                $ikon_konfirmasi = "fas fa-check-circle";
                $warna_ikon = "#2ecc71"; // Hijau
                $link_lanjutan_dua = "<a href='akun-saya/riwayat-perjalanan.php' class='btn btn-primary'><i class='fas fa-history'></i> Lihat Riwayat Booking</a>";
                break;
            case 'pending':
                $pesan_konfirmasi_utama = "Pembayaran Pending";
                if ($payment_method_url === 'transfer' || strtolower($pemesanan_detail['payment_method'] ?? '') === 'transfer') {
                     $pesan_konfirmasi_detail = "Pesanan Anda telah kami terima. Silakan selesaikan pembayaran melalui transfer bank sesuai instruksi. Detail pesanan dan instruksi juga telah dikirim ke email Anda jika tersedia.";
                } else {
                     $pesan_konfirmasi_detail = "Pembayaran Anda sedang diproses atau menunggu konfirmasi dari pihak payment gateway. Kami akan memberitahu Anda setelah statusnya diperbarui. Cek email Anda secara berkala atau halaman status pesanan.";
                }
                $ikon_konfirmasi = "fas fa-hourglass-half";
                $warna_ikon = "#f39c12"; // Oranye
                $link_lanjutan_dua = "<a href='#' class='btn btn-primary' onclick=\"alert('Silakan cek email Anda untuk instruksi pembayaran atau status dari Midtrans.'); return false;\"><i class='fas fa-wallet'></i> Cek Instruksi</a>";
                break;
            case 'failure':
            case 'error':
            case 'expire': 
            case 'cancel': 
            case 'deny': 
                $pesan_konfirmasi_utama = "Pembayaran Gagal";
                $pesan_konfirmasi_detail = "Maaf, pembayaran untuk pesanan Anda tidak berhasil diproses atau dibatalkan. Silakan coba lagi atau hubungi layanan pelanggan kami jika Anda memerlukan bantuan.";
                $ikon_konfirmasi = "fas fa-times-circle";
                $warna_ikon = "#e74c3c"; // Merah
                $link_lanjutan_dua = "<a href='pembayaran.php?order_id_ulang=" . htmlspecialchars($order_id_url) . "' class='btn btn-primary'><i class='fas fa-redo'></i> Coba Bayar Lagi</a>"; 
                break;
            case 'error_communication':
                 $pesan_konfirmasi_utama = "Error Komunikasi Server";
                 $pesan_konfirmasi_detail = "Terjadi kesalahan saat mengupdate status pembayaran Anda. Tim kami akan segera memeriksa. Mohon cek status pesanan Anda secara berkala atau hubungi customer service.";
                 $ikon_konfirmasi = "fas fa-exclamation-triangle";
                 $warna_ikon = "#e74c3c";
                break;
            default:
                $pesan_konfirmasi_utama = "Status Pesanan Tidak Diketahui";
                $pesan_konfirmasi_detail = "Status pembayaran untuk pesanan Anda tidak dapat kami tentukan saat ini (Status: ".htmlspecialchars($status_final_pembayaran)."). Silakan hubungi customer service untuk bantuan lebih lanjut.";
                $ikon_konfirmasi = "fas fa-question-circle";
                $warna_ikon = "#3498db";
                break;
        }

    } else {
        $pesan_konfirmasi_utama = "Pesanan Tidak Ditemukan";
        $pesan_konfirmasi_detail = "Maaf, kami tidak dapat menemukan detail pesanan dengan ID '".htmlspecialchars($order_id_url ?? '')."'. Pastikan ID Pesanan sudah benar atau hubungi kami.";
        $ikon_konfirmasi = "fas fa-search-minus";
        $warna_ikon = "#e74c3c";
    }
} else {
    $pesan_konfirmasi_utama = "Akses Tidak Valid";
    $pesan_konfirmasi_detail = "Halaman ini tidak dapat diakses secara langsung tanpa ID Pesanan yang valid.";
    $ikon_konfirmasi = "fas fa-ban";
    $warna_ikon = "#e74c3c";
}

if (!function_exists('format_rupiah')) {
    function format_rupiah($number) {
        return 'Rp ' . number_format(floatval($number), 0, ',', '.');
    }
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pesan_konfirmasi_utama); ?> - GoTravel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        html { height: 100%; }
        body { background-color: #f8f9fa; color: #333; line-height: 1.6; display: flex; flex-direction: column; min-height: 100vh;}
        main.confirmation-main-content { flex-grow: 1; padding-bottom: 3rem; }

        .hero { 
            min-height: 250px; 
            background-image: linear-gradient(rgba(0,0,0,0.55), rgba(0,0,0,0.55)), url('https://images.unsplash.com/photo-1507525428034-b723cf961d3e?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover; background-position: center; display: flex; justify-content: center; align-items: center;
            color: white; text-align: center; position: relative; padding: 20px;
        }
        .hero::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 60px; background: linear-gradient(to top, #f8f9fa, transparent); }
        .hero-content { z-index: 1; max-width: 700px; }
        .hero h1 { font-size: 2.2rem; margin-bottom: 0.8rem; text-shadow: 1px 1px 3px rgba(0,0,0,0.6); }
        
        .confirmation-container { max-width: 800px; margin: -50px auto 50px; padding: 0 1rem; position: relative; z-index: 2; }
        .confirmation-card {
            background-color: white; padding: 2.5rem; border-radius: 12px; 
            box-shadow: 0 8px 25px rgba(0,0,0,0.07); margin-bottom: 2rem;
        }
        
        .booking-progress { display: flex; justify-content: space-between; margin-bottom: 2.5rem; position:relative; }
        .progress-step { display: flex; flex-direction: column; align-items: center; text-align: center; flex: 1; position: relative; z-index: 1;}
        .step-number {
          width: 32px; height: 32px; border-radius: 50%; color: white;
          display: flex; justify-content: center; align-items: center; font-weight: bold; margin-bottom: 0.5rem; border: 2px solid; font-size:0.9rem;
        }
        .progress-step.completed .step-number { background-color: #158677; border-color: #158677; }
        .progress-step.active .step-number { background-color: #1a9988; border-color: #1a9988;}
        .progress-step:not(.active):not(.completed) .step-number { background-color: #e0f7f5; color: #1a9988; border-color: #1a9988; }
        
        .step-label { font-size: 0.8rem; font-weight: 500; }
        .progress-step.active .step-label, .progress-step.completed .step-label { color: #1a9988; font-weight: 600; }
        .progress-step:not(:last-child)::after {
            content: ''; position: absolute; top: 15px; left: 50%; width: 100%;
            height: 2px; z-index: -1; 
        }
        .progress-step.completed + .progress-step.completed::before,
        .progress-step.completed + .progress-step.active::before,
        .progress-step.active + .progress-step.active::before,
        .progress-step.completed::after,
        .progress-step.active::after { background-color: #1a9988; }
        
        .progress-step:not(:first-child)::before {
            content: ''; position: absolute; top: 15px; right: 50%; width: 100%;
            height: 2px; background-color: #e0f7f5; z-index: -1;
        }
        
        .section-title { color: #1a9988; margin-bottom: 1.5rem; font-size: 1.5rem; position: relative; padding-bottom: 8px; text-align:center; }
        .section-title::after { content: ''; position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); width: 60px; height: 3px; background-color: #1a9988; border-radius: 2px; }
        
        .status-display { text-align: center; margin-bottom: 2rem; }
        .status-icon {
            font-size: 3.5rem; margin-bottom: 1rem; display: inline-block;
            width: 80px; height: 80px; line-height:80px; text-align:center;
            background-color: #e9f5f3; border-radius: 50%;
        }
        .status-title { font-size: 1.8rem; color: #333; margin-bottom: 0.5rem; }
        .status-message { color: #555; font-size: 1.05rem; max-width:600px; margin:0 auto 1.5rem auto; }
        
        .booking-details-summary { background-color: #f9f9f9; border-radius: 8px; padding: 1.5rem; margin-bottom: 2rem; border:1px solid #eee;}
        .detail-row { display: flex; justify-content: space-between; margin-bottom: 0.8rem; padding-bottom: 0.8rem; border-bottom: 1px solid #e8e8e8; font-size:0.95rem; }
        .detail-row:last-child { border-bottom: none; margin-bottom: 0; padding-bottom: 0;}
        .detail-label { font-weight: 500; color: #444; }
        .detail-value { font-weight: 600; color: #222; text-align: right; }
        .detail-value.status-success { color: #2ecc71; font-weight:bold; }
        .detail-value.status-pending { color: #f39c12; font-weight:bold; }
        .detail-value.status-failure { color: #e74c3c; font-weight:bold; }

        .action-buttons { display: flex; flex-direction: column; gap: 1rem; margin-top: 2rem; align-items:center; }
        .btn {
          padding: 0.9rem 1.8rem; border-radius: 6px; font-size: 0.95rem; font-weight: 600; cursor: pointer;
          transition: all 0.3s ease; border: none; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem;
          min-width:220px; justify-content:center;
        }
        .btn i { font-size: 0.9em; }
        .btn-primary { background-color: #2c7a51; color: white; }
        .btn-primary:hover { background-color: #1e5a3a; }
        .btn-secondary { background-color: #6c757d; color: white; }
        .btn-secondary:hover { background-color: #5a6268; }

        @media (max-width: 768px) {
            .confirmation-container { padding: 0 1rem; margin-top:-30px; }
            .confirmation-card { padding: 1.5rem; }
            .hero h1 {font-size: 1.8rem;}
            .status-title {font-size:1.5rem;}
            .status-message {font-size:1rem;}
            .progress-step .step-label { font-size: 0.75rem; }
            .action-buttons { flex-direction: column; }
        }
    </style>
</head>
<body>
    <?php // Navbar sudah di-include ?>
    <main class="confirmation-main-content">
        <section class="hero">
            <div class="hero-content">
                <h1><?php echo htmlspecialchars($pesan_konfirmasi_utama); ?></h1>
            </div>
        </section>

        <div class="confirmation-container">
            <div class="confirmation-card">
                <div class="booking-progress">
                    <div class="progress-step completed"> <div class="step-number">1</div> <div class="step-label">Data Diri</div> </div>
                    <div class="progress-step completed"> <div class="step-number">2</div> <div class="step-label">Pembayaran</div> </div>
                    <div class="progress-step active">  <div class="step-number" style="background-color: <?php echo $warna_ikon; ?>; border-color: <?php echo $warna_ikon; ?>;">3</div> <div class="step-label" style="color:<?php echo $warna_ikon; ?>; font-weight:bold;">Selesai</div> </div>
                </div>
                
                <div class="status-display">
                    <div class="status-icon" style="background-color: <?php echo $warna_ikon."33"; ?>; color: <?php echo $warna_ikon; ?>;">
                        <i class="<?php echo $ikon_konfirmaci; ?>"></i>
                    </div>
                    <h2 class="status-title" style="color: <?php echo $warna_ikon; ?>;"><?php echo htmlspecialchars($pesan_konfirmasi_utama); ?></h2>
                    <p class="status-message"><?php echo $pesan_konfirmasi_detail; ?></p>
                </div>
                
                <?php if ($pemesanan_detail): ?>
                <div class="booking-details-summary">
                    <h3 class="section-title" style="font-size:1.3rem; margin-bottom:1rem; text-align:left; border-bottom:1px solid #eee; padding-bottom:0.5rem;">Detail Pesanan Anda:</h3>
                    <div class="detail-row">
                        <span class="detail-label">Kode Booking</span>
                        <span class="detail-value"><?php echo htmlspecialchars($pemesanan_detail['kode_pemesanan']); ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Nama Paket</span>
                        <span class="detail-value"><?php echo htmlspecialchars($pemesanan_detail['nama_paket']); ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Nama Pemesan</span>
                        <span class="detail-value"><?php echo htmlspecialchars($pemesanan_detail['nama_lengkap']); ?></span>
                    </div>
                    <?php if(isset($pemesanan_detail['tanggal_keberangkatan']) && !empty($pemesanan_detail['tanggal_keberangkatan'])): ?>
                    <div class="detail-row">
                        <span class="detail-label">Tgl. Keberangkatan</span>
                        <span class="detail-value"><?php echo htmlspecialchars(date('d F Y', strtotime($pemesanan_detail['tanggal_keberangkatan']))); ?></span>
                    </div>
                    <?php endif; ?>
                    <?php if(isset($pemesanan_detail['jumlah_peserta']) && $pemesanan_detail['jumlah_peserta'] > 0): ?>
                    <div class="detail-row">
                        <span class="detail-label">Jumlah Peserta</span>
                        <span class="detail-value"><?php echo htmlspecialchars($pemesanan_detail['jumlah_peserta']); ?> Orang</span>
                    </div>
                    <?php endif; ?>
                    <?php if(isset($pemesanan_detail['total_harga']) && $pemesanan_detail['total_harga'] > 0): ?>
                    <div class="detail-row">
                        <span class="detail-label">Total Pembayaran</span>
                        <span class="detail-value" style="color: #d9534f; font-weight:bold;"><?php echo format_rupiah($pemesanan_detail['total_harga']); ?></span>
                    </div>
                    <?php endif; ?>
                    <div class="detail-row">
                        <span class="detail-label">Status Pembayaran</span>
                        <span class="detail-value 
                            <?php 
                            $db_status_pembayaran = strtolower($pemesanan_detail['status_pemesanan']);
                            switch ($db_status_pembayaran) {
                                case 'success': 
                                case 'completed': // Tangani status completed sebagai sukses
                                case 'settlement': 
                                    echo 'status-success'; 
                                    break;
                                case 'pending': 
                                    echo 'status-pending'; 
                                    break;
                                case 'failure':
                                case 'error':
                                case 'expire': 
                                case 'cancel': 
                                case 'deny': 
                                    echo 'status-failure'; 
                                    break;
                                default: 
                                    echo 'status-failure'; 
                                    break;
                            }
                            ?>">
                            <?php echo htmlspecialchars(ucfirst($db_status_pembayaran)); ?>
                        </span>
                    </div>
                    <?php if ($transaction_id_url): ?>
                    <div class="detail-row">
                        <span class="detail-label">ID Transaksi</span>
                        <span class="detail-value"><?php echo htmlspecialchars($transaction_id_url); ?></span>
                    </div>
                    <?php endif; ?>
                     <?php if ($payment_method_url): ?>
                    <div class="detail-row">
                        <span class="detail-label">Metode Pembayaran</span>
                        <span class="detail-value"><?php echo htmlspecialchars(ucfirst($payment_method_url)); ?></span>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                <div class="action-buttons">
                    <?php echo $link_lanjutan_satu; ?>
                    <?php if (!empty($link_lanjutan_dua)) { echo $link_lanjutan_dua; } ?>
                </div>

            </div>
        </div>
    </main>
    <?php include 'Komponen/footer.php'; ?>
</body>
</html>