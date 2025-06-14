<?php
session_start();
require_once '../backend/koneksi.php';

// --- Fetch Data Kuliner ---
$kuliner_list = [];
$sql = "SELECT id_akomodasi_kuliner, nama_restaurant, gambar_url FROM akomodasi_kuliner ORDER BY nama_restaurant ASC";
$result = $conn->query($sql);
if (!$result) {
    die("Error executing query: " . $conn->error);
}
while ($row = $result->fetch_assoc()) {
    $kuliner_list[] = $row;
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Manajemen Kuliner</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f6f9; color: #333; margin: 0; }
        .main-content { margin-left: 250px; padding: 30px; }
        .dashboard-header { background: #ffffff; border-radius: 8px; padding: 20px; margin-bottom: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); display: flex; justify-content: space-between; align-items: center; }
        .dashboard-header h1 { color: #2c3e50; font-size: 1.8rem; font-weight: 600; margin: 0; }
        .btn-add { background-color: #3498db; color: white; border: none; padding: 10px 18px; border-radius: 6px; cursor: pointer; text-decoration: none; display: flex; align-items: center; gap: 8px; }
        .table-container { background: #ffffff; border-radius: 8px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow: hidden; }
        table { width: 100%; border-collapse: collapse; }
        th { background-color: #f8f9fa; padding: 12px 15px; text-align: left; font-weight: 600; color: #495057; font-size: 0.85rem; text-transform: uppercase; border-bottom: 2px solid #dee2e6; }
        td { padding: 15px; border-bottom: 1px solid #ecf0f1; vertical-align: middle; }
        .thumbnail { width: 120px; height: 70px; border-radius: 6px; background-color: #e9ecef; display: flex; align-items: center; justify-content: center; color: #adb5bd; overflow: hidden; flex-shrink: 0; }
        .thumbnail img { width: 100%; height: 100%; object-fit: cover; }
        .action-buttons { display: flex; gap: 8px; }
        .btn { padding: 8px 12px; border: none; border-radius: 6px; cursor: pointer; text-decoration: none; color: white; }
        .btn-edit { background-color: #f39c12; }
        .btn-delete { background-color: #e74c3c; }
        .modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.5); }
        .modal-content { background-color: #fefefe; margin: 10% auto; padding: 25px 30px; border-radius: 10px; width: 80%; max-width: 500px; }
        .modal-header { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e5e5e5; padding-bottom: 15px; margin-bottom: 20px; }
        .close-button { color: #aaa; font-size: 28px; font-weight: bold; cursor: pointer; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: 600; }
        .form-group input, .form-group textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
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
      <h1>Manajemen Kuliner</h1>
      <a href="../backend/tambah_kuliner.php" class="btn-add"><i class="fas fa-plus"></i> Tambah Kuliner</a>
    </header>

    <div class="table-container">
        <table>
          <thead>
            <tr><th>Gambar</th><th>Nama Restaurant/Kuliner</th><th>Aksi</th></tr>
          </thead>
          <tbody>
            <?php if (!empty($kuliner_list)): ?>
              <?php foreach($kuliner_list as $item): ?>
              <tr>
                <td>
                  <div class="thumbnail">
                    <?php if (!empty($item['gambar_url']) && file_exists('../' . $item['gambar_url'])): ?>
                        <img src="../<?php echo htmlspecialchars($item['gambar_url']); ?>" alt="<?php echo htmlspecialchars($item['nama_restaurant']); ?>">
                    <?php else: ?>
                        <i class="fas fa-utensils fa-2x"></i>
                    <?php endif; ?>
                  </div>
                </td>
                <td><?php echo htmlspecialchars($item['nama_restaurant']); ?></td>
                <td>
                  <div class="action-buttons">
                    <button class="btn btn-edit" onclick="openEditModal(<?php echo $item['id_akomodasi_kuliner']; ?>)" title="Edit"><i class="fas fa-edit"></i> Edit</button>
                    <a href="../backend/hapus_kuliner.php?id=<?php echo $item['id_akomodasi_kuliner']; ?>" class="btn btn-delete" title="Hapus" onclick="return confirm('Apakah Anda yakin?');"><i class="fas fa-trash"></i> Hapus</a>
                  </div>
                </td>
              </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr><td colspan="3" style="text-align: center; padding: 20px;">Tidak ada data kuliner.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
    </div>
  </main>

  <div id="editModal" class="modal"><div class="modal-content"><div class="modal-header"><h2>Edit Kuliner</h2><span class="close-button">&times;</span></div><div class="modal-body" id="modalBody"></div></div></div>

  <script>
    const modal = document.getElementById('editModal');
    const modalBody = document.getElementById('modalBody');
    const closeBtn = document.querySelector('.close-button');

    closeBtn.onclick = () => modal.style.display = 'none';
    window.onclick = (event) => { if (event.target == modal) { modal.style.display = 'none'; } };

    async function openEditModal(id) {
        // Pengecekan di sisi JavaScript untuk memastikan ID adalah angka
        if (!id || typeof id !== 'number') {
            alert("Error: ID yang diterima oleh JavaScript tidak valid atau kosong!");
            console.error("Invalid ID received:", id);
            return;
        }

        modal.style.display = 'block';
        modalBody.innerHTML = '<p style="text-align:center;">Memuat...</p>';
        try {
            const response = await fetch(`../backend/get_kuliner_detail.php?id=${id}`);
            const data = await response.json();
            if (data.error) throw new Error(data.error);
            modalBody.innerHTML = data.html;
        } catch (error) {
            modalBody.innerHTML = `<p style="color: red;">Gagal memuat data: ${error.message}</p>`;
        }
    }

    modalBody.addEventListener('submit', async function(event) {
        if (event.target.id === 'editKulinerForm') {
            event.preventDefault();
            const formData = new FormData(event.target);
            const submitButton = event.target.querySelector('button[type="submit"]');
            submitButton.disabled = true;
            submitButton.innerHTML = 'Menyimpan...';
            try {
                const response = await fetch('../backend/update_kuliner.php', { method: 'POST', body: formData });
                const result = await response.json();
                if (result.status === 'success') {
                    modal.style.display = 'none';
                    showNotification(result.message, 'success');
                    setTimeout(() => location.reload(), 1500);
                } else { throw new Error(result.message); }
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