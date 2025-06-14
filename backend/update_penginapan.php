<?php
header('Content-Type: application/json');
session_start();
require_once 'koneksi.php';

$response = ['status' => 'error', 'message' => 'Permintaan tidak valid.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['id_akomodasi_penginapan']) || !is_numeric($_POST['id_akomodasi_penginapan'])) {
        $response['message'] = 'ID Penginapan tidak ditemukan.';
        echo json_encode($response);
        exit();
    }

    $id_penginapan = (int)$_POST['id_akomodasi_penginapan'];
    $nama_penginapan = $_POST['nama_penginapan'] ?? '';
    $rating_bintang = (int)($_POST['rating_bintang'] ?? 0);
    $harga_per_malam = (int)($_POST['harga_per_malam'] ?? 0);
    
    $stmt_old = $conn->prepare("SELECT gambar_url FROM akomodasi_penginapan WHERE id_akomodasi_penginapan = ?");
    $stmt_old->bind_param("i", $id_penginapan);
    $stmt_old->execute();
    $old_img_path = $stmt_old->get_result()->fetch_assoc()['gambar_url'];
    $stmt_old->close();

    $gambar_path_db = $old_img_path;

    if (isset($_FILES['gambar_penginapan']) && $_FILES['gambar_penginapan']['error'] == 0) {
        $upload_dir = '../uploads/penginapan/';
        $file_info = pathinfo($_FILES['gambar_penginapan']['name']);
        $file_name = uniqid('penginapan_', true) . '.' . strtolower($file_info['extension']);
        
        if (move_uploaded_file($_FILES['gambar_penginapan']['tmp_name'], $upload_dir . $file_name)) {
            $gambar_path_db = 'uploads/penginapan/' . $file_name;
            if ($old_img_path && file_exists('../' . $old_img_path)) {
                unlink('../' . $old_img_path);
            }
        }
    }
    
    try {
        $stmt = $conn->prepare("UPDATE akomodasi_penginapan SET nama_penginapan = ?, rating_bintang = ?, harga_per_malam = ?, gambar_url = ? WHERE id_akomodasi_penginapan = ?");
        $stmt->bind_param("siisi", $nama_penginapan, $rating_bintang, $harga_per_malam, $gambar_path_db, $id_penginapan);
        $stmt->execute();
        $stmt->close();

        $response['status'] = 'success';
        $response['message'] = 'Data penginapan berhasil diperbarui.';
    } catch (Exception $e) {
        $response['message'] = 'Gagal memperbarui data: ' . $e->getMessage();
    }
}

$conn->close();
echo json_encode($response);
?>