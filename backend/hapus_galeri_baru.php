<?php
session_start();
require_once '../backend/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul'] ?? 'Media Baru';
    $kategori = $_POST['kategori'] ?? 'Umum';
    $path_file_db = null;

    if (isset($_FILES['media_file']) && $_FILES['media_file']['error'] == 0) {
        $file = $_FILES['media_file'];
        $file_type_info = mime_content_type($file['tmp_name']);
        $tipe_file = strpos($file_type_info, 'video') !== false ? 'video' : 'gambar';
        
        $upload_dir = ($tipe_file === 'video') ? '../uploads/videos/' : '../uploads/galeri/';
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
        
        $file_name = uniqid($tipe_file . '_', true) . '.' . strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $target_file = $upload_dir . $file_name;

        if (move_uploaded_file($file['tmp_name'], $target_file)) {
            $path_file_db = str_replace('../', '', $target_file);
        } else {
            $_SESSION['error_message'] = "Gagal mengupload file."; header("Location: tambah_galeri_baru.php"); exit();
        }
    } else {
        $_SESSION['error_message'] = "Anda wajib memilih file untuk diupload."; header("Location: tambah_galeri_baru.php"); exit();
    }
    
    try {
        $stmt = $conn->prepare("INSERT INTO galeri (judul, kategori, tipe_file, path_file) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $judul, $kategori, $tipe_file, $path_file_db);
        $stmt->execute();
        $stmt->close();
        $conn->close();

        $_SESSION['success_message'] = "Media baru berhasil ditambahkan.";
        header("Location: manajemen_galeri.php"); exit();
    } catch (Exception $e) {
        if ($path_file_db && file_exists('../' . $path_file_db)) unlink('../' . $path_file_db);
        $_SESSION['error_message'] = "Gagal menyimpan ke database: " . $e->getMessage();
        header("Location: tambah_galeri_baru.php"); exit();
    }
}
?>
<!DOCTYPE html><html lang="id"><head><title>Tambah Media Galeri</title><style>
body { font-family: 'Segoe UI', sans-serif; background-color: #f4f6f9; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
.form-container { background: #fff; padding: 30px 40px; border-radius: 8px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); width: 100%; max-width: 500px; }
h1 { text-align: center; color: #2c3e50; margin-bottom: 20px; }
.form-group { margin-bottom: 20px; } label { display: block; margin-bottom: 8px; font-weight: 600; }
input, select { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
.form-actions { display: flex; justify-content: flex-end; gap: 10px; margin-top: 25px; }
.btn { padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-weight: 500; text-decoration: none; }
.btn-submit { background-color: #2ecc71; color: white; } .btn-cancel { background-color: #e0e0e0; color: #333; }
</style></head><body><div class="form-container"><h1>Tambah Media Baru</h1><form method="POST" action="" enctype="multipart/form-data"><div class="form-group"><label for="media_file">Pilih File (Gambar atau Video)</label><input type="file" id="media_file" name="media_file" accept="image/*,video/mp4" required></div><div class="form-group"><label for="judul">Judul / Caption</label><input type="text" id="judul" name="judul" required></div><div class="form-group"><label for="kategori">Kategori (Opsional)</label><input type="text" id="kategori" name="kategori" placeholder="Contoh: Pantai, Gunung, Kuliner"></div><div class="form-actions"><a href="manajemen_galeri.php" class="btn btn-cancel">Batal</a><button type="submit" class="btn btn-submit">Upload & Simpan</button></div></form></div></body></html>