<?php
include "Komponen/navbar.php"; // Pastikan path ini benar
include "backend/koneksi.php"; // Pastikan path ini benar

// Cek login
if (!isset($_SESSION['user']['email'])) {
    echo '<section class="container" style="padding-top:100px;"><h3>Anda harus login untuk melihat riwayat pemesanan.</h3></section>';
    include 'Komponen/footer.php';
    exit;
}

$email_pengunjung = $_SESSION['user']['email'];

// Query untuk mengambil semua riwayat pemesanan
$query = "SELECT p.*, pw.nama_paket, pw.id_paket_wisata 
          FROM pemesanan p
          INNER JOIN paket_wisata pw ON p.id_paket_wisata = pw.id_paket_wisata
          WHERE p.email = ?
          ORDER BY p.tanggal_pemesanan DESC";
          
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email_pengunjung);
$stmt->execute();
$result = $stmt->get_result();
$riwayat = [];

while ($row = $result->fetch_assoc()) {
    // Ambil gambar paket
    $gambar_sql = "SELECT url_gambar FROM gambar_paket 
                   WHERE id_paket_wisata = ? 
                   ORDER BY is_thumbnail DESC, id_gambar_paket ASC 
                   LIMIT 1";
    $gambar_stmt = $conn->prepare($gambar_sql);
    $gambar_stmt->bind_param("i", $row['id_paket_wisata']);
    $gambar_stmt->execute();
    $gambar_result = $gambar_stmt->get_result();
    $gambar_row = $gambar_result->fetch_assoc();
    
    $row['gambar_url'] = $gambar_row ? 'uploads/paket/' . $gambar_row['url_gambar'] : 'img/default_package.jpg';
    $gambar_stmt->close();
    
    $riwayat[] = $row;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Riwayat Pemesanan - <?php echo htmlspecialchars($_SESSION['user']['nama'] ?? 'User'); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        body {
            padding-top: 80px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color:rgb(6, 80, 4);
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            color: #fff; /* Changed for better contrast on green background */
        }
        
        .header h1 {
            color: #fff; /* Changed for better contrast */
            margin-bottom: 10px;
        }
        
        .header p {
            color: #ccc; /* Lighter text for description */
        }

        .riwayat-list {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
        }
        
        .riwayat-item {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
            display: flex;
        }
        
        .riwayat-image {
            width: 200px;
            height: 150px;
            object-fit: cover;
        }
        
        .riwayat-content {
            padding: 15px;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between; /* To push button to bottom */
        }
        
        .riwayat-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }
        
        .riwayat-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 10px;
            font-size: 14px;
            color: #666;
        }
        
        .riwayat-meta div {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .riwayat-status {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 13px;
            font-weight: bold;
        }
        
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .status-completed {
            background-color: #d4edda;
            color: #155724;
        }
        
        .status-cancelled {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .no-history {
            text-align: center;
            padding: 50px 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .no-history i {
            font-size: 50px;
            color: #ddd;
            margin-bottom: 15px;
        }
        
        .no-history h3 {
            color: #555;
            margin-bottom: 10px;
        }
        
        .btn {
            display: inline-block;
            padding: 8px 16px;
            background: #2c7a51;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
            margin-top: 10px;
        }

        .btn-actions-group { /* New style for grouping action buttons */
            display: flex;
            gap: 10px; /* Space between buttons */
            margin-top: 10px;
            flex-wrap: wrap; /* Allow wrapping on small screens */
        }

        .btn-pay {
            background-color: #007bff;
            color: white;
            padding: 8px 16px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 14px;
        }
        .btn-pay:hover {
            background-color: #0056b3;
        }

        .btn-cancel { /* New style for cancel button */
            background-color: #dc3545; /* Red color for cancellation */
            color: white;
            padding: 8px 16px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 14px;
        }
        .btn-cancel:hover {
            background-color: #c82333;
        }
        
        @media (max-width: 768px) {
            .riwayat-item {
                flex-direction: column;
            }
            
            .riwayat-image {
                width: 100%;
                height: 150px;
            }
            .btn-actions-group {
                justify-content: center; /* Center buttons on small screens */
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Riwayat Pemesanan</h1>
            <p>Daftar semua pemesanan yang pernah Anda lakukan</p>
        </div>
        
        <div class="riwayat-list">
            <?php if (!empty($riwayat)): ?>
                <?php foreach ($riwayat as $item): ?>
                    <div class="riwayat-item">
                        <img src="<?php echo htmlspecialchars($item['gambar_url']); ?>" 
                             alt="<?php echo htmlspecialchars($item['nama_paket']); ?>"
                             class="riwayat-image"
                             onerror="this.onerror=null;this.src='img/default_package.jpg';">
                             
                        <div class="riwayat-content">
                            <div> <div class="riwayat-title"><?php echo htmlspecialchars($item['nama_paket']); ?></div>
                                
                                <div class="riwayat-meta">
                                    <div>
                                        <i class="fas fa-tag"></i>
                                        <span><?php echo htmlspecialchars($item['kode_pemesanan']); ?></span>
                                    </div>
                                    
                                    <div>
                                        <i class="far fa-calendar-alt"></i>
                                        <span><?php echo date('d M Y', strtotime($item['tanggal_pemesanan'])); ?></span>
                                    </div>
                                    
                                    <div>
                                        <i class="fas fa-users"></i>
                                        <span><?php echo htmlspecialchars($item['jumlah_peserta']); ?> orang</span>
                                    </div>
                                    
                                    <div>
                                        <i class="fas fa-money-bill-wave"></i>
                                        <span>Rp<?php echo number_format($item['total_harga'], 0, ',', '.'); ?></span>
                                    </div>
                                </div>
                            </div>

                            <div> <span class="riwayat-status status-<?php echo strtolower($item['status_pemesanan']); ?>">
                                    <?php echo ucfirst($item['status_pemesanan']); ?>
                                </span>
                                <?php if ($item['status_pemesanan'] == 'pending'): ?>
                                    <div class="btn-actions-group">
                                        <a href="pembayaran.php?order_id=<?php echo htmlspecialchars($item['kode_pemesanan']); ?>" class="btn-pay">Bayar Sekarang</a>
                                        <a href="backend/cancel_pemesanan.php?order_id=<?php echo htmlspecialchars($item['kode_pemesanan']); ?>" class="btn-cancel" onclick="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?');">Batalkan</a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="no-history">
                    <i class="fas fa-box-open"></i>
                    <h3>Belum Ada Riwayat Pemesanan</h3>
                    <p>Anda belum pernah melakukan pemesanan paket wisata</p>
                    <a href="paket_wisata.php" class="btn">Lihat Paket Wisata</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php include "Komponen/footer.php"; ?>
</body>
</html>