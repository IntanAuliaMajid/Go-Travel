<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Go-Travel - Jelajahi Nusantara</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <style>
    /* Hero Section */
    .hero {
      height: 100vh;
      background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('https://4.bp.blogspot.com/-hb_IkgXy4Qc/WHXq4q2-QwI/AAAAAAAADn4/Lw6pgdmJnxgzR1ZJ9L9fStWiYMK02TSgwCLcB/s1600/1.jpg') no-repeat center center/cover;
      display: flex;
      justify-content: center;
      align-items: center;
      color: white;
      text-align: center;
      padding: 0 20px;
      position: relative;
    }

    .hero-content {
      max-width: 800px;
      animation: fadeInUp 1s ease-out;
    }

    .hero-subtitle {
      font-size: 1.2rem;
      margin-bottom: 1rem;
      color: #ff6b35;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 2px;
    }

    .hero h1 {
      font-size: 4rem;
      margin-bottom: 1rem;
      font-weight: 700;
      text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    }

    .hero-description {
      font-size: 1.3rem;
      margin-bottom: 2rem;
      color: rgba(255,255,255,0.9);
    }

    .cta-button {
      display: inline-block;
      background: linear-gradient(135deg, #ff6b35, #f7931e);
      color: white;
      padding: 15px 30px;
      text-decoration: none;
      border-radius: 50px;
      font-weight: 600;
      font-size: 1.1rem;
      transition: all 0.3s;
      box-shadow: 0 5px 15px rgba(255, 107, 53, 0.4);
    }

    .cta-button:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(255, 107, 53, 0.6);
    }

    /* About Section */
    .about {
      padding: 80px 2rem;
      background: #f8f9fa;
    }

    .container {
      max-width: 1200px;
      margin: 0 auto;
    }

    .section-title {
      text-align: center;
      font-size: 2.5rem;
      font-weight: 700;
      margin-bottom: 1rem;
      color: #333;
    }

    .section-subtitle {
      text-align: center;
      font-size: 1.1rem;
      color: #666;
      margin-bottom: 3rem;
      max-width: 600px;
      margin-left: auto;
      margin-right: auto;
    }

    .about-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 4rem;
      align-items: center;
      margin-top: 3rem;
    }

    .about-text h3 {
      font-size: 1.8rem;
      margin-bottom: 1rem;
      color: #333;
    }

    .about-text p {
      color: #666;
      margin-bottom: 1.5rem;
      line-height: 1.8;
    }

    .about-image {
      position: relative;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }

    .about-image img {
      width: 100%;
      height: 300px;
      object-fit: cover;
    }

    /* Features Section */
    .features {
      padding: 80px 2rem;
      background: white;
    }

    .features-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 3rem;
      margin-top: 3rem;
    }

    .feature-card {
      text-align: center;
      padding: 2rem;
      border-radius: 15px;
      background: #f8f9fa;
      transition: all 0.3s;
      border: 1px solid #eee;
    }

    .feature-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 15px 35px rgba(0,0,0,0.1);
      background: white;
    }

    .feature-icon {
      font-size: 3rem;
      color: #ff6b35;
      margin-bottom: 1rem;
    }

    .feature-card h3 {
      font-size: 1.3rem;
      margin-bottom: 1rem;
      color: #333;
    }

    .feature-card p {
      color: #666;
      line-height: 1.6;
    }

    /* Gallery Section */
    .gallery {
      padding: 80px 2rem;
      background: #f8f9fa;
    }

    .gallery-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 2rem;
      margin-top: 3rem;
    }

    .gallery-item {
      position: relative;
      border-radius: 15px;
      overflow: hidden;
      aspect-ratio: 4/3;
      cursor: pointer;
      transition: all 0.3s;
    }

    .gallery-item:hover {
      transform: scale(1.05);
    }

    .gallery-item img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .gallery-overlay {
      position: absolute;
      bottom: 0;
      left: 0;
      right: 0;
      background: linear-gradient(transparent, rgba(0,0,0,0.8));
      color: white;
      padding: 2rem;
      transform: translateY(100%);
      transition: transform 0.3s;
    }

    .gallery-item:hover .gallery-overlay {
      transform: translateY(0);
    }

    .gallery-overlay h3 {
      font-size: 1.3rem;
      margin-bottom: 0.5rem;
    }

  
    /* Animations */
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Responsive */
    @media (max-width: 768px) {
      .nav-menu {
        display: none;
      }

      .hero h1 {
        font-size: 2.5rem;
      }

      .hero-description {
        font-size: 1.1rem;
      }

      .about-grid {
        grid-template-columns: 1fr;
        gap: 2rem;
      }

      .section-title {
        font-size: 2rem;
      }

      .gallery-grid {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>
<body>

<?php include "Komponen/navbar.php" ?>

  <!-- Hero Section -->
  <header class="hero" id="home">
    <div class="hero-content">
      <p class="hero-subtitle">Welcome</p>
      <h1>Go-Travel</h1>
      <p class="hero-description">Temukan destinasi wisata terbaik di Pulau Jawa, dari pantai eksotis hingga tempat hiburan yang menyenangkan

</p>
      <a href="#gallery" class="cta-button">Mulai Penjelajahan</a>
    </div>
  </header>

  <!-- About Section -->
  <section class="about" id="about">
    <div class="container">
      <h2 class="section-title">Tentang Kami</h2>
      <p class="section-subtitle">Kami adalah panduan terpercaya untuk menjelajahi keindahan Nusantara dengan pengalaman yang tak terlupakan</p>
      
      <div class="about-grid">
        <div class="about-text">
          <h3>Kenapa Memilih Kami?</h3>
          <p>Dengan pengalaman lebih dari 10 tahun dalam industri pariwisata, kami telah membantu ribuan wisatawan menemukan destinasi impian mereka di seluruh Indonesia.</p>
          <p>Tim ahli kami siap memberikan rekomendasi terbaik dan layanan yang personal untuk setiap perjalanan Anda. Dari perencanaan hingga eksekusi, kami pastikan perjalanan Anda berkesan.</p>
        </div>
        <div class="about-image">
          <img src="https://connect-assets.prosple.com/cdn/ff/1GxpmxcXvWsOjGP1iXisD6_mWBKX1mejX1P0dT1_6aU/1656046826/public/2022-06/thumbnail-article-mengenal-project-manager-2022.jpg" alt="Tim Jelajahi Nusantara">
        </div>
      </div>
    </div>
  </section>

  <!-- Features Section -->
  <section class="features">
    <div class="container">
      <h2 class="section-title">Layanan Kami</h2>
      <p class="section-subtitle">Paket lengkap untuk perjalanan terbaik Anda</p>
      
      <div class="features-grid">
        <div class="feature-card">
          <div class="feature-icon">
            <i class="fas fa-map-marked-alt"></i>
          </div>
          <h3>Panduan Lokal</h3>
          <p>Pemandu wisata berpengalaman yang mengenal setiap sudut destinasi untuk memberikan pengalaman terbaik.</p>
        </div>
        
        <div class="feature-card">
          <div class="feature-icon">
            <i class="fas fa-hotel"></i>
          </div>
          <h3>Akomodasi Terbaik</h3>
          <p>Hotel dan penginapan pilihan dengan fasilitas lengkap dan lokasi strategis di setiap destinasi.</p>
        </div>
        
        <div class="feature-card">
          <div class="feature-icon">
            <i class="fas fa-utensils"></i>
          </div>
          <h3>Kuliner Nusantara</h3>
          <p>Nikmati cita rasa autentik kuliner tradisional dari berbagai daerah yang kamu kunjungi.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Gallery Section -->
  <section class="gallery" id="gallery">
    <div class="container">
      <h2 class="section-title">Destinasi Populer</h2>
      <p class="section-subtitle">Jelajahi keindahan alam dan budaya Indonesia yang memukau</p>
      
      <div class="gallery-grid">
        <div class="gallery-item">
          <img src="https://www.nativeindonesia.com/foto/2024/07/pantai-tanjung-kodok-1.jpg" alt="Pantai Tanjung Kodok">
          <div class="gallery-overlay">
            <h3>Pantai Tanjung Kodok</h3>
            <p>Nikmati keindahan sunrise yang menakjubkan di destinasi ikonik Indonesia ini.</p>
          </div>
        </div>
        
        <div class="gallery-item">
          <img src="https://anekatempatwisata.com/wp-content/uploads/2018/04/Jakarta-Aquarium-loop.jpg" alt="Jakarta Aquarium">
          <div class="gallery-overlay">
            <h3>Jakarta Aquarium</h3>
            <p>Surga bawah laut dengan keanekaragaman hayati terkaya</p>
          </div>
        </div>
        
        <div class="gallery-item">
          <img src="https://www.nativeindonesia.com/foto/2024/02/museum-mandhilaras-pamekasan.jpg" alt="Museum Mandhilaras">
          <div class="gallery-overlay">
            <h3>Museum Mandhilaras</h3>
            <p>Museum Mandhilaras adalah museum budaya Madura yang menyimpan koleksi sejarah dan seni tradisional.</p>
          </div>
        </div>
        
        <div class="gallery-item">
          <img src="https://anekatempatwisata.com/wp-content/uploads/2018/04/Monumen-Nasional-610x406.jpg" alt="Monumen Nasional">
          <div class="gallery-overlay">
            <h3>Monumen Nasional</h3>
            <p>Selamat datang di Taman Mini Indonesia Indah (TMII), sebuah miniatur megah yang menampilkan kekayaan budaya dan keindahan alam dari 34 provinsi di Indonesia.</p>
          </div>
        </div>
        
        <div class="gallery-item">
          <img src="https://labuhanmangrove.files.wordpress.com/2019/09/whatsapp-image-2019-09-11-at-10.58.31-1.jpeg" alt="Labuhan Mangrove Educational Park">
          <div class="gallery-overlay">
            <h3>Labuhan Mangrove Educational Park</h3>
            <p>Taman edukasi dan wisata alam yang menyajikan keindahan hutan mangrove serta kegiatan konservasi pesisir.</p>
          </div>
        </div>
        
        <div class="gallery-item">
          <img src="http://informazone.com/wp-content/uploads/2020/01/header.jpg" alt="monumen kapal selam">
          <div class="gallery-overlay">
            <h3>monumen kapal selam</h3>
            <p>Monumen Kapal Selam Surabaya adalah museum dalam kapal selam KRI Pasopati 410 yang menampilkan sejarah perjuangan Angkatan Laut Indonesia.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php include "Komponen/footer.php"?>


  <script>
    // Smooth scrolling for navigation links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
          target.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
          });
        }
      });
    });

    // Gallery item animation on scroll
    const observerOptions = {
      threshold: 0.1,
      rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.style.opacity = '1';
          entry.target.style.transform = 'translateY(0)';
        }
      });
    }, observerOptions);

    document.querySelectorAll('.gallery-item, .feature-card').forEach(item => {
      item.style.opacity = '0';
      item.style.transform = 'translateY(30px)';
      item.style.transition = 'all 0.6s ease-out';
      observer.observe(item);
    });
  </script>
</body>
</html>