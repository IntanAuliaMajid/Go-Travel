<?php
// backend/proses_login.php

session_start();

// Koneksi ke database
include "koneksi.php";

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Ambil data dari form dan gunakan prepared statement untuk keamanan
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// Validasi input dasar
if (empty($email) || empty($password)) {
    $_SESSION['login_error'] = "Email dan password harus diisi!";
    header("Location: ../login.php");
    exit();
}

// Cari user berdasarkan email menggunakan prepared statement
$stmt = $conn->prepare("SELECT id_pengunjung, nama_depan, nama_belakang, username, email, no_tlp, deskripsi, avatar, password FROM pengunjung WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
    
    // Verifikasi password
    if (password_verify($password, $user['password'])) {
        // Login berhasil! Simpan data user yang LENGKAP ke session
        // Data ini akan digunakan di halaman profil dan bagian lain yang memerlukan info user
        $_SESSION['user'] = [
            'id_pengunjung' => $user['id_pengunjung'],
            'nama_depan'    => $user['nama_depan'],
            'nama_belakang' => $user['nama_belakang'],
            'username'      => $user['username'],
            'email'         => $user['email'],
            'no_tlp'        => $user['no_tlp'],
            'deskripsi'     => $user['deskripsi'],
            'avatar'        => $user['avatar'] ? $user['avatar'] : './uploads/avatars/default_avatar.png' // Pastikan path avatar default
        ];
        
        // Redirect ke halaman beranda setelah login berhasil
        header("Location: ../beranda.php"); // Atau ke beranda.php jika itu halaman utama Anda
        exit();
    }
}

// Jika login gagal (email tidak ditemukan atau password salah)
$_SESSION['login_error'] = "Email atau password salah!";
header("Location: ../login.php");
exit();

$stmt->close();
$conn->close();
?>