<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Go-Travel - Login</title>
    <link rel="stylesheet" href="./CSS/login.css">
</head>
<body>
    <div class="container">
        <form class="form-box" action="backend/proses_login.php" method="POST">
            <h2>Selamat Datang Kembali!</h2>

            <label for="username_or_email">Username atau Email</label>
            <input type="text" id="username_or_email" name="username_or_email" placeholder="Masukkan username atau email kamu.." required>

            <label for="password">Kata Sandi</label>
            <input type="password" id="password" name="password" placeholder="Masukkan kata sandi kamu di sini.." required>

            <a href="#" class="link-small">Lupa password?</a>

            <button type="submit" class="masuk">Masuk</button>

            <p>Belum punya akun? <a href="daftar.php">Daftar di sini</a></p>
        </form>

        <div class="image-box">
            <img src="./Gambar/logo.png" alt="Logo Go-Travel">
        </div>
    </div>
</body>
</html>