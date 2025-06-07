<?php
include 'backend/koneksi.php'; // Include your database connection
include 'Komponen/navbar.php'; // Assuming this is your navbar component

// --- Simulate logged-in user ---
// In a real application, this would come from your login system.
// Make sure the email used here exists in your 'pemesanan' table for testing.
if (!isset($_SESSION['user_email'])) {
    // For demonstration, if no user is logged in, redirect to a login page or set a default.
    // For this example, I'll set a default user email that has bookings in your sample data.
    $_SESSION['user_email'] = 'tuhu@gmail.com'; 
    // You should replace this with actual login logic.
    // If you want to test with no bookings, set an email that has no bookings or leave it empty and handle appropriately.
}
$currentUserEmail = $_SESSION['user_email'] ?? null; // Use null coalescing operator

// --- Handle Filters ---
$statusFilter = isset($_GET['status-filter']) ? $conn->real_escape_string($_GET['status-filter']) : '';
$dateFromFilter = isset($_GET['date-from']) ? $conn->real_escape_string($_GET['date-from']) : '';
$dateToFilter = isset($_GET['date-to']) ? $conn->real_escape_string($_GET['date-to']) : '';

// --- Initialize arrays and variables ---
$bookings = [];
$totalBookingsCount = 0;
$completedBookingsCount = 0;
$totalSpentAmount = 0;

if ($currentUserEmail) {
    // --- Build SQL Query for Bookings ---
    $sqlBookings = "SELECT p.*, 
                           pw.nama_paket, 
                           pw.durasi_paket, 
                           w.nama_wisata, 
                           l.nama_lokasi,
                           COALESCE(
                               (SELECT g.url FROM gambar g WHERE g.wisata_id = pw.id_wisata ORDER BY g.id_gambar ASC LIMIT 1), 
                               pw.denah_lokasi
                           ) as gambar_url_paket
                    FROM pemesanan p
                    JOIN paket_wisata pw ON p.id_paket_wisata = pw.id_paket_wisata
                    JOIN wisata w ON pw.id_wisata = w.id_wisata
                    JOIN lokasi l ON w.id_lokasi = l.id_lokasi
                    WHERE p.email = ? ";

    $params = [$currentUserEmail];
    $types = "s";

    if (!empty($statusFilter)) {
        $sqlBookings .= " AND p.status_pemesanan = ?";
        $types .= "s";
        $params[] = $statusFilter;
    }
    if (!empty($dateFromFilter)) {
        // Assuming tanggal_pemesanan is the booking creation date
        $sqlBookings .= " AND DATE(p.tanggal_pemesanan) >= ?"; 
        $types .= "s";
        $params[] = $dateFromFilter;
    }
    if (!empty($dateToFilter)) {
        $sqlBookings .= " AND DATE(p.tanggal_pemesanan) <= ?";
        $types .= "s";
        $params[] = $dateToFilter;
    }
    $sqlBookings .= " ORDER BY p.tanggal_pemesanan DESC";

    $stmtBookings = $conn->prepare($sqlBookings);
    if ($stmtBookings) {
        $stmtBookings->bind_param($types, ...$params);
        $stmtBookings->execute();
        $resultBookings = $stmtBookings->get_result();
        while ($row = $resultBookings->fetch_assoc()) {
            $bookings[] = $row;
        }
        $stmtBookings->close();
    } else {
        // Handle error, e.g., log it or display a user-friendly message
        error_log("Error preparing bookings statement: " . $conn->error);
        // Optionally, display a message to the user
        // echo "<p class='container'>Error fetching booking data. Please try again later.</p>";
    }

    // --- Fetch Stats ---
    // Total Bookings for user
    $sqlTotal = "SELECT COUNT(*) as total FROM pemesanan WHERE email = ?";
    $stmtTotal = $conn->prepare($sqlTotal);
    if ($stmtTotal) {
        $stmtTotal->bind_param("s", $currentUserEmail);
        $stmtTotal->execute();
        $totalBookingsCount = $stmtTotal->get_result()->fetch_assoc()['total'] ?? 0;
        $stmtTotal->close();
    } else {
        error_log("Error preparing total bookings statement: " . $conn->error);
    }


    // Completed Bookings for user
    $sqlCompleted = "SELECT COUNT(*) as total FROM pemesanan WHERE email = ? AND status_pemesanan = 'completed'";
    $stmtCompleted = $conn->prepare($sqlCompleted);
     if ($stmtCompleted) {
        $stmtCompleted->bind_param("s", $currentUserEmail);
        $stmtCompleted->execute();
        $completedBookingsCount = $stmtCompleted->get_result()->fetch_assoc()['total'] ?? 0;
        $stmtCompleted->close();
    } else {
        error_log("Error preparing completed bookings statement: " . $conn->error);
    }

    // Total Spent for user (on completed bookings, or all depending on preference)
    // Let's consider all non-cancelled bookings for total spent for now.
    $sqlSpent = "SELECT SUM(total_harga) as total_spent FROM pemesanan WHERE email = ? AND status_pemesanan != 'cancelled'";
    $stmtSpent = $conn->prepare($sqlSpent);
    if ($stmtSpent) {
        $stmtSpent->bind_param("s", $currentUserEmail);
        $stmtSpent->execute();
        $totalSpentAmount = $stmtSpent->get_result()->fetch_assoc()['total_spent'] ?? 0;
        $stmtSpent->close();
    } else {
        error_log("Error preparing total spent statement: " . $conn->error);
    }
    $totalSpentAmount = $totalSpentAmount ?: 0; // Ensure it's at least 0 if null
}

// Helper function to determine status class
function getStatusClass($status) {
    switch (strtolower($status)) {
        case 'completed': return 'status-completed';
        case 'pending': return 'status-pending';
        case 'cancelled': return 'status-cancelled';
        case 'processing': // Assuming your DB might use 'processing' or similar for Midtrans
        case 'paid': // Or other paid statuses from payment gateway
            return 'status-processing'; // Or a specific 'status-paid'
        default: return 'status-pending'; // Default for unknown statuses
    }
}
function getStatusText($status) {
    switch (strtolower($status)) {
        case 'completed': return 'Selesai';
        case 'pending': return 'Menunggu Pembayaran';
        case 'cancelled': return 'Dibatalkan';
        case 'processing': return 'Diproses';
        case 'paid': return 'Telah Dibayar'; // Example
        default: return ucfirst($status);
    }
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Riwayat Pemesanan</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
    /* Header */
    .history-header {
      background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), 
                  url('https://www.ruparupa.com/blog/wp-content/uploads/2022/03/Jakarta_Batavia_%C2%A9-CEphoto-Uwe-Aranas.jpg') no-repeat center center/cover;
      height: 60vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      color: #fff;
      padding: 2rem;
      margin-top: 20px; /* Adjust if navbar is fixed or has height */
    }

    .history-header h1 {
      margin-top: 50px; /* Adjust as needed */
      font-size: 3rem;
      margin-bottom: 1rem;
      text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);
    }

    .history-header p {
      font-size: 1.2rem;
      max-width: 800px;
      margin-bottom: 2rem;
    }

    /* Container */
    .container {
      max-width: 1200px;
      margin: 2rem auto;
      padding: 0 1rem;
    }

    /* Filter Section */
    .filter-section {
      background-color: #fff;
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      margin-bottom: 2rem;
    }
    .filter-section form { /* Added to make the filter a form */
        display: contents;
    }

    .filter-row {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 1rem;
      align-items: end;
    }

    .filter-group {
      display: flex;
      flex-direction: column;
    }

    .filter-group label {
      margin-bottom: 0.5rem;
      font-weight: bold;
      color: #333;
    }

    .filter-group select,
    .filter-group input[type="date"] { /* Specific to date input */
      padding: 0.75rem;
      border: 2px solid #ddd;
      border-radius: 5px;
      font-size: 1rem;
      transition: border-color 0.3s;
      box-sizing: border-box; /* Ensures padding doesn't add to width */
      width: 100%; /* Make inputs take full width of their grid cell */
    }

    .filter-group select:focus,
    .filter-group input[type="date"]:focus {
      outline: none;
      border-color: #2c7a51;
    }

    .filter-button {
      background-color: #2c7a51;
      color: white;
      border: none;
      padding: 0.75rem 1.5rem;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s;
      font-size: 1rem;
      width: 100%; /* Make button take full width of its grid cell */
      height: calc(0.75rem * 2 + 1rem + 4px + 0.7rem); /* Match input height approx */
    }

    .filter-button:hover {
      background-color: #1d5b3a;
    }

    /* Stats Section */
    .stats-section {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 1.5rem;
      margin-bottom: 2rem;
    }

    .stat-card {
      background: linear-gradient(135deg, #2c7a51, #34a85f);
      color: white;
      padding: 2rem;
      border-radius: 10px;
      text-align: center;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .stat-card i {
      font-size: 3rem;
      margin-bottom: 1rem;
      opacity: 0.8;
    }

    .stat-card h3 {
      font-size: 2rem;
      margin-bottom: 0.5rem;
    }

    .stat-card p {
      opacity: 0.9;
    }

    /* Empty State */
    .empty-history {
      text-align: center;
      padding: 4rem 0;
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .empty-history i {
      font-size: 5rem;
      color: #ff6b6b; /* Changed to a less aggressive red */
      margin-bottom: 1.5rem;
    }

    .empty-history h3 {
      font-size: 1.8rem;
      margin-bottom: 1rem;
      color: #333;
    }

    .empty-history p {
      color: #666;
      margin-bottom: 2rem;
      max-width: 500px;
      margin-left: auto;
      margin-right: auto;
    }

    .explore-button {
      background-color: #2c7a51;
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
      background-color: #1d5b3a;
    }

    /* Booking Cards */
    .bookings-grid {
      display: flex;
      flex-direction: column;
      gap: 1.5rem;
    }

    .booking-card {
      background-color: #fff;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s, box-shadow 0.3s;
    }

    .booking-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .booking-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 1.5rem;
      background: linear-gradient(135deg, #f8f9fa, #e9ecef);
      border-bottom: 1px solid #dee2e6;
    }

    .booking-id {
      font-weight: bold;
      color: #333;
    }

    .booking-status {
      padding: 0.5rem 1rem;
      border-radius: 50px;
      font-size: 0.85rem;
      font-weight: bold;
      text-transform: uppercase;
    }

    .status-completed { background-color: #d4edda; color: #155724; }
    .status-pending { background-color: #fff3cd; color: #856404; }
    .status-cancelled { background-color: #f8d7da; color: #721c24; }
    .status-processing { background-color: #d1ecf1; color: #0c5460; } /* For 'paid' or 'processing' */


    .booking-content {
      display: grid;
      grid-template-columns: 200px 1fr;
      gap: 1.5rem;
      padding: 1.5rem;
    }

    .booking-image {
      border-radius: 8px;
      overflow: hidden;
    }

    .booking-image img {
      width: 100%;
      height: 150px;
      object-fit: cover;
    }

    .booking-details h3 {
      margin-bottom: 0.5rem;
      font-size: 1.4rem;
      color: #333;
    }

    .booking-info {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 1rem;
      margin-bottom: 1rem;
    }

    .info-item {
      display: flex;
      align-items: center;
      color: #666;
      font-size: 0.95rem;
    }

    .info-item i {
      margin-right: 0.5rem;
      color: #2c7a51;
      width: 16px;
    }

    .booking-footer {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 1.5rem;
      border-top: 1px solid #dee2e6;
      background-color: #f8f9fa;
    }

    .booking-total {
      font-size: 1.2rem;
      font-weight: bold;
      color: #2c7a51;
    }

    .booking-actions {
      display: flex;
      gap: 1rem;
    }

    .action-button {
      padding: 0.5rem 1rem;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      text-decoration: none;
      font-size: 0.9rem;
      transition: all 0.3s;
    }

    .btn-primary {
      background-color: #2c7a51;
      color: white;
    }

    .btn-primary:hover {
      background-color: #1d5b3a;
    }

    .btn-secondary {
      background-color: #6c757d;
      color: white;
    }

    .btn-secondary:hover {
      background-color: #5a6268;
    }

    .btn-danger {
      background-color: #dc3545;
      color: white;
    }

    .btn-danger:hover {
      background-color: #c82333;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      .history-header h1 {
        font-size: 2.5rem;
      }

      .filter-row {
        grid-template-columns: 1fr; /* Stack filters on smaller screens */
      }

      .stats-section {
        grid-template-columns: 1fr;
      }

      .booking-content {
        grid-template-columns: 1fr; /* Stack image and details */
      }
       .booking-image img {
        height: 200px; /* Adjust image height for stacked layout */
      }

      .booking-info {
        grid-template-columns: 1fr;
      }

      .booking-footer {
        flex-direction: column;
        gap: 1rem;
        align-items: stretch;
      }
      .booking-actions {
        justify-content: center;
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
    
    .notification.info {
      background-color: #17a2b8;
    }

    .notification.warning {
      background-color: #ffc107;
      color: #333; /* Darker text for yellow background */
    }
  </style>
</head>
<body>
  <section class="history-header">
    <h1>Riwayat Pemesanan</h1>
    <p>Lihat dan kelola semua pemesanan destinasi wisata Anda</p>
  </section>

  <section class="container">
    
    <?php if ($currentUserEmail): ?>
    <div class="filter-section">
      <form method="GET" action="riwayat_pemesanan.php"> <div class="filter-row">
          <div class="filter-group">
            <label for="status-filter">Status Pemesanan</label>
            <select id="status-filter" name="status-filter">
              <option value="" <?= $statusFilter == '' ? 'selected' : '' ?>>Semua Status</option>
              <option value="completed" <?= $statusFilter == 'completed' ? 'selected' : '' ?>>Selesai</option>
              <option value="pending" <?= $statusFilter == 'pending' ? 'selected' : '' ?>>Menunggu Pembayaran</option>
              <option value="processing" <?= $statusFilter == 'processing' ? 'selected' : '' ?>>Diproses</option>
              <option value="paid" <?= $statusFilter == 'paid' ? 'selected' : '' ?>>Telah Dibayar</option>
              <option value="cancelled" <?= $statusFilter == 'cancelled' ? 'selected' : '' ?>>Dibatalkan</option>
            </select>
          </div>
          <div class="filter-group">
            <label for="date-from">Dari Tanggal Pemesanan</label>
            <input type="date" id="date-from" name="date-from" value="<?= htmlspecialchars($dateFromFilter) ?>">
          </div>
          <div class="filter-group">
            <label for="date-to">Sampai Tanggal Pemesanan</label>
            <input type="date" id="date-to" name="date-to" value="<?= htmlspecialchars($dateToFilter) ?>">
          </div>
          <div class="filter-group">
            <button type="submit" class="filter-button"> <i class="fas fa-search"></i> Filter
            </button>
          </div>
        </div>
      </form>
    </div>

    <div class="stats-section">
      <div class="stat-card">
        <i class="fas fa-clipboard-list"></i>
        <h3 id="total-bookings"><?= $totalBookingsCount ?></h3>
        <p>Total Pemesanan</p>
      </div>
      <div class="stat-card">
        <i class="fas fa-check-circle"></i>
        <h3 id="completed-bookings"><?= $completedBookingsCount ?></h3>
        <p>Pemesanan Selesai</p>
      </div>
      <div class="stat-card">
        <i class="fas fa-money-bill-wave"></i>
        <h3 id="total-spent">Rp <?= number_format($totalSpentAmount, 0, ',', '.') ?></h3>
        <p>Total Pengeluaran</p>
      </div>
    </div>

    <div class="bookings-grid" id="bookings-container">
      <?php if (count($bookings) > 0): ?>
        <?php foreach ($bookings as $booking): ?>
          <div class="booking-card" data-status="<?= htmlspecialchars(strtolower($booking['status_pemesanan'])) ?>" data-date="<?= date('Y-m-d', strtotime($booking['tanggal_pemesanan'])) ?>">
            <div class="booking-header">
              <div class="booking-id">
                <i class="fas fa-ticket-alt"></i> 
                Booking #<?= htmlspecialchars($booking['kode_pemesanan']) ?>
              </div>
              <span class="booking-status <?= getStatusClass($booking['status_pemesanan']) ?>">
                  <?= getStatusText($booking['status_pemesanan']) ?>
              </span>
            </div>
            <div class="booking-content">
              <div class="booking-image">
                <img src="<?= htmlspecialchars(!empty($booking['gambar_url_paket']) ? $booking['gambar_url_paket'] : 'https://via.placeholder.com/200x150.png?text=No+Image+Available') ?>" alt="<?= htmlspecialchars($booking['nama_paket']) ?>">
              </div>
              <div class="booking-details">
                <h3><?= htmlspecialchars($booking['nama_paket']) ?></h3>
                <div class="booking-info">
                  <div class="info-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <span><?= htmlspecialchars($booking['nama_lokasi']) ?></span>
                  </div>
                  <div class="info-item">
                    <i class="fas fa-calendar"></i>
                    <span><?= date('d M Y', strtotime($booking['tanggal_keberangkatan'])) ?></span>
                  </div>
                  <div class="info-item">
                    <i class="fas fa-users"></i>
                    <span><?= htmlspecialchars($booking['jumlah_peserta']) ?> Orang</span>
                  </div>
                  <div class="info-item">
                    <i class="fas fa-clock"></i>
                    <span><?= htmlspecialchars($booking['durasi_paket']) ?></span>
                  </div>
                </div>
              </div>
            </div>
            <div class="booking-footer">
              <div class="booking-total">Total: Rp <?= number_format($booking['total_harga'], 0, ',', '.') ?></div>
              <div class="booking-actions">
                <a href="detail_pemesanan.php?kode_pemesanan=<?= htmlspecialchars($booking['kode_pemesanan']) ?>" class="action-button btn-primary">Lihat Detail</a>
                <?php if (strtolower($booking['status_pemesanan']) == 'completed' || strtolower($booking['status_pemesanan']) == 'paid' || strtolower($booking['status_pemesanan']) == 'processing'): ?>
                  <button class="action-button btn-secondary" onclick="downloadInvoice('<?= htmlspecialchars($booking['kode_pemesanan']) ?>')">
                    <i class="fas fa-download"></i> Invoice
                  </button>
                <?php endif; ?>
                <?php if (strtolower($booking['status_pemesanan']) == 'pending'): ?>
                  <a href="pembayaran.php?kode_pemesanan=<?= htmlspecialchars($booking['kode_pemesanan']) ?>" class="action-button btn-primary">Bayar Sekarang</a>
                   <button class="action-button btn-danger" onclick="cancelBooking('<?= htmlspecialchars($booking['kode_pemesanan']) ?>')">
                    Batalkan
                  </button>
                <?php endif; ?>
                <?php if (strtolower($booking['status_pemesanan']) == 'completed' || strtolower($booking['status_pemesanan']) == 'cancelled'): ?>
                <button class="action-button btn-primary" onclick="bookAgain(<?= $booking['id_paket_wisata'] ?>)">
                  Pesan Lagi
                </button>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="empty-history" id="empty-state">
          <i class="fas fa-box-open"></i> <h3>Belum Ada Riwayat Pemesanan</h3>
          <p>
            <?php if (!empty($statusFilter) || !empty($dateFromFilter) || !empty($dateToFilter)): ?>
                Tidak ada pemesanan yang cocok dengan filter Anda. Coba sesuaikan filter atau lihat semua pemesanan.
            <?php else: ?>
                Anda belum melakukan pemesanan destinasi wisata. Mulai petualangan Anda dengan menjelajahi destinasi menarik yang tersedia.
            <?php endif; ?>
          </p>
          <a href="destinasi.php" class="explore-button">Jelajahi Destinasi</a>
           <?php if (!empty($statusFilter) || !empty($dateFromFilter) || !empty($dateToFilter)): ?>
             <a href="riwayat_pemesanan.php" class="action-button btn-secondary" style="margin-left: 10px;">Reset Filter</a>
           <?php endif; ?>
        </div>
      <?php endif; ?>
    </div>
    <?php else: ?>
        <div class="empty-history">
            <i class="fas fa-sign-in-alt"></i>
            <h3>Silakan Login</h3>
            <p>Anda perlu login untuk melihat riwayat pemesanan Anda.</p>
            <a href="login.php" class="explore-button">Login Sekarang</a>
        </div>
    <?php endif; ?>
  </section>

  <?php include 'Komponen/footer.php'; ?>

  <script>
    // JavaScript functions remain largely the same, 
    // but filtering is now handled by PHP on page reload.
    // The JS can still be used for purely client-side interactions like notifications.

    function cancelBooking(kodePemesanan) {
      if (confirm('Apakah Anda yakin ingin membatalkan pemesanan #' + kodePemesanan + '? Tindakan ini mungkin tidak dapat diurungkan.')) {
        // You would typically make an AJAX call to a PHP script to update the database
        // For now, let's simulate and then reload or update UI
        showNotification(`Pemesanan #${kodePemesanan} sedang diproses untuk pembatalan...`, 'info');
        
        // Example: Simulate an API call
        // fetch('api/cancel_booking.php', {
        //   method: 'POST',
        //   headers: {'Content-Type': 'application/json'},
        //   body: JSON.stringify({ kode_pemesanan: kodePemesanan })
        // })
        // .then(response => response.json())
        // .then(data => {
        //   if (data.success) {
        //     showNotification(`Pemesanan #${kodePemesanan} berhasil dibatalkan.`, 'success');
        //     setTimeout(() => location.reload(), 1500);
        //   } else {
        //     showNotification(`Gagal membatalkan pemesanan: ${data.message}`, 'warning');
        //   }
        // })
        // .catch(err => {
        //    showNotification('Terjadi kesalahan saat menghubungi server.', 'warning');
        // });
        
        // For demo without actual backend for cancel:
        alert(`Pembatalan untuk ${kodePemesanan} akan membutuhkan implementasi backend. Untuk demo, status tidak akan berubah.`);
        // To make it appear cancelled on the frontend for demo:
        // const card = document.querySelector(`.booking-card[data-booking-id="${kodePemesanan}"]`);
        // if (card) {
        //   const statusElement = card.querySelector('.booking-status');
        //   statusElement.className = 'booking-status status-cancelled';
        //   statusElement.textContent = 'Dibatalkan';
        //   card.dataset.status = 'cancelled';
        //   // Remove pay/cancel buttons if any
        // }
      }
    }

    function downloadInvoice(kodePemesanan) {
      showNotification(`Mengunduh invoice untuk ${kodePemesanan}...`, 'info');
      // In a real app, you'd redirect to a PHP script that generates and serves the PDF invoice
      // window.location.href = `generate_invoice.php?kode_pemesanan=${kodePemesanan}`;
      setTimeout(() => {
        showNotification('Fitur unduh invoice akan segera tersedia.', 'info');
      }, 1500);
    }

    function bookAgain(idPaketWisata) {
        // Redirect to the detail page of the package, so user can book it again.
        // Make sure you have a page like 'detail_paket.php' or similar that accepts 'id_paket_wisata'.
        window.location.href = `detail_paket.php?id=${idPaketWisata}`;
    }

    // Notification system
    function showNotification(message, type = 'success') {
      const notification = document.createElement('div');
      notification.className = `notification ${type}`;
      notification.textContent = message;
      document.body.appendChild(notification);
      
      setTimeout(() => {
        notification.classList.add('show');
      }, 10); // Slight delay to allow CSS transition
      
      setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => {
          if (document.body.contains(notification)) {
            document.body.removeChild(notification);
          }
        }, 300); // Wait for fade out transition
      }, 3000); // Notification visible for 3 seconds
    }

    // No need for applyFilters() JS if PHP handles it on reload.
    // updateStats() is also not needed as stats are from PHP.
  </script>
</body>
</html>
<?php
$conn->close();
?>