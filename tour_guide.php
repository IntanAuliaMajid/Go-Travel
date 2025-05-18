<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Tour Guide Indonesia</title>
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

    /* Hero Section */
    .hero {
      background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), 
                  url('./Gambar/guides-hero.jpg') no-repeat center center/cover;
      height: 50vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      color: #fff;
      padding: 2rem;
    }

    .hero h1 {
      font-size: 3.5rem;
      margin-bottom: 1rem;
      text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);
    }

    .hero p {
      font-size: 1.2rem;
      max-width: 800px;
      margin-bottom: 2rem;
    }

    /* Container */
    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 1rem;
    }

    /* Section Heading */
    .section-heading {
      text-align: center;
      margin-bottom: 2.5rem;
      color: #2c7a51;
      padding-top: 3rem;
    }

    .section-heading h2 {
      font-size: 2.5rem;
      margin-bottom: 0.5rem;
    }

    .section-heading p {
      color: #666;
      max-width: 700px;
      margin: 0 auto;
    }

    /* Filter Section */
    .filter-section {
      background-color: #fff;
      padding: 1.5rem;
      margin-top: -2rem;
      margin-bottom: 2rem;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      position: relative;
      z-index: 10;
      max-width: 1200px;
      margin-left: auto;
      margin-right: auto;
    }

    .filter-container {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 1rem;
    }

    .filter-group {
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .filter-label {
      font-weight: bold;
      color: #555;
    }

    .filter-select {
      padding: 0.5rem 1rem;
      border-radius: 5px;
      border: 1px solid #ddd;
      background-color: #f9f9f9;
      cursor: pointer;
    }

    .filter-button {
      background-color: #2c7a51;
      color: white;
      border: none;
      padding: 0.5rem 1.5rem;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .filter-button:hover {
      background-color: #1d5b3a;
    }

    /* Guide Cards */
    .guides-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
      gap: 2rem;
      margin-bottom: 3rem;
    }

    .guide-card {
      background-color: #fff;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s, box-shadow 0.3s;
      display: flex;
      flex-direction: column;
    }

    .guide-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    .guide-image {
      height: 250px;
      position: relative;
      overflow: hidden;
    }

    .guide-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.5s;
    }

    .guide-card:hover .guide-image img {
      transform: scale(1.05);
    }

    .guide-badge {
      position: absolute;
      top: 1rem;
      right: 1rem;
      background-color: #ff6b6b;
      color: white;
      padding: 0.25rem 0.75rem;
      border-radius: 50px;
      font-size: 0.8rem;
      font-weight: bold;
    }

    .certified-badge {
      background-color: #2c7a51;
    }

    .guide-content {
      padding: 1.5rem;
      flex-grow: 1;
      display: flex;
      flex-direction: column;
    }

    .guide-content h3 {
      margin-bottom: 0.5rem;
      font-size: 1.3rem;
    }

    .guide-location {
      color: #666;
      font-size: 0.9rem;
      display: flex;
      align-items: center;
      margin-bottom: 0.75rem;
    }

    .guide-location i {
      margin-right: 0.5rem;
      color: #2c7a51;
    }

    .guide-languages {
      display: flex;
      flex-wrap: wrap;
      gap: 0.5rem;
      margin-bottom: 1rem;
    }

    .language-tag {
      background-color: #eef7ed;
      color: #2c7a51;
      padding: 0.25rem 0.75rem;
      border-radius: 50px;
      font-size: 0.8rem;
    }

    .guide-rating {
      display: flex;
      align-items: center;
      margin-bottom: 1rem;
    }

    .guide-rating .stars {
      color: #ffc107;
      margin-right: 0.5rem;
    }

    .guide-rating .count {
      color: #666;
      font-size: 0.9rem;
    }

    .guide-description {
      margin-bottom: 1.5rem;
      color: #666;
      font-size: 0.95rem;
      flex-grow: 1;
    }

    .guide-meta {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding-top: 1rem;
      border-top: 1px solid #eee;
    }

    .guide-price {
      font-weight: bold;
      color: #2c7a51;
    }

    .guide-price span {
      font-size: 0.8rem;
      color: #666;
      font-weight: normal;
    }

    .guide-button {
      background-color: #2c7a51;
      color: white;
      border: none;
      padding: 0.5rem 1rem;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s;
      text-decoration: none;
      display: inline-block;
    }

    .guide-button:hover {
      background-color: #1d5b3a;
    }

    /* Testimonials */
    .testimonials-section {
      background-color: #eef7ed;
      padding: 4rem 0;
    }

    .testimonials-container {
      display: flex;
      gap: 2rem;
      margin-top: 2rem;
      overflow-x: auto;
      padding: 1rem 0.5rem;
    }

    .testimonial-card {
      background-color: #fff;
      border-radius: 10px;
      padding: 2rem;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      min-width: 300px;
      max-width: 400px;
      position: relative;
    }

    .testimonial-card:before {
      content: "\201C";
      font-size: 5rem;
      position: absolute;
      top: -15px;
      left: 10px;
      color: #eef7ed;
      font-family: Georgia, serif;
    }

    .testimonial-text {
      margin-bottom: 1.5rem;
      font-style: italic;
      color: #555;
    }

    .testimonial-author {
      display: flex;
      align-items: center;
    }

    .testimonial-avatar {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      overflow: hidden;
      margin-right: 1rem;
    }

    .testimonial-avatar img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .testimonial-info h4 {
      margin: 0;
      color: #333;
    }

    .testimonial-info p {
      margin: 0;
      color: #666;
      font-size: 0.9rem;
    }

    /* Become a Guide */
    .become-guide-section {
      padding: 5rem 0;
      background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), 
                  url('./Gambar/become-guide.jpg') no-repeat center center/cover;
      color: white;
      text-align: center;
    }

    .become-guide-content {
      max-width: 700px;
      margin: 0 auto;
    }

    .become-guide-content h2 {
      font-size: 2.5rem;
      margin-bottom: 1rem;
    }

    .become-guide-content p {
      margin-bottom: 2rem;
    }

    .big-button {
      display: inline-block;
      background-color: #ff6b6b;
      color: white;
      padding: 1rem 2rem;
      border-radius: 50px;
      font-weight: bold;
      text-decoration: none;
      transition: background-color 0.3s;
    }

    .big-button:hover {
      background-color: #ff5252;
    }

    /* Pagination */
    .pagination {
      display: flex;
      justify-content: center;
      margin: 3rem 0;
    }

    .pagination a {
      display: inline-block;
      padding: 0.5rem 1rem;
      margin: 0 0.25rem;
      border-radius: 5px;
      background-color: #f5f5f5;
      color: #333;
      text-decoration: none;
      transition: background-color 0.3s;
    }

    .pagination a.active {
      background-color: #2c7a51;
      color: white;
    }

    .pagination a:hover:not(.active) {
      background-color: #e0e0e0;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .hero h1 {
        font-size: 2.5rem;
      }

      .filter-container {
        flex-direction: column;
        align-items: stretch;
      }

      .filter-group {
        flex-direction: column;
        align-items: flex-start;
      }

      .filter-select {
        width: 100%;
      }

      .testimonials-container {
        flex-direction: column;
      }

      .testimonial-card {
        max-width: none;
      }
    }
  </style>
</head>
<body>
  <?php include 'Komponen/navbar.php'; ?>

  <!-- Hero Section -->
  <section class="hero">
    <h1>Tour Guide Indonesia</h1>
    <p>Jelajahi Indonesia dengan tour guide berpengalaman dan berlisensi untuk pengalaman yang lebih bermakna</p>
  </section>

  <!-- Filter Section -->
  <section class="filter-section">
    <div class="filter-container">
      <div class="filter-group">
        <div class="filter-label">Lokasi:</div>
        <select class="filter-select">
          <option value="">Semua Lokasi</option>
          <option value="bali">Bali</option>
          <option value="jawa">Jawa</option>
          <option value="sumatra">Sumatra</option>
          <option value="kalimantan">Kalimantan</option>
          <option value="sulawesi">Sulawesi</option>
          <option value="papua">Papua</option>
        </select>
      </div>
      <div class="filter-group">
        <div class="filter-label">Bahasa:</div>
        <select class="filter-select">
          <option value="">Semua Bahasa</option>
          <option value="indonesia">Indonesia</option>
          <option value="english">Inggris</option>
          <option value="mandarin">Mandarin</option>
          <option value="japanese">Jepang</option>
          <option value="korean">Korea</option>
        </select>
      </div>
      <div class="filter-group">
        <div class="filter-label">Rating:</div>
        <select class="filter-select">
          <option value="">Semua Rating</option>
          <option value="5">5 Bintang</option>
          <option value="4">4+ Bintang</option>
          <option value="3">3+ Bintang</option>
        </select>
      </div>
      <div class="filter-group">
        <button class="filter-button">Terapkan Filter</button>
      </div>
    </div>
  </section>

  <!-- Featured Guides -->
  <section class="container">
    <div class="section-heading">
      <h2>Tour Guide Terbaik</h2>
      <p>Temukan tour guide profesional dan berpengalaman untuk menemani perjalananmu di Indonesia</p>
    </div>

    <div class="guides-grid">
      <!-- Guide 1 -->
      <div class="guide-card">
        <div class="guide-image">
          <img src="https://image.popbela.com/post/20240625/318eec2bd6a926500cbb4bb06242a631.jpg?tr=w-1920,f-webp,q-75&width=1920&format=webp&quality=75" alt="Putu Aditya">
          <span class="guide-badge certified-badge">Tersertifikasi</span>
        </div>
        <div class="guide-content">
          <h3>Putu Aditya</h3>
          <div class="guide-location">
            <i class="fas fa-map-marker-alt"></i> Bali
          </div>
          <div class="guide-languages">
            <span class="language-tag">Indonesia</span>
            <span class="language-tag">Inggris</span>
            <span class="language-tag">Jepang</span>
          </div>
          <div class="guide-rating">
            <div class="stars">★★★★★</div>
            <div class="count">(124 ulasan)</div>
          </div>
          <div class="guide-description">
            Pemandu wisata berpengalaman di Bali selama 8 tahun. Ahli dalam sejarah, budaya, dan tradisi Bali. Spesialis tur spiritual dan heritage.
          </div>
          <div class="guide-meta">
            <div class="guide-price">
              Rp 500.000 <span>/hari</span>
            </div>
            <a href="detail_guide.php?id=putu-aditya" class="guide-button">Profil Lengkap</a>
          </div>
        </div>
      </div>

      <!-- Guide 2 -->
      <div class="guide-card">
        <div class="guide-image">
          <img src="https://image.popbela.com/post/20240625/318eec2bd6a926500cbb4bb06242a631.jpg?tr=w-1920,f-webp,q-75&width=1920&format=webp&quality=75" alt="Ratna Dewi">
          <span class="guide-badge">Populer</span>
        </div>
        <div class="guide-content">
          <h3>Ratna Dewi</h3>
          <div class="guide-location">
            <i class="fas fa-map-marker-alt"></i> Yogyakarta
          </div>
          <div class="guide-languages">
            <span class="language-tag">Indonesia</span>
            <span class="language-tag">Inggris</span>
          </div>
          <div class="guide-rating">
            <div class="stars">★★★★★</div>
            <div class="count">(98 ulasan)</div>
          </div>
          <div class="guide-description">
            Spesialis wisata budaya di Yogyakarta. Memiliki pengetahuan mendalam tentang sejarah candi, keraton, dan kesenian tradisional Jawa.
          </div>
          <div class="guide-meta">
            <div class="guide-price">
              Rp 450.000 <span>/hari</span>
            </div>
            <a href="detail_guide.php?id=ratna-dewi" class="guide-button">Profil Lengkap</a>
          </div>
        </div>
      </div>

      <!-- Guide 3 -->
      <div class="guide-card">
        <div class="guide-image">
          <img src="https://image.popbela.com/post/20240625/318eec2bd6a926500cbb4bb06242a631.jpg?tr=w-1920,f-webp,q-75&width=1920&format=webp&quality=75" alt="Budi Santoso">
          <span class="guide-badge certified-badge">Tersertifikasi</span>
        </div>
        <div class="guide-content">
          <h3>Budi Santoso</h3>
          <div class="guide-location">
            <i class="fas fa-map-marker-alt"></i> Jawa Timur
          </div>
          <div class="guide-languages">
            <span class="language-tag">Indonesia</span>
            <span class="language-tag">Inggris</span>
            <span class="language-tag">Mandarin</span>
          </div>
          <div class="guide-rating">
            <div class="stars">★★★★☆</div>
            <div class="count">(87 ulasan)</div>
          </div>
          <div class="guide-description">
            Ahli pendakian dan tur gunung Bromo & Ijen. Berpengalaman 10 tahun sebagai pemandu wisata alam dan petualangan.
          </div>
          <div class="guide-meta">
            <div class="guide-price">
              Rp 550.000 <span>/hari</span>
            </div>
            <a href="detail_guide.php?id=budi-santoso" class="guide-button">Profil Lengkap</a>
          </div>
        </div>
      </div>

      <!-- Guide 4 -->
      <div class="guide-card">
        <div class="guide-image">
          <img src="https://image.popbela.com/post/20240625/318eec2bd6a926500cbb4bb06242a631.jpg?tr=w-1920,f-webp,q-75&width=1920&format=webp&quality=75" alt="Siti Nuraini">
        </div>
        <div class="guide-content">
          <h3>Siti Nuraini</h3>
          <div class="guide-location">
            <i class="fas fa-map-marker-alt"></i> Jakarta
          </div>
          <div class="guide-languages">
            <span class="language-tag">Indonesia</span>
            <span class="language-tag">Inggris</span>
            <span class="language-tag">Belanda</span>
          </div>
          <div class="guide-rating">
            <div class="stars">★★★★☆</div>
            <div class="count">(76 ulasan)</div>
          </div>
          <div class="guide-description">
            Spesialis wisata kota dan sejarah di Jakarta. Ahli dalam tur kuliner dan mengenalkan beragam makanan lokal yang otentik.
          </div>
          <div class="guide-meta">
            <div class="guide-price">
              Rp 400.000 <span>/hari</span>
            </div>
            <a href="detail_guide.php?id=siti-nuraini" class="guide-button">Profil Lengkap</a>
          </div>
        </div>
      </div>

      <!-- Guide 5 -->
      <div class="guide-card">
        <div class="guide-image">
          <img src="https://image.popbela.com/post/20240625/318eec2bd6a926500cbb4bb06242a631.jpg?tr=w-1920,f-webp,q-75&width=1920&format=webp&quality=75" alt="Rahmat Hidayat">
          <span class="guide-badge">Baru</span>
        </div>
        <div class="guide-content">
          <h3>Rahmat Hidayat</h3>
          <div class="guide-location">
            <i class="fas fa-map-marker-alt"></i> Lombok
          </div>
          <div class="guide-languages">
            <span class="language-tag">Indonesia</span>
            <span class="language-tag">Inggris</span>
            <span class="language-tag">Jerman</span>
          </div>
          <div class="guide-rating">
            <div class="stars">★★★★★</div>
            <div class="count">(42 ulasan)</div>
          </div>
          <div class="guide-description">
            Tour guide lokal Lombok spesialis trekking Gunung Rinjani dan wisata pantai. Berpengalaman mengorganisir tur multi-hari.
          </div>
          <div class="guide-meta">
            <div class="guide-price">
              Rp 500.000 <span>/hari</span>
            </div>
            <a href="detail_guide.php?id=rahmat-hidayat" class="guide-button">Profil Lengkap</a>
          </div>
        </div>
      </div>

      <!-- Guide 6 -->
      <div class="guide-card">
        <div class="guide-image">
          <img src="https://image.popbela.com/post/20240625/318eec2bd6a926500cbb4bb06242a631.jpg?tr=w-1920,f-webp,q-75&width=1920&format=webp&quality=75" alt="Maya Indriani">
          <span class="guide-badge certified-badge">Tersertifikasi</span>
        </div>
        <div class="guide-content">
          <h3>Maya Indriani</h3>
          <div class="guide-location">
            <i class="fas fa-map-marker-alt"></i> Raja Ampat, Papua
          </div>
          <div class="guide-languages">
            <span class="language-tag">Indonesia</span>
            <span class="language-tag">Inggris</span>
          </div>
          <div class="guide-rating">
            <div class="stars">★★★★★</div>
            <div class="count">(68 ulasan)</div>
          </div>
          <div class="guide-description">
            Pemandu wisata spesialis diving dan snorkeling di Raja Ampat. Ahli dalam konservasi laut dan ekologi terumbu karang.
          </div>
          <div class="guide-meta">
            <div class="guide-price">
              Rp 650.000 <span>/hari</span>
            </div>
            <a href="detail_guide.php?id=maya-indriani" class="guide-button">Profil Lengkap</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Pagination -->
    <div class="pagination">
      <a href="#" class="active">1</a>
      <a href="#">2</a>
      <a href="#">3</a>
      <a href="#">4</a>
      <a href="#">5</a>
      <a href="#">&raquo;</a>
    </div>
  </section>

  <!-- Testimonials -->
  <section class="testimonials-section">
    <div class="container">
      <div class="section-heading">
        <h2>Apa Kata Mereka</h2>
        <p>Pengalaman wisatawan yang telah menggunakan jasa tour guide kami</p>
      </div>

      <div class="testimonials-container">
        <div class="testimonial-card">
          <div class="testimonial-text">
            "Perjalanan kami di Bali menjadi sangat spesial berkat Pak Putu. Dia sangat berpengetahuan dan membawa kami ke tempat-tempat yang tidak banyak dikunjungi wisatawan. Pengalaman yang luar biasa!"
          </div>
          <div class="testimonial-author">
            <div class="testimonial-avatar">
              <img src="https://image.popbela.com/post/20240625/318eec2bd6a926500cbb4bb06242a631.jpg?tr=w-1920,f-webp,q-75&width=1920&format=webp&quality=75" alt="Sarah">
            </div>
            <div class="testimonial-info">
              <h4>Sarah Johnson</h4>
              <p>Australia, wisata ke Bali</p>
            </div>
          </div>
        </div>

        <div class="testimonial-card">
          <div class="testimonial-text">
            "Bu Ratna sangat membantu selama perjalanan kami di Yogyakarta. Pengetahuannya tentang sejarah dan budaya lokal membuat pengalaman kami jauh lebih bermakna. Sangat direkomendasikan!"
          </div>
          <div class="testimonial-author">
            <div class="testimonial-avatar">
              <img src="https://image.popbela.com/post/20240625/318eec2bd6a926500cbb4bb06242a631.jpg?tr=w-1920,f-webp,q-75&width=1920&format=webp&quality=75" alt="David">
            </div>
            <div class="testimonial-info">
              <h4>David Kim</h4>
              <p>Korea Selatan, wisata ke Yogyakarta</p>
            </div>
          </div>
        </div>

        <div class="testimonial-card">
          <div class="testimonial-text">
            "Pendakian Gunung Bromo dengan Pak Budi adalah pengalaman terbaik kami di Indonesia. Dia sangat profesional, sabar, dan memastikan keamanan kami sepanjang perjalanan."
          </div>
          <div class="testimonial-author">
            <div class="testimonial-avatar">
              <img src="https://image.popbela.com/post/20240625/318eec2bd6a926500cbb4bb06242a631.jpg?tr=w-1920,f-webp,q-75&width=1920&format=webp&quality=75" alt="Emma">
            </div>
            <div class="testimonial-info">
              <h4>Emma Wilson</h4>
              <p>Inggris, wisata ke Jawa Timur</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Become a Guide -->
  <section class="become-guide-section">
    <div class="become-guide-content">
      <h2>Bergabunglah Menjadi Tour Guide</h2>
      <p>Jadilah bagian dari jaringan tour guide profesional kami. Dapatkan lebih banyak klien dan kembangkan karir Anda sebagai pemandu wisata di Indonesia.</p>
      <a href="daftar_guide.php" class="big-button">Daftar Sekarang</a>
    </div>
  </section>

  <?php include 'Komponen/footer.php'; ?>
</body>
</html>