<?php
session_start(); // WAJIB di paling atas untuk menggunakan session

include 'koneksi.php';

if (!isset($conn) || !($conn instanceof mysqli) || $conn->connect_error) {
    $_SESSION['error_message_system'] = "Koneksi database gagal atau tidak valid. Harap hubungi administrator.";
    if (isset($conn) && $conn->connect_error) {
        error_log("MySQL connection error in proses_pemesanan.php: " . $conn->connect_error);
    } else {
        error_log("Variable \$conn tidak terdefinisi atau bukan objek mysqli yang valid setelah include koneksi.php di proses_pemesanan.php. Path yang digunakan: 'koneksi.php'");
    }
    echo "<div style='text-align:center; padding: 50px; font-family: Arial, sans-serif; background-color: #fff1f1; border: 1px solid #d9534f; margin: 20px;'>";
    echo "<h1 style='color: #d9534f;'>Error Sistem Kritis</h1>";
    echo "<p style='font-size: 1.1em; color: #555;'>Tidak dapat terhubung ke database untuk memproses pesanan Anda.</p>";
    echo "<p style='font-size: 0.9em; color: #777;'>Pastikan file koneksi ('koneksi.php') sudah benar, dapat diakses di dalam folder 'backend', dan konfigurasi database valid.</p>";
    echo "<p><a href='../index.php' style='display:inline-block; margin-top:20px; padding:10px 20px; background-color:#2c7a51; color:white; text-decoration:none; border-radius:5px;'>Kembali ke Beranda</a></p>";
    echo "</div>";
    exit;
}

if (!function_exists('format_rupiah')) {
    function format_rupiah($number) {
        return 'Rp ' . number_format(floatval($number), 0, ',', '.');
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 1. Ambil Data dari Form POST & Sanitasi Dasar (Primary Booker)
    $id_paket_wisata_str = isset($_POST['id_paket_wisata']) ? $_POST['id_paket_wisata'] : null;
    $nama_lengkap_raw = isset($_POST['nama_lengkap_pemesan']) ? $_POST['nama_lengkap_pemesan'] : null; // Changed name
    $email_raw = isset($_POST['email_pemesan']) ? $_POST['email_pemesan'] : null;     // Changed name
    $no_telepon_raw = isset($_POST['no_telepon_pemesan']) ? $_POST['no_telepon_pemesan'] : null; // Changed name
    $no_ktp_raw = isset($_POST['no_ktp_pemesan']) ? $_POST['no_ktp_pemesan'] : null;     // Changed name
    $alamat_raw = isset($_POST['alamat_pemesan']) ? $_POST['alamat_pemesan'] : null;     // Changed name

    $tanggal_keberangkatan_input = isset($_POST['tanggal_keberangkatan']) ? $_POST['tanggal_keberangkatan'] : null;
    $jumlah_peserta_raw = isset($_POST['jumlah_peserta']) ? $_POST['jumlah_peserta'] : '1';
    $catatan_tambahan_raw = isset($_POST['catatan_tambahan']) ? $_POST['catatan_tambahan'] : null;
    $total_harga_keseluruhan_dari_form = isset($_POST['total_harga_keseluruhan_hidden']) ? floatval($_POST['total_harga_keseluruhan_hidden']) : 0;

    $nama_paket_dipesan_form = isset($_POST['nama_paket_dipesan']) ? $_POST['nama_paket_dipesan'] : 'Tidak Diketahui';
    $durasi_paket_dipesan_form = isset($_POST['durasi_paket_dipesan']) ? $_POST['durasi_paket_dipesan'] : '-';
    $is_family_package_from_form = isset($_POST['is_family_package_hidden']) && $_POST['is_family_package_hidden'] === '1';


    // --- PERBAIKAN: Validasi dan Format Tanggal Keberangkatan ---
    $tanggal_keberangkatan_sql = null;
    if (!empty($tanggal_keberangkatan_input)) {
        try {
            $date_obj = DateTime::createFromFormat('Y-m-d', $tanggal_keberangkatan_input);
            if ($date_obj && $date_obj->format('Y-m-d') === $tanggal_keberangkatan_input) {
                $tanggal_keberangkatan_sql = $tanggal_keberangkatan_input; // Format sudah benar
            } else {
                // Coba format lain jika mungkin (walaupun type="date" seharusnya Y-m-d)
                $date_obj_alt = date_create($tanggal_keberangkatan_input);
                if ($date_obj_alt) {
                    $tanggal_keberangkatan_sql = date_format($date_obj_alt, 'Y-m-d');
                } else {
                    $_SESSION['error_message_pemesanan'] = "Format tanggal keberangkatan tidak valid. Harap gunakan format YYYY-MM-DD.";
                    header("Location: ../pemesanan.php?id_paket=" . urlencode($id_paket_wisata_str));
                    exit;
                }
            }
        } catch (Exception $e) {
            $_SESSION['error_message_pemesanan'] = "Terjadi kesalahan dalam memproses tanggal keberangkatan.";
            header("Location: ../pemesanan.php?id_paket=" . urlencode($id_paket_wisata_str));
            exit;
        }
    }
    // --- AKHIR PERBAIKAN TANGGAL ---

    // Sanitasi setelah validasi format (jika diperlukan)
    $id_paket_wisata = $id_paket_wisata_str ? (int)$id_paket_wisata_str : null; // Casting ke integer
    $nama_lengkap = $nama_lengkap_raw ? mysqli_real_escape_string($conn, trim($nama_lengkap_raw)) : null;
    $email = $email_raw ? mysqli_real_escape_string($conn, trim($email_raw)) : null;
    $no_telepon = $no_telepon_raw ? mysqli_real_escape_string($conn, trim($no_telepon_raw)) : null;
    $no_ktp = $no_ktp_raw ? mysqli_real_escape_string($conn, trim($no_ktp_raw)) : null;
    $alamat = $alamat_raw ? mysqli_real_escape_string($conn, trim($alamat_raw)) : null;
    $jumlah_peserta = (int)$jumlah_peserta_raw;
    $catatan_tambahan = $catatan_tambahan_raw ? mysqli_real_escape_string($conn, trim($catatan_tambahan_raw)) : null;


    // 2. Validasi Data Utama (Primary Booker)
    if (empty($id_paket_wisata) || empty($nama_lengkap) || empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($no_telepon) || empty($no_ktp) || empty($alamat) || empty($tanggal_keberangkatan_sql) || $jumlah_peserta <= 0 || $total_harga_keseluruhan_dari_form <= 0) {
        $_SESSION['error_message_pemesanan'] = "Semua field Data Pemesan Utama dan Detail Perjalanan wajib diisi dengan benar dan valid. Pastikan tanggal keberangkatan juga valid. (Error Code: VLD01)";
        header("Location: ../pemesanan.php?id_paket=" . urlencode($id_paket_wisata_str));
        exit;
    }

    // 3. Generate Kode Pemesanan Unik
    $kode_pemesanan = "GT-" . strtoupper(substr(md5(uniqid(rand(), true)), 0, 10));

    // 4. Ambil Detail Paket dari Database
    $paket_detail_sql = "SELECT nama_paket, durasi_paket, harga, id_jenis_paket FROM paket_wisata WHERE id_paket_wisata = ? LIMIT 1"; // Added id_jenis_paket
    $stmt_paket = mysqli_prepare($conn, $paket_detail_sql);
    if ($stmt_paket) {
        mysqli_stmt_bind_param($stmt_paket, "i", $id_paket_wisata); // Bind sebagai integer
        mysqli_stmt_execute($stmt_paket);
        $paket_detail_result = mysqli_stmt_get_result($stmt_paket);

        if ($paket_detail_result && mysqli_num_rows($paket_detail_result) > 0) {
            $paket_db_row = mysqli_fetch_assoc($paket_detail_result);
            $nama_paket_db_valid = $paket_db_row['nama_paket'];
            $durasi_paket_db_valid = $paket_db_row['durasi_paket'];
            // Check if package is actually a family package from DB, not just form hidden input
            $db_id_jenis_paket = $paket_db_row['id_jenis_paket'];
            // Assuming 3 is the ID for family packages (as per your frontend script)
            $is_family_package_validated = ($db_id_jenis_paket == 3);
        } else {
            $_SESSION['error_message_pemesanan'] = "Paket wisata yang dipilih tidak valid (ID: ".htmlspecialchars($id_paket_wisata_str).").";
            header("Location: ../paket_wisata.php");
            exit;
        }
        mysqli_stmt_close($stmt_paket);
    } else {
        error_log("Gagal mempersiapkan statement untuk mengambil detail paket: " . mysqli_error($conn));
        $_SESSION['error_message_system'] = "Terjadi kesalahan saat memverifikasi paket. Silakan coba lagi.";
        header("Location: ../pemesanan.php?id_paket=" . urlencode($id_paket_wisata_str));
        exit;
    }

    // 5. Simpan Data Pemesanan Awal ke Database
    $status_pemesanan_awal = 'pending';
    // Pastikan urutan kolom di INSERT INTO sesuai dengan urutan parameter di bind_param
    $insert_pemesanan_sql = "INSERT INTO pemesanan
                             (kode_pemesanan, id_paket_wisata, nama_lengkap, email, no_telepon, no_ktp, alamat, tanggal_keberangkatan, jumlah_peserta, catatan_tambahan, total_harga, status_pemesanan, tanggal_pemesanan)
                             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

    $stmt_insert = mysqli_prepare($conn, $insert_pemesanan_sql);
    if ($stmt_insert) {
        mysqli_stmt_bind_param($stmt_insert, "sissssssisds",
            $kode_pemesanan,
            $id_paket_wisata,
            $nama_lengkap, // Primary booker's name
            $email,       // Primary booker's email
            $no_telepon,  // Primary booker's phone
            $no_ktp,      // Primary booker's KTP
            $alamat,      // Primary booker's address
            $tanggal_keberangkatan_sql,
            $jumlah_peserta,
            $catatan_tambahan,
            $total_harga_keseluruhan_dari_form,
            $status_pemesanan_awal
        );

        if (mysqli_stmt_execute($stmt_insert)) {
            $_SESSION['id_db_pemesanan'] = mysqli_insert_id($conn);
            $id_pemesanan_baru = $_SESSION['id_db_pemesanan']; // Get the new booking ID
        } else {
            // Error saat execute
            error_log("Gagal menyimpan pemesanan awal ke DB (Order: ".$kode_pemesanan."): " . mysqli_stmt_error($stmt_insert));
            $_SESSION['error_message_system'] = "Terjadi kesalahan saat menyimpan pesanan Anda (DBExecuteError). Error: " . mysqli_stmt_error($stmt_insert);
            header("Location: ../pemesanan.php?id_paket=" . urlencode($id_paket_wisata_str));
            exit;
        }
        mysqli_stmt_close($stmt_insert);
    } else {
        error_log("Gagal mempersiapkan statement insert pemesanan: " . mysqli_error($conn));
        $_SESSION['error_message_system'] = "Pemesanan Anda akan diproses, namun ada sedikit kendala sistem (DBPrepareError).";
        header("Location: ../pemesanan.php?id_paket=" . urlencode($id_paket_wisata_str));
        exit;
    }

    // --- NEW: Handle Additional Participants' Data ---
    // This part should only run if it's NOT a family package AND jumlah_peserta > 1
    if (!$is_family_package_validated && $jumlah_peserta > 1 && isset($_POST['peserta']) && is_array($_POST['peserta'])) {
        // Prepare for inserting multiple participants
        $insert_peserta_sql = "INSERT INTO detail_peserta_pemesanan
                               (id_pemesanan, nama_lengkap, no_ktp, tanggal_lahir, jenis_kelamin)
                               VALUES (?, ?, ?, ?, ?)";
        $stmt_peserta = mysqli_prepare($conn, $insert_peserta_sql);

        if ($stmt_peserta) {
            // Loop through each participant data submitted from the form
            foreach ($_POST['peserta'] as $index => $peserta_data) {
                // Sanitize and validate each participant's data
                $nama_lengkap_peserta = isset($peserta_data['nama_lengkap']) ? mysqli_real_escape_string($conn, trim($peserta_data['nama_lengkap'])) : null;
                $no_ktp_peserta = isset($peserta_data['no_ktp']) ? mysqli_real_escape_string($conn, trim($peserta_data['no_ktp'])) : null;
                $tanggal_lahir_peserta_raw = isset($peserta_data['tanggal_lahir']) ? $peserta_data['tanggal_lahir'] : null;
                $jenis_kelamin_peserta = isset($peserta_data['jenis_kelamin']) ? mysqli_real_escape_string($conn, trim($peserta_data['jenis_kelamin'])) : null;

                // Basic validation for participant data
                if (empty($nama_lengkap_peserta) || empty($no_ktp_peserta) || empty($tanggal_lahir_peserta_raw) || empty($jenis_kelamin_peserta)) {
                    // Log the error and potentially redirect back or show a warning
                    error_log("Data peserta tidak lengkap untuk peserta indeks $index pada pemesanan $id_pemesanan_baru.");
                    // You might choose to skip this participant or trigger an error message for the user.
                    // For now, we'll log and continue, but robust applications would need better error handling here.
                    continue; // Skip to the next participant if data is invalid
                }

                // Validate and format tanggal_lahir_peserta
                $tanggal_lahir_peserta_sql = null;
                try {
                    $date_obj_peserta = DateTime::createFromFormat('Y-m-d', $tanggal_lahir_peserta_raw);
                    if ($date_obj_peserta && $date_obj_peserta->format('Y-m-d') === $tanggal_lahir_peserta_raw) {
                        $tanggal_lahir_peserta_sql = $tanggal_lahir_peserta_raw;
                    } else {
                        error_log("Format tanggal lahir peserta $index tidak valid: $tanggal_lahir_peserta_raw");
                        continue; // Skip if date format is bad
                    }
                } catch (Exception $e) {
                    error_log("Kesalahan parsing tanggal lahir peserta $index: " . $e->getMessage());
                    continue; // Skip on exception
                }

                // Bind parameters and execute for each participant
                mysqli_stmt_bind_param($stmt_peserta, "issss",
                    $id_pemesanan_baru, // Link to the main booking
                    $nama_lengkap_peserta,
                    $no_ktp_peserta,
                    $tanggal_lahir_peserta_sql,
                    $jenis_kelamin_peserta
                );

                if (!mysqli_stmt_execute($stmt_peserta)) {
                    error_log("Gagal menyimpan detail peserta ke DB untuk pemesanan $id_pemesanan_baru (Peserta indeks $index): " . mysqli_stmt_error($stmt_peserta));
                    // Consider rolling back the main pemesanan if participant details fail
                    // Or add a warning message to the session for the user
                }
            }
            mysqli_stmt_close($stmt_peserta);
        } else {
            error_log("Gagal mempersiapkan statement insert detail peserta: " . mysqli_error($conn));
            // Add a warning message, but don't stop the main booking process
            $_SESSION['error_message_system'] = "Ada masalah saat menyimpan detail peserta, namun pesanan utama Anda sedang diproses. Silakan hubungi kami untuk konfirmasi detail peserta.";
        }
    }
    // --- END NEW: Handle Additional Participants' Data ---

    // 6. Simpan Data ke SESSION (Updated for clarity and consistency)
    $_SESSION['kode_pemesanan'] = $kode_pemesanan;
    $_SESSION['id_paket_wisata_dipesan'] = $id_paket_wisata;
    $_SESSION['nama_paket_dipesan'] = $nama_paket_db_valid;
    $_SESSION['durasi_paket_dipesan'] = $durasi_paket_db_valid;
    $_SESSION['jumlah_peserta_dipesan'] = $jumlah_peserta;
    $_SESSION['total_harga_akhir'] = $total_harga_keseluruhan_dari_form;
    $_SESSION['nama_lengkap_pemesan'] = $nama_lengkap;
    $_SESSION['email_pemesan'] = $email;
    $_SESSION['telepon_pemesan'] = $no_telepon;
    $_SESSION['no_ktp_pemesan'] = $no_ktp;
    $_SESSION['alamat_pemesan'] = $alamat;
    $_SESSION['tanggal_keberangkatan_pemesan'] = $tanggal_keberangkatan_sql;
    $_SESSION['catatan_tambahan_pemesan'] = $catatan_tambahan;
    $_SESSION['is_family_package'] = $is_family_package_validated; // Use validated value from DB

    // 7. Redirect ke Halaman Pembayaran
    header("Location: ../pembayaran.php");
    exit;

} else {
    // Jika halaman diakses langsung tanpa POST
    header("Location: ../index.php");
    exit;
}
?>