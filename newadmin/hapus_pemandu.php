<?php
require_once '../backend/koneksi.php';

// Validasi ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Akses tidak valid.");
}
$id = (int)$_GET['id'];
$pemandu = null;

// Query untuk mengambil data lengkap pemandu
$sql = "SELECT 
            p.*,
            l.nama_lokasi,
            (SELECT GROUP_CONCAT(b.nama_bahasa SEPARATOR ', ')
             FROM pemandu_bahasa pb
             JOIN bahasa b ON pb.id_bahasa = b.id_bahasa
             WHERE pb.id_pemandu_wisata = p.id_pemandu_wisata) AS bahasa_dikuasai
        FROM pemandu_wisata p
        LEFT JOIN lokasi l ON p.id_lokasi = l.id_lokasi
        WHERE p.id_pemandu_wisata = ?
        LIMIT 1";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $pemandu = $result->fetch_assoc();
} else {
    die("Pemandu wisata tidak ditemukan.");
}
$stmt->close();
$conn->close();

function get_initials_view($nama) {
    $words = explode(' ', $nama);
    $initials = '';
    $i = 0;
    foreach ($words as $w) {
        if ($i < 2 && !empty($w)) { $initials .= strtoupper($w[0]); $i++; }
    }
    return $initials ?: 'NN';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><title>Detail Pemandu Wisata</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f6f9; color: #333; display: flex; justify-content: center; padding-top: 50px; }
        .card { background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 5px 25px rgba(0,0,0,0.1); width: 100%; max-width: 500px; }
        .card-header { text-align: center; border-bottom: 1px solid #eee; padding-bottom: 20px; margin-bottom: 20px; }
        .avatar { width: 120px; height: 120px; border-radius: 50%; background-color: #6c5ce7; color: white; display: flex; justify-content: center; align-items: center; font-size: 3rem; font-weight: bold; margin: 0 auto 15px auto; border: 4px solid white; box-shadow: 0 0 15px rgba(0,0,0,0.2); }
        .avatar img { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; }
        .card-header h2 { margin: 0; color: #2c3e50; }
        .card-header p { color: #7f8c8d; }
        .card-body .detail-item { display: flex; justify-content: space-between; align-items: center; padding: 12px 0; border-bottom: 1px solid #f0f0f0; }
        .card-body .detail-item:last-child { border-bottom: none; }
        .card-body strong { color: #555; font-weight: 600; }
        .card-body span { text-align: right; }
        .badge { background-color: #e9ecef; color: #495057; padding: 5px 10px; border-radius: 15px; font-size: 0.9em; }
        .rating i { color: #f39c12; }
        .card-footer { text-align: center; margin-top: 25px; }
        .btn-back { display: inline-block; padding: 12px 30px; background-color: #3498db; color: white; text-decoration: none; border-radius: 6px; font-weight: 500; transition: background-color 0.2s ease; }
        .btn-back:hover { background-color: #2980b9; }
    </style>
</head>
<body>
    <div class="card">
        <div class="card-header">
            <div class="avatar">
                <?php if (!empty($pemandu['foto_url']) && filter_var($pemandu['foto_url'], FILTER_VALIDATE_URL)): ?>
                    <img src="<?php echo htmlspecialchars($pemandu['foto_url']); ?>" alt="Avatar">
                <?php else: echo get_initials_view(htmlspecialchars($pemandu['nama_pemandu'])); endif; ?>
            </div>
            <h2><?php echo htmlspecialchars($pemandu['nama_pemandu']); ?></h2>
            <p><?php echo htmlspecialchars($pemandu['email']); ?></p>
        </div>
        <div class="card-body">
            <div class="detail-item"><strong>Telepon:</strong> <span><?php echo htmlspecialchars($pemandu['telepon'] ?? 'N/A'); ?></span></div>
            <div class="detail-item"><strong>Lokasi Tugas:</strong> <span class="badge"><?php echo htmlspecialchars($pemandu['nama_lokasi'] ?? 'N/A'); ?></span></div>
            <div class="detail-item"><strong>Pengalaman:</strong> <span><?php echo htmlspecialchars($pemandu['pengalaman'] ?? 'N/A'); ?></span></div>
            <div class="detail-item"><strong>Rating:</strong> <span class="rating"><?php echo number_format($pemandu['rating'] ?? 0, 1); ?> <i class="fas fa-star"></i></span></div>
            <div class="detail-item"><strong>Bahasa:</strong> <span><?php echo htmlspecialchars($pemandu['bahasa_dikuasai'] ?? 'N/A'); ?></span></div>
            <div class="detail-item"><strong>Spesialisasi:</strong> <span><?php echo htmlspecialchars($pemandu['spesialisasi'] ?? 'N/A'); ?></span></div>
        </div>
        <div class="card-footer">
            <a href="manajemen_pemandu.php" class="btn-back">Kembali</a>
        </div>
    </div>
</body>
</html>