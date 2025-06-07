<?php
// Pastikan session_start() ada di paling atas
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Sesuaikan path jika koneksi.php tidak selevel dengan proses_wishlist.php
// Jika koneksi.php ada di root folder backend:
include 'koneksi.php';
// Jika koneksi.php ada di level atas (misal di root utama proyek):
// include '../koneksi.php';

header('Content-Type: application/json');

// 1. Cek apakah pengguna sudah login
// PERBAIKAN: Ganti 'id' dengan 'id_pengunjung' untuk konsistensi dengan sesi
if (!isset($_SESSION['user']['id_pengunjung'])) {
    echo json_encode(['success' => false, 'message' => 'Sesi berakhir atau Anda belum login. Silakan login kembali untuk menggunakan fitur wishlist.']);
    exit;
}

// 2. Cek apakah id_wisata dikirim dan valid
if (!isset($_POST['id_wisata'])) {
    echo json_encode(['success' => false, 'message' => 'Permintaan tidak valid: ID Wisata tidak ditemukan.']);
    exit;
}

// PERBAIKAN: Ganti 'id' dengan 'id_pengunjung' untuk mengambil ID pengguna dari sesi
$id_pengunjung = (int)$_SESSION['user']['id_pengunjung'];
$id_wisata = (int)$_POST['id_wisata'];

if ($id_wisata <= 0) {
    echo json_encode(['success' => false, 'message' => 'Permintaan tidak valid: ID Wisata tidak valid.']);
    exit;
}

// 3. Cek apakah item sudah ada di wishlist
$sql_check = "SELECT id_wishlist FROM wishlist WHERE user_id = ? AND wisata_id = ?";
$stmt_check = mysqli_prepare($conn, $sql_check);

if (!$stmt_check) {
    error_log("MySQLi prepare error (check): " . mysqli_error($conn));
    echo json_encode(['success' => false, 'message' => 'Terjadi kesalahan pada server (cek).']);
    exit;
}

mysqli_stmt_bind_param($stmt_check, "ii", $id_pengunjung, $id_wisata);
mysqli_stmt_execute($stmt_check);
$result_check = mysqli_stmt_get_result($stmt_check);

if (mysqli_num_rows($result_check) > 0) {
    // 4. Jika ada, hapus dari wishlist
    mysqli_stmt_close($stmt_check); // Tutup statement check lebih awal

    $sql_delete = "DELETE FROM wishlist WHERE user_id = ? AND wisata_id = ?";
    $stmt_delete = mysqli_prepare($conn, $sql_delete);

    if (!$stmt_delete) {
        error_log("MySQLi prepare error (delete): " . mysqli_error($conn));
        echo json_encode(['success' => false, 'message' => 'Terjadi kesalahan pada server (hapus).']);
        exit;
    }

    mysqli_stmt_bind_param($stmt_delete, "ii", $id_pengunjung, $id_wisata);

    if (mysqli_stmt_execute($stmt_delete)) {
        echo json_encode(['success' => true, 'status' => 'removed', 'message' => 'Wisata berhasil dihapus dari wishlist Anda.']);
    } else {
        error_log("MySQLi execute error (delete): " . mysqli_stmt_error($stmt_delete));
        echo json_encode(['success' => false, 'message' => 'Gagal menghapus wisata dari wishlist: ' . mysqli_stmt_error($stmt_delete)]);
    }
    mysqli_stmt_close($stmt_delete);

} else {
    mysqli_stmt_close($stmt_check); // Tutup statement check jika tidak ada row

    // 5. Jika tidak ada, tambahkan ke wishlist
    $sql_insert = "INSERT INTO wishlist (user_id, wisata_id, created_at) VALUES (?, ?, NOW())";
    $stmt_insert = mysqli_prepare($conn, $sql_insert);

    if (!$stmt_insert) {
        error_log("MySQLi prepare error (insert): " . mysqli_error($conn));
        echo json_encode(['success' => false, 'message' => 'Terjadi kesalahan pada server (tambah).']);
        exit;
    }

    mysqli_stmt_bind_param($stmt_insert, "ii", $id_pengunjung, $id_wisata);

    if (mysqli_stmt_execute($stmt_insert)) {
        echo json_encode(['success' => true, 'status' => 'added', 'message' => 'Wisata berhasil ditambahkan ke wishlist Anda.']);
    } else {
        error_log("MySQLi execute error (insert): " . mysqli_stmt_error($stmt_insert) . " (Errno: " . mysqli_errno($conn) . ")");
        // Error 1062: Duplicate entry for key 'unique_wishlist' (jika ada race condition kecil atau jika cek awal gagal)
        if(mysqli_errno($conn) == 1062){ // Error number for duplicate entry
            echo json_encode(['success' => true, 'status' => 'exists', 'message' => 'Wisata ini sudah ada di wishlist Anda.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal menambahkan wisata ke wishlist: ' . mysqli_stmt_error($stmt_insert)]);
        }
    }
    mysqli_stmt_close($stmt_insert);
}

mysqli_close($conn);
?>