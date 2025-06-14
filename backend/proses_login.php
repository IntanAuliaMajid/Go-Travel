<?php
// backend/proses_login.php

session_start();

// Koneksi ke database
include "koneksi.php";

if (!$conn) {
    // Sebaiknya tidak menampilkan error teknis ke pengguna
    // Cukup catat di log server dan tampilkan pesan umum
    error_log("Koneksi database gagal: " . mysqli_connect_error());
    $_SESSION['login_error'] = "Terjadi masalah pada server. Silakan coba lagi nanti.";
    header("Location: ../login.php");
    exit();
}

// 1. Ambil input dari form dengan nama 'username_or_email'
$login_identifier = $_POST['username_or_email'] ?? '';
$password = $_POST['password'] ?? '';

// Validasi input dasar
if (empty($login_identifier) || empty($password)) {
    $_SESSION['login_error'] = "Username/Email dan Password harus diisi!";
    header("Location: ../login.php");
    exit();
}

// 2. Tentukan apakah input adalah email atau username
$field_type = filter_var($login_identifier, FILTER_VALIDATE_EMAIL) ? "email" : "username";

// 3. Siapkan query yang dinamis berdasarkan tipe input
$sql = "SELECT id_pengunjung, nama_depan, nama_belakang, username, email, no_tlp, deskripsi, avatar, password FROM pengunjung WHERE $field_type = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    error_log("Gagal menyiapkan statement: " . $conn->error);
    $_SESSION['login_error'] = "Terjadi kesalahan sistem. Silakan coba lagi.";
    header("Location: ../login.php");
    exit();
}

// 4. Bind parameter dengan input dari pengguna
$stmt->bind_param("s", $login_identifier);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
    
    // 5. Verifikasi password
    if (password_verify($password, $user['password'])) {
        // Login berhasil!
        
        // ==========================================================
        // PERUBAHAN DI SINI: Update timestamp last_login untuk pengguna ini
        // ==========================================================
        $update_stmt = $conn->prepare("UPDATE pengunjung SET last_login = NOW() WHERE id_pengunjung = ?");
        $update_stmt->bind_param("i", $user['id_pengunjung']);
        $update_stmt->execute();
        $update_stmt->close();
        // ==========================================================

        // Hapus pesan error lama jika ada
        unset($_SESSION['login_error']);

        // Simpan data user yang LENGKAP ke session
        $_SESSION['user'] = [
            'id_pengunjung' => $user['id_pengunjung'],
            'nama_depan'    => $user['nama_depan'],
            'nama_belakang' => $user['nama_belakang'],
            'username'      => $user['username'],
            'email'         => $user['email'],
            'no_tlp'        => $user['no_tlp'],
            'deskripsi'     => $user['deskripsi'],
            'avatar'        => $user['avatar'] ? $user['avatar'] : './uploads/avatars/default_avatar.png'
        ];
        
        // Tandai bahwa user sudah login
        $_SESSION['is_logged_in'] = true;
        
        // Redirect ke halaman utama setelah login berhasil
        header("Location: ../beranda.php"); // Pastikan ini halaman utama Anda setelah login
        exit();
    }
}

// Jika login gagal (user tidak ditemukan atau password salah)
$_SESSION['login_error'] = "Username/Email atau Password salah!";
header("Location: ../login.php");
exit();

$stmt->close();
$conn->close();
?>