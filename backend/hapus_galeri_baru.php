<?php
// hapus_galeri_baru.php

// Memulai session
// session_start();

// // Cek apakah user adalah admin
// if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
//     header('HTTP/1.1 403 Forbidden');
//     echo 'Akses ditolak. Hanya admin yang dapat melakukan operasi ini.';
//     exit;
// }

// Include file koneksi database
require_once 'koneksi.php'; // Sesuaikan dengan path koneksi database

// Ambil id_galeri dari parameter GET
$id_galeri = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id_galeri <= 0) {
    header('HTTP/1.1 400 Bad Request');
    echo 'ID Galeri tidak valid.';
    exit;
}

// Ambil data galeri untuk mendapatkan path file
$sql_select = "SELECT path_file FROM galeri WHERE id_galeri = ?";
$stmt_select = $conn->prepare($sql_select);
$stmt_select->bind_param('i', $id_galeri);
$stmt_select->execute();
$result = $stmt_select->get_result();
$gallery = $result->fetch_assoc();

if (!$gallery) {
    header('Location: newadmin/gallery.php?status=error&message=Data+galeri+tidak+ditemukan');
    exit;
}

$file_path = $gallery['path_file'];

// Hapus data dari database
$sql_delete = "DELETE FROM galeri WHERE id_galeri = ?";
$stmt_delete = $conn->prepare($sql_delete);
$stmt_delete->bind_param('i', $id_galeri);
$success = $stmt_delete->execute();

if ($success) {
    // Hapus file dari server jika ada
    if (!empty($file_path) && file_exists($file_path)) {
        unlink($file_path);
    }
    
    header('Location: ../newadmin/galeri.php?status=success&message=Galeri+berhasil+dihapus');
    exit;
} else {
    header('Location: ../newadmin/galeri.php?status=error&message=Gagal+menghapus+data+dari+database');
    exit;
}