
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - GoTravel</title>
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
        
        .payment-container {
            max-width: 1200px;
            margin: -40px auto 50px;
            padding: 0 2rem;
            display: flex;
            gap: 2rem;
            flex-wrap: wrap;
            position: relative;
            z-index: 2;
        }
        
        .payment-form {
            flex: 2;
            min-width: 320px;
            background-color: white;
            padding: 2.5rem;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }
        
        .order-summary {
            flex: 1;
            min-width: 320px;
            background-color: white;
            padding: 2.5rem;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
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
        .progress-step:not(.active):not(.completed) .step-number {
            background-color: #e0f7f5;
            color: #1a9988;
        }
        .step-label {
            font-size: 0.9rem;
            color: #1a9988;
            font-weight: 600;
        }
        .progress-step:not(.active):not(.completed) .step-label {
            color: #777;
            font-weight: 500;
        }
        .progress-line {
            height: 3px;
            background-color: #1a9988;
            flex-grow: 1;
            margin: 0 8px;
            transform: translateY(-16px);
        }
        .progress-step:not(.active):not(.completed) + .progress-step .progress-line,
        .progress-step:not(.completed) .progress-line {
            background-color: #e0f7f5;
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
        
        /* Payment method selection */
        .payment-methods {
            margin-bottom: 2rem;
        }
        .payment-method {
            border: 2px solid #e1e5ee;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }
        .payment-method:hover {
            border-color: #1a9988;
            box-shadow: 0 4px 12px rgba(26, 153, 136, 0.1);
        }
        .payment-method.active {
            border-color: #1a9988;
            background-color: #f0f9f8;
        }
        .payment-method.active::before {
            content: '✓';
            position: absolute;
            right: 15px;
            top: 15px;
            background-color: #1a9988;
            color: white;
            width: 25px;
            height: 25px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            font-weight: bold;
        }
        .payment-header {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }
        .payment-icon {
            font-size: 1.5rem;
            color: #1a9988;
            margin-right: 1rem;
            width: 30px;
        }
        .payment-name {
            font-weight: 600;
            font-size: 1.1rem;
            color: #333;
        }
        .payment-description {
            color: #666;
            font-size: 0.9rem;
            margin-left: 46px;
        }
        
        /* Payment details form */
        .payment-details {
            margin-top: 2rem;
            padding: 1.5rem;
            background-color: #fafafa;
            border-radius: 10px;
            border: 1px dashed #ddd;
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
        .form-group input {
            width: 100%;
            padding: 1rem;
            border: 1.5px solid #e1e5ee;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: white;
        }
        .form-group input:focus {
            outline: none;
            border-color: #1a9988;
            box-shadow: 0 0 0 4px rgba(26, 153, 136, 0.1);
        }
        .form-row {
            display: flex;
            gap: 1rem;
        }
        .form-row .form-group {
            flex: 1;
        }
        
        /* Transfer details */
        .transfer-info {
            background-color: #e0f7f5;
            padding: 1.5rem;
            border-radius: 10px;
            margin-top: 1rem;
        }
        .bank-details {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }
        .bank-info {
            font-weight: 600;
            color: #1a9988;
        }
        .copy-btn {
            background-color: #1a9988;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }
        .copy-btn:hover {
            background-color: #158677;
        }
        
        /* Order summary styles */
        .booking-summary {
            margin-bottom: 2rem;
        }
        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #f0f0f0;
        }
        .summary-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }
        .summary-label {
            color: #666;
            font-size: 0.95rem;
        }
        .summary-value {
            font-weight: 500;
            color: #333;
        }
        .total-amount {
            font-size: 1.4rem;
            font-weight: bold;
            color: #1a9988;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 2px dashed #1a9988;
        }
        
        /* Package card mini */
        .package-mini {
            background-color: #f8f9fa;
            padding: 1.2rem;
            border-radius: 10px;
            margin-bottom: 2rem;
        }
        .package-mini-header {
            display: flex;
            align-items: center;
            margin-bottom: 0.8rem;
        }
        .package-mini-image {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            object-fit: cover;
            margin-right: 1rem;
        }
        .package-mini-info h3 {
            color: #333;
            font-size: 1.1rem;
            margin-bottom: 0.3rem;
        }
        .package-mini-info p {
            color: #666;
            font-size: 0.9rem;
        }
        
        /* Security info */
        .security-info {
            background-color: #f0f9f8;
            padding: 1.2rem;
            border-radius: 10px;
            margin-bottom: 2rem;
            border-left: 4px solid #1a9988;
        }
        .security-header {
            display: flex;
            align-items: center;
            margin-bottom: 0.8rem;
        }
        .security-header i {
            color: #1a9988;
            margin-right: 0.8rem;
            font-size: 1.2rem;
        }
        .security-header h3 {
            color: #1a9988;
            font-size: 1rem;
        }
        .security-list {
            list-style: none;
            padding-left: 0;
        }
        .security-list li {
            color: #555;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
            position: relative;
            padding-left: 1.5rem;
        }
        .security-list li::before {
            content: '✓';
            position: absolute;
            left: 0;
            color: #1a9988;
            font-weight: bold;
        }
        
        /* Action buttons */
        .action-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
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
            background-color: #1a9988;
            color: white;
            transform: translateY(-3px);
        }
        
        /* Timer */
        .payment-timer {
            background-color: #fff3cd;
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 2rem;
            border: 1px solid #ffeaa7;
            text-align: center;
        }
        .timer-text {
            color: #f39c12;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        .timer-value {
            font-size: 1.5rem;
            font-weight: bold;
            color: #e67e22;
        }
        
        /* E-wallet options */
        .ewallet-options {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }
        .ewallet-option {
            text-align: center;
            padding: 1rem;
            border: 2px solid #e1e5ee;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .ewallet-option:hover,
        .ewallet-option.selected {
            border-color: #1a9988;
            background-color: #f0f9f8;
        }
        .ewallet-logo {
            height: 40px;
            margin-bottom: 0.5rem;
        }
        .ewallet-name {
            font-size: 0.9rem;
            font-weight: 500;
            color: #333;
        }
        
        /* Responsive design */
        @media (max-width: 768px) {
            .payment-container {
                flex-direction: column;
            }
            .action-buttons {
                flex-direction: column;
            }
            .form-row {
                flex-direction: column;
            }
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
            <h1>Pembayaran</h1>
            <p>Selesaikan pembayaran untuk konfirmasi booking paket wisata Anda</p>
        </div>
    </section>

    <div class="payment-container">
        <div class="payment-form">
            <!-- Progress indicator -->
            <div class="booking-progress">
                <div class="progress-step completed">
                    <div class="step-number">1</div>
                    <div class="step-label">Pilih Paket</div>
                </div>
                <div class="progress-line"></div>
                <div class="progress-step completed">
                    <div class="step-number">2</div>
                    <div class="step-label">Data Diri</div>
                </div>
                <div class="progress-line"></div>
                <div class="progress-step active">
                    <div class="step-number">3</div>
                    <div class="step-label">Pembayaran</div>
                </div>
                <div class="progress-line"></div>
                <div class="progress-step completed">
                    <div class="step-number">4</div>
                    <div class="step-label">Konfirmasi</div>
                </div>
            </div>
            
            <!-- Payment timer -->
            <div class="payment-timer">
                <div class="timer-text">Selesaikan pembayaran dalam:</div>
                <div class="timer-value" id="countdown">23:45:12</div>
            </div>
            
            <h2 class="section-title">Pilih Metode Pembayaran</h2>
            
            <!-- Transfer Bank -->
            <div class="payment-method active" data-method="transfer">
                <div class="payment-header">
                    <div class="payment-icon">
                        <i class="fas fa-university"></i>
                    </div>
                    <div class="payment-name">Transfer Bank</div>
                </div>
                <div class="payment-description">
                    Transfer langsung ke rekening bank kami. Konfirmasi otomatis dalam 1-3 jam kerja.
                </div>
                <div class="transfer-info" id="transferDetails">
                    <div class="bank-details">
                        <div>
                            <div class="bank-info">Bank Mandiri</div>
                            <div>No. Rek: 1570-0000-1234-567</div>
                            <div>a.n PT GoTravel Indonesia</div>
                        </div>
                        <button class="copy-btn" onclick="copyToClipboard('1570000012345674')">
                            <i class="fas fa-copy"></i> Salin
                        </button>
                    </div>
                    <div style="margin-top: 1rem;">
                        <strong>Nominal Transfer: Rp 3.102.123</strong><br>
                        <small style="color: #666;">*Tambahkan 3 digit unik (123) untuk verifikasi otomatis</small>
                    </div>
                </div>
            </div>
            
            <!-- E-Wallet -->
            <div class="payment-method" data-method="ewallet">
                <div class="payment-header">
                    <div class="payment-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <div class="payment-name">E-Wallet</div>
                </div>
                <div class="payment-description">
                    Bayar dengan aplikasi dompet digital favorit Anda.
                </div>
                <div class="ewallet-options" id="ewalletOptions" style="display: none;">
                    <div class="ewallet-option" data-ewallet="dana">
                        <img src="/api/placeholder/80/40" alt="DANA" class="ewallet-logo">
                        <div class="ewallet-name">DANA</div>
                    </div>
                    <div class="ewallet-option" data-ewallet="gopay">
                        <img src="/api/placeholder/80/40" alt="GoPay" class="ewallet-logo">
                        <div class="ewallet-name">GoPay</div>
                    </div>
                    <div class="ewallet-option" data-ewallet="ovo">
                        <img src="/api/placeholder/80/40" alt="OVO" class="ewallet-logo">
                        <div class="ewallet-name">OVO</div>
                    </div>
                    <div class="ewallet-option" data-ewallet="shopeepay">
                        <img src="/api/placeholder/80/40" alt="ShopeePay" class="ewallet-logo">
                        <div class="ewallet-name">ShopeePay</div>
                    </div>
                </div>
            </div>
            
            <!-- Credit Card -->
            <div class="payment-method" data-method="creditcard">
                <div class="payment-header">
                    <div class="payment-icon">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <div class="payment-name">Kartu Kredit/Debit</div>
                </div>
                <div class="payment-description">
                    Pembayaran aman dengan kartu kredit atau debit Visa/Mastercard.
                </div>
                <div class="payment-details" id="cardDetails" style="display: none;">
                    <div class="form-group">
                        <label for="cardNumber">
                            <i class="fas fa-credit-card"></i> Nomor Kartu
                        </label>
                        <input type="text" id="cardNumber" placeholder="1234 5678 9012 3456" maxlength="19">
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="expiry">Exp. Date</label>
                            <input type="text" id="expiry" placeholder="MM/YY" maxlength="5">
                        </div>
                        <div class="form-group">
                            <label for="cvv">CVV</label>
                            <input type="text" id="cvv" placeholder="123" maxlength="3">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="cardName">Nama Pemegang Kartu</label>
                        <input type="text" id="cardName" placeholder="Nama sesuai dengan kartu">
                    </div>
                </div>
            </div>
            
            <!-- Action buttons -->
            <div class="action-buttons">
                <a href="#" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <button class="btn btn-primary" onclick="processPayment()">
                    <i class="fas fa-lock"></i> <a href="booking_confirmation.php" style="text-decoration:none; color:#FFFF">Bayar Sekarang</a>
                </button>
            </div>
        </div>
        
        <div class="order-summary">
            <h2 class="section-title">Ringkasan Pesanan</h2>
            
            <!-- Package mini card -->
            <div class="package-mini">
                <div class="package-mini-header">
                    <img src="https://www.ancol.com/blog/wp-content/uploads/2022/03/wisata-aquarium-di-jakarta.jpg" alt="Ancol" class="package-mini-image">
                    <div class="package-mini-info">
                        <h3>Ancol Taman Impian</h3>
                        <p>3 Hari 2 Malam • 2 Dewasa</p>
                    </div>
                </div>
            </div>
            
            <!-- Booking summary -->
            <div class="booking-summary">
                <div class="summary-item">
                    <span class="summary-label">Paket Wisata</span>
                    <span class="summary-value">Rp 320.000</span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Penginapan</span>
                    <span class="summary-value">Rp 1.000.000</span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Tour Guide</span>
                    <span class="summary-value">Rp 500.000</span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Transportasi (Sedan)</span>
                    <span class="summary-value">Rp 1.000.000</span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Pajak & Biaya Layanan</span>
                    <span class="summary-value">Rp 282.000</span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Biaya Admin</span>
                    <span class="summary-value">Rp 0</span>
                </div>
            </div>
            
            <div class="total-amount">
                <div style="display: flex; justify-content: space-between;">
                    <span>Total Pembayaran</span>
                    <span>Rp 3.102.000</span>
                </div>
            </div>
            
        </div>
    </div>
    <?php include 'Komponen/footer.php'; ?>
    <script>
        // Payment method selection
        document.addEventListener('DOMContentLoaded', function() {
            const paymentMethods = document.querySelectorAll('.payment-method');
            
            paymentMethods.forEach(method => {
                method.addEventListener('click', function() {
                    // Remove active class from all methods
                    paymentMethods.forEach(m => m.classList.remove('active'));
                    // Add active class to clicked method
                    this.classList.add('active');
                    
                    // Hide all payment details
                    document.getElementById('transferDetails').style.display = 'none';
                    document.getElementById('ewalletOptions').style.display = 'none';
                    document.getElementById('cardDetails').style.display = 'none';
                    
                    // Show relevant payment details
                    const methodType = this.getAttribute('data-method');
                    if (methodType === 'transfer') {
                        document.getElementById('transferDetails').style.display = 'block';
                    } else if (methodType === 'ewallet') {
                        document.getElementById('ewalletOptions').style.display = 'grid';
                    } else if (methodType === 'creditcard') {
                        document.getElementById('cardDetails').style.display = 'block';
                    }
                });
            });
            
            // E-wallet selection
            const ewalletOptions = document.querySelectorAll('.ewallet-option');
            ewalletOptions.forEach(option => {
                option.addEventListener('click', function() {
                    ewalletOptions.forEach(opt => opt.classList.remove('selected'));
                    this.classList.add('selected');
                });
            });
            
            // Card number formatting
            const cardNumberInput = document.getElementById('cardNumber');
            if (cardNumberInput) {
                cardNumberInput.addEventListener('input', function() {
                    let value = this.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
                    let formatedValue = value.match(/.{1,4}/g)?.join(' ') || value;
                    this.value = formatedValue;
                });
            }
            
            // Expiry date formatting
            const expiryInput = document.getElementById('expiry');
            if (expiryInput) {
                expiryInput.addEventListener('input', function() {
                    let value = this.value.replace(/\D/g, '');
                    if (value.length >= 2) {
                        value = value.substring(0, 2) + '/' + value.substring(2, 4);
                    }
                    this.value = value;
                });
            }
            
            // CVV input restriction
            const cvvInput = document.getElementById('cvv');
            if (cvvInput) {
                cvvInput.addEventListener('input', function() {
                    this.value = this.value.replace(/\D/g, '');
                });
            }
        });
        
        // Countdown timer
        function startCountdown() {
            let timeLeft = 24 * 60 * 60 - 15 *             // 60 - 48; // Total 24 hours minus 15 minutes 48 seconds
            let timeLeft = 23 * 3600 + 45 * 60 + 12; // 23:45:12 in seconds
            const countdownElement = document.getElementById('countdown');
            
            const timerInterval = setInterval(() => {
                const hours = Math.floor(timeLeft / 3600);
                const minutes = Math.floor((timeLeft % 3600) / 60);
                const seconds = timeLeft % 60;
                
                countdownElement.textContent = 
                    `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
                
                if (timeLeft <= 0) {
                    clearInterval(timerInterval);
                    alert('Waktu pembayaran telah habis! Silakan lakukan pemesanan ulang.');
                    window.location.reload();
                }
                timeLeft--;
            }, 1000);
        }
        
        // Clipboard copy function
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text)
                .then(() => alert('Nomor rekening berhasil disalin!'))
                .catch(err => console.error('Gagal menyalin:', err));
        }
        
        // Payment processing
        function processPayment() {
            const activeMethod = document.querySelector('.payment-method.active');
            if (!activeMethod) return alert('Pilih metode pembayaran terlebih dahulu!');
            
            const methodType = activeMethod.dataset.method;
            let isValid = true;
            
            if (methodType === 'creditcard') {
                const cardNumber = document.getElementById('cardNumber').value.replace(/\s/g, '');
                const expiry = document.getElementById('expiry').value;
                const cvv = document.getElementById('cvv').value;
                const cardName = document.getElementById('cardName').value;
                
                if (!/^\d{16}$/.test(cardNumber)) isValid = false;
                if (!/^\d{2}\/\d{2}$/.test(expiry)) isValid = false;
                if (!/^\d{3}$/.test(cvv)) isValid = false;
                if (cardName.trim() === '') isValid = false;
            }
            else if (methodType === 'ewallet') {
                const selected = document.querySelector('.ewallet-option.selected');
                if (!selected) isValid = false;
            }
            
            if (isValid) {
                alert('Pembayaran berhasil diproses!');
                window.location.href = 'payment-success.html';
            } else {
                alert('Harap lengkapi data pembayaran dengan benar!');
            }
        }
        
        // Initialize countdown when page loads
        startCountdown();
    </script>
</body>
</html>