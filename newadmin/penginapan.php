<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Admin - Manajemen Penginapan</title>
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
      border-left: 5px solid #9b59b6;
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
      background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="%239b59b6" stroke-width="1" opacity="0.1"><path d="M20 9V7a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v2M4 9v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9M4 9h16M8 5v4m8-4v4m-4-4v4"></path></svg>') no-repeat center;
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

    .stat-card.purple::before {
      background: linear-gradient(90deg, #9b59b6, #8e44ad);
    }

    .stat-card.green::before {
      background: linear-gradient(90deg, #27ae60, #2ecc71);
    }

    .stat-card.orange::before {
      background: linear-gradient(90deg, #e67e22, #d35400);
    }

    .stat-card.blue::before {
      background: linear-gradient(90deg, #3498db, #2980b9);
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

    .stat-card.purple .stat-icon { color: #9b59b6; }
    .stat-card.green .stat-icon { color: #27ae60; }
    .stat-card.orange .stat-icon { color: #e67e22; }
    .stat-card.blue .stat-icon { color: #3498db; }

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
      background: linear-gradient(135deg, #9b59b6, #8e44ad);
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
      box-shadow: 0 10px 20px rgba(155, 89, 182, 0.3);
      text-decoration: none;
      color: white;
    }

    .action-btn.green {
      background: linear-gradient(135deg, #27ae60, #2ecc71);
    }

    .action-btn.green:hover {
      box-shadow: 0 10px 20px rgba(39, 174, 96, 0.3);
    }

    .action-btn.orange {
      background: linear-gradient(135deg, #e67e22, #d35400);
    }

    .action-btn.orange:hover {
      box-shadow: 0 10px 20px rgba(230, 126, 34, 0.3);
    }

    /* Accommodation Management */
    .accommodation-management {
      background: white;
      padding: 25px;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .section-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }

    .section-header h2 {
      color: #2c3e50;
      font-size: 1.5rem;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .search-bar {
      display: flex;
      gap: 10px;
    }

    .search-bar input {
      padding: 10px 15px;
      border: 1px solid #ddd;
      border-radius: 8px;
      width: 250px;
    }

    .search-bar button {
      background: #9b59b6;
      color: white;
      border: none;
      border-radius: 8px;
      padding: 10px 15px;
      cursor: pointer;
    }

    .accommodation-table {
      width: 100%;
      border-collapse: collapse;
    }

    .accommodation-table th {
      background: #f8f9fa;
      text-align: left;
      padding: 15px;
      color: #2c3e50;
      font-weight: 600;
      border-bottom: 2px solid #eee;
    }

    .accommodation-table td {
      padding: 15px;
      border-bottom: 1px solid #eee;
      color: #555;
    }

    .accommodation-table tr:hover {
      background: #f9f9f9;
    }

    .status-badge {
      padding: 5px 10px;
      border-radius: 20px;
      font-size: 0.85rem;
      font-weight: 500;
    }

    .status-badge.available {
      background: #d4edda;
      color: #155724;
    }

    .status-badge.full {
      background: #fff3cd;
      color: #856404;
    }

    .status-badge.maintenance {
      background: #f8d7da;
      color: #721c24;
    }

    .rating-stars {
      color: #f1c40f;
      font-size: 0.9rem;
    }

    .action-icons {
      display: flex;
      gap: 12px;
    }

    .action-icons a {
      color: #555;
      transition: color 0.3s;
      text-decoration: none;
    }

    .action-icons a:hover {
      color: #9b59b6;
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

      .section-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
      }

      .search-bar {
        width: 100%;
      }

      .search-bar input {
        width: 100%;
      }

      .accommodation-table {
        display: block;
        overflow-x: auto;
      }
    }
  </style>
</head>
<body>
  <!-- Sidebar tetap sama seperti di contoh -->
  <?php include '../komponen/sidebar_admin.php'; ?>

  <main>
    <!-- Dashboard Header -->
    <div class="dashboard-header">
      <h1><i class="fas fa-hotel" style="color: #9b59b6; margin-right: 10px;"></i>Manajemen Penginapan</h1>
      <p>Kelola akomodasi wisata dengan mudah. Tambah, edit, atau hapus penginapan sesuai kebutuhan.</p>
    </div>

    <!-- Stats Cards -->
    <div class="stats-container">
      <div class="stat-card purple">
        <div class="stat-icon">
          <i class="fas fa-hotel"></i>
        </div>
        <h3>38</h3>
        <p>Total Penginapan</p>
        <small style="color: #27ae60;">↑ 5 penginapan baru bulan ini</small>
      </div>
      
      <div class="stat-card green">
        <div class="stat-icon">
          <i class="fas fa-bed"></i>
        </div>
        <h3>287</h3>
        <p>Kamar Tersedia</p>
        <small style="color: #e74c3c;">↓ 4% dari bulan lalu</small>
      </div>
      
      <div class="stat-card orange">
        <div class="stat-icon">
          <i class="fas fa-star"></i>
        </div>
        <h3>4.5</h3>
        <p>Rating Rata-rata</p>
        <small style="color: #27ae60;">↑ 0.2 dari bulan lalu</small>
      </div>
    </div>

    <!-- Quick Actions -->
    <div class="quick-actions">
      <h2><i class="fas fa-bolt"></i> Aksi Cepat</h2>
      <div class="action-buttons">
        <a href="tambah_penginapan.php" class="action-btn">
          <i class="fas fa-plus-circle"></i> Tambah Penginapan
        </a>
        <a href="kelola_reservasi.php" class="action-btn green">
          <i class="fas fa-calendar-check"></i> Kelola Reservasi
        </a>
        <a href="review_pelanggan.php" class="action-btn orange">
          <i class="fas fa-star"></i> Review Pelanggan
        </a>
        <a href="laporan_pendapatan.php" class="action-btn" style="background: linear-gradient(135deg, #3498db, #2980b9);">
          <i class="fas fa-chart-bar"></i> Laporan Pendapatan
        </a>
      </div>
    </div>

    <!-- Accommodation Management -->
    <div class="accommodation-management">
      <div class="section-header">
        <h2><i class="fas fa-list"></i> Daftar Penginapan</h2>
        <div class="search-bar">
          <input type="text" placeholder="Cari penginapan...">
          <button><i class="fas fa-search"></i></button>
        </div>
      </div>
      
      <table class="accommodation-table">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama Penginapan</th>
            <th>Lokasi</th>
            <th>Tipe</th>
            <th>Harga/Malam</th>
            <th>Rating</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1</td>
            <td>Grand Luxury Resort</td>
            <td>Bali, Ubud</td>
            <td>Resort</td>
            <td>Rp 1.500.000</td>
            <td>
              <div class="rating-stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
                <span>(4.5)</span>
              </div>
            </td>
            <td><span class="status-badge available">Tersedia</span></td>
            <td>
              <div class="action-icons">
                <a href="edit_penginapan.php?id=1" title="Edit"><i class="fas fa-edit"></i></a>
                <a href="hapus_penginapan.php?id=1" title="Hapus" onclick="return confirm('Yakin ingin menghapus penginapan ini?')"><i class="fas fa-trash-alt"></i></a>
                <a href="detail_penginapan.php?id=1" title="Lihat Detail"><i class="fas fa-eye"></i></a>
              </div>
            </td>
          </tr>
          <tr>
            <td>2</td>
            <td>Ocean View Hotel</td>
            <td>Lombok, Pantai Kuta</td>
            <td>Hotel Bintang 4</td>
            <td>Rp 850.000</td>
            <td>
              <div class="rating-stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="far fa-star"></i>
                <span>(4.0)</span>
              </div>
            </td>
            <td><span class="status-badge full">Penuh</span></td>
            <td>
              <div class="action-icons">
                <a href="edit_penginapan.php?id=2" title="Edit"><i class="fas fa-edit"></i></a>
                <a href="hapus_penginapan.php?id=2" title="Hapus" onclick="return confirm('Yakin ingin menghapus penginapan ini?')"><i class="fas fa-trash-alt"></i></a>
                <a href="detail_penginapan.php?id=2" title="Lihat Detail"><i class="fas fa-eye"></i></a>
              </div>
            </td>
          </tr>
          <tr>
            <td>3</td>
            <td>Mountain Cabin Retreat</td>
            <td>Jawa Barat, Puncak</td>
            <td>Villa</td>
            <td>Rp 2.200.000</td>
            <td>
              <div class="rating-stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <span>(4.9)</span>
              </div>
            </td>
            <td><span class="status-badge available">Tersedia</span></td>
            <td>
              <div class="action-icons">
                <a href="edit_penginapan.php?id=3" title="Edit"><i class="fas fa-edit"></i></a>
                <a href="hapus_penginapan.php?id=3" title="Hapus" onclick="return confirm('Yakin ingin menghapus penginapan ini?')"><i class="fas fa-trash-alt"></i></a>
                <a href="detail_penginapan.php?id=3" title="Lihat Detail"><i class="fas fa-eye"></i></a>
              </div>
            </td>
          </tr>
          <tr>
            <td>4</td>
            <td>City Central Inn</td>
            <td>Jakarta Pusat</td>
            <td>Hotel Bintang 3</td>
            <td>Rp 650.000</td>
            <td>
              <div class="rating-stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="far fa-star"></i>
                <i class="far fa-star"></i>
                <span>(3.2)</span>
              </div>
            </td>
            <td><span class="status-badge maintenance">Renovasi</span></td>
            <td>
              <div class="action-icons">
                <a href="edit_penginapan.php?id=4" title="Edit"><i class="fas fa-edit"></i></a>
                <a href="hapus_penginapan.php?id=4" title="Hapus" onclick="return confirm('Yakin ingin menghapus penginapan ini?')"><i class="fas fa-trash-alt"></i></a>
                <a href="detail_penginapan.php?id=4" title="Lihat Detail"><i class="fas fa-eye"></i></a>
              </div>
            </td>
          </tr>
          <tr>
            <td>5</td>
            <td>Beachfront Bungalows</td>
            <td>Bali, Canggu</td>
            <td>Bungalow</td>
            <td>Rp 1.100.000</td>
            <td>
              <div class="rating-stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
                <span>(4.6)</span>
              </div>
            </td>
            <td><span class="status-badge available">Tersedia</span></td>
            <td>
              <div class="action-icons">
                <a href="edit_penginapan.php?id=5" title="Edit"><i class="fas fa-edit"></i></a>
                <a href="hapus_penginapan.php?id=5" title="Hapus" onclick="return confirm('Yakin ingin menghapus penginapan ini?')"><i class="fas fa-trash-alt"></i></a>
                <a href="detail_penginapan.php?id=5" title="Lihat Detail"><i class="fas fa-eye"></i></a>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </main>

  <script>
    // Simple search functionality
    const searchInput = document.querySelector('.search-bar input');
    const searchButton = document.querySelector('.search-bar button');
    const tableRows = document.querySelectorAll('.accommodation-table tbody tr');

    function performSearch() {
      const searchTerm = searchInput.value.toLowerCase();
      
      tableRows.forEach(row => {
        const text = row.textContent.toLowerCase();
        if (text.includes(searchTerm)) {
          row.style.display = '';
        } else {
          row.style.display = 'none';
        }
      });
    }

    searchButton.addEventListener('click', performSearch);
    searchInput.addEventListener('keyup', function(e) {
      if (e.key === 'Enter') {
        performSearch();
      }
    });

    // Real-time search
    searchInput.addEventListener('input', performSearch);
  </script>
</body>
</html>