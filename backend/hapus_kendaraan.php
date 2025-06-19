<?php
session_start();
require_once 'koneksi.php'; // Memanggil file koneksi yang ada di folder backend

// Keamanan: Pastikan hanya admin yang login yang bisa mengakses fitur ini
// Gantilah 'admin_id' dengan nama session yang Anda gunakan untuk login admin
// if (!isset($_SESSION['id_admin'])) {
//     // Jika tidak ada sesi admin, redirect ke halaman login
//     header('Location: ../login.php'); // Sesuaikan dengan halaman login Anda
//     exit();
// }

// 1. Validasi ID Kendaraan dari URL
// Pastikan ID ada dan merupakan angka
if (!isset($_GET['id']) || !filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    // Jika ID tidak valid, kembalikan ke halaman manajemen dengan status error
    header('Location: ../newadmin/endaraan.php?status=hapus_gagal&error=invalid_id');
    exit();
}

$id_kendaraan = $_GET['id'];

// 2. Hapus File Gambar dari Server
// Pertama, kita perlu mengambil path gambar dari database sebelum recordnya dihapus
$sql_select = "SELECT gambar FROM kendaraan WHERE id_kendaraan = ?";
$stmt_select = $conn->prepare($sql_select);
$stmt_select->bind_param("i", $id_kendaraan);
$stmt_select->execute();
$result = $stmt_select->get_result();

if ($row = $result->fetch_assoc()) {
    $gambar_path = $row['gambar'];

    // Buat path file lengkap di server (keluar dari folder backend dulu dengan ../)
    $file_to_delete = '../' . $gambar_path;

    // Cek apakah file benar-benar ada dan bukan direktori, lalu hapus
    if (file_exists($file_to_delete) && !is_dir($file_to_delete)) {
        unlink($file_to_delete); // Fungsi untuk menghapus file
    }
}
$stmt_select->close();


// 3. Hapus Record dari Database
$sql_delete = "DELETE FROM kendaraan WHERE id_kendaraan = ?";
$stmt_delete = $conn->prepare($sql_delete);

// Periksa apakah statement berhasil dipersiapkan
if ($stmt_delete === false) {
    // Jika gagal, redirect dengan pesan error
    header('Location: ../newadmin/kendaraan.php?status=hapus_gagal&error=' . urlencode($conn->error));
    exit();
}

// Bind parameter ID ke statement
$stmt_delete->bind_param("i", $id_kendaraan);

// Eksekusi statement delete
if ($stmt_delete->execute()) {
    // Jika eksekusi berhasil, redirect ke halaman manajemen dengan status sukses
    header('Location: ../newadmin/kendaraan.php?status=hapus_sukses');
} else {
    // Jika gagal, redirect dengan pesan error
    header('Location: ../newadmin/kendaraan.php?status=hapus_gagal&error=' . urlencode($stmt_delete->error));
}

// Tutup statement dan koneksi
$stmt_delete->close();
$conn->close();
exit();
?>