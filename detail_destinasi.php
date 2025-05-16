<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Detail Wisata - Gunung Bromo</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./CSS/detail_destinasi.css" />  
</head>
<body>
<?php include 'Komponen/navbar.php'; ?>

<header class="hero">
  <div class="hero-text">
    <h1>Gunung Bromo</h1>
    <p>Keajaiban Alam di Jawa Timur</p>
  </div>
</header>

<div class="container">
  <!-- Left Column -->
  <div class="left-column">
    <div class="gallery">
      <img src="./Gambar/bromo.jpg" alt="Sunrise di Bromo">
      <img src="./Gambar/bromo.jpg" alt="Kawah Bromo">
      <img src="./Gambar/bromo.jpg" alt="Kabut di Bromo">
      <img src="./Gambar/bromo.jpg" alt="Kuda di Bromo">
      <img src="./Gambar/bromo.jpg" alt="Pemandangan Bromo">
      <img src="./Gambar/bromo.jpg" alt="Gunung Bromo">
    </div>

    <div class="section">
      <h3>Tentang Gunung Bromo</h3>
      <p class="deskripsi">Gunung Bromo adalah salah satu destinasi wisata paling ikonik di Indonesia yang terletak di Jawa Timur. Kawasan ini terkenal dengan pemandangan matahari terbitnya yang spektakuler dan lautan pasir yang luas. Gunung Bromo berada di dalam kawasan Taman Nasional Bromo Tengger Semeru dengan ketinggian 2.329 meter di atas permukaan laut.</p>
      <p class="deskripsi">Kawah aktif dengan asap belerang yang mengepul menjadi daya tarik tersendiri bagi para wisatawan. Selain itu, wisatawan dapat menikmati keindahan alam sambil menunggang kuda melintasi lautan pasir atau menjelajahi kawah yang aktif. Kawasan ini juga memiliki nilai spiritual bagi masyarakat Tengger yang tinggal di sekitar kaki gunung.</p>
    </div>

    <div class="section">
      <h3>Apa yang bisa dilakukan</h3>
      <div class="activities">
        <div class="activity"><i class="fas fa-sun"></i> <span>Berburu Sunrise di Penanjakan</span></div>
        <div class="activity"><i class="fas fa-hiking"></i> <span>Mendaki Gunung Bromo</span></div>
        <div class="activity"><i class="fas fa-camera"></i> <span>Fotografi Lanskap</span></div>
        <div class="activity"><i class="fas fa-horse"></i> <span>Menunggang Kuda di Lautan Pasir</span></div>
        <div class="activity"><i class="fas fa-mountain"></i> <span>Melihat Kawah Aktif</span></div>
        <div class="activity"><i class="fas fa-history"></i> <span>Mengunjungi Pura Luhur Poten</span></div>
      </div>
    </div>

    <div class="section">
      <h3>Rating & Ulasan</h3>
      <div class="review">
        <div class="name">Joko Anwar</div>
        <div class="stars">★★★★★</div>
        <div class="comment">Pengalaman luar biasa! Pemandangan sunrise-nya menakjubkan. Sangat direkomendasikan untuk datang lebih awal dan menikmati kawasan ini di pagi hari.</div>
      </div>
      <div class="review">
        <div class="name">Dina Aprilia</div>
        <div class="stars">★★★★☆</div>
        <div class="comment">Tempat bagus tapi jalan menuju ke sana cukup menantang. Pastikan untuk membawa jaket tebal karena suhu bisa mencapai 5°C di pagi hari.</div>
      </div>
      <div class="review">
        <div class="name">Suci Rahma</div>
        <div class="stars">★★★★★</div>
        <div class="comment">Sangat recommended untuk liburan keluarga dan pecinta alam. Saya sangat terkesan dengan keramahan penduduk lokal dan keindahan alam yang tiada duanya.</div>
      </div>
    </div>
  </div>

  <!-- Right Column -->
  <div class="right-column">
    <div class="info-box">
      <h4>Informasi Singkat</h4>
      <ul>
        <li>✔️ Waktu Terbaik: April-Oktober (Musim Kemarau)</li>
        <li>✔️ Rekomendasi Kunjungan: 2-3 hari</li>
        <li>✔️ Ketinggian: 2.329m</li>
        <li>✔️ Status: Gunung Berapi Aktif</li>
        <li>✔️ Tiket Masuk: Rp 27.500 - 32.500 (WNI), Rp 220.000 - 320.000 (WNA)</li>
        <li>✔️ Jam Buka: 24 Jam</li>
      </ul>
    </div>

    <div class="location-box">
      <h4>Lokasi</h4>
      <iframe
        class="map"
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3955.663042383319!2d112.9535033!3d-7.9424934!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7882f3df30c62f%3A0x8a64ad31d8be1575!2sGunung%20Bromo!5e0!3m2!1sen!2sid!4v1615462118306!5m2!1sen!2sid"
        allowfullscreen=""
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade">
      </iframe>
      <p style="margin-top: 10px; font-size: 14px;">Taman Nasional Bromo Tengger Semeru, Jawa Timur, Indonesia</p>
    </div>

    <div class="related-box">
      <h4>Wisata Terdekat</h4>
      <ul>
        <li>Gunung Semeru</li>
        <li>Air Terjun Madakaripura</li>
        <li>Bukit Teletubbies</li>
        <li>Gunung Penanjakan</li>
        <li>Ranu Kumbolo</li>
      </ul>
    </div>
    
    <div class="info-box" style="margin-top: 20px;">
      <h4>Tips Berkunjung</h4>
      <ul>
        <li>✔️ Datang sebelum jam 4 pagi untuk melihat sunrise</li>
        <li>✔️ Bawa jaket tebal karena suhu bisa sangat dingin</li>
        <li>✔️ Sewa jeep untuk akses yang lebih mudah</li>
        <li>✔️ Sediakan masker untuk debu dan bau belerang</li>
      </ul>
    </div>
  </div>
</div>

<?php include 'Komponen/footer.php'; ?>
</body>
</html>