<?php
include './Komponen/navbar.php';
require_once './backend/koneksi.php'; // Sesuaikan path

$ulasan_message = ''; // Untuk menampilkan pesan sukses/error setelah submit ulasan

// --- Proses Penambahan Ulasan Pemandu ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_ulasan_pemandu'])) {
    $id_pemandu_target = filter_input(INPUT_POST, 'id_pemandu_wisata', FILTER_VALIDATE_INT);
    $rating = filter_input(INPUT_POST, 'rating', FILTER_VALIDATE_INT);
    $komentar = trim($_POST['komentar']);
    
    $id_pengunjung_session = null;
    $nama_pengulas_form = null;

    // Cek apakah pengguna login (sesuaikan dengan sistem login Anda)
    if (isset($_SESSION['id_pengunjung']) && !empty($_SESSION['id_pengunjung'])) {
        $id_pengunjung_session = (int)$_SESSION['id_pengunjung'];
        // Ambil nama pengunjung dari session jika ada, untuk ditampilkan di "Anda akan memberi ulasan sebagai:"
        // Pastikan $_SESSION['nama_pengunjung'] di-set saat login
    } else {
        $nama_pengulas_form = trim($_POST['nama_pengulas'] ?? '');
        if (empty($nama_pengulas_form)) {
            $ulasan_message = "<div class='alert alert-danger'>Nama Anda diperlukan jika tidak login.</div>";
        }
    }

    // Validasi dasar
    if (empty($komentar)) {
        $ulasan_message .= "<div class='alert alert-danger'>Komentar tidak boleh kosong.</div>";
    }
    if ($id_pemandu_target === false || $id_pemandu_target <= 0) {
        $ulasan_message .= "<div class='alert alert-danger'>ID Pemandu tidak valid.</div>";
    }
    if ($rating === false || $rating < 1 || $rating > 5) {
        $ulasan_message .= "<div class='alert alert-danger'>Rating tidak valid (harus antara 1-5).</div>";
    }

    if (empty($ulasan_message)) { // Jika tidak ada error validasi
        $sql_insert_ulasan = "INSERT INTO ulasan_pemandu (id_pemandu_wisata, id_pengunjung, nama_pengulas, rating, komentar, tanggal_ulasan) 
                                VALUES (?, ?, ?, ?, ?, NOW())";
        $stmt_insert = $conn->prepare($sql_insert_ulasan);
        
        // Tipe data untuk bind_param: i (integer), i (integer), s (string), i (integer), s (string)
        $stmt_insert->bind_param("iisis", $id_pemandu_target, $id_pengunjung_session, $nama_pengulas_form, $rating, $komentar);

        if ($stmt_insert->execute()) {
            $_SESSION['ulasan_message'] = "<div class='alert alert-success'>Ulasan Anda berhasil ditambahkan! Terima kasih.</div>";
            header("Location: " . $_SERVER['PHP_SELF'] . "?id_pemandu=" . $id_pemandu_target . "#reviews-section");
            exit;
        } else {
            $ulasan_message = "<div class='alert alert-danger'>Gagal menyimpan ulasan: " . htmlspecialchars($stmt_insert->error) . "</div>";
        }
        $stmt_insert->close();
    }
}

if (isset($_SESSION['ulasan_message'])) {
    $ulasan_message = $_SESSION['ulasan_message'];
    unset($_SESSION['ulasan_message']); 
}


$id_pemandu = isset($_GET['id_pemandu']) && is_numeric($_GET['id_pemandu']) ? (int)$_GET['id_pemandu'] : 0;

// --- Fetch Data Pemandu Utama ---
// Kolom 'telepon' dan 'email' akan otomatis terbawa jika sudah ditambahkan ke tabel 'pemandu_wisata'
// dan query menggunakan pw.*
$pemandu = null;
$sql_pemandu = "SELECT pw.*, l.nama_lokasi
                FROM pemandu_wisata pw
                LEFT JOIN lokasi l ON pw.id_lokasi = l.id_lokasi 
                WHERE pw.id_pemandu_wisata = ?";
$stmt_pemandu_main = $conn->prepare($sql_pemandu); 
if ($stmt_pemandu_main) {
    $stmt_pemandu_main->bind_param("i", $id_pemandu);
    $stmt_pemandu_main->execute();
    $result_pemandu_main = $stmt_pemandu_main->get_result();
    if ($result_pemandu_main) {
        $pemandu = $result_pemandu_main->fetch_assoc();
    }
    $stmt_pemandu_main->close();
}


if (!$pemandu) {
    echo "<div class='container' style='padding-top: 20px; text-align:center;'>Pemandu wisata tidak ditemukan atau ID tidak valid.</div>";
    include "./Komponen/footer.php";
    exit;
}

$tahun_pengalaman_str = $pemandu['pengalaman'] ?? 'Informasi belum tersedia';

$bahasa_dikuasai = [];
$sql_bahasa = "SELECT b.nama_bahasa FROM bahasa b
                INNER JOIN pemandu_bahasa pb ON b.id_bahasa = pb.id_bahasa
                WHERE pb.id_pemandu_wisata = ?
                ORDER BY b.nama_bahasa ASC";
$stmt_bahasa_main = $conn->prepare($sql_bahasa); 
if ($stmt_bahasa_main) {
    $stmt_bahasa_main->bind_param("i", $id_pemandu);
    $stmt_bahasa_main->execute();
    $result_bahasa_main = $stmt_bahasa_main->get_result();
    if ($result_bahasa_main) {
        while ($row_bhs = $result_bahasa_main->fetch_assoc()) {
            $bahasa_dikuasai[] = $row_bhs['nama_bahasa'];
        }
    }
    $stmt_bahasa_main->close();
}

$paket_tur_list = [];
$sql_paket = "SELECT id_paket_wisata, nama_paket, durasi_paket, harga, deskripsi
                FROM paket_wisata
                WHERE id_pemandu_wisata = ?
                ORDER BY nama_paket ASC";
$stmt_paket_main = $conn->prepare($sql_paket); 
if ($stmt_paket_main) {
    $stmt_paket_main->bind_param("i", $id_pemandu);
    $stmt_paket_main->execute();
    $result_paket_main = $stmt_paket_main->get_result();
    if ($result_paket_main) {
        $paket_tur_list = $result_paket_main->fetch_all(MYSQLI_ASSOC);
    }
    $stmt_paket_main->close();
}

$ulasan_pemandu_list = [];
$sql_ulasan_pemandu = "SELECT
                            up.rating,
                            up.komentar,
                            up.tanggal_ulasan,
                            up.nama_pengulas AS nama_pengulas_anonim,
                            peng.nama_depan AS reviewer_nama_depan,
                            peng.nama_belakang AS reviewer_nama_belakang,
                            peng.avatar AS reviewer_avatar
                        FROM ulasan_pemandu up
                        LEFT JOIN pengunjung peng ON up.id_pengunjung = peng.id_pengunjung
                        WHERE up.id_pemandu_wisata = ?
                        ORDER BY up.tanggal_ulasan DESC
                        LIMIT 5"; 
$stmt_ulasan_pemandu_query = $conn->prepare($sql_ulasan_pemandu);
if ($stmt_ulasan_pemandu_query) {
    $stmt_ulasan_pemandu_query->bind_param("i", $id_pemandu);
    $stmt_ulasan_pemandu_query->execute();
    $result_ulasan_pemandu_query = $stmt_ulasan_pemandu_query->get_result();
    if ($result_ulasan_pemandu_query) {
        $ulasan_pemandu_list = $result_ulasan_pemandu_query->fetch_all(MYSQLI_ASSOC);
    }
    $stmt_ulasan_pemandu_query->close();
}

$total_ulasan_pemandu_count = 0;
$rating_pemandu_distribution = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
$sql_stats_pemandu = "SELECT rating, COUNT(id_ulasan_pemandu) as count
                        FROM ulasan_pemandu
                        WHERE id_pemandu_wisata = ?
                        GROUP BY rating";
$stmt_stats_pemandu = $conn->prepare($sql_stats_pemandu);
if ($stmt_stats_pemandu) {
    $stmt_stats_pemandu->bind_param("i", $id_pemandu);
    $stmt_stats_pemandu->execute();
    $result_stats_pemandu = $stmt_stats_pemandu->get_result();
    if ($result_stats_pemandu) {
        while($row_stat = $result_stats_pemandu->fetch_assoc()){
            if(isset($rating_pemandu_distribution[$row_stat['rating']])){
                $rating_pemandu_distribution[$row_stat['rating']] = (int)$row_stat['count'];
                $total_ulasan_pemandu_count += (int)$row_stat['count'];
            }
        }
    }
    $stmt_stats_pemandu->close();
}

$rata_rata_rating_pemandu_display = $pemandu['rating'] ?? 0.0; 
if ($total_ulasan_pemandu_count > 0) {
    $sum_of_pemandu_ratings = 0;
    foreach($rating_pemandu_distribution as $rating_value => $count_val){
        $sum_of_pemandu_ratings += $rating_value * $count_val;
    }
    $rata_rata_rating_pemandu_display = $sum_of_pemandu_ratings / $total_ulasan_pemandu_count;
}

function displayStarsDetail($rating_value) {
    $rating = (float)($rating_value ?? 0.0);
    $stars_html = '';
    for ($i = 1; $i <= 5; $i++) {
        if ($rating >= $i) {
            $stars_html .= '<i class="fas fa-star"></i>';
        } elseif ($rating >= $i - 0.5) {
            $stars_html .= '<i class="fas fa-star-half-alt"></i>';
        } else {
            $stars_html .= '<i class="far fa-star"></i>';
        }
    }
    return $stars_html;
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Profil <?php echo htmlspecialchars($pemandu['nama_pemandu']); ?> | Tour Guide GoTravel</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
    /* ... (CSS Anda dari file sebelumnya, pastikan .form-group, .form-control, dan .btn-primary sudah terdefinisi jika digunakan di form ulasan) ... */
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f7f9fc; color: #333; line-height: 1.6; }
    .container { max-width: 1200px; margin: 0 auto; padding: 0 1rem; }
    .profile-hero { background-color: #2c7a51; padding: 2rem 0 3rem 0; color: white; }
    .profile-header { padding-top: 2rem; display: flex; align-items: center; gap: 2rem; }
    .profile-image { width: 150px; height: 150px; border-radius: 50%; overflow: hidden; border: 4px solid white; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2); flex-shrink: 0; }
    .profile-image img { width: 100%; height: 100%; object-fit: cover; }
    .profile-info h1 { font-size: 2.2rem; margin-bottom: 0.5rem; }
    .profile-meta { display: flex; flex-wrap: wrap; gap: 1rem 1.5rem; margin-top: 0.75rem; font-size: 0.95rem; }
    .profile-meta-item { display: flex; align-items: center; }
    .profile-meta-item i { margin-right: 0.5rem; width:16px; text-align:center; }
    .profile-badges { display: flex; flex-wrap: wrap; gap: 0.75rem; margin-top: 1rem; }
    .profile-badge { background-color: rgba(255, 255, 255, 0.15); padding: 0.35rem 0.85rem; border-radius: 50px; font-size: 0.85rem; display: flex; align-items: center; }
    .profile-badge i { margin-right: 0.35rem; }
    .certified-badge { background-color: #27ae60; } /* Contoh badge tambahan */

    .main-content { margin-top: 2rem; display: grid; grid-template-columns: minmax(0, 2fr) minmax(0, 1fr); gap: 2rem; }
    .section-title { color: #2c7a51; font-size: 1.4rem; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 2px solid #e9f5db; font-weight: 600; }
    .about-section p, .experience-list li, .specialties-list li { margin-bottom: 0.8rem; color: #454545; }
    .languages-section, .experience-section, .specialties-section, .tours-section, .reviews-section, .gallery-section { margin-top: 2.5rem; }
    .languages-list { display: flex; flex-wrap: wrap; gap: 0.75rem; }
    .language-item { background-color: #e9f5db; color: #2c7a51; padding: 0.5rem 1rem; border-radius: 50px; display: flex; align-items: center; font-size: 0.9rem; }
    .language-item i { margin-right: 0.5rem; }
    .experience-list, .specialties-list { list-style: none; padding-left: 0; }
    .experience-item, .specialty-item { margin-bottom: 0.8rem; padding-left: 1.75rem; position: relative; }
    .experience-item:before, .specialty-item:before { content: "\f058"; font-family: "Font Awesome 6 Free"; font-weight: 900; color: #27ae60; position: absolute; left: 0; top: 2px; }
    
    .tour-card { background-color: white; border-radius: 8px; padding: 1.5rem; margin-bottom: 1.5rem; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); border: 1px solid #e9ecef; }
    .tour-card h3 { margin-bottom: 0.5rem; color: #2c7a51; font-size: 1.2rem; }
    .tour-card p { font-size: 0.95rem; color: #555; margin-bottom: 1rem;}
    .tour-details { margin-top: 1rem; font-size: 0.9rem; }
    .tour-detail { display: flex; align-items: center; margin-bottom: 0.6rem; color: #454545; }
    .tour-detail i { margin-right: 0.75rem; color: #2c7a51; width: 20px; text-align: center; }
    .tour-actions { display: flex; justify-content: space-between; align-items: center; margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid #f0f0f0; }
    .tour-price { font-weight: bold; color: #2c7a51; font-size: 1.2rem; }
    .tour-price span { font-size: 0.85rem; color: #666; font-weight: normal; }
    .book-button { background-color: #2c7a51; color: white; border: none; padding: 0.6rem 1.2rem; border-radius: 5px; cursor: pointer; transition: background-color 0.3s; text-decoration: none; font-size: 0.9rem; }
    .book-button:hover { background-color: #1d5b3a; }

    .sidebar-card { background-color: white; border-radius: 8px; padding: 1.5rem; margin-bottom: 2rem; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); border: 1px solid #e9ecef; }
    .contact-section h3 { color: #2c7a51; margin-bottom: 1rem; font-size: 1.2rem; }
    .contact-option { display: flex; align-items: center; margin-bottom: 1rem; padding: 0.75rem; background-color: #f8f9fa; border-radius: 5px; cursor: pointer; transition: background-color 0.3s; text-decoration: none; color: #333; }
    .contact-option:hover { background-color: #e9f5db; }
    .contact-option i { width: 35px; height: 35px; background-color: #2c7a51; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 1rem; font-size: 1rem; }
    
    .reviews-section { margin-top: 2.5rem; }
    .review-stats { display: flex; align-items: center; gap: 2rem; margin-bottom: 2rem; background: #fff; padding: 1.5rem; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
    .average-rating { text-align: center; }
    .average-rating .number { font-size: 2.5rem; font-weight: bold; color: #2c7a51; }
    .average-rating .stars { color: #ffc107; font-size: 1.1rem; margin: 0.3rem 0; }
    .average-rating .count { color: #666; font-size: 0.9rem; }
    .rating-bars { flex-grow: 1; }
    .rating-bar { display: flex; align-items: center; margin-bottom: 0.5rem; }
    .rating-label { width: 40px; text-align: right; margin-right: 0.75rem; font-size: 0.9rem; color: #555;}
    .rating-progress { height: 8px; background-color: #e9ecef; border-radius: 4px; overflow: hidden; flex-grow: 1; }
    .rating-progress-fill { height: 100%; background-color: #ffc107; }
    .rating-count { width: 30px; margin-left: 0.75rem; color: #666; font-size: 0.85rem; text-align: right; }
    .review-card { background-color: white; border-radius: 8px; padding: 1.5rem; margin-bottom: 1.5rem; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); border: 1px solid #e9ecef; }
    .review-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.75rem; }
    .reviewer { display: flex; align-items: center; }
    .reviewer-avatar { width: 45px; height: 45px; border-radius: 50%; overflow: hidden; margin-right: 0.75rem; background-color: #eee; }
    .reviewer-avatar img { width: 100%; height: 100%; object-fit: cover; }
    .reviewer-info h4 { margin: 0; font-size: 1rem; }
    .reviewer-info .date { color: #666; font-size: 0.85rem; }
    .review-rating { color: #ffc107; font-size: 0.9rem; }
    .review-content p { margin-bottom: 0.5rem; font-size: 0.95rem; color: #454545; }
    .see-more-button { display: block; text-align: center; padding: 0.75rem; background-color: #f0f0f0; color: #555; border-radius: 5px; margin-top: 1.5rem; text-decoration: none; transition: background-color 0.3s; font-weight: 500; }
    .see-more-button:hover { background-color: #e0e0e0; }
    .no-reviews { text-align: center; padding: 2rem; background-color: #fff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); color: #666; }
    
    .add-review-form { background-color: white; border-radius: 8px; padding: 2rem; margin-top: 2rem; box-shadow: 0 4px 12px rgba(0,0,0,0.08); border: 1px solid #e9ecef; }
    .add-review-form h3 { color: #2c7a51; margin-bottom: 1.5rem; font-size: 1.3rem; text-align: center; }
    .form-group { margin-bottom: 1rem; }
    .form-group label { display: block; margin-bottom: 0.5rem; font-weight: 500; font-size: 0.9rem; color: #495057;}
    .form-control { width: 100%; padding: 0.75rem; border: 1px solid #ced4da; border-radius: 5px; font-family: inherit; font-size: 0.95rem; box-sizing: border-box; } /* Added box-sizing */
    textarea.form-control { min-height: 80px; } /* Specific for textarea */
    .rating-stars-input { display: flex; flex-direction: row-reverse; justify-content: center; gap: 0.3rem; margin-bottom: 1rem; }
    .rating-stars-input input[type="radio"] { display: none; }
    .rating-stars-input label { font-size: 2rem; color: #ddd; cursor: pointer; transition: color 0.2s; }
    .rating-stars-input input[type="radio"]:checked ~ label, 
    .rating-stars-input label:hover,
    .rating-stars-input label:hover ~ label 
    { color: #ffc107; }
    .alert { padding: 0.75rem 1.25rem; margin-bottom: 1rem; border: 1px solid transparent; border-radius: 0.25rem; }
    .alert-success { color: #155724; background-color: #d4edda; border-color: #c3e6cb; }
    .alert-danger { color: #721c24; background-color: #f8d7da; border-color: #f5c6cb; }
    .btn-primary { background-color: #2c7a51; color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 5px; cursor: pointer; transition: background-color 0.3s; font-size: 1rem; font-weight: 500; }
    .btn-primary:hover { background-color: #1d5b3a; }

    @media (max-width: 992px) { .main-content { grid-template-columns: 1fr; } }
    @media (max-width: 768px) { .profile-header { flex-direction: column; text-align: center; } .profile-meta, .profile-badges { justify-content: center; } .review-stats {flex-direction: column; gap: 1rem;} }
  </style>
</head>
<body>
  <section class="profile-hero">
    <div class="container">
      <div class="profile-header">
        <div class="profile-image">
            <img src="<?php echo !empty($pemandu['foto_url']) ? htmlspecialchars($pemandu['foto_url']) : './assets/img/default-avatar.png'; ?>" alt="<?php echo htmlspecialchars($pemandu['nama_pemandu']); ?>" onerror="this.onerror=null;this.src='./assets/img/default-avatar.png';">
        </div>
        <div class="profile-info">
          <h1><?php echo htmlspecialchars($pemandu['nama_pemandu']); ?></h1>
          <div class="profile-meta">
            <?php if (!empty($pemandu['nama_lokasi'])): ?>
            <div class="profile-meta-item">
              <i class="fas fa-map-marker-alt"></i>
              <span><?php echo htmlspecialchars($pemandu['nama_lokasi']); ?></span>
            </div>
            <?php endif; ?>
            <div class="profile-meta-item">
              <i class="fas fa-star"></i>
              <span><?php echo htmlspecialchars(number_format($rata_rata_rating_pemandu_display, 1)); ?> (<?php echo $total_ulasan_pemandu_count; ?> ulasan)</span>
            </div>
            <?php if (isset($pemandu['jumlah_wisatawan_dibimbing']) && $pemandu['jumlah_wisatawan_dibimbing'] > 0): // Ganti 'jumlah_wisatawan_dibimbing' dengan nama kolom yang sesuai jika ada ?>
            <div class="profile-meta-item">
              <i class="fas fa-user-friends"></i>
              <span><?php echo htmlspecialchars($pemandu['jumlah_wisatawan_dibimbing']); ?> wisatawan telah dibimbing</span>
            </div>
            <?php endif; ?>
          </div>
          <div class="profile-badges">
             <?php if (isset($pemandu['is_tersertifikasi']) && $pemandu['is_tersertifikasi']): // Ganti 'is_tersertifikasi' dengan nama kolom yang sesuai jika ada ?>
            <div class="profile-badge certified-badge">
              <i class="fas fa-certificate"></i>
              <span>Tersertifikasi</span>
            </div>
            <?php endif; ?>
            <?php if(!empty($tahun_pengalaman_str) && strpos($tahun_pengalaman_str, '0 tahun') === false && $tahun_pengalaman_str !== 'Informasi belum tersedia'): ?>
            <div class="profile-badge">
              <i class="fas fa-clock"></i>
              <span><?php echo htmlspecialchars($tahun_pengalaman_str); ?></span>
            </div>
            <?php endif; ?>
            </div>
        </div>
      </div>
    </div>
  </section>

  <div class="container">
    <div class="main-content">
      <div class="left-column">
        <section class="about-section">
          <h2 class="section-title">Tentang Pemandu</h2>
          <p><?php echo nl2br(htmlspecialchars($pemandu['biodata'] ?? 'Informasi tentang pemandu ini akan segera tersedia.')); ?></p>
        </section>
        
        <?php if (!empty($bahasa_dikuasai)): ?>
        <section class="languages-section">
          <h2 class="section-title">Bahasa yang Dikuasai</h2>
          <div class="languages-list">
            <?php foreach ($bahasa_dikuasai as $bahasa): ?>
            <div class="language-item">
              <i class="fas fa-language"></i>
              <span><?php echo htmlspecialchars($bahasa); ?></span>
            </div>
            <?php endforeach; ?>
          </div>
        </section>
        <?php endif; ?>
        
        <?php if (!empty($pemandu['pengalaman'])): ?>
        <section class="experience-section">
          <h2 class="section-title">Pengalaman Pemandu</h2>
          <p><?php echo nl2br(htmlspecialchars($pemandu['pengalaman'])); ?></p>
          </section>
        <?php endif; ?>
        
        <?php if (!empty($pemandu['spesialisasi'])): ?>
        <section class="specialties-section">
          <h2 class="section-title">Spesialisasi</h2>
            <ul class="specialties-list">
            <?php
                $spesialisasi_list = array_map('trim', explode(',', $pemandu['spesialisasi']));
                foreach ($spesialisasi_list as $spec):
            ?>
            <li class="specialty-item"><?php echo htmlspecialchars($spec); ?></li>
            <?php endforeach; ?>
          </ul>
        </section>
        <?php endif; ?>
        
        <?php if (!empty($paket_tur_list)): ?>
        <section class="tours-section">
          <h2 class="section-title">Paket Tur yang Ditawarkan oleh Pemandu Ini</h2>
          <?php foreach ($paket_tur_list as $paket): ?>
          <div class="tour-card">
            <h3><?php echo htmlspecialchars($paket['nama_paket']); ?></h3>
            <p><?php echo htmlspecialchars(substr($paket['deskripsi'] ?? 'Deskripsi tur akan segera tersedia.', 0, 150) . (strlen($paket['deskripsi'] ?? '') > 150 ? '...' : '')); ?></p>
            <div class="tour-details">
              <?php if (!empty($paket['durasi_paket'])): ?>
              <div class="tour-detail">
                <i class="far fa-clock"></i>
                <span>Durasi: <?php echo htmlspecialchars($paket['durasi_paket']); ?></span>
              </div>
              <?php endif; ?>
              </div>
            <div class="tour-actions">
              <div class="tour-price">
                Rp <?php echo htmlspecialchars(number_format((float)($paket['harga'] ?? 0), 0, ',', '.')); ?>
                <span>/paket</span> </div>
              <a href="paket_wisata_detail.php?id=<?php echo $paket['id_paket_wisata']; ?>" class="book-button">Lihat Detail Paket</a>
            </div>
          </div>
          <?php endforeach; ?>
        </section>
        <?php endif; ?>
        
        <section class="reviews-section" id="reviews-section">
          <h2 class="section-title">Ulasan untuk Pemandu Ini</h2>

          <?php if (!empty($ulasan_message)) { echo $ulasan_message; } ?>

          <?php if ($total_ulasan_pemandu_count > 0): ?>
          <div class="review-stats">
            <div class="average-rating">
              <div class="number"><?php echo htmlspecialchars(number_format($rata_rata_rating_pemandu_display, 1)); ?></div>
              <div class="stars"><?php echo displayStarsDetail($rata_rata_rating_pemandu_display); ?></div>
              <div class="count"><?php echo $total_ulasan_pemandu_count; ?> ulasan</div>
            </div>
            <div class="rating-bars">
                <?php for ($i = 5; $i >= 1; $i--):
                    $percentage = ($total_ulasan_pemandu_count > 0 && isset($rating_pemandu_distribution[$i])) ? ($rating_pemandu_distribution[$i] / $total_ulasan_pemandu_count) * 100 : 0;
                    $count_for_star = isset($rating_pemandu_distribution[$i]) ? $rating_pemandu_distribution[$i] : 0;
                ?>
              <div class="rating-bar">
                <div class="rating-label"><?php echo $i; ?>★</div>
                <div class="rating-progress"><div class="rating-progress-fill" style="width: <?php echo $percentage; ?>%"></div></div>
                <div class="rating-count"><?php echo $count_for_star; ?></div>
              </div>
              <?php endfor; ?>
            </div>
          </div>
          
          <?php foreach ($ulasan_pemandu_list as $ulasan_item): ?>
          <div class="review-card">
              <div class="review-header">
                <div class="reviewer">
                  <div class="reviewer-avatar">
                    <img src="<?php echo !empty($ulasan_item['reviewer_avatar']) ? htmlspecialchars($ulasan_item['reviewer_avatar']) : './assets/img/default-avatar.png'; ?>" 
                         alt="<?php echo htmlspecialchars($ulasan_item['reviewer_nama_depan'] ?? $ulasan_item['nama_pengulas_anonim'] ?? 'Pengulas'); ?>" 
                         onerror="this.onerror=null;this.src='./assets/img/default-avatar.png';">
                  </div>
                  <div class="reviewer-info">
                    <h4>
                        <?php 
                        if (!empty($ulasan_item['reviewer_nama_depan'])) {
                            echo htmlspecialchars($ulasan_item['reviewer_nama_depan'] . ' ' . ($ulasan_item['reviewer_nama_belakang'] ?? ''));
                        } elseif (!empty($ulasan_item['nama_pengulas_anonim'])) {
                            echo htmlspecialchars($ulasan_item['nama_pengulas_anonim']);
                        } else {
                            echo 'Pengulas Anonim';
                        }
                        ?>
                    </h4>
                    <?php if (!empty($ulasan_item['tanggal_ulasan'])): ?>
                        <div class="date"><?php echo date("d F Y, H:i", strtotime($ulasan_item['tanggal_ulasan'])); ?></div>
                    <?php endif; ?>
                  </div>
                </div>
                <div class="review-rating"><?php echo displayStarsDetail($ulasan_item['rating']); ?></div>
              </div>
              <div class="review-content"><p><?php echo nl2br(htmlspecialchars($ulasan_item['komentar'])); ?></p></div>
            </div>
          <?php endforeach; ?>

          <?php if ($total_ulasan_pemandu_count > count($ulasan_pemandu_list)): ?>
            <a href="semua_ulasan_pemandu.php?id_pemandu=<?php echo $id_pemandu; ?>" class="see-more-button">Lihat Semua Ulasan Pemandu (<?php echo $total_ulasan_pemandu_count; ?>)</a>
          <?php endif; ?>

          <?php else: ?>
              <?php if (empty($ulasan_message)) : ?>
                <div class="no-reviews">
                    <i class="fas fa-comment-dots fa-3x" style="margin-bottom: 1rem; color: #ccc;"></i>
                    <p>Belum ada ulasan untuk pemandu ini.</p>
                </div>
            <?php endif; ?>
          <?php endif; ?>

            <div class="add-review-form">
              <h3>Beri Ulasan untuk <?php echo htmlspecialchars($pemandu['nama_pemandu']); ?></h3>
              <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . '?id_pemandu=' . $id_pemandu; ?>#reviews-section" method="POST">
                <input type="hidden" name="id_pemandu_wisata" value="<?php echo $id_pemandu; ?>">
                
                <?php 
                if (!isset($_SESSION['id_pengunjung']) || empty($_SESSION['id_pengunjung'])): 
                ?>
                    <div class="form-group">
                        <label for="nama_pengulas">Nama Anda:</label>
                        <input type="text" name="nama_pengulas" id="nama_pengulas" class="form-control" required>
                    </div>
                <?php else: ?>
                    <p style="margin-bottom:1rem;">Anda akan memberi ulasan sebagai: <strong><?php echo htmlspecialchars($_SESSION['nama_pengunjung'] ?? 'Pengunjung Terdaftar'); // Pastikan $_SESSION['nama_pengunjung'] di-set saat login ?></strong></p>
                <?php endif; ?>

                <div class="form-group">
                    <label>Rating Anda:</label>
                    <div class="rating-stars-input">
                        <input type="radio" id="star5" name="rating" value="5" required><label for="star5" title="Luar Biasa">★</label>
                        <input type="radio" id="star4" name="rating" value="4"><label for="star4" title="Baik">★</label>
                        <input type="radio" id="star3" name="rating" value="3"><label for="star3" title="Cukup">★</label>
                        <input type="radio" id="star2" name="rating" value="2"><label for="star2" title="Kurang">★</label>
                        <input type="radio" id="star1" name="rating" value="1"><label for="star1" title="Buruk">★</label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="komentar">Komentar Anda:</label>
                    <textarea name="komentar" id="komentar" class="form-control" rows="4" placeholder="Bagikan pengalaman Anda dengan pemandu ini..." required></textarea>
                </div>
                <div style="text-align: center;">
                    <button type="submit" name="submit_ulasan_pemandu" class="btn-primary">Kirim Ulasan</button>
                </div>
              </form>
            </div>
        </section>
      </div>

      <aside class="right-column">
        <div class="sidebar-card contact-section">
          <h3>Hubungi Pemandu</h3>
          <?php
            // Data 'telepon' dan 'email' diambil dari array $pemandu
            // yang berasal dari query database di awal script.
            $nomor_telepon = $pemandu['telepon'] ?? null;
            $email_pemandu = $pemandu['email'] ?? null;
          ?>
          <?php if ($nomor_telepon): ?>
          <a href="tel:<?php echo htmlspecialchars(str_replace([' ','-','(',')'], '', $nomor_telepon)); ?>" class="contact-option">
            <i class="fas fa-phone-alt"></i>
            <span>Telepon <?php echo htmlspecialchars($pemandu['nama_pemandu']); ?></span>
          </a>
          <a href="https://wa.me/<?php 
            $no_wa = preg_replace('/[^0-9]/', '', $nomor_telepon);
            if (substr($no_wa, 0, 1) === '0') {
                $no_wa = '62' . substr($no_wa, 1);
            } elseif (substr($no_wa, 0, 2) !== '62') {
                 $no_wa = '62' . $no_wa;
            }
            echo htmlspecialchars($no_wa); 
          ?>?text=Halo%20<?php echo urlencode($pemandu['nama_pemandu']); ?>,%20saya%20tertarik%20dengan%20jasa%20pemandu%20wisata%20Anda." target="_blank" class="contact-option">
            <i class="fab fa-whatsapp"></i>
            <span>WhatsApp <?php echo htmlspecialchars($pemandu['nama_pemandu']); ?></span>
          </a>
          <?php endif; ?>
          <?php if ($email_pemandu): ?>
          <a href="mailto:<?php echo htmlspecialchars($email_pemandu); ?>" class="contact-option">
            <i class="fas fa-envelope"></i>
            <span>Email <?php echo htmlspecialchars($pemandu['nama_pemandu']); ?></span>
          </a>
          <?php endif; ?>
          <?php if (!$nomor_telepon && !$email_pemandu): ?>
            <p style="text-align:center; color:#777;">Informasi kontak tidak tersedia.</p>
          <?php endif; ?>
        </div>
      </aside>
    </div>
  </div>

  <?php include "./Komponen/footer.php" ?>
  <script>
    // Tidak ada JavaScript spesifik yang diperlukan untuk bagian kontak,
    // karena link telepon (tel:) dan email (mailto:) ditangani oleh browser.
    // JavaScript untuk form booking sudah dihapus sesuai permintaan sebelumnya.
  </script>
</body>
</html>