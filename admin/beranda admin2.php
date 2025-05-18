<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Panel - Travel Package</title>
  <link rel="stylesheet" href="beranda admin2.css" />
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>
  <div class="container">
    <!-- Sidebar -->
    <div class="sidebar">
      <h2 class="logo">ADMIN PANEL</h2>
      <ul class="nav">
        <li class="active">Dashboard</li>
        <li>Users</li>
        <li>Booking</li>
        <li>Travel package</li>
        <li>Blog</li>
      </ul>
    </div>

    <!-- Main content -->
    <div class="main">
      <div class="topbar">
        <span class="toggle-menu">&#9776;</span>
        <span class="user">admin</span>
      </div>

      <div class="content">
        <h1>Travel Package</h1>
        <button class="add-btn">+</button>
        <table>
          <thead>
            <tr>
              <th>No</th>
              <th>Type</th>
              <th>Location</th>
              <th>Price</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td>Test</td>
              <td>malang indonesia</td>
              <td>300000</td>
              <td>
                <button class="action edit"><i class="fas fa-edit"></i></button>
                <button class="action delete"><i class="fas fa-trash-alt"></i></button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>
</html>
