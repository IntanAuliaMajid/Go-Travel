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

    /* Main Content */
    main {
      margin-left: 250px;
      padding: 20px;
      min-height: 100vh;
    }

    /* Header */
    .page-header {
      background: white;
      padding: 20px;
      border-radius: 8px;
      margin-bottom: 20px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .page-header h1 {
      color: #2c3e50;
      font-size: 1.8rem;
      font-weight: 600;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .page-header p {
      color: #6c757d;
      margin-top: 5px;
      font-size: 1rem;
    }

    /* Stats Cards */
    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 15px;
      margin-bottom: 20px;
    }

    .stat-card {
      background: white;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
      display: flex;
      align-items: center;
      gap: 15px;
    }

    .stat-icon {
      width: 50px;
      height: 50px;
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.2rem;
      color: white;
    }

    .stat-icon.total { background-color: #3498db; }
    .stat-icon.confirmed { background-color: #27ae60; }
    .stat-icon.pending { background-color: #f39c12; }
    .stat-icon.cancelled { background-color: #e74c3c; }

    .stat-info h3 {
      font-size: 1.8rem;
      font-weight: 600;
      color: #2c3e50;
      margin-bottom: 2px;
    }

    .stat-info p {
      color: #6c757d;
      font-size: 0.9rem;
    }

    /* Filter Section */
    .filter-section {
      background: white;
      padding: 20px;
      border-radius: 8px;
      margin-bottom: 20px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .filter-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
      gap: 15px;
      align-items: end;
    }

    .filter-group label {
      display: block;
      color: #2c3e50;
      font-weight: 500;
      margin-bottom: 5px;
      font-size: 0.9rem;
    }

    .filter-group input, .filter-group select {
      width: 100%;
      padding: 10px 12px;
      border: 1px solid #ddd;
      border-radius: 6px;
      font-size: 0.9rem;
      transition: border-color 0.2s ease;
    }

    .filter-group input:focus, .filter-group select:focus {
      outline: none;
      border-color: #3498db;
    }

    .btn-filter {
      background-color: #3498db;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 6px;
      font-size: 0.9rem;
      font-weight: 500;
      cursor: pointer;
      transition: background-color 0.2s ease;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .btn-filter:hover {
      background-color: #2980b9;
    }

    /* Table Container */
    .table-container {
      background: white;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
      overflow: hidden;
    }

    .table-header {
      padding: 20px;
      border-bottom: 1px solid #e9ecef;
    }

    .table-header h2 {
      font-size: 1.3rem;
      color: #2c3e50;
      font-weight: 600;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    /* Table */
    .order-table {
      width: 100%;
      border-collapse: collapse;
    }

    .order-table thead {
      background-color: #f8f9fa;
    }

    .order-table th {
      padding: 15px;
      text-align: left;
      color: #495057;
      font-weight: 600;
      font-size: 0.85rem;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      border-bottom: 1px solid #dee2e6;
    }

    .order-table td {
      padding: 15px;
      color: #495057;
      font-size: 0.9rem;
      border-bottom: 1px solid #f1f3f4;
      vertical-align: middle;
    }

    .order-table tbody tr:hover {
      background-color: #f8f9fa;
    }

    /* Status Badges */
    .status-badge {
      padding: 6px 12px;
      border-radius: 20px;
      font-size: 0.75rem;
      font-weight: 500;
      text-transform: uppercase;
      letter-spacing: 0.3px;
      display: inline-block;
    }

    .status-badge.confirmed {
      background-color: #d4edda;
      color: #155724;
    }

    .status-badge.pending {
      background-color: #fff3cd;
      color: #856404;
    }

    .status-badge.cancelled {
      background-color: #f8d7da;
      color: #721c24;
    }

    .status-badge.paid {
      background-color: #d1ecf1;
      color: #0c5460;
    }

    /* Action Buttons */
    .action-buttons {
      display: flex;
      gap: 5px;
    }

    .btn-action {
      padding: 8px 10px;
      border: none;
      border-radius: 6px;
      font-size: 0.8rem;
      cursor: pointer;
      color: white;
      transition: opacity 0.2s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      min-width: 35px;
    }

    .btn-action:hover {
      opacity: 0.8;
    }

    .btn-view { background-color: #3498db; }
    .btn-confirm { background-color: #27ae60; }
    .btn-cancel { background-color: #e74c3c; }
    .btn-edit { background-color: #f39c12; }

    /* Customer Info */
    .customer-info {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .customer-avatar {
      width: 35px;
      height: 35px;
      border-radius: 50%;
      background-color: #6c757d;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-weight: 500;
      font-size: 0.8rem;
    }

    .customer-details h4 {
      color: #2c3e50;
      font-size: 0.9rem;
      font-weight: 500;
      margin-bottom: 1px;
    }

    .customer-details p {
      color: #6c757d;
      font-size: 0.75rem;
    }

    /* Package Info */
    .package-info {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .package-icon {
      width: 30px;
      height: 30px;
      border-radius: 6px;
      background-color: #e74c3c;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 0.7rem;
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
      .sidebar {
        transform: translateX(-100%);
      }
      
      main {
        margin-left: 0;
      }
      
      .stats-grid {
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
      }
    }

    @media (max-width: 768px) {
      main {
        padding: 15px;
      }
      
      .filter-grid {
        grid-template-columns: 1fr;
      }
      
      .order-table {
        font-size: 0.8rem;
      }
      
      .order-table th, .order-table td {
        padding: 10px;
      }
      
      .action-buttons {
        flex-direction: column;
        gap: 3px;
      }
      
      .customer-info, .package-info {
        flex-direction: column;
        align-items: flex-start;
        gap: 5px;
      }
    }
  </style>
</head>
<body>
    <?php include '../Komponen/sidebar_admin.php'; ?>
  <main>
    <!-- Page Header -->
    <div class="page-header">
      <h1><i class="fas fa-file-invoice"></i> Manajemen Pemesanan</h1>
      <p>Kelola dan pantau semua pemesanan wisata Anda</p>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-icon total">
          <i class="fas fa-file-invoice"></i>
        </div>
        <div class="stat-info">
          <h3>24</h3>
          <p>Total Pemesanan</p>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-icon confirmed">
          <i class="fas fa-check-circle"></i>
        </div>
        <div class="stat-info">
          <h3>18</h3>
          <p>Dikonfirmasi</p>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-icon pending">
          <i class="fas fa-clock"></i>
        </div>
        <div class="stat-info">
          <h3>4</h3>
          <p>Menunggu</p>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-icon cancelled">
          <i class="fas fa-times-circle"></i>
        </div>
        <div class="stat-info">
          <h3>2</h3>
          <p>Dibatalkan</p>
        </div>
      </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
      <div class="filter-grid">
        <div class="filter-group">
          <label>Status Pembayaran</label>
          <select>
            <option value="">Semua Status</option>
            <option value="paid">Lunas</option>
            <option value="pending">Belum Bayar</option>
          </select>
        </div>
        <div class="filter-group">
          <label>Status Order</label>
          <select>
            <option value="">Semua Status</option>
            <option value="confirmed">Dikonfirmasi</option>
            <option value="pending">Menunggu</option>
            <option value="cancelled">Dibatalkan</option>
          </select>
        </div>
        <div class="filter-group">
          <label>Tanggal Mulai</label>
          <input type="date" value="2025-06-01">
        </div>
        <div class="filter-group">
          <label>Tanggal Akhir</label>
          <input type="date" value="2025-12-31">
        </div>
        <div class="filter-group">
          <button class="btn-filter">
            <i class="fas fa-search"></i>
            Filter
          </button>
        </div>
      </div>
    </div>

    <!-- Table Container -->
    <div class="table-container">
      <div class="table-header">
        <h2><i class="fas fa-list"></i> Daftar Pemesanan</h2>
      </div>
      
      <table class="order-table">
        <thead>
          <tr>
            <th>No</th>
            <th>Pemesan</th>
            <th>Paket Wisata</th>
            <th>Tanggal</th>
            <th>Peserta</th>
            <th>Pembayaran</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><strong>#001</strong></td>
            <td>
              <div class="customer-info">
                <div class="customer-avatar">AW</div>
                <div class="customer-details">
                  <h4>Andi Wijaya</h4>
                  <p>andi.wijaya@email.com</p>
                </div>
              </div>
            </td>
            <td>
              <div class="package-info">
                <div>
                  <strong>Pulau Seribu</strong>
                  <br><small>3D2N - Rp 2.500.000</small>
                </div>
              </div>
            </td>
            <td>
              <strong>10 Jun 2025</strong>
              <br><small>3 hari lagi</small>
            </td>
            <td>
              <strong>2 Orang</strong>
              <br><small>Dewasa: 2</small>
            </td>
            <td><span class="status-badge paid">Lunas</span></td>
            <td><span class="status-badge confirmed">Dikonfirmasi</span></td>
            <td>
              <div class="action-buttons">
                <button class="btn-action btn-view" title="Lihat Detail">
                  <i class="fas fa-eye"></i>
                </button>
                <button class="btn-action btn-edit" title="Edit">
                  <i class="fas fa-edit"></i>
                </button>
                <button class="btn-action btn-cancel" title="Batalkan">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </td>
          </tr>
          <tr>
            <td><strong>#002</strong></td>
            <td>
              <div class="customer-info">
                <div class="customer-avatar">SL</div>
                <div class="customer-details">
                  <h4>Sinta Lestari</h4>
                  <p>sinta.lestari@email.com</p>
                </div>
              </div>
            </td>
            <td>
              <div class="package-info">
                <div>
                  <strong>Gunung Bromo</strong>
                  <br><small>2D1N - Rp 1.800.000</small>
                </div>
              </div>
            </td>
            <td>
              <strong>01 Jul 2025</strong>
              <br><small>32 hari lagi</small>
            </td>
            <td>
              <strong>4 Orang</strong>
              <br><small>Dewasa: 3, Anak: 1</small>
            </td>
            <td><span class="status-badge pending">Belum Bayar</span></td>
            <td><span class="status-badge pending">Menunggu</span></td>
            <td>
              <div class="action-buttons">
                <button class="btn-action btn-view" title="Lihat Detail">
                  <i class="fas fa-eye"></i>
                </button>
                <button class="btn-action btn-confirm" title="Konfirmasi">
                  <i class="fas fa-check"></i>
                </button>
                <button class="btn-action btn-edit" title="Edit">
                  <i class="fas fa-edit"></i>
                </button>
              </div>
            </td>
          </tr>
          <tr>
            <td><strong>#003</strong></td>
            <td>
              <div class="customer-info">
                <div class="customer-avatar">BH</div>
                <div class="customer-details">
                  <h4>Budi Hartono</h4>
                  <p>budi.hartono@email.com</p>
                </div>
              </div>
            </td>
            <td>
              <div class="package-info">
                <div>
                  <strong>Pantai Bali</strong>
                  <br><small>4D3N - Rp 3.200.000</small>
                </div>
              </div>
            </td>
            <td>
              <strong>15 Jun 2025</strong>
              <br><small>16 hari lagi</small>
            </td>
            <td>
              <strong>6 Orang</strong>
              <br><small>Dewasa: 4, Anak: 2</small>
            </td>
            <td><span class="status-badge paid">Lunas</span></td>
            <td><span class="status-badge confirmed">Dikonfirmasi</span></td>
            <td>
              <div class="action-buttons">
                <button class="btn-action btn-view" title="Lihat Detail">
                  <i class="fas fa-eye"></i>
                </button>
                <button class="btn-action btn-edit" title="Edit">
                  <i class="fas fa-edit"></i>
                </button>
                <button class="btn-action btn-cancel" title="Batalkan">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </td>
          </tr>
          <tr>
            <td><strong>#004</strong></td>
            <td>
              <div class="customer-info">
                <div class="customer-avatar">MP</div>
                <div class="customer-details">
                  <h4>Maya Putri</h4>
                  <p>maya.putri@email.com</p>
                </div>
              </div>
            </td>
            <td>
              <div class="package-info">
                <div>
                  <strong>Hutan Pinus</strong>
                  <br><small>1D - Rp 500.000</small>
                </div>
              </div>
            </td>
            <td>
              <strong>20 Jun 2025</strong>
              <br><small>21 hari lagi</small>
            </td>
            <td>
              <strong>8 Orang</strong>
              <br><small>Dewasa: 6, Anak: 2</small>
            </td>
            <td><span class="status-badge pending">Belum Bayar</span></td>
            <td><span class="status-badge cancelled">Dibatalkan</span></td>
            <td>
              <div class="action-buttons">
                <button class="btn-action btn-view" title="Lihat Detail">
                  <i class="fas fa-eye"></i>
                </button>
                <button class="btn-action btn-edit" title="Edit">
                  <i class="fas fa-edit"></i>
                </button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </main>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Simple button click handlers
      document.querySelectorAll('.btn-action').forEach(btn => {
        btn.addEventListener('click', function(e) {
          e.preventDefault();
          const action = this.classList.contains('btn-view') ? 'view' :
                        this.classList.contains('btn-confirm') ? 'confirm' :
                        this.classList.contains('btn-edit') ? 'edit' : 'cancel';
          
          console.log(`Action: ${action} clicked`);
        });
      });

      // Filter functionality
      document.querySelector('.btn-filter').addEventListener('click', function() {
        console.log('Filter applied');
      });
    });
  </script>
</body>
</html>