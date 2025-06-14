<?php
// order_detail.php

session_start();
require_once '../backend/koneksi.php'; // Sesuaikan path ke koneksi.php

// 1. Validasi dan ambil ID dari URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: manajemen_pemesanan.php");
    exit();
}
$id_pemesanan = $_GET['id'];

// 2. Query untuk mengambil data pemesanan secara lengkap
// PERBAIKAN: Mengganti p.nomor_telepon menjadi p.no_telepon
$sql = "SELECT
            p.id_pemesanan, p.kode_pemesanan, p.nama_lengkap, p.email, p.no_telepon, p.alamat,
            p.tanggal_keberangkatan, p.jumlah_peserta, p.total_harga, p.status_pemesanan,
            p.tanggal_pemesanan, p.catatan_tambahan,
            pw.nama_paket, pw.durasi_paket, pw.harga AS harga_satuan_paket,
            peng.avatar AS customer_avatar_url
        FROM pemesanan p
        JOIN paket_wisata pw ON p.id_paket_wisata = pw.id_paket_wisata
        LEFT JOIN pengunjung peng ON p.email = peng.email
        WHERE p.id_pemesanan = ?
        LIMIT 1";

$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}
$stmt->bind_param("i", $id_pemesanan);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();
$stmt->close();

if (!$order) {
    $_SESSION['error_message'] = "Pemesanan tidak ditemukan.";
    header("Location: manajemen_pemesanan.php");
    exit();
}

function get_initials($name) {
    $words = explode(' ', trim($name));
    $initials = '';
    if (count($words) >= 2) {
        $initials .= strtoupper(substr($words[0], 0, 1));
        $initials .= strtoupper(substr(end($words), 0, 1));
    } elseif (count($words) == 1 && !empty($words[0])) {
        $initials .= strtoupper(substr($words[0], 0, 1));
        if (strlen($words[0]) > 1) $initials .= strtoupper(substr($words[0], 1, 1));
    }
    return $initials ?: 'N/A';
}

$status_pemesanan_map = [
    'pending' => ['text' => 'Menunggu', 'class' => 'pending'],
    'completed' => ['text' => 'Dikonfirmasi', 'class' => 'confirmed'],
    'cancelled' => ['text' => 'Dibatalkan', 'class' => 'cancelled']
];

$payment_status_map = [
    'pending' => ['text' => 'Belum Bayar', 'class' => 'pending'],
    'completed' => ['text' => 'Lunas', 'class' => 'paid'],
    'cancelled' => ['text' => 'Dibatalkan', 'class' => 'cancelled']
];

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pemesanan - #<?php echo htmlspecialchars($order['kode_pemesanan']); ?></title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root { --primary-color: #3498db; --success-color: #27ae60; --danger-color: #e74c3c; --warning-color: #f39c12; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8f9fa; color: #333; }
        main { margin-left: 250px; padding: 20px; }
        .page-header { background: white; padding: 20px 25px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); display: flex; justify-content: space-between; align-items: center; }
        .page-header h1 { color: #2c3e50; font-size: 1.8rem; font-weight: 600; }
        .btn-back { background-color: #6c757d; color: white; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-weight: 500; transition: background-color 0.2s; display: inline-flex; align-items: center; gap: 8px; }
        .btn-back:hover { background-color: #5a6268; }
        
        .detail-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 20px; }
        .card { background: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-bottom: 20px; }
        .card-header { padding: 15px 20px; border-bottom: 1px solid #e9ecef; font-size: 1.2rem; font-weight: 600; color: #2c3e50; display: flex; align-items: center; gap: 10px; }
        .card-body { padding: 20px; }
        
        .info-list { list-style: none; }
        .info-list li { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #f1f3f4; }
        .info-list li:last-child { border-bottom: none; }
        .info-list .label { color: #6c757d; font-weight: 500; }
        .info-list .value { color: #2c3e50; font-weight: 500; text-align: right; }
        .info-list .value.large { font-size: 1.5rem; font-weight: 600; color: var(--primary-color); }

        .customer-profile { text-align: center; }
        .customer-avatar { width: 90px; height: 90px; border-radius: 50%; background-color: #6c757d; margin: 0 auto 15px auto; display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 2rem; overflow: hidden; border: 3px solid #e9ecef;}
        .customer-avatar img { width: 100%; height: 100%; object-fit: cover; }
        .customer-profile h3 { font-size: 1.3rem; color: #2c3e50; margin-bottom: 5px; }
        .customer-profile p { color: #6c757d; font-size: 0.9rem; }
        
        .status-badge { padding: 6px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 500; }
        .status-badge.confirmed, .status-badge.paid { background-color: #d4edda; color: #155724; }
        .status-badge.pending { background-color: #fff3cd; color: #856404; }
        .status-badge.cancelled { background-color: #f8d7da; color: #721c24; }

        @media (max-width: 1024px) { main { margin-left: 0; } }
        @media (max-width: 768px) { .detail-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <?php include '../Komponen/sidebar_admin.php'; // Sesuaikan path ?>
    <main>
        <div class="page-header">
            <h1><i class="fas fa-file-invoice" style="color: var(--primary-color);"></i> Detail Pemesanan</h1>
            <a href="pemesanan.php" class="btn-back"><i class="fas fa-arrow-left"></i> Kembali</a>
        </div>
        
        <div class="detail-grid">
            <div class="left-column">
                <div class="card">
                    <div class="card-header"><i class="fas fa-box" style="color: var(--warning-color);"></i> Detail Paket</div>
                    <div class="card-body">
                        <ul class="info-list">
                            <li><span class="label">Nama Paket</span><span class="value"><?php echo htmlspecialchars($order['nama_paket']); ?></span></li>
                            <li><span class="label">Durasi</span><span class="value"><?php echo htmlspecialchars($order['durasi_paket']); ?></span></li>
                            <li><span class="label">Tanggal Keberangkatan</span><span class="value"><?php echo date('d F Y', strtotime($order['tanggal_keberangkatan'])); ?></span></li>
                            <li><span class="label">Jumlah Peserta</span><span class="value"><?php echo htmlspecialchars($order['jumlah_peserta']); ?> Orang</span></li>
                        </ul>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header"><i class="fas fa-dollar-sign" style="color: var(--success-color);"></i> Rincian Biaya</div>
                    <div class="card-body">
                         <ul class="info-list">
                            <li><span class="label">Harga Satuan Paket</span><span class="value">Rp <?php echo number_format($order['harga_satuan_paket'], 0, ',', '.'); ?></span></li>
                            <li><span class="label">Jumlah Peserta</span><span class="value">x <?php echo htmlspecialchars($order['jumlah_peserta']); ?></span></li>
                            <hr>
                            <li><span class="label">Total Harga</span><span class="value large">Rp <?php echo number_format($order['total_harga'], 0, ',', '.'); ?></span></li>
                        </ul>
                    </div>
                </div>
                 <div class="card">
                    <div class="card-header"><i class="fas fa-info-circle"></i> Catatan Tambahan dari Pelanggan</div>
                    <div class="card-body">
                        <p><?php echo !empty($order['catatan_tambahan']) ? htmlspecialchars($order['catatan_tambahan']) : '<em>Tidak ada catatan tambahan.</em>'; ?></p>
                    </div>
                </div>
            </div>
            
            <div class="right-column">
                <div class="card">
                    <div class="card-header"><i class="fas fa-receipt" style="color: var(--primary-color);"></i> Info Pemesanan</div>
                    <div class="card-body">
                        <ul class="info-list">
                            <li><span class="label">Kode Pesanan</span><span class="value">#<?php echo htmlspecialchars($order['kode_pemesanan']); ?></span></li>
                            <li><span class="label">Tanggal Pesan</span><span class="value"><?php echo date('d M Y, H:i', strtotime($order['tanggal_pemesanan'])); ?></span></li>
                            <li><span class="label">Status Pesanan</span><span class="value"><span class="status-badge <?php echo $status_pemesanan_map[$order['status_pemesanan']]['class']; ?>"><?php echo $status_pemesanan_map[$order['status_pemesanan']]['text']; ?></span></span></li>
                            <li><span class="label">Status Bayar</span><span class="value"><span class="status-badge <?php echo $payment_status_map[$order['status_pemesanan']]['class']; ?>"><?php echo $payment_status_map[$order['status_pemesanan']]['text']; ?></span></span></li>
                        </ul>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header"><i class="fas fa-user-circle" style="color: var(--primary-color);"></i> Info Pelanggan</div>
                    <div class="card-body">
                        <div class="customer-profile">
                            <div class="customer-avatar">
                                <?php if (!empty($order['customer_avatar_url'])): ?>
                                    <img src="<?php echo htmlspecialchars($order['customer_avatar_url']); ?>" alt="Avatar">
                                <?php else: ?>
                                    <?php echo get_initials(htmlspecialchars($order['nama_lengkap'])); ?>
                                <?php endif; ?>
                            </div>
                            <h3><?php echo htmlspecialchars($order['nama_lengkap']); ?></h3>
                        </div>
                        <ul class="info-list">
                            <li><span class="label">Email</span><span class="value"><?php echo htmlspecialchars($order['email']); ?></span></li>
                            <li><span class="label">Telepon</span><span class="value"><?php echo htmlspecialchars($order['no_telepon'] ?: 'N/A'); ?></span></li>
                            <li><span class="label">Alamat</span><span class="value"><?php echo htmlspecialchars($order['alamat'] ?: 'N/A'); ?></span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>