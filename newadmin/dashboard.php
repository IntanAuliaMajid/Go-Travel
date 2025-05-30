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
      margin-left: 220px;
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

    /* Quick Actions */
    .quick-actions {
      background: white;
      padding: 25px;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
      margin-bottom: 30px;
    }

    .quick-actions h2 {
      color: #2c3e50;
      margin-bottom: 20px;
      font-size: 1.5rem;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .action-buttons {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 15px;
    }

    .action-btn {
      background: linear-gradient(135deg, #e67e22, #d35400);
      color: white;
      padding: 15px 20px;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      transition: all 0.3s ease;
      font-size: 1rem;
      text-align: center;
      text-decoration: none;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
    }

    .action-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 20px rgba(230, 126, 34, 0.3);
    }

    .action-btn.blue {
      background: linear-gradient(135deg, #3498db, #2980b9);
    }

    .action-btn.blue:hover {
      box-shadow: 0 10px 20px rgba(52, 152, 219, 0.3);
    }

    .action-btn.green {
      background: linear-gradient(135deg, #27ae60, #2ecc71);
    }

    .action-btn.green:hover {
      box-shadow: 0 10px 20px rgba(39, 174, 96, 0.3);
    }

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
    }

    .activity-text p {
      color: #7f8c8d;
      font-size: 0.9rem;
    }

    .activity-time {
      color: #95a5a6;
      font-size: 0.8rem;
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
      main {
        margin-left: 0;
        padding: 20px;
      }

      .dashboard-header h1 {
        font-size: 1.8rem;
      }

      .stats-container {
        grid-template-columns: 1fr;
      }

      .action-buttons {
        grid-template-columns: 1fr;
      }
    }

    /* Status badges */
    .status-badge {
      padding: 4px 8px;
      border-radius: 12px;
      font-size: 0.8rem;
      font-weight: 500;
    }

    .status-badge.pending {
      background: #fff3cd;
      color: #856404;
    }

    .status-badge.confirmed {
      background: #d4edda;
      color: #155724;
    }

    .status-badge.cancelled {
      background: #f8d7da;
      color: #721c24;
    }
  </style>
</head>
<body>
  <?php include '../komponen/sidebar_admin.php'; ?>

  <main>
    <!-- Dashboard Header -->
    <div class="dashboard-header">
      <h1><i class="fas fa-map-marked-alt" style="color: #e67e22; margin-right: 10px;"></i>Dashboard Paket Wisata</h1>
      <p>Kelola pemesanan dan paket wisata dengan mudah. Selamat datang di panel administrasi.</p>
    </div>

    <!-- Stats Cards -->
    <div class="stats-container">
      <div class="stat-card orange">
        <div class="stat-icon">
          <i class="fas fa-suitcase-rolling"></i>
        </div>
        <h3>156</h3>
        <p>Total Paket Wisata</p>
        <small style="color: #27ae60;">↑ 8 paket baru bulan ini</small>
      </div>
      
      <div class="stat-card blue">
        <div class="stat-icon">
          <i class="fas fa-calendar-check"></i>
        </div>
        <h3>89</h3>
        <p>Pemesanan Bulan Ini</p>
        <small style="color: #27ae60;">↑ 23% dari bulan lalu</small>
      </div>
      
      <div class="stat-card green">
        <div class="stat-icon">
          <i class="fas fa-money-bill-wave"></i>
        </div>
        <h3>Rp 185.5M</h3>
        <p>Pendapatan Bulan Ini</p>
        <small style="color: #27ae60;">↑ 18% dari bulan lalu</small>
      </div>
      
      <div class="stat-card purple">
        <div class="stat-icon">
          <i class="fas fa-users"></i>
        </div>
        <h3>1,247</h3>
        <p>Total Wisatawan</p>
        <small style="color: #e74c3c;">↓ 2% dari bulan lalu</small>
      </div>
    </div>

    <!-- Recent Activity -->
    <div class="recent-activity">
      <h2><i class="fas fa-clock"></i> Aktivitas Terbaru</h2>
      
      <div class="activity-item">
        <div class="activity-icon orange">
          <i class="fas fa-shopping-cart"></i>
        </div>
        <div class="activity-text">
          <h4>Pemesanan Baru - Paket Wisata Bahari Lamongan</h4>
          <p>Andi Wijaya memesan paket Wisata Bahari Lamongan</p>
        </div>
        <div class="activity-time">
          <span class="status-badge pending">Menunggu</span><br>
          <small>5 menit lalu</small>
        </div>
      </div>
      
      <div class="activity-item">
        <div class="activity-icon green">
          <i class="fas fa-check-circle"></i>
        </div>
        <div class="activity-text">
          <h4>Pembayaran Dikonfirmasi</h4>
          <p>Pembayaran untuk paket Wisata Bahari Lamongan telah dikonfirmasi</p>
        </div>
        <div class="activity-time">
          <span class="status-badge confirmed">Lunas</span><br>
          <small>15 menit lalu</small>
        </div>
      </div>
      
      <div class="activity-item">
        <div class="activity-icon blue">
          <i class="fas fa-map-pin"></i>
        </div>
        <div class="activity-text">
          <h4>Paket Wisata Baru Ditambahkan</h4>
          <p>Paket "Pantai Rongkang" telah ditambahkan ke katalog</p>
        </div>
        <div class="activity-time">
          <small>1 jam lalu</small>
        </div>
      </div>
      
      <div class="activity-item">
        <div class="activity-icon green">
          <i class="fas fa-star"></i>
        </div>
        <div class="activity-text">
          <h4>Review Baru</h4>
          <p>Budi Santoso memberikan rating 5 bintang untuk paket Taman Mini Indonesia</p>
        </div>
        <div class="activity-time">
          <small>3 jam lalu</small>
        </div>
      </div>
    </div>
  </main>
</body>
</html>