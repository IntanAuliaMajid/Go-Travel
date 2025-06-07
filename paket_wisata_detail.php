<?php
include 'Komponen/navbar.php';
include 'backend/koneksi.php'; // Pastikan $conn terdefinisi di sini

$id = '';
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
} else {
    echo "<div style='text-align:center; padding: 50px;'>";
    echo "<h1>Error</h1>";
    echo "<p>ID Paket Wisata tidak valid atau tidak ditemukan.</p>";
    echo "<a href='paket_wisata.php' style='display:inline-block; margin-top:20px; padding:10px 20px; background-color:#2c7a51; color:white; text-decoration:none; border-radius:5px;'>Kembali ke Daftar Paket</a>";
    echo "</div>";
    include 'Komponen/footer.php';
    exit;
}

function format_rupiah($number) {
    return 'Rp ' . number_format(floatval($number), 0, ',', '.');
}

function display_stars($rating_value, $is_decimal_rating = true) {
    $output = '';
    if ($is_decimal_rating) {
        $rating = floatval($rating_value);
        $fullStars = floor($rating);
        $halfStar = ($rating - $fullStars) >= 0.4;
        $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);

        for ($i = 0; $i < $fullStars; $i++) { $output .= '<i class="fas fa-star"></i>'; }
        if ($halfStar) { $output .= '<i class="fas fa-star-half-alt"></i>'; }
        for ($i = 0; $i < $emptyStars; $i++) { $output .= '<i class="far fa-star"></i>'; }
    } else {
        $bintang = intval($rating_value);
        for ($i = 0; $i < $bintang; $i++) { $output .= '<i class="fas fa-star"></i>'; }
        for ($i = $bintang; $i < 5; $i++) { $output .= '<i class="far fa-star"></i>';}
    }
    return $output;
}

// --- MODIFIKASI 1: Ubah Query SQL ---
// Tambahkan pw.denah_lokasi AS denah_paket
$wisata_detail_sql = "SELECT
    pw.nama_paket,
    pw.deskripsi,
    pw.durasi_paket,
    pw.harga,
    pw.id_akomodasi_penginapan,
    pw.id_akomodasi_kuliner,
    pw.info_penting,
    pw.id_wisata,
    pw.id_kendaraan,
    pw.id_pemandu_wisata,
    pw.denah_lokasi AS denah_paket, -- INI TAMBAHAN PENTING
    wil.id_wilayah,
    wil.nama_wilayah,
    kend.jenis_kendaraan,
    kend.gambar AS kendaraan_gambar_url,
    pmd.nama_pemandu,
    pmd.pengalaman AS pemandu_pengalaman,
    pmd.foto_url AS pemandu_foto_url,
    pmd.rating AS pemandu_rating,
    pmd.harga AS pemandu_harga,
    ap.nama_penginapan,
    ap.gambar_url AS penginapan_gambar_url,
    ap.rating_bintang AS penginapan_rating_bintang,
    ak.nama_restaurant,
    ak.gambar_url AS kuliner_gambar_url,
    w.Alamat AS wisata_alamat,
    w.telepon AS wisata_telepon,
    w.nama_wisata AS nama_objek_wisata_utama
FROM
    paket_wisata pw
LEFT JOIN
    wilayah wil ON pw.id_wilayah = wil.id_wilayah
LEFT JOIN
    kendaraan kend ON pw.id_kendaraan = kend.id_kendaraan
LEFT JOIN
    pemandu_wisata pmd ON pw.id_pemandu_wisata = pmd.id_pemandu_wisata
LEFT JOIN
    akomodasi_penginapan ap ON pw.id_akomodasi_penginapan = ap.id_akomodasi_penginapan
LEFT JOIN
    akomodasi_kuliner ak ON pw.id_akomodasi_kuliner = ak.id_akomodasi_kuliner
LEFT JOIN
    wisata w ON pw.id_wisata = w.id_wisata
WHERE
    pw.id_paket_wisata = '$id'";

$wisata_detail_result = mysqli_query($conn, $wisata_detail_sql);

if (!$wisata_detail_result || mysqli_num_rows($wisata_detail_result) == 0) {
    echo "<div style='text-align:center; padding: 50px;'><h1>Paket Tidak Ditemukan</h1><p>Detail Paket Wisata dengan ID ".$id." tidak dapat ditemukan.</p><a href='paket_wisata.php' style='display:inline-block; margin-top:20px; padding:10px 20px; background-color:#2c7a51; color:white; text-decoration:none; border-radius:5px;'>Kembali ke Daftar Paket</a></div>";
    include 'Komponen/footer.php';
    exit;
}
$wisataresult = mysqli_fetch_assoc($wisata_detail_result);
$id_paket_wisata = $id;

$penginapan_detail_list = [];
if (!empty($wisataresult['id_akomodasi_penginapan'])) {
    $id_penginapan_fk = (int)$wisataresult['id_akomodasi_penginapan'];
    $penginapan_detail_sql = "SELECT termasuk FROM akomodasi_penginapan_detail WHERE id_akomodasi = '$id_penginapan_fk'";
    $penginapan_detail_query_result = mysqli_query($conn, $penginapan_detail_sql);
    if ($penginapan_detail_query_result) { while ($row_pd = mysqli_fetch_assoc($penginapan_detail_query_result)) { $penginapan_detail_list[] = $row_pd; } }
}

$kuliner_detail_list = [];
if (!empty($wisataresult['id_akomodasi_kuliner'])) {
    $id_kuliner_fk = (int)$wisataresult['id_akomodasi_kuliner'];
    $kuliner_detail_sql = "SELECT termasuk FROM akomodasi_kuliner_detail WHERE id_akomodasi_kuliner = '$id_kuliner_fk'";
    $kuliner_detail_query_result = mysqli_query($conn, $kuliner_detail_sql);
    if ($kuliner_detail_query_result) { while ($row_kd = mysqli_fetch_assoc($kuliner_detail_query_result)) { $kuliner_detail_list[] = $row_kd; } }
}

$rencana_perjalanan_list = [];
$rencana_perjalanan_sql = "SELECT hari, perjalanan, jam, deskripsi_perjalanan FROM rencana_perjalanan WHERE id_paket = '$id_paket_wisata' ORDER BY hari ASC, STR_TO_DATE(jam, '%H:%i') ASC";
$rencana_perjalanan_query_result = mysqli_query($conn, $rencana_perjalanan_sql);
if ($rencana_perjalanan_query_result) { while ($row_rp = mysqli_fetch_assoc($rencana_perjalanan_query_result)) { $rencana_perjalanan_list[] = $row_rp; } }

$termasuk_paket_list = [];
$subtotal_rincian_komponen = 0;
$termasuk_paket_sql = "SELECT termasuk, harga_komponen FROM termasuk_paket WHERE id_paket = '$id_paket_wisata' ORDER BY id_termasuk_paket ASC";
$termasuk_paket_query_result = mysqli_query($conn, $termasuk_paket_sql);
if ($termasuk_paket_query_result) {
    while ($row_tp = mysqli_fetch_assoc($termasuk_paket_query_result)) {
        $termasuk_paket_list[] = $row_tp;
        if (isset($row_tp['harga_komponen']) && is_numeric($row_tp['harga_komponen'])) {
            $subtotal_rincian_komponen += floatval($row_tp['harga_komponen']);
        }
    }
}

$harga_default_dari_paket = floatval($wisataresult['harga']);
$harga_final_untuk_sidebar = ($subtotal_rincian_komponen > 0) ? $subtotal_rincian_komponen : $harga_default_dari_paket;

?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?php echo htmlspecialchars($wisataresult['nama_paket']); ?> - Detail Paket Wisata</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
    /* ... (SEMUA CSS ANDA SAMA SEPERTI SEBELUMNYA) ... */
     * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
    html { height: 100%; }
    body { display: flex; flex-direction: column; min-height: 100vh; background-color: #f5f5f5; }
    main.detail-container { flex-grow: 1; max-width: 1200px; margin-left: auto; margin-right: auto; padding-left: 1rem; padding-right: 1rem; width: 100%; }
    .detail-hero { background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('<?php
                                    $hero_image_url = 'https://placehold.co/1200x600/e0e0e0/757575?text=Go+Travel'; // Default
                                    $img_paket_query_hero = "SELECT url_gambar FROM gambar_paket WHERE id_paket_wisata = " . (int)$id_paket_wisata . " ORDER BY is_thumbnail DESC, id_gambar_paket ASC LIMIT 1";
                                    $img_paket_result_hero = mysqli_query($conn, $img_paket_query_hero);
                                    if ($img_paket_result_hero && mysqli_num_rows($img_paket_result_hero) > 0) {
                                        $img_row_hero = mysqli_fetch_assoc($img_paket_result_hero);
                                        $hero_image_url = 'uploads/paket/' . htmlspecialchars($img_row_hero['url_gambar']);
                                    }
                                    echo $hero_image_url;
                                  ?>') no-repeat center center/cover;
      min-height: 50vh; display: flex; align-items: flex-end; justify-content: center; text-align: center; padding: 2rem 1rem; color: white; margin-bottom: 2rem; }
    .detail-hero .detail-container-hero-text { padding: 0; }
    .detail-hero h1 { font-size: clamp(2rem, 5vw, 3rem); margin-bottom: 0.5rem; text-shadow: 2px 2px 4px rgba(0,0,0,0.7); }
    .detail-hero .card-location { font-size: clamp(1rem, 2.5vw, 1.2rem); opacity: 0.9; display: flex; align-items: center; justify-content: center; gap: 0.5rem; }
    .detail-main { display: grid; grid-template-columns: 2fr 1fr; gap: 2.5rem; margin-bottom: 4rem; }
    .detail-section { margin-bottom: 2.5rem; background: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08); }
    .detail-section:last-child { margin-bottom: 0; }
    .detail-section p{ line-height: 1.7; color: #555; font-size: 0.95rem; margin-bottom: 1rem; }
    .detail-section p:last-child { margin-bottom: 0; }
    .detail-section h3 { font-size: 1.4rem; color: #2c7a51; margin-bottom: 1.2rem; padding-bottom: 0.6rem; border-bottom: 1px solid #e0e0e0; }
    .itinerary-container { margin-top: 1rem; }
    .itinerary-item { display: flex; gap: 1.5rem; margin-bottom: 1rem; padding: 1rem; background: #f9f9f9; border-radius: 6px; border-left: 4px solid #2c7a51; }
    .itinerary-item p { margin: 0; padding-top: 0.2rem; color: #444; font-size: 0.9rem; line-height: 1.6; }
    .itinerary-item h4 { font-size: 1rem; color: #333; margin-bottom: 0.3rem; }
    .itinerary-time { font-weight: 700; min-width: 90px; color: #2c7a51; font-size: 0.9rem; padding-top: 0.1rem; }
    .itinerary-day { background: #2c7a51; color: white; padding: 0.8rem 1rem; border-radius: 6px; text-align: center; font-weight: 700; margin: 1.5rem 0 1rem 0; font-size: 1.1rem; }
    .package-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; margin-bottom: 0; }
    .package-card { background: #f9f9f9; padding: 1.2rem; border-radius: 8px; border: 1px solid #e8e8e8; display: flex; flex-direction: column; }
    .package-card h4 { color: #2c7a51; margin-bottom: 0.8rem; font-size: 1.1rem; }
    .package-card img { width: 100%; height: 180px; object-fit: cover; border-radius: 6px; margin-bottom: 0.8rem; }
    .package-card h5 { font-size: 1rem; color: #333; margin-bottom: 0.8rem; display: flex; align-items: center; gap: 0.5rem; }
    .package-features { list-style: none; margin: 0.8rem 0 0 0; padding: 0; font-size: 0.85rem; }
    .package-features li { margin-bottom: 0.4rem; display: flex; align-items: center; color: #555; }
    .package-features li i { color: #2c7a51; margin-right: 8px; width: 16px; text-align: center; }
    .detail-info { background: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08); height: fit-content; position: sticky; top: 2rem; }
    .detail-info h2 { font-size: 1.3rem; color: #333; margin-bottom: 0.3rem; }
    .detail-info .detail-meta p { font-size: 0.9rem; color: #555; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem; }
    .detail-info .detail-meta p i { color: #2c7a51; }
    .sidebar-subtitle { margin-top:1.5rem; margin-bottom:0.8rem; color:#2c7a51; font-size:1.1rem; font-weight: 600; padding-bottom:0.5rem; border-bottom:1px solid #eee; }
    .price-display-container { display: flex; justify-content: space-between; align-items: flex-start; margin: 1.5rem 0; flex-wrap: wrap; }
    .price-display-label { font-size: 1rem; color: #555; font-weight: 600; margin-right: 10px; line-height: 1.8rem; }
    .price-display-value { text-align: right; }
    .price-display-amount { font-size: 1.8rem; color: #d9534f; font-weight: 700; display: block; }
    .price-display-per-person { font-size:0.8rem; display:block; color:#777; font-weight:normal; }
    .pesan-sekarang-link { text-decoration: none; color: white; display: block; margin-top: 2rem; }
    .pesan-sekarang { width: 100%; display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem; background-color: #2c7a51; color: white; padding: 0.9rem 1.5rem; border-radius: 6px; text-decoration: none; font-size: 1rem; text-align: center; transition: background-color 0.3s ease, transform 0.2s ease; border: none; cursor: pointer; }
    .pesan-sekarang:hover { background-color: #1e5a3a; transform: translateY(-2px); }
    .info-penting-list { margin:0; padding:0; list-style: none; font-size: 0.9rem; }
    .info-penting-list li { display:flex; align-items:flex-start; gap:10px; margin-bottom: 0.5rem; }
    .info-penting-list li:last-child { margin-bottom: 0; }
    .info-penting-list li .fas.fa-info-circle { color: #2c7a51; margin-top:3px; }
    .info-penting-list li span { color: #555; }
    .map-container { border-radius: 8px; overflow: hidden; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08); margin-top: 1rem; background-color: #e9e9e9; min-height: 350px; display: flex; align-items: center; justify-content: center; }
    .map-container img { width: 100%; height: auto; display: block; }
    .map-container iframe { width: 100%; height: 350px; border: 0; }
    .location-details { margin-top: 1rem; padding: 1rem; background: #f9f9f9; border-radius: 6px; font-size: 0.9rem; }
    .location-item { display: flex; align-items: flex-start; margin-bottom: 0.7rem; color: #555; }
    .location-item i { color: #2c7a51; margin-right: 10px; width: 20px; text-align: center; margin-top: 3px; }
    .location-item strong { color: #333; margin-right: 5px; }
    .transport-guide { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; margin-top: 1.5rem; }
    .transport-card, .guide-card { background: #f9f9f9; padding: 1.2rem; border-radius: 8px; border: 1px solid #e8e8e8; }
    .transport-card h4, .guide-card h4 { color: #2c7a51; margin-bottom: 0.8rem; font-size: 1.1rem; display: flex; align-items: center; }
    .transport-card h4 i, .guide-card h4 i { margin-right: 8px; }
    .rating-stars { font-size:0.9em; color: #ffc107; }
    .rating-stars .fa-star-half-alt { color: #ffc107; }
    .rating-stars .far.fa-star { color: #e0e0e0; }
    @media (max-width: 992px) { .detail-main { grid-template-columns: 1fr; } .detail-info { position: static; margin-top: 2rem; } }
    @media (max-width: 768px) { .detail-hero { min-height: 40vh; padding: 1.5rem; } .detail-main { gap: 2rem; } .detail-info { order: -1; margin-bottom: 2rem; } .package-grid { grid-template-columns: 1fr; } .detail-section, .detail-info, .package-card, .transport-card, .guide-card { padding: 1.2rem; } }
    .price-itemized { font-weight: 500; margin-left: auto; padding-left: 10px; }
    .itemized-list-item { display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem; font-size: 0.85rem; }
    .itemized-list-item .description { display: flex; align-items: center; flex-grow: 1; margin-right: 10px; color: #444; }
    .itemized-list-item .description .fa-check { color: #2c7a51; margin-right: 8px; font-size: 0.9em; }
    .itemized-list-item .price-itemized { color: #333; white-space: nowrap; }
    .itemized-list-item .price-itemized[style*="color:#777"] { font-style: italic; }
  </style>
</head>
<body>
  <?php include 'Komponen/navbar.php'; ?>

  <section class="detail-hero">
    <div class="detail-container-hero-text"> <h1><?php echo htmlspecialchars($wisataresult['nama_paket']); ?></h1>
      <div class="card-location">
        <i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($wisataresult['nama_wilayah']); ?>
      </div>
    </div>
  </section>

  <main class="detail-container">
    <div class="detail-main">
      <div> 
        <div class="detail-section">
          <h3>Deskripsi Paket Wisata</h3>
          <p><?= nl2br(htmlspecialchars($wisataresult['deskripsi'] ?? 'Deskripsi paket wisata ini akan segera tersedia.')) ?></p>
        </div>

        <div class="detail-section">
            <h3>Peta Lokasi & Info Paket</h3>
             <div class="map-container">
                <?php
                // Menggunakan kolom 'denah_paket' yang baru kita tambahkan di query
                $denah_data = $wisataresult['denah_paket'] ?? '';

                if (!empty($denah_data)) {
                    // Cek apakah data tersebut adalah kode iframe
                    if (strpos($denah_data, '<iframe') !== false) {
                        echo $denah_data; // Tampilkan iframe langsung
                    } 
                    // Jika bukan iframe, anggap sebagai nama file gambar denah
                    else {
                        // Pastikan path ini sesuai dengan struktur folder Anda
                        $denah_image_url = 'uploads/denah/' . htmlspecialchars($denah_data);
                        echo '<img src="' . $denah_image_url . '" alt="Denah Lokasi ' . htmlspecialchars($wisataresult['nama_paket']) . '" onerror="this.parentElement.innerHTML=\'<p style=text-align:center;color:#777;>Denah lokasi tidak dapat dimuat.</p>\';">';
                    }
                } else {
                    echo '<p style="text-align:center; color:#777;">Denah lokasi atau peta untuk paket ini tidak tersedia.</p>';
                }
                ?>
            </div>
             <?php if (!empty($wisataresult['nama_objek_wisata_utama'])): ?>
            <div class="location-details">
              <div class="location-item">
                <i class="fas fa-monument"></i>
                <div><strong>Wisata Utama:</strong> <span><?php echo htmlspecialchars($wisataresult['nama_objek_wisata_utama']); ?></span></div>
              </div>
              <div class="location-item">
                <i class="fas fa-map-marked-alt"></i>
                <div><strong>Alamat Wisata:</strong> <span><?php echo !empty($wisataresult['wisata_alamat']) ? htmlspecialchars($wisataresult['wisata_alamat']) : 'N/A'; ?></span></div>
              </div>
              <div class="location-item">
                <i class="fas fa-phone-alt"></i>
                <div><strong>Telepon Wisata:</strong> <span><?php echo !empty($wisataresult['wisata_telepon']) ? htmlspecialchars($wisataresult['wisata_telepon']) : 'N/A'; ?></span></div>
              </div>
            </div>
            <?php endif; ?>
        </div>

        <?php if (!empty($wisataresult['nama_penginapan']) || !empty($wisataresult['nama_restaurant'])): ?>
        <div class="detail-section">
          <h3>Akomodasi & Kuliner</h3>
          <div class="package-grid">
            <?php if (!empty($wisataresult['nama_penginapan'])): ?>
            <div class="package-card">
              <h4><i class="fas fa-hotel"></i> Penginapan</h4>
              <img src="<?php echo !empty($wisataresult['penginapan_gambar_url']) ? htmlspecialchars($wisataresult['penginapan_gambar_url']) : 'https://via.placeholder.com/300x200?text=Hotel'; ?>" alt="<?php echo htmlspecialchars($wisataresult['nama_penginapan']); ?>">
              <h5><?php echo htmlspecialchars($wisataresult['nama_penginapan']); ?>
                <?php if (!empty($wisataresult['penginapan_rating_bintang'])) echo '<span class="rating-stars">' . display_stars($wisataresult['penginapan_rating_bintang'], false) . '</span>'; ?>
              </h5>
              <?php if (!empty($penginapan_detail_list)): ?>
              <ul class="package-features">
                <?php foreach ($penginapan_detail_list as $item_pd): ?>
                  <li><i class="fas fa-check"></i> <?php echo htmlspecialchars($item_pd['termasuk']); ?></li>
                <?php endforeach; ?>
              </ul>
              <?php endif; ?>
            </div>
            <?php endif; ?>

            <?php if (!empty($wisataresult['nama_restaurant'])): ?>
            <div class="package-card">
              <h4><i class="fas fa-utensils"></i> Kuliner Unggulan</h4>
              <img src="<?php echo !empty($wisataresult['kuliner_gambar_url']) ? htmlspecialchars($wisataresult['kuliner_gambar_url']) : 'https://via.placeholder.com/300x200?text=Restoran'; ?>" alt="<?php echo htmlspecialchars($wisataresult['nama_restaurant']); ?>">
              <h5><?php echo htmlspecialchars($wisataresult['nama_restaurant']); ?></h5>
              <?php if (!empty($kuliner_detail_list)): ?>
              <ul class="package-features">
                  <?php foreach ($kuliner_detail_list as $item_kd): ?>
                  <li><i class="fas fa-check"></i> <?php echo htmlspecialchars($item_kd['termasuk']); ?></li>
                <?php endforeach; ?>
              </ul>
              <?php endif; ?>
            </div>
            <?php endif; ?>
          </div>
        </div>
        <?php endif; ?>

        <?php if (!empty($rencana_perjalanan_list)): ?>
        <div class="detail-section">
          <h3>Rencana Perjalanan</h3>
          <div class="itinerary-container">
              <?php
              $current_day = null;
              foreach ($rencana_perjalanan_list as $item_rp):
                if ($item_rp['hari'] !== $current_day) {
                  echo '<div class="itinerary-day">HARI ' . htmlspecialchars($item_rp['hari']) . '</div>';
                  $current_day = $item_rp['hari'];
                }
              ?>
              <div class="itinerary-item">
                <div class="itinerary-time"><?php echo htmlspecialchars($item_rp['jam']); ?></div>
                <div class="itinerary-content">
                  <h4><?php echo htmlspecialchars($item_rp['perjalanan']); ?></h4>
                  <p><?php echo nl2br(htmlspecialchars($item_rp['deskripsi_perjalanan'])); ?></p>
                </div>
              </div>
              <?php endforeach; ?>
          </div>
        </div>
        <?php endif; ?>

      </div>

      <div class="detail-info">
        <div class="detail-meta">
          <h2><?php echo htmlspecialchars($wisataresult['nama_paket']); ?></h2>
          <p><i class="fas fa-clock"></i> Durasi: <?php echo htmlspecialchars($wisataresult['durasi_paket']); ?></p>
        </div>

        <h4 class="sidebar-subtitle">Rincian Fasilitas & Biaya:</h4>
        <?php if (!empty($termasuk_paket_list)): ?>
        <ul style="margin:0; padding:0; list-style: none; font-size: 0.9rem;">
          <?php foreach($termasuk_paket_list as $item_tp): ?>
          <li class="itemized-list-item">
            <span class="description"><i class="fas fa-check"></i> <?php echo htmlspecialchars($item_tp['termasuk']); ?></span>
            <?php if (isset($item_tp['harga_komponen']) && floatval($item_tp['harga_komponen']) > 0): ?>
              <span class="price-itemized"><?php echo format_rupiah($item_tp['harga_komponen']); ?></span>
            <?php else: ?>
              <span class="price-itemized" style="color:#777;">Termasuk</span>
            <?php endif; ?>
          </li>
          <?php endforeach; ?>
            <?php if ($subtotal_rincian_komponen > 0) : ?>
            <li class="itemized-list-item" style="margin-top: 0.8rem; padding-top: 0.8rem; border-top: 1px dashed #ddd; font-weight:bold;">
                <span class="description" style="color:#333;">Estimasi Subtotal</span>
                <span class="price-itemized" style="color:#333;"><?php echo format_rupiah($subtotal_rincian_komponen); ?></span>
            </li>
            <?php endif; ?>
        </ul>
        <?php else: ?>
        <p style="font-size: 0.9rem; color:#777;">Informasi rincian fasilitas tidak tersedia.</p>
        <?php endif; ?>

        <div class="price-display-container">
            <span class="price-display-label">Harga Paket Mulai:</span>
            <div class="price-display-value">
                <span class="price-display-amount"><?php echo format_rupiah($harga_final_untuk_sidebar); ?></span>
                <span class="price-display-per-person">per orang</span>
            </div>
        </div>

        <h4 class="sidebar-subtitle">Info Penting:</h4>
        <ul class="info-penting-list">
          <?php if (!empty($wisataresult['info_penting'])): ?>
            <li><i class="fas fa-info-circle"></i> <span><?php echo nl2br(htmlspecialchars($wisataresult['info_penting'])); ?></span></li>
          <?php else: ?>
            <li><i class="fas fa-info-circle"></i> <span>Tidak ada info penting tambahan untuk paket ini.</span></li>
          <?php endif; ?>
        </ul>

        <a href="pemesanan.php?id_paket=<?php echo htmlspecialchars($id_paket_wisata); ?>" class="pesan-sekarang-link">
          <button class="pesan-sekarang">
            <i class="fas fa-shopping-cart"></i> Pesan Paket Sekarang
          </button>
        </a>
      </div>
    </div>
  </main>

  <?php include 'Komponen/footer.php'; ?>
</body>
</html>
<?php
if (isset($conn) && $conn instanceof mysqli) {
    mysqli_close($conn);
}
?>