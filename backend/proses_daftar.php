<?php
include "koneksi.php";

// 1. Ambil semua data dari form, termasuk username
$nama_depan = $_POST['nama_depan'];
$nama_belakang = $_POST['nama_belakang'];
$username = $_POST['username']; // Tambahan
$email = $_POST['email'];
$password = $_POST['password'];
$konfirmasi = $_POST['konfirmasi_password'];

// Cek jika ada input yang kosong
if (empty($nama_depan) || empty($nama_belakang) || empty($username) || empty($email) || empty($password)) {
    die("Semua kolom wajib diisi!");
}

if ($password !== $konfirmasi) {
    die("Password tidak cocok!");
}

$hash = password_hash($password, PASSWORD_DEFAULT);

// 2. Cek apakah username sudah digunakan
$cek_username = $conn->prepare("SELECT id_pengunjung FROM pengunjung WHERE username = ?");
$cek_username->bind_param("s", $username);
$cek_username->execute();
$cek_username->store_result();

if ($cek_username->num_rows > 0) {
    // Jika username sudah ada, hentikan proses
    die("Username sudah digunakan, silakan pilih yang lain!");
}
$cek_username->close();


// Cek apakah email sudah digunakan
$cek_email = $conn->prepare("SELECT id_pengunjung FROM pengunjung WHERE email = ?");
$cek_email->bind_param("s", $email);
$cek_email->execute();
$cek_email->store_result();

if ($cek_email->num_rows > 0) {
    // Jika email sudah ada, hentikan proses
    die("Email sudah digunakan!");
}
$cek_email->close();

// 3. Siapkan statement untuk menyimpan data (dengan kolom username)
$stmt = $conn->prepare("INSERT INTO pengunjung (nama_depan, nama_belakang, username, email, password) VALUES (?, ?, ?, ?, ?)");

// 4. Sesuaikan bind_param untuk menyertakan username
$stmt->bind_param("sssss", $nama_depan, $nama_belakang, $username, $email, $hash);

if ($stmt->execute()) {
    echo "<script>
        alert('Pendaftaran berhasil! Silakan login.');
        window.location.href = '../login.php';
    </script>";
    exit;
} else {
    echo "Terjadi kesalahan: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>