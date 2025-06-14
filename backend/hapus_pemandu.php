<?php
session_start();
require_once '../backend/koneksi.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['error_message'] = "ID Pemandu tidak valid.";
    header("Location: ../newadmin/pemandu_wisata.php");
    exit();
}

$id_pemandu = (int)$_GET['id'];

$conn->begin_transaction();
try {
    // Ambil path foto sebelum dihapus dari DB
    $stmt_foto = $conn->prepare("SELECT foto_url FROM pemandu_wisata WHERE id_pemandu_wisata = ?");
    $stmt_foto->bind_param("i", $id_pemandu);
    $stmt_foto->execute();
    $result_foto = $stmt_foto->get_result();
    $foto_path = $result_foto->fetch_assoc()['foto_url'];
    $stmt_foto->close();

    // Hapus data pemandu dari tabel utama.
    // Karena ada ON DELETE CASCADE, data di `pemandu_bahasa` akan ikut terhapus.
    $stmt = $conn->prepare("DELETE FROM pemandu_wisata WHERE id_pemandu_wisata = ?");
    $stmt->bind_param("i", $id_pemandu);
    $stmt->execute();
    
    if ($stmt->affected_rows > 0) {
        // Jika data DB berhasil dihapus, hapus juga file fotonya
        if ($foto_path && file_exists('../' . $foto_path)) {
            unlink('../' . $foto_path);
        }
        $_SESSION['success_message'] = "Pemandu wisata berhasil dihapus.";
    } else {
        $_SESSION['error_message'] = "Pemandu wisata tidak ditemukan.";
    }
    $stmt->close();

    $conn->commit();
} catch (Exception $e) {
    $conn->rollback();
    $_SESSION['error_message'] = "Gagal menghapus data: " . $e->getMessage();
}

$conn->close();
header("Location: ../newadmin/pemandu_wisata.php");
exit();
?>