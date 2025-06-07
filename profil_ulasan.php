<?php
// profil_ulasan.php - Konten untuk tab "Ulasan Saya"
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'backend/koneksi.php'; // Sesuaikan path

if (!isset($_SESSION['user'])) {
    echo "<p style='text-align: center; color: #dc3545;'>Anda harus login untuk melihat ulasan.</p>";
    exit();
}

$id_pengunjung = $_SESSION['user']['id_pengunjung'];

// Ambil data Ulasan Saya
$my_reviews = [];
$sql_reviews = "SELECT u.rating, u.komentar, w.nama_wisata, w.denah AS wisata_gambar_url
                FROM ulasan u
                JOIN wisata w ON u.id_wisata = w.id_wisata
                WHERE u.id_pengunjung = ?
                ORDER BY u.id_ulasan DESC";

$stmt_reviews = $conn->prepare($sql_reviews);
if ($stmt_reviews) {
    $stmt_reviews->bind_param("i", $id_pengunjung);
    $stmt_reviews->execute();
    $result_reviews = $stmt_reviews->get_result();
    while ($row = $result_reviews->fetch_assoc()) {
        $my_reviews[] = $row;
    }
    $stmt_reviews->close();
}
$conn->close();

// Define paths for images (adjust as per your project structure)
define('WEB_URL_WISATA_GAMBAR', './uploads/wisata/'); 
?>

<h3 class="section-title">Ulasan Saya</h3>
<?php if (!empty($my_reviews)): ?>
    <?php foreach ($my_reviews as $review): ?>
        <div class="booking-item">
            <?php
            $review_image_url = 'https://via.placeholder.com/100x80?text=No+Image';
            if (!empty($review['wisata_gambar_url'])) {
                if (filter_var($review['wisata_gambar_url'], FILTER_VALIDATE_URL)) {
                    $review_image_url = htmlspecialchars($review['wisata_gambar_url']);
                } elseif (strpos($review['wisata_gambar_url'], '../gambar/') === 0) {
                    $review_image_url = './' . substr(htmlspecialchars($review['wisata_gambar_url']), 3);
                } elseif (strpos($review['wisata_gambar_url'], '../uploads/denah/') === 0) {
                    $review_image_url = './' . substr(htmlspecialchars($review['wisata_gambar_url']), 3);
                } elseif (strpos($review['wisata_gambar_url'], 'denah_') === 0 || strpos($review['wisata_gambar_url'], 'wisata_') === 0) {
                    $review_image_url = WEB_URL_WISATA_GAMBAR . htmlspecialchars($review['wisata_gambar_url']);
                }
            }
            ?>
            <img src="<?php echo $review_image_url; ?>" alt="<?php echo htmlspecialchars($review['nama_wisata'] ?? 'Wisata'); ?>" class="booking-image">
            <div class="booking-details">
                <h4><?php echo htmlspecialchars($review['nama_wisata']); ?></h4>
                <p style="margin-bottom: 0.5rem;">
                    <?php for ($i = 0; $i < $review['rating']; $i++): ?><i class="fas fa-star" style="color: #ffc107;"></i><?php endfor; ?>
                    <?php for ($i = 0; $i < (5 - $review['rating']); $i++): ?><i class="far fa-star" style="color: #ffc107;"></i><?php endfor; ?>
                </p>
                <p><?php echo htmlspecialchars($review['komentar']); ?></p>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p style="text-align: center; color: #666; margin-top: 2rem;">Anda belum menulis ulasan.</p>
<?php endif; ?>