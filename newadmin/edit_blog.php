<?php
session_start();
require_once '../backend/koneksi.php';

// --- Inisialisasi Variabel ---
$article_id = null;
$article = null;
$kategori_options = [];
$error_message = '';
$success_message = '';

// Mengambil pesan notifikasi dari sesi
if (isset($_SESSION['success_message'])) {
    $success_message = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}
if (isset($_SESSION['error_message'])) {
    $error_message = $_SESSION['error_message'];
    unset($_SESSION['error_message']);
}

// --- Fetch Opsi Kategori ---
$result_kategori = $conn->query("SELECT id_jenis_artikel, jenis_artikel FROM jenis_artikel ORDER BY jenis_artikel ASC");
if ($result_kategori) {
    while ($row = $result_kategori->fetch_assoc()) {
        $kategori_options[] = $row;
    }
}

// --- Cek ID Artikel dari URL ---
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $article_id = (int)$_GET['id'];
} else {
    $error_message = "ID Artikel tidak valid atau tidak ditemukan.";
}

// --- Logika Handle Form Submission (UPDATE) ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['article_id'])) {
    // --- Ambil Data dari Form ---
    $posted_id = (int)$_POST['article_id'];
    $judul = trim($_POST['judul_artikel']);
    $isi = $_POST['isi_artikel']; // Tidak perlu trim, TinyMCE sudah handle
    $kategori_id = (int)$_POST['kategori'];
    $tags = trim($_POST['tag']);
    $new_gambar_id = null;

    // --- Validasi Data Teks ---
    if (empty($judul) || empty($isi) || empty($kategori_id)) {
        $error_message = "Judul, Isi Artikel, dan Kategori tidak boleh kosong.";
    } else {
        // --- PROSES UPLOAD GAMBAR BARU (JIKA ADA) ---
        if (isset($_FILES['gambar_artikel_baru']) && $_FILES['gambar_artikel_baru']['error'] == 0) {
            $upload_dir = '../uploads/artikel/'; // Pastikan folder ini ada dan writable!
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0775, true);
            }
            
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            $max_size = 5 * 1024 * 1024; // 5 MB

            $file_name = $_FILES['gambar_artikel_baru']['name'];
            $file_size = $_FILES['gambar_artikel_baru']['size'];
            $file_tmp = $_FILES['gambar_artikel_baru']['tmp_name'];
            $file_type = $_FILES['gambar_artikel_baru']['type'];
            
            // Validasi Tipe File
            if (!in_array($file_type, $allowed_types)) {
                $error_message = "Error: Tipe file tidak diizinkan. Hanya JPG, PNG, GIF, WEBP.";
            } 
            // Validasi Ukuran File
            elseif ($file_size > $max_size) {
                $error_message = "Error: Ukuran file terlalu besar. Maksimal 5 MB.";
            } else {
                // Buat nama file unik untuk menghindari tumpang tindih
                $new_file_name = uniqid('artikel_', true) . '.' . strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
                $target_file = $upload_dir . $new_file_name;

                if (move_uploaded_file($file_tmp, $target_file)) {
                    // ==========================================================
                    // PERBAIKAN BAGIAN 1: Menyimpan path relatif ke database
                    // ==========================================================
                    $path_relatif_untuk_db = 'uploads/artikel/' . $new_file_name;
                    
                    $stmt_img = $conn->prepare("INSERT INTO gambar_artikel (url) VALUES (?)");
                    if ($stmt_img) {
                        $stmt_img->bind_param("s", $path_relatif_untuk_db);
                        if ($stmt_img->execute()) {
                            $new_gambar_id = $conn->insert_id; // Dapatkan ID gambar yang baru saja di-insert
                        } else {
                             $error_message = "Gagal menyimpan data gambar ke database.";
                        }
                        $stmt_img->close();
                    }
                } else {
                    $error_message = "Gagal mengupload file gambar.";
                }
            }
        }
        
        // --- Lanjutkan ke UPDATE ARTIKEL jika tidak ada error sebelumnya ---
        if (empty($error_message)) {
            $params = [];
            $types = "";

            // Bangun query secara dinamis
            $sql_update_parts = [
                "judul_artikel = ?",
                "isi_artikel = ?",
                "id_jenis_artikel = ?",
                "tag = ?"
            ];
            $params = [$judul, $isi, $kategori_id, $tags];
            $types = "ssis";

            // Jika ada gambar baru yang berhasil diupload dan disimpan di DB
            if ($new_gambar_id !== null) {
                $sql_update_parts[] = "id_gambar_artikel = ?";
                $params[] = $new_gambar_id;
                $types .= "i";
            }
            
            $params[] = $posted_id; // Terakhir adalah ID artikel untuk klausa WHERE
            $types .= "i";

            $sql_update = "UPDATE artikel SET " . implode(", ", $sql_update_parts) . " WHERE id_artikel = ?";
            
            $stmt = $conn->prepare($sql_update);
            if ($stmt) {
                $stmt->bind_param($types, ...$params);
                if ($stmt->execute()) {
                    $_SESSION['success_message'] = "Artikel berhasil diperbarui!";
                    header("Location: " . $_SERVER['PHP_SELF'] . "?id=" . $posted_id); // Reload halaman edit
                    exit();
                } else {
                    $error_message = "Gagal memperbarui artikel: " . $stmt->error;
                }
                $stmt->close();
            } else {
                $error_message = "Gagal menyiapkan statement: " . $conn->error;
            }
        }
    }
    // Jika ada error, ID perlu di-set ulang untuk mengambil data lagi
    $article_id = $posted_id; 
}


// --- Fetch Data Artikel untuk Ditampilkan di Form ---
if ($article_id && empty($error_message)) {
    $sql_fetch = "SELECT a.id_artikel, a.judul_artikel, a.isi_artikel, a.tag, a.id_jenis_artikel,
                         ga.url AS gambar_url
                  FROM artikel a
                  LEFT JOIN gambar_artikel ga ON a.id_gambar_artikel = ga.id_gambar_artikel
                  WHERE a.id_artikel = ?
                  LIMIT 1";

    $stmt_fetch = $conn->prepare($sql_fetch);
    if ($stmt_fetch) {
        $stmt_fetch->bind_param("i", $article_id);
        if ($stmt_fetch->execute()) {
            $result = $stmt_fetch->get_result();
            if ($result->num_rows > 0) {
                $article = $result->fetch_assoc();
            } else {
                $error_message = "Artikel dengan ID " . $article_id . " tidak ditemukan.";
                $article = null;
            }
        }
        $stmt_fetch->close();
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin GoTravel - Edit Artikel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tiny.cloud/1/f8t5evd0wdqu166izusls3oby6rw52z7vd5idrxss3y1fzzj/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <style>
        :root {
            --primary: #5a7d7c; --primary-dark: #4c6867; --secondary: #36454F;
            --text-dark: #2c3e50; --text-light: #6b7280; --bg-light: #f9fafb;
            --border-color: #e5e7eb; --card-bg: #ffffff;
            --shadow-light: 0 1px 3px rgba(0,0,0,0.05), 0 1px 2px rgba(0,0,0,0.03);
            --shadow-medium: 0 4px 6px rgba(0,0,0,0.05), 0 2px 4px rgba(0,0,0,0.03);
            --border-radius-sm: 6px; --border-radius-md: 10px; --transition-speed: 0.2s;
            --success: #10b981; --danger: #ef4444;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background-color: var(--bg-light); color: var(--text-dark); line-height: 1.6; }
        main { margin-left: 220px; padding: 30px; }
        .btn {
            padding: 10px 18px; border-radius: var(--border-radius-sm); border: none; cursor: pointer;
            font-weight: 500; transition: all var(--transition-speed) ease-in-out;
            display: inline-flex; align-items: center; justify-content: center; gap: 8px;
            text-decoration: none; font-size: 0.95rem;
        }
        .btn-primary { background-color: var(--primary); color: white; }
        .btn-primary:hover { background-color: var(--primary-dark); }
        .btn-outline { background-color: transparent; border: 1px solid var(--border-color); color: var(--text-light); }
        .btn-outline:hover { background-color: var(--border-color); color: var(--text-dark); }

        .header-container {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 30px; padding-bottom: 20px; border-bottom: 1px solid var(--border-color);
        }
        .page-title { color: var(--secondary); padding-left: 15px; border-left: 4px solid var(--primary); font-size: 2rem; font-weight: 700; }

        .form-container {
            background-color: var(--card-bg); border-radius: var(--border-radius-md); padding: 30px;
            box-shadow: var(--shadow-medium);
        }
        .form-grid { display: grid; grid-template-columns: 1fr; gap: 25px; }
        .form-group { display: flex; flex-direction: column; }
        .form-label { font-size: 0.9rem; margin-bottom: 8px; color: var(--text-dark); font-weight: 600; }
        .form-input, .form-textarea, .form-select {
            padding: 12px 15px; border: 1px solid var(--border-color);
            border-radius: var(--border-radius-sm); font-size: 0.95rem; transition: all var(--transition-speed) ease-in-out;
            background-color: var(--bg-light); width: 100%;
        }
        .form-input:focus, .form-textarea:focus, .form-select:focus { 
            border-color: var(--primary); outline: none; box-shadow: 0 0 0 3px rgba(90, 125, 124, 0.1); background-color: white; 
        }
        .form-hint { font-size: 0.8rem; color: var(--text-light); margin-top: 8px; }

        .form-actions { 
            display: flex; gap: 12px; justify-content: flex-end; padding-top: 25px; 
            margin-top: 25px; border-top: 1px solid var(--border-color);
        }

        .alert {
            padding: 15px 20px; margin-bottom: 20px; border-radius: var(--border-radius-sm);
            border: 1px solid transparent; font-weight: 500;
            display: flex; align-items: center; gap: 15px;
        }
        .alert-danger { background-color: #fee2e2; border-color: #fca5a5; color: #991b1b; }
        .alert-success { background-color: #d1fae5; border-color: #6ee7b7; color: #065f46; }
        .alert i { font-size: 1.2rem; }

        .image-preview-group { display: flex; align-items: flex-start; gap: 20px; }
        .image-preview-current { text-align: center; }
        .image-preview {
            width: 150px; height: 100px; object-fit: cover; border-radius: var(--border-radius-sm);
            border: 1px solid var(--border-color); background-color: #e9ecef;
        }
        .form-input-file {
            border: 2px dashed var(--border-color); background-color: #f9fafb;
            padding: 20px; text-align: center; cursor: pointer;
            transition: background-color var(--transition-speed);
        }
        .form-input-file:hover { background-color: #f3f4f6; border-color: var(--primary); }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <?php include '../komponen/sidebar_admin.php'; ?>

    <main>
        <div class="header-container">
            <h1 class="page-title">Edit Artikel</h1>
            <a href="blog.php" class="btn btn-outline"> <i class="fas fa-arrow-left"></i> Kembali ke Manajemen
            </a>
        </div>

        <?php if ($error_message): ?>
            <div class="alert alert-danger"><i class="fas fa-times-circle"></i> <?php echo $error_message; ?></div>
        <?php endif; ?>
        <?php if ($success_message): ?>
            <div class="alert alert-success"><i class="fas fa-check-circle"></i> <?php echo $success_message; ?></div>
        <?php endif; ?>

        <?php if ($article): ?>
        <div class="form-container">
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . '?id=' . $article_id; ?>" enctype="multipart/form-data">
                <input type="hidden" name="article_id" value="<?php echo $article['id_artikel']; ?>">

                <div class="form-grid">
                    <div class="form-group">
                        <label for="judul_artikel" class="form-label">Judul Artikel</label>
                        <input type="text" name="judul_artikel" id="judul_artikel" class="form-input" 
                               value="<?php echo htmlspecialchars($article['judul_artikel']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="kategori" class="form-label">Kategori</label>
                        <select name="kategori" id="kategori" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            <?php foreach($kategori_options as $kategori): ?>
                                <option value="<?php echo $kategori['id_jenis_artikel']; ?>" 
                                    <?php echo ($article['id_jenis_artikel'] == $kategori['id_jenis_artikel']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($kategori['jenis_artikel']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Gambar Utama</label>
                        <div class="image-preview-group">
                            <div class="image-preview-current">
                                <?php
                                    // ==========================================================
                                    // PERBAIKAN BAGIAN 2: Logika "pintar" untuk menampilkan gambar
                                    // ==========================================================
                                    $gambar_src = 'https://via.placeholder.com/150x100?text=No+Image'; // Gambar default
                                    if (!empty($article['gambar_url'])) {
                                        $url = $article['gambar_url'];
                                        // Jika URL adalah link eksternal (dimulai dengan http atau https)
                                        if (strpos($url, 'http') === 0) {
                                            $gambar_src = htmlspecialchars($url);
                                        }
                                        // Jika tidak, berarti itu adalah path lokal
                                        else {
                                            // Tambahkan ../ karena skrip ini ada di dalam folder 'newadmin'
                                            $gambar_src = '../' . htmlspecialchars($url);
                                        }
                                    }
                                ?>
                                <img src="<?php echo $gambar_src; ?>" 
                                     alt="Gambar Saat Ini" class="image-preview" id="preview-image">
                                <small class="form-hint">Gambar saat ini</small>
                            </div>
                            <div class="form-group" style="flex: 1;">
                                <label for="gambar_artikel_baru" class="form-label">Ganti Gambar (Opsional)</label>
                                <input type="file" name="gambar_artikel_baru" id="gambar_artikel_baru" class="form-input" 
                                       accept="image/png, image/jpeg, image/gif, image/webp">
                                <small class="form-hint">Biarkan kosong jika tidak ingin mengubah gambar. Maks. 5MB.</small>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="tag" class="form-label">Tag (Destinasi / Topik)</label>
                        <input type="text" name="tag" id="tag" class="form-input" 
                               value="<?php echo htmlspecialchars($article['tag']); ?>">
                        <small class="form-hint">Pisahkan setiap tag dengan koma (,).</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="isi_artikel_editor" class="form-label">Isi Artikel</label>
                        <textarea name="isi_artikel" id="isi_artikel_editor"><?php echo htmlspecialchars($article['isi_artikel']); ?></textarea>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="manajemen_blog.php" class="btn btn-outline">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Artikel
                    </button>
                </div>
            </form>
        </div>
        <?php elseif(empty($error_message)): ?>
            <div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> Memuat data atau artikel tidak ditemukan.</div>
        <?php endif; ?>

    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inisialisasi TinyMCE
            tinymce.init({
                selector: '#isi_artikel_editor',
                plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
                toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
                height: 400,
            });

            // Script untuk preview gambar saat dipilih
            const fileInput = document.getElementById('gambar_artikel_baru');
            const previewImage = document.getElementById('preview-image');
            
            if(fileInput && previewImage) {
                fileInput.addEventListener('change', function(event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            previewImage.src = e.target.result;
                        }
                        reader.readAsDataURL(file);
                    }
                });
            }
        });
    </script>
</body>
</html>