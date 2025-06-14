<?php
// order_edit.php

session_start();
require_once '../backend/koneksi.php';

// 1. Validasi ID dari URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: manajemen_pemesanan.php");
    exit();
}
$id_pemesanan = $_GET['id'];

// 2. Logika untuk UPDATE (ketika form disubmit)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_order'])) {
    
    // Ambil data dari form
    $nama_lengkap = $_POST['nama_lengkap'];
    $email = $_POST['email'];
    $no_telepon = $_POST['no_telepon'];
    $jumlah_peserta = (int)$_POST['jumlah_peserta'];
    $id_paket_wisata = (int)$_POST['id_paket_wisata'];
    $status_pemesanan = $_POST['status_pemesanan'];
    $tanggal_keberangkatan = $_POST['tanggal_keberangkatan']; // Data sudah benar dalam format Y-m-d

    // Ambil harga paket dari database untuk kalkulasi ulang yang aman
    $stmt_paket = $conn->prepare("SELECT harga FROM paket_wisata WHERE id_paket_wisata = ?");
    $stmt_paket->bind_param("i", $id_paket_wisata);
    $stmt_paket->execute();
    $paket_result = $stmt_paket->get_result()->fetch_assoc();
    $harga_satuan = $paket_result['harga'];
    $stmt_paket->close();

    // Kalkulasi ulang total harga di backend
    $total_harga_recalculated = $harga_satuan * $jumlah_peserta;

    $sql_update = "UPDATE pemesanan SET 
                    nama_lengkap = ?, email = ?, no_telepon = ?, id_paket_wisata = ?,
                    tanggal_keberangkatan = ?, jumlah_peserta = ?, total_harga = ?,
                    status_pemesanan = ?
                   WHERE id_pemesanan = ?";
    
    $stmt_update = $conn->prepare($sql_update);
    if ($stmt_update === false) {
        die("Prepare failed: " . $conn->error);
    }
    
    // =================================================================
    // KESALAHAN ADA DI SINI DAN SEKARANG SUDAH DIPERBAIKI
    // Tipe data untuk tanggal_keberangkatan diubah dari 'i' menjadi 's' (string)
    // Tipe data untuk jumlah_peserta diubah dari 's' menjadi 'i' (integer)
    // "sssiisdsi" -> "ssssidsi"
    // =================================================================
// INI ADALAH BARIS YANG BENAR
$stmt_update->bind_param("sssisidsi", 
    $nama_lengkap, $email, $no_telepon, $id_paket_wisata,
    $tanggal_keberangkatan, $jumlah_peserta, $total_harga_recalculated,
    $status_pemesanan, $id_pemesanan
);
    
    if ($stmt_update->execute()) {
        $_SESSION['success_message'] = "Pemesanan berhasil diperbarui.";
    } else {
        $_SESSION['error_message'] = "Gagal memperbarui pemesanan: " . $stmt_update->error;
    }
    $stmt_update->close();
    
    header("Location: order_edit.php?id=" . $id_pemesanan);
    exit();
}


// 3. Logika untuk GET (menampilkan form dengan data yang ada)
$sql_select = "SELECT * FROM pemesanan WHERE id_pemesanan = ?";
$stmt_select = $conn->prepare($sql_select);
$stmt_select->bind_param("i", $id_pemesanan);
$stmt_select->execute();
$order = $stmt_select->get_result()->fetch_assoc();
$stmt_select->close();

if (!$order) {
    $_SESSION['error_message'] = "Pemesanan tidak ditemukan.";
    header("Location: manajemen_pemesanan.php");
    exit();
}

$paket_wisata_list = $conn->query("SELECT id_paket_wisata, nama_paket, harga FROM paket_wisata ORDER BY nama_paket ASC");
$status_options = ['pending' => 'Menunggu', 'completed' => 'Dikonfirmasi', 'cancelled' => 'Dibatalkan'];

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pemesanan - #<?php echo htmlspecialchars($order['kode_pemesanan']); ?></title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root { --primary-color: #3498db; --success-color: #27ae60; --danger-color: #e74c3c; --warning-color: #f39c12; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8f9fa; }
        main { margin-left: 250px; padding: 20px; }
        .page-header { background: white; padding: 20px 25px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); display: flex; justify-content: space-between; align-items: center; }
        .page-header h1 { color: #2c3e50; font-size: 1.8rem; font-weight: 600; }
        .btn-back { background-color: #6c757d; color: white; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-weight: 500; transition: background-color 0.2s; display: inline-flex; align-items: center; gap: 8px; }
        .btn-back:hover { background-color: #5a6268; }

        .form-card { background: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .form-card .card-header { padding: 15px 20px; border-bottom: 1px solid #e9ecef; font-size: 1.2rem; font-weight: 600; color: #2c3e50; display: flex; align-items: center; gap: 10px; }
        .form-card .card-body { padding: 25px; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 25px; }
        .form-group { display: flex; flex-direction: column; }
        .form-group.full-width { grid-column: 1 / -1; }
        .form-group label { margin-bottom: 8px; font-weight: 600; color: #495057; }
        .form-group input, .form-group select { width: 100%; padding: 12px; border: 1px solid #ced4da; border-radius: 5px; transition: border-color 0.2s, box-shadow 0.2s; font-size: 0.95rem; }
        .form-group input:focus, .form-group select:focus { border-color: var(--primary-color); outline: none; box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2); }
        
        .price-display { background-color: #e9ecef; padding: 20px; border-radius: 8px; text-align: center; margin-top: 20px; }
        .price-display p { color: #495057; font-size: 1rem; margin-bottom: 5px; }
        .price-display h3 { color: var(--success-color); font-size: 2rem; font-weight: 700; }

        .form-actions { margin-top: 30px; text-align: right; }
        .btn-submit { background-color: var(--success-color); color: white; padding: 12px 25px; border: none; border-radius: 6px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: background-color 0.2s; }
        .btn-submit:hover { background-color: #229954; }

        .alert { padding: 15px; margin-bottom: 20px; border-radius: 6px; border: 1px solid transparent; }
        .alert-success { background-color: #d4edda; color: #155724; border-color: #c3e6cb; }
        .alert-danger { background-color: #f8d7da; color: #721c24; border-color: #f5c6cb; }
    </style>
</head>
<body>
    <?php include '../Komponen/sidebar_admin.php'; ?>
    <main>
        <div class="page-header">
            <h1><i class="fas fa-edit" style="color: var(--warning-color);"></i> Edit Pemesanan</h1>
            <a href="pemesanan.php" class="btn-back"><i class="fas fa-arrow-left"></i> Kembali</a>
        </div>
        
        <?php if(isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success"><?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?></div>
        <?php endif; ?>
        <?php if(isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger"><?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?></div>
        <?php endif; ?>

        <form method="POST" action="order_edit.php?id=<?php echo $id_pemesanan; ?>">
            <div class="form-card">
                <div class="card-header">
                    <i class="fas fa-user-edit"></i> Form Edit untuk Pesanan #<?php echo htmlspecialchars($order['kode_pemesanan']); ?>
                </div>
                <div class="card-body">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="nama_lengkap">Nama Lengkap</label>
                            <input type="text" id="nama_lengkap" name="nama_lengkap" value="<?php echo htmlspecialchars($order['nama_lengkap']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($order['email']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="no_telepon">Nomor Telepon</label>
                            <input type="tel" id="no_telepon" name="no_telepon" value="<?php echo htmlspecialchars($order['no_telepon']); ?>">
                        </div>
                        <div class="form-group">
                            <label for="tanggal_keberangkatan">Tanggal Keberangkatan</label>
                            <input type="date" id="tanggal_keberangkatan" name="tanggal_keberangkatan" 
                                   value="<?php echo date('Y-m-d', strtotime($order['tanggal_keberangkatan'])); ?>" required>
                        </div>
                         <div class="form-group full-width">
                            <label for="id_paket_wisata">Paket Wisata</label>
                            <select id="id_paket_wisata" name="id_paket_wisata" required>
                                <?php $paket_wisata_list->data_seek(0);
                                      while($paket = $paket_wisata_list->fetch_assoc()): ?>
                                    <option value="<?php echo $paket['id_paket_wisata']; ?>" 
                                            data-harga="<?php echo $paket['harga']; ?>"
                                            <?php echo ($paket['id_paket_wisata'] == $order['id_paket_wisata']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($paket['nama_paket']); ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="jumlah_peserta">Jumlah Peserta</label>
                            <input type="number" id="jumlah_peserta" name="jumlah_peserta" value="<?php echo htmlspecialchars($order['jumlah_peserta']); ?>" min="1" required>
                        </div>
                        <div class="form-group">
                             <label for="status_pemesanan">Status Pemesanan</label>
                             <select id="status_pemesanan" name="status_pemesanan" required>
                                <?php foreach ($status_options as $key => $value): ?>
                                    <option value="<?php echo $key; ?>" <?php echo ($key == $order['status_pemesanan']) ? 'selected' : ''; ?>>
                                        <?php echo $value; ?>
                                    </option>
                                <?php endforeach; ?>
                             </select>
                        </div>
                    </div>
                    
                    <div class="price-display">
                        <p>Total Harga yang Dihitung Ulang</p>
                        <h3 id="display_total_harga">Rp <?php echo number_format($order['total_harga'], 0, ',', '.'); ?></h3>
                    </div>

                    <div class="form-actions">
                        <button type="submit" name="update_order" class="btn-submit"><i class="fas fa-save"></i> Simpan Perubahan</button>
                    </div>
                </div>
            </div>
        </form>
    </main>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const paketSelect = document.getElementById('id_paket_wisata');
        const pesertaInput = document.getElementById('jumlah_peserta');
        const hargaDisplay = document.getElementById('display_total_harga');

        function calculateTotalPrice() {
            const selectedOption = paketSelect.options[paketSelect.selectedIndex];
            const hargaSatuan = parseFloat(selectedOption.getAttribute('data-harga')) || 0;
            const jumlahPeserta = parseInt(pesertaInput.value) || 0;
            const total = hargaSatuan * jumlahPeserta;
            hargaDisplay.textContent = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(total);
        }
        paketSelect.addEventListener('change', calculateTotalPrice);
        pesertaInput.addEventListener('input', calculateTotalPrice);
    });
    </script>
</body>
</html>