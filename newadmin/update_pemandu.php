<?php
header('Content-Type: application/json');
session_start();
require_once '../backend/koneksi.php';

$response = ['status' => 'error', 'message' => 'Permintaan tidak valid.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['id_pemandu_wisata']) || !is_numeric($_POST['id_pemandu_wisata'])) {
        $response['message'] = 'ID Pemandu tidak ditemukan.';
        echo json_encode($response);
        exit();
    }

    $id_pemandu = (int)$_POST['id_pemandu_wisata'];
    $nama_pemandu = $_POST['nama_pemandu'] ?? '';
    $email = $_POST['email'] ?? '';
    $telepon = $_POST['telepon'] ?? '';
    $id_lokasi = (int)($_POST['id_lokasi'] ?? 0);
    $pengalaman = $_POST['pengalaman'] ?? '';
    $biodata = $_POST['biodata'] ?? '';
    $spesialisasi = $_POST['spesialisasi'] ?? '';
    $bahasa_ids = isset($_POST['bahasa']) ? $_POST['bahasa'] : [];

    // Ambil path foto lama
    $stmt_old = $conn->prepare("SELECT foto_url FROM pemandu_wisata WHERE id_pemandu_wisata = ?");
    $stmt_old->bind_param("i", $id_pemandu);
    $stmt_old->execute();
    $old_foto_path = $stmt_old->get_result()->fetch_assoc()['foto_url'];
    $stmt_old->close();

    $foto_path_db = $old_foto_path;

    // Proses upload file baru jika ada
    if (isset($_FILES['pemandu_foto']) && $_FILES['pemandu_foto']['error'] == 0) {
        $upload_dir = '../uploads/pemandu/';
        $file_info = pathinfo($_FILES['pemandu_foto']['name']);
        $file_name = uniqid('pemandu_', true) . '.' . $file_info['extension'];
        
        if (move_uploaded_file($_FILES['pemandu_foto']['tmp_name'], $upload_dir . $file_name)) {
            $foto_path_db = 'uploads/pemandu/' . $file_name;
            // Hapus file foto lama jika ada
            if ($old_foto_path && file_exists('../' . $old_foto_path)) {
                unlink('../' . $old_foto_path);
            }
        }
    }
    
    $conn->begin_transaction();
    try {
        $stmt1 = $conn->prepare("UPDATE pemandu_wisata SET nama_pemandu=?, email=?, telepon=?, id_lokasi=?, pengalaman=?, biodata=?, spesialisasi=?, foto_url=? WHERE id_pemandu_wisata=?");
        $stmt1->bind_param("sssissssi", $nama_pemandu, $email, $telepon, $id_lokasi, $pengalaman, $biodata, $spesialisasi, $foto_path_db, $id_pemandu);
        $stmt1->execute();
        $stmt1->close();

        // Update relasi bahasa
        $stmt_del = $conn->prepare("DELETE FROM pemandu_bahasa WHERE id_pemandu_wisata = ?");
        $stmt_del->bind_param("i", $id_pemandu);
        $stmt_del->execute();
        $stmt_del->close();

        if (!empty($bahasa_ids)) {
            $stmt_ins = $conn->prepare("INSERT INTO pemandu_bahasa (id_pemandu_wisata, id_bahasa) VALUES (?, ?)");
            $id_pemandu_to_bind = $id_pemandu;
            $id_bahasa_to_bind = 0;
            $stmt_ins->bind_param("ii", $id_pemandu_to_bind, $id_bahasa_to_bind);
            foreach ($bahasa_ids as $id_bahasa) {
                $id_bahasa_to_bind = (int)$id_bahasa;
                $stmt_ins->execute();
            }
            $stmt_ins->close();
        }

        $conn->commit();
        $response['status'] = 'success';
        $response['message'] = 'Data pemandu wisata berhasil diperbarui.';

    } catch (Exception $e) {
        $conn->rollback();
        $response['message'] = 'Gagal memperbarui data: ' . $e->getMessage();
    }
}

$conn->close();
echo json_encode($response);
?>