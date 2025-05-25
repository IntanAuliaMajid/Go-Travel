<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Form Pemesanan Paket Wisata</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
    /* Global Styles */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', sans-serif;
    }

    body {
      background-color: #f5f5f5;
    }

    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 1rem;
    }

    /* Header Section */
    .order-header {
      background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),
                  url('https://www.ancol.com/blog/wp-content/uploads/2022/03/wisata-aquarium-di-jakarta.jpg') no-repeat center center/cover;
      height: 40vh;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      margin-bottom: 2rem;
      text-align: center;
    }

    .order-header h1 {
      font-size: 2.5rem;
      margin-bottom: 1rem;
    }

    /* Main Content */
    .order-main {
      display: grid;
      grid-template-columns: 1fr 350px;
      gap: 3rem;
      margin-bottom: 4rem;
    }

    /* Form Styles */
    .order-form {
      background: white;
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .order-form h2 {
      color: #2c7a51;
      margin-bottom: 1.5rem;
      padding-bottom: 0.5rem;
      border-bottom: 2px solid #eee;
    }

    .form-group {
      margin-bottom: 1.5rem;
    }

    .form-group label {
      display: block;
      margin-bottom: 0.5rem;
      font-weight: 600;
      color: #333;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
      width: 100%;
      padding: 0.8rem;
      border: 1px solid #ddd;
      border-radius: 5px;
      font-size: 1rem;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
      outline: none;
      border-color: #2c7a51;
      box-shadow: 0 0 0 2px rgba(44, 122, 81, 0.2);
    }

    .form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 1.5rem;
    }

    .form-actions {
      margin-top: 2rem;
      display: flex;
      justify-content: space-between;
    }

    .btn {
      padding: 1rem 2rem;
      border-radius: 5px;
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      border: none;
    }

    .btn-primary {
      background-color: #2c7a51;
      color: white;
    }

    .btn-primary:hover {
      background-color: #1e5a3a;
    }

    .btn-secondary {
      background-color: #f0f0f0;
      color: #333;
    }

    .btn-secondary:hover {
      background-color: #e0e0e0;
    }

    /* Order Summary */
    .order-summary {
      background: white;
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      height: fit-content;
      position: sticky;
      top: 20px;
    }

    .order-summary h2 {
      color: #2c7a51;
      margin-bottom: 1.5rem;
      padding-bottom: 0.5rem;
      border-bottom: 2px solid #eee;
    }

    .package-info {
      margin-bottom: 1.5rem;
    }

    .package-info h3 {
      font-size: 1.2rem;
      margin-bottom: 0.5rem;
    }

    .package-info p {
      color: #666;
      margin-bottom: 0.5rem;
      font-size: 0.8rem;
    }

    .package-details p {
      font-size: 0.8rem;
      margin-bottom: 0.5rem;
    }

    .price-detail {
      margin: 1.5rem 0;
    }
    .price-detail span{
      font-size: 0.8rem;
    }

    .price-row {
      display: flex;
      justify-content: space-between;
      margin-bottom: 0.8rem;
    }

    .price-total {
      font-weight: bold;
      font-size: 1.2rem;
      border-top: 1px solid #eee;
      padding-top: 0.8rem;
      margin-top: 0.8rem;
    }

    .payment-methods {
      margin-top: 1.5rem;
    }

    .payment-methods h4 {
      margin-bottom: 1rem;
    }

    .payment-option {
      display: flex;
      align-items: center;
      margin-bottom: 0.8rem;
      padding: 0.8rem;
      border: 1px solid #ddd;
      border-radius: 5px;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .payment-option:hover {
      border-color: #2c7a51;
    }

    .payment-option input {
      margin-right: 1rem;
    }

    .payment-option img {
      height: 30px;
      margin-left: auto;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      .order-main {
        grid-template-columns: 1fr;
      }
      
      .form-row {
        grid-template-columns: 1fr;
        gap: 1rem;
      }
      
      .order-header h1 {
        font-size: 2rem;
      }
    }
  </style>
</head>
<body>
  <?php include 'Komponen/navbar.php'; ?>

  <!-- Header Section -->
  <section class="order-header">
    <div class="container">
      <h1>Form Pemesanan Paket Wisata</h1>
      <p>Ancol Taman Impian 2D1N</p>
    </div>
  </section>

  <main class="container">
    <div class="order-main">

      <!-- Form Pemesanan -->
      <div class="order-form">
        <h2>Data Pemesan</h2>
        
        <form action="pembayaran.php" method="POST">
          <div class="form-row">
            <div class="form-group">
              <label for="nama">Nama Lengkap</label>
              <input type="text" id="nama" name="nama" placeholder="Masukan nama lengkap" required>
            </div>
            
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" id="email" name="email" placeholder="Masukan alamat email" required>
            </div>
          </div>
          
          <div class="form-row">
            <div class="form-group">
              <label for="telepon">Nomor Telepon</label>
              <input type="tel" id="telepon" name="telepon" placeholder="Nomor telepon" required>
            </div>
            
            <div class="form-group">
              <label for="ktp">Nomor KTP</label>
              <input type="text" id="ktp" name="ktp" placeholder="Masukkan nomor KTP (16 digit)"  required>
            </div>
          </div>
          
          <div class="form-group">
            <label for="alamat">Alamat Lengkap</label>
            <textarea id="alamat" name="alamat" rows="3" placeholder="Masukkan alamat lengkap Anda" required></textarea>
          </div>
          
          <h2 style="margin-top: 2rem;">Detail Perjalanan</h2>
          
          <div class="form-row">
            <div class="form-group">
              <label for="tanggal">Tanggal Keberangkatan</label>
              <input type="date" id="tanggal" name="tanggal" required>
            </div>
            

          </div>
          
          <div class="form-group">
            <label for="catatan">Catatan Tambahan</label>
            <textarea id="catatan" name="catatan" rows="3"></textarea>
          </div>
          
          <div class="form-actions">
            <button type="button" class="btn btn-secondary" onclick="window.history.back()">
              <i class="fas fa-arrow-left"></i> Kembali
            </button>
            <a href="pembayaran.php"><button type="submit" class="btn btn-primary">
              Lanjutkan Pembayaran
            </button>
            </a>
          </div>
        </form>
      </div>
      
      <!-- Order Summary -->
<div class="order-summary">
  <h2>Ringkasan Pesanan</h2>
  
  <div class="package-info">
    <h3>Paket Wisata Ancol 2D1N</h3>
    <p><i class="fas fa-calendar"></i> 2 Hari 1 Malam</p>
    <p><i class="fas fa-map-marker-alt"></i> Ancol Taman Impian, Jakarta Utara</p>
    <p><i class="fas fa-users"></i> Harga per orang (minimal 2 orang)</p>
  </div>
  
  <div class="price-detail">
    <h4 style="margin-bottom: 1rem; color: #2c7a51;">Detail Harga:</h4>
    
    <div class="price-row">
      <span><i class="fas fa-hotel"></i> Hotel Santika Premiere (1 malam)</span>
      <span>Rp 450.000</span>
    </div>
    <div class="price-row">
      <span><i class="fas fa-utensils"></i> Makan (3x) di D'Cost Seafood</span>
      <span>Rp 150.000</span>
    </div>
    <div class="price-row">
      <span><i class="fas fa-car"></i> Transportasi Avanza (12 jam)</span>
      <span>Rp 150.000</span>
    </div>
    <div class="price-row">
      <span><i class="fas fa-user"></i> Tour Guide (Bpk. Andi)</span>
      <span>Rp 100.000</span>
    </div>
    <div class="price-row">
      <span><i class="fas fa-ticket-alt"></i> Tiket Masuk Ancol</span>
      <span>Rp 100.000</span>
    </div>
    <div class="price-row">
      <span><i class="fas fa-ticket-alt"></i> Tiket Dunia Fantasi</span>
      <span>Rp 250.000</span>
    </div>
    <div class="price-row">
      <span><i class="fas fa-ticket-alt"></i> Tiket SeaWorld</span>
      <span>Rp 150.000</span>
    </div>
    
    <div class="price-row" style="margin-top: 1rem;">
      <span>Subtotal</span>
      <span>Rp 1.350.000</span>
    </div>
    <div class="price-row">
      <span>Diskon Paket</span>
      <span>- Rp 500.000</span>
    </div>
    <div class="price-row">
      <span>Biaya Admin</span>
      <span>Rp 10.000</span>
    </div>
    <div class="price-row price-total">
      <span>Total Perkiraan</span>
      <span>Rp 860.000</span>
    </div>
  </div>
  
  <div class="package-details" style="margin-top: 1.5rem;">
    <h4 style="margin-bottom: 0.5rem; color: #2c7a51;">Detail Paket:</h4>
    <p><strong>Hotel:</strong> Santika Premiere Ancol - Kamar Deluxe</p>
    <p><strong>Restoran:</strong> D'Cost Seafood - Menu prasmanan</p>
    <p><strong>Transportasi:</strong> Toyota Avanza (max 6 orang) dengan sopir</p>
    <p><strong>Tour Guide:</strong> Bpk. Andi (berpengalaman 5 tahun)</p>
    <p><strong>Itinerary:</strong> Dunia Fantasi, SeaWorld, Pantai, EcoPark</p>
  </div>
  
  <div class="payment-methods">
    <h4>Metode Pembayaran</h4>
    
    <label class="payment-option">
      <input type="radio" name="payment" value="bca" checked>
      Transfer Bank
      <img src="http://1.bp.blogspot.com/-THibJz4NpO0/UNhEbur9-fI/AAAAAAAAEQM/b5J4fwEPD-c/s1600/Logo+Bank+BCA.JPG" alt="BCA">
    </label>
    
    <label class="payment-option">
      <input type="radio" name="payment" value="mandiri">
      Transfer Bank
      <img src="https://freepngdesign.com/content/uploads/images/p-2813-2-bank-mandiri-logo-png-transparent-logo-699390155888.png" alt="Mandiri">
    </label>
    
    <label class="payment-option">
      <input type="radio" name="payment" value="bri">
      Transfer Bank
      <img src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEiI-LYwxppMGg1RwIURouPa5KZxSxiAIQStRSQXcz0aGNJiB5twYeb_VbsN2ZW9hAu_cVG6-Y47EeMr0g9AQqG6YpxNujH4VmRX4ZN2bCsWUiG17huO2DE1PJyWy-rel0wq3_FKRzsbqCWluyqPrSIejEKmPOjIYWqQ10H7jygYHzZTzB-F4jATGcxHXQ/s1920/BRI.jpg" alt="BRI">
    </label>
    
    <label class="payment-option">
      <input type="radio" name="payment" value="gopay">
      E-Wallet
      <img src="https://1000logos.net/wp-content/uploads/2021/05/GoPay-Logo.png" alt="GoPay">
    </label>
    
    <label class="payment-option">
      <input type="radio" name="payment" value="ovo">
      E-Wallet
      <img src="https://1.bp.blogspot.com/-Iq0Ztu117_8/XzNYaM4ABdI/AAAAAAAAHA0/MabT7B02ErIzty8g26JvnC6cPeBZtATNgCLcBGAsYHQ/s1000/logo-ovo.png" alt="OVO">
    </label>
  </div>
  
  <div style="margin-top: 1.5rem; font-size: 0.9rem; color: #666;">
    <p><i class="fas fa-info-circle"></i> Pembayaran harus dilakukan dalam 24 jam setelah pemesanan</p>
    <p><i class="fas fa-info-circle"></i> Konfirmasi pembayaran akan dikirim via email</p>
    <p><i class="fas fa-info-circle"></i> Free cancelation 7 hari sebelum keberangkatan</p>
  </div>
</div>
  </main>

  <?php include 'Komponen/footer.php'; ?>

  <script>
    // Script untuk menghitung total harga secara dinamis
    document.getElementById('jumlah').addEventListener('change', function() {
      const jumlah = parseInt(this.value);
      const hargaPerOrang = 850000;
      const diskonGrup = jumlah >= 4 ? 50000 : 0;
      const biayaAdmin = 10000;
      
      let subtotal = hargaPerOrang * jumlah;
      let total = subtotal - (diskonGrup * jumlah) + biayaAdmin;
      
      // Update ringkasan harga
      document.querySelector('.price-row:nth-child(1) span:last-child').textContent = 
        `Rp ${(hargaPerOrang * jumlah).toLocaleString('id-ID')}`;
      
      document.querySelector('.price-row:nth-child(2) span:last-child').textContent = 
        jumlah >= 4 ? `- Rp ${(diskonGrup * jumlah).toLocaleString('id-ID')}` : 'Rp 0';
      
      document.querySelector('.price-total span:last-child').textContent = 
        `Rp ${total.toLocaleString('id-ID')}`;
    });
  </script>
</body>
</html>