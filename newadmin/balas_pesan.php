<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Balas Pesan | Admin Go Travel Indonesia</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --primary: #3b82f6;
      --primary-dark: #2563eb;
      --primary-light: #dbeafe;
      --secondary: #10b981;
      --light: #f9fafb;
      --dark: #1f2937;
      --gray: #6b7280;
      --border: #e5e7eb;
      --shadow: 0 4px 12px rgba(0,0,0,0.08);
      --shadow-hover: 0 6px 16px rgba(0,0,0,0.12);
    }
    
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    body {
      font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #f3f4f6, #e5e7eb);
      color: var(--dark);
      min-height: 100vh;
      display: flex;
      overflow-x: hidden;
    }
    


    
    .menu-item {
      padding: 12px 20px;
      display: flex;
      align-items: center;
      gap: 12px;
      cursor: pointer;
      color: rgba(255,255,255,0.8);
      transition: all 0.3s;
    }
    
    .menu-item:hover {
      background: rgba(255,255,255,0.1);
      color: white;
    }
    
    .menu-item.active {
      background: rgba(255,255,255,0.2);
      color: white;
      border-left: 4px solid white;
    }
    
    /* Main Content Area */
    main {
      flex: 1;
      margin-left: 250px;
      padding: 24px;
      transition: margin 0.3s;
      min-height: 100vh;
    }
    
    /* Header */
    .admin-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 16px 24px;
      background: white;
      border-radius: 16px;
      box-shadow: var(--shadow);
      margin-bottom: 24px;
      position: sticky;
      top: 24px;
      z-index: 100;
    }
    
    .admin-header h1 {
      display: flex;
      align-items: center;
      gap: 12px;
      font-size: 1.5rem;
      font-weight: 600;
      color: var(--dark);
    }
    
    .admin-header h1 i {
      color: var(--primary);
      background: var(--primary-light);
      padding: 10px;
      border-radius: 12px;
    }
    
    .admin-actions {
      display: flex;
      gap: 12px;
    }
    
    .admin-actions .btn {
      background-color: var(--primary);
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-size: 14px;
      font-weight: 500;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    
    .admin-actions .btn:hover {
      background-color: var(--primary-dark);
      transform: translateY(-2px);
      box-shadow: var(--shadow-hover);
    }
    
    /* Content Container */
    .container {
      background-color: white;
      padding: 32px;
      border-radius: 16px;
      box-shadow: var(--shadow);
      max-width: 900px;
      margin: 0 auto;
    }
    
    .content-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 32px;
      flex-wrap: wrap;
      gap: 16px;
    }
    
    .content-header h2 {
      font-size: 1.5rem;
      font-weight: 600;
      display: flex;
      align-items: center;
      gap: 12px;
      color: var(--dark);
    }
    
    .content-header h2 i {
      color: var(--primary);
      background: var(--primary-light);
      padding: 10px;
      border-radius: 12px;
    }
    
    .back-link {
      display: flex;
      align-items: center;
      gap: 8px;
      color: var(--gray);
      text-decoration: none;
      font-weight: 500;
      transition: all 0.2s;
      padding: 8px 16px;
      border-radius: 8px;
      border: 1px solid var(--border);
    }
    
    .back-link:hover {
      color: var(--primary);
      background: #f0f7ff;
      border-color: var(--primary-light);
    }
    
    .message-detail {
      margin-bottom: 32px;
      padding: 24px;
      background-color: #f9fafb;
      border-left: 4px solid var(--primary);
      border-radius: 12px;
      box-shadow: var(--shadow);
      transition: transform 0.3s ease;
      position: relative;
      overflow: hidden;
    }
    
    .message-detail:hover {
      transform: translateY(-3px);
    }
    
    .message-detail::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 4px;
      background: linear-gradient(90deg, var(--primary), var(--secondary));
    }
    
    .message-detail p {
      margin: 12px 0;
      line-height: 1.6;
    }
    
    .message-detail strong {
      display: inline-block;
      width: 100px;
      color: var(--dark);
      font-weight: 600;
    }
    
    .message-content {
      margin-top: 20px;
      padding-top: 20px;
      border-top: 1px dashed var(--border);
    }
    
    .form-group {
      margin-bottom: 24px;
    }
    
    .form-group label {
      display: block;
      margin-bottom: 8px;
      font-weight: 500;
      color: var(--dark);
      display: flex;
      align-items: center;
      gap: 8px;
    }
    
    .form-group label i {
      color: var(--primary);
      width: 20px;
      text-align: center;
    }
    
    form input[type="text"],
    form textarea {
      width: 100%;
      padding: 14px 16px;
      border-radius: 10px;
      border: 1px solid var(--border);
      font-size: 15px;
      font-family: 'Poppins', sans-serif;
      transition: all 0.3s ease;
    }
    
    form input[type="text"]:focus,
    form textarea:focus {
      outline: none;
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(59,130,246,0.2);
    }
    
    form textarea {
      min-height: 200px;
      resize: vertical;
      line-height: 1.6;
    }
    
    .btn-send {
      background: linear-gradient(135deg, var(--primary), var(--primary-dark));
      color: white;
      padding: 14px 28px;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      font-size: 16px;
      font-weight: 600;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      gap: 10px;
      box-shadow: 0 4px 6px rgba(59,130,246,0.3);
      margin-top: 10px;
    }
    
    .btn-send:hover {
      transform: translateY(-3px);
      box-shadow: 0 6px 12px rgba(59,130,246,0.4);
      background: linear-gradient(135deg, var(--primary-dark), var(--primary));
    }
    
    .btn-send:active {
      transform: translateY(0);
    }
    
    /* Footer */
    .admin-footer {
      text-align: center;
      padding: 24px;
      margin-top: 40px;
      color: var(--gray);
      font-size: 0.9rem;
      border-top: 1px solid var(--border);
    }
    
    /* Responsiveness */
    @media (max-width: 992px) {
      .sidebar {
        width: 80px;
      }
      
      .sidebar .menu-text, .sidebar-title {
        display: none;
      }
      
      .sidebar-header {
        padding: 15px 10px;
      }
      
      .sidebar-logo {
        font-size: 20px;
        margin-bottom: 5px;
      }
      
      main {
        margin-left: 80px;
      }
    }
    
    @media (max-width: 768px) {
      .admin-header {
        flex-direction: column;
        gap: 16px;
      }
      
      .admin-actions {
        width: 100%;
        justify-content: center;
        flex-wrap: wrap;
      }
      
      .content-header {
        flex-direction: column;
        align-items: flex-start;
      }
      
      .container {
        padding: 24px;
      }
      
      .message-detail strong {
        display: block;
        width: auto;
        margin-top: 10px;
      }
      
      main {
        padding: 16px;
      }
    }
    
    @media (max-width: 576px) {
      .sidebar {
        width: 60px;
      }
      
      main {
        margin-left: 60px;
        padding: 12px;
      }
      
      .admin-header h1 {
        font-size: 1.3rem;
      }
      
      .admin-actions .btn {
        padding: 8px 12px;
        font-size: 13px;
      }
      
      .content-header h2 {
        font-size: 1.3rem;
      }
    }
    
    /* Animation */
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    .container {
      animation: fadeIn 0.6s ease-out;
    }
    
    .message-detail {
      animation: fadeIn 0.4s ease-out 0.2s both;
    }
    
    form {
      animation: fadeIn 0.4s ease-out 0.4s both;
    }
  </style>
</head>
<body>
  <!-- Sidebar di-include dari komponen eksternal -->
  <?php include '../komponen/sidebar_admin.php'; ?>
  
  <!-- Konten Utama -->
  <main>
    
    <!-- Area Konten -->
    <div class="container">
      <div class="content-header">
        <h2> Balas Pesan</h2>
        <a href="pertanyaan.php" class="back-link"><i class="fas fa-arrow-left"></i> Kembali ke Kotak Masuk</a>
      </div>
      
      <!-- Detail Pesan -->
      <div class="message-detail">
        <p><strong><i class="fas fa-user"></i> Nama:</strong> Budi Santoso</p>
        <p><strong><i class="fas fa-envelope"></i> Email:</strong> budi@example.com</p>
        <p><strong><i class="fas fa-calendar"></i> Tanggal:</strong> 30 Mei 2025, 14:30 WIB</p>
        <p><strong><i class="fas fa-tag"></i> Subjek:</strong> Pertanyaan Paket Wisata</p>
        <div class="message-content">
          <p><strong><i class="fas fa-comment-dots"></i> Pesan:</strong></p>
          <p>Halo, saya ingin tahu lebih lanjut tentang paket ke Labuan ancol. Apakah ada paket untuk 4 hari 3 malam dengan harga sekitar 5 juta per orang? Saya berencana untuk pergi bulan depan bersama keluarga (4 orang). Terima kasih.</p>
        </div>
      </div>
      
      <!-- Form Balasan -->
      <form action="proses_balas.php" method="post">
        <input type="hidden" name="email_tujuan" value="budi@example.com">
        
        <div class="form-group">
          <label for="subjek"><i class="fas fa-heading"></i> Subjek Balasan</label>
          <input type="text" name="subjek" id="subjek" value="Re: Pertanyaan Paket Wisata" required>
        </div>
        
        <div class="form-group">
          <label for="pesan"><i class="fas fa-comment-alt"></i> Isi Balasan</label>
          <textarea name="pesan" id="pesan" rows="8" placeholder="Tulis balasan Anda di sini..." required>Halo Budi,

Terima kasih telah menghubungi Go Travel Indonesia. Berikut informasi paket Labuan Bajo yang Anda tanyakan:

✅ Paket 4 Hari 3 Malam
✅ Harga mulai Rp 4.800.000/orang
✅ Include: Penginapan, transportasi, makan, dan pemandu wisata
✅ Destinasi: Pulau Padar, Pink Beach, Pulau Komodo, Manta Point

Kami telah melampirkan brosur lengkap di email ini. Silakan hubungi kami jika ada pertanyaan lebih lanjut.

Salam,
Tim Go Travel Indonesia</textarea>
        </div>
        
        <button type="submit" class="btn-send"><i class="fas fa-paper-plane"></i> Kirim Balasan</button>
      </form>
      
      <!-- Footer -->
      <div class="admin-footer">
        <p>&copy; 2025 Go Travel Indonesia. Hak Cipta Dilindungi. Versi 2.1.0</p>
      </div>
    </div>
  </main>

  <script>
    // Animasi sederhana untuk interaksi
    document.addEventListener('DOMContentLoaded', function() {
      const messageDetail = document.querySelector('.message-detail');
      const sendButton = document.querySelector('.btn-send');
      
      if (messageDetail) {
        messageDetail.addEventListener('mouseenter', function() {
          this.style.transform = 'translateY(-5px)';
        });
        
        messageDetail.addEventListener('mouseleave', function() {
          this.style.transform = 'translateY(0)';
        });
      }
      
      if (sendButton) {
        sendButton.addEventListener('mouseenter', function() {
          this.style.transform = 'translateY(-3px)';
        });
        
        sendButton.addEventListener('mouseleave', function() {
          this.style.transform = 'translateY(0)';
        });
        
        sendButton.addEventListener('click', function() {
          this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengirim...';
          setTimeout(() => {
            this.innerHTML = '<i class="fas fa-check"></i> Terkirim!';
            this.style.background = 'linear-gradient(135deg, #10b981, #059669)';
          }, 1500);
        });
      }
    });
  </script>
</body>
</html>