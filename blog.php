<?php
include 'Komponen/navbar.php'; // Make sure this path is correct
require_once 'backend/koneksi.php'; // Ensure this file provides $conn as a mysqli object

// Function to create an excerpt
function create_excerpt($text, $limit = 150, $ellipsis = "...") {
    $text = strip_tags($text); // Remove HTML tags
    if (strlen($text) > $limit) {
        $text = substr($text, 0, $limit);
        $text = substr($text, 0, strrpos($text, ' ')); // Ensure we don't cut in the middle of a word
        $text .= $ellipsis;
    }
    return $text;
}

// --- Pagination Logic ---
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$posts_per_page = 6;
$offset = ($page - 1) * $posts_per_page;

// --- Search Logic (preparing for mysqli) ---
$search_term = isset($_GET['search']) ? trim($_GET['search']) : '';
$search_query_part = "";
$search_params_values = []; // For values to bind
$search_param_types = "";   // For type string in bind_param

if (!empty($search_term)) {
    $search_query_part = " WHERE (a.judul_artikel LIKE ? OR a.isi_artikel LIKE ? OR ja.jenis_artikel LIKE ?)";
    $like_search_term = '%' . $search_term . '%';
    $search_params_values[] = $like_search_term; // for judul
    $search_params_values[] = $like_search_term; // for isi
    $search_params_values[] = $like_search_term; // for jenis
    $search_param_types .= "sss"; // three strings
}

// --- Fetch Total Articles for Pagination (mysqli) ---
$total_sql = "SELECT COUNT(a.id_artikel)
              FROM artikel a
              LEFT JOIN jenis_artikel ja ON a.id_jenis_artikel = ja.id_jenis_artikel" . $search_query_part;

$total_stmt = $conn->prepare($total_sql);
if (!$total_stmt) {
    die("Error preparing total count query: " . $conn->error); // Basic error handling
}

if (!empty($search_term)) {
    $total_stmt->bind_param($search_param_types, ...$search_params_values);
}
$total_stmt->execute();
$total_stmt->bind_result($total_articles_count);
$total_stmt->fetch();
$total_stmt->close();

$total_articles = $total_articles_count;
$total_pages = ($total_articles > 0) ? ceil($total_articles / $posts_per_page) : 0;


// --- Fetch Articles for Current Page (mysqli) ---
$sql = "SELECT a.id_artikel, a.judul_artikel, a.tanggal_dipublish, a.isi_artikel,
               COALESCE(ga.url, 'https://via.placeholder.com/400x200.png?text=No+Image+Available') AS gambar_url,
               ja.jenis_artikel AS kategori_artikel
        FROM artikel a
        LEFT JOIN gambar_artikel ga ON a.id_gambar_artikel = ga.id_gambar_artikel
        LEFT JOIN jenis_artikel ja ON a.id_jenis_artikel = ja.id_jenis_artikel"
        . $search_query_part . // Contains '?' if search is active
       " ORDER BY a.tanggal_dipublish DESC
        LIMIT ?, ?"; // Placeholders for limit and offset

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error preparing main articles query: " . $conn->error); // Basic error handling
}

// Combine search params with pagination params for binding
$current_bind_params_values = $search_params_values; // Start with search values
$current_bind_param_types = $search_param_types;   // Start with search types

$current_bind_params_values[] = $offset;           // Add offset value
$current_bind_params_values[] = $posts_per_page;   // Add limit value
$current_bind_param_types .= "ii";                 // Add types for offset and limit (integers)

if (!empty($current_bind_param_types)) { // Bind if there are any parameters
    $stmt->bind_param($current_bind_param_types, ...$current_bind_params_values);
}

$stmt->execute();
$result = $stmt->get_result(); // Get mysqli_result object
$articles = [];
if ($result) {
    $articles = $result->fetch_all(MYSQLI_ASSOC); // Fetch all rows
}
$stmt->close();


// --- Fetch Popular/Recent Articles for Sidebar (mysqli) ---
$popular_sql = "SELECT id_artikel, judul_artikel FROM artikel ORDER BY tanggal_dipublish DESC LIMIT 3";
$popular_result = $conn->query($popular_sql);
$popular_articles = [];
if ($popular_result) {
    $popular_articles = $popular_result->fetch_all(MYSQLI_ASSOC);
    $popular_result->free(); // Free result set
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Blog - GoTravel</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
    /* Improved Blog Styles */
    body { font-family: Arial, sans-serif; margin: 0; background-color: #f9f9f9; color: #333;}
    .container { max-width: 1200px; margin: 0 auto; padding: 0 1rem; }
    .section-heading { font-size: 2rem; color: #333; margin-bottom: 1.5rem; text-align: center; }
    .card-button {
        display: inline-block;
        background-color: #2c7a51;
        color: white;
        padding: 0.6rem 1.2rem;
        border-radius: 5px;
        text-decoration: none;
        transition: background-color 0.3s ease;
        margin-top: 1rem;
        font-size: 0.9rem;
    }
    .card-button:hover { background-color: #1f563a; }

    .blog-hero {
      background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),
                  url('https://plus.unsplash.com/premium_photo-1684581214880-2043e5bc8b8b?fm=jpg&q=60&w=3000&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8YmxvZyUyMGJhY2tncm91bmR8ZW58MHx8MHx8fDA%3D') no-repeat center center/cover;
      min-height: 70vh; /* Reduced height a bit */
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      padding: 2rem;
      color: white;
    }
    .blog-hero h1 { font-size: 3rem; margin-bottom: 0.5rem;}
    .blog-hero p { font-size: 1.2rem; margin-bottom: 2rem; max-width: 700px;}

    .blog-search {
      max-width: 600px;
      width: 90%; /* Responsive width */
      margin-top: 2rem;
      display: flex;
      gap: 0.5rem;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1); /* Subtle shadow */
    }

    .blog-search input {
      flex: 1;
      padding: 0.9rem; /* Increased padding */
      border: 1px solid #ddd; /* Softer border */
      border-radius: 8px 0 0 8px; /* Rounded left corners */
      font-size: 1rem;
    }
    .blog-search input:focus { outline-color: #2c7a51; }


    .blog-search button {
      background: #2c7a51;
      color: white;
      border: none;
      padding: 0.9rem 1.5rem; /* Increased padding */
      border-radius: 0 8px 8px 0; /* Rounded right corners */
      cursor: pointer;
      transition: background 0.3s ease;
      font-size: 1rem;
    }

    .blog-search button:hover {
      background: #1f563a;
    }

    .blog-container {
      display: flex;
      gap: 2rem;
      padding: 3rem 0; /* Increased padding */
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
      background: white;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08); /* Softer shadow */
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      display: flex; /* For consistent card structure */
      flex-direction: column; /* Stack image, content */
    }

    .blog-post:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
    }

    .blog-post .card-image { /* Added class for image container */
        width: 100%;
        height: 200px;
        position: relative; /* For positioning blog-category */
    }
    .blog-post .card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .blog-category {
      background-color: #2c7a51;
      color: white;
      padding: 0.3rem 0.8rem; /* Adjusted padding */
      border-radius: 50px;
      font-size: 0.75rem; /* Adjusted font size */
      position: absolute;
      top: 1rem;
      left: 1rem;
      z-index: 1;
      font-weight: 500;
    }

    .blog-content {
      padding: 1.5rem;
      flex-grow: 1; /* Allow content to take remaining space */
      display: flex; /* For aligning button to bottom */
      flex-direction: column; /* Stack content elements */
    }
    .blog-content h3 {
        font-size: 1.4rem; margin-top: 0.5rem; margin-bottom: 0.75rem; color: #333;
        line-height: 1.3;
    }


    .blog-meta {
      display: flex;
      color: #777; /* Lighter color */
      font-size: 0.85rem; /* Adjusted font size */
      margin-bottom: 1rem;
      flex-wrap: wrap;
      gap: 1rem; /* Spacing between meta items */
    }
    .blog-meta span { display: inline-flex; align-items: center; }
    .blog-meta i { margin-right: 0.4rem; color: #2c7a51;}


    .blog-excerpt {
      color: #555; /* Slightly darker than meta */
      margin: 0 0 1rem 0; /* Adjusted margin */
      line-height: 1.6;
      font-size: 0.95rem;
      display: -webkit-box;
      -webkit-line-clamp: 3; /* Show 3 lines */
      -webkit-box-orient: vertical;
      overflow: hidden;
      min-height: calc(1.6em * 3); /* Approx height for 3 lines */
      flex-grow: 1; /* Push button to bottom */
    }

    .sidebar {
      width: 300px;
      padding-top: 0; /* Align with top of blog-main content */
    }

    .recent-posts {
      background: #fff;
      padding: 1.5rem;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    }
    .recent-posts h3 {
        font-size: 1.3rem;
        color: #333;
        margin-top:0;
        margin-bottom: 1rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #eee;
    }
    .recent-posts ul { list-style: none; padding: 0; margin: 0;}
    .recent-posts li a {
        text-decoration: none;
        color: #2c7a51;
        display: block;
        padding: 0.6rem 0;
        border-bottom: 1px solid #f5f5f5;
        transition: color 0.3s ease;
        font-size: 0.95rem;
    }
    .recent-posts li:last-child a { border-bottom: none; }
    .recent-posts li a:hover { color: #1f563a; }


    .pagination {
      display: flex;
      justify-content: center;
      gap: 0.5rem;
      margin-top: 3rem; /* Increased margin */
      padding-bottom: 2rem;
    }

    .pagination a {
      padding: 0.6rem 1.1rem; /* Adjusted padding */
      border-radius: 5px;
      background: #e9e9e9; /* Lighter background */
      color: #555;
      text-decoration: none;
      transition: background 0.3s ease, color 0.3s ease;
      font-size: 0.9rem;
    }

    .pagination a:hover,
    .pagination a.active {
      background: #2c7a51;
      color: white;
    }
    .pagination span { /* For "..." */
        padding: 0.6rem 0.8rem;
        color: #999;
    }


    @media (max-width: 992px) { /* Adjusted breakpoint */
      .blog-container {
        flex-direction: column;
      }
      .sidebar {
        width: 100%;
        margin-top: 2rem; /* Add space when stacked */
      }
    }

    @media (max-width: 768px) {
      .blog-hero h1 { font-size: 2.5rem; }
      .blog-hero p { font-size: 1rem; }
      .blog-search {
        flex-direction: column;
      }
      .blog-search input, .blog-search button {
        border-radius: 8px; /* Full radius when stacked */
      }
      .blog-search button {
        width: 100%;
      }
      .blog-grid {
        grid-template-columns: 1fr; /* Single column on smaller screens */
      }
    }
  </style>
</head>
<body>
  <header class="blog-hero">
    <h1>Artikel Wisata Indonesia</h1>
    <p>Temukan tips perjalanan, panduan destinasi, dan cerita inspiratif seputar wisata Indonesia</p>
    <form class="blog-search" role="search" method="GET" action="blog.php">
      <input name="search" type="text" placeholder="Cari artikel..." aria-label="Cari artikel" value="<?php echo htmlspecialchars($search_term); ?>">
      <button type="submit"><i class="fas fa-search"></i> Cari</button>
    </form>
  </header>

  <main class="container blog-container">
    <div class="blog-main">
      <section aria-labelledby="latest-articles">
        <h2 id="latest-articles" class="section-heading" style="padding:1rem 0; text-align:left;">
            <?php echo !empty($search_term) ? 'Hasil Pencarian untuk "' . htmlspecialchars($search_term) . '"' : 'Artikel Terbaru'; ?>
        </h2>
        <div class="blog-grid">
          <?php if (empty($articles)): ?>
            <p style="grid-column: 1 / -1; text-align: center; font-size: 1.1rem;">
                <?php echo !empty($search_term) ? 'Tidak ada artikel yang cocok dengan pencarian Anda.' : 'Belum ada artikel untuk ditampilkan.'; ?>
            </p>
          <?php else: ?>
            <?php foreach ($articles as $article): ?>
            <article class="blog-post">
              <div class="card-image">
                <img src="<?php echo htmlspecialchars($article['gambar_url']); ?>"
                     alt="Gambar untuk <?php echo htmlspecialchars($article['judul_artikel']); ?>"
                     loading="lazy">
                <?php if (!empty($article['kategori_artikel'])): ?>
                  <span class="blog-category"><?php echo htmlspecialchars($article['kategori_artikel']); ?></span>
                <?php endif; ?>
              </div>
              <div class="blog-content">
                <div class="blog-meta">
                  <span><i class="fas fa-user" aria-hidden="true"></i> GoTravel Admin</span> <span><i class="fas fa-calendar" aria-hidden="true"></i>
                    <?php echo htmlspecialchars(date("d F Y", strtotime($article['tanggal_dipublish']))); ?>
                  </span>
                </div>
                <h3><?php echo htmlspecialchars($article['judul_artikel']); ?></h3>
                <p class="blog-excerpt">
                  <?php echo htmlspecialchars(create_excerpt($article['isi_artikel'])); ?>
                </p>
                <a href="blog_detail.php?id=<?php echo htmlspecialchars($article['id_artikel']); ?>" class="card-button"
                   aria-label="Baca artikel tentang <?php echo htmlspecialchars($article['judul_artikel']); ?>">
                  Baca Selengkapnya
                </a>
              </div>
            </article>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </section>

      <?php if ($total_pages > 1 && !empty($articles)): ?>
      <nav class="pagination" aria-label="Navigasi halaman">
          <?php if ($page > 1): ?>
              <a href="?page=<?php echo $page - 1; ?><?php echo !empty($search_term) ? '&search='.urlencode($search_term) : ''; ?>" aria-label="Halaman sebelumnya">&laquo;</a>
          <?php endif; ?>

          <?php
          $links_to_show = 2;
          $start = max(1, $page - $links_to_show);
          $end = min($total_pages, $page + $links_to_show);

          if ($start > 1) {
              echo '<a href="?page=1'.(!empty($search_term) ? '&search='.urlencode($search_term) : '').'">1</a>';
              if ($start > 2) {
                  echo '<span>...</span>';
              }
          }

          for ($i = $start; $i <= $end; $i++): ?>
              <a href="?page=<?php echo $i; ?><?php echo !empty($search_term) ? '&search='.urlencode($search_term) : ''; ?>" class="<?php echo ($i == $page) ? 'active' : ''; ?>"><?php echo $i; ?></a>
          <?php endfor;

          if ($end < $total_pages) {
              if ($end < $total_pages - 1) {
                  echo '<span>...</span>';
              }
              echo '<a href="?page='.$total_pages.(!empty($search_term) ? '&search='.urlencode($search_term) : '').'">'.$total_pages.'</a>';
          }
          ?>

          <?php if ($page < $total_pages): ?>
              <a href="?page=<?php echo $page + 1; ?><?php echo !empty($search_term) ? '&search='.urlencode($search_term) : ''; ?>" aria-label="Halaman berikutnya">&raquo;</a>
          <?php endif; ?>
      </nav>
      <?php endif; ?>
    </div>

    <aside class="sidebar" aria-labelledby="recent-posts-heading">
      <div class="recent-posts">
        <h3 id="recent-posts-heading">Artikel Terpopuler</h3>
        <?php if (empty($popular_articles)): ?>
            <p>Belum ada artikel populer.</p>
        <?php else: ?>
        <ul>
          <?php foreach ($popular_articles as $pop_article): ?>
          <li>
            <a href="blog_detail.php?id=<?php echo htmlspecialchars($pop_article['id_artikel']); ?>">
                <?php echo htmlspecialchars($pop_article['judul_artikel']); ?>
            </a>
          </li>
          <?php endforeach; ?>
        </ul>
        <?php endif; ?>
      </div>
    </aside>
  </main>

  <?php include 'Komponen/footer.php'; // Make sure this path is correct ?>
</body>
</html>