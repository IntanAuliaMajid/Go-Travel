<!DOCTYPE html>
<html>
<head>
<title>Homepage Aden Muliana Azis</title>
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
        <img src="./Gambar/aden.jpg" alt="Foto Profil Aden">
        <p><b>Nama:</b> Aden Muliana Azis<br>
        <b>NIM:</b> 240411100219<br>
        <b>Kelas:</b> IF 2F</p>
    </div>

    <div class="project-section">
        <h3>Project Akhir - Pariwisata</h3>
        <ul>
            <li>
                <b>Interface 1:</b> Pemesanan (ADMIN)<br>
                Halaman ini digunakan oleh admin untuk melihat, mengelola, dan memverifikasi data pemesanan yang dilakukan oleh pengguna. Admin dapat memantau status pemesanan, mengubah informasi jika diperlukan, mengonfirmasi pembayaran, serta mengatur jadwal keberangkatan dan layanan yang dipesan.
            </li>
            <li>
                <b>Interface 2:</b> Manajemen Blog (ADMIN)<br>
                Ini adalah halaman Manajemen Artikel (Content Management System) untuk panel admin. Tujuannya adalah sebagai antarmuka utama bagi admin untuk mengelola semua konten artikel atau blog travel.
            </li>
            <li>
                <b>Interface 3:</b> Manajemen Kendaraan (ADMIN)<br>
                Halaman ini berfungsi sebagai Dasbor Manajemen Kendaraan, sebuah antarmuka bagi administrator untuk mengelola daftar jenis-jenis kendaraan yang tersedia untuk layanan wisata (misalnya, Avanza, HiAce, Bus Pariwisata).
            </li>
            <li>
                <b>Interface 4:</b> Pemandu Wisata (USER)<br>
                Halaman ini menampilkan daftar pemandu wisata yang tersedia di Go Travel, lengkap dengan informasi profil, pengalaman, bahasa yang dikuasai, dan wilayah layanan. Pengguna dapat melihat detail setiap pemandu dan memilih pemandu yang sesuai dengan kebutuhan perjalanan mereka.
            </li>
            <li>
                <b>Interface 5:</b> Kendaraan (USER)<br>
                Halaman ini menampilkan daftar kendaraan yang tersedia untuk disewa oleh pengguna selama perjalanan wisata. Pengguna dapat melihat jenis kendaraan, kapasitas, fasilitas, harga sewa, dan ketersediaan. Halaman ini memudahkan pengguna dalam memilih kendaraan yang sesuai dengan kebutuhan wisata mereka.
            </li>
        </ul>
    </div>

    <footer>
        <p>&copy; 2025 Homepage Aden Muliana Azis</p>
    </footer>
</div>

</body>
</html>