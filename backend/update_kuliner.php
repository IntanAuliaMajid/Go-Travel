<?php
session_start();
require_once 'koneksi.php'; // Ensure this path is correct

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_akomodasi_kuliner = isset($_POST['id_akomodasi_kuliner']) ? intval($_POST['id_akomodasi_kuliner']) : 0;
    $nama_restaurant = isset($_POST['nama_restaurant']) ? trim($_POST['nama_restaurant']) : '';
    $harga = isset($_POST['harga']) ? floatval($_POST['harga']) : 0.00;
    $existing_gambar_url = isset($_POST['existing_gambar_url']) ? $_POST['existing_gambar_url'] : '';

    $gambar_url = $existing_gambar_url; // Default to existing image

    // Validate inputs
    if ($id_akomodasi_kuliner <= 0 || empty($nama_restaurant) || $harga < 0) {
        echo json_encode(['status' => 'error', 'message' => 'Data tidak lengkap atau tidak valid.']);
        exit;
    }

    // Handle image upload
    if (isset($_FILES['gambar_url']) && $_FILES['gambar_url']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/kuliner/'; // Adjust as per your actual upload directory
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileTmpPath = $_FILES['gambar_url']['tmp_name'];
        $fileName = $_FILES['gambar_url']['name'];
        $fileSize = $_FILES['gambar_url']['size'];
        $fileType = $_FILES['gambar_url']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        $newFileName = 'kuliner_' . uniqid() . '.' . $fileExtension;
        $destPath = $uploadDir . $newFileName;

        $allowedfileExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (in_array($fileExtension, $allowedfileExtensions)) {
            if (move_uploaded_file($fileTmpPath, $destPath)) {
                $gambar_url = 'uploads/kuliner/' . $newFileName; // Path to save in DB
                // Optionally delete old image if it exists and is not default
                if (!empty($existing_gambar_url) && file_exists('../' . $existing_gambar_url) && strpos($existing_gambar_url, 'default_') === false) {
                    unlink('../' . $existing_gambar_url);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal mengunggah gambar.']);
                exit;
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Format file gambar tidak didukung.']);
            exit;
        }
    }

    // Update data in database
    $stmt = $conn->prepare("UPDATE akomodasi_kuliner SET nama_restaurant = ?, gambar_url = ?, harga = ? WHERE id_akomodasi_kuliner = ?");
    $stmt->bind_param("ssdi", $nama_restaurant, $gambar_url, $harga, $id_akomodasi_kuliner);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Data kuliner berhasil diperbarui.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui data kuliner: ' . $conn->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Metode request tidak valid.']);
}

$conn->close();
?>