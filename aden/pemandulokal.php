<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemandu Wisata Lokal</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }

        .header {
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
            padding: 30px;
            text-align: left;
        }

        .header h1 {
            color: #1565c0;
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .header p {
            color: #666;
            font-size: 14px;
            line-height: 1.4;
        }

        .search-section {
            padding: 20px 30px;
            background: #fafafa;
            border-bottom: 1px solid #e0e0e0;
        }

        .search-container {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .search-input {
            flex: 1;
            padding: 12px 16px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            background: white;
        }

        .search-input:focus {
            outline: none;
            border-color: #2196f3;
        }

        .filter-buttons {
            display: flex;
            gap: 8px;
        }

        .filter-btn {
            padding: 8px 16px;
            border: 1px solid #ddd;
            background: white;
            border-radius: 20px;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.2s;
            color: #666;
        }

        .filter-btn:hover {
            border-color: #2196f3;
            color: #2196f3;
        }

        .filter-btn.active {
            background: #2196f3;
            color: white;
            border-color: #2196f3;
        }

        .content {
            padding: 0 30px 30px 30px;
        }

        .guide-card {
            display: flex;
            gap: 20px;
            padding: 25px 0;
            border-bottom: 1px solid #f0f0f0;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .guide-card:hover {
            background: #fafafa;
            margin: 0 -30px;
            padding: 25px 30px;
            border-radius: 12px;
        }

        .guide-card:last-child {
            border-bottom: none;
        }

        .guide-avatar {
            width: 80px;
            height: 80px;
            border-radius: 12px;
            background: #e0e0e0;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .guide-avatar-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #bdbdbd;
        }

        .guide-info {
            flex: 1;
        }

        .guide-name {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            margin-bottom: 6px;
        }

        .guide-rating {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 8px;
        }

        .stars {
            color: #ffc107;
            font-size: 14px;
            letter-spacing: 1px;
        }

        .rating-text {
            color: #666;
            font-size: 13px;
        }

        .guide-location {
            color: #666;
            font-size: 13px;
            margin-bottom: 12px;
        }

        .guide-details {
            margin-bottom: 15px;
        }

        .detail-row {
            display: flex;
            margin-bottom: 6px;
            font-size: 13px;
        }

        .detail-label {
            color: #666;
            width: 70px;
            flex-shrink: 0;
        }

        .detail-value {
            color: #333;
        }

        .tags {
            display: flex;
            gap: 6px;
            margin-bottom: 15px;
            flex-wrap: wrap;
        }

        .tag {
            padding: 4px 10px;
            background: #e3f2fd;
            color: #1565c0;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 500;
        }

        .guide-actions {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 8px 20px;
            border: none;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-pesan {
            background: #ff5722;
            color: white;
        }

        .btn-pesan:hover {
            background: #e64a19;
            transform: translateY(-1px);
        }

        .btn-hubungi {
            background: white;
            color: #2196f3;
            border: 1px solid #2196f3;
        }

        .btn-hubungi:hover {
            background: #2196f3;
            color: white;
        }

        .testimonials-section {
            background: #fafafa;
            padding: 30px;
            border-top: 1px solid #e0e0e0;
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
        }

        .testimonials-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .testimonial-card {
            background: white;
            padding: 15px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .testimonial-header {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
        }

        .testimonial-avatar {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: #e0e0e0;
            flex-shrink: 0;
        }

        .testimonial-name {
            font-size: 12px;
            font-weight: 600;
            color: #333;
        }

        .testimonial-rating {
            color: #ffc107;
            font-size: 12px;
            margin-bottom: 8px;
        }

        .testimonial-text {
            font-size: 11px;
            color: #666;
            line-height: 1.4;
        }

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
            padding-top: 10px;
        }

        .pagination-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #ddd;
            cursor: pointer;
            transition: all 0.2s;
        }

        .pagination-dot.active {
            background: #2196f3;
            width: 20px;
            border-radius: 10px;
        }

        .pagination-link {
            color: #2196f3;
            text-decoration: none;
            font-size: 12px;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
            padding: 20px;
        }

        .modal-content {
            background: white;
            border-radius: 16px;
            max-width: 400px;
            margin: 50px auto;
            padding: 30px;
            position: relative;
        }

        .modal-close {
            position: absolute;
            top: 15px;
            right: 20px;
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #999;
        }

        .modal h3 {
            color: #333;
            margin-bottom: 15px;
            font-size: 18px;
        }

        .modal p {
            color: #666;
            line-height: 1.5;
            margin-bottom: 10px;
        }

        @media (max-width: 768px) {
            body {
                padding: 10px;
            }
            
            .container {
                border-radius: 12px;
            }
            
            .header, .content, .testimonials-section {
                padding: 20px;
            }
            
            .search-container {
                flex-direction: column;
                gap: 15px;
            }
            
            .search-input {
                width: 100%;
            }
            
            .guide-card {
                flex-direction: column;
                text-align: center;
            }
            
            .guide-avatar {
                align-self: center;
            }
            
            .testimonials-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
     <?php include '../Komponen/navbar.php'; ?>
    <div class="container">
        <div class="header">
            <h1>Pemandu Wisata Lokal</h1>
            <p>Temukan pemandu lokal berpengalaman untuk pengalaman wisata terbaik di Indonesia</p>
        </div>

        <div class="search-section">
            <div class="search-container">
                <input type="text" class="search-input" placeholder="Cari pemandu berdasarkan nama, lokasi, atau keahlian..." id="searchInput">
                <div class="filter-buttons">
                    <button class="filter-btn" data-filter="lokal">Lokal</button>
                    <button class="filter-btn" data-filter="bahasa">Bahasa</button>
                    <button class="filter-btn active" data-filter="cari">Cari</button>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="guide-card" data-category="gunung">
                <div class="guide-avatar">
                    <div class="guide-avatar-icon"></div>
                </div>
                <div class="guide-info">
                    <div class="guide-name">Putu Wirdana</div>
                    <div class="guide-rating">
                        <span class="stars">★★★★☆</span>
                        <span class="rating-text">4.8 (124 reviews)</span>
                    </div>
                    <div class="guide-location">Gunung Bromo, Indonesia</div>
                    <div class="guide-details">
                        <div class="detail-row">
                            <span class="detail-label">Bahasa:</span>
                            <span class="detail-value">Indonesia, Inggris, Jepang</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Keahlian:</span>
                            <span class="detail-value">Gunung Bromo, Fotografi, Hiking</span>
                        </div>
                    </div>
                    <div class="tags">
                        <span class="tag">Sunrise</span>
                    </div>
                    <div class="guide-actions">
                        <button class="btn btn-pesan" onclick="openModal('Putu Wirdana')">Pesan</button>
                        <button class="btn btn-hubungi" onclick="openModal('hubungi-putu')">Hubungi</button>
                    </div>
                </div>
            </div>

            <div class="guide-card" data-category="pantai">
                <div class="guide-avatar">
                    <div class="guide-avatar-icon"></div>
                </div>
                <div class="guide-info">
                    <div class="guide-name">Siti Rahma</div>
                    <div class="guide-rating">
                        <span class="stars">★★★★★</span>
                        <span class="rating-text">5.0 (87 reviews)</span>
                    </div>
                    <div class="guide-location">Lombok, Indonesia</div>
                    <div class="guide-details">
                        <div class="detail-row">
                            <span class="detail-label">Bahasa:</span>
                            <span class="detail-value">Indonesia, Inggris, Arab</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Keahlian:</span>
                            <span class="detail-value">Pantai, Snorkeling, Selam</span>
                        </div>
                    </div>
                    <div class="guide-actions">
                        <button class="btn btn-pesan" onclick="openModal('Siti Rahma')">Pesan</button>
                        <button class="btn btn-hubungi" onclick="openModal('hubungi-siti')">Hubungi</button>
                    </div>
                </div>
            </div>

            <div class="guide-card" data-category="budaya">
                <div class="guide-avatar">
                    <div class="guide-avatar-icon"></div>
                </div>
                <div class="guide-info">
                    <div class="guide-name">Rizky Pratama</div>
                    <div class="guide-rating">
                        <span class="stars">★★★★☆</span>
                        <span class="rating-text">4.7 (96 reviews)</span>
                    </div>
                    <div class="guide-location">Pantai Parangtritis, Indonesia</div>
                    <div class="guide-details">
                        <div class="detail-row">
                            <span class="detail-label">Bahasa:</span>
                            <span class="detail-value">Indonesia, Inggris</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Keahlian:</span>
                            <span class="detail-value">Diving, Snorkeling, Island Tour</span>
                        </div>
                    </div>
                    <div class="guide-actions">
                        <button class="btn btn-pesan" onclick="openModal('Rizky Pratama')">Pesan</button>
                        <button class="btn btn-hubungi" onclick="openModal('hubungi-rizky')">Hubungi</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="testimonials-section">
            <div class="section-title">Ulasan Terbaru</div>
            <div class="testimonials-grid">
                <div class="testimonial-card">
                    <div class="testimonial-header">
                        <div class="testimonial-avatar"></div>
                        <div class="testimonial-name">Anita Wijaya</div>
                    </div>
                    <div class="testimonial-rating">★★★★★</div>
                    <div class="testimonial-text">Pengalaman yang luar biasa dengan Putu! Perjalanan sunrise di Bromo benar-benar tak terlupakan. Guide yang sangat berpengetahuan luas.</div>
                </div>

                <div class="testimonial-card">
                    <div class="testimonial-header">
                        <div class="testimonial-avatar"></div>
                        <div class="testimonial-name">Budi Santoso</div>
                    </div>
                    <div class="testimonial-rating">★★★★★</div>
                    <div class="testimonial-text">Siti sangat profesional dan ramah. Trip diving di Lombok sangat aman dan menyenangkan. Pasti akan booking lagi!</div>
                </div>

                <div class="testimonial-card">
                    <div class="testimonial-header">
                        <div class="testimonial-avatar"></div>
                        <div class="testimonial-name">Maya Sari</div>
                    </div>
                    <div class="testimonial-rating">★★★★★</div>
                    <div class="testimonial-text">Rizky sangat profesional dan menjelaskan sejarah dengan baik. Pengalaman budaya yang sangat berkesan di Yogyakarta!</div>
                </div>
            </div>

            <div class="pagination">
                <div class="pagination-dot active"></div>
                <div class="pagination-dot"></div>
                <div class="pagination-dot"></div>
                <div class="pagination-dot"></div>
                <div class="pagination-dot"></div>
                <a href="#" class="pagination-link">Semua ulasan →</a>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal" id="modal">
        <div class="modal-content">
            <button class="modal-close" onclick="closeModal()">&times;</button>
            <div id="modalBody">
                <h3>Konten Modal</h3>
                <p>Ini adalah contoh modal yang dapat dikustomisasi.</p>
            </div>
        </div>
    </div>

    <script>
        // Search functionality
        const searchInput = document.getElementById('searchInput');
        const filterBtns = document.querySelectorAll('.filter-btn');
        const guideCards = document.querySelectorAll('.guide-card');

        searchInput.addEventListener('input', filterGuides);

        filterBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                filterBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                filterGuides();
            });
        });

        function filterGuides() {
            const searchTerm = searchInput.value.toLowerCase();
            
            guideCards.forEach(card => {
                const text = card.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // Pagination dots
        const paginationDots = document.querySelectorAll('.pagination-dot');
        
        paginationDots.forEach((dot, index) => {
            dot.addEventListener('click', function() {
                paginationDots.forEach(d => d.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Modal functionality
        function openModal(type) {
            const modal = document.getElementById('modal');
            const modalBody = document.getElementById('modalBody');
            
            let content = '';
            
            switch(type) {
                case 'Putu Wirdana':
                    content = `
                        <h3>Pemesanan Guide - Putu Wirdana</h3>
                        <p><strong>Lokasi:</strong> Gunung Bromo, Indonesia</p>
                        <p><strong>Spesialisasi:</strong> Sunrise, Fotografi, Hiking</p>
                        <p><strong>Rating:</strong> 4.8/5 (124 reviews)</p>
                        <p><strong>Bahasa:</strong> Indonesia, Inggris, Jepang</p>
                        <br>
                        <p>Untuk melakukan pemesanan, silakan hubungi:</p>
                        <p><strong>WhatsApp:</strong> +62 812-3456-7890</p>
                        <p><strong>Email:</strong> putu.wirdana@email.com</p>
                        <br>
                        <button class="btn btn-pesan" onclick="alert('Mengarahkan ke WhatsApp...')">Hubungi via WhatsApp</button>
                    `;
                    break;
                case 'Siti Rahma':
                    content = `
                        <h3>Pemesanan Guide - Siti Rahma</h3>
                        <p><strong>Lokasi:</strong> Lombok, Indonesia</p>
                        <p><strong>Spesialisasi:</strong> Pantai, Snorkeling, Diving</p>
                        <p><strong>Rating:</strong> 5.0/5 (87 reviews)</p>
                        <p><strong>Bahasa:</strong> Indonesia, Inggris, Arab</p>
                        <br>
                        <p>Untuk melakukan pemesanan, silakan hubungi:</p>
                        <p><strong>WhatsApp:</strong> +62 813-4567-8901</p>
                        <p><strong>Email:</strong> siti.rahma@email.com</p>
                        <br>
                        <button class="btn btn-pesan" onclick="alert('Mengarahkan ke WhatsApp...')">Hubungi via WhatsApp</button>
                    `;
                    break;
                case 'Rizky Pratama':
                    content = `
                        <h3>Pemesanan Guide - Rizky Pratama</h3>
                        <p><strong>Lokasi:</strong> Pantai Parangtritis, Indonesia</p>
                        <p><strong>Spesialisasi:</strong> Diving, Snorkeling, Island Tour</p>
                        <p><strong>Rating:</strong> 4.7/5 (96 reviews)</p>
                        <p><strong>Bahasa:</strong> Indonesia, Inggris</p>
                        <br>
                        <p>Untuk melakukan pemesanan, silakan hubungi:</p>
                        <p><strong>WhatsApp:</strong> +62 814-5678-9012</p>
                        <p><strong>Email:</strong> rizky.pratama@email.com</p>
                        <br>
                        <button class="btn btn-pesan" onclick="alert('Mengarahkan ke WhatsApp...')">Hubungi via WhatsApp</button>
                    `;
                    break;
                default:
                    content = `
                        <h3>Hubungi Guide</h3>
                        <p>Anda dapat menghubungi guide untuk konsultasi lebih lanjut tentang paket wisata yang tersedia.</p>
                        <br>
                        <p>Silakan klik tombol WhatsApp untuk chat langsung atau kirim email untuk pertanyaan detail.</p>
                    `;
            }
            
            modalBody.innerHTML = content;
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            const modal = document.getElementById('modal');
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        // Close modal when clicking outside
        window.addEventListener('click', function(e) {
            const modal = document.getElementById('modal');
            if (e.target === modal) {
                closeModal();
            }
        });

        // Add hover effects
        guideCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateX(5px)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateX(0)';
            });
        });
    </script>
    
  <?php include '../Komponen/footer.php'; ?>
</body>
</html>