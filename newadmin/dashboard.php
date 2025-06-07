<?php
// Corrected path assuming 'new_admin' and 'backend' are sibling directories
require_once '../backend/koneksi.php'; 

// Helper function to format time ago
function time_ago($timestamp) {
    if ($timestamp === null) return 'N/A';
    $time_ago = strtotime($timestamp);
    $current_time = time();
    $time_difference = $current_time - $time_ago;
    $seconds = $time_difference;
    $minutes      = round($seconds / 60);
    $hours           = round($seconds / 3600);
    $days          = round($seconds / 86400);
    $weeks          = round($seconds / 604800);
    $months      = round($seconds / 2629440);
    $years          = round($seconds / 31553280);

    if ($seconds <= 60) {
        return "Baru saja";
    } else if ($minutes <= 60) {
        return ($minutes == 1) ? "1 menit lalu" : "$minutes menit lalu";
    } else if ($hours <= 24) {
        return ($hours == 1) ? "1 jam lalu" : "$hours jam lalu";
    } else if ($days <= 7) {
        return ($days == 1) ? "Kemarin" : "$days hari lalu";
    } else if ($weeks <= 4.3) {
        return ($weeks == 1) ? "1 minggu lalu" : "$weeks minggu lalu";
    } else if ($months <= 12) {
        return ($months == 1) ? "1 bulan lalu" : "$months bulan lalu";
    } else {
        return ($years == 1) ? "1 tahun lalu" : "$years tahun lalu";
    }
}

// --- Fetch Stats ---
$total_paket_result = $conn->query("SELECT COUNT(*) as total FROM paket_wisata");
$total_paket = ($total_paket_result->num_rows > 0) ? $total_paket_result->fetch_assoc()['total'] : 0;

$current_month = date('m');
$current_year = date('Y');

$pemesanan_bulan_ini_result = $conn->query("SELECT COUNT(*) as total FROM pemesanan WHERE MONTH(tanggal_pemesanan) = '$current_month' AND YEAR(tanggal_pemesanan) = '$current_year'");
$pemesanan_bulan_ini = ($pemesanan_bulan_ini_result->num_rows > 0) ? $pemesanan_bulan_ini_result->fetch_assoc()['total'] : 0;

$pendapatan_bulan_ini_result = $conn->query("SELECT SUM(gross_amount_paid) as total FROM pemesanan WHERE MONTH(tanggal_pemesanan) = '$current_month' AND YEAR(tanggal_pemesanan) = '$current_year' AND status_pemesanan = 'completed'");
$pendapatan_bulan_ini_raw = ($pendapatan_bulan_ini_result->num_rows > 0) ? $pendapatan_bulan_ini_result->fetch_assoc()['total'] : 0;
$pendapatan_bulan_ini_formatted = "Rp " . number_format($pendapatan_bulan_ini_raw ?? 0, 0, ',', '.');

$wisatawan_bulan_ini_result = $conn->query("SELECT SUM(jumlah_peserta) as total FROM pemesanan WHERE MONTH(tanggal_keberangkatan) = '$current_month' AND YEAR(tanggal_keberangkatan) = '$current_year' AND (status_pemesanan = 'completed' OR status_pemesanan = 'confirmed')");
$wisatawan_bulan_ini = ($wisatawan_bulan_ini_result->num_rows > 0) ? $wisatawan_bulan_ini_result->fetch_assoc()['total'] : 0;
$wisatawan_bulan_ini = $wisatawan_bulan_ini ?? 0;


// --- Fetch Recent Activities ---
$latest_pemesanan = null;
$latest_pemesanan_result = $conn->query("
    SELECT p.nama_lengkap, pw.nama_paket, p.tanggal_pemesanan, p.status_pemesanan
    FROM pemesanan p
    JOIN paket_wisata pw ON p.id_paket_wisata = pw.id_paket_wisata
    ORDER BY p.tanggal_pemesanan DESC
    LIMIT 1
");
if ($latest_pemesanan_result && $latest_pemesanan_result->num_rows > 0) {
    $latest_pemesanan = $latest_pemesanan_result->fetch_assoc();
}

$latest_pembayaran = null;
$latest_pembayaran_result = $conn->query("
    SELECT p.nama_lengkap, pw.nama_paket, p.tanggal_pemesanan
    FROM pemesanan p
    JOIN paket_wisata pw ON p.id_paket_wisata = pw.id_paket_wisata
    WHERE p.status_pemesanan = 'completed'
    ORDER BY p.tanggal_pemesanan DESC
    LIMIT 1
");
if ($latest_pembayaran_result && $latest_pembayaran_result->num_rows > 0) {
    $latest_pembayaran = $latest_pembayaran_result->fetch_assoc();
}

$latest_paket_added = null;
$latest_paket_added_result = $conn->query("
    SELECT nama_paket, id_paket_wisata
    FROM paket_wisata
    ORDER BY id_paket_wisata DESC
    LIMIT 1
");
if ($latest_paket_added_result && $latest_paket_added_result->num_rows > 0) {
    $latest_paket_added = $latest_paket_added_result->fetch_assoc();
}

$latest_review = null;
$latest_review_result = $conn->query("
    SELECT u.komentar, w.nama_wisata, pj.nama_depan, pj.nama_belakang, u.rating, u.id_ulasan
    FROM ulasan u
    JOIN wisata w ON u.id_wisata = w.id_wisata
    LEFT JOIN pengunjung pj ON u.id_pengunjung = pj.id_pengunjung
    ORDER BY u.id_ulasan DESC
    LIMIT 1
");
if ($latest_review_result && $latest_review_result->num_rows > 0) {
    $latest_review = $latest_review_result->fetch_assoc();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Admin - Paket Wisata</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
      color: #333;
    }

    main {
      margin-left: 220px; /* Adjust if your sidebar width from sidebar_admin.php is different */
      padding: 30px;
      min-height: 100vh;
      transition: margin-left 0.3s ease;
    }

    /* Dashboard Header */
    .dashboard-header {
      background: white;
      padding: 25px 30px;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
      margin-bottom: 30px;
      border-left: 5px solid #e67e22;
      position: relative;
      overflow: hidden;
    }

    .dashboard-header::before {
      content: '';
      position: absolute;
      top: 0;
      right: 0;
      width: 100px;
      height: 100px;
      background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="%23e67e22" stroke-width="1" opacity="0.1"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>') no-repeat center;
      background-size: contain;
    }

    .dashboard-header h1 {
      font-size: 2.2rem;
      color: #2c3e50;
      margin-bottom: 10px;
      font-weight: 600;
    }

    .dashboard-header p {
      color: #7f8c8d;
      font-size: 1.1rem;
    }

    /* Stats Cards */
    .stats-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 25px;
      margin-bottom: 30px;
    }

    .stat-card {
      background: white;
      padding: 25px;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      position: relative;
      overflow: hidden;
    }

    .stat-card.orange::before {
      background: linear-gradient(90deg, #e67e22, #d35400);
    }

    .stat-card.blue::before {
      background: linear-gradient(90deg, #3498db, #2980b9);
    }

    .stat-card.green::before {
      background: linear-gradient(90deg, #27ae60, #2ecc71);
    }

    .stat-card.purple::before {
      background: linear-gradient(90deg, #9b59b6, #8e44ad);
    }

    .stat-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
    }

    .stat-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }

    .stat-card h3 {
      font-size: 2rem;
      color: #2c3e50;
      margin-bottom: 10px;
    }

    .stat-card p {
      color: #7f8c8d;
      font-size: 1rem;
      margin-bottom: 15px;
    }
    .stat-card small {
        font-size: 0.85rem;
    }

    .stat-icon {
      position: absolute;
      top: 20px;
      right: 20px;
      font-size: 2.5rem;
      opacity: 0.3;
    }

    .stat-card.orange .stat-icon { color: #e67e22; }
    .stat-card.blue .stat-icon { color: #3498db; }
    .stat-card.green .stat-icon { color: #27ae60; }
    .stat-card.purple .stat-icon { color: #9b59b6; }

    /* Quick Actions (Style from original HTML, can be removed if not used) */
    .quick-actions {
      background: white;
      padding: 25px;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
      margin-bottom: 30px;
    }
    .quick-actions h2 {
      color: #2c3e50; margin-bottom: 20px; font-size: 1.5rem; display: flex; align-items: center; gap: 10px;
    }
    .action-buttons {
      display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;
    }
    .action-btn {
      background: linear-gradient(135deg, #e67e22, #d35400); color: white; padding: 15px 20px; border: none; border-radius: 10px;
      cursor: pointer; transition: all 0.3s ease; font-size: 1rem; text-align: center; text-decoration: none;
      display: flex; align-items: center; justify-content: center; gap: 10px;
    }
    .action-btn:hover {
      transform: translateY(-2px); box-shadow: 0 10px 20px rgba(230, 126, 34, 0.3);
    }
    /* End Quick Actions Style */

    /* Recent Activity */
    .recent-activity {
      background: white;
      padding: 25px;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .recent-activity h2 {
      color: #2c3e50;
      margin-bottom: 20px;
      font-size: 1.5rem;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .activity-item {
      padding: 15px 0;
      border-bottom: 1px solid #ecf0f1;
      display: flex;
      align-items: center;
      gap: 15px;
    }

    .activity-item:last-child {
      border-bottom: none;
    }

    .activity-icon {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      flex-shrink: 0;
    }

    .activity-icon.orange { background: #e67e22; }
    .activity-icon.blue { background: #3498db; }
    .activity-icon.green { background: #27ae60; }
    .activity-icon.purple { background: #9b59b6; }

    .activity-text {
      flex: 1;
    }

    .activity-text h4 {
      color: #2c3e50;
      margin-bottom: 5px;
      font-size: 0.95rem;
    }

    .activity-text p {
      color: #7f8c8d;
      font-size: 0.9rem;
    }

    .activity-time {
      color: #95a5a6;
      font-size: 0.8rem;
      text-align: right;
    }
    .activity-time small {
        display: block;
        margin-top: 4px;
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
      /* Adjust sidebar behavior for mobile in your sidebar_admin.php or its CSS */
      main {
        margin-left: 0; /* Or a smaller margin if sidebar is toggleable */
        padding: 20px;
      }
      .dashboard-header h1 { font-size: 1.8rem; }
      .stats-container { grid-template-columns: 1fr; }
      .action-buttons { grid-template-columns: 1fr; } /* If using quick actions */
      .activity-item { flex-direction: column; align-items: flex-start; }
      .activity-time { text-align: left; margin-top: 5px; }
    }

    /* Status badges */
    .status-badge {
      padding: 4px 8px; border-radius: 12px; font-size: 0.8rem; font-weight: 500; display: inline-block;
    }
    .status-badge.pending { background: #fff3cd; color: #856404; }
    .status-badge.confirmed, .status-badge.completed, .status-badge.paid, .status-badge.lunas { background: #d4edda; color: #155724; }
    .status-badge.cancelled, .status-badge.failed { background: #f8d7da; color: #721c24; }
    .status-badge.approved { background-color: #cce5ff; color: #004085; }
    .status-badge.new { background-color: #d1ecf1; color: #0c5460; }
  </style>
</head>
<body>
  <?php 
    // This is your original sidebar include. 
    // Ensure the path is correct relative to this file's location (new_admin/dashboard_paket.php)
    // If 'komponen' is a sibling folder to 'new_admin', this path is correct.
    include '../komponen/sidebar_admin.php'; 
  ?>

  <main>
    <div class="dashboard-header">
      <h1><i class="fas fa-map-marked-alt" style="color: #e67e22; margin-right: 10px;"></i>Dashboard Paket Wisata</h1>
      <p>Kelola pemesanan dan paket wisata dengan mudah. Selamat datang di panel administrasi.</p>
    </div>

    <div class="stats-container">
      <div class="stat-card orange">
        <div class="stat-icon"><i class="fas fa-suitcase-rolling"></i></div>
        <h3><?php echo $total_paket; ?></h3>
        <p>Total Paket Wisata</p>
      </div>
      
      <div class="stat-card blue">
        <div class="stat-icon"><i class="fas fa-calendar-check"></i></div>
        <h3><?php echo $pemesanan_bulan_ini; ?></h3>
        <p>Pemesanan Bulan Ini</p>
      </div>
      
      <div class="stat-card green">
        <div class="stat-icon"><i class="fas fa-money-bill-wave"></i></div>
        <h3><?php echo $pendapatan_bulan_ini_formatted; ?></h3>
        <p>Pendapatan Bulan Ini</p>
      </div>
      
      <div class="stat-card purple">
        <div class="stat-icon"><i class="fas fa-users"></i></div>
        <h3><?php echo $wisatawan_bulan_ini; ?></h3>
        <p>Total Wisatawan Bulan Ini</p>
      </div>
    </div>

    <div class="recent-activity">
      <h2><i class="fas fa-history"></i> Aktivitas Terbaru</h2>
      
      <?php if ($latest_pemesanan): ?>
      <div class="activity-item">
        <div class="activity-icon orange"><i class="fas fa-shopping-cart"></i></div>
        <div class="activity-text">
          <h4>Pemesanan Baru - <?php echo htmlspecialchars($latest_pemesanan['nama_paket']); ?></h4>
          <p><?php echo htmlspecialchars($latest_pemesanan['nama_lengkap']); ?> memesan paket <?php echo htmlspecialchars($latest_pemesanan['nama_paket']); ?></p>
        </div>
        <div class="activity-time">
          <span class="status-badge <?php echo strtolower(htmlspecialchars($latest_pemesanan['status_pemesanan'])); ?>">
            <?php echo ucfirst(htmlspecialchars($latest_pemesanan['status_pemesanan'])); ?>
          </span><br>
          <small><?php echo time_ago($latest_pemesanan['tanggal_pemesanan']); ?></small>
        </div>
      </div>
      <?php endif; ?>
      
      <?php if ($latest_pembayaran): ?>
      <div class="activity-item">
        <div class="activity-icon green"><i class="fas fa-check-circle"></i></div>
        <div class="activity-text">
          <h4>Pembayaran Dikonfirmasi</h4>
          <p>Pembayaran untuk paket <?php echo htmlspecialchars($latest_pembayaran['nama_paket']); ?> (<?php echo htmlspecialchars($latest_pembayaran['nama_lengkap']); ?>) telah dikonfirmasi.</p>
        </div>
        <div class="activity-time">
          <span class="status-badge completed">Lunas</span><br>
          <small><?php echo time_ago($latest_pembayaran['tanggal_pemesanan']); ?></small>
        </div>
      </div>
      <?php endif; ?>
      
      <?php if ($latest_paket_added): ?>
      <div class="activity-item">
        <div class="activity-icon blue"><i class="fas fa-map-pin"></i></div>
        <div class="activity-text">
          <h4>Paket Wisata Baru Ditambahkan</h4>
          <p>Paket "<?php echo htmlspecialchars($latest_paket_added['nama_paket']); ?>" telah ditambahkan ke katalog.</p>
        </div>
        <div class="activity-time">
          <small>ID: <?php echo $latest_paket_added['id_paket_wisata']; ?></small>
        </div>
      </div>
      <?php endif; ?>
      
      <?php if ($latest_review): ?>
      <div class="activity-item">
        <div class="activity-icon purple"><i class="fas fa-star"></i></div>
        <div class="activity-text">
          <h4>Review Baru (<?php echo $latest_review['rating'] ?> <i class="fas fa-star" style="color: #f1c40f;"></i>)</h4>
          <p>
            <?php 
            $reviewer_name = "Anonim";
            if (!empty($latest_review['nama_depan'])) {
                $reviewer_name = htmlspecialchars(trim($latest_review['nama_depan'] . ' ' . $latest_review['nama_belakang']));
            }
            echo $reviewer_name; 
            ?>
            memberikan review untuk <?php echo htmlspecialchars($latest_review['nama_wisata']); ?>: "<?php echo htmlspecialchars(substr($latest_review['komentar'], 0, 50)) . (strlen($latest_review['komentar']) > 50 ? '...' : ''); ?>"
          </p>
        </div>
        <div class="activity-time">
          <small>Ulasan ID: <?php echo $latest_review['id_ulasan']; ?></small>
        </div>
      </div>
      <?php endif; ?>

      <?php if (!$latest_pemesanan && !$latest_pembayaran && !$latest_paket_added && !$latest_review): ?>
        <p>Tidak ada aktivitas terbaru.</p>
      <?php endif; ?>

    </div>
  </main>
</body>
</html>