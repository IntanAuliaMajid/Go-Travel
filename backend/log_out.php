<?php
// 1. Memulai atau melanjutkan session yang sudah ada.
// Ini adalah langkah wajib sebelum bisa memanipulasi session.
session_start();

// 2. Menghapus semua variabel session.
// Cara ini akan mengosongkan array $_SESSION.
$_SESSION = array();

// 3. Menghancurkan session.
// Langkah ini akan menghapus session itu sendiri di server.
session_destroy();

// 4. Mengarahkan pengguna kembali ke halaman login.
// Pengguna yang sudah logout tidak boleh berada di halaman kosong.
header("location: ../newadmin/login_admin.php");

// 5. Memastikan tidak ada kode lain yang dieksekusi setelah redirect.
exit;
?>