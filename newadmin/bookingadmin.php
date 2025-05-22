<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Management - Admin Panel</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- Sidebar -->
    <?php include '../Komponen/sidebar_admin.php'; ?>
    
    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <header class="dashboard-header">
            <div class="header-content">
                <div class="header-left">
                    <h1>Booking Management</h1>
                    <p>Kelola semua booking dalam sistem</p>
                </div>
                <div class="header-right">
                    <div class="date-time">
                        <i class="fas fa-calendar"></i>
                        <span id="current-date"></span>
                    </div>
                    <div class="admin-profile">
                        <img src="https://wp.mokapos.com/wp-content/uploads/2023/02/customer-service-layanan-pelanggan-tugas-admin-toko.jpg" alt="Admin" class="profile-img">
                        <span>Admin User</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content Container -->
        <div class="dashboard-container">
            <!-- Booking Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon total-bookings" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div class="stat-content">
                        <h3>847</h3>
                        <p>Total Bookings</p>
                        <span class="stat-change positive">
                            <i class="fas fa-arrow-up"></i> +15% dari bulan lalu
                        </span>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon pending-bookings" style="background: linear-gradient(135deg, #ff9a9e 0%, #fad0c4 100%);">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-content">
                        <h3>24</h3>
                        <p>Pending Bookings</p>
                        <span class="stat-change negative">
                            <i class="fas fa-arrow-up"></i> +8% dari bulan lalu
                        </span>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon confirmed-bookings" style="background: linear-gradient(135deg, #0ba360 0%, #3cba92 100%);">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-content">
                        <h3>621</h3>
                        <p>Confirmed Bookings</p>
                        <span class="stat-change positive">
                            <i class="fas fa-arrow-up"></i> +12% dari bulan lalu
                        </span>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon cancelled-bookings" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                        <i class="fas fa-ban"></i>
                    </div>
                    <div class="stat-content">
                        <h3>56</h3>
                        <p>Cancelled Bookings</p>
                        <span class="stat-change negative">
                            <i class="fas fa-arrow-down"></i> -5% dari bulan lalu
                        </span>
                    </div>
                </div>
            </div>

            <!-- Booking Management Section -->
            <div class="card booking-management-card">
                <div class="card-header">
                    <h3>Daftar Booking</h3>
                    <div class="card-actions">
                        <div class="search-container">
                            <input type="text" class="search-input" placeholder="Cari booking...">
                            <i class="fas fa-search search-icon"></i>
                        </div>
                        <button class="btn-add-booking">
                            <i class="fas fa-plus"></i> Tambah Booking
                        </button>
                    </div>
                </div>
                <div class="filter-section">
                    <div class="filter-row">
                        <div class="filter-group">
                            <label>Status</label>
                            <select class="filter-select">
                                <option value="">Semua Status</option>
                                <option value="pending">Pending</option>
                                <option value="confirmed">Confirmed</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                        <div class="filter-group">
                            <label>Destinasi</label>
                            <select class="filter-select">
                                <option value="">Semua Destinasi</option>
                                <option value="bali">Bali</option>
                                <option value="lombok">Lombok</option>
                                <option value="yogyakarta">Yogyakarta</option>
                                <option value="raja-ampat">Raja Ampat</option>
                            </select>
                        </div>
                        <div class="filter-group">
                            <label>Guide</label>
                            <select class="filter-select">
                                <option value="">Semua Guide</option>
                                <option value="dewi-lestari">Dewi Lestari</option>
                                <option value="budi-santoso">Budi Santoso</option>
                                <option value="ahmad-fadillah">Ahmad Fadillah</option>
                            </select>
                        </div>
                        <div class="filter-group date-range">
                            <label>Tanggal</label>
                            <div class="date-inputs">
                                <input type="date" class="filter-date" placeholder="Dari">
                                <span class="date-separator">-</span>
                                <input type="date" class="filter-date" placeholder="Sampai">
                            </div>
                        </div>
                        <div class="filter-buttons">
                            <button class="btn-filter-apply">Terapkan Filter</button>
                            <button class="btn-filter-reset">Reset</button>
                        </div>
                    </div>
                </div>
                <div class="card-content">
                    <div class="table-responsive">
                        <table class="booking-table">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" class="select-all-checkbox">
                                    </th>
                                    <th>ID Booking</th>
                                    <th>Customer</th>
                                    <th>Destinasi</th>
                                    <th>Tanggal Perjalanan</th>
                                    <th>Durasi</th>
                                    <th>Guide</th>
                                    <th>Harga</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="checkbox" class="booking-checkbox"></td>
                                    <td>#BK001</td>
                                    <td>
                                        <div class="user-info">
                                            <img src="/api/placeholder/40/40" alt="User" class="user-avatar">
                                            <span>Siti Nurhaliza</span>
                                        </div>
                                    </td>
                                    <td>Bali</td>
                                    <td>20 Mei 2025</td>
                                    <td>5 hari</td>
                                    <td>Dewi Lestari</td>
                                    <td>Rp 7.500.000</td>
                                    <td><span class="badge confirmed">Confirmed</span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-view" title="View Details"><i class="fas fa-eye"></i></button>
                                            <button class="btn-edit" title="Edit Booking"><i class="fas fa-edit"></i></button>
                                            <button class="btn-cancel" title="Cancel Booking"><i class="fas fa-ban"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" class="booking-checkbox"></td>
                                    <td>#BK002</td>
                                    <td>
                                        <div class="user-info">
                                            <img src="/api/placeholder/40/40" alt="User" class="user-avatar">
                                            <span>Budi Santoso</span>
                                        </div>
                                    </td>
                                    <td>Lombok</td>
                                    <td>23 Mei 2025</td>
                                    <td>3 hari</td>
                                    <td>Ahmad Fadillah</td>
                                    <td>Rp 4.200.000</td>
                                    <td><span class="badge pending">Pending</span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-view" title="View Details"><i class="fas fa-eye"></i></button>
                                            <button class="btn-edit" title="Edit Booking"><i class="fas fa-edit"></i></button>
                                            <button class="btn-cancel" title="Cancel Booking"><i class="fas fa-ban"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" class="booking-checkbox"></td>
                                    <td>#BK003</td>
                                    <td>
                                        <div class="user-info">
                                            <img src="/api/placeholder/40/40" alt="User" class="user-avatar">
                                            <span>Rina Wati</span>
                                        </div>
                                    </td>
                                    <td>Raja Ampat</td>
                                    <td>25 Mei 2025</td>
                                    <td>7 hari</td>
                                    <td>Budi Santoso</td>
                                    <td>Rp 12.800.000</td>
                                    <td><span class="badge completed">Completed</span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-view" title="View Details"><i class="fas fa-eye"></i></button>
                                            <button class="btn-edit" title="Edit Booking"><i class="fas fa-edit"></i></button>
                                            <button class="btn-cancel disabled" title="Cancel Booking"><i class="fas fa-ban"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" class="booking-checkbox"></td>
                                    <td>#BK004</td>
                                    <td>
                                        <div class="user-info">
                                            <img src="/api/placeholder/40/40" alt="User" class="user-avatar">
                                            <span>Agus Hartono</span>
                                        </div>
                                    </td>
                                    <td>Yogyakarta</td>
                                    <td>21 Mei 2025</td>
                                    <td>2 hari</td>
                                    <td>Dewi Lestari</td>
                                    <td>Rp 2.500.000</td>
                                    <td><span class="badge cancelled">Cancelled</span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-view" title="View Details"><i class="fas fa-eye"></i></button>
                                            <button class="btn-edit" title="Edit Booking"><i class="fas fa-edit"></i></button>
                                            <button class="btn-cancel disabled" title="Cancel Booking"><i class="fas fa-ban"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" class="booking-checkbox"></td>
                                    <td>#BK005</td>
                                    <td>
                                        <div class="user-info">
                                            <img src="/api/placeholder/40/40" alt="User" class="user-avatar">
                                            <span>Doni Kusuma</span>
                                        </div>
                                    </td>
                                    <td>Bali</td>
                                    <td>27 Mei 2025</td>
                                    <td>4 hari</td>
                                    <td>Ahmad Fadillah</td>
                                    <td>Rp 6.300.000</td>
                                    <td><span class="badge confirmed">Confirmed</span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-view" title="View Details"><i class="fas fa-eye"></i></button>
                                            <button class="btn-edit" title="Edit Booking"><i class="fas fa-edit"></i></button>
                                            <button class="btn-cancel" title="Cancel Booking"><i class="fas fa-ban"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" class="booking-checkbox"></td>
                                    <td>#BK006</td>
                                    <td>
                                        <div class="user-info">
                                            <img src="/api/placeholder/40/40" alt="User" class="user-avatar">
                                            <span>Putri Anggraini</span>
                                        </div>
                                    </td>
                                    <td>Raja Ampat</td>
                                    <td>30 Mei 2025</td>
                                    <td>6 hari</td>
                                    <td>Budi Santoso</td>
                                    <td>Rp 10.500.000</td>
                                    <td><span class="badge pending">Pending</span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-view" title="View Details"><i class="fas fa-eye"></i></button>
                                            <button class="btn-edit" title="Edit Booking"><i class="fas fa-edit"></i></button>
                                            <button class="btn-cancel" title="Cancel Booking"><i class="fas fa-ban"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" class="booking-checkbox"></td>
                                    <td>#BK007</td>
                                    <td>
                                        <div class="user-info">
                                            <img src="/api/placeholder/40/40" alt="User" class="user-avatar">
                                            <span>Tono Sucipto</span>
                                        </div>
                                    </td>
                                    <td>Yogyakarta</td>
                                    <td>22 Mei 2025</td>
                                    <td>3 hari</td>
                                    <td>Dewi Lestari</td>
                                    <td>Rp 3.800.000</td>
                                    <td><span class="badge confirmed">Confirmed</span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-view" title="View Details"><i class="fas fa-eye"></i></button>
                                            <button class="btn-edit" title="Edit Booking"><i class="fas fa-edit"></i></button>
                                            <button class="btn-cancel" title="Cancel Booking"><i class="fas fa-ban"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="pagination-container">
                        <div class="pagination-info">
                            Showing <span>1-7</span> of <span>847</span> bookings
                        </div>
                        <div class="pagination">
                            <button class="page-btn disabled"><i class="fas fa-chevron-left"></i></button>
                            <button class="page-btn active">1</button>
                            <button class="page-btn">2</button>
                            <button class="page-btn">3</button>
                            <span class="page-ellipsis">...</span>
                            <button class="page-btn">121</button>
                            <button class="page-btn"><i class="fas fa-chevron-right"></i></button>
                        </div>
                        <div class="per-page-selector">
                            <label for="perPage">Show:</label>
                            <select id="perPage" class="per-page">
                                <option value="10" selected>10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Booking Statistics and Revenue Charts -->
            <div class="dashboard-row">
                <!-- Booking Statistics Chart -->
                <div class="chart-section">
                    <div class="card">
                        <div class="card-header">
                            <h3>Statistik Booking</h3>
                            <div class="card-actions">
                                <select class="timeframe-selector">
                                    <option value="weekly">Mingguan</option>
                                    <option value="monthly" selected>Bulanan</option>
                                    <option value="yearly">Tahunan</option>
                                </select>
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="chart-container">
                                <canvas id="bookingStatisticsChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Revenue Chart -->
                <div class="chart-section">
                    <div class="card">
                        <div class="card-header">
                            <h3>Pendapatan Booking</h3>
                            <div class="card-actions">
                                <select class="timeframe-selector">
                                    <option value="weekly">Mingguan</option>
                                    <option value="monthly" selected>Bulanan</option>
                                    <option value="yearly">Tahunan</option>
                                </select>
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="chart-container">
                                <canvas id="revenueChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Bookings and Popular Destinations -->
            <div class="dashboard-row">
                <!-- Recent Bookings -->
                <div class="recent-bookings">
                    <div class="card">
                        <div class="card-header">
                            <h3>Booking Terbaru</h3>
                            <a href="#" class="view-all">Lihat Semua</a>
                        </div>
                        <div class="card-content">
                            <div class="booking-list">
                                <div class="booking-item">
                                    <div class="booking-customer">
                                        <img src="/api/placeholder/45/45" alt="User" class="user-avatar">
                                        <div class="customer-details">
                                            <h4>Putri Anggraini</h4>
                                            <p>Raja Ampat - 6 hari</p>
                                        </div>
                                    </div>
                                    <div class="booking-info">
                                        <span class="badge pending">Pending</span>
                                        <span class="booking-time">10 menit yang lalu</span>
                                    </div>
                                </div>
                                <div class="booking-item">
                                    <div class="booking-customer">
                                        <img src="/api/placeholder/45/45" alt="User" class="user-avatar">
                                        <div class="customer-details">
                                            <h4>Tono Sucipto</h4>
                                            <p>Yogyakarta - 3 hari</p>
                                        </div>
                                    </div>
                                    <div class="booking-info">
                                        <span class="badge confirmed">Confirmed</span>
                                        <span class="booking-time">35 menit yang lalu</span>
                                    </div>
                                </div>
                                <div class="booking-item">
                                    <div class="booking-customer">
                                        <img src="/api/placeholder/45/45" alt="User" class="user-avatar">
                                        <div class="customer-details">
                                            <h4>Doni Kusuma</h4>
                                            <p>Bali - 4 hari</p>
                                        </div>
                                    </div>
                                    <div class="booking-info">
                                        <span class="badge confirmed">Confirmed</span>
                                        <span class="booking-time">2 jam yang lalu</span>
                                    </div>
                                </div>
                                <div class="booking-item">
                                    <div class="booking-customer">
                                        <img src="/api/placeholder/45/45" alt="User" class="user-avatar">
                                        <div class="customer-details">
                                            <h4>Agus Hartono</h4>
                                            <p>Yogyakarta - 2 hari</p>
                                        </div>
                                    </div>
                                    <div class="booking-info">
                                        <span class="badge cancelled">Cancelled</span>
                                        <span class="booking-time">5 jam yang lalu</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Popular Destinations -->
                <div class="popular-destinations">
                    <div class="card">
                        <div class="card-header">
                            <h3>Destinasi Populer</h3>
                            <a href="#" class="view-all">Lihat Semua</a>
                        </div>
                        <div class="card-content">
                            <div class="destination-list">
                                <div class="destination-item">
                                    <div class="destination-thumbnail">
                                        <img src="/api/placeholder/80/60" alt="Bali" class="destination-img">
                                    </div>
                                    <div class="destination-info">
                                        <h4>Bali</h4>
                                        <div class="destination-stats">
                                            <div class="stat">
                                                <i class="fas fa-calendar-check"></i>
                                                <span>352 bookings</span>
                                            </div>
                                            <div class="stat">
                                                <i class="fas fa-star"></i>
                                                <span>4.8/5</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="destination-trend positive">
                                        <i class="fas fa-chart-line"></i>
                                        <span>+12%</span>
                                    </div>
                                </div>
                                <div class="destination-item">
                                    <div class="destination-thumbnail">
                                        <img src="/api/placeholder/80/60" alt="Raja Ampat" class="destination-img">
                                    </div>
                                    <div class="destination-info">
                                        <h4>Raja Ampat</h4>
                                        <div class="destination-stats">
                                            <div class="stat">
                                                <i class="fas fa-calendar-check"></i>
                                                <span>215 bookings</span>
                                            </div>
                                            <div class="stat">
                                                <i class="fas fa-star"></i>
                                                <span>4.9/5</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="destination-trend positive">
                                        <i class="fas fa-chart-line"></i>
                                        <span>+23%</span>
                                    </div>
                                </div>
                                <div class="destination-item">
                                    <div class="destination-thumbnail">
                                        <img src="/api/placeholder/80/60" alt="Lombok" class="destination-img">
                                    </div>
                                    <div class="destination-info">
                                        <h4>Lombok</h4>
                                        <div class="destination-stats">
                                            <div class="stat">
                                                <i class="fas fa-calendar-check"></i>
                                                <span>178 bookings</span>
                                            </div>
                                            <div class="stat">
                                                <i class="fas fa-star"></i>
                                                <span>4.6/5</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="destination-trend positive">
                                        <i class="fas fa-chart-line"></i>
                                        <span>+8%</span>
                                    </div>
                                </div>
                                <div class="destination-item">
                                    <div class="destination-thumbnail">
                                        <img src="/api/placeholder/80/60" alt="Yogyakarta" class="destination-img">
                                    </div>
                                    <div class="destination-info">
                                        <h4>Yogyakarta</h4>
                                        <div class="destination-stats">
                                            <div class="stat">
                                                <i class="fas fa-calendar-check"></i>
                                                <span>102 bookings</span>
                                            </div>
                                            <div class="stat">
                                                <i class="fas fa-star"></i>
                                                <span>4.5/5</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="destination-trend negative">
                                        <i class="fas fa-chart-line"></i>
                                        <span>-3%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit Booking Modal -->
    <div class="modal" id="bookingModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Tambah Booking Baru</h3>
                <button class="close-modal"><i class="fas fa-times"></i></button>
            </div>
            <div class="modal-body">
                <form id="bookingForm">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="customerName">Customer</label>
                            <select id="customerName" name="customerName" class="form-control" required>
                                <option value="">Pilih Customer</option>
                                <option value="1">Siti Nurhaliza</option>
                                <option value="2">Budi Santoso</option>
                                <option value="3">Rina Wati</option>
                                <option value="4">Agus Hartono</option>
                                <option value="5">Doni Kusuma</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="destination">Destinasi</label>
                            <select id="destination" name="destination" class="form-control" required>
                                <option value="">Pilih Destinasi</option>
                                <option value="bali">Bali</option>
                                <option value="lombok">Lombok</option>
                                <option value="yogyakarta">Yogyakarta</option>
                                <option value="raja-ampat">Raja Ampat</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="travelDate">Tanggal Perjalanan</label>
                            <input type="date" id="travelDate" name="travelDate" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="duration">Durasi (hari)</label>
                            <input type="number" id="duration" name="duration" class="form-control" min="1" max="30" required>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="guide">Guide</label>
                            <select id="guide" name="guide" class="form-control" required>
                                <option value="">Pilih Guide</option>
                                <option value="1">Dewi Lestari</option>
                                <option value="2">Budi Santoso</option>
                                <option value="3">Ahmad Fadillah</option>
                                                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="price">Harga</label>
                                <input type="number" id="price" name="price" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select id="status" name="status" class="form-control" required>
                                    <option value="pending">Pending</option>
                                    <option value="confirmed">Confirmed</option>
                                    <option value="completed">Completed</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-modal">Batal</button>
                    <button type="submit" form="bookingForm" class="btn btn-primary">Simpan Booking</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Tanggal dan waktu
        const currentDateElement = document.getElementById('current-date');
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        currentDateElement.textContent = new Date().toLocaleDateString('id-ID', options);

        // Modal Handling
        const modal = document.getElementById('bookingModal');
        const openModalButtons = document.querySelectorAll('.btn-add-booking');
        const closeModalButtons = document.querySelectorAll('.close-modal');

        openModalButtons.forEach(button => {
            button.addEventListener('click', () => {
                modal.style.display = 'block';
            });
        });

        closeModalButtons.forEach(button => {
            button.addEventListener('click', () => {
                modal.style.display = 'none';
            });
        });

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }

        // Inisialisasi Chart
        const bookingChartCtx = document.getElementById('bookingStatisticsChart').getContext('2d');
        new Chart(bookingChartCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                datasets: [{
                    label: 'Total Booking',
                    data: [65, 59, 80, 81, 56, 55],
                    borderColor: '#667eea',
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' }
                }
            }
        });

        const revenueChartCtx = document.getElementById('revenueChart').getContext('2d');
        new Chart(revenueChartCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                datasets: [{
                    label: 'Pendapatan (Juta Rupiah)',
                    data: [120, 190, 30, 50, 20, 30],
                    backgroundColor: '#0ba360'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' }
                }
            }
        });

        // Fungsi Pencarian
        document.querySelector('.search-input').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            document.querySelectorAll('.booking-table tbody tr').forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    </script>

    <style>
        /* Basic Styles */
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            background: #f0f2f5;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
        }

        .dashboard-header {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            display: flex;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .booking-table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
        }

        .booking-table th, 
        .booking-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .badge {
            padding: 4px 8px;
            border-radius: 20px;
            font-size: 0.8em;
        }

        .badge.pending { background: #fff3cd; color: #856404; }
        .badge.confirmed { background: #d4edda; color: #155724; }
        .badge.cancelled { background: #f8d7da; color: #721c24; }
        .badge.completed { background: #d1ecf1; color: #0c5460; }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: white;
            padding: 20px;
            border-radius: 8px;
            width: 600px;
        }
    </style>
</body>
</html>