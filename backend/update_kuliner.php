<?php
// File: backend/update_kuliner.php (VERSI FINAL & BERSIH)

header('Content-Type: application/json');
session_start();
require_once 'koneksi.php';

$response = ['status' => 'error', 'message' => 'Permintaan tidak valid.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['id_akomodasi_kuliner']) || !is_numeric($_POST['id_akomodasi_kuliner'])) {
        $response['message'] = 'ID Kuliner tidak ditemukan.';
        echo json_encode($response);
        exit();
    }

    $id_kuliner = (int)$_POST['id_akomodasi_kuliner'];
    $nama_restaurant = $_POST['nama_restaurant'] ?? '';
    
    // Ambil path gambar lama dari DB
    $stmt_old = $conn->prepare("SELECT gambar_url FROM akomodasi_kuliner WHERE id_akomodasi_kuliner = ?");
    $stmt_old->bind_param("i", $id_kuliner);
    $stmt_old->execute();
    $old_img_path = $stmt_old->get_result()->fetch_assoc()['gambar_url'];
    $stmt_old->close();

    $gambar_path_db = $old_img_path;

    // Proses upload file baru jika ada
    if (isset($_FILES['gambar_kuliner']) && $_FILES['gambar_kuliner']['error'] == 0) {
        $upload_dir = '../uploads/kuliner/';
        $file_info = pathinfo($_FILES['gambar_kuliner']['name']);
        $file_name = uniqid('kuliner_', true) . '.' . strtolower($file_info['extension']);
        
        if (move_uploaded_file($_FILES['gambar_kuliner']['tmp_name'], $upload_dir . $file_name)) {
            $gambar_path_db = 'uploads/kuliner/' . $file_name;
            // Hapus file gambar lama jika ada dan bukan URL eksternal
            if ($old_img_path && !filter_var($old_img_path, FILTER_VALIDATE_URL) && file_exists('../' . $old_img_path)) {
                unlink('../' . $old_img_path);
            }
        }
    }
    
    try {
        $stmt = $conn->prepare("UPDATE akomodasi_kuliner SET nama_restaurant = ?, gambar_url = ? WHERE id_akomodasi_kuliner = ?");
        $stmt->bind_param("ssi", $nama_restaurant, $gambar_path_db, $id_kuliner);
        $stmt->execute();
        $stmt->close();

        $response['status'] = 'success';
        $response['message'] = 'Data kuliner berhasil diperbarui.';

    } catch (Exception $e) {
        $response['message'] = 'Gagal memperbarui data: ' . $e->getMessage();
    }
}

$conn->close();
echo json_encode($response);
?>