<?php
session_start();
require_once 'koneksi.php'; // Pastikan path ini benar

// Pastikan pengguna sudah login
if (!isset($_SESSION['user']['email'])) {
    $_SESSION['error_message'] = "Anda harus login untuk membatalkan pesanan.";
    header("Location: ../login.php"); // Sesuaikan dengan halaman login Anda
    exit;
}

$email_pengunjung = $_SESSION['user']['email'];
$kode_pemesanan = $_GET['order_id'] ?? '';

if (empty($kode_pemesanan)) {
    $_SESSION['error_message'] = "Kode pemesanan tidak ditemukan.";
    header("Location: ../riwayat_pemesanan.php");
    exit;
}

// Lakukan pembatalan pesanan di database
try {
    // Pastikan pesanan tersebut milik pengguna yang sedang login dan statusnya masih 'pending'
    $stmt = $conn->prepare("UPDATE pemesanan SET status_pemesanan = 'cancelled' WHERE kode_pemesanan = ? AND email = ? AND status_pemesanan = 'pending'");
    $stmt->bind_param("ss", $kode_pemesanan, $email_pengunjung);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $_SESSION['success_message'] = "Pesanan dengan kode " . htmlspecialchars($kode_pemesanan) . " berhasil dibatalkan.";
    } else {
        // Ini bisa terjadi jika pesanan tidak ditemukan, bukan milik user, atau sudah tidak 'pending'
        $_SESSION['error_message'] = "Gagal membatalkan pesanan. Pesanan mungkin tidak ditemukan, bukan milik Anda, atau statusnya sudah berubah.";
    }
    $stmt->close();
} catch (Exception $e) {
    $_SESSION['error_message'] = "Terjadi kesalahan saat membatalkan pesanan: " . $e->getMessage();
}

$conn->close();

// Redirect kembali ke halaman riwayat pemesanan
header("Location: ../riwayat_pemesanan.php");
exit;
?>