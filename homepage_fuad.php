<!DOCTYPE html>
<html>
<head>
<title>Achmad Saiful Fuadi</title>
<style>

body {
    background-color: #f5f7fa; 
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
    margin: 0; 
    display: flex; 
    justify-content: center;
    align-items: center;
    min-height: 100vh; 
    line-height: 1.7; 
    color: #333d4d; 
}

.container {
    max-width: 850px; 
    margin: 30px auto; 
    background-color: #ffffff; 
    padding: 30px; 
    border-radius: 12px; 
    box-shadow: 0 8px 25px rgba(0,0,0,0.1); 
    display: grid; 
    grid-template-columns: 1fr 2fr;
    gap: 30px; 
}

header, footer {
    grid-column: span 2; 
    background-color: #4CAF50; 
    color: #fff;
    text-align: center;
    padding: 15px 0; 
    border-radius: 8px; 
    font-weight: 600; 
    letter-spacing: 0.5px; 
}

h2 {
    font-size: 2.2em;
    margin: 0;
}

h3 {
    color: #2c3e50; 
    font-size: 1.6em; 
    margin-bottom: 15px; 
    border-bottom: 2px solid #a8e6cf; 
    padding-bottom: 8px;
}

.profile-section {
    background-color: #e8f5e9; 
    padding: 20px; 
    border-radius: 10px; 
    box-shadow: 0 4px 15px rgba(0,0,0,0.08); 
    text-align: center; 
}

.profile-section img {
    width: 150px; 
    height: 150px; 
    border-radius: 50%; 
    object-fit: cover;
    display: block;
    margin: 0 auto 20px auto; 
    border: 5px solid #66bb6a; 
    box-shadow: 0 0 0 7px rgba(102, 187, 106, 0.3); 
    transition: transform 0.3s ease-in-out; 
}

.profile-section img:hover {
    transform: scale(1.05); 
}

.profile-section p {
    text-align: center; 
    font-size: 1.1em; 
    line-height: 1.5;
}

.profile-section p b {
    color: #388e3c; 
}

.project-section {
    background-color: #e8f5e9; 
    padding: 20px; 
    border-radius: 10px; 
    box-shadow: 0 4px 15px rgba(0,0,0,0.08); 
}

ul {
    list-style-type: none; 
    padding: 0; 
}

li {
    background-color: #ffffff; 
    margin-bottom: 15px; 
    padding: 15px; 
    border: 1px solid #d4edda; 
    border-radius: 8px; 
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out; 
}

li:hover {
    transform: translateY(-5px); 
    box-shadow: 0 6px 20px rgba(0,0,0,0.15); 
}

li b {
    color: #2e7d32; 
    font-size: 1.1em; 
}
</style>
</head>
<body>

<div class="container">
    <header>
        <h2>Homepage Pribadi</h2>
    </header>

    <div class="profile-section">
        <h3>Data Pribadi</h3>
        <img src="./Gambar/fuad.jpg" alt="Foto Profil Fuad">
        <p><b>Nama:</b> Achmad Saiful Fuadi<br>
        <b>NIM:</b> 240411100012<br>
        <b>Kelas:</b> IF 2F</p>
    </div>

    <div class="project-section">
        <h3>Project Akhir - Pariwisata</h3>
        <ul>
            <li>
                <b>Interface 1:</b> Galeri (USER)<br>
                Halaman koleksi foto-foto dan video tempat wisata yang telah dikunjungi atau masuk dalam daftar rekomendasi. Fitur ini sangat membantu untuk melihat keindahan suatu lokasi secara visual sebelum memutuskan berkunjung.
            </li>
            <li>
                <b>Interface 2:</b> Detail Blog (USER)<br>
                Halaman detail artikel dari Go Travel yang berisi informasi atau seputar tips dari Go Travel.
            </li>
            <li>
                <b>Interface 3:</b> Pemandu Wisata (USER)<br>
                Halaman ini adalah Pusat Pengelolaan Pesan Masuk (Inbox) yang berasal dari formulir kontak di website Go Travel. Tujuannya adalah untuk memberikan administrator sebuah antarmuka yang terorganisir untuk membaca, mengelola, dan menanggapi semua pesan yang dikirim oleh pengguna atau pengunjung situs.
            </li>
            <li>
                <b>Interface 4:</b> Privacy Policy (USER)<br>
                  Halaman ini menampilkan Kebijakan Privasi dari website Go Travel. Tujuannya adalah untuk memberikan informasi yang transparan kepada pengguna mengenai bagaimana data pribadi mereka dikumpulkan, digunakan, disimpan, dan dilindungi oleh sistem. Halaman ini juga mencakup hak-hak pengguna atas data mereka serta informasi apakah data akan dibagikan kepada pihak ketiga atau tidak.
            </li>
            <li>
                <b>Interface 5:</b> Kontak (ADMIN)<br>
                Halaman ini digunakan untuk mengelola data kontak milik admin, seperti menambah, mengedit, atau menghapus informasi kontak yang akan ditampilkan di halaman publik website Go Travel.
            </li>
            <li>
                <b>Interface 6:</b> Pertanyaan (ADMIN) <br>
                Halaman ini berfungsi sebagai pusat pengelolaan pertanyaan yang dikirim oleh pengguna terkait layanan wisata, pemesanan, atau informasi lainnya. Admin dapat membaca, membalas, dan mengarsipkan pertanyaan-pertanyaan ini sebagai bagian dari layanan pelanggan.
            </li>
            <li>
                <b>Interface 6:</b>Galeri (ADMIN)<br>
                Halaman ini berfungsi sebagai Pusat Manajemen Galeri Media. Tujuannya adalah untuk memberikan administrator antarmuka visual untuk mengelola semua aset media (gambar dan video) yang akan ditampilkan di berbagai bagian galleri.
            </li>
        </ul>
    </div>

    <footer>
        <p>&copy; 2025 Homepage Achmad Saiful Fuadi</p>
    </footer>
</div>

</body>
</html>