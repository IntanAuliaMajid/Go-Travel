<?php
header('Content-Type: application/json');
require_once '../backend/koneksi.php';

// Helper function untuk bintang
function display_rating_stars_json($rating) {
    if ($rating === null) return 'N/A';
    $rating_int = floor($rating);
    $output = '';
    for ($i = 1; $i <= 5; $i++) {
        $output .= '<i class="' . ($i <= $rating_int ? 'fas' : 'far') . ' fa-star" style="color: #f39c12;"></i>';
    }
    return $output . ' <span style="font-weight: 500; font-size: 0.9em; color: #555;">(' . number_format($rating, 1) . ')</span>';
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo json_encode(['error' => 'ID tidak valid.']); exit();
}

$id = (int)$_GET['id'];
$type = $_GET['type'] ?? 'view';
$response = [];

try {
    $stmt = $conn->prepare("SELECT p.*, l.nama_lokasi FROM pemandu_wisata p LEFT JOIN lokasi l ON p.id_lokasi = l.id_lokasi WHERE p.id_pemandu_wisata = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $pemandu = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$pemandu) {
        echo json_encode(['error' => 'Pemandu tidak ditemukan.']); exit();
    }
    
    ob_start();
    if ($type === 'view') {
        $stmt_lang = $conn->prepare("SELECT b.nama_bahasa FROM pemandu_bahasa pb JOIN bahasa b ON pb.id_bahasa = b.id_bahasa WHERE pb.id_pemandu_wisata = ?");
        $stmt_lang->bind_param("i", $id);
        $stmt_lang->execute();
        $res_lang = $stmt_lang->get_result();
        $bahasa_dikuasai = [];
        while($row = $res_lang->fetch_assoc()){ $bahasa_dikuasai[] = $row['nama_bahasa']; }
        $stmt_lang->close();
        ?>
        <div style="display: flex; flex-direction: column; gap: 10px; font-size: 1rem;">
            <p><strong>Nama:</strong> <?php echo htmlspecialchars($pemandu['nama_pemandu']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($pemandu['email']); ?></p>
            <p><strong>Telepon:</strong> <?php echo htmlspecialchars($pemandu['telepon'] ?? 'N/A'); ?></p>
            <p><strong>Lokasi:</strong> <span class="badge"><?php echo htmlspecialchars($pemandu['nama_lokasi'] ?? 'N/A'); ?></span></p>
            <p><strong>Pengalaman:</strong> <?php echo htmlspecialchars($pemandu['pengalaman'] ?? 'N/A'); ?></p>
            <p><strong>Rating:</strong> <?php echo display_rating_stars_json($pemandu['rating']); ?></p>
            <p><strong>Bahasa:</strong> <?php echo implode(', ', $bahasa_dikuasai) ?: 'N/A'; ?></p>
            <p><strong>Spesialisasi:</strong> <?php echo htmlspecialchars($pemandu['spesialisasi'] ?? 'N/A'); ?></p>
            <hr>
            <p><strong>Biodata:</strong><br><?php echo nl2br(htmlspecialchars($pemandu['biodata'] ?? 'N/A')); ?></p>
        </div>
        <?php
    } else { // type 'edit'
        $locations = $conn->query("SELECT id_lokasi, nama_lokasi FROM lokasi ORDER BY nama_lokasi ASC")->fetch_all(MYSQLI_ASSOC);
        $languages = $conn->query("SELECT id_bahasa, nama_bahasa FROM bahasa ORDER BY nama_bahasa ASC")->fetch_all(MYSQLI_ASSOC);
        
        $pemandu_lang_ids = [];
        $stmt_lang_ids = $conn->prepare("SELECT id_bahasa FROM pemandu_bahasa WHERE id_pemandu_wisata = ?");
        $stmt_lang_ids->bind_param("i", $id);
        $stmt_lang_ids->execute();
        $res_lang_ids = $stmt_lang_ids->get_result();
        while($row = $res_lang_ids->fetch_assoc()){ $pemandu_lang_ids[] = $row['id_bahasa']; }
        $stmt_lang_ids->close();
        ?>
        <form id="editPemanduForm" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_pemandu_wisata" value="<?php echo $pemandu['id_pemandu_wisata']; ?>">
            <div class="form-grid">
                <div class="form-group"><label>Nama Pemandu</label><input type="text" name="nama_pemandu" value="<?php echo htmlspecialchars($pemandu['nama_pemandu']); ?>" required></div>
                <div class="form-group"><label>Email</label><input type="email" name="email" value="<?php echo htmlspecialchars($pemandu['email']); ?>" required></div>
                <div class="form-group"><label>Telepon</label><input type="tel" name="telepon" value="<?php echo htmlspecialchars($pemandu['telepon']); ?>"></div>
                <div class="form-group"><label>Lokasi</label><select name="id_lokasi" required><?php foreach($locations as $loc): ?><option value="<?php echo $loc['id_lokasi']; ?>" <?php echo ($pemandu['id_lokasi'] == $loc['id_lokasi'] ? 'selected' : ''); ?>><?php echo htmlspecialchars($loc['nama_lokasi']); ?></option><?php endforeach; ?></select></div>
                <div class="form-group"><label>Pengalaman</label><input type="text" name="pengalaman" value="<?php echo htmlspecialchars($pemandu['pengalaman']); ?>"></div>
                <div class="form-group"><label>Rating (Read-Only)</label><div style="padding: 10px; background-color: #f0f0f0; border-radius: 5px;"><?php echo display_rating_stars_json($pemandu['rating']); ?></div></div>
                <div class="form-group full-width"><label>Spesialisasi</label><input type="text" name="spesialisasi" value="<?php echo htmlspecialchars($pemandu['spesialisasi']); ?>"></div>
                <div class="form-group full-width"><label>Ganti Foto (Opsional)</label><input type="file" name="pemandu_foto" accept="image/*"></div>
                <div class="form-group full-width"><label>Biodata</label><textarea name="biodata" rows="3"><?php echo htmlspecialchars($pemandu['biodata']); ?></textarea></div>
                <div class="form-group full-width">
                    <label>Bahasa yang Dikuasai</label>
                    <div class="language-group"><?php foreach($languages as $lang): ?><div class="language-item"><input type="checkbox" name="bahasa[]" value="<?php echo $lang['id_bahasa']; ?>" id="lang_<?php echo $lang['id_bahasa']; ?>" <?php echo (in_array($lang['id_bahasa'], $pemandu_lang_ids) ? 'checked' : ''); ?>><label for="lang_<?php echo $lang['id_bahasa']; ?>"><?php echo htmlspecialchars($lang['nama_bahasa']); ?></label></div><?php endforeach; ?></div>
                </div>
            </div>
            <div class="modal-footer"><button type="button" class="btn" style="background-color: #95a5a6;" onclick="modal.style.display='none'">Batal</button><button type="submit" class="btn" style="background-color: #27ae60;">Simpan Perubahan</button></div>
        </form>
        <?php
    }
    $response['html'] = ob_get_clean();

} catch (Exception $e) {
    $response['error'] = 'Database error: ' . $e->getMessage();
}

$conn->close();
echo json_encode($response);
?>