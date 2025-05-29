<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Wishlist Destinasi Wisata</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
    /* Header */
    .wishlist-header {
      background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), 
                  url('https://www.ruparupa.com/blog/wp-content/uploads/2022/03/Jakarta_Batavia_%C2%A9-CEphoto-Uwe-Aranas.jpg') no-repeat center center/cover;
      height: 60vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      color: #fff;
      padding: 2rem;
      margin-top: 20px;
    }

    .wishlist-header h1 {
    margin-top: 50px;
      font-size: 3rem;
      margin-bottom: 1rem;
      text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);
    }

    .wishlist-header p {
      font-size: 1.2rem;
      max-width: 800px;
      margin-bottom: 2rem;
    }

    /* Container */
    .container {
      max-width: 1200px;
      margin: 2rem auto;
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

    /* Empty Wishlist State */
    .empty-wishlist {
      text-align: center;
      padding: 4rem 0;
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .empty-wishlist i {
      font-size: 5rem;
      color: #ff6b6b;
      margin-bottom: 1.5rem;
    }

    .empty-wishlist h3 {
      font-size: 1.8rem;
      margin-bottom: 1rem;
      color: #333;
    }

    .empty-wishlist p {
      color: #666;
      margin-bottom: 2rem;
      max-width: 500px;
      margin-left: auto;
      margin-right: auto;
    }

    .explore-button {
      background-color: #2c7a51;
      color: white;
      border: none;
      padding: 0.75rem 1.5rem;
      border-radius: 50px;
      cursor: pointer;
      transition: background-color 0.3s;
      text-decoration: none;
      display: inline-block;
      font-size: 1rem;
    }

    .explore-button:hover {
      background-color: #1d5b3a;
    }

    /* Destinations Grid */
    .destinations-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      gap: 2rem;
      margin-bottom: 3rem;
    }

    .destination-card {
      display: flex;
  flex-direction: column;
  justify-content: space-between;
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

    .remove-wishlist {
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

    .remove-wishlist i {
      color: #ff6b6b;
      font-size: 1.2rem;
      transition: all 0.3s ease;
    }

    .remove-wishlist:hover {
      background-color: white;
    }

    .remove-wishlist:hover i {
      color: #ff5252;
      transform: scale(1.1);
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
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding-top: 1rem;
      border-top: 1px solid #eee;
      margin-top: auto;
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

    /* Action Buttons */
    .wishlist-actions {
      display: flex;
      justify-content: space-between;
      margin-bottom: 2rem;
      padding: 1rem;
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .wishlist-count {
      font-weight: bold;
      color: #333;
    }

    .clear-wishlist {
      background-color: #ff6b6b;
      color: white;
      border: none;
      padding: 0.5rem 1rem;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .clear-wishlist:hover {
      background-color: #ff5252;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .wishlist-header h1 {
        font-size: 2.5rem;
      }

      .wishlist-actions {
        flex-direction: column;
        gap: 1rem;
      }
    }
  </style>
</head>
<body>
  <?php include 'Komponen/navbar.php'; ?>

  <!-- Wishlist Header -->
  <section class="wishlist-header">
    <h1>Wishlist Destinasi Wisata</h1>
    <p>Lihat dan kelola daftar destinasi impian Anda</p>
  </section>


  <!-- Wishlist Content -->
  <section class="container">
    <div class="wishlist-actions">
      <div class="wishlist-count">
        <i class="fas fa-heart" style="color: #ff6b6b;"></i> 5 Destinasi dalam wishlist
      </div>
      <button class="clear-wishlist">
        <i class="fas fa-trash-alt"></i> Kosongkan Wishlist
      </button>
    </div>

    <!-- Jika wishlist kosong -->
    <!-- <div class="empty-wishlist">
      <i class="far fa-heart"></i>
      <h3>Wishlist Anda Kosong</h3>
      <p>Anda belum menambahkan destinasi wisata ke dalam wishlist. Jelajahi destinasi menarik dan tambahkan ke wishlist untuk menyimpannya di sini.</p>
      <a href="destinasi.php" class="explore-button">Jelajahi Destinasi</a>
    </div> -->

    <!-- Jika wishlist berisi -->
    <div class="destinations-grid">
      <!-- Destination 1: Pantai Tanjung Kodok -->
      <div class="destination-card">
        <div class="card-image">
          <img src="https://www.nativeindonesia.com/foto/2024/07/pantai-tanjung-kodok-1.jpg" alt="Pantai Tanjung Kodok">
          <button class="remove-wishlist" title="Hapus dari wishlist">
            <i class="fas fa-heart"></i>
          </button>
          <span class="card-badge">Populer</span>
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
            <div class="card-price">Rp50.000 <span>/orang</span></div>
            <a href="detail_destinasi.php?id=bromo" class="card-button">Lihat Detail</a>
          </div>
        </div>
      </div>

      <!-- Destination 2: Pantai Lorena -->
      <div class="destination-card">
        <div class="card-image">
          <img src="https://www.nativeindonesia.com/foto/2024/07/sunset-di-pantai-lorena.jpg" alt="Pantai Lorena">
          <button class="remove-wishlist" title="Hapus dari wishlist">
            <i class="fas fa-heart"></i>
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
            <div class="card-price">Rp75.000 <span>/orang</span></div>
            <a href="detail_destinasi.php?id=raja-ampat" class="card-button">Lihat Detail</a>
          </div>
        </div>
      </div>

      <!-- Destination 3: Wisata Bahari Lamongan -->
      <div class="destination-card">
        <div class="card-image">
          <img src="https://salsawisata.com/wp-content/uploads/2022/07/Wisata-Bahari-Lamongan.jpg" alt="Wisata Bahari Lamongan">
          <button class="remove-wishlist" title="Hapus dari wishlist">
            <i class="fas fa-heart"></i>
          </button>
          <span class="card-badge">Populer</span>
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
            <div class="card-price">Rp100.000 <span>/orang</span></div>
            <a href="detail_destinasi.php?id=komodo" class="card-button">Lihat Detail</a>
          </div>
        </div>
      </div>

      <!-- Destination 4: Taman Mini Indonesia Indah -->
      <div class="destination-card">
        <div class="card-image">
          <img src="https://anekatempatwisata.com/wp-content/uploads/2018/04/Taman-Mini-Indonesia-Indah-610x407.jpg" alt="Taman Mini Indonesia Indah">
          <button class="remove-wishlist" title="Hapus dari wishlist">
            <i class="fas fa-heart"></i>
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
            <div class="card-price">Rp25.000 <span>/orang</span></div>
            <a href="detail_destinasi.php?id=labuan-bajo" class="card-button">Lihat Detail</a>
          </div>
        </div>
      </div>

      <!-- Destination 5: Museum Nasional Indonesia -->
      <div class="destination-card">
        <div class="card-image">
          <img src="https://anekatempatwisata.com/wp-content/uploads/2018/04/Museum-Nasional-Indonesia-610x610.jpg" alt="Museum Nasional Indonesia">
          <button class="remove-wishlist" title="Hapus dari wishlist">
            <i class="fas fa-heart"></i>
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
            <div class="card-price">Rp10.000 <span>/orang</span></div>
            <a href="detail_destinasi.php?id=labuan-bajo" class="card-button">Lihat Detail</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php include 'Komponen/footer.php'; ?>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Fungsi untuk menghapus item dari wishlist
      const removeButtons = document.querySelectorAll('.remove-wishlist');
      const clearWishlistBtn = document.querySelector('.clear-wishlist');
      const wishlistCount = document.querySelector('.wishlist-count');
      
      // Hitung jumlah item wishlist
      let itemCount = removeButtons.length;
      updateWishlistCount();
      
      // Fungsi untuk update counter wishlist
      function updateWishlistCount() {
        wishlistCount.innerHTML = `<i class="fas fa-heart" style="color: #ff6b6b;"></i> ${itemCount} Destinasi dalam wishlist`;
        
        // Jika wishlist kosong, tampilkan pesan
        if (itemCount === 0) {
          document.querySelector('.destinations-grid').innerHTML = `
            <div class="empty-wishlist">
              <i class="far fa-heart"></i>
              <h3>Wishlist Anda Kosong</h3>
              <p>Anda belum menambahkan destinasi wisata ke dalam wishlist. Jelajahi destinasi menarik dan tambahkan ke wishlist untuk menyimpannya di sini.</p>
              <a href="destinasi.php" class="explore-button">Jelajahi Destinasi</a>
            </div>
          `;
        }
      }
      
      // Event listener untuk tombol hapus per item
      removeButtons.forEach(button => {
        button.addEventListener('click', function() {
          this.closest('.destination-card').remove();
          itemCount--;
          updateWishlistCount();
          
          // Tampilkan notifikasi
          showNotification('Destinasi dihapus dari wishlist');
        });
      });
      
      // Event listener untuk tombol hapus semua
      clearWishlistBtn.addEventListener('click', function() {
        if (itemCount > 0) {
          if (confirm('Apakah Anda yakin ingin mengosongkan wishlist?')) {
            document.querySelector('.destinations-grid').innerHTML = '';
            itemCount = 0;
            updateWishlistCount();
            showNotification('Semua destinasi dihapus dari wishlist');
          }
        } else {
          showNotification('Wishlist sudah kosong', 'info');
        }
      });
      
      // Fungsi untuk menampilkan notifikasi
      function showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.textContent = message;
        document.body.appendChild(notification);
        
        setTimeout(() => {
          notification.classList.add('show');
        }, 10);
        
        setTimeout(() => {
          notification.classList.remove('show');
          setTimeout(() => {
            document.body.removeChild(notification);
          }, 300);
        }, 3000);
      }
    });
  </script>

  <style>
    /* Notification Styles */
    .notification {
      position: fixed;
      bottom: 20px;
      right: 20px;
      padding: 15px 25px;
      border-radius: 5px;
      color: white;
      font-weight: bold;
      transform: translateY(100px);
      opacity: 0;
      transition: all 0.3s ease;
      z-index: 1000;
    }
    
    .notification.show {
      transform: translateY(0);
      opacity: 1;
    }
    
    .notification.success {
      background-color: #2c7a51;
    }
    
    .notification.info {
      background-color: #17a2b8;
    }
  </style>
</body>
</html>