<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Admin - Edit Penginapan</title>
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
      border-left: 5px solid #e74c3c;
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
      background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="%23e74c3c" stroke-width="1" opacity="0.1"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="m18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>') no-repeat center;
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

    .form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
      margin-bottom: 20px;
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
      border: 2px solid #ecf0f1;
      border-radius: 8px;
      font-family: inherit;
      font-size: 1rem;
      transition: all 0.3s;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
      outline: none;
      border-color: #e74c3c;
      box-shadow: 0 0 0 3px rgba(231, 76, 60, 0.1);
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
      padding: 12px 24px;
      border-radius: 8px;
      border: none;
      cursor: pointer;
      font-weight: 500;
      font-size: 1rem;
      transition: all 0.3s;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      text-decoration: none;
    }

    .btn-primary {
      background: #e74c3c;
      color: white;
    }

    .btn-primary:hover {
      background: #c0392b;
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(231, 76, 60, 0.3);
    }

    .btn-secondary {
      background: #ecf0f1;
      color: #7f8c8d;
    }

    .btn-secondary:hover {
      background: #d5dbdb;
      color: #2c3e50;
    }

    .btn-danger {
      background: #e67e22;
      color: white;
    }

    .btn-danger:hover {
      background: #d35400;
    }

    /* Image Preview */
    .image-preview {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
      gap: 15px;
      margin-top: 15px;
    }

    .preview-item {
      position: relative;
      width: 120px;
      height: 120px;
      border-radius: 12px;
      overflow: hidden;
      border: 2px solid #ecf0f1;
      transition: all 0.3s;
    }

    .preview-item:hover {
      border-color: #e74c3c;
      transform: scale(1.05);
    }

    .preview-item img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .remove-img {
      position: absolute;
      top: 8px;
      right: 8px;
      background: rgba(231, 76, 60, 0.9);
      color: white;
      width: 24px;
      height: 24px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      font-size: 12px;
      font-weight: bold;
      transition: all 0.3s;
    }

    .remove-img:hover {
      background: #c0392b;
      transform: scale(1.1);
    }

    /* Status indicators */
    .status-badge {
      display: inline-block;
      padding: 4px 12px;
      border-radius: 15px;
      font-size: 0.85rem;
      font-weight: 500;
      margin-left: 10px;
    }

    .status-available {
      background: #d5f4e6;
      color: #27ae60;
    }

    .status-full {
      background: #fadbd8;
      color: #e74c3c;
    }

    .status-maintenance {
      background: #fdeaa7;
      color: #f39c12;
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

      .form-row {
        grid-template-columns: 1fr;
      }

      .form-actions {
        flex-direction: column;
      }

      .btn {
        width: 100%;
        justify-content: center;
      }

      .image-preview {
        grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
      }

      .preview-item {
        width: 100px;
        height: 100px;
      }
    }
  </style>
</head>
<body>
<?php include "../Komponen/sidebar_admin.php"?>

  <main>
    <!-- Dashboard Header -->
    <div class="dashboard-header">
      <h1><i class="fas fa-edit" style="color: #e74c3c; margin-right: 10px;"></i>Edit Penginapan</h1>
      <p>Edit dan perbarui informasi penginapan yang sudah ada <span class="status-badge status-available">ID: #PG001</span></p>
    </div>

    <!-- Form Container -->
    <div class="form-container">
      <h2><i class="fas fa-hotel"></i> Form Edit Penginapan</h2>
      
      <form id="editAccommodationForm">
        <div class="form-row">
          <div class="form-group">
            <label for="accName"><i class="fas fa-building"></i> Nama Penginapan</label>
            <input type="text" id="accName" value="Hotel Santika Jakarta" required>
          </div>
          
          <div class="form-group">
            <label for="accLocation"><i class="fas fa-map-marker-alt"></i> Lokasi</label>
            <input type="text" id="accLocation" value="Jl. Raya Ubud No.123, Bali" required>
          </div>
        </div>
        
        <div class="form-row">
          <div class="form-group">
            <label for="accType"><i class="fas fa-home"></i> Tipe Penginapan</label>
            <select id="accType" required>
              <option value="">Pilih Tipe</option>
              <option value="hotel" selected>Hotel</option>
              <option value="resort">Resort</option>
              <option value="villa">Villa</option>
              <option value="bungalow">Bungalow</option>
              <option value="hostel">Hostel</option>
              <option value="apartment">Apartemen</option>
            </select>
          </div>
          
          <div class="form-group">
            <label for="accPrice"><i class="fas fa-money-bill-wave"></i> Harga per Malam (Rp)</label>
            <input type="number" id="accPrice" min="100000" value="746.652" required>
          </div>
        </div>
        
        <div class="form-row">
          <div class="form-group">
            <label for="accRating"><i class="fas fa-star"></i> Rating (0-5)</label>
            <input type="number" id="accRating" min="0" max="5" step="0.1" value="4.7">
          </div>
          
          <div class="form-group">
            <label for="accRooms"><i class="fas fa-door-open"></i> Jumlah Kamar</label>
            <input type="number" id="accRooms" min="1" value="58" required>
          </div>
        </div>
        
        <div class="form-group">
          <label for="accStatus"><i class="fas fa-info-circle"></i> Status</label>
          <select id="accStatus" required>
            <option value="available" selected>Tersedia</option>
            <option value="full">Penuh</option>
            <option value="maintenance">Renovasi/Perbaikan</option>
          </select>
        </div>
        
        <div class="form-group">
          <label for="accFacilities"><i class="fas fa-swimming-pool"></i> Fasilitas</label>
          <textarea id="accFacilities" placeholder="Daftar fasilitas yang tersedia...">Kolam renang infinity, Spa premium, Restoran fine dining, WiFi gratis berkecepatan tinggi, Sarapan prasmanan internasional, Parkir valet gratis, Gym 24 jam, Kids club, Business center, Laundry service</textarea>
        </div>
        
        <div class="form-group">
          <label for="accDescription"><i class="fas fa-file-alt"></i> Deskripsi</label>
          <textarea id="accDescription" placeholder="Deskripsi lengkap penginapan...">Resort mewah bintang 5 dengan pemandangan sawah terasering yang menakjubkan di jantung Ubud. Menawarkan pengalaman menginap yang tak terlupakan dengan arsitektur tradisional Bali yang dipadukan dengan fasilitas modern. Setiap villa dilengkapi dengan kolam renang private dan teras yang menghadap ke alam yang asri. Sempurna untuk bulan madu, liburan keluarga, atau retreat spiritual.</textarea>
        </div>
        
        <div class="form-group">
          <label for="accImages"><i class="fas fa-images"></i> Gambar Penginapan</label>
          <input type="file" id="accImages" multiple accept="image/*">
          <div class="image-preview" id="imagePreview">
            <div class="preview-item">
              <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=400" alt="Resort View">
              <div class="remove-img">×</div>
            </div>
            <div class="preview-item">
              <img src="https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=400" alt="Pool Area">
              <div class="remove-img">×</div>
            </div>
            <div class="preview-item">
              <img src="https://images.unsplash.com/photo-1578683010236-d716f9a3f461?auto=format&fit=crop&w=400" alt="Room Interior">
              <div class="remove-img">×</div>
            </div>
            <div class="preview-item">
              <img src="https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?auto=format&fit=crop&w=400" alt="Restaurant">
              <div class="remove-img">×</div>
            </div>
          </div>
        </div>
        
        <div class="form-actions">
          <a href="daftar_penginapan.php" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
          </a>
          <button type="button" class="btn btn-danger" onclick="confirmDelete()">
            <i class="fas fa-trash"></i> Hapus Penginapan
          </button>
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Update Penginapan
          </button>
        </div>
      </form>
    </div>
  </main>

  <script>
    // Image preview functionality for new uploads
    document.getElementById('accImages').addEventListener('change', function() {
      const files = this.files;
      
      if (files.length > 0) {
        for (let i = 0; i < files.length; i++) {
          const file = files[i];
          const reader = new FileReader();
          
          reader.onload = function(e) {
            const previewItem = document.createElement('div');
            previewItem.className = 'preview-item';
            previewItem.innerHTML = `
              <img src="${e.target.result}" alt="New Image">
              <div class="remove-img">×</div>
            `;
            
            document.getElementById('imagePreview').appendChild(previewItem);
            
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
    document.getElementById('editAccommodationForm').addEventListener('submit', function(e) {
      e.preventDefault();
      
      // Simulate form submission
      const submitBtn = this.querySelector('button[type="submit"]');
      const originalText = submitBtn.innerHTML;
      
      submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengupdate...';
      submitBtn.disabled = true;
      
      setTimeout(() => {
        alert('Penginapan berhasil diupdate!');
        window.location.href = 'daftar_penginapan.php';
      }, 2000);
    });
    
    // Delete confirmation
    function confirmDelete() {
      if (confirm('Apakah Anda yakin ingin menghapus penginapan ini? Tindakan ini tidak dapat dibatalkan.')) {
        if (confirm('Konfirmasi sekali lagi: Hapus penginapan "Grand Luxury Resort Ubud"?')) {
          alert('Penginapan berhasil dihapus!');
          window.location.href = 'daftar_penginapan.php';
        }
      }
    }
    
    // Auto-format currency input
    document.getElementById('accPrice').addEventListener('input', function() {
      let value = this.value.replace(/[^\d]/g, '');
      if (value) {
        this.value = parseInt(value).toLocaleString('id-ID');
      }
    });
    
    // Real-time validation feedback
    const inputs = document.querySelectorAll('input[required], select[required]');
    inputs.forEach(input => {
      input.addEventListener('blur', function() {
        if (this.value.trim() === '') {
          this.style.borderColor = '#e74c3c';
        } else {
          this.style.borderColor = '#27ae60';
        }
      });
    });
  </script>
</body>
</html>