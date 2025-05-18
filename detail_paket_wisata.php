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
                  url('https://4.bp.blogspot.com/-_Np9OVi0EEU/VU3XHqemogI/AAAAAAAAA9g/QcUM52-qKws/s1600/1.jpg') no-repeat center center/cover;
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
      height: 400px;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      margin-top: 1rem;
    }

    .map-container iframe {
      width: 100%;
      height: 100%;
      border: 0;
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
      
      .map-container {
        height: 300px;
      }
    }
  </style>
</head>
<body>
  <?php include 'Komponen/navbar.php'; ?>

  <!-- Hero Section -->
  <section class="detail-hero">
    <div class="detail-container">
      <h1>Pantai Tanjung Kodok</h1>
      <div class="card-location">
        <i class="fas fa-map-marker-alt"></i> Lamongan, Jawa Timur
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
          <p>Pantai Tanjung Kodok menawarkan pesona pantai berpasir putih dengan fasilitas lengkap. Nikmati berbagai aktivitas air seperti banana boat, jet ski, dan snorkeling. Tempat yang cocok untuk liburan keluarga dengan berbagai fasilitas pendukung.</p>
        </div>

        <!-- Denah Lokasi -->
        <div class="detail-section">
          <h3>Lokasi & Denah</h3>
          <div class="map-container">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3959.7263846461384!2d112.332!3d-7.053!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e786b1f9c84349d%3A0x7b2d44e45b2c22a3!2sPantai%20Tanjung%20Kodok!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid" frameborder="0"></iframe>
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
              <p>Pantainya sangat bersih dengan fasilitas lengkap. Pelayanan staff sangat ramah dan profesional. Sangat recommended untuk liburan keluarga!</p>
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
          <div class="detail-price">Rp 30.000/orang</div>
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