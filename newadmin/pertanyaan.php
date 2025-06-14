<?php
// Mulai session di baris paling atas untuk menangani notifikasi
session_start();

require_once '../backend/koneksi.php'; // Sesuaikan path jika perlu

// --- Konfigurasi Pagination ---
$messages_per_page = 10;
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

        if ($seconds <= 60) return "Baru saja";
        elseif ($minutes <= 60) return ($minutes == 1) ? "1 menit lalu" : "$minutes menit lalu";
        elseif ($hours <= 24) return ($hours == 1) ? "1 jam lalu" : "$hours jam lalu";
        else return ($days == 1) ? "Kemarin" : "$days hari lalu";
    } catch (Exception $e) {
        return 'Timestamp Invalid';
    }
}

function message_preview($text, $length = 100) {
    if (empty($text)) return '';
    $text = strip_tags($text);
    return mb_strlen($text) > $length ? mb_substr($text, 0, $length) . '...' : $text;
}

// --- Handle Filters & Search ---
$filter_search = isset($_GET['search']) ? trim($_GET['search']) : '';
$filter_status = isset($_GET['status_filter']) ? $_GET['status_filter'] : '';

$where_clauses = [];
$params = [];
$types = "";

if (!empty($filter_search)) {
    $where_clauses[] = "(CONCAT(first_name, ' ', last_name) LIKE ? OR email LIKE ? OR subject LIKE ?)";
    $like_term = "%" . $filter_search . "%";
    $params = array_merge($params, [$like_term, $like_term, $like_term]);
    $types .= "sss";
}

if (!empty($filter_status)) {
    $where_clauses[] = "status = ?";
    $params[] = $filter_status;
    $types .= "s";
}

$sql_base = "FROM contact_messages";
$sql_where = !empty($where_clauses) ? " WHERE " . implode(" AND ", $where_clauses) : "";

// Query untuk total pesan (untuk pagination)
$sql_total_messages = "SELECT COUNT(*) as total " . $sql_base . $sql_where;
$stmt_total = $conn->prepare($sql_total_messages);
$total_messages = 0;
if ($stmt_total) {
    if (!empty($params)) {
        $stmt_total->bind_param($types, ...$params);
    }
    if ($stmt_total->execute()) {
        $total_messages = $stmt_total->get_result()->fetch_assoc()['total'] ?? 0;
    }
    $stmt_total->close();
}
$total_pages = ceil($total_messages / $messages_per_page);
if ($current_page > $total_pages && $total_pages > 0) $current_page = $total_pages;
$offset = ($current_page - 1) * $messages_per_page;

// Query untuk mengambil pesan dengan limit dan offset
$messages = [];
$sql_messages = "SELECT id_message, first_name, last_name, email, subject, message, received_at, status "
    . $sql_base . $sql_where . " ORDER BY received_at DESC LIMIT ? OFFSET ?";
$stmt_messages = $conn->prepare($sql_messages);
if ($stmt_messages) {
    $current_params = $params;
    $current_types = $types;
    
    $current_params[] = $messages_per_page;
    $current_types .= "i";
    $current_params[] = $offset;
    $current_types .= "i";

    if (!empty($current_params)) {
        $stmt_messages->bind_param($current_types, ...$current_params);
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
}
$conn->close();

$status_map = [
    'unread' => ['text' => 'Belum Dibaca', 'class' => 'status-unread', 'row_class' => 'unread'],
    'read' => ['text' => 'Sudah Dibaca', 'class' => 'status-read', 'row_class' => 'read'],
    'replied' => ['text' => 'Sudah Dibalas', 'class' => 'status-replied', 'row_class' => 'replied']
];

?>
<!DOCTYPE html>
<html lang="id">
<head>
 <meta charset="UTF-8" />
 <meta name="viewport" content="width=device-width, initial-scale=1.0" />
 <title>Admin - Kelola Pesan Kontak | Go Travel</title>
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
 <style>
    :root {
     --primary: #3b82f6; --primary-dark: #2563eb; --danger: #ef4444;
     --danger-dark: #dc2626; --success: #10b981; --success-dark: #059669;
     --warning: #f59e0b; --warning-dark: #d97706; --unread-bg: #fefce8;
     --header-bg: #f9fafb; --border-color: #e5e7eb; --text-light: #6b7280;
     --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { background-color: #f3f4f6; font-family: 'Segoe UI', sans-serif; }
    main { margin-left: 250px; padding: 24px; transition: all 0.3s ease; }
    .container { background-color: white; padding: 24px; border-radius: 12px; box-shadow: var(--shadow); }
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 16px; }
    h2 { font-size: 24px; font-weight: 700; color: #111827; display: flex; align-items: center; gap: 10px; }
    h2 i { color: var(--primary); }
    .search-filter-form { display: flex; gap: 12px; flex-wrap: wrap; }
    .search-container { position: relative; display: flex; align-items: center; }
    .search-container input, .filter-select { padding: 10px 16px; border: 1px solid var(--border-color); border-radius: 6px; font-size: 14px; }
    .search-container input { padding-left: 40px; width: 250px; }
    .filter-select { min-width: 180px; }
    .search-container input:focus, .filter-select:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2); }
    .search-container i.fa-search { position: absolute; left: 14px; color: var(--text-light); }
    .btn-apply-filter { background: var(--primary); color: white; border: none; padding: 10px 16px; border-radius: 6px; cursor: pointer; font-size: 14px; font-weight: 500; display: flex; align-items: center; gap: 6px; }
    .btn-apply-filter:hover { background: var(--primary-dark); }
    table { width: 100%; border-collapse: separate; border-spacing: 0; border: 1px solid var(--border-color); border-radius: 8px; overflow: hidden; }
    thead { background-color: var(--header-bg); text-align: left; }
    th, td { padding: 14px 16px; font-size: 14px; vertical-align: top; border-bottom: 1px solid var(--border-color); }
    th { color: #374151; font-weight: 600; }
    tbody tr:hover { background-color: #f9fafb; }
    tr.unread { background-color: var(--unread-bg); font-weight: 600; color: #1f2937; }
    tr.replied { background-color: #eef2ff; }
    td.cell-nama { position: relative; }
    tr.unread td.cell-nama::before { content: ''; position: absolute; left: 6px; top: 50%; transform: translateY(-50%); width: 8px; height: 8px; background-color: var(--primary); border-radius: 50%; }
    .message-preview { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; max-width: 300px; line-height: 1.5; }
    .btn { padding: 7px 12px; border: none; border-radius: 6px; color: white; cursor: pointer; font-size: 13px; font-weight: 500; display: inline-flex; align-items: center; gap: 6px; text-decoration: none; }
    .btn-reply { background-color: var(--primary); } .btn-reply:hover { background-color: var(--primary-dark); }
    .btn-delete { background-color: var(--danger); } .btn-delete:hover { background-color: var(--danger-dark); }
    .btn-mark-read { background-color: var(--success); } .btn-mark-read:hover { background-color: var(--success-dark); }
    .btn-mark-unread { background-color: var(--warning); color: #1f2937; } .btn-mark-unread:hover { background-color: var(--warning-dark); }
    .action-buttons { display: flex; gap: 8px; flex-wrap: wrap; }
    .status-badge { display: inline-block; padding: 4px 10px; border-radius: 15px; font-size: 11px; font-weight: 600; }
    .status-unread { background-color: var(--unread-bg); color: #ca8a04; border: 1px solid #fde68a; }
    .status-read { background-color: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
    .status-replied { background-color: #e0e7ff; color: #4338ca; border: 1px solid #c7d2fe; }
    .pagination { display: flex; justify-content: flex-end; margin-top: 24px; gap: 8px; }
    .pagination-btn { min-width: 36px; height: 36px; padding: 0 10px; display: flex; align-items: center; justify-content: center; border-radius: 6px; border: 1px solid var(--border-color); background: white; cursor: pointer; text-decoration: none; color: #374151; }
    .pagination-btn:hover { background-color: #f3f4f6; border-color: var(--primary); color: var(--primary); }
    .pagination-btn.active { background-color: var(--primary); border-color: var(--primary); color: white; }
    .pagination-btn.disabled { pointer-events: none; background-color: #e9ecef; color: #adb5bd; }
    .timestamp { color: var(--text-light); font-size: 12px; margin-top: 4px; display: block; font-weight: 400; }
    .alert { padding: 16px; margin-bottom: 20px; border-radius: 8px; font-weight: 500; display: flex; align-items: center; gap: 12px; }
    .alert-success { background-color: #d1fae5; color: #065f46; }
    .alert-danger { background-color: #fee2e2; color: #991b1b; }
    .alert .close-btn { margin-left: auto; background: none; border: none; font-size: 20px; cursor: pointer; color: inherit; }
    @media (max-width: 1024px) { main { margin-left: 0px; } }
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
       <button type="submit" class="btn-apply-filter"><i class="fas fa-filter"></i><span>Filter</span></button>
     </form>
    </div>
    
    <?php if (isset($_SESSION['message'])): ?>
      <div class="alert <?php echo $_SESSION['message_type']; ?>">
        <i class="fas <?php echo $_SESSION['message_type'] == 'alert-success' ? 'fa-check-circle' : 'fa-times-circle'; ?>"></i>
        <span><?php echo $_SESSION['message']; ?></span>
        <button class="close-btn" onclick="this.parentElement.style.display='none'">&times;</button>
      </div>
      <?php unset($_SESSION['message']); unset($_SESSION['message_type']); ?>
    <?php endif; ?>

    <div style="overflow-x:auto;">
      <table>
        <thead>
          <tr>
            <th style="width: 25%;">Dari</th>
            <th style="width: 20%;">Subjek</th>
            <th style="width: 30%;">Pesan</th>
            <th style="width: 10%;">Status</th>
            <th style="width: 15%;">Tindakan</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($messages)): ?>
            <?php foreach ($messages as $msg): ?>
              <?php $current_status_info = $status_map[$msg['status']]; ?>
              <tr class="<?php echo htmlspecialchars($current_status_info['row_class']); ?>">
                <td class="cell-nama">
                  <?php echo htmlspecialchars(trim($msg['first_name'] . ' ' . $msg['last_name'])); ?>
                  <span class="timestamp"><?php echo htmlspecialchars($msg['email']); ?></span>
                  <span class="timestamp"><?php echo time_ago_message($msg['received_at']); ?></span>
                </td>
                <td><?php echo htmlspecialchars($msg['subject']); ?></td>
                <td class="message-preview" title="<?php echo htmlspecialchars($msg['message']); ?>"><?php echo htmlspecialchars(message_preview($msg['message'], 100)); ?></td>
                <td>
                  <span class="status-badge <?php echo htmlspecialchars($current_status_info['class']); ?>">
                    <?php echo htmlspecialchars($current_status_info['text']); ?>
                  </span>
                </td>
                <td>
                  <div class="action-buttons">
                    <a href="aksi_pesan.php?action=reply&id=<?php echo $msg['id_message']; ?>&email=<?php echo htmlspecialchars($msg['email']); ?>&subject=<?php echo htmlspecialchars(rawurlencode($msg['subject'])); ?>" class="btn btn-reply" title="Balas & Tandai Sudah Dibalas">
                      <i class="fas fa-reply"></i>
                    </a>
                    
                    <?php if ($msg['status'] == 'unread'): ?>
                      <a href="aksi_pesan.php?action=mark_read&id=<?php echo $msg['id_message']; ?>" class="btn btn-mark-read" title="Tandai Sudah Dibaca">
                        <i class="fas fa-check-circle"></i>
                      </a>
                    <?php else: // Berlaku untuk status 'read' dan 'replied' ?>
                      <a href="aksi_pesan.php?action=mark_unread&id=<?php echo $msg['id_message']; ?>" class="btn btn-mark-unread" title="Tandai Belum Dibaca">
                        <i class="fas fa-envelope"></i>
                      </a>
                    <?php endif; ?>
                    
                    <a href="aksi_pesan.php?action=delete&id=<?php echo $msg['id_message']; ?>" class="btn btn-delete" title="Hapus Pesan" onclick="return confirm('Anda yakin ingin menghapus pesan ini secara permanen?');">
                      <i class="fas fa-trash-alt"></i>
                    </a>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="5" style="text-align: center; padding: 40px;">
                <i class="fas fa-inbox" style="font-size: 32px; color: #ccc; margin-bottom: 16px;"></i><br>
                <?php echo (empty($filter_search) && empty($filter_status)) ? 'Tidak ada pesan masuk.' : 'Tidak ada pesan ditemukan sesuai filter/pencarian.'; ?>
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
    
    <?php if ($total_pages > 1): ?>
    <div class="pagination">
        <?php
            $query_params = "&search=" . urlencode($filter_search) . "&status_filter=" . $filter_status;
        ?>
        <a href="?page=<?php echo max(1, $current_page - 1); ?><?php echo $query_params; ?>" 
           class="pagination-btn <?php echo ($current_page <= 1) ? 'disabled' : ''; ?>">
            <i class="fas fa-chevron-left"></i>
        </a>

        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="?page=<?php echo $i; ?><?php echo $query_params; ?>" 
               class="pagination-btn <?php echo ($i == $current_page) ? 'active' : ''; ?>">
                <?php echo $i; ?>
            </a>
        <?php endfor; ?>
        
        <a href="?page=<?php echo min($total_pages, $current_page + 1); ?><?php echo $query_params; ?>" 
           class="pagination-btn <?php echo ($current_page >= $total_pages) ? 'disabled' : ''; ?>">
            <i class="fas fa-chevron-right"></i>
        </a>
    </div>
    <?php endif; ?>
  </div>
 </main>
</body>
</html>