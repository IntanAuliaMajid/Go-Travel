<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Kendaraan - Manajemen Kendaraan</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
      color: #333;
    }

    main {
      margin-left: 220px;
      padding: 30px;
    }

    .form-container {
      background: white;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
      max-width: 100%;
      margin: 0 auto;
    }

    .form-container h1 {
      font-size: 2rem;
      color: #2c3e50;
      margin-bottom: 25px;
      text-align: center;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      margin-bottom: 8px;
      font-weight: 500;
      color: #2c3e50;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
      width: 100%;
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 8px;
    }

    .form-group textarea {
      resize: vertical;
      min-height: 100px;
    }

    .form-actions {
      display: flex;
      justify-content: flex-end;
      gap: 15px;
    }

    .btn {
      padding: 12px 20px;
      border: none;
      border-radius: 8px;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.3s;
    }

    .btn-primary {
      background: #3498db;
      color: white;
    }

    .btn-primary:hover {
      background: #2980b9;
    }

    .btn-secondary {
      background: #bdc3c7;
      color: white;
    }

    .btn-secondary:hover {
      background: #95a5a6;
    }

    @media (max-width: 768px) {
      main {
        margin-left: 0;
        padding: 20px;
      }

      .form-container {
        padding: 20px;
      }
    }
  </style>
</head>
<body>

  <!-- Sidebar tetap -->
  <?php include '../komponen/sidebar_admin.php'; ?>

  <main>
    <div class="form-container">
      <h1><i class="fas fa-plus-circle" style="color:#3498db; margin-right:10px;"></i>Tambah Kendaraan</h1>
      <form action="proses_tambah_kendaraan.php" method="POST">
        <div class="form-group">
          <label for="nama">Nama Kendaraan</label>
          <input type="text" id="nama" name="nama" required>
        </div>

        <div class="form-group">
          <label for="jenis">Jenis Kendaraan</label>
          <select id="jenis" name="jenis" required>
            <option value="">-- Pilih Jenis --</option>
            <option value="SUV">SUV</option>
            <option value="Sedan">Sedan</option>
            <option value="Minibus">Minibus</option>
            <option value="Bus Mini">Bus Mini</option>
          </select>
        </div>

        <div class="form-group">
          <label for="kapasitas">Kapasitas</label>
          <input type="text" id="kapasitas" name="kapasitas" placeholder="Contoh: 7 Orang" required>
        </div>

        <div class="form-group">
          <label for="harga">Harga Sewa per Hari</label>
          <input type="number" id="harga" name="harga" placeholder="Contoh: 1200000" required>
        </div>

        <div class="form-group">
          <label for="deskripsi">Deskripsi</label>
          <textarea id="deskripsi" name="deskripsi"></textarea>
        </div>

        <div class="form-actions">
          <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
          <a href="dashboard_kendaraan.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Batal</a>
        </div>
      </form>
    </div>
  </main>
</body>
</html>
