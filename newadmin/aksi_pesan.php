<?php
session_start();
require_once '../backend/koneksi.php'; // Sesuaikan path jika perlu

// Fungsi untuk redirect dengan pesan
function redirectWithMessage($message, $type, $location = 'pertanyaan.php') {
    $_SESSION['message'] = $message;
    $_SESSION['message_type'] = $type;
    header("Location: $location");
    exit();
}

// Validasi input dasar
if (!isset($_GET['action']) || !isset($_GET['id'])) {
    redirectWithMessage("Aksi tidak valid atau ID tidak ditemukan.", "alert-danger");
}

$action = $_GET['action'];
$id = (int)$_GET['id']; // Pastikan ID adalah integer

if ($id <= 0) {
    redirectWithMessage("ID pesan tidak valid.", "alert-danger");
}

// Gunakan switch untuk menangani berbagai aksi
switch ($action) {
    case 'mark_read':
    case 'mark_unread':
    case 'replied':
        // Aksi untuk mengubah status
        $new_status = '';
        if ($action == 'mark_read') $new_status = 'read';
        if ($action == 'mark_unread') $new_status = 'unread';
        if ($action == 'replied') $new_status = 'replied';
        
        $sql = "UPDATE contact_messages SET status = ? WHERE id_message = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("si", $new_status, $id);
            if ($stmt->execute()) {
                // Jika aksinya adalah reply, redirect ke mailto client
                if ($action == 'reply' && isset($_GET['email'])) {
                    $email = $_GET['email'];
                    $subject = isset($_GET['subject']) ? 'Re: ' . $_GET['subject'] : '';
                    header("Location: mailto:" . rawurldecode($email) . "?subject=" . rawurldecode($subject));
                    exit();
                }
                redirectWithMessage("Status pesan berhasil diperbarui.", "alert-success");
            } else {
                redirectWithMessage("Gagal memperbarui status pesan.", "alert-danger");
            }
            $stmt->close();
        } else {
            redirectWithMessage("Gagal menyiapkan statement database.", "alert-danger");
        }
        break;

    case 'delete':
        // Aksi untuk menghapus pesan
        $sql = "DELETE FROM contact_messages WHERE id_message = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                redirectWithMessage("Pesan berhasil dihapus secara permanen.", "alert-success");
            } else {
                redirectWithMessage("Gagal menghapus pesan.", "alert-danger");
            }
            $stmt->close();
        } else {
            redirectWithMessage("Gagal menyiapkan statement database.", "alert-danger");
        }
        break;

    case 'reply':
        // Aksi gabungan: update status ke 'replied' lalu redirect ke mailto
        $sql_update_status = "UPDATE contact_messages SET status = 'replied' WHERE id_message = ?";
        $stmt_update = $conn->prepare($sql_update_status);
        if ($stmt_update) {
            $stmt_update->bind_param("i", $id);
            $stmt_update->execute(); // Jalankan update
            $stmt_update->close();

            // Sekarang redirect ke mailto
            if (isset($_GET['email'])) {
                $email = $_GET['email'];
                $subject = isset($_GET['subject']) ? 'Re: ' . $_GET['subject'] : '';
                header("Location: mailto:" . rawurldecode($email) . "?subject=" . rawurldecode($subject));
                exit();
            } else {
                 redirectWithMessage("Email tujuan tidak ditemukan.", "alert-danger");
            }
        }
         redirectWithMessage("Gagal memperbarui status sebelum membalas.", "alert-danger");
        break;


    default:
        // Aksi tidak dikenal
        redirectWithMessage("Aksi tidak dikenal.", "alert-danger");
        break;
}

$conn->close();
?>