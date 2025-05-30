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
      margin-top: 20px;
    }

    .history-header h1 {
      margin-top: 50px;
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
    .filter-group input {
      padding: 0.75rem;
      border: 2px solid #ddd;
      border-radius: 5px;
      font-size: 1rem;
      transition: border-color 0.3s;
    }

    .filter-group select:focus,
    .filter-group input:focus {
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
      color: #ff6b6b;
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
    .status-processing { background-color: #d1ecf1; color: #0c5460; }

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
        grid-template-columns: 1fr;
      }

      .stats-section {
        grid-template-columns: 1fr;
      }

      .booking-content {
        grid-template-columns: 1fr;
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
      color: #333;
    }
  </style>
</head>
<body>
  <?php include 'Komponen/navbar.php'; ?>

  <!-- History Header -->
  <section class="history-header">
    <h1>Riwayat Pemesanan</h1>
    <p>Lihat dan kelola semua pemesanan destinasi wisata Anda</p>
  </section>

  <!-- Main Content -->
  <section class="container">
    
    <!-- Filter Section -->
    <div class="filter-section">
      <div class="filter-row">
        <div class="filter-group">
          <label for="status-filter">Status Pemesanan</label>
          <select id="status-filter">
            <option value="">Semua Status</option>
            <option value="completed">Selesai</option>
            <option value="pending">Menunggu</option>
            <option value="processing">Diproses</option>
            <option value="cancelled">Dibatalkan</option>
          </select>
        </div>
        <div class="filter-group">
          <label for="date-from">Dari Tanggal</label>
          <input type="date" id="date-from">
        </div>
        <div class="filter-group">
          <label for="date-to">Sampai Tanggal</label>
          <input type="date" id="date-to">
        </div>
        <div class="filter-group">
          <button class="filter-button" onclick="applyFilters()">
            <i class="fas fa-search"></i> Filter
          </button>
        </div>
      </div>
    </div>

    <!-- Stats Section -->
    <div class="stats-section">
      <div class="stat-card">
        <i class="fas fa-clipboard-list"></i>
        <h3 id="total-bookings">12</h3>
        <p>Total Pemesanan</p>
      </div>
      <div class="stat-card">
        <i class="fas fa-check-circle"></i>
        <h3 id="completed-bookings">8</h3>
        <p>Pemesanan Selesai</p>
      </div>
      <div class="stat-card">
        <i class="fas fa-money-bill-wave"></i>
        <h3 id="total-spent">Rp 15.6M</h3>
        <p>Total Pengeluaran</p>
      </div>
    </div>

    <!-- Empty State (hidden by default) -->
    <div class="empty-history" id="empty-state" style="display: none;">
      <i class="fas fa-clipboard-list"></i>
      <h3>Belum Ada Riwayat Pemesanan</h3>
      <p>Anda belum melakukan pemesanan destinasi wisata. Mulai petualangan Anda dengan menjelajahi destinasi menarik yang tersedia.</p>
      <a href="destinasi.php" class="explore-button">Jelajahi Destinasi</a>
    </div>

    <!-- Bookings Grid -->
    <div class="bookings-grid" id="bookings-container">
      
      <!-- Booking 1 -->
      <div class="booking-card" data-status="completed" data-date="2024-12-15">
        <div class="booking-header">
          <div class="booking-id">
            <i class="fas fa-ticket-alt"></i> 
            Booking #TRV-2024-001
          </div>
          <span class="booking-status status-completed">Selesai</span>
        </div>
        <div class="booking-content">
          <div class="booking-image">
            <img src="https://www.nativeindonesia.com/foto/2024/07/sunset-di-pantai-lorena.jpg" alt="Pantai Lorena">
          </div>
          <div class="booking-details">
            <h3>Pantai Lorena</h3>
            <div class="booking-info">
              <div class="info-item">
                <i class="fas fa-map-marker-alt"></i>
                <span>Lamongan, Jawa Timur</span>
              </div>
              <div class="info-item">
                <i class="fas fa-calendar"></i>
                <span>15 Desember 2024</span>
              </div>
              <div class="info-item">
                <i class="fas fa-users"></i>
                <span>2 Orang</span>
              </div>
              <div class="info-item">
                <i class="fas fa-clock"></i>
                <span>3 Hari 2 Malam</span>
              </div>
            </div>
          </div>
        </div>
        <div class="booking-footer">
          <div class="booking-total">Total: Rp 2.700.000</div>
          <div class="booking-actions">
            <a href="#" class="action-button btn-primary">Lihat Detail</a>
            <button class="action-button btn-secondary" onclick="downloadInvoice('TRV-2024-001')">
              <i class="fas fa-download"></i> Invoice
            </button>
            <button class="action-button btn-primary" onclick="bookAgain('pantai-lorena')">
              Pesan Lagi
            </button>
          </div>
        </div>
      </div>

      <!-- Booking 2 -->
      <div class="booking-card" data-status="processing" data-date="2024-12-20">
        <div class="booking-header">
          <div class="booking-id">
            <i class="fas fa-ticket-alt"></i> 
            Booking #TRV-2024-002
          </div>
          <span class="booking-status status-processing">Diproses</span>
        </div>
        <div class="booking-content">
          <div class="booking-image">
            <img src="https://salsawisata.com/wp-content/uploads/2022/07/Wisata-Bahari-Lamongan.jpg" alt="Wisata Bahari Lamongan">
          </div>
          <div class="booking-details">
            <h3>Wisata Bahari Lamongan</h3>
            <div class="booking-info">
              <div class="info-item">
                <i class="fas fa-map-marker-alt"></i>
                <span>Lamongan, Jawa Timur</span>
              </div>
              <div class="info-item">
                <i class="fas fa-calendar"></i>
                <span>20 Desember 2024</span>
              </div>
              <div class="info-item">
                <i class="fas fa-users"></i>
                <span>4 Orang</span>
              </div>
              <div class="info-item">
                <i class="fas fa-clock"></i>
                <span>2 Hari 1 Malam</span>
              </div>
            </div>
          </div>
        </div>
        <div class="booking-footer">
          <div class="booking-total">Total: Rp 7.000.000</div>
          <div class="booking-actions">
            <a href="#" class="action-button btn-primary">Lihat Detail</a>
            <button class="action-button btn-danger" onclick="cancelBooking('TRV-2024-002')">
              Batalkan
            </button>
          </div>
        </div>
      </div>

      <!-- Booking 3 -->
      <div class="booking-card" data-status="pending" data-date="2025-01-05">
        <div class="booking-header">
          <div class="booking-id">
            <i class="fas fa-ticket-alt"></i> 
            Booking #TRV-2025-003
          </div>
          <span class="booking-status status-pending">Menunggu Pembayaran</span>
        </div>
        <div class="booking-content">
          <div class="booking-image">
            <img src="https://anekatempatwisata.com/wp-content/uploads/2018/04/Taman-Mini-Indonesia-Indah-610x407.jpg" alt="Taman Mini Indonesia Indah">
          </div>
          <div class="booking-details">
            <h3>Taman Mini Indonesia Indah</h3>
            <div class="booking-info">
              <div class="info-item">
                <i class="fas fa-map-marker-alt"></i>
                <span>Jakarta</span>
              </div>
              <div class="info-item">
                <i class="fas fa-calendar"></i>
                <span>5 Januari 2025</span>
              </div>
              <div class="info-item">
                <i class="fas fa-users"></i>
                <span>3 Orang</span>
              </div>
              <div class="info-item">
                <i class="fas fa-clock"></i>
                <span>1 Hari</span>
              </div>
            </div>
          </div>
        </div>
        <div class="booking-footer">
          <div class="booking-total">Total: Rp 4.050.000</div>
          <div class="booking-actions">
            <a href="#" class="action-button btn-primary">Bayar Sekarang</a>
            <a href="#" class="action-button btn-secondary">Lihat Detail</a>
            <button class="action-button btn-danger" onclick="cancelBooking('TRV-2025-003')">
              Batalkan
            </button>
          </div>
        </div>
      </div>

      <!-- Booking 4 -->
      <div class="booking-card" data-status="cancelled" data-date="2024-11-28">
        <div class="booking-header">
          <div class="booking-id">
            <i class="fas fa-ticket-alt"></i> 
            Booking #TRV-2024-004
          </div>
          <span class="booking-status status-cancelled">Dibatalkan</span>
        </div>
        <div class="booking-content">
          <div class="booking-image">
            <img src="https://anekatempatwisata.com/wp-content/uploads/2018/04/Museum-Nasional-Indonesia-610x610.jpg" alt="Museum Nasional Indonesia">
          </div>
          <div class="booking-details">
            <h3>Museum Nasional Indonesia</h3>
            <div class="booking-info">
              <div class="info-item">
                <i class="fas fa-map-marker-alt"></i>
                <span>Jakarta</span>
              </div>
              <div class="info-item">
                <i class="fas fa-calendar"></i>
                <span>28 November 2024</span>
              </div>
              <div class="info-item">
                <i class="fas fa-users"></i>
                <span>2 Orang</span>
              </div>
              <div class="info-item">
                <i class="fas fa-clock"></i>
                <span>1 Hari</span>
              </div>
            </div>
          </div>
        </div>
        <div class="booking-footer">
          <div class="booking-total">Total: Rp 3.600.000</div>
          <div class="booking-actions">
            <a href="#" class="action-button btn-secondary">Lihat Detail</a>
            <button class="action-button btn-primary" onclick="bookAgain('museum-nasional')">
              Pesan Lagi
            </button>
          </div>
        </div>
      </div>

    </div>
  </section>

  <?php include 'Komponen/footer.php'; ?>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Initialize page
      updateStats();
    });

    // Filter functionality
    function applyFilters() {
      const statusFilter = document.getElementById('status-filter').value;
      const dateFromFilter = document.getElementById('date-from').value;
      const dateToFilter = document.getElementById('date-to').value;
      
      const bookingCards = document.querySelectorAll('.booking-card');
      let visibleCount = 0;
      
      bookingCards.forEach(card => {
        let shouldShow = true;
        
        // Status filter
        if (statusFilter && card.dataset.status !== statusFilter) {
          shouldShow = false;
        }
        
        // Date filter
        const cardDate = card.dataset.date;
        if (dateFromFilter && cardDate < dateFromFilter) {
          shouldShow = false;
        }
        if (dateToFilter && cardDate > dateToFilter) {
          shouldShow = false;
        }
        
        // Show/hide card
        if (shouldShow) {
          card.style.display = 'block';
          visibleCount++;
        } else {
          card.style.display = 'none';
        }
      });
      
      // Show empty state if no results
      const emptyState = document.getElementById('empty-state');
      const bookingsContainer = document.getElementById('bookings-container');
      
      if (visibleCount === 0) {
        emptyState.style.display = 'block';
        bookingsContainer.style.display = 'none';
      } else {
        emptyState.style.display = 'none';
        bookingsContainer.style.display = 'flex';
      }
      
      showNotification(`Menampilkan ${visibleCount} pemesanan`, 'info');
    }

    // Update statistics
    function updateStats() {
      const allCards = document.querySelectorAll('.booking-card');
      const completedCards = document.querySelectorAll('.booking-card[data-status="completed"]');
      
      document.getElementById('total-bookings').textContent = allCards.length;
      document.getElementById('completed-bookings').textContent = completedCards.length;
    }

    // Cancel booking
    function cancelBooking(bookingId) {
      if (confirm('Apakah Anda yakin ingin membatalkan pemesanan ini?')) {
        // Find the booking card
        const bookingCard = document.querySelector(`[data-booking-id="${bookingId}"]`) || 
                           document.querySelector(`.booking-card:has(.booking-id:contains("${bookingId}"))`);
        
        // In real implementation, you would make an API call here
        showNotification(`Pemesanan ${bookingId} berhasil dibatalkan`, 'warning');
        
        // Update status to cancelled (for demo purposes)
        setTimeout(() => {
          location.reload(); // In real app, you'd update the status dynamically
        }, 2000);
      }
    }

    // Download invoice
    function downloadInvoice(bookingId) {
      showNotification(`Mengunduh invoice untuk ${bookingId}...`, 'info');
      
      // In real implementation, you would download the actual invoice
      setTimeout(() => {
        showNotification('Invoice berhasil diunduh', 'success');
      }, 1500);
    }

    // Book again
    function bookAgain(destinationSlug) {
      showNotification('Mengarahkan ke halaman pemesanan...', 'info');
      
      // In real implementation, redirect to booking page with pre-filled destination
      setTimeout(() => {
        // window.location.href = `pemesanan.php?destination=${destinationSlug}`;
        showNotification('Fitur akan segera tersedia', 'info');
      }, 1500);
    }

    // Notification system
    function showNotification(message, type = 'success') {
      const notification = document.createElement('div');
      notification.className = `notification ${type}`;
      notification.textContent = message;
      document.body.appendChild(notification);
      
      setTimeout(() => {
        notification.classList.add('show');
      }, 10);
      
      setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => {
          if (document.body.contains(notification)) {
            document.body.removeChild(notification);
          }
        }, 300);
      }, 3000);
    }

    // Reset filters
    function resetFilters() {
      document.getElementById('status-filter').value = '';
      document.getElementById('date-from').value = '';
      document.getElementById('date-to').value = '';
      applyFilters();
    }
  </script>
</body>
</html>