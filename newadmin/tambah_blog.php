<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Blog - Admin</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f9f9f9;
      margin: 0;
    }
    main {
      margin-left: 220px;
      padding: 20px;
    }
    form {
      background-color: #fff;
      padding: 20px;
      border-radius: 6px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      max-width: 700px;
    }
    label {
      display: block;
      margin-top: 15px;
      font-weight: bold;
    }
    input[type="text"],
    input[type="date"],
    textarea,
    select {
      width: 100%;
      padding: 10px;
      margin-top: 6px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
    }
    textarea {
      height: 150px;
    }
    button {
      margin-top: 20px;
      background-color: #4CAF50;
      color: white;
      padding: 10px 16px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
    button:hover {
      background-color: #45a049;
    }
  </style>
</head>
<body>
  <?php include '../komponen/sidebar_admin.php'; ?>

  <main>
    <h1>Tambah Artikel Blog</h1>
    <form action="proses_tambah_blog.php" method="post" enctype="multipart/form-data">
      <label for="judul">Judul Artikel</label>
      <input type="text" id="judul" name="judul" required>

      <label for="penulis">Penulis</label>
      <input type="text" id="penulis" name="penulis" required>

      <label for="tanggal">Tanggal Publikasi</label>
      <input type="date" id="tanggal" name="tanggal" required>

      <label for="konten">Konten Artikel</label>
      <textarea id="konten" name="konten" required></textarea>

      <label for="gambar">Gambar (opsional)</label>
      <input type="file" id="gambar" name="gambar">

      <button type="submit">Simpan Artikel</button>
    </form>
  </main>
</body>
</html>
