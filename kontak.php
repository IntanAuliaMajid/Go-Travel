<?php
// PASTIKAN INI ADALAH BARIS PERTAMA DALAM FILE, TANPA SPASI ATAU APAPUN SEBELUMNYA
include 'Komponen/navbar.php';

require_once 'backend/koneksi.php'; // Koneksi database

$form_submission_message = '';
$form_message_type = '';
$submitted_values = [
    'firstName' => '', 'lastName' => '', 'email' => '',
    'phone' => '', 'subject' => '', 'message' => ''
];

// Proses form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_contact_form'])) {
    $firstName = trim($conn->real_escape_string($_POST['firstName']));
    $lastName = trim($conn->real_escape_string($_POST['lastName']));
    $email_form = trim($conn->real_escape_string($_POST['email']));
    $phone = trim($conn->real_escape_string($_POST['phone']));
    $subject = trim($conn->real_escape_string($_POST['subject']));
    $message_content = trim($conn->real_escape_string($_POST['message']));

    // Isi kembali nilai yang disubmit untuk ditampilkan jika ada error
    $submitted_values = $_POST;

    if (empty($firstName) || empty($lastName) || empty($email_form) || empty($subject) || empty($message_content)) {
        $_SESSION['form_message'] = "Harap lengkapi semua field yang wajib diisi (*).";
        $_SESSION['form_message_type'] = 'error';
        $_SESSION['form_submitted_values'] = $submitted_values; // Simpan nilai form di session
        header("Location: kontak.php#formMessageScrollTarget"); // Redirect kembali ke form
        exit;
    } elseif (!filter_var($email_form, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['form_message'] = "Format email tidak valid.";
        $_SESSION['form_message_type'] = 'error';
        $_SESSION['form_submitted_values'] = $submitted_values;
        header("Location: kontak.php#formMessageScrollTarget");
        exit;
    } else {
        $sql_insert_message = "INSERT INTO contact_messages (first_name, last_name, email, phone, subject, message)
                               VALUES (?, ?, ?, ?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert_message);
        if ($stmt_insert) {
            $stmt_insert->bind_param("ssssss", $firstName, $lastName, $email_form, $phone, $subject, $message_content);
            if ($stmt_insert->execute()) {
                $_SESSION['form_message'] = "Pesan Anda berhasil dikirim! Kami akan segera menghubungi Anda.";
                $_SESSION['form_message_type'] = 'success';
                // Tidak perlu menyimpan submitted_values lagi karena form akan kosong setelah sukses
                header("Location: kontak.php#formMessageScrollTarget");
                exit;
            } else {
                $_SESSION['form_message'] = "Terjadi kesalahan saat mengirim pesan: " . $stmt_insert->error;
                $_SESSION['form_message_type'] = 'error';
                $_SESSION['form_submitted_values'] = $submitted_values;
            }
            $stmt_insert->close();
        } else {
             $_SESSION['form_message'] = "Gagal mempersiapkan statement: " . $conn->error;
             $_SESSION['form_message_type'] = 'error';
             $_SESSION['form_submitted_values'] = $submitted_values;
        }
        header("Location: kontak.php#formMessageScrollTarget");
        exit;
    }
}

// Ambil pesan dan nilai form dari session jika ada (setelah redirect)
if (isset($_SESSION['form_message'])) {
    $form_submission_message = $_SESSION['form_message'];
    $form_message_type = $_SESSION['form_message_type'];
    unset($_SESSION['form_message']);
    unset($_SESSION['form_message_type']);

    if (isset($_SESSION['form_submitted_values'])) {
        $submitted_values = $_SESSION['form_submitted_values'];
        unset($_SESSION['form_submitted_values']);
    }
}


// --- Fetch Contact Info ---
$contact_info = null;
$office_hours_parsed = [];
// Default values jika tidak ada data di DB
$default_contact_info = [
    'alamat_kantor' => 'Jl. Contoh Alamat No. 1, Kota Contoh, 12345',
    'telepon' => '(021) 000-0000',
    'email' => 'kontak@example.com',
    'website' => 'www.example.com',
    'jam_operasional' => 'Senin - Jumat: 09:00 - 17:00, Sabtu: 09:00 - 13:00, Minggu: Tutup'
];

$sql_kontak = "SELECT id_kontak, alamat_kantor, telepon, email, website, jam_operasional FROM kontak ORDER BY id_kontak ASC LIMIT 1";
$result_kontak = $conn->query($sql_kontak);
if ($result_kontak && $result_kontak->num_rows > 0) {
    $contact_info = $result_kontak->fetch_assoc();
} else {
    $contact_info = $default_contact_info;
}

// Parse jam_operasional
if (!empty($contact_info['jam_operasional'])) {
    $hours_entries = explode(',', $contact_info['jam_operasional']);
    foreach ($hours_entries as $entry) {
        $parts = explode(':', $entry, 2);
        if (count($parts) == 2) {
            $office_hours_parsed[] = ['day' => trim($parts[0]), 'time' => trim($parts[1])];
        } else {
            $office_hours_parsed[] = ['day' => trim($parts[0]),'time' => '']; // Atau 'Tutup'
        }
    }
}


// --- Fetch FAQ Data ---
$faq_list = [];
$sql_faq = "SELECT id_faq, pertanyaan, jawaban FROM faq WHERE is_active = TRUE ORDER BY urutan_tampil ASC, id_faq ASC";
$result_faq = $conn->query($sql_faq);
if ($result_faq && $result_faq->num_rows > 0) {
    while ($row_faq = $result_faq->fetch_assoc()) {
        $faq_list[] = $row_faq;
    }
}

// SETELAH SEMUA LOGIKA PHP SELESAI, BARU INCLUDE NAVBAR DAN MULAI HTML

?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Kontak Kami - GoTravel</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
    /* ... (CSS Anda dari sebelumnya tetap di sini, pastikan tidak ada duplikasi) ... */
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f7f9fc; color: #333; line-height: 1.6; }
    .hero { background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('https://akasiamas.com/cfind/source/thumb/images/images/content/cover_w970_h499_kontak.jpg') no-repeat center center/cover; height: 60vh; display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; color: #fff; padding: 2rem; }
    .hero h1 { font-size: 2.8rem; margin-bottom: 1rem; text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5); }
    .hero p { font-size: 1.1rem; max-width: 600px; margin: 0 auto; }
    .container { max-width: 1200px; margin: 0 auto; padding: 0 1rem; }
    .contact-section { padding: 3rem 0; }
    .contact-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 2.5rem; margin-top: 2rem; }
    .contact-form-container, .contact-info { background-color: #fff; padding: 2.5rem; border-radius: 10px; box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08); }
    .contact-form-container h2, .contact-info h2 { color: #2c7a51; margin-bottom: 1.5rem; font-size: 1.6rem; }
    .form-group { margin-bottom: 1.25rem; }
    .form-group label { display: block; margin-bottom: 0.5rem; font-weight: 500; color: #495057; }
    .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 0.85rem; border: 1px solid #ced4da; border-radius: 5px; font-size: 0.95rem; transition: border-color 0.3s, box-shadow 0.3s; }
    .form-group input:focus, .form-group select:focus, .form-group textarea:focus { outline: none; border-color: #2c7a51; box-shadow: 0 0 0 0.2rem rgba(44, 122, 81, 0.25); }
    .form-group textarea { height: 120px; resize: vertical; }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; }
    .submit-btn { background-color: #2c7a51; color: white; border: none; padding: 0.85rem 2rem; border-radius: 5px; cursor: pointer; font-size: 1rem; transition: background-color 0.3s; width: 100%; }
    .submit-btn:hover { background-color: #1d5b3a; }
    .form-message { padding: 1rem; border-radius: 5px; margin-bottom: 1rem; font-size: 0.95rem; }
    .form-message.success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    .form-message.error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    .info-item { display: flex; align-items: flex-start; margin-bottom: 1.5rem; padding: 1.25rem; background-color: #f8f9fa; border-radius: 8px; transition: transform 0.2s ease, box-shadow 0.2s ease; border: 1px solid #e9ecef; }
    .info-item:hover { transform: translateY(-3px); box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); }
    .info-icon { width: 45px; height: 45px; background-color: #2c7a51; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 1.25rem; flex-shrink: 0; }
    .info-icon i { color: white; font-size: 1.1rem; }
    .info-content h3 { margin-bottom: 0.3rem; color: #333; font-size: 1.1rem; }
    .info-content p { color: #555; margin-bottom: 0.25rem; font-size:0.95rem; word-break: break-word; }
    .info-content p a { color: #2c7a51; text-decoration: none;}
    .info-content p a:hover { text-decoration: underline;}
    .map-section { padding: 3rem 0; background-color: #eef7ed; }
    .section-heading { text-align: center; margin-bottom: 2.5rem; color: #2c7a51; }
    .section-heading h2 { font-size: 2.2rem; margin-bottom: 0.5rem; }
    .section-heading p { color: #555; max-width: 700px; margin: 0 auto; }
    .map-container { background-color: #fff; border-radius: 10px; overflow: hidden; box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08); height: 400px; display: flex; align-items: center; justify-content: center; color: #555; font-size: 1.1rem; }
    .map-container iframe {width: 100%; height: 100%; border:0;}
    .faq-section { padding: 3rem 0; }
    .faq-container { max-width: 800px; margin: 0 auto; }
    .faq-item { background-color: #fff; margin-bottom: 1rem; border-radius: 8px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.07); overflow: hidden; border: 1px solid #e9ecef; }
    .faq-question { padding: 1.25rem; background-color: #fff; cursor: pointer; transition: background-color 0.2s; display: flex; justify-content: space-between; align-items: center; }
    .faq-question:hover { background-color: #f8f9fa; }
    .faq-question h3 { margin: 0; color: #2c7a51; font-size: 1.1rem; font-weight: 500; }
    .faq-toggle { font-size: 1rem; color: #2c7a51; transition: transform 0.3s ease-in-out; }
    .faq-item.active .faq-toggle { transform: rotate(45deg); }
    .faq-answer { padding: 0 1.5rem; max-height: 0; overflow: hidden; transition: max-height 0.35s ease-in-out, padding 0.35s ease-in-out; background-color: #fdfdff; border-top: 1px solid #e9ecef;}
    .faq-item.active .faq-answer { padding: 1.5rem; max-height: 250px; }
    .faq-answer p { color: #555; line-height: 1.7; }
    .office-hours { background-color: #f8f9fa; padding: 1.5rem; border-radius: 8px; margin-top: 1.5rem; border: 1px solid #e9ecef; }
    .office-hours h3 { color: #2c7a51; margin-bottom: 1rem; font-size: 1.1rem; }
    .hours-grid { display: grid; grid-template-columns: auto 1fr; gap: 0.5rem 1rem; }
    .hour-item { display: contents; }
    .hour-day { font-weight: 500; color: #333; padding: 0.3rem 0; }
    .hour-time { color: #555; padding: 0.3rem 0; }
    @media (max-width: 768px) { .hero h1 { font-size: 2.2rem; } .contact-grid { grid-template-columns: 1fr; gap: 2rem; } .form-row { grid-template-columns: 1fr; } .section-heading h2 { font-size: 1.8rem; } .contact-form-container, .contact-info {padding: 1.5rem;} .hours-grid {grid-template-columns: auto 1fr;} }
  </style>
</head>
<body>
  <section class="hero">
    <h1>Hubungi Kami</h1>
    <p>Kami siap membantu merencanakan petualangan wisata terbaik Anda di Indonesia</p>
  </section>

  <section class="contact-section">
    <div class="container">
      <div class="section-heading">
        <h2>Mari Berbicara</h2>
        <p>Tim ahli kami siap membantu Anda merencanakan liburan impian ke destinasi wisata terbaik Indonesia</p>
      </div>

      <div class="contact-grid">
        <div class="contact-form-container">
          <h2>Kirim Pesan</h2>
            <?php if (!empty($form_submission_message)): ?>
            <div class="form-message <?php echo htmlspecialchars($form_message_type); ?>" id="formMessageScrollTarget">
              <i class="fas <?php echo ($form_message_type == 'success') ? 'fa-check-circle' : 'fa-exclamation-circle'; ?>"></i>
              <?php echo htmlspecialchars($form_submission_message); ?>
            </div>
            <?php endif; ?>
          <form id="contactForm" class="contact-form" method="POST" action="kontak.php#formMessageScrollTarget">
            <div class="form-row">
              <div class="form-group">
                <label for="firstName">Nama Depan *</label>
                <input type="text" id="firstName" name="firstName" value="<?php echo htmlspecialchars($submitted_values['firstName']); ?>" required>
              </div>
              <div class="form-group">
                <label for="lastName">Nama Belakang *</label>
                <input type="text" id="lastName" name="lastName" value="<?php echo htmlspecialchars($submitted_values['lastName']); ?>" required>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($submitted_values['email']); ?>" required>
              </div>
              <div class="form-group">
                <label for="phone">Nomor Telepon</label>
                <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($submitted_values['phone']); ?>">
              </div>
            </div>
            <div class="form-group">
              <label for="subject">Subjek *</label>
              <select id="subject" name="subject" required>
                <option value="" <?php echo ($submitted_values['subject'] == '') ? 'selected' : ''; ?>>Pilih Subjek</option>
                <option value="informasi-umum" <?php echo ($submitted_values['subject'] == 'informasi-umum') ? 'selected' : ''; ?>>Informasi Umum</option>
                <option value="reservasi" <?php echo ($submitted_values['subject'] == 'reservasi') ? 'selected' : ''; ?>>Reservasi & Pemesanan</option>
                <option value="keluhan" <?php echo ($submitted_values['subject'] == 'keluhan') ? 'selected' : ''; ?>>Keluhan & Saran</option>
                <option value="kerjasama" <?php echo ($submitted_values['subject'] == 'kerjasama') ? 'selected' : ''; ?>>Kerjasama & Partnership</option>
                <option value="lainnya" <?php echo ($submitted_values['subject'] == 'lainnya') ? 'selected' : ''; ?>>Lainnya</option>
              </select>
            </div>
            <div class="form-group">
              <label for="message">Pesan *</label>
              <textarea id="message" name="message" placeholder="Ceritakan bagaimana kami bisa membantu Anda..." required><?php echo htmlspecialchars($submitted_values['message']); ?></textarea>
            </div>
            <button type="submit" name="submit_contact_form" class="submit-btn">
              <i class="fas fa-paper-plane"></i> Kirim Pesan
            </button>
          </form>
        </div>

        <div class="contact-info">
          <h2>Informasi Kontak</h2>
          <div class="info-item">
            <div class="info-icon"><i class="fas fa-map-marker-alt"></i></div>
            <div class="info-content">
              <h3>Alamat Kantor</h3>
              <p><?php echo nl2br(htmlspecialchars($contact_info['alamat_kantor'])); ?></p>
            </div>
          </div>
          <div class="info-item">
            <div class="info-icon"><i class="fas fa-phone"></i></div>
            <div class="info-content">
              <h3>Telepon</h3>
              <p><a href="tel:<?php echo htmlspecialchars(str_replace([' ','-','(',')'], '', $contact_info['telepon'])); ?>"><?php echo htmlspecialchars($contact_info['telepon']); ?></a></p>
            </div>
          </div>
          <div class="info-item">
            <div class="info-icon"><i class="fas fa-envelope"></i></div>
            <div class="info-content">
              <h3>Email</h3>
              <p><a href="mailto:<?php echo htmlspecialchars($contact_info['email']); ?>"><?php echo htmlspecialchars($contact_info['email']); ?></a></p>
            </div>
          </div>
          <div class="info-item">
            <div class="info-icon"><i class="fas fa-globe"></i></div>
            <div class="info-content">
              <h3>Website</h3>
              <p><a href="http://<?php echo htmlspecialchars(str_replace(['http://', 'https://'], '', $contact_info['website'])); ?>" target="_blank" rel="noopener noreferrer"><?php echo htmlspecialchars($contact_info['website']); ?></a></p>
            </div>
          </div>
          <div class="office-hours">
            <h3>Jam Operasional</h3>
            <div class="hours-grid">
              <?php if (!empty($office_hours_parsed)): ?>
                <?php foreach ($office_hours_parsed as $item): ?>
                  <span class="hour-day"><?php echo htmlspecialchars($item['day']); ?></span>
                  <span class="hour-time"><?php echo htmlspecialchars($item['time']); ?></span>
                <?php endforeach; ?>
              <?php else: ?>
                <span class="hour-day" style="grid-column: 1 / -1;"><?php echo htmlspecialchars($contact_info['jam_operasional']); ?></span>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="map-section">
    <div class="container">
      <div class="section-heading">
        <h2>Lokasi Kantor</h2>
        <p>Kunjungi kantor kami untuk konsultasi langsung tentang destinasi wisata impian Anda.</p>
      </div>
      <div class="map-container">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3957.634538816806!2d112.7521648153195!3d-7.282288994742071!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7fde455555555%3A0x明星大学!2zU3VyYWJheWEsIEphd2EgVGltdXIsIEluZG9uZXNpYQ!5e0!3m2!1sen!2sid!4v1622540000000!5m2!1sen!2sid" title="Lokasi Kantor GoTravel" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div>
    </div>
  </section>

  <section class="faq-section">
    <div class="container">
      <div class="section-heading">
        <h2>Pertanyaan Umum</h2>
        <p>Temukan jawaban atas pertanyaan yang sering diajukan tentang layanan wisata kami</p>
      </div>
      <div class="faq-container">
        <?php if (!empty($faq_list)): ?>
          <?php foreach ($faq_list as $faq_item): ?>
            <div class="faq-item">
              <div class="faq-question" onclick="toggleFAQ(this)">
                <h3><?php echo htmlspecialchars($faq_item['pertanyaan']); ?></h3>
                <span class="faq-toggle"><i class="fas fa-plus"></i></span>
              </div>
              <div class="faq-answer">
                <p><?php echo nl2br(htmlspecialchars($faq_item['jawaban'])); ?></p>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p style="text-align: center;">Saat ini belum ada pertanyaan umum yang tersedia.</p>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <?php include 'Komponen/footer.php'; ?>

  <script>
    function toggleFAQ(element) {
      const faqItem = element.parentElement;
      const isActive = faqItem.classList.contains('active');
      const icon = element.querySelector('.faq-toggle i');
      
      document.querySelectorAll('.faq-item').forEach(item => {
        if (item !== faqItem) {
          item.classList.remove('active');
          const otherIcon = item.querySelector('.faq-toggle i');
          if (otherIcon) {
            otherIcon.classList.remove('fa-minus');
            otherIcon.classList.add('fa-plus');
          }
        }
      });
      
      if (!isActive) {
        faqItem.classList.add('active');
        if (icon) { icon.classList.remove('fa-plus'); icon.classList.add('fa-minus'); }
      } else {
        faqItem.classList.remove('active');
        if (icon) { icon.classList.remove('fa-minus'); icon.classList.add('fa-plus'); }
      }
    }
    
    // Scroll ke pesan form jika ada (setelah redirect dari PHP)
    window.addEventListener('DOMContentLoaded', (event) => {
        const formMessageTarget = document.getElementById('formMessageScrollTarget');
        if (formMessageTarget && formMessageTarget.innerText.trim() !== '') {
            // Cek apakah pesan ini hasil dari redirect (misalnya, tidak ada input dari user di halaman ini)
            // atau apakah ada error message dari submit di halaman yang sama.
            // Ini untuk menghindari scroll jika pengguna hanya mengisi form lalu ada error validasi sebelum submit.
            // Jika ada query param `status` dari redirect, atau jika message ada tanpa nilai form yang diisi ulang (untuk kasus error non-redirect)
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('status')) {
                 formMessageTarget.scrollIntoView({ behavior: 'smooth', block: 'center' });
            } else if (formMessageTarget.classList.contains('error') && 
                       document.getElementById('firstName').value === '' && 
                       document.getElementById('lastName').value === '') {
                // Kasus error yang bukan dari submit di halaman ini (misal, direct load dengan pesan error dari session)
                // Sebaiknya logika ini lebih disempurnakan tergantung flow aplikasi
            } else if (formMessageTarget.classList.contains('error') && 
                       (document.getElementById('firstName').value !== '' || 
                        document.getElementById('lastName').value !== '')) {
                // Error validasi dari submit di halaman ini, scroll juga
                formMessageTarget.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }

        }
    });


    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function (e) {
        const hrefAttr = this.getAttribute('href');
        if (hrefAttr.length > 1 && hrefAttr.startsWith('#')) {
            const targetId = hrefAttr.substring(1);
            const targetElement = document.getElementById(targetId);
            if (targetElement && targetId !== 'formMessageScrollTarget') { // Jangan preventDefault untuk anchor form message kita
                e.preventDefault();
                targetElement.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }
      });
    });
  </script>
</body>
</html>