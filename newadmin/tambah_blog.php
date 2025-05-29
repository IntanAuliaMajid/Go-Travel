<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Artikel Baru - Admin GoTravel</title>
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
      display: flex;
      min-height: 100vh;
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
    
    .btn {
      padding: 12px 24px;
      border-radius: var(--border-radius);
      border: none;
      cursor: pointer;
      font-weight: 500;
      transition: var(--transition);
      display: inline-flex;
      align-items: center;
      gap: 8px;
      font-size: 1rem;
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
    
    /* === LAYOUT UTAMA === */
    
    main {
      flex: 1;
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
    
    .back-link {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      color: var(--primary);
      text-decoration: none;
      margin-bottom: 20px;
      font-weight: 500;
    }
    
    .back-link:hover {
      text-decoration: underline;
    }
    
    /* === FORM TAMBAH ARTIKEL === */
    .article-form-container {
      background-color: white;
      border-radius: var(--border-radius);
      padding: 30px;
      box-shadow: var(--shadow);
    }
    
    .form-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 25px;
    }
    
    .form-full {
      grid-column: span 2;
    }
    
    .form-group {
      margin-bottom: 20px;
    }
    
    .form-label {
      display: block;
      margin-bottom: 8px;
      font-weight: 500;
      color: var(--secondary);
    }
    
    .form-label span {
      color: var(--danger);
    }
    
    .form-input {
      width: 100%;
      padding: 12px 15px;
      border: 1px solid var(--gray);
      border-radius: var(--border-radius);
      font-size: 1rem;
      transition: var(--transition);
    }
    
    .form-input:focus {
      border-color: var(--primary);
      outline: none;
      box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
    }
    
    .form-textarea {
      min-height: 200px;
      resize: vertical;
    }
    
    .form-select {
      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
      background-position: right 0.5rem center;
      background-repeat: no-repeat;
      background-size: 1.5em 1.5em;
      -webkit-appearance: none;
      -moz-appearance: none;
      appearance: none;
    }
    
    .image-upload {
      border: 2px dashed var(--gray);
      border-radius: var(--border-radius);
      padding: 25px;
      text-align: center;
      cursor: pointer;
      transition: var(--transition);
    }
    
    .image-upload:hover {
      border-color: var(--primary);
      background-color: rgba(52, 152, 219, 0.05);
    }
    
    .image-upload i {
      font-size: 2.5rem;
      color: var(--primary);
      margin-bottom: 15px;
    }
    
    .image-upload p {
      color: var(--dark-gray);
      margin-bottom: 10px;
    }
    
    .image-upload .btn {
      margin-top: 10px;
    }
    
    .preview-container {
      display: none;
      margin-top: 20px;
      text-align: center;
    }
    
    .preview-image {
      max-width: 100%;
      max-height: 250px;
      border-radius: var(--border-radius);
      border: 1px solid var(--gray);
      margin-bottom: 15px;
    }
    
    .status-toggle {
      display: flex;
      gap: 15px;
    }
    
    .toggle-option {
      flex: 1;
    }
    
    .toggle-option input[type="radio"] {
      display: none;
    }
    
    .toggle-option label {
      display: block;
      padding: 15px;
      border: 1px solid var(--gray);
      border-radius: var(--border-radius);
      text-align: center;
      cursor: pointer;
      transition: var(--transition);
    }
    
    .toggle-option input[type="radio"]:checked + label {
      border-color: var(--primary);
      background-color: rgba(52, 152, 219, 0.1);
      color: var(--primary);
      font-weight: 500;
    }
    
    .form-actions {
      display: flex;
      justify-content: flex-end;
      gap: 15px;
      margin-top: 30px;
      padding-top: 20px;
      border-top: 1px solid var(--gray);
    }
    
    /* === RESPONSIVENESS === */
    @media (max-width: 992px) {
      .form-grid {
        grid-template-columns: 1fr;
      }
      
      .form-full {
        grid-column: span 1;
      }
    }
    
    @media (max-width: 768px) {
      .sidebar {
        width: 70px;
        overflow: hidden;
      }
      
      .sidebar-header h2 span,
      .sidebar-menu li a span {
        display: none;
      }
      
      main {
        margin-left: 70px;
      }
      
      .status-toggle {
        flex-direction: column;
      }
    }
    
    @media (max-width: 576px) {
      main {
        padding: 15px;
        margin-left: 0;
      }
      
      .sidebar {
        display: none;
      }
      
      .header-container {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
      }
      
      .form-actions {
        flex-direction: column;
      }
      
      .form-actions .btn {
        width: 100%;
      }
    }
  </style>
</head>
<body>
  <?php include "../Komponen/sidebar_admin.php" ?>

  <main>
    <a href="blog.php" class="back-link">
      <i class="fas fa-arrow-left"></i> Kembali ke Manajemen Artikel
    </a>
    
    <div class="header-container">
      <h1 class="page-title">Tambah Artikel Baru</h1>
    </div>

    <div class="article-form-container">
      <form id="articleForm">
        <div class="form-grid">
          <div class="form-group form-full">
            <label class="form-label" for="articleTitle">Judul Artikel <span>*</span></label>
            <input type="text" id="articleTitle" class="form-input" placeholder="Contoh: 10 Hidden Gem di Lamongan yang wajib dikunjungi" required>
          </div>
          
          <div class="form-group">
            <label class="form-label" for="articleCategory">Kategori <span>*</span></label>
            <select id="articleCategory" class="form-input form-select" required>
              <option value="">Pilih Kategori</option>
              <option value="destination">Destinasi Populer</option>
              <option value="tips">Tips Travel</option>
              <option value="review">Review Paket</option>
              <option value="culture">Budaya Lokal</option>
            </select>
          </div>
          
          <div class="form-group">
            <label class="form-label" for="articleDestination">Lokasi Destinasi</label>
            <select id="articleDestination" class="form-input form-select">
              <option value="">Pilih Destinasi</option>
              <option value="bali">Lamongan</option>
              <option value="lombok">Jakarta</option>
              <option value="yogyakarta">Pamekasan</option>
              <option value="rajaampat">Bangkalan</option>
            </select>
          </div>
          
          <div class="form-group">
            <label class="form-label" for="articleAuthor">Penulis <span>*</span></label>
            <input type="text" id="articleAuthor" class="form-input" value="Admin Travel" required>
          </div>
          
          <div class="form-group">
            <label class="form-label" for="articleDate">Tanggal Publikasi</label>
            <input type="date" id="articleDate" class="form-input" value="2024-05-29">
          </div>
          
          <div class="form-group form-full">
            <label class="form-label">Gambar Utama <span>*</span></label>
            <div class="image-upload" id="imageUpload">
              <i class="fas fa-cloud-upload-alt"></i>
              <p>Seret & letakkan gambar di sini atau klik untuk memilih</p>
              <p class="small" style="font-size: 0.9rem; color: #888;">Format: JPG, PNG, atau GIF (Maks. 5MB)</p>
              <button type="button" class="btn btn-outline">
                <i class="fas fa-folder-open"></i> Pilih Gambar
              </button>
            </div>
            <div class="preview-container" id="previewContainer">
              <img src="" alt="Preview" class="preview-image" id="previewImage">
              <button type="button" class="btn btn-outline" id="changeImageBtn">
                <i class="fas fa-sync"></i> Ganti Gambar
              </button>
            </div>
            <input type="file" id="fileInput" style="display: none;" accept="image/*">
          </div>
          
          <div class="form-group form-full">
            <label class="form-label" for="articleExcerpt">Ringkasan Artikel <span>*</span></label>
            <textarea id="articleExcerpt" class="form-input" placeholder="Tulis ringkasan singkat tentang artikel ini (maks. 200 karakter)" rows="3" maxlength="200" required></textarea>
          </div>
          
          <div class="form-group form-full">
            <label class="form-label" for="articleContent">Konten Artikel <span>*</span></label>
            <textarea id="articleContent" class="form-input form-textarea" placeholder="Tulis konten artikel lengkap di sini..." rows="10" required></textarea>
          </div>
          
          <div class="form-group form-full">
            <label class="form-label">Status Artikel <span>*</span></label>
            <div class="status-toggle">
              <div class="toggle-option">
                <input type="radio" id="statusPublished" name="articleStatus" value="published" checked>
                <label for="statusPublished">
                  <i class="fas fa-check-circle"></i> Publikasikan
                </label>
              </div>
              <div class="toggle-option">
                <input type="radio" id="statusDraft" name="articleStatus" value="draft">
                <label for="statusDraft">
                  <i class="fas fa-save"></i> Simpan sebagai Draft
                </label>
              </div>
            </div>
          </div>
        </div>
        
        <div class="form-actions">
          <button type="button" class="btn btn-outline">
            <i class="fas fa-times"></i> Batal
          </button>
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-paper-plane"></i> Publikasikan Artikel
          </button>
        </div>
      </form>
    </div>
  </main>
  
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const imageUpload = document.getElementById('imageUpload');
      const fileInput = document.getElementById('fileInput');
      const previewContainer = document.getElementById('previewContainer');
      const previewImage = document.getElementById('previewImage');
      const changeImageBtn = document.getElementById('changeImageBtn');
      
      // Handle image upload
      imageUpload.addEventListener('click', () => {
        fileInput.click();
      });
      
      fileInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
          const reader = new FileReader();
          
          reader.onload = function(e) {
            previewImage.src = e.target.result;
            previewContainer.style.display = 'block';
            imageUpload.style.display = 'none';
          }
          
          reader.readAsDataURL(this.files[0]);
        }
      });
      
      // Change image button
      changeImageBtn.addEventListener('click', () => {
        fileInput.value = '';
        previewContainer.style.display = 'none';
        imageUpload.style.display = 'block';
      });
      
      // Form submission
      const articleForm = document.getElementById('articleForm');
      
      articleForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Simple validation
        const title = document.getElementById('articleTitle').value;
        const category = document.getElementById('articleCategory').value;
        const image = fileInput.files[0];
        
        if (!title || !category || !image) {
          alert('Harap lengkapi semua bidang yang wajib diisi!');
          return;
        }
        
        // Show success message
        alert('Artikel berhasil ditambahkan!');
        articleForm.reset();
        previewContainer.style.display = 'none';
        imageUpload.style.display = 'block';
      });
      
      // Update publish button text based on status
      const statusRadios = document.querySelectorAll('input[name="articleStatus"]');
      const submitButton = articleForm.querySelector('button[type="submit"]');
      
      statusRadios.forEach(radio => {
        radio.addEventListener('change', function() {
          if (this.value === 'published') {
            submitButton.innerHTML = '<i class="fas fa-paper-plane"></i> Publikasikan Artikel';
          } else {
            submitButton.innerHTML = '<i class="fas fa-save"></i> Simpan sebagai Draft';
          }
        });
      });
    });
  </script>
</body>
</html>