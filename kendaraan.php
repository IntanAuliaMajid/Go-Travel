<?php
include 'Komponen/navbar.php'; // Pastikan path ini benar
require_once 'backend/koneksi.php'; // Pastikan file ini menyediakan variabel $conn

// --- Logika Paginasi ---
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$items_per_page = 6; // Jumlah kendaraan per halaman
$offset = ($page - 1) * $items_per_page;

// --- Logika Pencarian ---
$search_term = isset($_GET['search']) ? trim($_GET['search']) : '';
$search_query_part = "";
$search_params_values = [];
$search_param_types = "";

if (!empty($search_term)) {
    $search_query_part = " WHERE jenis_kendaraan LIKE ?";
    $like_search_term = '%' . $search_term . '%';
    $search_params_values[] = $like_search_term;
    $search_param_types .= "s";
}

// --- Mengambil Total Kendaraan untuk Paginasi ---
$total_sql = "SELECT COUNT(id_kendaraan) FROM kendaraan" . $search_query_part;
$total_stmt = $conn->prepare($total_sql);

if (!empty($search_term)) {
    $total_stmt->bind_param($search_param_types, ...$search_params_values);
}
$total_stmt->execute();
$total_stmt->bind_result($total_vehicles_count);
$total_stmt->fetch();
$total_stmt->close();

$total_pages = ($total_vehicles_count > 0) ? ceil($total_vehicles_count / $items_per_page) : 0;

// --- Mengambil Data Kendaraan untuk Halaman Saat Ini ---
$sql = "SELECT id_kendaraan, jenis_kendaraan, gambar 
        FROM kendaraan"
       . $search_query_part .
       " ORDER BY jenis_kendaraan ASC
        LIMIT ?, ?";

$stmt = $conn->prepare($sql);

// Menggabungkan parameter pencarian dan paginasi
$current_bind_params_values = $search_params_values;
$current_bind_param_types = $search_param_types;
$current_bind_params_values[] = $offset;
$current_bind_params_values[] = $items_per_page;
$current_bind_param_types .= "ii";

$stmt->bind_param($current_bind_param_types, ...$current_bind_params_values);
$stmt->execute();
$result = $stmt->get_result();
$vehicles = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Armada Kendaraan - GoTravel</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
    /* Sebagian besar style tetap sama, namun beberapa disesuaikan untuk layout tanpa sidebar */
    body { font-family: Arial, sans-serif; margin: 0; background-color: #f9f9f9; color: #333;}
    .container { max-width: 1200px; margin: 0 auto; padding: 0 1rem; }
    .section-heading { font-size: 2rem; color: #333; margin-bottom: 1.5rem; text-align: center; }
    
    .page-hero {
      background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),
                  url('https://images.unsplash.com/photo-1517524008697-84bbe3c3fd98?fm=jpg&q=60&w=3000&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1yZWxhdGVkfDE0fHx8ZW58MHx8fHx8') no-repeat center center/cover;
      min-height: 70vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      padding: 2rem;
      color: white;
    }
    .page-hero h1 { font-size: 3rem; margin-bottom: 0.5rem;}
    .page-hero p { font-size: 1.2rem; margin-bottom: 2rem; max-width: 700px;}

    .main-search {
      max-width: 600px;
      width: 90%;
      margin-top: 2rem;
      display: flex;
      gap: 0.5rem;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .main-search input {
      flex: 1;
      padding: 0.9rem;
      border: 1px solid #ddd;
      border-radius: 8px 0 0 8px;
      font-size: 1rem;
    }
    .main-search input:focus { outline-color: #2c7a51; }


    .main-search button {
      background: #2c7a51;
      color: white;
      border: none;
      padding: 0.9rem 1.5rem;
      border-radius: 0 8px 8px 0;
      cursor: pointer;
      transition: background 0.3s ease;
      font-size: 1rem;
    }
    .main-search button:hover { background: #1f563a; }

    /* Container utama tidak perlu display: flex lagi */
    .page-container {
      padding: 3rem 0;
    }

    .main-content {
      flex: 1;
    }

    .vehicle-grid {
      display: grid;
      /* Dibuat 3 kolom di layar besar */
      grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
      gap: 2rem;
      margin-bottom: 3rem;
    }

    .vehicle-card {
      background: white;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      display: flex;
      flex-direction: column;
    }
    .vehicle-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
    }
    .vehicle-card .card-image {
        width: 100%;
        height: 200px;
    }
    .vehicle-card .card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .vehicle-content {
      padding: 1.5rem;
      flex-grow: 1;
      display: flex;
      flex-direction: column;
    }
    .vehicle-content h3 {
        font-size: 1.6rem; margin-top: 0.5rem; margin-bottom: 0.75rem; color: #333;
        line-height: 1.3;
    }
    .vehicle-description {
      color: #555;
      margin: 0 0 1rem 0;
      line-height: 1.6;
      font-size: 0.95rem;
      flex-grow: 1;
    }

    .pagination {
      display: flex; justify-content: center; gap: 0.5rem; margin-top: 3rem; padding-bottom: 2rem;
    }
    .pagination a {
      padding: 0.6rem 1.1rem; border-radius: 5px; background: #e9e9e9; color: #555;
      text-decoration: none; transition: background 0.3s ease, color 0.3s ease; font-size: 0.9rem;
    }
    .pagination a:hover,
    .pagination a.active {
      background: #2c7a51;
      color: white;
    }
    .pagination span { padding: 0.6rem 0.8rem; color: #999; }
    
    @media (max-width: 768px) {
      .page-hero h1 { font-size: 2.5rem; }
      .page-hero p { font-size: 1rem; }
      .main-search { flex-direction: column; }
      .main-search input, .main-search button { border-radius: 8px; }
      .main-search button { width: 100%; }
      .vehicle-grid { grid-template-columns: 1fr; }
    }
  </style>
</head>
<body>

  <main class="container page-container">
    <div class="main-content">
      <section aria-labelledby="vehicle-list-heading">
        <h2 id="vehicle-list-heading" class="section-heading" style="padding:1rem 0; text-align:left;">
            <?php echo !empty($search_term) ? 'Hasil Pencarian untuk "' . htmlspecialchars($search_term) . '"' : 'Pilihan Kendaraan'; ?>
        </h2>
        <div class="vehicle-grid">
          <?php if (empty($vehicles)): ?>
            <p style="grid-column: 1 / -1; text-align: center; font-size: 1.1rem;">
                <?php echo !empty($search_term) ? 'Tidak ada kendaraan yang cocok dengan pencarian Anda.' : 'Belum ada kendaraan untuk ditampilkan.'; ?>
            </p>
          <?php else: ?>
            <?php foreach ($vehicles as $vehicle): ?>
            <article class="vehicle-card">
              <div class="card-image">
                <img src="<?php echo htmlspecialchars($vehicle['gambar']); ?>"
                     alt="Gambar <?php echo htmlspecialchars($vehicle['jenis_kendaraan']); ?>"
                     loading="lazy">
              </div>
              <div class="vehicle-content">
                <h3><?php echo htmlspecialchars($vehicle['jenis_kendaraan']); ?></h3>
                <p class="vehicle-description">
                  Kendaraan ini siap menemani perjalanan Anda dengan nyaman dan aman. Cocok untuk perjalanan keluarga, grup, maupun pribadi.
                </p>
                </div>
            </article>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </section>

      <?php if ($total_pages > 1 && !empty($vehicles)): ?>
      <nav class="pagination" aria-label="Navigasi halaman">
          <?php if ($page > 1): ?>
              <a href="?page=<?php echo $page - 1; ?><?php echo !empty($search_term) ? '&search='.urlencode($search_term) : ''; ?>" aria-label="Halaman sebelumnya">&laquo;</a>
          <?php endif; ?>

          <?php for ($i = 1; $i <= $total_pages; $i++): ?>
              <a href="?page=<?php echo $i; ?><?php echo !empty($search_term) ? '&search='.urlencode($search_term) : ''; ?>" class="<?php echo ($i == $page) ? 'active' : ''; ?>"><?php echo $i; ?></a>
          <?php endfor; ?>
          
          <?php if ($page < $total_pages): ?>
              <a href="?page=<?php echo $page + 1; ?><?php echo !empty($search_term) ? '&search='.urlencode($search_term) : ''; ?>" aria-label="Halaman berikutnya">&raquo;</a>
          <?php endif; ?>
      </nav>
      <?php endif; ?>
    </div>

    </main>

  <?php include 'Komponen/footer.php'; // Pastikan path ini benar ?>
</body>
</html>