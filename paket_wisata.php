<?php
include "Komponen/navbar.php";
include "backend/koneksi.php";

// Get filter options
$wilayah = "SELECT * FROM wilayah";
$result_wilayah = mysqli_query($conn, $wilayah);

$jenis_paket = "SELECT * FROM jenis_paket";
$result_jenis_paket = mysqli_query($conn, $jenis_paket);

$kategori = "SELECT * FROM kategori_wisata";
$result_kategori = mysqli_query($conn, $kategori);

// Get all packages with related data
$paket_wisata = "SELECT pw.*, w.nama_wisata, w.kategori_id, kw.nama_kategori, 
                jp.jenis_paket, wy.nama_wilayah 
                FROM paket_wisata pw
                JOIN wisata w ON pw.id_wisata = w.id_wisata
                JOIN kategori_wisata kw ON w.kategori_id = kw.id_kategori
                JOIN jenis_paket jp ON pw.id_jenis_paket = jp.id_jenis_paket
                JOIN wilayah wy ON pw.id_wilayah = wy.id_wilayah";
$result_paket_wisata = mysqli_query($conn, $paket_wisata);

// Count total packages
$total_packages = mysqli_num_rows($result_paket_wisata);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Paket Wisata</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="stylesheet" href="CSS/paket_wisata.css">
</head>
<body>
  <!-- Hero Section -->
  <section class="hero">
    <h1>Paket Wisata</h1>
    <p>Pilih berdasarkan Wilayah, Harga, Jenis Paket dan Kategori</p>
  </section>

  <!-- Filter Section -->
  <section class="filter-section">
    <div class="filter-container">
      <div class="filter-group">
        <div class="filter-label">Wilayah:</div>
        <select id="wilayah" class="filter-select">
          <option value="all">Semua Wilayah</option>
          <?php while ($row = mysqli_fetch_assoc($result_wilayah)) { ?>
            <option value="<?php echo $row['id_wilayah']; ?>">
              <?php echo $row['nama_wilayah']; ?>
            </option>
          <?php } ?>
        </select>
      </div>
      <div class="filter-group">
        <div class="filter-label">Kategori:</div>
        <select id="kategori" class="filter-select">
          <option value="all">Semua Kategori</option>
          <?php while ($row = mysqli_fetch_assoc($result_kategori)) { ?>
            <option value="<?php echo $row['id_kategori']; ?>">
              <?php echo $row['nama_kategori']; ?>
            </option>
          <?php } ?>
        </select>
      </div>
      <div class="filter-group">
        <div class="filter-label">Jenis Paket:</div>
        <select id="jenis" class="filter-select">
          <option value="all">Semua Jenis</option>
          <?php while ($row = mysqli_fetch_assoc($result_jenis_paket)) { ?>
            <option value="<?php echo $row['id_jenis_paket']; ?>">
              <?php echo $row['jenis_paket']; ?>
            </option>
          <?php } ?>
        </select>
      </div>
      <div class="filter-group">
        <div class="filter-label">Harga Maks:</div>
        <input type="number" id="maxHarga" class="filter-input" placeholder="Rp">
      </div>
      <div class="filter-group">
        <button class="filter-button" onclick="applyFilters()">Terapkan Filter</button>
      </div>
    </div>
  </section>

  <!-- Featured Packages -->
  <section class="container">
    <div class="section-heading">
      <h2>Paket Wisata Populer</h2>
      <p>Temukan paket wisata terbaik sesuai dengan budget dan preferensi Anda</p>
    </div>

    <div class="results-counter" id="resultsCounter">
      Menampilkan <span id="resultCount"><?php echo $total_packages; ?></span> paket wisata
    </div>

    <div id="paketContainer" class="paket-grid">
      <?php 
      // Reset pointer for packages
      mysqli_data_seek($result_paket_wisata, 0);
      
      while ($row = mysqli_fetch_assoc($result_paket_wisata)) { 
        // Get first image for this wisata
        $img_query = "SELECT url FROM gambar WHERE wisata_id = " . $row['id_wisata'] . " LIMIT 1";
        $img_result = mysqli_query($conn, $img_query);
        $img_row = mysqli_fetch_assoc($img_result);
        $image_url = $img_row ? $img_row['url'] : 'https://via.placeholder.com/300x200';
      ?>
      <div class="paket-card <?php echo strtolower($row['nama_wilayah']); ?> <?php echo strtolower($row['nama_kategori']); ?> <?php echo strtolower($row['jenis_paket']); ?>" 
           data-harga="<?php echo $row['harga']; ?>"
           data-wilayah="<?php echo $row['id_wilayah']; ?>"
           data-kategori="<?php echo $row['kategori_id']; ?>"
           data-jenis="<?php echo $row['id_jenis_paket']; ?>">
        <div class="card-image">
          <img src="<?php echo $image_url; ?>" alt="<?php echo $row['nama_wisata']; ?>">
          <div class="card-badge <?php echo strtolower($row['jenis_paket']); ?>">
            <?php echo $row['jenis_paket']; ?>
          </div>
        </div>
        <div class="card-content">
          <h3><?php echo $row['nama_paket']; ?></h3>
          <div class="card-location">
            <i class="fas fa-map-marker-alt"></i> <?php echo $row['nama_wilayah']; ?>
          </div>
          <div class="card-meta">
            <div class="card-price">Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></div>
            <div class="card-category"><?php echo $row['nama_kategori']; ?></div>
          </div>
          <button class="detail-button" onclick="viewDetail(<?php echo $row['id_paket_wisata']; ?>)">
            <i class="fas fa-eye"></i>
            Lihat Detail
          </button>
        </div>
      </div>
      <?php } ?>

      <div class="no-results hidden" id="noResults">
        <i class="fas fa-binoculars"></i>
        <h3>Maaf, tidak ada paket yang ditemukan</h3>
        <p>Coba sesuaikan filter pencarian Anda</p>
      </div>
    </div>
  </section>
  
  <?php include "Komponen/footer.php"; ?>
  
  <script>
    function applyFilters() {
      const wilayah = document.getElementById('wilayah').value;
      const kategori = document.getElementById('kategori').value;
      const jenis = document.getElementById('jenis').value;
      const maxHarga = document.getElementById('maxHarga').value;
      const cards = document.querySelectorAll('.paket-card');
      let visibleCount = 0;

      cards.forEach(card => {
        const cardWilayah = card.dataset.wilayah;
        const cardKategori = card.dataset.kategori;
        const cardJenis = card.dataset.jenis;
        const cardHarga = parseInt(card.dataset.harga);

        const wilayahMatch = wilayah === 'all' || cardWilayah === wilayah;
        const kategoriMatch = kategori === 'all' || cardKategori === kategori;
        const jenisMatch = jenis === 'all' || cardJenis === jenis;
        const hargaMatch = !maxHarga || cardHarga <= maxHarga;

        if (wilayahMatch && kategoriMatch && jenisMatch && hargaMatch) {
          card.style.display = 'block';
          visibleCount++;
        } else {
          card.style.display = 'none';
        }
      });

      document.getElementById('resultCount').textContent = visibleCount;
      document.getElementById('noResults').classList.toggle('hidden', visibleCount > 0);
    }

    function viewDetail(paketId) {
      window.location.href = `paket_wisata_detail.php?id=${paketId}`;
    }

    // Initialize filters on page load
    document.addEventListener('DOMContentLoaded', applyFilters);
  </script>
</body>
</html>