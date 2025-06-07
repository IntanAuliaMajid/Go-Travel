<?php
require_once '../backend/koneksi.php'; // Sesuaikan path jika perlu

// --- Konfigurasi Pagination ---
$articles_per_page = 5; // Jumlah artikel per halaman
$current_page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($current_page - 1) * $articles_per_page;

// --- Helper Functions ---
function format_date_indonesian($date_str) {
    if (empty($date_str)) return 'N/A';
    try {
        $date = new DateTime($date_str);
        // Array bulan dalam bahasa Indonesia
        $bulan = array (1 => 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des');
        return $date->format('d') . ' ' . $bulan[(int)$date->format('n')] . ' ' . $date->format('Y');
    } catch (Exception $e) {
        return 'Tanggal Invalid';
    }
}

function get_excerpt($text, $length = 100) {
    if (empty($text)) return '';
    $text = strip_tags($text);
    if (strlen($text) > $length) {
        $text = substr($text, 0, $length) . '...';
    }
    return $text;
}

function get_first_tag_as_destination($tags_string) {
    if (empty($tags_string)) return '-';
    $tags_array = explode(',', $tags_string);
    return trim(ucfirst($tags_array[0])); // Ambil tag pertama dan capitalize
}


// --- Fetch Filter Options ---
$kategori_options = [];
$result_kategori = $conn->query("SELECT id_jenis_artikel, jenis_artikel FROM jenis_artikel ORDER BY jenis_artikel ASC");
if ($result_kategori) {
    while ($row = $result_kategori->fetch_assoc()) {
        $kategori_options[] = $row;
    }
}

$destinasi_options = []; // Untuk filter dropdown (dari tabel wilayah)
$result_destinasi_filter = $conn->query("SELECT id_wilayah, nama_wilayah FROM wilayah ORDER BY nama_wilayah ASC");
if ($result_destinasi_filter) {
    while ($row = $result_destinasi_filter->fetch_assoc()) {
        $destinasi_options[] = $row;
    }
}

// --- Handle Filters ---
$filter_search = isset($_GET['search']) ? trim($_GET['search']) : '';
$filter_kategori = isset($_GET['kategori']) && is_numeric($_GET['kategori']) ? (int)$_GET['kategori'] : '';
$filter_destinasi = isset($_GET['destinasi']) && is_numeric($_GET['destinasi']) ? (int)$_GET['destinasi'] : ''; // Ini akan filter berdasarkan wilayah, bukan tag artikel

$where_clauses = [];
$params = [];
$types = "";

if (!empty($filter_search)) {
    $where_clauses[] = "a.judul_artikel LIKE ?";
    $params[] = "%" . $filter_search . "%";
    $types .= "s";
}
if (!empty($filter_kategori)) {
    $where_clauses[] = "a.id_jenis_artikel = ?";
    $params[] = $filter_kategori;
    $types .= "i";
}

// Perhatian: Filter destinasi berdasarkan tabel 'wilayah' tidak bisa langsung diterapkan ke tabel 'artikel'
// dengan JOIN seperti ini. Anda perlu menambahkan kolom id_wilayah ke tabel artikel atau mekanisme lain.
// Untuk saat ini, filter ini tidak akan memengaruhi hasil query artikel dari sisi database
// kecuali Anda memiliki kolom `id_wilayah` di tabel `artikel` atau relasi melalui tabel lain.
/*
if (!empty($filter_destinasi)) {
    // Jika Anda memiliki kolom id_wilayah di tabel artikel, uncomment ini:
    // $where_clauses[] = "a.id_wilayah = ?"; 
    // $params[] = $filter_destinasi;
    // $types .= "i";
    // Jika Anda ingin filter berdasarkan tag artikel yang cocok dengan nama wilayah, butuh logika lebih lanjut
}
*/


// --- Fetch Articles ---
$sql_base = "FROM artikel a
             LEFT JOIN jenis_artikel ja ON a.id_jenis_artikel = ja.id_jenis_artikel
             LEFT JOIN gambar_artikel ga ON a.id_gambar_artikel = ga.id_gambar_artikel";

$sql_where = "";
if (!empty($where_clauses)) {
    $sql_where = " WHERE " . implode(" AND ", $where_clauses);
}

// Query untuk total artikel (untuk pagination)
$sql_total_articles = "SELECT COUNT(DISTINCT a.id_artikel) as total " . $sql_base . $sql_where;
$stmt_total = $conn->prepare($sql_total_articles);
$total_articles = 0;
if ($stmt_total) {
    if (!empty($params)) {
        $stmt_total->bind_param($types, ...$params);
    }
    if ($stmt_total->execute()) {
        $result_total_articles = $stmt_total->get_result();
        $total_articles = $result_total_articles->fetch_assoc()['total'] ?? 0;
    }
    $stmt_total->close();
}
$total_pages = ceil($total_articles / $articles_per_page);


// Query untuk mengambil artikel dengan limit dan offset
$articles = [];
$sql_articles = "SELECT DISTINCT a.id_artikel, a.judul_artikel, a.isi_artikel, a.tanggal_dipublish, a.tag,
                         ja.jenis_artikel, 
                         ga.url AS gambar_url 
                 " . $sql_base . $sql_where . "
                 ORDER BY a.tanggal_dipublish DESC, a.id_artikel DESC
                 LIMIT ? OFFSET ?";

$stmt_articles = $conn->prepare($sql_articles);
if ($stmt_articles) {
    $current_params = $params; // Salin params dari filter
    $current_types = $types;   // Salin types dari filter
    
    $current_params[] = $articles_per_page;
    $current_types .= "i";
    $current_params[] = $offset;
    $current_types .= "i";

    if (!empty($current_params)) {
      if (count($current_params) > 0) {
          $stmt_articles->bind_param($current_types, ...$current_params);
      }
    }

    if ($stmt_articles->execute()) {
        $result_articles_data = $stmt_articles->get_result();
        while ($row = $result_articles_data->fetch_assoc()) {
            $articles[] = $row;
        }
    } else {
        error_log("Error executing articles statement: " . $stmt_articles->error);
    }
    $stmt_articles->close();
} else {
    error_log("Error preparing articles statement: " . $conn->error);
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin GoTravel - Manajemen Artikel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #5a7d7c; /* Soft teal */
            --primary-dark: #4c6867; /* Darker teal */
            --secondary: #36454F; /* Charcoal */
            --text-dark: #2c3e50; /* Very dark blue for strong text */
            --text-light: #6b7280; /* Gray for subtle text */
            --bg-light: #f9fafb; /* Off-white background */
            --border-color: #e5e7eb; /* Light border */
            --card-bg: #ffffff; /* White card background */
            --shadow-light: 0 1px 3px rgba(0,0,0,0.05), 0 1px 2px rgba(0,0,0,0.03);
            --shadow-medium: 0 4px 6px rgba(0,0,0,0.05), 0 2px 4px rgba(0,0,0,0.03);
            --border-radius-sm: 6px;
            --border-radius-md: 10px;
            --transition-speed: 0.2s;
        }

        /* General styles */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background-color: var(--bg-light); color: var(--text-dark); line-height: 1.6; }

        /* Utilities */
        .btn {
            padding: 10px 18px; border-radius: var(--border-radius-sm); border: none; cursor: pointer;
            font-weight: 500; transition: all var(--transition-speed) ease-in-out;
            display: inline-flex; align-items: center; justify-content: center; gap: 8px;
            text-decoration: none; font-size: 0.95rem;
        }
        .btn-primary { background-color: var(--primary); color: white; }
        .btn-primary:hover { background-color: var(--primary-dark); transform: translateY(-1px); box-shadow: var(--shadow-light); }
        .btn-outline { background-color: transparent; border: 1px solid var(--border-color); color: var(--text-light); }
        .btn-outline:hover { background-color: var(--border-color); color: var(--text-dark); }
        .btn-danger { background-color: #ef4444; color: white; } /* Tailwind red-500 */
        .btn-danger:hover { background-color: #dc2626; transform: translateY(-1px); box-shadow: var(--shadow-light); } /* Tailwind red-600 */
        .btn-sm { padding: 8px 14px; font-size: 0.85rem; }

        /* Layout */
        main { margin-left: 220px; padding: 30px; } /* Adjust margin-left if sidebar width changes */
        
        /* Header */
        .header-container {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 30px; padding-bottom: 20px; border-bottom: 1px solid var(--border-color);
        }
        .page-title { color: var(--secondary); padding-left: 15px; border-left: 4px solid var(--primary); font-size: 2rem; font-weight: 700; }

        /* Filter Section */
        .filter-section {
            background-color: var(--card-bg); border-radius: var(--border-radius-md); padding: 25px;
            margin-bottom: 30px; box-shadow: var(--shadow-medium);
        }
        .filter-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px; margin-bottom: 20px; }
        .filter-group { display: flex; flex-direction: column; }
        .filter-label { font-size: 0.85rem; margin-bottom: 8px; color: var(--text-light); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
        .filter-input {
            padding: 12px 15px; border: 1px solid var(--border-color);
            border-radius: var(--border-radius-sm); font-size: 0.9rem; transition: all var(--transition-speed) ease-in-out;
            background-color: var(--bg-light);
        }
        .filter-input:focus { border-color: var(--primary); outline: none; box-shadow: 0 0 0 3px rgba(90, 125, 124, 0.1); background-color: white; }
        .filter-actions { display: flex; gap: 12px; justify-content: flex-end; padding-top: 15px; border-top: 1px dashed var(--border-color); }
        .filter-input::placeholder { color: #a1a1aa; }
        .filter-group .fa-search {
            position: absolute; right: 15px; top: 50%; transform: translateY(-50%); color: #a1a1aa;
            pointer-events: none; /* Make icon unclickable */
        }
        .filter-group small {
            font-size: 0.75rem; color: var(--text-light); margin-top: 5px;
        }

        /* Table styles */
        .table-container {
            background-color: var(--card-bg); border-radius: var(--border-radius-md);
            overflow: hidden; box-shadow: var(--shadow-medium); overflow-x: auto;
        }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 16px 20px; text-align: left; font-size: 0.9rem; border-bottom: 1px solid var(--border-color); }
        thead { background-color: var(--secondary); }
        thead th { color: white; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
        tbody tr:last-child td { border-bottom: none; }
        tbody tr:hover { background-color: #f6f8fa; }

        /* Article specific styles */
        .article-info { display: flex; align-items: flex-start; gap: 15px; }
        .thumbnail {
            width: 80px; height: 50px; object-fit: cover; border-radius: var(--border-radius-sm);
            border: 1px solid #e0e0e0; flex-shrink: 0;
            background-color: #f0f0f0;
        }
        .thumbnail-placeholder {
            width: 80px; height: 50px; background-color: #e9ecef; border-radius: var(--border-radius-sm);
            display: flex; align-items: center; justify-content: center; color: #adb5bd;
            font-size: 0.7rem; text-align: center; line-height: 1.2; flex-shrink: 0;
        }
        .article-details h3 { font-size: 1rem; margin-bottom: 5px; color: var(--primary-dark); font-weight: 600; }
        .article-details p { font-size: 0.8rem; color: var(--text-light); display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        
        .badge { 
            padding: 5px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; 
            display: inline-block; color: white; text-transform: capitalize;
        }
        .badge-kategori-default { background-color: var(--primary); }
        /* Add more specific badge colors if needed */

        .action-buttons { display: flex; gap: 10px; flex-wrap: wrap; }

        /* Pagination */
        .pagination { display: flex; justify-content: center; gap: 8px; margin-top: 30px; }
        .pagination-btn {
            min-width: 40px; height: 40px; padding: 0 12px; display: flex; align-items: center; justify-content: center;
            border-radius: var(--border-radius-sm); border: 1px solid var(--border-color);
            background-color: var(--card-bg); cursor: pointer; transition: all var(--transition-speed) ease-in-out;
            text-decoration: none; color: var(--text-dark); font-weight: 500;
        }
        .pagination-btn:hover, .pagination-btn.active {
            background-color: var(--primary); color: white; border-color: var(--primary);
        }
        .pagination-btn.disabled {
            pointer-events: none; background-color: #f3f4f6; color: #a1a1aa; border-color: #e5e7eb; cursor: default;
        }

        /* Responsive adjustments */
        @media (max-width: 992px) { 
            main { margin-left: 0px; padding: 20px; } /* Sidebar might be collapsed or hidden */ 
            .header-container { flex-direction: column; align-items: flex-start; gap: 20px; }
            .page-title { font-size: 1.8rem; }
            .filter-grid { grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); }
            .filter-actions { justify-content: center; flex-wrap: wrap; }
            .btn { width: 100%; max-width: 250px; } /* Full width buttons on small screens */
            .table-container { border-radius: 0; } /* Remove radius for full width on very small screens */
            th, td { padding: 12px 15px; font-size: 0.85rem; }
            .thumbnail, .thumbnail-placeholder { width: 70px; height: 45px; }
            .article-details h3 { font-size: 0.95rem; }
            .article-details p { font-size: 0.75rem; }
        }
        @media (max-width: 600px) {
            main { padding: 15px; }
            .filter-grid { grid-template-columns: 1fr; }
            .btn { width: 100%; }
            th, td { padding: 10px 12px; font-size: 0.8rem; }
            .thumbnail, .thumbnail-placeholder { width: 60px; height: 40px; }
            .article-details h3 { font-size: 0.9rem; }
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <?php include '../komponen/sidebar_admin.php'; // Pastikan path ini benar ?>

    <main>
        <div class="header-container">
            <h1 class="page-title">Manajemen Artikel Travel</h1>
            <a href="tambah_blog.php" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Artikel
            </a>
        </div>

        <div class="filter-section">
            <form method="GET" action="">
                <div class="filter-grid">
                    <div class="filter-group">
                        <label for="search" class="filter-label">Cari Artikel</label>
                        <div style="position: relative;">
                            <input type="text" name="search" id="search" class="filter-input" placeholder="Judul artikel..." value="<?php echo htmlspecialchars($filter_search); ?>">
                            <i class="fas fa-search"></i>
                        </div>
                    </div>
                    
                    <div class="filter-group">
                        <label for="kategori" class="filter-label">Kategori</label>
                        <select name="kategori" id="kategori" class="filter-input">
                            <option value="">Semua Kategori</option>
                            <?php foreach($kategori_options as $kategori): ?>
                                <option value="<?php echo $kategori['id_jenis_artikel']; ?>" <?php echo ($filter_kategori == $kategori['id_jenis_artikel']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($kategori['jenis_artikel']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label for="destinasi" class="filter-label">Destinasi (Wilayah)</label>
                        <select name="destinasi" id="destinasi" class="filter-input">
                            <option value="">Semua Destinasi</option>
                            <?php foreach($destinasi_options as $destinasi): ?>
                                <option value="<?php echo $destinasi['id_wilayah']; ?>" <?php echo ($filter_destinasi == $destinasi['id_wilayah']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($destinasi['nama_wilayah']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <small>Filter ini berdasarkan wilayah umum, tidak langsung terhubung ke artikel.</small>
                    </div>
                </div>
                
                <div class="filter-actions">
                    <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="btn btn-outline">
                        <i class="fas fa-sync-alt"></i> Reset Filter
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter"></i> Terapkan Filter
                    </button>
                </div>
            </form>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th style="width: 90px;">Gambar</th>
                        <th>Judul Artikel</th>
                        <th style="width: 150px;">Kategori</th>
                        <th style="width: 150px;">Tag Utama</th>
                        <th style="width: 130px;">Penulis</th>
                        <th style="width: 120px;">Tanggal</th>
                        <th style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($articles)): ?>
                        <?php foreach($articles as $article): ?>
                        <tr>
                            <td>
                                <?php if (!empty($article['gambar_url']) && filter_var($article['gambar_url'], FILTER_VALIDATE_URL)): ?>
                                    <img src="<?php echo htmlspecialchars($article['gambar_url']); ?>" class="thumbnail" alt="Thumbnail">
                                <?php else: ?>
                                    <div class="thumbnail-placeholder">No Image</div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="article-info">
                                    <div class="article-details">
                                        <h3><?php echo htmlspecialchars($article['judul_artikel']); ?></h3>
                                        <p><?php echo htmlspecialchars(get_excerpt($article['isi_artikel'], 60)); ?></p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-kategori-default">
                                    <?php echo !empty($article['jenis_artikel']) ? htmlspecialchars($article['jenis_artikel']) : 'N/A'; ?>
                                </span>
                            </td>
                            <td><?php echo htmlspecialchars(get_first_tag_as_destination($article['tag'])); ?></td>
                            <td>Tim GoTravel</td> 
                            <td><?php echo format_date_indonesian($article['tanggal_dipublish']); ?></td>
                            <td>
                                <div class="action-buttons">
                                    <a href="edit_blog.php?id=<?php echo $article['id_artikel']; ?>" class="btn btn-outline btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="../backend/hapus_blog.php?id=<?php echo $article['id_artikel']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin ingin menghapus artikel ini?');">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 30px; color: var(--text-light);">
                                <?php echo (empty($filter_search) && empty($filter_kategori) && empty($filter_destinasi)) ? 
                                'Belum ada artikel yang tersedia.' : 'Tidak ada artikel ditemukan sesuai kriteria filter Anda.'; ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if ($total_pages > 1): ?>
        <div class="pagination">
            <a href="?page=<?php echo max(1, $current_page - 1); ?>&search=<?php echo urlencode($filter_search); ?>&kategori=<?php echo $filter_kategori; ?>&destinasi=<?php echo $filter_destinasi; ?>" 
               class="pagination-btn <?php echo ($current_page <= 1) ? 'disabled' : ''; ?>">
                <i class="fas fa-chevron-left"></i>
            </a>

            <?php 
            // Logic to show limited page numbers (e.g., first, last, current, and some around current)
            $link_limit = 2; // Number of pages to show around the current page
            $start_page = max(1, $current_page - $link_limit);
            $end_page = min($total_pages, $current_page + $link_limit);

            if ($start_page > 1) {
                echo '<a href="?page=1&search=' . urlencode($filter_search) . '&kategori=' . $filter_kategori . '&destinasi=' . $filter_destinasi . '" class="pagination-btn">1</a>';
                if ($start_page > 2) {
                    echo '<span class="pagination-btn disabled" style="cursor:default;">...</span>';
                }
            }

            for ($i = $start_page; $i <= $end_page; $i++) {
                echo '<a href="?page=' . $i . '&search=' . urlencode($filter_search) . '&kategori=' . $filter_kategori . '&destinasi=' . $filter_destinasi . '" class="pagination-btn ' . (($i == $current_page) ? 'active' : '') . '">' . $i . '</a>';
            }

            if ($end_page < $total_pages) {
                if ($end_page < $total_pages - 1) {
                    echo '<span class="pagination-btn disabled" style="cursor:default;">...</span>';
                }
                echo '<a href="?page=' . $total_pages . '&search=' . urlencode($filter_search) . '&kategori=' . $filter_kategori . '&destinasi=' . $filter_destinasi . '" class="pagination-btn">' . $total_pages . '</a>';
            }
            ?>

            <a href="?page=<?php echo min($total_pages, $current_page + 1); ?>&search=<?php echo urlencode($filter_search); ?>&kategori=<?php echo $filter_kategori; ?>&destinasi=<?php echo $filter_destinasi; ?>" 
               class="pagination-btn <?php echo ($current_page >= $total_pages) ? 'disabled' : ''; ?>">
                <i class="fas fa-chevron-right"></i>
            </a>
        </div>
        <?php endif; ?>

    </main>
    
    <script>
        // Optional: Auto-submit filter form on select/input change for a more dynamic feel
        document.addEventListener('DOMContentLoaded', function() {
            const filterForm = document.querySelector('.filter-section form');
            if (filterForm) {
                document.getElementById('kategori').addEventListener('change', function() {
                    filterForm.submit();
                });
                document.getElementById('destinasi').addEventListener('change', function() {
                    filterForm.submit();
                });
                // Optional: For search input, you might want a debounce or a separate search button click
                // document.getElementById('search').addEventListener('input', function() {
                //     // Add debounce logic here if needed to avoid too many requests
                //     // filterForm.submit();
                // });
            }
        });
    </script>
</body>
</html>