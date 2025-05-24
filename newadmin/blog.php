<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Manajemen Blog - Admin</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f9f9f9;
      margin: 0;
    }
    main {
      margin-left: 220px;
      padding: 20px;
    }
    h1 {
      margin-bottom: 20px;
    }
    a.button {
      display: inline-block;
      padding: 8px 12px;
      margin: 5px 0;
      background-color: #4CAF50;
      color: white;
      text-decoration: none;
      border-radius: 4px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      background-color: #fff;
    }
    th, td {
      padding: 12px;
      border: 1px solid #ddd;
      text-align: left;
    }
    th {
      background-color: #f2f2f2;
    }
    .actions a {
      margin-right: 6px;
      padding: 6px 10px;
      border-radius: 4px;
      color: white;
      text-decoration: none;
    }
    .edit {
      background-color: #2196F3;
    }
    .delete {
      background-color: #f44336;
    }
  </style>
</head>
<body>
  <?php include '../komponen/sidebar_admin.php'; ?>

  <main>
    <h1>Manajemen Blog</h1>
    <a href="tambah_blog.php" class="button">+ Tambah Artikel</a>

    <table>
      <thead>
        <tr>
          <th>Judul</th>
          <th>Penulis</th>
          <th>Tanggal</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Data statis, ganti dengan data dari database
        $blogs = [
          ['id' => 1, 'judul' => '10 Tips Aman Mendaki Gunung untuk Pemula', 'penulis' => 'John Doe', 'tanggal' => '2024-07-15', 'status' => 'Dipublikasikan'],
          ['id' => 2, 'judul' => '7 Pantai Tersembunyi di Indonesia Timur', 'penulis' => 'Jane Smith', 'tanggal' => '2024-07-12', 'status' => 'Draft']
        ];

        foreach ($blogs as $blog) {
          echo "<tr>
                  <td>{$blog['judul']}</td>
                  <td>{$blog['penulis']}</td>
                  <td>{$blog['tanggal']}</td>
                  <td>{$blog['status']}</td>
                  <td class='actions'>
                    <a href='edit_blog.php?id={$blog['id']}' class='edit'>Edit</a>
                    <a href='hapus_blog.php?id={$blog['id']}' class='delete' onclick='return confirm(\"Hapus artikel ini?\")'>Hapus</a>
                  </td>
                </tr>";
        }
        ?>
      </tbody>
    </table>
  </main>
</body>
</html>
