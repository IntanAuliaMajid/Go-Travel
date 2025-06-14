<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Go-Travel</title>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', sans-serif;
    }

    body {
      background:black;
    }

    .container {
      display: flex;
      min-height: 100vh;
    }

    .form-box {
      flex: 1;
      background: black;
      padding: 60px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .form-box h2 {
        color: white;
      margin-bottom: 20px;
    }

    .form-box label {
        color: white;
      margin-top: 15px;
      font-weight: 600;
      display: block; /* Agar label selalu di atas input */
    }

    .form-box input {
      width: 100%; /* Agar input memenuhi lebar form */
      padding: 10px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .form-box .link-small {
      font-size: 0.9em;
      color: #0a7dbf;
      margin-top: 10px;
      text-decoration: none;
    }

    .form-box .masuk {
      text-decoration: none;
      display: flex;
      justify-content: center;
      margin-top: 20px;
      padding: 12px;
      background-color: #4a90e2;
      color: white;
      border: none;
      border-radius: 5px;
      font-size: 1em;
      cursor: pointer;
      width: 100%; /* Samakan lebar dengan input */
    }

    .form-box p {
        color:white;
      margin-top: 15px;
      font-size: 0.95em;
    }

    .form-box p a {
      color: #0a7dbf;
      text-decoration: none;
    }

    .image-box {
      flex: 1;
      background:url("batik1.jpg");
      color: white;
      text-align: center;
      padding: 60px 30px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
    }

    .image-box img {
      width: 500px;
      margin-bottom: 20px;
    }
  </style>
</head>
<body>
  <div class="container">
    <form class="form-box" action="backend/proses_daftar.php" method="POST">
      <h2>Daftar</h2>
      
      <label for="nama_depan">Nama Awal</label>
      <input type="text" id="nama_depan" name="nama_depan" placeholder="Masukan nama awal kamu disini.." required>
      
      <label for="nama_belakang">Nama Akhir</label>
      <input type="text" id="nama_belakang" name="nama_belakang" placeholder="Masukan nama akhir kamu disini.." required>

      <label for="username">Username</label>
      <input type="text" id="username" name="username" placeholder="Masukan username kamu disini.." required>
      <label for="email">Alamat Email</label>
      <input type="email" id="email" name="email" placeholder="Masukan alamat email kamu disini.." required>

      <label for="password">Password</label>
      <input type="password" id="password" name="password" placeholder="Masukan kata sandi kamu disini.." required>

      <label for="konfirmasi_password">Konfirmasi Password</label>
      <input type="password" id="konfirmasi_password" name="konfirmasi_password" placeholder="Masukan kembali kata sandi disini.." required>

      <button type="submit" class="masuk">Daftar</button>
      <p>Sudah punya akun? <a href="login.php">Masuk Disini</a></p>
    </form>
    <div class="image-box">
      <img src="Gambar/logo.png" alt="Logo">
    </div>
  </div>
</body>
</html>