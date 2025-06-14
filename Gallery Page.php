<?php
// Meng-include komponen dan koneksi database
include 'Komponen/navbar.php';
include 'backend/koneksi.php';

// --- PENGATURAN PAGINATION ---
$items_per_page = 12; // Tampilkan 12 media per halaman agar lebih banyak
$current_page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($current_page - 1) * $items_per_page;

// --- MENGHITUNG TOTAL DATA UNTUK PAGINATION ---
$total_items_result = $conn->query("SELECT COUNT(*) as total FROM galeri");
$total_items = $total_items_result->fetch_assoc()['total'];
$total_pages = ceil($total_items / $items_per_page);

// --- MENGAMBIL DATA DARI DATABASE SESUAI HALAMAN ---
$gallery_items = [];
$stmt = $conn->prepare("SELECT id_galeri, judul, kategori, tipe_file, path_file 
                        FROM galeri 
                        ORDER BY tanggal_upload DESC 
                        LIMIT ? OFFSET ?");
$stmt->bind_param("ii", $items_per_page, $offset);
$stmt->execute();
$result = $stmt->get_result();
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $gallery_items[] = $row;
    }
}
$stmt->close();
$conn->close();

// --- MEMISAHKAN GAMBAR DAN VIDEO ---
$gambar_items = [];
$video_items = [];
foreach ($gallery_items as $item) {
    if ($item['tipe_file'] == 'gambar') {
        $gambar_items[] = $item;
    } else {
        $video_items[] = $item;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri Wisata Go-Travel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="css/fuadi.css">
    <style>
        .gallery-grid, .video-wrapper { /* Aturan ini sekarang berlaku untuk foto dan video */
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        .gallery-item, .video-item { /* Class baru untuk video agar konsisten */
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background-color: #000; /* Latar belakang hitam untuk video */
        }
        .gallery-item:hover, .video-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        .gallery-item img, .video-item video {
            width: 100%;
            height: 220px;
            object-fit: cover;
            display: block;
        }
        .video-section {
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 1px solid #e0e0e0;
        }
        .pagination {
            text-align: center;
            margin-top: 2rem;
        }
        .pagination a {
            color: #2c7a51;
            padding: 10px 15px;
            text-decoration: none;
            border: 1px solid #ddd;
            margin: 0 4px;
            border-radius: 5px;
        }
        .pagination a.active,
        .pagination a:hover {
            background-color: #2c7a51;
            color: white;
            border-color: #2c7a51;
        }
    </style>
</head>
<body>

    <div class="section-header">
      <h2 class="mt_16" >Galeri Keindahan Wisata</h2>
    </div>
    
    <main>
        <div class="gallery-grid">
            <?php foreach ($gambar_items as $gambar): ?>
                <div class="gallery-item">
                    <img src="<?php echo htmlspecialchars($gambar['path_file']); ?>" alt="<?php echo htmlspecialchars($gambar['judul']); ?>">
                </div>
            <?php endforeach; ?>
        </div>

        <?php if (!empty($video_items)): ?>
        <div class="video-section">
            <h3>Video Wisata</h3>
            <div class="video-wrapper">
                <?php foreach ($video_items as $video): ?>
                    <div class="video-item">
                        <video controls>
                            <source src="<?php echo htmlspecialchars($video['path_file']); ?>" type="video/mp4">
                            Browser Anda tidak mendukung tag video.
                        </video>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <?php if (empty($gallery_items)): ?>
            <p style="text-align: center;">Belum ada media di galeri.</p>
        <?php endif; ?>

        <div class="pagination">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="?page=<?php echo $i; ?>" class="<?php echo ($i == $current_page) ? 'active' : ''; ?>">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>
        </div>
    </main>

    <?php include './Komponen/footer.php'; ?>

</body>
</html>