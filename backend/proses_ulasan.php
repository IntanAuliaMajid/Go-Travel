<?php
session_start();
include './koneksi.php'; // pastikan koneksi sudah benar

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $rating = $_POST['rating'];
    $komentar = $_POST['komentar'];
    $id_wisata = $_POST['id_wisata'];
    $id_pengunjung = $_SESSION['user']['id'];


    // Validasi sederhana
    if (!empty($rating) && !empty($komentar) && !empty($id_wisata) && !empty($id_pengunjung)) {
        // Gunakan prepared statement untuk keamanan
        $stmt = $conn->prepare("INSERT INTO ulasan (id_pengunjung, rating, komentar, id_wisata) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sdss", $id_pengunjung, $rating, $komentar, $id_wisata);

        if ($stmt->execute()) {
            header("Location: ../wisata_detail.php?id=" . $id_wisata);
            exit();
        } else {
            echo "Gagal menyimpan ulasan: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Semua kolom harus diisi.";
    }
}
?>
