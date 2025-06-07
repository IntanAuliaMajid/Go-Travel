<?php
// File: ../newadmin/kelola_wisata.php

// Pastikan sesi dimulai untuk mengakses pesan status
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../backend/koneksi.php'; // Sesuaikan path jika perlu

// --- Fetch Wisata Data ---
$wisata_list = [];
// Query untuk mengambil data wisata beserta lokasi, kategori, dan satu gambar utama
$sql = "SELECT
            w.id_wisata,
            w.nama_wisata,
            w.deskripsi_wisata,
            l.nama_lokasi,
            kw.nama_kategori,
            (SELECT g.url FROM gambar g WHERE g.wisata_id = w.id_wisata ORDER BY g.id_gambar ASC LIMIT 1) AS gambar_url
        FROM wisata w
        LEFT JOIN lokasi l ON w.id_lokasi = l.id_lokasi
        LEFT JOIN kategori_wisata kw ON w.kategori_id = kw.id_kategori
        ORDER BY w.id_wisata DESC";

$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $wisata_list[] = $row;
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Kelola Wisata</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Menggunakan gaya yang sama dengan halaman kelola_paket.php untuk konsistensi */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f6f9; min-height: 100vh; color: #333; }
        .main-content { margin-left: 220px; padding: 25px; transition: margin-left 0.3s ease; }
        .page-header { background: #ffffff; padding: 20px 25px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05); margin-bottom: 25px; display: flex; justify-content: space-between; align-items: center; }
        .page-title { color: #2c3e50; font-size: 1.7rem; font-weight: 600; display: flex; align-items: center; }
        .page-title i { margin-right: 10px; color: #27ae60; } /* Warna ikon diubah */
        .btn-primary-header { background-color: #27ae60; color: white; padding: 10px 20px; border: none; border-radius: 6px; text-decoration: none; display: inline-flex; align-items: center; font-weight: 500; font-size: 0.9rem; transition: all 0.2s ease; }
        .btn-primary-header:hover { background-color: #229954; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); transform: translateY(-1px); }
        .btn-primary-header i { margin-right: 8px; }
        .card { background: #ffffff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05); overflow: hidden; }
        .table-container { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        thead { background-color: #343a40; }
        th { padding: 14px 15px; text-align: left; color: white; font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px; }
        td { padding: 12px 15px; border-bottom: 1px solid #e9ecef; color: #495057; font-size: 0.9rem; vertical-align: middle; }
        tbody tr:hover { background-color: #f8f9fa; }
        .action-buttons { display: flex; gap: 6px; }
        .btn { padding: 7px 10px; border: none; border-radius: 5px; font-size: 0.8rem; font-weight: 500; cursor: pointer; transition: all 0.2s ease; text-decoration: none; display: inline-flex; align-items: center; gap: 5px; }
        .btn-edit { background-color: #f39c12; color: white; }
        .btn-delete { background-color: #e74c3c; color: white; }
        .btn:hover { opacity: 0.85; transform: translateY(-1px); }
        .wisata-info { display: flex; align-items: center; gap: 15px; }
        .wisata-info img { width: 80px; height: 55px; border-radius: 6px; object-fit: cover; flex-shrink: 0; }
        .wisata-name strong { color: #2c3e50; font-weight: 500; font-size: 0.95rem; }
        .wisata-name small { color: #6c757d; font-size: 0.8rem; display: block; margin-top: 3px; }
        .location-badge { background-color: rgba(231, 76, 60, 0.1); color: #e74c3c; padding: 5px 10px; border-radius: 15px; font-size: 0.8rem; font-weight: 500; display: inline-block; }
        .category-badge { background-color: rgba(52, 152, 219, 0.1); color: #3498db; padding: 5px 10px; border-radius: 15px; font-size: 0.8rem; font-weight: 500; display: inline-block; }
        /* Style untuk pesan status */
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
    <?php include '../komponen/sidebar_admin.php'; // Pastikan path ini benar ?>

    <main class="main-content">
        <div class="page-header">
            <h1 class="page-title">
                <i class="fas fa-mountain"></i>
                Kelola Wisata
            </h1>
            <a href="tambah_wisata.php" class="btn-primary-header">
                <i class="fas fa-plus"></i>
                Tambah Wisata
            </a>
        </div>

        <?php
        // Menampilkan pesan status dari session (setelah operasi hapus, tambah, edit)
        if (isset($_SESSION['message'])) {
            echo "<div class='message " . htmlspecialchars($_SESSION['message_type']) . "'>" . htmlspecialchars($_SESSION['message']) . "</div>";
            unset($_SESSION['message']); // Hapus pesan setelah ditampilkan
            unset($_SESSION['message_type']); // Hapus tipe pesan juga
        }
        ?>

        <div class="card">
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th style="width: 40%;">Wisata</th>
                            <th style="width: 20%;">Lokasi</th>
                            <th style="width: 20%;">Kategori</th>
                            <th style="width: 15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($wisata_list)): ?>
                            <?php $no = 1; ?>
                            <?php foreach ($wisata_list as $wisata): ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td>
                                    <div class="wisata-info">
                                        <?php
                                        $gambar_display_url = !empty($wisata['gambar_url']) ? htmlspecialchars($wisata['gambar_url']) : 'https://placehold.co/80x55/e0e0e0/757575?text=N/A';
                                        // Path di DB disimpan relatif ke root proyek, misal '../uploads/wisata/gambar.jpg'
                                        // Dari kelola_wisata.php (newadmin/), ini akan menjadi 'uploads/wisata/gambar.jpg'
                                        // Kita perlu membuang satu level '..' dari awal path DB jika memang ada.
                                        $final_image_src = $gambar_display_url; // Mengganti '../' menjadi './' untuk path relatif dari current directory
                                        ?>
                                        <img src="<?php echo $final_image_src; ?>" alt="<?php echo htmlspecialchars($wisata['nama_wisata']); ?>" onerror="this.onerror=null;this.src='https://placehold.co/80x55/e0e0e0/757575?text=Error';">
                                        <div class="wisata-name">
                                            <strong><?php echo htmlspecialchars($wisata['nama_wisata']); ?></strong>
                                            <small>
                                                <?php
                                                $deskripsi_singkat = strip_tags($wisata['deskripsi_wisata']);
                                                echo htmlspecialchars(substr($deskripsi_singkat, 0, 70)) . (strlen($deskripsi_singkat) > 70 ? '...' : '');
                                                ?>
                                            </small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="location-badge"><?php echo htmlspecialchars($wisata['nama_lokasi'] ?? 'N/A'); ?></span>
                                </td>
                                <td>
                                    <span class="category-badge"><?php echo htmlspecialchars($wisata['nama_kategori'] ?? 'N/A'); ?></span>
                                </td>
                                <td>
                                    <div class='action-buttons'>
                                        <a href='edit_wisata.php?id=<?php echo $wisata['id_wisata']; ?>' class='btn btn-edit'>
                                            <i class='fas fa-edit'></i> Edit
                                        </a>
                                        <a href='../backend/hapus_wisata.php?id=<?php echo $wisata['id_wisata']; ?>' class='btn btn-delete' onclick='return confirm("Yakin ingin menghapus data wisata: <?php echo htmlspecialchars(addslashes($wisata['nama_wisata'])); ?>? Aksi ini tidak dapat dibatalkan.")'>
                                            <i class='fas fa-trash'></i> Hapus
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php $no++; ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 20px;">Belum ada data wisata yang ditambahkan.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

</body>
</html>