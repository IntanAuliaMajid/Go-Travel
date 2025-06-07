<?php
session_start();
require_once '../backend/koneksi.php';

$locations = $conn->query("SELECT id_lokasi, nama_lokasi FROM lokasi ORDER BY nama_lokasi ASC")->fetch_all(MYSQLI_ASSOC);
$languages = $conn->query("SELECT id_bahasa, nama_bahasa FROM bahasa ORDER BY nama_bahasa ASC")->fetch_all(MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_pemandu = $_POST['nama_pemandu'];
    $email = $_POST['email'];
    $telepon = $_POST['telepon'];
    $id_lokasi = (int)$_POST['id_lokasi'];
    $pengalaman = $_POST['pengalaman'];
    $biodata = $_POST['biodata'];
    $spesialisasi = $_POST['spesialisasi'];
    $bahasa_ids = isset($_POST['bahasa']) ? $_POST['bahasa'] : [];

    $foto_path_db = null;

    if (isset($_FILES['pemandu_foto']) && $_FILES['pemandu_foto']['error'] == 0) {
        $upload_dir = '../uploads/pemandu/';
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
        
        $file_info = pathinfo($_FILES['pemandu_foto']['name']);
        $file_name = uniqid('pemandu_', true) . '.' . $file_info['extension'];
        $target_file = $upload_dir . $file_name;

        if (move_uploaded_file($_FILES['pemandu_foto']['tmp_name'], $target_file)) {
            $foto_path_db = 'uploads/pemandu/' . $file_name;
        } else {
            $_SESSION['error_message'] = "Gagal memindahkan file yang di-upload.";
            header("Location: tambah_pemandu.php"); exit();
        }
    }

    $conn->begin_transaction();
    try {
        $stmt1 = $conn->prepare("INSERT INTO pemandu_wisata (nama_pemandu, email, telepon, id_lokasi, pengalaman, biodata, spesialisasi, foto_url) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt1->bind_param("sssissss", $nama_pemandu, $email, $telepon, $id_lokasi, $pengalaman, $biodata, $spesialisasi, $foto_path_db);
        $stmt1->execute();
        $id_pemandu_baru = $conn->insert_id;
        $stmt1->close();

        if (!empty($bahasa_ids)) {
            $stmt2 = $conn->prepare("INSERT INTO pemandu_bahasa (id_pemandu_wisata, id_bahasa) VALUES (?, ?)");
            foreach ($bahasa_ids as $id_bahasa) {
                $stmt2->bind_param("ii", $id_pemandu_baru, $id_bahasa);
                $stmt2->execute();
            }
            $stmt2->close();
        }

        $conn->commit();
        $_SESSION['success_message'] = "Pemandu wisata baru berhasil ditambahkan.";
        header("Location: manajemen_pemandu.php");
        exit();
    } catch (Exception $e) {
        $conn->rollback();
        if ($foto_path_db && file_exists('../' . $foto_path_db)) unlink('../' . $foto_path_db);
        $_SESSION['error_message'] = "Gagal menambahkan pemandu: " . $e->getMessage();
        header("Location: tambah_pemandu.php");
        exit();
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><title>Tambah Pemandu Wisata</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f6f9; color: #333; display: flex; justify-content: center; align-items: center; min-height: 100vh; padding: 20px; }
        .form-container { background: #fff; padding: 30px 40px; border-radius: 8px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); width: 100%; max-width: 600px; }
        h1 { text-align: center; color: #2c3e50; margin-bottom: 20px; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .form-group { margin-bottom: 15px; }
        .full-width { grid-column: 1 / -1; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: 600; color: #555; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
        .language-group { display: flex; flex-wrap: wrap; gap: 15px; border: 1px solid #ddd; padding: 10px; border-radius: 5px; }
        .language-item { display: flex; align-items: center; gap: 5px; }
        .form-actions { display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px; padding-top: 20px; border-top: 1px solid #eee; }
        .btn { padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-weight: 500; text-decoration: none; display: inline-block; }
        .btn-submit { background-color: #2ecc71; color: white; }
        .btn-cancel { background-color: #e0e0e0; color: #333; }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Tambah Pemandu Baru</h1>
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="form-grid">
                <div class="form-group"><label>Nama Pemandu</label><input type="text" name="nama_pemandu" required></div>
                <div class="form-group"><label>Email</label><input type="email" name="email" required></div>
                <div class="form-group"><label>Telepon</label><input type="tel" name="telepon"></div>
                <div class="form-group"><label>Lokasi</label><select name="id_lokasi" required><option value="">-- Pilih Lokasi --</option><?php foreach($locations as $loc): ?><option value="<?php echo $loc['id_lokasi']; ?>"><?php echo htmlspecialchars($loc['nama_lokasi']); ?></option><?php endforeach; ?></select></div>
                <div class="form-group"><label>Pengalaman (cth: 5 tahun)</label><input type="text" name="pengalaman"></div>
                <div class="form-group"><label>Spesialisasi</label><input type="text" name="spesialisasi" placeholder="cth: Tur Sejarah, Kuliner"></div>
                <div class="form-group full-width"><label>Foto Pemandu (Opsional)</label><input type="file" name="pemandu_foto" accept="image/jpeg,image/png,image/gif"></div>
                <div class="form-group full-width"><label>Biodata</label><textarea name="biodata" rows="3"></textarea></div>
                <div class="form-group full-width">
                    <label>Bahasa yang Dikuasai</label>
                    <div class="language-group">
                        <?php foreach($languages as $lang): ?>
                        <div class="language-item"><input type="checkbox" name="bahasa[]" value="<?php echo $lang['id_bahasa']; ?>" id="lang_<?php echo $lang['id_bahasa']; ?>"><label for="lang_<?php echo $lang['id_bahasa']; ?>"><?php echo htmlspecialchars($lang['nama_bahasa']); ?></label></div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="form-actions"><a href="manajemen_pemandu.php" class="btn btn-cancel">Batal</a><button type="submit" class="btn btn-submit">Simpan</button></div>
        </form>
    </div>
</body>
</html>