<?php

$conn = new mysqli("localhost", "root", "", "go_travel");

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}