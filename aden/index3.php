<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transportasi Booking</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f5f5;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        /* Navigation */
        .nav {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            padding: 15px 0;
        }
        
        .nav a {
            margin-left: 20px;
            text-decoration: none;
            color: #333;
            font-weight: 500;
        }
        
        .pesan-sekarang-btn {
            background-color: #2563eb;
            color: white !important;
            padding: 8px 15px;
            border-radius: 5px;
        }
        
        /* Main Content */
        .main-content {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        
        .header {
            background-color: #f0f2f9;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .header h1 {
            color: #2d3142;
            font-size: 22px;
            margin-bottom: 5px;
        }
        
        .header p {
            color: #565973;
            font-size: 14px;
        }
        
        /* Form */
        .form-group {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-bottom: 20px;
        }
        
        .form-input {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        
        .cari-btn {
            background-color: #2563eb;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        
        /* Selection */
        .selection-area {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        
        .select-mobil-btn {
            background-color: #424698;
            color: white;
            padding: 8px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        
        /* Vehicle Cards */
        .vehicle-card {
            display: grid;
            grid-template-columns: 100px 1fr;
            gap: 15px;
            border: 1px solid #eee;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }
        
        .vehicle-image {
            background-color: #eee;
            border-radius: 5px;
            height: 80px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .vehicle-details {
            display: flex;
            justify-content: space-between;
        }
        
        .vehicle-info h3 {
            margin-bottom: 5px;
            font-size: 16px;
        }
        
        .vehicle-info p {
            color: #666;
            font-size: 13px;
            margin-bottom: 5px;
        }
        
        .features {
            display: flex;
            gap: 10px;
            margin-top: 8px;
            margin-bottom: 5px;
        }
        
        .feature {
            display: flex;
            align-items: center;
            font-size: 12px;
            color: #666;
        }
        
        .feature span {
            width: 6px;
            height: 6px;
            background-color: #424698;
            border-radius: 50%;
            margin-right: 5px;
        }
        
        .price-section {
            text-align: right;
        }
        
        .total-text {
            font-size: 12px;
            color: #666;
        }
        
        .price {
            font-weight: bold;
            color: #333;
            margin: 5px 0;
        }
        
        .per-day {
            font-size: 12px;
            color: #666;
        }
        
        .pesan-sekarang {
            background-color: #ff6b00;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            margin-top: 5px;
        }
        
        /* Filter Section */
        .filter-section {
            margin-top: 30px;
            margin-bottom: 20px;
        }
        
        .filter-title {
            font-size: 16px;
            margin-bottom: 15px;
            color: #333;
        }
        
        .filter-options {
            display: flex;
            gap: 20px;
        }
        
        .filter-option {
            display: flex;
            align-items: center;
        }
        
        .filter-option input[type="radio"] {
            margin-right: 5px;
        }
        
        /* Footer */
        .footer {
            margin-top: 50px;
            padding: 20px 0;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }
        
        .footer-column h3 {
            margin-bottom: 15px;
            font-size: 16px;
        }
        
        .footer-column p {
            font-size: 13px;
            color: #666;
            margin-bottom: 15px;
        }
        
        .footer-column a {
            display: block;
            margin-bottom: 8px;
            color: #555;
            text-decoration: none;
            font-size: 14px;
        }
        
        .logo {
            max-width: 80px;
        }
        
        .social-icons {
            display: flex;
            gap: 10px;
        }
        
        .social-icon {
            width: 25px;
            height: 25px;
            background-color: #f0f2f9;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>
<body>
    <?php include '../Komponen/navbar.php'; ?>
    <div class="container">
       
        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <div class="header">
                <h1>Transportasi</h1>
                <p>Pilih berbagai layanan transport dan sesuai kebutuhan perjalanan Anda.</p>
            </div>
            
            <!-- Booking Form -->
            <div>
                <h3>Cari Transportasi</h3>
                <div class="form-group">
                    <input type="text" class="form-input" placeholder="Lokasi Penjemputan">
                    <input type="text" class="form-input" placeholder="Lokasi Tujuan">
                    <input type="date" class="form-input" value="2023-05-15">
                    <select class="form-input">
                        <option>2 Orang</option>
                        <option>3 Orang</option>
                        <option>4 Orang</option>
                        <option>5 orang</option>
                        <option>6 orang</option>
                        <option>7 orang</option>
                    </select>
                </div>
                <div style="text-align: right;">
                    <button class="cari-btn">Cari</button>
                </div>
            </div>
            
            <!-- Selection Area -->
            <div class="selection-area">
                <button class="select-mobil-btn">Select Mobil</button>
                <div>Bus</div>
                <div>Antar-Jemput Bandara</div>
                <div>Outbus</div>
            </div>
            
            <!-- Vehicle Cards -->
            <div class="vehicle-card">
                <div class="vehicle-image">
                    <svg width="60" height="30" viewBox="0 0 60 30" fill="#aaa">
                        <rect x="5" y="15" width="50" height="10" rx="2" />
                        <circle cx="15" cy="25" r="4" />
                        <circle cx="45" cy="25" r="4" />
                    </svg>
                </div>
                <div class="vehicle-details">
                    <div class="vehicle-info">
                        <h3>Toyota Avanza (SUV)</h3>
                        <p>Kapasitas: 5 orang (maksimum)</p>
                        <div class="features">
                            <div class="feature"><span></span> AC Dingin</div>
                            <div class="feature"><span></span> WiFi Gratis</div>
                            <div class="feature"><span></span> GPS</div>
                        </div>
                        <p>Termasuk: Driver, Bensin, Parkir AYCE card</p>
                    </div>
                    <div class="price-section">
                        <div class="total-text">Total Biaya</div>
                        <div class="price">Rp 500.000</div>
                        <div class="per-day">per hari</div>
                        <button class="pesan-sekarang">Pesan Sekarang</button>
                    </div>
                </div>
            </div>
            
            <div class="vehicle-card">
                <div class="vehicle-image">
                    <svg width="60" height="30" viewBox="0 0 60 30" fill="#aaa">
                        <rect x="5" y="15" width="50" height="10" rx="2" />
                        <circle cx="15" cy="25" r="4" />
                        <circle cx="45" cy="25" r="4" />
                    </svg>
                </div>
                <div class="vehicle-details">
                    <div class="vehicle-info">
                        <h3>Honda Civic (Sedan)</h3>
                        <p>Kapasitas: 5 orang (maksimum)</p>
                        <div class="features">
                            <div class="feature"><span></span> AC Dingin</div>
                            <div class="feature"><span></span> WiFi Gratis</div>
                            <div class="feature"><span></span> Moonroof</div>
                        </div>
                        <p>Termasuk: Driver, Bensin, Minuman</p>
                    </div>
                    <div class="price-section">
                        <div class="total-text">Total Biaya</div>
                        <div class="price">Rp 600.000</div>
                        <div class="per-day">per hari</div>
                        <button class="pesan-sekarang">Pesan Sekarang</button>
                    </div>
                </div>
            </div>
            
            <div class="vehicle-card">
                <div class="vehicle-image">
                    <svg width="60" height="30" viewBox="0 0 60 30" fill="#aaa">
                        <rect x="5" y="10" width="50" height="15" rx="2" />
                        <rect x="5" y="5" width="50" height="5" rx="1" />
                        <circle cx="15" cy="25" r="4" />
                        <circle cx="45" cy="25" r="4" />
                        <circle cx="30" cy="25" r="4" />
                    </svg>
                </div>
                <div class="vehicle-details">
                    <div class="vehicle-info">
                        <h3>Bus Pariwisata Medium</h3>
                        <p>Kapasitas: 25-30 orang | Design Style</p>
                        <div class="features">
                            <div class="feature"><span></span> Reclining Seat</div>
                            <div class="feature"><span></span> GPS System</div>
                            <div class="feature"><span></span> WiFi</div>
                        </div>
                        <p>Termasuk: Driver, mainan anak, Snack, TV, Audio Prima</p>
                    </div>
                    <div class="price-section">
                        <div class="total-text">Total Biaya</div>
                        <div class="price">Rp 2.500.000</div>
                        <div class="per-day">per hari</div>
                        <button class="pesan-sekarang">Pesan Sekarang</button>
                    </div>
                </div>
            </div>
            
            <div class="vehicle-card">
                <div class="vehicle-image">
                    <svg width="60" height="30" viewBox="0 0 60 30" fill="#aaa">
                        <rect x="5" y="10" width="50" height="15" rx="2" />
                        <rect x="5" y="5" width="50" height="5" rx="1" />
                        <circle cx="15" cy="25" r="4" />
                        <circle cx="45" cy="25" r="4" />
                    </svg>
                </div>
                <div class="vehicle-details">
                    <div class="vehicle-info">
                        <h3>Antar-Jemput Bandara (VIP Van)</h3>
                        <p>Kapasitas: 7 orang | Design Style</p>
                        <div class="features">
                            <div class="feature"><span></span> Reclining Seat</div>
                            <div class="feature"><span></span> WiFi</div>
                            <div class="feature"><span></span> Air Mineral</div>
                        </div>
                        <p>Layanan: Antar dan Jemput Bandara | 24 jam operasional</p>
                    </div>
                    <div class="price-section">
                        <div class="total-text">Total Biaya</div>
                        <div class="price">Rp 350.000</div>
                        <div class="per-day">sekali jalan</div>
                        <button class="pesan-sekarang">Pesan Sekarang</button>
                    </div>
                </div>
            </div>
            
            <!-- Filter Section -->
            <div class="filter-section">
                <h3 class="filter-title">Mengapa Memilih Layanan Transportasi Kami?</h3>
                <div class="filter-options">
                    <div class="filter-option">
                        <input type="radio" name="filter" id="option1" checked>
                        <label for="option1">Armada Terawat & Bersih</label>
                    </div>
                    <div class="filter-option">
                        <input type="radio" name="filter" id="option2">
                        <label for="option2">Supir Profesional</label>
                    </div>
                    <div class="filter-option">
                        <input type="radio" name="filter" id="option3">
                        <label for="option3">Pelayanan Antar Jemput 24 jam</label>
                    </div>
                    <div class="filter-option">
                        <input type="radio" name="filter" id="option4">
                        <label for="option4">Pembayaran Amana</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include '../Komponen/footer.php'; ?>
</body>
</html>