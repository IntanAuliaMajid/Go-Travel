<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Profil Tour Guide | Tour Guide Indonesia</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f7f9fc;
      color: #333;
      line-height: 1.6;
    }

    /* Container */
    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 1rem;
    }

    /* Hero Section */
    .profile-hero {
      background-color: #2c7a51;
      padding: 3rem 0;
      color: white;
    }

    .profile-header {
        padding-top: 3rem;
      display: flex;
      align-items: center;
      gap: 2rem;
    }

    .profile-image {
      width: 180px;
      height: 180px;
      border-radius: 50%;
      overflow: hidden;
      border: 5px solid white;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    .profile-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .profile-info h1 {
      font-size: 2.5rem;
      margin-bottom: 0.5rem;
    }

    .profile-meta {
      display: flex;
      flex-wrap: wrap;
      gap: 1.5rem;
      margin-top: 1rem;
    }

    .profile-meta-item {
      display: flex;
      align-items: center;
    }

    .profile-meta-item i {
      margin-right: 0.5rem;
    }

    .profile-badges {
      display: flex;
      gap: 0.75rem;
      margin-top: 1rem;
    }

    .profile-badge {
      background-color: rgba(255, 255, 255, 0.2);
      padding: 0.25rem 0.75rem;
      border-radius: 50px;
      font-size: 0.9rem;
      display: flex;
      align-items: center;
    }

    .profile-badge i {
      margin-right: 0.35rem;
    }

    .certified-badge {
      background-color: #ff6b6b;
    }

    /* Main Content */
    .main-content {
      margin-top: 2rem;
      display: grid;
      grid-template-columns: 2fr 1fr;
      gap: 2rem;
    }

    @media (max-width: 768px) {
      .main-content {
        grid-template-columns: 1fr;
      }

      .profile-header {
        flex-direction: column;
        text-align: center;
      }

      .profile-meta {
        justify-content: center;
      }

      .profile-badges {
        justify-content: center;
      }
    }

    /* About Section */
    .section-title {
      color: #2c7a51;
      font-size: 1.5rem;
      margin-bottom: 1rem;
      padding-bottom: 0.5rem;
      border-bottom: 2px solid #eef7ed;
    }

    .about-section p {
      margin-bottom: 1rem;
    }

    .languages-section {
      margin-top: 2rem;
    }

    .languages-list {
      display: flex;
      flex-wrap: wrap;
      gap: 0.75rem;
    }

    .language-item {
      background-color: #eef7ed;
      color: #2c7a51;
      padding: 0.5rem 1rem;
      border-radius: 50px;
      display: flex;
      align-items: center;
    }

    .language-item i {
      margin-right: 0.5rem;
    }

    .language-level {
      font-size: 0.8rem;
      color: #666;
      margin-left: 0.5rem;
    }

    /* Experience & Specialties */
    .experience-section, .specialties-section {
      margin-top: 2rem;
    }

    .experience-list, .specialties-list {
      list-style: none;
    }

    .experience-item, .specialty-item {
      margin-bottom: 1rem;
      padding-left: 1.5rem;
      position: relative;
    }

    .experience-item:before, .specialty-item:before {
      content: "\f058";
      font-family: "Font Awesome 5 Free";
      font-weight: 900;
      color: #2c7a51;
      position: absolute;
      left: 0;
    }

    /* Tours Section */
    .tours-section {
      margin-top: 2rem;
    }

    .tour-card {
      background-color: white;
      border-radius: 10px;
      padding: 1.5rem;
      margin-bottom: 1.5rem;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .tour-card h3 {
      margin-bottom: 0.5rem;
      color: #2c7a51;
    }

    .tour-details {
      margin-top: 1rem;
    }

    .tour-detail {
      display: flex;
      align-items: center;
      margin-bottom: 0.5rem;
    }

    .tour-detail i {
      margin-right: 0.5rem;
      color: #2c7a51;
      width: 20px;
      text-align: center;
    }

    .tour-actions {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-top: 1.5rem;
      padding-top: 1rem;
      border-top: 1px solid #eee;
    }

    .tour-price {
      font-weight: bold;
      color: #2c7a51;
      font-size: 1.1rem;
    }

    .tour-price span {
      font-size: 0.85rem;
      color: #666;
      font-weight: normal;
    }

    .book-button {
      background-color: #2c7a51;
      color: white;
      border: none;
      padding: 0.5rem 1.5rem;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s;
      text-decoration: none;
    }

    .book-button:hover {
      background-color: #1d5b3a;
    }

    /* Sidebar */
    .sidebar-card {
      background-color: white;
      border-radius: 10px;
      padding: 1.5rem;
      margin-bottom: 2rem;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .book-guide-section h3 {
      color: #2c7a51;
      margin-bottom: 1rem;
    }

    .form-group {
      margin-bottom: 1rem;
    }

    .form-group label {
      display: block;
      margin-bottom: 0.5rem;
      font-weight: 500;
    }

    .form-control {
      width: 100%;
      padding: 0.75rem;
      border: 1px solid #ddd;
      border-radius: 5px;
      font-family: inherit;
    }

    .form-submit {
      background-color: #ff6b6b;
      color: white;
      border: none;
      padding: 0.75rem 0;
      border-radius: 5px;
      width: 100%;
      cursor: pointer;
      font-weight: bold;
      transition: background-color 0.3s;
      margin-top: 1rem;
    }

    .form-submit:hover {
      background-color: #ff5252;
    }

    .contact-section {
      margin-top: 2rem;
    }

    .contact-option {
      display: flex;
      align-items: center;
      margin-bottom: 1rem;
      padding: 0.75rem;
      background-color: #f9f9f9;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .contact-option:hover {
      background-color: #eef7ed;
    }

    .contact-option i {
      width: 40px;
      height: 40px;
      background-color: #2c7a51;
      color: white;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 1rem;
    }

    /* Reviews Section */
    .reviews-section {
      margin-top: 3rem;
    }

    .review-stats {
      display: flex;
      align-items: center;
      gap: 2rem;
      margin-bottom: 2rem;
    }

    .average-rating {
      text-align: center;
    }

    .average-rating .number {
      font-size: 3rem;
      font-weight: bold;
      color: #2c7a51;
    }

    .average-rating .stars {
      color: #ffc107;
      font-size: 1.2rem;
      margin: 0.5rem 0;
    }

    .average-rating .count {
      color: #666;
    }

    .rating-bars {
      flex-grow: 1;
    }

    .rating-bar {
      display: flex;
      align-items: center;
      margin-bottom: 0.5rem;
    }

    .rating-label {
      width: 40px;
      text-align: right;
      margin-right: 1rem;
    }

    .rating-progress {
      height: 8px;
      background-color: #eee;
      border-radius: 4px;
      overflow: hidden;
      flex-grow: 1;
    }

    .rating-progress-fill {
      height: 100%;
      background-color: #ffc107;
    }

    .rating-count {
      width: 40px;
      margin-left: 1rem;
      color: #666;
      font-size: 0.9rem;
    }

    .review-card {
      background-color: white;
      border-radius: 10px;
      padding: 1.5rem;
      margin-bottom: 1.5rem;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .review-header {
      display: flex;
      justify-content: space-between;
      margin-bottom: 1rem;
    }

    .reviewer {
      display: flex;
      align-items: center;
    }

    .reviewer-avatar {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      overflow: hidden;
      margin-right: 1rem;
    }

    .reviewer-avatar img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .reviewer-info h4 {
      margin: 0;
    }

    .reviewer-info .date {
      color: #666;
      font-size: 0.9rem;
    }

    .review-rating {
      color: #ffc107;
    }

    .review-content {
      margin-bottom: 1rem;
    }

    .review-tour {
      font-style: italic;
      color: #666;
      font-size: 0.9rem;
    }

    .review-photos {
      display: flex;
      gap: 0.5rem;
      margin-top: 1rem;
    }

    .review-photo {
      width: 80px;
      height: 80px;
      border-radius: 5px;
      overflow: hidden;
    }

    .review-photo img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .see-more-button {
      display: block;
      text-align: center;
      padding: 0.75rem;
      background-color: #f5f5f5;
      color: #555;
      border-radius: 5px;
      margin-top: 1rem;
      text-decoration: none;
      transition: background-color 0.3s;
    }

    .see-more-button:hover {
      background-color: #e0e0e0;
    }

    /* Gallery Section */
    .gallery-section {
      margin-top: 3rem;
    }

    .gallery-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 1rem;
    }

    .gallery-item {
      height: 200px;
      border-radius: 10px;
      overflow: hidden;
      position: relative;
    }

    .gallery-item img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.3s;
    }

    .gallery-item:hover img {
      transform: scale(1.05);
    }

    @media (max-width: 768px) {
      .gallery-grid {
        grid-template-columns: repeat(2, 1fr);
      }
    }
  </style>
</head>
<body>
  <?php include 'Komponen/navbar.php'; ?>
  <!-- Profile Hero Section -->
  <section class="profile-hero">
    <div class="container">
      <div class="profile-header">
        <div class="profile-image">
          <img src="https://image.popbela.com/post/20240625/318eec2bd6a926500cbb4bb06242a631.jpg?tr=w-1920,f-webp,q-75&width=1920&format=webp&quality=75" alt="Putu Aditya">
        </div>
        <div class="profile-info">
          <h1>Putu Aditya</h1>
          <div class="profile-meta">
            <div class="profile-meta-item">
              <i class="fas fa-map-marker-alt"></i>
              <span>Bali, Indonesia</span>
            </div>
            <div class="profile-meta-item">
              <i class="fas fa-star"></i>
              <span>4.9 (124 ulasan)</span>
            </div>
            <div class="profile-meta-item">
              <i class="fas fa-user-friends"></i>
              <span>248 wisatawan telah dibimbing</span>
            </div>
          </div>
          <div class="profile-badges">
            <div class="profile-badge certified-badge">
              <i class="fas fa-certificate"></i>
              <span>Tersertifikasi</span>
            </div>
            <div class="profile-badge">
              <i class="fas fa-clock"></i>
              <span>8 tahun pengalaman</span>
            </div>
            <div class="profile-badge">
              <i class="fas fa-bolt"></i>
              <span>Respons cepat</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Main Content -->
  <div class="container">
    <div class="main-content">
      <!-- Left Column -->
      <div class="left-column">
        <!-- About Section -->
        <section class="about-section">
          <h2 class="section-title">Tentang Saya</h2>
          <p>Selamat datang di profil saya! Saya adalah Putu Aditya, pemandu wisata berpengalaman di Bali selama 8 tahun. Saya lahir dan besar di Ubud, jantung budaya Bali, yang memberikan saya pengetahuan mendalam tentang tradisi, sejarah, dan kehidupan masyarakat lokal Bali.</p>
          
          <p>Dengan latar belakang pendidikan di bidang Pariwisata dan Budaya dari Universitas Udayana, saya menawarkan pengalaman wisata yang autentik dan mendalam. Saya percaya bahwa perjalanan terbaik adalah yang dapat menghubungkan wisatawan dengan jiwa tempat yang mereka kunjungi.</p>
          
          <p>Saya adalah pemegang sertifikat pemandu wisata profesional dari Kementerian Pariwisata Indonesia dan aktif dalam komunitas pelestarian budaya Bali. Mari jelajahi keindahan dan keunikan Pulau Dewata bersama saya!</p>
        </section>
        
        <!-- Languages Section -->
        <section class="languages-section">
          <h2 class="section-title">Bahasa</h2>
          <div class="languages-list">
            <div class="language-item">
              <i class="fas fa-language"></i>
              <span>Bahasa Indonesia</span>
              <span class="language-level">(Bahasa ibu)</span>
            </div>
            <div class="language-item">
              <i class="fas fa-language"></i>
              <span>Bahasa Bali</span>
              <span class="language-level">(Bahasa ibu)</span>
            </div>
            <div class="language-item">
              <i class="fas fa-language"></i>
              <span>Bahasa Inggris</span>
              <span class="language-level">(Lancar)</span>
            </div>
            <div class="language-item">
              <i class="fas fa-language"></i>
              <span>Bahasa Jepang</span>
              <span class="language-level">(Menengah)</span>
            </div>
          </div>
        </section>
        
        <!-- Experience Section -->
        <section class="experience-section">
          <h2 class="section-title">Pengalaman</h2>
          <ul class="experience-list">
            <li class="experience-item">Pemandu wisata profesional di Bali sejak 2016</li>
            <li class="experience-item">Spesialis tur budaya dan spiritual di daerah Ubud</li>
            <li class="experience-item">Bekerja dengan agen perjalanan internasional seperti TripAdvisor, Lonely Planet, dan Intrepid Travel</li>
            <li class="experience-item">Pembicara tamu di Festival Budaya Bali 2022-2023</li>
            <li class="experience-item">Penghargaan "Tour Guide Terbaik Bali" tahun 2021</li>
          </ul>
        </section>
        
        <!-- Specialties Section -->
        <section class="specialties-section">
          <h2 class="section-title">Spesialisasi</h2>
          <ul class="specialties-list">
            <li class="specialty-item">Tur budaya dan spiritual ke pura-pura kuno dan tempat sakral</li>
            <li class="specialty-item">Eksplorasi desa tradisional dan kehidupan komunitas lokal</li>
            <li class="specialty-item">Wisata kuliner dan kelas memasak masakan Bali</li>
            <li class="specialty-item">Tur fotografi ke lokasi-lokasi ikonik dan tersembunyi di Bali</li>
            <li class="specialty-item">Tur trekking di area persawahan dan hutan di pedalaman Bali</li>
          </ul>
        </section>
        
        <!-- Tours Section -->
        <section class="tours-section">
          <h2 class="section-title">Paket Tur yang Ditawarkan</h2>
          <!-- Tour 1 -->
          
          <!-- Tour 2 -->
          <div class="tour-card">
            <h3>Hidden Gems of East Bali</h3>
            <p>Jelajahi sisi timur Bali yang eksotis dan jarang dikunjungi wisatawan. Nikmati pantai tersembunyi, desa tradisional, dan pemandangan alam yang menakjubkan.</p>
            
            <div class="tour-details">
              <div class="tour-detail">
                <i class="far fa-clock"></i>
                <span>Durasi: 10 jam (Full Day)</span>
              </div>
              <div class="tour-detail">
                <i class="fas fa-users"></i>
                <span>Ukuran grup: 1-4 orang</span>
              </div>
              <div class="tour-detail">
                <i class="fas fa-route"></i>
                <span>Termasuk: Pura Lempuyang, Blue Lagoon, Desa Tenganan</span>
              </div>
              <div class="tour-detail">
                <i class="fas fa-utensils"></i>
                <span>Makan siang seafood di pantai disediakan</span>
              </div>
            </div>
            
            <div class="tour-actions">
              <div class="tour-price">
                Rp 900.000 <span>/orang</span>
              </div>
              <a href="booking.php?tour=east-bali" class="book-button">Pesan Sekarang</a>
            </div>
          </div>
          
          <!-- Tour 3 -->
          <div class="tour-card">
            <h3>Bali Culinary Adventure</h3>
            <p>Petualangan kuliner untuk mencicipi berbagai hidangan otentik Bali. Kunjungi pasar tradisional, pelajari resep-resep lokal, dan ikuti kelas memasak.</p>
            
            <div class="tour-details">
              <div class="tour-detail">
                <i class="far fa-clock"></i>
                <span>Durasi: 6 jam (Half Day)</span>
              </div>
              <div class="tour-detail">
                <i class="fas fa-users"></i>
                <span>Ukuran grup: 1-8 orang</span>
              </div>
              <div class="tour-detail">
                <i class="fas fa-route"></i>
                <span>Termasuk: Pasar Tradisional, Kelas Memasak, Makan Siang</span>
              </div>
              <div class="tour-detail">
                <i class="fas fa-book"></i>
                <span>Buku resep Bali diberikan sebagai souvenir</span>
              </div>
            </div>
            
            <div class="tour-actions">
              <div class="tour-price">
                Rp 650.000 <span>/orang</span>
              </div>
              <a href="booking.php?tour=culinary-adventure" class="book-button">Pesan Sekarang</a>
            </div>
          </div>
        </section>
        
        <!-- Reviews Section -->
        <section class="reviews-section">
          <h2 class="section-title">Ulasan dari Wisatawan</h2>
          
          <div class="review-stats">
            <div class="average-rating">
              <div class="number">4.9</div>
              <div class="stars">★★★★★</div>
              <div class="count">124 ulasan</div>
            </div>
            
            <div class="rating-bars">
              <div class="rating-bar">
                <div class="rating-label">5 ★</div>
                <div class="rating-progress">
                  <div class="rating-progress-fill" style="width: 85%"></div>
                </div>
                <div class="rating-count">106</div>
              </div>
              <div class="rating-bar">
                <div class="rating-label">4 ★</div>
                <div class="rating-progress">
                  <div class="rating-progress-fill" style="width: 10%"></div>
                </div>
                <div class="rating-count">12</div>
              </div>
              <div class="rating-bar">
                <div class="rating-label">3 ★</div>
                <div class="rating-progress">
                  <div class="rating-progress-fill" style="width: 4%"></div>
                </div>
                <div class="rating-count">5</div>
              </div>
              <div class="rating-bar">
                <div class="rating-label">2 ★</div>
                <div class="rating-progress">
                  <div class="rating-progress-fill" style="width: 1%"></div>
                </div>
                <div class="rating-count">1</div>
              </div>
              <div class="rating-bar">
                <div class="rating-label">1 ★</div>
                <div class="rating-progress">
                  <div class="rating-progress-fill" style="width: 0%"></div>
                </div>
                <div class="rating-count">0</div>
              </div>
            </div>
          </div>
          
          <!-- Review Cards -->
          <div class="review-card">
            <div class="review-header">
              <div class="reviewer">
                <div class="reviewer-avatar">
                  <img src="https://image.popbela.com/post/20240625/318eec2bd6a926500cbb4bb06242a631.jpg?tr=w-1920,f-webp,q-75&width=1920&format=webp&quality=75" alt="Sarah Johnson">
                </div>
                <div class="reviewer-info">
                  <h4>Sarah Johnson</h4>
                  <div class="date">Juli 2024</div>
                </div>
              </div>
              <div class="review-rating">★★★★★</div>
            </div>
            <div class="review-content">
              <p>Pak Putu adalah guide terbaik yang pernah saya temui! Pengetahuannya tentang budaya dan sejarah Bali sangat mendalam. Dia membawa kami ke tempat-tempat yang tidak ada di panduan wisata dan memberikan pengalaman yang benar-benar otentik. Yang paling berkesan adalah ketika kami diajak mengikuti upacara di pura lokal dan diterima dengan hangat oleh masyarakat setempat.</p>
            </div>
            <div class="review-tour">
              <strong>Tour:</strong> Spiritual Ubud Journey
            </div>
            <div class="review-photos">
              <div class="review-photo">
                <img src="https://image.popbela.com/post/20240625/318eec2bd6a926500cbb4bb06242a631.jpg?tr=w-1920,f-webp,q-75&width=1920&format=webp&quality=75" alt="Review Photo">
              </div>
              <div class="review-photo">
                <img src="https://image.popbela.com/post/20240625/318eec2bd6a926500cbb4bb06242a631.jpg?tr=w-1920,f-webp,q-75&width=1920&format=webp&quality=75" alt="Review Photo">
              </div>
            </div>
          </div>
          
          <div class="review-card">
            <div class="review-header">
              <div class="reviewer">
                <div class="reviewer-avatar">
                  <img src="https://image.popbela.com/post/20240625/318eec2bd6a926500cbb4bb06242a631.jpg?tr=w-1920,f-webp,q-75&width=1920&format=webp&quality=75" alt="Takashi Yamamoto">
                </div>
                <div class="reviewer-info">
                  <h4>Takashi Yamamoto</h4>
                  <div class="date">Mei 2024</div>
                </div>
              </div>
              <div class="review-rating">★★★★★</div>
            </div>
            <div class="review-content">
              <p>素晴らしい経験でした！プトゥさんは日本語も話せて、とても助かりました。バリの文化や伝統についての知識が豊富で、普通の観光では行けないような場所に連れて行ってくれました。特に東バリのツアーは忘れられない思い出になりました。次回バリに来る時も必ずプトゥさ</p>
            </div>
            <div class="review-tour">
              <strong>Tour:</strong> Spiritual Ubud Journey
            </div>
            <div class="review-photos">
              <div class="review-photo">
                <img src="https://image.popbela.com/post/20240625/318eec2bd6a926500cbb4bb06242a631.jpg?tr=w-1920,f-webp,q-75&width=1920&format=webp&quality=75" alt="Review Photo">
              </div>
              <div class="review-photo">
                <img src="https://image.popbela.com/post/20240625/318eec2bd6a926500cbb4bb06242a631.jpg?tr=w-1920,f-webp,q-75&width=1920&format=webp&quality=75" alt="Review Photo">
              </div>
            </div>
        </section>
    </div>
</div>
</div>
<?php include "./Komponen/footer.php" ?>
</body>