<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Admin GoTravel - Manajemen Artikel</title>
  <style>
    /* Styling Konsisten Tema Travel */
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    
    th, td {
      padding: 12px;
      text-align: left;
      border-bottom: 1px solid #e0e0e0;
    }
    
    th {
      background-color: #2c3e50;
      color: white;
    }
    
    tr:hover {
      background-color: #f5f6fa;
    }
    
    .status-published {
      color: #27ae60;
      font-weight: bold;
    }
    
    .status-draft {
      color: #f39c12;
      font-weight: bold;
    }
    
    .thumbnail {
      width: 100px;
      height: 60px;
      object-fit: cover;
      border-radius: 4px;
      border: 1px solid #ddd;
    }
    
    .badge {
      padding: 4px 8px;
      border-radius: 12px;
      font-size: 0.8em;
    }
    
    .badge-destination {
      background-color: #3498db;
      color: white;
    }
    
    .badge-tips {
      background-color: #e67e22;
      color: white;
    }
  </style>
</head>
<body>
  <?php include '../komponen/sidebar_admin.php'; ?>

  <main style="margin-left: 220px; padding: 20px; font-family: 'Arial', sans-serif;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
      <h1 style="color: #2c3e50; border-left: 4px solid #3498db; padding-left: 10px;">Manajemen Artikel Travel</h1>
      <div>
        <button style="padding: 10px 20px; background-color: #3498db; color: white; border: none; border-radius: 5px; cursor: pointer; transition: 0.3s;">
          ✈️ Tambah Artikel
        </button>
      </div>
    </div>

    <!-- Filter dan Pencarian -->
    <div style="display: flex; gap: 15px; margin-bottom: 20px; flex-wrap: wrap;">
      <input type="text" placeholder="Cari judul artikel..." style="padding: 10px; width: 300px; border: 1px solid #ddd; border-radius: 5px;">
      
      <select style="padding: 10px; border: 1px solid #ddd; border-radius: 5px; background-color: white;">
        <option>Semua Kategori</option>
        <option>Destinasi Populer</option>
        <option>Tips Travel</option>
        <option>Review Paket</option>
        <option>Promo Wisata</option>
      </select>
      
      <select style="padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
        <option>Semua Destinasi</option>
        <option>Bali</option>
        <option>Lombok</option>
        <option>Yogyakarta</option>
        <option>Raja Ampat</option>
      </select>
    </div>

    <!-- Tabel Artikel -->
    <div style="overflow-x: auto; border-radius: 8px; border: 1px solid #eee;">
      <table>
        <thead>
          <tr>
              <th>Gambar</th>
              <th>Judul Artikel</th>
              <th>Kategori</th>
              <th>Destinasi</th>
              <th>Penulis</th>
              <th>Tanggal</th>
              <th>Status</th>
              <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <!-- Contoh Data Travel -->
          <tr>
              <td><img src="bali-beach.jpg" class="thumbnail" alt="Pantai Bali"></td>
              <td>
                <div style="font-weight: 600;">10 Hidden Gem di Bali yang Wajib Dikunjungi</div>
                <div style="font-size: 0.9em; color: #666;">Wisata alam, kuliner, dan budaya Bali</div>
              </td>
              <td><span class="badge badge-destination">Destinasi</span></td>
              <td>Bali, Indonesia</td>
              <td>Admin Travel</td>
              <td>2024-03-15</td>
              <td><span class="status-published">Published</span></td>
              <td>
                  <button style="padding: 6px 12px; background-color: #3498db; color: white; border: none; border-radius: 3px; cursor: pointer; margin-right: 5px;">
                      ✏️ Edit
                  </button>
                  <button style="padding: 6px 12px; background-color: #e74c3c; color: white; border: none; border-radius: 3px; cursor: pointer;">
                      🗑️ Hapus
                  </button>
              </td>
          </tr>
          
          <tr>
              <td><img src="packing-tips.jpg" class="thumbnail" alt="Packing"></td>
              <td>
                <div style="font-weight: 600;">Packing List Wisata 7 Hari ala Backpacker</div>
                <div style="font-size: 0.9em; color: #666;">Tips menyusun barang bepergian</div>
              </td>
              <td><span class="badge badge-tips">Tips</span></td>
              <td>-</td>
              <td>Travel Expert</td>
              <td>2024-03-14</td>
              <td><span class="status-draft">Draft</span></td>
              <td>
                  <button style="padding: 6px 12px; background-color: #3498db; color: white; border: none; border-radius: 3px; cursor: pointer; margin-right: 5px;">
                      ✏️ Edit
                  </button>
                  <button style="padding: 6px 12px; background-color: #e74c3c; color: white; border: none; border-radius: 3px; cursor: pointer;">
                      🗑️ Hapus
                  </button>
              </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div style="margin-top: 25px; display: flex; justify-content: center; gap: 8px;">
      <button style="padding: 8px 15px; background-color: #3498db; color: white; border: none; border-radius: 3px; cursor: pointer;">«</button>
      <button style="padding: 8px 15px; background-color: #f8f9fa; border: 1px solid #ddd; border-radius: 3px; cursor: pointer;">1</button>
      <button style="padding: 8px 15px; background-color: #f8f9fa; border: 1px solid #ddd; border-radius: 3px; cursor: pointer;">2</button>
      <button style="padding: 8px 15px; background-color: #f8f9fa; border: 1px solid #ddd; border-radius: 3px; cursor: pointer;">3</button>
      <button style="padding: 8px 15px; background-color: #3498db; color: white; border: none; border-radius: 3px; cursor: pointer;">»</button>
    </div>
  </main>
</body>
</html>