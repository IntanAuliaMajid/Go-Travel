<?php
session_start();
require_once 'koneksi.php'; // Ensure this path is correct

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_restaurant = $_POST['nama_restaurant'] ?? '';
    $harga = $_POST['harga'] ?? 0.00; // Get the price from the form
    $gambar_path_db = null;

    // Basic validation
    if (empty($nama_restaurant)) {
        $_SESSION['error_message'] = "Nama restaurant tidak boleh kosong.";
    } elseif (!is_numeric($harga) || $harga < 0) { // Validate price
        $_SESSION['error_message'] = "Harga tidak valid.";
    } else {
        $harga = floatval($harga); // Ensure price is a float

        if (isset($_FILES['gambar_kuliner']) && $_FILES['gambar_kuliner']['error'] == 0) {
            $upload_dir = '../uploads/kuliner/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            $file_info = pathinfo($_FILES['gambar_kuliner']['name']);
            $file_name = uniqid('kuliner_', true) . '.' . strtolower($file_info['extension']);
            $target_file = $upload_dir . $file_name;

            // Allowed extensions for images
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            if (!in_array(strtolower($file_info['extension']), $allowed_extensions)) {
                $_SESSION['error_message'] = "Format gambar tidak didukung. Hanya JPG, JPEG, PNG, GIF, dan WEBP yang diizinkan.";
                header("Location: tambah_kuliner.php");
                exit();
            }

            if (move_uploaded_file($_FILES['gambar_kuliner']['tmp_name'], $target_file)) {
                $gambar_path_db = 'uploads/kuliner/' . $file_name;
            } else {
                $_SESSION['error_message'] = "Gagal mengupload file gambar.";
                header("Location: tambah_kuliner.php");
                exit();
            }
        }

        try {
            // Prepare the SQL statement to insert nama_restaurant, gambar_url, and harga
            $stmt = $conn->prepare("INSERT INTO akomodasi_kuliner (nama_restaurant, gambar_url, harga) VALUES (?, ?, ?)");
            // 'ssd' for string, string, decimal/double
            $stmt->bind_param("ssd", $nama_restaurant, $gambar_path_db, $harga);
            $stmt->execute();
            $stmt->close();
            $_SESSION['success_message'] = "Item kuliner baru berhasil ditambahkan.";
            header("Location: ../newadmin/kuliner.php");
            exit();
        } catch (Exception $e) {
            // If an error occurs, delete the uploaded file if it exists
            if ($gambar_path_db && file_exists('../' . $gambar_path_db)) {
                unlink('../' . $gambar_path_db);
            }
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
    <meta charset="UTF-8">
    <title>Tambah Kuliner</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f6f9; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
        .form-container { background: #fff; padding: 30px 40px; border-radius: 8px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); width: 100%; max-width: 500px; }
        h1 { text-align: center; color: #2c3e50; margin-bottom: 20px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: 600; }
        input[type="text"], input[type="file"], input[type="number"], textarea { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; } /* Added input[type="number"] */
        .form-actions { display: flex; justify-content: flex-end; gap: 10px; margin-top: 25px; }
        .btn { padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-weight: 500; text-decoration: none; }
        .btn-submit { background-color: #2ecc71; color: white; }
        .btn-cancel { background-color: #e0e0e0; color: #333; }
        /* Notification styles */
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            border-radius: 6px;
            color: white;
            font-weight: 500;
            z-index: 2000;
            display: block; /* Changed to block for initial display if message exists */
            opacity: 1;
            transition: opacity 0.5s ease-in-out;
        }
        .notification.success { background-color: #2ecc71; }
        .notification.error { background-color: #e74c3c; }
        .notification.hide { opacity: 0; }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Tambah Item Kuliner Baru</h1>
        <?php
        // Display session messages
        if (isset($_SESSION['success_message'])) {
            echo '<div class="notification success">' . $_SESSION['success_message'] . '</div>';
            unset($_SESSION['success_message']);
        }
        if (isset($_SESSION['error_message'])) {
            echo '<div class="notification error">' . $_SESSION['error_message'] . '</div>';
            unset($_SESSION['error_message']);
        }
        ?>
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nama_restaurant">Nama Restaurant / Kuliner</label>
                <textarea id="nama_restaurant" name="nama_restaurant" rows="2" required></textarea>
            </div>
            <div class="form-group">
                <label for="harga">Harga</label>
                <input type="number" id="harga" name="harga" step="0.01" min="0" required placeholder="Contoh: 50000.00">
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

    <script>
        // Auto-hide notifications after a few seconds
        document.addEventListener('DOMContentLoaded', () => {
            const notification = document.querySelector('.notification');
            if (notification) {
                setTimeout(() => {
                    notification.classList.add('hide');
                    // Remove after transition
                    notification.addEventListener('transitionend', () => notification.remove());
                }, 3000); // 3 seconds
            }
        });
    </script>
</body>
</html>