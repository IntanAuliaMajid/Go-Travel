<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Admin Panel</title>
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
                    <h1>Dashboard</h1>
                    <p>Selamat datang kembali, Admin</p>
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
            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon total-users">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-content">
                        <h3>1,245</h3>
                        <p>Total Users</p>
                        <span class="stat-change positive">
                            <i class="fas fa-arrow-up"></i> +12% dari bulan lalu
                        </span>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon total-bookings">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div class="stat-content">
                        <h3>856</h3>
                        <p>Total Bookings</p>
                        <span class="stat-change positive">
                            <i class="fas fa-arrow-up"></i> +8% dari bulan lalu
                        </span>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon total-packages">
                        <i class="fas fa-suitcase-rolling"></i>
                    </div>
                    <div class="stat-content">
                        <h3>42</h3>
                        <p>Travel Packages</p>
                        <span class="stat-change neutral">
                            <i class="fas fa-minus"></i> Tidak ada perubahan
                        </span>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon total-revenue">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <div class="stat-content">
                        <h3>Rp 2.4M</h3>
                        <p>Total Revenue</p>
                        <span class="stat-change positive">
                            <i class="fas fa-arrow-up"></i> +15% dari bulan lalu
                        </span>
                    </div>
                </div>
            </div>
            <!-- Charts and Tables Row -->
            <div class="dashboard-row">
                <!-- Chart Section -->
                <div class="chart-section">
                    <div class="card">
                        <div class="card-header">
                            <h3>Statistik Booking Bulanan</h3>
                            <div class="card-actions">
                                <select class="year-selector">
                                    <option value="2024">2024</option>
                                    <option value="2023">2023</option>
                                </select>
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="chart-container">
                                <canvas id="bookingChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="quick-stats">
                    <div class="card">
                        <div class="card-header">
                            <h3>Quick Stats</h3>
                        </div>
                        <div class="card-content">
                            <div class="quick-stat-item">
                                <div class="quick-stat-icon pending">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="quick-stat-info">
                                    <span class="count">24</span>
                                    <span class="label">Pending Bookings</span>
                                </div>
                            </div>
                            <div class="quick-stat-item">
                                <div class="quick-stat-icon confirmed">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div class="quick-stat-info">
                                    <span class="count">186</span>
                                    <span class="label">Confirmed Bookings</span>
                                </div>
                            </div>
                            <div class="quick-stat-item">
                                <div class="quick-stat-icon cancelled">
                                    <i class="fas fa-times-circle"></i>
                                </div>
                                <div class="quick-stat-info">
                                    <span class="count">12</span>
                                    <span class="label">Cancelled Bookings</span>
                                </div>
                            </div>
                            <div class="quick-stat-item">
                                <div class="quick-stat-icon active">
                                    <i class="fas fa-star"></i>
                                </div>
                                <div class="quick-stat-info">
                                    <span class="count">35</span>
                                    <span class="label">Active Packages</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activities and Popular Packages -->
            <div class="dashboard-row">
                <!-- Recent Activities -->
                <div class="recent-activities">
                    <div class="card">
                        <div class="card-header">
                            <h3>Aktivitas Terbaru</h3>
                            <a href="#" class="view-all">Lihat Semua</a>
                        </div>
                        <div class="card-content">
                            <div class="activity-list">
                                <div class="activity-item">
                                    <div class="activity-icon new-user">
                                        <i class="fas fa-user-plus"></i>
                                    </div>
                                    <div class="activity-content">
                                        <p><strong>User baru</strong> mendaftar</p>
                                        <span class="activity-time">2 menit yang lalu</span>
                                    </div>
                                </div>
                                <div class="activity-item">
                                    <div class="activity-icon new-booking">
                                        <i class="fas fa-calendar-plus"></i>
                                    </div>
                                    <div class="activity-content">
                                        <p><strong>Booking baru</strong> Wisata Bahari Lamongan</p>
                                        <span class="activity-time">15 menit yang lalu</span>
                                    </div>
                                </div>
                                <div class="activity-item">
                                    <div class="activity-icon payment">
                                        <i class="fas fa-credit-card"></i>
                                    </div>
                                    <div class="activity-content">
                                        <p><strong>Pembayaran</strong> berhasil dikonfirmasi</p>
                                        <span class="activity-time">1 jam yang lalu</span>
                                    </div>
                                </div>
                                <div class="activity-item">
                                    <div class="activity-icon package-update">
                                        <i class="fas fa-edit"></i>
                                    </div>
                                    <div class="activity-content">
                                        <p><strong>Paket wisata</strong> diperbarui</p>
                                        <span class="activity-time">3 jam yang lalu</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Popular Packages -->
                <div class="popular-packages">
                    <div class="card">
                        <div class="card-header">
                            <h3>Paket Terpopuler</h3>
                            <a href="#" class="view-all">Lihat Semua</a>
                        </div>
                        <div class="card-content">
                            <div class="package-list">
                                <div class="package-item">
                                    <img src="/api/placeholder/80/60" alt="Bali Adventure" class="package-img">
                                    <div class="package-info">
                                        <h4>Taman Mini</h4>
                                        <p>142 bookings</p>
                                        <span class="price">Rp 1,500,000</span>
                                    </div>
                                </div>
                                <div class="package-item">
                                    <img src="/api/placeholder/80/60" alt="Jakarta City Tour" class="package-img">
                                    <div class="package-info">
                                        <h4>Pantai Lorena</h4>
                                        <p>98 bookings</p>
                                        <span class="price">Rp 750,000</span>
                                    </div>
                                </div>
                                <div class="package-item">
                                    <img src="/api/placeholder/80/60" alt="Yogyakarta Heritage" class="package-img">
                                    <div class="package-info">
                                        <h4>Museum Nasional Indonesia</h4>
                                        <p>76 bookings</p>
                                        <span class="price">Rp 900,000</span>
                                    </div>
                                </div>
                                <div class="package-item">
                                    <img src="/api/placeholder/80/60" alt="Lombok Paradise" class="package-img">
                                    <div class="package-info">
                                        <h4>Mercusuar Sembilangan</h4>
                                        <p>64 bookings</p>
                                        <span class="price">Rp 1,200,000</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script>
        // Update current date
        function updateDateTime() {
            const now = new Date();
            const options = { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            };
            document.getElementById('current-date').textContent = now.toLocaleDateString('id-ID', options);
        }
        updateDateTime();

        // Booking Chart
        const ctx = document.getElementById('bookingChart').getContext('2d');
        const bookingChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Bookings',
                    data: [65, 59, 80, 81, 56, 55, 140, 180, 165, 175, 190, 200],
                    borderColor: '#4A90E2',
                    backgroundColor: 'rgba(74, 144, 226, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f0f0f0'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    </script>

    <style>
        /* Main Content */
        .main-content {
            margin-left: 280px;
            min-height: 100vh;
            padding: 0;
            width: calc(100% - 280px);
            overflow-x: hidden;
            position: relative;
        }

        /* Container for all dashboard content */
        .dashboard-container {
            padding: 0 30px 30px;
            width: 100%;
            max-width: 100%;
            overflow-x: hidden;
        }

        /* Dashboard Header */
        .dashboard-header {
            background: white;
            padding: 25px 30px;
            border-bottom: 1px solid #e5e7eb;
            margin-bottom: 30px;
            width: 100%;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            max-width: 100%;
            flex-wrap: nowrap;
        }

        .header-left h1 {
            font-size: 28px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 5px;
        }

        .header-left p {
            color: #6b7280;
            font-size: 16px;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
            flex-wrap: nowrap;
        }

        .date-time {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #6b7280;
            padding: 8px 16px;
            background: #f9fafb;
            border-radius: 8px;
            white-space: nowrap;
        }

        .admin-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 16px;
            background: #f9fafb;
            border-radius: 8px;
            white-space: nowrap;
        }

        .profile-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
            width: 100%;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            gap: 20px;
            transition: transform 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
            flex-shrink: 0;
        }

        .stat-icon.total-users { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .stat-icon.total-bookings { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
        .stat-icon.total-packages { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
        .stat-icon.total-revenue { background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); }

        .stat-content h3 {
            font-size: 32px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 5px;
        }

        .stat-content p {
            color: #6b7280;
            font-size: 16px;
            margin-bottom: 8px;
        }

        .stat-change {
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .stat-change.positive { color: #10b981; }
        .stat-change.neutral { color: #6b7280; }

        /* Dashboard Row */
        .dashboard-row {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 25px;
            margin-bottom: 30px;
            width: 100%;
        }

        /* Card Styles */
        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            width: 100%;
        }

        .card-header {
            padding: 20px 25px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-header h3 {
            font-size: 18px;
            font-weight: 600;
            color: #1f2937;
        }

        .card-content {
            padding: 25px;
        }

        .view-all {
            color: #4A90E2;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
        }

        .view-all:hover {
            text-decoration: underline;
        }

        /* Chart */
        .chart-container {
            width: 100%;
            height: 300px;
            position: relative;
        }

        .chart-section canvas {
            height: 100% !important;
            width: 100% !important;
        }

        .year-selector {
            padding: 8px 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            background: white;
            font-size: 14px;
        }

        /* Quick Stats */
        .quick-stat-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px 0;
            border-bottom: 1px solid #f3f4f6;
            width: 100%;
        }

        .quick-stat-item:last-child {
            border-bottom: none;
        }

        .quick-stat-icon {
            width: 45px;
            height: 45px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            flex-shrink: 0;
        }

        .quick-stat-icon.pending { background: #f59e0b; }
        .quick-stat-icon.confirmed { background: #10b981; }
        .quick-stat-icon.cancelled { background: #ef4444; }
        .quick-stat-icon.active { background: #8b5cf6; }

        .quick-stat-info .count {
            font-size: 24px;
            font-weight: 700;
            color: #1f2937;
            display: block;
        }

        .quick-stat-info .label {
            color: #6b7280;
            font-size: 14px;
        }

        /* Activities */
        .activity-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px 0;
            border-bottom: 1px solid #f3f4f6;
            width: 100%;
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            flex-shrink: 0;
        }

        .activity-icon.new-user { background: #3b82f6; }
        .activity-icon.new-booking { background: #10b981; }
        .activity-icon.payment { background: #f59e0b; }
        .activity-icon.package-update { background: #8b5cf6; }

        .activity-content {
            width: calc(100% - 55px);
            min-width: 0;
        }

        .activity-content p {
            margin-bottom: 5px;
            color: #1f2937;
            white-space: normal;
            word-wrap: break-word;
        }

        .activity-time {
            color: #6b7280;
            font-size: 12px;
        }

        /* Popular Packages */
        .package-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px 0;
            border-bottom: 1px solid #f3f4f6;
            width: 100%;
        }

        .package-item:last-child {
            border-bottom: none;
        }

        .package-img {
            width: 80px;
            height: 60px;
            border-radius: 8px;
            object-fit: cover;
            flex-shrink: 0;
        }

        .package-info {
            width: calc(100% - 95px);
            min-width: 0;
        }

        .package-info h4 {
            font-size: 16px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 5px;
            white-space: normal;
            word-wrap: break-word;
        }

        .package-info p {
            color: #6b7280;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .package-info .price {
            color: #10b981;
            font-weight: 600;
            font-size: 14px;
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .dashboard-row {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                width: 100%;
            }

            .admin-sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .header-content {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .header-right {
                width: 100%;
                flex-wrap: wrap;
            }
        }

        /* Tambahan untuk memastikan tidak ada scroll horizontal */
        img, svg, canvas {
            max-width: 100%;
        }

        /* Perbaikan untuk responsive text */
        p, h1, h2, h3, h4, span {
            max-width: 100%;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }
    </style>
</body>
</html>