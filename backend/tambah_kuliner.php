<?php
session_start();
require_once 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_restaurant = $_POST['nama_restaurant'] ?? '';
    $gambar_path_db = null;

    if (empty($nama_restaurant)) {
        $_SESSION['error_message'] = "Nama restaurant tidak boleh kosong.";
    } else {
        if (isset($_FILES['gambar_kuliner']) && $_FILES['gambar_kuliner']['error'] == 0) {
            $upload_dir = '../uploads/kuliner/';
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
            
            $file_info = pathinfo($_FILES['gambar_kuliner']['name']);
            $file_name = uniqid('kuliner_', true) . '.' . strtolower($file_info['extension']);
            $target_file = $upload_dir . $file_name;

            if (move_uploaded_file($_FILES['gambar_kuliner']['tmp_name'], $target_file)) {
                $gambar_path_db = 'uploads/kuliner/' . $file_name;
            } else {
                $_SESSION['error_message'] = "Gagal mengupload file gambar.";
                header("Location: tambah_kuliner.php"); exit();
            }
        }
        
        try {
            $stmt = $conn->prepare("INSERT INTO akomodasi_kuliner (nama_restaurant, gambar_url) VALUES (?, ?)");
            $stmt->bind_param("ss", $nama_restaurant, $gambar_path_db);
            $stmt->execute();
            $stmt->close();
            $_SESSION['success_message'] = "Item kuliner baru berhasil ditambahkan.";
            header("Location: ../newadmin/kuliner.php"); exit();
        } catch (Exception $e) {
            if ($gambar_path_db && file_exists('../' . $gambar_path_db)) unlink('../' . $gambar_path_db);
            $_SESSION['error_message'] = "Gagal menambahkan data: " . $e->getMessage();
        }
    }
    header("Location: tambah_kuliner.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><title>Tambah Kuliner</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f6f9; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
        .form-container { background: #fff; padding: 30px 40px; border-radius: 8px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); width: 100%; max-width: 500px; }
        h1 { text-align: center; color: #2c3e50; margin-bottom: 20px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: 600; }
        input[type="text"], input[type="file"], textarea { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
        .form-actions { display: flex; justify-content: flex-end; gap: 10px; margin-top: 25px; }
        .btn { padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-weight: 500; text-decoration: none; }
        .btn-submit { background-color: #2ecc71; color: white; }
        .btn-cancel { background-color: #e0e0e0; color: #333; }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Tambah Item Kuliner Baru</h1>
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nama_restaurant">Nama Restaurant / Kuliner</label>
                <textarea id="nama_restaurant" name="nama_restaurant" rows="2" required></textarea>
            </div>
            <div class="form-group">
                <label for="gambar_kuliner">Gambar</label>
                <input type="file" id="gambar_kuliner" name="gambar_kuliner" accept="image/*">
            </div>
            <div class="form-actions">
                <a href="../newadmin/kuliner.php" class="btn btn-cancel">Batal</a>
                <button type="submit" class="btn btn-submit">Simpan</button>
            </div>
        </form>
    </div>
</body>
</html>