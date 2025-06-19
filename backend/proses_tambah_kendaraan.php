<?php
session_start();
require_once '../backend/koneksi.php'; // Sesuaikan path ke file koneksi Anda

// Cek apakah form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 1. Validasi Input
    if (empty(trim($_POST['jenis_kendaraan']))) {
        $_SESSION['error_message'] = "Jenis kendaraan tidak boleh kosong.";
        header("Location: tambah_kendaraan.php");
        exit();
    }
    
    if (!isset($_FILES['gambar']) || $_FILES['gambar']['error'] != UPLOAD_ERR_OK) {
        $_SESSION['error_message'] = "Silakan pilih file gambar untuk diunggah.";
        header("Location: tambah_kendaraan.php");
        exit();
    }

    $jenis_kendaraan = trim($_POST['jenis_kendaraan']);
    $gambar = $_FILES['gambar'];

    // 2. Proses Unggah Gambar
    $target_dir = "../uploads/kendaraan/"; // Path folder dari file ini
    
    // Buat direktori jika belum ada
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $file_extension = pathinfo($gambar["name"], PATHINFO_EXTENSION);
    $unique_id = uniqid('', true); // Menghasilkan ID unik yang lebih kuat
    $new_file_name = "kendaraan_" . str_replace('.', '_', $unique_id) . "." . $file_extension;
    $target_file = $target_dir . $new_file_name;
    $db_path = "uploads/kendaraan/" . $new_file_name; // Path yang akan disimpan di DB

    // Validasi file gambar
    $check = getimagesize($gambar["tmp_name"]);
    if($check === false) {
        $_SESSION['error_message'] = "File yang diunggah bukan gambar.";
        header("Location: ../newadmin/tambah_kendaraan.php");
        exit();
    }

    // Validasi ukuran file (misal, maks 2MB)
    if ($gambar["size"] > 2000000) {
        $_SESSION['error_message'] = "Ukuran gambar terlalu besar. Maksimal 2MB.";
        header("Location: .../newadmin/tambah_kendaraan.php");
        exit();
    }

    // Validasi format file
    $allowed_formats = ['jpg', 'jpeg', 'png', 'webp'];
    if (!in_array(strtolower($file_extension), $allowed_formats)) {
        $_SESSION['error_message'] = "Format gambar tidak didukung. Hanya JPG, PNG, WEBP yang diizinkan.";
        header("Location: ../newadmin/tambah_kendaraan.php");
        exit();
    }

    // Pindahkan file yang diunggah
    if (move_uploaded_file($gambar["tmp_name"], $target_file)) {
        
        // 3. Simpan ke Database
        $sql = "INSERT INTO kendaraan (jenis_kendaraan, gambar) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        
        if ($stmt) {
            $stmt->bind_param("ss", $jenis_kendaraan, $db_path);
            
            if ($stmt->execute()) {
                $_SESSION['success_message'] = "Kendaraan baru berhasil ditambahkan!";
            } else {
                $_SESSION['error_message'] = "Gagal menyimpan data ke database: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $_SESSION['error_message'] = "Gagal mempersiapkan query: " . $conn->error;
        }

    } else {
        $_SESSION['error_message'] = "Terjadi kesalahan saat mengunggah file gambar.";
    }

    $conn->close();
    header("Location: ../newadmin/tambah_kendaraan.php");
    exit();

} else {
    // Jika file diakses langsung tanpa POST, redirect ke halaman form
    header("Location: ../newadmin/tambah_kendaraan.php");
    exit();
}
?>