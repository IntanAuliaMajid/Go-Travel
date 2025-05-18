<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Bookings</title>
    <link rel="stylesheet" href="../CSS/styles.css">
</head>
<body>
    <div class="sidebar">
        <div class="admin-panel-header">
            ADMIN PANEL
        </div>
        <div class="sidebar-menu">
            <a href="#" class="menu-item">Dashboard</a>
            <a href="#" class="menu-item active">Pemesanan</a>
            <a href="#" class="menu-item">Pengguna</a>
            <a href="#" class="menu-item">Laporan</a>
            <a href="#" class="menu-item">Pengaturan</a>
        </div>
    </div>
    
    <div class="main-content">
        <div class="header">
            <h1>Manage Bookings</h1>
            <form action="#" method="get">
                <input type="text" class="search-bar" placeholder="Cari pemesanan...">
            </form>
        </div>
        
        <div class="filters">
            <a href="#" class="filter-button">Filter: Semua</a>
            <a href="#" class="filter-button">Tanggal: Terbaru</a>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Pelanggan</th>
                    <th>Tanggal</th>
                    <th>Status Pembayaran</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>#1023</td>
                    <td>Budi Santoso</td>
                    <td>05-05-2025</td>
                    <td><span class="status lunas">LUNAS</span></td>
                    <td><a href="#" class="action-button konfirmasi">Konfirmasi</a></td>
                </tr>
                <tr>
                    <td>#1022</td>
                    <td>Siti Aminah</td>
                    <td>05-05-2025</td>
                    <td><span class="status tertunda">TERTUNDA</span></td>
                    <td><a href="#" class="action-button tolak">Tolak</a></td>
                </tr>
                <tr>
                    <td>#1021</td>
                    <td>Ahmad Fadli</td>
                    <td>04-05-2025</td>
                    <td><span class="status sebagian">SEBAGIAN</span></td>
                    <td><a href="#" class="action-button konfirmasi">Konfirmasi</a></td>
                </tr>
                <tr>
                    <td>#1020</td>
                    <td>Dewi Safitri</td>
                    <td>04-05-2025</td>
                    <td><span class="status lunas">LUNAS</span></td>
                    <td><a href="#" class="action-button konfirmasi">Konfirmasi</a></td>
                </tr>
                <tr>
                    <td>#1019</td>
                    <td></td>
                    <td>03-05-2025</td>
                    <td><span class="status dibatalkan">DIBATALKAN</span></td>
                    <td><a href="#" class="action-button diproses">Diproses</a></td>
                </tr>
            </tbody>
        </table>
        
        <div class="pagination">
            <a href="#" class="active">1</a>
            <a href="#">2</a>
            <a href="#">3</a>
            <a href="#">></a>
        </div>
    </div>
</body>
</html>