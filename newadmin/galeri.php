<?php
session_start();
require_once '../backend/koneksi.php';

// --- Ambil semua data dari tabel 'galeri' yang baru ---
$gallery_items = [];
$sql = "SELECT id_galeri, judul, kategori, tipe_file, path_file 
        FROM galeri 
        ORDER BY tanggal_upload DESC";

$result = $conn->query($sql);
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $gallery_items[] = $row;
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Manajemen Galeri</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Menggunakan style yang sama persis dengan modul lain */
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f6f9; color: #333; margin: 0; }
        .main-content { margin-left: 250px; padding: 30px; }
        .dashboard-header { display: flex; justify-content: space-between; align-items: center; background: white; border-radius: 8px; padding: 20px; margin-bottom: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .dashboard-header h1 { margin: 0; color: #2c3e50; }
        .btn-add { background-color: #3498db; color: white; border: none; padding: 10px 18px; border-radius: 6px; cursor: pointer; text-decoration: none; display: flex; align-items: center; gap: 8px; }
        .galeri-container { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px; }
        .item-card { background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); position: relative; display: flex; flex-direction: column; }
        .media-container { width: 100%; height: 200px; background-color: #2c3e50; position: relative; }
        .media-container img, .media-container video { width: 100%; height: 100%; object-fit: cover; }
        .media-type-icon { position: absolute; top: 10px; right: 10px; color: white; background-color: rgba(0,0,0,0.5); padding: 5px 8px; border-radius: 5px; font-size: 0.8em; }
        .item-card .info { padding: 15px; flex-grow: 1; }
        .item-card .info h5 { margin: 0 0 5px 0; color: #333; }
        .item-card .info .badge { display: inline-block; background-color: #e9ecef; color: #495057; padding: 3px 10px; border-radius: 12px; font-size: 0.8em; font-weight: 500; }
        .item-card .actions { display: flex; justify-content: flex-end; padding: 10px; background: #f8f9fa; border-top: 1px solid #f0f0f0; }
        .item-card .btn-delete { background-color: #e74c3c; color: white; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer; font-size: 0.85em; text-decoration: none; display: inline-flex; align-items: center; gap: 5px; }
        .alert { padding: 15px; margin-bottom: 20px; border-radius: 6px; font-weight: 500; }
        .alert-success { color: #155724; background-color: #d4edda; }
        .alert-danger { color: #721c24; background-color: #f8d7da; }
    </style>
</head>
<body>
  <?php include '../komponen/sidebar_admin.php'; ?>

  <div class="main-content">
    <header class="dashboard-header">
      <h1>📸 Kelola Galeri</h1>
      <a href="../backend/tambah_galeri_baru.php" class="btn-add"><i class="fas fa-plus"></i> Tambah Media</a>
    </header>

    <?php
        if (isset($_SESSION['success_message'])) {
            echo '<div class="alert alert-success">' . htmlspecialchars($_SESSION['success_message']) . '</div>';
            unset($_SESSION['success_message']);
        }
        if (isset($_SESSION['error_message'])) {
            echo '<div class="alert alert-danger">' . htmlspecialchars($_SESSION['error_message']) . '</div>';
            unset($_SESSION['error_message']);
        }
    ?>

    <div class="galeri-container">
        <?php if (!empty($gallery_items)): ?>
            <?php foreach ($gallery_items as $item): ?>
                <div class="item-card">
                    <div class="media-container">
                        <?php if ($item['tipe_file'] == 'gambar'): ?>
                            <img src="../<?php echo htmlspecialchars($item['path_file']); ?>" alt="<?php echo htmlspecialchars($item['judul']); ?>">
                            <span class="media-type-icon"><i class="fas fa-image"></i> Gambar</span>
                        <?php else: ?>
                            <video width="100%" height="100%" controls>
                                <source src="../<?php echo htmlspecialchars($item['path_file']); ?>" type="video/mp4">
                                Browser Anda tidak mendukung tag video.
                            </video>
                            <span class="media-type-icon"><i class="fas fa-video"></i> Video</span>
                        <?php endif; ?>
                    </div>
                    <div class="info">
                        <h5><?php echo htmlspecialchars($item['judul']); ?></h5>
                        <?php if (!empty($item['kategori'])): ?>
                            <p><span class="badge"><?php echo htmlspecialchars($item['kategori']); ?></span></p>
                        <?php endif; ?>
                    </div>
                    <div class="actions">
                        <a href="../backend/hapus_galeri_baru.php?id=<?php echo $item['id_galeri']; ?>" class="btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus media ini?');">
                            <i class="fas fa-trash"></i> Hapus
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Belum ada media di galeri. Silakan tambahkan media baru.</p>
        <?php endif; ?>
    </div>
  </div>
</body>
</html>