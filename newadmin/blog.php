<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin GoTravel - Manajemen Artikel</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    /* === VARIABEL & RESET === */
    :root {
      --primary: #3498db;
      --primary-dark: #2980b9;
      --secondary: #2c3e50;
      --success: #27ae60;
      --warning: #f39c12;
      --danger: #e74c3c;
      --light: #f8f9fa;
      --gray: #e0e0e0;
      --dark-gray: #666;
      --border-radius: 8px;
      --shadow: 0 4px 12px rgba(0,0,0,0.08);
      --transition: all 0.3s ease;
    }
    
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    body {
      background-color: #f5f7fa;
      color: #333;
    }
    
    /* === UTILITAS === */
    .badge {
      padding: 4px 10px;
      border-radius: 20px;
      font-size: 0.8rem;
      font-weight: 500;
      display: inline-block;
    }
    
    .badge-destination {
      background-color: #3498db;
      color: white;
    }
    
    .badge-tips {
      background-color: #e67e22;
      color: white;
    }
    
    .badge-promo {
      background-color: #9b59b6;
      color: white;
    }
    
    .badge-review {
      background-color: #1abc9c;
      color: white;
    }
    
    .status-published {
      color: #27ae60;
      font-weight: 600;
    }
    
    .status-draft {
      color: #f39c12;
      font-weight: 600;
    }
    
    .btn {
      padding: 10px 18px;
      border-radius: var(--border-radius);
      border: none;
      cursor: pointer;
      font-weight: 500;
      transition: var(--transition);
      display: inline-flex;
      align-items: center;
      gap: 8px;
    }
    
    .btn-primary {
      background-color: var(--primary);
      color: white;
    }
    
    .btn-primary:hover {
      background-color: var(--primary-dark);
      transform: translateY(-2px);
      box-shadow: var(--shadow);
    }
    
    .btn-outline {
      background-color: transparent;
      border: 1px solid var(--gray);
      color: var(--secondary);
    }
    
    .btn-outline:hover {
      background-color: var(--light);
    }
    
    .btn-danger {
      background-color: var(--danger);
      color: white;
    }
    
    .btn-danger:hover {
      background-color: #c0392b;
      transform: translateY(-2px);
      box-shadow: var(--shadow);
    }
    
    .btn-sm {
      padding: 6px 12px;
      font-size: 0.85rem;
    }
    
    /* === LAYOUT UTAMA === */
    main {
      margin-left: 220px;
      padding: 30px;
    }
    
    .header-container {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
      padding-bottom: 15px;
      border-bottom: 1px solid var(--gray);
    }
    
    .page-title {
      color: var(--secondary);
      padding-left: 15px;
      border-left: 4px solid var(--primary);
      font-size: 1.8rem;
    }
    
    /* === FILTER SECTION === */
    .filter-section {
      background-color: white;
      border-radius: var(--border-radius);
      padding: 20px;
      margin-bottom: 25px;
      box-shadow: var(--shadow);
    }
    
    .filter-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
      gap: 15px;
      margin-bottom: 15px;
    }
    
    .filter-group {
      display: flex;
      flex-direction: column;
    }
    
    .filter-label {
      font-size: 0.85rem;
      margin-bottom: 6px;
      color: var(--dark-gray);
      font-weight: 500;
    }
    
    .filter-input {
      padding: 12px 15px;
      border: 1px solid var(--gray);
      border-radius: var(--border-radius);
      font-size: 0.95rem;
      transition: var(--transition);
    }
    
    .filter-input:focus {
      border-color: var(--primary);
      outline: none;
      box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
    }
    
    .filter-actions {
      display: flex;
      gap: 12px;
      justify-content: flex-end;
    }
    
    /* === TABEL ARTIKEL === */
    .table-container {
      background-color: white;
      border-radius: var(--border-radius);
      overflow: hidden;
      box-shadow: var(--shadow);
      overflow-x: auto;
    }
    
    table {
      width: 100%;
      border-collapse: collapse;
    }
    
    th, td {
      padding: 16px 20px;
      text-align: left;
    }
    
    thead {
      background-color: var(--secondary);
    }
    
    thead th {
      color: white;
      font-weight: 500;
      font-size: 0.95rem;
    }
    
    tbody tr {
      border-bottom: 1px solid var(--gray);
      transition: var(--transition);
    }
    
    tbody tr:last-child {
      border-bottom: none;
    }
    
    tbody tr:hover {
      background-color: #f9fbfd;
    }
    
    .article-info {
      display: flex;
      align-items: center;
      gap: 15px;
    }
    
    .thumbnail {
      width: 80px;
      height: 50px;
      object-fit: cover;
      border-radius: 4px;
      border: 1px solid #eee;
    }
    
    .article-details h3 {
      font-size: 1.05rem;
      margin-bottom: 5px;
    }
    
    .article-details p {
      font-size: 0.9rem;
      color: var(--dark-gray);
    }
    
    .action-buttons {
      display: flex;
      gap: 8px;
    }
    
    /* === PAGINATION === */
    .pagination {
      display: flex;
      justify-content: center;
      gap: 8px;
      margin-top: 30px;
    }
    
    .pagination-btn {
      width: 38px;
      height: 38px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 50%;
      border: 1px solid var(--gray);
      background-color: white;
      cursor: pointer;
      transition: var(--transition);
    }
    
    .pagination-btn:hover, 
    .pagination-btn.active {
      background-color: var(--primary);
      color: white;
      border-color: var(--primary);
    }
    
    /* === RESPONSIVENESS === */
    @media (max-width: 992px) {
      main {
        margin-left: 80px;
        padding: 20px;
      }
      
      .filter-grid {
        grid-template-columns: 1fr;
      }
    }
    
    @media (max-width: 576px) {
      main {
        margin-left: 0;
        padding: 15px;
      }
      
      .header-container {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
      }
      
      .action-buttons {
        flex-wrap: wrap;
      }
    }
  </style>
</head>
<body>
  <!-- Sidebar akan dimuat dari file eksternal -->
  <?php include '../komponen/sidebar_admin.php'; ?>

  <main>
    <!-- Header dengan Judul dan Tombol Tambah Artikel -->
    <div class="header-container">
      <h1 class="page-title">Manajemen Artikel Travel</h1>
      <a href="tambah_blog.php" class="btn btn-primary" style="text-decoration:none;">
        <i class="fas fa-plus"></i> Tambah Artikel
  </a>
    </div>

    <!-- Filter dan Pencarian -->
    <div class="filter-section">
      <div class="filter-grid">
        <div class="filter-group">
          <label class="filter-label">Cari Artikel</label>
          <div style="position: relative;">
            <input type="text" class="filter-input" placeholder="Masukkan judul artikel...">
            <i class="fas fa-search" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); color: #aaa;"></i>
          </div>
        </div>
        
        <div class="filter-group">
          <label class="filter-label">Kategori</label>
          <select class="filter-input">
            <option>Semua Kategori</option>
            <option>Destinasi Populer</option>
            <option>Tips Travel</option>
            <option>Review Paket</option>
          </select>
        </div>
        
        <div class="filter-group">
          <label class="filter-label">Destinasi</label>
          <select class="filter-input">
            <option>Semua Destinasi</option>
            <option>Lamongan</option>
            <option>Pamekasan</option>
            <option>Bangkalan</option>
            <option>Jakarta</option>
          </select>
        </div>
        
        <div class="filter-group">
          <label class="filter-label">Status</label>
          <select class="filter-input">
            <option>Semua Status</option>
            <option>Published</option>
            <option>Draft</option>
          </select>
        </div>
      </div>
      
      <div class="filter-actions">
        <button class="btn btn-outline">
          <i class="fas fa-sync-alt"></i> Reset Filter
        </button>
        <button class="btn btn-primary">
          <i class="fas fa-filter"></i> Terapkan Filter
        </button>
      </div>
    </div>

    <!-- Tabel Artikel -->
    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th style="width: 120px;">Gambar</th>
            <th>Judul Artikel</th>
            <th style="width: 140px;">Kategori</th>
            <th style="width: 150px;">Destinasi</th>
            <th style="width: 140px;">Penulis</th>
            <th style="width: 120px;">Tanggal</th>
            <th style="width: 120px;">Status</th>
            <th style="width: 180px;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <!-- Artikel 1 -->
          <tr>
            <td>
              <img src="https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=200&q=80" class="thumbnail" alt="Pantai Bali">
            </td>
            <td>
              <div class="article-info">
                <div class="article-details">
                  <h3>10 Hidden Gem di Bali yang Wajib Dikunjungi</h3>
                  <p>Wisata alam, kuliner, dan budaya Bali</p>
                </div>
              </div>
            </td>
            <td><span class="badge badge-destination">Destinasi</span></td>
            <td>Bali, Indonesia</td>
            <td>Admin Travel</td>
            <td>2024-03-15</td>
            <td><span class="status-published">Published</span></td>
            <td>
              <div class="action-buttons">
                <button class="btn btn-outline btn-sm">
                  <i class="fas fa-edit"></i> Edit
                </button>
                <button class="btn btn-danger btn-sm">
                  <i class="fas fa-trash"></i>
                </button>
              </div>
            </td>
          </tr>
          
          <!-- Artikel 2 -->
          <tr>
            <td>
              <img src="https://images.unsplash.com/photo-1552733407-5d5c46c3bb3b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=200&q=80" class="thumbnail" alt="Packing">
            </td>
            <td>
              <div class="article-info">
                <div class="article-details">
                  <h3>Packing List Wisata 7 Hari ala Backpacker</h3>
                  <p>Tips menyusun barang bepergian</p>
                </div>
              </div>
            </td>
            <td><span class="badge badge-tips">Tips</span></td>
            <td>-</td>
            <td>Travel Expert</td>
            <td>2024-03-14</td>
            <td><span class="status-draft">Draft</span></td>
            <td>
              <div class="action-buttons">
                <button class="btn btn-outline btn-sm">
                  <i class="fas fa-edit"></i> Edit
                </button>
                <button class="btn btn-danger btn-sm">
                  <i class="fas fa-trash"></i>
                </button>
              </div>
            </td>
          </tr>
          
          <!-- Artikel 3 -->
          <tr>
            <td>
              <img src="https://images.unsplash.com/photo-1503220317375-aaad61436b1b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=200&q=80" class="thumbnail" alt="Yogyakarta">
            </td>
            <td>
              <div class="article-info">
                <div class="article-details">
                  <h3>Jelajah Yogyakarta: 5 Tempat Instagramable</h3>
                  <p>Spot foto terbaik di Jogja</p>
                </div>
              </div>
            </td>
            <td><span class="badge badge-destination">Destinasi</span></td>
            <td>Yogyakarta</td>
            <td>Travel Blogger</td>
            <td>2024-03-12</td>
            <td><span class="status-published">Published</span></td>
            <td>
              <div class="action-buttons">
                <button class="btn btn-outline btn-sm">
                  <i class="fas fa-edit"></i> Edit
                </button>
                <button class="btn btn-danger btn-sm">
                  <i class="fas fa-trash"></i>
                </button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div class="pagination">
      <button class="pagination-btn">
        <i class="fas fa-chevron-left"></i>
      </button>
      <button class="pagination-btn active">1</button>
      <button class="pagination-btn">2</button>
      <button class="pagination-btn">3</button>
      <button class="pagination-btn">
        <i class="fas fa-chevron-right"></i>
      </button>
    </div>
  </main>
  
  <script>
    // Menambahkan efek interaktif sederhana
    document.addEventListener('DOMContentLoaded', function() {
      // Efek hover pada baris tabel
      const rows = document.querySelectorAll('tbody tr');
      rows.forEach(row => {
        row.addEventListener('mouseenter', () => {
          row.style.transform = 'translateY(-2px)';
          row.style.boxShadow = '0 6px 12px rgba(0,0,0,0.05)';
        });
        
        row.addEventListener('mouseleave', () => {
          row.style.transform = '';
          row.style.boxShadow = '';
        });
      });
      
      // Efek tombol
      const buttons = document.querySelectorAll('.btn');
      buttons.forEach(btn => {
        btn.addEventListener('mouseenter', () => {
          btn.style.transform = 'translateY(-2px)';
        });
        
        btn.addEventListener('mouseleave', () => {
          btn.style.transform = '';
        });
      });
    });
  </script>
</body>
</html>