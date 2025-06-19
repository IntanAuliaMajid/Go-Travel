<!DOCTYPE html>
<html>
<head>
<title>Homepage Zulfikar Ramdan F</title>
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
        <img src="./Gambar/fiki.jpg" alt="Foto Profil Fiki">
        <p><b>Nama:</b> Zulfikar Ramdan F<br>
        <b>NIM:</b> 240411100213<br>
        <b>Kelas:</b> IF 2F</p>
    </div>

    <div class="project-section">
        <h3>Project Akhir - Pariwisata</h3>
        <ul>
            <li>
                <b>Interface 1:</b> Wisata (ADMIN)<br>
                Halaman ini berfungsi sebagai Pusat Manajemen Objek Wisata di dalam panel admin. Tujuannya adalah untuk menyediakan antarmuka bagi administrator untuk melakukan manajemen objek wisata itu sendiri .
            </li>
            <li>
                <b>Interface 2:</b> Paket wisata (ADMIN) <br>
                Halaman ini berfungsi untuk Manajemen Paket Wisata. Ini adalah halaman inti bagi administrator untuk mengelola produk utama yang ditawarkan, yaitu paket-paket perjalanan. Halaman ini menyediakan antarmuka yang jelas untuk melihat semua paket yang tersedia, serta untuk melakukan tindakan pengelolaan dasar.
            </li>
            <li>
                <b>Interface 3:</b> Penginapan (ADMIN)<br>
                Halaman ini berfungsi sebagai Dasbor Manajemen Akomodasi/Penginapan. Tujuannya adalah untuk menyediakan antarmuka terpusat bagi administrator untuk mengelola daftar akomodasi (seperti hotel, villa, guesthouse) yang bisa menjadi bagian dari paket wisata .
            </li>
            <li>
                <b>Interface 4:</b> Dashboard (ADMIN) <br>
                Ini adalah Halaman Dashboard Admin untuk sebuah sistem informasi paket wisata. Tujuannya adalah untuk memberikan gambaran umum (overview) yang cepat dan informatif kepada administrator mengenai status terkini dari bisnis go-travel .
            </li>
            <li>
                <b>Interface 5:</b> Pengguna (ADMIN) <br>
                Ini adalah halaman Manajemen Pengguna (User Management) untuk panel admin. Tujuan utamanya adalah untuk menyediakan satu antarmuka terpusat bagi administrator untuk melihat, mencari, dan mengelola semua jenis pengguna yang ada di sistem, baik itu Admin maupun Pengunjung (pengguna biasa).
            </li>
        </ul>
    </div>

    <footer>
        <p>&copy; 2025 Homepage Zulfikar Ramdan F</p>
    </footer>
</html>
