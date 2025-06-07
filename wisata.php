<?php 
include 'Komponen/navbar.php'; 
include './backend/koneksi.php';

// Baca parameter GET jika ada
$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';
$lokasi = isset($_GET['lokasi']) ? $_GET['lokasi'] : '';

// Parameter untuk pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 6; 
$offset = ($page - 1) * $limit;

// Ambil data kategori
$queryKategori = "SELECT id_kategori, nama_kategori FROM kategori_wisata ORDER BY nama_kategori ASC";
$resultKategori = mysqli_query($conn, $queryKategori);

// Ambil data lokasi
$queryLokasi = "SELECT id_lokasi, nama_lokasi FROM lokasi ORDER BY nama_lokasi ASC";
$resultLokasi = mysqli_query($conn, $queryLokasi);

// Mulai bangun kondisi WHERE
$where = [];
if (!empty($kategori) && $kategori !== 'all') {
    $kategori_escaped = mysqli_real_escape_string($conn, $kategori);
    $where[] = "k.id_kategori = '$kategori_escaped'";
}
if (!empty($lokasi) && $lokasi !== 'all') {
    $lokasi_escaped = mysqli_real_escape_string($conn, $lokasi);
    $where[] = "l.id_lokasi = '$lokasi_escaped'";
}

$whereSQL = '';
if (count($where) > 0) {
    $whereSQL = 'WHERE ' . implode(' AND ', $where);
}

$countQuery = "
SELECT COUNT(DISTINCT w.id_wisata) as total
FROM wisata w
JOIN lokasi l ON l.id_lokasi = w.id_lokasi
JOIN kategori_wisata k ON k.id_kategori = w.kategori_id
{$whereSQL}
";
$countResult = mysqli_query($conn, $countQuery);
$totalData = mysqli_fetch_assoc($countResult)['total'];
$totalPages = ceil($totalData / $limit);

// Query utama dengan LIMIT dan OFFSET
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
    COUNT(DISTINCT u.id_ulasan) AS jumlah_ulasan -- Pakai DISTINCT untuk jumlah ulasan
FROM wisata w
LEFT JOIN (
    SELECT wisata_id, MIN(id_gambar) as id_gambar
    FROM gambar
    GROUP BY wisata_id
) g1 ON g1.wisata_id = w.id_wisata
LEFT JOIN gambar g ON g.id_gambar = g1.id_gambar
JOIN lokasi l ON l.id_lokasi = w.id_lokasi
JOIN kategori_wisata k ON k.id_kategori = w.kategori_id
LEFT JOIN ulasan u ON u.id_wisata = w.id_wisata
{$whereSQL}
GROUP BY 
    w.id_wisata, w.nama_wisata, w.deskripsi_wisata, l.nama_lokasi, k.nama_kategori, g.url, g.caption
ORDER BY w.nama_wisata ASC
LIMIT {$limit} OFFSET {$offset}
";

$result = mysqli_query($conn, $query);
if (!$result) {
    die("Query error: " . mysqli_error($conn));
}

// >>> MODIFIKASI UNTUK WISHLIST DINAMIS <<<
$user_wishlist_ids = [];
if (isset($_SESSION['user']['id_pengunjung'])) {
    $id_pengunjung_logged_in = (int)$_SESSION['user']['id_pengunjung'];
    $queryWishlist = "SELECT wisata_id FROM wishlist WHERE user_id = $id_pengunjung_logged_in";
    $resultWishlist = mysqli_query($conn, $queryWishlist);
    if ($resultWishlist) {
        while ($wish_row = mysqli_fetch_assoc($resultWishlist)) {
            $user_wishlist_ids[] = $wish_row['wisata_id'];
        }
    }
}
// >>> AKHIR MODIFIKASI WISHLIST <<<

$queryKategoriCount = "
SELECT 
    k.id_kategori, k.nama_kategori, COUNT(w.id_wisata) as jumlah_destinasi 
FROM kategori_wisata k 
LEFT JOIN wisata w ON k.id_kategori = w.kategori_id 
GROUP BY k.id_kategori, k.nama_kategori 
ORDER BY jumlah_destinasi DESC, k.nama_kategori ASC
";
$resultKategoriCount = mysqli_query($conn, $queryKategoriCount);

function buildPaginationUrl($page, $kategori = '', $lokasi = '') {
    $params = [];
    if (!empty($kategori) && $kategori !== 'all') $params['kategori'] = $kategori;
    if (!empty($lokasi) && $lokasi !== 'all') $params['lokasi'] = $lokasi;
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
  <style>
    /* Tambahkan style untuk tombol wishlist yang aktif */
    .wishlist-button.active i {
        font-weight: 900; /* Membuat ikon menjadi solid (fas) */
        color: red; /* Warna hati saat aktif */
    }
  </style>
</head>
<body>
<section class="hero">
    <h1>Jelajahi Keindahan Pulau Jawa</h1>
    <p>Temukan destinasi wisata terbaik di Pulau Jawa, dari pantai eksotis hingga tempat hiburan yang menyenangkan</p>
    <div class="search-container">
      <input type="text" placeholder="Cari destinasi wisata..." id="searchInput">
      <button id="searchButton"><i class="fas fa-search"></i> Cari</button>
    </div>
  </section>

  <section class="filter-section">
    <form method="GET" action="">
      <div class="filter-container">
        <div class="filter-group">
          <div class="filter-label">Kategori:</div>
          <select class="filter-select" name="kategori">
            <option value="all" <?= ($kategori === 'all' || $kategori === '') ? 'selected' : '' ?>>Semua Kategori</option>
            <?php 
            if ($resultKategori && mysqli_num_rows($resultKategori) > 0) {
                mysqli_data_seek($resultKategori, 0);
                while($kat = mysqli_fetch_assoc($resultKategori)): 
            ?>
              <option value="<?= $kat['id_kategori']; ?>" <?= ($kategori == $kat['id_kategori']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($kat['nama_kategori']); ?>
              </option>
            <?php 
                endwhile; 
            }
            ?>
          </select>
        </div>
        
        <div class="filter-group">
          <div class="filter-label">Lokasi:</div>
          <select class="filter-select" name="lokasi">
            <option value="all" <?= ($lokasi === 'all' || $lokasi === '') ? 'selected' : '' ?>>Semua Lokasi</option>
            <?php 
            if ($resultLokasi && mysqli_num_rows($resultLokasi) > 0) {
                mysqli_data_seek($resultLokasi, 0);
                while($lok = mysqli_fetch_assoc($resultLokasi)): 
            ?>
              <option value="<?= $lok['id_lokasi']; ?>" <?= ($lokasi == $lok['id_lokasi']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($lok['nama_lokasi']); ?>
              </option>
            <?php 
                endwhile; 
            }
            ?>
          </select>
        </div>
        
        <div class="filter-group">
          <button type="submit" class="filter-button">
            <i class="fas fa-filter"></i> Terapkan Filter
          </button>
          <?php if ((!empty($kategori) && $kategori !== 'all') || (!empty($lokasi) && $lokasi !== 'all')): ?>
            <a href="?" class="clear-filter">
              <i class="fas fa-times"></i> Reset Filter
            </a>
          <?php endif; ?>
        </div>
      </div>
    </form>
  </section>

  <?php if ((!empty($kategori) && $kategori !== 'all') || (!empty($lokasi) && $lokasi !== 'all')): ?>
  <section class="container">
    <div class="filter-info">
      <i class="fas fa-info-circle"></i>
      <strong>Filter Aktif:</strong>
      <?php 
      $filterText = [];
      if (!empty($kategori) && $kategori !== 'all') {
        if ($resultKategori) mysqli_data_seek($resultKategori, 0); // Reset pointer jika sudah pernah di-loop
        while($kat = mysqli_fetch_assoc($resultKategori)) {
          if ($kat['id_kategori'] == $kategori) {
            $filterText[] = "Kategori: " . htmlspecialchars($kat['nama_kategori']);
            break;
          }
        }
      }
      if (!empty($lokasi) && $lokasi !== 'all') {
        if ($resultLokasi) mysqli_data_seek($resultLokasi, 0); // Reset pointer
        while($lok = mysqli_fetch_assoc($resultLokasi)) {
          if ($lok['id_lokasi'] == $lokasi) {
            $filterText[] = "Lokasi: " . htmlspecialchars($lok['nama_lokasi']);
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

  <section class="container">
    <div class="section-heading">
      <h2>
        <?php if ((!empty($kategori) && $kategori !== 'all') || (!empty($lokasi) && $lokasi !== 'all')): ?>
          Hasil Pencarian
        <?php else: ?>
          Destinasi Populer
        <?php endif; ?>
      </h2>
      <p>
        <?php if ((!empty($kategori) && $kategori !== 'all') || (!empty($lokasi) && $lokasi !== 'all')): ?>
          Destinasi wisata yang sesuai dengan filter yang dipilih
        <?php else: ?>
          Temukan destinasi wisata terpopuler yang wajib dikunjungi di Pulau Jawa
        <?php endif; ?>
      </p>
    </div>

    <?php if ($result && mysqli_num_rows($result) > 0): ?>
    <div class="destinations-grid">
      <?php mysqli_data_seek($result, 0); // Pastikan pointer di awal sebelum loop kartu ?>
      <?php while($row = mysqli_fetch_assoc($result)): ?>
        <?php
            // Cek apakah wisata ini ada di wishlist pengguna
            $is_in_wishlist = in_array($row['id_wisata'], $user_wishlist_ids);
            $wishlist_icon_class = $is_in_wishlist ? 'fas fa-heart' : 'far fa-heart';
            $wishlist_button_class = $is_in_wishlist ? 'active' : '';
        ?>
        <div class="destination-card">
          <div class="card-image">
            <img src="<?= htmlspecialchars(str_replace('../', './', $row['url'] ?? 'https://via.placeholder.com/300x200?text=No+Image')); ?>" 
     alt="<?= htmlspecialchars($row['nama_wisata']); ?>" 
     onerror="this.src='https://via.placeholder.com/300x200?text=No+Image'">

            <button class="wishlist-button <?= $wishlist_button_class ?>" data-wisata-id="<?= $row['id_wisata']; ?>" title="Tambahkan ke Wishlist">
              <i class="<?= $wishlist_icon_class ?>"></i>
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
                  $stars_filled = round($rating);
                  for ($i = 1; $i <= 5; $i++) {
                    echo ($i <= $stars_filled) ? '<i class="fas fa-star"></i>' : '<i class="far fa-star"></i>';
                  }
                ?>
              </div>
              <div class="count">(<?= (int)($row['jumlah_ulasan'] ?? 0); ?> ulasan)</div>
            </div>
            <div class="card-description">
              <?= htmlspecialchars(substr($row['deskripsi_wisata'] ?? '', 0, 100)); ?>
              <?= (strlen($row['deskripsi_wisata'] ?? '') > 100) ? '...' : '' ?>
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
    
    <div class="pagination-info">
      Menampilkan <?= (($page - 1) * $limit) + 1; ?> - <?= min($page * $limit, $totalData); ?> dari <?= $totalData; ?> destinasi
    </div>
    
    <?php if ($totalPages > 1): ?>
    <div class="pagination">
      <?php if ($page > 1): ?>
        <a href="<?= buildPaginationUrl($page - 1, $kategori, $lokasi); ?>" title="Halaman Sebelumnya"><i class="fas fa-chevron-left"></i></a>
      <?php else: ?>
        <span class="disabled"><i class="fas fa-chevron-left"></i></span>
      <?php endif; ?>

      <?php
      $start_page = max(1, $page - 2);
      $end_page = min($totalPages, $page + 2);
      if ($page <= 3) $end_page = min($totalPages, 5);
      if ($page > $totalPages - 3) $start_page = max(1, $totalPages - 4);

      if ($start_page > 1): ?>
        <a href="<?= buildPaginationUrl(1, $kategori, $lokasi); ?>">1</a>
        <?php if ($start_page > 2): ?><span class="page-dots">...</span><?php endif; ?>
      <?php endif; ?>

      <?php for ($i = $start_page; $i <= $end_page; $i++): ?>
        <?php if ($i == $page): ?>
          <span class="current"><?= $i; ?></span>
        <?php else: ?>
          <a href="<?= buildPaginationUrl($i, $kategori, $lokasi); ?>"><?= $i; ?></a>
        <?php endif; ?>
      <?php endfor; ?>

      <?php if ($end_page < $totalPages): ?>
        <?php if ($end_page < $totalPages - 1): ?><span class="page-dots">...</span><?php endif; ?>
        <a href="<?= buildPaginationUrl($totalPages, $kategori, $lokasi); ?>"><?= $totalPages; ?></a>
      <?php endif; ?>

      <?php if ($page < $totalPages): ?>
        <a href="<?= buildPaginationUrl($page + 1, $kategori, $lokasi); ?>" title="Halaman Selanjutnya"><i class="fas fa-chevron-right"></i></a>
      <?php else: ?>
        <span class="disabled"><i class="fas fa-chevron-right"></i></span>
      <?php endif; ?>
    </div>
    <?php endif; ?>

    <?php else: ?>
    <div class="no-results">
      <i class="fas fa-search"></i>
      <h3>Tidak ada destinasi ditemukan</h3>
      <p>Coba ubah filter atau reset untuk melihat semua destinasi.</p>
      <a href="?" class="card-button" style="margin-top: 1rem;">
        <i class="fas fa-sync-alt"></i> Lihat Semua Destinasi
      </a>
    </div>
    <?php endif; ?>
  </section>

<section class="categories-section">
  <div class="container">
    <div class="section-heading">
      <h2>Kategori Populer</h2>
      <p>Temukan berbagai jenis destinasi wisata sesuai dengan minat perjalanan Anda</p>
    </div>
    <div class="categories-container">
      <?php
      if ($resultKategoriCount && mysqli_num_rows($resultKategoriCount) > 0) {
        while ($row = mysqli_fetch_assoc($resultKategoriCount)) {
          $idKategori = $row['id_kategori'];
          $namaKategori = $row['nama_kategori'];
          $jumlahDestinasi = $row['jumlah_destinasi'];
          $ikon = '<i class="fas fa-map-marked-alt"></i>';
          if (stripos($namaKategori, "Pantai") !== false) $ikon = '<i class="fas fa-umbrella-beach"></i>';
          elseif (stripos($namaKategori, "Hiburan") !== false) $ikon = '<i class="fas fa-theater-masks"></i>'; // FontAwesome 5
          elseif (stripos($namaKategori, "Budaya") !== false || stripos($namaKategori, "Sejarah") !== false) $ikon = '<i class="fas fa-landmark"></i>';
          elseif (stripos($namaKategori, "Alam") !== false) $ikon = '<i class="fas fa-tree"></i>';
          elseif (stripos($namaKategori, "Religi") !== false) $ikon = '<i class="fas fa-place-of-worship"></i>'; // FontAwesome 5 for mosque etc
          
          echo '
          <div class="category-card" onclick="window.location.href=\'?kategori=' . $idKategori . '\'">
            <div class="category-icon">' . $ikon . '</div>
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
        const wisataId = this.dataset.wisataId;
        const icon = this.querySelector('i');

        // Cek apakah pengguna sudah login (dari PHP via variabel global JS jika perlu, atau minta login)
        <?php if (!isset($_SESSION['user']['id_pengunjung'])): ?>
            alert('Anda harus login untuk menggunakan fitur wishlist.');
            // window.location.href = 'login.php'; // Arahkan ke halaman login
            return;
        <?php endif; ?>

        // Kirim request ke backend
        fetch('./backend/wishlist_handler.php', { // Pastikan path ini benar
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
          },
          body: 'id_wisata=' + wisataId
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            if (data.status === 'added') {
              this.classList.add('active');
              icon.classList.remove('far');
              icon.classList.add('fas');
            } else if (data.status === 'removed') {
              this.classList.remove('active');
              icon.classList.remove('fas');
              icon.classList.add('far');
            }
            // Mungkin update jumlah wishlist di navbar jika ada
          } else {
            alert('Error: ' + (data.message || 'Gagal memproses wishlist.'));
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('Terjadi kesalahan koneksi saat memproses wishlist.');
        });
      });
    });

    // Search functionality (Hero)
    const searchInputHero = document.getElementById('searchInput'); // Ganti selector jika perlu
    const searchButtonHero = document.getElementById('searchButton'); // Ganti selector jika perlu
    
    if(searchButtonHero && searchInputHero) {
        searchButtonHero.addEventListener('click', function(e) {
            e.preventDefault();
            const searchValue = searchInputHero.value.trim();
            if (searchValue) {
                window.location.href = '?search=' + encodeURIComponent(searchValue); // Ubah ke URL pencarian yang sesuai
            }
        });

        searchInputHero.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                searchButtonHero.click();
            }
        });
    }
    
    // Auto-submit form when filter changes (optional)
    const filterSelects = document.querySelectorAll('.filter-select');
    filterSelects.forEach(select => {
      select.addEventListener('change', function() {
        // this.form.submit(); // Uncomment jika ingin auto-submit
      });
    });
  });
  </script>
</body>
</html>