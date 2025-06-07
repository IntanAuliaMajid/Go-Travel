<?php
// AKTIFKAN UNTUK DEVELOPMENT, NONAKTIFKAN/HAPUS DI PRODUKSI!
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../backend/koneksi.php';

// Inisialisasi variabel untuk form
$nama_wisata = '';
$deskripsi_wisata = '';
$tips_berkunjung_input = '';
$todo = '';
$alamat = '';
$id_lokasi = '';
$kategori_id = '';
$telepon = '';
$info_aksesibilitas = '';

$message = '';
$message_type = '';

// Direktori untuk menyimpan file gambar yang diunggah
$upload_dir = '../uploads/wisata/'; // Pastikan folder ini ada dan writable!

// Default placeholder for denah if no file is uploaded.
// Pastikan file ini ada di lokasi yang ditentukan!
$default_denah_path = $upload_dir . 'default_denah.png'; // Misalnya: '../uploads/wisata/default_denah.png'

// Fetch data lokasi dan kategori
$lokasi_list = [];
$kategori_list = [];

$sql_lokasi = "SELECT id_lokasi, nama_lokasi FROM lokasi";
$result_lokasi = $conn->query($sql_lokasi);
if ($result_lokasi) { // Pastikan query berhasil
    while ($row = $result_lokasi->fetch_assoc()) {
        $lokasi_list[] = $row;
    }
} else {
    // Handle error fetching locations
    error_log("Error fetching locations: " . $conn->error);
}

$sql_kategori = "SELECT id_kategori, nama_kategori FROM kategori_wisata";
$result_kategori = $conn->query($sql_kategori);
if ($result_kategori) { // Pastikan query berhasil
    while ($row = $result_kategori->fetch_assoc()) {
        $kategori_list[] = $row;
    }
} else {
    // Handle error fetching categories
    error_log("Error fetching categories: " . $conn->error);
}

// Fungsi untuk menangani upload file gambar
function handleFileUpload($file_input_name, $id_entity, $upload_dir, $prefix = 'file_') {
    // Pastikan folder upload ada
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0775, true); // Buat folder jika belum ada, dengan izin 0775
    }

    $uploaded_file_path = ''; // Default empty
    if (isset($_FILES[$file_input_name]) && $_FILES[$file_input_name]['error'] == UPLOAD_ERR_OK) {
        $file_tmp_name = $_FILES[$file_input_name]['tmp_name'];
        $file_name = $_FILES[$file_input_name]['name'];
        $file_size = $_FILES[$file_input_name]['size'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        // Generate nama file unik
        $new_file_name = $prefix . $id_entity . '_' . uniqid() . '.' . $file_ext;
        $target_file = $upload_dir . $new_file_name;

        // Periksa jenis file yang diizinkan
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($file_ext, $allowed_extensions)) {
            throw new Exception("Format file " . htmlspecialchars($file_name) . " tidak diizinkan. Hanya JPG, JPEG, PNG, GIF.");
        }

        // Periksa ukuran file (misal, maks 5MB)
        if ($file_size > 5 * 1024 * 1024) { // 5 MB
            throw new Exception("Ukuran file " . htmlspecialchars($file_name) . " terlalu besar (maks 5MB).");
        }

        // Pindahkan file yang diupload
        if (move_uploaded_file($file_tmp_name, $target_file)) {
            $uploaded_file_path = $target_file; // Simpan path relatif dari root proyek
        } else {
            // Memberikan pesan error yang lebih spesifik dari PHP
            $upload_error_code = $_FILES[$file_input_name]['error'];
            $error_message = "Gagal mengunggah file " . htmlspecialchars($file_name) . ". Kode error: " . $upload_error_code . ". ";
            switch ($upload_error_code) {
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    $error_message .= "Ukuran file melebihi batas upload.";
                    break;
                case UPLOAD_ERR_PARTIAL:
                    $error_message .= "File hanya terunggah sebagian.";
                    break;
                case UPLOAD_ERR_NO_FILE:
                    $error_message .= "Tidak ada file yang dipilih untuk diunggah.";
                    break;
                case UPLOAD_ERR_NO_TMP_DIR:
                    $error_message .= "Folder temporary tidak ada.";
                    break;
                case UPLOAD_ERR_CANT_WRITE:
                    $error_message .= "Gagal menulis file ke disk. Periksa izin folder.";
                    break;
                case UPLOAD_ERR_EXTENSION:
                    $error_message .= "Ekstensi PHP menghentikan upload file.";
                    break;
                default:
                    $error_message .= "Kesalahan upload tidak diketahui.";
                    break;
            }
            throw new Exception($error_message);
        }
    }
    return $uploaded_file_path;
}


// Proses form submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $nama_wisata = $_POST['nama_wisata'];
    $deskripsi_wisata = $_POST['deskripsi_wisata'];
    $tips_berkunjung_input = $_POST['tips_berkunjung'];
    $todo = $_POST['todo'];
    $alamat = $_POST['alamat'];
    $id_lokasi = $_POST['id_lokasi'] ?? NULL;
    $kategori_id = $_POST['kategori_id'] ?? NULL;
    $telepon = $_POST['telepon'];
    $info_aksesibilitas = $_POST['info_aksesibilitas'];

    // Inisialisasi path gambar dan denah dari upload
    $uploaded_gambar_utama_path = '';
    $uploaded_denah_path = '';

    // Validasi dasar (opsional, bisa diperluas)
    if (empty($nama_wisata) || empty($deskripsi_wisata) || empty($alamat) || empty($id_lokasi) || empty($kategori_id)) {
        $message = "Nama wisata, deskripsi, alamat, lokasi, dan kategori harus diisi.";
        $message_type = "error";
    } else {
        $conn->begin_transaction();

        try {
            // --- Penanganan Upload Denah Lokasi (Sebelum INSERT utama) ---
            // Kita akan mencoba mengunggah denah dengan ID sementara ('new')
            // Path ini akan diupdate setelah kita mendapatkan new_wisata_id
            $initial_denah_upload_path = handleFileUpload('denah_file', 'new_temp', $upload_dir, 'denah');

            // Jika tidak ada denah file yang diunggah, gunakan path default
            if (empty($initial_denah_upload_path)) {
                $denah_to_insert = $default_denah_path;
            } else {
                $denah_to_insert = $initial_denah_upload_path;
            }

            // Masukkan data wisata ke tabel 'wisata'
            // Gunakan $denah_to_insert yang sudah berisi path file yang diupload sementara atau default
            $stmt = $conn->prepare("INSERT INTO wisata (nama_wisata, deskripsi_wisata, todo, Alamat, id_lokasi, kategori_id, denah, telepon, info_aksesibilitas) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            // Type definition string: ssss (string), ii (integer), sss (string) => Total 9 parameters
            $stmt->bind_param("ssssiisss", $nama_wisata, $deskripsi_wisata, $todo, $alamat, $id_lokasi, $kategori_id, $denah_to_insert, $telepon, $info_aksesibilitas);

            if (!$stmt->execute()) {
                throw new Exception("Gagal menyimpan data wisata utama: " . $stmt->error);
            }

            $new_wisata_id = $stmt->insert_id;
            $stmt->close();

            // --- Jika denah berhasil diunggah dengan ID sementara, ganti nama filenya sekarang ---
            if (!empty($initial_denah_upload_path) && strpos($initial_denah_upload_path, 'new_temp') !== false) {
                $old_path_parts = pathinfo($initial_denah_upload_path);
                // Buat nama file baru dengan ID wisata yang sebenarnya
                $new_denah_file_name = 'denah_' . $new_wisata_id . '_' . uniqid() . '.' . $old_path_parts['extension'];
                $new_full_path_for_denah = $upload_dir . $new_denah_file_name;

                if (rename($initial_denah_upload_path, $new_full_path_for_denah)) {
                    // Update path denah di database dengan nama file yang benar
                    $stmt_update_denah = $conn->prepare("UPDATE wisata SET denah = ? WHERE id_wisata = ?");
                    $stmt_update_denah->bind_param("si", $new_full_path_for_denah, $new_wisata_id);
                    if (!$stmt_update_denah->execute()) {
                        // Ini error yang tidak fatal untuk transaksi, tapi perlu log
                        error_log("Gagal memperbarui path denah di DB untuk ID " . $new_wisata_id . ": " . $stmt_update_denah->error);
                    }
                    $stmt_update_denah->close();
                    $uploaded_denah_path = $new_full_path_for_denah; // Simpan path final untuk cleanup jika rollback
                } else {
                    // Jika gagal rename, kita tetap pakai nama sementara di DB, tapi ini suboptimal
                    // Pertimbangkan untuk melemparkan exception atau memberikan peringatan keras.
                    error_log("Gagal rename file denah dari " . $initial_denah_upload_path . " ke " . $new_full_path_for_denah);
                    $uploaded_denah_path = $initial_denah_upload_path; // Simpan path sementara untuk cleanup jika rollback
                }
            } else {
                $uploaded_denah_path = $denah_to_insert; // Denah adalah default atau tidak ada upload
            }


            // Insert tips berkunjung ke tabel 'tips_berkunjung'
            if (!empty(trim($tips_berkunjung_input))) {
                $tips_array = array_map('trim', explode("\n", $tips_berkunjung_input));
                $stmt_tips = $conn->prepare("INSERT INTO tips_berkunjung (id_wisata, tip_text) VALUES (?, ?)");
                if ($stmt_tips) {
                    foreach ($tips_array as $tip_text) {
                        if (!empty($tip_text)) {
                            $stmt_tips->bind_param("is", $new_wisata_id, $tip_text);
                            if (!$stmt_tips->execute()) {
                                error_log("Gagal menyimpan tips untuk ID " . $new_wisata_id . ": " . $stmt_tips->error);
                            }
                        }
                    }
                    $stmt_tips->close();
                } else {
                    error_log("Gagal mempersiapkan statement tips: " . $conn->error);
                }
            }

            // --- Penanganan Upload Gambar Utama ---
            // Panggil fungsi handleFileUpload untuk gambar utama
            $uploaded_gambar_utama_path = handleFileUpload('gambar_utama_file', $new_wisata_id, $upload_dir, 'wisata');
            if (!empty($uploaded_gambar_utama_path)) {
                // Simpan path gambar utama ke tabel 'gambar'
                $stmt_gambar = $conn->prepare("INSERT INTO gambar (wisata_id, url, caption) VALUES (?, ?, ?)");
                if ($stmt_gambar) {
                    $caption = $nama_wisata . ' - Gambar Utama';
                    $stmt_gambar->bind_param("iss", $new_wisata_id, $uploaded_gambar_utama_path, $caption);
                    if (!$stmt_gambar->execute()) {
                        error_log("Gagal menyimpan gambar utama untuk ID " . $new_wisata_id . ": " . $stmt_gambar->error);
                    }
                    $stmt_gambar->close();
                } else {
                    error_log("Gagal mempersiapkan statement gambar: " . $conn->error);
                }
            }


            $conn->commit();
            $message = "Data wisata berhasil ditambahkan!";
            $message_type = "success";

            // Kosongkan form setelah berhasil
            $nama_wisata = $deskripsi_wisata = $tips_berkunjung_input = $todo = $alamat = $id_lokasi = $kategori_id = $telepon = $info_aksesibilitas = '';

        } catch (Exception $e) {
            $conn->rollback();
            $message = "Error: " . $e->getMessage();
            $message_type = "error";
            // Jika terjadi error, hapus file yang sudah terupload agar tidak ada file yatim.
            if (!empty($uploaded_gambar_utama_path) && file_exists($uploaded_gambar_utama_path)) {
                unlink($uploaded_gambar_utama_path);
            }
            // Hapus denah hanya jika itu diunggah (bukan default) dan ada di disk
            if (!empty($uploaded_denah_path) && file_exists($uploaded_denah_path) && $uploaded_denah_path !== $default_denah_path) {
                unlink($uploaded_denah_path);
            }
        }
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Tambah Wisata</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Styles sama seperti sebelumnya */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f6f9; min-height: 100vh; color: #333; }
        .main-content { margin-left: 220px; padding: 25px; transition: margin-left 0.3s ease; }
        .page-header { background: #ffffff; padding: 20px 25px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05); margin-bottom: 25px; display: flex; justify-content: space-between; align-items: center; }
        .page-title { color: #2c3e50; font-size: 1.7rem; font-weight: 600; display: flex; align-items: center; }
        .page-title i { margin-right: 10px; color: #27ae60; }
        .btn-back { background-color: #6c757d; color: white; padding: 10px 20px; border: none; border-radius: 6px; text-decoration: none; display: inline-flex; align-items: center; font-weight: 500; font-size: 0.9rem; transition: all 0.2s ease; }
        .btn-back:hover { background-color: #5a6268; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); transform: translateY(-1px); }
        .btn-back i { margin-right: 8px; }
        .card { background: #ffffff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05); padding: 30px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; }
        .form-group input[type="text"],
        .form-group input[type="url"],
        .form-group input[type="tel"],
        .form-group input[type="file"], /* Tambahkan style untuk input file */
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 12px;
            border: 1px solid #e0e6ed;
            border-radius: 5px;
            font-size: 1rem;
            color: #34495e;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }
        .form-group input[type="text"]:focus,
        .form-group input[type="url"]:focus,
        .form-group input[type="tel"]:focus,
        .form-group input[type="file"]:focus, /* Tambahkan style untuk input file focus */
        .form-group textarea:focus,
        .form-group select:focus {
            border-color: #27ae60;
            box-shadow: 0 0 0 3px rgba(39, 174, 96, 0.2);
            outline: none;
        }
        .form-group textarea {
            min-height: 100px;
            resize: vertical;
        }
        .form-actions { text-align: right; margin-top: 30px; }
        .btn-submit { background-color: #27ae60; color: white; padding: 12px 25px; border: none; border-radius: 6px; font-size: 1rem; font-weight: 500; cursor: pointer; transition: all 0.2s ease; }
        .btn-submit:hover { background-color: #229954; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); transform: translateY(-1px); }
        .message {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .message.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .message.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <?php include '../komponen/sidebar_admin.php'; ?>

    <main class="main-content">
        <div class="page-header">
            <h1 class="page-title">
                <i class="fas fa-plus-circle"></i>
                Tambah Wisata Baru
            </h1>
            <a href="kelola_wisata.php" class="btn-back">
                <i class="fas fa-arrow-left"></i> Kembali ke Kelola Wisata
            </a>
        </div>

        <?php if (!empty($message)): ?>
            <div class="message <?php echo $message_type; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <div class="card">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nama_wisata">Nama Wisata <span style="color: red;">*</span></label>
                    <input type="text" id="nama_wisata" name="nama_wisata" value="<?php echo htmlspecialchars($nama_wisata); ?>" required>
                </div>

                <div class="form-group">
                    <label for="deskripsi_wisata">Deskripsi Wisata <span style="color: red;">*</span></label>
                    <textarea id="deskripsi_wisata" name="deskripsi_wisata" required><?php echo htmlspecialchars($deskripsi_wisata); ?></textarea>
                </div>

                <div class="form-group">
                    <label for="tips_berkunjung">Tips Berkunjung (Pisahkan dengan baris baru)</label>
                    <textarea id="tips_berkunjung" name="tips_berkunjung"><?php echo htmlspecialchars($tips_berkunjung_input); ?></textarea>
                </div>

                <div class="form-group">
                    <label for="todo">Hal yang Dapat Dilakukan (Pisahkan dengan koma)</label>
                    <textarea id="todo" name="todo"><?php echo htmlspecialchars($todo); ?></textarea>
                </div>

                <div class="form-group">
                    <label for="alamat">Alamat <span style="color: red;">*</span></label>
                    <textarea id="alamat" name="alamat" required><?php echo htmlspecialchars($alamat); ?></textarea>
                </div>

                <div class="form-group">
                    <label for="id_lokasi">Lokasi <span style="color: red;">*</span></label>
                    <select id="id_lokasi" name="id_lokasi" required>
                        <option value="">Pilih Lokasi</option>
                        <?php foreach ($lokasi_list as $lokasi): ?>
                            <option value="<?php echo htmlspecialchars($lokasi['id_lokasi']); ?>" <?php echo ($id_lokasi == $lokasi['id_lokasi']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($lokasi['nama_lokasi']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="kategori_id">Kategori <span style="color: red;">*</span></label>
                    <select id="kategori_id" name="kategori_id" required>
                        <option value="">Pilih Kategori</option>
                        <?php foreach ($kategori_list as $kategori): ?>
                            <option value="<?php echo htmlspecialchars($kategori['id_kategori']); ?>" <?php echo ($kategori_id == $kategori['id_kategori']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($kategori['nama_kategori']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="telepon">Telepon</label>
                    <input type="tel" id="telepon" name="telepon" value="<?php echo htmlspecialchars($telepon); ?>">
                </div>

                <div class="form-group">
                    <label for="info_aksesibilitas">Info Aksesibilitas</label>
                    <textarea id="info_aksesibilitas" name="info_aksesibilitas"><?php echo htmlspecialchars($info_aksesibilitas); ?></textarea>
                </div>

                <div class="form-group">
                    <label for="gambar_utama_file">Upload Gambar Utama</label>
                    <input type="file" id="gambar_utama_file" name="gambar_utama_file" accept="image/jpeg, image/png, image/gif">
                    <small>Maksimal ukuran file: 5MB. Format: JPG, JPEG, PNG, GIF.</small>
                </div>

                <div class="form-group">
                    <label for="denah_file">Upload Denah Lokasi</label>
                    <input type="file" id="denah_file" name="denah_file" accept="image/jpeg, image/png, image/gif">
                    <small>Maksimal ukuran file: 5MB. Format: JPG, JPEG, PNG, GIF.</small>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-save"></i> Simpan Wisata
                    </button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>