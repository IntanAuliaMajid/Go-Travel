<?php
// session_start(); // Diasumsikan sudah ada di navbar.php dan navbar.php dipanggil pertama
include 'Komponen/navbar.php';
include 'backend/koneksi.php';

$id_paket = null;
$paket_info = null;
$item_termasuk_list = [];
$harga_paket_untuk_kalkulasi = 0;
$id_jenis_paket_keluarga = 3;

// Ambil pesan error dari session jika ada
$error_message_pemesanan = '';
if (isset($_SESSION['error_message_pemesanan'])) {
    $error_message_pemesanan = $_SESSION['error_message_pemesanan'];
    unset($_SESSION['error_message_pemesanan']); // Hapus pesan setelah ditampilkan
}
$error_message_system = '';
if (isset($_SESSION['error_message_system'])) {
    $error_message_system = $_SESSION['error_message_system'];
    unset($_SESSION['error_message_system']); // Hapus pesan setelah ditampilkan
}


if (isset($_GET['id_paket'])) {
    // Pastikan $conn ada dan valid sebelum digunakan
    if (isset($conn) && $conn instanceof mysqli) {
        $id_paket = mysqli_real_escape_string($conn, $_GET['id_paket']);

        $paket_info_sql = "SELECT
                                pw.id_paket_wisata,
                                pw.nama_paket,
                                pw.durasi_paket,
                                pw.id_jenis_paket,
                                w.nama_wilayah
                              FROM paket_wisata pw
                              LEFT JOIN wilayah w ON pw.id_wilayah = w.id_wilayah
                              WHERE pw.id_paket_wisata = '$id_paket'";
        $paket_info_result = mysqli_query($conn, $paket_info_sql);

        if ($paket_info_result && mysqli_num_rows($paket_info_result) > 0) {
            $paket_info = mysqli_fetch_assoc($paket_info_result);

            $item_termasuk_sql = "SELECT termasuk, harga_komponen
                                    FROM termasuk_paket
                                    WHERE id_paket = '$id_paket'
                                    ORDER BY id_termasuk_paket ASC";
            $item_termasuk_result = mysqli_query($conn, $item_termasuk_sql);
            if ($item_termasuk_result) {
                $temp_harga_komponen_total = 0;
                while ($row = mysqli_fetch_assoc($item_termasuk_result)) {
                    $item_termasuk_list[] = $row;
                    if (isset($row['harga_komponen']) && is_numeric($row['harga_komponen'])) {
                        $temp_harga_komponen_total += floatval($row['harga_komponen']);
                    }
                }
                $harga_paket_untuk_kalkulasi = $temp_harga_komponen_total;
            }

        } else {
            echo "<div style='text-align:center; padding: 50px;'><h1>Error</h1><p>Detail Paket Wisata tidak ditemukan atau ID paket tidak valid.</p><a href='index.php' style='display:inline-block; margin-top:20px; padding:10px 20px; background-color:#2c7a51; color:white; text-decoration:none; border-radius:5px;'>Kembali ke Beranda</a></div>";
            if (isset($conn) && $conn instanceof mysqli) { mysqli_close($conn); }
            exit;
        }
    } else {
        // Error jika $conn tidak terdefinisi setelah include koneksi.php
        echo "<div style='text-align:center; padding: 50px;'><h1>Error Kritis</h1><p>Koneksi ke database gagal. Tidak dapat memuat detail paket.</p><a href='index.php' style='display:inline-block; margin-top:20px; padding:10px 20px; background-color:#2c7a51; color:white; text-decoration:none; border-radius:5px;'>Kembali ke Beranda</a></div>";
        exit;
    }
} else {
    echo "<div style='text-align:center; padding: 50px;'><h1>Error</h1><p>ID Paket Wisata tidak disediakan di URL.</p><a href='index.php' style='display:inline-block; margin-top:20px; padding:10px 20px; background-color:#2c7a51; color:white; text-decoration:none; border-radius:5px;'>Kembali ke Beranda</a></div>";
    if (isset($conn) && $conn instanceof mysqli) { mysqli_close($conn); }
    exit;
}

if (!function_exists('format_rupiah')) {
    function format_rupiah($number) {
        return 'Rp ' . number_format(floatval($number), 0, ',', '.');
    }
}
$is_paket_keluarga = ($paket_info && isset($paket_info['id_jenis_paket']) && $paket_info['id_jenis_paket'] == $id_jenis_paket_keluarga);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Form Pemesanan: <?php echo htmlspecialchars($paket_info['nama_paket'] ?? 'Paket Wisata'); ?></title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
    /* Global Styles */
    * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }

    html { height: 100%; }
    body {
        background-color: #f5f5f5;
        color: #333;
        line-height: 1.6;
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }
    main.container {
        flex-grow: 1;
        max-width: 1200px;
        margin: 2rem auto;
        padding: 0 1rem;
        width: 100%;
    }

    /* Alert/Error Message Style */
    .alert-message {
        padding: 1rem;
        margin-bottom: 1.5rem;
        border-radius: 6px;
        font-size: 0.95rem;
        text-align: center;
    }
    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
    .alert-warning {
        background-color: #fff3cd;
        color: #856404;
        border: 1px solid #ffeeba;
    }


    /* Header Section */
    .order-header {
      background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),
                  url('https://www.ancol.com/blog/wp-content/uploads/2022/03/wisata-aquarium-di-jakarta.jpg') no-repeat center center/cover;
      min-height: 30vh;
      padding: 2rem 1rem;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      color: white;
      margin-bottom: 2.5rem;
      text-align: center;
      border-radius: 0 0 15px 15px;
      /* === Tambahkan margin-top di sini untuk menurunkan header === */
      margin-top: 70px; /* Sesuaikan nilai ini (misal: 60px, 70px, 80px) agar pas di bawah navbar Anda */
    }
    .order-header h1 { font-size: clamp(1.8rem, 5vw, 2.5rem); margin-bottom: 0.5rem; }
    .order-header p.package-name-header { font-size: clamp(1rem, 3vw, 1.2rem); font-weight: 500; margin-top: 0.5rem; opacity: 0.9; }

    /* Main Content */
    .order-main { display: grid; grid-template-columns: 2fr 1fr; gap: 2.5rem; margin-bottom: 4rem; }

    /* Form Styles */
    .order-form { background: white; padding: 2.5rem; border-radius: 10px; box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08); }
    .order-form h2 {
        font-size: 1.5rem; color: #2c7a51; margin-bottom: 1.5rem;
        padding-bottom: 0.8rem; border-bottom: 2px solid #eef;
    }
    .form-group { margin-bottom: 1.5rem; }
    .form-group label { display: block; margin-bottom: 0.6rem; font-weight: 600; color: #444; font-size: 0.9rem; }
    .form-group input, .form-group select, .form-group textarea {
      width: 100%; padding: 0.9rem; border: 1px solid #ddd; border-radius: 6px; font-size: 0.95rem;
      transition: border-color 0.3s, box-shadow 0.3s;
    }
    .form-group input[disabled] { background-color: #e9ecef; cursor: not-allowed; }
    .form-group input[type="number"] { -moz-appearance: textfield; }
    .form-group input[type="number"]::-webkit-outer-spin-button,
    .form-group input[type="number"]::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
    .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
      outline: none; border-color: #2c7a51; box-shadow: 0 0 0 3px rgba(44, 122, 81, 0.15);
    }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; }
    .form-actions { margin-top: 2.5rem; display: flex; justify-content: space-between; align-items: center; }
    .btn {
      padding: 0.9rem 1.8rem; border-radius: 6px; font-size: 0.95rem; font-weight: 600; cursor: pointer;
      transition: all 0.3s ease; border: none; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem;
    }
    .btn i { font-size: 0.9em; }
    .btn-primary { background-color: #2c7a51; color: white; }
    .btn-primary:hover { background-color: #1e5a3a; transform: translateY(-2px); box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
    .btn-secondary { background-color: #f0f0f0; color: #333; border: 1px solid #ddd; }
    .btn-secondary:hover { background-color: #e0e0e0; transform: translateY(-2px); box-shadow: 0 4px 10px rgba(0,0,0,0.05); }

    /* Order Summary */
    .order-summary {
      background: white; padding: 2.5rem; border-radius: 10px; box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
      height: fit-content; position: sticky; top: 2rem;
    }
    .order-summary h2, .order-summary h3.section-title {
      font-size: 1.5rem; color: #2c7a51; margin-bottom: 1.5rem; padding-bottom: 0.8rem; border-bottom: 2px solid #eef;
    }
    .package-info { margin-bottom: 1.5rem; }
    .package-info h3 { font-size: 1.2rem; margin-bottom: 0.6rem; color: #333; }
    .package-info p { color: #555; margin-bottom: 0.4rem; font-size: 0.9rem; display: flex; align-items: center; gap: 0.5rem;}
    .package-info p i { color: #2c7a51; width: 16px; text-align: center; }

    .price-detail-title {
        font-size: 1.1rem; color: #2c7a51; margin-bottom: 1rem; padding-top: 1rem;
        border-top: 1px dashed #ccc;
    }
    .price-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.7rem; font-size: 0.9rem; }
    .price-row .label { color: #555; flex: 1; }
    .price-row .label i.fa-check { color: #2c7a51; margin-right: 8px; font-size:0.8em; }
    .price-row .value { font-weight: 600; color: #333; text-align: right; white-space: nowrap; }
    .price-total {
      font-weight: bold; font-size: 1.2rem; border-top: 2px solid #2c7a51;
      padding-top: 1rem; margin-top: 1rem; color: #2c7a51;
    }
    .itemized-breakdown { margin-top: 1.5rem; }
    .itemized-breakdown h3.section-title { font-size: 1.2rem; margin-bottom:1rem; }

    /* New styles for dynamic passenger forms */
    .passenger-form-group {
        background-color: #f9f9f9;
        border: 1px solid #eee;
        border-radius: 8px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: inset 0 1px 3px rgba(0,0,0,0.05);
    }
    .passenger-form-group h3 {
        font-size: 1.3rem;
        color: #2c7a51;
        margin-bottom: 1rem;
        border-bottom: 1px dotted #ccc;
        padding-bottom: 0.5rem;
    }
    /* End new styles */


    @media (max-width: 992px) {
      .order-main { grid-template-columns: 1fr; }
      .order-summary { margin-top: 2.5rem; position: static; }
    }
    @media (max-width: 768px) {
      main.container { margin: 1rem auto; }
      .order-header { min-height: 25vh; margin-bottom: 1.5rem; }
      .order-form, .order-summary { padding: 1.5rem; }
      .form-row { grid-template-columns: 1fr; gap: 0; }
      .form-group { margin-bottom: 1.2rem; }
      .form-actions { flex-direction: column; gap: 1rem; }
      .btn { width: 100%; padding: 0.9rem 1.5rem; }
    }

    .booking-progress { display: flex; justify-content: space-between; margin-bottom: 2.5rem; position: relative; }
    .progress-step { display: flex; flex-direction: column; align-items: center; text-align: center; flex: 1; position: relative; z-index: 1; }
    .step-number {
      width: 35px; height: 35px; border-radius: 50%; background-color: #e0f7f5; color: #1a9988;
      display: flex; justify-content: center; align-items: center; font-weight: bold; margin-bottom: 0.5rem; border: 2px solid #1a9988;
      transition: background-color 0.3s, color 0.3s;
    }
    .progress-step.active .step-number { background-color: #1a9988; color: white; }
    .progress-step.completed .step-number { background-color: #158677; color: white; border-color: #158677; }
    .step-label { font-size: 0.85rem; color: #777; font-weight: 500; transition: color 0.3s; }
    .progress-step.active .step-label, .progress-step.completed .step-label { color: #1a9988; font-weight: 600; }
    .progress-step:not(:last-child)::after {
      content: ''; position: absolute; top: 17px; left: 50%; width: 100%; height: 3px; background-color: #e0f7f5; z-index: -1;
      transition: background-color 0.3s;
    }
    .progress-step.active::after, .progress-step.completed::after { background-color: #1a9988; }
    .progress-step:last-child::after { display: none; }
  </style>
</head>
<body>
  <?php // Navbar sudah di-include di atas. ?>

  <section class="order-header">
    <div class="container"> <h1>Form Pemesanan Paket Wisata</h1>
      <p class="package-name-header"><?php echo htmlspecialchars($paket_info['nama_paket'] ?? 'Pilih Paket Anda'); ?></p>
    </div>
  </section>

  <main class="container">
    <div class="order-main">
      <div class="order-form">
        <div class="booking-progress">
            <div class="progress-step active">
                <div class="step-number">1</div>
                <div class="step-label">Data Pemesan & Perjalanan</div>
            </div>
            <div class="progress-step">
                <div class="step-number">2</div>
                <div class="step-label">Pembayaran</div>
            </div>
            <div class="progress-step">
                <div class="step-number">3</div>
                <div class="step-label">Konfirmasi</div>
            </div>
        </div>

        <?php if (!empty($error_message_pemesanan)): ?>
            <div class="alert-message alert-danger">
                <i class="fas fa-exclamation-triangle"></i> <?php echo htmlspecialchars($error_message_pemesanan); ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($error_message_system)): ?>
            <div class="alert-message alert-warning">
                <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error_message_system); ?>
            </div>
        <?php endif; ?>

        <h2>Data Pemesan</h2>

        <form action="backend/proses_pemesanan.php" method="POST" id="bookingForm">
          <input type="hidden" name="id_paket_wisata" value="<?php echo htmlspecialchars($id_paket); ?>">
          <input type="hidden" name="base_price_package" id="base_price_package_hidden" value="<?php echo htmlspecialchars($harga_paket_untuk_kalkulasi); ?>">

          <input type="hidden" name="total_harga_keseluruhan_hidden" id="total_harga_keseluruhan_hidden" value="">
          <input type="hidden" name="is_family_package_hidden" id="is_family_package_hidden" value="<?php echo $is_paket_keluarga ? '1' : '0'; ?>">
          <input type="hidden" name="nama_paket_dipesan" value="<?php echo htmlspecialchars($paket_info['nama_paket'] ?? ''); ?>">
          <input type="hidden" name="durasi_paket_dipesan" value="<?php echo htmlspecialchars($paket_info['durasi_paket'] ?? ''); ?>">

          <div class="passenger-form-group" id="primary_booker_form">
              <h3>Data Pemesan Utama</h3>
              <div class="form-row">
                <div class="form-group">
                  <label for="nama_lengkap">Nama Lengkap (Sesuai KTP)</label>
                  <input type="text" id="nama_lengkap" name="nama_lengkap_pemesan" placeholder="Masukan nama lengkap Anda" required>
                </div>
                <div class="form-group">
                  <label for="email">Alamat Email</label>
                  <input type="email" id="email" name="email_pemesan" placeholder="contoh@email.com" required>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group">
                  <label for="no_telepon">Nomor Telepon (Aktif WhatsApp)</label>
                  <input type="tel" id="no_telepon" name="no_telepon_pemesan" placeholder="Contoh: 081234567890" required pattern="[0-9]{10,15}" title="Masukkan 10-15 digit nomor telepon.">
                </div>
                <div class="form-group">
                  <label for="no_ktp">Nomor Induk Kependudukan (NIK)</label>
                  <input type="text" id="no_ktp" name="no_ktp_pemesan" placeholder="16 digit NIK" required pattern="[0-9]{16}" title="NIK harus 16 digit angka.">
                </div>
              </div>

              <div class="form-group">
                <label for="alamat">Alamat Lengkap (Sesuai KTP)</label>
                <textarea id="alamat" name="alamat_pemesan" rows="3" placeholder="Jl. Contoh No. 1, RT/RW, Kelurahan, Kecamatan, Kota/Kab, Provinsi, Kode Pos" required></textarea>
              </div>
          </div>

          <h2 style="margin-top: 2.5rem;">Detail Perjalanan</h2>
          <div class="form-row">
            <div class="form-group">
              <label for="tanggal_keberangkatan">Pilih Tanggal Keberangkatan</label>
              <input type="date" id="tanggal_keberangkatan" name="tanggal_keberangkatan" required min="<?php echo date('Y-m-d', strtotime('+2 day')); ?>">
            </div>
            <div class="form-group">
              <label for="jumlah_peserta" id="label_jumlah_peserta">Jumlah Peserta</label>
              <input type="number" id="jumlah_peserta" name="jumlah_peserta" value="1" min="1" max="50" required>
              <small id="info_paket_keluarga" style="display:none; color: #2c7a51; font-size: 0.8em; margin-top: 5px; display: block;">Harga paket keluarga sudah untuk 1 unit keluarga (misal: maks 4 orang).</small>
            </div>
          </div>

          <div id="additional_passengers_container">
          </div>

          <div class="form-group">
            <label for="catatan_tambahan">Catatan Tambahan (Opsional)</label>
            <textarea id="catatan_tambahan" name="catatan_tambahan" rows="3" placeholder="Contoh: Permintaan khusus (kamar non-smoking, preferensi diet), alergi makanan, dll."></textarea>
          </div>

          <div class="form-actions">
            <button type="button" class="btn btn-secondary" onclick="window.location.href='paket_wisata_detail.php?id=<?php echo htmlspecialchars($id_paket); ?>';">
              <i class="fas fa-arrow-left"></i> Kembali
            </button>
            <button type="submit" class="btn btn-primary">
              Lanjutkan ke Pembayaran <i class="fas fa-arrow-right"></i>
            </button>
          </div>
        </form>
      </div>

      <div class="order-summary">
        <h2>Ringkasan Pesanan</h2>

        <?php if ($paket_info): ?>
        <div class="package-info">
          <h3 id="summary_package_name"><?php echo htmlspecialchars($paket_info['nama_paket']); ?></h3>
          <p><i class="fas fa-calendar-alt"></i> <span id="summary_duration"><?php echo htmlspecialchars($paket_info['durasi_paket']); ?></span></p>
          <p><i class="fas fa-map-marker-alt"></i> <span id="summary_location"><?php echo htmlspecialchars($paket_info['nama_wilayah'] ?? 'N/A'); ?></span></p>
        </div>

        <h4 class="price-detail-title" id="title_rincian_harga">Rincian Harga <?php echo $is_paket_keluarga ? 'Paket Keluarga' : 'per Orang'; ?>:</h4>
        <?php if (!empty($item_termasuk_list)): ?>
            <?php
                $subtotal_komponen_per_orang_display = 0;
                foreach ($item_termasuk_list as $item):
                if (isset($item['harga_komponen']) && floatval($item['harga_komponen']) > 0) {
                    $subtotal_komponen_per_orang_display += floatval($item['harga_komponen']);
            ?>
                <div class="price-row">
                    <span class="label"><i class="fas fa-check"></i><?php echo htmlspecialchars($item['termasuk']); ?></span>
                    <span class="value"><?php echo format_rupiah($item['harga_komponen']); ?></span>
                </div>
            <?php
                } elseif (!empty($item['termasuk'])) {
            ?>
                    <div class="price-row">
                    <span class="label"><i class="fas fa-check"></i><?php echo htmlspecialchars($item['termasuk']); ?></span>
                    <span class="value">Termasuk</span>
                </div>
            <?php
                }
                endforeach;
            ?>
            <div class="price-row" style="border-top: 1px dashed #ccc; padding-top: 0.6rem; margin-top:0.6rem;">
                <span class="label" style="font-weight:bold;" id="label_harga_dasar_paket">Harga Dasar Paket <?php echo $is_paket_keluarga ? '(Keluarga)' : '(per Orang)'; ?></span>
                <span class="value" style="font-weight:bold;" id="summary_harga_dasar_paket_display"><?php echo format_rupiah($harga_paket_untuk_kalkulasi); ?></span>
            </div>
        <?php else: ?>
            <p style="font-size:0.9rem; color:#777;">Rincian fasilitas tidak tersedia.</p>
        <?php endif; ?>

        <h4 class="price-detail-title" style="margin-top: 1.5rem;">Kalkulasi Total:</h4>
        <div class="price-row">
            <span class="label" id="summary_label_jumlah">Jumlah Peserta</span>
            <span class="value" id="summary_jumlah_display">1 Orang</span>
        </div>
        <div class="price-row">
            <span class="label">Subtotal Paket</span>
            <span class="value" id="summary_subtotal_paket"><?php echo format_rupiah($harga_paket_untuk_kalkulasi); ?></span>
        </div>
        <div class="price-row">
            <span class="label">Biaya Administrasi</span>
            <span class="value" id="summary_biaya_admin"><?php echo format_rupiah(10000); ?></span>
        </div>
        <div class="price-row price-total">
            <span>Total Pembayaran</span>
            <span id="summary_total_pembayaran"><?php echo format_rupiah($harga_paket_untuk_kalkulasi + 10000); ?></span>
        </div>
        <?php else: ?>
            <p style="font-size:0.9rem; color:#777;">Gagal memuat ringkasan pesanan. Silakan pilih paket yang valid.</p>
        <?php endif; ?>
      </div>
    </div>
  </main>

  <?php include 'Komponen/footer.php'; ?>

  <script>
  document.addEventListener('DOMContentLoaded', function() {
      const jumlahPesertaInput = document.getElementById('jumlah_peserta');
      const hargaPerOrangHidden = document.getElementById('base_price_package_hidden');
      const isFamilyPackageHidden = document.getElementById('is_family_package_hidden');

      const hargaPaketUntukKalkulasi = hargaPerOrangHidden ? parseFloat(hargaPerOrangHidden.value) : 0;
      const isFamilyPackage = isFamilyPackageHidden ? (isFamilyPackageHidden.value === '1') : false;
      const biayaAdmin = 10000;

      const summaryJumlahDisplay = document.getElementById('summary_jumlah_display');
      const summarySubtotalPaket = document.getElementById('summary_subtotal_paket');
      const summaryTotalPembayaran = document.getElementById('summary_total_pembayaran');
      const totalHargaKeseluruhanHiddenInput = document.getElementById('total_harga_keseluruhan_hidden');
      const summaryHargaDasarPaketDisplay = document.getElementById('summary_harga_dasar_paket_display');
      const labelJumlahPeserta = document.getElementById('label_jumlah_peserta');
      const infoPaketKeluarga = document.getElementById('info_paket_keluarga');
      const titleRincianHarga = document.getElementById('title_rincian_harga');
      const labelHargaDasarPaket = document.getElementById('label_harga_dasar_paket');
      const summaryLabelJumlah = document.getElementById('summary_label_jumlah');

      const additionalPassengersContainer = document.getElementById('additional_passengers_container');
      const primaryBookerForm = document.getElementById('primary_booker_form');

      if (isFamilyPackage) {
          if(labelJumlahPeserta) labelJumlahPeserta.textContent = 'Paket Keluarga (Harga Tetap)';
          if(jumlahPesertaInput) {
              jumlahPesertaInput.value = 1;
              jumlahPesertaInput.disabled = true;
          }
          if(infoPaketKeluarga) infoPaketKeluarga.style.display = 'block';
          if(titleRincianHarga) titleRincianHarga.textContent = 'Rincian Harga Paket Keluarga:';
          if(labelHargaDasarPaket) labelHargaDasarPaket.textContent = 'Harga Dasar Paket (Keluarga)';
          if(summaryLabelJumlah) summaryLabelJumlah.textContent = 'Jumlah';
      }

      function updateRingkasanHarga() {
          let jumlah = 1;
          if (!isFamilyPackage && jumlahPesertaInput) {
              jumlah = parseInt(jumlahPesertaInput.value) || 0;
          } else if (isFamilyPackage) {
              if (jumlahPesertaInput && jumlahPesertaInput.disabled) {
                  jumlah = parseInt(jumlahPesertaInput.value);
              }
          }

          if (hargaPaketUntukKalkulasi === 0) {
                  if(summaryJumlahDisplay) summaryJumlahDisplay.textContent = isFamilyPackage ? '1 Paket Keluarga' : jumlah + ' Orang';
                  if(summarySubtotalPaket) summarySubtotalPaket.textContent = 'N/A';
    
                  if(summaryTotalPembayaran) summaryTotalPembayaran.textContent = 'N/A';
                  if(totalHargaKeseluruhanHiddenInput) totalHargaKeseluruhanHiddenInput.value = 0;
                  return;
          }
          if (jumlah <= 0 && !isFamilyPackage) {
              if(summaryJumlahDisplay) summaryJumlahDisplay.textContent = '0 Orang';
              if(summarySubtotalPaket) summarySubtotalPaket.textContent = formatRupiahJS(0);
              if(summaryTotalPembayaran) summaryTotalPembayaran.textContent = formatRupiahJS(biayaAdmin);
              if(totalHargaKeseluruhanHiddenInput) totalHargaKeseluruhanHiddenInput.value = biayaAdmin;
              return;
          }

          let subtotalPaket;
          if (isFamilyPackage) {
              subtotalPaket = hargaPaketUntukKalkulasi;
          } else {
              subtotalPaket = hargaPaketUntukKalkulasi * jumlah;
          }


          const total = subtotalPaket + biayaAdmin;

          if(summaryJumlahDisplay) summaryJumlahDisplay.textContent = isFamilyPackage ? '1 Paket Keluarga' : jumlah + ' Orang';
          if(summarySubtotalPaket) summarySubtotalPaket.textContent = formatRupiahJS(subtotalPaket);

          if(summaryTotalPembayaran) summaryTotalPembayaran.textContent = formatRupiahJS(total);
          if(totalHargaKeseluruhanHiddenInput) totalHargaKeseluruhanHiddenInput.value = total;
      }

      function formatRupiahJS(angka) {
          if (isNaN(angka) || angka === null) return 'Rp 0';
          return 'Rp ' + parseFloat(angka).toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ".");
      }

      function generatePassengerForm(index) {
          const passengerNum = index + 1; // Actual passenger number for display
          return `
              <div class="passenger-form-group" id="passenger_form_${index}">
                  <h3>Data Peserta Tambahan ${passengerNum -1 }</h3> 
                  <div class="form-row">
                      <div class="form-group">
                          <label for="nama_lengkap_peserta_${index}">Nama Lengkap Peserta ${passengerNum -1}</label>
                          <input type="text" id="nama_lengkap_peserta_${index}" name="peserta[${index}][nama_lengkap]" placeholder="Nama peserta ${passengerNum -1}" required>
                      </div>
                      <div class="form-group">
                          <label for="no_ktp_peserta_${index}">NIK Peserta ${passengerNum-1}</label>
                          <input type="text" id="no_ktp_peserta_${index}" name="peserta[${index}][no_ktp]" placeholder="16 digit NIK peserta ${passengerNum-1}" required pattern="[0-9]{16}" title="NIK harus 16 digit angka.">
                      </div>
                  </div>
                  <div class="form-row">
                      <div class="form-group">
                          <label for="tanggal_lahir_peserta_${index}">Tanggal Lahir Peserta ${passengerNum-1}</label>
                          <input type="date" id="tanggal_lahir_peserta_${index}" name="peserta[${index}][tanggal_lahir]" required>
                      </div>
                      <div class="form-group">
                          <label for="jenis_kelamin_peserta_${index}">Jenis Kelamin Peserta ${passengerNum-1}</label>
                          <select id="jenis_kelamin_peserta_${index}" name="peserta[${index}][jenis_kelamin]" required>
                              <option value="">Pilih Jenis Kelamin</option>
                              <option value="Laki-laki">Laki-laki</option>
                              <option value="Perempuan">Perempuan</option>
                          </select>
                      </div>
                  </div>
              </div>
          `;
      }

      function updatePassengerForms() {
          if (isFamilyPackage) {
              additionalPassengersContainer.innerHTML = '';
              return;
          }

          const currentNumPassengers = parseInt(jumlahPesertaInput.value) || 0;
          
          // Clear existing additional passenger forms
          additionalPassengersContainer.innerHTML = '';

          // Start adding forms from the second participant
          // The first participant's data is the primary booker
          if (currentNumPassengers > 1) {
              for (let i = 1; i < currentNumPassengers; i++) { // Loop from 1 up to (but not including) currentNumPassengers
                  additionalPassengersContainer.insertAdjacentHTML('beforeend', generatePassengerForm(i));
              }
          }
      }

      if (hargaPerOrangHidden) {
          if (jumlahPesertaInput) {
              jumlahPesertaInput.addEventListener('input', function() {
                  updateRingkasanHarga();
                  updatePassengerForms();
              });
          }
          if (summaryHargaDasarPaketDisplay) {
              summaryHargaDasarPaketDisplay.textContent = formatRupiahJS(hargaPaketUntukKalkulasi);
          }
          updateRingkasanHarga();
          updatePassengerForms(); // Initial call
      }

      const tanggalKeberangkatanInput = document.getElementById('tanggal_keberangkatan');
      if (tanggalKeberangkatanInput) {
          const today = new Date();
          today.setDate(today.getDate() + 2);
          const minDate = today.toISOString().split('T')[0];
          tanggalKeberangkatanInput.setAttribute('min', minDate);
      }
  });
  </script>
</body>
</html>