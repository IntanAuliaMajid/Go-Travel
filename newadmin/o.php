<?php
session_start();
require_once '../backend/koneksi.php';

// DEFINISIKAN PATH UPLOAD
define('UPLOAD_DIR_BASE', __DIR__ . '/../uploads/');
define('UPLOAD_DIR_PAKET', UPLOAD_DIR_BASE . 'paket/');
define('UPLOAD_DIR_DENAH', UPLOAD_DIR_BASE . 'denah/');

// URL untuk akses browser
define('UPLOAD_URL_PAKET', '../uploads/paket/');
define('UPLOAD_URL_DENAH', '../uploads/denah/');

// Buat folder jika belum ada
if (!is_dir(UPLOAD_DIR_PAKET)) mkdir(UPLOAD_DIR_PAKET, 0775, true);
if (!is_dir(UPLOAD_DIR_DENAH)) mkdir(UPLOAD_DIR_DENAH, 0775, true);

// Helper function untuk menghitung jumlah malam
function getJumlahMalam($durasi_text) {
    preg_match('/(\d+)/', $durasi_text, $matches);
    return isset($matches[1]) ? max(0, (int)$matches[1] - 1) : 0;
}

// Fungsi untuk menangani upload file gambar
function handleFileUpload($file_input_name, $id_entity, $upload_dir_abs, $prefix = 'file_') {
    $uploaded_file_name = '';
    if (isset($_FILES[$file_input_name]) && $_FILES[$file_input_name]['error'] == UPLOAD_ERR_OK) {
        $file_tmp_name = $_FILES[$file_input_name]['tmp_name'];
        $file_name_original = $_FILES[$file_input_name]['name'];
        $file_size = $_FILES[$file_input_name]['size'];
        $file_ext = strtolower(pathinfo($file_name_original, PATHINFO_EXTENSION));

        $new_file_name = $prefix . $id_entity . '_' . uniqid() . '.' . $file_ext;
        $target_file_abs = $upload_dir_abs . $new_file_name;

        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (!in_array($file_ext, $allowed_extensions)) {
            throw new Exception("Format file tidak diizinkan. Hanya JPG, PNG, GIF, WebP.");
        }
        if ($file_size > 2 * 1024 * 1024) {
            throw new Exception("Ukuran file terlalu besar (maks 2MB).");
        }

        if (move_uploaded_file($file_tmp_name, $target_file_abs)) {
            $uploaded_file_name = $new_file_name;
        } else {
            throw new Exception("Gagal memindahkan file.");
        }
    }
    return $uploaded_file_name;
}

// --- 1. GET THE PACKAGE ID ---
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: kelola_paket.php");
    exit();
}
$id_paket_wisata = $_GET['id'];

// --- Helper function untuk menghitung jumlah malam ---
function getJumlahMalam($durasi_text) {
    preg_match('/(\d+)/', $durasi_text, $matches);
    return isset($matches[1]) ? max(0, (int)$matches[1] - 1) : 0;
}


// Fungsi untuk menangani upload file gambar
// Catatan: Fungsi ini sekarang akan mengembalikan NAMA FILE saja (bukan path lengkap)
function handleFileUpload($file_input_name, $id_entity, $upload_dir_abs, $prefix = 'file_') {
    $uploaded_file_name = ''; // Default empty
    if (isset($_FILES[$file_input_name]) && $_FILES[$file_input_name]['error'] == UPLOAD_ERR_OK) {
        $file_tmp_name = $_FILES[$file_input_name]['tmp_name'];
        $file_name_original = $_FILES[$file_input_name]['name'];
        $file_size = $_FILES[$file_input_name]['size'];
        $file_ext = strtolower(pathinfo($file_name_original, PATHINFO_EXTENSION));

        $new_file_name = $prefix . $id_entity . '_' . uniqid() . '.' . $file_ext;
        $target_file_abs = $upload_dir_abs . $new_file_name;

        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp']; // Tambahkan webp
        if (!in_array($file_ext, $allowed_extensions)) {
            throw new Exception("Format file " . htmlspecialchars($file_name_original) . " tidak diizinkan. Hanya JPG, PNG, GIF, WebP.");
        }
        if ($file_size > 2 * 1024 * 1024) { // 2MB
            throw new Exception("Ukuran file " . htmlspecialchars($file_name_original) . " terlalu besar (maks 2MB).");
        }

        if (move_uploaded_file($file_tmp_name, $target_file_abs)) {
            $uploaded_file_name = $new_file_name; // Mengembalikan nama file saja
        } else {
            $upload_error_code = $_FILES[$file_input_name]['error'];
            $error_details = 'Kesalahan saat upload: ';
            switch ($upload_error_code) {
                case UPLOAD_ERR_INI_SIZE: $error_details .= 'Ukuran melebihi php.ini.'; break;
                case UPLOAD_ERR_FORM_SIZE: $error_details .= 'Ukuran melebihi MAX_FILE_SIZE HTML.'; break;
                case UPLOAD_ERR_PARTIAL: $error_details .= 'File hanya terunggah sebagian.'; break;
                case UPLOAD_ERR_NO_FILE: $error_details .= 'Tidak ada file dipilih.'; break;
                case UPLOAD_ERR_NO_TMP_DIR: $error_details .= 'Folder temp tidak ada.'; break;
                case UPLOAD_ERR_CANT_WRITE: $error_details .= 'Gagal menulis file ke disk (izin?).'; break;
                case UPLOAD_ERR_EXTENSION: $error_details .= 'Ekstensi PHP menghentikan upload.'; break;
                default: $error_details .= 'Tidak diketahui.'; break;
            }
            throw new Exception("Gagal memindahkan file " . htmlspecialchars($file_name_original) . ": " . $error_details);
        }
    } else if (isset($_FILES[$file_input_name]) && $_FILES[$file_input_name]['error'] !== UPLOAD_ERR_NO_FILE) {
        // Tangani error lain selain 'tidak ada file'
        $upload_error_code = $_FILES[$file_input_name]['error'];
        $error_details = 'Terjadi error umum saat upload: ';
        switch ($upload_error_code) {
            case UPLOAD_ERR_INI_SIZE: $error_details .= 'Ukuran melebihi php.ini.'; break;
            case UPLOAD_ERR_FORM_SIZE: $error_details .= 'Ukuran melebihi MAX_FILE_SIZE HTML.'; break;
            case UPLOAD_ERR_PARTIAL: $error_details .= 'File hanya terunggah sebagian.'; break;
            case UPLOAD_ERR_NO_TMP_DIR: $error_details .= 'Folder temp tidak ada.'; break;
            case UPLOAD_ERR_CANT_WRITE: $error_details .= 'Gagal menulis file ke disk (izin?).'; break;
            case UPLOAD_ERR_EXTENSION: $error_details .= 'Ekstensi PHP menghentikan upload.'; break;
            default: $error_details .= 'Tidak diketahui.'; break;
        }
        throw new Exception("Error upload " . htmlspecialchars($file_name_original ?? 'file') . ": " . $error_details);
    }
    return $uploaded_file_name;
}


// --- 2. HANDLE FORM SUBMISSIONS ---

// Handle Deletion of an Image
if (isset($_POST['delete_gambar'])) {
    $id_gambar_paket = $_POST['id_gambar_paket'];
    $url_gambar_hapus = $_POST['url_gambar']; // Ini adalah nama file (e.g., 'paket_1_uniqueid.jpg')

    $conn->begin_transaction();
    try {
        $stmt = $conn->prepare("DELETE FROM gambar_paket WHERE id_gambar_paket = ?");
        if (!$stmt) {
            throw new Exception("Gagal mempersiapkan statement delete gambar: " . $conn->error);
        }
        $stmt->bind_param("i", $id_gambar_paket);
        if ($stmt->execute()) {
            // Hapus file fisik
            $physical_file_path = UPLOAD_DIR_PAKET . $url_gambar_hapus;
            if (!empty($url_gambar_hapus) && file_exists($physical_file_path) && !is_dir($physical_file_path)) {
                if (!unlink($physical_file_path)) {
                    error_log("Gagal menghapus file fisik: " . $physical_file_path);
                }
            }
            $_SESSION['success_message'] = "Gambar berhasil dihapus.";
        } else {
            throw new Exception("Gagal menghapus gambar dari database: " . $stmt->error);
        }
        $stmt->close();
        $conn->commit();
    } catch (Exception $e) {
        $conn->rollback();
        $_SESSION['error_message'] = "Error menghapus gambar: " . $e->getMessage();
    }
    header("Location: edit_paket.php?id=" . $id_paket_wisata);
    exit();
}

// Handle Adding a New Image
if (isset($_POST['add_gambar'])) {
    try {
        $caption = $_POST['caption_gambar'];
        // Panggil handleFileUpload, yang sekarang mengembalikan NAMA FILE saja
        $uploaded_file_name = handleFileUpload('gambar_file', $id_paket_wisata, UPLOAD_DIR_PAKET, 'paket_');

        if (!empty($uploaded_file_name)) {
            // Simpan HANYA NAMA FILE ke database, karena UPLOAD_URL_PAKET akan ditambahkan saat display
            $stmt = $conn->prepare("INSERT INTO gambar_paket (id_paket_wisata, url_gambar, caption_gambar) VALUES (?, ?, ?)");
            if (!$stmt) {
                throw new Exception("Gagal mempersiapkan statement insert gambar: " . $conn->error);
            }
            $stmt->bind_param("iss", $id_paket_wisata, $uploaded_file_name, $caption); // Simpan nama file saja
            if ($stmt->execute()) {
                $_SESSION['success_message'] = "Gambar berhasil di-upload dan disimpan ke database.";
            } else {
                // Jika gagal insert ke DB, hapus file yang sudah terupload
                unlink(UPLOAD_DIR_PAKET . $uploaded_file_name);
                throw new Exception("Gagal menyimpan data gambar ke database: " . $stmt->error);
            }
            $stmt->close();
        } else {
            // Ini akan ter-throw jika handleFileUpload menemukan masalah tapi tidak ada error UPLOAD_ERR_NO_FILE
            // atau jika tidak ada file yang dipilih (UPLOAD_ERR_NO_FILE), tapi kita ingin error message yang lebih spesifik
            // jika tidak ada file dipilih, harusnya itu dari input form.
            if (!isset($_FILES['gambar_file']) || $_FILES['gambar_file']['error'] == UPLOAD_ERR_NO_FILE) {
                 $_SESSION['error_message'] = "Tidak ada file gambar yang dipilih untuk diunggah.";
            } else {
                // Ini akan menangkap exception dari handleFileUpload
                throw new Exception("Terjadi error tidak terduga saat upload gambar.");
            }
        }
    } catch (Exception $e) {
        $_SESSION['error_message'] = $e->getMessage();
    }
    header("Location: edit_paket.php?id=" . $id_paket_wisata);
    exit();
}


// Handle Deletion of an Inclusion Item
if (isset($_POST['delete_termasuk'])) {
    $id_termasuk_paket = $_POST['id_termasuk_paket'];
    $stmt = $conn->prepare("DELETE FROM termasuk_paket WHERE id_termasuk_paket = ?");
    $stmt->bind_param("i", $id_termasuk_paket);
    if($stmt->execute()){ $_SESSION['success_message'] = "Item 'termasuk paket' berhasil dihapus."; } else { $_SESSION['error_message'] = "Gagal menghapus item."; }
    $stmt->close();
    header("Location: edit_paket.php?id=" . $id_paket_wisata);
    exit();
}

// Handle Deletion of an Itinerary Item
if (isset($_POST['delete_rencana'])) {
    $id_rencana_perjalanan = $_POST['id_rencana_perjalanan'];
    $stmt = $conn->prepare("DELETE FROM rencana_perjalanan WHERE id_rencana_perjalanan = ?");
    $stmt->bind_param("i", $id_rencana_perjalanan);
    if($stmt->execute()){ $_SESSION['success_message'] = "Langkah rencana perjalanan berhasil dihapus."; } else { $_SESSION['error_message'] = "Gagal menghapus rencana perjalanan."; }
    $stmt->close();
    header("Location: edit_paket.php?id=" . $id_paket_wisata);
    exit();
}

// Handle Adding a New Inclusion
if (isset($_POST['add_termasuk'])) {
    $termasuk = $_POST['termasuk_deskripsi'];
    $harga_komponen = $_POST['termasuk_harga'];
    $stmt = $conn->prepare("INSERT INTO termasuk_paket (termasuk, harga_komponen, id_paket) VALUES (?, ?, ?)");
    $stmt->bind_param("sdi", $termasuk, $harga_komponen, $id_paket_wisata);
    if($stmt->execute()){ $_SESSION['success_message'] = "Item 'termasuk paket' berhasil ditambahkan."; } else { $_SESSION['error_message'] = "Gagal menambahkan item."; }
    $stmt->close();
    header("Location: edit_paket.php?id=" . $id_paket_wisata);
    exit();
}

// Handle Adding a New Itinerary
if (isset($_POST['add_rencana'])) {
    $hari = $_POST['rencana_hari'];
    $jam = $_POST['rencana_jam'];
    $perjalanan = $_POST['rencana_perjalanan'];
    $deskripsi_perjalanan = $_POST['rencana_deskripsi'];
    $stmt = $conn->prepare("INSERT INTO rencana_perjalanan (hari, jam, perjalanan, deskripsi_perjalanan, id_paket) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("isssi", $hari, $jam, $perjalanan, $deskripsi_perjalanan, $id_paket_wisata);
    if($stmt->execute()){ $_SESSION['success_message'] = "Langkah rencana perjalanan berhasil ditambahkan."; } else { $_SESSION['error_message'] = "Gagal menambahkan rencana perjalanan."; }
    $stmt->close();
    header("Location: edit_paket.php?id=" . $id_paket_wisata);
    exit();
}

// Handle Update Main Package Data - MODIFIKASI UNTUK AKOMODASI OTOMATIS
if (isset($_POST['update_paket'])) {
    $conn->begin_transaction();
    try {
        // Ambil semua data dari form
        $nama_paket = $_POST['nama_paket'];
        $id_wisata = !empty($_POST['id_wisata']) ? $_POST['id_wisata'] : NULL;
        $id_jenis_paket = !empty($_POST['id_jenis_paket']) ? $_POST['id_jenis_paket'] : NULL;
        $id_wilayah = !empty($_POST['id_wilayah']) ? $_POST['id_wilayah'] : NULL;
        $durasi_paket = $_POST['durasi_paket'];
        $harga = $_POST['harga'];
        $deskripsi = $_POST['deskripsi'];
        $info_penting = !empty($_POST['info_penting']) ? $_POST['info_penting'] : NULL;
        $id_pemandu_wisata = !empty($_POST['id_pemandu_wisata']) ? $_POST['id_pemandu_wisata'] : NULL;
        $id_kendaraan = !empty($_POST['id_kendaraan']) ? $_POST['id_kendaraan'] : NULL;
        $id_akomodasi_kuliner = !empty($_POST['id_akomodasi_kuliner']) ? $_POST['id_akomodasi_kuliner'] : NULL;
        $id_akomodasi_penginapan = !empty($_POST['id_akomodasi_penginapan']) ? $_POST['id_akomodasi_penginapan'] : NULL;

        // --- LOGIKA BARU UNTUK DENAH LOKASI ---
        $denah_lokasi_final = $_POST['denah_lokasi_current']; // Nilai denah yang tersimpan saat ini
        $denah_type = $_POST['denah_type'];
        
        // Update main package data
        $sql_update = "UPDATE paket_wisata SET nama_paket=?, id_wisata=?, id_jenis_paket=?, id_wilayah=?, durasi_paket=?, harga=?, deskripsi=?, denah_lokasi=?, info_penting=?, id_pemandu_wisata=?, id_kendaraan=?, id_akomodasi_kuliner=?, id_akomodasi_penginapan=? WHERE id_paket_wisata=?";
        $stmt_main = $conn->prepare($sql_update);
        $stmt_main->bind_param("siiisdsssiiiii",
            $nama_paket, $id_wisata, $id_jenis_paket, $id_wilayah, $durasi_paket, $harga,
            $deskripsi, $denah_lokasi_final, $info_penting, $id_pemandu_wisata,
            $id_kendaraan, $id_akomodasi_kuliner, $id_akomodasi_penginapan, $id_paket_wisata
        );
        $stmt_main->execute();
        $stmt_main->close();

        // LOGIKA UNTUK OTOMATIS MASUKKAN AKOMODASI KE PAKET TERMASUK
        // 1. Otomatis untuk Pemandu Wisata
        $stmt_cek = $conn->prepare("SELECT id_termasuk_paket FROM termasuk_paket WHERE id_paket = ? AND termasuk LIKE 'Jasa Pemandu%'");
        $stmt_cek->bind_param("i", $id_paket_wisata); 
        $stmt_cek->execute(); 
        $result_cek = $stmt_cek->get_result(); 
        $existing_pemandu_item = $result_cek->fetch_assoc(); 
        $stmt_cek->close();
        
        if ($id_pemandu_wisata) {
            $stmt_pemandu = $conn->prepare("SELECT nama_pemandu, harga FROM pemandu_wisata WHERE id_pemandu_wisata = ?");
            $stmt_pemandu->bind_param("i", $id_pemandu_wisata); 
            $stmt_pemandu->execute(); 
            $pemandu_data = $stmt_pemandu->get_result()->fetch_assoc(); 
            $stmt_pemandu->close();
            
            $pemandu_deskripsi = "Jasa Pemandu (" . $pemandu_data['nama_pemandu'] . ")"; 
            $pemandu_harga = $pemandu_data['harga'];
            
            if ($existing_pemandu_item) { 
                $stmt_update = $conn->prepare("UPDATE termasuk_paket SET termasuk = ?, harga_komponen = ? WHERE id_termasuk_paket = ?"); 
                $stmt_update->bind_param("sdi", $pemandu_deskripsi, $pemandu_harga, $existing_pemandu_item['id_termasuk_paket']); 
                $stmt_update->execute(); 
                $stmt_update->close();
            } else { 
                $stmt_insert = $conn->prepare("INSERT INTO termasuk_paket (termasuk, harga_komponen, id_paket) VALUES (?, ?, ?)"); 
                $stmt_insert->bind_param("sdi", $pemandu_deskripsi, $pemandu_harga, $id_paket_wisata); 
                $stmt_insert->execute(); 
                $stmt_insert->close(); 
            }
        } else { 
            if ($existing_pemandu_item) { 
                $stmt_delete = $conn->prepare("DELETE FROM termasuk_paket WHERE id_termasuk_paket = ?"); 
                $stmt_delete->bind_param("i", $existing_pemandu_item['id_termasuk_paket']); 
                $stmt_delete->execute(); 
                $stmt_delete->close(); 
            } 
        }

        // 2. Otomatis untuk Akomodasi Penginapan
        $stmt_cek_penginapan = $conn->prepare("SELECT id_termasuk_paket FROM termasuk_paket WHERE id_paket = ? AND (termasuk LIKE 'Penginapan%' OR termasuk LIKE 'Akomodasi%')");
        $stmt_cek_penginapan->bind_param("i", $id_paket_wisata); 
        $stmt_cek_penginapan->execute(); 
        $result_cek_penginapan = $stmt_cek_penginapan->get_result(); 
        $existing_penginapan_item = $result_cek_penginapan->fetch_assoc(); 
        $stmt_cek_penginapan->close();
        
        $jumlah_malam = getJumlahMalam($durasi_paket);
        
        if ($id_akomodasi_penginapan && $jumlah_malam > 0) {
            $stmt_penginapan = $conn->prepare("SELECT nama_penginapan, harga_per_malam FROM akomodasi_penginapan WHERE id_akomodasi_penginapan = ?");
            $stmt_penginapan->bind_param("i", $id_akomodasi_penginapan); 
            $stmt_penginapan->execute(); 
            $penginapan_data = $stmt_penginapan->get_result()->fetch_assoc(); 
            $stmt_penginapan->close();
            
            $total_harga_penginapan = $jumlah_malam * $penginapan_data['harga_per_malam']; 
            $penginapan_deskripsi = "Penginapan " . $jumlah_malam . " Malam (" . $penginapan_data['nama_penginapan'] . ")";
            
            if ($existing_penginapan_item) { 
                $stmt_update = $conn->prepare("UPDATE termasuk_paket SET termasuk = ?, harga_komponen = ? WHERE id_termasuk_paket = ?"); 
                $stmt_update->bind_param("sdi", $penginapan_deskripsi, $total_harga_penginapan, $existing_penginapan_item['id_termasuk_paket']); 
                $stmt_update->execute(); 
                $stmt_update->close();
            } else { 
                $stmt_insert = $conn->prepare("INSERT INTO termasuk_paket (termasuk, harga_komponen, id_paket) VALUES (?, ?, ?)"); 
                $stmt_insert->bind_param("sdi", $penginapan_deskripsi, $total_harga_penginapan, $id_paket_wisata); 
                $stmt_insert->execute(); 
                $stmt_insert->close(); 
            }
        } else { 
            if ($existing_penginapan_item) { 
                $stmt_delete = $conn->prepare("DELETE FROM termasuk_paket WHERE id_termasuk_paket = ?"); 
                $stmt_delete->bind_param("i", $existing_penginapan_item['id_termasuk_paket']); 
                $stmt_delete->execute(); 
                $stmt_delete->close(); 
            } 
        }

        $conn->commit();
        $_SESSION['success_message'] = "Data paket wisata berhasil diperbarui!";

    } catch (Exception $e) {
        $conn->rollback();
        $_SESSION['error_message'] = "Gagal memperbarui data: " . $e->getMessage();
    }
    header("Location: edit_paket.php?id=" . $id_paket_wisata);
    exit();
}

// --- 3. FETCH ALL DATA FOR DISPLAY ---
$stmt = $conn->prepare("SELECT * FROM paket_wisata WHERE id_paket_wisata = ?");
$stmt->bind_param("i", $id_paket_wisata);
$stmt->execute();
$paket = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$paket) { echo "Paket tidak ditemukan."; exit(); }

function fetchData($conn, $sql) { 
    $result = $conn->query($sql); 
    $data = []; 
    if ($result) { 
        while ($row = $result->fetch_assoc()) { 
            $data[] = $row; 
        } 
    } 
    return $data; 
}

$wisata_list = fetchData($conn, "SELECT id_wisata, nama_wisata FROM wisata ORDER BY nama_wisata ASC");
$jenis_paket_list = fetchData($conn, "SELECT id_jenis_paket, jenis_paket FROM jenis_paket ORDER BY jenis_paket ASC");
$wilayah_list = fetchData($conn, "SELECT id_wilayah, nama_wilayah FROM wilayah ORDER BY nama_wilayah ASC");
$pemandu_list = fetchData($conn, "SELECT id_pemandu_wisata, nama_pemandu, harga FROM pemandu_wisata ORDER BY nama_pemandu ASC");
$kendaraan_list = fetchData($conn, "SELECT id_kendaraan, jenis_kendaraan FROM kendaraan ORDER BY jenis_kendaraan ASC");
$kuliner_list = fetchData($conn, "SELECT id_akomodasi_kuliner, nama_restaurant FROM akomodasi_kuliner ORDER BY nama_restaurant ASC");
$penginapan_list = fetchData($conn, "SELECT id_akomodasi_penginapan, nama_penginapan, harga_per_malam FROM akomodasi_penginapan ORDER BY nama_penginapan ASC");
$termasuk_list = fetchData($conn, "SELECT * FROM termasuk_paket WHERE id_paket = $id_paket_wisata ORDER BY id_termasuk_paket ASC");
$rencana_list = fetchData($conn, "SELECT * FROM rencana_perjalanan WHERE id_paket = $id_paket_wisata ORDER BY hari, jam ASC");
$gambar_list = fetchData($conn, "SELECT * FROM gambar_paket WHERE id_paket_wisata = $id_paket_wisata ORDER BY id_gambar_paket ASC");

function format_rupiah($number) { 
    return "Rp " . number_format($number, 0, ',', '.'); 
}

$success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : null;
$error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : null;
unset($_SESSION['success_message'], $_SESSION['error_message']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Edit Paket Wisata</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root { --primary-color: #3498db; --success-color: #27ae60; --danger-color: #e74c3c; --warning-color: #f39c12; --light-bg: #f4f6f9; --white-bg: #ffffff; --dark-text: #2c3e50; --light-text: #6c757d; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: var(--light-bg); color: #333; }
        .main-content { margin-left: 220px; padding: 25px; }
        .page-header { background: var(--white-bg); padding: 20px 25px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-bottom: 25px; display: flex; justify-content: space-between; align-items: center; }
        .page-title { color: var(--dark-text); font-size: 1.7rem; font-weight: 600; }
        .page-title i { margin-right: 10px; color: var(--primary-color); }
        .btn-secondary-header { background-color: var(--light-text); color: white; padding: 10px 20px; border-radius: 6px; text-decoration: none; display: inline-flex; align-items: center; font-weight: 500; transition: background-color 0.2s; }
        .btn-secondary-header:hover { background-color: #5a6268; }
        .btn-secondary-header i { margin-right: 8px; }
        .card { background: var(--white-bg); border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-bottom: 25px; overflow: hidden; }
        .card-header { padding: 15px 20px; background-color: #f8f9fa; border-bottom: 1px solid #e9ecef; font-size: 1.1rem; font-weight: 600; color: var(--dark-text); }
        .card-header i { margin-right: 10px; }
        .card-body { padding: 20px; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .form-group { display: flex; flex-direction: column; }
        .form-group.full-width { grid-column: 1 / -1; }
        .form-group label { margin-bottom: 8px; font-weight: 600; color: #495057; }
        .form-control { width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 5px; transition: border-color 0.2s, box-shadow 0.2s; }
        .form-control:focus { border-color: var(--primary-color); outline: none; box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2); }
        textarea.form-control { min-height: 120px; resize: vertical; }
        .form-actions { margin-top: 25px; text-align: right; }
        .btn-submit { background-color: var(--success-color); color: white; padding: 12px 25px; border: none; border-radius: 6px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: background-color 0.2s; }
        .btn-submit:hover { background-color: #229954; }
        .btn-submit i { margin-right: 8px; }
        .alert { padding: 15px; margin-bottom: 20px; border-radius: 6px; }
        .alert-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-danger { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #e9ecef; vertical-align: middle; }
        thead th { background-color: #e9ecef; font-weight: 600; }
        .action-buttons { display: flex; gap: 10px; align-items: center; }
        .action-buttons form { display: inline; }
        .btn-edit, .btn-delete { background: none; border: none; cursor: pointer; font-size: 1.1rem; }
        .btn-edit { color: var(--warning-color); }
        .btn-delete { color: var(--danger-color); }
        .btn-delete:disabled { color: #ccc; cursor: not-allowed; }
        .details-form { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px; align-items: flex-end; border-top: 1px solid #e9ecef; padding-top: 20px; margin-top: 20px; }
        .btn-add, .btn-update, .btn-cancel { border: none; padding: 10px 15px; border-radius: 5px; cursor: pointer; color: white; display: inline-flex; align-items: center; gap: 5px; }
        .btn-add { background-color: var(--primary-color); }
        .btn-update { background-color: var(--success-color); }
        .btn-cancel { background-color: var(--light-text); }
        .harga-display { margin-top: 8px; font-size: 0.9rem; font-weight: 600; color: var(--success-color); height: 1.2em; }
        .auto-managed-item { color: var(--light-text); font-style: italic; font-size: 0.85rem; margin-left: 5px;}
        .image-gallery { display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 15px; margin-bottom: 20px;}
        .image-card { border: 1px solid #e9ecef; border-radius: 8px; overflow: hidden; position: relative; }
        .image-card img { width: 100%; height: 120px; object-fit: cover; display: block; }
        .image-card-caption { padding: 8px; font-size: 0.85rem; background: #f8f9fa; text-align: center; }
        .image-card-delete { position: absolute; top: 5px; right: 5px; }
        .image-card-delete .btn-delete { background-color: rgba(255, 255, 255, 0.7); border-radius: 50%; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; font-size: 0.9rem; }
        .denah-preview { margin-top: 15px; border: 2px dashed #ddd; padding: 10px; min-height: 150px; display: flex; align-items: center; justify-content: center; text-align: center; border-radius: 8px; background-color: #f8f9fa; }
        .denah-preview img { max-width: 100%; max-height: 300px; border-radius: 5px; }
        .denah-preview iframe { max-width: 100%; border-radius: 5px; border: 1px solid #ccc; }
        .radio-group { display: flex; gap: 20px; margin-bottom: 15px; flex-wrap: wrap;}
        .radio-group label { font-weight: normal; display: flex; align-items: center; gap: 5px; cursor: pointer; }
    </style>
</head>
<body>
    <?php include '../komponen/sidebar_admin.php'; ?>

    <main class="main-content">
        <div class="page-header">
            <h1 class="page-title"><i class="fas fa-edit"></i> Edit Paket Wisata</h1>
            <a href="paket_wisata.php" class="btn-secondary-header"><i class="fas fa-arrow-left"></i> Kembali</a>
        </div>

        <?php if ($success_message): ?> <div class="alert alert-success"><?php echo htmlspecialchars($success_message); ?></div> <?php endif; ?>
        <?php if ($error_message): ?> <div class="alert alert-danger"><?php echo htmlspecialchars($error_message); ?></div> <?php endif; ?>

        <form action="edit_paket.php?id=<?php echo $id_paket_wisata; ?>" method="POST" enctype="multipart/form-data">
            <div class="card">
                <div class="card-header"><i class="fas fa-info-circle"></i> Data Utama Paket</div>
                <div class="card-body">
                    <input type="hidden" name="update_paket" value="1">
                    <div class="form-grid">
                        <!-- [Form input tetap sama] -->
                        
                        <!-- TAMBAH ELEMENT UNTUK MENAMPILKAN HARGA AKOMODASI -->
                        <div class="form-group">
                            <label for="id_akomodasi_penginapan">Akomodasi Penginapan</label>
                            <select id="id_akomodasi_penginapan" name="id_akomodasi_penginapan" class="form-control">
                                <option value="" data-harga-per-malam="0">-- Tidak Ada Penginapan --</option>
                                <?php foreach($penginapan_list as $item): ?>
                                <option value="<?php echo $item['id_akomodasi_penginapan']; ?>" 
                                        data-harga-per-malam="<?php echo $item['harga_per_malam']; ?>"
                                        <?php if ($item['id_akomodasi_penginapan'] == $paket['id_akomodasi_penginapan']) echo 'selected'; ?>>
                                    <?php echo htmlspecialchars($item['nama_penginapan']); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                            <small id="harga_penginapan_display" class="harga-display"></small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- [Bagian denah lokasi tetap sama] -->

            <div class="form-actions" style="background-color: var(--white-bg); padding: 20px; border-radius: 8px; text-align:center; margin-top: -10px;">
                <button type="submit" class="btn-submit"><i class="fas fa-sync-alt"></i> SIMPAN SEMUA PERUBAHAN</button>
            </div>
        </form>

        <!-- [Bagian gallery gambar tetap sama] -->

        <div class="card">
            <div class="card-header"><i class="fas fa-check-circle"></i> Kelola "Paket Termasuk"</div>
            <div class="card-body">
                <table>
                    <thead><tr><th>Deskripsi</th><th>Harga Komponen</th><th style="width: 50px;">Aksi</th></tr></thead>
                    <tbody>
                        <?php if(!empty($termasuk_list)): ?>
                            <?php foreach($termasuk_list as $item):
                                // Tandai item yang di-generate otomatis
                                $is_auto_item = (
                                    strpos($item['termasuk'], 'Jasa Pemandu') === 0 || 
                                    strpos($item['termasuk'], 'Penginapan') === 0
                                );
                            ?>
                            <tr>
                                <td>
                                    <?php echo htmlspecialchars($item['termasuk']); ?>
                                    <?php if($is_auto_item): ?>
                                        <span class="auto-managed-item">(Otomatis)</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo format_rupiah($item['harga_komponen']); ?></td>
                                <td class="action-buttons">
                                    <form action="edit_paket.php?id=<?php echo $id_paket_wisata; ?>" method="POST" onsubmit="return confirm('Yakin ingin menghapus item ini?');">
                                        <input type="hidden" name="id_termasuk_paket" value="<?php echo $item['id_termasuk_paket']; ?>">
                                        <button type="submit" name="delete_termasuk" class="btn-delete" 
                                            <?php if($is_auto_item) echo 'disabled title="Dikelola otomatis dari Data Utama Paket"'; ?>>
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="3" style="text-align:center;">Belum ada item.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <!-- [Form tambah item termasuk tetap sama] -->
            </div>
        </div>

        <!-- [Bagian rencana perjalanan tetap sama] -->
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ... (kode JavaScript sebelumnya)
            
            // TAMBAH FUNGSI UNTUK MENGHITUNG HARGA PENGINAPAN
            const penginapanSelect = document.getElementById('id_akomodasi_penginapan');
            const hargaPenginapanDisplay = document.getElementById('harga_penginapan_display');
            const durasiInput = document.getElementById('durasi_paket');

            function updateHargaPenginapan() {
                const selectedOption = penginapanSelect.options[penginapanSelect.selectedIndex];
                const hargaPerMalam = parseFloat(selectedOption.getAttribute('data-harga-per-malam'));
                const durasiText = durasiInput.value;
                const match = durasiText.match(/(\d+)/);
                let jumlahMalam = 0;
                
                if (match) {
                    const hari = parseInt(match[1], 10);
                    jumlahMalam = Math.max(0, hari - 1);
                }
                
                if (hargaPerMalam > 0 && jumlahMalam > 0) {
                    const totalHarga = jumlahMalam * hargaPerMalam;
                    hargaPenginapanDisplay.textContent = `Total: ${formatRupiah(totalHarga)} (${jumlahMalam} malam)`;
                } else {
                    hargaPenginapanDisplay.textContent = '';
                }
            }

            if(penginapanSelect) {
                updateHargaPenginapan();
                penginapanSelect.addEventListener('change', updateHargaPenginapan);
                durasiInput.addEventListener('input', updateHargaPenginapan);
            }
            
            function formatRupiah(number) {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                }).format(number);
            }
        });
    </script>
</body>
</html>