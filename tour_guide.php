<?php include './Komponen/navbar.php'; ?>
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
                  url('https://campuspedia.id/news/wp-content/uploads/2020/10/tour-guide.jpg') no-repeat center center/cover;
      height: 90vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      color: #fff;
      padding: 2rem;
    }

    .hero h1 {
      margin-top: 40px;
      font-size: 3rem;
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
                  url('/api/placeholder/1200/600') no-repeat center center/cover;
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
  
  <!-- Hero Section -->
  <section class="hero">
    <h1>Tour Guide Go-Travel</h1>
    <p>Jelajahi Indonesia dengan tour guide berpengalaman dan berlisensi untuk pengalaman yang lebih bermakna</p>
  </section>

  <!-- Filter Section -->
  <section class="filter-section">
    <div class="filter-container">
      <div class="filter-group">
        <div class="filter-label">Lokasi:</div>
        <select class="filter-select">
          <option value="">Semua Lokasi</option>
          <option value="lamongan">Lamongan</option>
          <option value="jakarta">Jakarta</option>
          <option value="bangkalan">Bangkalan</option>
          <option value="pamekasan">Pamekasan</option>
          <option value="surabaya">Surabaya</option>
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
          <img src="https://blog.cakap.com/wp-content/uploads/2022/10/H1-ukuran-foto-melamar-kerja-1.jpg" alt="Putu Aditya">
          <span class="guide-badge certified-badge">Tersertifikasi</span>
        </div>
        <div class="guide-content">
          <h3>Putu Aditya</h3>
          <div class="guide-location">
            <i class="fas fa-map-marker-alt"></i> Lamongan
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
            Pemandu wisata berpengalaman di Lamongan selama 8 tahun. Ahli dalam wisata religi makam Sunan Drajat dan destinasi kuliner khas Lamongan.
          </div>
          <div class="guide-meta">
            <div class="guide-price">
              Rp 100.000 <span>/hari</span>
            </div>
            <a href="tour_guide_detail.php" class="guide-button">Profil Lengkap</a>
          </div>
        </div>
      </div>

      <!-- Guide 2 -->
      <div class="guide-card">
        <div class="guide-image">
          <img src="https://cnc-magazine.oramiland.com/parenting/images/foto-formal.width-800.format-webp.webp" alt="Ratna Dewi">
          <span class="guide-badge">Populer</span>
        </div>
        <div class="guide-content">
          <h3>Ratna Dewi</h3>
          <div class="guide-location">
            <i class="fas fa-map-marker-alt"></i> Jakarta
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
            Spesialis wisata kota Jakarta. Memiliki pengetahuan mendalam tentang sejarah metropolitan, museum, dan seni budaya Jakarta.
          </div>
          <div class="guide-meta">
            <div class="guide-price">
              Rp 450.000 <span>/hari</span>
            </div>
            <a href="tour_guide_detail.php" class="guide-button">Profil Lengkap</a>
          </div>
        </div>
      </div>

      <!-- Guide 3 -->
      <div class="guide-card">
        <div class="guide-image">
          <img src="https://blog.cakap.com/wp-content/uploads/2022/10/H1-ukuran-foto-melamar-kerja-1.jpg" alt="Budi Santoso">
          <span class="guide-badge certified-badge">Tersertifikasi</span>
        </div>
        <div class="guide-content">
          <h3>Budi Santoso</h3>
          <div class="guide-location">
            <i class="fas fa-map-marker-alt"></i> Bangkalan
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
            Ahli wisata sejarah dan budaya Madura di Bangkalan. Berpengalaman 10 tahun memandu wisata religi, batik, dan kesenian tradisional Madura.
          </div>
          <div class="guide-meta">
            <div class="guide-price">
              Rp 550.000 <span>/hari</span>
            </div>
            <a href="tour_guide_detail.php" class="guide-button">Profil Lengkap</a>
          </div>
        </div>
      </div>

      <!-- Guide 4 -->
      <div class="guide-card">
        <div class="guide-image">
          <img src="https://glints.com/id/lowongan/wp-content/uploads/2022/04/cara-mengambil-foto-profesional-2.jpg" alt="Siti Nuraini">
        </div>
        <div class="guide-content">
          <h3>Siti Nuraini</h3>
          <div class="guide-location">
            <i class="fas fa-map-marker-alt"></i> Pamekasan
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
            Spesialis wisata kuliner dan agro di Pamekasan. Ahli dalam tur wisata perkebunan tembakau dan makanan khas Madura yang otentik.
          </div>
          <div class="guide-meta">
            <div class="guide-price">
              Rp 400.000 <span>/hari</span>
            </div>
            <a href="tour_guide_detail.php" class="guide-button">Profil Lengkap</a>
          </div>
        </div>
      </div>

      <!-- Guide 5 -->
      <div class="guide-card">
        <div class="guide-image">
          <img src="https://png.pngtree.com/thumb_back/fh260/background/20210908/pngtree-business-daytime-mens-office-professional-wear-photography-map-with-map-image_830379.jpg" alt="Rahmat Hidayat">
          <span class="guide-badge">Baru</span>
        </div>
        <div class="guide-content">
          <h3>Rahmat Hidayat</h3>
          <div class="guide-location">
            <i class="fas fa-map-marker-alt"></i> Surabaya
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
            Tour guide lokal Surabaya spesialis wisata heritage dan kuliner. Berpengalaman mengorganisir tur sejarah kota pahlawan dan wisata kampung heritage.
          </div>
          <div class="guide-meta">
            <div class="guide-price">
              Rp 500.000 <span>/hari</span>
            </div>
            <a href="tour_guide_detail.php" class="guide-button">Profil Lengkap</a>
          </div>
        </div>
      </div>

      <!-- Guide 6 -->
      <div class="guide-card">
        <div class="guide-image">
          <img src="https://shanibacreative.com/wp-content/uploads/2023/06/foto-untuk-melamar-kerja.jpg" alt="Maya Indriani">
          <span class="guide-badge certified-badge">Tersertifikasi</span>
        </div>
        <div class="guide-content">
          <h3>Maya Indriani</h3>
          <div class="guide-location">
            <i class="fas fa-map-marker-alt"></i> Jakarta
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
            Pemandu wisata spesialis museum dan galeri seni di Jakarta. Ahli dalam wisata edukasi dan sejarah perkembangan ibu kota Indonesia.
          </div>
          <div class="guide-meta">
            <div class="guide-price">
              Rp 650.000 <span>/hari</span>
            </div>
            <a href="tour_guide_detail.php" class="guide-button">Profil Lengkap</a>
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
            "Perjalanan kami di Lamongan menjadi sangat spesial berkat Pak Putu. Dia sangat berpengetahuan tentang sejarah makam Sunan Drajat dan membawa kami ke tempat-tempat kuliner yang tidak banyak dikunjungi wisatawan. Pengalaman yang luar biasa!"
          </div>
          <div class="testimonial-author">
            <div class="testimonial-avatar">
              <img src="https://cloud.jpnn.com/photo/sultra/news/normal/2022/03/20/mimpi-buruk-bule-cantik-asal-australia-bronte-gossling-berli-vul8.jpg" alt="Sarah">
            </div>
            <div class="testimonial-info">
              <h4>Sarah Johnson</h4>
              <p>Australia, wisata ke Lamongan</p>
            </div>
          </div>
        </div>

        <div class="testimonial-card">
          <div class="testimonial-text">
            "Bu Ratna sangat membantu selama perjalanan kami di Jakarta. Pengetahuannya tentang sejarah kota dan budaya metropolitan membuat pengalaman kami jauh lebih bermakna. Sangat direkomendasikan!"
          </div>
          <div class="testimonial-author">
            <div class="testimonial-avatar">
              <img src="https://awsimages.detik.net.id/community/media/visual/2024/02/05/queen-of-tears-2_169.jpeg?w=500&q=90" alt="David">
            </div>
            <div class="testimonial-info">
              <h4>David Kim</h4>
              <p>Korea Selatan, wisata ke Jakarta</p>
            </div>
          </div>
        </div>

        <div class="testimonial-card">
          <div class="testimonial-text">
            "Wisata budaya Madura di Bangkalan dengan Pak Budi adalah pengalaman terbaik kami di Indonesia. Dia sangat profesional, sabar, dan memperkenalkan budaya lokal dengan sangat menarik."
          </div>
          <div class="testimonial-author">
            <div class="testimonial-avatar">
              <img src="https://blue.kumparan.com/image/upload/fl_progressive,fl_lossy,c_fill,q_auto:best,w_640/v1545208898/1912_Khamid_aa0g0y.jpg" alt="Emma">
            </div>
            <div class="testimonial-info">
              <h4>Emma Wilson</h4>
              <p>Inggris, wisata ke Bangkalan</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

<?php include './Komponen/footer.php'; ?>
</body>
</html>