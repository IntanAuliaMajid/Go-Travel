<?php
session_start();
header('Content-Type: application/json');

// Include koneksi database
include 'koneksi.php'; // Sesuaikan path

// Ambil data dari POST
$order_id = $_POST['order_id'] ?? null;
$payment_status = $_POST['payment_status'] ?? null;
$payment_method = $_POST['payment_method'] ?? 'midtrans';
$transaction_id = $_POST['transaction_id'] ?? null;
$gross_amount = $_POST['gross_amount'] ?? 0;

// Validasi
if (!$order_id || !$payment_status) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid parameters']);
    exit;
}

// Mapping status
$db_status = '';
switch ($payment_status) {
    case 'success': $db_status = 'completed'; break;
    case 'pending': $db_status = 'pending'; break;
    case 'error': $db_status = 'failed'; break;
    default: $db_status = 'pending';
}

// Update database
try {
    $update_sql = "UPDATE pemesanan SET 
        status_pemesanan = ?, 
        payment_method = ?, 
        midtrans_transaction_id = ?, 
        gross_amount_paid = ? 
        WHERE kode_pemesanan = ?";
    
    $stmt = mysqli_prepare($conn, $update_sql);
    
    mysqli_stmt_bind_param($stmt, "sssss", 
        $db_status,
        $payment_method,
        $transaction_id,
        $gross_amount,
        $order_id
    );
    
    mysqli_stmt_execute($stmt);
    
    echo json_encode([
        'status' => 'success',
        'redirect_url' => "pembayaran_konfirmasi.php?order_id=$order_id&status=$db_status"
    ]);
    
} catch (Exception $e) {
    error_log("Database Error: " . $e->getMessage());
    echo json_encode([
        'status' => 'error',
        'message' => 'Database update failed'
    ]);
}
?>