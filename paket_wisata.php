<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Paket Wisata</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="stylesheet" href="CSS/paket_wisata.css" />
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
          <option value="all">Semua Kategori</option>
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

      <div class="paket-card lamongan hiburan" data-harga="500000">
        <div class="card-image">
          <img src="https://tugujatim.id/wp-content/uploads/2023/10/WhatsApp-Image-2023-10-20-at-16.12.53.jpeg" alt="WBL DAN MZG">
        </div>
        <div class="card-content">
          <h3>Maharani Zoo And Goa</h3>
          <div class="card-location">
            <i class="fas fa-map-marker-alt"></i> Lamongan
          </div>
          <div class="card-meta">
            <div class="card-price">Rp 500.000</div>
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

      <div class="paket-card jakarta budaya" data-harga="200000">
        <div class="card-image">
          <img src="https://anekatempatwisata.com/wp-content/uploads/2018/04/Museum-Nasional-Indonesia-610x610.jpg" alt="Museum Nasional Indonesia">
        </div>
        <div class="card-content">
          <h3>Museum Nasional Indonesia</h3>
          <div class="card-location">
            <i class="fas fa-map-marker-alt"></i> Jakarta
          </div>
          <div class="card-meta">
            <div class="card-price">Rp 200.000</div>
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

      <div class="paket-card jakarta budaya" data-harga="100000">
        <div class="card-image">
          <img src="https://anekatempatwisata.com/wp-content/uploads/2018/04/Monumen-Nasional-610x406.jpg" alt="Monumen Nasional">
        </div>
        <div class="card-content">
          <h3>Monumen Nasional</h3>
          <div class="card-location">
            <i class="fas fa-map-marker-alt"></i> Jakarta
          </div>
          <div class="card-meta">
            <div class="card-price">Rp 100.000</div>
          </div>
          <button class="detail-button" onclick="viewDetail('monumen-nasional')">
            <i class="fas fa-eye"></i>
            Lihat Detail
          </button>
        </div>
      </div>

      <div class="paket-card jakarta pantai" data-harga="180000">
        <div class="card-image">
          <img src="https://anekatempatwisata.com/wp-content/uploads/2018/04/Dunia-Fantasi-klook.png" alt="ancol taman impian">
        </div>
        <div class="card-content">
          <h3>Ancol Taman Impian</h3>
          <div class="card-location">
            <i class="fas fa-map-marker-alt"></i> Jakarta
          </div>
          <div class="card-meta">
            <div class="card-price">Rp 180.000</div>
          </div>
          <button class="detail-button" onclick="viewDetail('dufan-ancol-kotatua')">
            <i class="fas fa-eye"></i>
            Lihat Detail
          </button>
        </div>
      </div>

      <!-- Bangkalan Packages -->
      <div class="paket-card bangkalan pantai" data-harga="30000">
        <div class="card-image">
          <img src="https://www.nativeindonesia.com/foto/2024/03/pantai-pasir-putih-tlongoh.jpg" alt="Pantai Pasir Putih Tlangoh">
        </div>
        <div class="card-content">
          <h3>Pantai Pasir Putih Tlangoh</h3>
          <div class="card-location">
            <i class="fas fa-map-marker-alt"></i> Bangkalan
          </div>
          <div class="card-meta">
            <div class="card-price">Rp 30.000</div>
          </div>
          <button class="detail-button" onclick="viewDetail('pantai-tlangoh')">
            <i class="fas fa-eye"></i>
            Lihat Detail
          </button>
        </div>
      </div>

      <div class="paket-card bangkalan budaya" data-harga="20000">
        <div class="card-image">
          <img src="https://dimadura.id/wp-content/uploads/2025/04/Mercusuar-Sembilangan_Wisata-Sejarah-di-Bangkalan_-1.jpg" alt="Mercusuar Sembilangan">
        </div>
        <div class="card-content">
          <h3>Mercusuar Sembilangan</h3>
          <div class="card-location">
            <i class="fas fa-map-marker-alt"></i> Bangkalan
          </div>
          <div class="card-meta">
            <div class="card-price">Rp 20.000</div>
          </div>
          <button class="detail-button" onclick="viewDetail('mercusuar-sembilangan')">
            <i class="fas fa-eye"></i>
            Lihat Detail
          </button>
        </div>
      </div>

      <div class="paket-card bangkalan hiburan" data-harga="35000">
        <div class="card-image">
          <img src="https://labuhanmangrove.files.wordpress.com/2019/09/whatsapp-image-2019-09-11-at-10.58.31-1.jpeg" alt="Labuhan Mangrove Educational Park">
        </div>
        <div class="card-content">
          <h3>Labuhan Mangrove Educational Park</h3>
          <div class="card-location">
            <i class="fas fa-map-marker-alt"></i> Bangkalan
          </div>
          <div class="card-meta">
            <div class="card-price">Rp 35.000</div>
          </div>
          <button class="detail-button" onclick="viewDetail('labuhan-mangrove')">
            <i class="fas fa-eye"></i>
            Lihat Detail
          </button>
        </div>
      </div>

      <div class="paket-card bangkalan pantai" data-harga="80.000">
        <div class="card-image">
          <img src="https://dimadura.id/wp-content/uploads/2025/04/Pantai-Rongkang-Bangkalan-Madura-IG-geonerations-700x400.jpg" alt="Pantai Rongkang">
        </div>
        <div class="card-content">
          <h3>Pantai Rongkang</h3>
          <div class="card-location">
            <i class="fas fa-map-marker-alt"></i> Bangkalan
          </div>
          <div class="card-meta">
            <div class="card-price">Rp 80.000</div>
          </div>
          <button class="detail-button" onclick="viewDetail('pantai-rongkang')">
            <i class="fas fa-eye"></i>
            Lihat Detail
          </button>
        </div>
      </div>

      <div class="paket-card bangkalan pantai" data-harga="1800000">
        <div class="card-image">
          <img src="https://hosnews.id/wp-content/uploads/2022/10/Wisata-Cafe-Kapal-Rindu-Bangkalan-1024x535.png?v=1665633171" alt="Pantai Sembilan, Pantai Pasir Putih Tlangoh, dan Labuhan Mangrove Educational Park">
        </div>
        <div class="card-content">
          <h3>Wisata Kapal Rindu</h3>
          <div class="card-location">
            <i class="fas fa-map-marker-alt"></i> Bangkalan
          </div>
          <div class="card-meta">
            <div class="card-price">Rp 1.000.000</div>
          </div>
          <button class="detail-button" onclick="viewDetail('bangkalan-combo')">
            <i class="fas fa-eye"></i>
            Lihat Detail
          </button>
        </div>
      </div>

      <div class="paket-card surabaya budaya" data-harga="1800000">
        <div class="card-image">
          <img src="https://res.klook.com/image/upload/fl_lossy.progressive,q_85/c_fill,w_1000/v1626756055/blog/mh867iuqf0eegifllqlc.webp" alt="Museum 10 November">
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
          <img src="https://blog.bookingtogo.com/wp-content/uploads/2022/06/Sunrise-di-Puncak-Ratu-Pamekasan-696x690.jpg" alt="Puncak Ratu Pamekasan">
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