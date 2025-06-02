<?php
// backend/proses_login.php

session_start();

// Koneksi ke database (sesuaikan dengan konfigurasi Anda)
include "koneksi.php";

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Ambil data dari form
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

// Cari user berdasarkan email
$query = "SELECT * FROM pengunjung WHERE email = '$email'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 1) {
    $user = mysqli_fetch_assoc($result);
    
    // Verifikasi password
    if (password_verify($password, $user['password'])) {
        // Simpan data user ke session
        $_SESSION['user'] = [
            'id' => $user['id_pengunjung'],
            'name' => $user['name'],
            'email' => $user['email'],
            'avatar' => $user['avatar'] ? $user['avatar'] : 'default_avatar.png'
        ];
        
        // Redirect ke halaman beranda setelah login berhasil
        header("Location: ../beranda.php");
        exit();
    }
}

// Jika login gagal
$_SESSION['login_error'] = "Email atau password salah!";
header("Location: ../login.php");
exit();
?>