<?php
// FILE: detail_paket_wisata.php (Contoh Nama File)

// =================================================================
// BAGIAN 1: LOGIKA PHP (KONEKSI, QUERY, DAN FUNGSI)
// =================================================================

include 'Komponen/navbar.php';
include 'backend/koneksi.php'; // Pastikan $conn terdefinisi dan koneksi berhasil

// Validasi ID Paket dari URL
$id = '';
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
} else {
    // Tampilkan pesan error jika ID tidak valid
    echo "<div style='text-align:center; padding: 50px;'>";
    echo "<h1>Error</h1>";
    echo "<p>ID Paket Wisata tidak valid atau tidak ditemukan.</p>";
    echo "<a href='paket_wisata.php' style='display:inline-block; margin-top:20px; padding:10px 20px; background-color:#2c7a51; color:white; text-decoration:none; border-radius:5px;'>Kembali ke Daftar Paket</a>";
    echo "</div>";
    include 'Komponen/footer.php';
    exit;
}

// Fungsi untuk format Rupiah
function format_rupiah($number) {
    return 'Rp ' . number_format(floatval($number), 0, ',', '.');
}

// Fungsi untuk menampilkan bintang rating
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

// Query utama untuk mengambil semua detail paket wisata
$wisata_detail_sql = "SELECT
    pw.nama_paket, pw.deskripsi, pw.durasi_paket, pw.harga, pw.id_akomodasi_penginapan, pw.id_akomodasi_kuliner, pw.info_penting, pw.id_wisata, pw.id_kendaraan, pw.id_pemandu_wisata, pw.denah_lokasi AS denah_paket,
    wil.id_wilayah, wil.nama_wilayah,
    kend.jenis_kendaraan, kend.gambar AS kendaraan_gambar_url,
    pmd.nama_pemandu, pmd.pengalaman AS pemandu_pengalaman, pmd.foto_url AS pemandu_foto_url, pmd.rating AS pemandu_rating, pmd.harga AS pemandu_harga,
    ap.nama_penginapan, ap.gambar_url AS penginapan_gambar_url, ap.rating_bintang AS penginapan_rating_bintang,
    ak.nama_restaurant, ak.gambar_url AS kuliner_gambar_url,
    w.Alamat AS wisata_alamat, w.telepon AS wisata_telepon, w.nama_wisata AS nama_objek_wisata_utama
FROM
    paket_wisata pw
LEFT JOIN wilayah wil ON pw.id_wilayah = wil.id_wilayah
LEFT JOIN kendaraan kend ON pw.id_kendaraan = kend.id_kendaraan
LEFT JOIN pemandu_wisata pmd ON pw.id_pemandu_wisata = pmd.id_pemandu_wisata
LEFT JOIN akomodasi_penginapan ap ON pw.id_akomodasi_penginapan = ap.id_akomodasi_penginapan
LEFT JOIN akomodasi_kuliner ak ON pw.id_akomodasi_kuliner = ak.id_akomodasi_kuliner
LEFT JOIN wisata w ON pw.id_wisata = w.id_wisata
WHERE
    pw.id_paket_wisata = '$id'";

$wisata_detail_result = mysqli_query($conn, $wisata_detail_sql);

// Handle jika paket tidak ditemukan
if (!$wisata_detail_result || mysqli_num_rows($wisata_detail_result) == 0) {
    echo "<div style='text-align:center; padding: 50px;'><h1>Paket Tidak Ditemukan</h1><p>Detail Paket Wisata dengan ID ".$id." tidak dapat ditemukan.</p><a href='paket_wisata.php' style='display:inline-block; margin-top:20px; padding:10px 20px; background-color:#2c7a51; color:white; text-decoration:none; border-radius:5px;'>Kembali ke Daftar Paket</a></div>";
    include 'Komponen/footer.php';
    exit;
}
$wisataresult = mysqli_fetch_assoc($wisata_detail_result);
$id_paket_wisata = $id;

// Logika untuk mengambil detail penginapan, kuliner, rencana perjalanan, dan rincian biaya
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
        /* ================================================================= */
        /* BAGIAN 2: CSS (DESAIN TAMPILAN)                                   */
        /* ================================================================= */

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        html { height: 100%; }
        body { display: flex; flex-direction: column; min-height: 100vh; background-color: #f5f5f5; }
        main.detail-container { flex-grow: 1; max-width: 1200px; margin-left: auto; margin-right: auto; padding-left: 1rem; padding-right: 1rem; width: 100%; }
        
        .detail-hero {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('<?php
                $hero_image_url = 'https://placehold.co/1200x600/e0e0e0/757575?text=Go+Travel'; // Default fallback image

                // Logika untuk mencari gambar hero
                $img_paket_query = "SELECT url_gambar FROM gambar_paket WHERE id_paket_wisata = " . (int)$id_paket_wisata . " ORDER BY is_thumbnail DESC LIMIT 1";
                $img_paket_result = mysqli_query($conn, $img_paket_query);

                if ($img_paket_result && mysqli_num_rows($img_paket_result) > 0) {
                    $img_row = mysqli_fetch_assoc($img_paket_result);
                    $hero_image_url = 'uploads/paket/' . htmlspecialchars($img_row['url_gambar']);
                } 
                else if (!empty($wisataresult['id_wisata'])) {
                    $id_wisata_utama = (int)$wisataresult['id_wisata'];
                    $img_wisata_query = "SELECT url FROM gambar WHERE wisata_id = " . $id_wisata_utama . " LIMIT 1";
                    $img_wisata_result = mysqli_query($conn, $img_wisata_query);

                    if ($img_wisata_result && mysqli_num_rows($img_wisata_result) > 0) {
                        $img_wisata_row = mysqli_fetch_assoc($img_wisata_result);
                        $hero_image_url = str_replace('../', '', htmlspecialchars($img_wisata_row['url']));
                    }
                }
                echo $hero_image_url;
                ?>') no-repeat center center/cover;
            min-height: 50vh; display: flex; align-items: flex-end; justify-content: center; text-align: center; padding: 2rem 1rem; color: white; margin-bottom: 2rem;
        }
        .detail-hero .detail-container-hero-text { padding: 0; }
        .detail-hero h1 { font-size: clamp(2rem, 5vw, 3rem); margin-bottom: 0.5rem; text-shadow: 2px 2px 4px rgba(0,0,0,0.7); }
        .detail-hero .card-location { font-size: clamp(1rem, 2.5vw, 1.2rem); opacity: 0.9; display: flex; align-items: center; justify-content: center; gap: 0.5rem; }
        
        .detail-main { display: grid; grid-template-columns: 2fr 1fr; gap: 2.5rem; margin-bottom: 4rem; }
        .detail-section { margin-bottom: 2.5rem; background: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08); }
        .detail-section:last-child { margin-bottom: 0; }
        .detail-section p{ line-height: 1.7; color: #555; font-size: 0.95rem; margin-bottom: 1rem; }
        .detail-section h3 { font-size: 1.4rem; color: #2c7a51; margin-bottom: 1.2rem; padding-bottom: 0.6rem; border-bottom: 1px solid #e0e0e0; }
        
        .itinerary-container { margin-top: 1rem; }
        .itinerary-item { display: flex; gap: 1.5rem; margin-bottom: 1rem; padding: 1rem; background: #f9f9f9; border-radius: 6px; border-left: 4px solid #2c7a51; }
        .itinerary-item p { margin: 0; padding-top: 0.2rem; color: #444; font-size: 0.9rem; line-height: 1.6; }
        .itinerary-item h4 { font-size: 1rem; color: #333; margin-bottom: 0.3rem; }
        .itinerary-time { font-weight: 700; min-width: 90px; color: #2c7a51; font-size: 0.9rem; padding-top: 0.1rem; }
        .itinerary-day { background: #2c7a51; color: white; padding: 0.8rem 1rem; border-radius: 6px; text-align: center; font-weight: 700; margin: 1.5rem 0 1rem 0; font-size: 1.1rem; }
        
        .package-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; margin-bottom: 0; }
        .package-card { background: #f9f9f9; padding: 1.2rem; border-radius: 8px; border: 1px solid #e8e8e8; display: flex; flex-direction: column; }
        .package-card h4 { color: #2c7a51; margin-bottom: 0.8rem; font-size: 1.1rem; display: flex; align-items: center; gap: 8px; }
        .package-card img { width: 100%; height: 180px; object-fit: cover; border-radius: 6px; margin-bottom: 0.8rem; }
        .package-card h5 { font-size: 1rem; color: #333; margin-bottom: 0.8rem; display: flex; align-items: center; gap: 8px; }
        .package-features { list-style: none; margin: 0.8rem 0 0 0; padding: 0; font-size: 0.85rem; }
        .package-features li { margin-bottom: 0.4rem; display: flex; align-items: center; color: #555; }
        .package-features li i { color: #2c7a51; margin-right: 8px; width: 16px; text-align: center; }
        
        .detail-info { background: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08); height: fit-content; position: sticky; top: 2rem; }
        .detail-info h2 { font-size: 1.3rem; color: #333; margin-bottom: 0.3rem; }
        .detail-info .detail-meta p { font-size: 0.9rem; color: #555; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem; }
        
        .price-display-container { display: flex; justify-content: space-between; align-items: flex-start; margin: 1.5rem 0; flex-wrap: wrap; }
        .price-display-label { font-size: 1rem; color: #555; font-weight: 600; }
        .price-display-value { text-align: right; }
        .price-display-amount { font-size: 1.8rem; color: #d9534f; font-weight: 700; display: block; }
        .price-display-per-person { font-size:0.8rem; display:block; color:#777; font-weight:normal; }
        
        .pesan-sekarang-link { text-decoration: none; color: white; display: block; }
        .pesan-sekarang { width: 100%; display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem; background-color: #2c7a51; color: white; padding: 0.9rem 1.5rem; border-radius: 6px; text-decoration: none; font-size: 1rem; text-align: center; transition: background-color 0.3s ease; border: none; cursor: pointer; }
        .rating-stars { font-size:0.9em; color: #ffc107; }
        
        @media (max-width: 992px) { .detail-main { grid-template-columns: 1fr; } .detail-info { position: static; margin-top: 2rem; } }

        /* KODE CSS BARU UNTUK INFO PENTING (YANG SUDAH DIPERBAIKI) */
        .info-penting-box {
            background-color: #fffbeb; 
            border-left: 4px solid #f59e0b;
            padding: 1rem 1.2rem;
            margin-top: 1.5rem;
            border-radius: 0 8px 8px 0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            margin-bottom: 1.5rem;
        }
        .info-penting-box h4 {
            font-size: 1.1rem;
            font-weight: 600;
            color: #b45309;
            margin: 0 0 1rem 0;
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }
        .info-penting-box h4 i {
            font-size: 1.2em;
        }
        .info-penting-box ol {
            list-style: none;
            padding-left: 0;
            counter-reset: info-counter;
            margin: 0;
        }
        .info-penting-box ol li {
            counter-increment: info-counter;
            display: flex;
            align-items: flex-start;
            gap: 0.8rem;
            font-size: 0.9rem;
            color: #444;
            line-height: 1.6;
        }
        .info-penting-box ol li + li {
            margin-top: 0.75rem;
        }
        .info-penting-box ol li::before {
            content: counter(info-counter);
            background-color: #f59e0b;
            color: white;
            font-weight: 700;
            font-size: 0.75rem;
            border-radius: 50%;
            min-width: 22px;
            height: 22px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-top: 2px;
        }
    </style>
</head>
<body>

<?php // include 'Komponen/navbar.php'; -> Pindah ke atas ?>

<section class="detail-hero">
    <div class="detail-container-hero-text">
        <h1><?php echo htmlspecialchars($wisataresult['nama_paket']); ?></h1>
        <div class="card-location"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($wisataresult['nama_wilayah']); ?></div>
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
                <h3>Akomodasi, Kuliner & Fasilitas</h3>
                <div class="package-grid">
                    <?php if (!empty($wisataresult['nama_penginapan'])): ?>
                    <div class="package-card">
                        <h4><i class="fas fa-hotel"></i> Penginapan</h4>
                        <img src="<?php echo !empty($wisataresult['penginapan_gambar_url']) ? htmlspecialchars($wisataresult['penginapan_gambar_url']) : 'https://placehold.co/300x200?text=Hotel'; ?>" alt="<?php echo htmlspecialchars($wisataresult['nama_penginapan']); ?>">
                        <h5><?php echo htmlspecialchars($wisataresult['nama_penginapan']); ?>
                            <?php if (!empty($wisataresult['penginapan_rating_bintang'])) echo '<span class="rating-stars">' . display_stars($wisataresult['penginapan_rating_bintang'], false) . '</span>'; ?>
                        </h5>
                        <?php if (!empty($penginapan_detail_list)): ?>
                        <ul class="package-features">
                            <?php foreach ($penginapan_detail_list as $item_pd): ?><li><i class="fas fa-check"></i> <?php echo htmlspecialchars($item_pd['termasuk']); ?></li><?php endforeach; ?>
                        </ul>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>

                    <?php if (!empty($wisataresult['nama_restaurant'])): ?>
                    <div class="package-card">
                        <h4><i class="fas fa-utensils"></i> Kuliner Unggulan</h4>
                        <img src="<?php echo !empty($wisataresult['kuliner_gambar_url']) ? htmlspecialchars($wisataresult['kuliner_gambar_url']) : 'https://placehold.co/300x200?text=Restoran'; ?>" alt="<?php echo htmlspecialchars($wisataresult['nama_restaurant']); ?>">
                        <h5><?php echo htmlspecialchars($wisataresult['nama_restaurant']); ?></h5>
                        <?php if (!empty($kuliner_detail_list)): ?>
                        <ul class="package-features">
                            <?php foreach ($kuliner_detail_list as $item_kd): ?><li><i class="fas fa-check"></i> <?php echo htmlspecialchars($item_kd['termasuk']); ?></li><?php endforeach; ?>
                        </ul>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($wisataresult['jenis_kendaraan'])): ?>
                    <div class="package-card">
                        <h4><i class="fas fa-car"></i> Transportasi</h4>
                        <img src="<?php echo htmlspecialchars($wisataresult['kendaraan_gambar_url']); ?>" alt="<?php echo htmlspecialchars($wisataresult['jenis_kendaraan']); ?>">
                        <h5><?php echo htmlspecialchars($wisataresult['jenis_kendaraan']); ?></h5>
                        <ul class="package-features">
                            <li><i class="fas fa-check"></i> Driver Berpengalaman</li>
                            <li><i class="fas fa-check"></i> Kondisi AC Dingin</li>
                            <li><i class="fas fa-check"></i> Termasuk BBM & Parkir</li>
                        </ul>
                    </div>
                    <?php endif; ?>

                    <?php if (!empty($wisataresult['nama_pemandu'])): ?>
                    <div class="package-card">
                        <h4><i class="fas fa-user-tie"></i> Pemandu Wisata</h4>
                        <img src="<?php echo !empty($wisataresult['pemandu_foto_url']) ? htmlspecialchars($wisataresult['pemandu_foto_url']) : 'https://placehold.co/300x200?text=Pemandu'; ?>" alt="<?php echo htmlspecialchars($wisataresult['nama_pemandu']); ?>">
                        <h5><?php echo htmlspecialchars($wisataresult['nama_pemandu']); ?></h5>
                        <ul class="package-features">
                            <li><i class="fas fa-star"></i> Rating: <?php echo number_format($wisataresult['pemandu_rating'] ?? 0, 1); ?> / 5.0</li>
                            <li><i class="fas fa-briefcase"></i> Pengalaman: <?php echo htmlspecialchars($wisataresult['pemandu_pengalaman'] ?? 'N/A'); ?></li>
                        </ul>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

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
            
            <h4 class="sidebar-subtitle" style="margin-bottom:8px">Rincian Fasilitas & Biaya:</h4>
            <?php if (!empty($termasuk_paket_list)): ?>
            <ul style="margin:0; padding:0; list-style: none; font-size: 0.9rem;">
                <?php foreach($termasuk_paket_list as $item_tp): ?>
                <li class="itemized-list-item" style="display: flex; justify-content: space-between; margin-bottom:8px;">
                    <span class="description" style="display: inline-flex; align-items: center; gap: 8px;"><i class="fas fa-check" style="color: #2c7a51;"></i> <?php echo htmlspecialchars($item_tp['termasuk']); ?></span>
                    <?php if (isset($item_tp['harga_komponen']) && floatval($item_tp['harga_komponen']) > 0): ?>
                    <span class="price-itemized"><?php echo format_rupiah($item_tp['harga_komponen']); ?></span>
                    <?php else: ?>
                    <span class="price-itemized" style="color:#777;">Termasuk</span>
                    <?php endif; ?>
                </li>
                <?php endforeach; ?>
                <?php if ($subtotal_rincian_komponen > 0) : ?>
                <li class="itemized-list-item" style="display: flex; justify-content: space-between; margin-top: 0.8rem; padding-top: 0.8rem; border-top: 1px dashed #ddd; font-weight:bold;">
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
            
            <?php if (!empty($wisataresult['info_penting'])): ?>
<div class="info-penting-box">
    <h4><i class="fas fa-exclamation-triangle"></i> Info Penting</h4>
    <ol>
        <?php
            // 1. Pecah string dari database berdasarkan baris baru (newline).
            //    preg_split lebih andal daripada explode("\n", ...) karena bisa menangani berbagai jenis line break (\n atau \r\n).
            $info_items = preg_split('/\r\n?|\n/', $wisataresult['info_penting']);
            
            foreach ($info_items as $item):
                // 2. Hapus nomor manual di awal baris (seperti "1. ", "2. ", dst.) agar tidak terjadi penomoran ganda.
                //    Regex ini akan menghapus angka, titik, dan spasi di awal setiap baris.
                $cleaned_item = preg_replace('/^\d+\.\s*/', '', $item);

                // 3. Bersihkan spasi ekstra di awal dan akhir.
                $trimmed_item = trim($cleaned_item);
                
                // 4. Hanya tampilkan jika baris tidak kosong setelah dibersihkan.
                if (!empty($trimmed_item)):
        ?>
        <li>
            <?php echo htmlspecialchars($trimmed_item); ?>
        </li>
        <?php 
                endif;
            endforeach; 
        ?>
    </ol>
</div>
<?php else: ?>
<div class="info-penting-box" style="background-color: #f0fdf4; border-left-color: #4ade80;">
    <p style="margin:0; font-size: 0.9rem; color: #555;">
        <i class="fas fa-check-circle" style="color:#4ade80; margin-right: 8px;"></i>
        Tidak ada info penting tambahan untuk paket ini.
    </p>
</div>
<?php endif; ?>
            <a href="pemesanan.php?id_paket=<?php echo htmlspecialchars($id_paket_wisata); ?>" class="pesan-sekarang-link">
                <button class="pesan-sekarang">
                    <i class="fas fa-shopping-cart"></i> Pesan Paket Sekarang
                </button>
            </a>
        </div>
    </div>
</main>

<?php 
// =================================================================
// BAGIAN 4: FOOTER DAN PENUTUP KONEKSI
// =================================================================
include 'Komponen/footer.php'; 

// Tutup koneksi database jika ada
if (isset($conn) && $conn instanceof mysqli) {
    mysqli_close($conn);
}
?>
</body>
</html>