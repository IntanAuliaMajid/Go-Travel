<?php
session_start();
require_once 'koneksi.php'; // Sesuaikan path jika perlu

// Inisialisasi pesan
$_SESSION['success_message'] = '';
$_SESSION['error_message'] = '';

// 1. Validasi ID dari URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['error_message'] = "Akses tidak valid atau ID artikel tidak ditemukan.";
    header("Location: ../newadmin/blog.php"); // Ganti jika nama file manajemen Anda berbeda
    exit();
}

$article_id = (int)$_GET['id'];

try {
    // Mulai Transaksi Database untuk memastikan semua operasi berhasil atau gagal bersamaan
    $conn->begin_transaction();

    // Langkah 1: Ambil semua URL gambar yang terkait dengan artikel ini untuk dihapus dari server
    $stmt_select_images = $conn->prepare("SELECT url FROM gambar_artikel WHERE id_artikel = ?");
    $stmt_select_images->bind_param("i", $article_id);
    $stmt_select_images->execute();
    $result_images = $stmt_select_images->get_result();
    
    $image_urls = [];
    while ($row = $result_images->fetch_assoc()) {
        $image_urls[] = $row['url'];
    }
    $stmt_select_images->close();

    // Langkah 2: Hapus file gambar fisik dari server
    if (!empty($image_urls)) {
        // Sesuaikan '/gotravel/' dengan path root proyek Anda di server jika berbeda
        $base_path_on_server = $_SERVER['DOCUMENT_ROOT'] . '/gotravel/'; 
        $base_url_to_replace = 'http://' . $_SERVER['HTTP_HOST'] . '/gotravel/';

        foreach ($image_urls as $url) {
            $file_path = str_replace($base_url_to_replace, $base_path_on_server, $url);
            if (file_exists($file_path)) {
                unlink($file_path); // Hapus file
            }
        }
    }

    // Langkah 3: Hapus record dari tabel `gambar_artikel` (tabel anak) TERLEBIH DAHULU
    $stmt_delete_images_db = $conn->prepare("DELETE FROM gambar_artikel WHERE id_artikel = ?");
    $stmt_delete_images_db->bind_param("i", $article_id);
    $stmt_delete_images_db->execute();
    $stmt_delete_images_db->close();

    // Langkah 4: Hapus record dari tabel `artikel` (tabel induk)
    $stmt_delete_article = $conn->prepare("DELETE FROM artikel WHERE id_artikel = ?");
    $stmt_delete_article->bind_param("i", $article_id);
    $stmt_delete_article->execute();
    
    // Periksa apakah artikelnya sendiri berhasil dihapus
    if ($stmt_delete_article->affected_rows > 0) {
        // Jika berhasil, simpan semua perubahan
        $conn->commit();
        $_SESSION['success_message'] = "Artikel dan semua gambar terkait berhasil dihapus.";
    } else {
        // Jika artikel tidak ditemukan, lempar error untuk membatalkan transaksi
        throw new Exception("Artikel dengan ID " . $article_id . " tidak ditemukan.");
    }
    $stmt_delete_article->close();

} catch (Exception $e) {
    // Jika terjadi error di salah satu langkah, batalkan semua perubahan
    $conn->rollback();
    $_SESSION['error_message'] = "Terjadi kesalahan: " . $e->getMessage();
} finally {
    // Tutup koneksi dan redirect kembali ke halaman manajemen
    $conn->close();
    header("Location: ../newadmin/blog.php"); // Ganti jika nama file manajemen Anda berbeda
    exit();
}
?>