<footer class="footer">
  <div class="footer-container">
    <div class="footer-brand">
      <img src="./Gambar/logo.png" alt="Logo Jelajah Malang" class="logo" />
      <p>Visi kami adalah membantu orang menemukan tempat terbaik untuk bepergian dengan keamanan tinggi</p>
    </div>
    <div class="footer-links">
      <div>
        <h4>Tentang</h4>
        <ul>
          <li><a href="#">Tentang Kami</a></li>
          <li><a href="#">Paket Wisata</a></li>
          <li><a href="#">Blog</a></li>
        </ul>
      </div>
      <div>
        <h4>Perusahaan</h4>
        <ul>
          <li><a href="#">Cara Pemesanan</a></li>
        </ul>
      </div>
      <div>
        <h4>Dukungan</h4>
        <ul>
          <li><a href="#">Pertanyaan Umum</a></li>
          <li><a href="#">Hubungi kami</a></li>
          <li><a href="#">Privacy Policy</a></li>
        </ul>
      </div>
      <div>
        <h4>Ikuti Kami</h4>
        <div class="social-icons">
          <a href="#"><img src="https://cdn-icons-png.flaticon.com/512/1384/1384060.png" alt="YouTube" /></a>
          <a href="#"><img src="https://cdn-icons-png.flaticon.com/512/733/733547.png" alt="Facebook" /></a>
          <a href="#"><img src="https://cdn-icons-png.flaticon.com/512/1384/1384063.png" alt="Instagram" /></a>
        </div>
      </div>
    </div>
  </div>
  <div class="footer-bottom">
    <p>©2025 | Jelajah Malang. Hak cipta dilindungi.</p>
  </div>
</footer>

<style>
    .footer {
  background-color: white;
  padding: 40px 20px 20px;
  font-size: 14px;
  color: #333;
  margin-top: 40px;
}

.footer-container {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  max-width: 1100px;
  margin: 0 auto;
}

.footer-brand {
  flex: 1 1 250px;
  margin-bottom: 20px;
}

.footer-brand .logo {
  width: 100px;
  margin-bottom: 10px;
}

.footer-brand p {
  max-width: 300px;
  color: #666;
}

.footer-links {
  display: flex;
  flex: 2 1 500px;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 20px;
}

.footer-links h4 {
  margin-bottom: 10px;
  color: #002f6c;
  font-weight: bold;
}

.footer-links ul {
  list-style: none;
  padding: 0;
  margin: 0;
}

.footer-links ul li {
  margin-bottom: 6px;
}

.footer-links a {
  color: #333;
  text-decoration: none;
}

.footer-links a:hover {
  text-decoration: underline;
}

.social-icons a {
  margin-right: 10px;
}

.social-icons img {
  width: 20px;
  height: 20px;
}

.footer-bottom {
  text-align: center;
  margin-top: 30px;
  color: #777;
}
</style>