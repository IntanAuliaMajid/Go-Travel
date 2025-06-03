<?php
session_start(); // Mulai sesi untuk mengakses $_SESSION

// Sertakan file koneksi database Anda
// Pastikan path ini benar relatif terhadap lokasi proses_wishlist.php
// Jika proses_wishlist.php ada di root, dan koneksi.php ada di dalam folder backend:
include './backend/koneksi.php'; // Sesuaikan path jika perlu

header('Content-Type: application/json'); // Set header untuk output JSON

// 1. Cek apakah pengguna sudah login
if (!isset($_SESSION['user']['id'])) {
    echo json_encode(['success' => false, 'status' => 'error', 'message' => 'Anda harus login untuk mengubah wishlist.']);
    exit;
}

// 2. Cek apakah id_wisata dikirim melalui POST
if (!isset($_POST['id_wisata'])) {
    echo json_encode(['success' => false, 'status' => 'error', 'message' => 'ID Wisata tidak ditemukan.']);
    exit;
}

$id_pengunjung = (int)$_SESSION['user']['id']; // Ambil ID pengguna dari sesi
$id_wisata = (int)$_POST['id_wisata'];       // Ambil ID wisata dari POST

if ($id_wisata <= 0) {
    echo json_encode(['success' => false, 'status' => 'error', 'message' => 'ID Wisata tidak valid.']);
    exit;
}

// 3. Siapkan dan jalankan statement DELETE
// Perhatikan: Dalam skema Anda, kolom di tabel wishlist adalah user_id dan wisata_id
$sql = "DELETE FROM wishlist WHERE user_id = ? AND wisata_id = ?";
$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    // Kesalahan saat mempersiapkan statement
    error_log("MySQLi prepare error (delete wishlist item): " . mysqli_error($conn));
    echo json_encode(['success' => false, 'status' => 'error', 'message' => 'Terjadi kesalahan pada server (prepare).']);
    mysqli_close($conn);
    exit;
}

mysqli_stmt_bind_param($stmt, "ii", $id_pengunjung, $id_wisata);

if (mysqli_stmt_execute($stmt)) {
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        // Item berhasil dihapus
        echo json_encode(['success' => true, 'status' => 'removed', 'message' => 'Destinasi berhasil dihapus dari wishlist.']);
    } else {
        // Tidak ada baris yang terpengaruh, mungkin item tidak ada atau sudah dihapus sebelumnya
        // Atau bisa juga item ditambahkan oleh user lain jika id_pengunjung tidak cocok
        echo json_encode(['success' => false, 'status' => 'notfound', 'message' => 'Destinasi tidak ditemukan di wishlist Anda atau sudah dihapus.']);
    }
} else {
    // Kesalahan saat eksekusi statement
    error_log("MySQLi execute error (delete wishlist item): " . mysqli_stmt_error($stmt));
    echo json_encode(['success' => false, 'status' => 'error', 'message' => 'Gagal menghapus destinasi dari wishlist: ' . mysqli_stmt_error($stmt)]);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>