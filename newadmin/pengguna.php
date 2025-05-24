<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Manajemen Pengguna</title>
  <link rel="stylesheet" href="../CSS/adminuser.css"> 
</head>
<body>
  <?php include '../komponen/sidebar_admin.php'; ?>

  <main style="margin-left: 220px; padding: 20px; font-family: Arial, sans-serif;">
    <h1>Manajemen Pengguna</h1>
    <a href="tambah_pengguna.php" class="button">Tambah Pengguna</a>
    
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Nama</th>
          <th>Email</th>
          <th>Password</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Contoh data statis, ganti dengan data dari database
        $pengguna = [
          ['id' => 1, 'nama' => 'Admin Satu', 'email' => 'admin1@example.com' , 'password' => 'password123'],
          ['id' => 2, 'nama' => 'User Dua', 'email' => 'user2@example.com' , 'password' => 'password123']
        ];
        
        foreach ($pengguna as $user) {
          echo "<tr>
                  <td>{$user['id']}</td>
                  <td>{$user['nama']}</td>
                  <td>{$user['email']}</td>
                  <td>{$user['password']}</td>
                  <td>
                    <a href='edit_pengguna.php?id={$user['id']}' class='button edit'>Edit</a>
                    <a href='hapus_pengguna.php?id={$user['id']}' class='button delete' onclick='return confirm(\"Yakin ingin menghapus pengguna ini?\")'>Hapus</a>
                  </td>
                </tr>";
        }
        ?>
      </tbody>
    </table>
  </main>
</body>
</html>
