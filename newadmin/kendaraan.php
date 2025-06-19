<?php
session_start();
require_once '../backend/koneksi.php';

// --- Fetch Data Kendaraan ---
$kendaraan_list = [];
$sql = "SELECT id_kendaraan, jenis_kendaraan, gambar FROM kendaraan ORDER BY jenis_kendaraan ASC";
$result = $conn->query($sql);
if (!$result) {
    die("Error executing query: " . $conn->error);
}
while ($row = $result->fetch_assoc()) {
    $kendaraan_list[] = $row;
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Manajemen Kendaraan</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Menggunakan style yang sama persis dengan modul lain untuk konsistensi */
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f6f9; color: #333; line-height: 1.6; margin: 0; }
        .main-content { margin-left: 220px; padding: 30px; }
        .dashboard-header { background: #ffffff; border-radius: 8px; padding: 20px; margin-bottom: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); display: flex; justify-content: space-between; align-items: center; }
        .dashboard-header h1 { color: #2c3e50; font-size: 1.8rem; font-weight: 600; margin: 0; }
        .btn-add { background-color: #3498db; color: white; border: none; padding: 10px 18px; border-radius: 6px; cursor: pointer; font-weight: 500; font-size: 0.9rem; text-decoration: none; display: flex; align-items: center; gap: 8px; }
        .btn-add:hover { background-color: #2980b9; }
        .table-container { background: #ffffff; border-radius: 8px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow: hidden; }
        .table-wrapper { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        th { background-color: #f8f9fa; padding: 12px 15px; text-align: left; font-weight: 600; color: #495057; font-size: 0.85rem; text-transform: uppercase; border-bottom: 2px solid #dee2e6; }
        td { padding: 15px; border-bottom: 1px solid #ecf0f1; vertical-align: middle; font-size: 0.9rem; }
        .kendaraan-info { display: flex; align-items: center; gap: 15px; }
        .kendaraan-thumbnail { width: 100px; height: 60px; border-radius: 6px; background-color: #e9ecef; display: flex; align-items: center; justify-content: center; color: #adb5bd; overflow: hidden; flex-shrink: 0; }
        .kendaraan-thumbnail img { width: 100%; height: 100%; object-fit: cover; }
        .action-buttons { display: flex; gap: 8px; }
        .btn { padding: 8px 12px; border: none; border-radius: 6px; cursor: pointer; font-size: 0.85rem; text-decoration: none; color: white; }
        .btn i { font-size: 0.9em; }
        .btn-edit { background-color: #f39c12; }
        .btn-delete { background-color: #e74c3c; }
        .modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.5); }
        .modal-content { background-color: #fefefe; margin: 10% auto; padding: 25px 30px; border-radius: 10px; width: 80%; max-width: 500px; }
        .modal-header { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e5e5e5; padding-bottom: 15px; margin-bottom: 20px; }
        .close-button { color: #aaa; float: right; font-size: 28px; font-weight: bold; cursor: pointer; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: 600; }
        .form-group input { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
        .modal-footer { margin-top: 20px; padding-top: 20px; border-top: 1px solid #eee; display: flex; justify-content: flex-end; gap: 10px; }
        #notification { position: fixed; top: 20px; right: 20px; padding: 15px 20px; border-radius: 6px; color: white; font-weight: 500; z-index: 2000; display: none; }
        #notification.success { background-color: #2ecc71; }
        #notification.error { background-color: #e74c3c; }
    </style>
</head>
<body>
  <?php include '../komponen/sidebar_admin.php'; ?>
  <main class="main-content">
    <div id="notification"></div>
    <header class="dashboard-header">
      <h1>Manajemen Kendaraan</h1>
      <a href="tambah_kendaraan.php" class="btn-add"><i class="fas fa-plus"></i> Tambah Kendaraan</a>
    </header>

    <div class="table-container">
      <div class="table-wrapper">
        <table>
          <thead>
            <tr><th>Gambar</th><th>Jenis Kendaraan</th><th>Aksi</th></tr>
          </thead>
          <tbody>
            <?php if (!empty($kendaraan_list)): ?>
              <?php foreach($kendaraan_list as $kendaraan): ?>
              <tr data-id="<?php echo $kendaraan['id_kendaraan']; ?>">
                <td>
                  <div class="kendaraan-thumbnail">
                    <?php if (!empty($kendaraan['gambar']) && file_exists('../' . $kendaraan['gambar'])): ?>
                        <img src="../<?php echo htmlspecialchars($kendaraan['gambar']); ?>" alt="<?php echo htmlspecialchars($kendaraan['jenis_kendaraan']); ?>">
                    <?php else: ?>
                        <i class="fas fa-car-side"></i>
                    <?php endif; ?>
                  </div>
                </td>
                <td><?php echo htmlspecialchars($kendaraan['jenis_kendaraan']); ?></td>
                <td>
                  <div class="action-buttons">
                    <button class="btn btn-edit" onclick="openEditModal(<?php echo $kendaraan['id_kendaraan']; ?>)" title="Edit"><i class="fas fa-edit"></i> Edit</button>
                    <a href="../backend/hapus_kendaraan.php?id=<?php echo $kendaraan['id_kendaraan']; ?>" class="btn btn-delete" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus kendaraan ini?');"><i class="fas fa-trash"></i> Hapus</a>
                  </div>
                </td>
              </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr><td colspan="3" style="text-align: center; padding: 20px;">Tidak ada data kendaraan.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </main>

  <div id="editModal" class="modal"><div class="modal-content"><div class="modal-header"><h2 id="modalTitle">Edit Kendaraan</h2><span class="close-button">&times;</span></div><div class="modal-body" id="modalBody"></div></div></div>

  <script>
    const modal = document.getElementById('editModal');
    const modalBody = document.getElementById('modalBody');
    const closeBtn = document.querySelector('.close-button');

    closeBtn.onclick = () => modal.style.display = 'none';
    window.onclick = (event) => { if (event.target == modal) { modal.style.display = 'none'; } };

    async function openEditModal(id) {
        modal.style.display = 'block';
        modalBody.innerHTML = '<p>Memuat...</p>';
        try {
            const response = await fetch(`get_kendaraan_detail.php?id=${id}`);
            const data = await response.json();
            if (data.error) throw new Error(data.error);
            modalBody.innerHTML = data.html;
        } catch (error) {
            modalBody.innerHTML = `<p style="color: red;">Gagal memuat data: ${error.message}</p>`;
        }
    }

    modalBody.addEventListener('submit', async function(event) {
        if (event.target.id === 'editKendaraanForm') {
            event.preventDefault();
            const formData = new FormData(event.target);
            const submitButton = event.target.querySelector('button[type="submit"]');
            submitButton.disabled = true;
            submitButton.innerHTML = 'Menyimpan...';

            try {
                const response = await fetch('update_kendaraan.php', { method: 'POST', body: formData });
                const result = await response.json();
                if (result.status === 'success') {
                    modal.style.display = 'none';
                    showNotification(result.message, 'success');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    throw new Error(result.message);
                }
            } catch (error) {
                alert('Error: ' + error.message);
                submitButton.disabled = false;
                submitButton.innerHTML = 'Simpan Perubahan';
            }
        }
    });

    function showNotification(message, type) {
        const notification = document.getElementById('notification');
        notification.textContent = message;
        notification.className = type;
        notification.style.display = 'block';
        setTimeout(() => { notification.style.display = 'none'; }, 3000);
    }
  </script>
</body>
</html>