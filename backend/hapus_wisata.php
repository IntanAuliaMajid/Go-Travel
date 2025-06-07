<?php
// File: ../backend/hapus_wisata.php

// Pastikan sesi dimulai jika Anda menggunakannya untuk pesan status atau autentikasi
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Sesuaikan path ke koneksi.php
require_once 'koneksi.php'; // Jika koneksi.php ada di direktori yang sama dengan hapus_wisata.php

// Define the base upload directory relative to the project root
// Assuming project root is where 'newadmin' and 'backend' folders are
$project_root_uploads_dir = '../newadmin/uploads/wisata/'; // Path dari root proyek ke folder uploads/wisata/

// Periksa apakah ID wisata diberikan melalui parameter GET
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['message'] = "ID Wisata tidak valid untuk dihapus.";
    $_SESSION['message_type'] = "error";
    header("Location: ../newadmin/kelola_wisata.php"); // Redirect kembali ke newadmin/kelola_wisata.php
    exit();
}

$id_wisata = (int)$_GET['id'];

// Mulai transaksi untuk memastikan integritas data
$conn->begin_transaction();

try {
    // --- 1. Ambil path gambar dan denah terlebih dahulu sebelum dihapus dari DB ---
    $gambar_paths_to_delete_db = []; // Paths as stored in DB (e.g., '../uploads/wisata/...')

    // Ambil gambar utama dari tabel `gambar`
    $stmt_get_images = $conn->prepare("SELECT url FROM gambar WHERE wisata_id = ?");
    if ($stmt_get_images) {
        $stmt_get_images->bind_param("i", $id_wisata);
        $stmt_get_images->execute();
        $result_images = $stmt_get_images->get_result();
        while ($row = $result_images->fetch_assoc()) {
            $gambar_paths_to_delete_db[] = $row['url'];
        }
        $stmt_get_images->close();
    } else {
        throw new Exception("Gagal mempersiapkan query gambar: " . $conn->error);
    }

    // Ambil path denah dari tabel `wisata`
    $stmt_get_denah = $conn->prepare("SELECT denah FROM wisata WHERE id_wisata = ?");
    if ($stmt_get_denah) {
        $stmt_get_denah->bind_param("i", $id_wisata);
        $stmt_get_denah->execute();
        $result_denah = $stmt_get_denah->get_result();
        if ($row = $result_denah->fetch_assoc()) {
            // Hanya tambahkan ke daftar hapus jika bukan path default placeholder
            // Path default harus konsisten dengan yang digunakan saat menyimpan (e.g., '../uploads/wisata/default_denah.png')
            $default_denah_in_db = '../uploads/wisata/default_denah.png'; // Pastikan ini sama dengan di `tambah_wisata.php`
            if (!empty($row['denah']) && $row['denah'] !== $default_denah_in_db) {
                $gambar_paths_to_delete_db[] = $row['denah'];
            }
        }
        $stmt_get_denah->close();
    } else {
        throw new Exception("Gagal mempersiapkan query denah: " . $conn->error);
    }

    // --- 2. Hapus data dari tabel `wisata` ---
    // Karena kita sudah mengubah ON DELETE CASCADE, ini akan otomatis menghapus dari `tips_berkunjung` dan `gambar`
    $stmt_delete_wisata = $conn->prepare("DELETE FROM wisata WHERE id_wisata = ?");
    if ($stmt_delete_wisata) {
        $stmt_delete_wisata->bind_param("i", $id_wisata);
        if (!$stmt_delete_wisata->execute()) {
            throw new Exception("Gagal menghapus data wisata dari database: " . $stmt_delete_wisata->error);
        }
        $stmt_delete_wisata->close();
    } else {
        throw new Exception("Gagal mempersiapkan statement hapus wisata: " . $conn->error);
    }

    // --- 3. Hapus file fisik dari server ---
    // Iterasi melalui path yang diambil dari DB dan ubah menjadi path absolut untuk penghapusan
    foreach ($gambar_paths_to_delete_db as $db_path) {
        // Asumsi path di DB adalah seperti '../uploads/wisata/file.png'
        // Kita perlu mengganti '../uploads/' menjadi '../newadmin/uploads/' untuk path fisik dari `backend/`
        $physical_path = str_replace('../uploads/', $project_root_uploads_dir, $db_path);

        if (file_exists($physical_path) && !is_dir($physical_path)) {
            if (!unlink($physical_path)) {
                error_log("Gagal menghapus file fisik: " . $physical_path);
                // Kita tidak akan throw Exception di sini karena DB sudah terhapus,
                // tapi ini penting untuk logging agar tahu ada file yang tidak terhapus.
            }
        } else {
            error_log("File fisik tidak ditemukan atau bukan file: " . $physical_path);
        }
    }

    $conn->commit();
    $_SESSION['message'] = "Data wisata dan file terkait berhasil dihapus.";
    $_SESSION['message_type'] = "success";

} catch (Exception $e) {
    $conn->rollback();
    $_SESSION['message'] = "Error saat menghapus wisata: " . $e->getMessage();
    $_SESSION['message_type'] = "error";
}

$conn->close();

// Redirect kembali ke halaman kelola wisata
header("Location: ../newadmin/wisata.php");
exit();
?>