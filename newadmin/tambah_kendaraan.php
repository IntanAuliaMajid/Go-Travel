<?php
session_start();
// Blok PHP untuk memproses form submission
$pesan_error = "";

// Cek jika form telah disubmit (metode request adalah POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Memanggil file koneksi
    require_once '../backend/koneksi.php';

    // Ambil data dari form
    $jenis_kendaraan = $_POST['jenis_kendaraan'];
    $harga = $_POST['harga'];
    $gambar_path = "";

    // --- LOGIKA UPLOAD GAMBAR ---
    // Cek apakah ada file yang diupload dan tidak ada error
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $target_dir = "../uploads/kendaraan/"; // Lokasi folder upload
        
        // Pastikan direktori target ada, jika tidak, coba buat
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }

        // Buat nama file yang unik untuk menghindari penimpaan file
        $nama_file_unik = uniqid('kendaraan_') . '_' . basename($_FILES["gambar"]["name"]);
        $target_file = $target_dir . $nama_file_unik;
        $tipe_file = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Validasi tipe file
        $allowed_types = ["jpg", "png", "jpeg", "gif", "webp"];
        if (!in_array($tipe_file, $allowed_types)) {
            $pesan_error = "Maaf, hanya file JPG, JPEG, PNG, GIF & WEBP yang diizinkan.";
        }
        
        // Jika tidak ada error, coba upload file
        if (empty($pesan_error)) {
            if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
                // Simpan path relatif dari direktori utama (hapus ../) untuk disimpan ke DB
                $gambar_path = "uploads/kendaraan/" . $nama_file_unik;
            } else {
                $pesan_error = "Maaf, terjadi error saat mengupload file Anda.";
            }
        }
    } else {
        $pesan_error = "Gambar kendaraan wajib diunggah.";
    }
    // --- AKHIR LOGIKA UPLOAD GAMBAR ---

    // Lanjutkan proses insert ke database hanya jika tidak ada error upload
    if (empty($pesan_error)) {
        // SQL query disesuaikan dengan 3 kolom: jenis_kendaraan, harga, gambar
        $sql = "INSERT INTO kendaraan (jenis_kendaraan, harga, gambar) VALUES (?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        
        // Bind parameter ke statement: s(string), i(integer), s(string)
        $stmt->bind_param("sis", $jenis_kendaraan, $harga, $gambar_path);

        // Eksekusi statement
        if ($stmt->execute()) {
            // Jika berhasil, alihkan ke halaman manajemen kendaraan
            $stmt->close();
            $conn->close();
            header("Location: kendaraan.php?status=tambah_sukses");
            exit();
        } else {
            $pesan_error = "Gagal menyimpan data ke database: " . $stmt->error;
        }

        $stmt->close();
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Tambah Kendaraan - GoTravel</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Style ini sama dengan halaman manajemen kendaraan Anda untuk konsistensi */
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f6f9; color: #333; line-height: 1.6; margin: 0; }
        .main-content { margin-left: 220px; padding: 30px; }
        .dashboard-header { background: #ffffff; border-radius: 8px; padding: 20px; margin-bottom: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .dashboard-header h1 { color: #2c3e50; font-size: 1.8rem; font-weight: 600; margin: 0; }
        
        .form-container { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .form-group { margin-bottom: 20px; }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #495057;
            font-size: 0.9rem;
        }
        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ced4da;
            border-radius: 6px;
            box-sizing: border-box;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .form-group input:focus,
        .form-group select:focus {
            border-color: #3498db;
            outline: none;
            box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.25);
        }
        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 25px;
        }
        .btn {
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 0.95rem;
            transition: background-color 0.3s;
        }
        .btn-primary { background: #3498db; color: white; }
        .btn-primary:hover { background: #2980b9; }
        .btn-secondary { background: #ecf0f1; color: #34495e; border: 1px solid #bdc3c7; }
        .btn-secondary:hover { background: #e0e6e8; }
        .alert-error {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 6px;
            color: #a94442;
            background-color: #f2dede;
            border-color: #ebccd1;
        }
    </style>
</head>
<body>
    <?php include '../komponen/sidebar_admin.php'; ?>
    <main class="main-content">
        <header class="dashboard-header">
            <h1>Tambah Kendaraan Baru</h1>
        </header>

        <div class="form-container">
            <?php if(!empty($pesan_error)): ?>
                <div class="alert-error"><?php echo $pesan_error; ?></div>
            <?php endif; ?>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                
                <div class="form-group">
                    <label for="jenis_kendaraan">Nama Kendaraan</label>
                    <input type="text" id="jenis_kendaraan" name="jenis_kendaraan" placeholder="Contoh: Toyota Hiace Commuter, Kijang Innova" required>
                </div>
                
                <div class="form-group">
                    <label for="harga">Harga Sewa per Hari (Rp)</label>
                    <input type="number" id="harga" name="harga" placeholder="Contoh: 500000 (hanya angka)" required>
                </div>

                <div class="form-group">
                    <label for="gambar">Gambar Kendaraan</label>
                    <input type="file" id="gambar" name="gambar" accept="image/*" required>
                </div>
                
                <div class="form-actions">
                    <a href="manajemen_kendaraan.php" class="btn btn-secondary"><i class="fas fa-times"></i> Batal</a>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Kendaraan</button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>