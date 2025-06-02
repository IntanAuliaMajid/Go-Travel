<?php 
include 'Komponen/navbar.php'; 
include './backend/koneksi.php';

$id_wisata = $_GET['id'];

$query = "SELECT * FROM wisata WHERE id_wisata = $id_wisata";
$queryGambar = "SELECT * FROM gambar WHERE wisata_id = $id_wisata";
// Eksekusi query untuk mendapatkan data wisata
$resultGambar = mysqli_query($conn, $queryGambar);
$result = mysqli_query($conn, $query);
$destinasi = mysqli_fetch_assoc($result);

$aktivitas = $destinasi['todo'];
// Pecah berdasarkan koma
$list = explode(",", $aktivitas);

$ulasan = "SELECT pengunjung.id_pengunjung,pengunjung.nama_depan,pengunjung.nama_belakang,ulasan.rating,ulasan.komentar FROM ulasan JOIN pengunjung ON ulasan.id_pengunjung = pengunjung.id_pengunjung WHERE ulasan.id_wisata = $id_wisata";
$resultUlasan = mysqli_query($conn, $ulasan);


?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Detail Wisata - <?= $destinasi['nama_wisata'] ?></title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="./CSS/detail_destinasi.css" />  
</head>
<body>

<header class="hero">
  <div class="hero-overlay"></div>
  <div class="hero-content">
    <h1><?= $destinasi['nama_wisata'] ?></h1>
    <p class="hero-subtitle">Keajaiban Alam di Jawa Timur</p>
  </div>
</header>

<main class="container">
  <!-- Main Content Column -->
  <div class="main-content">
    <div class="gallery-section">
      <div class="gallery-grid">
        <?php while ($gambar = mysqli_fetch_assoc($resultGambar)) { ?>
          <img src="<?= $gambar['url'] ?>" alt="<?= $destinasi['nama_wisata'] ?>" class="gallery-image">
        <?php } ?>
      </div>
    </div>

    <section class="content-section about-section">
      <h2 class="section-title">Tentang <?= $destinasi['nama_wisata'] ?></h2>
      <p class="section-description"><?= $destinasi['deskripsi_wisata'] ?></p>
    </section>

    <section class="content-section activities-section">
      <h2 class="section-title">Aktivitas di <?= $destinasi['nama_wisata'] ?></h2>
      <div class="activities-grid">
        <?php foreach ($list as $item) { 
          $item = trim($item);
          $itemFormatted = ucwords($item); ?>
          <div class="activity-card">
            <i class="fas fa-check-circle activity-icon"></i>
            <span class="activity-text"><?= $itemFormatted ?></span>
          </div>
        <?php } ?>
      </div>
    </section>

    <section class="content-section reviews-section">
      <h2 class="section-title">Ulasan Pengunjung</h2>
      <div class="reviews-container">
        <?php while ($row = mysqli_fetch_assoc($resultUlasan)) { ?>
        <div class="review-card">
          <div class="review-header">
            <h4 class="reviewer-name"><?= $row['nama_depan'] . ' ' . $row['nama_belakang'] ?></h4>
            <div class="review-rating">
              <?= str_repeat('★', $row['rating']) . str_repeat('☆', 5 - $row['rating']) ?>
            </div>
          </div>
          <p class="review-comment"><?= $row['komentar'] ?></p>
        </div>
        <?php } ?>
      </div>
    </section>

    <section class="content-section review-form-section">
      <h2 class="section-title">Berikan Ulasan Anda</h2>
      <form action="./backend/proses_ulasan.php" method="post" class="review-form">
        <!-- <div class="form-group">
          <label for="nama" class="form-label">Nama Lengkap</label>
          <input type="text" id="nama" name="nama" class="form-input" required>
        </div> -->

        <div class="form-group">
          <label for="rating" class="form-label">Rating</label>
          <select id="rating" name="rating" class="form-select" required>
            <option value="" disabled selected>Pilih Rating</option>
            <option value="5">★★★★★ - Luar Biasa</option>
            <option value="4">★★★★☆ - Bagus</option>
            <option value="3">★★★☆☆ - Cukup</option>
            <option value="2">★★☆☆☆ - Kurang</option>
            <option value="1">★☆☆☆☆ - Buruk</option>
          </select>
        </div>

        <div class="form-group">
          <label for="komentar" class="form-label">Komentar</label>
          <textarea id="komentar" name="komentar" rows="5" class="form-textarea"></textarea>
        </div>
        <input type="hidden" name="id_wisata" value="<?= $id_wisata ?>">

        <button type="submit" class="submit-button">
          <i class="fas fa-paper-plane"></i> Kirim Ulasan
        </button>
      </form>
    </section>
  </div>

  <!-- Sidebar Column -->
  <aside class="sidebar">
    <div class="info-card">
      <h3 class="card-title">Informasi Wisata</h3>
      <ul class="info-list">
        <li class="info-item">
          <i class="fas fa-clock info-icon"></i>
          <span>Waktu Terbaik: Pagi hari</span>
        </li>
        <li class="info-item">
          <i class="fas fa-calendar-day info-icon"></i>
          <span>Durasi Kunjungan: 2-3 hari</span>
        </li>
        <li class="info-item">
          <i class="fas fa-ticket-alt info-icon"></i>
          <span>Tiket Masuk: Rp 30.000</span>
        </li>
        <li class="info-item">
          <i class="fas fa-door-open info-icon"></i>
          <span>Jam Buka: 08.00 - 17.00 WIB</span>
        </li>
      </ul>
    </div>

    <div class="location-card">
      <h3 class="card-title"><i class="fas fa-map-marker-alt location-icon"></i> Denah </h3>
      <div class="map-container">
        <img src="<?php echo $destinasi['denah']; ?>" alt="Peta Lokasi" class="map-image">
      </div>
      <p class="location-address">
        <?php echo $destinasi['Alamat']; ?>
      </p>
    </div>

    <div class="related-card">
      <h3 class="card-title">Wisata Terdekat</h3>
      <ul class="related-list">
        <li class="related-item">
          <i class="fas fa-umbrella-beach related-icon"></i>
          Wisata Bahari Lamongan
        </li>
        <li class="related-item">
          <i class="fas fa-water related-icon"></i>
          Pantai Maldives Kemantren
        </li>
        <li class="related-item">
          <i class="fas fa-resort related-icon"></i>
          Tanjung Kodok Beach Resort
        </li>
        <li class="related-item">
          <i class="fas fa-paw related-icon"></i>
          Maharani Zoo & Goa
        </li>
        <li class="related-item">
          <i class="fas fa-sun related-icon"></i>
          Pantai Lorena
        </li>
      </ul>
    </div>
    
    <div class="tips-card">
      <h3 class="card-title">Tips Berkunjung</h3>
      <ul class="tips-list">
        <li class="tips-item">
          <i class="fas fa-lightbulb tips-icon"></i>
          Datang lebih awal untuk menghindari keramaian
        </li>
        <li class="tips-item">
          <i class="fas fa-tshirt tips-icon"></i>
          Kenakan pakaian yang nyaman
        </li>
        <li class="tips-item">
          <i class="fas fa-swimming-pool tips-icon"></i>
          Bawa perlengkapan renang
        </li>
        <li class="tips-item">
          <i class="fas fa-wallet tips-icon"></i>
          Siapkan uang tunai atau kartu
        </li>
      </ul>
    </div>
  </aside>
</main>

<?php include 'Komponen/footer.php'; ?>
</body>
</html>