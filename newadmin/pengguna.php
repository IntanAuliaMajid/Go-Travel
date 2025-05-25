<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Admin - Manajemen Pengguna</title>
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
    }



    /* Main Content */
    .main-content {
      margin-left: 220px;
      padding: 30px;
      min-height: 100vh;
    }

    .dashboard-header {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(10px);
      border-radius: 20px;
      padding: 30px;
      margin-bottom: 30px;
      box-shadow: 0 10px 40px rgba(0,0,0,0.1);
      border: 1px solid rgba(255,255,255,0.2);
    }

    .header-top {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }

    .header-top h1 {
      color: #2c3e50;
      font-size: 2.2rem;
      font-weight: 700;
      background: linear-gradient(135deg, #667eea, #764ba2);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    .add-user-btn {
      background: linear-gradient(135deg, #3498db, #2980b9);
      color: white;
      border: none;
      padding: 15px 25px;
      border-radius: 12px;
      cursor: pointer;
      font-weight: 600;
      font-size: 1rem;
      transition: all 0.3s ease;
      box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .add-user-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(52, 152, 219, 0.4);
    }

    .search-container {
      position: relative;
      max-width: 400px;
    }

    .search-input {
      width: 100%;
      padding: 15px 20px 15px 50px;
      border: 2px solid #e8ecef;
      border-radius: 15px;
      font-size: 1rem;
      background: white;
      transition: all 0.3s ease;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .search-input:focus {
      outline: none;
      border-color: #3498db;
      box-shadow: 0 5px 20px rgba(52, 152, 219, 0.2);
    }

    .search-icon {
      position: absolute;
      left: 18px;
      top: 50%;
      transform: translateY(-50%);
      color: #7f8c8d;
      font-size: 1.1rem;
    }

    /* Stats Cards */
    .stats-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 20px;
      margin-bottom: 30px;
    }

    .stat-card {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(10px);
      border-radius: 20px;
      padding: 25px;
      box-shadow: 0 10px 40px rgba(0,0,0,0.1);
      border: 1px solid rgba(255,255,255,0.2);
      transition: all 0.3s ease;
    }

    .stat-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 15px 50px rgba(0,0,0,0.15);
    }

    .stat-card h3 {
      color: #7f8c8d;
      font-size: 0.9rem;
      margin-bottom: 10px;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .stat-card .number {
      font-size: 2.5rem;
      font-weight: 700;
      color: #2c3e50;
      margin-bottom: 5px;
    }

    .stat-card .trend {
      font-size: 0.85rem;
      color: #27ae60;
    }

    /* Table Styles */
    .table-container {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(10px);
      border-radius: 20px;
      padding: 30px;
      box-shadow: 0 10px 40px rgba(0,0,0,0.1);
      border: 1px solid rgba(255,255,255,0.2);
      overflow: hidden;
    }

    .table-wrapper {
      overflow-x: auto;
      border-radius: 15px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: white;
    }

    th {
      background: linear-gradient(135deg, #f8f9fa, #e9ecef);
      padding: 20px 15px;
      text-align: left;
      font-weight: 600;
      color: #2c3e50;
      font-size: 0.95rem;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      border: none;
    }

    td {
      padding: 20px 15px;
      border-bottom: 1px solid #f1f3f4;
      vertical-align: middle;
    }

    tr:hover {
      background: linear-gradient(90deg, rgba(52, 152, 219, 0.05), rgba(52, 152, 219, 0.02));
    }

    .user-info {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .user-avatar {
      width: 45px;
      height: 45px;
      border-radius: 50%;
      background: linear-gradient(135deg, #3498db, #2980b9);
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-weight: 600;
      font-size: 1.1rem;
    }

    .user-details h4 {
      color: #2c3e50;
      font-weight: 600;
      margin-bottom: 2px;
    }

    .user-details span {
      color: #7f8c8d;
      font-size: 0.9rem;
    }

    .role-badge {
      padding: 8px 15px;
      border-radius: 20px;
      font-size: 0.85rem;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .role-admin {
      background: linear-gradient(135deg, #e74c3c, #c0392b);
      color: white;
    }

    .role-user {
      background: linear-gradient(135deg, #27ae60, #2ecc71);
      color: white;
    }



    .action-buttons {
      display: flex;
      gap: 8px;
    }

    .btn {
      padding: 8px 15px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-size: 0.85rem;
      font-weight: 500;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      gap: 5px;
    }

    .btn-edit {
      background: linear-gradient(135deg, #3498db, #2980b9);
      color: white;
    }

    .btn-edit:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
    }

    .btn-delete {
      background: linear-gradient(135deg, #e74c3c, #c0392b);
      color: white;
    }

    .btn-delete:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(231, 76, 60, 0.3);
    }

    .btn-view {
      background: linear-gradient(135deg, #95a5a6, #7f8c8d);
      color: white;
    }

    .btn-view:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(149, 165, 166, 0.3);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      .main-content {
        margin-left: 0;
        padding: 20px;
      }

      .header-top {
        flex-direction: column;
        gap: 20px;
        align-items: stretch;
      }

      .stats-container {
        grid-template-columns: 1fr;
      }

      .action-buttons {
        flex-direction: column;
      }
    }

    /* Loading Animation */
    @keyframes pulse {
      0% { opacity: 1; }
      50% { opacity: 0.5; }
      100% { opacity: 1; }
    }

    .loading {
      animation: pulse 1.5s ease-in-out infinite;
    }
  </style>
</head>
<body>
  <?php include '../komponen/sidebar_admin.php'; ?>

  <!-- Main Content -->
  <main class="main-content">
    <!-- Dashboard Header -->
    <div class="dashboard-header">
      <div class="header-top">
        <div>
          <h1>Manajemen Pengguna</h1>
          <p style="color: #7f8c8d; margin-top: 8px;">Kelola semua pengguna sistem dengan mudah</p>
        </div>
        <button class="add-user-btn" onclick="addUser()">
          <i class="fas fa-plus"></i>
          Tambah Pengguna
        </button>
      </div>

      <!-- Search Bar -->
      <div class="search-container">
        <i class="fas fa-search search-icon"></i>
        <input type="text" class="search-input" placeholder="Cari berdasarkan nama atau email..." id="searchInput">
      </div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-container">
      <div class="stat-card">
        <h3>Total Pengguna</h3>
        <div class="number">1,247</div>
        <div class="trend"><i class="fas fa-arrow-up"></i> +12% bulan ini</div>
      </div>
      <div class="stat-card">
        <h3>Admin Aktif</h3>
        <div class="number">23</div>
        <div class="trend"><i class="fas fa-arrow-up"></i> +2 minggu ini</div>
      </div>
      <div class="stat-card">
        <h3>User Aktif</h3>
        <div class="number">1,224</div>
        <div class="trend"><i class="fas fa-arrow-up"></i> +8% minggu ini</div>
      </div>
    </div>

    <!-- User Table -->
    <div class="table-container">
      <div class="table-wrapper">
        <table id="userTable">
          <thead>
            <tr>
              <th>Pengguna</th>
              <th>Role</th>
              <th>Status</th>
              <th>Terakhir Login</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>
                <div class="user-info">
                  <div class="user-avatar">JD</div>
                  <div class="user-details">
                    <h4>John Doe</h4>
                    <span>john.doe@example.com</span>
                  </div>
                </div>
              </td>
              <td><span class="role-badge role-admin">Admin</span></td>
              <td><span style="color: #27ae60; font-weight: 600;"><i class="fas fa-circle" style="font-size: 8px; margin-right: 5px;"></i>Online</span></td>
              <td>2 menit lalu</td>
              <td>
                <div class="action-buttons">
                  <button class="btn btn-view" onclick="viewUser(1)">
                    <i class="fas fa-eye"></i>
                  </button>
                  <button class="btn btn-edit" onclick="editUser(1)">
                    <i class="fas fa-edit"></i>
                  </button>
                  <button class="btn btn-delete" onclick="deleteUser(1)">
                    <i class="fas fa-trash"></i>
                  </button>
                </div>
              </td>
            </tr>
            <tr>
              <td>
                <div class="user-info">
                  <div class="user-avatar">JS</div>
                  <div class="user-details">
                    <h4>Jane Smith</h4>
                    <span>jane.smith@example.com</span>
                  </div>
                </div>
              </td>
              <td><span class="role-badge role-user">User</span></td>
              <td><span style="color: #7f8c8d; font-weight: 600;"><i class="fas fa-circle" style="font-size: 8px; margin-right: 5px;"></i>Offline</span></td>
              <td>1 jam lalu</td>
              <td>
                <div class="action-buttons">
                  <button class="btn btn-view" onclick="viewUser(2)">
                    <i class="fas fa-eye"></i>
                  </button>
                  <button class="btn btn-edit" onclick="editUser(2)">
                    <i class="fas fa-edit"></i>
                  </button>
                  <button class="btn btn-delete" onclick="deleteUser(2)">
                    <i class="fas fa-trash"></i>
                  </button>
                </div>
              </td>
            </tr>
            <tr>
              <td>
                <div class="user-info">
                  <div class="user-avatar">MJ</div>
                  <div class="user-details">
                    <h4>Michael Johnson</h4>
                    <span>michael.j@example.com</span>
                  </div>
                </div>
              </td>
              <td><span class="role-badge role-user">User</span></td>
              <td><span style="color: #27ae60; font-weight: 600;"><i class="fas fa-circle" style="font-size: 8px; margin-right: 5px;"></i>Online</span></td>
              <td>5 menit lalu</td>
              <td>
                <div class="action-buttons">
                  <button class="btn btn-view" onclick="viewUser(3)">
                    <i class="fas fa-eye"></i>
                  </button>
                  <button class="btn btn-edit" onclick="editUser(3)">
                    <i class="fas fa-edit"></i>
                  </button>
                  <button class="btn btn-delete" onclick="deleteUser(3)">
                    <i class="fas fa-trash"></i>
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </main>

  <script>
    // Search functionality
    document.getElementById('searchInput').addEventListener('input', function(e) {
      const searchTerm = e.target.value.toLowerCase();
      const rows = document.querySelectorAll('#userTable tbody tr');
      
      rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
      });
    });

    // Button functions
    function addUser() {
      alert('Fitur tambah pengguna akan segera hadir!');
    }

    function viewUser(id) {
      alert(`Melihat detail pengguna ID: ${id}`);
    }

    function editUser(id) {
      alert(`Edit pengguna ID: ${id}`);
    }

    function deleteUser(id) {
      if (confirm('Apakah Anda yakin ingin menghapus pengguna ini?')) {
        alert(`Pengguna ID: ${id} telah dihapus`);
      }
    }

    // Add smooth scrolling and loading effects
    document.addEventListener('DOMContentLoaded', function() {
      // Animate cards on load
      const cards = document.querySelectorAll('.stat-card, .table-container');
      cards.forEach((card, index) => {
        setTimeout(() => {
          card.style.opacity = '0';
          card.style.transform = 'translateY(20px)';
          card.style.transition = 'all 0.6s ease';
          
          setTimeout(() => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
          }, 100);
        }, index * 150);
      });
    });
  </script>
</body>
</html>