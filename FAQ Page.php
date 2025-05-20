<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ Page</title>
    <link rel="stylesheet" href="./CSS/fuadi.css">
</head>
<body>
    <?php include './Komponen/navbar.php'; ?>
    <div class="header18">
        <h1>Pertanyaan Umum</h1>
    </div>
    <main>
        <div class="accordion-item">
            <div class="accordion-header">
                <span>Bagaimana Cara Mesan paket wisata?</span>
                <span class="accordion-icon">▼</span>
            </div>
            <div class="accordion-content">
            <p>Anda dapat memesan paket wisata melalui beberapa cara:</p>
            <ol>
                <li>melalui website kami dengan memilih paket yang diinginkan dan mengisi formulir pemesanan</li>
                <li>melalui whatsapp customer service kami di +62 ***</li>
                <li>dengan mengunjungi kantor kami di Jl. Wisata No 123, Jawa</li>
                <li>melalui email ke booking@***</li>
            </ol>
            <p>Setelah pemesanan, kami akan mengirimkan konfirmasi beserta invoice pembayaran.</p>
            </div>
        </div>

        <div class="accordion-item">
            <div class="accordion-header">
                <span>Apa saja metode pembayaran yang tersedia?</span>
                <span class="accordion-icon">▼</span>
            </div>
            <div class="accordion-content">
            <p>Metode pembayaran dapat dilakukan melalui transfer bank, e-wallet, atau kartu kredit.</p>
            </div>
        </div>

        <div class="accordion-item">
            <div class="accordion-header">
                <span>Apa kebijakan pembatalan dan refund?</span>
                <span class="accordion-icon">▼</span>
            </div>
            <div class="accordion-content">
            <p>Pembatalan dapat dilakukan maksimal 3 hari sebelum keberangkatan untuk refund penuh. Setelah itu, refund tidak tersedia.</p>
            </div>
        </div>

        <div class="accordion-item">
            <div class="accordion-header">
                <span>Apa ada diskon untuk group atau keluarga</span>
                <span class="accordion-icon">▼</span>
            </div>
            <div class="accordion-content">
            <p>Ya, kami menyediakan diskon khusus untuk pemesanan grup atau keluarga dengan jumlah peserta minimal 5 orang. 
            Silakan hubungi customer service kami untuk mendapatkan penawaran dan informasi lebih lanjut.</p>
            </div>
        </div>
    </main>
    <div class="contack">
        <h1>Masih ada pertanyaan?</h1>
        <p>team customer service siap membantu anda</p>
        <a href="kontak.php" class="contact-button"><h3>Hubungi kami</h3></a>
    </div>

    <?php include './Komponen/footer.php'; ?>
    
    <script>
    const accordions = document.querySelectorAll('.accordion-item');

accordions.forEach(item => {
  const header = item.querySelector('.accordion-header');
  header.addEventListener('click', () => {
    item.classList.toggle('active');
  });
});

  </script>
</body>
</html>