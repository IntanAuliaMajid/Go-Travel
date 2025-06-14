<?php
header('Content-Type: application/json');
require_once 'koneksi.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo json_encode(['error' => 'ID tidak valid.']); exit();
}

$id = (int)$_GET['id'];
$response = [];

try {
    $stmt = $conn->prepare("SELECT * FROM akomodasi_penginapan WHERE id_akomodasi_penginapan = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $penginapan = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$penginapan) {
        echo json_encode(['error' => 'Penginapan tidak ditemukan.']); exit();
    }
    
    ob_start();
    ?>
    <form id="editPenginapanForm" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id_akomodasi_penginapan" value="<?php echo $penginapan['id_akomodasi_penginapan']; ?>">
        <div class="form-group">
            <label>Nama Penginapan</label>
            <input type="text" name="nama_penginapan" value="<?php echo htmlspecialchars($penginapan['nama_penginapan']); ?>" required>
        </div>
        <div class="form-group">
            <label>Rating Bintang (1-5)</label>
            <input type="number" name="rating_bintang" value="<?php echo htmlspecialchars($penginapan['rating_bintang']); ?>" min="1" max="5">
        </div>
        <div class="form-group">
            <label>Harga per Malam (Rp)</label>
            <input type="number" name="harga_per_malam" value="<?php echo htmlspecialchars($penginapan['harga_per_malam']); ?>" min="0">
        </div>
        <div class="form-group">
            <label>Ganti Gambar (Opsional)</label>
            <input type="file" name="gambar_penginapan" accept="image/*">
            <?php if(!empty($penginapan['gambar_url'])): ?>
                <small>Gambar saat ini: <?php echo basename($penginapan['gambar_url']); ?></small>
            <?php endif; ?>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn" style="background-color: #95a5a6;" onclick="modal.style.display='none'">Batal</button>
            <button type="submit" class="btn" style="background-color: #27ae60;">Simpan Perubahan</button>
        </div>
    </form>
    <?php
    $response['html'] = ob_get_clean();

} catch (Exception $e) {
    $response['error'] = 'Database error: ' . $e->getMessage();
}

$conn->close();
echo json_encode($response);
?>