<?php
// backend/upload_avatar.php

session_start();
require_once 'koneksi.php';

header('Content-Type: application/json');

$response = ['success' => false, 'message' => '', 'avatar_url' => ''];

if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id_pengunjung'])) {
    $response['message'] = 'Anda tidak memiliki izin.';
    echo json_encode($response);
    exit();
}

$id_pengunjung = $_SESSION['user']['id_pengunjung'];
$upload_dir = '../uploads/avatars/'; // Sesuaikan dengan folder upload Anda, keluar satu level dari backend

// Buat direktori jika belum ada
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_photo'])) {
    $file = $_FILES['profile_photo'];

    // Validasi file
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
    $max_size = 5 * 1024 * 1024; // 5MB

    if (!in_array($file['type'], $allowed_types)) {
        $response['message'] = 'Tipe file tidak didukung. Hanya JPG, PNG, GIF yang diizinkan.';
        echo json_encode($response);
        exit();
    }

    if ($file['size'] > $max_size) {
        $response['message'] = 'Ukuran file terlalu besar. Maksimal 5MB.';
        echo json_encode($response);
        exit();
    }

    if ($file['error'] !== UPLOAD_ERR_OK) {
        $response['message'] = 'Terjadi kesalahan saat mengunggah file: ' . $file['error'];
        echo json_encode($response);
        exit();
    }

    // Generate nama file unik
    $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $new_file_name = 'avatar_' . $id_pengunjung . '_' . uniqid() . '.' . $file_extension;
    $target_file_path = $upload_dir . $new_file_name;
    // URL yang akan disimpan di DB dan digunakan di frontend (relative dari root web)
    $relative_avatar_url = './uploads/avatars/' . $new_file_name; 

    // Hapus avatar lama jika ada dan bukan avatar default
    if (!empty($_SESSION['user']['avatar']) && 
        file_exists($_SESSION['user']['avatar']) && 
        basename($_SESSION['user']['avatar']) != 'default_avatar.png') {
        unlink($_SESSION['user']['avatar']);
    }

    if (move_uploaded_file($file['tmp_name'], $target_file_path)) {
        // Update path avatar di database
        $stmt = $conn->prepare("UPDATE pengunjung SET avatar = ? WHERE id_pengunjung = ?");
        $stmt->bind_param("si", $relative_avatar_url, $id_pengunjung);

        if ($stmt->execute()) {
            $_SESSION['user']['avatar'] = $relative_avatar_url; // Update session
            $response['success'] = true;
            $response['message'] = 'Foto profil berhasil diperbarui.';
            $response['avatar_url'] = $relative_avatar_url; // Kirim URL baru ke frontend
        } else {
            $response['message'] = 'Gagal menyimpan path avatar ke database: ' . $stmt->error;
            // Hapus file yang sudah diupload jika gagal disimpan ke DB
            unlink($target_file_path); 
        }
        $stmt->close();
    } else {
        $response['message'] = 'Gagal memindahkan file yang diunggah.';
    }
} else {
    $response['message'] = 'Tidak ada file yang diunggah atau metode request tidak valid.';
}

$conn->close();
echo json_encode($response);
?>