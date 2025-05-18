<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Pengguna</title>
  <link rel="stylesheet" href="13.css">
</head>
<body>

  <!-- Navbar -->
  <div class="navbar">
    <div class="logo"></div>
    <div class="menu">
      <a href="#">Beranda</a>
      <a href="#">Riwayat Wisata</a>
      <a href="#">Blog</a>
      <a href="#">Kontak</a>
      <a href="#">Bantuan</a>
      <a href="#" class="btn">Pesan Sekarang</a>
    </div>
  </div>

  <!-- Dashboard -->
  <div class="dashboard-container">
    <div class="sidebar">
      <p>Selamat datang, User</p>
      <a href="#">Dashboard Pengguna</a>
    </div>

    <div class="main-content">
      <!-- Riwayat Pemesanan -->
      <div class="box">
        <h3>Riwayat Pemesanan</h3>
        <table>
          <thead>
            <tr>
              <th>Destinasi</th>
              <th>Tanggal</th>
              <th>Jumlah</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Malang</td>
              <td>10 - 15 Mei 2025</td>
              <td>2 orang</td>
              <td class="status-lunas">lunas</td>
            </tr>
            <tr>
              <td>Malang</td>
              <td>2 - 5 Juli 2025</td>
              <td>1 orang</td>
              <td class="status-menunggu">menunggu</td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Edit Profil -->
      <div class="box">
        <h3>Edit Profil</h3>
        <form>
          <input type="text" placeholder="Nama">
          <input type="email" placeholder="Email">
          <button class="btn-blue" type="submit">Simpan Perubahan</button>
        </form>
      </div>

      <!-- Ubah Kata Sandi -->
      <div class="box">
        <h3>Ubah Kata Sandi</h3>
        <form>
          <input type="password" placeholder="Kata sandi lama">
          <input type="password" placeholder="Kata sandi baru">
          <button class="btn-green" type="submit">Ubah Kata Sandi</button>
        </form>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="footer">
    <div class="footer-left">
      <img src="https://tse4.mm.bing.net/th?id=OIP.Oeb5S-qnoZOY6EpFxIsuogHaHa&pid=Api&P=0&h=180" alt="Logo" class="footer-logo">
      <p>Visi kami adalah membantu orang menemukan tempat terbaik untuk berwisata dengan keamanan tinggi.</p>
    </div>

    <div class="footer-center">
      <div>
        <h4>Tentang</h4>
        <p>Perusahaan</p>
        <p>Tim Kami</p>
      </div>
      <div>
        <h4>Dukungan</h4>
        <p>FAQ</p>
        <p>Kebijakan Privasi</p>
      </div>
    </div>

    <div class="footer-right">
      <h4>Ikuti Kami</h4>
      <img src="instagram.png" alt="Instagram" class="social-icon">
      <img src="youtube.png" alt="YouTube" class="social-icon">
    </div>
  </footer>

</body>
</html>
