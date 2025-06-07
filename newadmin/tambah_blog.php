<?php
session_start(); // Pastikan session dimulai untuk mungkin mengambil ID pengguna jika diperlukan
require_once '../backend/koneksi.php'; // Sesuaikan path jika perlu. Ini mengasumsikan koneksi.php ada di Go-Travel/backend/

// Periksa apakah pengguna sudah login sebagai admin (contoh sederhana)
// Anda mungkin perlu logika otentikasi yang lebih kompleks
if (!isset($_SESSION['user_admin_id'])) { // Asumsi ada session ID admin
    // header("Location: login_admin.php"); // Alihkan ke halaman login admin jika belum login
    // exit();
    // Untuk demo, kita akan membiarkan tanpa redirect, tapi ini penting untuk produksi
}

$message = '';
$message_type = '';

// Fetch jenis_artikel for the dropdown
$jenis_artikel_options = [];
$sql_jenis_artikel = "SELECT id_jenis_artikel, jenis_artikel FROM jenis_artikel ORDER BY jenis_artikel ASC";
$result_jenis_artikel = $conn->query($sql_jenis_artikel);
if ($result_jenis_artikel) {
    while ($row = $result_jenis_artikel->fetch_assoc()) {
        $jenis_artikel_options[] = $row;
    }
} else {
    $message = "Error fetching article types: " . $conn->error;
    $message_type = "danger";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul_artikel = $_POST['judul_artikel'] ?? '';
    $isi_artikel = $_POST['isi_artikel'] ?? '';
    $tag = $_POST['tag'] ?? '';
    $id_jenis_artikel = $_POST['id_jenis_artikel'] ?? null;
    $tanggal_dipublish = date("Y-m-d"); // Tanggal otomatis saat ini

    // *** PERUBAHAN PENTING DI SINI UNTUK PATH UPLOAD ***
    $target_dir = "../uploads/artikel/"; // Path relatif dari newadmin/tambah_blog.php ke Go-Travel/uploads/artikel/
    
    $uploadOk = 1;
    $id_gambar_artikel = null; // Default null, akan diisi jika upload berhasil

    // Handle gambar upload
    if (isset($_FILES["gambar_artikel"]) && $_FILES["gambar_artikel"]["error"] == UPLOAD_ERR_OK) {
        // Tambahkan kode ini untuk memastikan direktori ada dan memiliki izin
        if (!is_dir($target_dir)) { 
            // Coba buat direktori dengan izin penuh (0777) secara rekursif
            // Di lingkungan produksi, pertimbangkan izin yang lebih ketat seperti 0755 atau 0775
            if (!mkdir($target_dir, 0777, true)) { 
                $message = "Gagal membuat direktori upload: " . $target_dir . ". Pastikan folder induk Go-Travel memiliki izin tulis.";
                $message_type = "danger";
                $uploadOk = 0; // Set uploadOk ke 0 agar proses upload tidak dilanjutkan
            }
        }

        if ($uploadOk) { // Lanjutkan hanya jika direktori berhasil dibuat atau sudah ada
            $file_name = uniqid() . '_' . basename($_FILES["gambar_artikel"]["name"]);
            $target_file = $target_dir . $file_name;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Validasi tipe file
            $check = getimagesize($_FILES["gambar_artikel"]["tmp_name"]);
            if ($check !== false) {
                // Check file size (contoh: max 5MB)
                if ($_FILES["gambar_artikel"]["size"] > 5 * 1024 * 1024) {
                    $message = "Ukuran gambar terlalu besar. Maksimal 5MB.";
                    $message_type = "danger";
                    $uploadOk = 0;
                }
                // Allow certain file formats
                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                    $message = "Hanya file JPG, JPEG, PNG & GIF yang diizinkan.";
                    $message_type = "danger";
                    $uploadOk = 0;
                }
            } else {
                $message = "File bukan gambar.";
                $message_type = "danger";
                $uploadOk = 0;
            }
        }

        // Upload file jika semua validasi lolos
        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["gambar_artikel"]["tmp_name"], $target_file)) {
                // Simpan info gambar ke tabel gambar_artikel
                $stmt_gambar = $conn->prepare("INSERT INTO gambar_artikel (url) VALUES (?)");
                // *** PERUBAHAN PENTING DI SINI UNTUK URL YANG DISIMPAN KE DATABASE ***
                // Ini adalah path yang akan diakses oleh browser dari root situs web
                $gambar_url = './uploads/artikel/' . $file_name; 
                
                $stmt_gambar->bind_param("s", $gambar_url);
                if ($stmt_gambar->execute()) {
                    $id_gambar_artikel = $conn->insert_id;
                } else {
                    $message = "Error menyimpan info gambar ke database: " . $stmt_gambar->error;
                    $message_type = "danger";
                    // Hapus file yang sudah diupload jika gagal disimpan ke DB
                    unlink($target_file); 
                    $uploadOk = 0;
                }
                $stmt_gambar->close();
            } else {
                $message = "Maaf, terjadi kesalahan saat mengunggah gambar Anda. Pastikan folder 'uploads/artikel' memiliki izin tulis.";
                $message_type = "danger";
                $uploadOk = 0;
            }
        }
    } else if (isset($_FILES["gambar_artikel"]) && $_FILES["gambar_artikel"]["error"] != UPLOAD_ERR_NO_FILE) {
        // Jika ada error upload selain UPLOAD_ERR_NO_FILE (tidak ada file dipilih)
        $message = "Error upload gambar: " . $_FILES["gambar_artikel"]["error"];
        $message_type = "danger";
        $uploadOk = 0;
    }

    if ($uploadOk == 1 || ($_FILES["gambar_artikel"]["error"] == UPLOAD_ERR_NO_FILE)) { // Lanjutkan jika upload berhasil atau tidak ada gambar diupload
        // Insert artikel ke database
        $stmt_artikel = $conn->prepare("INSERT INTO artikel (judul_artikel, tanggal_dipublish, isi_artikel, tag, id_jenis_artikel, id_gambar_artikel) VALUES (?, ?, ?, ?, ?, ?)");
        if ($stmt_artikel) {
            $stmt_artikel->bind_param("ssssii", $judul_artikel, $tanggal_dipublish, $isi_artikel, $tag, $id_jenis_artikel, $id_gambar_artikel);

            if ($stmt_artikel->execute()) {
                $message = "Artikel berhasil ditambahkan!";
                $message_type = "success";
                // Clear form fields
                $judul_artikel = $isi_artikel = $tag = $id_jenis_artikel = '';
            } else {
                $message = "Error: " . $stmt_artikel->error;
                $message_type = "danger";
            }
            $stmt_artikel->close();
        } else {
            $message = "Error mempersiapkan statement: " . $conn->error;
            $message_type = "danger";
        }
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin GoTravel - Tambah Artikel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #5a7d7c; /* Soft teal */
            --primary-dark: #4c6867; /* Darker teal */
            --secondary: #36454F; /* Charcoal */
            --text-dark: #2c3e50; /* Very dark blue for strong text */
            --text-light: #6b7280; /* Gray for subtle text */
            --bg-light: #f9fafb; /* Off-white background */
            --border-color: #e5e7eb; /* Light border */
            --card-bg: #ffffff; /* White card background */
            --shadow-light: 0 1px 3px rgba(0,0,0,0.05), 0 1px 2px rgba(0,0,0,0.03);
            --shadow-medium: 0 4px 6px rgba(0,0,0,0.05), 0 2px 4px rgba(0,0,0,0.03);
            --border-radius-sm: 6px;
            --border-radius-md: 10px;
            --transition-speed: 0.2s;

            --success-color: #28a745; /* Green for success */
            --danger-color: #dc3545; /* Red for danger */
            --warning-color: #ffc107; /* Yellow for warning */
        }

        /* General styles */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background-color: var(--bg-light); color: var(--text-dark); line-height: 1.6; }

        /* Utilities */
        .btn {
            padding: 10px 18px; border-radius: var(--border-radius-sm); border: none; cursor: pointer;
            font-weight: 500; transition: all var(--transition-speed) ease-in-out;
            display: inline-flex; align-items: center; justify-content: center; gap: 8px;
            text-decoration: none; font-size: 0.95rem;
        }
        .btn-primary { background-color: var(--primary); color: white; }
        .btn-primary:hover { background-color: var(--primary-dark); transform: translateY(-1px); box-shadow: var(--shadow-light); }
        .btn-outline { background-color: transparent; border: 1px solid var(--border-color); color: var(--text-light); }
        .btn-outline:hover { background-color: var(--border-color); color: var(--text-dark); }
        .btn-danger { background-color: var(--danger-color); color: white; }
        .btn-danger:hover { background-color: #c0392b; transform: translateY(-1px); box-shadow: var(--shadow-light); }
        .btn-sm { padding: 8px 14px; font-size: 0.85rem; }

        /* Layout */
        main { margin-left: 220px; padding: 30px; } /* Adjust margin-left if sidebar width changes */
        
        /* Header */
        .header-container {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 30px; padding-bottom: 20px; border-bottom: 1px solid var(--border-color);
        }
        .page-title { color: var(--secondary); padding-left: 15px; border-left: 4px solid var(--primary); font-size: 2rem; font-weight: 700; }

        /* Form Section */
        .form-section {
            background-color: var(--card-bg); border-radius: var(--border-radius-md); padding: 30px;
            box-shadow: var(--shadow-medium);
        }
        .form-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
            margin-bottom: 25px;
        }
        .form-group {
            display: flex;
            flex-direction: column;
        }
        .form-label {
            font-size: 0.9rem;
            margin-bottom: 8px;
            color: var(--text-dark);
            font-weight: 600;
        }
        .form-input,
        .form-textarea,
        .form-select {
            padding: 12px 15px;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius-sm);
            font-size: 0.9rem;
            transition: all var(--transition-speed) ease-in-out;
            background-color: var(--bg-light);
            width: 100%;
        }
        .form-input:focus,
        .form-textarea:focus,
        .form-select:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(90, 125, 124, 0.1);
            background-color: white;
        }
        .form-textarea {
            resize: vertical;
            min-height: 120px;
        }
        .form-actions {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
            padding-top: 20px;
            border-top: 1px dashed var(--border-color);
            margin-top: 20px;
        }

        /* File Upload */
        .file-upload-wrapper {
            position: relative;
            display: inline-block;
            width: 100%;
        }
        .file-upload-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 15px;
            background-color: #f3f4f6; /* light gray */
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius-sm);
            cursor: pointer;
            font-size: 0.9rem;
            color: var(--text-light);
            transition: all var(--transition-speed) ease;
        }
        .file-upload-button:hover {
            background-color: #e5e7eb; /* darker gray */
        }
        .file-upload-input {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }
        .file-name {
            margin-top: 8px;
            font-size: 0.85rem;
            color: var(--text-light);
        }
        .file-preview {
            margin-top: 15px;
            max-width: 200px;
            height: auto;
            border-radius: var(--border-radius-sm);
            border: 1px solid var(--border-color);
            display: block; /* Ensure it's a block element */
        }

        /* Message Box */
        .message-box {
            padding: 15px 20px;
            margin-bottom: 20px;
            border-radius: var(--border-radius-sm);
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 500;
        }
        .message-box.success {
            background-color: #d4edda;
            color: var(--success-color);
            border: 1px solid #c3e6cb;
        }
        .message-box.danger {
            background-color: #f8d7da;
            color: var(--danger-color);
            border: 1px solid #f5c6cb;
        }
        .message-box i {
            font-size: 1.1rem;
        }

        /* Responsive */
        @media (min-width: 768px) {
            .form-grid {
                grid-template-columns: repeat(2, 1fr); /* Two columns for larger screens */
            }
            .form-group.full-width {
                grid-column: 1 / -1; /* Full width for textareas etc. */
            }
        }

        @media (max-width: 992px) { 
            main { margin-left: 0px; padding: 20px; }
            .header-container { flex-direction: column; align-items: flex-start; gap: 20px; }
            .page-title { font-size: 1.8rem; }
            .form-actions { flex-direction: column; align-items: stretch; }
            .btn { width: 100%; }
        }
        @media (max-width: 600px) {
            main { padding: 15px; }
            .form-section { padding: 20px; }
            .form-grid { grid-template-columns: 1fr; }
            .form-input, .form-textarea, .form-select, .file-upload-button { font-size: 0.85rem; padding: 10px 12px; }
            .form-label { font-size: 0.8rem; }
            .page-title { font-size: 1.5rem; }
        }
    </style>
</head>
<body>
    <?php include '../komponen/sidebar_admin.php'; // Pastikan path ini benar ?>

    <main>
        <div class="header-container">
            <h1 class="page-title">Tambah Artikel Baru</h1>
            <a href="manajemen_artikel.php" class="btn btn-outline">
                <i class="fas fa-arrow-left"></i> Kembali ke Manajemen Artikel
            </a>
        </div>

        <?php if (!empty($message)): ?>
            <div class="message-box <?php echo $message_type; ?>">
                <i class="fas <?php echo ($message_type == 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'); ?>"></i>
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <div class="form-section">
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="judul_artikel" class="form-label">Judul Artikel <span style="color: red;">*</span></label>
                        <input type="text" id="judul_artikel" name="judul_artikel" class="form-input" placeholder="Masukkan judul artikel" value="<?php echo htmlspecialchars($judul_artikel ?? ''); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="id_jenis_artikel" class="form-label">Kategori Artikel <span style="color: red;">*</span></label>
                        <select id="id_jenis_artikel" name="id_jenis_artikel" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            <?php foreach ($jenis_artikel_options as $option): ?>
                                <option value="<?php echo htmlspecialchars($option['id_jenis_artikel']); ?>" <?php echo (isset($id_jenis_artikel) && $id_jenis_artikel == $option['id_jenis_artikel']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($option['jenis_artikel']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group full-width">
                        <label for="isi_artikel" class="form-label">Isi Artikel <span style="color: red;">*</span></label>
                        <textarea id="isi_artikel" name="isi_artikel" class="form-textarea" placeholder="Tulis isi artikel lengkap di sini..." required><?php echo htmlspecialchars($isi_artikel ?? ''); ?></textarea>
                    </div>

                    <div class="form-group full-width">
                        <label for="tag" class="form-label">Tag (Pisahkan dengan koma)</label>
                        <input type="text" id="tag" name="tag" class="form-input" placeholder="Contoh: kuliner, jakarta, travel tips" value="<?php echo htmlspecialchars($tag ?? ''); ?>">
                    </div>

                    <div class="form-group full-width">
                        <label for="gambar_artikel" class="form-label">Unggah Gambar Artikel</label>
                        <div class="file-upload-wrapper">
                            <button type="button" class="file-upload-button" onclick="document.getElementById('gambar_artikel').click();">
                                <i class="fas fa-upload"></i> Pilih Gambar
                            </button>
                            <input type="file" id="gambar_artikel" name="gambar_artikel" class="file-upload-input" accept="image/*" onchange="displayFileName(this)">
                            <span id="file-name" class="file-name">Tidak ada file dipilih</span>
                        </div>
                        <small style="color: var(--text-light); margin-top: 5px;">Format: JPG, JPEG, PNG, GIF. Maks. 5MB.</small>
                        <img id="image-preview" src="#" alt="Pratinjau Gambar" class="file-preview" style="display: none;">
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Artikel
                    </button>
                    <button type="reset" class="btn btn-outline">
                        <i class="fas fa-times-circle"></i> Reset Form
                    </button>
                </div>
            </form>
        </div>
    </main>

    <script>
        function displayFileName(input) {
            const fileNameSpan = document.getElementById('file-name');
            const imagePreview = document.getElementById('image-preview');

            if (input.files && input.files[0]) {
                fileNameSpan.textContent = input.files[0].name;

                // Show image preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                fileNameSpan.textContent = 'Tidak ada file dipilih';
                imagePreview.src = '#';
                imagePreview.style.display = 'none';
            }
        }
    </script>
</body>
</html>