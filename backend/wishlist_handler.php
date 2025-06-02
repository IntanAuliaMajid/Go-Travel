<?php
session_start();
include 'koneksi.php';

// Set header untuk JSON response
header('Content-Type: application/json');

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Anda harus login terlebih dahulu'
    ]);
    exit;
}

$user_id = $_SESSION['user_id'];
$action = $_POST['action'] ?? '';
$wisata_id = $_POST['wisata_id'] ?? '';

if (empty($wisata_id) || !is_numeric($wisata_id)) {
    echo json_encode([
        'success' => false,
        'message' => 'ID wisata tidak valid'
    ]);
    exit;
}

try {
    if ($action === 'add') {
        // Cek apakah sudah ada di wishlist
        $checkQuery = "SELECT id_wishlist FROM wishlist WHERE user_id = ? AND wisata_id = ?";
        $checkStmt = mysqli_prepare($conn, $checkQuery);
        mysqli_stmt_bind_param($checkStmt, "ii", $user_id, $wisata_id);
        mysqli_stmt_execute($checkStmt);
        $checkResult = mysqli_stmt_get_result($checkStmt);
        
        if (mysqli_num_rows($checkResult) > 0) {
            echo json_encode([
                'success' => false,
                'message' => 'Destinasi sudah ada di wishlist Anda'
            ]);
            exit;
        }
        
        // Tambah ke wishlist
        $insertQuery = "INSERT INTO wishlist (user_id, wisata_id, created_at) VALUES (?, ?, NOW())";
        $insertStmt = mysqli_prepare($conn, $insertQuery);
        mysqli_stmt_bind_param($insertStmt, "ii", $user_id, $wisata_id);
        
        if (mysqli_stmt_execute($insertStmt)) {
            echo json_encode([
                'success' => true,
                'message' => 'Destinasi berhasil ditambahkan ke wishlist',
                'action' => 'added'
            ]);
        } else {
            throw new Exception('Gagal menambahkan ke wishlist');
        }
        
    } elseif ($action === 'remove') {
        // Hapus dari wishlist
        $deleteQuery = "DELETE FROM wishlist WHERE user_id = ? AND wisata_id = ?";
        $deleteStmt = mysqli_prepare($conn, $deleteQuery);
        mysqli_stmt_bind_param($deleteStmt, "ii", $user_id, $wisata_id);
        
        if (mysqli_stmt_execute($deleteStmt)) {
            if (mysqli_stmt_affected_rows($deleteStmt) > 0) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Destinasi berhasil dihapus dari wishlist',
                    'action' => 'removed'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Destinasi tidak ditemukan di wishlist'
                ]);
            }
        } else {
            throw new Exception('Gagal menghapus dari wishlist');
        }
        
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Aksi tidak valid'
        ]);
    }
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Terjadi kesalahan: ' . $e->getMessage()
    ]);
}
?>