<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Edit Kendaraan - Dashboard Admin</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #f4f6f8;
      padding: 40px;
      color: #333;
    }
    .edit-container {
      max-width: 700px; /* batasi lebar maksimal container */
      margin-left: 220px;
      background: white;
      border-radius: 12px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
      padding: 30px;
    }
    h2 {
      margin-bottom: 25px;
      color: #2c3e50;
    }
    .form-group {
      margin-bottom: 18px;
    }
    label {
      display: block;
      margin-bottom: 6px;
      font-weight: 600;
      color: #34495e;
    }
    input[type="text"],
    input[type="number"],
    select,
    textarea {
      width: 100%;
      max-width: 700px;  /* batas maksimal lebar input */
      min-width: 280px;  /* batas minimal lebar input */
      padding: 10px 15px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 1rem;
      font-family: inherit;
      resize: vertical;
      box-sizing: border-box; /* supaya padding dan border masuk hitungan width */
    }
    textarea {
      min-height: 100px;
    }
    .btn-group {
      display: flex;
      justify-content: flex-end;
      gap: 15px;
      margin-top: 30px;
    }
    button {
      padding: 12px 25px;
      border-radius: 8px;
      border: none;
      font-weight: 600;
      cursor: pointer;
      transition: background-color 0.3s ease;
      font-size: 1rem;
    }
    .btn-cancel {
      background: #ecf0f1;
      color: #7f8c8d;
    }
    .btn-cancel:hover {
      background: #d5dbdb;
    }
    .btn-save {
      background: #3498db;
      color: white;
    }
    .btn-save:hover {
      background: #2980b9;
    }
  </style>
</head>
<body>
    <?php include "../Komponen/sidebar_admin.php" ?>
  <div class="edit-container">
    <h2><i class="fas fa-edit" style="color:#3498db; margin-right:10px;"></i>Edit Kendaraan</h2>
    <form id="editVehicleForm">
      <div class="form-group">
        <label for="vehicleName">Nama Kendaraan</label>
        <input type="text" id="vehicleName" name="vehicleName" required />
      </div>
      <div class="form-group">
        <label for="vehicleType">Jenis Kendaraan</label>
        <select id="vehicleType" name="vehicleType" required>
          <option value="">Pilih Jenis</option>
          <option value="sedan">Sedan</option>
          <option value="suv">SUV</option>
          <option value="mpv">MPV</option>
          <option value="minibus">Minibus</option>
          <option value="bus">Bus</option>
          <option value="motor">Motor</option>
        </select>
      </div>
      <div class="form-group">
        <label for="vehicleCapacity">Kapasitas (Orang)</label>
        <input type="number" id="vehicleCapacity" name="vehicleCapacity" min="1" max="50" required />
      </div>
      <div class="form-group">
        <label for="vehiclePrice">Harga Sewa per Hari (Rp)</label>
        <input type="number" id="vehiclePrice" name="vehiclePrice" min="100000" required />
      </div>
      <div class="form-group">
        <label for="vehicleStatus">Status</label>
        <select id="vehicleStatus" name="vehicleStatus" required>
          <option value="available">Tersedia</option>
          <option value="booked">Dipesan</option>
          <option value="maintenance">Perbaikan</option>
        </select>
      </div>
      <div class="form-group">
        <label for="vehicleNotes">Catatan</label>
        <textarea id="vehicleNotes" name="vehicleNotes" placeholder="Tambahkan catatan tentang kendaraan..."></textarea>
      </div>
      <div class="btn-group">
        <button type="button" class="btn-cancel" onclick="window.history.back()">Batal</button>
        <button type="submit" class="btn-save">Simpan Perubahan</button>
      </div>
    </form>
  </div>

  <script>
    const vehicleData = {
      id: 3,
      vehicleName: "Isuzu Elf Long",
      vehicleType: "bus",
      vehicleCapacity: 24,
      vehiclePrice: 2000000,
      vehicleStatus: "available",
      vehicleNotes: "Bus mini yang nyaman untuk rombongan besar."
    };

    window.onload = () => {
      document.getElementById('vehicleName').value = vehicleData.vehicleName;
      document.getElementById('vehicleType').value = vehicleData.vehicleType;
      document.getElementById('vehicleCapacity').value = vehicleData.vehicleCapacity;
      document.getElementById('vehiclePrice').value = vehicleData.vehiclePrice;
      document.getElementById('vehicleStatus').value = vehicleData.vehicleStatus;
      document.getElementById('vehicleNotes').value = vehicleData.vehicleNotes;
    };

    document.getElementById('editVehicleForm').addEventListener('submit', function(event) {
      event.preventDefault();

      const updatedVehicle = {
        id: vehicleData.id,
        vehicleName: this.vehicleName.value.trim(),
        vehicleType: this.vehicleType.value,
        vehicleCapacity: parseInt(this.vehicleCapacity.value),
        vehiclePrice: parseInt(this.vehiclePrice.value),
        vehicleStatus: this.vehicleStatus.value,
        vehicleNotes: this.vehicleNotes.value.trim(),
      };

      alert('Data kendaraan berhasil disimpan:\n' + JSON.stringify(updatedVehicle, null, 2));
      // window.location.href = 'daftar_kendaraan.php';
    });
  </script>
</body>
</html>
