<?php
session_start();
require_once '../backend/koneksi.php';

// Helper functions
function display_rating_stars($rating) {
    if ($rating === null) return 'N/A';
    $rating_int = floor($rating);
    $output = '';
    for ($i = 1; $i <= 5; $i++) {
        $output .= '<i class="' . ($i <= $rating_int ? 'fas' : 'far') . ' fa-star" style="color: #f39c12;"></i>';
    }
    return $output . ' <span style="font-weight: 500; font-size: 0.9em; color: #555;">(' . number_format($rating, 1) . ')</span>';
}

function get_initials($nama) {
    $words = explode(' ', $nama);
    $initials = '';
    $i = 0;
    foreach ($words as $w) {
        if ($i < 2 && !empty($w)) { $initials .= strtoupper($w[0]); $i++; }
    }
    return $initials ?: 'NN';
}

// --- Fetch Data Pemandu Wisata ---
$pemandu_wisata = [];
$sql = "SELECT 
            p.id_pemandu_wisata, p.nama_pemandu, p.email, p.pengalaman, p.rating, p.foto_url,
            l.nama_lokasi,
            (SELECT GROUP_CONCAT(b.nama_bahasa SEPARATOR ', ')
             FROM pemandu_bahasa pb
             JOIN bahasa b ON pb.id_bahasa = b.id_bahasa
             WHERE pb.id_pemandu_wisata = p.id_pemandu_wisata) AS bahasa_dikuasai
        FROM pemandu_wisata p
        LEFT JOIN lokasi l ON p.id_lokasi = l.id_lokasi
        ORDER BY p.nama_pemandu ASC";

$result = $conn->query($sql);
if (!$result) {
    die("Error executing query: " . $conn->error);
}
while ($row = $result->fetch_assoc()) {
    $pemandu_wisata[] = $row;
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Manajemen Pemandu Wisata</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
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
        .pemandu-info { display: flex; align-items: center; gap: 15px; }
        .pemandu-avatar { width: 45px; height: 45px; border-radius: 50%; background-color: #6c5ce7; display: flex; align-items: center; justify-content: center; color: white; font-weight: 500; font-size: 1.2rem; overflow: hidden; flex-shrink: 0; }
        .pemandu-avatar img { width: 100%; height: 100%; object-fit: cover; }
        .pemandu-details h4 { color: #2c3e50; font-weight: 600; margin: 0; font-size: 0.95rem; }
        .pemandu-details span { color: #777; font-size: 0.85rem; }
        .action-buttons { display: flex; gap: 8px; }
        .btn { padding: 8px 12px; border: none; border-radius: 6px; cursor: pointer; font-size: 0.85rem; transition: opacity 0.2s ease; display: inline-flex; align-items: center; gap: 5px; text-decoration: none; color: white; }
        .btn i { font-size: 0.9em; }
        .btn-view { background-color: #3498db; }
        .btn-edit { background-color: #f39c12; }
        .btn-delete { background-color: #e74c3c; }
        .badge { padding: 4px 10px; border-radius: 12px; font-size: 0.8em; background: #e9ecef; color: #495057; font-weight: 500; white-space: nowrap; }
        .modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.5); animation: fadeIn 0.3s; }
        .modal-content { background-color: #fefefe; margin: 5% auto; padding: 25px 30px; border-radius: 10px; width: 80%; max-width: 700px; box-shadow: 0 5px 15px rgba(0,0,0,0.3); animation: slideIn 0.3s; }
        .modal-header { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e5e5e5; padding-bottom: 15px; margin-bottom: 20px; }
        .close-button { color: #aaa; float: right; font-size: 28px; font-weight: bold; cursor: pointer; }
        .modal-body { max-height: 70vh; overflow-y: auto; padding-right: 15px; }
        .modal-footer { margin-top: 20px; padding-top: 20px; border-top: 1px solid #eee; display: flex; justify-content: flex-end; gap: 10px; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        .form-group { margin-bottom: 15px; }
        .full-width { grid-column: 1 / -1; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: 600; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
        .language-group { display: flex; flex-wrap: wrap; gap: 15px; border: 1px solid #ddd; padding: 10px; border-radius: 5px; }
        .language-item { display: flex; align-items: center; gap: 5px; }
        #notification { position: fixed; top: 20px; right: 20px; padding: 15px 20px; border-radius: 6px; color: white; font-weight: 500; z-index: 2000; display: none; animation: slideIn 0.5s, fadeOut 0.5s 2.5s; }
        #notification.success { background-color: #2ecc71; }
        #notification.error { background-color: #e74c3c; }
        @keyframes fadeIn { from {opacity: 0;} to {opacity: 1;} }
        @keyframes fadeOut { from {opacity: 1;} to {opacity: 0;} }
        @keyframes slideIn { from {transform: translateY(-50px);} to {transform: translateY(0);} }
    </style>
</head>
<body>
  <?php include '../komponen/sidebar_admin.php'; ?>
  <main class="main-content">
    <div id="notification"></div>
    <header class="dashboard-header">
      <h1>Manajemen Pemandu Wisata</h1>
      <a href="tambah_pemandu.php" class="btn-add"><i class="fas fa-plus"></i> Tambah Pemandu</a>
    </header>

    <div class="table-container">
      <div class="table-wrapper">
        <table>
          <thead>
            <tr><th>Pemandu</th><th>Lokasi</th><th>Bahasa</th><th>Rating</th><th>Aksi</th></tr>
          </thead>
          <tbody>
            <?php if (!empty($pemandu_wisata)): ?>
              <?php foreach($pemandu_wisata as $pemandu): ?>
              <tr data-id="<?php echo $pemandu['id_pemandu_wisata']; ?>">
                <td>
                  <div class="pemandu-info">
                    <div class="pemandu-avatar">
                        <?php if (!empty($pemandu['foto_url']) && filter_var($pemandu['foto_url'], FILTER_VALIDATE_URL)): ?><img src="<?php echo htmlspecialchars($pemandu['foto_url']); ?>" alt="Avatar"><?php else: echo get_initials(htmlspecialchars($pemandu['nama_pemandu'])); endif; ?>
                    </div>
                    <div class="pemandu-details">
                      <h4><?php echo htmlspecialchars($pemandu['nama_pemandu']); ?></h4>
                      <span><?php echo htmlspecialchars($pemandu['email']); ?></span>
                    </div>
                  </div>
                </td>
                <td><span class="badge"><?php echo htmlspecialchars($pemandu['nama_lokasi'] ?? 'N/A'); ?></span></td>
                <td><?php echo htmlspecialchars($pemandu['bahasa_dikuasai'] ?? 'N/A'); ?></td>
                <td><?php echo display_rating_stars($pemandu['rating']); ?></td>
                <td>
                  <div class="action-buttons">
                    <button class="btn btn-view" onclick="openModal('view', <?php echo $pemandu['id_pemandu_wisata']; ?>)" title="Lihat"><i class="fas fa-eye"></i></button>
                    <button class="btn btn-edit" onclick="openModal('edit', <?php echo $pemandu['id_pemandu_wisata']; ?>)" title="Edit"><i class="fas fa-edit"></i></button>
                    <a href="hapus_pemandu.php?id=<?php echo $pemandu['id_pemandu_wisata']; ?>" class="btn btn-delete" title="Hapus" onclick="return confirm('Apakah Anda yakin?');"><i class="fas fa-trash"></i></a>
                  </div>
                </td>
              </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr><td colspan="5" style="text-align: center; padding: 20px;">Tidak ada data pemandu wisata.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </main>

  <div id="dataModal" class="modal"><div class="modal-content"><div class="modal-header"><h2 id="modalTitle"></h2><span class="close-button">&times;</span></div><div class="modal-body" id="modalBody"></div></div></div>

  <script>
    const modal = document.getElementById('dataModal');
    const modalTitle = document.getElementById('modalTitle');
    const modalBody = document.getElementById('modalBody');
    const closeBtn = document.querySelector('.close-button');

    closeBtn.onclick = () => modal.style.display = 'none';
    window.onclick = (event) => { if (event.target == modal) { modal.style.display = 'none'; } };

    async function openModal(type, id) {
        modal.style.display = 'block';
        modalTitle.innerText = type === 'view' ? 'Detail Pemandu Wisata' : 'Edit Pemandu Wisata';
        modalBody.innerHTML = '<p>Memuat...</p>';

        try {
            const response = await fetch(`get_pemandu_detail.php?id=${id}&type=${type}`);
            const data = await response.json();
            if (data.error) throw new Error(data.error);
            modalBody.innerHTML = data.html;
        } catch (error) {
            modalBody.innerHTML = `<p style="color: red;">Gagal memuat data: ${error.message}</p>`;
        }
    }

    modalBody.addEventListener('submit', async function(event) {
        if (event.target.id === 'editPemanduForm') {
            event.preventDefault();
            const form = event.target;
            const formData = new FormData(form);
            const submitButton = form.querySelector('button[type="submit"]');
            submitButton.disabled = true;
            submitButton.innerHTML = 'Menyimpan...';

            try {
                const response = await fetch('update_pemandu.php', { method: 'POST', body: formData });
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