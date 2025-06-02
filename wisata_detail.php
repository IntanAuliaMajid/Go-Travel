<?php 
include 'Komponen/navbar.php'; 
$query = "SELECT * FROM destinasi WHERE id = $_POST['id_wisata']";
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Detail Wisata - Pantai Tanjung Kodok</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./CSS/detail_destinasi.css" />  
</head>
<body>


<header class="hero">
  <div class="hero-text">
    <h1>Pantai Tanjung Kodok</h1>
    <p>Keajaiban Alam di Jawa Timur</p>
  </div>
</header>

<div class="container">
  <!-- Left Column -->
  <div class="left-column">
    <div class="gallery">
      <img src="https://1.bp.blogspot.com/-9xf_ASpphxM/TrvDC4Tch-I/AAAAAAAABMc/RExb1UrDcwQ/s1600/tanjung%2Bkodok.JPG" alt="">
      <img src="https://nativeindonesia.com/wp-content/uploads/2021/08/Pantai-Tanjung-Kodok.jpg" alt="">
      <img src="https://www.nativeindonesia.com/foto/2024/07/pantai-tanjung-kodok-1.jpg" alt="">
      <img src="https://www.nativeindonesia.com/foto/2024/07/wisata-pantai-tanjung-kodok.jpg" alt="">
      <img src="https://cdn.idntimes.com/content-images/community/2022/11/149402858-1534426486747158-1924235549356764180-n-74a5bbce32d431e2700b8e2b2284983e-f213f7f31db44e837aedc4a3b7e6ec0c.jpg" alt="">
      <img src="https://www.nativeindonesia.com/foto/2024/07/sunset-di-pantai-tanjung-kodok.jpg" alt=""> 
    </div>

    <div class="section">
      <h3>Tentang Pantai Tanjung Kodok</h3>
      <p class="deskripsi">Selamat datang di Pantai Tanjung Kodok, sebuah permata tersembunyi di pesisir utara Lamongan, Jawa Timur. Pantai ini menawarkan pesona alam yang unik dengan formasi batu karang menyerupai kodok raksasa, yang menjadi ciri khas dan asal namanya.</p>
      <p class="deskripsi">Pantai Tanjung Kodok memanjakan pengunjung dengan hamparan pasir putih yang lembut dan air laut yang jernih, mengundang Anda untuk bersantai, berjemur, atau bermain air. Deburan ombak yang tenang menciptakan suasana yang damai dan menenangkan, menjauhkan Anda dari hiruk pikuk kehidupan kota.</p>
      <p class="deskripsi">Keunikan utama pantai ini terletak pada gugusan batu karang yang tersebar di sepanjang garis pantai. Salah satu batu karang yang paling ikonik adalah yang berbentuk seperti kodok sedang beristirahat, menjadi daya tarik utama bagi para wisatawan dan fotografer. Anda dapat menjelajahi area ini saat air surut dan mengabadikan momen yang tak terlupakan.</p>
      <p class="deskripsi">Selain keindahan formasi batu karangnya, Pantai Tanjung Kodok juga menawarkan pemandangan matahari terbenam yang spektakuler. Langit yang berwarna-warni menjadi latar belakang yang sempurna untuk siluet batu kodok, menciptakan suasana romantis dan magis.</p>
    </div>

    <div class="section">
      <h3>Apa yang bisa dilakukan</h3>
      <div class="activities">
        <div class="activity"><i class="fas fa-sun"></i> <span>Menikmati Pemandangan Batu Karang Unik</span></div>
        <div class="activity"><i class="fas fa-hiking"></i> <span>Menikmati Sunset dan Sunrise</span></div>
        <div class="activity"><i class="fas fa-camera"></i> <span>Mengunjungi Menara Rukyat</span></div>
        <div class="activity"><i class="fas fa-horse"></i> <span>Bermain Pasir dan Aktivitas Anak-anak</span></div>
        <div class="activity"><i class="fas fa-mountain"></i> <span>Menikmati Angkringan/Musik di Malam Hari (Weekend)</span></div>
        <div class="activity"><i class="fas fa-history"></i> <span>Naik Perahu atau Kano (musiman)</span></div>
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
        <div class="comment">Tempat bagus dan suasana pantai yang masih alami di Lamongan.</div>
      </div>
      <div class="review">
        <div class="name">Suci Rahma</div>
        <div class="stars">★★★★★</div>
        <div class="comment">Sangat recommended untuk liburan keluarga dan pecinta alam. Saya sangat terkesan dengan keramahan penduduk lokal dan keindahan alam yang tiada duanya.</div>
      </div>
    </div>

  <!-- field ulasan -->
   <div class="section">
  <h3>Kirim Ulasan Anda</h3>
  <form action="#" method="post" class="review-form">
    <div class="form-group">
      <label for="nama">Nama:</label>
      <input type="text" id="nama" name="nama" required>
    </div>

    <div class="form-group">
      <label for="rating">Rating:</label>
      <select id="rating" name="rating" required>
        <option value="">Pilih Rating</option>
        <option value="5">★★★★★ - Luar Biasa</option>
        <option value="4">★★★★☆ - Bagus</option>
        <option value="3">★★★☆☆ - Cukup</option>
        <option value="2">★★☆☆☆ - Kurang</option>
        <option value="1">★☆☆☆☆ - Buruk</option>
      </select>
    </div>

    <div class="form-group">
      <label for="komentar">Komentar:</label>
      <textarea id="komentar" name="komentar" rows="4"></textarea>
    </div>

    <a href="#"><button type="submit" class="submit-btn">Kirim Ulasan</button></a>
  </form>
</div>
</div>

  <!-- Right Column -->
  <div class="right-column">
    <div class="info-box">
      <h4>Informasi Singkat</h4>
      <ul>
        <li style="margin-top:10px;">✔️ Waktu Terbaik: Pagi hari</li>
        <li>✔️ Rekomendasi Kunjungan: 2-3 hari</li>
        <li>✔️ Tiket Masuk: Rp 30.000</li>
        <li>✔️ Jam Buka: Jam 08.00 - 17.00 WIB</li>
      </ul>
    </div>

    <div class="location-box">
      <h4>Lokasi</h4>
      <img 
        class="map" 
        src="./Gambar/tanjungkodok.png" 
        alt="Peta Lokasi Pantai Tanjung Kodok" 
        width="100%" 
        height="auto">
      <p style="margin-top: 10px; font-size: 14px;">Pantai Tanjung Kodok, Labuhan, Brondong, Lamongan, Jawa Timur, Indonesia</p>
    </div>

    <div class="related-box">
      <h4>Wisata Terdekat</h4>
      <ul>
        <li>Wisata Bahari Lamongan</li>
        <li>Pantai Maldives Kemantren</li>
        <li>Tanjung Kodok Beach Resort Lamongan</li>
        <li>Maharani Zoo & Goa</li>
        <li>Pantai Lorena</li>
      </ul>
    </div>
    
    <div class="info-box" style="margin-top: 20px;">
      <h4>Tips Berkunjung</h4>
      <ul>
        <li style="margin-top:10px;">✔️ Datang lebih awal</li>
        <li>✔️ Kenakan pakaian yang nyaman dan mudah kering</li>
        <li>✔️ Bawa perlengkapan renang</li>
        <li>✔️ Siapkan uang tunai atau kartu</li>
        <li>✔️ Manfaatkan peta dan informasi</li>
        <li>✔️ Jaga barang bawaan</li>
      </ul>
    </div>
  </div>
</div>

<?php include 'Komponen/footer.php'; ?>
</body>
</html>