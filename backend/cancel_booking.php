<?php
// backend/cancel_booking.php

// Aktifkan error reporting untuk debugging. HAPUS ini di lingkungan produksi!
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Pastikan ini adalah baris pertama di file, tanpa spasi atau karakter di depannya.
session_start();

// Penting: Memberi tahu browser bahwa respons adalah JSON
header('Content-Type: application/json');

// Pastikan pengguna sudah login sebelum memproses pembatalan
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['email'])) {
    echo json_encode(['success' => false, 'message' => 'Anda harus login untuk membatalkan pemesanan.']);
    exit();
}

// Sertakan file koneksi database
// PASTIKAN PATH INI BENAR: Jika file ini ada di root/backend/ dan koneksi.php ada di root/, maka path ini sudah benar.
require_once 'koneksi.php';

$response = ['success' => false, 'message' => 'Terjadi kesalahan tidak dikenal di server.'];

// Pastikan permintaan datang melalui metode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil ID Pemesanan dari POST request dan sanitasi
    $id_pemesanan = isset($_POST['id_pemesanan']) ? (int)$_POST['id_pemesanan'] : 0;
    $email_pengunjung = $_SESSION['user']['email']; // Ambil email dari session pengguna yang login

    if ($id_pemesanan > 0) {
        $conn->begin_transaction();
        try {
            // Langkah 1: Periksa status dan kepemilikan pemesanan
            $check_stmt = $conn->prepare("SELECT status_pemesanan FROM pemesanan WHERE id_pemesanan = ? AND email = ?");
            $check_stmt->bind_param("is", $id_pemesanan, $email_pengunjung);
            $check_stmt->execute();
            $check_result = $check_stmt->get_result();
            $current_status_row = $check_result->fetch_assoc();
            $check_stmt->close();

            if ($current_status_row) {
                $current_status = strtolower($current_status_row['status_pemesanan']);
                
                // Hanya izinkan pembatalan jika statusnya 'pending'
                if ($current_status === 'pending') {
                    // Langkah 2: Update status pemesanan menjadi 'cancelled'
                    $update_stmt = $conn->prepare("UPDATE pemesanan SET status_pemesanan = 'cancelled' WHERE id_pemesanan = ?");
                    $update_stmt->bind_param("i", $id_pemesanan);

                    if ($update_stmt->execute()) {
                        if ($update_stmt->affected_rows > 0) {
                            $conn->commit();
                            $response = ['success' => true, 'message' => 'Pemesanan berhasil dibatalkan.'];
                        } else {
                            $conn->rollback();
                            $response = ['success' => false, 'message' => 'Tidak ada perubahan. Status pesanan tidak berubah.'];
                        }
                    } else {
                        throw new Exception("Gagal mengeksekusi update.");
                    }
                    $update_stmt->close();
                } else {
                    $response = ['success' => false, 'message' => 'Pemesanan tidak dapat dibatalkan karena statusnya bukan "pending".'];
                }
            } else {
                $response = ['success' => false, 'message' => 'Pemesanan tidak ditemukan atau Anda tidak berhak mengaksesnya.'];
            }
        } catch (Exception $e) {
            $conn->rollback();
            $response = ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    } else {
        $response = ['success' => false, 'message' => 'ID Pemesanan tidak valid.'];
    }
} else {
    $response = ['success' => false, 'message' => 'Metode request tidak diizinkan.'];
}

$conn->close();
echo json_encode($response);
exit();
?>