
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management - Admin Panel</title>
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
                    <h1>User Management</h1>
                    <p>Kelola semua pengguna dalam sistem</p>
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
            <!-- User Stats Cards -->
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
                    <div class="stat-icon new-users" style="background: linear-gradient(135deg, #00c6fb 0%, #005bea 100%);">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <div class="stat-content">
                        <h3>78</h3>
                        <p>New Users</p>
                        <span class="stat-change positive">
                            <i class="fas fa-arrow-up"></i> +5% dari bulan lalu
                        </span>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon active-users" style="background: linear-gradient(135deg, #0ba360 0%, #3cba92 100%);">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <div class="stat-content">
                        <h3>967</h3>
                        <p>Active Users</p>
                        <span class="stat-change positive">
                            <i class="fas fa-arrow-up"></i> +8% dari bulan lalu
                        </span>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon inactive-users" style="background: linear-gradient(135deg, #ff9a9e 0%, #fad0c4 100%);">
                        <i class="fas fa-user-clock"></i>
                    </div>
                    <div class="stat-content">
                        <h3>278</h3>
                        <p>Inactive Users</p>
                        <span class="stat-change negative">
                            <i class="fas fa-arrow-down"></i> -3% dari bulan lalu
                        </span>
                    </div>
                </div>
            </div>

            <!-- User Management Section -->
            <div class="card user-management-card">
                <div class="card-header">
                    <h3>Daftar Pengguna</h3>
                    <div class="card-actions">
                        <div class="search-container">
                            <input type="text" class="search-input" placeholder="Cari pengguna...">
                            <i class="fas fa-search search-icon"></i>
                        </div>
                        <button class="btn-add-user">
                            <i class="fas fa-plus"></i> Tambah Pengguna
                        </button>
                    </div>
                </div>
                <div class="card-content">
                    <div class="table-responsive">
                        <table class="user-table">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" class="select-all-checkbox">
                                    </th>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Tanggal Registrasi</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="checkbox" class="user-checkbox"></td>
                                    <td>#001</td>
                                    <td>
                                        <div class="user-info">
                                            <img src="/api/placeholder/40/40" alt="User" class="user-avatar">
                                            <span>Ahmad Fadillah</span>
                                        </div>
                                    </td>
                                    <td>ahmad@example.com</td>
                                    <td><span class="badge admin">Admin</span></td>
                                    <td><span class="badge active">Active</span></td>
                                    <td>21 Apr 2024</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-edit" title="Edit User"><i class="fas fa-edit"></i></button>
                                            <button class="btn-delete" title="Delete User"><i class="fas fa-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" class="user-checkbox"></td>
                                    <td>#002</td>
                                    <td>
                                        <div class="user-info">
                                            <img src="/api/placeholder/40/40" alt="User" class="user-avatar">
                                            <span>Siti Nurhaliza</span>
                                        </div>
                                    </td>
                                    <td>siti@example.com</td>
                                    <td><span class="badge customer">Customer</span></td>
                                    <td><span class="badge active">Active</span></td>
                                    <td>18 Apr 2024</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-edit" title="Edit User"><i class="fas fa-edit"></i></button>
                                            <button class="btn-delete" title="Delete User"><i class="fas fa-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" class="user-checkbox"></td>
                                    <td>#003</td>
                                    <td>
                                        <div class="user-info">
                                            <img src="/api/placeholder/40/40" alt="User" class="user-avatar">
                                            <span>Budi Santoso</span>
                                        </div>
                                    </td>
                                    <td>budi@example.com</td>
                                    <td><span class="badge customer">Customer</span></td>
                                    <td><span class="badge inactive">Inactive</span></td>
                                    <td>12 Apr 2024</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-edit" title="Edit User"><i class="fas fa-edit"></i></button>
                                            <button class="btn-delete" title="Delete User"><i class="fas fa-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" class="user-checkbox"></td>
                                    <td>#004</td>
                                    <td>
                                        <div class="user-info">
                                            <img src="/api/placeholder/40/40" alt="User" class="user-avatar">
                                            <span>Dewi Lestari</span>
                                        </div>
                                    </td>
                                    <td>dewi@example.com</td>
                                    <td><span class="badge guide">Guide</span></td>
                                    <td><span class="badge active">Active</span></td>
                                    <td>10 Apr 2024</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-edit" title="Edit User"><i class="fas fa-edit"></i></button>
                                            <button class="btn-delete" title="Delete User"><i class="fas fa-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" class="user-checkbox"></td>
                                    <td>#005</td>
                                    <td>
                                        <div class="user-info">
                                            <img src="/api/placeholder/40/40" alt="User" class="user-avatar">
                                            <span>Rudi Hermawan</span>
                                        </div>
                                    </td>
                                    <td>rudi@example.com</td>
                                    <td><span class="badge customer">Customer</span></td>
                                    <td><span class="badge pending">Pending</span></td>
                                    <td>8 Apr 2024</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-edit" title="Edit User"><i class="fas fa-edit"></i></button>
                                            <button class="btn-delete" title="Delete User"><i class="fas fa-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" class="user-checkbox"></td>
                                    <td>#006</td>
                                    <td>
                                        <div class="user-info">
                                            <img src="/api/placeholder/40/40" alt="User" class="user-avatar">
                                            <span>Rina Wati</span>
                                        </div>
                                    </td>
                                    <td>rina@example.com</td>
                                    <td><span class="badge manager">Manager</span></td>
                                    <td><span class="badge active">Active</span></td>
                                    <td>5 Apr 2024</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-edit" title="Edit User"><i class="fas fa-edit"></i></button>
                                            <button class="btn-delete" title="Delete User"><i class="fas fa-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" class="user-checkbox"></td>
                                    <td>#007</td>
                                    <td>
                                        <div class="user-info">
                                            <img src="/api/placeholder/40/40" alt="User" class="user-avatar">
                                            <span>Doni Kusuma</span>
                                        </div>
                                    </td>
                                    <td>doni@example.com</td>
                                    <td><span class="badge customer">Customer</span></td>
                                    <td><span class="badge blocked">Blocked</span></td>
                                    <td>1 Apr 2024</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-edit" title="Edit User"><i class="fas fa-edit"></i></button>
                                            <button class="btn-delete" title="Delete User"><i class="fas fa-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="pagination-container">
                        <div class="pagination-info">
                            Showing <span>1-7</span> of <span>1,245</span> users
                        </div>
                        <div class="pagination">
                            <button class="page-btn disabled"><i class="fas fa-chevron-left"></i></button>
                            <button class="page-btn active">1</button>
                            <button class="page-btn">2</button>
                            <button class="page-btn">3</button>
                            <span class="page-ellipsis">...</span>
                            <button class="page-btn">178</button>
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

            <!-- User Activity and Growth Chart -->
            <div class="dashboard-row">
                <!-- User Registration Chart -->
                <div class="chart-section">
                    <div class="card">
                        <div class="card-header">
                            <h3>Statistik Registrasi Pengguna</h3>
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
                                <canvas id="userRegistrationChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User Distribution by Role -->
                <div class="chart-section">
                    <div class="card">
                        <div class="card-header">
                            <h3>Distribusi Peran Pengguna</h3>
                        </div>
                        <div class="card-content">
                            <div class="chart-container">
                                <canvas id="userRoleChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Registrations and User Activities -->
            <div class="dashboard-row">
                <!-- Recent Registrations -->
                <div class="recent-registrations">
                    <div class="card">
                        <div class="card-header">
                            <h3>Registrasi Terbaru</h3>
                            <a href="#" class="view-all">Lihat Semua</a>
                        </div>
                        <div class="card-content">
                            <div class="registration-list">
                                <div class="registration-item">
                                    <div class="registration-user">
                                        <img src="/api/placeholder/45/45" alt="User" class="user-avatar">
                                        <div class="user-details">
                                            <h4>Putri Anggraini</h4>
                                            <p>putri@example.com</p>
                                        </div>
                                    </div>
                                    <div class="registration-info">
                                        <span class="badge customer">Customer</span>
                                        <span class="registration-time">5 menit yang lalu</span>
                                    </div>
                                </div>
                                <div class="registration-item">
                                    <div class="registration-user">
                                        <img src="/api/placeholder/45/45" alt="User" class="user-avatar">
                                        <div class="user-details">
                                            <h4>Tono Sucipto</h4>
                                            <p>tono@example.com</p>
                                        </div>
                                    </div>
                                    <div class="registration-info">
                                        <span class="badge customer">Customer</span>
                                        <span class="registration-time">30 menit yang lalu</span>
                                    </div>
                                </div>
                                <div class="registration-item">
                                    <div class="registration-user">
                                        <img src="/api/placeholder/45/45" alt="User" class="user-avatar">
                                        <div class="user-details">
                                            <h4>Lina Marlina</h4>
                                            <p>lina@example.com</p>
                                        </div>
                                    </div>
                                    <div class="registration-info">
                                        <span class="badge guide">Guide</span>
                                        <span class="registration-time">2 jam yang lalu</span>
                                    </div>
                                </div>
                                <div class="registration-item">
                                    <div class="registration-user">
                                        <img src="/api/placeholder/45/45" alt="User" class="user-avatar">
                                        <div class="user-details">
                                            <h4>Agus Hartono</h4>
                                            <p>agus@example.com</p>
                                        </div>
                                    </div>
                                    <div class="registration-info">
                                        <span class="badge customer">Customer</span>
                                        <span class="registration-time">5 jam yang lalu</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User Activities -->
                <div class="user-activities">
                    <div class="card">
                        <div class="card-header">
                            <h3>Aktivitas Pengguna</h3>
                            <a href="#" class="view-all">Lihat Semua</a>
                        </div>
                        <div class="card-content">
                            <div class="activity-list">
                                <div class="activity-item">
                                    <div class="activity-icon login" style="background: #3b82f6;">
                                        <i class="fas fa-sign-in-alt"></i>
                                    </div>
                                    <div class="activity-content">
                                        <p><strong>Rina Wati</strong> melakukan login</p>
                                        <span class="activity-time">10 menit yang lalu</span>
                                    </div>
                                </div>
                                <div class="activity-item">
                                    <div class="activity-icon profile" style="background: #8b5cf6;">
                                        <i class="fas fa-user-edit"></i>
                                    </div>
                                    <div class="activity-content">
                                        <p><strong>Ahmad Fadillah</strong> memperbarui profil</p>
                                        <span class="activity-time">45 menit yang lalu</span>
                                    </div>
                                </div>
                                <div class="activity-item">
                                    <div class="activity-icon password" style="background: #f59e0b;">
                                        <i class="fas fa-key"></i>
                                    </div>
                                    <div class="activity-content">
                                        <p><strong>Siti Nurhaliza</strong> mengganti password</p>
                                        <span class="activity-time">1 jam yang lalu</span>
                                    </div>
                                </div>
                                <div class="activity-item">
                                    <div class="activity-icon booking" style="background: #10b981;">
                                        <i class="fas fa-calendar-check"></i>
                                    </div>
                                    <div class="activity-content">
                                        <p><strong>Budi Santoso</strong> membuat booking baru</p>
                                        <span class="activity-time">3 jam yang lalu</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add User Modal -->
    <div class="modal" id="addUserModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Tambah Pengguna Baru</h3>
                <button class="close-modal"><i class="fas fa-times"></i></button>
            </div>
            <div class="modal-body">
                <form id="addUserForm">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="firstName">Nama Depan</label>
                            <input type="text" id="firstName" name="firstName" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="lastName">Nama Belakang</label>
                            <input type="text" id="lastName" name="lastName" class="form-control" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="phone">Nomor Telepon</label>
                            <input type="tel" id="phone" name="phone" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select id="role" name="role" class="form-control" required>
                                <option value="">Pilih Role</option>
                                <option value="admin">Admin</option>
                                <option value="manager">Manager</option>
                                <option value="guide">Guide</option>
                                <option value="customer">Customer</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="confirmPassword">Konfirmasi Password</label>
                            <input type="password" id="confirmPassword" name="confirmPassword" class="form-control" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Status</label>
                        <div class="radio-group">
                            <label class="radio-label">
                                <input type="radio" name="status" value="active" checked> Active
                            </label>
                            <label class="radio-label">
                                <input type="radio" name="status" value="inactive"> Inactive
                            </label>
                            <label class="radio-label">
                                <input type="radio" name="status" value="pending"> Pending
                            </label>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="button" class="btn-cancel">Batal</button>
                        <button type="submit" class="btn-submit">Simpan</button>
                    </div>
                </form>
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

        // User Registration Chart
        const registrationCtx = document.getElementById('userRegistrationChart').getContext('2d');
        const userRegistrationChart = new Chart(registrationCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'New Users',
                    data: [42, 55, 63, 89, 76, 56, 65, 74, 83, 95, 110, 78],
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

        // User Role Chart
        const roleCtx = document.getElementById('userRoleChart').getContext('2d');
        const userRoleChart = new Chart(roleCtx, {
            type: 'doughnut',
            data: {
                labels: ['Customer', 'Admin', 'Guide', 'Manager'],
                datasets: [{
                    data: [1050, 15, 95, 85],
                    backgroundColor: [
                        '#4A90E2',
                        '#FF6384',
                        '#36A2EB',
                        '#FFCE56'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                },
                cutout: '65%'
            }
        });

        // Modal functionality
        document.addEventListener('DOMContentLoaded', function() {
            const addUserBtn = document.querySelector('.btn-add-user');
            const modal = document.getElementById('addUserModal');
            const closeModal = document.querySelector('.close-modal');
            const cancelBtn = document.querySelector('.btn-cancel');

            function openModal() {
                modal.classList.add('show');
            }

            function closeModalFunc() {
                modal.classList.remove('show');
            }

            if (addUserBtn) addUserBtn.addEventListener('click', openModal);
            if (closeModal) closeModal.addEventListener('click', closeModalFunc);
            if (cancelBtn) cancelBtn.addEventListener('click', closeModalFunc);

            // Close modal when clicking outside
            window.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeModalFunc();
                }
            });

            // Handle form submission (just for demonstration)
            const addUserForm = document.getElementById('addUserForm');
            if (addUserForm) {
                addUserForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    alert('User would be added here in a real application');
                    closeModalFunc();
                });
            }

            // Select all checkbox functionality
            const selectAll = document.querySelector('.select-all-checkbox');
            const userCheckboxes = document.querySelectorAll('.user-checkbox');
            
            if (selectAll) {
                selectAll.addEventListener('change', function() {
                    userCheckboxes.forEach(checkbox => {
                        checkbox.checked = selectAll.checked;
                    });
                });
            }
        });
    </script>

    <style>
       /* Main Content Styles */
        .main-content {
            margin-left: 280px;
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        /* Dashboard Header */
        .dashboard-header {
            padding: 20px 30px;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-left h1 {
            font-size: 24px;
            font-weight: 700;
            color: #333;
            margin-bottom: 5px;
        }

        .header-left p {
            font-size: 14px;
            color: #666;
            margin: 0;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 25px;
        }

        .date-time {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #666;
            font-size: 14px;
        }

        .date-time i {
            color: #4A90E2;
        }

        .admin-profile {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .profile-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #e0e7ff;
        }

        /* Dashboard Container */
        .dashboard-container {
            padding: 30px;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            color: white;
            font-size: 24px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .stat-content h3 {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 5px;
            color: #333;
        }

        .stat-content p {
            font-size: 14px;
            color: #666;
            margin-bottom: 5px;
        }

        .stat-change {
            font-size: 12px;
            display: flex;
            align-items: center;
            gap: 3px;
        }

        .stat-change.positive {
            color: #10B981;
        }

        .stat-change.negative {
            color: #EF4444;
        }

        /* Card Styles */
        .card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }

        .card-header {
            padding: 20px 25px;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-header h3 {
            font-size: 18px;
            font-weight: 600;
            color: #333;
        }

        .card-actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .search-container {
            position: relative;
        }

        .search-input {
            padding: 8px 15px 8px 35px;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            font-size: 14px;
            width: 200px;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            outline: none;
            border-color: #4A90E2;
            box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            font-size: 14px;
        }

        .btn-add-user {
            background-color: #4A90E2;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-add-user:hover {
            background-color: #3a7bc8;
        }

        /* Table Styles */
        .table-responsive {
            overflow-x: auto;
        }

        .user-table {
            width: 100%;
            border-collapse: collapse;
        }

        .user-table th, .user-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #f0f0f0;
        }

        .user-table th {
            font-size: 13px;
            font-weight: 600;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            background-color: #f9fafb;
        }

        .user-table td {
            font-size: 14px;
            color: #555;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        /* Badge Styles */
        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .badge.admin {
            background-color: #EFF6FF;
            color: #3B82F6;
        }

        .badge.customer {
            background-color: #ECFDF5;
            color: #10B981;
        }

        .badge.guide {
            background-color: #F5F3FF;
            color: #8B5CF6;
        }

        .badge.manager {
            background-color: #FEF2F2;
            color: #EF4444;
        }

        .badge.active {
            background-color: #ECFDF5;
            color: #10B981;
        }

        .badge.inactive {
            background-color: #FEF2F2;
            color: #EF4444;
        }

        .badge.pending {
            background-color: #FEF3C7;
            color: #D97706;
        }

        .badge.blocked {
            background-color: #F3F4F6;
            color: #6B7280;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .btn-edit, .btn-delete {
            width: 30px;
            height: 30px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-edit {
            background-color: #EFF6FF;
            color: #3B82F6;
        }

        .btn-edit:hover {
            background-color: #DBEAFE;
        }

        .btn-delete {
            background-color: #FEF2F2;
            color: #EF4444;
        }

        .btn-delete:hover {
            background-color: #FEE2E2;
        }

        /* Pagination */
        .pagination-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            border-top: 1px solid #f0f0f0;
        }

        .pagination-info {
            font-size: 14px;
            color: #666;
        }

        .pagination-info span {
            font-weight: 600;
            color: #333;
        }

        .pagination {
            display: flex;
            gap: 5px;
        }

        .page-btn {
            width: 35px;
            height: 35px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #e0e0e0;
            background-color: white;
            color: #666;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .page-btn:hover {
            border-color: #4A90E2;
            color: #4A90E2;
        }

        .page-btn.active {
            background-color: #4A90E2;
            border-color: #4A90E2;
            color: white;
        }

        .page-btn.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .page-ellipsis {
            display: flex;
            align-items: center;
            padding: 0 10px;
            color: #999;
        }

        .per-page-selector {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .per-page-selector label {
            font-size: 14px;
            color: #666;
        }

        .per-page {
            padding: 6px 10px;
            border-radius: 6px;
            border: 1px solid #e0e0e0;
            font-size: 14px;
        }

        /* Dashboard Grid Layout */
        .dashboard-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        /* Chart Containers */
        .chart-container {
            height: 300px;
            padding: 15px;
        }

        /* Recent Registrations */
        .registration-list {
            padding: 0;
        }

        .registration-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            border-bottom: 1px solid #f0f0f0;
        }

        .registration-user {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-details h4 {
            font-size: 15px;
            font-weight: 600;
            color: #333;
            margin-bottom: 3px;
        }

        .user-details p {
            font-size: 13px;
            color: #999;
            margin: 0;
        }

        .registration-info {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 5px;
        }

        .registration-time {
            font-size: 12px;
            color: #999;
        }

        .view-all {
            font-size: 14px;
            color: #4A90E2;
            text-decoration: none;
            font-weight: 500;
        }

        .view-all:hover {
            text-decoration: underline;
        }

        /* Activity List */
        .activity-list {
            padding: 0;
        }

        .activity-item {
            display: flex;
            gap: 15px;
            padding: 15px 20px;
            border-bottom: 1px solid #f0e0f0;
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 16px;
        }

        .activity-content {
            flex: 1;
        }

        .activity-content p {
            font-size: 14px;
            color: #555;
            margin-bottom: 5px;
        }

        .activity-time {
            font-size: 12px;
            color: #999;
        }

        /* Modal Styles */
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .modal.show {
            opacity: 1;
            visibility: visible;
        }

        .modal-content {
            background-color: white;
            border-radius: 10px;
            width: 100%;
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transform: translateY(-20px);
            transition: all 0.3s ease;
        }

        .modal.show .modal-content {
            transform: translateY(0);
        }

        .modal-header {
            padding: 20px 25px;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h3 {
            font-size: 18px;
            font-weight: 600;
            color: #333;
        }

        .close-modal {
            background: none;
            border: none;
            font-size: 20px;
            color: #999;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .close-modal:hover {
            color: #666;
        }

        .modal-body {
            padding: 25px;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 20px;
        }

        .form-row {
            display: flex;
            gap: 20px;
        }

        .form-row .form-group {
            flex: 1;
        }

        .form-control {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: #4A90E2;
            box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 500;
            color: #555;
        }

        .radio-group {
            display: flex;
            gap: 20px;
            margin-top: 10px;
        }

        .radio-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            color: #666;
            cursor: pointer;
        }

        .radio-label input {
            margin: 0;
        }

        /* Form Actions */
        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #f0f0f0;
        }

        .btn-cancel {
            padding: 10px 20px;
            background-color: #f0f0f0;
            color: #666;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-cancel:hover {
            background-color: #e0e0e0;
        }

        .btn-submit {
            padding: 10px 20px;
            background-color: #4A90E2;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-submit:hover {
            background-color: #3a7bc8;
        }

        /* Responsive Styles */
        @media (max-width: 1200px) {
            .main-content {
                margin-left: 0;
            }
            
            .admin-sidebar {
                transform: translateX(-100%);
            }
        }

        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            
            .header-right {
                width: 100%;
                justify-content: space-between;
            }
            
            .dashboard-row {
                grid-template-columns: 1fr;
            }
            
            .form-row {
                flex-direction: column;
                gap: 0;
            }
        }

        @media (max-width: 576px) {
            .dashboard-container {
                padding: 15px;
            }
            
            .card-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            
            .card-actions {
                width: 100%;
                flex-direction: column;
                gap: 10px;
            }
            
            .search-container {
                width: 100%;
            }
            
            .search-input {
                width: 100%;
            }
            
            .btn-add-user {
                width: 100%;
                justify-content: center;
            }
            
            .pagination-container {
                flex-direction: column;
                gap: 15px;
            }
            
            .modal-content {
                margin: 15px;
                width: calc(100% - 30px);
            }
        }
    </style>
</body>
</html>