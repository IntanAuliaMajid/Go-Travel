<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin - Paket Wisata</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
    }

    /* Existing sidebar styles will be preserved from sidebar_admin.php */

    /* Main Content */
    .main-content {
      margin-left: 220px;
      padding: 30px;
      min-height: 100vh;
      transition: margin-left 0.3s ease;
    }

    .page-header {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(10px);
      padding: 25px 30px;
      border-radius: 15px;
      box-shadow: 0 8px 32px rgba(31, 38, 135, 0.37);
      margin-bottom: 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .page-title {
      color: #333;
      font-size: 1.8rem;
      font-weight: 600;
      display: flex;
      align-items: center;
    }

    .page-title i {
      margin-right: 12px;
      color: #667eea;
    }

    .btn-primary {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      padding: 12px 24px;
      border: none;
      border-radius: 8px;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      font-weight: 500;
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }

    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
    }

    .btn-primary i {
      margin-right: 8px;
    }

    /* Card Container */
    .card {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(10px);
      border-radius: 15px;
      box-shadow: 0 8px 32px rgba(31, 38, 135, 0.37);
      overflow: hidden;
    }

    /* Table Styles */
    .table-container {
      overflow-x: auto;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: white;
    }

    thead {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    th {
      padding: 18px 15px;
      text-align: left;
      color: white;
      font-weight: 600;
      font-size: 0.9rem;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    td {
      padding: 16px 15px;
      border-bottom: 1px solid #f0f0f0;
      color: #333;
    }

    tbody tr {
      transition: all 0.3s ease;
    }

    tbody tr:hover {
      background: rgba(102, 126, 234, 0.05);
      transform: scale(1.01);
    }

    /* Action Buttons */
    .action-buttons {
      display: flex;
      gap: 8px;
    }

    .btn {
      padding: 8px 12px;
      border: none;
      border-radius: 6px;
      font-size: 0.8rem;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.3s ease;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 4px;
    }

    .btn-edit {
      background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
      color: white;
    }

    .btn-delete {
      background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
      color: white;
    }

    .btn:hover {
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    /* Price styling */
    .price {
      font-weight: 600;
      color: #27ae60;
      font-size: 1rem;
    }

    /* Duration badge */
    .duration {
      background: rgba(102, 126, 234, 0.1);
      color: #667eea;
      padding: 4px 12px;
      border-radius: 20px;
      font-size: 0.85rem;
      font-weight: 500;
    }

    /* Status indicators */
    .row-number {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      width: 30px;
      height: 30px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 600;
      font-size: 0.9rem;
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
      .main-content {
        margin-left: 0;
        padding: 15px;
      }

      .page-header {
        flex-direction: column;
        gap: 15px;
        text-align: center;
      }

      .page-title {
        font-size: 1.5rem;
      }

      table {
        font-size: 0.85rem;
      }

      th, td {
        padding: 12px 8px;
      }

      .action-buttons {
        flex-direction: column;
      }
    }

    /* Animation for table rows */
    tbody tr {
      opacity: 0;
      animation: fadeInUp 0.5s ease forwards;
    }

    tbody tr:nth-child(1) { animation-delay: 0.1s; }
    tbody tr:nth-child(2) { animation-delay: 0.2s; }
    tbody tr:nth-child(3) { animation-delay: 0.3s; }

    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>
</head>
<body>
  <?php include '../komponen/sidebar_admin.php'; ?>

  <!-- Main Content -->
  <main class="main-content">
    <div class="page-header">
      <h1 class="page-title">
        <i class="fas fa-map-marked-alt"></i>
        Kelola Paket Wisata
      </h1>
      <a href="tambah_paket.php" class="btn-primary">
        <i class="fas fa-plus"></i>
        Tambah Paket Wisata
      </a>
    </div>

    <div class="card">
      <div class="table-container">
        <table>
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Paket</th>
              <th>Destinasi</th>
              <th>Harga</th>
              <th>Durasi</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            // Contoh data dummy, ganti dengan data dari database
            $paket = [
              ["nama" => "Paket Bali Eksotis", "destinasi" => "Bali", "harga" => "2.500.000", "durasi" => "3 Hari 2 Malam"],
              ["nama" => "Paket Lombok Adventure", "destinasi" => "Lombok", "harga" => "3.000.000", "durasi" => "4 Hari 3 Malam"],
              ["nama" => "Paket Yogyakarta Heritage", "destinasi" => "Yogyakarta", "harga" => "1.800.000", "durasi" => "2 Hari 1 Malam"]
            ];
            $no = 1;
            foreach ($paket as $p) {
              echo "<tr>
                <td>
                  <div class='row-number'>{$no}</div>
                </td>
                <td>
                  <strong>{$p['nama']}</strong>
                  <br>
                  <small style='color: #666;'>Liburan lengkap dan berkesan</small>
                </td>
                <td>
                  <i class='fas fa-map-marker-alt' style='color: #e74c3c; margin-right: 5px;'></i>
                  {$p['destinasi']}
                </td>
                <td>
                  <span class='price'>Rp {$p['harga']}</span>
                </td>
                <td>
                  <span class='duration'>{$p['durasi']}</span>
                </td>
                <td>
                  <div class='action-buttons'>
                    <a href='edit_paket.php?id={$no}' class='btn btn-edit'>
                      <i class='fas fa-edit'></i> Edit
                    </a>
                    <a href='hapus_paket.php?id={$no}' class='btn btn-delete' onclick='return confirm(\"Yakin ingin menghapus paket ini?\")'>
                      <i class='fas fa-trash'></i> Hapus
                    </a>
                  </div>
                </td>
              </tr>";
              $no++;
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </main>

  <script>
    // Simple script for any additional functionality if needed
  </script>
</body>
</html>