<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Kontak Admin</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(135deg, #8e44ad, #6c5ce7);
    }
    .container {
      display: flex;
      min-height: 100vh;
    }
    .main-content {
      flex: 1;
      background: white;
      padding: 30px;
      margin: 40px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
      margin-left: 300px;
      padding: 30px;
      min-height: 100vh;
      transition: margin-left 0.3s ease;
    }
    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    header h1 {
      margin: 0;
    }
    header button {
      background: linear-gradient(135deg, #6c5ce7, #8e44ad);
      border: none;
      padding: 10px 20px;
      color: white;
      border-radius: 6px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }
    header button:hover {
      background-color: #5a4fcf;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    th, td {
      text-align: left;
      padding: 12px;
      border-bottom: 1px solid #ddd;
    }
    .edit, .delete {
      padding: 6px 12px;
      border: none;
      border-radius: 4px;
      color: white;
      cursor: pointer;
      transition: opacity 0.3s ease;
    }
    .edit { background-color: #f39c12; }
    .edit:hover { opacity: 0.8; }
    .delete { background-color: #e74c3c; }
    .delete:hover { opacity: 0.8; }
  </style>
</head>
<body>
  <div class="container">
    <?php include '../komponen/sidebar_admin.php'; ?>
    
    <div class="main-content">
      <header>
        <h1>Daftar Kontak Admin</h1>
        <button onclick="tambahAdmin()">+ Tambah Admin</button>
      </header>

      <table>
        <thead>
          <tr>
            <th>NO</th>
            <th>Nama</th>
            <th>Email</th>
            <th>No. Telepon</th>
            <th>Jabatan</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody id="admin-list">
          <tr>
            <td>1</td>
            <td>Andi Saputra</td>
            <td>andi@admin.com</td>
            <td>081234567890</td>
            <td>Super Admin</td>
            <td>
              <button class="edit">Edit</button>
              <button class="delete" onclick="hapusBaris(this)">Hapus</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <script>
    function tambahAdmin() {
      const tbody = document.getElementById("admin-list");
      const no = tbody.rows.length + 1;
      const tr = document.createElement("tr");
      tr.innerHTML = `
        <td>${no}</td>
        <td>Nama Admin</td>
        <td>admin@email.com</td>
        <td>08xxxxxxxxxx</td>
        <td>Admin</td>
        <td>
          <button class="edit">Edit</button>
          <button class="delete" onclick="hapusBaris(this)">Hapus</button>
        </td>
      `;
      tbody.appendChild(tr);
    }

    function hapusBaris(btn) {
      const row = btn.parentNode.parentNode;
      row.parentNode.removeChild(row);
      const tbody = document.getElementById("admin-list");
      for (let i = 0; i < tbody.rows.length; i++) {
        tbody.rows[i].cells[0].textContent = i + 1;
      }
    }
  </script>
</body>
</html>
