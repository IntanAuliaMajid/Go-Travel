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

    /* Navbar Styles */
    .navbar {
      background-color: #2c7a51;
      padding: 1rem 2rem;
      color: white;
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
    }

    .itinerary-time {
      font-weight: bold;
      min-width: 100px;
      color: #2c7a51;
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
      margin-bottom: 0.5rem;
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
    }
  </style>
</head>
<body>
  <?php include 'Komponen/navbar.php'; ?>

  <!-- Hero Section -->
  <section class="detail-hero">
    <div class="detail-container">
      <h1>Ancol Taman Impian</h1>
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
          <h3>Deskripsi Wisata</h3>
          <p>Ancol Taman Impian merupakan destinasi rekreasi terbesar di Jakarta yang menawarkan beragam wahana hiburan dan wisata keluarga. Nikmati berbagai atraksi seru seperti Dunia Fantasi (Dufan), SeaWorld, Atlantis Water Adventure, dan pantai yang indah. Cocok untuk liburan bersama keluarga, Ancol juga menyediakan fasilitas lengkap seperti restoran, penginapan, dan area bermain anak, menjadikannya tempat favorit untuk bersantai dan bersenang-senang di ibu kota.</p>
        </div>

        <!-- Denah Lokasi -->
        <div class="detail-section">
          <h3>Denah Lokasi  </h3>
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
          </div>
        </div>

        <!-- Ulasan -->
        <div class="detail-section">
          <h3>Ulasan Pengunjung (4.8/5)</h3>
          <div class="reviews-section">
            <!-- Ulasan 1 -->
            <div class="review-item">
              <div class="review-header">
                <div>
                  <div class="review-author">Budi Santoso</div>
                  <div class="review-date">15 Maret 2024</div>
                </div>
                <div class="rating-stars">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                </div>
              </div>
              <p>Pantainya tertata rapi dan bersih, dilengkapi dengan berbagai fasilitas yang memadai. Stafnya ramah dan profesional, memberikan pengalaman berlibur yang menyenangkan. Sangat direkomendasikan sebagai destinasi liburan keluarga!</p>
            </div>

            <!-- Ulasan 2 -->
            <div class="review-item">
              <div class="review-header">
                <div>
                  <div class="review-author">Anita Rahma</div>
                  <div class="review-date">10 Maret 2024</div>
                </div>
                <div class="rating-stars">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="far fa-star"></i>
                </div>
              </div>
              <p>Wisata yang menyenangkan, tapi area parkir agak sempit saat weekend. Fasilitas toilet bisa lebih ditingkatkan kebersihannya.</p>
            </div>

            <!-- Form Ulasan -->
            <div class="add-review">
              <h4>Berikan Ulasan Anda</h4>
              <form class="review-form">
                <div class="form-group">
                  <textarea placeholder="Bagikan pengalaman Anda selama berkunjung..."></textarea>
                </div>
                <div class="rating-input">
                  <label>Rating:</label>
                  <div class="rating-stars">
                    <i class="far fa-star"></i>
                    <i class="far fa-star"></i>
                    <i class="far fa-star"></i>
                    <i class="far fa-star"></i>
                    <i class="far fa-star"></i>
                  </div>
                </div>
                <button type="submit" class="pesan-sekarang">Kirim Ulasan</button>
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- Sidebar Booking -->
      <div class="detail-info">
        <div class="detail-meta">
          <h2>Paket Wisata</h2>
          <div class="detail-price">Rp 180.000/orang</div>
          <div class="facility-item" style="margin:1rem 0">
            <i class="fas fa-clock"></i> Buka: 08.00 - 18.00 WIB
          </div>
        </div>
        
        <h4>Fasilitas Termasuk:</h4>
        <ul style="margin:1rem 0; list-style: none;">
          <li><i class="fas fa-check"></i> Area Parkir</li>
          <li><i class="fas fa-check"></i> Toilet Umum</li>
          <li><i class="fas fa-check"></i> Area Bermain Anak</li>
        </ul>
        
        <button class="pesan-sekarang"><a href="booking.php" style="text-decoration:none; color:#FFFF;">Pesan Tiket Sekarang</a></button>
      </div>
    </div>
  </main>

  <?php include 'Komponen/footer.php'; ?>
</body>
</html>