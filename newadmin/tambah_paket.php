<?php
session_start();

// Inisialisasi array jika belum ada
if (!isset($_SESSION['paket_wisata'])) {
  $_SESSION['paket_wisata'] = [];
}

// Daftar pilihan dropdown
$daftar_destinasi = ["Bali", "Lombok", "Raja Ampat", "Yogyakarta", "Labuan Bajo"];
$daftar_penginapan = ["Hotel Bintang 3", "Hotel Bintang 4", "Villa", "Homestay"];
$daftar_jenis_paket = ["Budget", "Standar", "Premium", "Keluarga"];
$daftar_kendaraan = ["Toyota Avanza", "Toyota Alphard", "Innova Reborn", "HiAce", "Fortuner", "Tanpa Kendaraan"];
$daftar_tour_guide = [
  "Tanpa Tour Guide",
  "Ahmad Santoso - Local Expert",
  "Sari Dewi - Nature Specialist", 
  "Budi Hartono - Cultural Guide",
  "Maya Putri - Adventure Guide",
  "Eko Prasetyo - Photography Guide"
];

$berhasil = false;
$error_message = "";

// Proses penyimpanan data dari form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $gambar = null;

  // Proses upload gambar
  if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == UPLOAD_ERR_OK) {
    $upload_dir = 'uploads/';
    $nama_file = basename($_FILES['gambar']['name']);
    $file_extension = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
    
    // Validasi ekstensi file
    if (in_array($file_extension, $allowed_extensions)) {
      $target_file = $upload_dir . time() . "_" . $nama_file;

      // Pastikan folder uploads/ sudah ada
      if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
      }

      if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
        $gambar = $target_file;
      } else {
        $error_message = "Gagal mengupload gambar.";
      }
    } else {
      $error_message = "Format gambar tidak valid. Gunakan JPG, JPEG, PNG, atau GIF.";
    }
  }

  if (empty($error_message)) {
    $paket = [
      'nama' => $_POST['nama'],
      'jenis_paket' => $_POST['jenis_paket'],
      'destinasi' => $_POST['destinasi'],
      'penginapan' => $_POST['penginapan'],
      'kendaraan' => $_POST['kendaraan'],
      'tour_guide' => $_POST['tour_guide'],
      'harga_tiket' => (int)$_POST['harga_tiket'],
      'durasi' => $_POST['durasi'],
      'deskripsi' => $_POST['deskripsi'],
      'gambar' => $gambar
    ];

    $_SESSION['paket_wisata'][] = $paket;
    $berhasil = true;
  }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Paket Wisata</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #06b6d4 0%, #10b981 100%);
      min-height: 100vh;
    }

    .container {
      margin-left: 220px;
      padding: 30px;
      min-height: 100vh;
    }

    .card {
      background: white;
      border-radius: 20px;
      box-shadow: 0 20px 40px rgba(0,0,0,0.1);
      padding: 40px;
      max-width: 900px;
      margin: 0 auto;
    }

    .header {
      text-align: center;
      margin-bottom: 40px;
    }

    .header h1 {
      color: #1e293b;
      font-size: 2.5rem;
      margin-bottom: 10px;
      font-weight: 700;
    }

    .header p {
      color: #64748b;
      font-size: 1.1rem;
    }

    .form-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 25px;
      margin-bottom: 25px;
    }

    .form-group {
      display: flex;
      flex-direction: column;
    }

    .form-group.full-width {
      grid-column: span 2;
    }

    .form-group label {
      font-weight: 600;
      color: #1e293b;
      margin-bottom: 8px;
      font-size: 0.95rem;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
      padding: 15px;
      border: 2px solid #e2e8f0;
      border-radius: 12px;
      font-size: 1rem;
      transition: all 0.3s ease;
      background: #f8fafc;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
      outline: none;
      border-color: #06b6d4;
      background: white;
      box-shadow: 0 0 0 3px rgba(6, 182, 212, 0.1);
    }

    .form-group textarea {
      resize: vertical;
      min-height: 120px;
    }

    .price-input {
      position: relative;
    }

    .price-input::before {
      content: 'Rp';
      position: absolute;
      left: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: #64748b;
      font-weight: 600;
    }

    .price-input input {
      padding-left: 40px;
    }

    .file-input-wrapper {
      position: relative;
      display: inline-block;
      width: 100%;
    }

    .file-input {
      position: relative;
      overflow: hidden;
      background: linear-gradient(45deg, #06b6d4, #10b981);
      color: white;
      border: none;
      padding: 15px 20px;
      border-radius: 12px;
      cursor: pointer;
      text-align: center;
      transition: all 0.3s ease;
    }

    .file-input:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(6, 182, 212, 0.3);
    }

    .file-input input[type=file] {
      position: absolute;
      left: -9999px;
    }

    .btn-submit {
      background: linear-gradient(45deg, #06b6d4, #10b981);
      color: white;
      border: none;
      padding: 18px 40px;
      border-radius: 12px;
      font-size: 1.1rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      margin-top: 30px;
      width: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
    }

    .btn-submit:hover {
      transform: translateY(-3px);
      box-shadow: 0 15px 30px rgba(6, 182, 212, 0.4);
    }

    .alert {
      padding: 20px;
      border-radius: 12px;
      margin-bottom: 30px;
      display: flex;
      align-items: center;
      gap: 12px;
      font-weight: 500;
    }

    .alert.success {
      background: linear-gradient(45deg, #10b981, #059669);
      color: white;
    }

    .alert.error {
      background: linear-gradient(45deg, #ef4444, #dc2626);
      color: white;
    }

    .icon {
      font-size: 1.2rem;
    }

    .info-text {
      font-size: 0.85rem;
      color: #64748b;
      margin-top: 5px;
      font-style: italic;
    }

    .form-section {
      background: #f8fafc;
      padding: 25px;
      border-radius: 12px;
      margin-bottom: 25px;
      border-left: 4px solid #06b6d4;
    }

    .section-title {
      font-size: 1.2rem;
      font-weight: 600;
      color: #1e293b;
      margin-bottom: 20px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      .container {
        margin-left: 0;
        padding: 20px;
      }

      .form-grid {
        grid-template-columns: 1fr;
      }

      .form-group.full-width {
        grid-column: span 1;
      }

      .header h1 {
        font-size: 2rem;
      }

      .card {
        padding: 25px;
      }
    }

    /* Loading Animation */
    .loading {
      display: none;
      width: 20px;
      height: 20px;
      border: 2px solid transparent;
      border-top: 2px solid white;
      border-radius: 50%;
      animation: spin 1s linear infinite;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    .btn-submit:disabled {
      opacity: 0.7;
      cursor: not-allowed;
    }
  </style>
</head>
<body>
  <?php include '../komponen/sidebar_admin.php'; ?>

  <div class="container">
    <div class="card">
      <div class="header">
        <h1><i class="fas fa-plus-circle"></i> Tambah Paket Wisata</h1>
        <p>Buat paket wisata baru untuk pelanggan Anda</p>
      </div>

      <?php if ($berhasil) : ?>
        <div class="alert success">
          <i class="fas fa-check-circle icon"></i>
          Paket wisata berhasil ditambahkan!
        </div>
      <?php endif; ?>

      <?php if (!empty($error_message)) : ?>
        <div class="alert error">
          <i class="fas fa-exclamation-triangle icon"></i>
          <?= htmlspecialchars($error_message) ?>
        </div>
      <?php endif; ?>

      <form method="POST" enctype="multipart/form-data" id="paketForm">
        <!-- Informasi Dasar Paket -->
        <div class="form-section">
          <div class="section-title">
            <i class="fas fa-info-circle"></i>
            Informasi Dasar Paket
          </div>
          
          <div class="form-grid">
            <div class="form-group">
              <label for="nama">
                <i class="fas fa-tag"></i>
                Nama Paket
              </label>
              <input type="text" name="nama" id="nama" placeholder="Masukkan nama paket wisata" required>
            </div>

            <div class="form-group">
              <label for="jenis_paket">
                <i class="fas fa-star"></i>
                Jenis Paket
              </label>
              <select name="jenis_paket" id="jenis_paket" required>
                <option value="">-- Pilih Jenis Paket --</option>
                <?php foreach ($daftar_jenis_paket as $jenis) : ?>
                  <option value="<?= htmlspecialchars($jenis) ?>"><?= htmlspecialchars($jenis) ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="form-group">
              <label for="destinasi">
                <i class="fas fa-map-marker-alt"></i>
                Destinasi
              </label>
              <select name="destinasi" id="destinasi" required>
                <option value="">-- Pilih Destinasi --</option>
                <?php foreach ($daftar_destinasi as $d) : ?>
                  <option value="<?= htmlspecialchars($d) ?>"><?= htmlspecialchars($d) ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="form-group">
              <label for="durasi">
                <i class="fas fa-clock"></i>
                Durasi
              </label>
              <input type="text" name="durasi" id="durasi" placeholder="Contoh: 3 Hari 2 Malam" required>
            </div>

            <div class="form-group">
              <label for="harga_tiket">
                <i class="fas fa-ticket-alt"></i>
                Harga Tiket Masuk
              </label>
              <div class="price-input">
                <input type="number" name="harga_tiket" id="harga_tiket" placeholder="0" min="0" required>
              </div>
              <div class="info-text">Harga tiket masuk destinasi wisata</div>
            </div>
          </div>
        </div>

        <!-- Fasilitas Paket -->
        <div class="form-section">
          <div class="section-title">
            <i class="fas fa-concierge-bell"></i>
            Fasilitas Paket
          </div>
          
          <div class="form-grid">
            <div class="form-group">
              <label for="penginapan">
                <i class="fas fa-bed"></i>
                Paket Penginapan
              </label>
              <select name="penginapan" id="penginapan" required>
                <option value="">-- Pilih Penginapan --</option>
                <?php foreach ($daftar_penginapan as $p) : ?>
                  <option value="<?= htmlspecialchars($p) ?>"><?= htmlspecialchars($p) ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="form-group">
              <label for="kendaraan">
                <i class="fas fa-car"></i>
                Jenis Kendaraan
              </label>
              <select name="kendaraan" id="kendaraan" required>
                <option value="">-- Pilih Kendaraan --</option>
                <?php foreach ($daftar_kendaraan as $k) : ?>
                  <option value="<?= htmlspecialchars($k) ?>"><?= htmlspecialchars($k) ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="form-group">
              <label for="tour_guide">
                <i class="fas fa-user-tie"></i>
                Tour Guide
              </label>
              <select name="tour_guide" id="tour_guide" required>
                <option value="">-- Pilih Tour Guide --</option>
                <?php foreach ($daftar_tour_guide as $guide) : ?>
                  <option value="<?= htmlspecialchars($guide) ?>"><?= htmlspecialchars($guide) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
        </div>

        <!-- Detail Paket -->
        <div class="form-section">
          <div class="section-title">
            <i class="fas fa-clipboard-list"></i>
            Detail Paket
          </div>
          
          <div class="form-grid">
            <div class="form-group full-width">
              <label for="deskripsi">
                <i class="fas fa-align-left"></i>
                Deskripsi Paket
              </label>
              <textarea name="deskripsi" id="deskripsi" placeholder="Deskripsikan paket wisata Anda secara detail..." required></textarea>
            </div>

            <div class="form-group full-width">
              <label>
                <i class="fas fa-image"></i>
                Gambar Paket
              </label>
              <div class="file-input-wrapper">
                <label for="gambar" class="file-input">
                  <i class="fas fa-upload"></i>
                  <span>Pilih Gambar (JPG, PNG, GIF)</span>
                  <input type="file" name="gambar" id="gambar" accept="image/*" required>
                </label>
              </div>
              <div class="info-text">Ukuran maksimal 5MB, format JPG/PNG/GIF</div>
            </div>
          </div>
        </div>

        <button type="submit" class="btn-submit" id="submitBtn">
          <i class="fas fa-save"></i>
          <span class="btn-text">Simpan Paket Wisata</span>
          <div class="loading"></div>
        </button>
      </form>
    </div>
  </div>

  <script>
    // Form submission with loading animation
    document.getElementById('paketForm').addEventListener('submit', function() {
      const submitBtn = document.getElementById('submitBtn');
      const btnText = submitBtn.querySelector('.btn-text');
      const loading = submitBtn.querySelector('.loading');
      
      submitBtn.disabled = true;
      btnText.style.display = 'none';
      loading.style.display = 'inline-block';
    });

    // File input preview
    document.getElementById('gambar').addEventListener('change', function(e) {
      const file = e.target.files[0];
      const label = document.querySelector('.file-input span');
      
      if (file) {
        label.textContent = file.name;
      } else {
        label.textContent = 'Pilih Gambar (JPG, PNG, GIF)';
      }
    });

    // Auto-format currency inputs
    const priceInputs = document.querySelectorAll('input[type="number"]');
    priceInputs.forEach(input => {
      input.addEventListener('input', function() {
        // Remove non-numeric characters except decimal point
        let value = this.value.replace(/[^\d]/g, '');
        this.value = value;
      });
    });
  </script>
</body>
</html>