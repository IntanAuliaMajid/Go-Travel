<?php
require_once '../backend/koneksi.php'; // Sesuaikan path jika perlu

// --- Helper Functions ---
function format_rupiah($number) {
    return "Rp " . number_format($number, 0, ',', '.');
}

// --- Fetch Tour Packages ---
$paket_wisata_list = [];
$sql = "SELECT
            pw.id_paket_wisata,
            pw.nama_paket,
            pw.deskripsi,
            w.nama_wilayah AS destinasi,
            pw.harga,
            pw.durasi_paket
        FROM paket_wisata pw
        LEFT JOIN wilayah w ON pw.id_wilayah = w.id_wilayah
        ORDER BY pw.id_paket_wisata DESC";

$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $paket_wisata_list[] = $row;
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Kelola Paket Wisata</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        /* ... CSS yang sudah ada sebelumnya ... */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f6f9; min-height: 100vh; color: #333; }
        .main-content { margin-left: 220px; padding: 25px; transition: margin-left 0.3s ease; }
        .page-header { background: #ffffff; padding: 20px 25px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05); margin-bottom: 25px; display: flex; justify-content: space-between; align-items: center; }
        .page-title { color: #2c3e50; font-size: 1.7rem; font-weight: 600; display: flex; align-items: center; }
        .page-title i { margin-right: 10px; color: #3498db; }
        .btn-primary-header { background-color: #3498db; color: white; padding: 10px 20px; border: none; border-radius: 6px; text-decoration: none; display: inline-flex; align-items: center; font-weight: 500; font-size: 0.9rem; transition: background-color 0.2s ease, box-shadow 0.2s ease; }
        .btn-primary-header:hover { background-color: #2980b9; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); transform: translateY(-1px); }
        .btn-primary-header i { margin-right: 8px; }
        .card { background: #ffffff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05); overflow: hidden; }
        .table-container { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        thead { background-color: #343a40; }
        th { padding: 14px 15px; text-align: left; color: white; font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px; }
        td { padding: 14px 15px; border-bottom: 1px solid #e9ecef; color: #495057; font-size: 0.9rem; vertical-align: middle; }
        tbody tr:hover { background-color: #f8f9fa; }
        .action-buttons { display: flex; gap: 6px; flex-wrap: wrap; }
        .btn { padding: 7px 10px; border: none; border-radius: 5px; font-size: 0.8rem; font-weight: 500; cursor: pointer; transition: opacity 0.2s ease, transform 0.2s ease; text-decoration: none; display: inline-flex; align-items: center; gap: 5px; }
        .btn-edit { background-color: #f39c12; color: white; }
        .btn-delete { background-color: #e74c3c; color: white; }
        /* Hapus atau komentari style terkait .btn-map, .btn-map:disabled */
        .btn:hover { opacity: 0.85; transform: translateY(-1px); }
        .price { font-weight: 600; color: #27ae60; font-size: 0.95rem; }
        .duration { background-color: rgba(52, 152, 219, 0.1); color: #3498db; padding: 5px 10px; border-radius: 15px; font-size: 0.8rem; font-weight: 500; display: inline-block; }
        .row-number { background-color: #6c757d; color: white; width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 0.85rem; }
        .package-name strong { color: #2c3e50; font-weight: 500; }
        .package-name small { color: #6c757d; font-size: 0.8rem; display: block; margin-top: 2px; }
        .destinasi-text i { color: #e74c3c; margin-right: 5px; }

        /* Hapus atau komentari semua CSS untuk Modal Peta */
        /* .modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.6); animation: fadeIn 0.3s; } */
        /* .modal-content { background-color: #fefefe; margin: 5% auto; padding: 0; border: 1px solid #888; width: 80%; max-width: 900px; border-radius: 8px; box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19); animation: slideIn 0.4s; } */
        /* .modal-header { padding: 15px 20px; background-color: #3498db; color: white; border-top-left-radius: 8px; border-top-right-radius: 8px; display: flex; justify-content: space-between; align-items: center; } */
        /* .modal-header h2 { margin: 0; font-size: 1.2rem; } */
        /* .modal-body { height: 70vh; } */
        /* .modal-body iframe { width: 100%; height: 100%; border: none; } */
        /* .close-button { color: #fff; font-size: 28px; font-weight: bold; cursor: pointer; transition: color 0.2s; } */
        /* .close-button:hover, .close-button:focus { color: #e0e0e0; text-decoration: none; } */
        /* @keyframes fadeIn { from {opacity: 0;} to {opacity: 1;} } */
        /* @keyframes slideIn { from {top: -50px; opacity: 0} to {top: 0; opacity: 1} } */

        /* @media (max-width: 768px) { */
        /* .main-content { margin-left: 0; padding: 15px; } */
        /* .page-header { flex-direction: column; gap: 15px; padding: 15px; } */
        /* .page-title { font-size: 1.5rem; text-align: center; } */
        /* .btn-primary-header { padding: 10px 15px; font-size: 0.85rem; } */
        /* table { font-size: 0.85rem; } */
        /* th, td { padding: 10px 8px; } */
        /* .action-buttons { flex-wrap: wrap; } */
        /* .btn { padding: 6px 8px; font-size: 0.75rem; } */
        /* } */
    </style>
</head>
<body>
    <?php include '../komponen/sidebar_admin.php'; // Pastikan path ini benar ?>

    <main class="main-content">
        <div class="page-header">
            <h1 class="page-title">
                <i class="fas fa-suitcase-rolling"></i>
                Kelola Paket Wisata
            </h1>
            <a href="tambah_paket.php" class="btn-primary-header">
                <i class="fas fa-plus"></i>
                Tambah Paket Wisata
            </a>
        </div>

        <div class="card">
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th style="width: 60px;">No</th>
                            <th>Nama Paket</th>
                            <th>Destinasi</th>
                            <th>Harga</th>
                            <th>Durasi</th>
                            <th style="width: 150px;">Aksi</th> </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($paket_wisata_list)): ?>
                            <?php $no = 1; ?>
                            <?php foreach ($paket_wisata_list as $paket): ?>
                            <tr>
                                <td>
                                    <div class='row-number'><?php echo $no; ?></div>
                                </td>
                                <td class="package-name">
                                    <strong><?php echo htmlspecialchars($paket['nama_paket']); ?></strong>
                                    <br>
                                    <small>
                                        <?php
                                        $deskripsi_singkat = strip_tags($paket['deskripsi']);
                                        echo htmlspecialchars(substr($deskripsi_singkat, 0, 50)) . (strlen($deskripsi_singkat) > 50 ? '...' : '');
                                        ?>
                                    </small>
                                </td>
                                <td class="destinasi-text">
                                    <i class='fas fa-map-marker-alt'></i>
                                    <?php echo htmlspecialchars($paket['destinasi'] ?: 'N/A'); ?>
                                </td>
                                <td>
                                    <span class='price'><?php echo format_rupiah($paket['harga']); ?></span>
                                </td>
                                <td>
                                    <span class='duration'><?php echo htmlspecialchars($paket['durasi_paket']); ?></span>
                                </td>
                                <td>
                                    <div class='action-buttons'>
                                        <a href='edit_paket.php?id=<?php echo $paket['id_paket_wisata']; ?>' class='btn btn-edit'>
                                            <i class='fas fa-edit'></i> Edit
                                        </a>
                                        <a href='../backend/hapus_paket.php?id=<?php echo $paket['id_paket_wisata']; ?>' class='btn btn-delete' onclick='return confirm("Yakin ingin menghapus paket ini: <?php echo htmlspecialchars(addslashes($paket['nama_paket'])); ?>?")'>
                                            <i class='fas fa-trash'></i> Hapus
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php $no++; ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 20px;">Belum ada paket wisata yang ditambahkan.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    </body>
</html>