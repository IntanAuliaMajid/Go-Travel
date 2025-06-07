<?php
// session_start(); // Diasumsikan sudah ada di navbar.php dan navbar.php dipanggil pertama
include 'Komponen/navbar.php'; 
include 'backend/koneksi.php'; 

// --- DEBUG: Lihat isi session ---
// echo "<pre>SESSION DATA:\n";
// var_dump($_SESSION);
// echo "</pre>";
// --- AKHIR DEBUG ---

// 1. Ambil Data Pemesanan dari Session
$kode_pemesanan_unik = isset($_SESSION['kode_pemesanan']) ? trim($_SESSION['kode_pemesanan']) : 'INV-' . time() . rand(100,999);
$total_pembayaran = isset($_SESSION['total_harga_akhir']) ? (int)$_SESSION['total_harga_akhir'] : 0; // Pastikan integer
$nama_pelanggan_lengkap = isset($_SESSION['nama_lengkap_pemesan']) ? trim($_SESSION['nama_lengkap_pemesan']) : 'Pelanggan';
$email_pelanggan = isset($_SESSION['email_pemesan']) ? trim($_SESSION['email_pemesan']) : 'pelanggan@example.com';
$telepon_pelanggan = isset($_SESSION['telepon_pemesan']) ? trim($_SESSION['telepon_pemesan']) : '080000000000';
$id_paket_wisata_session = isset($_SESSION['id_paket_wisata_dipesan']) ? trim($_SESSION['id_paket_wisata_dipesan']) : null;
$nama_paket_dipesan = isset($_SESSION['nama_paket_dipesan']) ? trim($_SESSION['nama_paket_dipesan']) : 'Paket Wisata Tidak Diketahui';
$durasi_paket_dipesan = isset($_SESSION['durasi_paket_dipesan']) ? trim($_SESSION['durasi_paket_dipesan']) : '-';
$jumlah_peserta_dipesan = isset($_SESSION['jumlah_peserta_dipesan']) ? (int)$_SESSION['jumlah_peserta_dipesan'] : 1;

$data_valid_untuk_pembayaran = true;
if ($total_pembayaran <= 0) {
    error_log("Pembayaran Error: Total pembayaran adalah nol atau kurang untuk Order ID: " . $kode_pemesanan_unik);
    $data_valid_untuk_pembayaran = false;
}
if (empty($id_paket_wisata_session)) {
    error_log("Pembayaran Error: ID Paket Wisata session kosong untuk Order ID: " . $kode_pemesanan_unik);
    $data_valid_untuk_pembayaran = false;
}
if (empty($nama_pelanggan_lengkap) || empty($email_pelanggan) || empty($telepon_pelanggan) || !filter_var($email_pelanggan, FILTER_VALIDATE_EMAIL)) {
    error_log("Pembayaran Error: Detail pelanggan tidak lengkap atau email tidak valid untuk Order ID: " . $kode_pemesanan_unik);
    $data_valid_untuk_pembayaran = false;
}


if (!function_exists('format_rupiah')) {
    function format_rupiah($number) {
        return 'Rp ' . number_format(floatval($number), 0, ',', '.');
    }
}

$snapToken = ''; 
$midtransClientKey = 'SB-Mid-client-RU-4tatn5CIGtpeG'; // GANTI DENGAN CLIENT KEY ANDA (JIKA BELUM)

if ($data_valid_untuk_pembayaran) {
    require_once 'vendor/autoload.php'; 

    \Midtrans\Config::$serverKey = 'SB-Mid-server-1zCj_s8Ixz5PgsPt4xpWFnNS'; // GANTI DENGAN SERVER KEY ANDA (JIKA BELUM)
    \Midtrans\Config::$isProduction = false; 
    \Midtrans\Config::$isSanitized = true;
    \Midtrans\Config::$is3ds = true; 

    $nama_parts = explode(' ', $nama_pelanggan_lengkap, 2);
    $first_name = trim($nama_parts[0]);
    $last_name = isset($nama_parts[1]) && !empty(trim($nama_parts[1])) ? trim($nama_parts[1]) : $first_name;

    // Validasi tambahan untuk parameter Midtrans
    if (empty($first_name)) $first_name = "Pelanggan"; // Fallback jika nama depan kosong setelah trim

    $params = array(
        'transaction_details' => array(
            'order_id' => (string)$kode_pemesanan_unik, // Pastikan string
            'gross_amount' => (int)$total_pembayaran, // Pastikan integer
        ),
        'customer_details' => array(
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email_pelanggan,
            'phone' => preg_replace('/[^0-9]/', '', $telepon_pelanggan), // Bersihkan nomor telepon
        ),
        'item_details' => array( 
            array(
                'id' => (string)$id_paket_wisata_session,
                'price' => (int)$total_pembayaran, 
                'quantity' => 1, 
                'name' => substr($nama_paket_dipesan, 0, 50)
            )
        ),
        'callbacks' => array(
            'finish' => "http://localhost/Go-Travel/pembayaran_konfirmasi.php?order_id=".(string)$kode_pemesanan_unik
        ),
        'expiry' => array(
            'start_time' => date("Y-m-d H:i:s O"),
            'unit' => 'hour', 
            'duration' => 24
        )
    );

    // --- DEBUG: Lihat parameter yang dikirim ke Midtrans ---
    // echo "<pre>PARAMS TO MIDTRANS:\n";
    // var_dump($params);
    // echo "</pre>";
    // --- AKHIR DEBUG ---

    try {
        $snapToken = \Midtrans\Snap::getSnapToken($params);
    } catch (Exception $e) {
        error_log("Midtrans Snap Token Exception (Order ID: ".$kode_pemesanan_unik."): " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - <?php echo htmlspecialchars($nama_paket_dipesan); ?></title>
    
    <?php if ($data_valid_untuk_pembayaran && !empty($snapToken)): ?>
    <script type="text/javascript"
      src="<?php echo (\Midtrans\Config::$isProduction ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js'); ?>"
      data-client-key="<?php echo htmlspecialchars($midtransClientKey); ?>"></script>
    <?php endif; ?>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    <style>
        /* CSS Anda yang sudah ada dari prompt sebelumnya, dengan sedikit penyesuaian */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background-color: #f8f9fa; color: #333; line-height:1.6; display: flex; flex-direction: column; min-height: 100vh;} /* Sticky footer */
        main.payment-page-main-content { flex-grow: 1; } /* Untuk sticky footer */

        .hero { 
            min-height: 250px; 
            background-image: linear-gradient(rgba(0,0,0,0.55), rgba(0,0,0,0.55)), url('https://www.ancol.com/blog/wp-content/uploads/2022/03/wisata-aquarium-di-jakarta.jpg');
            background-size: cover; background-position: center; display: flex; justify-content: center; align-items: center;
            color: white; text-align: center; position: relative; padding: 20px;
        }
        .hero::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 60px; background: linear-gradient(to top, #f8f9fa, transparent); }
        .hero-content { z-index: 1; max-width: 700px; }
        .hero h1 { font-size: 2.2rem; margin-bottom: 0.8rem; text-shadow: 1px 1px 3px rgba(0,0,0,0.6); }
        .hero p { font-size: 1rem; max-width: 550px; margin: 0 auto; text-shadow: 1px 1px 2px rgba(0,0,0,0.6); opacity: 0.9; }
        
        .payment-container { max-width: 1100px; margin: -50px auto 50px; padding: 0 1rem; display: flex; gap: 2rem; flex-wrap: wrap; position: relative; z-index: 2; }
        .payment-form { flex: 2; min-width: 300px; background-color: white; padding: 2rem; border-radius: 12px; box-shadow: 0 8px 25px rgba(0,0,0,0.07); }
        .order-summary { flex: 1; min-width: 300px; background-color: white; padding: 2rem; border-radius: 12px; box-shadow: 0 8px 25px rgba(0,0,0,0.07); }
        
        .booking-progress { display: flex; justify-content: space-between; margin-bottom: 2.5rem; position:relative; }
        .progress-step { display: flex; flex-direction: column; align-items: center; text-align: center; flex: 1; position: relative; z-index: 1;}
        .step-number {
          width: 32px; height: 32px; border-radius: 50%; background-color: #e0f7f5; color: #1a9988;
          display: flex; justify-content: center; align-items: center; font-weight: bold; margin-bottom: 0.5rem; border: 2px solid #1a9988; font-size:0.9rem;
        }
        .progress-step.active .step-number { background-color: #1a9988; color: white; }
        .progress-step.completed .step-number { background-color: #158677; color: white; border-color: #158677; }
        .step-label { font-size: 0.8rem; color: #777; font-weight: 500; }
        .progress-step.active .step-label, .progress-step.completed .step-label { color: #1a9988; font-weight: 600; }
        .progress-step:not(:last-child)::after {
            content: ''; position: absolute; top: 15px; left: 50%; width: 100%;
            height: 2px; background-color: #e0f7f5; z-index: -1; 
        }
        .progress-step.active::after, .progress-step.completed::after,
        .progress-step.active + .progress-step.active::before, 
        .progress-step.completed + .progress-step.active::before,
        .progress-step.completed + .progress-step.completed::before { background-color: #1a9988; }
        .progress-step:not(:first-child)::before {
            content: ''; position: absolute; top: 15px; right: 50%; width: 100%;
            height: 2px; background-color: #e0f7f5; z-index: -1;
        }

        .section-title { color: #1a9988; margin-bottom: 1.5rem; font-size: 1.5rem; position: relative; padding-bottom: 8px; }
        .section-title::after { content: ''; position: absolute; bottom: 0; left: 0; width: 50px; height: 3px; background-color: #1a9988; border-radius: 2px; }
        
        .payment-method { border: 1.5px solid #e1e5ee; border-radius: 10px; padding: 1.2rem; margin-bottom: 1rem; cursor: pointer; transition: all 0.2s ease-in-out; position: relative; }
        .payment-method:hover { border-color: #1a9988; box-shadow: 0 2px 8px rgba(26,153,136,0.1); }
        .payment-method.active { border-color: #1a9988; background-color: #f0f9f8; box-shadow: 0 2px 8px rgba(26,153,136,0.15); }
        .payment-method.active::before {
          content: '✓'; position: absolute; right: 12px; top: 12px; background-color: #1a9988; color: white;
          width: 22px; height: 22px; border-radius: 50%; display: flex; align-items: center; justify-content: center;
          font-size: 0.7rem; font-weight: bold;
        }
        .payment-header { display: flex; align-items: center; margin-bottom: 0.5rem; }
        .payment-icon { font-size: 1.3rem; color: #1a9988; margin-right: 0.8rem; width: 25px; text-align:center;}
        .payment-icon img { height: 22px; width:auto; vertical-align: middle;}
        .payment-name { font-weight: 600; font-size: 1.05rem; color: #333; }
        .payment-description { color: #555; font-size: 0.85rem; margin-left: calc(25px + 0.8rem); line-height:1.4;}
        
        .transfer-info { background-color: #e9f5f3; padding: 1.2rem; border-radius: 8px; margin-top: 1rem; border: 1px solid #cce0dd;}
        .bank-details { display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.8rem; font-size:0.9rem; }
        .bank-info { font-weight: 600; color: #177a6f; }
        .bank-info div:not(:first-child) { font-weight:normal; color:#444; font-size:0.85rem;}
        .copy-btn {
          background-color: #1a9988; color: white; border: none; padding: 0.4rem 0.8rem; border-radius: 5px;
          cursor: pointer; font-size: 0.8rem; transition: all 0.2s ease;
        }
        .copy-btn:hover { background-color: #158677; }
        .copy-btn i { margin-right: 5px;}
        
        .booking-summary { margin-bottom: 1.5rem; }
        .summary-item { display: flex; justify-content: space-between; margin-bottom: 0.7rem; padding-bottom: 0.7rem; border-bottom: 1px solid #f3f3f3; font-size:0.9rem; }
        .summary-item:last-of-type { border-bottom: none; margin-bottom: 0; }
        .summary-label { color: #555; }
        .summary-value { font-weight: 500; color: #333; }
        .total-amount {
          font-size: 1.25rem; font-weight: bold; color: #1a9988; margin-top: 1.2rem;
          padding-top: 1.2rem; border-top: 2px solid #1a9988;
          display: flex; justify-content: space-between;
        }
        
        .package-mini { background-color: #f8f9fa; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; border:1px solid #eee;}
        .package-mini-header { display: flex; align-items: center; }
        .package-mini-image { width: 50px; height: 50px; border-radius: 6px; object-fit: cover; margin-right: 0.8rem; }
        .package-mini-info h3 { color: #333; font-size: 1rem; margin-bottom: 0.2rem; line-height: 1.3; }
        .package-mini-info p { color: #666; font-size: 0.85rem; line-height: 1.3; margin-bottom:0;}
        
        .security-info { background-color: #f0f9f8; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; border-left: 3px solid #1a9988; }
        .security-header { display: flex; align-items: center; margin-bottom: 0.6rem; }
        .security-header i { color: #1a9988; margin-right: 0.6rem; font-size: 1.1rem; }
        .security-header h3 { color: #1a9988; font-size: 0.95rem; margin:0; }
        .security-list { list-style: none; padding-left: 0; }
        .security-list li { color: #555; font-size: 0.85rem; margin-bottom: 0.4rem; position: relative; padding-left: 1.3rem; }
        .security-list li::before { content: '✓'; position: absolute; left: 0; color: #1a9988; font-weight: bold; }
        
        .action-buttons { display: flex; gap: 1rem; margin-top: 2rem; }
        .action-buttons .btn { flex: 1; padding: 0.9rem; border-radius: 8px; font-size: 0.95rem; }
        
        .payment-timer { background-color: #fff8e1; padding: 0.8rem 1rem; border-radius: 8px; margin-bottom: 2rem; border: 1px solid #ffecb3; text-align: center; }
        .timer-text { color: #8d6e00; font-weight: 500; margin-bottom: 0.3rem; font-size:0.9rem; }
        .timer-value { font-size: 1.3rem; font-weight: bold; color: #d35400; }
        
        .error-container { text-align:center; padding: 50px; background-color:white; margin: 2rem auto; border-radius:12px; box-shadow: 0 8px 25px rgba(0,0,0,0.07); max-width: 600px;}
        .error-container h1 { color: #d9534f; margin-bottom:1rem; }
        .error-container p { margin-bottom:1.5rem; color:#555;}
        .error-container a { display:inline-block; padding:10px 20px; background-color:#2c7a51; color:white; text-decoration:none; border-radius:5px; transition: background-color 0.3s; }
        .error-container a:hover { background-color: #1e5a3a; }

        @media (max-width: 768px) {
            .payment-container { flex-direction: column; padding: 0 1rem; margin-top:-30px; }
            .payment-form, .order-summary { padding: 1.5rem; }
            .action-buttons { flex-direction: column; }
            .hero h1 {font-size: 1.8rem;}
            .hero p {font-size: 1rem;}
            .section-title {font-size:1.3rem;}
            .progress-step .step-label { font-size: 0.75rem; }
        }
    </style>
</head>
<body>
    <?php // Navbar sudah di-include ?>
    <main class="payment-page-main-content"> 
        <section class="hero">
            <div class="hero-content">
                <h1>Konfirmasi Pembayaran Anda</h1>
                <p>Selesaikan langkah terakhir untuk mengamankan pesanan paket wisata impian Anda.</p>
            </div>
        </section>

        <?php if (!$data_valid_untuk_pembayaran || empty($snapToken)): ?>
            <div class="error-container">
                <h1>Error Proses Pembayaran</h1>
                <?php if (!$data_valid_untuk_pembayaran): ?>
                    <p>Data pembayaran tidak lengkap atau total harga tidak valid. Tidak dapat melanjutkan ke pembayaran. Silakan ulangi proses pemesanan dari awal.</p>
                <?php elseif (empty($snapToken)): ?>
                    <p>Gagal mendapatkan token pembayaran dari Midtrans. Mohon coba beberapa saat lagi atau hubungi dukungan kami.</p>
                    <p><small>Pastikan konfigurasi Server Key Midtrans Anda sudah benar dan parameter transaksi valid. Periksa juga log error server PHP Anda untuk detail lebih lanjut.</small></p>
                <?php endif; ?>
                <a href="paket_wisata.php">Kembali ke Daftar Paket</a>
            </div>
        <?php else: ?>
            <div class="payment-container">
                <div class="payment-form">
                    <div class="booking-progress">
                        <div class="progress-step completed"> <div class="step-number">1</div> <div class="step-label">Data Diri</div> </div>
                        <div class="progress-step active"> <div class="step-number">2</div> <div class="step-label">Pembayaran</div> </div>
                        <div class="progress-step"> <div class="step-number">3</div> <div class="step-label">Selesai</div> </div>
                    </div>
                    
                    <div class="payment-timer">
                        <div class="timer-text">Selesaikan pembayaran dalam:</div>
                        <div class="timer-value" id="countdown">23:59:59</div>
                    </div>
                    
                    <h2 class="section-title">Pilih Metode Pembayaran</h2>
                    
                    <div class="payment-methods">
                        <div class="payment-method" data-method="midtrans">
                            <div class="payment-header">
                                 <div class="payment-icon"><img src="https://docs.midtrans.com/assets/img/midtrans-logo.png" alt="Midtrans"></div>
                                <div class="payment-name">Midtrans Payment Gateway</div>
                            </div>
                            <div class="payment-description">
                                Bayar dengan Kartu Kredit/Debit, GoPay, ShopeePay, QRIS, Virtual Account Bank (BCA, Mandiri, BRI, dll.), dan lainnya.
                            </div>
                        </div>

                        <div class="payment-method" data-method="transfer">
                            <div class="payment-header">
                                <div class="payment-icon"><i class="fas fa-university"></i></div>
                                <div class="payment-name">Transfer Bank (Verifikasi Manual)</div>
                            </div>
                            <div class="payment-description">
                                Transfer ke rekening bank kami. Konfirmasi manual mungkin memerlukan waktu. Sertakan ID Pesanan Anda (<?php echo htmlspecialchars($kode_pemesanan_unik); ?>) pada berita transfer.
                            </div>
                            <div class="transfer-info" id="transferDetails" style="display: none;">
                                <p style="font-size:0.9em; color:#555; margin-bottom:1rem;">Silakan transfer sejumlah <strong><?php echo format_rupiah($total_pembayaran); ?></strong> ke salah satu rekening berikut:</p>
                                <div class="bank-details">
                                    <div>
                                        <div class="bank-info">Bank Mandiri</div>
                                        <div>No. Rek: 1570-0000-1234-567</div>
                                        <div>a.n PT GoTravel Indonesia</div>
                                    </div>
                                    <button class="copy-btn" onclick="copyToClipboard('157000001234567')"><i class="fas fa-copy"></i> Salin</button>
                                </div>
                                <div class="bank-details" style="margin-top:1rem;">
                                    <div>
                                        <div class="bank-info">Bank BCA</div>
                                        <div>No. Rek: 0123-456-7890</div>
                                        <div>a.n PT GoTravel Indonesia</div>
                                    </div>
                                    <button class="copy-btn" onclick="copyToClipboard('01234567890')"><i class="fas fa-copy"></i> Salin</button>
                                </div>
                                <p style="font-size:0.85em; color:#777; margin-top:1.5rem;">Penting: Setelah melakukan transfer, mohon lakukan konfirmasi pembayaran melalui tautan yang akan kami kirimkan ke email Anda atau melalui halaman status pesanan Anda.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="order-summary">
                    <h2 class="section-title">Ringkasan Pesanan</h2>
                    
                    <div class="package-mini">
                        <div class="package-mini-header">
                            <img src="https://via.placeholder.com/60x60?text=Paket" alt="<?php echo htmlspecialchars($nama_paket_dipesan); ?>" class="package-mini-image">
                            <div class="package-mini-info">
                                <h3><?php echo htmlspecialchars($nama_paket_dipesan); ?></h3>
                                <p>
                                    <?php echo htmlspecialchars($durasi_paket_dipesan); ?> 
                                    <?php if($jumlah_peserta_dipesan > 0) { 
                                        echo "• " . htmlspecialchars($jumlah_peserta_dipesan) . ($jumlah_peserta_dipesan > 1 || (isset($_SESSION['is_family_package']) && $_SESSION['is_family_package']) ? " Peserta/Keluarga" : " Peserta"); 
                                    } ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="booking-summary">
                        <div class="summary-item">
                            <span class="summary-label">ID Pesanan:</span>
                            <span class="summary-value"><?php echo htmlspecialchars($kode_pemesanan_unik); ?></span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Nama Pemesan:</span>
                            <span class="summary-value"><?php echo htmlspecialchars($nama_pelanggan_lengkap); ?></span>
                        </div>
                         <div class="summary-item">
                            <span class="summary-label">Email:</span>
                            <span class="summary-value"><?php echo htmlspecialchars($email_pelanggan); ?></span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">No. Telepon:</span>
                            <span class="summary-value"><?php echo htmlspecialchars($telepon_pelanggan); ?></span>
                        </div>
                        
                        <div class="total-amount">
                            <span>Total Pembayaran:</span>
                            <span><?php echo format_rupiah($total_pembayaran); ?></span>
                        </div>
                    </div>
                    
                    <div class="security-info">
                        <div class="security-header">
                            <i class="fas fa-shield-alt"></i>
                            <h3>Pembayaran Aman & Terjamin</h3>
                        </div>
                        <ul class="security-list">
                            <li>Transaksi Anda dilindungi enkripsi SSL.</li>
                            <li>Kami menjaga privasi data Anda.</li>
                            <li>Pembayaran diproses oleh Midtrans, payment gateway terpercaya di Indonesia (untuk opsi Midtrans).</li>
                        </ul>
                    </div>

                    <div class="action-buttons">
                        <button type="button" class="btn btn-secondary" onclick="window.location.href='pemesanan.php?id_paket=<?php echo htmlspecialchars($id_paket_wisata_session); ?>'">
                            <i class="fas fa-arrow-left"></i> Ubah Pesanan
                        </button>
                        <button type="button" class="btn btn-primary" id="pay-button">
                            <i class="fas fa-lock"></i> Lanjutkan Pembayaran
                        </button>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </main>
    <?php include 'Komponen/footer.php'; ?>

    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            const snapToken = "<?php echo $snapToken; ?>"; 
            const paymentMethods = document.querySelectorAll('.payment-method');
            const transferDetails = document.getElementById('transferDetails');
            let selectedMethod = null; 

            function activatePaymentMethod(methodElement) {
                if (!methodElement) return; 
                paymentMethods.forEach(m => m.classList.remove('active'));
                methodElement.classList.add('active');
                selectedMethod = methodElement.getAttribute('data-method');

                if (transferDetails) {
                    transferDetails.style.display = (selectedMethod === 'transfer') ? 'block' : 'none';
                }
            }

            const defaultMidtransMethod = document.querySelector('.payment-method[data-method="midtrans"]');
            if (defaultMidtransMethod) {
                activatePaymentMethod(defaultMidtransMethod);
            } else if (paymentMethods.length > 0) {
                activatePaymentMethod(paymentMethods[0]);
            }

            paymentMethods.forEach(method => {
                method.addEventListener('click', function() {
                    activatePaymentMethod(this);
                });
            });

            var payButton = document.getElementById('pay-button');
            if (payButton) {
                // Hanya tambahkan event listener jika tombol ada (yaitu, tidak ada error kritis sebelumnya)
                if (<?php echo ($data_valid_untuk_pembayaran && !empty($snapToken)) ? 'true' : 'false'; ?>) {
                    payButton.addEventListener('click', function () {
                        if (!selectedMethod) {
                            alert('Silakan pilih metode pembayaran terlebih dahulu.');
                            return;
                        }

                        if (selectedMethod === 'midtrans') {
                            if (snapToken) {
                                snap.pay(snapToken, {
                                    onSuccess: function(result){
                                        console.log('Midtrans Success:', result);
                                        handleMidtransResponse(result, 'success');
                                    },
                                    onPending: function(result){
                                        console.log('Midtrans Pending:', result);
                                        handleMidtransResponse(result, 'pending');
                                    },
                                    onError: function(result){
                                        console.error('Midtrans Error:', result);
                                        handleMidtransResponse(result, 'error');
                                    },
                                    onClose: function(){
                                        console.log('Anda menutup popup pembayaran sebelum menyelesaikan transaksi.');
                                    }
                                });
                            } else {
                                alert('Error: Token pembayaran Midtrans tidak tersedia. Silakan coba muat ulang halaman atau hubungi dukungan jika masalah berlanjut.');
                            }
                        } else if (selectedMethod === 'transfer') {
                            window.location.href = 'pembayaran_konfirmasi.php?order_id=<?php echo htmlspecialchars($kode_pemesanan_unik); ?>&status=pending&method=transfer';
                        }
                    });
                } else {
                    // Jika snapToken kosong atau data tidak valid, tombol mungkin tidak berfungsi atau menampilkan pesan lain
                    payButton.disabled = true;
                    payButton.innerHTML = '<i class="fas fa-exclamation-circle"></i> Pembayaran Tidak Tersedia';
                    payButton.style.backgroundColor = '#ccc';
                    payButton.style.cursor = 'not-allowed';
                }
            }
        });

        function handleMidtransResponse(result, status_pembayaran) {
            var formData = new FormData();
            formData.append('midtrans_response', JSON.stringify(result));
            formData.append('payment_status', status_pembayaran);
            formData.append('order_id', result.order_id || '<?php echo htmlspecialchars($kode_pemesanan_unik); ?>');
            formData.append('payment_method', result.payment_type || 'midtrans'); 
            formData.append('transaction_id', result.transaction_id || null);
            formData.append('gross_amount', result.gross_amount || null);
            formData.append('status_code', result.status_code || null);

            fetch('./backend/proses_update_pembayaran.php', { 
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                if (data.redirect_url) { 
                    window.location.href = data.redirect_url;
                } else { 
                    let redirectUrl = 'pembayaran_konfirmasi.php?order_id=' + (result.order_id || '<?php echo htmlspecialchars($kode_pemesanan_unik); ?>') + '&status=' + status_pembayaran;
                    if(result.transaction_id) {
                        redirectUrl += '&transaction_id=' + result.transaction_id;
                    }
                    window.location.href = redirectUrl;
                }
            })
            .catch(error => {
                console.error('Error sending Midtrans response to server:', error);
                alert('Terjadi kesalahan saat memproses status pembayaran Anda. Silakan periksa status pesanan Anda atau hubungi dukungan.');
                window.location.href = 'pembayaran_konfirmasi.php?order_id=' + (result.order_id || '<?php echo htmlspecialchars($kode_pemesanan_unik); ?>') + '&status=error_communication';
            });
        }

        function copyToClipboard(text) {
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(text)
                    .then(() => alert('Nomor rekening berhasil disalin: ' + text))
                    .catch(err => {
                        console.error('Gagal menyalin teks modern: ', err);
                        fallbackCopyToClipboard(text);
                    });
            } else {
                fallbackCopyToClipboard(text);
            }
        }
        function fallbackCopyToClipboard(text) {
            const textArea = document.createElement("textarea");
            textArea.value = text;
            textArea.style.position = "fixed";
            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();
            try {
                const successful = document.execCommand('copy');
                const msg = successful ? 'Nomor rekening berhasil disalin (fallback): ' : 'Gagal menyalin nomor rekening (fallback)';
                alert(msg + text);
            } catch (err) {
                console.error('Fallback: Gagal menyalin teks', err);
                alert('Gagal menyalin nomor rekening.');
            }
            document.body.removeChild(textArea);
        }

        function startCountdown() {
            let duration = 24 * 60 * 60; 
            const countdownElement = document.getElementById('countdown');
            if (!countdownElement) return;

            let timer = duration, hours, minutes, seconds;
            const interval = setInterval(function () {
                hours = parseInt(timer / 3600, 10);
                minutes = parseInt((timer % 3600) / 60, 10);
                seconds = parseInt(timer % 60, 10);

                hours = hours < 10 ? "0" + hours : hours;
                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;

                countdownElement.textContent = hours + ":" + minutes + ":" + seconds;

                if (--timer < 0) {
                    clearInterval(interval);
                    countdownElement.textContent = "Waktu Habis";
                    const payBtn = document.getElementById('pay-button');
                    if(payBtn) {
                        payBtn.disabled = true;
                        payBtn.innerHTML = '<i class="fas fa-times-circle"></i> Waktu Pembayaran Habis';
                        payBtn.style.backgroundColor = '#aaa';
                        payBtn.style.cursor = 'not-allowed';
                    }
                }
            }, 1000);
        }
        // Hanya mulai countdown jika tidak ada error kritis
        if (<?php echo ($data_valid_untuk_pembayaran && !empty($snapToken)) ? 'true' : 'false'; ?>) {
            startCountdown();
        }
    </script>
</body>
</html>
