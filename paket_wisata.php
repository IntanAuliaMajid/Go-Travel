<?php
include "Komponen/navbar.php";
include "backend/koneksi.php"; 

// --- Pengaturan Paginasi ---
$item_per_halaman = 6;
$halaman_aktif = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
if ($halaman_aktif < 1) {
    $halaman_aktif = 1;
}
$offset = ($halaman_aktif - 1) * $item_per_halaman;

$filter_wilayah_id = isset($_GET['wilayah_id']) && $_GET['wilayah_id'] !== 'all' && is_numeric($_GET['wilayah_id']) ? (int)$_GET['wilayah_id'] : null;
$filter_kategori_id = isset($_GET['kategori_id']) && $_GET['kategori_id'] !== 'all' && is_numeric($_GET['kategori_id']) ? (int)$_GET['kategori_id'] : null;
$filter_jenis_id = isset($_GET['jenis_id']) && $_GET['jenis_id'] !== 'all' && is_numeric($_GET['jenis_id']) ? (int)$_GET['jenis_id'] : null;
$filter_max_harga = isset($_GET['max_harga']) && is_numeric($_GET['max_harga']) && $_GET['max_harga'] > 0 ? (int)$_GET['max_harga'] : null;

// --- Bangun Query String untuk Link Paginasi & Form ---
$query_string_filters_array = [];
if ($filter_wilayah_id !== null) $query_string_filters_array['wilayah_id'] = $filter_wilayah_id;
if ($filter_kategori_id !== null) $query_string_filters_array['kategori_id'] = $filter_kategori_id;
if ($filter_jenis_id !== null) $query_string_filters_array['jenis_id'] = $filter_jenis_id;
if ($filter_max_harga !== null) $query_string_filters_array['max_harga'] = $filter_max_harga;
$http_query_filters = http_build_query($query_string_filters_array); // e.g., "wilayah_id=1&kategori_id=2"

// Get filter options (untuk dropdown)
$wilayah_sql = "SELECT * FROM wilayah";
$result_wilayah = mysqli_query($conn, $wilayah_sql);
if (!$result_wilayah) { die("Error query wilayah: " . mysqli_error($conn)); }


$jenis_paket_sql = "SELECT * FROM jenis_paket";
$result_jenis_paket = mysqli_query($conn, $jenis_paket_sql);
if (!$result_jenis_paket) { die("Error query jenis paket: " . mysqli_error($conn)); }

$kategori_sql = "SELECT * FROM kategori_wisata";
$result_kategori = mysqli_query($conn, $kategori_sql);
if (!$result_kategori) { die("Error query kategori: " . mysqli_error($conn)); }

// --- Bangun Kondisi WHERE untuk Query SQL ---
$where_conditions = [];
if ($filter_wilayah_id !== null) {
    $where_conditions[] = "pw.id_wilayah = " . $filter_wilayah_id;
}
if ($filter_kategori_id !== null) {
    // Asumsi di tabel wisata ada kolom kategori_id yang berelasi dengan tabel kategori_wisata
    $where_conditions[] = "w.kategori_id = " . $filter_kategori_id;
}
if ($filter_jenis_id !== null) {
    $where_conditions[] = "pw.id_jenis_paket = " . $filter_jenis_id;
}
if ($filter_max_harga !== null) {
    // Pastikan kolom harga adalah numerik di database
    $where_conditions[] = "pw.harga <= " . $filter_max_harga;
}

$where_clause = "";
if (!empty($where_conditions)) {
    $where_clause = " WHERE " . implode(" AND ", $where_conditions);
}

// --- Query untuk menghitung total paket (DENGAN FILTER) ---
$query_total_paket = "SELECT COUNT(DISTINCT pw.id_paket_wisata) as total
                      FROM paket_wisata pw
                      JOIN wisata w ON pw.id_wisata = w.id_wisata
                      JOIN kategori_wisata kw ON w.kategori_id = kw.id_kategori
                      JOIN jenis_paket jp ON pw.id_jenis_paket = jp.id_jenis_paket
                      JOIN wilayah wy ON pw.id_wilayah = wy.id_wilayah" . $where_clause;

$result_total_paket = mysqli_query($conn, $query_total_paket);
if (!$result_total_paket) {
    die("Error counting total packages: " . mysqli_error($conn));
}
$row_total_paket = mysqli_fetch_assoc($result_total_paket);
$total_semua_paket_filtered = $row_total_paket['total'];
$total_halaman = ceil($total_semua_paket_filtered / $item_per_halaman);

// Koreksi halaman aktif jika melebihi total halaman setelah filter
if ($total_halaman < 1 && $total_semua_paket_filtered > 0) { // Jika ada hasil tapi kurang dari 1 halaman
    $total_halaman = 1;
}

// Perbaiki logika penyesuaian halaman aktif dan offset
if ($halaman_aktif > $total_halaman) {
    if ($total_halaman > 0) {
        $halaman_aktif = $total_halaman; // Set ke halaman terakhir yang valid
    } else {
        $halaman_aktif = 1; // Jika tidak ada hasil, set ke halaman 1
    }
}
$offset = ($halaman_aktif - 1) * $item_per_halaman;
if ($offset < 0) $offset = 0; // Pastikan offset tidak negatif


// --- Query untuk mengambil paket wisata dengan LIMIT, OFFSET, dan FILTER ---
$paket_wisata_sql = "SELECT pw.*, w.nama_wisata, w.kategori_id, kw.nama_kategori,
                       jp.jenis_paket, wy.nama_wilayah
                       FROM paket_wisata pw
                       JOIN wisata w ON pw.id_wisata = w.id_wisata
                       JOIN kategori_wisata kw ON w.kategori_id = kw.id_kategori
                       JOIN jenis_paket jp ON pw.id_jenis_paket = jp.id_jenis_paket
                       JOIN wilayah wy ON pw.id_wilayah = wy.id_wilayah" . $where_clause;

$paket_wisata_sql .= " ORDER BY pw.id_paket_wisata DESC"; // Contoh pengurutan
$paket_wisata_sql .= " LIMIT $item_per_halaman OFFSET $offset";

$result_paket_wisata = mysqli_query($conn, $paket_wisata_sql);
if (!$result_paket_wisata) {
    die("Error fetching packages: " . mysqli_error($conn));
}
$jumlah_paket_di_halaman_ini = mysqli_num_rows($result_paket_wisata);

?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Paket Wisata</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="CSS/paket_wisata.css"> 
  <style>
    /* Tambahan CSS untuk Paginasi */
   .pagination {
     display: flex;
     justify-content: center;
     align-items: center;
     margin: 3rem 0;
     gap: 0.5rem; /* Jarak antar tombol */
   }

   .pagination a, .pagination span {
     display: inline-flex; /* Agar ikon dan teks (jika ada) sejajar dan ukuran tombol pas */
     align-items: center;
     justify-content: center;
     padding: 0.75rem 1rem; /* Sesuaikan padding jika hanya ikon */
     margin: 0; /* Hapus margin default jika ada */
     border-radius: 8px;
     background-color: #f8f9fa;
     color: #495057;
     text-decoration: none;
     transition: all 0.3s ease;
     border: 1px solid #dee2e6;
     min-width: 44px; /* Ukuran minimum tombol */
     height: 44px;   /* Ukuran minimum tombol */
     font-weight: 500;
     box-sizing: border-box; /* Untuk memastikan padding dan border masuk dalam width/height */
   }

   .pagination a:hover {
     background-color: #e9ecef;
     color: #2c7a51; /* Warna ikon saat hover */
     border-color: #2c7a51;
     transform: translateY(-1px);
   }

   .pagination .current { /* Class untuk halaman aktif */
     background-color: #2c7a51;
     color: white;
     border-color: #2c7a51;
     font-weight: bold;
     cursor: default;
   }

   .pagination .disabled { /* Class untuk tombol non-aktif (misal prev di hal 1) */
     background-color: #f8f9fa;
     color: #adb5bd; /* Warna ikon disabled */
     cursor: not-allowed;
     border-color: #dee2e6;
   }

   .pagination .disabled:hover {
     background-color: #f8f9fa; /* Tidak ada perubahan saat hover */
     color: #adb5bd;
     transform: none;
   }
   /* Styling untuk ellipsis (...) jika digunakan */
   .pagination span:not(.disabled) {
     color: #495057; /* Warna default untuk ... */
   }

   .results-counter {
     text-align: center;
     margin-bottom: 1rem;
     color: #666;
     font-size: 0.9rem;
   }
   .no-results {
        text-align: center;
        padding: 2rem;
        color: #777;
    }
    .no-results i {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: #ccc;
    }
    .no-results h3 {
        margin-bottom: 0.5rem;
    }
    /* CSS dari file paket_wisata.css Anda akan tetap berlaku */
  </style>
</head>
<body>
  <?php // Navbar sudah di-include di atas ?>

  <section class="hero">
    <h1>Paket Wisata</h1>
    <p>Pilih berdasarkan Wilayah, Harga, Jenis Paket dan Kategori</p>
  </section>

  <section class="filter-section">
    <form method="GET" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="filterForm">
        <div class="filter-container">
            <div class="filter-group">
                <div class="filter-label">Wilayah:</div>
                <select id="wilayah_id" name="wilayah_id" class="filter-select">
                    <option value="all">Semua Wilayah</option>
                    <?php
                    if ($result_wilayah) {
                        mysqli_data_seek($result_wilayah, 0);
                        while ($row = mysqli_fetch_assoc($result_wilayah)) {
                            echo '<option value="' . htmlspecialchars($row['id_wilayah']) . '" ' . ($filter_wilayah_id == $row['id_wilayah'] ? 'selected' : '') . '>'
                               . htmlspecialchars($row['nama_wilayah'])
                               . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="filter-group">
                <div class="filter-label">Kategori:</div>
                <select id="kategori_id" name="kategori_id" class="filter-select">
                    <option value="all">Semua Kategori</option>
                    <?php
                    if ($result_kategori) {
                        mysqli_data_seek($result_kategori, 0);
                        while ($row = mysqli_fetch_assoc($result_kategori)) {
                            echo '<option value="' . htmlspecialchars($row['id_kategori']) . '" ' . ($filter_kategori_id == $row['id_kategori'] ? 'selected' : '') . '>'
                               . htmlspecialchars($row['nama_kategori'])
                               . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="filter-group">
                <div class="filter-label">Jenis Paket:</div>
                <select id="jenis_id" name="jenis_id" class="filter-select">
                    <option value="all">Semua Jenis</option>
                    <?php
                    if ($result_jenis_paket) {
                        mysqli_data_seek($result_jenis_paket, 0);
                        while ($row = mysqli_fetch_assoc($result_jenis_paket)) {
                            echo '<option value="' . htmlspecialchars($row['id_jenis_paket']) . '" ' . ($filter_jenis_id == $row['id_jenis_paket'] ? 'selected' : '') . '>'
                               . htmlspecialchars($row['jenis_paket'])
                               . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="filter-group">
                <div class="filter-label">Harga Maks:</div>
                <input type="number" id="max_harga" name="max_harga" class="filter-input" placeholder="Rp" value="<?php echo htmlspecialchars($filter_max_harga ?? ''); ?>" min="0">
            </div>
            <div class="filter-group">
                <button type="submit" class="filter-button">Terapkan Filter</button>
            </div>
        </div>
    </form>
  </section>

  <section class="container">
    <div class="section-heading">
      <h2>Paket Wisata Populer</h2>
      <p>Temukan paket wisata terbaik sesuai dengan budget dan preferensi Anda</p>
    </div>

    <div class="results-counter" id="resultsCounter">
        <?php if ($total_semua_paket_filtered > 0): ?>
            Menampilkan <?php echo $jumlah_paket_di_halaman_ini; ?> dari total <?php echo $total_semua_paket_filtered; ?> paket wisata yang cocok.
            Halaman <?php echo $halaman_aktif; ?> dari <?php echo $total_halaman; ?>.
        <?php elseif (!empty($http_query_filters)): // Jika ada filter aktif tapi tidak ada hasil ?>
             Tidak ada paket wisata yang cocok dengan filter Anda saat ini.
        <?php else: // Jika tidak ada filter dan tidak ada hasil (atau database kosong) ?>
            Saat ini belum ada paket wisata yang tersedia.
        <?php endif; ?>
    </div>

    <div id="paketContainer" class="paket-grid">
      <?php
      if ($jumlah_paket_di_halaman_ini > 0) {
        mysqli_data_seek($result_paket_wisata, 0);
        while ($row = mysqli_fetch_assoc($result_paket_wisata)) {
          // Get first image for this wisata
          $image_url = 'https://via.placeholder.com/300x200?text=Gambar+Wisata'; // Default image
          if (isset($row['id_wisata'])) {
              $img_query = "SELECT url FROM gambar WHERE wisata_id = " . (int)$row['id_wisata'] . " LIMIT 1";
              $img_result = mysqli_query($conn, $img_query);
              if ($img_result && mysqli_num_rows($img_result) > 0) {
                  $img_row = mysqli_fetch_assoc($img_result);
                  $image_url = htmlspecialchars($img_row['url']);
              }
          }
      ?>
      <div class="paket-card"
           data-harga="<?php echo htmlspecialchars($row['harga']); ?>"
           data-wilayah="<?php echo htmlspecialchars($row['id_wilayah']); ?>"
           data-kategori="<?php echo htmlspecialchars($row['kategori_id']); ?>"
           data-jenis="<?php echo htmlspecialchars($row['id_jenis_paket']); ?>">
        <div class="card-image">
          <img src="<?php echo $image_url; ?>" alt="<?php echo htmlspecialchars($row['nama_wisata']); ?>">
          <div class="card-badge <?php echo strtolower(htmlspecialchars($row['jenis_paket'])); ?>">
            <?php echo htmlspecialchars($row['jenis_paket']); ?>
          </div>
        </div>
        <div class="card-content">
          <h3><?php echo htmlspecialchars($row['nama_paket']); ?></h3>
          <div class="card-location">
            <i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($row['nama_wilayah']); ?>
          </div>
          <div class="card-meta">
            <div class="card-price">Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></div>
            <div class="card-category"><?php echo htmlspecialchars($row['nama_kategori']); ?></div>
          </div>
          <button class="detail-button" onclick="viewDetail(<?php echo $row['id_paket_wisata']; ?>)">
            <i class="fas fa-eye"></i>
            Lihat Detail
          </button>
        </div>
      </div>
      <?php
        } // end while
      } elseif ($total_semua_paket_filtered === 0 && !empty($http_query_filters)) {
      ?>
        <div class="no-results">
          <i class="fas fa-binoculars"></i>
          <h3>Maaf, tidak ada paket yang ditemukan</h3>
          <p>Coba sesuaikan filter pencarian Anda atau hapus beberapa filter.</p>
        </div>
      <?php
      } elseif ($total_semua_paket_filtered === 0) { // Kondisi jika database benar-benar kosong atau tidak ada paket sama sekali
      ?>
        <div class="no-results">
          <i class="fas fa-box-open"></i>
          <h3>Belum Ada Paket Wisata</h3>
          <p>Silakan cek kembali nanti untuk penawaran paket wisata terbaru.</p>
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

        // Tombol Previous (Chevron Kiri)
        if ($halaman_aktif > 1) {
            echo '<a href="' . $base_page_url . ($halaman_aktif - 1) . $filter_params_for_pagination . '" aria-label="Halaman Sebelumnya"><i class="fas fa-chevron-left"></i></a>';
        } else {
            echo '<span class="disabled" aria-hidden="true"><i class="fas fa-chevron-left"></i></span>';
        }

        // Nomor Halaman
        $link_limit = 2;
        $start_page = max(1, $halaman_aktif - $link_limit);
        $end_page = min($total_halaman, $halaman_aktif + $link_limit);

        if ($start_page > 1) {
            echo '<a href="' . $base_page_url . '1' . $filter_params_for_pagination . '">1</a>';
            if ($start_page > 2) {
                echo '<span>...</span>';
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
                echo '<span>...</span>';
            }
            echo '<a href="' . $base_page_url . $total_halaman . $filter_params_for_pagination . '">' . $total_halaman . '</a>';
        }

        // Tombol Next (Chevron Kanan)
        if ($halaman_aktif < $total_halaman) {
            echo '<a href="' . $base_page_url . ($halaman_aktif + 1) . $filter_params_for_pagination . '" aria-label="Halaman Berikutnya"><i class="fas fa-chevron-right"></i></a>';
        } else {
            echo '<span class="disabled" aria-hidden="true"><i class="fas fa-chevron-right"></i></span>';
        }
        ?>
    </div>
    <?php endif; ?>

  </section>

  <?php include "Komponen/footer.php"; // Pastikan path ini benar ?>

  <script>
    function viewDetail(paketId) {
      // Pastikan Anda memiliki halaman paket_wisata_detail.php atau sesuaikan URL-nya
      window.location.href = `paket_wisata_detail.php?id=${paketId}`;
    }

    // Tidak ada JavaScript filter client-side yang diperlukan untuk fungsi utama
    // karena semua filter dan paginasi ditangani oleh server.
  </script>
</body>
</html>
<?php
// Tutup koneksi database jika sudah tidak digunakan lagi di akhir script
if (isset($conn) && $conn instanceof mysqli) {
    mysqli_close($conn);
}
?>