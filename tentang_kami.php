<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tentang Kami - Go-Travel</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <style>
    /* Hero Section */
    .hero {
      height: 70vh;
      background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1503220317375-aaad61436b1b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') no-repeat center center/cover;
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

    /* Values Section */
    .values {
      padding: 80px 2rem;
      background: white;
    }

    .values-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 3rem;
      margin-top: 3rem;
    }

    .value-card {
      text-align: center;
      padding: 2rem;
      border-radius: 15px;
      background: #f8f9fa;
      transition: all 0.3s;
      border: 1px solid #eee;
    }

    .value-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 15px 35px rgba(0,0,0,0.1);
      background: white;
    }

    .value-icon {
      font-size: 3rem;
      color: #ff6b35;
      margin-bottom: 1rem;
    }

    .value-card h3 {
      font-size: 1.3rem;
      margin-bottom: 1rem;
      color: #333;
    }

    .value-card p {
      color: #666;
      line-height: 1.6;
    }

    /* Team Section */
    .team {
      padding: 80px 2rem;
      background: #f8f9fa;
    }

    .team-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 3rem;
      margin-top: 3rem;
    }

    .team-member {
      text-align: center;
      background: white;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
      transition: all 0.3s;
    }

    .team-member:hover {
      transform: translateY(-10px);
    }

    .member-photo {
      width: 100%;
      height: 250px;
      object-fit: cover;
    }

    .member-info {
      padding: 1.5rem;
    }

    .member-name {
      font-size: 1.3rem;
      margin-bottom: 0.5rem;
      color: #333;
    }

    .member-position {
      color: #ff6b35;
      font-weight: 600;
      margin-bottom: 1rem;
    }

    .member-bio {
      color: #666;
      line-height: 1.6;
      font-size: 0.9rem;
    }

    .social-links {
      display: flex;
      justify-content: center;
      gap: 1rem;
      margin-top: 1rem;
    }

    .social-links a {
      color: #666;
      font-size: 1.2rem;
      transition: color 0.3s;
    }

    .social-links a:hover {
      color: #ff6b35;
    }

    /* Timeline Section */
    .timeline {
      padding: 80px 2rem;
      background: white;
    }

    .timeline-container {
      position: relative;
      max-width: 800px;
      margin: 0 auto;
    }

    .timeline-container::after {
      content: '';
      position: absolute;
      width: 4px;
      background-color: #ff6b35;
      top: 0;
      bottom: 0;
      left: 50%;
      margin-left: -2px;
    }

    .timeline-item {
      padding: 10px 40px;
      position: relative;
      width: 50%;
      box-sizing: border-box;
    }

    .timeline-item:nth-child(odd) {
      left: 0;
    }

    .timeline-item:nth-child(even) {
      left: 50%;
    }

    .timeline-item::after {
      content: '';
      position: absolute;
      width: 20px;
      height: 20px;
      background-color: white;
      border: 4px solid #ff6b35;
      top: 15px;
      border-radius: 50%;
      z-index: 1;
    }

    .timeline-item:nth-child(odd)::after {
      right: -12px;
    }

    .timeline-item:nth-child(even)::after {
      left: -12px;
    }

    .timeline-content {
      padding: 20px;
      background-color: #f8f9fa;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .timeline-year {
      font-weight: 700;
      color: #ff6b35;
      margin-bottom: 0.5rem;
    }

    .timeline-title {
      font-size: 1.2rem;
      margin-bottom: 1rem;
      color: #333;
    }

    .timeline-desc {
      color: #666;
      line-height: 1.6;
    }

    /* CTA Section */
    .cta-section {
      padding: 80px 2rem;
      text-align: center;
      background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('https://images.unsplash.com/photo-1501555088652-021faa106b9b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') no-repeat center center/cover;
      color: white;
    }

    .cta-title {
      font-size: 2.5rem;
      margin-bottom: 1.5rem;
    }

    .cta-description {
      max-width: 600px;
      margin: 0 auto 2rem;
      font-size: 1.1rem;
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
      .hero {
        height: 50vh;
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
      
      .timeline-container::after {
        left: 31px;
      }
      
      .timeline-item {
        width: 100%;
        padding-left: 70px;
        padding-right: 25px;
      }
      
      .timeline-item:nth-child(even) {
        left: 0;
      }
      
      .timeline-item::after {
        left: 21px;
      }
    }
  </style>
</head>
<body>

<?php include "Komponen/navbar.php" ?>

  <!-- Hero Section -->
  <header class="hero" id="home">
    <div class="hero-content">
      <p class="hero-subtitle">Mengenal Lebih Dekat</p>
      <h1>Tentang Go-Travel</h1>
      <p class="hero-description">Perjalanan bukan hanya tentang destinasi, tapi tentang pengalaman dan cerita yang akan Anda kenang seumur hidup</p>
    </div>
  </header>

  <!-- About Section -->
  <section class="about" id="about">
    <div class="container">
      <h2 class="section-title">Kisah Kami</h2>
      <p class="section-subtitle">Perjalanan Go-Travel dimulai dari kecintaan terhadap keindahan alam dan budaya Nusantara</p>
      
      <div class="about-grid">
        <div class="about-image">
          <img src="https://images.unsplash.com/photo-1544551763-46a013bb70d5?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Tim Go-Travel">
        </div>
        <div class="about-text">
          <h3>Perjalanan Go-Travel</h3>
          <p>Go-Travel didirikan pada tahun 2010 oleh sekelompok pecinta petualangan yang memiliki visi untuk memperkenalkan keindahan Nusantara kepada dunia. Awalnya kami hanya mengoperasikan tur lokal di Jawa Timur, namun seiring dengan meningkatnya permintaan dan kepercayaan pelanggan, kami berkembang menjadi salah satu penyedia layanan wisata terkemuka di Indonesia.</p>
          <p>Dengan lebih dari 100.000 wisatawan yang telah kami layani, Go-Travel berkomitmen untuk memberikan pengalaman perjalanan yang autentik, berkesan, dan bertanggung jawab. Kami tidak hanya fokus pada kepuasan pelanggan, tetapi juga pada kelestarian alam dan kesejahteraan masyarakat lokal di setiap destinasi yang kami kunjungi.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Values Section -->
  <section class="values">
    <div class="container">
      <h2 class="section-title">Nilai-Nilai Kami</h2>
      <p class="section-subtitle">Prinsip yang membimbing setiap langkah perjalanan bersama kami</p>
      
      <div class="values-grid">
        <div class="value-card">
          <div class="value-icon">
            <i class="fas fa-heart"></i>
          </div>
          <h3>Passion</h3>
          <p>Kami melakukan segalanya dengan penuh semangat dan dedikasi karena mencintai apa yang kami lakukan. Setiap perjalanan dirancang dengan hati untuk memberikan pengalaman terbaik.</p>
        </div>
        
        <div class="value-card">
          <div class="value-icon">
            <i class="fas fa-handshake"></i>
          </div>
          <h3>Integritas</h3>
          <p>Kejujuran dan transparansi adalah landasan setiap interaksi dengan pelanggan dan mitra. Kami selalu memberikan apa yang kami janjikan dan bahkan lebih.</p>
        </div>
        
        <div class="value-card">
          <div class="value-icon">
            <i class="fas fa-leaf"></i>
          </div>
          <h3>Keberlanjutan</h3>
          <p>Kami berkomitmen untuk pariwisata berkelanjutan yang menghormati alam, budaya lokal, dan memberikan manfaat ekonomi kepada masyarakat setempat.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Team Section -->
  <section class="team">
    <div class="container">
      <h2 class="section-title">Tim Kami</h2>
      <p class="section-subtitle">Orang-orang berdedikasi yang membuat setiap perjalanan menjadi istimewa</p>
      
      <div class="team-grid">
        <div class="team-member">
          <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Budi Santoso" class="member-photo">
          <div class="member-info">
            <h3 class="member-name">Budi Santoso</h3>
            <p class="member-position">Founder & CEO</p>
            <p class="member-bio">Pendiri Go-Travel dengan pengalaman 15 tahun di industri pariwisata. Memiliki passion yang besar untuk mempromosikan keindahan Indonesia.</p>
            <div class="social-links">
              <a href="#"><i class="fab fa-linkedin"></i></a>
              <a href="#"><i class="fab fa-twitter"></i></a>
              <a href="#"><i class="fab fa-instagram"></i></a>
            </div>
          </div>
        </div>
        
        <div class="team-member">
          <img src="https://images.unsplash.com/photo-1580489944761-15a19d654956?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Ani Wijaya" class="member-photo">
          <div class="member-info">
            <h3 class="member-name">Ani Wijaya</h3>
            <p class="member-position">Direktur Operasional</p>
            <p class="member-bio">Ahli dalam mengelola operasional perjalanan dengan pengalaman 10 tahun. Memastikan setiap detail perjalanan berjalan sempurna.</p>
            <div class="social-links">
              <a href="#"><i class="fab fa-linkedin"></i></a>
              <a href="#"><i class="fab fa-twitter"></i></a>
              <a href="#"><i class="fab fa-instagram"></i></a>
            </div>
          </div>
        </div>
        
        <div class="team-member">
          <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Dewi Puspita" class="member-photo">
          <div class="member-info">
            <h3 class="member-name">Dewi Puspita</h3>
            <p class="member-position">Manajer Pemasaran</p>
            <p class="member-bio">Spesialis pemasaran digital dengan kreativitas tinggi. Bertanggung jawab membawa Go-Travel dikenal oleh lebih banyak orang.</p>
            <div class="social-links">
              <a href="#"><i class="fab fa-linkedin"></i></a>
              <a href="#"><i class="fab fa-twitter"></i></a>
              <a href="#"><i class="fab fa-instagram"></i></a>
            </div>
          </div>
        </div>
        
        <div class="team-member">
          <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Rudi Hermawan" class="member-photo">
          <div class="member-info">
            <h3 class="member-name">Rudi Hermawan</h3>
            <p class="member-position">Kepala Pemandu</p>
            <p class="member-bio">Pemandu wisata berpengalaman yang mengenal setiap sudut Indonesia. Penuh cerita menarik dan pengetahuan lokal yang mendalam.</p>
            <div class="social-links">
              <a href="#"><i class="fab fa-linkedin"></i></a>
              <a href="#"><i class="fab fa-twitter"></i></a>
              <a href="#"><i class="fab fa-instagram"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Timeline Section -->
  <section class="timeline">
    <div class="container">
      <h2 class="section-title">Perjalanan Kami</h2>
      <p class="section-subtitle">Momen penting dalam sejarah Go-Travel</p>
      
      <div class="timeline-container">
        <div class="timeline-item">
          <div class="timeline-content">
            <div class="timeline-year">2010</div>
            <h3 class="timeline-title">Pendirian Go-Travel</h3>
            <p class="timeline-desc">Go-Travel didirikan dengan fokus pada tur lokal di Jawa Timur. Awalnya hanya memiliki 3 pemandu wisata dan 1 kantor kecil di Surabaya.</p>
          </div>
        </div>
        <div class="timeline-item">
          <div class="timeline-content">
            <div class="timeline-year">2013</div>
            <h3 class="timeline-title">Ekspansi ke Bali</h3>
            <p class="timeline-desc">Membuka cabang pertama di Bali dan memperluas layanan ke destinasi wisata internasional. Tim bertambah menjadi 20 orang.</p>
          </div>
        </div>
        <div class="timeline-item">
          <div class="timeline-content">
            <div class="timeline-year">2016</div>
            <h3 class="timeline-title">Penghargaan Industri</h3>
            <p class="timeline-desc">Menerima penghargaan "Tour Operator Terbaik" dari Kementerian Pariwisata untuk layanan inovatif dan kepuasan pelanggan yang tinggi.</p>
          </div>
        </div>
        <div class="timeline-item">
          <div class="timeline-content">
            <div class="timeline-year">2019</div>
            <h3 class="timeline-title">Platform Digital</h3>
            <p class="timeline-desc">Meluncurkan platform pemesanan online yang memudahkan pelanggan merencanakan perjalanan mereka secara mandiri.</p>
          </div>
        </div>
        <div class="timeline-item">
          <div class="timeline-content">
            <div class="timeline-year">2023</div>
            <h3 class="timeline-title">Ekspansi Internasional</h3>
            <p class="timeline-desc">Memulai layanan tur ke destinasi Asia Tenggara dengan fokus pada pengalaman budaya dan alam yang autentik.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA Section -->
  <section class="cta-section">
    <div class="container">
      <h2 class="cta-title">Siap untuk Petualangan Berikutnya?</h2>
      <p class="cta-description">Bergabunglah dengan ribuan wisatawan yang telah mempercayai Go-Travel untuk pengalaman perjalanan tak terlupakan mereka</p>
      <a href="#" class="cta-button">Mulai Perjalanan Anda</a>
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

    // Animation on scroll for timeline items
    const timelineItems = document.querySelectorAll('.timeline-item');
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.style.opacity = '1';
          entry.target.style.transform = 'translateY(0)';
        }
      });
    }, { threshold: 0.1 });

    timelineItems.forEach(item => {
      item.style.opacity = '0';
      item.style.transform = 'translateY(30px)';
      item.style.transition = 'all 0.6s ease-out';
      observer.observe(item);
    });
  </script>
</body>
</html>