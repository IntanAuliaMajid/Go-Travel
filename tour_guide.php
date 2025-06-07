<?php

include './Komponen/navbar.php';
require_once './backend/koneksi.php'; // Sesuaikan path jika perlu

// --- Logic untuk Filter dan Pagination ---
$selected_location_id = isset($_GET['lokasi']) && is_numeric($_GET['lokasi']) ? (int)$_GET['lokasi'] : '';
$selected_language_id = isset($_GET['bahasa']) && is_numeric($_GET['bahasa']) ? (int)$_GET['bahasa'] : '';
$selected_rating_val = isset($_GET['rating']) && is_numeric($_GET['rating']) ? (float)$_GET['rating'] : 0;

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$guides_per_page = 6; // Jumlah guide per halaman
$offset = ($page - 1) * $guides_per_page;

// --- Bangun Query SQL ---
$sql_select_base = "SELECT DISTINCT pw.id_pemandu_wisata, pw.nama_pemandu, pw.biodata, pw.harga, pw.foto_url, pw.rating, l.nama_lokasi";
$sql_from_base = " FROM pemandu_wisata pw LEFT JOIN lokasi l ON pw.id_lokasi = l.id_lokasi";
$sql_from_extra_for_language = "";

if (!empty($selected_language_id)) {
    $sql_from_extra_for_language = " INNER JOIN pemandu_bahasa pb ON pw.id_pemandu_wisata = pb.id_pemandu_wisata";
}

$sql_where_parts = [];
$sql_params_values = [];
$sql_params_types = "";

if (!empty($selected_location_id)) {
    $sql_where_parts[] = "pw.id_lokasi = ?";
    $sql_params_values[] = $selected_location_id;
    $sql_params_types .= "i";
}

if (!empty($selected_language_id)) {
    $sql_where_parts[] = "pb.id_bahasa = ?";
    $sql_params_values[] = $selected_language_id;
    $sql_params_types .= "i";
}

if ($selected_rating_val > 0) {
    $sql_where_parts[] = "pw.rating >= ?";
    $sql_params_values[] = $selected_rating_val;
    $sql_params_types .= "d";
}

$sql_where = "";
if (!empty($sql_where_parts)) {
    $sql_where = " WHERE " . implode(" AND ", $sql_where_parts);
}

// Query untuk total guides (untuk pagination)
$sql_count = "SELECT COUNT(DISTINCT pw.id_pemandu_wisata) as total" . $sql_from_base . $sql_from_extra_for_language . $sql_where;
$stmt_count = $conn->prepare($sql_count);
$total_guides = 0;
if ($stmt_count) {
    if (!empty($sql_params_types)) {
        $stmt_count->bind_param($sql_params_types, ...$sql_params_values);
    }
    if ($stmt_count->execute()) {
        $result_count = $stmt_count->get_result();
        if($result_count) {
            $total_guides_row = $result_count->fetch_assoc();
            $total_guides = $total_guides_row ? (int)$total_guides_row['total'] : 0;
        }
    } else {
        // error_log("Error executing count query: " . $stmt_count->error); // Untuk debugging
    }
    $stmt_count->close();
} else {
    // error_log("Error preparing count query: " . $conn->error); // Untuk debugging
}
$total_pages = $total_guides > 0 ? ceil($total_guides / $guides_per_page) : 0;

if ($page > $total_pages && $total_pages > 0) {
    $page = $total_pages;
    $offset = ($page - 1) * $guides_per_page;
}


// Query untuk mengambil data guide dengan pagination
$sql_guides_data = $sql_select_base . $sql_from_base . $sql_from_extra_for_language . $sql_where . " ORDER BY pw.rating DESC, pw.nama_pemandu ASC LIMIT ? OFFSET ?";
$stmt_guides = $conn->prepare($sql_guides_data);

$current_params_values_for_data = $sql_params_values; // Salin parameter filter
$current_params_types_for_data = $sql_params_types;   // Salin tipe filter

$current_params_values_for_data[] = $guides_per_page; // Tambah parameter LIMIT
$current_params_types_for_data .= "i";
$current_params_values_for_data[] = $offset;          // Tambah parameter OFFSET
$current_params_types_for_data .= "i";

$guides = [];
if ($stmt_guides) {
    if(!empty($current_params_types_for_data)){ // Hanya bind jika ada parameter
         $stmt_guides->bind_param($current_params_types_for_data, ...$current_params_values_for_data);
    }
    if ($stmt_guides->execute()) {
        $result_guides = $stmt_guides->get_result();
        if ($result_guides) {
            $guides = $result_guides->fetch_all(MYSQLI_ASSOC);
        }
    } else {
        // error_log("Error executing guides data query: " . $stmt_guides->error); // Untuk debugging
    }
    $stmt_guides->close();
} else {
    // error_log("Error preparing guides data query: " . $conn->error); // Untuk debugging
}


// Fetch data untuk filter dinamis
$lokasi_filters = [];
$sql_lokasi_filter = "SELECT id_lokasi, nama_lokasi FROM lokasi ORDER BY nama_lokasi ASC";
$result_lokasi_filter = $conn->query($sql_lokasi_filter);
if ($result_lokasi_filter && $result_lokasi_filter->num_rows > 0) {
    while($row = $result_lokasi_filter->fetch_assoc()){
        $lokasi_filters[] = $row;
    }
}

$bahasa_filters = [];
$sql_bahasa_filter = "SELECT id_bahasa, nama_bahasa FROM bahasa ORDER BY nama_bahasa ASC";
$result_bahasa_filter = $conn->query($sql_bahasa_filter);
if ($result_bahasa_filter && $result_bahasa_filter->num_rows > 0) {
     while($row = $result_bahasa_filter->fetch_assoc()){
        $bahasa_filters[] = $row;
    }
}

function getGuideLanguages($conn_ref, $id_pemandu) {
    $languages = [];
    $sql = "SELECT b.nama_bahasa
            FROM bahasa b
            INNER JOIN pemandu_bahasa pb ON b.id_bahasa = pb.id_bahasa
            WHERE pb.id_pemandu_wisata = ?
            ORDER BY b.nama_bahasa";
    $stmt = $conn_ref->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $id_pemandu);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result){
            while ($row = $result->fetch_assoc()) {
                $languages[] = $row['nama_bahasa'];
            }
        }
        $stmt->close();
    }
    return $languages;
}

function displayStars($rating_value) {
    $rating = (float)($rating_value ?? 0.0);
    $stars_html = '';
    for ($i = 1; $i <= 5; $i++) {
        if ($rating >= $i) {
            $stars_html .= '<i class="fas fa-star"></i>'; // Bintang penuh
        } elseif ($rating >= $i - 0.75) { // Dianggap bintang penuh jika >= x.75
             $stars_html .= '<i class="fas fa-star"></i>';
        } elseif ($rating >= $i - 0.25 && $rating > $i - 0.75) { // Dianggap setengah jika antara x.25 dan x.75
            $stars_html .= '<i class="fas fa-star-half-alt"></i>';
        } else {
            $stars_html .= '<i class="far fa-star"></i>'; // Bintang kosong
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
  <title>Tour Guide Pilihan - GoTravel</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f7f9fc; color: #333; line-height: 1.6; }
    .hero { background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('https://campuspedia.id/news/wp-content/uploads/2020/10/tour-guide.jpg') no-repeat center center/cover; min-height: 60vh; display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; color: #fff; padding: 2rem; }
    .hero h1 { margin-top: 40px; font-size: 2.8rem; margin-bottom: 1rem; text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5); }
    .hero p { font-size: 1.1rem; max-width: 800px; margin-bottom: 2rem; }
    .container { max-width: 1200px; margin: 0 auto; padding: 0 1rem; }
    .section-heading { text-align: center; margin-bottom: 2.5rem; color: #2c7a51; padding-top: 3rem; }
    .section-heading h2 { font-size: 2.2rem; margin-bottom: 0.5rem; }
    .section-heading p { color: #666; max-width: 700px; margin: 0 auto; }
    .filter-section { background-color: #fff; padding: 1.5rem; margin-top: -50px; margin-bottom: 3rem; border-radius: 10px; box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1); position: relative; z-index: 10; max-width: 1000px; margin-left: auto; margin-right: auto; }
    .filter-container { display: flex; justify-content: space-around; align-items: flex-end; flex-wrap: wrap; gap: 1rem; }
    .filter-group { display: flex; flex-direction: column; align-items: flex-start; gap: 0.5rem; flex-grow: 1; min-width: 180px; }
    .filter-label { font-weight: 500; color: #495057; font-size: 0.9rem; }
    .filter-select { padding: 0.75rem 1rem; border-radius: 5px; border: 1px solid #ced4da; background-color: #fff; cursor: pointer; font-size: 0.95rem; width: 100%; }
    .filter-button { background-color: #2c7a51; color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 5px; cursor: pointer; transition: background-color 0.3s; font-size: 0.95rem; height: calc(0.75rem * 2 + 1.9em); /* Perkiraan tinggi select */ }
    .filter-button:hover { background-color: #1d5b3a; }
    .guides-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 2rem; margin-bottom: 3rem; }
    .guide-card { background-color: #fff; border-radius: 10px; overflow: hidden; box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08); transition: transform 0.3s, box-shadow 0.3s; display: flex; flex-direction: column; }
    .guide-card:hover { transform: translateY(-8px); box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12); }
    .guide-image { height: 220px; position: relative; overflow: hidden; background-color: #f0f0f0; /* Warna placeholder jika gambar error */ }
    .guide-image img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease; }
    .guide-card:hover .guide-image img { transform: scale(1.03); }
    .guide-badge { position: absolute; top: 0.8rem; right: 0.8rem; background-color: #e74c3c; color: white; padding: 0.3rem 0.8rem; border-radius: 50px; font-size: 0.75rem; font-weight: bold; }
    .certified-badge { background-color: #27ae60; }
    .guide-content { padding: 1.25rem; flex-grow: 1; display: flex; flex-direction: column; }
    .guide-content h3 { margin-bottom: 0.4rem; font-size: 1.25rem; color: #333; }
    .guide-location { color: #555; font-size: 0.9rem; display: flex; align-items: center; margin-bottom: 0.75rem; }
    .guide-location i { margin-right: 0.4rem; color: #2c7a51; }
    .guide-languages { display: flex; flex-wrap: wrap; gap: 0.4rem; margin-bottom: 1rem; min-height: 22px; }
    .language-tag { background-color: #e9f5db; color: #2c7a51; padding: 0.25rem 0.75rem; border-radius: 15px; font-size: 0.75rem; }
    .guide-rating { display: flex; align-items: center; margin-bottom: 1rem; }
    .guide-rating .stars { color: #f39c12; margin-right: 0.5rem; font-size: 1rem; }
    .guide-rating .stars .far.fa-star { color: #d3d3d3; }
    .guide-rating .count { color: #777; font-size: 0.85rem; }
    .guide-description { margin-bottom: 1.25rem; color: #555; font-size: 0.9rem; line-height: 1.5; flex-grow: 1; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; min-height: calc(1.5em * 3); }
    .guide-meta { display: flex; justify-content: space-between; align-items: center; padding-top: 1rem; border-top: 1px solid #f0f0f0; margin-top: auto; }
    .guide-price { font-weight: bold; color: #2c7a51; font-size: 1.1rem; }
    .guide-price span { font-size: 0.8rem; color: #777; font-weight: normal; }
    .guide-button { background-color: #2c7a51; color: white; border: none; padding: 0.6rem 1.2rem; border-radius: 5px; cursor: pointer; transition: background-color 0.3s; text-decoration: none; display: inline-block; font-size: 0.9rem; }
    .guide-button:hover { background-color: #1d5b3a; }
    .testimonials-section { background-color: #eef7ed; padding: 3rem 0; }
    .testimonials-container { display: flex; gap: 2rem; margin-top: 2rem; overflow-x: auto; padding: 1rem 0.5rem; scroll-snap-type: x mandatory; }
    .testimonial-card { background-color: #fff; border-radius: 10px; padding: 2rem; box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08); min-width: 320px; max-width: 380px; position: relative; scroll-snap-align: start; }
    .testimonial-card:before { content: "\201C"; font-size: 4rem; position: absolute; top: -10px; left: 10px; color: #d1e7dd; font-family: Georgia, serif; z-index: 0;}
    .testimonial-text { margin-bottom: 1.5rem; font-style: italic; color: #555; position: relative; z-index: 1;}
    .testimonial-author { display: flex; align-items: center; }
    .testimonial-avatar { width: 45px; height: 45px; border-radius: 50%; overflow: hidden; margin-right: 1rem; border: 2px solid #2c7a51; }
    .testimonial-avatar img { width: 100%; height: 100%; object-fit: cover; }
    .testimonial-info h4 { margin: 0; color: #333; font-size: 1rem; }
    .testimonial-info p { margin: 0; color: #666; font-size: 0.85rem; }
    .pagination { display: flex; justify-content: center; flex-wrap: wrap; margin: 3rem 0 2rem 0; }
    .pagination a, .pagination span { display: inline-block; padding: 0.6rem 1.1rem; margin: 0.25rem; border-radius: 5px; background-color: #e9e9e9; color: #555; text-decoration: none; transition: background-color 0.2s, color 0.2s; font-size: 0.9rem; }
    .pagination a.active { background-color: #2c7a51; color: white; }
    .pagination a:hover:not(.active) { background-color: #d1e7dd; }
    .pagination span { background-color: transparent; color: #aaa; } /* Styling untuk '...' */
    .no-guides { text-align: center; padding: 2rem; font-size: 1.1rem; color: #555; grid-column: 1 / -1; }
    @media (max-width: 768px) { .hero h1 { font-size: 2.2rem; } .filter-container { flex-direction: column; align-items: stretch; } .filter-group { align-items: stretch; width: 100%;} .filter-button {width: 100%; margin-top: 1rem;} .section-heading h2 { font-size: 1.8rem; } .testimonials-container { scroll-snap-type: none; } }
    @media (max-width: 480px) { .filter-container { gap: 0.5rem; } .filter-group { margin-bottom: 0.5rem; } }
  </style>
</head>
<body>
  <section class="hero">
    <h1>Tour Guide Pilihan Go-Travel</h1>
    <p>Jelajahi Indonesia dengan pemandu wisata berpengalaman dan berlisensi untuk pengalaman yang lebih bermakna dan tak terlupakan.</p>
  </section>

  <section class="filter-section">
    <form method="GET" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      <div class="filter-container">
        <div class="filter-group">
          <label for="lokasiFilter" class="filter-label">Lokasi:</label>
          <select id="lokasiFilter" name="lokasi" class="filter-select">
            <option value="">Semua Lokasi</option>
            <?php foreach ($lokasi_filters as $lok): ?>
              <option value="<?php echo htmlspecialchars($lok['id_lokasi']); ?>" <?php echo ($selected_location_id == $lok['id_lokasi']) ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($lok['nama_lokasi']); ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="filter-group">
          <label for="bahasaFilter" class="filter-label">Bahasa:</label>
          <select id="bahasaFilter" name="bahasa" class="filter-select">
            <option value="">Semua Bahasa</option>
             <?php foreach ($bahasa_filters as $bhs): ?>
              <option value="<?php echo htmlspecialchars($bhs['id_bahasa']); ?>" <?php echo ($selected_language_id == $bhs['id_bahasa']) ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($bhs['nama_bahasa']); ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="filter-group">
          <label for="ratingFilter" class="filter-label">Rating Minimal:</label>
          <select id="ratingFilter" name="rating" class="filter-select">
            <option value="">Semua Rating</option>
            <option value="5" <?php echo ($selected_rating_val == 5) ? 'selected' : ''; ?>>★★★★★ (5)</option>
            <option value="4" <?php echo ($selected_rating_val == 4) ? 'selected' : ''; ?>>★★★★☆ (4+)</option>
            <option value="3" <?php echo ($selected_rating_val == 3) ? 'selected' : ''; ?>>★★★☆☆ (3+)</option>
            <option value="2" <?php echo ($selected_rating_val == 2) ? 'selected' : ''; ?>>★★☆☆☆ (2+)</option>
            <option value="1" <?php echo ($selected_rating_val == 1) ? 'selected' : ''; ?>>★☆☆☆☆ (1+)</option>
          </select>
        </div>
        <div class="filter-group" style="align-self: flex-end;">
          <button type="submit" class="filter-button"><i class="fas fa-filter"></i> Terapkan</button>
        </div>
      </div>
    </form>
  </section>

  <section class="container">
    <div class="section-heading">
      <h2>Tour Guide Terbaik Kami</h2>
      <p>Temukan pemandu wisata profesional dan berpengalaman untuk menemani perjalanan Anda di berbagai destinasi Indonesia.</p>
    </div>

    <?php if (!empty($guides)): ?>
    <div class="guides-grid">
      <?php foreach ($guides as $guide): ?>
      <?php $guide_languages = getGuideLanguages($conn, $guide['id_pemandu_wisata']); ?>
      <div class="guide-card">
        <div class="guide-image">
          <img src="<?php echo !empty($guide['foto_url']) ? htmlspecialchars($guide['foto_url']) : 'https://via.placeholder.com/300x220.png?text=Foto+Pemandu'; ?>" alt="<?php echo htmlspecialchars($guide['nama_pemandu']); ?>" onerror="this.onerror=null;this.src='https://via.placeholder.com/300x220.png?text=Error+Memuat';">
          <?php if (!empty($guide['rating']) && $guide['rating'] >= 4.8): ?>
            <span class="guide-badge certified-badge">Top Rated</span>
          <?php elseif (!empty($guide['rating']) && $guide['rating'] >= 4.5): ?>
            <span class="guide-badge">Populer</span>
          <?php endif; ?>
        </div>
        <div class="guide-content">
          <h3><?php echo htmlspecialchars($guide['nama_pemandu']); ?></h3>
          <?php if (!empty($guide['nama_lokasi'])): ?>
          <div class="guide-location">
            <i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($guide['nama_lokasi']); ?>
          </div>
          <?php endif; ?>
          <div class="guide-languages">
            <?php if (!empty($guide_languages)): ?>
              <?php foreach ($guide_languages as $lang): ?>
                <span class="language-tag"><?php echo htmlspecialchars($lang); ?></span>
              <?php endforeach; ?>
            <?php else: ?>
                <span class="language-tag">Indonesia</span> <?php endif; ?>
          </div>
          <div class="guide-rating">
            <div class="stars"><?php echo displayStars($guide['rating']); ?></div>
            <div class="count">(<?php echo htmlspecialchars(number_format($guide['rating'] ?? 0.0, 1)); ?>)</div>
             </div>
          <div class="guide-description">
            <?php
              $description = !empty($guide['biodata']) ? $guide['biodata'] : 'Informasi lebih lanjut akan segera tersedia.';
              echo htmlspecialchars(substr($description, 0, 120) . (strlen($description) > 120 ? '...' : ''));
            ?>
          </div>
          <div class="guide-meta">
            <div class="guide-price">
              Rp <?php echo htmlspecialchars(number_format((float)($guide['harga'] ?? 0), 0, ',', '.')); ?> <span>/hari</span>
            </div>
            <a href="tour_guide_detail.php?id_pemandu=<?php echo $guide['id_pemandu_wisata']; ?>" class="guide-button">Profil Lengkap</a>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <?php else: ?>
        <p class="no-guides">Tidak ada pemandu wisata yang sesuai dengan kriteria filter Anda saat ini.</p>
    <?php endif; ?>

    <?php if ($total_pages > 1 && !empty($guides)): ?>
    <div class="pagination">
      <?php
        $query_params = [];
        if (!empty($selected_location_id)) $query_params['lokasi'] = $selected_location_id;
        if (!empty($selected_language_id)) $query_params['bahasa'] = $selected_language_id;
        if ($selected_rating_val > 0) $query_params['rating'] = $selected_rating_val; // Hanya tambah jika ada nilai
        $filter_query_string = http_build_query($query_params);
      ?>
      <?php if ($page > 1): ?>
        <a href="?page=<?php echo $page - 1; ?>&<?php echo $filter_query_string; ?>">&laquo; Prev</a>
      <?php endif; ?>

      <?php
        $max_pages_to_show = 5;
        $start_page = max(1, $page - floor($max_pages_to_show / 2));
        $end_page = min($total_pages, $start_page + $max_pages_to_show - 1);
        if ($end_page - $start_page + 1 < $max_pages_to_show) { // Adjust if it's too short at the beginning
            $start_page = max(1, $end_page - $max_pages_to_show + 1);
        }


        if ($start_page > 1) {
            echo '<a href="?page=1&'.$filter_query_string.'">1</a>';
            if ($start_page > 2) {
                echo '<span>...</span>';
            }
        }

        for ($i = $start_page; $i <= $end_page; $i++):
      ?>
        <a href="?page=<?php echo $i; ?>&<?php echo $filter_query_string; ?>" class="<?php echo ($i == $page) ? 'active' : ''; ?>">
          <?php echo $i; ?>
        </a>
      <?php
        endfor;

        if ($end_page < $total_pages) {
            if ($end_page < $total_pages - 1) {
                echo '<span>...</span>';
            }
            echo '<a href="?page='.$total_pages.'&'.$filter_query_string.'">'.$total_pages.'</a>';
        }
      ?>

      <?php if ($page < $total_pages): ?>
        <a href="?page=<?php echo $page + 1; ?>&<?php echo $filter_query_string; ?>">Next &raquo;</a>
      <?php endif; ?>
    </div>
    <?php endif; ?>
  </section>

  <section class="testimonials-section">
    <div class="container">
      <div class="section-heading">
        <h2>Apa Kata Mereka</h2>
        <p>Pengalaman wisatawan yang telah menggunakan jasa tour guide kami</p>
      </div>
      <div class="testimonials-container">
        <div class="testimonial-card">
          <div class="testimonial-text">"Perjalanan kami di Lamongan menjadi sangat spesial berkat Pak Putu..."</div>
          <div class="testimonial-author">
            <div class="testimonial-avatar"><img src="https://cloud.jpnn.com/photo/sultra/news/normal/2022/03/20/mimpi-buruk-bule-cantik-asal-australia-bronte-gossling-berli-vul8.jpg" alt="Sarah"></div>
            <div class="testimonial-info"><h4>Sarah Johnson</h4><p>Australia, wisata ke Lamongan</p></div>
          </div>
        </div>
        <div class="testimonial-card">
          <div class="testimonial-text">"Bu Ratna sangat membantu selama perjalanan kami di Jakarta..."</div>
          <div class="testimonial-author">
            <div class="testimonial-avatar"><img src="https://awsimages.detik.net.id/community/media/visual/2024/02/05/queen-of-tears-2_169.jpeg?w=500&q=90" alt="David"></div>
            <div class="testimonial-info"><h4>David Kim</h4><p>Korea Selatan, wisata ke Jakarta</p></div>
          </div>
        </div>
         <div class="testimonial-card">
          <div class="testimonial-text">"Wisata budaya Madura di Bangkalan dengan Pak Budi adalah pengalaman terbaik..."</div>
          <div class="testimonial-author">
            <div class="testimonial-avatar"><img src="https://blue.kumparan.com/image/upload/fl_progressive,fl_lossy,c_fill,q_auto:best,w_640/v1545208898/1912_Khamid_aa0g0y.jpg" alt="Emma"></div>
            <div class="testimonial-info"><h4>Emma Wilson</h4><p>Inggris, wisata ke Bangkalan</p></div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php include './Komponen/footer.php'; ?>
</body>
</html>