<?php
session_start();
include 'koneksi.php'; // Pastikan path ini benar
header('Content-Type: application/json');
// 1. Cek apakah pengguna sudah login
if (!isset($_SESSION['user']['id'])) {
    echo json_encode(['success' => false, 'message' => 'Sesi berakhir atau Anda belum login. Silakan login kembali.']);
    exit;
}

$id_pengunjung = (int)$_SESSION['user']['id'];

// 2. Hapus semua item wishlist untuk pengguna ini
$sql_clear = "DELETE FROM wishlist WHERE user_id = ?";
$stmt_clear = mysqli_prepare($conn, $sql_clear);

if (!$stmt_clear) {
    error_log("MySQLi prepare error (clear wishlist): " . mysqli_error($conn));
    echo json_encode(['success' => false, 'message' => 'Terjadi kesalahan pada server.']);
    exit;
}

mysqli_stmt_bind_param($stmt_clear, "i", $id_pengunjung);

if (mysqli_stmt_execute($stmt_clear)) {
    if (mysqli_stmt_affected_rows($stmt_clear) > 0) {
        echo json_encode(['success' => true, 'message' => 'Wishlist berhasil dikosongkan.']);
    } else {
        // Tidak ada baris yang terpengaruh, mungkin wishlist sudah kosong
        echo json_encode(['success' => true, 'message' => 'Wishlist sudah kosong atau tidak ada item untuk dihapus.']);
    }
} else {
    error_log("MySQLi execute error (clear wishlist): " . mysqli_stmt_error($stmt_clear));
    echo json_encode(['success' => false, 'message' => 'Gagal mengosongkan wishlist: ' . mysqli_stmt_error($stmt_clear)]);
}

mysqli_stmt_close($stmt_clear);
mysqli_close($conn);
?>