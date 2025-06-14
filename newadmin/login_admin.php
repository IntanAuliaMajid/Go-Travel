<?php
// Memulai session di baris paling atas
session_start();

// Jika admin sudah login, redirect ke halaman dashboard
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: dashboard.php"); // Ganti dashboard.php jika nama file Anda berbeda
    exit;
}

require_once '../backend/koneksi.php'; // Sesuaikan path koneksi.php

$error_message = '';

// Cek apakah form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Validasi input
    if (empty(trim($_POST['username'])) || empty(trim($_POST['password']))) {
        $error_message = 'Username dan Password tidak boleh kosong.';
    } else {
        $username_or_email = trim($_POST['username']);
        $password = trim($_POST['password']);

        // Menyiapkan statement untuk mencegah SQL Injection
        // Memungkinkan login via username atau email
        $sql = "SELECT id_admin, username, email, password FROM admin WHERE username = ? OR email = ?";
        
        $stmt = $conn->prepare($sql);
        
        if ($stmt) {
            $stmt->bind_param("ss", $username_or_email, $username_or_email);
            
            if ($stmt->execute()) {
                $stmt->store_result();
                
                // Cek jika user ditemukan
                if ($stmt->num_rows == 1) {
                    $stmt->bind_result($id_admin, $username, $email, $hashed_password);
                    if ($stmt->fetch()) {
                        // Verifikasi password
                        if (password_verify($password, $hashed_password)) {
                            
                            // Password benar, mulai session baru
                            session_regenerate_id(); // Mencegah session fixation
                            
                            $_SESSION['admin_logged_in'] = true;
                            $_SESSION['id_admin'] = $id_admin;
                            $_SESSION['username_admin'] = $username;

                            // Update last_login
                            $update_sql = "UPDATE admin SET last_login = CURRENT_TIMESTAMP WHERE id_admin = ?";
                            $update_stmt = $conn->prepare($update_sql);
                            if($update_stmt) {
                                $update_stmt->bind_param("i", $id_admin);
                                $update_stmt->execute();
                                $update_stmt->close();
                            }
                            
                            // Redirect ke halaman dashboard admin
                            header("Location: dashboard.php"); // Ganti jika perlu
                            exit;

                        } else {
                            // Password salah
                            $error_message = 'Username atau Password yang Anda masukkan salah.';
                        }
                    }
                } else {
                    // User tidak ditemukan
                    $error_message = 'Username atau Password yang Anda masukkan salah.';
                }
            } else {
                $error_message = 'Terjadi kesalahan. Silakan coba lagi.';
            }
            $stmt->close();
        } else {
             $error_message = 'Terjadi kesalahan pada database. Silakan coba lagi.';
        }
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Go Travel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #3b82f6;
            --primary-dark: #2563eb;
            --background-color: #f3f4f6;
            --form-background: #ffffff;
            --text-color: #1f2937;
            --border-color: #e5e7eb;
            --danger-color: #ef4444;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--background-color);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            color: var(--text-color);
        }

        .login-container {
            background-color: var(--form-background);
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .login-header h2 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .login-header p {
            color: #6b7280;
            margin-bottom: 30px;
        }

        .input-group {
            position: relative;
            margin-bottom: 20px;
        }

        .input-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
        }

        .input-field {
            width: 100%;
            padding: 12px 12px 12px 45px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .input-field:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-login:hover {
            background-color: var(--primary-dark);
        }

        .error-message {
            background-color: #fee2e2;
            color: var(--danger-color);
            border: 1px solid var(--danger-color);
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 14px;
            display: <?php echo !empty($error_message) ? 'block' : 'none'; ?>;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h2>Admin Login</h2>
            <p>Selamat datang kembali! Silakan masuk.</p>
        </div>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            
            <div class="error-message">
                <?php echo $error_message; ?>
            </div>

            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="username" class="input-field" placeholder="Username atau Email" required>
            </div>
            
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" class="input-field" placeholder="Password" required>
            </div>
            
            <button type="submit" class="btn-login">Masuk</button>
        </form>
    </div>
</body>