<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri Wisata Dinamis</title>
    <link rel="stylesheet" href="css/fuadi.css">
</head>
<body>

    <?php include './Komponen/navbar.php'; ?>

    <!-- Galeri -->
<div class="section-header">
  <h2 class="mt_16" >Galeri Keindahan Wisata</h2>
</div>
<main >

  <!-- Galeri Foto -->
  <div class="gallery-grid" id="gallery-container">
    <img src="https://www.nativeindonesia.com/foto/2024/07/sunset-di-pantai-lorena.jpg" alt="Foto 1">
    <img src="https://www.nativeindonesia.com/foto/2024/07/pantai-tanjung-kodok-1.jpg" alt="Foto 2">
    <img src="https://salsawisata.com/wp-content/uploads/2022/07/Indonesian-Islamic-Art-Museum.jpg" alt="Foto 3">
    <img src="https://salsawisata.com/wp-content/uploads/2022/07/Wisata-Bahari-Lamongan.jpg" alt="Foto 4">
  </div>

  <button id="loadMore" class="btn-primary">Muat lebih banyak ↓</button>

  <!-- Video Wisata -->
  <div class="video-section">
    <h3>Video Wisata</h3>
    <div class="video-wrapper">
      <iframe src="https://www.youtube.com/embed/TGZNSNk7tEw" frameborder="0" allowfullscreen></iframe>
      <iframe src="https://www.youtube.com/embed/uTQw0yIQx5c" frameborder="0" allowfullscreen></iframe>
    </div>
  </div>
</main>



    <!-- Footer -->
    <?php include './Komponen/footer.php'; ?>

    <script src="js/gallery.js"></script>
</body>
</html>
