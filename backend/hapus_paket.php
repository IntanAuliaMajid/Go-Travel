<?php
// Pastikan ini adalah baris pertama di file, tanpa spasi atau karakter di depannya.
session_start();

// --- Konfigurasi Koneksi Database ---
// SESUAIKAN PATH INI:
// Jika file koneksi.php berada satu folder di atas folder 'backend', gunakan '../koneksi.php'.
// Contoh: root/koneksi.php dan root/backend/delete_paket.php
require_once 'koneksi.php'; 

// --- Inisialisasi Pesan Status ---
$message = '';
$message_type = ''; // Digunakan untuk kelas CSS Bootstrap alert (misal: 'success', 'danger', 'warning')

// --- Proses Penghapusan Paket Wisata ---
// Memastikan bahwa 'id' diterima melalui URL (GET) dan nilainya adalah angka
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_paket_wisata = (int)$_GET['id']; // Casting ke integer untuk keamanan SQL Injection

    // Mulai transaksi database. Ini penting untuk menjaga integritas data.
    // Jika ada langkah yang gagal, semua perubahan akan dibatalkan (rollback).
    $conn->begin_transaction();

    try {
        // Prepared Statement: Amankan query DELETE dari SQL Injection
        $stmt = $conn->prepare("DELETE FROM paket_wisata WHERE id_paket_wisata = ?");

        if ($stmt) {
            // Mengikat parameter ID ke placeholder (?)
            // 'i' menunjukkan bahwa parameter adalah integer
            $stmt->bind_param("i", $id_paket_wisata);

            // Eksekusi prepared statement
            if ($stmt->execute()) {
                // Periksa apakah ada baris yang benar-benar terpengaruh (terhapus)
                if ($stmt->affected_rows > 0) {
                    $conn->commit(); // Jika berhasil, konfirmasi perubahan ke database
                    $message = "Paket wisata berhasil dihapus.";
                    $message_type = "success";
                } else {
                    // Jika 0 baris terpengaruh, ID tidak ditemukan di database
                    $conn->rollback(); // Batalkan transaksi
                    $message = "Paket wisata dengan ID **" . $id_paket_wisata . "** tidak ditemukan atau sudah dihapus.";
                    $message_type = "warning"; // Gunakan 'warning' untuk kondisi ini
                }
            } else {
                // Eksekusi statement gagal (misalnya karena foreign key constraint)
                $conn->rollback(); // Batalkan transaksi

                // Cek kode error MySQL untuk memberikan pesan yang lebih spesifik
                if ($conn->errno == 1451) { // Error code for foreign key constraint violation (ON DELETE RESTRICT)
                    $message = "Gagal menghapus paket wisata. Terdapat **pemesanan, gambar, atau data lain** yang masih terkait dengan paket ini. Harap hapus atau ubah data terkait terlebih dahulu.";
                } else {
                    // Pesan error umum jika bukan karena foreign key
                    $message = "Error saat menghapus paket wisata: " . $stmt->error;
                }
                $message_type = "danger"; // Menunjukkan kesalahan serius
            }
            $stmt->close(); // Tutup prepared statement
        } else {
            // Jika persiapan statement gagal (misal: kesalahan sintaks SQL)
            $conn->rollback();
            $message = "Error mempersiapkan statement: " . $conn->error;
            $message_type = "danger";
        }
    } catch (mysqli_sql_exception $e) {
        // Tangani pengecualian (exceptions) jika terjadi kesalahan fatal pada level database
        $conn->rollback();
        $message = "Terjadi kesalahan database: " . $e->getMessage();
        $message_type = "danger";
    }
} else {
    // Jika ID tidak valid atau tidak diberikan
    $message = "ID paket wisata tidak valid atau tidak ditemukan dalam permintaan.";
    $message_type = "danger";
}

$conn->close(); // Tutup koneksi database setelah semua operasi selesai

// --- Simpan Pesan Status dan Redirect ---
// Simpan pesan dan tipe pesan ke session agar bisa diambil di halaman berikutnya
$_SESSION['delete_message'] = $message;
$_SESSION['delete_message_type'] = $message_type;

// Redirect pengguna kembali ke halaman manajemen paket wisata.
// SESUAIKAN PATH INI agar mengarah ke file paket_wisata.php yang benar
// Contoh: Jika delete_paket.php ada di 'backend/' dan paket_wisata.php ada di 'newadmin/',
// maka '../newadmin/paket_wisata.php' adalah path yang tepat.
header("Location: ../newadmin/paket_wisata.php");
exit(); // Penting: Hentikan eksekusi script setelah redirect
?>