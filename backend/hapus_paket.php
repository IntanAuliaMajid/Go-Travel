<?php
session_start(); // Mulai session

// Pastikan pengguna sudah login sebagai admin
// Sesuaikan dengan logika autentikasi dan otorisasi admin Anda
// if (!isset($_SESSION['user_admin_id'])) { // Ganti 'user_admin_id' dengan session variable yang sesuai
//     header("Location: ../newadmin/login_admin.php"); // Redirect ke halaman login admin di newadmin
//     exit();
// }

require_once 'koneksi.php'; // Sesuaikan path jika koneksi.php ada di folder yang sama (backend)

$message = '';
$message_type = '';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_paket_wisata = (int)$_GET['id'];

    // Mulai transaksi untuk memastikan integritas data
    $conn->begin_transaction();

    try {
        // Karena ada FOREIGN KEY dengan ON DELETE CASCADE (gambar_paket, termasuk_paket),
        // cukup hapus dari tabel paket_wisata.
        // Namun, jika ada ON DELETE RESTRICT (pemesanan, rencana_perjalanan),
        // penghapusan akan gagal jika ada data terkait.

        $stmt = $conn->prepare("DELETE FROM paket_wisata WHERE id_paket_wisata = ?");
        if ($stmt) {
            $stmt->bind_param("i", $id_paket_wisata);
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    // Jika berhasil menghapus, commit transaksi
                    $conn->commit();
                    $message = "Paket wisata berhasil dihapus.";
                    $message_type = "success";
                } else {
                    // Tidak ada baris yang terpengaruh, berarti ID tidak ditemukan
                    $conn->rollback(); // Rollback jika tidak ada yang dihapus
                    $message = "Paket wisata dengan ID " . $id_paket_wisata . " tidak ditemukan.";
                    $message_type = "danger";
                }
            } else {
                // Eksekusi gagal (misalnya karena ON DELETE RESTRICT)
                $conn->rollback();
                // Cek error untuk pesan yang lebih spesifik
                if ($conn->errno == 1451) { // Error code for foreign key constraint violation
                    $message = "Gagal menghapus paket wisata. Terdapat pemesanan atau rencana perjalanan yang masih terkait dengan paket ini. Harap hapus atau ubah data terkait terlebih dahulu.";
                } else {
                    $message = "Error saat menghapus paket wisata: " . $stmt->error;
                }
                $message_type = "danger";
            }
            $stmt->close();
        } else {
            $conn->rollback();
            $message = "Error mempersiapkan statement: " . $conn->error;
            $message_type = "danger";
        }
    } catch (mysqli_sql_exception $e) {
        $conn->rollback();
        $message = "Terjadi kesalahan database: " . $e->getMessage();
        $message_type = "danger";
    }
} else {
    $message = "ID paket wisata tidak valid.";
    $message_type = "danger";
}

$conn->close();

// Redirect kembali ke halaman manajemen paket wisata dengan pesan status
$_SESSION['delete_message'] = $message;
$_SESSION['delete_message_type'] = $message_type;
// Redirect ke halaman manajemen_paket.php yang ada di newadmin/
header("Location: ../newadmin/paket_wisata.php");
exit();

?>