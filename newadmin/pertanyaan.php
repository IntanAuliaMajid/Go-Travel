<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin - Kelola Pesan Kontak | Go Travel Indonesia</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --primary: #3b82f6;
      --primary-dark: #2563eb;
      --danger: #ef4444;
      --danger-dark: #dc2626;
      --success: #10b981;
      --success-dark: #059669;
      --warning: #f59e0b;
      --warning-dark: #d97706;
      --unread-bg: #fef9c3;
      --unread-border: #fde047;
      --header-bg: #f9fafb;
      --border-color: #e5e7eb;
      --text-light: #6b7280;
      --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      background-color: #f3f4f6;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      padding: 0;
      min-height: 100vh;
      color: #1f2937;
    }

    main {
      margin-left: 250px;
      padding: 24px;
      transition: all 0.3s ease;
    }

    .container {
      background-color: white;
      padding: 24px;
      border-radius: 12px;
      box-shadow: var(--shadow);
    }

    .page-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 24px;
      flex-wrap: wrap;
      gap: 16px;
    }

    h2 {
      font-size: 24px;
      font-weight: 700;
      color: #111827;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    h2 i {
      color: var(--primary);
    }

    .header-actions {
      display: flex;
      gap: 12px;
      flex-wrap: wrap;
    }

    .search-container {
      position: relative;
      display: flex;
      align-items: center;
    }

    .search-container input {
      padding: 10px 16px 10px 40px;
      border: 1px solid var(--border-color);
      border-radius: 6px;
      width: 280px;
      font-size: 14px;
      transition: all 0.3s;
    }

    .search-container input:focus {
      outline: none;
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
    }

    .search-container i {
      position: absolute;
      left: 14px;
      color: var(--text-light);
    }

    .filter-btn {
      background: white;
      border: 1px solid var(--border-color);
      border-radius: 6px;
      padding: 10px 16px;
      display: flex;
      align-items: center;
      gap: 8px;
      cursor: pointer;
      font-size: 14px;
      transition: all 0.3s;
    }

    .filter-btn:hover {
      border-color: var(--primary);
    }

    .filter-btn i {
      color: var(--text-light);
    }

    table {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0;
      border: 1px solid var(--border-color);
      border-radius: 8px;
      overflow: hidden;
    }

    thead {
      background-color: var(--header-bg);
      text-align: left;
    }

    th, td {
      padding: 16px;
      font-size: 14px;
      vertical-align: top;
      border-bottom: 1px solid var(--border-color);
    }

    th {
      color: #374151;
      font-weight: 600;
      position: relative;
    }

    th:not(:last-child):after {
      content: '';
      position: absolute;
      top: 20%;
      right: 0;
      height: 60%;
      width: 1px;
      background-color: var(--border-color);
    }

    tbody tr {
      transition: background-color 0.2s;
    }

    tbody tr:hover {
      background-color: #f9fafb;
    }

    .unread {
      background-color: var(--unread-bg);
      border-left: 4px solid var(--warning);
      font-weight: 600;
    }

    .unread td:first-child {
      position: relative;
    }

    .unread td:first-child::before {
      content: '';
      position: absolute;
      left: 0;
      top: 50%;
      transform: translateY(-50%);
      width: 8px;
      height: 8px;
      background-color: var(--warning);
      border-radius: 50%;
    }

    .message-preview {
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
      text-overflow: ellipsis;
      max-width: 300px;
      line-height: 1.5;
    }

    .btn {
      padding: 8px 14px;
      border: none;
      border-radius: 6px;
      color: white;
      cursor: pointer;
      font-size: 14px;
      font-weight: 500;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      transition: all 0.2s;
    }

    .btn-reply {
      background-color: var(--primary);
    }

    .btn-reply:hover {
      background-color: var(--primary-dark);
      transform: translateY(-1px);
      box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.3), 0 2px 4px -1px rgba(59, 130, 246, 0.1);
    }

    .btn-delete {
      background-color: var(--danger);
    }

    .btn-delete:hover {
      background-color: var(--danger-dark);
      transform: translateY(-1px);
      box-shadow: 0 4px 6px -1px rgba(239, 68, 68, 0.3), 0 2px 4px -1px rgba(239, 68, 68, 0.1);
    }

    .btn-mark-read {
      background-color: var(--success);
    }

    .btn-mark-read:hover {
      background-color: var(--success-dark);
      transform: translateY(-1px);
      box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.3), 0 2px 4px -1px rgba(16, 185, 129, 0.1);
    }

    .action-buttons {
      display: flex;
      gap: 10px;
      flex-wrap: wrap;
    }

    .status-badge {
      display: inline-block;
      padding: 4px 10px;
      border-radius: 20px;
      font-size: 12px;
      font-weight: 500;
    }

    .status-unread {
      background-color: #fef3c7;
      color: #92400e;
    }

    .status-read {
      background-color: #d1fae5;
      color: #065f46;
    }

    .pagination {
      display: flex;
      justify-content: flex-end;
      margin-top: 24px;
      gap: 8px;
    }

    .pagination-btn {
      width: 36px;
      height: 36px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 6px;
      border: 1px solid var(--border-color);
      background: white;
      cursor: pointer;
      transition: all 0.2s;
    }

    .pagination-btn:hover {
      background-color: #f3f4f6;
      border-color: var(--primary);
      color: var(--primary);
    }

    .pagination-btn.active {
      background-color: var(--primary);
      border-color: var(--primary);
      color: white;
    }

    .timestamp {
      color: var(--text-light);
      font-size: 13px;
      margin-top: 4px;
      display: block;
    }

    /* Responsiveness */
    @media (max-width: 1024px) {
      main {
        margin-left: 80px;
        padding: 16px;
      }
      
      .search-container input {
        width: 200px;
      }
    }

    @media (max-width: 768px) {
      .container {
        padding: 16px;
      }
      
      .page-header {
        flex-direction: column;
        align-items: flex-start;
      }
      
      .header-actions {
        width: 100%;
        justify-content: space-between;
      }
      
      .search-container {
        flex-grow: 1;
      }
      
      .search-container input {
        width: 100%;
      }
      
      table {
        display: block;
        overflow-x: auto;
      }
      
      .action-buttons {
        flex-direction: column;
      }
      
      .message-preview {
        max-width: 200px;
      }
    }

    @media (max-width: 480px) {
      main {
        margin-left: 0;
        padding: 12px;
      }
      
      .container {
        border-radius: 0;
      }
      
      .filter-btn span {
        display: none;
      }
      
      .btn {
        padding: 8px 12px;
        font-size: 13px;
      }
      
      .btn span {
        display: none;
      }
      
      .btn i {
        margin-right: 0;
      }
    }
  </style>
</head>
<body>
  <?php include '../Komponen/sidebar_admin.php'; ?>

  <main>
    <div class="container">
      <div class="page-header">
        <h2>
          <i class="fas fa-envelope"></i>
          Pesan Masuk
        </h2>
        <div class="header-actions">
          <div class="search-container">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" placeholder="Cari pesan...">
          </div>
          <button class="filter-btn">
            <i class="fas fa-filter"></i>
            <span>Filter</span>
          </button>
        </div>
      </div>
      
      <div style="overflow-x:auto;">
        <table>
          <thead>
            <tr>
              <th style="width: 15%;">Nama</th>
              <th style="width: 20%;">Email</th>
              <th style="width: 15%;">Subjek</th>
              <th style="width: 30%;">Pesan</th>
              <th style="width: 20%;">Tindakan</th>
            </tr>
          </thead>
          <tbody>
            <!-- Contoh pesan BELUM DIBACA -->
            <tr class="unread">
              <td>
                Budi Santoso
                <span class="status-badge status-unread">Belum Dibaca</span>
                <span class="timestamp">2 jam yang lalu</span>
              </td>
              <td>budi@example.com</td>
              <td>Pertanyaan Paket Wisata</td>
              <td class="message-preview">Halo, saya ingin tahu lebih lanjut tentang paket ke Labuan Bajo. Apakah ada paket untuk 4 hari 3 malam dengan harga sekitar 5 juta per orang? Terima kasih.</td>
              <td>
                <div class="action-buttons">
                  <button class="btn btn-reply">
                    <i class="fas fa-reply"></i>
                    <span>Balas</span>
                  </button>
                  <button class="btn btn-mark-read" onclick="markAsRead(this)">
                    <i class="fas fa-check-circle"></i>
                    <span>Tandai Dibaca</span>
                  </button>
                  <button class="btn btn-delete">
                    <i class="fas fa-trash-alt"></i>
                    <span>Hapus</span>
                  </button>
                </div>
              </td>
            </tr>

            <!-- Contoh pesan SUDAH DIBACA -->
            <tr class="read">
              <td>
                Rina Aulia
                <span class="status-badge status-read">Sudah Dibaca</span>
                <span class="timestamp">1 hari yang lalu</span>
              </td>
              <td>rina@example.com</td>
              <td>Booking Tour</td>
              <td class="message-preview">Saya sudah transfer untuk trip ke Bali. Mohon konfirmasi penerimaan pembayaran dan kirim detail itinerary ke email saya. Terima kasih.</td>
              <td>
                <div class="action-buttons">
                  <button class="btn btn-reply">
                    <i class="fas fa-reply"></i>
                    <span>Balas</span>
                  </button>
                  <button class="btn btn-delete">
                    <i class="fas fa-trash-alt"></i>
                    <span>Hapus</span>
                  </button>
                </div>
              </td>
            </tr>
            
            <!-- Pesan lainnya -->
            <tr class="unread">
              <td>
                Ahmad Fauzi
                <span class="status-badge status-unread">Belum Dibaca</span>
                <span class="timestamp">5 jam yang lalu</span>
              </td>
              <td>ahmad@travelagency.id</td>
              <td>Kerjasama Travel</td>
              <td class="message-preview">Saya mewakili agen travel dari Bandung ingin menawarkan kerjasama untuk paket wisata ke Raja Ampat. Bisa kita diskusikan lebih lanjut?</td>
              <td>
                <div class="action-buttons">
                  <button class="btn btn-reply">
                    <i class="fas fa-reply"></i>
                    <span>Balas</span>
                  </button>
                  <button class="btn btn-mark-read" onclick="markAsRead(this)">
                    <i class="fas fa-check-circle"></i>
                    <span>Tandai Dibaca</span>
                  </button>
                  <button class="btn btn-delete">
                    <i class="fas fa-trash-alt"></i>
                    <span>Hapus</span>
                  </button>
                </div>
              </td>
            </tr>
            
            <tr class="read">
              <td>
                Siti Rahayu
                <span class="status-badge status-read">Sudah Dibaca</span>
                <span class="timestamp">3 hari yang lalu</span>
              </td>
              <td>siti.rahayu@gmail.com</td>
              <td>Ulasan Perjalanan</td>
              <td class="message-preview">Saya baru saja kembali dari trip Lombok bersama Go Travel Indonesia. Pengalaman yang sangat menyenangkan! Pemandu wisatanya sangat ramah dan informatif. Terima kasih!</td>
              <td>
                <div class="action-buttons">
                  <button class="btn btn-reply">
                    <i class="fas fa-reply"></i>
                    <span>Balas</span>
                  </button>
                  <button class="btn btn-delete">
                    <i class="fas fa-trash-alt"></i>
                    <span>Hapus</span>
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      
      <div class="pagination">
        <button class="pagination-btn">
          <i class="fas fa-chevron-left"></i>
        </button>
        <button class="pagination-btn active">1</button>
        <button class="pagination-btn">2</button>
        <button class="pagination-btn">3</button>
        <button class="pagination-btn">
          <i class="fas fa-chevron-right"></i>
        </button>
      </div>
    </div>
  </main>

  <script>
    function markAsRead(button) {
      const row = button.closest('tr');
      row.classList.remove('unread');
      row.classList.add('read');
      
      // Update status badge
      const statusBadge = row.querySelector('.status-badge');
      statusBadge.classList.remove('status-unread');
      statusBadge.classList.add('status-read');
      statusBadge.textContent = 'Sudah Dibaca';
      
      // Remove mark as read button
      button.remove();
    }
    
    // Search functionality
    const searchInput = document.getElementById('searchInput');
    searchInput.addEventListener('input', function() {
      const searchTerm = this.value.toLowerCase();
      const rows = document.querySelectorAll('tbody tr');
      
      rows.forEach(row => {
        const textContent = row.textContent.toLowerCase();
        if (textContent.includes(searchTerm)) {
          row.style.display = '';
        } else {
          row.style.display = 'none';
        }
      });
    });
  </script>
</body>
</html>