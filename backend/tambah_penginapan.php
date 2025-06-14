<?php
session_start();
require_once '../backend/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_penginapan = $_POST['nama_penginapan'] ?? '';
    $rating_bintang = (int)($_POST['rating_bintang'] ?? 0);
    $harga_per_malam = (int)($_POST['harga_per_malam'] ?? 0);
    $gambar_path_db = null;

    if (empty($nama_penginapan)) {
        $_SESSION['error_message'] = "Nama penginapan tidak boleh kosong.";
    } else {
        if (isset($_FILES['gambar_penginapan']) && $_FILES['gambar_penginapan']['error'] == 0) {
            $upload_dir = '../uploads/penginapan/';
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
            
            $file_info = pathinfo($_FILES['gambar_penginapan']['name']);
            $file_name = uniqid('penginapan_', true) . '.' . strtolower($file_info['extension']);
            $target_file = $upload_dir . $file_name;

            if (move_uploaded_file($_FILES['gambar_penginapan']['tmp_name'], $target_file)) {
                $gambar_path_db = 'uploads/penginapan/' . $file_name;
            }
        }
        
        try {
            $stmt = $conn->prepare("INSERT INTO akomodasi_penginapan (nama_penginapan, rating_bintang, harga_per_malam, gambar_url) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("siis", $nama_penginapan, $rating_bintang, $harga_per_malam, $gambar_path_db);
            $stmt->execute();
            $stmt->close();

            $_SESSION['success_message'] = "Penginapan baru berhasil ditambahkan.";
            header("Location: ../newadmin/penginapan.php");
            exit();
        } catch (Exception $e) {
            if ($gambar_path_db && file_exists('../' . $gambar_path_db)) unlink('../' . $gambar_path_db);
            $_SESSION['error_message'] = "Gagal menambahkan penginapan: " . $e->getMessage();
        }
    }
    header("Location: ../newadmin/penginapan.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><title>Tambah Penginapan</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f6f9; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
        .form-container { background: #fff; padding: 30px 40px; border-radius: 8px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); width: 100%; max-width: 500px; }
        h1 { text-align: center; color: #2c3e50; margin-bottom: 20px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 5px; font-weight: 600; }
        input[type="text"], input[type="number"], input[type="file"], select { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
        .form-actions { display: flex; justify-content: flex-end; gap: 10px; margin-top: 25px; }
        .btn { padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-weight: 500; text-decoration: none; }
        .btn-submit { background-color: #2ecc71; color: white; }
        .btn-cancel { background-color: #e0e0e0; color: #333; }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Tambah Penginapan Baru</h1>
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nama_penginapan">Nama Penginapan</label>
                <input type="text" id="nama_penginapan" name="nama_penginapan" required>
            </div>
            <div class="form-group">
                <label for="rating_bintang">Rating Bintang (1-5)</label>
                <input type="number" id="rating_bintang" name="rating_bintang" min="1" max="5">
            </div>
             <div class="form-group">
                <label for="harga_per_malam">Harga per Malam (Rp)</label>
                <input type="number" id="harga_per_malam" name="harga_per_malam" min="0">
            </div>
            <div class="form-group">
                <label for="gambar_penginapan">Gambar Penginapan</label>
                <input type="file" id="gambar_penginapan" name="gambar_penginapan" accept="image/*">
            </div>
            <div class="form-actions">
                <a href="../newadmin/penginapan.php" class="btn btn-cancel">Batal</a>
                <button type="submit" class="btn btn-submit">Simpan</button>
            </div>
        </form>
    </div>
</body>
</html>