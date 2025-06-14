<?php
// File: get_kendaraan_detail.php (VERSI FINAL & BERSIH)

header('Content-Type: application/json'); // 1. Beritahu browser ini adalah JSON
require_once '../backend/koneksi.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo json_encode(['error' => 'ID tidak valid.']);
    exit();
}

$id = (int)$_GET['id'];
$response = [];

try {
    $stmt = $conn->prepare("SELECT * FROM kendaraan WHERE id_kendaraan = ?");
    if (!$stmt) {
        throw new Exception("Query preparation failed: " . $conn->error);
    }
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $kendaraan = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$kendaraan) {
        echo json_encode(['error' => 'Kendaraan tidak ditemukan.']);
        exit();
    }
    
    // 2. Mulai menangkap semua output HTML
    ob_start();
    ?>
    <form id="editKendaraanForm" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id_kendaraan" value="<?php echo $kendaraan['id_kendaraan']; ?>">
        <div class="form-group">
            <label>Jenis Kendaraan</label>
            <input type="text" name="jenis_kendaraan" value="<?php echo htmlspecialchars($kendaraan['jenis_kendaraan']); ?>" required>
        </div>
        <div class="form-group">
            <label>Ganti Gambar (Opsional)</label>
            <input type="file" name="gambar_kendaraan" accept="image/*">
            <?php if(!empty($kendaraan['gambar'])): ?>
                <small>Gambar saat ini: <?php echo basename($kendaraan['gambar']); ?></small>
            <?php endif; ?>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn" style="background-color: #95a5a6;" onclick="modal.style.display='none'">Batal</button>
            <button type="submit" class="btn" style="background-color: #27ae60;">Simpan Perubahan</button>
        </div>
    </form>
    <?php
    // 3. Ambil HTML yang ditangkap dan masukkan ke dalam array response
    $response['html'] = ob_get_clean();

} catch (Exception $e) {
    $response['error'] = 'Server error: ' . $e->getMessage();
}

$conn->close();

// 4. Cetak array response sebagai JSON
echo json_encode($response);
?>