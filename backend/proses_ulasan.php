<?php
session_start();
include './koneksi.php'; // Pastikan path koneksi.php sudah benar

// Pastikan pengguna sudah login
if (!isset($_SESSION['user']['id'])) {
    // Jika belum login, arahkan ke halaman login atau tampilkan pesan
    // Misalnya, kembali ke halaman detail wisata dengan pesan error
    // header("Location: ../wisata_detail.php?id=" . $_POST['id_wisata'] . "&error=notloggedin");
    echo "Anda harus login untuk memberikan ulasan."; // Atau pesan yang lebih baik
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari POST
    $rating = $_POST['rating'];
    $komentar = trim($_POST['komentar']); // Trim untuk menghapus spasi ekstra di awal/akhir
    $id_wisata = $_POST['id_wisata'];
    
    // Ambil id_pengunjung dari session
    $id_pengunjung = $_SESSION['user']['id'];

    // Validasi dasar (rating '0' dari input hidden akan dianggap empty di sini, yang bagus)
    // Komentar bisa saja kosong jika pengguna hanya ingin memberi rating, sesuaikan jika komentar wajib.
    if (!empty($rating) && $rating >= 1 && $rating <= 5 && !empty($id_wisata) && !empty($id_pengunjung)) {
        
        // Konversi id_wisata dan rating ke integer untuk keamanan tambahan dan tipe data yang benar
        $id_wisata_int = (int)$id_wisata;
        $rating_int = (int)$rating;
        $id_pengunjung_int = (int)$id_pengunjung; // Meskipun dari session, konversi tidak ada salahnya

        // Gunakan prepared statement untuk keamanan
        $stmt = $conn->prepare("INSERT INTO ulasan (id_pengunjung, rating, komentar, id_wisata) VALUES (?, ?, ?, ?)");
        
        // Bind parameter dengan tipe data yang benar: i = integer, s = string
        // id_pengunjung (int), rating (int), komentar (string), id_wisata (int)
        $stmt->bind_param("iisi", $id_pengunjung_int, $rating_int, $komentar, $id_wisata_int);

        if ($stmt->execute()) {
            // Redirect kembali ke halaman detail wisata dengan pesan sukses (opsional)
            // header("Location: ../wisata_detail.php?id=" . $id_wisata_int . "&status=reviewsuccess");
            header("Location: ../wisata_detail.php?id=" . $id_wisata_int);
            exit();
        } else {
            // Untuk development, tampilkan error SQL. Untuk produksi, catat error dan tampilkan pesan umum.
            error_log("Gagal menyimpan ulasan: " . $stmt->error); // Catat error ke log server
            // header("Location: ../wisata_detail.php?id=" . $id_wisata_int . "&error=dberror");
            echo "Terjadi kesalahan saat menyimpan ulasan Anda. Silakan coba lagi nanti.";
            // echo "Gagal menyimpan ulasan: " . $stmt->error; // Baris ini bisa di-komentar untuk produksi
        }
        $stmt->close();
    } else {
        // Jika validasi gagal, kembali ke halaman detail dengan pesan error
        $error_message = "Rating harus dipilih (1-5 bintang).";
        if (empty($komentar) && $rating >=1 && $rating <=5) {
             // Jika hanya komentar yang kosong dan itu diperbolehkan, lanjutkan.
             // Jika komentar wajib, tambahkan kondisi di atas: && !empty($komentar)
             // dan ubah pesan error di sini.
             // Untuk saat ini, asumsikan komentar tidak wajib jika rating sudah diisi.
             // Jika komentar juga wajib, uncomment baris di bawah dan sesuaikan kondisi if di atas.
             // $error_message = "Rating dan komentar harus diisi.";
        }
        // header("Location: ../wisata_detail.php?id=" . $id_wisata . "&error=validation&message=" . urlencode($error_message));
        echo $error_message; // Atau redirect dengan parameter error
    }
    $conn->close(); // Tutup koneksi database
} else {
    // Jika bukan metode POST, mungkin arahkan ke halaman utama atau tampilkan error
    // header("Location: ../index.php");
    echo "Metode permintaan tidak valid.";
    exit();
}
?>