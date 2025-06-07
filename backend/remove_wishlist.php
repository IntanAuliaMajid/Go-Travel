<?php
// backend/remove_wishlist.php

session_start();
require_once 'koneksi.php';

header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id_pengunjung'])) {
    $response['message'] = 'Anda tidak memiliki izin.';
    echo json_encode($response);
    exit();
}

$user_id = $_SESSION['user']['id_pengunjung'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $wisata_id = $_POST['wisata_id'] ?? null;

    if ($wisata_id === null) {
        $response['message'] = 'ID Wisata tidak ditemukan.';
        echo json_encode($response);
        exit();
    }

    $stmt = $conn->prepare("DELETE FROM wishlist WHERE user_id = ? AND wisata_id = ?");
    $stmt->bind_param("ii", $user_id, $wisata_id);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            $response['success'] = true;
            $response['message'] = 'Destinasi berhasil dihapus dari wishlist.';
        } else {
            $response['message'] = 'Item tidak ditemukan di wishlist Anda atau sudah dihapus.';
        }
    } else {
        $response['message'] = 'Gagal menghapus dari wishlist: ' . $stmt->error;
    }
    $stmt->close();
} else {
    $response['message'] = 'Metode request tidak diizinkan.';
}

$conn->close();
echo json_encode($response);
?>