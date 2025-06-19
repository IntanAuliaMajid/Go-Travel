<?php
require_once 'koneksi.php'; // Ensure this path is correct

header('Content-Type: application/json');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    if ($id <= 0) {
        echo json_encode(['error' => 'ID kuliner tidak valid.']);
        exit;
    }

    $stmt = $conn->prepare("SELECT id_akomodasi_kuliner, nama_restaurant, gambar_url, harga FROM akomodasi_kuliner WHERE id_akomodasi_kuliner = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $kuliner = $result->fetch_assoc();
        echo json_encode($kuliner);
    } else {
        echo json_encode(['error' => 'Data kuliner tidak ditemukan.']);
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'Parameter ID tidak ditemukan.']);
}

$conn->close();
?>