<?php
session_start();
require_once '../backend/koneksi.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['error_message'] = "ID Penginapan tidak valid.";
    header("Location: ../newadmin/penginapan.php");
    exit();
}

$id_penginapan = (int)$_GET['id'];

try {
    $stmt_img = $conn->prepare("SELECT gambar_url FROM akomodasi_penginapan WHERE id_akomodasi_penginapan = ?");
    $stmt_img->bind_param("i", $id_penginapan);
    $stmt_img->execute();
    $result_img = $stmt_img->get_result();
    $img_data = $result_img->fetch_assoc();
    $stmt_img->close();
    
    $stmt = $conn->prepare("DELETE FROM akomodasi_penginapan WHERE id_akomodasi_penginapan = ?");
    $stmt->bind_param("i", $id_penginapan);
    $stmt->execute();
    
    if ($stmt->affected_rows > 0) {
        if ($img_data && !empty($img_data['gambar_url']) && file_exists('../' . $img_data['gambar_url'])) {
            unlink('../' . $img_data['gambar_url']);
        }
        $_SESSION['success_message'] = "Penginapan berhasil dihapus.";
    } else {
        $_SESSION['error_message'] = "Penginapan tidak ditemukan.";
    }
    $stmt->close();
} catch (Exception $e) {
    $_SESSION['error_message'] = "Gagal menghapus data: " . $e->getMessage();
}

$conn->close();
header("Location: ../newadmin/penginapan.php");
exit();
?>