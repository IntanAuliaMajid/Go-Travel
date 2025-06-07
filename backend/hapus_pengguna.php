<?php
session_start();
require_once 'koneksi.php';

// Validasi input
if (!isset($_GET['role']) || !isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['error_message'] = "Permintaan tidak valid.";
    header("Location: pengguna.php");
    exit();
}

$role = $_GET['role'];
$id = (int)$_GET['id'];

// Tentukan tabel dan kolom ID berdasarkan peran
$table_name = '';
$id_column = '';

if ($role === 'admin') {
    $table_name = 'admin';
    $id_column = 'id_admin';
} elseif ($role === 'pengunjung') {
    $table_name = 'pengunjung';
    $id_column = 'id_pengunjung';
} else {
    $_SESSION['error_message'] = "Peran pengguna tidak dikenali.";
    header("Location: pengguna.php");
    exit();
}

try {
    // Khusus untuk pengunjung, hapus file avatar fisiknya terlebih dahulu
    if ($role === 'pengunjung') {
        $stmt_avatar = $conn->prepare("SELECT avatar FROM pengunjung WHERE id_pengunjung = ?");
        $stmt_avatar->bind_param("i", $id);
        $stmt_avatar->execute();
        $result = $stmt_avatar->get_result();
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (!empty($user['avatar'])) {
                // Asumsi path: [project_root]/uploads/avatars/namafile.jpg
                $avatar_path = __DIR__ . '/../uploads/avatars/' . basename($user['avatar']);
                if (file_exists($avatar_path)) {
                    unlink($avatar_path);
                }
            }
        }
        $stmt_avatar->close();
    }

    // Hapus pengguna dari database
    $stmt_delete = $conn->prepare("DELETE FROM $table_name WHERE $id_column = ?");
    $stmt_delete->bind_param("i", $id);
    
    if ($stmt_delete->execute()) {
        if ($stmt_delete->affected_rows > 0) {
            $_SESSION['success_message'] = "Pengguna berhasil dihapus.";
        } else {
            $_SESSION['error_message'] = "Pengguna tidak ditemukan atau sudah dihapus.";
        }
    } else {
        throw new Exception("Gagal mengeksekusi perintah hapus.");
    }
    $stmt_delete->close();

} catch (Exception $e) {
    $_SESSION['error_message'] = "Terjadi kesalahan: " . $e->getMessage();
}

$conn->close();
header("Location: ../newadmin/pengguna.php");
exit();
?>