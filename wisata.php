<?php 
include 'Komponen/navbar.php'; 
include './backend/koneksi.php'; 

// Baca parameter GET jika ada
$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';
$lokasi = isset($_GET['lokasi']) ? $_GET['lokasi'] : '';

// TAMBAHAN: Parameter untuk pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 6; // Jumlah data per halaman
$offset = ($page - 1) * $limit;

// Ambil data kategori
$queryKategori = "SELECT id_kategori, nama_kategori FROM kategori_wisata ORDER BY nama_kategori ASC";
$resultKategori = mysqli_query($conn, $queryKategori);

// Ambil data lokasi
$queryLokasi = "SELECT id_lokasi, nama_lokasi FROM lokasi ORDER BY nama_lokasi ASC";
$resultLokasi = mysqli_query($conn, $queryLokasi);

// Mulai bangun kondisi WHERE
$where = [];

// Filter berdasarkan kategori
if (!empty($kategori) && $kategori !== 'all') {
    $kategori_escaped = mysqli_real_escape_string($conn, $kategori);
    $where[] = "k.id_kategori = '$kategori_escaped'";
}

// Filter berdasarkan lokasi
if (!empty($lokasi) && $lokasi !== 'all') {
    $lokasi_escaped = mysqli_real_escape_string($conn, $lokasi);
    $where[] = "l.id_lokasi = '$lokasi_escaped'";
}

// Gabungkan kondisi WHERE
$whereSQL = '';
if (count($where) > 0) {
    $whereSQL = 'WHERE ' . implode(' AND ', $where);
}

// PERBAIKAN: Hitung total hasil untuk pagination SEBELUM query utama
$countQuery = "
SELECT COUNT(DISTINCT w.id_wisata) as total
FROM wisata w
JOIN lokasi l ON l.id_lokasi = w.id_lokasi
JOIN kategori_wisata k ON k.id_kategori = w.kategori_id
{$whereSQL}
";
$countResult = mysqli_query($conn, $countQuery);
$totalData = mysqli_fetch_assoc($countResult)['total'];

// PERBAIKAN: Hitung total halaman
$totalPages = ceil($totalData / $limit);

// PERBAIKAN: Query utama dengan LIMIT dan OFFSET
$query = "
SELECT 
    w.id_wisata, 
    w.nama_wisata, 
    w.deskripsi_wisata, 
    l.nama_lokasi,
    k.nama_kategori,
    g.url, 
    g.caption,
    AVG(u.rating) AS avg_rating,
    COUNT(u.id_ulasan) AS jumlah_ulasan
FROM wisata w
JOIN gambar g ON g.wisata_id = w.id_wisata
JOIN lokasi l ON l.id_lokasi = w.id_lokasi
JOIN kategori_wisata k ON k.id_kategori = w.kategori_id
LEFT JOIN ulasan u ON u.id_wisata = w.id_wisata
{$whereSQL}
GROUP BY 
    w.id_wisata, 
    w.nama_wisata, 
    w.deskripsi_wisata, 
    l.nama_lokasi, 
    k.nama_kategori, 
    g.url, 
    g.caption
ORDER BY w.nama_wisata ASC
LIMIT {$limit} OFFSET {$offset}
";

$result = mysqli_query($conn, $query);
if (!$result) {
    die("Query error: " . mysqli_error($conn));
}

$queryKategoriCount = "
SELECT 
    k.id_kategori, 
    k.nama_kategori, 
    COUNT(w.id_wisata) as jumlah_destinasi 
FROM kategori_wisata k 
LEFT JOIN wisata w ON k.id_kategori = w.kategori_id 
GROUP BY k.id_kategori, k.nama_kategori 
ORDER BY jumlah_destinasi DESC, k.nama_kategori ASC
";
$resultKategoriCount = mysqli_query($conn, $queryKategoriCount);

// TAMBAHAN: Function untuk membuat URL pagination
function buildPaginationUrl($page, $kategori = '', $lokasi = '') {
    $params = [];
    if (!empty($kategori) && $kategori !== 'all') {
        $params['kategori'] = $kategori;
    }
    if (!empty($lokasi) && $lokasi !== 'all') {
        $params['lokasi'] = $lokasi;
    }
    $params['page'] = $page;
    
    return '?' . http_build_query($params);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Destinasi Wisata</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="stylesheet" href="CSS/wisata.css">
</head>
<body>
<!-- Hero Section -->
  <section class="hero">
    <h1>Jelajahi Keindahan Pulau Jawa</h1>
    <p>Temukan destinasi wisata terbaik di Pulau Jawa, dari pantai eksotis hingga tempat hiburan yang menyenangkan</p>
    <div class="search-container">
      <input type="text" placeholder="Cari destinasi wisata...">
      <button><i class="fas fa-search"></i> Cari</button>
    </div>
  </section>

  <!-- Filter Section -->
  <section class="filter-section">
    <form method="GET" action="">
      <div class="filter-container">
        <div class="filter-group">
          <div class="filter-label">Kategori:</div>
          <select class="filter-select" name="kategori">
            <option value="all" <?= ($kategori === 'all' || $kategori === '') ? 'selected' : '' ?>>Semua Kategori</option>
            <?php 
            mysqli_data_seek($resultKategori, 0);
            while($kat = mysqli_fetch_assoc($resultKategori)): 
            ?>
              <option value="<?= $kat['id_kategori']; ?>" <?= ($kategori == $kat['id_kategori']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($kat['nama_kategori']); ?>
              </option>
            <?php endwhile; ?>
          </select>
        </div>
        
        <div class="filter-group">
          <div class="filter-label">Lokasi:</div>
          <select class="filter-select" name="lokasi">
            <option value="all" <?= ($lokasi === 'all' || $lokasi === '') ? 'selected' : '' ?>>Semua Lokasi</option>
            <?php 
            mysqli_data_seek($resultLokasi, 0);
            while($lok = mysqli_fetch_assoc($resultLokasi)): 
            ?>
              <option value="<?= $lok['id_lokasi']; ?>" <?= ($lokasi == $lok['id_lokasi']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($lok['nama_lokasi']); ?>
              </option>
            <?php endwhile; ?>
          </select>
        </div>
        
        <div class="filter-group">
          <button type="submit" class="filter-button">
            <i class="fas fa-filter"></i> Terapkan Filter
          </button>
          <?php if (!empty($kategori) || !empty($lokasi)): ?>
            <a href="?" class="clear-filter">
              <i class="fas fa-times"></i> Reset Filter
            </a>
          <?php endif; ?>
        </div>
      </div>
    </form>
  </section>

  <!-- Filter Info -->
  <?php if (!empty($kategori) || !empty($lokasi)): ?>
  <section class="container">
    <div class="filter-info">
      <i class="fas fa-info-circle"></i>
      <strong>Filter Aktif:</strong>
      <?php 
      $filterText = [];
      if (!empty($kategori) && $kategori !== 'all') {
        // Cari nama kategori
        mysqli_data_seek($resultKategori, 0);
        while($kat = mysqli_fetch_assoc($resultKategori)) {
          if ($kat['id_kategori'] == $kategori) {
            $filterText[] = "Kategori: " . $kat['nama_kategori'];
            break;
          }
        }
      }
      if (!empty($lokasi) && $lokasi !== 'all') {
        // Cari nama lokasi
        mysqli_data_seek($resultLokasi, 0);
        while($lok = mysqli_fetch_assoc($resultLokasi)) {
          if ($lok['id_lokasi'] == $lokasi) {
            $filterText[] = "Lokasi: " . $lok['nama_lokasi'];
            break;
          }
        }
      }
      echo implode(" | ", $filterText);
      ?>
      | Ditemukan <?= $totalData; ?> destinasi
    </div>
  </section>
  <?php endif; ?>

  <!-- Featured Destinations -->
  <section class="container">
    <div class="section-heading">
      <h2>
        <?php if (!empty($kategori) || !empty($lokasi)): ?>
          Hasil Pencarian
        <?php else: ?>
          Destinasi Populer
        <?php endif; ?>
      </h2>
      <p>
        <?php if (!empty($kategori) || !empty($lokasi)): ?>
          Destinasi wisata yang sesuai dengan filter yang dipilih
        <?php else: ?>
          Temukan destinasi wisata terpopuler yang wajib dikunjungi di Pulau Jawa
        <?php endif; ?>
      </p>
    </div>

    <?php if (mysqli_num_rows($result) > 0): ?>
    <div class="destinations-grid">
      <?php while($row = mysqli_fetch_assoc($result)): ?>
        <div class="destination-card">
          <div class="card-image">
            <img src="<?= htmlspecialchars($row['url']); ?>" alt="<?= htmlspecialchars($row['nama_wisata']); ?>" onerror="this.src='https://via.placeholder.com/300x200?text=No+Image'">
            <button class="wishlist-button">
              <i class="far fa-heart"></i>
            </button>
          </div>
          <div class="card-content">
            <h3><?= htmlspecialchars($row['nama_wisata']); ?></h3>
            <div class="card-location">
              <i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($row['nama_lokasi']); ?>
            </div>
            <div class="card-category">
              <i class="fas fa-tag"></i> <?= htmlspecialchars($row['nama_kategori']); ?>
            </div>
            <div class="card-rating">
              <div class="stars">
                <?php
                  $rating = $row['avg_rating'] ?? 0;
                  $stars = round($rating);
                  for ($i = 0; $i < $stars; $i++) {
                      echo "★";
                  }
                  for ($i = $stars; $i < 5; $i++) {
                      echo "☆";
                  }
                ?>
              </div>
              <div class="count">(<?= $row['jumlah_ulasan']; ?> ulasan)</div>
            </div>
            <div class="card-description">
              <?= htmlspecialchars($row['deskripsi_wisata']); ?>
            </div>
            <div class="card-meta">
              <a href="wisata_detail.php?id=<?= $row['id_wisata']; ?>" class="card-button">
                <i class="fas fa-eye"></i> Lihat Detail
              </a>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
    <?php else: ?>
    <div class="no-results">
      <i class="fas fa-search"></i>
      <h3>Tidak ada destinasi ditemukan</h3>
      <p>Coba ubah filter atau reset untuk melihat semua destinasi.</p>
      <a href="?" class="card-button" style="margin-top: 1rem;">
        <i class="fas fa-refresh"></i> Lihat Semua Destinasi
      </a>
    </div>
    <?php endif; ?>
  <section class="container">


    <?php if (mysqli_num_rows($result) > 0): ?>
    <!-- TAMBAHAN: Info pagination -->
    <div class="pagination-info">
      Menampilkan <?= (($page - 1) * $limit) + 1; ?> - <?= min($page * $limit, $totalData); ?> dari <?= $totalData; ?> destinasi
    </div>
    
    <div class="destinations-grid">
      <?php while($row = mysqli_fetch_assoc($result)): ?>
        <!-- Card HTML tetap sama -->
        <div class="destination-card">
          <div class="card-image">
            <img src="<?= htmlspecialchars($row['url']); ?>" alt="<?= htmlspecialchars($row['nama_wisata']); ?>" onerror="this.src='https://via.placeholder.com/300x200?text=No+Image'">
          <button class="wishlist-button" data-wisata="<?= $row['id_wisata']; ?>">
              <i class="far fa-heart"></i>
          </button>
          </div>
          <div class="card-content">
            <h3><?= htmlspecialchars($row['nama_wisata']); ?></h3>
            <div class="card-location">
              <i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($row['nama_lokasi']); ?>
            </div>
            <div class="card-category">
              <i class="fas fa-tag"></i> <?= htmlspecialchars($row['nama_kategori']); ?>
            </div>
            <div class="card-rating">
              <div class="stars">
                <?php
                  $rating = $row['avg_rating'] ?? 0;
                  $stars = round($rating);
                  for ($i = 0; $i < $stars; $i++) {
                      echo "★";
                  }
                  for ($i = $stars; $i < 5; $i++) {
                      echo "☆";
                  }
                ?>
              </div>
              <div class="count">(<?= $row['jumlah_ulasan']; ?> ulasan)</div>
            </div>
            <div class="card-description">
              <?= htmlspecialchars($row['deskripsi_wisata']); ?>
            </div>
            <div class="card-meta">
              <a href="wisata_detail.php?id=<?= $row['id_wisata']; ?>" class="card-button">
                <i class="fas fa-eye"></i> Lihat Detail
              </a>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
    <?php else: ?>
    <div class="no-results">
      <i class="fas fa-search"></i>
      <h3>Tidak ada destinasi ditemukan</h3>
      <p>Coba ubah filter atau reset untuk melihat semua destinasi.</p>
      <a href="?" class="card-button" style="margin-top: 1rem;">
        <i class="fas fa-refresh"></i> Lihat Semua Destinasi
      </a>
    </div>
    <?php endif; ?>

    <!-- PERBAIKAN: Pagination yang dinamis -->
    <?php if ($totalPages > 1): ?>
    <div class="pagination">
      <!-- Tombol Previous -->
      <?php if ($page > 1): ?>
        <a href="<?= buildPaginationUrl($page - 1, $kategori, $lokasi); ?>" title="Halaman Sebelumnya">
          <i class="fas fa-chevron-left"></i>
        </a>
      <?php else: ?>
        <span class="disabled">
          <i class="fas fa-chevron-left"></i>
        </span>
      <?php endif; ?>

      <?php
      // Logika untuk menampilkan nomor halaman
      $start = max(1, $page - 2);
      $end = min($totalPages, $page + 2);
      
      // Jika di awal, tampilkan lebih banyak halaman ke depan
      if ($page <= 3) {
        $end = min($totalPages, 5);
      }
      
      // Jika di akhir, tampilkan lebih banyak halaman ke belakang
      if ($page > $totalPages - 3) {
        $start = max(1, $totalPages - 4);
      }
      ?>

      <!-- Halaman pertama dan dots jika perlu -->
      <?php if ($start > 1): ?>
        <a href="<?= buildPaginationUrl(1, $kategori, $lokasi); ?>">1</a>
        <?php if ($start > 2): ?>
          <span class="page-dots">...</span>
        <?php endif; ?>
      <?php endif; ?>

      <!-- Halaman-halaman di tengah -->
      <?php for ($i = $start; $i <= $end; $i++): ?>
        <?php if ($i == $page): ?>
          <span class="current"><?= $i; ?></span>
        <?php else: ?>
          <a href="<?= buildPaginationUrl($i, $kategori, $lokasi); ?>"><?= $i; ?></a>
        <?php endif; ?>
      <?php endfor; ?>

      <!-- Dots dan halaman terakhir jika perlu -->
      <?php if ($end < $totalPages): ?>
        <?php if ($end < $totalPages - 1): ?>
          <span class="page-dots">...</span>
        <?php endif; ?>
        <a href="<?= buildPaginationUrl($totalPages, $kategori, $lokasi); ?>"><?= $totalPages; ?></a>
      <?php endif; ?>

      <!-- Tombol Next -->
      <?php if ($page < $totalPages): ?>
        <a href="<?= buildPaginationUrl($page + 1, $kategori, $lokasi); ?>" title="Halaman Selanjutnya">
          <i class="fas fa-chevron-right"></i>
        </a>
      <?php else: ?>
        <span class="disabled">
          <i class="fas fa-chevron-right"></i>
        </span>
      <?php endif; ?>
    </div>
    <?php endif; ?>
  </section>

<!-- Popular Categories -->
  <!-- Popular Categories -->
<section class="categories-section">
  <div class="container">
    <div class="section-heading">
      <h2>Kategori Populer</h2>
      <p>Temukan berbagai jenis destinasi wisata sesuai dengan minat perjalanan Anda</p>
    </div>

    <div class="categories-container">
      <?php
      // Periksa jika query berhasil
      if ($resultKategoriCount && mysqli_num_rows($resultKategoriCount) > 0) {
        while ($row = mysqli_fetch_assoc($resultKategoriCount)) {
          $idKategori = $row['id_kategori'];
          $namaKategori = $row['nama_kategori'];
          $jumlahDestinasi = $row['jumlah_destinasi'];

          // Pilih ikon berdasarkan kategori (opsional: sesuaikan dengan kategori)
          $ikon = '<i class="fas fa-map-marked-alt"></i>'; // default icon
          if ($namaKategori == "Pantai") {
            $ikon = '<i class="fas fa-umbrella-beach"></i>';
          } elseif ($namaKategori == "Hiburan") {
            $ikon = '<i class="fa fa-theater-masks"></i>';
          } elseif ($namaKategori == "Budaya & Sejarah") {
            $ikon = '<i class="fas fa-landmark"></i>';
          }

          echo '
          <div class="category-card" onclick="window.location.href=\'?kategori=' . $idKategori . '\'">
            <div class="category-icon">
              ' . $ikon . '
            </div>
            <div class="category-name">' . htmlspecialchars($namaKategori) . '</div>
            <div class="category-count">' . $jumlahDestinasi . ' Destinasi</div>
          </div>';
        }
      } else {
        echo '<p>Tidak ada kategori ditemukan.</p>';
      }
      ?>
    </div>
  </div>
</section>


  <?php include 'Komponen/footer.php'; ?>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Wishlist functionality
      const wishlistButtons = document.querySelectorAll('.wishlist-button');
      
      wishlistButtons.forEach(button => {
        button.addEventListener('click', function(e) {
          e.preventDefault();
          const icon = this.querySelector('i');
          this.classList.toggle('active');
          
          if (this.classList.contains('active')) {
            icon.classList.remove('far');
            icon.classList.add('fas');
          } else {
            icon.classList.remove('fas');
            icon.classList.add('far');
          }
        });
      });

      // Search functionality
      const searchInput = document.querySelector('.search-container input');
      const searchButton = document.querySelector('.search-container button');
      
      searchButton.addEventListener('click', function(e) {
        e.preventDefault();
        const searchValue = searchInput.value.trim();
        if (searchValue) {
          // Implementasi pencarian bisa ditambahkan di sini
          console.log('Searching for:', searchValue);
          // window.location.href = '?search=' + encodeURIComponent(searchValue);
        }
      });

      searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
          e.preventDefault();
          searchButton.click();
        }
      });

      // Auto-submit form when filter changes (optional)
      const filterSelects = document.querySelectorAll('.filter-select');
      filterSelects.forEach(select => {
        select.addEventListener('change', function() {
          // Uncomment the line below if you want auto-submit on filter change
          // this.form.submit();
        });
      });
    });
  </script>
</body>
</html>