<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Filter Paket Wisata</title>
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
                  url('https://4.bp.blogspot.com/-_Np9OVi0EEU/VU3XHqemogI/AAAAAAAAA9g/QcUM52-qKws/s1600/1.jpg') no-repeat center center/cover;
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

    .filter-select, .filter-input {
      padding: 0.5rem 1rem;
      border-radius: 5px;
      border: 1px solid #ddd;
      background-color: #f9f9f9;
      cursor: pointer;
    }

    .filter-input {
      width: 120px;
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

    /* Paket Grid */
    .paket-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
      gap: 2rem;
      margin-bottom: 3rem;
    }

    .paket-card {
      background-color: #fff;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s, box-shadow 0.3s;
      color: inherit;
    }

    .paket-card:hover {
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

    .paket-card:hover .card-image img {
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
      text-transform: capitalize;
    }

    .card-badge.standar {
      background-color: #28a745;
    }

    .card-badge.deluxe {
      background-color: #ffc107;
      color: #333;
    }

    .card-badge.premium {
      background-color: #007bff;
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
      text-transform: capitalize;
    }

    .card-location i {
      margin-right: 0.5rem;
      color: #2c7a51;
    }

    .card-meta {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding-top: 1rem;
      border-top: 1px solid #eee;
      margin-bottom: 1rem;
    }

    .card-price {
      font-weight: bold;
      color: #2c7a51;
      font-size: 1.1rem;
    }

    .card-category {
      background-color: #f8f9fa;
      color: #495057;
      padding: 0.25rem 0.5rem;
      border-radius: 15px;
      font-size: 0.8rem;
      text-transform: capitalize;
    }

    /* Detail Button */
    .detail-button {
      width: 100%;
      background-color: #2c7a51;
      color: white;
      border: none;
      padding: 0.75rem 1rem;
      border-radius: 8px;
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      transition: background-color 0.3s, transform 0.2s;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
    }

    .detail-button:hover {
      background-color: #1d5b3a;
      transform: translateY(-2px);
    }

    .detail-button:active {
      transform: translateY(0);
    }

    /* Results Counter */
    .results-counter {
      text-align: center;
      margin: 2rem 0;
      color: #666;
      font-size: 1.1rem;
    }

    /* No Results */
    .no-results {
      text-align: center;
      padding: 3rem;
      color: #666;
    }

    .no-results i {
      font-size: 4rem;
      color: #ddd;
      margin-bottom: 1rem;
    }

    .no-results h3 {
      margin-bottom: 0.5rem;
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

      .filter-select, .filter-input {
        width: 100%;
      }

      .paket-grid {
        grid-template-columns: 1fr;
      }
    }

    .hidden {
      display: none !important;
    }
  </style>
</head>
<body>
  <?php include 'Komponen/navbar.php'; ?>
  <!-- Hero Section -->
  <section class="hero">
    <h1>Paket Wisata</h1>
    <p>Pilih berdasarkan Wilayah, Harga, dan Kategori</p>
  </section>

  <!-- Filter Section -->
  <section class="filter-section">
    <div class="filter-container">
      <div class="filter-group">
        <div class="filter-label">Wilayah:</div>
        <select id="wilayah" class="filter-select">
          <option value="all">Semua Wilayah</option>
          <option value="lamongan">Lamongan</option>
          <option value="jakarta">Jakarta</option>
          <option value="bangkalan">Bangkalan</option>
          <option value="surabaya">Surabaya</option>
          <option value="Pamekasan">Pamekasan</option>
        </select>
      </div>
      <div class="filter-group">
        <div class="filter-label">Kategori:</div>
        <select id="kategori" class="filter-select">
          <option value="">Semua Kategori</option>
          <option value="pantai">Pantai</option>
          <option value="gunung">Gunung</option>
          <option value="air-terjun">Air Terjun</option>
          <option value="danau">Danau</option>
          <option value="budaya">Budaya & Sejarah</option>
          <option value="hiburan">hiburan & Edukasi</option>
        </select>
      </div>
      <div class="filter-group">
        <div class="filter-label">Harga Maks:</div>
        <input type="number" id="maxHarga" class="filter-input" placeholder="Rp">
      </div>
      <div class="filter-group">
        <button class="filter-button" onclick="applyFilters()">Terapkan Filter</button>
      </div>
    </div>
  </section>

  <!-- Featured Packages -->
  <section class="container">
    <div class="section-heading">
      <h2>Paket Wisata Populer</h2>
      <p>Temukan paket wisata terbaik sesuai dengan budget dan preferensi Anda</p>
    </div>

    <div class="results-counter" id="resultsCounter">
      Menampilkan <span id="resultCount">15</span> paket wisata
    </div>

    <div id="paketContainer" class="paket-grid">
      <!-- Lamongan Packages -->
      <div class="paket-card lamongan pantai" data-harga="30000">
        <div class="card-image">
          <img src="https://www.nativeindonesia.com/foto/2024/07/pantai-tanjung-kodok-1.jpg" alt="Pantai Tanjung Kodok">
        </div>
        <div class="card-content">
          <h3>Pantai Tanjung Kodok</h3>
          <div class="card-location">
            <i class="fas fa-map-marker-alt"></i> Lamongan
          </div>
          <div class="card-meta">
            <div class="card-price">Rp 30.000</div>
          </div>
          <button class="detail-button" onclick="viewDetail('pantai-tanjung-kodok')">
            <i class="fas fa-eye"></i>
            Lihat Detail
          </button>
        </div>
      </div>

      <div class="paket-card lamongan pantai" data-harga="20000">
        <div class="card-image">
          <img src="https://www.nativeindonesia.com/foto/2024/07/sunset-di-pantai-lorena.jpg" alt="Pantai Lorena">
        </div>
        <div class="card-content">
          <h3>Pantai Lorena</h3>
          <div class="card-location">
            <i class="fas fa-map-marker-alt"></i> Lamongan
          </div>
          <div class="card-meta">
            <div class="card-price">Rp 20.000</div>
          </div>
          <button class="detail-button" onclick="viewDetail('pantai-lorena')">
            <i class="fas fa-eye"></i>
            Lihat Detail
          </button>
        </div>
      </div>

      <div class="paket-card lamongan budaya" data-harga="50000">
        <div class="card-image">
          <img src="https://salsawisata.com/wp-content/uploads/2022/07/Indonesian-Islamic-Art-Museum.jpg" alt="Indonesian Islamic Art Museum">
        </div>
        <div class="card-content">
          <h3>Indonesian Islamic Art Museum</h3>
          <div class="card-location">
            <i class="fas fa-map-marker-alt"></i> Lamongan
          </div>
          <div class="card-meta">
            <div class="card-price">Rp 50.000</div>
          </div>
          <button class="detail-button" onclick="viewDetail('islamic-art-museum')">
            <i class="fas fa-eye"></i>
            Lihat Detail
          </button>
        </div>
      </div>

      <div class="paket-card lamongan hiburan" data-harga="200000">
        <div class="card-image">
          <img src="https://salsawisata.com/wp-content/uploads/2022/07/Wisata-Bahari-Lamongan.jpg" alt="Wisata Bahari Lamongan">
        </div>
        <div class="card-content">
          <h3>Wisata Bahari Lamongan</h3>
          <div class="card-location">
            <i class="fas fa-map-marker-alt"></i> Lamongan
          </div>
          <div class="card-meta">
            <div class="card-price">Rp 200.000</div>
          </div>
          <button class="detail-button" onclick="viewDetail('wisata-bahari-lamongan')">
            <i class="fas fa-eye"></i>
            Lihat Detail
          </button>
        </div>
      </div>

      <div class="paket-card lamongan hiburan" data-harga="2500000">
        <div class="card-image">
          <img src="https://tugujatim.id/wp-content/uploads/2023/10/WhatsApp-Image-2023-10-20-at-16.12.53.jpeg" alt="WBL DAN MZG">
        </div>
        <div class="card-content">
          <h3>Maharani Zoo And Goa</h3>
          <div class="card-location">
            <i class="fas fa-map-marker-alt"></i> Lamongan
          </div>
          <div class="card-meta">
            <div class="card-price">Rp 2.500.000</div>
          </div>
          <button class="detail-button" onclick="viewDetail('wbl-dan-mzg')">
            <i class="fas fa-eye"></i>
            Lihat Detail
          </button>
        </div>
      </div>

      <!-- Jakarta Packages -->
      <div class="paket-card jakarta hiburan" data-harga="70000">
        <div class="card-image">
          <img src="https://anekatempatwisata.com/wp-content/uploads/2018/04/Taman-Mini-Indonesia-Indah-610x407.jpg" alt="Taman Mini Indonesia Indah">
        </div>
        <div class="card-content">
          <h3>Taman Mini Indonesia Indah</h3>
          <div class="card-location">
            <i class="fas fa-map-marker-alt"></i> Jakarta
          </div>
          <div class="card-meta">
            <div class="card-price">Rp 70.000</div>
          </div>
          <button class="detail-button" onclick="viewDetail('taman-mini')">
            <i class="fas fa-eye"></i>
            Lihat Detail
          </button>
        </div>
      </div>

      <div class="paket-card jakarta budaya" data-harga="1400000">
        <div class="card-image">
          <img src="https://anekatempatwisata.com/wp-content/uploads/2018/04/Museum-Nasional-Indonesia-610x610.jpg" alt="Museum Nasional Indonesia">
        </div>
        <div class="card-content">
          <h3>Museum Nasional Indonesia</h3>
          <div class="card-location">
            <i class="fas fa-map-marker-alt"></i> Jakarta
          </div>
          <div class="card-meta">
            <div class="card-price">Rp 1.400.000</div>
          </div>
          <button class="detail-button" onclick="viewDetail('museum-nasional')">
            <i class="fas fa-eye"></i>
            Lihat Detail
          </button>
        </div>
      </div>

      <div class="paket-card jakarta hiburan" data-harga="1200000">
        <div class="card-image">
          <img src="https://anekatempatwisata.com/wp-content/uploads/2018/04/Jakarta-Aquarium-loop.jpg" alt="Jakarta Aquarium">
        </div>
        <div class="card-content">
          <h3>Jakarta Aquarium</h3>
          <div class="card-location">
            <i class="fas fa-map-marker-alt"></i> Jakarta
          </div>
          <div class="card-meta">
            <div class="card-price">Rp 1.200.000</div>
          </div>
          <button class="detail-button" onclick="viewDetail('jakarta-aquarium')">
            <i class="fas fa-eye"></i>
            Lihat Detail
          </button>
        </div>
      </div>

      <div class="paket-card jakarta budaya" data-harga="1400000">
        <div class="card-image">
          <img src="https://anekatempatwisata.com/wp-content/uploads/2018/04/Monumen-Nasional-610x406.jpg" alt="Monumen Nasional">
        </div>
        <div class="card-content">
          <h3>Monumen Nasional</h3>
          <div class="card-location">
            <i class="fas fa-map-marker-alt"></i> Jakarta
          </div>
          <div class="card-meta">
            <div class="card-price">Rp 1.400.000</div>
          </div>
          <button class="detail-button" onclick="viewDetail('monumen-nasional')">
            <i class="fas fa-eye"></i>
            Lihat Detail
          </button>
        </div>
      </div>

      <div class="paket-card jakarta pantai" data-harga="1800000">
        <div class="card-image">
          <img src="https://anekatempatwisata.com/wp-content/uploads/2018/04/Dunia-Fantasi-klook.png" alt="Dunia Fantasi, Pantai Ancol, dan Kota Tua Jakarta">
        </div>
        <div class="card-content">
          <h3>Dunia Fantasi, Pantai Ancol, dan Kota Tua Jakarta</h3>
          <div class="card-location">
            <i class="fas fa-map-marker-alt"></i> Jakarta
          </div>
          <div class="card-meta">
            <div class="card-price">Rp 1.800.000</div>
          </div>
          <button class="detail-button" onclick="viewDetail('dufan-ancol-kotatua')">
            <i class="fas fa-eye"></i>
            Lihat Detail
          </button>
        </div>
      </div>

      <!-- Bangkalan Packages -->
      <div class="paket-card bangkalan pantai" data-harga="1800000">
        <div class="card-image">
          <img src="https://www.nativeindonesia.com/foto/2024/03/pantai-pasir-putih-tlongoh.jpg" alt="Pantai Pasir Putih Tlangoh">
        </div>
        <div class="card-content">
          <h3>Pantai Pasir Putih Tlangoh</h3>
          <div class="card-location">
            <i class="fas fa-map-marker-alt"></i> Bangkalan
          </div>
          <div class="card-meta">
            <div class="card-price">Rp 1.800.000</div>
          </div>
          <button class="detail-button" onclick="viewDetail('pantai-tlangoh')">
            <i class="fas fa-eye"></i>
            Lihat Detail
          </button>
        </div>
      </div>

      <div class="paket-card bangkalan budaya" data-harga="1800000">
        <div class="card-image">
          <img src="https://dimadura.id/wp-content/uploads/2025/04/Mercusuar-Sembilangan_Wisata-Sejarah-di-Bangkalan_-1.jpg" alt="Mercusuar Sembilangan">
        </div>
        <div class="card-content">
          <h3>Mercusuar Sembilangan</h3>
          <div class="card-location">
            <i class="fas fa-map-marker-alt"></i> Bangkalan
          </div>
          <div class="card-meta">
            <div class="card-price">Rp 1.800.000</div>
          </div>
          <button class="detail-button" onclick="viewDetail('mercusuar-sembilangan')">
            <i class="fas fa-eye"></i>
            Lihat Detail
          </button>
        </div>
      </div>

      <div class="paket-card bangkalan hiburan" data-harga="1800000">
        <div class="card-image">
          <img src="https://labuhanmangrove.files.wordpress.com/2019/09/whatsapp-image-2019-09-11-at-10.58.31-1.jpeg" alt="Labuhan Mangrove Educational Park">
        </div>
        <div class="card-content">
          <h3>Labuhan Mangrove Educational Park</h3>
          <div class="card-location">
            <i class="fas fa-map-marker-alt"></i> Bangkalan
          </div>
          <div class="card-meta">
            <div class="card-price">Rp 1.800.000</div>
          </div>
          <button class="detail-button" onclick="viewDetail('labuhan-mangrove')">
            <i class="fas fa-eye"></i>
            Lihat Detail
          </button>
        </div>
      </div>

      <div class="paket-card bangkalan pantai" data-harga="1800000">
        <div class="card-image">
          <img src="https://dimadura.id/wp-content/uploads/2025/04/Pantai-Rongkang-Bangkalan-Madura-IG-geonerations-700x400.jpg" alt="Pantai Rongkang">
        </div>
        <div class="card-content">
          <h3>Pantai Rongkang</h3>
          <div class="card-location">
            <i class="fas fa-map-marker-alt"></i> Bangkalan
          </div>
          <div class="card-meta">
            <div class="card-price">Rp 1.800.000</div>
          </div>
          <button class="detail-button" onclick="viewDetail('pantai-rongkang')">
            <i class="fas fa-eye"></i>
            Lihat Detail
          </button>
        </div>
      </div>

      <div class="paket-card bangkalan pantai" data-harga="1800000">
        <div class="card-image">
          <img src="https://superapp.id/blog/wp-content/uploads/2024/06/iqbal-alfaa-QAQBN3lkBfM-unsplash-scaled-e1718268961766-1440x720.jpg" alt="Pantai Sembilan, Pantai Pasir Putih Tlangoh, dan Labuhan Mangrove Educational Park">
        </div>
        <div class="card-content">
          <h3>Pantai Sembilan, Pantai Pasir Putih Tlangoh, dan Labuhan Mangrove Educational Park</h3>
          <div class="card-location">
            <i class="fas fa-map-marker-alt"></i> Bangkalan
          </div>
          <div class="card-meta">
            <div class="card-price">Rp 1.800.000</div>
          </div>
          <button class="detail-button" onclick="viewDetail('bangkalan-combo')">
            <i class="fas fa-eye"></i>
            Lihat Detail
          </button>
        </div>
      </div>

      <div class="paket-card surabaya budaya" data-harga="1800000">
        <div class="card-image">
          <img src="https://res.klook.com/image/upload/fl_lossy.progressive,q_85/c_fill,w_1000/v1626756055/blog/mh867iuqf0eegifllqlc.webp" alt="Pantai Sembilan, Pantai Pasir Putih Tlangoh, dan Labuhan Mangrove Educational Park">
        </div>
        <div class="card-content">
          <h3>Museum 10 November</h3>
          <div class="card-location">
            <i class="fas fa-map-marker-alt"></i> Surabaya
          </div>
          <div class="card-meta">
            <div class="card-price">Rp 40.000</div>
          </div>
          <button class="detail-button" onclick="viewDetail('bangkalan-combo')">
            <i class="fas fa-eye"></i>
            Lihat Detail
          </button>
        </div>
      </div>

      <div class="paket-card pamekasan budaya" data-harga="1800000">
        <div class="card-image">
          <img src="https://blog.bookingtogo.com/wp-content/uploads/2022/06/Sunrise-di-Puncak-Ratu-Pamekasan-696x690.jpg" alt="Pantai Sembilan, Pantai Pasir Putih Tlangoh, dan Labuhan Mangrove Educational Park">
        </div>
        <div class="card-content">
          <h3>Puncak Ratu Pamekasan</h3>
          <div class="card-location">
            <i class="fas fa-map-marker-alt"></i> Pamekasan
          </div>
          <div class="card-meta">
            <div class="card-price">Rp 80.000</div>
          </div>
          <button class="detail-button" onclick="viewDetail('bangkalan-combo')">
            <i class="fas fa-eye"></i>
            Lihat Detail
          </button>
        </div>
      </div>
    </div>

    <!-- No Results Message -->
    <div id="noResults" class="no-results hidden">
      <i class="fas fa-search"></i>
      <h3>Tidak ada paket wisata yang ditemukan</h3>
      <p>Coba ubah kriteria pencarian Anda</p>
    </div>
  </section>
  <?php include 'Komponen/footer.php'; ?>
  <script>
    function applyFilters() {
      const wilayah = document.getElementById('wilayah').value;
      const kategori = document.getElementById('kategori').value;
      const maxHarga = document.getElementById('maxHarga').value;
      
      const cards = document.querySelectorAll('.paket-card');
      const container = document.getElementById('paketContainer');
      const noResults = document.getElementById('noResults');
      const resultCounter = document.getElementById('resultsCounter');
      const resultCount = document.getElementById('resultCount');
      
      let visibleCount = 0;

      cards.forEach(card => {
        let show = true;

        // Filter by wilayah
        if (wilayah !== 'all' && !card.classList.contains(wilayah)) {
          show = false;
        }

        // Filter by kategori
        if (kategori !== 'all' && !card.classList.contains(kategori)) {
          show = false;
        }

        // Filter by harga
        if (maxHarga && maxHarga !== '') {
          const cardHarga = parseInt(card.getAttribute('data-harga'));
          if (cardHarga > parseInt(maxHarga)) {
            show = false;
          }
        }

        if (show) {
          card.classList.remove('hidden');
          visibleCount++;
        } else {
          card.classList.add('hidden');
        }
      });

      // Update result counter and show/hide no results message
      resultCount.textContent = visibleCount;
      
      if (visibleCount === 0) {
        noResults.classList.remove('hidden');
        resultCounter.classList.add('hidden');
      } else {
        noResults.classList.add('hidden');
        resultCounter.classList.remove('hidden');
      }
    }

    function viewDetail(packageId) {
      // You can implement the detail view logic here
      // alert(`Viewing details for package: ${packageId}`);
      // In a real application, you might redirect to a detail page:
      window.location.href = `detail_paket_wisata.php`;
    }

    // Auto apply filters when select changes
    document.getElementById('wilayah').addEventListener('change', applyFilters);
    document.getElementById('kategori').addEventListener('change', applyFilters);
    document.getElementById('maxHarga').addEventListener('input', applyFilters);

    // Initialize with all items visible
    applyFilters();
  </script>
</body>
</html>