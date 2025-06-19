<?php
// AKTIFKAN UNTUK DEVELOPMENT, NONAKTIFKAN/HAPUS DI PRODUKSI!
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 0. Mulai atau lanjutkan sesi
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include 'Komponen/navbar.php'; // Sertakan navbar
include './backend/koneksi.php'; // Sertakan koneksi database

// 1. Ambil ID Wisata dari URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<div class='container'><p class='error-message'>ID Wisata tidak valid.</p></div>";
    include 'Komponen/footer.php'; // Sertakan footer sebelum exit
    if ($conn) mysqli_close($conn); // Tutup koneksi jika ada sebelum exit
    exit;
}
$id_wisata = (int)$_GET['id'];

// 2. Handle Pengiriman Ulasan Baru
$ulasan_message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['kirim_ulasan'])) {
    if (!isset($_SESSION['user']['id_pengunjung'])) {
        $ulasan_message = "<p class='error-message'>Anda harus login untuk mengirim ulasan.</p>";
    } else {
        $id_pengunjung = (int)$_SESSION['user']['id_pengunjung'];
        $rating = isset($_POST['rating']) ? (int)$_POST['rating'] : 0;
        $komentar = mysqli_real_escape_string($conn, $_POST['komentar']);

        if (empty(trim($komentar))) {
            $ulasan_message = "<p class='error-message'>Komentar tidak boleh kosong.</p>";
        } elseif ($rating >= 1 && $rating <= 5) {
            $stmt_insert_ulasan = mysqli_prepare($conn, "INSERT INTO ulasan (id_wisata, id_pengunjung, rating, komentar) VALUES (?, ?, ?, ?)");
            if ($stmt_insert_ulasan) {
                mysqli_stmt_bind_param($stmt_insert_ulasan, "iiis", $id_wisata, $id_pengunjung, $rating, $komentar);
                if (mysqli_stmt_execute($stmt_insert_ulasan)) {
                    $ulasan_message = "<p class='success-message'>Ulasan Anda berhasil dikirim!</p>";
                } else {
                    $ulasan_message = "<p class='error-message'>Gagal mengirim ulasan: " . mysqli_stmt_error($stmt_insert_ulasan) . "</p>";
                }
                mysqli_stmt_close($stmt_insert_ulasan);
            } else {
                $ulasan_message = "<p class='error-message'>Gagal mempersiapkan statement ulasan: " . mysqli_error($conn) . "</p>";
            }
        } else {
            $ulasan_message = "<p class='error-message'>Rating tidak valid. Harap pilih rating antara 1 dan 5.</p>";
        }
    }
}

// 3. Query Data Utama Wisata
// Hapus LEFT JOIN tips_berkunjung dan t.nama_tips_berkunjung
$stmt_wisata = mysqli_prepare($conn, "
    SELECT w.nama_wisata, w.deskripsi_wisata, w.todo, w.Alamat as alamat_wisata, w.denah, w.id_lokasi,
           l.nama_lokasi
    FROM wisata w
    LEFT JOIN lokasi l ON w.id_lokasi = l.id_lokasi
    WHERE w.id_wisata = ?
");

if (!$stmt_wisata) {
    echo "<div class='container'><p class='error-message'>Gagal mempersiapkan query wisata: " . mysqli_error($conn) . "</p></div>";
    include 'Komponen/footer.php';
    if ($conn) mysqli_close($conn);
    exit;
}

mysqli_stmt_bind_param($stmt_wisata, "i", $id_wisata);
mysqli_stmt_execute($stmt_wisata);
$result_wisata = mysqli_stmt_get_result($stmt_wisata);
$wisata = mysqli_fetch_assoc($result_wisata);
mysqli_stmt_close($stmt_wisata);

if (!$wisata) {
    echo "<div class='container'><p class='error-message'>Wisata tidak ditemukan.</p></div>";
    include 'Komponen/footer.php';
    if ($conn) mysqli_close($conn);
    exit;
}

$nama_wisata_display = htmlspecialchars($wisata['nama_wisata']);
$deskripsi_parts = explode('.', $wisata['deskripsi_wisata'] ?? '', 2);
$deskripsi_singkat_wisata = isset($deskripsi_parts[0]) && trim($deskripsi_parts[0]) !== '' ? htmlspecialchars(trim($deskripsi_parts[0])) . '.' : 'Jelajahi keindahan dan pesona ' . $nama_wisata_display . '.';

// 4. Query Gambar dari tabel `gambar`
$stmt_gallery = mysqli_prepare($conn, "SELECT url, caption FROM gambar WHERE wisata_id = ? ORDER BY id_gambar ASC");
$gallery_images = [];
if ($stmt_gallery) {
    mysqli_stmt_bind_param($stmt_gallery, "i", $id_wisata);
    mysqli_stmt_execute($stmt_gallery);
    $result_gallery = mysqli_stmt_get_result($stmt_gallery);
    while ($img_row = mysqli_fetch_assoc($result_gallery)) {
        $gallery_images[] = $img_row;
    }
    mysqli_stmt_close($stmt_gallery);
} else {
    // Handle error jika prepare gagal, misal tampilkan pesan atau log
}

if (!empty($gallery_images)) {
    $gambar_utama_wisata = str_replace('../', './', $gallery_images[0]['url']);
    $gambar_utama_wisata = htmlspecialchars($gambar_utama_wisata);
} else {
    $gambar_utama_wisata = './Gambar/default-hero.jpg';
}

// 5. Query Ulasan
$stmt_ulasan = mysqli_prepare($conn, "
    SELECT u.rating, u.komentar, p.nama_depan, p.nama_belakang
    FROM ulasan u
    JOIN pengunjung p ON u.id_pengunjung = p.id_pengunjung
    WHERE u.id_wisata = ?
    ORDER BY u.id_ulasan DESC
    LIMIT 5
");
$ulasan_list = [];
if ($stmt_ulasan) {
    mysqli_stmt_bind_param($stmt_ulasan, "i", $id_wisata);
    mysqli_stmt_execute($stmt_ulasan);
    $result_ulasan = mysqli_stmt_get_result($stmt_ulasan);
    while ($ulasan_row = mysqli_fetch_assoc($result_ulasan)) {
        $ulasan_list[] = $ulasan_row;
    }
    mysqli_stmt_close($stmt_ulasan);
} else {
     // Handle error jika prepare gagal
}


// 6. Parse Aktivitas (dari kolom `todo`)
$activities_wisata = [];
if (!empty($wisata['todo'])) {
    $todo_items = explode(',', $wisata['todo']);
    foreach ($todo_items as $item) {
        $item_trimmed = trim($item);
        if (empty($item_trimmed)) continue;

        $icon = "fas fa-check-circle"; // Ikon default
        if (stripos($item_trimmed, "sunrise") !== false || stripos($item_trimmed, "sunset") !== false) $icon = "fas fa-sun";
        elseif (stripos($item_trimmed, "foto") !== false) $icon = "fas fa-camera";
        elseif (stripos($item_trimmed, "renang") !== false || stripos($item_trimmed, "berenang") !== false) $icon = "fas fa-swimmer";
        elseif (stripos($item_trimmed, "snorkeling") !== false || stripos($item_trimmed, "diving") !== false) $icon = "fas fa-water";
        elseif (stripos($item_trimmed, "museum") !== false) $icon = "fas fa-landmark";
        elseif (stripos($item_trimmed, "zoo") !== false || stripos($item_trimmed, "kebun binatang") !== false) $icon = "fas fa-paw";
        elseif (stripos($item_trimmed, "kuliner") !== false || stripos($item_trimmed, "makan") !== false || stripos($item_trimmed, "cicipi") !== false) $icon = "fas fa-utensils";
        elseif (stripos($item_trimmed, "belanja") !== false || stripos($item_trimmed, "oleh-oleh") !== false) $icon = "fas fa-shopping-bag";
        elseif (stripos($item_trimmed, "trekking") !== false || stripos($item_trimmed, "hiking") !== false) $icon = "fas fa-hiking";
        elseif (stripos($item_trimmed, "piknik") !== false) $icon = "fas fa-basket-shopping";


        $activities_wisata[] = ["icon" => $icon, "text" => htmlspecialchars($item_trimmed)];
    }
}

// 7. Query Tips Berkunjung (Diambil dari tabel baru `tips_berkunjung`)
$tips_berkunjung_list = [];
$stmt_tips = mysqli_prepare($conn, "
    SELECT tip_text
    FROM tips_berkunjung
    WHERE id_wisata = ?
    ORDER BY id_tips_berkunjung ASC
");
if ($stmt_tips) {
    mysqli_stmt_bind_param($stmt_tips, "i", $id_wisata);
    mysqli_stmt_execute($stmt_tips);
    $result_tips = mysqli_stmt_get_result($stmt_tips);
    while ($tip_row = mysqli_fetch_assoc($result_tips)) {
        $tips_berkunjung_list[] = htmlspecialchars($tip_row['tip_text']);
    }
    mysqli_stmt_close($stmt_tips);
} else {
    // Handle error jika prepare gagal
    // $ulasan_message .= "<p class='error-message'>Gagal memuat tips berkunjung.</p>";
}

// Populate default tips if no specific tips are found
if (empty($tips_berkunjung_list)) {
    $tips_berkunjung_list = [
        "Datang lebih awal untuk pengalaman terbaik.",
        "Kenakan pakaian dan alas kaki yang nyaman.",
        "Bawa air minum dan tabir surya.",
        "Jaga kebersihan lingkungan sekitar.",
        "Patuhi peraturan yang berlaku di lokasi."
    ];
}

// 8. Query Wisata Terdekat
$wisata_terdekat_list = [];
if (!empty($wisata['id_lokasi'])) {
    $stmt_terdekat = mysqli_prepare($conn, "
        SELECT id_wisata, nama_wisata
        FROM wisata
        WHERE id_lokasi = ? AND id_wisata != ?
        ORDER BY RAND()
        LIMIT 4
    ");
    if ($stmt_terdekat) {
        mysqli_stmt_bind_param($stmt_terdekat, "ii", $wisata['id_lokasi'], $id_wisata);
        mysqli_stmt_execute($stmt_terdekat);
        $result_terdekat = mysqli_stmt_get_result($stmt_terdekat);
        while ($terdekat_row = mysqli_fetch_assoc($result_terdekat)) {
            $wisata_terdekat_list[] = $terdekat_row;
        }
        mysqli_stmt_close($stmt_terdekat);
    } else {
          // Handle error jika prepare gagal
    }
}

// Informasi singkat
$info_singkat = [
    "Waktu Terbaik: Pagi & Sore",
    "Estimasi Durasi: 2-4 Jam",
];
// if (isset($wisata['harga_tiket']) && $wisata['harga_tiket'] > 0) {
//     $info_singkat[] = "Tiket: Rp " . number_format($wisata['harga_tiket']);
// } else {
//     $info_singkat[] = "Tiket: Bervariasi/Gratis";
// }


$peta_lokasi_url = !empty($wisata['denah']) ? htmlspecialchars($wisata['denah']) : './Gambar/default-map.png';
// Mengganti "../" dengan "./" agar path sesuai dengan struktur folder web
$peta_lokasi_url = str_replace('../', './', $peta_lokasi_url);


$alamat_display = !empty($wisata['alamat_wisata']) ? htmlspecialchars($wisata['alamat_wisata']) : 'Informasi alamat tidak tersedia.';
if (empty($wisata['alamat_wisata']) && !empty($wisata['nama_lokasi'])) {
    $alamat_display = "Berlokasi di area " . htmlspecialchars($wisata['nama_lokasi']);
}

// JANGAN tutup koneksi di sini lagi
// mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Detail Wisata - <?php echo $nama_wisata_display; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./CSS/detail_destinasi.css" />
</head>
<body>
<?php // Navbar sudah diinclude di atas ?>

<header class="hero" style="background-image: url('<?php echo $gambar_utama_wisata; ?>');">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h1><?php echo $nama_wisata_display; ?></h1>
        <p class="hero-subtitle"><?php echo $deskripsi_singkat_wisata; ?></p>
    </div>
</header>

<div class="container">
    <main class="main-content">
        <?php if (!empty($gallery_images) && count($gallery_images) > 0): ?>
        <section class="content-section">
            <h3 class="section-title">Galeri Foto</h3>
            <div class="gallery-grid">
                <?php foreach ($gallery_images as $image): ?>
                <img src="<?php echo htmlspecialchars(str_replace('../', './', $image['url'])); ?>" alt="<?php echo htmlspecialchars($image['caption'] ?? 'Gambar Wisata'); ?>" class="gallery-image">
                <?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>

        <section class="content-section">
            <h3 class="section-title">Tentang <?php echo $nama_wisata_display; ?></h3>
            <div class="section-description">
                <?php
                if (!empty(trim($wisata['deskripsi_wisata']))) {
                    $deskripsi_paragraphs = explode("\n", trim($wisata['deskripsi_wisata']));
                    foreach ($deskripsi_paragraphs as $paragraph) {
                        if(!empty(trim($paragraph))){
                            echo "<p>" . nl2br(htmlspecialchars(trim($paragraph))) . "</p>";
                        }
                    }
                } else {
                    echo "<p>Informasi detail mengenai tempat ini akan segera hadir. Nikmati keindahan visual dan aktivitas yang ditawarkan!</p>";
                }
                ?>
            </div>
        </section>

        <?php if (!empty($activities_wisata)): ?>
        <section class="content-section">
            <h3 class="section-title">Apa yang Bisa Dilakukan?</h3>
            <div class="activities-grid">
                <?php foreach ($activities_wisata as $activity): ?>
                <div class="activity-card">
                    <i class="<?php echo $activity['icon']; ?> activity-icon"></i>
                    <span class="activity-text"><?php echo $activity['text']; ?></span>
                </div>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>

        <section class="content-section">
            <h3 class="section-title">Rating & Ulasan Pengunjung</h3>
            <div class="reviews-container">
                <?php if (!empty($ulasan_list)): ?>
                    <?php foreach ($ulasan_list as $ulasan): ?>
                    <div class="review-card">
                        <div class="review-header">
                            <span class="reviewer-name"><?php echo htmlspecialchars($ulasan['nama_depan'] . ' ' . $ulasan['nama_belakang']); ?></span>
                            <span class="review-rating">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <?php echo ($i <= $ulasan['rating']) ? '<i class="fas fa-star"></i>' : '<i class="far fa-star"></i>'; ?>
                                <?php endfor; ?>
                            </span>
                        </div>
                        <p class="review-comment"><?php echo nl2br(htmlspecialchars($ulasan['komentar'])); ?></p>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="section-description">Belum ada ulasan untuk destinasi ini. Jadilah yang pertama memberikan ulasan!</p>
                <?php endif; ?>
            </div>
        </section>

        <section class="content-section" id="kirim-ulasan">
            <h3 class="section-title">Bagikan Pengalaman Anda</h3>
            <?php if (!empty($ulasan_message)) echo "<div class='form-message-container'>".$ulasan_message."</div>"; ?>

            <?php if (isset($_SESSION['user']['id_pengunjung'])): ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?id=<?php echo $id_wisata; ?>#kirim-ulasan" method="post" class="review-form">
                <div class="form-group">
                    <label for="rating" class="form-label">Rating Anda:</label>
                    <div class="star-rating">
                        <input type="radio" id="star5" name="rating" value="5" required /><label for="star5" title="Luar Biasa"></label>
                        <input type="radio" id="star4" name="rating" value="4" /><label for="star4" title="Bagus"></label>
                        <input type="radio" id="star3" name="rating" value="3" /><label for="star3" title="Cukup"></label>
                        <input type="radio" id="star2" name="rating" value="2" /><label for="star2" title="Kurang"></label>
                        <input type="radio" id="star1" name="rating" value="1" /><label for="star1" title="Buruk"></label>
                    </div>
                    <div class="rating-description-selected"></div>
                </div>
                <div class="form-group">
                    <label for="komentar" class="form-label">Komentar Anda:</label>
                    <textarea id="komentar" name="komentar" class="form-textarea" rows="4" placeholder="Tuliskan pengalaman menarik Anda di sini..." required></textarea>
                </div>
                <button type="submit" name="kirim_ulasan" class="submit-button">
                    <i class="fas fa-paper-plane"></i> Kirim Ulasan
                </button>
            </form>
            <?php else: ?>
                <p class="section-description">Anda harus <a href="login.php" class="login-link">login</a> atau <a href="register.php" class="register-link">daftar</a> untuk mengirim ulasan.</p>
            <?php endif; ?>
        </section>
    </main>

    <aside class="sidebar">
        <div class="info-card">
            <h4 class="card-title">Informasi Penting</h4>
            <ul class="info-list">
                <?php foreach ($info_singkat as $info): ?>
                <li class="info-item">
                    <i class="fas fa-info-circle info-icon"></i>
                    <span><?php echo htmlspecialchars($info); ?></span>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="location-card">
            <h4 class="card-title">Lokasi Destinasi</h4>
            <div class="map-container">
                <?php
                $map_query_param = ($wisata['alamat_wisata'] ?: $nama_wisata_display) . (!empty($wisata['nama_lokasi']) ? ', ' . $wisata['nama_lokasi'] : '');
                // Menggunakan https untuk Google Maps dan memastikan q parameter untuk query pencarian
                $map_link = "https://www.google.com/maps/search/?api=1&query=" . urlencode($map_query_param);
                ?>
                <a href="<?php echo $map_link; ?>" target="_blank" title="Lihat di Google Maps">
                <?php if (filter_var($peta_lokasi_url, FILTER_VALIDATE_URL) || (file_exists($peta_lokasi_url) && $peta_lokasi_url !== './Gambar/default-map.png') ): ?>
                    <img class="map-image" src="<?php echo $peta_lokasi_url; ?>" alt="Peta Lokasi <?php echo $nama_wisata_display; ?>">
                <?php else: ?>
                    <img class="map-image" src="./Gambar/default-map.png" alt="Peta Lokasi Default">
                <?php endif; ?>
                </a>
            </div>
            <div class="location-address">
                <i class="fas fa-map-marker-alt location-icon"></i>
                <span><?php echo $alamat_display; ?></span>
            </div>
            <?php if(!empty($wisata['nama_lokasi'])): ?>
            <div class="location-area">
                <i class="fas fa-thumbtack location-icon"></i>
                <span>Area: <?php echo htmlspecialchars($wisata['nama_lokasi']); ?></span>
            </div>
            <?php endif; ?>
             <a href="<?php echo $map_link; ?>" target="_blank" class="map-link-button">
                <i class="fas fa-directions"></i> Lihat Rute di Peta
            </a>
        </div>

        <?php if (!empty($wisata_terdekat_list)): ?>
        <div class="related-card">
            <h4 class="card-title">Wisata Sekitar Lainnya</h4>
            <ul class="related-list">
                <?php foreach ($wisata_terdekat_list as $terdekat): ?>
                <li class="related-item">
                    <i class="fas fa-map-pin related-icon"></i>
                    <a href="wisata_detail.php?id=<?php echo $terdekat['id_wisata']; ?>"><?php echo htmlspecialchars($terdekat['nama_wisata']); ?></a>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>

        <?php if (!empty($tips_berkunjung_list)): ?>
        <div class="tips-card">
            <h4 class="card-title">Tips Berkunjung</h4>
            <ul class="tips-list">
                <?php foreach ($tips_berkunjung_list as $tip): ?>
                <li class="tips-item">
                    <i class="fas fa-lightbulb tips-icon"></i>
                    <span><?php echo $tip; ?></span>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>
    </aside>
</div>

<?php include 'Komponen/footer.php'; ?>

<?php
// Tutup koneksi database di akhir skrip setelah semua selesai
if ($conn) {
    mysqli_close($conn);
}
?>

<script>
// Script untuk deskripsi rating bintang interaktif
const starRatingForm = document.querySelector('.star-rating');
const ratingDescriptionSelected = document.querySelector('.rating-description-selected');
const ratingLabels = {
    "5": "Luar Biasa Sekali!",
    "4": "Bagus & Memuaskan",
    "3": "Cukup Baik",
    "2": "Kurang Memuaskan",
    "1": "Sangat Buruk"
};

if (starRatingForm && ratingDescriptionSelected) {
    const radioButtons = starRatingForm.querySelectorAll('input[type="radio"]');
    radioButtons.forEach(radio => {
        radio.addEventListener('change', function(event) {
            if (event.target.name === 'rating') {
                ratingDescriptionSelected.textContent = ratingLabels[event.target.value] || '';
                ratingDescriptionSelected.style.marginTop = '8px';
                ratingDescriptionSelected.style.fontSize = '0.9em';
                ratingDescriptionSelected.style.color = 'var(--dark-color)'; // Pastikan var(--dark-color) terdefinisi di CSS Anda
            }
        });
    });
}
</script>
</body>
</html>