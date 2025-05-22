<!-- blog.php -->
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Blog Wisata Indonesia</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
    /* Tambahan styling khusus blog */
    .blog-hero {
      background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), 
                  url('https://images.unsplash.com/photo-1504384308090-c894fdcc538d') no-repeat center center/cover;
    }

    .blog-card {
      position: relative;
    }

    .blog-meta {
      display: flex;
      justify-content: space-between;
      color: #666;
      font-size: 0.9rem;
      margin-bottom: 1rem;
    }

    .blog-category {
      position: absolute;
      top: 1rem;
      left: 1rem;
      background-color: #2c7a51;
      color: white;
      padding: 0.25rem 0.75rem;
      border-radius: 50px;
      font-size: 0.8rem;
    }

    .blog-excerpt {
      color: #666;
      margin-bottom: 1rem;
      display: -webkit-box;
      -webkit-line-clamp: 3;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }

    /* Detail Blog */
    .blog-header {
      text-align: center;
      margin-bottom: 3rem;
    }

    .blog-date {
      color: #666;
      margin-bottom: 1rem;
    }

    .blog-content {
      max-width: 800px;
      margin: 0 auto;
      line-height: 1.8;
    }

    .blog-image {
      width: 100%;
      height: 400px;
      object-fit: cover;
      border-radius: 10px;
      margin: 2rem 0;
    }

    .recent-posts {
      background: #fff;
      padding: 1.5rem;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    @media (max-width: 768px) {
      .blog-content {
        padding: 0 1rem;
      }
      .sidebar {
        width: 100%;
        padding-left: 0;
        margin-top: 2rem;
      }
    }
  </style>
</head>
<body>
  <?php include 'Komponen/navbar.php'; ?>

  <!-- Blog Hero Section -->
  <section class="hero blog-hero">
    <h1>Artikel Wisata Indonesia</h1>
    <p>Temukan tips perjalanan, panduan destinasi, dan cerita inspiratif seputar wisata Indonesia</p>
    <div class="search-container">
      <input type="text" placeholder="Cari artikel...">
      <button><i class="fas fa-search"></i> Cari</button>
    </div>
  </section>

  <!-- Blog Container -->
  <section class="container">
    <div class="section-heading">
      <h2>Artikel Terbaru</h2>
      <p>Update terbaru seputar dunia pariwisata Indonesia</p>
    </div>

    <div class="destinations-grid">
      <!-- Blog Post 1 -->
      <article class="destination-card blog-card">
        <div class="card-image">
          <img src="https://images.unsplash.com/photo-1503220317375-aaad61436b1b" alt="Tips Naik Gunung">
          <span class="blog-category">Pendakian</span>
        </div>
        <div class="card-content">
          <div class="blog-meta">
            <span><i class="fas fa-user"></i> John Doe</span>
            <span><i class="fas fa-calendar"></i> 15 Juli 2024</span>
          </div>
          <h3>10 Tips Aman Mendaki Gunung untuk Pemula</h3>
          <div class="blog-excerpt">
            Mendaki gunung merupakan aktivitas yang menantang namun menyenangkan. Namun bagi pemula, perlu persiapan matang...
          </div>
          <div class="card-meta">
            <a href="blog-detail.php?id=1" class="card-button">Baca Selengkapnya</a>
          </div>
        </div>
      </article>

      <!-- Blog Post 2 -->
      <article class="destination-card blog-card">
        <div class="card-image">
          <img src="https://images.unsplash.com/photo-1506477331477-33d5d8b3dc85" alt="Pantai Eksotis">
          <span class="blog-category">Pantai</span>
        </div>
        <div class="card-content">
          <div class="blog-meta">
            <span><i class="fas fa-user"></i> Jane Smith</span>
            <span><i class="fas fa-calendar"></i> 12 Juli 2024</span>
          </div>
          <h3>7 Pantai Tersembunyi di Indonesia Timur</h3>
          <div class="blog-excerpt">
            Indonesia timur menyimpan banyak pesona pantai yang masih alami. Dari pasir putih hingga biota laut...
          </div>
          <div class="card-meta">
            <a href="blog-detail.php?id=2" class="card-button">Baca Selengkapnya</a>
          </div>
        </div>
      </article>

      <!-- Tambahkan lebih banyak blog post -->
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

  <?php include 'Komponen/footer.php'; ?>
</body>
</html>

<!-- blog-detail.php -->
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Detail Blog - Wisata Indonesia</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body>
  <?php include 'Komponen/navbar.php'; ?>

  <main class="container">
    <article>
      <!-- Blog Header -->
      <header class="blog-header">
        <div class="blog-meta">
          <span class="blog-category">Pendakian</span>
          <span class="blog-date"><i class="fas fa-calendar"></i> 15 Juli 2024</span>
        </div>
        <h1>10 Tips Aman Mendaki Gunung untuk Pemula</h1>
      </header>

      <!-- Blog Content -->
      <div class="blog-content">
        <img src="https://images.unsplash.com/photo-1503220317375-aaad61436b1b" alt="Tips Naik Gunung" class="blog-image">

        <div class="author-info">
          <img src="author-avatar.jpg" alt="John Doe" style="width:50px; border-radius:50%;">
          <div>
            <h4>John Doe</h4>
            <p>Penulis Wisata & Pendaki Professional</p>
          </div>
        </div>

        <div class="article-content">
          <h2>Persiapan Fisik dan Mental</h2>
          <p>Mendaki gunung bukan sekadar jalan-jalan biasa. Anda perlu mempersiapkan fisik minimal 1 bulan sebelumnya...</p>
          
          <h3>1. Latihan Kardio Rutin</h3>
          <p>Lakukan lari pagi minimal 3 kali seminggu dengan durasi 30 menit...</p>

          <h2>Peralatan Wajib</h2>
          <ul>
            <li>Sepatu hiking yang nyaman</li>
            <li>Jaket anti air</li>
            <li>Sleeping bag</li>
          </ul>

          <blockquote>
            "Keselamatan harus menjadi prioritas utama dalam setiap pendakian"
          </blockquote>
        </div>

        <!-- Social Sharing -->
        <div class="social-sharing">
          <span>Bagikan Artikel:</span>
          <a href="#"><i class="fab fa-facebook"></i></a>
          <a href="#"><i class="fab fa-twitter"></i></a>
          <a href="#"><i class="fab fa-whatsapp"></i></a>
        </div>
      </div>

      <!-- Sidebar -->
      <aside class="sidebar">
        <div class="recent-posts">
          <h3>Artikel Terbaru</h3>
          <div class="recent-post">
            <img src="thumb1.jpg" alt="Post Terbaru">
            <h4><a href="#">7 Pantai Tersembunyi</a></h4>
            <span>12 Juli 2024</span>
          </div>
          <!-- Tambahkan lebih banyak recent post -->
        </div>
      </aside>
    </article>

    <!-- Related Posts -->
    <section class="categories-section">
      <div class="container">
        <div class="section-heading">
          <h2>Artikel Terkait</h2>
        </div>
        <div class="destinations-grid">
          <!-- Tambahkan related posts -->
        </div>
      </div>
    </section>
  </main>

  <?php include 'Komponen/footer.php'; ?>
</body>
</html>