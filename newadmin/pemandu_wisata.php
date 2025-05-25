<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Dashboard Admin</title>
</head>

  <?php include '../komponen/sidebar_admin.php'; ?>
<body>
  <!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Manajemen Pemandu Wisata</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(135deg, #8e44ad, #6c5ce7);
      padding: 40px 20px;
    }
    .container {
      background: white;
      border-radius: 12px;
      padding: 24px;
      max-width: 1200px;
      margin: auto;
      box-shadow: 0 4px 16px rgba(0,0,0,0.1);
      margin-left: 240px;
      padding: 30px;
      min-height: 100vh;
      transition: margin-left 0.3s ease;
    }
    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 24px;
    }
    header h1 {
      margin: 0;
      color: #5a4fcf;
    }
    header button {
      background-color: #3498db;
      color: white;
      border: none;
      padding: 10px 18px;
      border-radius: 8px;
      cursor: pointer;
      font-weight: bold;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
    .guide-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }
    .guide-table th, .guide-table td {
      padding: 12px 16px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }
    .status {
      padding: 6px 12px;
      border-radius: 12px;
      font-size: 0.9em;
      font-weight: bold;
    }
    .online {
      background-color: #d1f5e0;
      color: #2ecc71;
    }
    .offline {
      background-color: #f9d6d5;
      color: #e74c3c;
    }
    .badge {
      padding: 5px 10px;
      border-radius: 12px;
      font-size: 0.8em;
      background: #f1f1f1;
      font-weight: bold;
    }
    .actions button {
      margin-right: 6px;
      padding: 6px 10px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      color: white;
    }
    .view { background: #6c5ce7; }
    .edit { background: #3498db; }
    .delete { background: #e74c3c; }
  </style>
  <div class="container">
    <header>
      <h1>Manajemen Pemandu Wisata</h1>
      <button onclick="tambahPemandu()">+ Tambah Pemandu</button>
    </header>
    <table class="guide-table">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama</th>
          <th>Email</th>
          <th>Status</th>
          <th>Bahasa</th>
          <th>Pengalaman</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody id="guide-list">
        <tr>
          <td>1</td>
          <td>Rizky Maulana</td>
          <td>rizky.guide@example.com</td>
          <td><span class="status online">Online</span></td>
          <td><span class="badge">Indonesia, Inggris</span></td>
          <td>5 tahun</td>
          <td class="actions">
            <button class="view">Lihat</button>
            <button class="edit">Edit</button>
            <button class="delete" onclick="hapusBaris(this)">Hapus</button>
          </td>
        </tr>
        <tr>
          <td>2</td>
          <td>Sarah Nabila</td>
          <td>sarah.guide@example.com</td>
          <td><span class="status offline">Offline</span></td>
          <td><span class="badge">Indonesia, Jepang</span></td>
          <td>3 tahun</td>
          <td class="actions">
            <button class="view">Lihat</button>
            <button class="edit">Edit</button>
            <button class="delete" onclick="hapusBaris(this)">Hapus</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>

  <script>
    function tambahPemandu() {
      const tbody = document.getElementById("guide-list");
      const no = tbody.rows.length + 1;
      const tr = document.createElement("tr");
      tr.innerHTML = `
        <td>${no}</td>
        <td>Nama Baru</td>
        <td>guidebaru@example.com</td>
        <td><span class="status online">Online</span></td>
        <td><span class="badge">Indonesia</span></td>
        <td>1 tahun</td>
        <td class="actions">
          <button class="view">Lihat</button>
          <button class="edit">Edit</button>
          <button class="delete" onclick="hapusBaris(this)">Hapus</button>
        </td>
      `;
      tbody.appendChild(tr);
    }

    function hapusBaris(button) {
      const row = button.closest("tr");
      row.remove();
      updateNomorUrut();
    }

    function updateNomorUrut() {
      const rows = document.querySelectorAll("#guide-list tr");
      rows.forEach((row, index) => {
        row.querySelector("td").textContent = index + 1;
      });
    }
  </script>

</body>
</html>
