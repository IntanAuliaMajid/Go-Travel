<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Admin - Tambah Penginapan</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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
      color: #333;
    }

    main {
      margin-left: 220px;
      padding: 30px;
      min-height: 100vh;
      transition: margin-left 0.3s ease;
    }

    /* Dashboard Header */
    .dashboard-header {
      background: white;
      padding: 25px 30px;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
      margin-bottom: 30px;
      border-left: 5px solid #9b59b6;
      position: relative;
      overflow: hidden;
    }

    .dashboard-header::before {
      content: '';
      position: absolute;
      top: 0;
      right: 0;
      width: 100px;
      height: 100px;
      background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="%239b59b6" stroke-width="1" opacity="0.1"><path d="M20 9V7a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v2M4 9v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9M4 9h16M8 5v4m8-4v4m-4-4v4"></path></svg>') no-repeat center;
      background-size: contain;
    }

    .dashboard-header h1 {
      font-size: 2.2rem;
      color: #2c3e50;
      margin-bottom: 10px;
      font-weight: 600;
    }

    .dashboard-header p {
      color: #7f8c8d;
      font-size: 1.1rem;
    }

    /* Form Container */
    .form-container {
      background: white;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
      margin-bottom: 30px;
    }

    .form-container h2 {
      color: #2c3e50;
      margin-bottom: 25px;
      font-size: 1.8rem;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      margin-bottom: 8px;
      color: #2c3e50;
      font-weight: 500;
    }

    .form-group input, 
    .form-group select, 
    .form-group textarea {
      width: 100%;
      padding: 12px;
      border: 1px solid #ddd;
      border-radius: 8px;
      font-family: inherit;
    }

    .form-group textarea {
      min-height: 100px;
      resize: vertical;
    }

    .form-actions {
      display: flex;
      justify-content: flex-end;
      gap: 15px;
      padding-top: 20px;
      border-top: 1px solid #eee;
      margin-top: 30px;
    }

    .btn {
      padding: 12px 20px;
      border-radius: 8px;
      border: none;
      cursor: pointer;
      font-weight: 500;
      transition: all 0.3s;
    }

    .btn-primary {
      background: #9b59b6;
      color: white;
    }

    .btn-primary:hover {
      background: #8e44ad;
    }

    .btn-secondary {
      background: #ecf0f1;
      color: #7f8c8d;
    }

    .btn-secondary:hover {
      background: #d5dbdb;
    }

    /* Image Preview */
    .image-preview {
      display: flex;
      gap: 10px;
      margin-top: 10px;
      flex-wrap: wrap;
    }

    .preview-item {
      position: relative;
      width: 80px;
      height: 80px;
      border-radius: 8px;
      overflow: hidden;
      border: 1px solid #ddd;
    }

    .preview-item img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .remove-img {
      position: absolute;
      top: 5px;
      right: 5px;
      background: rgba(0,0,0,0.5);
      color: white;
      width: 20px;
      height: 20px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      font-size: 12px;
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
      main {
        margin-left: 0;
        padding: 20px;
      }

      .dashboard-header h1 {
        font-size: 1.8rem;
      }

      .form-actions {
        flex-direction: column;
      }

      .btn {
        width: 100%;
      }
    }
  </style>
</head>
<body>
  <!-- Sidebar -->
  <?php include '../komponen/sidebar_admin.php'; ?>

  <main>
    <!-- Dashboard Header -->
    <div class="dashboard-header">
      <?php
        $isEdit = isset($_GET['id']);
        $title = $isEdit ? 'Edit Penginapan' : 'Tambah Penginapan Baru';
        $icon = $isEdit ? 'fa-edit' : 'fa-plus-circle';
      ?>
      <h1><i class="fas <?php echo $icon; ?>" style="color: #9b59b6; margin-right: 10px;"></i><?php echo $title; ?></h1>
      <p><?php echo $isEdit ? 'Edit data penginapan yang sudah ada' : 'Tambahkan penginapan baru ke dalam sistem'; ?></p>
    </div>

    <!-- Form Container -->
    <div class="form-container">
      <h2><i class="fas fa-hotel"></i> Form Penginapan</h2>
      
      <form id="accommodationForm">
        <div class="form-group">
          <label for="accName">Nama Penginapan</label>
          <input type="text" id="accName" placeholder="Contoh: Grand Luxury Resort" required
                 value="<?php echo $isEdit ? 'Grand Luxury Resort' : ''; ?>">
        </div>
        
        <div class="form-group">
          <label for="accLocation">Lokasi</label>
          <input type="text" id="accLocation" placeholder="Contoh: Bali, Ubud" required
                 value="<?php echo $isEdit ? 'Bali, Ubud' : ''; ?>">
        </div>
        
        <div class="form-group">
          <label for="accType">Tipe Penginapan</label>
          <select id="accType" required>
            <option value="">Pilih Tipe</option>
            <option value="hotel" <?php echo $isEdit ? 'selected' : ''; ?>>Hotel</option>
            <option value="resort" <?php echo $isEdit ? 'selected' : ''; ?>>Resort</option>
            <option value="villa" <?php echo $isEdit ? 'selected' : ''; ?>>Villa</option>
            <option value="bungalow" <?php echo $isEdit ? 'selected' : ''; ?>>Bungalow</option>
            <option value="hostel">Hostel</option>
            <option value="apartment">Apartemen</option>
          </select>
        </div>
        
        <div class="form-group">
          <label for="accPrice">Harga per Malam (Rp)</label>
          <input type="number" id="accPrice" min="100000" required
                 value="<?php echo $isEdit ? '1500000' : ''; ?>">
        </div>
        
        <div class="form-group">
          <label for="accRating">Rating (0-5)</label>
          <input type="number" id="accRating" min="0" max="5" step="0.1" placeholder="Contoh: 4.5"
                 value="<?php echo $isEdit ? '4.5' : ''; ?>">
        </div>
        
        <div class="form-group">
          <label for="accRooms">Jumlah Kamar</label>
          <input type="number" id="accRooms" min="1" required
                 value="<?php echo $isEdit ? '45' : ''; ?>">
        </div>
        
        <div class="form-group">
          <label for="accStatus">Status</label>
          <select id="accStatus" required>
            <option value="available" <?php echo $isEdit ? 'selected' : ''; ?>>Tersedia</option>
            <option value="full">Penuh</option>
            <option value="maintenance">Renovasi/Perbaikan</option>
          </select>
        </div>
        
        <div class="form-group">
          <label for="accFacilities">Fasilitas</label>
          <textarea id="accFacilities" placeholder="Kolam renang, WiFi gratis, Sarapan, AC, TV...">
            <?php echo $isEdit ? 'Kolam renang, Spa, Restoran, WiFi gratis, Sarapan prasmanan, Parkir gratis' : ''; ?>
          </textarea>
        </div>
        
        <div class="form-group">
          <label for="accDescription">Deskripsi</label>
          <textarea id="accDescription" placeholder="Deskripsi penginapan...">
            <?php echo $isEdit ? 'Resort mewah dengan pemandangan sawah yang indah di Ubud. Fasilitas lengkap dan pelayanan terbaik.' : ''; ?>
          </textarea>
        </div>
        
        <div class="form-group">
          <label for="accImages">Unggah Gambar</label>
          <input type="file" id="accImages" multiple accept="image/*">
          <div class="image-preview" id="imagePreview">
            <?php if ($isEdit): ?>
              <div class="preview-item">
                <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=200" alt="Preview">
                <div class="remove-img">×</div>
              </div>
              <div class="preview-item">
                <img src="https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=200" alt="Preview">
                <div class="remove-img">×</div>
              </div>
            <?php endif; ?>
          </div>
        </div>
        
        <div class="form-actions">
          <a href="daftar_penginapan.php" class="btn btn-secondary">Kembali</a>
          <button type="submit" class="btn btn-primary"><?php echo $isEdit ? 'Update Penginapan' : 'Simpan Penginapan'; ?></button>
        </div>
      </form>
    </div>
  </main>

  <script>
    // Image preview functionality
    document.getElementById('accImages').addEventListener('change', function() {
      const imagePreview = document.getElementById('imagePreview');
      imagePreview.innerHTML = '';
      
      if (this.files && this.files.length > 0) {
        for (let i = 0; i < this.files.length; i++) {
          const file = this.files[i];
          const reader = new FileReader();
          
          reader.onload = function(e) {
            const previewItem = document.createElement('div');
            previewItem.className = 'preview-item';
            previewItem.innerHTML = `
              <img src="${e.target.result}" alt="Preview">
              <div class="remove-img">×</div>
            `;
            imagePreview.appendChild(previewItem);
            
            // Add remove functionality
            const removeBtn = previewItem.querySelector('.remove-img');
            removeBtn.addEventListener('click', () => {
              previewItem.remove();
            });
          }
          
          reader.readAsDataURL(file);
        }
      }
    });
    
    // Remove existing image preview
    document.addEventListener('click', function(e) {
      if (e.target.classList.contains('remove-img')) {
        e.target.closest('.preview-item').remove();
      }
    });
    
    // Form submission
    document.getElementById('accommodationForm').addEventListener('submit', function(e) {
      e.preventDefault();
      const isEdit = <?php echo $isEdit ? 'true' : 'false'; ?>;
      alert(`Penginapan berhasil ${isEdit ? 'diupdate' : 'ditambahkan'}!`);
      window.location.href = 'daftar_penginapan.php';
    });
  </script>
</body>
</html>