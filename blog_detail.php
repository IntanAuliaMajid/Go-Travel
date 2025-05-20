<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>10 Tips Aman Mendaki Gunung untuk Pemula - Blog Wisata Indonesia</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      line-height: 1.6;
      color: #333;
      background-color: #f8f9fa;
    }

    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 1rem;
    }

    /* Header styles */
    .blog-header {
      background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), 
                  url('https://images.unsplash.com/photo-1503220317375-aaad61436b1b') no-repeat center center/cover;
      min-height: 50vh;
      display: flex;
      align-items: center;
      color: white;
      position: relative;
    }

    .header-content {
      max-width: 800px;
    }

    .breadcrumb {
      background: rgba(255, 255, 255, 0.2);
      padding: 0.5rem 1rem;
      border-radius: 25px;
      margin-bottom: 2rem;
      font-size: 0.9rem;
    }

    .breadcrumb a {
      color: white;
      text-decoration: none;
    }

    .breadcrumb a:hover {
      text-decoration: underline;
    }

    .article-category {
      background-color: #2c7a51;
      color: white;
      padding: 0.5rem 1rem;
      border-radius: 25px;
      font-size: 0.9rem;
      display: inline-block;
      margin-bottom: 1rem;
    }

    .article-title {
        margin-top: 50px;
      font-size: 2.5rem;
      font-weight: bold;
      margin-bottom: 1rem;
      line-height: 1.2;
    }

    .article-meta {
      display: flex;
      gap: 2rem;
      flex-wrap: wrap;
      align-items: center;
      color: #e0e0e0;
    }

    .meta-item {
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    /* Main content */
    .blog-detail-container {
      display: flex;
      gap: 2rem;
      padding: 3rem 0;
    }

    .article-content {
      flex: 1;
      background: white;
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .article-body {
      font-size: 1.1rem;
      line-height: 1.8;
      color: #444;
    }

    .article-body h2 {
      color: #2c7a51;
      margin: 2rem 0 1rem 0;
      font-size: 1.5rem;
    }

    .article-body h3 {
      color: #2c7a51;
      margin: 1.5rem 0 1rem 0;
      font-size: 1.3rem;
    }

    .article-body p {
      margin-bottom: 1.5rem;
      text-align: justify;
    }

    .article-body ul,
    .article-body ol {
      margin: 1rem 0 1.5rem 2rem;
    }

    .article-body li {
      margin-bottom: 0.5rem;
    }

    .article-body img {
      width: 100%;
      height: auto;
      border-radius: 8px;
      margin: 1.5rem 0;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .article-body blockquote {
      background: #f8f9fa;
      border-left: 4px solid #2c7a51;
      padding: 1rem 1.5rem;
      margin: 1.5rem 0;
      font-style: italic;
      border-radius: 0 8px 8px 0;
    }

    /* Social Share */
    .social-share {
      margin: 2rem 0;
      padding: 1.5rem;
      background: #f8f9fa;
      border-radius: 8px;
      text-align: center;
    }

    .social-share h4 {
      margin-bottom: 1rem;
      color: #333;
    }

    .share-buttons {
      display: flex;
      justify-content: center;
      gap: 1rem;
      flex-wrap: wrap;
    }

    .share-btn {
      padding: 0.5rem 1rem;
      border: none;
      border-radius: 25px;
      color: white;
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      transition: opacity 0.3s ease;
    }

    .share-btn:hover {
      opacity: 0.8;
    }

    .share-btn.facebook { background: #3b5998; }
    .share-btn.twitter { background: #1da1f2; }
    .share-btn.whatsapp { background: #25d366; }
    .share-btn.linkedin { background: #0077b5; }

    /* Comments Section */
    .comments-section {
      margin-top: 3rem;
      padding: 2rem;
      background: white;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .comments-section h3 {
      color: #2c7a51;
      margin-bottom: 1.5rem;
    }

    .comment-form {
      margin-bottom: 2rem;
      padding: 1.5rem;
      background: #f8f9fa;
      border-radius: 8px;
    }

    .form-group {
      margin-bottom: 1rem;
    }

    .form-group label {
      display: block;
      margin-bottom: 0.5rem;
      font-weight: 500;
      color: #333;
    }

    .form-group input,
    .form-group textarea {
      width: 100%;
      padding: 0.75rem;
      border: 1px solid #ddd;
      border-radius: 5px;
      font-size: 1rem;
    }

    .form-group textarea {
      min-height: 100px;
      resize: vertical;
    }

    .submit-btn {
      background: #2c7a51;
      color: white;
      padding: 0.75rem 1.5rem;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 1rem;
      transition: background 0.3s ease;
    }

    .submit-btn:hover {
      background: #1f563a;
    }

    .comment {
      border-bottom: 1px solid #eee;
      padding-bottom: 1.5rem;
      margin-bottom: 1.5rem;
    }

    .comment:last-child {
      border-bottom: none;
      margin-bottom: 0;
    }

    .comment-header {
      display: flex;
      align-items: center;
      gap: 1rem;
      margin-bottom: 0.5rem;
    }

    .comment-avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: #2c7a51;
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: bold;
    }

    .comment-meta {
      flex: 1;
    }

    .comment-author {
      font-weight: 500;
      color: #333;
    }

    .comment-date {
      font-size: 0.9rem;
      color: #666;
    }

    .comment-text {
      color: #444;
      line-height: 1.6;
    }

    /* Sidebar */
    .sidebar {
      width: 300px;
    }

    .sidebar-widget {
      background: white;
      padding: 1.5rem;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      margin-bottom: 2rem;
    }

    .sidebar-widget h3 {
      color: #2c7a51;
      margin-bottom: 1rem;
      font-size: 1.2rem;
    }

    .related-post {
      display: flex;
      gap: 1rem;
      margin-bottom: 1rem;
      padding-bottom: 1rem;
      border-bottom: 1px solid #eee;
    }

    .related-post:last-child {
      border-bottom: none;
      margin-bottom: 0;
    }

    .related-post img {
      width: 80px;
      height: 60px;
      object-fit: cover;
      border-radius: 5px;
    }

    .related-post-content {
      flex: 1;
    }

    .related-post-title {
      font-size: 0.9rem;
      line-height: 1.4;
      margin-bottom: 0.5rem;
    }

    .related-post-title a {
      color: #333;
      text-decoration: none;
    }

    .related-post-title a:hover {
      color: #2c7a51;
    }

    .related-post-date {
      font-size: 0.8rem;
      color: #666;
    }

    /* Navigation */
    .article-navigation {
      display: flex;
      justify-content: space-between;
      margin-top: 2rem;
      gap: 1rem;
    }

    .nav-link {
      flex: 1;
      padding: 1rem;
      background: white;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      text-decoration: none;
      color: #333;
      transition: transform 0.3s ease;
    }

    .nav-link:hover {
      transform: translateY(-2px);
    }

    .nav-link.prev {
      text-align: left;
    }

    .nav-link.next {
      text-align: right;
    }

    .nav-label {
      font-size: 0.9rem;
      color: #666;
      margin-bottom: 0.5rem;
    }

    .nav-title {
      font-weight: 500;
      color: #2c7a51;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      .blog-detail-container {
        flex-direction: column;
      }

      .sidebar {
        width: 100%;
      }

      .article-title {
        font-size: 2rem;
      }

      .article-meta {
        gap: 1rem;
      }

      .share-buttons {
        justify-content: center;
      }

      .article-navigation {
        flex-direction: column;
      }

      .nav-link.next {
        text-align: left;
      }
    }

    /* Utility classes */
    .text-center {
      text-align: center;
    }

    .mb-2 {
      margin-bottom: 1rem;
    }

    .mb-3 {
      margin-bottom: 1.5rem;
    }
  </style>
</head>
<body>
  <!-- Navigation would be included here -->
  <?php include 'Komponen/navbar.php'; ?>

  <!-- Article Header -->
  <header class="blog-header">
    <div class="container">
      <div class="header-content">
        <h1 class="article-title">10 Tips Aman Mendaki Gunung untuk Pemula</h1>
        
        <div class="article-meta">
          <div class="meta-item">
            <i class="fas fa-user"></i>
            <span>John Doe</span>
          </div>
          <div class="meta-item">
            <i class="fas fa-calendar"></i>
            <span>15 Juli 2024</span>
          </div>
          <div class="meta-item">
            <i class="fas fa-clock"></i>
            <span>5 menit baca</span>
          </div>
          <div class="meta-item">
            <i class="fas fa-eye"></i>
            <span>1,234 views</span>
          </div>
        </div>
      </div>
    </div>
  </header>

  <main class="container blog-detail-container">
    <article class="article-content">
      <div class="article-body">
        <p>Mendaki gunung merupakan aktivitas yang menantang namun menyenangkan. Namun bagi pemula, persiapan matang sangat diperlukan untuk memastikan keselamatan dan kenyamanan selama perjalanan. Berikut adalah 10 tips aman mendaki gunung untuk pemula.</p>

        <img src="https://cdn.antaranews.com/cache/1200x800/2022/08/03/Kerinci.jpg" alt="Persiapan pendakian gunung" />

        <h2>1. Persiapan Fisik yang Matang</h2>
        <p>Sebelum mendaki, pastikan kondisi fisik Anda sudah siap. Mulailah rutin berolahraga minimal 4-6 minggu sebelum pendakian. Fokus pada latihan kardio seperti jogging, bersepeda, dan naik turun tangga untuk meningkatkan stamina.</p>

        <h2>2. Pelajari Rute Pendakian</h2>
        <p>Kenali rute yang akan dilalui, titik-titik penting, pos pendakian, dan estimasi waktu tempuh. Informasi ini dapat diperoleh dari berbagai sumber seperti komunitas pendaki, website resmi taman nasional, atau aplikasi pendakian.</p>

        <blockquote>
          "Persiapan yang baik adalah kunci dari pendakian yang aman dan menyenangkan." - Komunitas Pendaki Indonesia
        </blockquote>

        <h2>3. Persiapkan Perlengkapan yang Tepat</h2>
        <p>Perlengkapan yang tepat sangat krusial untuk keselamatan. Berikut adalah daftar perlengkapan dasar:</p>
        <ul>
          <li>Tas carrier dengan kapasitas sesuai kebutuhan</li>
          <li>Sepatu gunung yang sudah dicoba dan nyaman</li>
          <li>Pakaian berlapis (layer system)</li>
          <li>Sleeping bag dan matras</li>
          <li>Headlamp dan senter cadangan</li>
          <li>P3K dan obat-obatan pribadi</li>
          <li>Makanan dan minuman yang cukup</li>
        </ul>

        <img src="/api/placeholder/600/400" alt="Perlengkapan pendakian gunung" />

        <h2>4. Periksa Cuaca dan Kondisi Gunung</h2>
        <p>Selalu cek prakiraan cuaca dan kondisi gunung sebelum berangkat. Hindari mendaki saat cuaca buruk, musim hujan lebat, atau ada peringatan dari BMKG dan pengelola gunung.</p>

        <h2>5. Daftar dan Lapor ke Pos Pendakian</h2>
        <p>Jangan lupa untuk melakukan pendaftaran di pos pendakian dan melaporkan rencana perjalanan Anda. Ini penting untuk keselamatan dan memudahkan pencarian jika terjadi sesuatu.</p>

        <h2>6. Jaga Kecepatan Pendakian</h2>
        <p>Sebagai pemula, jangan terburu-buru. Ikuti prinsip "pelan tapi pasti". Istirahat secara teratur dan dengarkan tubuh Anda. Jika merasa lelah berlebihan, jangan memaksakan diri.</p>

        <h3>Tips Mengatur Ritme Pendakian:</h3>
        <ol>
          <li>Jalan 30-45 menit, istirahat 10-15 menit</li>
          <li>Minum air secara teratur</li>
          <li>Makan camilan energi setiap 1-2 jam</li>
          <li>Perhatikan tanda-tanda kelelahan</li>
        </ol>

        <h2>7. Bawa Air dan Makanan yang Cukup</h2>
        <p>Pastikan membawa air minum yang cukup, minimal 2-3 liter per hari. Bawa juga makanan berenergi tinggi seperti kurma, coklat, atau energy bar. Jangan lupa makanan pokok untuk makan besar.</p>

        <h2>8. Jaga Kebersihan Lingkungan</h2>
        <p>Terapkan prinsip "Leave No Trace". Bawa turun semua sampah Anda, jangan buang air kecil/besar sembarangan, dan jangan merusak vegetasi. Gunung adalah rumah bagi flora dan fauna, kita harus menjaganya.</p>

        <img src="/api/placeholder/600/400" alt="Menjaga kebersihan gunung" />

        <h2>9. Pahami Tanda-tanda Hipotermia dan AMS</h2>
        <p>Acute Mountain Sickness (AMS) dan hipotermia adalah risiko serius dalam pendakian. Pelajari gejalanya:</p>
        
        <h3>Gejala AMS:</h3>
        <ul>
          <li>Sakit kepala</li>
          <li>Mual dan muntah</li>
          <li>Kelelahan ekstrem</li>
          <li>Pusing</li>
          <li>Sulit tidur</li>
        </ul>

        <h3>Gejala Hipotermia:</h3>
        <ul>
          <li>Tubuh menggigil tidak terkendali</li>
          <li>Kulit pucat dan dingin</li>
          <li>Kehilangan koordinasi</li>
          <li>Bicara tidak jelas</li>
          <li>Mengantuk berlebihan</li>
        </ul>

        <h2>10. Bergabung dengan Grup Pendakian</h2>
        <p>Sebagai pemula, sangat disarankan untuk bergabung dengan grup pendakian yang berpengalaman. Mereka bisa membimbing dan membantu jika terjadi masalah. Hindari mendaki sendirian, terutama untuk gunung-gunung tinggi.</p>

        <h2>Kesimpulan</h2>
        <p>Mendaki gunung adalah aktivitas yang luar biasa dan memberikan pengalaman tak terlupakan. Dengan persiapan yang matang dan mengikuti tips keselamatan di atas, Anda dapat menikmati petualangan ini dengan aman. Ingatlah bahwa keselamatan adalah prioritas utama, dan tidak ada yang salah dengan memutuskan untuk turun jika kondisi tidak memungkinkan.</p>

        <p>Selamat mendaki dan semoga tips ini bermanfaat untuk perjalanan Anda! Jangan lupa untuk selalu menghormati alam dan sesama pendaki.</p>
      </div>

      <!-- Social Share -->
      <div class="social-share">
        <h4>Bagikan Artikel Ini</h4>
        <div class="share-buttons">
          <a href="#" class="share-btn facebook">
            <i class="fab fa-facebook-f"></i> Facebook
          </a>
          <a href="#" class="share-btn twitter">
            <i class="fab fa-twitter"></i> Twitter
          </a>
          <a href="#" class="share-btn whatsapp">
            <i class="fab fa-whatsapp"></i> WhatsApp
          </a>
          <a href="#" class="share-btn linkedin">
            <i class="fab fa-linkedin-in"></i> LinkedIn
          </a>
        </div>
      </div>

      <!-- Comments Section -->
      <section class="comments-section">
        <h3><i class="fas fa-comments"></i> Komentar (3)</h3>
        
        <!-- Comment Form -->
        <form class="comment-form">
          <h4 class="mb-2">Tinggalkan Komentar</h4>
          <div class="form-group">
            <label for="comment-name">Nama *</label>
            <input type="text" id="comment-name" name="name" required>
          </div>
          <div class="form-group">
            <label for="comment-email">Email *</label>
            <input type="email" id="comment-email" name="email" required>
          </div>
          <div class="form-group">
            <label for="comment-message">Pesan *</label>
            <textarea id="comment-message" name="message" placeholder="Tulis komentar Anda..." required></textarea>
          </div>
          <button type="submit" class="submit-btn">
            <i class="fas fa-paper-plane"></i> Kirim Komentar
          </button>
        </form>

        <!-- Existing Comments -->
        <div class="comments-list">
          <div class="comment">
            <div class="comment-header">
              <div class="comment-avatar">AS</div>
              <div class="comment-meta">
                <div class="comment-author">Anton Setiawan</div>
                <div class="comment-date">16 Juli 2024, 10:30</div>
              </div>
            </div>
            <div class="comment-text">
              Artikel yang sangat bermanfaat! Saya baru-baru ini mendaki Gunung Lawu dan tips-tips ini benar-benar membantu. Terutama soal persiapan fisik, saya merasa bedanya ketika sudah latihan rutin sebelumnya.
            </div>
          </div>

          <div class="comment">
            <div class="comment-header">
              <div class="comment-avatar">MR</div>
              <div class="comment-meta">
                <div class="comment-author">Maya Rahayu</div>
                <div class="comment-date">15 Juli 2024, 20:15</div>
              </div>
            </div>
            <div class="comment-text">
              Terima kasih untuk tipsnya! Sebagai perempuan yang baru ingin mulai mendaki, artikel ini memberikan banyak insight. Boleh tanya, untuk pemula sebaiknya mulai dari gunung apa ya?
            </div>
          </div>

          <div class="comment">
            <div class="comment-header">
              <div class="comment-avatar">RH</div>
              <div class="comment-meta">
                <div class="comment-author">Rian Hidayat</div>
                <div class="comment-date">15 Juli 2024, 14:45</div>
              </div>
            </div>
            <div class="comment-text">
              Setuju banget dengan poin tentang menjaga kebersihan lingkungan. Sayangnya masih banyak pendaki yang kurang peduli. Mari kita jaga gunung-gunung kita agar tetap indah untuk generasi mendatang.
            </div>
          </div>
        </div>
      </section>

      <!-- Article Navigation -->
      <nav class="article-navigation">
        <a href="#" class="nav-link prev">
          <div class="nav-label">
            <i class="fas fa-chevron-left"></i> Artikel Sebelumnya
          </div>
          <div class="nav-title">5 Destinasi Wisata Kuliner </div>
        </a>
        <a href="#" class="nav-link next">
          <div class="nav-label">
            Artikel Selanjutnya <i class="fas fa-chevron-right"></i>
          </div>
          <div class="nav-title">7 Pantai Tersembunyi di Indonesia</div>
        </a>
      </nav>
    </article>

    <!-- Sidebar -->
    <aside class="sidebar">
      <!-- Related Posts -->
      <div class="sidebar-widget">
        <h3><i class="fas fa-newspaper"></i> Artikel Terkait</h3>
        <div class="related-post">
          <img src="https://bobobox.com/blog/wp-content//uploads/2023/07/Sleeping-Bag.jpg" alt="Perlengkapan camping">
          <div class="related-post-content">
            <div class="related-post-title">
              <a href="#">Daftar Perlengkapan Camping untuk Pemula</a>
            </div>
            <div class="related-post-date">10 Juli 2024</div>
          </div>
        </div>
        <div class="related-post">
          <img src="https://akcdn.detik.net.id/visual/2018/07/29/bc121b83-938b-4c7c-946c-1f6f22e75d6d_169.jpeg?w=1200" alt="Gunung Rinjani">
          <div class="related-post-content">
            <div class="related-post-title">
              <a href="#">Panduan Pendakian Gunung Rinjani</a>
            </div>
            <div class="related-post-date">8 Juli 2024</div>
          </div>
        </div>
        <div class="related-post">
          <img src="https://www.wisatagunung.com/wp-content/uploads/2021/05/savana-dan-gunung-mereapi-dan-gunung-merbabu-scaled.jpg" alt="Merbabu sunrise">
          <div class="related-post-content">
            <div class="related-post-title">
              <a href="#">Menikmati Sunrise di Puncak Merbabu</a>
            </div>
            <div class="related-post-date">5 Juli 2024</div>
          </div>
        </div>
      </div>

      <!-- Popular Posts -->
      <div class="sidebar-widget">
        <h3><i class="fas fa-fire"></i> Artikel Populer</h3>
        <div class="related-post">
          <img src="https://cdn.rri.co.id/berita/Surabaya/o/1727694944790-IMG_2219/eexf4sck8fztc29.jpeg" alt="Raja Ampat">
          <div class="related-post-content">
            <div class="related-post-title">
              <a href="#">Wisata Bahari Lamongan</a>
            </div>
            <div class="related-post-date">2,345 views</div>
          </div>
        </div>
        <div class="related-post">
          <img src="https://statik.tempo.co/data/2019/10/31/id_885298/885298_720.jpg" alt="Festival budaya">
          <div class="related-post-content">
            <div class="related-post-title">
              <a href="#">Festival Budaya Indonesia 2024</a>
            </div>
            <div class="related-post-date">1,876 views</div>
          </div>
        </div>
        <div class="related-post">
          <img src="https://statik.tempo.co/data/2019/10/31/id_885298/885298_720.jpg" alt="Kuliner Jawa Barat">
          <div class="related-post-content">
            <div class="related-post-title">
              <a href="#">5 Destinasi Wisata Kuliner</a>
            </div>
            <div class="related-post-date">1,654 views</div>
          </div>
        </div>
      </div>

      <!-- Tags -->
      <div class="sidebar-widget">
        <h3><i class="fas fa-tags"></i> Tags</h3>
        <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
          <span style="background: #f0f0f0; padding: 0.25rem 0.75rem; border-radius: 15px; font-size: 0.9rem; color: #666;">#pendakian</span>
          <span style="background: #f0f0f0; padding: 0.25rem 0.75rem; border-radius: 15px; font-size: 0.9rem; color: #666;">#gunung</span>
          <span style="background: #f0f0f0; padding: 0.25rem 0.75rem; border-radius: 15px; font-size: 0.9rem; color: #666;">#adventure</span>
          <span style="background: #f0f0f0; padding: 0.25rem 0.75rem; border-radius: 15px; font-size: 0.9rem; color: #666;">#tips</span>
          <span style="background: #f0f0f0; padding: 0.25rem 0.75rem; border-radius: 15px; font-size: 0.9rem; color: #666;">#pemula</span>
          <span style="background: #f0f0f0; padding: 0.25rem 0.75rem; border-radius: 15px; font-size: 0.9rem; color: #666;">#keselamatan</span>
        </div>
      </div>
    </aside>
  </main>

  <!-- Footer would be included here -->
  <!-- <?php include 'Komponen/footer.php'; ?> -->

  <script>
    // Simple script for comment form
    document.querySelector('.comment-form').addEventListener('submit', function(e) {
      e.preventDefault();
      alert('Komentar berhasil dikirim! (Ini hanya demo)');
      // Reset form
      this.reset();
    });

    // Smooth scrolling for navigation links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
          target.scrollIntoView({
            behavior: 'smooth'
          });
        }
      });
    });

    // Share buttons functionality
    document.querySelectorAll('.share-btn').forEach(btn => {
      btn.addEventListener('click', function(e) {
        e.preventDefault();
        const platform = this.classList[1]; // facebook, twitter, etc.
        const url = encodeURIComponent(window.location.href);
        const title = encodeURIComponent(document.title);
        
        let shareUrl;
        switch(platform) {
          case 'facebook':
            shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
            break;
          case 'twitter':
            shareUrl = `https://twitter.com/intent/tweet?url=${url}&text=${title}`;
            break;
          case 'whatsapp':
            shareUrl = `https://wa.me/?text=${title} ${url}`;
            break;
          case 'linkedin':
            shareUrl = `https://www.linkedin.com/sharing/share-offsite/?url=${url}`;
            break;
        }
        
        if (shareUrl) {
          window.open(shareUrl, '_blank', 'width=600,height=400');
        }
      });
    });

    // Reading progress indicator
    window.addEventListener('scroll', function() {
      const article = document.querySelector('.article-content');
      const scrollTop = window.pageYOffset;
      const docHeight = document.documentElement.scrollHeight - window.innerHeight;
      const scrollPercent = (scrollTop / docHeight) * 100;
      
      // You can add a progress bar here if needed
      // For now, we'll just add a simple indicator
      if (scrollPercent > 10 && !document.querySelector('.reading-progress')) {
        const progressBar = document.createElement('div');
        progressBar.className = 'reading-progress';
        progressBar.style.cssText = `
          position: fixed;
          top: 0;
          left: 0;
          height: 3px;
          background: #2c7a51;
          width: ${scrollPercent}%;
          z-index: 1000;
          transition: width 0.1s ease;
        `;
        document.body.appendChild(progressBar);
      } else if (document.querySelector('.reading-progress')) {
        document.querySelector('.reading-progress').style.width = `${scrollPercent}%`;
      }
    });

    // Copy link functionality (you can add a copy link button if needed)
    function copyToClipboard() {
      navigator.clipboard.writeText(window.location.href).then(function() {
        alert('Link berhasil disalin!');
      });
    }
    </script>
</body>
</html>