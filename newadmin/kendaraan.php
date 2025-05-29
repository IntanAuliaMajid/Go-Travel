<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Admin - Manajemen Kendaraan</title>
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
      border-left: 5px solid #3498db;
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
      background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="%233498db" stroke-width="1" opacity="0.1"><path d="M5 18H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h3m14 0h3a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2h-3m-14 0v2a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2M5 18h14M5 8h14"></path></svg>') no-repeat center;
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

    .stat-card.blue::before {
      background: linear-gradient(90deg, #3498db, #2980b9);
    }

    .stat-card.green::before {
      background: linear-gradient(90deg, #27ae60, #2ecc71);
    }

    .stat-card.orange::before {
      background: linear-gradient(90deg, #e67e22, #d35400);
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

    .stat-card.blue .stat-icon { color: #3498db; }
    .stat-card.green .stat-icon { color: #27ae60; }
    .stat-card.orange .stat-icon { color: #e67e22; }
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
      background: linear-gradient(135deg, #3498db, #2980b9);
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
      box-shadow: 0 10px 20px rgba(52, 152, 219, 0.3);
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

    /* Vehicle Management */
    .vehicle-management {
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
      background: #3498db;
      color: white;
      border: none;
      border-radius: 8px;
      padding: 10px 15px;
      cursor: pointer;
    }

    .vehicle-table {
      width: 100%;
      border-collapse: collapse;
    }

    .vehicle-table th {
      background: #f8f9fa;
      text-align: left;
      padding: 15px;
      color: #2c3e50;
      font-weight: 600;
      border-bottom: 2px solid #eee;
    }

    .vehicle-table td {
      padding: 15px;
      border-bottom: 1px solid #eee;
      color: #555;
    }

    .vehicle-table tr:hover {
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

    .status-badge.booked {
      background: #fff3cd;
      color: #856404;
    }

    .status-badge.maintenance {
      background: #f8d7da;
      color: #721c24;
    }

    .action-icons {
      display: flex;
      gap: 12px;
    }

    .action-icons a {
      color: #555;
      transition: color 0.3s;
    }

    .action-icons a:hover {
      color: #3498db;
    }

    /* Form Modal */
    .modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0,0,0,0.5);
      z-index: 1000;
      justify-content: center;
      align-items: center;
    }

    .modal-content {
      background: white;
      border-radius: 15px;
      width: 500px;
      max-width: 90%;
      box-shadow: 0 20px 40px rgba(0,0,0,0.2);
    }

    .modal-header {
      padding: 20px;
      border-bottom: 1px solid #eee;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .modal-header h3 {
      color: #2c3e50;
      font-size: 1.4rem;
    }

    .close-modal {
      background: none;
      border: none;
      font-size: 1.5rem;
      cursor: pointer;
      color: #7f8c8d;
    }

    .modal-body {
      padding: 20px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      margin-bottom: 8px;
      color: #2c3e50;
      font-weight: 500;
    }

    .form-group input, 
    .form-group select, 
    .form-group textarea {
      width: 100%;
      padding: 12px;
      border: 1px solid #ddd;
      border-radius: 8px;
      font-family: inherit;
    }

    .form-group textarea {
      min-height: 100px;
      resize: vertical;
    }

    .form-actions {
      display: flex;
      justify-content: flex-end;
      gap: 15px;
      padding: 20px;
      border-top: 1px solid #eee;
    }

    .btn {
      padding: 12px 20px;
      border-radius: 8px;
      border: none;
      cursor: pointer;
      font-weight: 500;
      transition: all 0.3s;
    }

    .btn-primary {
      background: #3498db;
      color: white;
    }

    .btn-primary:hover {
      background: #2980b9;
    }

    .btn-secondary {
      background: #ecf0f1;
      color: #7f8c8d;
    }

    .btn-secondary:hover {
      background: #d5dbdb;
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

      .vehicle-table {
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
      <h1><i class="fas fa-car" style="color: #3498db; margin-right: 10px;"></i>Manajemen Kendaraan</h1>
      <p>Kelola armada kendaraan dengan mudah. Tambah, edit, atau hapus kendaraan sesuai kebutuhan.</p>
    </div>

    <!-- Stats Cards -->
    <div class="stats-container">
      <div class="stat-card blue">
        <div class="stat-icon">
          <i class="fas fa-car"></i>
        </div>
        <h3>42</h3>
        <p>Total Kendaraan</p>
        <small style="color: #27ae60;">↑ 3 kendaraan baru bulan ini</small>
      </div>
      
      <div class="stat-card green">
        <div class="stat-icon">
          <i class="fas fa-check-circle"></i>
        </div>
        <h3>35</h3>
        <p>Kendaraan Tersedia</p>
        <small style="color: #e74c3c;">↓ 2% dari bulan lalu</small>
      </div>
      
      <div class="stat-card orange">
        <div class="stat-icon">
          <i class="fas fa-tools"></i>
        </div>
        <h3>4</h3>
        <p>Dalam Perbaikan</p>
        <small style="color: #27ae60;">↓ 1 dari bulan lalu</small>
      </div>
    </div>

    <!-- Quick Actions -->
    <div class="quick-actions">
      <h2><i class="fas fa-bolt"></i> Aksi Cepat</h2>
      <div class="action-buttons">
        <button id="addVehicleBtn" class="action-btn">
          <i class="fas fa-plus-circle"></i> Tambah Kendaraan
        </button>
        <a href="#" class="action-btn orange">
          <i class="fas fa-calendar-alt"></i> Jadwal Perawatan
        </a>
      </div>
    </div>

    <!-- Vehicle Management -->
    <div class="vehicle-management">
      <div class="section-header">
        <h2><i class="fas fa-list"></i> Daftar Kendaraan</h2>
        <div class="search-bar">
          <input type="text" placeholder="Cari kendaraan...">
          <button><i class="fas fa-search"></i></button>
        </div>
      </div>
      
      <table class="vehicle-table">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama Kendaraan</th>
            <th>Jenis</th>
            <th>Kapasitas</th>
            <th>Harga Sewa</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1</td>
            <td>Toyota Hiace Premio</td>
            <td>Minibus</td>
            <td>14 Orang</td>
            <td>Rp 1.200.000/hari</td>
            <td><span class="status-badge available">Tersedia</span></td>
            <td>
              <div class="action-icons">
                <a href="#" class="edit-btn" data-id="1"><i class="fas fa-edit"></i></a>
                <a href="#"><i class="fas fa-trash-alt"></i></a>
                <a href="#"><i class="fas fa-info-circle"></i></a>
              </div>
            </td>
          </tr>
          <tr>
            <td>2</td>
            <td>Mitsubishi Pajero Sport</td>
            <td>SUV</td>
            <td>7 Orang</td>
            <td>Rp 1.500.000/hari</td>
            <td><span class="status-badge booked">Dipesan</span></td>
            <td>
              <div class="action-icons">
                <a href="#" class="edit-btn" data-id="2"><i class="fas fa-edit"></i></a>
                <a href="#"><i class="fas fa-trash-alt"></i></a>
                <a href="#"><i class="fas fa-info-circle"></i></a>
              </div>
            </td>
          </tr>
          <tr>
            <td>3</td>
            <td>Isuzu Elf Long</td>
            <td>Bus Mini</td>
            <td>24 Orang</td>
            <td>Rp 2.000.000/hari</td>
            <td><span class="status-badge available">Tersedia</span></td>
            <td>
              <div class="action-icons">
                <a href="#" class="edit-btn" data-id="3"><i class="fas fa-edit"></i></a>
                <a href="#"><i class="fas fa-trash-alt"></i></a>
                <a href="#"><i class="fas fa-info-circle"></i></a>
              </div>
            </td>
          </tr>
          <tr>
            <td>4</td>
            <td>Honda Brio</td>
            <td>Sedan Kecil</td>
            <td>5 Orang</td>
            <td>Rp 400.000/hari</td>
            <td><span class="status-badge booked">Dipesan</span></td>
            <td>
              <div class="action-icons">
                <a href="#" class="edit-btn" data-id="4"><i class="fas fa-edit"></i></a>
                <a href="#"><i class="fas fa-trash-alt"></i></a>
                <a href="#"><i class="fas fa-info-circle"></i></a>
              </div>
            </td>
          </tr>
          <tr>
            <td>5</td>
            <td>Toyota Avanza</td>
            <td>MPV</td>
            <td>7 Orang</td>
            <td>Rp 500.000/hari</td>
            <td><span class="status-badge maintenance">Perbaikan</span></td>
            <td>
              <div class="action-icons">
                <a href="#" class="edit-btn" data-id="5"><i class="fas fa-edit"></i></a>
                <a href="#"><i class="fas fa-trash-alt"></i></a>
                <a href="#"><i class="fas fa-info-circle"></i></a>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    
    <!-- Add Vehicle Modal -->
    <div id="vehicleModal" class="modal">
      <div class="modal-content">
        <div class="modal-header">
          <h3 id="modalTitle">Tambah Kendaraan Baru</h3>
          <button class="close-modal">&times;</button>
        </div>
        <div class="modal-body">
          <form id="vehicleForm">
            <div class="form-group">
              <label for="vehicleName">Nama Kendaraan</label>
              <input type="text" id="vehicleName" placeholder="Contoh: Toyota Avanza" required>
            </div>
            <div class="form-group">
              <label for="vehicleType">Jenis Kendaraan</label>
              <select id="vehicleType" required>
                <option value="">Pilih Jenis</option>
                <option value="sedan">Sedan</option>
                <option value="suv">SUV</option>
                <option value="mpv">MPV</option>
                <option value="minibus">Minibus</option>
                <option value="bus">Bus</option>
                <option value="motor">Motor</option>
              </select>
            </div>
            <div class="form-group">
              <label for="vehicleCapacity">Kapasitas (Orang)</label>
              <input type="number" id="vehicleCapacity" min="1" max="50" required>
            </div>
            <div class="form-group">
              <label for="vehiclePrice">Harga Sewa per Hari (Rp)</label>
              <input type="number" id="vehiclePrice" min="100000" required>
            </div>
            <div class="form-group">
              <label for="vehicleStatus">Status</label>
              <select id="vehicleStatus" required>
                <option value="available">Tersedia</option>
                <option value="booked">Dipesan</option>
                <option value="maintenance">Perbaikan</option>
              </select>
            </div>
            <div class="form-group">
              <label for="vehicleNotes">Catatan</label>
              <textarea id="vehicleNotes" placeholder="Tambahkan catatan tentang kendaraan..."></textarea>
            </div>
          </form>
        </div>
        <div class="form-actions">
          <button class="btn btn-secondary close-modal">Batal</button>
          <button class="btn btn-primary" id="saveVehicle">Simpan</button>
        </div>
      </div>
    </div>
  </main>

  <script>
    // Modal functionality
    const modal = document.getElementById('vehicleModal');
    const addBtn = document.getElementById('addVehicleBtn');
    const closeBtns = document.querySelectorAll('.close-modal');
    const saveBtn = document.getElementById('saveVehicle');
    const modalTitle = document.getElementById('modalTitle');
    const editBtns = document.querySelectorAll('.edit-btn');
    
    // Open modal for adding vehicle
    addBtn.addEventListener('click', () => {
      modalTitle.textContent = 'Tambah Kendaraan Baru';
      document.getElementById('vehicleForm').reset();
      modal.style.display = 'flex';
    });
    
    // Open modal for editing vehicle
    editBtns.forEach(btn => {
      btn.addEventListener('click', (e) => {
        e.preventDefault();
        const vehicleId = btn.getAttribute('data-id');
        modalTitle.textContent = 'Edit Kendaraan';
        
        // In a real app, you would fetch vehicle data based on ID
        // For demo, we'll set some sample values
        document.getElementById('vehicleName').value = 'Toyota Hiace Premio';
        document.getElementById('vehicleType').value = 'minibus';
        document.getElementById('vehicleCapacity').value = 14;
        document.getElementById('vehiclePrice').value = 1200000;
        document.getElementById('vehicleStatus').value = 'available';
        document.getElementById('vehicleNotes').value = 'Kendaraan dalam kondisi baik, servis terakhir 3 bulan lalu';
        
        modal.style.display = 'flex';
      });
    });
    
    // Close modal
    closeBtns.forEach(btn => {
      btn.addEventListener('click', () => {
        modal.style.display = 'none';
      });
    });
    
    // Save vehicle data
    saveBtn.addEventListener('click', () => {
      // In a real app, you would save to database
      alert('Data kendaraan berhasil disimpan!');
      modal.style.display = 'none';
    });
    
    // Close modal when clicking outside
    window.addEventListener('click', (e) => {
      if (e.target === modal) {
        modal.style.display = 'none';
      }
    });
  </script>
</body>
</html>