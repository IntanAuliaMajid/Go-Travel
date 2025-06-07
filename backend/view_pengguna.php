<?php
require_once 'koneksi.php';

// --- Validasi Awal & Ambil Data ---
if (!isset($_GET['role']) || !isset($_GET['id']) || !is_numeric($_GET['id'])) die("Permintaan tidak valid.");
$role = $_GET['role'];
$id = (int)$_GET['id'];
$user_data = null;

$table_name = ($role === 'admin') ? 'admin' : 'pengunjung';
$id_column = ($role === 'admin') ? 'id_admin' : 'id_pengunjung';

$stmt = $conn->prepare("SELECT * FROM $table_name WHERE $id_column = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) $user_data = $result->fetch_assoc();
else die("Pengguna tidak ditemukan.");
$stmt->close();
$conn->close();

function get_initials($nama_depan, $nama_belakang) {
    $initials = ''; if (!empty($nama_depan)) $initials .= strtoupper(substr($nama_depan, 0, 1)); if (!empty($nama_belakang)) $initials .= strtoupper(substr($nama_belakang, 0, 1)); return $initials ?: 'NN';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><title>Detail Pengguna</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f6f9; color: #333; display: flex; justify-content: center; padding-top: 50px; }
        .card { background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); width: 100%; max-width: 450px; }
        .card-header { text-align: center; border-bottom: 1px solid #eee; padding-bottom: 20px; margin-bottom: 20px; }
        .avatar { width: 100px; height: 100px; border-radius: 50%; background-color: #3498db; color: white; display: flex; justify-content: center; align-items: center; font-size: 2.5rem; font-weight: bold; margin: 0 auto 15px auto; }
        .avatar img { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; }
        .card-header h2 { margin: 0; }
        .card-header p { color: #777; }
        .card-body .detail-item { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f0f0f0; }
        .card-body .detail-item:last-child { border-bottom: none; }
        .card-body strong { color: #555; }
        .card-footer { text-align: center; margin-top: 20px; }
        .btn-back { display: inline-block; padding: 10px 25px; background-color: #3498db; color: white; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="card">
        <div class="card-header">
            <div class="avatar">
                <?php if($role === 'pengunjung' && !empty($user_data['avatar']) && file_exists(__DIR__ . '/../uploads/avatars/' . $user_data['avatar'])): ?>
                    <img src="../uploads/avatars/<?php echo htmlspecialchars($user_data['avatar']); ?>" alt="Avatar">
                <?php else: echo get_initials(htmlspecialchars($user_data['nama_depan'] ?? $user_data['nama_lengkap']), htmlspecialchars($user_data['nama_belakang'] ?? '')); endif; ?>
            </div>
            <h2><?php echo htmlspecialchars($user_data['nama_lengkap'] ?? ($user_data['nama_depan'] . ' ' . $user_data['nama_belakang'])); ?></h2>
            <p><?php echo htmlspecialchars($user_data['email']); ?></p>
        </div>
        <div class="card-body">
            <div class="detail-item"><strong>Username:</strong> <span><?php echo htmlspecialchars($user_data['username']); ?></span></div>
            <div class="detail-item"><strong>Peran:</strong> <span><?php echo ucfirst($role); ?></span></div>
            <div class="detail-item"><strong>Status:</strong> <span>Aktif</span></div>
        </div>
        <div class="card-footer">
            <a href="../newadmin/pengguna.php" class="btn-back">Kembali</a>
        </div>
    </div>
</body>
</html>