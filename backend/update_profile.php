<?php
// backend/update_profile.php

session_start();
require_once 'koneksi.php';

header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id_pengunjung'])) {
    $response['message'] = 'Anda tidak memiliki izin.';
    echo json_encode($response);
    exit();
}

$id_pengunjung = $_SESSION['user']['id_pengunjung'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'update_profile') {
        $nama_depan = $_POST['nama_depan'] ?? '';
        $nama_belakang = $_POST['nama_belakang'] ?? '';
        $email = $_POST['email'] ?? '';
        $no_tlp = $_POST['no_tlp'] ?? '';
        $deskripsi = $_POST['deskripsi'] ?? '';

        // Validasi input
        if (empty($nama_depan) || empty($email)) {
            $response['message'] = 'Nama depan dan email tidak boleh kosong.';
            echo json_encode($response);
            exit();
        }

        // Cek apakah email sudah digunakan oleh pengguna lain
        $stmt_check_email = $conn->prepare("SELECT id_pengunjung FROM pengunjung WHERE email = ? AND id_pengunjung != ?");
        $stmt_check_email->bind_param("si", $email, $id_pengunjung);
        $stmt_check_email->execute();
        $stmt_check_email->store_result();
        if ($stmt_check_email->num_rows > 0) {
            $response['message'] = 'Email sudah digunakan oleh akun lain.';
            echo json_encode($response);
            $stmt_check_email->close();
            exit();
        }
        $stmt_check_email->close();

        $stmt = $conn->prepare("UPDATE pengunjung SET nama_depan = ?, nama_belakang = ?, email = ?, no_tlp = ?, deskripsi = ? WHERE id_pengunjung = ?");
        $stmt->bind_param("sssssi", $nama_depan, $nama_belakang, $email, $no_tlp, $deskripsi, $id_pengunjung);

        if ($stmt->execute()) {
            // Perbarui data di session
            $_SESSION['user']['nama_depan'] = $nama_depan;
            $_SESSION['user']['nama_belakang'] = $nama_belakang;
            $_SESSION['user']['email'] = $email;
            $_SESSION['user']['no_tlp'] = $no_tlp;
            $_SESSION['user']['deskripsi'] = $deskripsi;
            $response['success'] = true;
            $response['message'] = 'Profil berhasil diperbarui.';
        } else {
            $response['message'] = 'Gagal memperbarui profil: ' . $stmt->error;
        }
        $stmt->close();

    } elseif ($action === 'update_password') {
        $current_password = $_POST['current_password'] ?? '';
        $new_password = $_POST['new_password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';

        if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
            $response['message'] = 'Semua kolom password harus diisi.';
            echo json_encode($response);
            exit();
        }

        if ($new_password !== $confirm_password) {
            $response['message'] = 'Konfirmasi password baru tidak cocok.';
            echo json_encode($response);
            exit();
        }
        
        // Minimal panjang password baru
        if (strlen($new_password) < 6) {
            $response['message'] = 'Password baru minimal 6 karakter.';
            echo json_encode($response);
            exit();
        }


        // Ambil password lama dari DB
        $stmt_check_pass = $conn->prepare("SELECT password FROM pengunjung WHERE id_pengunjung = ?");
        $stmt_check_pass->bind_param("i", $id_pengunjung);
        $stmt_check_pass->execute();
        $result_check_pass = $stmt_check_pass->get_result();
        $user_db = $result_check_pass->fetch_assoc();
        $stmt_check_pass->close();

        if ($user_db && password_verify($current_password, $user_db['password'])) {
            // Hash password baru
            $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);

            $stmt_update_pass = $conn->prepare("UPDATE pengunjung SET password = ? WHERE id_pengunjung = ?");
            $stmt_update_pass->bind_param("si", $hashed_new_password, $id_pengunjung);

            if ($stmt_update_pass->execute()) {
                $response['success'] = true;
                $response['message'] = 'Password berhasil diperbarui.';
            } else {
                $response['message'] = 'Gagal memperbarui password: ' . $stmt_update_pass->error;
            }
            $stmt_update_pass->close();
        } else {
            $response['message'] = 'Password saat ini salah.';
        }
    } else {
        $response['message'] = 'Aksi tidak valid.';
    }
} else {
    $response['message'] = 'Metode request tidak diizinkan.';
}

$conn->close();
echo json_encode($response);
?>