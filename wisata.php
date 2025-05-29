<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Destinasi Wisata</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
    /* Hero Section */
    .hero {
      background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), 
                  url('https://www.nativeindonesia.com/foto/2024/07/pantai-tanjung-kodok-1.jpg') no-repeat center center/cover;
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
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    .destination-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    .card-image {
      height: 200px;
      overflow: hidden;
      position: relative;
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
      flex-grow: 1;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
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
       margin-top: auto;
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

    /* Wishlist Button Styles */
    .wishlist-button {
      position: absolute;
      top: 1rem;
      left: 1rem;
      background-color: rgba(255, 255, 255, 0.8);
      border: none;
      width: 36px;
      height: 36px;
      border-radius: 50%;
      display: flex;
      justify-content: center;
      align-items: center;
      cursor: pointer;
      transition: all 0.3s ease;
      z-index: 2;
    }

    .wishlist-button i {
      color: #ff6b6b;
      font-size: 1.2rem;
      transition: all 0.3s ease;
    }

    .wishlist-button:hover {
      background-color: white;
    }

    .wishlist-button:hover i {
      color: #ff5252;
      transform: scale(1.1);
    }

    .wishlist-button.active i {
      color: #ff6b6b;
      font-weight: 900;
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
    <h1>Jelajahi Keindahan Pulau Jawa</h1>
    <p>Temukan destinasi wisata terbaik di Pulau Jawa, dari pantai eksotis hingga tempat hiburan yang menyenangkan</p>
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
          <option value="all">Semua Kategori</option>
          <option value="pantai">Pantai</option>
          <option value="budaya">Budaya & Sejarah</option>
          <option value="hiburan">Wisata Hiburan</option>
        </select>
      </div>
      <div class="filter-group">
        <div class="filter-label">Lokasi:</div>
        <select class="filter-select">
          <option value="">Semua Lokasi</option>
          <option value="bali">Lamongan</option>
          <option value="jawa">Jakarta</option>
          <option value="sumatra">Bangkalan</option>
          <option value="kalimantan">Surabaya</option>
          <option value="sulawesi">Pamekasan</option>
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
      <p>Temukan destinasi wisata terpopuler yang wajib dikunjungi di Pulau Jawa</p>
    </div>

    <div class="destinations-grid">
      <!-- Destination 1: Pantai Tanjung Kodok -->
      <div class="destination-card">
        <div class="card-image">
          <img src="https://www.nativeindonesia.com/foto/2024/07/pantai-tanjung-kodok-1.jpg" alt="Pantai Tanjung Kodok">
          <button class="wishlist-button">
            <i class="far fa-heart"></i>
          </button>
        </div>
        <div class="card-content">
          <h3>Pantai Tanjung Kodok</h3>
          <div class="card-location">
            <i class="fas fa-map-marker-alt"></i> Lamongan
          </div>
          <div class="card-rating">
            <div class="stars">★★★★★</div>
            <div class="count">(218 ulasan)</div>
          </div>
          <div class="card-description">
            Nikmati keindahan sunrise yang menakjubkan di destinasi ikonik Indonesia ini.
          </div>
          <div class="card-meta">
            <a href="wisata_detail.php" class="card-button">Lihat Detail</a>
          </div>
        </div>
      </div>

      <!-- Destination 2: Pantai Lorena -->
      <div class="destination-card">
        <div class="card-image">
          <img src="https://www.nativeindonesia.com/foto/2024/07/sunset-di-pantai-lorena.jpg" alt="Pantai Lorena">
          <button class="wishlist-button">
            <i class="far fa-heart"></i>
          </button>
        </div>
        <div class="card-content">
          <h3>Pantai Lorena</h3>
          <div class="card-location">
            <i class="fas fa-map-marker-alt"></i> Lamongan
          </div>
          <div class="card-rating">
            <div class="stars">★★★★★</div>
            <div class="count">(189 ulasan)</div>
          </div>
          <div class="card-description">
            Surga bawah laut dengan keanekaragaman hayati terkaya di dunia yang menawarkan pengalaman snorkeling dan diving terbaik.
          </div>
          <div class="card-meta">
            <a href="detail_destinasi.php?id=raja-ampat" class="card-button">Lihat Detail</a>
          </div>
        </div>
      </div>

      <!-- Destination 3: Indonesian Islamic Art Museum -->
      <div class="destination-card">
        <div class="card-image">
          <img src="https://salsawisata.com/wp-content/uploads/2022/07/Indonesian-Islamic-Art-Museum.jpg" alt="Indonesian Islamic Art Museum">
          <button class="wishlist-button">
            <i class="far fa-heart"></i>
          </button>
        </div>
        <div class="card-content">
          <h3>Indonesian Islamic Art Museum</h3>
          <div class="card-location">
            <i class="fas fa-map-marker-alt"></i> Lamongan
          </div>
          <div class="card-rating">
            <div class="stars">★★★★☆</div>
            <div class="count">(176 ulasan)</div>
          </div>
          <div class="card-description">
            sebuah jendela yang memukau untuk memahami kekayaan seni dan budaya Islam di Indonesia. 
          </div>
          <div class="card-meta">
            <a href="detail_destinasi.php?id=borobudur" class="card-button">Lihat Detail</a>
          </div>
        </div>
      </div>

      <!-- Destination 4: Wisata Bahari Lamongan -->
      <div class="destination-card">
        <div class="card-image">
          <img src="https://salsawisata.com/wp-content/uploads/2022/07/Wisata-Bahari-Lamongan.jpg" alt="Wisata Bahari Lamongan">
          <button class="wishlist-button">
            <i class="far fa-heart"></i>
          </button>
        </div>
        <div class="card-content">
          <h3>Wisata Bahari Lamongan</h3>
          <div class="card-location">
            <i class="fas fa-map-marker-alt"></i> Lamongan
          </div>
          <div class="card-rating">
            <div class="stars">★★★★★</div>
            <div class="count">(145 ulasan)</div>
          </div>
          <div class="card-description">
            Dengan konsep taman rekreasi keluarga, WBL menyediakan fasilitas lengkap seperti area bermain anak, restoran dengan beragam pilihan kuliner, toko suvenir, dan area parkir yang luas.
          </div>
          <div class="card-meta">
            <a href="detail_destinasi.php?id=komodo" class="card-button">Lihat Detail</a>
          </div>
        </div>
      </div>

      <!-- Destination 5: WBL DAN MZG -->
      <div class="destination-card">
        <div class="card-image">
          <img src="https://tugujatim.id/wp-content/uploads/2023/10/WhatsApp-Image-2023-10-20-at-16.12.53.jpeg" alt="WBL DAN MZG">
          <button class="wishlist-button">
            <i class="far fa-heart"></i>
          </button>
        </div>
        <div class="card-content">
          <h3>WBL DAN MZG</h3>
          <div class="card-location">
            <i class="fas fa-map-marker-alt"></i> Lamongan
          </div>
          <div class="card-rating">
            <div class="stars">★★★★☆</div>
            <div class="count">(132 ulasan)</div>
          </div>
          <div class="card-description">
            Rasakan pengalaman liburan ganda yang tak terlupakan dengan mengunjungi dua destinasi unggulan Lamongan sekaligus: Wisata Bahari Lamongan (WBL) dan Maharani Zoo & Goa (MZG)! 
          </div>
          <div class="card-meta">
            <a href="detail_destinasi.php?id=danau-toba" class="card-button">Lihat Detail</a>
          </div>
        </div>
      </div>

      <!-- Destination 6: Taman Mini Indonesia Indah -->
      <div class="destination-card">
        <div class="card-image">
          <img src="https://anekatempatwisata.com/wp-content/uploads/2018/04/Taman-Mini-Indonesia-Indah-610x407.jpg" alt="Taman Mini Indonesia Indah">
          <button class="wishlist-button">
            <i class="far fa-heart"></i>
          </button>
        </div>
        <div class="card-content">
          <h3>Taman Mini Indonesia Indah</h3>
          <div class="card-location">
            <i class="fas fa-map-marker-alt"></i> Jakarta
          </div>
          <div class="card-rating">
            <div class="stars">★★★★★</div>
            <div class="count">(120 ulasan)</div>
          </div>
          <div class="card-description">
            Selamat datang di Taman Mini Indonesia Indah (TMII), sebuah miniatur megah yang menampilkan kekayaan budaya dan keindahan alam dari 34 provinsi di Indonesia.
          </div>
          <div class="card-meta">
            <a href="detail_destinasi.php?id=labuan-bajo" class="card-button">Lihat Detail</a>
          </div>
        </div>
      </div>

      <!-- Destination 7: Museum Nasional Indonesia -->
      <div class="destination-card">
        <div class="card-image">
          <img src="https://anekatempatwisata.com/wp-content/uploads/2018/04/Museum-Nasional-Indonesia-610x610.jpg" alt="Museum Nasional Indonesia">
          <button class="wishlist-button">
            <i class="far fa-heart"></i>
          </button>
        </div>
        <div class="card-content">
          <h3>Museum Nasional Indonesia</h3>
          <div class="card-location">
            <i class="fas fa-map-marker-alt"></i> Jakarta
          </div>
          <div class="card-rating">
            <div class="stars">★★★★★</div>
            <div class="count">(120 ulasan)</div>
          </div>
          <div class="card-description">
            Selamat datang di Museum Nasional Indonesia, yang juga dikenal sebagai Museum Gajah. Berlokasi di jantung Jakarta Pusat, museum ini adalah yang terbesar dan terlengkap di Indonesia, menyimpan khazanah tak ternilai dari warisan arkeologi, sejarah, etnografi, dan seni bangsa.
          </div>
          <div class="card-meta">
            <a href="detail_destinasi.php?id=labuan-bajo" class="card-button">Lihat Detail</a>
          </div>
        </div>
      </div>
      
      <!-- Destination 8: Jakarta Aquarium -->
      <div class="destination-card">
        <div class="card-image">
          <img src="https://anekatempatwisata.com/wp-content/uploads/2018/04/Jakarta-Aquarium-loop.jpg" alt="Jakarta Aquarium">
          <button class="wishlist-button">
            <i class="far fa-heart"></i>
          </button>
        </div>
        <div class="card-content">
          <h3>Jakarta Aquarium</h3>
          <div class="card-location">
            <i class="fas fa-map-marker-alt"></i> Jakarta
          </div>
          <div class="card-rating">
            <div class="stars">★★★★★</div>
            <div class="count">(120 ulasan)</div>
          </div>
          <div class="card-description">
            Selamat datang di Jakarta Aquarium & Safari, sebuah destinasi wisata yang memukau di tengah hiruk pikuk ibu kota! Di sini, Anda akan diajak dalam perjalanan yang menakjubkan untuk menjelajahi keindahan bawah laut Indonesia dan berbagai satwa eksotis dari seluruh dunia.
          </div>
          <div class="card-meta">
            <a href="detail_destinasi.php?id=labuan-bajo" class="card-button">Lihat Detail</a>
          </div>
        </div>
      </div>
      
      <!-- Destination 9: Monumen Nasional -->
      <div class="destination-card">
        <div class="card-image">
          <img src="https://anekatempatwisata.com/wp-content/uploads/2018/04/Monumen-Nasional-610x406.jpg" alt="Monumen Nasional">
          <button class="wishlist-button">
            <i class="far fa-heart"></i>
          </button>
        </div>
        <div class="card-content">
          <h3>Monumen Nasional</h3>
          <div class="card-location">
            <i class="fas fa-map-marker-alt"></i> Jakarta
          </div>
          <div class="card-rating">
            <div class="stars">★★★★★</div>
            <div class="count">(120 ulasan)</div>
          </div>
          <div class="card-description">
            Selamat datang di Taman Mini Indonesia Indah (TMII), sebuah miniatur megah yang menampilkan kekayaan budaya dan keindahan alam dari 34 provinsi di Indonesia.
          </div>
          <div class="card-meta">
            <a href="detail_destinasi.php?id=labuan-bajo" class="card-button">Lihat Detail</a>
          </div>
        </div>
      </div>
      
      <!-- Destination 10: Dunia Fantasi, Pantai Ancol, dan Kota Tua Jakarta -->
      <div class="destination-card">
        <div class="card-image">
          <img src="https://anekatempatwisata.com/wp-content/uploads/2018/04/Dunia-Fantasi-klook.png" alt="Dunia Fantasi, Pantai Ancol, dan Kota Tua Jakarta">
          <button class="wishlist-button">
            <i class="far fa-heart"></i>
          </button>
        </div>
        <div class="card-content">
          <h3>Dunia Fantasi, Pantai Ancol, dan Kota Tua Jakarta</h3>
          <div class="card-location">
            <i class="fas fa-map-marker-alt"></i> Jakarta
          </div>
          <div class="card-rating">
            <div class="stars">★★★★★</div>
            <div class="count">(120 ulasan)</div>
          </div>
          <div class="card-description">
            Selamat datang di Taman Mini Indonesia Indah (TMII), sebuah miniatur megah yang menampilkan kekayaan budaya dan keindahan alam dari 34 provinsi di Indonesia.
          </div>
          <div class="card-meta">
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
            <i class="fa fa-theater-masks"></i>
          </div>
          <div class="category-name">Hiburan</div>
          <div class="category-count">29 Destinasi</div>
        </div>

        <div class="category-card">
          <div class="category-icon">
            <i class="fas fa-landmark"></i>
          </div>
          <div class="category-name">Budaya & Sejarah</div>
          <div class="category-count">42 Destinasi</div>
        </div>
    </div>
  

  <?php include 'Komponen/footer.php'; ?>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const wishlistButtons = document.querySelectorAll('.wishlist-button');
      
      wishlistButtons.forEach(button => {
        button.addEventListener('click', function() {
          const icon = this.querySelector('i');
          this.classList.toggle('active');
          
          if (this.classList.contains('active')) {
            icon.classList.remove('far');
            icon.classList.add('fas');
          } else {
            icon.classList.remove('fas');
            icon.classList.add('far');
          }
        });
      });
    });
  </script>
</body>
</html>