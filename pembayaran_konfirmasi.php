<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Booking - GoTravel</title>
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
        
        .hero {
            height: 280px;
            background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('https://www.ancol.com/blog/wp-content/uploads/2022/03/wisata-aquarium-di-jakarta.jpg');
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
            height: 80px;
            background: linear-gradient(to top, #f8f9fa, transparent);
        }
        .hero-content {
            z-index: 1;
            max-width: 800px;
            padding: 0 20px;
        }
        .hero h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        .hero p {
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }
        
        .confirmation-container {
            max-width: 900px;
            margin: -40px auto 50px;
            padding: 0 2rem;
            position: relative;
            z-index: 2;
        }
        
        .confirmation-card {
            background-color: white;
            padding: 2.5rem;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            margin-bottom: 2rem;
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
            background-color: #1a9988;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: bold;
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 1;
        }
        .progress-step.completed .step-number {
            background-color: #158677;
        }
        .step-label {
            font-size: 0.9rem;
            color: #1a9988;
            font-weight: 600;
        }
        .progress-line {
            height: 3px;
            background-color: #1a9988;
            flex-grow: 1;
            margin: 0 8px;
            transform: translateY(-16px);
        }
        
        .section-title {
            color: #1a9988;
            margin-bottom: 1.8rem;
            font-size: 1.8rem;
            position: relative;
            padding-bottom: 10px;
        }
        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 4px;
            background-color: #1a9988;
            border-radius: 2px;
        }
        
        .success-message {
            text-align: center;
            margin-bottom: 2rem;
        }
        .success-icon {
            font-size: 3rem;
            color: #1a9988;
            margin-bottom: 1rem;
            display: inline-block;
            padding: 1rem;
            background-color: #e0f7f5;
            border-radius: 50%;
            width: 100px;
            height: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .success-title {
            font-size: 1.8rem;
            color: #333;
            margin-bottom: 0.5rem;
        }
        .success-subtitle {
            color: #666;
            font-size: 1.1rem;
        }
        
        .booking-details {
            background-color: #f8f9fa;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
        .booking-id {
            font-size: 1.3rem;
            font-weight: 600;
            color: #1a9988;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px dashed #ccc;
            text-align: center;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #eee;
        }
        .detail-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        .detail-label {
            font-weight: 500;
            color: #555;
        }
        .detail-value {
            font-weight: 600;
            color: #333;
            text-align: right;
        }
        
        .traveler-details {
            margin-bottom: 2rem;
        }
        .traveler-card {
            background-color: #f8f9fa;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1rem;
        }
        .traveler-header {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #eee;
        }
        .traveler-icon {
            width: 40px;
            height: 40px;
            background-color: #1a9988;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
        }
        .traveler-title {
            font-weight: 600;
            font-size: 1.1rem;
        }
        .traveler-info {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
        }
        .traveler-info-item {
            margin-bottom: 0.5rem;
        }
        .info-label {
            font-size: 0.85rem;
            color: #666;
            margin-bottom: 0.2rem;
        }
        .info-value {
            font-weight: 500;
            color: #333;
        }
        
        .package-details {
            margin-bottom: 2rem;
        }
        .package-card {
            background-color: #f8f9fa;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1rem;
        }
        .package-header {
            display: flex;
            margin-bottom: 1.5rem;
        }
        .package-image {
            width: 100px;
            height: 100px;
            border-radius: 10px;
            object-fit: cover;
            margin-right: 1.5rem;
        }
        .package-info h3 {
            font-size: 1.3rem;
            margin-bottom: 0.5rem;
            color: #333;
        }
        .package-info p {
            color: #666;
            margin-bottom: 0.3rem;
        }
        .package-features {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }
        .feature-item {
            display: flex;
            align-items: center;
        }
        .feature-icon {
            color: #1a9988;
            margin-right: 0.5rem;
            font-size: 1.1rem;
        }
        .feature-text {
            font-size: 0.9rem;
            color: #555;
        }
        
        .payment-info {
            margin-bottom: 2rem;
        }
        .payment-box {
            background-color: #f8f9fa;
            border-radius: 12px;
            padding: 1.5rem;
        }
        .payment-method {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #eee;
        }
        .payment-icon {
            font-size: 1.5rem;
            color: #1a9988;
            margin-right: 1rem;
            width: 30px;
        }
        .payment-name {
            font-weight: 600;
        }
        .payment-details {
            margin-top: 1rem;
        }
        .payment-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.8rem;
        }
        .payment-item:last-child {
            margin-bottom: 0;
        }
        .payment-label {
            color: #666;
        }
        .payment-value {
            font-weight: 500;
            color: #333;
        }
        .payment-total {
            display: flex;
            justify-content: space-between;
            font-size: 1.2rem;
            font-weight: bold;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 2px dashed #1a9988;
        }
        .payment-total .payment-value {
            color: #1a9988;
        }
        
        .info-alert {
            background-color: #e0f7f5;
            padding: 1.5rem;
            border-radius: 10px;
            margin-bottom: 2rem;
            border-left: 4px solid #1a9988;
        }
        .info-alert-header {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }
        .info-alert-header i {
            color: #1a9988;
            margin-right: 0.8rem;
            font-size: 1.2rem;
        }
        .info-alert-header h3 {
            color: #1a9988;
            font-size: 1.1rem;
            font-weight: 600;
        }
        .info-alert-content {
            color: #555;
            font-size: 0.95rem;
        }
        .info-alert-content p {
            margin-bottom: 0.8rem;
        }
        .info-alert-content p:last-child {
            margin-bottom: 0;
        }
        
        .voucher-box {
            border: 2px dashed #1a9988;
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            margin-bottom: 2rem;
        }
        .voucher-title {
            color: #1a9988;
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        .voucher-buttons {
            display: flex;
            justify-content: center;
            gap: 1rem;
        }
        
        .action-buttons {
            display: flex;
            gap: 1rem;
        }
        .btn {
            flex: 1;
            padding: 1.2rem;
            border: none;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            text-align: center;
            display: inline-block;
        }
        .btn-primary {
            background-color: #1a9988;
            color: white;
            box-shadow: 0 4px 12px rgba(26, 153, 136, 0.3);
        }
        .btn-primary:hover {
            background-color: #158677;
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(26, 153, 136, 0.4);
        }
        .btn-secondary {
            background-color: #f8f9fa;
            color: #1a9988;
            border: 2px solid #1a9988;
        }
        .btn-secondary:hover {
            background-color: #e0f7f5;
            transform: translateY(-3px);
        }
        .btn-outline {
            background-color: transparent;
            color: #1a9988;
            border: 1px solid #1a9988;
            padding: 0.8rem 1.5rem;
            font-size: 1rem;
        }
        .btn-outline:hover {
            background-color: #e0f7f5;
        }
        
        .contact-card {
            background-color: #f8f9fa;
            border-radius: 12px;
            padding: 1.5rem;
            margin: 1rem 0 2rem;
            text-align: center;
        }
        .contact-title {
            font-size: 1.1rem;
            color: #333;
            margin-bottom: 1rem;
        }
        .contact-options {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin-bottom: 1rem;
        }
        .contact-option {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .contact-icon {
            width: 50px;
            height: 50px;
            background-color: #e0f7f5;
            color: #1a9988;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            margin-bottom: 0.5rem;
        }
        .contact-label {
            font-size: 0.9rem;
            color: #666;
        }
        .contact-value {
            font-weight: 600;
            color: #333;
        }
        
        .itinerary-preview {
            margin-top: 2rem;
        }
        .day-card {
            background-color: #f8f9fa;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1rem;
        }
        .day-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #eee;
        }
        .day-title {
            font-weight: 600;
            font-size: 1.1rem;
            color: #1a9988;
        }
        .day-date {
            color: #666;
        }
        .activity-item {
            display: flex;
            margin-bottom: 1rem;
        }
        .activity-time {
            width: 80px;
            color: #1a9988;
            font-weight: 500;
        }
        .activity-content {
            flex: 1;
        }
        .activity-title {
            font-weight: 500;
            margin-bottom: 0.3rem;
        }
        .activity-description {
            color: #666;
            font-size: 0.95rem;
        }
        
        .qr-container {
            text-align: center;
            padding: 1rem;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            width: 160px;
            margin: 0 auto;
        }
        .qr-code {
            width: 120px;
            height: 120px;
            margin-bottom: 0.5rem;
        }
        .qr-text {
            font-size: 0.8rem;
            color: #666;
        }
        
        /* Responsive design */
        @media (max-width: 768px) {
            .action-buttons {
                flex-direction: column;
            }
            .voucher-buttons {
                flex-direction: column;
            }
            .contact-options {
                flex-direction: column;
                gap: 1rem;
            }
            .traveler-info {
                grid-template-columns: 1fr;
            }
            .package-features {
                grid-template-columns: 1fr;
            }
            .package-header {
                flex-direction: column;
            }
            .package-image {
                margin-right: 0;
                margin-bottom: 1rem;
                width: 100%;
                height: 180px;
            }
        }
    </style>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
</head>
<body>
    <!-- Navbar would be included here -->
    <?php include 'Komponen/navbar.php'; ?>
    
    <section class="hero">
        <div class="hero-content">
            <h1>Konfirmasi Booking</h1>
            <p>Booking Anda telah berhasil! Berikut adalah detail perjalanan Anda</p>
        </div>
    </section>

    <div class="confirmation-container">
        <div class="confirmation-card">
            <!-- Progress indicator -->
            <div class="booking-progress">
                <div class="progress-step active">
                    <div class="step-number">1</div>
                    <div class="step-label">Pilihan Paket & Data Diri</div>
                </div>
                <div class="progress-line"></div>
                <div class="progress-step active">
                    <div class="step-number">2</div>
                    <div class="step-label">Pembayaran</div>
                </div>
                <div class="progress-line"></div>
                <div class="progress-step active">
                    <div class="step-number">3</div>
                    <div class="step-label">Konfirmasi</div>
                </div>
            </div>
            
            <div class="success-message">
                <!-- <div class="success-icon">
                    <i class="fas fa-check"></i>
                </div> -->
                <h2 class="success-title">Booking Berhasil!</h2>
                <p class="success-subtitle">Terima kasih telah memilih GoTravel untuk perjalanan Anda</p>
            </div>
            
            <div class="booking-details">
                <div class="booking-id">
                    Kode Booking: <strong>GT245789</strong>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Status Booking</div>
                    <div class="detail-value">
                        <span style="color: #2ecc71;">
                            <i class="fas fa-check-circle"></i> Terkonfirmasi
                        </span>
                    </div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Tanggal Booking</div>
                    <div class="detail-value">19 Mei 2025, 14:30 WIB</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Jadwal Perjalanan</div>
                    <div class="detail-value">25 - 27 Mei 2025</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Jumlah Peserta</div>
                    <div class="detail-value">2 Orang Dewasa</div>
                </div>
            </div>
            
            <div class="voucher-box">
                <h3 class="voucher-title">E-Voucher Perjalanan Anda</h3>
                <p>Tunjukkan e-voucher ini saat check-in di hotel dan aktivitas wisata</p>
                <div class="qr-container">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/d/d0/QR_code_for_mobile_English_Wikipedia.svg" alt="QR Code" class="qr-code">
                    <div class="qr-text">GT245789</div>
                </div>
                <div class="voucher-buttons" style="margin-top: 1.5rem;">
                    <button class="btn btn-outline">
                        <i class="fas fa-download"></i> Unduh E-Voucher
                    </button>
                    <button class="btn btn-outline">
                        <i class="fas fa-envelope"></i> Kirim ke Email
                    </button>
                </div>
            </div>
            
            <div class="info-alert">
                <div class="info-alert-header">
                    <i class="fas fa-info-circle"></i>
                    <h3>Informasi Penting</h3>
                </div>
                <div class="info-alert-content">
                    <p>Detail perjalanan lengkap dan e-voucher telah dikirim ke email Anda. Jika dalam 1 jam belum menerima, silakan periksa folder spam atau hubungi customer service kami.</p>
                    <p>Pastikan untuk membawa identitas diri (KTP/Paspor) yang sama dengan data booking saat check-in.</p>
                </div>
            </div>
            
            <h2 class="section-title">Detail Paket Wisata</h2>
            
            <div class="package-details">
                <div class="package-card">
                    <div class="package-header">
                        <img src="https://www.ancol.com/blog/wp-content/uploads/2022/03/wisata-aquarium-di-jakarta.jpg" alt="Ancol" class="package-image">
                        <div class="package-info">
                            <h3>Ancol Taman Impian</h3>
                            <p><i class="fas fa-calendar-alt"></i> 3 Hari 2 Malam (25 - 27 Mei 2025)</p>
                            <p><i class="fas fa-users"></i> 2 Orang Dewasa</p>
                            <p><i class="fas fa-map-marker-alt"></i> Jakarta Utara, Indonesia</p>
                        </div>
                    </div>
                    <div class="package-features">
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-hotel"></i>
                            </div>
                            <div class="feature-text">
                                Hotel Bintang 4
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-utensils"></i>
                            </div>
                            <div class="feature-text">
                                Termasuk Sarapan
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-ticket-alt"></i>
                            </div>
                            <div class="feature-text">
                                Semua Tiket Masuk
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-car"></i>
                            </div>
                            <div class="feature-text">
                                Transportasi Sedan
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <div class="feature-text">
                                Tour Guide Berpengalaman
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-camera"></i>
                            </div>
                            <div class="feature-text">
                                Foto Dokumentasi
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="itinerary-preview">
                <h3 style="margin-bottom: 1rem; color: #333;">Preview Itinerary:</h3>
                <div class="day-card">
                    <div class="day-header">
                        <div class="day-title">Hari 1</div>
                        <div class="day-date">25 Mei 2025</div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-time">08:00</div>
                        <div class="activity-content">
                            <div class="activity-title">Check-in Hotel</div>
                            <div class="activity-description">Penjemputan di lokasi dan check-in di Grand Ancol Hotel</div>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-time">10:00</div>
                        <div class="activity-content">
                            <div class="activity-title">Kunjungan Seaworld</div>
                            <div class="activity-description">Menikmati keindahan dunia bawah laut di Seaworld Ancol</div>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-time">13:00</div>
                        <div class="activity-content">
                            <div class="activity-title">Makan Siang</div>
                            <div class="activity-description">Makan siang di Restoran Pantai Ancol</div>
                        </div>
                    </div>
                    <div style="text-align: center; margin-top: 1rem;">
                        <a href="#" style="color: #1a9988; text-decoration: none;">Lihat Itinerary Lengkap <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            
            <h2 class="section-title">Detail Traveler</h2>
            
            <div class="traveler-details">
                <div class="traveler-card">
                    <div class="traveler-header">
                        <div class="traveler-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="traveler-title">Traveler Utama</div>
                    </div>
                    <div class="traveler-info">
                        <div class="traveler-info-item">
                            <div class="info-label">Nama Lengkap</div>
                            <div class="info-value">Ahmad Santoso</div>
                        </div>
                        <div class="traveler-info-item">
                            <div class="info-label">No. Identitas</div>
                            <div class="info-value">3271046801950002</div>
                        </div>
                        <div class="traveler-info-item">
                            <div class="info-label">Email</div>
                            <div class="info-value">ahmad.santoso@email.com</div>
                        </div>
                        <div class="traveler-info-item">
                            <div class="info-label">No. Telepon</div>
                            <div class="info-value">+62812-3456-7890</div>
                        </div>
                    </div>
                </div>
                
                <div class="traveler-card">
                    <div class="traveler-header">
                        <div class="traveler-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="traveler-title">Traveler 2</div>
                    </div>
                    <div class="traveler-info">
                        <div class="traveler-info-item">
                            <div class="info-label">Nama Lengkap</div>
                            <div class="info-value">Sinta Dewi</div>
                        </div>
                        <div class="traveler-info-item">
                            <div class="info-label">No. Identitas</div>
                            <div class="info-value">3271046801950003</div>
                        </div>
                        <div class="traveler-info-item">
                            <div class="info-label">Email</div>
                            <div class="info-value">-</div>
                        </div>
                        <div class="traveler-info-item">
                            <div class="info-label">No. Telepon</div>
                            <div class="info-value">+62823-4567-8901</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <h2 class="section-title">Detail Pembayaran</h2>
            
            <div class="payment-info">
                <div class="payment-box">
                    <div class="payment-method">
                        <div class="payment-icon">
                            <i class="fas fa-credit-card"></i>
                        </div>
                        <div>
                            <div class="payment-name">Bank Transfer - BCA</div>
                            <div style="color: #666;">Dibayar pada 19 Mei 2025, 14:25 WIB</div>
                        </div>
                    </div>
                    <div class="payment-details">
                        <div class="payment-item">
                            <div class="payment-label">Paket Wisata (2 Orang)</div>
                            <div class="payment-value">Rp 320.000</div>
                        </div>
                        <div class="payment-item">
                            <div class="payment-label">Penginapan</div>
                            <div class="payment-value">Rp 1.000.000</div>
                        </div>
                        <div class="payment-item">
                            <div class="payment-label">Tour Guide</div>
                            <div class="payment-value">Rp 500.000</div>
                        </div>
                        <div class="payment-item">
                            <div class="payment-label">Transportasi (Sedan)</div>
                            <div class="payment-value">Rp 1.000.000</div>
                        </div>
                        <div class="payment-item">
                            <div class="payment-label">Pajak & Biaya Layanan</div>
                            <div class="payment-value">Rp 282.000</div>
                        </div>
                        <div class="payment-item">
                            <div class="payment-label">Biaya Admin</div>
                            <div class="payment-value">Rp 0</div>
                        </div>
                        <div class="payment-total">
                            <div class="payment-label">Total Pembayaran</div>
                            <div class="payment-value">Rp 3.102.000</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="contact-card">
                <h3 class="contact-title">Butuh Bantuan?</h3>
                <div class="contact-options">
                    <div class="contact-option">
                        <div class="contact-icon">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div class="contact-label">Customer Service</div>
                        <div class="contact-value">+62 21-5050-5050</div>
                    </div>
                    <div class="contact-option">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="contact-label">Email Support</div>
                        <div class="contact-value">cs@gotravel.com</div>
                    </div>
                    <div class="contact-option">
                        <div class="contact-icon">
                            <i class="fab fa-whatsapp"></i>
                        </div>
                        <div class="contact-label">WhatsApp</div>
                        <div class="contact-value">+62 812-9999-8888</div>
                    </div>
                </div>
            </div>
            
            <h2 class="section-title">Kebijakan Pembatalan</h2>
            
            <div class="info-alert" style="background-color: #fff3e0; border-left-color: #ff9800;">
                <div class="info-alert-header">
                    <i class="fas fa-exclamation-circle" style="color: #ff9800;"></i>
                    <h3 style="color: #ff9800;">Syarat & Ketentuan</h3>
                </div>
                <div class="info-alert-content">
                    <p>• Pembatalan 7 hari atau lebih sebelum keberangkatan: pengembalian dana 80%</p>
                    <p>• Pembatalan 3-6 hari sebelum keberangkatan: pengembalian dana 50%</p>
                    <p>• Pembatalan kurang dari 3 hari sebelum keberangkatan: tidak ada pengembalian dana</p>
                    <p>• Perubahan tanggal dapat dilakukan minimal 7 hari sebelum keberangkatan dengan biaya administrasi Rp 150.000 per orang</p>
                </div>
            </div>
            
            <div class="action-buttons">
                <a href="index.php" class="btn btn-secondary">
                    <i class="fas fa-home"></i> Kembali ke Beranda
                </a>
                <a href="akun-saya/riwayat-perjalanan.php" class="btn btn-primary">
                    <i class="fas fa-history"></i> Lihat Riwayat Booking
                </a>
            </div>
        </div>
    </div>
    
    <!-- Footer would be included here -->
    <?php include 'Komponen/footer.php'; ?>
    
    <script>
        // JavaScript for any interactive elements
        document.addEventListener('DOMContentLoaded', function() {
            // Example: Add countdown for limited time offers
            const countdownElement = document.getElementById('countdown');
            if (countdownElement) {
                let timeLeft = 24 * 60 * 60; // 24 hours in seconds
                
                const updateCountdown = () => {
                    const hours = Math.floor(timeLeft / 3600);
                    const minutes = Math.floor((timeLeft % 3600) / 60);
                    const seconds = timeLeft % 60;
                    
                    countdownElement.textContent = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                    
                    if (timeLeft <= 0) {
                        clearInterval(countdownInterval);
                        countdownElement.parentElement.style.display = 'none';
                    }
                    
                    timeLeft--;
                };
                
                updateCountdown();
                const countdownInterval = setInterval(updateCountdown, 1000);
            }
        });
    </script>
</body>
</html>