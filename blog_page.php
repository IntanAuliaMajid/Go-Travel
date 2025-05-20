<!-- blog.php -->
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Blog Wisata Indonesia</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
    /* Improved Blog Styles */
    .blog-hero {
      background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), 
                  url('https://plus.unsplash.com/premium_photo-1684581214880-2043e5bc8b8b?fm=jpg&q=60&w=3000&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8YmxvZyUyMGJhY2tncm91bmR8ZW58MHx8MHx8fDA%3D') no-repeat center center/cover;
      min-height: 60vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      padding: 2rem;
      color: white;
    }

    .blog-search {
      max-width: 600px;
      width: 100%;
      margin-top: 2rem;
      display: flex;
      gap: 0.5rem;
    }

    .blog-search input {
      flex: 1;
      padding: 0.8rem;
      border: none;
      border-radius: 8px;
    }

    .blog-search button {
      background: #2c7a51;
      color: white;
      border: none;
      padding: 0.8rem 1.5rem;
      border-radius: 8px;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .blog-search button:hover {
      background: #1f563a;
    }

    .blog-container {
      display: flex;
      gap: 2rem;
      padding: 2rem 0;
    }

    .blog-main {
      flex: 1;
    }

    .blog-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 2rem;
      margin-bottom: 3rem;
    }

    .blog-post {
    padding: 1rem;
      background: white;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
    }

    .blog-post:hover {
      transform: translateY(-5px);
    }

    .blog-post img {
      width: 100%;
      height: 200px;
      object-fit: cover;
    }

    .blog-category {
      background-color: #2c7a51;
      color: white;
      padding: 0.25rem 0.75rem;
      border-radius: 50px;
      font-size: 0.8rem;
      position: absolute;
      top: 1rem;
      left: 1rem;
    }

    .blog-meta {
      display: flex;
      justify-content: space-between;
      color: #666;
      font-size: 0.9rem;
      margin-bottom: 1rem;
      flex-wrap: wrap;
      gap: 0.5rem;
    }

    .blog-content {
      padding: 1.5rem;
    }

    .blog-excerpt {
      color: #666;
      margin: 1rem 0;
      line-height: 1.6;
      display: -webkit-box;
      -webkit-line-clamp: 3;
      -webkit-box-orient: vertical;
      overflow: hidden;
      min-height: 4.8em;
    }

    .sidebar {
      width: 300px;
      padding: 1rem;
    }

    .recent-posts {
      background: #fff;
      padding: 1.5rem;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .pagination {
      display: flex;
      justify-content: center;
      gap: 0.5rem;
      margin-top: 2rem;
    }

    .pagination a {
      padding: 0.5rem 1rem;
      border-radius: 5px;
      background: #f0f0f0;
      color: #333;
      text-decoration: none;
      transition: background 0.3s ease;
    }

    .pagination a:hover,
    .pagination a.active {
      background: #2c7a51;
      color: white;
    }

    @media (max-width: 768px) {
      .blog-container {
        flex-direction: column;
      }

      .sidebar {
        width: 100%;
        padding: 0;
      }

      .blog-grid {
        grid-template-columns: 1fr;
      }

      .blog-search {
        flex-direction: column;
      }

      .blog-search button {
        width: 100%;
      }
    }
  </style>
</head>
<body>
  <?php include 'Komponen/navbar.php'; ?>

  <!-- Blog Hero Section -->    
  <header class="blog-hero">
    <h1>Artikel Wisata Indonesia</h1>
    <p>Temukan tips perjalanan, panduan destinasi, dan cerita inspiratif seputar wisata Indonesia</p>
    <form class="blog-search" role="search">
      <input type="text" placeholder="Cari artikel..." aria-label="Cari artikel">
      <button type="submit"><i class="fas fa-search"></i> Cari</button>
    </form>
  </header>

  <main class="container blog-container">
    <div class="blog-main">
      <section aria-labelledby="latest-articles">
        <h2 id="latest-articles" class="section-heading" style="padding:1rem;">Artikel Terbaru</h2>
        <div class="blog-grid">
          <!-- Blog Post 1 -->
          <article class="blog-post">
            <div class="card-image">
              <img src="https://images.unsplash.com/photo-1503220317375-aaad61436b1b" 
                   alt="Pendaki di puncak gunung" 
                   loading="lazy">
            </div>
            <div class="blog-content">
              <div class="blog-meta">
                <span><i class="fas fa-user" aria-hidden="true"></i> John Doe</span>
                <span><i class="fas fa-calendar" aria-hidden="true"></i> 15 Juli 2024</span>
              </div>
              <h3>10 Tips Aman Mendaki Gunung untuk Pemula</h3>
              <p class="blog-excerpt">
                Mendaki gunung merupakan aktivitas yang menantang namun menyenangkan. Namun bagi pemula, perlu persiapan matang...
              </p>
              <a href="blog_detail.php" class="card-button" aria-label="Baca artikel tentang tips mendaki gunung">
                Baca Selengkapnya
              </a>
            </div>
          </article>

          <!-- Blog Post 2 -->
          <article class="blog-post">
            <div class="card-image">
              <img src="https://images.unsplash.com/photo-1506477331477-33d5d8b3dc85" 
                   alt="Pantai berpasir putih dengan air jernih" 
                   loading="lazy">
            </div>
            <div class="blog-content">
              <div class="blog-meta">
                <span><i class="fas fa-user" aria-hidden="true"></i> Jane Smith</span>
                <span><i class="fas fa-calendar" aria-hidden="true"></i> 12 Juli 2024</span>
              </div>
              <h3>7 Pantai Tersembunyi di Indonesia Timur</h3>
              <p class="blog-excerpt">
                Indonesia timur menyimpan banyak pesona pantai yang masih alami. Dari pasir putih hingga biota laut...
              </p>
              <a href="blog_detail.php" class="card-button" aria-label="Baca artikel tentang pantai tersembunyi">
                Baca Selengkapnya
              </a>
            </div>
          </article>
        </div>
      </section>

      <!-- Pagination -->
      <nav class="pagination" aria-label="Navigasi halaman">
        <a href="#" class="active">1</a>
        <a href="#">2</a>
        <a href="#">3</a>
        <a href="#">4</a>
        <a href="#">5</a>
        <a href="#" aria-label="Halaman berikutnya">&raquo;</a>
      </nav>
    </div>

    <!-- Sidebar -->
    <aside class="sidebar" aria-labelledby="recent-posts-heading">
      <div class="recent-posts">
        <h3 id="recent-posts-heading">Artikel Terpopuler</h3>
        <!-- Recent posts list here -->
        <ul>
          <li><a href="#">5 Destinasi Wisata Kuliner di Jawa Timur</a></li>
          <li><a href="#">Panduan Backpacker ke Raja Ampat</a></li>
          <li><a href="#">Festival Budaya Indonesia 2024</a></li>
        </ul>
      </div>
    </aside>
  </main>

  <?php include 'Komponen/footer.php'; ?>
</body>
</html>