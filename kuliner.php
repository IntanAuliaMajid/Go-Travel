<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuliner - Wisata indonesia(Jawa)</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background: linear-gradient(135deg, #3d5ff8 0%, #a3a9ff 100%);
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
            color: white;
            margin-top: 100px;
        }

        .header h1 {
            font-size: 3em;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .header p {
            font-size: 1.2em;
            opacity: 0.9;
        }

        .controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 20px;
        }

        .search-box {
            flex: 1;
            min-width: 300px;
        }

        .search-box input {
            width: 100%;
            padding: 15px 20px;
            border: none;
            border-radius: 50px;
            font-size: 16px;
            background: rgba(255,255,255,0.9);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .search-box input:focus {
            outline: none;
            background: white;
            box-shadow: 0 6px 20px rgba(0,0,0,0.15);
            transform: translateY(-2px);
        }

        .filter-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .filter-btn {
            padding: 12px 24px;
            border: none;
            border-radius: 25px;
            background: rgba(255,255,255,0.2);
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
            backdrop-filter: blur(10px);
        }

        .filter-btn:hover, .filter-btn.active {
            background: rgba(255,255,255,0.9);
            color: #333;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .kuliner-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }

        .kuliner-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.4s ease;
            cursor: pointer;
            opacity: 0;
            transform: translateY(50px);
            animation: fadeInUp 0.6s ease forwards;
        }

        .kuliner-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }

        .kuliner-card.hidden {
            display: none;
        }

        .card-image {
            height: 250px;
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .card-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: rgba(255,255,255,0.9);
            color: #333;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            backdrop-filter: blur(10px);
        }

        .card-content {
            padding: 25px;
        }

        .card-title {
            font-size: 1.5em;
            font-weight: bold;
            margin-bottom: 10px;
            color: #2c3e50;
        }

        .card-region {
            color: #e74c3c;
            font-weight: 500;
            margin-bottom: 15px;
            font-size: 0.9em;
        }

        .card-description {
            color: #666;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .card-features {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }

        .rating {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .stars {
            color: #f39c12;
        }

        .price {
            font-weight: bold;
            color: #27ae60;
            font-size: 1.1em;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.8);
            backdrop-filter: blur(5px);
        }

        .modal-content {
            background-color: white;
            margin: 5% auto;
            padding: 0;
            border-radius: 20px;
            width: 90%;
            max-width: 800px;
            max-height: 90vh;
            overflow-y: auto;
            animation: modalSlideIn 0.4s ease;
        }

        .modal-header {
            height: 400px;
            background-size: cover;
            background-position: center;
            position: relative;
            border-radius: 20px 20px 0 0;
        }

        .modal-close {
            position: absolute;
            right: 20px;
            top: 20px;
            background: rgba(255,255,255,0.9);
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            font-size: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .modal-close:hover {
            background: white;
            transform: scale(1.1);
        }

        .modal-body {
            padding: 30px;
        }

        .modal-title {
            font-size: 2.5em;
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .modal-region {
            color: #e74c3c;
            font-weight: 500;
            font-size: 1.2em;
            margin-bottom: 20px;
        }

        .modal-description {
            font-size: 1.1em;
            line-height: 1.8;
            color: #666;
            margin-bottom: 30px;
        }

        .modal-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }

        .info-item {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 15px;
            text-align: center;
        }

        .info-item h4 {
            color: #2c3e50;
            margin-bottom: 10px;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes modalSlideIn {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @media (max-width: 768px) {
            .header h1 {
                font-size: 2em;
            }
            
            .controls {
                flex-direction: column;
                align-items: stretch;
            }
            
            .search-box {
                min-width: auto;
            }
            
            .filter-buttons {
                justify-content: center;
            }
            
            .kuliner-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }
        }
    </style>
</head>
<body>
<?php include './Komponen/navbar.php'; ?>

    <div class="container">
        <div class="header">
            <h1>🍽 Kuliner indonesia</h1>
            <p>Jelajahi Cita Rasa Khas jawa</p>
        </div>

        <div class="controls">
            <div class="search-box">
                <input type="text" id="searchInput" placeholder="Cari kuliner favorit Anda...">
            </div>
            <div class="filter-buttons">
                <button class="filter-btn active" data-category="all">Semua</button>
                <button class="filter-btn" data-category="makanan">Makanan</button>
                <button class="filter-btn" data-category="minuman">Minuman</button>
                <button class="filter-btn" data-category="jajanan">Jajanan</button>
                <button class="filter-btn" data-category="dessert">Dessert</button>
            </div>
        </div>

        <div class="kuliner-grid" id="kulinerGrid">
            
        </div>
    </div>

    <!-- Modal -->
    <div id="kulinerModal" class="modal">
        <div class="modal-content">
            <div class="modal-header" id="modalHeader">
                <button class="modal-close" onclick="closeModal()">&times;</button>
            </div>
            <div class="modal-body">
                <h2 class="modal-title" id="modalTitle"></h2>
                <div class="modal-region" id="modalRegion"></div>
                <div class="modal-description" id="modalDescription"></div>
                <div class="modal-info" id="modalInfo"></div>
            </div>
        </div>
    </div>
<?php include './Komponen/footer.php'; ?>
    <script src="js/kuliner.js"></script>
</body>
</html>
