<?php
session_start();
require_once 'koneksi.php';

// Validasi input
if (!isset($_GET['role']) || !isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['error_message'] = "Permintaan tidak valid.";
    header("Location: ../newadmin/pengguna.php");
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
    header("Location: ../newadmin/pengguna.php");
    exit();
}

try {
    // Khusus untuk pengunjung, lakukan pembersihan data terkait
    if ($role === 'pengunjung') {
        // 1. Hapus file avatar fisiknya
        $stmt_avatar = $conn->prepare("SELECT avatar FROM pengunjung WHERE id_pengunjung = ?");
        $stmt_avatar->bind_param("i", $id);
        $stmt_avatar->execute();
        $result = $stmt_avatar->get_result();
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            // Cek path avatar dan hapus jika ada
            if (!empty($user['avatar'])) {
                // Asumsi path dari file ini ke folder avatars
                 $avatar_path = __DIR__ . '/../' . $user['avatar']; // Path dinamis berdasarkan DB
                 if (file_exists($avatar_path) && is_file($avatar_path)) {
                     unlink($avatar_path);
                 }
            }
        }
        $stmt_avatar->close();

        // 2. HAPUS DATA TERKAIT DI TABEL WISHLIST (INI BAGIAN PENTINGNYA)
        $stmt_wishlist = $conn->prepare("DELETE FROM wishlist WHERE user_id = ?");
        $stmt_wishlist->bind_param("i", $id);
        $stmt_wishlist->execute();
        $stmt_wishlist->close();
        
        // Catatan: Data di tabel `ulasan` dan `ulasan_pemandu` akan otomatis menjadi NULL karena aturannya `ON DELETE SET NULL`, jadi tidak perlu dihapus manual.
    }

    // 3. Hapus pengguna dari database setelah data terkait dibersihkan
    $stmt_delete = $conn->prepare("DELETE FROM $table_name WHERE $id_column = ?");
    $stmt_delete->bind_param("i", $id);
    
    if ($stmt_delete->execute()) {
        if ($stmt_delete->affected_rows > 0) {
            $_SESSION['success_message'] = "Pengguna berhasil dihapus.";
        } else {
            $_SESSION['error_message'] = "Pengguna tidak ditemukan atau sudah dihapus.";
        }
    } else {
        // Tangkap error spesifik dari MySQL jika ada
        throw new Exception($conn->error);
    }
    $stmt_delete->close();

} catch (Exception $e) {
    // Ambil pesan error yang lebih deskriptif
    $errorMessage = $e->getMessage();
    if (strpos($errorMessage, 'foreign key constraint fails') !== false) {
        $_SESSION['error_message'] = "Gagal menghapus: Pengguna ini masih memiliki data terkait di tabel lain (misal: ulasan, pemesanan, dll).";
    } else {
        $_SESSION['error_message'] = "Terjadi kesalahan: " . $errorMessage;
    }
}

$conn->close();
header("Location: ../newadmin/pengguna.php");
exit();
?>