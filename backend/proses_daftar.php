<?php
include "koneksi.php";
$nama_depan = $_POST['nama_depan'];
$nama_belakang = $_POST['nama_belakang'];
$email = $_POST['email'];
$password = $_POST['password'];
$konfirmasi = $_POST['konfirmasi_password'];

if ($password !== $konfirmasi) {
    die("Password tidak cocok!");
}

$hash = password_hash($password, PASSWORD_DEFAULT);

// Cek apakah email sudah digunakan
$cek_email = $conn->prepare("SELECT id_pengunjung FROM pengunjung WHERE email = ?");
$cek_email->bind_param("s", $email);
$cek_email->execute();
$cek_email->store_result();

if ($cek_email->num_rows > 0) {
    die("Email sudah digunakan!");
}

// Siapkan statement untuk menyimpan data
$stmt = $conn->prepare("INSERT INTO pengunjung (nama_depan, nama_belakang, email, password) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $nama_depan, $nama_belakang, $email, $hash);

if ($stmt->execute()) {
    echo "<script>
        alert('Data berhasil disimpan!');
        window.location.href = '../login.php';
    </script>";
    exit;
} else {
    echo "Terjadi kesalahan: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
