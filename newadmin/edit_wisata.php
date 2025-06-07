<?php
session_start();
require_once '../backend/koneksi.php';

// DEFINISIKAN PATH UPLOAD
define('UPLOAD_DIR_WISATA', __DIR__ . '/../uploads/wisata/');
define('UPLOAD_URL_WISATA', '../uploads/wisata/');
define('UPLOAD_DIR_DENAH', __DIR__ . '/../uploads/denah/');
define('UPLOAD_URL_DENAH', '../uploads/denah/');

// Pastikan direktori upload ada
if (!is_dir(UPLOAD_DIR_DENAH)) mkdir(UPLOAD_DIR_DENAH, 0777, true);
if (!is_dir(UPLOAD_DIR_WISATA)) mkdir(UPLOAD_DIR_WISATA, 0777, true);

// Validasi ID Wisata
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) die("Error: ID Wisata tidak valid.");
$id_wisata = (int)$_GET['id'];

// Update Caption Gambar
if (isset($_POST['update_caption'])) {
    $stmt = $conn->prepare("UPDATE gambar SET caption = ? WHERE id_gambar = ?");
    $stmt->bind_param("si", $_POST['caption_gambar'], $_POST['id_gambar']);
    $_SESSION['success_message'] = $stmt->execute() ? "Caption berhasil diperbarui." : "Gagal memperbarui caption.";
    $stmt->close();
    header("Location: edit_wisata.php?id=$id_wisata"); exit();
}

// Hapus Gambar
if (isset($_POST['delete_gambar'])) {
    $stmt = $conn->prepare("DELETE FROM gambar WHERE id_gambar = ?");
    $stmt->bind_param("i", $_POST['id_gambar']);
    if ($stmt->execute()) {
        $file_path = str_replace(UPLOAD_URL_WISATA, UPLOAD_DIR_WISATA, $_POST['url_gambar']);
        if (file_exists($file_path)) unlink($file_path);
        $_SESSION['success_message'] = "Gambar berhasil dihapus.";
    } else {
        $_SESSION['error_message'] = "Gagal menghapus gambar.";
    }
    $stmt->close();
    header("Location: edit_wisata.php?id=$id_wisata"); exit();
}

// Tambah Gambar Baru
if (isset($_POST['add_gambar']) && isset($_FILES['gambar_file']) && $_FILES['gambar_file']['error'] == 0) {
    $file = $_FILES['gambar_file'];
    $caption = $_POST['caption_gambar'];
    $allowed = ['image/jpeg','image/png','image/gif','image/webp'];

    if (!in_array($file['type'], $allowed) || $file['size'] > 2000000) {
        $_SESSION['error_message'] = "File tidak valid.";
    } else {
        $new_name = 'wisata_' . $id_wisata . '_' . uniqid() . '_' . basename($file['name']);
        $target = UPLOAD_DIR_WISATA . $new_name;

        if (move_uploaded_file($file['tmp_name'], $target)) {
            $url = UPLOAD_URL_WISATA . $new_name;
            $stmt = $conn->prepare("INSERT INTO gambar (wisata_id, url, caption) VALUES (?, ?, ?)");
            $stmt->bind_param("iss", $id_wisata, $url, $caption);
            $_SESSION['success_message'] = $stmt->execute() ? "Gambar berhasil di-upload." : "Gagal menyimpan gambar.";
            $stmt->close();
        } else {
            $_SESSION['error_message'] = "Gagal upload file.";
        }
    }
    header("Location: edit_wisata.php?id=$id_wisata"); exit();
}

// Ambil data wisata
$stmt = $conn->prepare("SELECT * FROM wisata WHERE id_wisata = ?");
$stmt->bind_param("i", $id_wisata);
$stmt->execute();
$wisata = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$wisata) die("Data wisata tidak ditemukan.");

// Update data wisata utama
if (isset($_POST['update_wisata'])) {
    $nama = $_POST['nama_wisata'];
    $deskripsi = $_POST['deskripsi_wisata'];
    $alamat = $_POST['Alamat'];
    $telepon = $_POST['telepon'];
    $lokasi_id = !empty($_POST['id_lokasi']) ? $_POST['id_lokasi'] : NULL;
    $kategori_id = !empty($_POST['kategori_id']) ? $_POST['kategori_id'] : NULL;
    $todo = $_POST['todo'];
    $aksesibilitas = $_POST['info_aksesibilitas'];
    $denah = $wisata['denah'];

    if (isset($_FILES['gambar_denah']) && $_FILES['gambar_denah']['error'] == UPLOAD_ERR_OK) {
        $file = $_FILES['gambar_denah'];
        $allowed = ['image/jpeg','image/png','image/gif','image/webp'];

        if (in_array($file['type'], $allowed) && $file['size'] <= 2000000) {
            $new_denah = 'denah_' . $id_wisata . '_' . uniqid() . '_' . basename($file['name']);
            $target_denah = UPLOAD_DIR_DENAH . $new_denah;

            if (move_uploaded_file($file['tmp_name'], $target_denah)) {
                $denah = UPLOAD_URL_DENAH . $new_denah;
                $old_path = str_replace(UPLOAD_URL_DENAH, UPLOAD_DIR_DENAH, $wisata['denah']);
                if (file_exists($old_path)) unlink($old_path);
            } else {
                $_SESSION['error_message'] = "Gagal upload denah.";
            }
        } else {
            $_SESSION['error_message'] = "Denah tidak valid.";
        }
    }

    $stmt = $conn->prepare("UPDATE wisata SET nama_wisata=?, deskripsi_wisata=?, Alamat=?, telepon=?, id_lokasi=?, kategori_id=?, todo=?, info_aksesibilitas=?, denah=? WHERE id_wisata=?");
    $stmt->bind_param("ssssiisssi", $nama, $deskripsi, $alamat, $telepon, $lokasi_id, $kategori_id, $todo, $aksesibilitas, $denah, $id_wisata);
    $_SESSION['success_message'] = $stmt->execute() ? "Data wisata berhasil diperbarui." : "Gagal memperbarui data.";
    $stmt->close();
    header("Location: edit_wisata.php?id=$id_wisata"); exit();
}

// Fetch data tambahan
function fetchData($conn, $sql) {
    $result = $conn->query($sql); $data = [];
    if ($result) while ($row = $result->fetch_assoc()) $data[] = $row;
    return $data;
}

$lokasi_list = fetchData($conn, "SELECT id_lokasi, nama_lokasi FROM lokasi ORDER BY nama_lokasi ASC");
$kategori_list = fetchData($conn, "SELECT id_kategori, nama_kategori FROM kategori_wisata ORDER BY nama_kategori ASC");
$gambar_list = fetchData($conn, "SELECT * FROM gambar WHERE wisata_id = $id_wisata ORDER BY id_gambar ASC");

$success_message = $_SESSION['success_message'] ?? null;
$error_message = $_SESSION['error_message'] ?? null;
unset($_SESSION['success_message'], $_SESSION['error_message']);

$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Edit Wisata</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root { --primary-color: #27ae60; --danger-color: #e74c3c; --light-bg: #f4f6f9; --white-bg: #ffffff; --dark-text: #2c3e50; --light-text: #6c757d; --blue-color: #3498db; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: var(--light-bg); color: #333; }
        .main-content { margin-left: 220px; padding: 25px; }
        .page-header { background: var(--white-bg); padding: 20px 25px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-bottom: 25px; display: flex; justify-content: space-between; align-items: center; }
        .page-title { color: var(--dark-text); font-size: 1.7rem; font-weight: 600; }
        .page-title i { margin-right: 10px; color: var(--primary-color); }
        .btn-secondary-header { background-color: var(--light-text); color: white; padding: 10px 20px; border-radius: 6px; text-decoration: none; display: inline-flex; align-items: center; font-weight: 500; transition: background-color 0.2s; }
        .btn-secondary-header:hover { background-color: #5a6268; }
        .btn-secondary-header i { margin-right: 8px; }
        .card { background: var(--white-bg); border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-bottom: 25px; overflow: hidden; }
        .card-header { padding: 15px 20px; background-color: #f8f9fa; border-bottom: 1px solid #e9ecef; font-size: 1.1rem; font-weight: 600; color: var(--dark-text); }
        .card-header i { margin-right: 10px; }
        .card-body { padding: 20px; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .form-group { display: flex; flex-direction: column; }
        .form-group.full-width { grid-column: 1 / -1; }
        .form-group label { margin-bottom: 8px; font-weight: 600; color: #495057; }
        .form-control { width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 5px; transition: border-color 0.2s, box-shadow 0.2s; }
        .form-control:focus { border-color: var(--primary-color); outline: none; box-shadow: 0 0 0 2px rgba(39, 174, 96, 0.2); }
        textarea.form-control { min-height: 120px; resize: vertical; }
        .btn-submit { background-color: var(--primary-color); color: white; padding: 12px 25px; border: none; border-radius: 6px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: background-color 0.2s; }
        .btn-submit:hover { background-color: #229954; }
        .alert { padding: 15px; margin-bottom: 20px; border-radius: 6px; }
        .alert-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-danger { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .image-gallery { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 15px; margin-bottom: 20px;}
        .image-card { border: 1px solid #e9ecef; border-radius: 8px; overflow: hidden; position: relative; display: flex; flex-direction: column;}
        .image-card img { width: 100%; height: 150px; object-fit: cover; display: block; }
        .image-card-form { padding: 10px; background: #f8f9fa; flex-grow: 1; display: flex; flex-direction: column; gap: 8px; }
        .caption-input { padding: 8px; border: 1px solid #ddd; border-radius: 4px; width: 100%; font-size: 0.85rem; }
        .btn-caption-save { background-color: var(--blue-color); color: white; border: none; padding: 6px 10px; font-size: 0.8rem; border-radius: 4px; cursor: pointer; transition: background-color 0.2s; }
        .btn-caption-save:hover { background-color: #2980b9; }
        .image-card-delete { position: absolute; top: 5px; right: 5px; }
        .btn-delete { background: none; border: none; color: var(--danger-color); cursor: pointer; font-size: 1.1rem; }
        .image-card-delete .btn-delete { background-color: rgba(255, 255, 255, 0.8); border-radius: 50%; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; font-size: 0.9rem; }
        .details-form { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px; align-items: flex-end; border-top: 1px solid #e9ecef; padding-top: 20px; margin-top: 20px; }
        .btn-add { background-color: var(--primary-color); color: white; border: none; padding: 10px 15px; border-radius: 5px; cursor: pointer; }
        .denah-preview { margin-top: 10px; }
        .denah-preview img { max-width: 250px; max-height: 250px; border-radius: 6px; border: 1px solid #ddd; padding: 5px; }
        .denah-preview p { font-style: italic; color: var(--light-text); font-size: 0.9em; }
    </style>
</head>
<body>
    <?php include '../komponen/sidebar_admin.php'; ?>
    <main class="main-content">
        <div class="page-header">
            <h1 class="page-title"><i class="fas fa-edit"></i> Edit Wisata</h1>
            <a href="wisata.php" class="btn-secondary-header"><i class="fas fa-arrow-left"></i> Kembali</a>
        </div>
        <?php if ($success_message): ?> <div class="alert alert-success"><?php echo htmlspecialchars($success_message); ?></div> <?php endif; ?>
        <?php if ($error_message): ?> <div class="alert alert-danger"><?php echo htmlspecialchars($error_message); ?></div> <?php endif; ?>
        
        <form action="edit_wisata.php?id=<?php echo $id_wisata; ?>" method="POST" enctype="multipart/form-data">
            <div class="card">
                <div class="card-header"><i class="fas fa-info-circle"></i> Data Wisata</div>
                <div class="card-body">
                    <input type="hidden" name="update_wisata" value="1">
                    <div class="form-grid">
                        <div class="form-group full-width"><label for="nama_wisata">Nama Wisata</label><input type="text" id="nama_wisata" name="nama_wisata" class="form-control" value="<?php echo htmlspecialchars($wisata['nama_wisata'] ?? ''); ?>" required></div>
                        <div class="form-group"><label for="id_lokasi">Lokasi</label><select id="id_lokasi" name="id_lokasi" class="form-control"><option value="">-- Pilih Lokasi --</option><?php foreach($lokasi_list as $item): ?><option value="<?php echo $item['id_lokasi']; ?>" <?php if($item['id_lokasi'] == $wisata['id_lokasi']) echo 'selected'; ?>><?php echo htmlspecialchars($item['nama_lokasi']); ?></option><?php endforeach; ?></select></div>
                        <div class="form-group"><label for="kategori_id">Kategori</label><select id="kategori_id" name="kategori_id" class="form-control"><option value="">-- Pilih Kategori --</option><?php foreach($kategori_list as $item): ?><option value="<?php echo $item['id_kategori']; ?>" <?php if($item['id_kategori'] == $wisata['kategori_id']) echo 'selected'; ?>><?php echo htmlspecialchars($item['nama_kategori']); ?></option><?php endforeach; ?></select></div>
                        <div class="form-group full-width"><label for="deskripsi_wisata">Deskripsi</label><textarea id="deskripsi_wisata" name="deskripsi_wisata" class="form-control" rows="5"><?php echo htmlspecialchars($wisata['deskripsi_wisata'] ?? ''); ?></textarea></div>
                        
                        <div class="form-group full-width"><label for="Alamat">Alamat Lengkap</label><textarea id="Alamat" name="Alamat" class="form-control" rows="3"><?php echo htmlspecialchars($wisata['Alamat'] ?? ''); ?></textarea></div>

                        <div class="form-group"><label for="telepon">Telepon</label><input type="text" id="telepon" name="telepon" class="form-control" value="<?php echo htmlspecialchars($wisata['telepon'] ?? ''); ?>"></div>
                        <div class="form-group"><label for="todo">Aktivitas (To-do, pisahkan dengan koma)</label><input type="text" id="todo" name="todo" class="form-control" value="<?php echo htmlspecialchars($wisata['todo'] ?? ''); ?>"></div>
                        <div class="form-group full-width"><label for="info_aksesibilitas">Info Aksesibilitas</label><textarea id="info_aksesibilitas" name="info_aksesibilitas" class="form-control" rows="3"><?php echo htmlspecialchars($wisata['info_aksesibilitas'] ?? ''); ?></textarea></div>
                        
                        <div class="form-group full-width">
                            <label for="gambar_denah">Gambar Denah</label>
                            <?php if (!empty($wisata['denah'])): ?>
                                <div class="denah-preview">
                                    <p>Denah Saat Ini:</p>
                                    <img src="<?php echo htmlspecialchars($wisata['denah']); ?>" alt="Pratinjau Denah">
                                </div>
                            <?php endif; ?>
                            <input type="file" id="gambar_denah" name="gambar_denah" class="form-control" style="margin-top: 10px;">
                            <small style="color: var(--light-text); margin-top: 5px;">*Kosongkan jika tidak ingin mengganti gambar denah.</small>
                        </div>
                    </div>
                    <div style="text-align:right; margin-top:20px;">
                        <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Simpan Perubahan</button>
                    </div>
                </div>
            </div>
        </form>

        <div class="card">
            <div class="card-header"><i class="fas fa-images"></i> Kelola Gambar Wisata</div>
            <div class="card-body">
                <div class="image-gallery">
                    <?php if(!empty($gambar_list)): ?>
                        <?php foreach($gambar_list as $gambar): ?>
                            <div class="image-card">
                                <img src="<?php echo htmlspecialchars($gambar['url']); ?>" alt="<?php echo htmlspecialchars($gambar['caption'] ?? ''); ?>">
                                <form action="edit_wisata.php?id=<?php echo $id_wisata; ?>" method="POST" class="image-card-form">
                                    <input type="hidden" name="id_gambar" value="<?php echo $gambar['id_gambar']; ?>">
                                    <input type="text" name="caption_gambar" class="caption-input" placeholder="Edit caption..." value="<?php echo htmlspecialchars($gambar['caption'] ?? ''); ?>">
                                    <button type="submit" name="update_caption" class="btn-caption-save"><i class="fas fa-check"></i> Simpan</button>
                                </form>
                                <div class="image-card-delete">
                                    <form action="edit_wisata.php?id=<?php echo $id_wisata; ?>" method="POST" onsubmit="return confirm('Yakin ingin menghapus gambar ini?');">
                                        <input type="hidden" name="id_gambar" value="<?php echo $gambar['id_gambar']; ?>">
                                        <input type="hidden" name="url_gambar" value="<?php echo htmlspecialchars($gambar['url']); ?>">
                                        <button type="submit" name="delete_gambar" class="btn-delete" title="Hapus Gambar"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Belum ada gambar untuk wisata ini.</p>
                    <?php endif; ?>
                </div>

                <form action="edit_wisata.php?id=<?php echo $id_wisata; ?>" method="POST" class="details-form" enctype="multipart/form-data">
                    <input type="hidden" name="add_gambar" value="1">
                    <div class="form-group" style="grid-column: 1 / span 2;">
                        <label>Upload Gambar Baru</label>
                        <input type="file" name="gambar_file" class="form-control" required>
                    </div>
                    <div class="form-group" style="grid-column: 1 / span 2;">
                        <label>Caption Gambar (Opsional)</label>
                        <input type="text" name="caption_gambar" class="form-control" placeholder="Contoh: Pemandangan dari Puncak">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn-add"><i class="fas fa-upload"></i> Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>