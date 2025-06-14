<?php
// File: backend/get_kuliner_detail.php (VERSI FINAL)

header('Content-Type: application/json');
require_once 'koneksi.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo json_encode(['error' => 'ID tidak valid.']);
    exit();
}

$id = (int)$_GET['id'];
$response = [];

try {
    $stmt = $conn->prepare("SELECT * FROM akomodasi_kuliner WHERE id_akomodasi_kuliner = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $kuliner = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$kuliner) {
        echo json_encode(['error' => 'Item kuliner tidak ditemukan.']);
        exit();
    }
    
    // Mulai menangkap output HTML untuk dijadikan data JSON
    ob_start();
    ?>
    <form id="editKulinerForm" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id_akomodasi_kuliner" value="<?php echo $kuliner['id_akomodasi_kuliner']; ?>">
        <div class="form-group">
            <label>Nama Restaurant / Kuliner</label>
            <textarea name="nama_restaurant" rows="2" required><?php echo htmlspecialchars($kuliner['nama_restaurant']); ?></textarea>
        </div>
        <div class="form-group">
            <label>Ganti Gambar (Opsional)</label>
            <input type="file" name="gambar_kuliner" accept="image/*">
            <?php if(!empty($kuliner['gambar_url'])): ?>
                <small>Gambar saat ini: <?php echo basename($kuliner['gambar_url']); ?></small>
            <?php endif; ?>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn" style="background-color: #95a5a6;" onclick="document.getElementById('editModal').style.display='none'">Batal</button>
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