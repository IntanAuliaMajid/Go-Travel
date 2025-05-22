<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Kontak Kami</title>
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
                  url('https://akasiamas.com/cfind/source/thumb/images/images/content/cover_w970_h499_kontak.jpg') no-repeat center center/cover;
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
      font-size: 3rem;
      margin-bottom: 1rem;
      text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);
    }

    .hero p {
      font-size: 1.2rem;
      max-width: 600px;
      margin: 0 auto;
    }

    /* Container */
    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 1rem;
    }

    /* Contact Section */
    .contact-section {
      padding: 4rem 0;
    }

    .contact-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 3rem;
      margin-top: 2rem;
    }

    /* Contact Form */
    .contact-form-container {
      background-color: #fff;
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .contact-form-container h2 {
      color: #2c7a51;
      margin-bottom: 1.5rem;
      font-size: 1.8rem;
    }

    .form-group {
      margin-bottom: 1.5rem;
    }

    .form-group label {
      display: block;
      margin-bottom: 0.5rem;
      font-weight: bold;
      color: #555;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
      width: 100%;
      padding: 0.75rem;
      border: 1px solid #ddd;
      border-radius: 5px;
      font-size: 1rem;
      transition: border-color 0.3s;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
      outline: none;
      border-color: #2c7a51;
      box-shadow: 0 0 5px rgba(44, 122, 81, 0.3);
    }

    .form-group textarea {
      height: 120px;
      resize: vertical;
    }

    .form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 1rem;
    }

    .submit-btn {
      background-color: #2c7a51;
      color: white;
      border: none;
      padding: 0.75rem 2rem;
      border-radius: 5px;
      cursor: pointer;
      font-size: 1rem;
      transition: background-color 0.3s;
      width: 100%;
    }

    .submit-btn:hover {
      background-color: #1d5b3a;
    }

    /* Contact Info */
    .contact-info {
      background-color: #fff;
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .contact-info h2 {
      color: #2c7a51;
      margin-bottom: 1.5rem;
      font-size: 1.8rem;
    }

    .info-item {
      display: flex;
      align-items: flex-start;
      margin-bottom: 1.5rem;
      padding: 1rem;
      background-color: #f8f9fa;
      border-radius: 8px;
      transition: transform 0.3s;
    }

    .info-item:hover {
      transform: translateY(-2px);
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .info-icon {
      width: 50px;
      height: 50px;
      background-color: #2c7a51;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 1rem;
      flex-shrink: 0;
    }

    .info-icon i {
      color: white;
      font-size: 1.2rem;
    }

    .info-content h3 {
      margin-bottom: 0.5rem;
      color: #333;
    }

    .info-content p {
      color: #666;
      margin-bottom: 0.25rem;
    }

    /* Map Section */
    .map-section {
      padding: 4rem 0;
      background-color: #eef7ed;
    }

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

    .map-container {
      background-color: #fff;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      height: 400px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #666;
      font-size: 1.1rem;
    }

    /* FAQ Section */
    .faq-section {
      padding: 4rem 0;
    }

    .faq-container {
      max-width: 800px;
      margin: 0 auto;
    }

    .faq-item {
      background-color: #fff;
      margin-bottom: 1rem;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      overflow: hidden;
    }

    .faq-question {
      padding: 1.5rem;
      background-color: #f8f9fa;
      cursor: pointer;
      transition: background-color 0.3s;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .faq-question:hover {
      background-color: #e9ecef;
    }

    .faq-question h3 {
      margin: 0;
      color: #333;
    }

    .faq-toggle {
      font-size: 1.2rem;
      color: #2c7a51;
      transition: transform 0.3s;
    }

    .faq-item.active .faq-toggle {
      transform: rotate(180deg);
    }

    .faq-answer {
      padding: 0 1.5rem;
      max-height: 0;
      overflow: hidden;
      transition: max-height 0.3s ease-out, padding 0.3s ease-out;
    }

    .faq-item.active .faq-answer {
      padding: 1.5rem;
      max-height: 200px;
    }

    .faq-answer p {
      color: #666;
      line-height: 1.6;
    }

    /* Social Media */
    .social-section {
      padding: 4rem 0;
      background-color: #2c7a51;
      color: white;
      text-align: center;
    }

    .social-container h2 {
      margin-bottom: 1rem;
      font-size: 2rem;
    }

    .social-container p {
      margin-bottom: 2rem;
      opacity: 0.9;
    }

    .social-links {
      display: flex;
      justify-content: center;
      gap: 1.5rem;
      flex-wrap: wrap;
    }

    .social-link {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 60px;
      height: 60px;
      background-color: rgba(255, 255, 255, 0.1);
      border-radius: 50%;
      color: white;
      font-size: 1.5rem;
      text-decoration: none;
      transition: background-color 0.3s, transform 0.3s;
    }

    .social-link:hover {
      background-color: rgba(255, 255, 255, 0.2);
      transform: translateY(-3px);
    }

    /* Office Hours */
    .office-hours {
      background-color: #f8f9fa;
      padding: 1.5rem;
      border-radius: 8px;
      margin-top: 1.5rem;
    }

    .office-hours h3 {
      color: #2c7a51;
      margin-bottom: 1rem;
    }

    .hours-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 0.5rem;
    }

    .hour-item {
      display: flex;
      justify-content: space-between;
      padding: 0.25rem 0;
    }

    .hour-day {
      font-weight: bold;
      color: #333;
    }

    .hour-time {
      color: #666;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .hero h1 {
        font-size: 2.5rem;
      }

      .contact-grid {
        grid-template-columns: 1fr;
        gap: 2rem;
      }

      .form-row {
        grid-template-columns: 1fr;
      }

      .social-links {
        gap: 1rem;
      }

      .hours-grid {
        grid-template-columns: 1fr;
      }

      .section-heading h2 {
        font-size: 2rem;
      }
    }

    /* Success Message */
    .success-message {
      background-color: #d4edda;
      color: #155724;
      padding: 1rem;
      border-radius: 5px;
      margin-bottom: 1rem;
      display: none;
    }

    .success-message.show {
      display: block;
    }
  </style>
</head>
<body>
  <?php include 'Komponen/navbar.php'; ?>

  <!-- Hero Section -->
  <section class="hero">
    <h1>Hubungi Kami</h1>
    <p>Kami siap membantu merencanakan petualangan wisata terbaik Anda di Indonesia</p>
  </section>

  <!-- Contact Section -->
  <section class="contact-section">
    <div class="container">
      <div class="section-heading">
        <h2>Mari Berbicara</h2>
        <p>Tim ahli kami siap membantu Anda merencanakan liburan impian ke destinasi wisata terbaik Indonesia</p>
      </div>

      <div class="contact-grid">
        <!-- Contact Form -->
        <div class="contact-form-container">
          <h2>Kirim Pesan</h2>
          <div class="success-message" id="successMessage">
            <i class="fas fa-check-circle"></i> Pesan Anda berhasil dikirim! Kami akan segera menghubungi Anda.
          </div>
          <form id="contactForm" class="contact-form">
            <div class="form-row">
              <div class="form-group">
                <label for="firstName">Nama Depan *</label>
                <input type="text" id="firstName" name="firstName" required>
              </div>
              <div class="form-group">
                <label for="lastName">Nama Belakang *</label>
                <input type="text" id="lastName" name="lastName" required>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" id="email" name="email" required>
              </div>
              <div class="form-group">
                <label for="phone">Nomor Telepon</label>
                <input type="tel" id="phone" name="phone">
              </div>
            </div>
            <div class="form-group">
              <label for="subject">Subjek *</label>
              <select id="subject" name="subject" required>
                <option value="">Pilih Subjek</option>
                <option value="informasi-umum">Informasi Umum</option>
                <option value="reservasi">Reservasi & Pemesanan</option>
                <option value="keluhan">Keluhan & Saran</option>
                <option value="kerjasama">Kerjasama & Partnership</option>
                <option value="lainnya">Lainnya</option>
              </select>
            </div>
            <div class="form-group">
              <label for="message">Pesan *</label>
              <textarea id="message" name="message" placeholder="Ceritakan bagaimana kami bisa membantu Anda..." required></textarea>
            </div>
            <button type="submit" class="submit-btn">
              <i class="fas fa-paper-plane"></i> Kirim Pesan
            </button>
          </form>
        </div>

        <!-- Contact Info -->
        <div class="contact-info">
          <h2>Informasi Kontak</h2>
          
          <div class="info-item">
            <div class="info-icon">
              <i class="fas fa-map-marker-alt"></i>
            </div>
            <div class="info-content">
              <h3>Alamat Kantor</h3>
              <p>Jl. Wisata Indonesia No. 123</p>
              <p>Jakarta Pusat, 10110</p>
              <p>Indonesia</p>
            </div>
          </div>

          <div class="info-item">
            <div class="info-icon">
              <i class="fas fa-phone"></i>
            </div>
            <div class="info-content">
              <h3>Telepon</h3>
              <p>+62 21 123-4567</p>
              <p>+62 21 123-4568 (Fax)</p>
            </div>
          </div>

          <div class="info-item">
            <div class="info-icon">
              <i class="fas fa-envelope"></i>
            </div>
            <div class="info-content">
              <h3>Email</h3>
              <p>info@go-travel.com</p>
              <p>support@go-travel.com</p>
            </div>
          </div>

          <div class="info-item">
            <div class="info-icon">
              <i class="fas fa-globe"></i>
            </div>
            <div class="info-content">
              <h3>Website</h3>
              <p>www.go-travel.com</p>
              <p>www.tourguide-indonesia.com</p>
            </div>
          </div>

          <!-- Office Hours -->
          <div class="office-hours">
            <h3>Jam Operasional</h3>
            <div class="hours-grid">
              <div class="hour-item">
                <span class="hour-day">Senin - Jumat</span>
                <span class="hour-time">08:00 - 17:00</span>
              </div>
              <div class="hour-item">
                <span class="hour-day">Sabtu</span>
                <span class="hour-time">08:00 - 15:00</span>
              </div>
              <div class="hour-item">
                <span class="hour-day">Minggu</span>
                <span class="hour-time">Tutup</span>
              </div>
              <div class="hour-item">
                <span class="hour-day">Hari Libur</span>
                <span class="hour-time">Tutup</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Map Section -->
  <section class="map-section">
    <div class="container">
      <div class="section-heading">
        <h2>Lokasi Kantor</h2>
        <p>Kunjungi kantor kami untuk konsultasi langsung tentang destinasi wisata impian Anda</p>
      </div>
      <div class="map-container">
        <i class="fas fa-map-marked-alt" style="font-size: 3rem; margin-right: 1rem;"></i>
        <div style="text-align: center;">
            <h3>Go Travel Indonesia</h3>
          <p style="font-size: 0.9rem; margin-top: 0.5rem;">Jl. Wisata Indonesia No. 123, Kamal Pusat</p>
        </div>
      </div>
    </div>
  </section>

  <!-- FAQ Section -->
  <section class="faq-section">
    <div class="container">
      <div class="section-heading">
        <h2>Pertanyaan Umum</h2>
        <p>Temukan jawaban atas pertanyaan yang sering diajukan tentang layanan wisata kami</p>
      </div>

      <div class="faq-container">
        <div class="faq-item">
          <div class="faq-question" onclick="toggleFAQ(this)">
            <h3>Bagaimana cara memesan paket wisata?</h3>
            <span class="faq-toggle">▼</span>
          </div>
          <div class="faq-answer">
            <p>Anda dapat memesan paket wisata melalui website kami, menghubungi customer service, atau datang langsung ke kantor. Tim kami akan membantu merancang paket sesuai kebutuhan dan budget Anda.</p>
          </div>
        </div>

        <div class="faq-item">
          <div class="faq-question" onclick="toggleFAQ(this)">
            <h3>Apakah tersedia tour guide yang berbahasa Indonesia?</h3>
            <span class="faq-toggle">▼</span>
          </div>
          <div class="faq-answer">
            <p>Ya, semua tour guide kami adalah profesional berbahasa Indonesia. Kami juga menyediakan tour guide yang menguasai bahasa Inggris, Mandarin, dan bahasa asing lainnya sesuai kebutuhan.</p>
          </div>
        </div>

        <div class="faq-item">
          <div class="faq-question" onclick="toggleFAQ(this)">
            <h3>Bagaimana kebijakan pembatalan dan refund?</h3>
            <span class="faq-toggle">▼</span>
          </div>
          <div class="faq-answer">
            <p>Kebijakan pembatalan bervariasi tergantung pada jenis paket dan waktu pembatalan. Untuk pembatalan 30 hari sebelum keberangkatan, Anda mendapat refund 100%. Detail lengkap dapat dilihat di syarat dan ketentuan.</p>
          </div>
        </div>

        <div class="faq-item">
          <div class="faq-question" onclick="toggleFAQ(this)">
            <h3>Apakah asuransi perjalanan sudah termasuk?</h3>
            <span class="faq-toggle">▼</span>
          </div>
          <div class="faq-answer">
            <p>Asuransi perjalanan basic sudah termasuk dalam semua paket wisata kami. Namun, Anda dapat mengupgrade ke asuransi perjalanan premium dengan coverage yang lebih lengkap.</p>
          </div>
        </div>

        <div class="faq-item">
          <div class="faq-question" onclick="toggleFAQ(this)">
            <h3>Apakah bisa custom paket wisata sesuai keinginan?</h3>
            <span class="faq-toggle">▼</span>
          </div>
          <div class="faq-answer">
            <p>Tentu saja! Kami menyediakan layanan custom paket wisata sesuai dengan preferensi, budget, dan jadwal Anda. Tim travel consultant kami akan membantu merancang itinerary yang sempurna.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Social Media Section -->
  <section class="social-section">
    <div class="container">
      <div class="social-container">
        <h2>Ikuti Media Sosial Kami</h2>
        <p>Dapatkan update terbaru tentang destinasi wisata, tips perjalanan, dan penawaran spesial</p>
        <div class="social-links">
          <a href="#" class="social-link" title="Facebook">
            <i class="fab fa-facebook-f"></i>
          </a>
          <a href="#" class="social-link" title="Instagram">
            <i class="fab fa-instagram"></i>
          </a>
          <a href="#" class="social-link" title="Twitter">
            <i class="fab fa-twitter"></i>
          </a>
          <a href="#" class="social-link" title="YouTube">
            <i class="fab fa-youtube"></i>
          </a>
          <a href="#" class="social-link" title="TikTok">
            <i class="fab fa-tiktok"></i>
          </a>
          <a href="#" class="social-link" title="WhatsApp">
            <i class="fab fa-whatsapp"></i>
          </a>
        </div>
      </div>
    </div>
  </section>

  <?php include 'Komponen/footer.php'; ?>

  <script>
    // FAQ Toggle
    function toggleFAQ(element) {
      const faqItem = element.parentElement;
      const isActive = faqItem.classList.contains('active');
      
      // Close all FAQ items
      document.querySelectorAll('.faq-item').forEach(item => {
        item.classList.remove('active');
      });
      
      // Open clicked item if it wasn't active
      if (!isActive) {
        faqItem.classList.add('active');
      }
    }

    // Contact Form Submission
    document.getElementById('contactForm').addEventListener('submit', function(e) {
      e.preventDefault();
      
      // Simple form validation
      const requiredFields = this.querySelectorAll('[required]');
      let isValid = true;
      
      requiredFields.forEach(field => {
        if (!field.value.trim()) {
          isValid = false;
          field.style.borderColor = '#ff6b6b';
        } else {
          field.style.borderColor = '#ddd';
        }
      });
      
      if (isValid) {
        // Show success message
        document.getElementById('successMessage').classList.add('show');
        
        // Reset form
        this.reset();
        
        // Hide success message after 5 seconds
        setTimeout(() => {
          document.getElementById('successMessage').classList.remove('show');
        }, 5000);
        
        // Scroll to success message
        document.getElementById('successMessage').scrollIntoView({
          behavior: 'smooth',
          block: 'center'
        });
      }
    });

    // Smooth scrolling for internal links
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
  </script>
</body>
</html>