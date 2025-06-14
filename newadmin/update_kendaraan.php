<?php
header('Content-Type: application/json');
session_start();
require_once '../backend/koneksi.php';

$response = ['status' => 'error', 'message' => 'Permintaan tidak valid.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['id_kendaraan']) || !is_numeric($_POST['id_kendaraan'])) {
        $response['message'] = 'ID Kendaraan tidak ditemukan.';
        echo json_encode($response);
        exit();
    }

    $id_kendaraan = (int)$_POST['id_kendaraan'];
    $jenis_kendaraan = $_POST['jenis_kendaraan'] ?? '';
    
    // Ambil path gambar lama dari DB
    $stmt_old = $conn->prepare("SELECT gambar FROM kendaraan WHERE id_kendaraan = ?");
    $stmt_old->bind_param("i", $id_kendaraan);
    $stmt_old->execute();
    $old_img_path = $stmt_old->get_result()->fetch_assoc()['gambar'];
    $stmt_old->close();

    $gambar_path_db = $old_img_path;

    // Proses upload file baru jika ada
    if (isset($_FILES['gambar_kendaraan']) && $_FILES['gambar_kendaraan']['error'] == 0) {
        $upload_dir = '../uploads/kendaraan/';
        $file_info = pathinfo($_FILES['gambar_kendaraan']['name']);
        $file_name = uniqid('kendaraan_', true) . '.' . strtolower($file_info['extension']);
        
        if (move_uploaded_file($_FILES['gambar_kendaraan']['tmp_name'], $upload_dir . $file_name)) {
            $gambar_path_db = 'uploads/kendaraan/' . $file_name;
            // Hapus file gambar lama jika ada
            if ($old_img_path && file_exists('../' . $old_img_path)) {
                unlink('../' . $old_img_path);
            }
        }
    }
    
    try {
        $stmt = $conn->prepare("UPDATE kendaraan SET jenis_kendaraan = ?, gambar = ? WHERE id_kendaraan = ?");
        $stmt->bind_param("ssi", $jenis_kendaraan, $gambar_path_db, $id_kendaraan);
        $stmt->execute();
        $stmt->close();

        $response['status'] = 'success';
        $response['message'] = 'Data kendaraan berhasil diperbarui.';
    } catch (Exception $e) {
        $response['message'] = 'Gagal memperbarui data: ' . $e->getMessage();
    }
}

$conn->close();
echo json_encode($response);
?>