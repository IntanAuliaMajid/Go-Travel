<?php
session_start(); // HARUS ADA DI BARIS PALING ATAS
require_once '../backend/koneksi.php'; // Sesuaikan path jika perlu

// Helper function to get initials from a name
function get_initials_user($nama_depan, $nama_belakang) {
    $initials = '';
    if (!empty($nama_depan)) {
        $initials .= strtoupper(substr($nama_depan, 0, 1));
    }
    if (!empty($nama_belakang)) {
        $initials .= strtoupper(substr($nama_belakang, 0, 1));
    } elseif (empty($nama_belakang) && !empty($nama_depan) && strlen($nama_depan) > 1) {
        $initials = strtoupper(substr($nama_depan, 0, 2));
    }
    return $initials ?: 'NN'; // Return initials or 'NN' if both are empty
}

// --- Fetch Stats ---
$total_pengguna = 0;
$total_admin = 0;
$total_pengunjung_biasa = 0;

if ($conn) {
    $result_total_pengunjung = $conn->query("SELECT COUNT(*) as count FROM pengunjung");
    if ($result_total_pengunjung) {
        $total_pengunjung_biasa = $result_total_pengunjung->fetch_assoc()['count'];
    }
    $result_total_admin = $conn->query("SELECT COUNT(*) as count FROM admin");
    if ($result_total_admin) {
        $total_admin = $result_total_admin->fetch_assoc()['count'];
    }
    $total_pengguna = $total_pengunjung_biasa + $total_admin;
}

// --- Fetch Users ---
$search_term = isset($_GET['search']) ? trim($_GET['search']) : '';
$all_users = [];

$where_clause_pengunjung = "";
$where_clause_admin = "";
$params_pengunjung = [];
$types_pengunjung = "";
$params_admin = [];
$types_admin = "";

// =================================================================================
// PERBAIKAN 1: Memperbarui query SQL untuk mengambil 'last_login' dari kedua tabel
// =================================================================================
$sql_pengunjung = "SELECT id_pengunjung, nama_depan, nama_belakang, username, email, avatar, 'pengunjung' AS role_type, last_login FROM pengunjung";
$sql_admin = "SELECT id_admin AS id_pengunjung, nama_lengkap AS nama_depan, '' AS nama_belakang, username, email, NULL AS avatar, 'admin' AS role_type, last_login FROM admin";

if (!empty($search_term)) {
    $like_term = "%" . $search_term . "%";
    $where_clause_pengunjung = " WHERE CONCAT(nama_depan, ' ', nama_belakang) LIKE ? OR email LIKE ? OR username LIKE ?";
    $params_pengunjung = [$like_term, $like_term, $like_term];
    $types_pengunjung = "sss";
    $where_clause_admin = " WHERE nama_lengkap LIKE ? OR email LIKE ? OR username LIKE ?";
    $params_admin = [$like_term, $like_term, $like_term];
    $types_admin = "sss";
}

$final_sql = "($sql_pengunjung $where_clause_pengunjung) UNION ALL ($sql_admin $where_clause_admin) ORDER BY id_pengunjung DESC";

$stmt_final = null;
if ($conn) {
    $stmt_final = $conn->prepare($final_sql);
    if ($stmt_final) {
        if (!empty($search_term)) {
            // Jika ada pencarian, gabungkan parameter dan tipe
            $all_params = array_merge($params_pengunjung, $params_admin);
            $all_types = $types_pengunjung . $types_admin;
            $stmt_final->bind_param($all_types, ...$all_params);
        }

        if ($stmt_final->execute()) {
            $result_all_users = $stmt_final->get_result();
            while ($row = $result_all_users->fetch_assoc()) {
                if ($row['role_type'] === 'admin' && empty($row['nama_belakang'])) {
                    $row['nama_lengkap_display'] = $row['nama_depan'];
                } else {
                    $row['nama_lengkap_display'] = trim($row['nama_depan'] . ' ' . $row['nama_belakang']);
                }
                $all_users[] = $row;
            }
        }
        $stmt_final->close();
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Admin - Manajemen Pengguna</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f6f9; color: #333; line-height: 1.6; }
    .main-content { margin-left: 240px; padding: 20px; }
    .dashboard-header { background: #ffffff; border-radius: 8px; padding: 20px; margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
    .header-top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; }
    .header-top h1 { color: #2c3e50; font-size: 1.8rem; font-weight: 600; }
    .add-user-btn { background-color: #3498db; color: white; border: none; padding: 10px 18px; border-radius: 6px; cursor: pointer; font-weight: 500; font-size: 0.9rem; transition: background-color 0.2s ease; display: flex; align-items: center; gap: 8px; text-decoration: none; }
    .add-user-btn:hover { background-color: #2980b9; }
    .search-container { position: relative; max-width: 350px; }
    .search-input { width: 100%; padding: 10px 15px 10px 40px; border: 1px solid #ddd; border-radius: 6px; font-size: 0.9rem; transition: border-color 0.2s ease; }
    .search-input:focus { outline: none; border-color: #3498db; }
    .search-icon { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #7f8c8d; font-size: 1rem; }
    .stats-container { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 20px; }
    .stat-card { background: #ffffff; border-radius: 8px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
    .stat-card h3 { color: #555; font-size: 0.85rem; margin-bottom: 8px; text-transform: uppercase; font-weight: 500; }
    .stat-card .number { font-size: 2rem; font-weight: 600; color: #2c3e50; margin-bottom: 5px; }
    .table-container { background: #ffffff; border-radius: 8px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow: hidden; }
    .table-wrapper { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; }
    th { background-color: #f8f9fa; padding: 12px 15px; text-align: left; font-weight: 600; color: #495057; font-size: 0.85rem; text-transform: uppercase; border-bottom: 2px solid #dee2e6; }
    td { padding: 12px 15px; border-bottom: 1px solid #ecf0f1; vertical-align: middle; font-size: 0.9rem; }
    tr:hover { background-color: #f1f7ff; }
    .user-info { display: flex; align-items: center; gap: 10px; }
    .user-avatar { width: 40px; height: 40px; border-radius: 50%; background-color: #3498db; display: flex; align-items: center; justify-content: center; color: white; font-weight: 500; font-size: 1rem; overflow: hidden; }
    .user-avatar img { width: 100%; height: 100%; object-fit: cover; }
    .user-details h4 { color: #2c3e50; font-weight: 500; margin-bottom: 0; font-size: 0.95rem;}
    .user-details span { color: #777; font-size: 0.8rem; }
    .role-badge { padding: 5px 10px; border-radius: 15px; font-size: 0.75rem; font-weight: 500; text-transform: uppercase; color: white; }
    .role-admin { background-color: #e74c3c; }
    .role-pengunjung { background-color: #27ae60; }
    .status-text { font-weight: 500; font-size: 0.85rem; }
    .status-online { color: #27ae60; }
    .action-buttons { display: flex; gap: 6px; }
    .btn { padding: 7px 10px; border: none; border-radius: 5px; cursor: pointer; font-size: 0.8rem; transition: opacity 0.2s ease; display: flex; align-items: center; gap: 5px; }
    .btn i { font-size: 0.9em; }
    .btn-view { background-color: #3498db; color: white; }
    .btn-edit { background-color: #f39c12; color: white; }
    .btn-delete { background-color: #e74c3c; color: white; }
    .btn:hover { opacity: 0.85; }
    .alert { padding: 15px; margin-bottom: 20px; border: 1px solid transparent; border-radius: 6px; font-weight: 500; }
    .alert-success { color: #155724; background-color: #d4edda; border-color: #c3e6cb; }
    .alert-danger { color: #721c24; background-color: #f8d7da; border-color: #f5c6cb; }
    @media (max-width: 768px) {
        .main-content { margin-left: 0; padding: 15px; }
        .header-top { flex-direction: column; gap: 15px; align-items: stretch; }
        .stats-container { grid-template-columns: 1fr; }
        .action-buttons { flex-wrap: wrap; }
    }
  </style>
</head>
<body>
  <?php include '../komponen/sidebar_admin.php'; ?>

  <main class="main-content">
    <?php
        if (isset($_SESSION['success_message']) && !empty($_SESSION['success_message'])) {
            echo '<div class="alert alert-success">' . htmlspecialchars($_SESSION['success_message']) . '</div>';
            unset($_SESSION['success_message']);
        }
        if (isset($_SESSION['error_message']) && !empty($_SESSION['error_message'])) {
            echo '<div class="alert alert-danger">' . htmlspecialchars($_SESSION['error_message']) . '</div>';
            unset($_SESSION['error_message']);
        }
    ?>
    
    <div class="dashboard-header">
      <div class="header-top">
        <div>
          <h1>Manajemen Pengguna</h1>
          <p style="color: #6c757d; margin-top: 5px;">Kelola semua pengguna sistem dengan mudah</p>
        </div>
        <a href="tambah_pengguna.php" class="add-user-btn">
          <i class="fas fa-plus"></i> Tambah Pengguna
        </a>
      </div>
      <form method="GET" action="">
        <div class="search-container">
          <i class="fas fa-search search-icon"></i>
          <input type="text" name="search" class="search-input" placeholder="Cari berdasarkan nama atau email..." value="<?php echo htmlspecialchars($search_term); ?>" id="searchInput">
        </div>
      </form>
    </div>

    <div class="stats-container">
        <div class="stat-card"><h3>Total Pengguna</h3><div class="number"><?php echo $total_pengguna; ?></div></div>
        <div class="stat-card"><h3>Total Admin</h3><div class="number"><?php echo $total_admin; ?></div></div>
        <div class="stat-card"><h3>Pengunjung Terdaftar</h3><div class="number"><?php echo $total_pengunjung_biasa; ?></div></div>
    </div>

    <div class="table-container">
      <div class="table-wrapper">
        <table>
          <thead>
            <tr><th>Pengguna</th><th>Role</th><th>Status Akun</th><th>Terakhir Login</th><th>Aksi</th></tr>
          </thead>
          <tbody>
            <?php if (!empty($all_users)): ?>
              <?php foreach($all_users as $user):
                $user_full_name = htmlspecialchars($user['nama_lengkap_display']);
                $user_email = htmlspecialchars($user['email']);
                $user_id_for_action = $user['id_pengunjung'];
                $role_badge_class = ($user['role_type'] === 'admin') ? 'role-admin' : 'role-pengunjung';
                $role_display_name = ($user['role_type'] === 'admin') ? 'Admin' : 'Pengguna';
                
                // ==============================================================================
                // PERBAIKAN 2: Memperbarui logika tampilan agar bisa menampilkan 'last_login'
                // untuk admin dan pengunjung
                // ==============================================================================
                $last_login_display = !empty($user['last_login']) ? date('d M Y, H:i', strtotime($user['last_login'])) : 'N/A';
              ?>
              <tr>
                <td>
                  <div class="user-info"> 
                    <div class="user-avatar">
                        <?php
                            $avatar_path = '../uploads/avatars/' . basename($user['avatar']); // Keamanan: gunakan basename
                            if ($user['role_type'] === 'pengunjung' && !empty($user['avatar']) && file_exists($avatar_path)) {
                                echo '<img src="' . htmlspecialchars($avatar_path) . '" alt="Avatar">';
                            } else {
                                echo get_initials_user(htmlspecialchars($user['nama_depan']), htmlspecialchars($user['nama_belakang']));
                            }
                        ?>
                    </div>
                    <div class="user-details">
                      <h4><?php echo $user_full_name; ?></h4>
                      <span><?php echo $user_email; ?></span>
                    </div>
                  </div>
                </td>
                <td><span class="role-badge <?php echo $role_badge_class; ?>"><?php echo $role_display_name; ?></span></td>
                <td><span class="status-text status-online"><i class="fas fa-circle" style="font-size: 8px; margin-right: 5px;"></i>Aktif</span></td>
                <td><?php echo $last_login_display; ?></td>
                <td>
                  <div class="action-buttons">
                    <button class="btn btn-view" onclick="viewUser('<?php echo $user['role_type']; ?>', <?php echo $user_id_for_action; ?>)" title="Lihat"><i class="fas fa-eye"></i></button>
                    <button class="btn btn-edit" onclick="editUser('<?php echo $user['role_type']; ?>', <?php echo $user_id_for_action; ?>)" title="Edit"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-delete" onclick="deleteUser('<?php echo $user['role_type']; ?>', <?php echo $user_id_for_action; ?>)" title="Hapus"><i class="fas fa-trash"></i></button>
                  </div>
                </td>
              </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr><td colspan="5" style="text-align: center; padding: 20px;">
                <?php echo empty($search_term) ? 'Tidak ada pengguna.' : 'Tidak ada pengguna ditemukan untuk pencarian "' . htmlspecialchars($search_term) . '".'; ?>
              </td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </main>

  <script>
    document.getElementById('searchInput').addEventListener('keyup', function(e) {
      if (e.key === 'Enter' || this.value.length === 0 || this.value.length > 2) { this.form.submit(); }
    });

    function viewUser(role, id) { window.location.href = `lihat_pengguna.php?role=${role}&id=${id}`; }
    function editUser(role, id) { window.location.href = `edit_pengguna.php?role=${role}&id=${id}`; }
    function deleteUser(role, id) {
        if (confirm(`Apakah Anda yakin ingin menghapus ${role} ini? Data tidak dapat dikembalikan.`)) {
            window.location.href = `hapus_pengguna.php?role=${role}&id=${id}`;
        }
    }
  </script>
</body>
</html>