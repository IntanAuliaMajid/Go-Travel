<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Dashboard Admin</title>
  <style>
    body {
  margin: 0;
  font-family: 'Segoe UI', sans-serif;
  display: flex;
  background: linear-gradient(145deg, #7f5af0, #5d3fd3);
  color: #333;
}

/* .sidebar {
  width: 220px;
  background-color: #1e293b;
  color: white;
  height: 100vh;
  padding: 20px;
}

.sidebar h2 {
  font-size: 20px;
  margin-bottom: 30px;
}

.sidebar ul {
  list-style: none;
  padding: 0;
}

.sidebar ul li {
  margin: 15px 0;
}

.sidebar ul li a {
  color: white;
  text-decoration: none;
}

.sidebar ul li.active a {
  background: #22c55e;
  padding: 5px 10px;
  border-radius: 6px;
} */

.content {
  flex: 1;
  padding: 30px;
  margin-left: 250px;
  min-height: 100vh;
  transition: margin-left 0.3s ease;
}

.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  background: white;
  border-radius: 12px;
  padding: 20px;
  margin-bottom: 20px;
}

.header h1 {
  margin: 0;
}

.header button {
  background: linear-gradient(45deg, #7c3aed, #9333ea);
  color: white;
  border: none;
  padding: 10px 18px;
  border-radius: 10px;
  cursor: pointer;
}

.galeri-container {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
  gap: 20px;
}

.item-card {
  background: white;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
  position: relative;
}

.item-card img,
.item-card video {
  width: 100%;
  height: 160px;
  object-fit: cover;
}

.item-card .actions {
  display: flex;
  justify-content: space-around;
  padding: 10px;
  background: #f1f5f9;
}

.item-card button {
  border: none;
  padding: 6px 10px;
  border-radius: 6px;
  cursor: pointer;
}

.edit-btn {
  background-color: #38bdf8;
  color: white;
}

.delete-btn {
  background-color: #f87171;
  color: white;
}

  </style>
</head>
<body>
  <?php include '../komponen/sidebar_admin.php'; ?>

  <div class="content">
    <div class="header">
      <h1>📸 Kelola Galeri Wisata</h1>
      <button onclick="tambahItem()">+ Tambah Media</button>
    </div>

    <div class="galeri-container" id="galeriContainer">
    </div>
  </div>
  <script>
  const galeriData = [
    { type: 'image', src: 'https://www.nativeindonesia.com/foto/2024/07/sunset-di-pantai-lorena.jpg' },
    { type: 'image', src: 'https://www.nativeindonesia.com/foto/2024/07/pantai-tanjung-kodok-1.jpg' },
    { type: 'image', src: 'https://salsawisata.com/wp-content/uploads/2022/07/Indonesian-Islamic-Art-Museum.jpg' },
    { type: 'image', src: 'https://salsawisata.com/wp-content/uploads/2022/07/Wisata-Bahari-Lamongan.jpg' },
    { type: 'image', src: "https://tugujatim.id/wp-content/uploads/2023/10/WhatsApp-Image-2023-10-20-at-16.12.53.jpeg" },
    { type: 'image', src: "https://anekatempatwisata.com/wp-content/uploads/2018/04/Taman-Mini-Indonesia-Indah-610x407.jpg" },
    { type: 'image', src: "https://anekatempatwisata.com/wp-content/uploads/2018/04/Museum-Nasional-Indonesia-610x610.jpg" },
    { type: 'image', src: "https://anekatempatwisata.com/wp-content/uploads/2018/04/Jakarta-Aquarium-loop.jpg" },
    { type: 'image', src: "https://anekatempatwisata.com/wp-content/uploads/2018/04/Monumen-Nasional-610x406.jpg" },
    { type: 'image', src: "https://anekatempatwisata.com/wp-content/uploads/2018/04/Dunia-Fantasi-klook.png" },
    { type: 'image', src: "https://www.nativeindonesia.com/foto/2024/03/pantai-pasir-putih-tlongoh.jpg" },
    { type: 'image', src: 'https://dimadura.id/wp-content/uploads/2025/04/Mercusuar-Sembilangan_Wisata-Sejarah-di-Bangkalan_-1.jpg' },
    { type: 'image', src: "https://labuhanmangrove.files.wordpress.com/2019/09/whatsapp-image-2019-09-11-at-10.58.31-1.jpeg" },
    { type: 'video', src: 'video/promo-bromo.mp4' },
    { type: 'video', src: 'video/explore-jogja.mp4' }
  ];

  function renderGaleri() {
    const container = document.getElementById('galeriContainer');
    container.innerHTML = '';
    galeriData.forEach((item, index) => {
      const card = document.createElement('div');
      card.className = 'item-card';

      if (item.type === 'image') {
        card.innerHTML = `<img src="${item.src}" alt="Foto Wisata">`;
      } else {
        card.innerHTML = `<video src="${item.src}" controls></video>`;
      }

      const actions = document.createElement('div');
      actions.className = 'actions';
      actions.innerHTML = `
        <button class="edit-btn" onclick="editItem(${index})">Edit</button>
        <button class="delete-btn" onclick="hapusItem(${index})">Hapus</button>
      `;
      card.appendChild(actions);
      container.appendChild(card);
    });
  }

  function tambahItem() {
    const type = prompt('Tipe media (image/video):');
    const src = prompt('Masukkan URL atau path media:');
    if (type && src) {
      galeriData.push({ type, src });
      renderGaleri();
    }
  }

  function editItem(index) {
    const item = galeriData[index];
    const newSrc = prompt('Edit path:', item.src);
    if (newSrc) {
      galeriData[index].src = newSrc;
      renderGaleri();
    }
  }

  function hapusItem(index) {
    if (confirm('Yakin ingin menghapus media ini?')) {
      galeriData.splice(index, 1);
      renderGaleri();
    }
  }

  renderGaleri();

  </script>
</body>
</html>
