<?php
include "Komponen/navbar.php";
include "backend/koneksi.php";

// --- Pengaturan Paginasi ---
$item_per_halaman = 6;
$halaman_aktif = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
if ($halaman_aktif < 1) {
    $halaman_aktif = 1;
}

// --- Pengambilan Filter ---
$filter_wilayah_id = isset($_GET['wilayah_id']) && $_GET['wilayah_id'] !== 'all' && is_numeric($_GET['wilayah_id']) ? (int)$_GET['wilayah_id'] : null;
$filter_kategori_id = isset($_GET['kategori_id']) && $_GET['kategori_id'] !== 'all' && is_numeric($_GET['kategori_id']) ? (int)$_GET['kategori_id'] : null;
$filter_jenis_id = isset($_GET['jenis_id']) && $_GET['jenis_id'] !== 'all' && is_numeric($_GET['jenis_id']) ? (int)$_GET['jenis_id'] : null;
$filter_max_harga = isset($_GET['max_harga']) && is_numeric($_GET['max_harga']) && $_GET['max_harga'] > 0 ? (int)$_GET['max_harga'] : null;

// --- Membangun Query String untuk Paginasi ---
$query_string_filters_array = [];
if ($filter_wilayah_id !== null) $query_string_filters_array['wilayah_id'] = $filter_wilayah_id;
if ($filter_kategori_id !== null) $query_string_filters_array['kategori_id'] = $filter_kategori_id;
if ($filter_jenis_id !== null) $query_string_filters_array['jenis_id'] = $filter_jenis_id;
if ($filter_max_harga !== null) $query_string_filters_array['max_harga'] = $filter_max_harga;
$http_query_filters = http_build_query($query_string_filters_array);

// --- Fetch Data untuk Dropdown Filter ---
$wilayah_sql = "SELECT * FROM wilayah ORDER BY nama_wilayah ASC";
$result_wilayah = mysqli_query($conn, $wilayah_sql);
if (!$result_wilayah) { die("Error query wilayah: " . mysqli_error($conn)); }

$jenis_paket_sql = "SELECT * FROM jenis_paket ORDER BY jenis_paket ASC";
$result_jenis_paket = mysqli_query($conn, $jenis_paket_sql);
if (!$result_jenis_paket) { die("Error query jenis paket: " . mysqli_error($conn)); }

$kategori_sql = "SELECT * FROM kategori_wisata ORDER BY nama_kategori ASC";
$result_kategori = mysqli_query($conn, $kategori_sql);
if (!$result_kategori) { die("Error query kategori: " . mysqli_error($conn)); }

// --- Membangun Query Utama dengan Filter ---
$where_conditions = [];
$base_join_for_count = " FROM paket_wisata pw
                        LEFT JOIN wisata w ON pw.id_wisata = w.id_wisata
                        LEFT JOIN kategori_wisata kw ON w.kategori_id = kw.id_kategori
                        LEFT JOIN jenis_paket jp ON pw.id_jenis_paket = jp.id_jenis_paket
                        LEFT JOIN wilayah wy ON pw.id_wilayah = wy.id_wilayah";

if ($filter_wilayah_id !== null) {
    $where_conditions[] = "pw.id_wilayah = " . $filter_wilayah_id;
}
if ($filter_kategori_id !== null) {
    $where_conditions[] = "pw.id_wisata IS NOT NULL AND w.kategori_id = " . $filter_kategori_id;
}
if ($filter_jenis_id !== null) {
    $where_conditions[] = "pw.id_jenis_paket = " . $filter_jenis_id;
}

$price_subquery = "COALESCE(NULLIF((SELECT SUM(tp.harga_komponen) FROM termasuk_paket tp WHERE tp.id_paket = pw.id_paket_wisata), 0), pw.harga)";
if ($filter_max_harga !== null) {
     $where_conditions[] = $price_subquery . " <= " . $filter_max_harga;
}

$where_clause = "";
if (!empty($where_conditions)) {
    $where_clause = " WHERE " . implode(" AND ", $where_conditions);
}

// --- Menghitung Total Paket untuk Paginasi ---
$query_total_paket = "SELECT COUNT(DISTINCT pw.id_paket_wisata) as total " . $base_join_for_count . $where_clause;
$result_total_paket = mysqli_query($conn, $query_total_paket);
if (!$result_total_paket) {
    die("Error counting total packages: " . mysqli_error($conn) . "<br>Query: " . $query_total_paket);
}
$row_total_paket = mysqli_fetch_assoc($result_total_paket);
$total_semua_paket_filtered = $row_total_paket['total'];
$total_halaman = ceil($total_semua_paket_filtered / $item_per_halaman);

if ($total_halaman < 1 && $total_semua_paket_filtered > 0) $total_halaman = 1;
if ($halaman_aktif > $total_halaman && $total_halaman > 0) $halaman_aktif = $total_halaman;
elseif ($total_halaman == 0) $halaman_aktif = 1;

$offset = ($halaman_aktif - 1) * $item_per_halaman;
if ($offset < 0) $offset = 0;

// --- Query Final untuk Mengambil Paket di Halaman Aktif ---
$paket_wisata_sql = "SELECT pw.*, 
                            w.nama_wisata, 
                            w.kategori_id, 
                            kw.nama_kategori,
                            jp.jenis_paket, 
                            wy.nama_wilayah,
                            pw.harga AS harga_paket_default, 
                            COALESCE((SELECT SUM(tp.harga_komponen) 
                                      FROM termasuk_paket tp 
                                      WHERE tp.id_paket = pw.id_paket_wisata), 0) AS total_harga_komponen
                       FROM paket_wisata pw
                       LEFT JOIN wisata w ON pw.id_wisata = w.id_wisata
                       LEFT JOIN kategori_wisata kw ON w.kategori_id = kw.id_kategori
                       LEFT JOIN jenis_paket jp ON pw.id_jenis_paket = jp.id_jenis_paket
                       LEFT JOIN wilayah wy ON pw.id_wilayah = wy.id_wilayah"
                       . $where_clause;

$paket_wisata_sql .= " ORDER BY pw.id_paket_wisata DESC";
$paket_wisata_sql .= " LIMIT $item_per_halaman OFFSET $offset";

$result_paket_wisata = mysqli_query($conn, $paket_wisata_sql);
if (!$result_paket_wisata) {
    die("Error fetching packages: " . mysqli_error($conn) . "<br>Query: " . $paket_wisata_sql);
}
$jumlah_paket_di_halaman_ini = mysqli_num_rows($result_paket_wisata);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Paket Wisata - Jelajahi Pilihan Terbaik</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="stylesheet" href="CSS/paket_wisata.css">
  <style>
      .pagination { display: flex; justify-content: center; align-items: center; margin: 3rem 0; gap: 0.5rem; }
      .pagination a, .pagination span {
        display: inline-flex; align-items: center; justify-content: center; padding: 0.75rem 1rem;
        border-radius: 8px; background-color: #f8f9fa; color: #495057; text-decoration: none;
        transition: all 0.3s ease; border: 1px solid #dee2e6; min-width: 44px; height: 44px;
        font-weight: 500; box-sizing: border-box;
      }
      .pagination a:hover { background-color: #e9ecef; color: #2c7a51; border-color: #2c7a51; transform: translateY(-1px); }
      .pagination .current { background-color: #2c7a51; color: white; border-color: #2c7a51; font-weight: bold; cursor: default; }
      .pagination .disabled { background-color: #f8f9fa; color: #adb5bd; cursor: not-allowed; border-color: #dee2e6; }
      .pagination .disabled:hover { background-color: #f8f9fa; color: #adb5bd; transform: none; }
      .pagination span:not(.disabled) { color: #495057; }
      .results-counter { text-align: center; margin-bottom: 1rem; color: #666; font-size: 0.9rem; }
      .no-results { text-align: center; padding: 3rem 1rem; color: #777; background-color: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-top: 2rem;}
      .no-results i { font-size: 3rem; margin-bottom: 1rem; color: #d0d0d0; }
      .no-results h3 { margin-bottom: 0.5rem; font-size: 1.3rem; color: #555;}
      .ellipsis-placeholder { padding: 0.75rem 0.5rem; color: #495057; }
  </style>
</head>
<body>
  <section class="hero">
    <h1>Temukan Paket Wisata Impian Anda</h1>
    <p>Filter berdasarkan Wilayah, Harga, Jenis Paket, dan Kategori Wisata</p>
  </section>

  <section class="filter-section">
    <form method="GET" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="filterForm">
        <div class="filter-container">
            <div class="filter-group">
                <label for="wilayah_id" class="filter-label">Wilayah:</label>
                <select id="wilayah_id" name="wilayah_id" class="filter-select">
                    <option value="all">Semua Wilayah</option>
                    <?php
                    if ($result_wilayah) {
                        mysqli_data_seek($result_wilayah, 0);
                        while ($row_filter = mysqli_fetch_assoc($result_wilayah)) {
                            echo '<option value="' . htmlspecialchars($row_filter['id_wilayah']) . '" ' . ($filter_wilayah_id == $row_filter['id_wilayah'] ? 'selected' : '') . '>'
                                . htmlspecialchars($row_filter['nama_wilayah'])
                                . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="filter-group">
                <label for="kategori_id" class="filter-label">Kategori Wisata:</label>
                <select id="kategori_id" name="kategori_id" class="filter-select">
                    <option value="all">Semua Kategori</option>
                    <?php
                    if ($result_kategori) {
                        mysqli_data_seek($result_kategori, 0);
                        while ($row_filter = mysqli_fetch_assoc($result_kategori)) {
                            echo '<option value="' . htmlspecialchars($row_filter['id_kategori']) . '" ' . ($filter_kategori_id == $row_filter['id_kategori'] ? 'selected' : '') . '>'
                                . htmlspecialchars($row_filter['nama_kategori'])
                                . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="filter-group">
                <label for="jenis_id" class="filter-label">Jenis Paket:</label>
                <select id="jenis_id" name="jenis_id" class="filter-select">
                    <option value="all">Semua Jenis</option>
                    <?php
                    if ($result_jenis_paket) {
                        mysqli_data_seek($result_jenis_paket, 0);
                        while ($row_filter = mysqli_fetch_assoc($result_jenis_paket)) {
                            echo '<option value="' . htmlspecialchars($row_filter['id_jenis_paket']) . '" ' . ($filter_jenis_id == $row_filter['id_jenis_paket'] ? 'selected' : '') . '>'
                                . htmlspecialchars($row_filter['jenis_paket'])
                                . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="filter-group">
                <label for="max_harga" class="filter-label">Harga Maks (Rp):</label>
                <input type="number" id="max_harga" name="max_harga" class="filter-input" placeholder="Contoh: 1500000" value="<?php echo htmlspecialchars($filter_max_harga ?? ''); ?>" min="0" step="50000">
            </div>
            <div class="filter-group action-group">
                <button type="submit" class="filter-button"><i class="fas fa-filter"></i> Terapkan</button>
                <a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="filter-button reset">Reset Filter</a>
            </div>
        </div>
    </form>
  </section>

  <section class="container package-list-section">
    <div class="section-heading">
      <h2>Paket Wisata Populer</h2>
      <p>Temukan paket wisata terbaik sesuai dengan budget dan preferensi Anda.</p>
    </div>

    <div class="results-counter" id="resultsCounter">
        <?php if ($total_semua_paket_filtered > 0): ?>
            Menampilkan <?php echo $jumlah_paket_di_halaman_ini; ?> dari total <?php echo $total_semua_paket_filtered; ?> paket wisata.
            (Halaman <?php echo $halaman_aktif; ?> dari <?php echo $total_halaman; ?>)
        <?php elseif (!empty($http_query_filters)): ?>
            Tidak ada paket wisata yang cocok dengan kriteria filter Anda.
        <?php else: ?>
            Saat ini belum ada paket wisata yang tersedia.
        <?php endif; ?>
    </div>

    <div id="paketContainer" class="paket-grid">
      <?php
      if ($jumlah_paket_di_halaman_ini > 0) {
          mysqli_data_seek($result_paket_wisata, 0);
          while ($row = mysqli_fetch_assoc($result_paket_wisata)) {
              
              // --- Logika Gambar Baru (Hanya dari gambar_paket) ---
              $image_url = 'https://placehold.co/350x230/e0e0e0/757575?text=Gambar+Paket'; // Gambar default

              // Hanya cari gambar di tabel `gambar_paket`
              $img_paket_query = "SELECT url_gambar FROM gambar_paket WHERE id_paket_wisata = " . (int)$row['id_paket_wisata'] . " ORDER BY is_thumbnail DESC, id_gambar_paket ASC LIMIT 1";
              $img_paket_result = mysqli_query($conn, $img_paket_query);

              if ($img_paket_result && mysqli_num_rows($img_paket_result) > 0) {
                  $img_row = mysqli_fetch_assoc($img_paket_result);
                  // Pastikan path ini sesuai dengan struktur folder Anda
                  $image_url = 'uploads/paket/' . htmlspecialchars($img_row['url_gambar']); 
              }
              // --- Akhir Logika Gambar Baru ---

              $total_komponen = floatval($row['total_harga_komponen']);
              $harga_default_paket = floatval($row['harga_paket_default']);
              $harga_untuk_ditampilkan = ($total_komponen > 0) ? $total_komponen : $harga_default_paket;
      ?>
      <div class="paket-card">
        <div class="card-image">
          <img src="<?php echo $image_url; ?>" alt="<?php echo htmlspecialchars($row['nama_paket']); ?>" onerror="this.onerror=null;this.src='https://placehold.co/350x230/e0e0e0/757575?text=Gagal+Muat';">
          <div class="card-badge <?php echo strtolower(str_replace(' ', '-', htmlspecialchars($row['jenis_paket'] ?? 'Umum'))); ?>">
            <?php echo htmlspecialchars($row['jenis_paket'] ?? 'Umum'); ?>
          </div>
        </div>
        <div class="card-content">
          <h3><?php echo htmlspecialchars($row['nama_paket']); ?></h3>
          <div class="card-location">
            <i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($row['nama_wilayah']); ?>
          </div>
          <div class="card-meta">
            <div class="card-price">Rp <?php echo number_format($harga_untuk_ditampilkan, 0, ',', '.'); ?></div>
            <div class="card-category"><?php echo htmlspecialchars($row['nama_kategori'] ?? 'Umum'); ?></div>
          </div>
          <button class="detail-button" onclick="viewDetail(<?php echo $row['id_paket_wisata']; ?>)">
            <i class="fas fa-eye"></i>
            Lihat Detail
          </button>
        </div>
      </div>
      <?php
          } // end while
      } elseif ($total_semua_paket_filtered == 0 && !empty($http_query_filters)) {
      ?>
        <div class="no-results">
          <i class="fas fa-search-minus"></i>
          <h3>Paket Tidak Ditemukan</h3>
          <p>Maaf, tidak ada paket wisata yang sesuai dengan filter pencarian Anda. Coba ubah kriteria filter.</p>
        </div>
      <?php
      } elseif ($total_semua_paket_filtered == 0) {
      ?>
        <div class="no-results">
          <i class="fas fa-suitcase-rolling"></i>
          <h3>Belum Ada Paket Wisata</h3>
          <p>Kami sedang menyiapkan penawaran terbaik. Silakan cek kembali nanti!</p>
        </div>
      <?php
      }
      ?>
    </div>

    <?php if ($total_halaman > 1): ?>
    <div class="pagination">
        <?php
        $base_url_script = htmlspecialchars($_SERVER["PHP_SELF"]);
        $base_page_url = $base_url_script . '?page=';
        $filter_params_for_pagination = !empty($http_query_filters) ? '&' . $http_query_filters : '';

        if ($halaman_aktif > 1) {
            echo '<a href="' . $base_page_url . ($halaman_aktif - 1) . $filter_params_for_pagination . '" aria-label="Halaman Sebelumnya"><i class="fas fa-chevron-left"></i></a>';
        } else {
            echo '<span class="disabled" aria-hidden="true"><i class="fas fa-chevron-left"></i></span>';
        }

        $link_limit = 2;
        $start_page = max(1, $halaman_aktif - $link_limit);
        $end_page = min($total_halaman, $halaman_aktif + $link_limit);

        if ($start_page > 1) {
            echo '<a href="' . $base_page_url . '1' . $filter_params_for_pagination . '">1</a>';
            if ($start_page > 2) {
                echo '<span class="ellipsis-placeholder">...</span>';
            }
        }

        for ($i = $start_page; $i <= $end_page; $i++) {
            if ($i == $halaman_aktif) {
                echo '<a href="' . $base_page_url . $i . $filter_params_for_pagination . '" class="current" aria-current="page">' . $i . '</a>';
            } else {
                echo '<a href="' . $base_page_url . $i . $filter_params_for_pagination . '">' . $i . '</a>';
            }
        }

        if ($end_page < $total_halaman) {
            if ($end_page < $total_halaman - 1) {
                echo '<span class="ellipsis-placeholder">...</span>';
            }
            echo '<a href="' . $base_page_url . $total_halaman . $filter_params_for_pagination . '">' . $total_halaman . '</a>';
        }

        if ($halaman_aktif < $total_halaman) {
            echo '<a href="' . $base_page_url . ($halaman_aktif + 1) . $filter_params_for_pagination . '" aria-label="Halaman Berikutnya"><i class="fas fa-chevron-right"></i></a>';
        } else {
            echo '<span class="disabled" aria-hidden="true"><i class="fas fa-chevron-right"></i></span>';
        }
        ?>
    </div>
    <?php endif; ?>

  </section>

  <?php include "Komponen/footer.php"; ?>

  <script>
    function viewDetail(paketId) {
      window.location.href = `paket_wisata_detail.php?id=${paketId}`;
    }
  </script>
</body>
</html>
<?php
if (isset($conn) && $conn instanceof mysqli) {
    mysqli_close($conn);
}
?>