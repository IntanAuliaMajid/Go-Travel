<?php
session_start();
require_once 'koneksi.php';

// --- Validasi Awal ---
if (!isset($_GET['role']) || !isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Permintaan tidak valid.");
}
$role = $_GET['role'];
$id = (int)$_GET['id'];
$user_data = null;
$error_message = '';

// --- Tentukan Tabel & Kolom ---
$table_name = ($role === 'admin') ? 'admin' : 'pengunjung';
$id_column = ($role === 'admin') ? 'id_admin' : 'id_pengunjung';

// --- PROSES UPDATE (POST REQUEST) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        if ($role === 'admin') {
            $nama_lengkap = $_POST['nama_lengkap'];
            $sql = "UPDATE admin SET nama_lengkap=?, email=?, username=?" . (!empty($password) ? ", password=?" : "") . " WHERE id_admin=?";
            $stmt = $conn->prepare($sql);
            if (!empty($password)) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt->bind_param("ssssi", $nama_lengkap, $email, $username, $hashed_password, $id);
            } else {
                $stmt->bind_param("sssi", $nama_lengkap, $email, $username, $id);
            }
        } else {
            $nama_depan = $_POST['nama_depan'];
            $nama_belakang = $_POST['nama_belakang'];
            $sql = "UPDATE pengunjung SET nama_depan=?, nama_belakang=?, email=?, username=?" . (!empty($password) ? ", password=?" : "") . " WHERE id_pengunjung=?";
            $stmt = $conn->prepare($sql);
            if (!empty($password)) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt->bind_param("sssssi", $nama_depan, $nama_belakang, $email, $username, $hashed_password, $id);
            } else {
                $stmt->bind_param("ssssi", $nama_depan, $nama_belakang, $email, $username, $id);
            }
        }

        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Data pengguna berhasil diperbarui.";
            header("Location: ../newadmin/pengguna.php");
            exit();
        }
        $stmt->close();
    } catch (Exception $e) {
        $error_message = "Terjadi kesalahan: " . $e->getMessage();
    }
}

// --- AMBIL DATA UNTUK FORM (GET REQUEST) ---
$stmt = $conn->prepare("SELECT * FROM $table_name WHERE $id_column = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $user_data = $result->fetch_assoc();
} else {
    die("Pengguna tidak ditemukan.");
}
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><title>Edit Pengguna</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f6f9; color: #333; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
        .form-container { background: #fff; padding: 30px 40px; border-radius: 8px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); width: 100%; max-width: 500px; }
        h1 { text-align: center; color: #2c3e50; margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: 600; color: #555; }
        .form-group input { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; }
        .form-group input:focus { outline: none; border-color: #3498db; }
        .form-actions { display: flex; justify-content: space-between; margin-top: 20px; }
        .btn { padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-weight: 500; }
        .btn-submit { background-color: #2ecc71; color: white; }
        .btn-cancel { background-color: #e0e0e0; color: #333; text-decoration: none; }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Edit <?php echo ucfirst($role); ?></h1>
        <?php if($error_message): ?><p style="color: red; text-align: center;"><?php echo $error_message; ?></p><?php endif; ?>
        <form method="POST" action="">
            <?php if ($role === 'admin'): ?>
                <div class="form-group"><label>Nama Lengkap</label><input type="text" name="nama_lengkap" value="<?php echo htmlspecialchars($user_data['nama_lengkap']); ?>" required></div>
            <?php else: ?>
                <div class="form-group"><label>Nama Depan</label><input type="text" name="nama_depan" value="<?php echo htmlspecialchars($user_data['nama_depan']); ?>" required></div>
                <div class="form-group"><label>Nama Belakang</label><input type="text" name="nama_belakang" value="<?php echo htmlspecialchars($user_data['nama_belakang']); ?>"></div>
            <?php endif; ?>
            <div class="form-group"><label>Email</label><input type="email" name="email" value="<?php echo htmlspecialchars($user_data['email']); ?>" required></div>
            <div class="form-group"><label>Username</label><input type="text" name="username" value="<?php echo htmlspecialchars($user_data['username']); ?>" required></div>
            <div class="form-group"><label>Password Baru (Opsional)</label><input type="password" name="password" placeholder="Kosongkan jika tidak diubah"></div>
            <div class="form-actions"><a href="../newadmin/pengguna.php" class="btn btn-cancel">Batal</a><button type="submit" class="btn btn-submit">Simpan Perubahan</button></div>
        </form>
    </div>
</body>
</html>