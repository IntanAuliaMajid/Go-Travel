<?php
session_start();
require_once '../backend/koneksi.php'; // Sesuaikan path jika perlu

// DEFINISIKAN PATH UPLOAD
// Asumsi: 'uploads' ada di root proyek, sejajar dengan 'newadmin'
define('UPLOAD_DIR_BASE', __DIR__ . '/../uploads/'); // Path ABSOLUT di server ke folder 'uploads'
define('UPLOAD_DIR_PAKET', UPLOAD_DIR_BASE . 'paket/'); // Path absolut ke paket/
define('UPLOAD_DIR_DENAH', UPLOAD_DIR_BASE . 'denah/'); // Path absolut ke denah/

// URL untuk akses browser (relatif dari newadmin/tambah_paket.php)
define('UPLOAD_URL_PAKET', '../uploads/paket/'); // URL relatif dari newadmin/
define('UPLOAD_URL_DENAH', '../uploads/denah/'); // URL relatif dari newadmin/

// Pastikan folder upload ada dan writable
if (!is_dir(UPLOAD_DIR_PAKET)) {
    mkdir(UPLOAD_DIR_PAKET, 0775, true);
}
if (!is_dir(UPLOAD_DIR_DENAH)) {
    mkdir(UPLOAD_DIR_DENAH, 0775, true);
}

// Default placeholder for denah if no file is uploaded.
// Pastikan file ini ada di lokasi yang ditentukan (misal: Go-Travel/uploads/denah/default_denah.png)!
$default_denah_filename = 'default_denah.png'; // Ini nama file yang akan disimpan di DB

// --- Helper Functions (Dipindahkan ke atas agar bisa diakses) ---

// Fungsi untuk menghitung jumlah malam
function getJumlahMalam($durasi_text) {
    preg_match('/(\d+)/', $durasi_text, $matches);
    return isset($matches[1]) ? max(0, (int)$matches[1] - 1) : 0;
}

// Fungsi untuk mengambil data dari database
function fetchData($conn, $sql) {
    $result = $conn->query($sql);
    $data = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    return $data;
}

// Fungsi untuk menangani upload file gambar (mengembalikan NAMA FILE saja)
function handleFileUpload($file_input_name, $id_entity_prefix, $upload_dir_abs, $file_prefix = 'file_') {
    $uploaded_file_name = '';
    if (isset($_FILES[$file_input_name]) && $_FILES[$file_input_name]['error'] == UPLOAD_ERR_OK) {
        $file_tmp_name = $_FILES[$file_input_name]['tmp_name'];
        $file_name_original = $_FILES[$file_input_name]['name'];
        $file_size = $_FILES[$file_input_name]['size'];
        $file_ext = strtolower(pathinfo($file_name_original, PATHINFO_EXTENSION));

        // Buat nama file unik (gunakan uniqid() untuk menghindari bentrok)
        $new_file_name = $file_prefix . $id_entity_prefix . '_' . uniqid() . '.' . $file_ext;
        $target_file_abs = $upload_dir_abs . $new_file_name;

        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (!in_array($file_ext, $allowed_extensions)) {
            throw new Exception("Format file " . htmlspecialchars($file_name_original) . " tidak diizinkan. Hanya JPG, PNG, GIF, WebP.");
        }
        if ($file_size > 5 * 1024 * 1024) { // Max 5MB per file
            throw new Exception("Ukuran file " . htmlspecialchars($file_name_original) . " terlalu besar (Maks 5MB).");
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
        throw new Exception("Terjadi error saat upload file " . htmlspecialchars($_FILES[$file_input_name]['name'] ?? 'unknown file') . ": Code " . $_FILES[$file_input_name]['error']);
    }
    return $uploaded_file_name;
}


$wisata_list = fetchData($conn, "SELECT id_wisata, nama_wisata FROM wisata ORDER BY nama_wisata ASC");
$jenis_paket_list = fetchData($conn, "SELECT id_jenis_paket, jenis_paket FROM jenis_paket ORDER BY jenis_paket ASC");
$wilayah_list = fetchData($conn, "SELECT id_wilayah, nama_wilayah FROM wilayah ORDER BY nama_wilayah ASC");
$pemandu_list = fetchData($conn, "SELECT id_pemandu_wisata, nama_pemandu, harga FROM pemandu_wisata ORDER BY nama_pemandu ASC");
$kendaraan_list = fetchData($conn, "SELECT id_kendaraan, jenis_kendaraan FROM kendaraan ORDER BY jenis_kendaraan ASC");
$kuliner_list = fetchData($conn, "SELECT id_akomodasi_kuliner, nama_restaurant FROM akomodasi_kuliner ORDER BY nama_restaurant ASC");
$penginapan_list = fetchData($conn, "SELECT id_akomodasi_penginapan, nama_penginapan, harga_per_malam FROM akomodasi_penginapan ORDER BY nama_penginapan ASC");

$error_message = '';
$success_message = '';

// --- Handle Form Submission ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn->begin_transaction();
    try {
        // Retrieve and sanitize data
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

        $denah_lokasi_final = NULL; // Default to NULL
        $uploaded_gambar_utama_filename = ''; // To store the filename of the main package image
        $uploaded_denah_filename = ''; // To store the filename of the denah image

        // --- Handle Denah Lokasi (Gambar atau Iframe) ---
        $denah_type = $_POST['denah_type'];
        if ($denah_type === 'iframe') {
            $denah_iframe_code = $_POST['denah_iframe'];
            if (!empty($denah_iframe_code)) {
                $denah_lokasi_final = strip_tags($denah_iframe_code, '<iframe>'); // Simpan iframe
            }
        } elseif ($denah_type === 'gambar') {
            // Kita belum punya ID paket di sini, jadi pakai string sementara
            $uploaded_denah_filename = handleFileUpload('denah_gambar', 'new_temp', UPLOAD_DIR_DENAH, 'denah_');
            if (!empty($uploaded_denah_filename)) {
                // Simpan HANYA NAMA FILE ke database
                $denah_lokasi_final = $uploaded_denah_filename; 
            } else {
                // Jika tidak ada file diupload untuk denah gambar, gunakan default placeholder filename
                $denah_lokasi_final = $default_denah_filename;
            }
        }

        // Insert main package data
        $sql_insert = "INSERT INTO paket_wisata
            (nama_paket, id_wisata, id_jenis_paket, id_wilayah, durasi_paket, harga, deskripsi, denah_lokasi, info_penting, id_pemandu_wisata, id_kendaraan, id_akomodasi_kuliner, id_akomodasi_penginapan)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql_insert);
        if (!$stmt) {
            throw new Exception("Gagal mempersiapkan statement insert paket: " . $conn->error);
        }
        $stmt->bind_param("siiisdsssiiii",
            $nama_paket, $id_wisata, $id_jenis_paket, $id_wilayah, $durasi_paket, $harga,
            $deskripsi, $denah_lokasi_final, $info_penting, $id_pemandu_wisata, $id_kendaraan,
            $id_akomodasi_kuliner, $id_akomodasi_penginapan
        );

        if (!$stmt->execute()) {
            throw new Exception("Gagal mengeksekusi insert paket: " . $stmt->error);
        }
        $new_paket_id = $stmt->insert_id;
        $stmt->close();

        // --- Rename denah file jika diunggah dengan ID sementara (dan itu gambar) ---
        // dan update path di DB
        if (!empty($uploaded_denah_filename) && $denah_type === 'gambar' && strpos($uploaded_denah_filename, 'new_temp') !== false) {
            $old_abs_path = UPLOAD_DIR_DENAH . $uploaded_denah_filename;
            $file_ext = pathinfo($uploaded_denah_filename, PATHINFO_EXTENSION);
            $new_denah_filename = 'denah_' . $new_paket_id . '_' . uniqid() . '.' . $file_ext;
            $new_abs_path = UPLOAD_DIR_DENAH . $new_denah_filename;

            if (rename($old_abs_path, $new_abs_path)) {
                // Update database dengan NAMA FILE BARU setelah rename
                $final_denah_path_for_db = $new_denah_filename; 
                $stmt_update_denah = $conn->prepare("UPDATE paket_wisata SET denah_lokasi = ? WHERE id_paket_wisata = ?");
                $stmt_update_denah->bind_param("si", $final_denah_path_for_db, $new_paket_id);
                if (!$stmt_update_denah->execute()) {
                    error_log("Gagal memperbarui path denah di DB untuk ID " . $new_paket_id . ": " . $stmt_update_denah->error);
                }
                $stmt_update_denah->close();
                $uploaded_denah_filename = $new_denah_filename; // Update for potential cleanup
            } else {
                error_log("Gagal rename file denah: " . $old_abs_path);
            }
        }


        // --- Handle Upload Gambar Utama Paket ---
        $uploaded_gambar_utama_filename = handleFileUpload('gambar_utama_paket', $new_paket_id, UPLOAD_DIR_PAKET, 'paket_thumbnail_');

        if (!empty($uploaded_gambar_utama_filename)) {
            // Simpan HANYA NAMA FILE ke database
            $stmt_gambar = $conn->prepare("INSERT INTO gambar_paket (id_paket_wisata, url_gambar, caption_gambar, is_thumbnail) VALUES (?, ?, ?, 1)");
            if (!$stmt_gambar) {
                throw new Exception("Gagal mempersiapkan statement insert gambar paket: " . $conn->error);
            }
            $caption_default = $nama_paket . ' - Thumbnail';
            $stmt_gambar->bind_param("iss", $new_paket_id, $uploaded_gambar_utama_filename, $caption_default); // Simpan NAMA FILE SAJA
            if (!$stmt_gambar->execute()) {
                throw new Exception("Gagal menyimpan gambar utama paket ke database: " . $stmt_gambar->error);
            }
            $stmt_gambar->close();
        }

        // Auto-manage 'Pemandu Wisata' inclusion
        if ($id_pemandu_wisata) {
            $stmt_pemandu = $conn->prepare("SELECT nama_pemandu, harga FROM pemandu_wisata WHERE id_pemandu_wisata = ?");
            $stmt_pemandu->bind_param("i", $id_pemandu_wisata);
            $stmt_pemandu->execute();
            $pemandu_data = $stmt_pemandu->get_result()->fetch_assoc();
            $stmt_pemandu->close();

            if ($pemandu_data) {
                $pemandu_deskripsi = "Jasa Pemandu (" . $pemandu_data['nama_pemandu'] . ")";
                $pemandu_harga = $pemandu_data['harga'];
                $stmt_insert_pemandu_inc = $conn->prepare("INSERT INTO termasuk_paket (termasuk, harga_komponen, id_paket) VALUES (?, ?, ?)");
                $stmt_insert_pemandu_inc->bind_param("sdi", $pemandu_deskripsi, $pemandu_harga, $new_paket_id);
                $stmt_insert_pemandu_inc->execute();
                $stmt_insert_pemandu_inc->close();
            }
        }

        // Auto-manage 'Penginapan' inclusion
        $jumlah_malam = getJumlahMalam($durasi_paket);
        if ($id_akomodasi_penginapan && $jumlah_malam > 0) {
            $stmt_penginapan = $conn->prepare("SELECT nama_penginapan, harga_per_malam FROM akomodasi_penginapan WHERE id_akomodasi_penginapan = ?");
            $stmt_penginapan->bind_param("i", $id_akomodasi_penginapan);
            $stmt_penginapan->execute();
            $penginapan_data = $stmt_penginapan->get_result()->fetch_assoc();
            $stmt_penginapan->close();

            if ($penginapan_data) {
                $total_harga_penginapan = $jumlah_malam * $penginapan_data['harga_per_malam'];
                $penginapan_deskripsi = "Penginapan " . $jumlah_malam . " Malam (" . $penginapan_data['nama_penginapan'] . ")";
                $stmt_insert_penginapan_inc = $conn->prepare("INSERT INTO termasuk_paket (termasuk, harga_komponen, id_paket) VALUES (?, ?, ?)");
                $stmt_insert_penginapan_inc->bind_param("sdi", $penginapan_deskripsi, $total_harga_penginapan, $new_paket_id);
                $stmt_insert_penginapan_inc->execute();
                $stmt_insert_penginapan_inc->close();
            }
        }

        $conn->commit();
        $_SESSION['success_message'] = "Paket wisata '" . htmlspecialchars($nama_paket) . "' berhasil ditambahkan!";
        header("Location: paket_wisata.php");
        exit();

    } catch (Exception $e) {
        $conn->rollback();
        // Hapus file yang baru diunggah jika terjadi error
        if (!empty($uploaded_gambar_utama_filename) && file_exists(UPLOAD_DIR_PAKET . $uploaded_gambar_utama_filename)) {
            unlink(UPLOAD_DIR_PAKET . $uploaded_gambar_utama_filename);
        }
        // Pastikan untuk menghapus file denah yang diunggah jika itu adalah gambar dan terjadi error
        if (!empty($uploaded_denah_filename) && $denah_type === 'gambar' && file_exists(UPLOAD_DIR_DENAH . $uploaded_denah_filename)) {
            unlink(UPLOAD_DIR_DENAH . $uploaded_denah_filename);
        }
        $error_message = "Error: " . $e->getMessage();
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Tambah Paket Wisata</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Menggunakan CSS yang sama dari halaman kelola_paket.php untuk konsistensi */
        :root { --primary-color: #3498db; --success-color: #27ae60; --danger-color: #e74c3c; --warning-color: #f39c12; --light-bg: #f4f6f9; --white-bg: #ffffff; --dark-text: #2c3e50; --light-text: #6c757d; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: var(--light-bg); min-height: 100vh; color: #333; }
        .main-content { margin-left: 220px; padding: 25px; transition: margin-left 0.3s ease; }
        .page-header { background: var(--white-bg); padding: 20px 25px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05); margin-bottom: 25px; display: flex; justify-content: space-between; align-items: center; }
        .page-title { color: var(--dark-text); font-size: 1.7rem; font-weight: 600; display: flex; align-items: center; }
        .page-title i { margin-right: 10px; color: var(--primary-color); }
        .btn-secondary-header { background-color: var(--light-text); color: white; padding: 10px 20px; border: none; border-radius: 6px; text-decoration: none; display: inline-flex; align-items: center; font-weight: 500; font-size: 0.9rem; transition: background-color 0.2s ease, box-shadow 0.2s ease; }
        .btn-secondary-header:hover { background-color: #5a6268; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); transform: translateY(-1px); }
        .btn-secondary-header i { margin-right: 8px; }
        .card { background: var(--white-bg); border-radius: 8px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05); padding: 25px; margin-bottom: 25px;} /* Added margin-bottom here */

        /* Form Styles */
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .form-group { display: flex; flex-direction: column; }
        .form-group.full-width { grid-column: 1 / -1; }
        .form-group label { margin-bottom: 8px; font-weight: 600; color: #495057; font-size: 0.9rem; }
        .form-control { width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 5px; font-size: 0.95rem; transition: border-color 0.2s ease, box-shadow 0.2s ease; }
        .form-control:focus { border-color: #3498db; outline: none; box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2); }
        .form-control[type="number"] { -moz-appearance: textfield; } /* Hide number arrows */
        .form-control::-webkit-outer-spin-button, .form-control::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
        textarea.form-control { min-height: 120px; resize: vertical; }
        .form-actions { margin-top: 25px; text-align: right; }
        .btn-submit { background-color: #27ae60; color: white; padding: 12px 25px; border: none; border-radius: 6px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: background-color 0.2s ease; }
        .btn-submit:hover { background-color: #229954; }
        .btn-submit i { margin-right: 8px; }

        /* Alert Message Styles */
        .alert { padding: 15px; margin-bottom: 20px; border-radius: 6px; font-size: 0.95rem; }
        .alert-danger { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .alert-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }

        /* New styles for image upload and denah type selection */
        .radio-group { display: flex; gap: 20px; margin-bottom: 15px; flex-wrap: wrap;}
        .radio-group label { font-weight: normal; display: flex; align-items: center; gap: 5px; cursor: pointer; }
        .denah-preview { margin-top: 15px; border: 2px dashed #ddd; padding: 10px; min-height: 150px; display: flex; align-items: center; justify-content: center; text-align: center; border-radius: 8px; background-color: #f8f9fa; }
        .denah-preview img { max-width: 100%; max-height: 300px; border-radius: 5px; }
        .denah-preview iframe { max-width: 100%; border-radius: 5px; border: 1px solid #ccc; }

        @media (max-width: 992px) {
            .form-grid { grid-template-columns: 1fr; }
        }
        @media (max-width: 768px) {
            .main-content { margin-left: 0; padding: 15px; }
            .page-header { flex-direction: column; gap: 15px; }
        }
    </style>
</head>
<body>
    <?php include '../komponen/sidebar_admin.php'; // Pastikan path ini benar ?>

    <main class="main-content">
        <div class="page-header">
            <h1 class="page-title">
                <i class="fas fa-plus-circle"></i>
                Tambah Paket Wisata Baru
            </h1>
            <a href="kelola_paket.php" class="btn-secondary-header">
                <i class="fas fa-arrow-left"></i>
                Kembali ke Daftar Paket
            </a>
        </div>

        <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <?php if (!empty($success_message)): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <div class="card">
            <form action="tambah_paket.php" method="POST" enctype="multipart/form-data">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="nama_paket">Nama Paket Wisata</label>
                        <input type="text" id="nama_paket" name="nama_paket" class="form-control" placeholder="Contoh: Petualangan Jakarta 3D2N" required>
                    </div>

                    <div class="form-group">
                        <label for="id_wisata">Wisata Utama (Opsional)</label>
                        <select id="id_wisata" name="id_wisata" class="form-control">
                            <option value="">-- Pilih Wisata Utama --</option>
                            <?php foreach($wisata_list as $item): ?>
                                <option value="<?php echo $item['id_wisata']; ?>"><?php echo htmlspecialchars($item['nama_wisata']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="id_jenis_paket">Jenis Paket (Opsional)</label>
                        <select id="id_jenis_paket" name="id_jenis_paket" class="form-control">
                            <option value="">-- Pilih Jenis Paket --</option>
                            <?php foreach($jenis_paket_list as $item): ?>
                                <option value="<?php echo $item['id_jenis_paket']; ?>"><?php echo htmlspecialchars($item['jenis_paket']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="id_wilayah">Wilayah/Destinasi (Opsional)</label>
                        <select id="id_wilayah" name="id_wilayah" class="form-control">
                            <option value="">-- Pilih Wilayah --</option>
                            <?php foreach($wilayah_list as $item): ?>
                                <option value="<?php echo $item['id_wilayah']; ?>"><?php echo htmlspecialchars($item['nama_wilayah']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="durasi_paket">Durasi Paket</label>
                        <input type="text" id="durasi_paket" name="durasi_paket" class="form-control" placeholder="Contoh: 2 Hari 1 Malam" required>
                    </div>

                    <div class="form-group">
                        <label for="harga">Harga (IDR)</label>
                        <input type="number" id="harga" name="harga" class="form-control" placeholder="Contoh: 1500000" required>
                    </div>

                    <div class="form-group">
                        <label for="id_pemandu_wisata">Pemandu Wisata (Opsional)</label>
                        <select id="id_pemandu_wisata" name="id_pemandu_wisata" class="form-control">
                            <option value="">-- Tidak Ada Pemandu --</option>
                            <?php foreach($pemandu_list as $item): ?>
                                <option value="<?php echo $item['id_pemandu_wisata']; ?>"><?php echo htmlspecialchars($item['nama_pemandu']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="id_kendaraan">Kendaraan (Opsional)</label>
                        <select id="id_kendaraan" name="id_kendaraan" class="form-control">
                            <option value="">-- Tidak Ada Kendaraan --</option>
                            <?php foreach($kendaraan_list as $item): ?>
                                <option value="<?php echo $item['id_kendaraan']; ?>"><?php echo htmlspecialchars($item['jenis_kendaraan']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="id_akomodasi_kuliner">Akomodasi Kuliner (Opsional)</label>
                        <select id="id_akomodasi_kuliner" name="id_akomodasi_kuliner" class="form-control">
                            <option value="">-- Tidak Termasuk Kuliner Khusus --</option>
                            <?php foreach($kuliner_list as $item): ?>
                                <option value="<?php echo $item['id_akomodasi_kuliner']; ?>"><?php echo htmlspecialchars($item['nama_restaurant']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="id_akomodasi_penginapan">Akomodasi Penginapan (Opsional)</label>
                        <select id="id_akomodasi_penginapan" name="id_akomodasi_penginapan" class="form-control">
                            <option value="">-- Tidak Termasuk Penginapan --</option>
                            <?php foreach($penginapan_list as $item): ?>
                                <option value="<?php echo $item['id_akomodasi_penginapan']; ?>"><?php echo htmlspecialchars($item['nama_penginapan']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group full-width">
                        <label for="deskripsi">Deskripsi Paket</label>
                        <textarea id="deskripsi" name="deskripsi" class="form-control" placeholder="Jelaskan detail tentang paket wisata ini..." required></textarea>
                    </div>

                    <div class="form-group full-width">
                        <label for="info_penting">Informasi Penting (Opsional)</label>
                        <textarea id="info_penting" name="info_penting" class="form-control" placeholder="Contoh: Harap membawa pakaian renang. Anak di bawah 3 tahun gratis."></textarea>
                    </div>

                    <div class="form-group full-width">
                        <label>Tipe Denah/Peta</label>
                        <div class="radio-group">
                            <label><input type="radio" name="denah_type" value="gambar" checked> Gambar Denah</label>
                            <label><input type="radio" name="denah_type" value="iframe"> Peta Iframe</label>
                        </div>
                    </div>

                    <div id="denah-gambar-section" class="form-group full-width">
                        <label for="denah_gambar">Upload File Gambar Denah (Opsional)</label>
                        <input type="file" name="denah_gambar" id="denah_gambar" class="form-control" accept="image/*">
                        <small>Pilih file gambar denah. Maksimal 5MB. Format: JPG, PNG, GIF, WebP.</small>
                    </div>

                    <div id="denah-iframe-section" class="form-group full-width" style="display:none;">
                        <label for="denah_iframe">Kode Iframe Peta (Opsional)</label>
                        <textarea name="denah_iframe" id="denah_iframe" class="form-control" rows="4" placeholder="Tempel kode iframe dari Google Maps di sini..."></textarea>
                        <small>Contoh: &lt;iframe src="https://www.google.com/maps/embed?..."&gt;&lt;/iframe&gt;</small>
                    </div>
                    <div class="form-group full-width">
                        <label for="gambar_utama_paket">Upload Gambar Utama Paket (Thumbnail)</label>
                        <input type="file" name="gambar_utama_paket" id="gambar_utama_paket" class="form-control" accept="image/*" required>
                        <small>Gambar ini akan menjadi thumbnail utama paket. Maksimal 5MB. Format: JPG, PNG, GIF, WebP.</small>
                    </div>

                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-save"></i>
                        Simpan Paket
                    </button>
                </div>
            </form>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const radioButtons = document.querySelectorAll('input[name="denah_type"]');
            const gambarSection = document.getElementById('denah-gambar-section');
            const iframeSection = document.getElementById('denah-iframe-section');

            function toggleDenahSections() {
                if (document.querySelector('input[name="denah_type"]:checked').value === 'gambar') {
                    gambarSection.style.display = 'flex';
                    iframeSection.style.display = 'none';
                } else {
                    gambarSection.style.display = 'none';
                    iframeSection.style.display = 'flex';
                }
            }

            radioButtons.forEach(radio => { radio.addEventListener('change', toggleDenahSections); });
            // Initial call to set correct display based on default checked radio
            toggleDenahSections();
        });
    </script>
</body>
</html>