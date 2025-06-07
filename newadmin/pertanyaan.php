<?php
require_once '../backend/koneksi.php'; // Sesuaikan path jika perlu

// --- Konfigurasi Pagination ---
$messages_per_page = 10; // Jumlah pesan per halaman
$current_page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($current_page - 1) * $messages_per_page;

// --- Helper Functions ---
function time_ago_message($timestamp_str) {
    if (empty($timestamp_str)) return 'N/A';
    try {
        $time_ago = strtotime($timestamp_str);
        $current_time = time();
        $time_difference = $current_time - $time_ago;
        $seconds = $time_difference;
        $minutes = round($seconds / 60);
        $hours = round($seconds / 3600);
        $days = round($seconds / 86400);
        $weeks = round($seconds / 604800);
        $months = round($seconds / 2629440);
        $years = round($seconds / 31553280);

        if ($seconds <= 60) return "Baru saja";
        elseif ($minutes <= 60) return ($minutes == 1) ? "1 menit lalu" : "$minutes menit lalu";
        elseif ($hours <= 24) return ($hours == 1) ? "1 jam lalu" : "$hours jam lalu";
        elseif ($days <= 7) return ($days == 1) ? "Kemarin" : "$days hari lalu";
        elseif ($weeks <= 4.3) return ($weeks == 1) ? "1 minggu lalu" : "$weeks minggu lalu";
        elseif ($months <= 12) return ($months == 1) ? "1 bulan lalu" : "$months bulan lalu";
        else return ($years == 1) ? "1 tahun lalu" : "$years tahun lalu";
    } catch (Exception $e) {
        return 'Timestamp Invalid';
    }
}

function message_preview($text, $length = 100) {
    if (empty($text)) return '';
    $text = strip_tags($text);
    if (mb_strlen($text) > $length) {
        $text = mb_substr($text, 0, $length) . '...';
    }
    return $text;
}

// --- Handle Filters & Search ---
$filter_search = isset($_GET['search']) ? trim($_GET['search']) : '';
$filter_status = isset($_GET['status_filter']) ? $_GET['status_filter'] : '';

$where_clauses = [];
$params = [];
$types = "";

if (!empty($filter_search)) {
    $where_clauses[] = "(CONCAT(first_name, ' ', last_name) LIKE ? OR email LIKE ? OR subject LIKE ? OR message LIKE ?)";
    $like_term = "%" . $filter_search . "%";
    for ($i = 0; $i < 4; $i++) {
        $params[] = $like_term;
        $types .= "s";
    }
}

if (!empty($filter_status)) {
    $where_clauses[] = "status = ?";
    $params[] = $filter_status;
    $types .= "s";
}

$sql_base = "FROM contact_messages";
$sql_where = "";
if (!empty($where_clauses)) {
    $sql_where = " WHERE " . implode(" AND ", $where_clauses);
}

// Query untuk total pesan (untuk pagination)
$sql_total_messages = "SELECT COUNT(*) as total " . $sql_base . $sql_where;
$stmt_total = $conn->prepare($sql_total_messages);
$total_messages = 0;
if ($stmt_total) {
    if (!empty($params)) {
        $stmt_total->bind_param($types, ...$params);
    }
    if ($stmt_total->execute()) {
        $result_total_messages = $stmt_total->get_result();
        $total_messages = $result_total_messages->fetch_assoc()['total'] ?? 0;
    }
    $stmt_total->close();
}
$total_pages = ceil($total_messages / $messages_per_page);
if ($current_page > $total_pages && $total_pages > 0) $current_page = $total_pages; // Adjust current page if out of bounds
$offset = ($current_page - 1) * $messages_per_page;


// Query untuk mengambil pesan dengan limit dan offset
$messages = [];
$sql_messages = "SELECT id_message, first_name, last_name, email, subject, message, received_at, status "
              . $sql_base . $sql_where . "
                 ORDER BY received_at DESC
                 LIMIT ? OFFSET ?";

$stmt_messages = $conn->prepare($sql_messages);
if ($stmt_messages) {
    $current_params = $params; // Salin params dari filter
    $current_types = $types;   // Salin types dari filter
    
    $current_params[] = $messages_per_page;
    $current_types .= "i";
    $current_params[] = $offset;
    $current_types .= "i";

    if (!empty($current_params)) {
         if (count($current_params) > 0) { // Check if there are params to bind
            $stmt_messages->bind_param($current_types, ...$current_params);
        }
    }
    
    if ($stmt_messages->execute()) {
        $result_messages_data = $stmt_messages->get_result();
        while ($row = $result_messages_data->fetch_assoc()) {
            $messages[] = $row;
        }
    } else {
        error_log("Error executing messages statement: " . $stmt_messages->error);
    }
    $stmt_messages->close();
} else {
    error_log("Error preparing messages statement: " . $conn->error);
}

$conn->close();

$status_map = [
    'unread' => ['text' => 'Belum Dibaca', 'class' => 'status-unread', 'row_class' => 'unread'],
    'read' => ['text' => 'Sudah Dibaca', 'class' => 'status-read', 'row_class' => 'read'],
    'replied' => ['text' => 'Sudah Dibalas', 'class' => 'status-replied', 'row_class' => 'replied'] // Anda perlu menambahkan style untuk .status-replied dan .replied jika mau
];

?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin - Kelola Pesan Kontak | Go Travel Indonesia</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --primary: #3b82f6; --primary-dark: #2563eb; --danger: #ef4444;
      --danger-dark: #dc2626; --success: #10b981; --success-dark: #059669;
      --warning: #f59e0b; --warning-dark: #d97706; --unread-bg: #fef9c3; /* Kuning muda untuk unread row */
      --header-bg: #f9fafb; --border-color: #e5e7eb; --text-light: #6b7280;
      --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
      background-color: #f3f4f6; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0; padding: 0; min-height: 100vh; color: #1f2937;
    }
    main { margin-left: 250px; padding: 24px; transition: all 0.3s ease; } /* Sesuaikan margin-left */
    .container { background-color: white; padding: 24px; border-radius: 12px; box-shadow: var(--shadow); }
    .page-header {
      display: flex; justify-content: space-between; align-items: center;
      margin-bottom: 24px; flex-wrap: wrap; gap: 16px;
    }
    h2 {
      font-size: 24px; font-weight: 700; color: #111827;
      display: flex; align-items: center; gap: 10px;
    }
    h2 i { color: var(--primary); }
    .header-actions { display: flex; gap: 12px; flex-wrap: wrap; }
    .search-filter-form { display: flex; gap: 12px; flex-wrap: wrap; } /* Form untuk search dan filter */

    .search-container { position: relative; display: flex; align-items: center; }
    .search-container input, .filter-select {
      padding: 10px 16px; border: 1px solid var(--border-color);
      border-radius: 6px; font-size: 14px; transition: all 0.3s;
    }
    .search-container input { padding-left: 40px; width: 250px; } /* Width adjusted */
    .filter-select { min-width: 180px; }

    .search-container input:focus, .filter-select:focus {
      outline: none; border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
    }
    .search-container i.fa-search { position: absolute; left: 14px; color: var(--text-light); }
    
    .btn-apply-filter {
        background: var(--primary); color: white; border: none; padding: 10px 16px;
        border-radius: 6px; cursor: pointer; font-size: 14px; font-weight: 500;
        display: flex; align-items: center; gap: 6px; transition: background-color 0.2s ease;
    }
    .btn-apply-filter:hover { background: var(--primary-dark); }


    table {
      width: 100%; border-collapse: separate; border-spacing: 0;
      border: 1px solid var(--border-color); border-radius: 8px; overflow: hidden;
    }
    thead { background-color: var(--header-bg); text-align: left; }
    th, td { padding: 14px 16px; font-size: 14px; vertical-align: top; border-bottom: 1px solid var(--border-color); } /* Padding adjusted */
    th { color: #374151; font-weight: 600; position: relative; }
    th:not(:last-child):after { /* Separator line for th */
      content: ''; position: absolute; top: 20%; right: 0;
      height: 60%; width: 1px; background-color: var(--border-color);
    }
    tbody tr { transition: background-color 0.2s; }
    tbody tr:hover { background-color: #f9fafb; }

    tr.unread { background-color: var(--unread-bg); /* border-left: 4px solid var(--warning); */ font-weight: 500; }
    tr.read { /* No special background needed, just normal */ }
    tr.replied { background-color: #eef2ff; /* Light indigo for replied */ }

    /* Styling for the dot in the first cell of unread messages */
    td.cell-nama { position: relative; }
    tr.unread td.cell-nama::before {
        content: ''; position: absolute; left: 6px; /* Adjusted position */
        top: 50%; transform: translateY(-50%); width: 8px; height: 8px;
        background-color: var(--warning); border-radius: 50%;
    }


    .message-preview {
      display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
      overflow: hidden; text-overflow: ellipsis; max-width: 280px; line-height: 1.5; /* Max-width adjusted */
    }
    .btn {
      padding: 7px 12px; border: none; border-radius: 6px; color: white; /* Padding adjusted */
      cursor: pointer; font-size: 13px; font-weight: 500; /* Font-size adjusted */
      display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s;
    }
    .btn-reply { background-color: var(--primary); }
    .btn-reply:hover { background-color: var(--primary-dark); transform: translateY(-1px); box-shadow: 0 2px 4px rgba(59, 130, 246, 0.2); }
    .btn-delete { background-color: var(--danger); }
    .btn-delete:hover { background-color: var(--danger-dark); transform: translateY(-1px); box-shadow: 0 2px 4px rgba(239, 68, 68, 0.2); }
    .btn-mark-action { background-color: var(--success); } /* Generic class for mark read/unread */
    .btn-mark-action:hover { background-color: var(--success-dark); transform: translateY(-1px); box-shadow: 0 2px 4px rgba(16, 185, 129, 0.2); }

    .action-buttons { display: flex; gap: 8px; flex-wrap: wrap; } /* Gap adjusted */

    .status-badge { display: inline-block; padding: 3px 8px; border-radius: 15px; font-size: 11px; font-weight: 500; } /* Padding and font-size adjusted */
    .status-unread { background-color: #fef3c7; color: #92400e; }
    .status-read { background-color: #d1fae5; color: #065f46; }
    .status-replied { background-color: #e0e7ff; color: #3730a3; }


    .pagination { display: flex; justify-content: flex-end; margin-top: 24px; gap: 8px; }
    .pagination-btn {
      min-width: 36px; height: 36px; padding: 0 10px; display: flex; align-items: center; justify-content: center;
      border-radius: 6px; border: 1px solid var(--border-color); background: white;
      cursor: pointer; transition: all 0.2s; text-decoration: none; color: #374151;
    }
    .pagination-btn:hover { background-color: #f3f4f6; border-color: var(--primary); color: var(--primary); }
    .pagination-btn.active { background-color: var(--primary); border-color: var(--primary); color: white; }
    .pagination-btn.disabled { pointer-events: none; background-color: #e9ecef; color: #adb5bd; border-color: var(--border-color); }

    .timestamp { color: var(--text-light); font-size: 12px; margin-top: 4px; display: block; } /* Font-size adjusted */

    @media (max-width: 1024px) { main { margin-left: 0px; padding: 16px; } /* Sidebar collapsed */ }
    @media (max-width: 768px) {
      .container { padding: 16px; }
      .page-header { flex-direction: column; align-items: flex-start; }
      .search-filter-form { width: 100%; flex-direction: column; }
      .search-container input, .filter-select { width: 100%; }
      .btn-apply-filter { width: 100%; justify-content: center; }
      /* table { display: block; overflow-x: auto; } */ /* Already handled by div wrapper */
      .action-buttons { flex-direction: row; } /* Keep horizontal for actions if possible */
    }
    @media (max-width: 480px) {
      main { padding: 12px; }
      .btn span, .btn-apply-filter span { display: none; } /* Hide text on very small screens */
      .btn i, .btn-apply-filter i { margin-right: 0; }
      th, td { padding: 10px 8px; font-size: 13px; }
      .message-preview { max-width: 150px; }
    }
  </style>
</head>
<body>
  <?php include '../Komponen/sidebar_admin.php'; // Pastikan path ini benar ?>

  <main>
    <div class="container">
      <div class="page-header">
        <h2><i class="fas fa-envelope-open-text"></i> Pesan Masuk</h2>
        <form method="GET" action="" class="search-filter-form">
            <div class="search-container">
                <i class="fas fa-search"></i>
                <input type="text" name="search" id="searchInput" placeholder="Cari nama, email, subjek..." value="<?php echo htmlspecialchars($filter_search); ?>">
            </div>
            <select name="status_filter" class="filter-select">
                <option value="">Semua Status</option>
                <option value="unread" <?php if ($filter_status == 'unread') echo 'selected'; ?>>Belum Dibaca</option>
                <option value="read" <?php if ($filter_status == 'read') echo 'selected'; ?>>Sudah Dibaca</option>
                <option value="replied" <?php if ($filter_status == 'replied') echo 'selected'; ?>>Sudah Dibalas</option>
            </select>
            <button type="submit" class="btn-apply-filter">
                <i class="fas fa-filter"></i>
                <span>Filter</span>
            </button>
        </form>
      </div>
      
      <div style="overflow-x:auto;">
        <table>
          <thead>
            <tr>
              <th style="width: 20%;">Dari</th>
              <th style="width: 15%;">Subjek</th>
              <th style="width: 30%;">Pesan</th>
              <th style="width: 15%;">Status</th>
              <th style="width: 20%;">Tindakan</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($messages)): ?>
              <?php foreach ($messages as $msg): ?>
                <?php
                    $current_status_info = $status_map[$msg['status']] ?? ['text' => ucfirst($msg['status']), 'class' => '', 'row_class' => ''];
                ?>
                <tr class="<?php echo htmlspecialchars($current_status_info['row_class']); ?>">
                  <td class="cell-nama">
                    <?php echo htmlspecialchars(trim($msg['first_name'] . ' ' . $msg['last_name'])); ?>
                    <span class="timestamp"><?php echo htmlspecialchars($msg['email']); ?></span>
                    <span class="timestamp"><?php echo time_ago_message($msg['received_at']); ?></span>
                  </td>
                  <td><?php echo htmlspecialchars($msg['subject']); ?></td>
                  <td class="message-preview"><?php echo htmlspecialchars(message_preview($msg['message'], 100)); ?></td>
                  <td>
                    <span class="status-badge <?php echo htmlspecialchars($current_status_info['class']); ?>">
                        <?php echo htmlspecialchars($current_status_info['text']); ?>
                    </span>
                  </td>
                  <td>
                    <div class="action-buttons">
                      <a href="mailto:<?php echo htmlspecialchars($msg['email']); ?>?subject=Re: <?php echo htmlspecialchars(rawurlencode($msg['subject'])); ?>" class="btn btn-reply" title="Balas via Email">
                        <i class="fas fa-reply"></i>
                        <span>Balas</span>
                      </a>
                      <?php if ($msg['status'] == 'unread'): ?>
                        <a href="aksi_pesan.php?action=mark_read&id=<?php echo $msg['id_message']; ?>" class="btn btn-mark-action" title="Tandai Sudah Dibaca">
                          <i class="fas fa-check-circle"></i>
                          <span>Dibaca</span>
                        </a>
                      <?php elseif ($msg['status'] == 'read'): ?>
                         <a href="aksi_pesan.php?action=mark_unread&id=<?php echo $msg['id_message']; ?>" class="btn btn-mark-action" style="background-color: var(--warning);" title="Tandai Belum Dibaca">
                          <i class="fas fa-envelope"></i>
                          <span>Belum Dibaca</span>
                        </a>
                      <?php endif; ?>
                      <a href="aksi_pesan.php?action=delete&id=<?php echo $msg['id_message']; ?>" class="btn btn-delete" title="Hapus Pesan" onclick="return confirm('Anda yakin ingin menghapus pesan ini?');">
                        <i class="fas fa-trash-alt"></i>
                        <span>Hapus</span>
                      </a>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="5" style="text-align: center; padding: 20px;">
                    <?php echo (empty($filter_search) && empty($filter_status)) ? 
                    'Tidak ada pesan masuk.' : 'Tidak ada pesan ditemukan sesuai filter/pencarian.'; ?>
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
      
      <?php if ($total_pages > 1): ?>
      <div class="pagination">
        <a href="?page=<?php echo max(1, $current_page - 1); ?>&search=<?php echo urlencode($filter_search); ?>&status_filter=<?php echo $filter_status; ?>" 
           class="pagination-btn <?php echo ($current_page <= 1) ? 'disabled' : ''; ?>">
            <i class="fas fa-chevron-left"></i>
        </a>

        <?php 
        $num_links_around_current = 1; // Jumlah link sebelum dan sesudah halaman saat ini
        $start_page = max(1, $current_page - $num_links_around_current);
        $end_page = min($total_pages, $current_page + $num_links_around_current);

        if ($start_page > 1) {
            echo '<a href="?page=1&search='.urlencode($filter_search).'&status_filter='.$filter_status.'" class="pagination-btn">1</a>';
            if ($start_page > 2) {
                echo '<span class="pagination-btn disabled" style="cursor:default;">...</span>';
            }
        }

        for ($i = $start_page; $i <= $end_page; $i++): ?>
            <a href="?page=<?php echo $i; ?>&search=<?php echo urlencode($filter_search); ?>&status_filter=<?php echo $filter_status; ?>" 
               class="pagination-btn <?php echo ($i == $current_page) ? 'active' : ''; ?>">
                <?php echo $i; ?>
            </a>
        <?php endfor; 
        
        if ($end_page < $total_pages) {
            if ($end_page < $total_pages - 1) {
                echo '<span class="pagination-btn disabled" style="cursor:default;">...</span>';
            }
            echo '<a href="?page='.$total_pages.'&search='.urlencode($filter_search).'&status_filter='.$filter_status.'" class="pagination-btn">'.$total_pages.'</a>';
        }
        ?>
        
        <a href="?page=<?php echo min($total_pages, $current_page + 1); ?>&search=<?php echo urlencode($filter_search); ?>&status_filter=<?php echo $filter_status; ?>" 
           class="pagination-btn <?php echo ($current_page >= $total_pages) ? 'disabled' : ''; ?>">
            <i class="fas fa-chevron-right"></i>
        </a>
      </div>
      <?php endif; ?>

    </div>
  </main>

  <script>
    // Client-side search (opsional, karena PHP sudah handle search on page load if ?search=... is present)
    // Jika ingin real-time search tanpa reload, bisa diaktifkan dan disesuaikan.
    // const searchInput = document.getElementById('searchInput');
    // searchInput.addEventListener('input', function() {
    //   const searchTerm = this.value.toLowerCase();
    //   const rows = document.querySelectorAll('tbody tr');
    //   rows.forEach(row => {
    //     const textContent = row.textContent.toLowerCase();
    //     row.style.display = textContent.includes(searchTerm) ? '' : 'none';
    //   });
    // });

    // Fungsi markAsRead client-side (untuk efek visual instan)
    // Aksi backend tetap diperlukan melalui link yang di-klik.
    function markAsReadVisual(buttonEl) {
        const row = buttonEl.closest('tr');
        if (row) {
            row.classList.remove('unread');
            row.classList.add('read'); // Atau 'replied' tergantung aksi
            
            const statusBadge = row.querySelector('.status-badge');
            if (statusBadge) {
                statusBadge.classList.remove('status-unread');
                // Ganti dengan kelas status yang sesuai, misal 'status-read'
                statusBadge.classList.add('status-read'); 
                statusBadge.textContent = 'Sudah Dibaca'; // Atau 'Sudah Dibalas'
            }
            
            // Ganti tombol atau hapus tombol "Tandai Dibaca"
            // Ini hanya contoh visual, logika tombol server-side yang utama
            buttonEl.textContent = 'Sudah Dibaca';
            buttonEl.disabled = true; 
        }
    }
  </script>
</body>
</html>