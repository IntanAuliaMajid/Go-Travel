<?php
    $current_page = basename($_SERVER['PHP_SELF']);
    ?>
    <div id="admin-sidebar" class="admin-sidebar">
        <div class="sidebar-header">
            <h2>ADMIN PANEL</h2>
        </div>
        
        <nav class="sidebar-nav">
            <ul class="nav-items">
                <li>
                    <a href="dashboardadmin.php" class="nav-item <?php echo ($current_page == 'dashboardadmin.php') ? 'active' : ''; ?>">
                        <i class="fas fa-tachometer-alt"></i>
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="usermanajemen.php" class="nav-item <?php echo ($current_page == 'usermanajemen.php') ? 'active' : ''; ?>">
                        <i class="fas fa-users"></i>
                        <span class="nav-text">Users</span>
                    </a>
                </li>
                <li>
                    <a href="bookingadmin.php" class="nav-item dark-item <?php echo ($current_page == 'bookingadmin.php') ? 'active' : ''; ?>">
                        <i class="fas fa-calendar-check"></i>
                        <span class="nav-text">Booking</span>
                    </a>
                </li>
                <li>
                    <a href="travel_package.php" class="nav-item dark-item <?php echo ($current_page == 'travel_package.php') ? 'active' : ''; ?>">
                        <i class="fas fa-suitcase-rolling"></i>
                        <span class="nav-text">Travel Package</span>
                    </a>
                </li>
                <li>
                    <a href="blog.php" class="nav-item dark-item <?php echo ($current_page == 'blog.php') ? 'active' : ''; ?>">
                        <i class="fas fa-blog"></i>
                        <span class="nav-text">Blog</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: #f8fafc;
            color: #333;
            /* Mencegah scroll horizontal */
            overflow-x: hidden;
            width: 100%;
            min-height: 100vh;
            position: relative;
        }

        /* Sidebar Styles */
        .admin-sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 280px;
            height: 100vh;
            background: linear-gradient(180deg, #4A90E2 0%, #357ABD 100%);
            padding: 0;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .sidebar-header {
            padding: 30px 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-header h2 {
            color: white;
            font-size: 18px;
            font-weight: 700;
            letter-spacing: 1.5px;
            margin: 0;
        }

        .sidebar-nav {
            padding: 25px 0;
        }

        .nav-items {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .nav-items li {
            margin: 8px 15px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            padding: 16px 25px;
            color: white;
            text-decoration: none;
            font-weight: 500;
            font-size: 16px;
            border-radius: 10px;
            transition: all 0.3s ease;
            background-color: rgba(255, 255, 255, 0.1);
        }

        .nav-item i {
            margin-right: 12px;
            width: 20px;
            text-align: center;
        }

        .nav-item:hover {
            background-color: rgba(255, 255, 255, 0.2);
            transform: translateX(8px);
        }

        .nav-item.active {
            background-color: rgba(255, 255, 255, 0.25);
            border-left: 4px solid white;
        }

        .nav-item.dark-item {
            background-color: rgba(0, 0, 0, 0.2);
        }

        .nav-item.dark-item:hover {
            background-color: rgba(0, 0, 0, 0.35);
        }

        .nav-item.dark-item.active {
            background-color: rgba(0, 0, 0, 0.4);
            border-left: 4px solid #FFD700;
        }
    </style>

   