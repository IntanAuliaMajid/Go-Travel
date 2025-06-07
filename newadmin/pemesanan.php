<?php
// Path ke file koneksi database Anda
require_once '../backend/koneksi.php';

// Helper function to get initials from a name
function get_initials($name) {
    $words = explode(' ', trim($name));
    $initials = '';
    if (count($words) >= 2) {
        $initials .= strtoupper(substr($words[0], 0, 1));
        $initials .= strtoupper(substr(end($words), 0, 1));
    } elseif (count($words) == 1 && !empty($words[0])) {
        $initials .= strtoupper(substr($words[0], 0, 1));
         if (strlen($words[0]) > 1) {
            $initials .= strtoupper(substr($words[0], 1, 1));
         }
    }
    return $initials ?: 'N/A';
}

// Helper function to calculate days remaining or past
function get_date_difference_text($target_date_str) {
    if (!$target_date_str) return 'N/A';
    try {
        $target_date = new DateTime($target_date_str);
        $today = new DateTime('today'); // Ensure time part is ignored for today

        if ($target_date < $today) {
            $diff = $today->diff($target_date);
            return $diff->days . " hari lalu";
        } else {
            $diff = $today->diff($target_date);
            if ($diff->days == 0) {
                return "Hari ini";
            }
            return $diff->days . " hari lagi";
        }
    } catch (Exception $e) {
        return 'Tanggal Invalid';
    }
}


// --- Fetch Stats ---
$stats = [
    'total' => 0,
    'confirmed' => 0, // Ini akan kita mapping dari 'completed'
    'pending' => 0,
    'cancelled' => 0
];

$result_total = $conn->query("SELECT COUNT(*) as count FROM pemesanan");
if ($result_total) $stats['total'] = $result_total->fetch_assoc()['count'];

// Asumsi: 'completed' di DB = 'Dikonfirmasi' di tampilan
// Asumsi: 'pending' di DB = 'Menunggu' di tampilan
// Asumsi: 'cancelled' di DB = 'Dibatalkan' di tampilan
$result_confirmed = $conn->query("SELECT COUNT(*) as count FROM pemesanan WHERE status_pemesanan = 'completed'");
if ($result_confirmed) $stats['confirmed'] = $result_confirmed->fetch_assoc()['count'];

$result_pending = $conn->query("SELECT COUNT(*) as count FROM pemesanan WHERE status_pemesanan = 'pending'");
if ($result_pending) $stats['pending'] = $result_pending->fetch_assoc()['count'];

// Jika Anda memiliki status 'cancelled' di database
$result_cancelled = $conn->query("SELECT COUNT(*) as count FROM pemesanan WHERE status_pemesanan = 'cancelled'");
if ($result_cancelled) $stats['cancelled'] = $result_cancelled->fetch_assoc()['count'];


// --- Handle Filters ---
$filter_payment_status = isset($_GET['payment_status']) ? $_GET['payment_status'] : '';
$filter_order_status = isset($_GET['order_status']) ? $_GET['order_status'] : '';
$filter_start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$filter_end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';

$where_clauses = [];
$params = [];
$types = "";

// Filter by payment status (derived from order_status for simplicity here)
if ($filter_payment_status === 'paid') { // 'Lunas'
    $where_clauses[] = "p.status_pemesanan = ?";
    $params[] = 'completed';
    $types .= "s";
} elseif ($filter_payment_status === 'pending') { // 'Belum Bayar'
    $where_clauses[] = "p.status_pemesanan = ?";
    $params[] = 'pending';
    $types .= "s";
}

// Filter by order status
if (!empty($filter_order_status)) {
    $where_clauses[] = "p.status_pemesanan = ?";
    $params[] = $filter_order_status;
    $types .= "s";
}

// Filter by date range (tanggal_pemesanan)
if (!empty($filter_start_date)) {
    $where_clauses[] = "p.tanggal_pemesanan >= ?";
    $params[] = $filter_start_date . " 00:00:00";
    $types .= "s";
}
if (!empty($filter_end_date)) {
    $where_clauses[] = "p.tanggal_pemesanan <= ?";
    $params[] = $filter_end_date . " 23:59:59";
    $types .= "s";
}

$sql_orders = "SELECT
                p.id_pemesanan, p.kode_pemesanan, p.nama_lengkap, p.email,
                pw.nama_paket, pw.durasi_paket, pw.harga AS harga_paket,
                p.tanggal_keberangkatan, p.jumlah_peserta,
                p.total_harga, p.status_pemesanan, p.tanggal_pemesanan,
                peng.avatar AS customer_avatar_url -- Assuming 'pengunjung' table has 'avatar' and can be joined by email or an ID
            FROM pemesanan p
            JOIN paket_wisata pw ON p.id_paket_wisata = pw.id_paket_wisata
            LEFT JOIN pengunjung peng ON p.email = peng.email -- Join to get avatar
            ";

if (!empty($where_clauses)) {
    $sql_orders .= " WHERE " . implode(" AND ", $where_clauses);
}
$sql_orders .= " ORDER BY p.tanggal_pemesanan DESC";

$stmt_orders = $conn->prepare($sql_orders);
if ($stmt_orders === false) {
    die("Error preparing statement: " . $conn->error);
}

if (!empty($params)) {
    $stmt_orders->bind_param($types, ...$params);
}

$result_orders = null;
if ($stmt_orders->execute()) {
    $result_orders = $stmt_orders->get_result();
} else {
    die("Error executing statement: " . $stmt_orders->error);
}

// For status mapping in the table (DB status => Display Text, CSS Class)
$status_pemesanan_map = [
    'pending' => ['text' => 'Menunggu', 'class' => 'pending'],
    'completed' => ['text' => 'Dikonfirmasi', 'class' => 'confirmed'], // 'completed' is mapped to 'Dikonfirmasi' for order status
    'cancelled' => ['text' => 'Dibatalkan', 'class' => 'cancelled']
    // Add other statuses if they exist in your DB
];

$payment_status_map = [ // Derived from status_pemesanan for this example
    'pending' => ['text' => 'Belum Bayar', 'class' => 'pending'],
    'completed' => ['text' => 'Lunas', 'class' => 'paid'],
    'cancelled' => ['text' => 'N/A', 'class' => 'cancelled'] // Or how you want to represent payment for cancelled
];


?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manajemen Order - Admin</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f8f9fa;
      color: #333;
    }

    main {
      margin-left: 250px; /* Adjust this if your sidebar width is different */
      padding: 20px;
      min-height: 100vh;
    }

    .page-header {
      background: white; padding: 20px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .page-header h1 {
      color: #2c3e50; font-size: 1.8rem; font-weight: 600; display: flex; align-items: center; gap: 10px;
    }
    .page-header p { color: #6c757d; margin-top: 5px; font-size: 1rem; }

    .stats-grid {
      display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 20px;
    }
    .stat-card {
      background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);
      display: flex; align-items: center; gap: 15px;
    }
    .stat-icon {
      width: 50px; height: 50px; border-radius: 8px; display: flex; align-items: center; justify-content: center;
      font-size: 1.2rem; color: white;
    }
    .stat-icon.total { background-color: #3498db; }
    .stat-icon.confirmed { background-color: #27ae60; }
    .stat-icon.pending { background-color: #f39c12; }
    .stat-icon.cancelled { background-color: #e74c3c; }
    .stat-info h3 { font-size: 1.8rem; font-weight: 600; color: #2c3e50; margin-bottom: 2px; }
    .stat-info p { color: #6c757d; font-size: 0.9rem; }

    .filter-section {
      background: white; padding: 20px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .filter-grid {
      display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 15px; align-items: end;
    }
    .filter-group label {
      display: block; color: #2c3e50; font-weight: 500; margin-bottom: 5px; font-size: 0.9rem;
    }
    .filter-group input, .filter-group select {
      width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 0.9rem;
      transition: border-color 0.2s ease;
    }
    .filter-group input:focus, .filter-group select:focus { outline: none; border-color: #3498db; }
    .btn-filter {
      background-color: #3498db; color: white; border: none; padding: 10px 20px; border-radius: 6px;
      font-size: 0.9rem; font-weight: 500; cursor: pointer; transition: background-color 0.2s ease;
      display: flex; align-items: center; gap: 8px; height:41px; /* Match input height */
    }
    .btn-filter:hover { background-color: #2980b9; }

    .table-container {
      background: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow-x: auto;
    }
    .table-header { padding: 20px; border-bottom: 1px solid #e9ecef; }
    .table-header h2 {
      font-size: 1.3rem; color: #2c3e50; font-weight: 600; display: flex; align-items: center; gap: 10px;
    }
    .order-table { width: 100%; border-collapse: collapse; }
    .order-table thead { background-color: #f8f9fa; }
    .order-table th {
      padding: 15px; text-align: left; color: #495057; font-weight: 600; font-size: 0.85rem;
      text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid #dee2e6;
    }
    .order-table td {
      padding: 15px; color: #495057; font-size: 0.9rem; border-bottom: 1px solid #f1f3f4; vertical-align: middle;
    }
    .order-table tbody tr:hover { background-color: #f8f9fa; }

    .status-badge {
      padding: 6px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 500;
      text-transform: uppercase; letter-spacing: 0.3px; display: inline-block;
    }
    .status-badge.confirmed { background-color: #d4edda; color: #155724; } /* Dikonfirmasi */
    .status-badge.pending { background-color: #fff3cd; color: #856404; }   /* Menunggu & Belum Bayar */
    .status-badge.cancelled { background-color: #f8d7da; color: #721c24; } /* Dibatalkan */
    .status-badge.paid { background-color: #d1ecf1; color: #0c5460; }      /* Lunas */

    .action-buttons { display: flex; gap: 5px; }
    .btn-action {
      padding: 8px 10px; border: none; border-radius: 6px; font-size: 0.8rem; cursor: pointer;
      color: white; transition: opacity 0.2s ease; display: flex; align-items: center;
      justify-content: center; min-width: 35px;
    }
    .btn-action:hover { opacity: 0.8; }
    .btn-view { background-color: #3498db; }
    .btn-confirm { background-color: #27ae60; }
    .btn-cancel { background-color: #e74c3c; }
    .btn-edit { background-color: #f39c12; }

    .customer-info { display: flex; align-items: center; gap: 10px; }
    .customer-avatar {
      width: 35px; height: 35px; border-radius: 50%; background-color: #6c757d;
      display: flex; align-items: center; justify-content: center; color: white;
      font-weight: 500; font-size: 0.8rem; overflow: hidden;
    }
    .customer-avatar img { width: 100%; height: 100%; object-fit: cover; }
    .customer-details h4 { color: #2c3e50; font-size: 0.9rem; font-weight: 500; margin-bottom: 1px; }
    .customer-details p { color: #6c757d; font-size: 0.75rem; }

    .package-info { display: flex; align-items: center; gap: 10px; }
    /* .package-icon (style if needed) */

    @media (max-width: 1024px) {
      /* Sidebar toggle for mobile in your sidebar_admin.php JS */
      main { margin-left: 0; }
      .stats-grid { grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); }
    }
    @media (max-width: 768px) {
      main { padding: 15px; }
      .filter-grid { grid-template-columns: 1fr; }
      .order-table { font-size: 0.8rem; }
      .order-table th, .order-table td { padding: 10px; }
      .action-buttons { flex-direction: row; gap: 3px; } /* Keep horizontal for small screens if space allows */
      .customer-info, .package-info { /* flex-direction: column; align-items: flex-start; */ gap: 5px; }
    }

  </style>
</head>
<body>
  <?php include '../Komponen/sidebar_admin.php'; // Pastikan path ini benar ?>
  <main>
    <div class="page-header">
      <h1><i class="fas fa-file-invoice"></i> Manajemen Pemesanan</h1>
      <p>Kelola dan pantau semua pemesanan wisata Anda</p>
    </div>

    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-icon total"><i class="fas fa-file-alt"></i></div>
        <div class="stat-info">
          <h3><?php echo $stats['total']; ?></h3>
          <p>Total Pemesanan</p>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-icon confirmed"><i class="fas fa-check-circle"></i></div>
        <div class="stat-info">
          <h3><?php echo $stats['confirmed']; ?></h3>
          <p>Dikonfirmasi</p>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-icon pending"><i class="fas fa-clock"></i></div>
        <div class="stat-info">
          <h3><?php echo $stats['pending']; ?></h3>
          <p>Menunggu</p>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-icon cancelled"><i class="fas fa-times-circle"></i></div>
        <div class="stat-info">
          <h3><?php echo $stats['cancelled']; ?></h3>
          <p>Dibatalkan</p>
        </div>
      </div>
    </div>

    <div class="filter-section">
      <form method="GET" action="">
        <div class="filter-grid">
          <div class="filter-group">
            <label for="payment_status">Status Pembayaran</label>
            <select name="payment_status" id="payment_status">
              <option value="">Semua Pembayaran</option>
              <option value="paid" <?php echo ($filter_payment_status == 'paid') ? 'selected' : ''; ?>>Lunas</option>
              <option value="pending" <?php echo ($filter_payment_status == 'pending') ? 'selected' : ''; ?>>Belum Bayar</option>
            </select>
          </div>
          <div class="filter-group">
            <label for="order_status">Status Order</label>
            <select name="order_status" id="order_status">
              <option value="">Semua Status Order</option>
              <option value="completed" <?php echo ($filter_order_status == 'completed') ? 'selected' : ''; ?>>Dikonfirmasi</option>
              <option value="pending" <?php echo ($filter_order_status == 'pending') ? 'selected' : ''; ?>>Menunggu</option>
              <option value="cancelled" <?php echo ($filter_order_status == 'cancelled') ? 'selected' : ''; ?>>Dibatalkan</option>
            </select>
          </div>
          <div class="filter-group">
            <label for="start_date">Tanggal Mulai (Pemesanan)</label>
            <input type="date" name="start_date" id="start_date" value="<?php echo htmlspecialchars($filter_start_date); ?>">
          </div>
          <div class="filter-group">
            <label for="end_date">Tanggal Akhir (Pemesanan)</label>
            <input type="date" name="end_date" id="end_date" value="<?php echo htmlspecialchars($filter_end_date); ?>">
          </div>
          <div class="filter-group">
            <button type="submit" class="btn-filter">
              <i class="fas fa-search"></i> Filter
            </button>
          </div>
        </div>
      </form>
    </div>

    <div class="table-container">
      <div class="table-header">
        <h2><i class="fas fa-list"></i> Daftar Pemesanan</h2>
      </div>
      <table class="order-table">
        <thead>
          <tr>
            <th>ID Pesanan</th>
            <th>Pemesan</th>
            <th>Paket Wisata</th>
            <th>Tgl Keberangkatan</th>
            <th>Peserta</th>
            <th>Pembayaran</th>
            <th>Status Order</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($result_orders && $result_orders->num_rows > 0): ?>
            <?php while($row = $result_orders->fetch_assoc()): ?>
              <tr>
                <td><strong><?php echo htmlspecialchars($row['kode_pemesanan'] ?: '#' . $row['id_pemesanan']); ?></strong></td>
                <td>
                  <div class="customer-info">
                    <div class="customer-avatar">
                        <?php if (!empty($row['customer_avatar_url'])): ?>
                            <img src="<?php echo htmlspecialchars($row['customer_avatar_url']); ?>" alt="Avatar">
                        <?php else: ?>
                            <?php echo get_initials(htmlspecialchars($row['nama_lengkap'])); ?>
                        <?php endif; ?>
                    </div>
                    <div class="customer-details">
                      <h4><?php echo htmlspecialchars($row['nama_lengkap']); ?></h4>
                      <p><?php echo htmlspecialchars($row['email']); ?></p>
                    </div>
                  </div>
                </td>
                <td>
                  <div class="package-info">
                    <div>
                      <strong><?php echo htmlspecialchars($row['nama_paket']); ?></strong>
                      <br><small><?php echo htmlspecialchars($row['durasi_paket']); ?> - Rp <?php echo number_format($row['total_harga'], 0, ',', '.'); ?></small>
                    </div>
                  </div>
                </td>
                <td>
                  <strong><?php echo date('d M Y', strtotime($row['tanggal_keberangkatan'])); ?></strong>
                  <br><small><?php echo get_date_difference_text($row['tanggal_keberangkatan']); ?></small>
                </td>
                <td>
                  <strong><?php echo htmlspecialchars($row['jumlah_peserta']); ?> Orang</strong>
                  </td>
                <td>
                  <?php
                    $current_payment_status_key = $row['status_pemesanan']; // Using order status to derive payment status
                    $payment_display = isset($payment_status_map[$current_payment_status_key]) ? $payment_status_map[$current_payment_status_key] : ['text' => 'N/A', 'class' => ''];
                  ?>
                  <span class="status-badge <?php echo htmlspecialchars($payment_display['class']); ?>">
                    <?php echo htmlspecialchars($payment_display['text']); ?>
                  </span>
                </td>
                <td>
                  <?php
                    $current_order_status_key = $row['status_pemesanan'];
                    $order_display = isset($status_pemesanan_map[$current_order_status_key]) ? $status_pemesanan_map[$current_order_status_key] : ['text' => ucfirst($current_order_status_key), 'class' => ''];
                  ?>
                  <span class="status-badge <?php echo htmlspecialchars($order_display['class']); ?>">
                    <?php echo htmlspecialchars($order_display['text']); ?>
                  </span>
                </td>
                <td>
                  <div class="action-buttons">
                    <a href="order_detail.php?id=<?php echo $row['id_pemesanan']; ?>" class="btn-action btn-view" title="Lihat Detail">
                      <i class="fas fa-eye"></i>
                    </a>
                    <a href="order_edit.php?id=<?php echo $row['id_pemesanan']; ?>" class="btn-action btn-edit" title="Edit">
                      <i class="fas fa-edit"></i>
                    </a>
                    <?php if ($row['status_pemesanan'] === 'pending'): ?>
                      <a href="order_action.php?action=confirm&id=<?php echo $row['id_pemesanan']; ?>" class="btn-action btn-confirm" title="Konfirmasi Order" onclick="return confirm('Konfirmasi pemesanan ini?')">
                        <i class="fas fa-check"></i>
                      </a>
                    <?php endif; ?>
                     <?php if ($row['status_pemesanan'] !== 'cancelled' && $row['status_pemesanan'] !== 'completed'): ?>
                      <a href="order_action.php?action=cancel&id=<?php echo $row['id_pemesanan']; ?>" class="btn-action btn-cancel" title="Batalkan Order" onclick="return confirm('Anda yakin ingin membatalkan pemesanan ini?')">
                        <i class="fas fa-times"></i>
                      </a>
                    <?php endif; ?>
                  </div>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr>
              <td colspan="8" style="text-align: center; padding: 20px;">Tidak ada data pemesanan ditemukan.</td>
            </tr>
          <?php endif; ?>
          <?php if($stmt_orders) $stmt_orders->close(); ?>
        </tbody>
      </table>
    </div>
  </main>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Placeholder for any specific JS for this page if needed in future
      // e.g., more complex filter interactions, AJAX updates, etc.
      // The action buttons now use <a> tags for direct navigation or can be handled with JS for AJAX.
    });
  </script>
</body>
</html>