<?php
session_start();

// Inisialisasi session kendaraan
if (!isset($_SESSION['kendaraan'])) {
  $_SESSION['kendaraan'] = [];
}

$pesan = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nama = trim($_POST['nama'] ?? '');
  $harga = (int)($_POST['harga'] ?? 0);

  if ($nama && $harga > 0) {
    $_SESSION['kendaraan'][] = ['nama' => $nama, 'harga' => $harga];
    $pesan = "Kendaraan '$nama' berhasil ditambahkan.";
  } else {
    $pesan = "Nama dan harga kendaraan harus diisi dengan benar.";
  }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Kendaraan</title>
</head>
<body>
    <?php include '../Komponen/sidebar_admin.php'; ?>
    <main style="margin-left: 220px; padding: 20px; font-family: Arial, sans-serif;">
  <h1>Tambah Kendaraan</h1>
  <?php if ($pesan): ?>
    <p><?= htmlspecialchars($pesan) ?></p>
  <?php endif; ?>
  <form method="POST">
    <label for="nama">Nama Kendaraan</label><br>
    <input type="text" name="nama" id="nama" required><br><br>

    <label for="harga">Harga Kendaraan (Rp)</label><br>
    <input type="number" name="harga" id="harga" min="1" required><br><br>

    <button type="submit">Simpan Kendaraan</button>
  </form>

  <hr>
  <h2>Daftar Kendaraan Saat Ini</h2>
  <ul>
    <?php foreach ($_SESSION['kendaraan'] as $k): ?>
      <li><?= htmlspecialchars($k['nama']) ?> - Rp <?= number_format($k['harga']) ?></li>
    <?php endforeach; ?>
  </ul>
</main>
</body>
</html>
