<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Destinasi Wisata Indonesia</title>
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
                  url('https://source.unsplash.com/1600x900/?indonesia,landscape') no-repeat center center/cover;
      height: 60vh;
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

    .search-container {
      width: 100%;
      max-width: 600px;
      margin: 0 auto;
      position: relative;
    }

    .search-container input {
      width: 100%;
      padding: 1rem 1.5rem;
      border-radius: 50px;
      border: none;
      font-size: 1rem;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .search-container button {
      position: absolute;
      right: 5px;
      top: 5px;
      background-color: #2c7a51;
      color: white;
      border: none;
      padding: 0.75rem 1.5rem;
      border-radius: 50px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .search-container button:hover {
      background-color: #1d5b3a;
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

    /* Destinations Grid */
    .destinations-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      gap: 2rem;
      margin-bottom: 3rem;
    }

    .destination-card {
      background-color: #fff;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s, box-shadow 0.3s;
    }

    .destination-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    .card-image {
      height: 200px;
      overflow: hidden;
    }

    .card-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.5s;
    }

    .destination-card:hover .card-image img {
      transform: scale(1.05);
    }

    .card-badge {
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

    .card-content {
      padding: 1.5rem;
    }

    .card-content h3 {
      margin-bottom: 0.5rem;
      font-size: 1.3rem;
    }

    .card-location {
      color: #666;
      font-size: 0.9rem;
      display: flex;
      align-items: center;
      margin-bottom: 0.75rem;
    }

    .card-location i {
      margin-right: 0.5rem;
      color: #2c7a51;
    }

    .card-rating {
      display: flex;
      align-items: center;
      margin-bottom: 1rem;
    }

    .card-rating .stars {
      color: #ffc107;
      margin-right: 0.5rem;
    }

    .card-rating .count {
      color: #666;
      font-size: 0.9rem;
    }

    .card-description {
      margin-bottom: 1.5rem;
      color: #666;
      font-size: 0.95rem;
    }

    .card-meta {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding-top: 1rem;
      border-top: 1px solid #eee;
    }

    .card-price {
      font-weight: bold;
      color: #2c7a51;
    }

    .card-price span {
      font-size: 0.8rem;
      color: #666;
      font-weight: normal;
    }

    .card-button {
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

    .card-button:hover {
      background-color: #1d5b3a;
    }

    /* Popular Categories */
    .categories-section {
      padding: 4rem 0;
      background-color: #eef7ed;
    }

    .categories-container {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 1.5rem;
      margin-top: 2rem;
    }

    .category-card {
      flex: 1;
      min-width: 180px;
      max-width: 220px;
      background-color: #fff;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      text-align: center;
      transition: transform 0.3s;
      cursor: pointer;
    }

    .category-card:hover {
      transform: translateY(-5px);
    }

    .category-icon {
      height: 100px;
      display: flex;
      justify-content: center;
      align-items: center;
      background-color: #eef7ed;
    }

    .category-icon i {
      font-size: 2.5rem;
      color: #2c7a51;
    }

    .category-name {
      padding: 1rem;
      font-weight: bold;
    }

    .category-count {
      color: #666;
      font-size: 0.9rem;
      padding-bottom: 1rem;
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

    /* Newsletter */
    .newsletter-section {
      background-color: #2c7a51;
      padding: 4rem 0;
      color: white;
      text-align: center;
    }

    .newsletter-container {
      max-width: 600px;
      margin: 0 auto;
    }

    .newsletter-container h2 {
      margin-bottom: 1rem;
    }

    .newsletter-container p {
      margin-bottom: 2rem;
      opacity: 0.9;
    }

    .newsletter-form {
      display: flex;
      margin: 0 auto;
      max-width: 500px;
    }

    .newsletter-form input {
      flex: 1;
      padding: 0.75rem 1rem;
      border: none;
      border-radius: 50px 0 0 50px;
    }

    .newsletter-form button {
      background-color: #ff6b6b;
      color: white;
      border: none;
      padding: 0 1.5rem;
      border-radius: 0 50px 50px 0;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .newsletter-form button:hover {
      background-color: #ff5252;
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

      .newsletter-form {
        flex-direction: column;
      }

      .newsletter-form input {
        border-radius: 50px;
        margin-bottom: 1rem;
      }

      .newsletter-form button {
        border-radius: 50px;
        padding: 0.75rem;
      }
    }
  </style>
</head>
<body>
  <?php include 'Komponen/navbar.php'; ?>

  <!-- Hero Section -->
  <section class="hero">
    <h1>Jelajahi Keindahan Indonesia</h1>
    <p>Temukan destinasi wisata terbaik di seluruh Indonesia, dari pantai eksotis hingga gunung berapi yang megah</p>
    <div class="search-container">
      <input type="text" placeholder="Cari destinasi wisata...">
      <button><i class="fas fa-search"></i> Cari</button>
    </div>
  </section>

  <!-- Filter Section -->
  <section class="filter-section">
    <div class="filter-container">
      <div class="filter-group">
        <div class="filter-label">Kategori:</div>
        <select class="filter-select">
          <option value="">Semua Kategori</option>
          <option value="pantai">Pantai</option>
          <option value="gunung">Gunung</option>
          <option value="air-terjun">Air Terjun</option>
          <option value="danau">Danau</option>
          <option value="budaya">Budaya & Sejarah</option>
        </select>
      </div>
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
        <div class="filter-label">Harga:</div>
        <select class="filter-select">
          <option value="">Semua Harga</option>
          <option value="budget">Budget (< Rp 100rb)</option>
          <option value="medium">Medium (Rp 100rb - 500rb)</option>
          <option value="premium">Premium (> Rp 500rb)</option>
        </select>
      </div>
      <div class="filter-group">
        <button class="filter-button">Terapkan Filter</button>
      </div>
    </div>
  </section>

  <!-- Featured Destinations -->
  <section class="container">
    <div class="section-heading">
      <h2>Destinasi Populer</h2>
      <p>Temukan destinasi wisata terpopuler yang wajib dikunjungi di Indonesia</p>
    </div>

    <div class="destinations-grid">
      <!-- Destination 1: Bromo -->
      <div class="destination-card">
        <div class="card-image" style="position: relative;">
          <img src="https://source.unsplash.com/800x600/?bromo" alt="Gunung Bromo">
          <span class="card-badge">Populer</span>
        </div>
        <div class="card-content">
          <h3>Gunung Bromo</h3>
          <div class="card-location">
            <i class="fas fa-map-marker-alt"></i> Jawa Timur
          </div>
          <div class="card-rating">
            <div class="stars">★★★★★</div>
            <div class="count">(218 ulasan)</div>
          </div>
          <div class="card-description">
            Nikmati keindahan sunrise yang menakjubkan dan lanskap kawah aktif di destinasi ikonik Indonesia ini.
          </div>
          <div class="card-meta">
            <div class="card-price">
              Rp 27.500 <span>/orang (WNI)</span>
            </div>
            <a href="detail_destinasi.php?id=bromo" class="card-button">Lihat Detail</a>
          </div>
        </div>
      </div>

      <!-- Destination 2: Raja Ampat -->
      <div class="destination-card">
        <div class="card-image">
          <img src="https://source.unsplash.com/800x600/?raja,ampat" alt="Raja Ampat">
        </div>
        <div class="card-content">
          <h3>Raja Ampat</h3>
          <div class="card-location">
            <i class="fas fa-map-marker-alt"></i> Papua Barat
          </div>
          <div class="card-rating">
            <div class="stars">★★★★★</div>
            <div class="count">(189 ulasan)</div>
          </div>
          <div class="card-description">
            Surga bawah laut dengan keanekaragaman hayati terkaya di dunia yang menawarkan pengalaman snorkeling dan diving terbaik.
          </div>
          <div class="card-meta">
            <div class="card-price">
              Rp 500.000 <span>/orang</span>
            </div>
            <a href="detail_destinasi.php?id=raja-ampat" class="card-button">Lihat Detail</a>
          </div>
        </div>
      </div>

      <!-- Destination 3: Borobudur -->
      <div class="destination-card">
        <div class="card-image">
          <img src="https://source.unsplash.com/800x600/?borobudur" alt="Candi Borobudur">
        </div>
        <div class="card-content">
          <h3>Candi Borobudur</h3>
          <div class="card-location">
            <i class="fas fa-map-marker-alt"></i> Jawa Tengah
          </div>
          <div class="card-rating">
            <div class="stars">★★★★☆</div>
            <div class="count">(176 ulasan)</div>
          </div>
          <div class="card-description">
            Kunjungi candi Budha terbesar di dunia yang dibangun pada abad ke-9 dengan arsitektur dan relief yang mengagumkan.
          </div>
          <div class="card-meta">
            <div class="card-price">
              Rp 50.000 <span>/orang (WNI)</span>
            </div>
            <a href="detail_destinasi.php?id=borobudur" class="card-button">Lihat Detail</a>
          </div>
        </div>
      </div>

      <!-- Destination 4: Komodo -->
      <div class="destination-card">
        <div class="card-image" style="position: relative;">
          <img src="https://source.unsplash.com/800x600/?komodo,dragon" alt="Taman Nasional Komodo">
          <span class="card-badge">Premium</span>
        </div>
        <div class="card-content">
          <h3>Taman Nasional Komodo</h3>
          <div class="card-location">
            <i class="fas fa-map-marker-alt"></i> Nusa Tenggara Timur
          </div>
          <div class="card-rating">
            <div class="stars">★★★★★</div>
            <div class="count">(145 ulasan)</div>
          </div>
          <div class="card-description">
            Kunjungi habitat asli kadal terbesar di dunia dan nikmati pemandangan pantai Pink yang menakjubkan.
          </div>
          <div class="card-meta">
            <div class="card-price">
              Rp 150.000 <span>/orang (WNI)</span>
            </div>
            <a href="detail_destinasi.php?id=komodo" class="card-button">Lihat Detail</a>
          </div>
        </div>
      </div>

      <!-- Destination 5: Danau Toba -->
      <div class="destination-card">
        <div class="card-image">
          <img src="https://source.unsplash.com/800x600/?toba,lake" alt="Danau Toba">
        </div>
        <div class="card-content">
          <h3>Danau Toba</h3>
          <div class="card-location">
            <i class="fas fa-map-marker-alt"></i> Sumatra Utara
          </div>
          <div class="card-rating">
            <div class="stars">★★★★☆</div>
            <div class="count">(132 ulasan)</div>
          </div>
          <div class="card-description">
            Nikmati keindahan danau vulkanik terbesar di dunia dengan Pulau Samosir di tengahnya dan budaya Batak yang kental.
          </div>
          <div class="card-meta">
            <div class="card-price">
              Rp 15.000 <span>/orang</span>
            </div>
            <a href="detail_destinasi.php?id=danau-toba" class="card-button">Lihat Detail</a>
          </div>
        </div>
      </div>

      <!-- Destination 6: Labuan Bajo -->
      <div class="destination-card">
        <div class="card-image">
          <img src="https://source.unsplash.com/800x600/?labuan,bajo" alt="Labuan Bajo">
        </div>
        <div class="card-content">
          <h3>Labuan Bajo</h3>
          <div class="card-location">
            <i class="fas fa-map-marker-alt"></i> Nusa Tenggara Timur
          </div>
          <div class="card-rating">
            <div class="stars">★★★★★</div>
            <div class="count">(120 ulasan)</div>
          </div>
          <div class="card-description">
            Pintu gerbang menuju Taman Nasional Komodo dengan pemandangan sunset terbaik dan tempat diving yang menakjubkan.
          </div>
          <div class="card-meta">
            <div class="card-price">
              Rp 25.000 <span>/orang</span>
            </div>
            <a href="detail_destinasi.php?id=labuan-bajo" class="card-button">Lihat Detail</a>
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

  <!-- Popular Categories -->
  <section class="categories-section">
    <div class="container">
      <div class="section-heading">
        <h2>Kategori Populer</h2>
        <p>Temukan berbagai jenis destinasi wisata sesuai dengan minat perjalanan Anda</p>
      </div>

      <div class="categories-container">
        <div class="category-card">
          <div class="category-icon">
            <i class="fas fa-umbrella-beach"></i>
          </div>
          <div class="category-name">Pantai</div>
          <div class="category-count">48 Destinasi</div>
        </div>

        <div class="category-card">
          <div class="category-icon">
            <i class="fas fa-mountain"></i>
          </div>
          <div class="category-name">Gunung</div>
          <div class="category-count">36 Destinasi</div>
        </div>

        <div class="category-card">
          <div class="category-icon">
            <i class="fas fa-water"></i>
          </div>
          <div class="category-name">Air Terjun</div>
          <div class="category-count">29 Destinasi</div>
        </div>

        <div class="category-card">
          <div class="category-icon">
            <i class="fas fa-landmark"></i>
          </div>
          <div class="category-name">Budaya & Sejarah</div>
          <div class="category-count">42 Destinasi</div>
        </div>

        <div class="category-card">
          <div class="category-icon">
            <i class="fas fa-campground"></i>
          </div>
          <div class="category-name">Wisata Alam</div>
          <div class="category-count">53 Destinasi</div>
        </div>
      </div>
    </div>
  </section>

  <!-- Newsletter -->
  <section class="newsletter-section">
    <div class="newsletter-container">
      <h2>Dapatkan Informasi Terbaru</h2>
      <p>Berlangganan newsletter kami untuk mendapatkan informasi dan penawaran spesial tentang destinasi wisata terbaru di Indonesia</p>
      <form class="newsletter-form">
        <input type="email" placeholder="Masukkan email Anda">
        <button type="submit">Berlangganan</button>
      </form>
    </div>
  </section>

  <?php include 'Komponen/footer.php'; ?>
</body>
</html>