<?php
// File: logout.php

// Mulai session untuk mengakses data session
session_start();

// Hapus semua data session
session_unset();

// Hancurkan session
session_destroy();

// Redirect pengguna ke halaman login
header("Location: ../login.php");
exit();
?>