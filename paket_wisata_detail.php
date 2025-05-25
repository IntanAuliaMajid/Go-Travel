<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Detail Paket Wisata</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
    /* Global Styles */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', sans-serif;
    }

    body {
      background-color: #f5f5f5;
    }

    /* Hero Section */
    .detail-hero {
      background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),
                  url('https://www.ancol.com/blog/wp-content/uploads/2022/03/wisata-aquarium-di-jakarta.jpg') no-repeat center center/cover;
      height: 60vh;
      display: flex;
      align-items: flex-end;
      padding: 2rem;
      color: white;
      margin-bottom: 2rem;
    }

    .detail-container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 1rem;
    }

    .detail-main {
      display: grid;
      grid-template-columns: 1fr 350px;
      gap: 3rem;
      margin-bottom: 4rem;
    }

    /* Main Content Styles */
    .detail-image {
      border-radius: 10px;
      overflow: hidden;
      height: 400px;
    }

    .detail-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .detail-section {
      margin-bottom: 3rem;
      background: white;
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .detail-section p{
      line-height: 1.6;
      color: black;
      font-size: 0.9rem;
      margin-bottom: 1.5rem;
    }

    .detail-section h3 {
      font-size: 1.5rem;
      color: #2c7a51;
      margin-bottom: 1.5rem;
      padding-bottom: 0.5rem;
      border-bottom: 2px solid #eee;
    }

    /* Itinerary Styles */
    .itinerary-item {
      display: flex;
      gap: 1rem;
      margin-bottom: 1.5rem;
      padding: 1rem;
      background: #f7f9fc;
      border-radius: 8px;
      border-left: 4px solid #2c7a51;
    }

    .itinerary-item p {
      margin: 0;
      padding-top: 10px;
      color: black;
      font-size: 0.9rem;
    }

    .itinerary-time {
      font-weight: bold;
      min-width: 100px;
      color: #2c7a51;
    }

    .itinerary-day {
      background: #2c7a51;
      color: white;
      padding: 1rem;
      border-radius: 8px;
      text-align: center;
      font-weight: bold;
      margin: 2rem 0 1rem 0;
    }

    /* Package Details */
    .package-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 2rem;
      margin-bottom: 2rem;
    }

    .package-card {
      background: #f7f9fc;
      padding: 1.5rem;
      border-radius: 10px;
      border: 1px solid #e0e0e0;
    }

    .package-card h4 {
      color: #2c7a51;
      margin-bottom: 1rem;
      font-size: 1.2rem;
    }

    .package-card img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      border-radius: 8px;
      margin-bottom: 1rem;
    }

    .package-features {
      list-style: none;
      margin: 1rem 0;
    }

    .package-features li {
      margin-bottom: 0.5rem;
      display: flex;
      align-items: center;
    }

    .package-features li i {
      color: #2c7a51;
      margin-right: 10px;
      width: 20px;
    }

    /* Facilities Styles */
    .facilities-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
      gap: 1rem;
    }

    .facility-item {
      text-align: center;
      padding: 1rem;
      background: #f7f9fc;
      border-radius: 8px;
    }

    /* Booking Sidebar */
    .detail-info {
      background: white;
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      height: fit-content;
    }

    .detail-price {
      font-size: 2rem;
      color: #2c7a51;
      font-weight: bold;
      margin: 1.5rem 0;
    }

    .pesan-sekarang {
      width: 100%;
      display: inline-block;
      background-color: #2c7a51;
      color: white;
      padding: 1rem 2rem;
      border-radius: 5px;
      text-decoration: none;
      font-size: 1.1rem;
      text-align: center;
      transition: background-color 0.3s ease;
      border: none;
      cursor: pointer;
    }

    .pesan-sekarang:hover {
      background-color: #1e5a3a;
    }

    /* Map Section */
    .map-container {
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      margin-top: 1rem;
    }

    .map-container img {
      width: 100%;
      height: auto;
      display: block;
      border-radius: 8px;
    }

    .location-details {
      margin-top: 1rem;
      padding: 1rem;
      background: #f7f9fc;
      border-radius: 8px;
    }

    .location-item {
      display: flex;
      align-items: center;
      margin-bottom: 0.6rem;
    }

    .location-item i {
      color: #2c7a51;
      margin-right: 10px;
      width: 20px;
      text-align: center;
    }

    /* Reviews Section */
    .reviews-section {
      background: #f7f9fc;
      padding: 2rem;
      border-radius: 10px;
    }

    .review-item {
      background: white;
      padding: 1.5rem;
      border-radius: 8px;
      margin-bottom: 1.5rem;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .review-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 1rem;
    }

    .review-author {
      font-weight: bold;
      color: #2c7a51;
    }

    .review-date {
      color: #666;
      font-size: 0.9rem;
    }

    .rating-stars {
      color: #ffd700;
      margin: 0.5rem 0;
    }

    .rating-stars .fas {
      margin-right: 3px;
    }

    .add-review {
      margin-top: 2rem;
      border-top: 2px solid #eee;
      padding-top: 2rem;
    }

    .review-form textarea {
      width: 100%;
      padding: 1rem;
      border: 1px solid #ddd;
      border-radius: 5px;
      margin: 1rem 0;
      height: 100px;
      resize: vertical;
    }

    /* Transport & Guide Section */
    .transport-guide {
      display: flex;
      gap: 2rem;
      margin-top: 1.5rem;
    }

    .transport-card, .guide-card {
      flex: 1;
      background: #f7f9fc;
      padding: 1.5rem;
      border-radius: 10px;
      border: 1px solid #e0e0e0;
    }

    .transport-card h4, .guide-card h4 {
      color: #2c7a51;
      margin-bottom: 1rem;
      font-size: 1.2rem;
      display: flex;
      align-items: center;
    }

    .transport-card h4 i, .guide-card h4 i {
      margin-right: 10px;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      .detail-main {
        grid-template-columns: 1fr;
      }
      
      .detail-info {
        order: -1;
      }
      
      .detail-hero {
        height: 50vh;
        padding: 1.5rem;
      }

      .package-grid {
        grid-template-columns: 1fr;
      }

      .transport-guide {
        flex-direction: column;
      }
    }
  </style>
</head>
<body>
  <?php include 'Komponen/navbar.php'; ?>

  <!-- Hero Section -->
  <section class="detail-hero">
    <div class="detail-container">
      <h1>Paket Wisata Ancol Taman Impian 2D1N</h1>
      <div class="card-location">
        <i class="fas fa-map-marker-alt"></i> Jakarta, Jakarta Utara
      </div>
    </div>
  </section>

  <main class="detail-container">
    <div class="detail-main">
      <!-- Main Content -->
      <div>
        <!-- Deskripsi -->
        <div class="detail-section">
          <h3>Deskripsi Paket Wisata</h3>
          <p>Nikmati pengalaman lengkap berlibur di Ancol Taman Impian dengan paket 2 hari 1 malam yang sudah termasuk penginapan di hotel berbintang, makanan, dan akses ke semua wahana utama. Paket ini dirancang khusus untuk memberikan pengalaman liburan yang tak terlupakan bersama keluarga dengan kenyamanan maksimal tanpa perlu repot mengatur akomodasi dan transportasi.</p>
          
          <!-- Transportasi & Pemandu Wisata -->
          <div class="transport-guide">
            <div class="transport-card">
              <h4><i class="fas fa-bus"></i> Kendaraan yang Digunakan</h4>
              <p>Paket ini menggunakan kendaraan Toyota Hiace Commuter (kapasitas 10-12 orang) atau bus medium (kapasitas 25-30 orang) tergantung jumlah peserta. Semua kendaraan ber-AC, bersih, dan terawat dengan baik. Dilengkapi dengan sound system untuk hiburan selama perjalanan.</p>
              <div style="margin-top: 1rem;">
                <img src="https://th.bing.com/th/id/OIP.e5dFblG5uR4xQ6nU2lFh-AHaFj?cb=iwc2&rs=1&pid=ImgDetMain" alt="Toyota Hiace" style="width:100%; border-radius:8px;">
              </div>
            </div>
            
            <div class="guide-card">
              <h4><i class="fas fa-user-tie"></i> Pemandu Wisata</h4>
              <p>Dipandu oleh pemandu wisata profesional berpengalaman (Tour Guide) yang ramah, komunikatif, dan menguasai area wisata. Pemandu kami tersertifikasi dan akan menemani Anda selama kegiatan wisata berlangsung.</p>
              <div style="margin-top: 1rem; display:flex; align-items:center; gap:1rem;">
                <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Tour Guide" style="width:80px; height:80px; border-radius:50%; object-fit:cover; border:3px solid #2c7a51;">
                <div>
                  <strong>Bapak Agus Setiawan</strong>
                  <p style="font-size:0.9rem; color:#555;">Tour Guide Berpengalaman 5+ tahun</p>
                  <div class="rating-stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                    <span style="color:#555; margin-left:5px;">4.7</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Penginapan & Restoran -->
        <div class="detail-section">
          <h3>Akomodasi & Kuliner</h3>
          <div class="package-grid">
            <div class="package-card">
              <h4><i class="fas fa-hotel"></i> Penginapan</h4>
              <img src="https://santika-premiere-jakarta.bookhoteljakarta.com/data/Photos/OriginalPhoto/12215/1221569/1221569074/jakarta-hotel-santika-premiere-slipi-photo-27.JPEG" alt="Hotel Santika Jakarta"></img>
              
              <h5>Hotel Santika Jakarta ★★★★</h5>
              <ul class="package-features">
                <li><i class="fas fa-bed"></i> Kamar Twin/Double Bed</li>
                <li><i class="fas fa-wifi"></i> Free WiFi</li>
                <li><i class="fas fa-swimmer"></i> Kolam Renang</li>
                <li><i class="fas fa-parking"></i> Parkir Gratis</li>
                <li><i class="fas fa-utensils"></i> Sarapan Termasuk</li>
              </ul>
            </div>

            <div class="package-card">
              <h4><i class="fas fa-utensils"></i> Paket Makan</h4>
              <img src="https://1.bp.blogspot.com/-nvYbqCj6dSo/X6pfISypJII/AAAAAAAAA6k/nhIbYVDhdY4Ajm-egTfDBk9jSeHj3nwPgCLcBGAsYHQ/w640-h424/Materismk.my.id.jpg" alt="Restoran Bandar Djakarta">
              <h5>Bandar Djakarta Restaurant</h5>
              <ul class="package-features">
                <li><i class="fas fa-check"></i> Sarapan di Hotel</li>
                <li><i class="fas fa-check"></i> Makan Siang (Seafood)</li>
                <li><i class="fas fa-check"></i> Makan Malam (Buffet)</li>
                <li><i class="fas fa-check"></i> Cemilan & Minuman</li>
              </ul>
            </div>
          </div>
        </div>

        <!-- Rencana Perjalanan -->
        <div class="detail-section">
          <h3>Rencana Perjalanan</h3>
          <div class="itinerary-container">
            
            <div class="itinerary-day">HARI 1</div>
            
            <div class="itinerary-item">
              <div class="itinerary-time">07:00</div>
              <div class="itinerary-content">
                <h4>Check-in Hotel Santika Jakarta</h4>
                <p>Tiba di hotel, proses check-in dan penyerahan kunci kamar. Sarapan pagi di restoran hotel.</p>
              </div>
            </div>
            
            <div class="itinerary-item">
              <div class="itinerary-time">09:50</div>
              <div class="itinerary-content">
                <h4>Perjalanan ke Ancol</h4>
                <p>Berangkat menuju Ancol Taman Impian dengan transportasi yang telah disediakan.</p>
              </div>
            </div>
            
            <div class="itinerary-item">
              <div class="itinerary-time">10:00 - 12:30</div>
              <div class="itinerary-content">
                <h4>Dunia Fantasi (Dufan)</h4>
                <p>Menjelajahi berbagai wahana seru di Dunia Fantasi seperti Halilintar, Niagara Gulungan, dan Istana Boneka.</p>
              </div>
            </div>
            
            <div class="itinerary-item">
              <div class="itinerary-time">12:30 - 13:30</div>
              <div class="itinerary-content">
                <h4>Makan Siang - Bandar Djakarta</h4>
                <p>Menikmati hidangan seafood segar di Restoran Bandar Djakarta yang terkenal dengan cita rasa autentik.</p>
              </div>
            </div>
            
            <div class="itinerary-item">
              <div class="itinerary-time">13:30 - 15:30</div>
              <div class="itinerary-content">
                <h4>SeaWorld & Ocean Dream Samudra</h4>
                <p>Mengunjungi SeaWorld untuk melihat berbagai biota laut dan menyaksikan pertunjukan lumba-lumba yang memukau.</p>
              </div>
            </div>
            
            <div class="itinerary-item">
              <div class="itinerary-time">15:30 - 17:30</div>
              <div class="itinerary-content">
                <h4>Atlantis Water Adventure</h4>
                <p>Bersenang-senang di waterpark dengan berbagai kolam renang dan seluncuran air yang menyegarkan.</p>
              </div>
            </div>
            
            <div class="itinerary-item">
              <div class="itinerary-time">18:00 - 19:00</div>
              <div class="itinerary-content">
                <h4>Makan Malam - Pantai Ancol</h4>
                <p>Menikmati makan malam buffet sambil menyaksikan pemandangan matahari terbenam di pantai.</p>
              </div>
            </div>
            
            <div class="itinerary-item">
              <div class="itinerary-time">20:00</div>
              <div class="itinerary-content">
                <h4>Kembali ke Hotel</h4>
                <p>Kembali ke hotel untuk istirahat dan mempersiapkan kegiatan hari berikutnya.</p>
              </div>
            </div>

            <div class="itinerary-day">HARI 2</div>
            
            <div class="itinerary-item">
              <div class="itinerary-time">07:00 - 08:00</div>
              <div class="itinerary-content">
                <h4>Sarapan di Hotel</h4>
                <p>Menikmati sarapan buffet di restoran hotel dengan menu lengkap dan bergizi.</p>
              </div>
            </div>
            
            <div class="itinerary-item">
              <div class="itinerary-time">08:00 - 10:00</div>
              <div class="itinerary-content">
                <h4>Wahana Bebas Pilihan</h4>
                <p>Waktu bebas untuk menikmati wahana favorit atau mengunjungi tempat yang belum dikunjungi.</p>
              </div>
            </div>
            
            <div class="itinerary-item">
              <div class="itinerary-time">10:00 - 11:00</div>
              <div class="itinerary-content">
                <h4>Shopping & Oleh-oleh</h4>
                <p>Berbelanja cinderamata dan oleh-oleh khas Jakarta di area Ancol.</p>
              </div>
            </div>
            
            <div class="itinerary-item">
              <div class="itinerary-time">11:00 - 12:00</div>
              <div class="itinerary-content">
                <h4>Kembali ke hotel & Melakukan Check-out</h4>
                <p>Perjalanan kembali ke hotel dan melakukan check-out.</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Denah Lokasi -->
        <div class="detail-section">
          <h3>Denah Lokasi</h3>
          <div class="map-container">
            <img src="https://pbs.twimg.com/media/C_hU0aTUIAAWeb_?format=jpg&name=900x900" alt="Peta Lokasi Ancol Taman Impian">
          </div>
          <div class="location-details">
            <div class="location-item">
              <i class="fas fa-map-marker-alt"></i>
              <span>Jl. Lodan Timur No.7, RW.10, Ancol, Kec. Pademangan, Jakarta Utara, DKI Jakarta 14430</span>
            </div>
            <div class="location-item">
              <i class="fas fa-phone"></i>
              <span>(021) 29222222</span>
            </div>
            <div class="location-item">
              <i class="fas fa-car"></i>
              <span>20 menit dari pusat kota Jakarta</span>
            </div>
            <div class="location-item">
              <i class="fas fa-hotel"></i>
              <span>Hotel Santika Jakarta - 10 menit dari Ancol</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Sidebar Booking -->
      <div class="detail-info">
        <div class="detail-meta">
          <h2>Paket Wisata 2D1N</h2>
          <div class="detail-price">Rp 850.000/orang</div>
          <div class="facility-item" style="margin:1rem 0">
            <i class="fas fa-calendar"></i> 2 Hari 1 Malam
          </div>
        </div>
        
        <h4>Paket Sudah Termasuk:</h4>
        <ul style="margin:1rem 0; list-style: none; font-size: 0.9rem;">
          <li style="margin-bottom: 0.4rem;"><i class="fas fa-check" style="color: #2c7a51; margin-right: 10px;"></i> Penginapan Hotel ★★★★</li>
          <li style="margin-bottom: 0.4rem;"><i class="fas fa-check" style="color: #2c7a51; margin-right: 10px;"></i> Transportasi AC (Toyota Hiace/Bus)</li>
          <li style="margin-bottom: 0.4rem;"><i class="fas fa-check" style="color: #2c7a51; margin-right: 10px;"></i> 3x Makan (Sarapan, Siang, Malam)</li>
          <li style="margin-bottom: 0.4rem;"><i class="fas fa-check" style="color: #2c7a51; margin-right: 10px;"></i> Tiket Masuk Semua Wahana</li>
          <li style="margin-bottom: 0.4rem;"><i class="fas fa-check" style="color: #2c7a51; margin-right: 10px;"></i> Tour Guide Berpengalaman</li>
          <li style="margin-bottom: 0.4rem;"><i class="fas fa-check" style="color: #2c7a51; margin-right: 10px;"></i> Minuman & Snack</li>
          <li style="margin-bottom: 0.4rem;"><i class="fas fa-check" style="color: #2c7a51; margin-right: 10px;"></i> Dokumentasi Foto</li>
          <li><i class="fas fa-check" style="color: #2c7a51; margin-right: 10px;"></i> Asuransi Perjalanan</li>
        </ul>



        <h4 style="margin-top: 1.5rem;">Info Penting:</h4>
        <ul style="margin:1rem 0; list-style: none; font-size: 0.9rem;">
          <li><i class="fas fa-info-circle" style="color: #2c7a51; margin-right: 10px;"></i> Anak < 3 tahun gratis</li>
        </ul>
        
        <a href="pemesanan.php" style="text-decoration:none; color:#FFFF;">
          <button class="pesan-sekarang">
          Pesan Paket Sekarang
        </button>
        </a>
      </div>
    </div>
  </main>

  <?php include 'Komponen/footer.php'; ?>
</body>
</html>