<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Paket Wisata - GoTravel</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        body {
            background-color: #f8f9fa;
            color: #333;
        }
        .header {
            background-color: #1a9988;
            padding: 1.2rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .hero {
            height: 380px;
            background-image: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('https://www.ancol.com/blog/wp-content/uploads/2022/03/wisata-aquarium-di-jakarta.jpg');
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
            position: relative;
        }
        .hero::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 100px;
            background: linear-gradient(to top, #f8f9fa, transparent);
        }
        .hero-content {
            z-index: 1;
            max-width: 800px;
            padding: 0 20px;
        }
        .hero h1 {
            font-size: 3rem;
            margin-bottom: 1.5rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        .hero p {
            font-size: 1.3rem;
            max-width: 600px;
            margin: 0 auto;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }
        .booking-container {
            max-width: 1200px;
            margin: -50px auto 50px;
            padding: 0 2rem;
            display: flex;
            gap: 2rem;
            flex-wrap: wrap;
            position: relative;
            z-index: 2;
        }
        .booking-form {
            flex: 1;
            min-width: 320px;
            background-color: white;
            padding: 2.5rem;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }
        .booking-form h2 {
            color: #1a9988;
            margin-bottom: 1.8rem;
            font-size: 1.8rem;
            position: relative;
            padding-bottom: 10px;
        }
        .booking-form h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 4px;
            background-color: #1a9988;
            border-radius: 2px;
        }
        .form-group {
            margin-bottom: 1.8rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.6rem;
            font-weight: 500;
            color: #444;
        }
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 1rem;
            border: 1.5px solid #e1e5ee;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: #fafafa;
        }
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #1a9988;
            box-shadow: 0 0 0 4px rgba(26, 153, 136, 0.1);
            background-color: #fff;
        }
        .form-group textarea {
            min-height: 120px;
            resize: vertical;
        }
        .form-row {
            display: flex;
            gap: 1.5rem;
            margin-bottom: 1.8rem;
        }
        .form-row .form-group {
            flex: 1;
            margin-bottom: 0;
        }
        .checkout-summary {
            flex: 1;
            min-width: 320px;
            background-color: white;
            padding: 2.5rem;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }
        .checkout-summary h2 {
            color: #1a9988;
            margin-bottom: 1.8rem;
            font-size: 1.8rem;
            position: relative;
            padding-bottom: 10px;
        }
        .checkout-summary h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 4px;
            background-color: #1a9988;
            border-radius: 2px;
        }
        .package-details {
            margin-bottom: 2rem;
        }
        .package-image {
            width: 100%;
            height: 220px;
            object-fit: cover;
            border-radius: 12px;
            margin-bottom: 1.2rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        .package-name {
            font-size: 1.4rem;
            font-weight: bold;
            margin-bottom: 0.8rem;
            color: #333;
        }
        .package-description {
            color: #666;
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }
        .package-includes {
            background-color: #f8f9fa;
            padding: 1.2rem;
            border-radius: 10px;
            margin-top: 1.2rem;
        }
        .package-includes strong {
            display: block;
            margin-bottom: 0.8rem;
            color: #444;
        }
        .package-includes ul {
            padding-left: 1.5rem;
        }
        .package-includes li {
            margin-bottom: 0.5rem;
            color: #555;
        }
        .price-details {
            border-top: 1px solid #eee;
            padding-top: 1.8rem;
            margin-top: 1rem;
        }
        .price-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
            color: #555;
        }
        .price-total {
            font-weight: bold;
            font-size: 1.4rem;
            margin-top: 1.5rem;
            color: #1a9988;
            padding-top: 1rem;
            border-top: 1px dashed #ddd;
        }
        .booking-button {
            display: block;
            width: 100%;
            padding: 1.2rem;
            background-color: #1a9988;
            color: white;
            border: none;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            margin-top: 2rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(26, 153, 136, 0.3);
        }
        .booking-button:hover {
            background-color: #158677;
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(26, 153, 136, 0.4);
        }
        .booking-button:active {
            transform: translateY(-1px);
        }
        .payment-methods {
            margin-top: 2rem;
        }
        .payment-methods h3 {
            font-size: 1.1rem;
            margin-bottom: 1rem;
            color: #444;
        }
        .payment-options {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }
        .payment-option {
            flex: 1;
            min-width: 100px;
            padding: 1rem;
            border: 2px solid #e1e5ee;
            border-radius: 10px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        .payment-option:hover {
            border-color: #1a9988;
            background-color: #f0f9f8;
        }
        .payment-option.active {
            border-color: #1a9988;
            background-color: #e0f7f5;
            color: #1a9988;
        }
        
        /* Form section divider */
        .form-divider {
            margin: 2.5rem 0;
            border-top: 1px solid #eee;
            position: relative;
        }
        
        /* New quantity selector with + - buttons */
        .quantity-selector {
            display: flex;
            align-items: center;
            background-color: #fafafa;
            border: 1.5px solid #e1e5ee;
            border-radius: 10px;
            overflow: hidden;
        }
        .quantity-btn {
            width: 40px;
            height: 40px;
            background-color: #f0f9f8;
            border: none;
            font-size: 1.2rem;
            color: #1a9988;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .quantity-btn:hover {
            background-color: #e0f7f5;
        }
        .quantity-selector input {
            width: calc(100% - 80px);
            text-align: center;
            border: none;
            background-color: transparent;
            font-weight: 500;
            font-size: 1rem;
            padding: 0.5rem;
        }
        .quantity-selector input:focus {
            outline: none;
            box-shadow: none;
        }
        
        /* Progress indicator */
        .booking-progress {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2.5rem;
        }
        .progress-step {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            flex: 1;
        }
        .step-number {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background-color: #e0f7f5;
            color: #1a9988;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: bold;
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 1;
        }
        .progress-step.active .step-number {
            background-color: #1a9988;
            color: white;
        }
        .step-label {
            font-size: 0.9rem;
            color: #777;
            font-weight: 500;
        }
        .progress-step.active .step-label {
            color: #1a9988;
            font-weight: 600;
        }
        .progress-line {
            height: 3px;
            background-color: #e0f7f5;
            flex-grow: 1;
            margin: 0 8px;
            transform: translateY(-16px);
        }
        
        /* Package badge */
        .package-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: #1a9988;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-weight: 500;
            font-size: 0.9rem;
        }
        
        /* Featured highlight */
        .featured-item {
            display: flex;
            align-items: center;
            margin-bottom: 0.8rem;
        }
        .featured-item i {
            color: #1a9988;
            margin-right: 10px;
        }
        
        /* Vehicle selection styles */
        .vehicle-options {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            margin-top: 1rem;
        }
        .vehicle-option {
            flex: 1;
            min-width: 140px;
            background-color: #fafafa;
            border: 2px solid #e1e5ee;
            border-radius: 10px;
            padding: 1.2rem 1rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .vehicle-option:hover {
            transform: translateY(-3px);
            border-color: #1a9988;
            box-shadow: 0 6px 15px rgba(26, 153, 136, 0.15);
        }
        .vehicle-option.active {
            background-color: #e0f7f5;
            border-color: #1a9988;
        }
        .vehicle-icon {
            font-size: 2rem;
            color: #1a9988;
            margin-bottom: 0.8rem;
        }
        .vehicle-name {
            font-weight: 600;
            color: #444;
            margin-bottom: 0.4rem;
        }
        .vehicle-capacity {
            font-size: 0.85rem;
            color: #777;
        }
    </style>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
</head>
<body>
    <?php include 'Komponen/navbar.php'; ?>
    <section class="hero">
        <div class="hero-content">
            <h1>Booking Paket Wisata</h1>
            <p>Lengkapi data berikut untuk melakukan reservasi paket wisata pilihan Anda dan nikmati perjalanan tak terlupakan bersama kami</p>
        </div>
    </section>

    <div class="booking-container">
        <div class="booking-form">
            <!-- Progress indicator -->
            <div class="booking-progress">
                <div class="progress-step active">
                    <div class="step-number">1</div>
                    <div class="step-label">Pilih Paket</div>
                </div>
                <div class="progress-line"></div>
                <div class="progress-step">
                    <div class="step-number">2</div>
                    <div class="step-label">Data Diri</div>
                </div>
                <div class="progress-line"></div>
                <div class="progress-step">
                    <div class="step-number">3</div>
                    <div class="step-label">Pembayaran</div>
                </div>
            </div>
            
            <h2>Detail Pemesanan</h2>
            <form>
                <div class="form-group">
                    <label for="package">
                        <i class="fas fa-suitcase"></i> Pilih Paket Wisata
                    </label>
                    <select id="package" name="package">
                        <option value="">-- Pilih Paket Wisata --</option>
                        <option value="bali-3d2n" selected>Ancol Taman Impian</option>
                        <option value="lombok-4d3n">Pantai Tanjung Kodok</option>
                        <option value="raja-ampat-5d4n">Wisata Bahari Lamongan</option>
                        <option value="bromo-2d1n">Taman Mini</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="guide">
                        <i class="fas fa-user-tie"></i> Pilih Tour Guide
                    </label>
                    <select id="guide" name="guide">
                        <option value="">-- Pilih Tour Guide --</option>
                        <option value="guide1" selected>Pak Wayan (Bahasa Indonesia & Inggris)</option>
                        <option value="guide2">Ibu Dewi (Bahasa Indonesia & Mandarin)</option>
                        <option value="guide3">Pak Ngurah (Bahasa Indonesia, Inggris & Jepang)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="accommodation">
                        <i class="fas fa-hotel"></i> Pilih Penginapan
                    </label>
                    <select id="accommodation" name="accommodation">
                        <option value="">-- Pilih Penginapan --</option>
                        <option value="hotel1" selected>The Dream Villa (⭐⭐⭐⭐)</option>
                        <option value="hotel2">Ubud Paradise Resort (⭐⭐⭐)</option>
                        <option value="hotel3">Kuta Luxury Villas (⭐⭐⭐⭐⭐)</option>
                    </select>
                </div>

                <!-- Start: Bagian Pemilihan Kendaraan -->
                <div class="form-group">
                    <label for="vehicles">
                        <i class="fas fa-car"></i> Pilih Jenis Kendaraan
                    </label>
                    <div class="vehicle-options">
                        <div class="vehicle-option active">
                            <div class="vehicle-icon">
                                <i class="fas fa-car"></i>
                            </div>
                            <div class="vehicle-name">Sedan</div>
                            <div class="vehicle-capacity">Kapasitas: 4 orang</div>
                        </div>
                        <div class="vehicle-option">
                            <div class="vehicle-icon">
                                <i class="fas fa-shuttle-van"></i>
                            </div>
                            <div class="vehicle-name">MPV</div>
                            <div class="vehicle-capacity">Kapasitas: 6-7 orang</div>
                        </div>
                        <div class="vehicle-option">
                            <div class="vehicle-icon">
                                <i class="fas fa-bus"></i>
                            </div>
                            <div class="vehicle-name">Mini Bus</div>
                            <div class="vehicle-capacity">Kapasitas: 12-15 orang</div>
                        </div>
                    </div>
                </div>
                <!-- End: Bagian Pemilihan Kendaraan -->

                <div class="form-row">
                    <div class="form-group">
                        <label for="checkin">
                            <i class="fas fa-calendar-plus"></i> Tanggal Berangkat
                        </label>
                        <input type="date" id="checkin" name="checkin">
                    </div>
                    <div class="form-group">
                        <label for="checkout">
                            <i class="fas fa-calendar-minus"></i> Tanggal Pulang
                        </label>
                        <input type="date" id="checkout" name="checkout">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="adult">
                            <i class="fas fa-user"></i> Dewasa
                        </label>
                        <div class="quantity-selector">
                            <button type="button" class="quantity-btn">-</button>
                            <input type="number" id="adult" name="adult" min="1" value="2" readonly>
                            <button type="button" class="quantity-btn">+</button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="child">
                            <i class="fas fa-child"></i> Anak-anak
                        </label>
                        <div class="quantity-selector">
                            <button type="button" class="quantity-btn">-</button>
                            <input type="number" id="child" name="child" min="0" value="0" readonly>
                            <button type="button" class="quantity-btn">+</button>
                        </div>
                    </div>
                </div>

                <div class="form-divider"></div>
                
                <h2>Data Pemesan</h2>
                <div class="form-group">
                    <label for="name">
                        <i class="fas fa-user-circle"></i> Nama Lengkap
                    </label>
                    <input type="text" id="name" name="name" placeholder="Masukkan nama lengkap sesuai KTP">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="email">
                            <i class="fas fa-envelope"></i> Email
                        </label>
                        <input type="email" id="email" name="email" placeholder="email@example.com">
                    </div>
                    <div class="form-group">
                        <label for="phone">
                            <i class="fas fa-phone-alt"></i> No. Telepon
                        </label>
                        <input type="tel" id="phone" name="phone" placeholder="08xxxxxxxxxx">
                    </div>
                </div>

                <div class="form-group">
                    <label for="address">
                        <i class="fas fa-map-marker-alt"></i> Alamat
                    </label>
                    <textarea id="address" name="address" placeholder="Masukkan alamat lengkap Anda"></textarea>
                </div>

                <div class="form-group">
                    <label for="notes">
                        <i class="fas fa-sticky-note"></i> Catatan Khusus
                    </label>
                    <textarea id="notes" name="notes" placeholder="Permintaan khusus, alergi makanan, dll"></textarea>
                </div>
            </form>
        </div>

        <div class="checkout-summary">
            <h2>Ringkasan Pemesanan</h2>
            <div class="package-details">
                <div style="position: relative;">
                    <img src="https://www.ancol.com/blog/wp-content/uploads/2022/03/wisata-aquarium-di-jakarta.jpg" alt="Paket Wisata Bali" class="package-image">
                    <span class="package-badge">Best Seller</span>
                </div>
                <div class="package-name">Ancol Taman Impian</div>
                <div class="package-description">
                    Nikmati keindahan Ancol dengan mengunjungi Pantai Ancol, Dunia Fantasi, SeaWorld, dan berbagai tempat menarik lainnya. Paket lengkap dengan akomodasi, transportasi, dan makan.
                </div>
                
                <!-- Featured highlights -->
                <div style="margin-bottom: 1.5rem;">
                    <div class="featured-item">
                        <i class="fas fa-calendar-alt"></i>
                        <span>3 Hari 2 Malam</span>
                    </div>
                    <div class="featured-item">
                        <i class="fas fa-utensils"></i>
                        <span>Termasuk Makan 3x Sehari</span>
                    </div>
                    <!-- Tambahan info kendaraan -->
                    <div class="featured-item">
                        <i class="fas fa-car"></i>
                        <span>Transportasi Sedan Pribadi</span>
                    </div>
                </div>
                
                <div class="package-includes">
                    <strong>Termasuk dalam Paket:</strong>
                    <ul>
                        <li>Transportasi selama tour</li>
                        <li>Makan 3x sehari</li>
                        <li>Tour guide profesional</li>
                        <li>Tiket masuk objek wisata</li>
                    </ul>
                </div>
            </div>

            <div class="price-details">
                <div class="price-row">
                    <span>Harga paket (per orang)</span>
                    <span>Rp 3.500.000</span>
                </div>
                <div class="price-row">
                    <span>Jumlah peserta (2 dewasa)</span>
                    <span>Rp 7.000.000</span>
                </div>
                <div class="price-row">
                    <span>Biaya Penginapan</span>
                    <span>Rp 7.000.000</span>
                </div>
                <div class="price-row">
                    <span>Biaya Tour Guide</span>
                    <span>Rp 7.000.000</span>
                </div>
                <!-- Tambahan biaya kendaraan -->
                <div class="price-row">
                    <span>Biaya Kendaraan (Sedan)</span>
                    <span>Rp 1.500.000</span>
                </div>
                <div class="price-row">
                    <span>Pajak & biaya layanan (10%)</span>
                    <span>Rp 700.000</span>
                </div>
                <div class="price-row price-total">
                    <span>Total Pembayaran</span>
                    <span>Rp 9.200.000</span>
                </div>
            </div>

            <div class="payment-methods">
                <h3><i class="fas fa-credit-card"></i> Metode Pembayaran</h3>
                <div class="payment-options">
                    <div class="payment-option active">Transfer Bank</div>
                    <div class="payment-option">E-Wallet</div>
                    <div class="payment-option">Kartu Kredit</div>
                </div>
            </div>

            <button class="booking-button">
                <i class="fas fa-lock"></i> Lanjutkan Pembayaran
            </button>
        </div>
    </div>
    
    <script>
        // Simple JavaScript for quantity buttons functionality
        document.addEventListener('DOMContentLoaded', function() {
            const quantityButtons = document.querySelectorAll('.quantity-btn');
            
            quantityButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const input = this.parentNode.querySelector('input');
                    const currentValue = parseInt(input.value);
                    const min = parseInt(input.getAttribute('min'));
                    
                    if (this.textContent === '+') {
                        input.value = currentValue + 1;
                    } else if (this.textContent === '-' && currentValue > min) {
                        input.value = currentValue - 1;
                    }
                });
            });
            
            // JavaScript untuk opsi kendaraan
            const vehicleOptions = document.querySelectorAll('.vehicle-option');
            
            vehicleOptions.forEach(option => {
                option.addEventListener('click', function() {
                    // Hapus kelas 'active' dari semua opsi
                    vehicleOptions.forEach(opt => opt.classList.remove('active'));
                    // Tambahkan kelas 'active' ke opsi yang diklik
                    this.classList.add('active');
                });
            });
        });
    </script>
</body>
</html>
