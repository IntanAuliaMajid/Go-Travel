-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 19, 2025 at 03:28 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `go_travel`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `nama_lengkap`, `username`, `email`, `password`, `last_login`, `created_at`) VALUES
(1, 'Admin Utama', 'admin', 'admin@example.com', '$2y$10$hashed_password_here', '2025-06-07 00:06:29', '2025-06-06 17:06:29'),
(2, 'Admin2', 'admin2', 'tuhuwkwk@gmail.com', '$2y$10$j0S97jYru8fdvvxuVzErk.vlOSv9jBpWeWP6xPyg3jNQwqZ6cbo2K', '2025-06-15 22:17:49', '2025-06-07 13:14:06');

-- --------------------------------------------------------

--
-- Table structure for table `akomodasi_kuliner`
--

CREATE TABLE `akomodasi_kuliner` (
  `id_akomodasi_kuliner` int NOT NULL,
  `nama_restaurant` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `gambar_url` varchar(255) DEFAULT NULL,
  `harga` decimal(12,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `akomodasi_kuliner`
--

INSERT INTO `akomodasi_kuliner` (`id_akomodasi_kuliner`, `nama_restaurant`, `gambar_url`, `harga`) VALUES
(1, 'Bandar Djakarta Restaurant', 'uploads/kuliner/kuliner_684e8a6c071550.24039910.jpg', '75000.00'),
(2, 'Restoran Sunan Drajat Lamongan', 'uploads/kuliner/kuliner_684e8c159da455.96456541.jpg', '40000.00'),
(3, 'Warung Bebek Sinjay Bangkalan', 'uploads/kuliner/kuliner_684e8ee32f2913.43289435.jpg', '40000.00'),
(4, 'Rumah Makan Lesehan Seafood Madurasa Bangkalan', 'uploads/kuliner/kuliner_684e8caac36661.55557819.webp', '60000.00'),
(5, 'Suramadu Resto & Cafe Bangkalan', 'uploads/kuliner/kuliner_684e8dd1e7c206.52904379.jpg', '50000.00'),
(6, 'Depot Asih Jaya Lamongan', 'uploads/kuliner/kuliner_684e8b067e63f8.18982053.jpg', '70000.00'),
(7, 'Taman Kuliner Paciran (TKP) Lamongan', 'uploads/kuliner/kuliner_684e8eba3f1006.10475484.webp', '60000.00'),
(8, 'Soto Betawi H. Ma’ruf Jakarta', 'uploads/kuliner/kuliner_684e8da5831ef7.60007929.webp', '65000.00'),
(9, 'Gado-Gado Bonbin Cikini Jakarta', 'uploads/kuliner/kuliner_684e8b9a7a3554.98357025.webp', '30000.00'),
(10, 'De Soematra 1910 Surabaya', 'uploads/kuliner/kuliner_684e8ac48ed6b0.32491574.jpg', '70000.00'),
(11, 'Ayam Bakar Primarasa Surabaya', 'uploads/kuliner/kuliner_68515f2d90784.png', '70000.00'),
(12, 'Sky 36 Restaurant Surabaya', 'uploads/kuliner/kuliner_684e8d6a9cb056.21050222.jpg', '75000.00'),
(13, 'Sewindu Cafe & Resto Pamekasan', 'uploads/kuliner/kuliner_684e8d46a27c18.58235870.webp', '100000.00'),
(14, 'Depot Podomoro Pamekasan', 'uploads/kuliner/kuliner_684e8b56d73b94.40962512.webp', '35000.00'),
(15, 'Mie Gacoan Pamekasan', 'uploads/kuliner/kuliner_684e8bce752b72.95997190.webp', '35000.00');

-- --------------------------------------------------------

--
-- Table structure for table `akomodasi_kuliner_detail`
--

CREATE TABLE `akomodasi_kuliner_detail` (
  `id_akomodasi_kuliner` int NOT NULL,
  `termasuk` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `akomodasi_kuliner_detail`
--

INSERT INTO `akomodasi_kuliner_detail` (`id_akomodasi_kuliner`, `termasuk`) VALUES
(1, 'Sarapan di Hotel'),
(1, 'Makan Siang (Seafood)'),
(1, 'Makan Malam (Buffet)\r\n'),
(1, 'Cemilan & Minuman');

-- --------------------------------------------------------

--
-- Table structure for table `akomodasi_penginapan`
--

CREATE TABLE `akomodasi_penginapan` (
  `id_akomodasi_penginapan` int NOT NULL,
  `nama_penginapan` varchar(100) NOT NULL,
  `gambar_url` varchar(255) DEFAULT NULL,
  `rating_bintang` tinyint DEFAULT NULL,
  `harga_per_malam` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `akomodasi_penginapan`
--

INSERT INTO `akomodasi_penginapan` (`id_akomodasi_penginapan`, `nama_penginapan`, `gambar_url`, `rating_bintang`, `harga_per_malam`) VALUES
(1, 'Hotel Santika Jakarta', 'uploads/penginapan/penginapan_684e86afd6cbd0.35455033.jpg', 4, 470000),
(2, 'Arfina Residence Syariah Lamongan', 'https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Nnx8aG90ZWx8ZW58MHx8MHx8fDA%3D&w=1000&q=80', 5, 350000),
(3, 'Mercure Convention Center Ancol', 'uploads/penginapan/penginapan_684e8703304a63.88075716.jpg', 4, 450000),
(4, 'The Langham Jakarta', 'uploads/penginapan/penginapan_684e87dec0e0c3.16199645.avif', 5, 1500000),
(5, 'Tanjung Kodok Beach Resort Lamongan ', 'uploads/penginapan/penginapan_684e8799b049d9.09882005.crdownload', 5, 750000),
(6, 'Hotel Boegenviel Syariah Lamongan', 'https://images.unsplash.com/photo-1582719508461-905c673771fd?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTF8fGhvdGVsfGVufDB8fDB8fHww&w=1000&q=80', 5, 400000),
(7, 'Hotel Majapahit Surabaya', 'uploads/penginapan/penginapan_684e8641202722.44284906.jpg', 5, 700000),
(8, 'Swiss-Belinn Tunjungan Surabaya ', 'uploads/penginapan/penginapan_684e8767e45ea0.24926546.jpg', 5, 550000),
(9, 'My Studio Hotel Surabaya', 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTh8fGhvdGVsfGVufDB8fDB8fHww&w=1000&q=80', 5, 500000),
(10, 'Hotel Ningrat Bangkalan', 'https://images.unsplash.com/photo-1568084680786-a84f91d1153c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MjB8fGhvdGVsfGVufDB8fDB8fHww&w=1000&q=80', 5, 600000),
(11, 'Hotel Prima Sejahtera Bangkalan', 'https://images.unsplash.com/photo-1596394516093-501ba68a0ba6?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTd8fGhvdGVsfGVufDB8fDB8fHww&w=1000&q=80', 4, 400000),
(12, 'Rose Hotel Bangkalan ', 'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8OXx8aG90ZWx8ZW58MHx8MHx8fDA%3D&w=1000&q=80', 5, 300000),
(13, 'Front One Hotel Pamekasan', 'https://images.unsplash.com/photo-1455587734955-081b22074882?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MjV8fGhvdGVsfGVufDB8fDB8fHww&w=1000&q=80', 5, 600000),
(14, 'Odaita Hotel Pamekasan', 'https://images.unsplash.com/photo-1561501900-3701fa6a0864?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTB8fGhvdGVsfGVufDB8fDB8fHww&w=1000&q=80', 4, 200000),
(15, 'New Ramayana Hotel Pamekasan', 'https://images.unsplash.com/photo-1590073242678-70ee3fc28e8e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MzB8fGhvdGVsfGVufDB8fDB8fHww&w=1000&q=80', 5, 350000);

-- --------------------------------------------------------

--
-- Table structure for table `akomodasi_penginapan_detail`
--

CREATE TABLE `akomodasi_penginapan_detail` (
  `id_akomodasi` int NOT NULL,
  `termasuk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `akomodasi_penginapan_detail`
--

INSERT INTO `akomodasi_penginapan_detail` (`id_akomodasi`, `termasuk`) VALUES
(1, 'Kamar Twin/Double Bed'),
(1, 'Free WiFi'),
(1, 'Kolam Renang'),
(1, 'Parkir Gratis'),
(1, 'Sarapan');

-- --------------------------------------------------------

--
-- Table structure for table `artikel`
--

CREATE TABLE `artikel` (
  `id_artikel` int NOT NULL,
  `judul_artikel` varchar(200) DEFAULT NULL,
  `tanggal_dipublish` date DEFAULT NULL,
  `isi_artikel` text,
  `id_komentar_artikel` int DEFAULT NULL,
  `tag` varchar(100) DEFAULT NULL,
  `id_jenis_artikel` int DEFAULT NULL,
  `id_gambar_artikel` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `artikel`
--

INSERT INTO `artikel` (`id_artikel`, `judul_artikel`, `tanggal_dipublish`, `isi_artikel`, `id_komentar_artikel`, `tag`, `id_jenis_artikel`, `id_gambar_artikel`) VALUES
(1, 'Tips Aman Mendaki Gunung untuk Pemula', '2024-07-15', '<p>Mendaki gunung merupakan aktivitas yang menantang namun menyenangkan. Bagi pemula, perlu persiapan matang agar pendakian berjalan lancar dan aman. Pastikan fisik prima, bawa perbekalan cukup, dan selalu ikuti jalur yang ada. Jangan lupa membawa peta dan kompas, serta informasikan rencana pendakianmu kepada orang terdekat atau pos jaga. Cuaca di gunung bisa berubah cepat, jadi siapkan pakaian hangat dan jas hujan. Yang terpenting, jangan memaksakan diri jika kondisi tidak<strong> memungkinkan.</strong></p>', NULL, 'mendaki, tips, aman, gunung', 1, 1),
(2, 'Pantai Tersembunyi di Indonesia Timur yang Wajib Dikunjungi', '2024-07-12', '<p>Indonesia timur menyimpan banyak pesona pantai yang masih alami dan belum banyak terjamah. Dari pasir putih halus hingga keanekaragaman biota laut yang memukau, pantai-pantai ini menawarkan pengalaman liburan yang tak terlupakan. Beberapa di antaranya adalah Pantai Ora di Maluku, Pantai Pink di Lombok, dan Pantai Derawan di Kalimantan Timur. Siapkan dirimu untuk terpesona oleh keindahan alamnya!</p>', NULL, 'pantai, indonesia timur, destinasi', 2, 2),
(7, 'Tips Liburan Hemat Tahun 2025', '2025-06-15', '<p>Tips Liburan Hemat Tahun 2025 1. Rencanakan liburan jauh-jauh hari Merencanakan liburan sejak dini memberikan kamu waktu untuk mencari tiket transportasi dan akomodasi dengan harga terbaik. Biasanya, harga tiket pesawat, kereta, atau bus jauh lebih murah jika dipesan beberapa bulan sebelum keberangkatan. Selain itu, kamu juga bisa membandingkan berbagai pilihan untuk mendapatkan penawaran yang paling sesuai dengan anggaran. Selain soal harga, perencanaan awal juga memberimu kesempatan untuk menyesuaikan jadwal dengan destinasi yang ingin dikunjungi. Dengan begitu, kamu bisa menghindari waktu-waktu ramai seperti musim liburan atau akhir pekan panjang yang biasanya menaikkan biaya perjalanan dan penginapan. 2. Manfaatkan promo dan diskon Jangan ragu untuk berburu promo dari berbagai platform perjalanan. Banyak maskapai penerbangan, aplikasi booking hotel, atau agen perjalanan online yang menawarkan diskon besar-besaran di waktu tertentu. Misalnya, kamu bisa memanfaatkan momen seperti Harbolnas atau promo tahunan lainnya. Selain itu, jangan lupa manfaatkan kartu kredit atau membership tertentu yang sering memberikan cashback atau potongan harga untuk perjalanan. Dengan cermat memanfaatkan promo, kamu bisa menghemat banyak biaya tanpa mengurangi kenyamanan liburan. 3. Pilih destinasi yang ramah budget Tidak semua destinasi wisata membutuhkan biaya mahal. Kamu bisa memilih tujuan liburan lokal yang tidak kalah menarik dibandingkan destinasi internasional. Contohnya, banyak tempat wisata di Indonesia yang menawarkan keindahan alam dan budaya dengan harga yang terjangkau. Selain itu, kamu bisa mencari destinasi yang menawarkan banyak tempat wisata gratis atau murah, seperti taman kota, museum dengan tiket murah, atau pantai yang tidak memungut biaya masuk. Dengan pilihan destinasi yang tepat, pengalaman liburan tetap seru tanpa boros. 4. Gunakan transportasi umum Transportasi sering menjadi salah satu komponen pengeluaran terbesar saat liburan. Untuk menghemat, gunakan transportasi umum seperti bus, kereta, atau angkutan lokal di tempat tujuan. Selain lebih murah, transportasi umum juga memberimu kesempatan untuk merasakan kehidupan sehari-hari masyarakat setempat. Jika kamu bepergian dalam grup, pertimbangkan untuk menyewa kendaraan bersama. Biaya sewa bisa dibagi rata, sehingga lebih hemat dibandingkan menggunakan taksi atau transportasi online secara terpisah. 5. Coba penginapan alternatif Hotel berbintang memang menawarkan kenyamanan maksimal, tetapi sering kali biayanya cukup tinggi. Sebagai alternatif, kamu bisa mencoba hostel, guesthouse, atau homestay yang lebih ramah di kantong. Banyak opsi penginapan ini juga memberikan pengalaman unik, seperti tinggal bersama penduduk lokal. Selain itu, platform seperti Airbnb atau Couchsurfing bisa menjadi pilihan menarik untuk mencari tempat tinggal dengan harga lebih terjangkau, bahkan gratis. Pastikan untuk membaca ulasan sebelum memesan agar tetap merasa aman dan nyaman selama menginap.</p>', NULL, '#tips,  #hemat, #liburan', 1, 11),
(8, 'Berburu Makanan Khas Jakarta', '2025-06-15', 'Makanan khas Jakarta yang Melegenda\r\n\r\nKerak Telor\r\nNggak bisa dipungkiri lagi, kerak telor seakan jadi ikon makanan khas Jakarta. Kuliner tradisional yang terbuat dari beras ketan, telur bebek, ebi (udang kering), dan kelapa parut ini selalu hadir dalam berbagai festival dan acara besar di Jakarta. Rasanya yang gurih dengan sedikit sentuhan manis dari kelapa parut membuatnya selalu dirindukan.\r\n\r\nNasi Uduk\r\nKalau negara tetangga punya nasi lemak, Jakarta punya nasi uduk. Kuliner berupa nasi gurih ini termasuk mudah ditemukan di berbagai sudut Jakarta, terutama di daerah pemukiman.\r\nNasi uduk identik dengan menu sarapan mayoritas warga Jakarta. Meski begitu, nggak jarang juga kuliner satu ini dijual di malam hari. \r\n\r\nSoto Betawi\r\nHampir tiap daerah di Indonesia punya racikan sotonya masing-masing. Kalau di Jakarta tentu ada soto betawi\r\nSeporsi soto betawi berisi potongan daging sapi (terkadang dengan jeroan seperti paru dan kikil), tomat, kentang, dan emping yang disiram kuah santan maupun kuah susu yang gurih dan berempah.\r\nSalah satu punggawa kuliner Jakarta yang menjadi legenda Soto Betawi adalah Soto H. Ma’ruf yang digadang telah eksis sejak tahun 1940.', NULL, '#kuiner #enak #murah', 3, 12),
(9, 'Kuliner Khas Pamekasan yang Wajib Dicoba Saat Berkunjung Ke Pamekasan', '2025-06-15', 'Kuliner khas Pamekasan\r\n\r\nRujak Pamekasan\r\nRujak ini berbahan dasar petis ikan, bahan campurannya terdiri dari lontong, mentimun, kacang panjang, kecambah, tahu, cingur sapi, rumput laut segar, yang istimewa ada keripik tette (terbuat dari singkong).\r\n\r\nKaldu Kokot\r\nKaldu Kokot tampil dengan ciri yang berupa rebusan kacang hijau dan Kokot atau balungan sapi. Di Pamekasan banyak dijumpai kuliner ini karena merupakan salah satu kuliner khasnya.\r\n\r\nCampor Lorjuk\r\nCampor Lorjuk ini berbahan dasar lontong, kremesan keripik tette, Bihun, dan disiram dengan kuah merah yang ada kecambah pendek (toge) dan lorjuk (sejenis kerang atau yang dikenal sebagai kerang bambu).', NULL, '#kuliner #lokal #madura', 3, 13),
(10, 'Destinasi Terpopuler yang Harus Kamu Kunjungi di Bangkalan', '2025-06-15', '<p>Destinasi Terpopuler di Bangkalan Pantai Sambilangan Berbatasan langsung dengan lautan, menjadikan Kabupaten Bangkalan memiliki pantai yang menawan, salah satunya Pantai Sambilangan. Pantai ini berada di sisi barat Pulau Madura, tepatnya di Desa Sambilangan, Kabupaten Bangkalan. Daya tarik pantai ini adalah keberadaan mercusuar peninggalan Belanda, berdasarkan informasi dari Tribun News Wiki. Mercusuar yang berdiri pada 1879 itu, tingginya sekitar 78 meter dan terdiri dari 17 lantai. Mercusuar ini didirikan oleh Z.M. William III, seorang pimpinan kolonial Belanda. Fungsinya, untuk mengawasi lalu lintas di perairan Selat Madura. Selain menjadi destinasi wisata, Mercusuar Sembilangan masih digunakan sebagai pengatur lalu lintas kapal di sekitar Selat Madura. Pantai Rongkang Pantai Rongkang mempunyai daya tarik yang membedakannya dengan pantai di Madura lainnya. Ciri khas tersebut adalah bebatuan kecil yang menutupi pantai, berdasarkan informasi dari Tribun News Wiki. Baca juga: Kisah Aryan \"Selamatkan\" Temannya 2 Menit Jelang Air India Jatuh Selain bebatuan kecil di pantai, wisatawan juga akan menjumpai batuan karang di pinggiran pantai. Nama pantai ini berasal dari bahasa Madura ngrongkang yang berarti berlubang. Asal usul nama tersebut lantaran batuan karang di pinggir pantai berlubang akibat abrasi. Lokasi Pantai Rongkang berada di Desa Kwanyar Barat, Kecamatan Kwanyar, Kabupaten Bangkalan, atau sekitar 5 km dari Jembatan Suramadu. Masid Agung Bnagkalan Masjid Agung Bangkalan merupakan salah satu masjid bersejarah di Pulau Madura. Masjid yang memiliki nama resmi, Masjid Agung Sultan Kadirun Bangkalan ini, merupakan salah satu warisan sejarah kerajaan Islam yang pernah berdiri di Madura, seperti dilansir dari website Tourist Information Center. Masjid Agung Bangkalan di bangun pada 1819, sehingga menjadi salah satu masjid tertua di Madura. Dengan luas 11.527 meter persegi, masjid ini mampu menampung hingga 5000 jemaah. Keunikan masjid ini adalah atapnya tidak berbentuk kubah, melainkan atap rumah tradisional Jawa. Selain beribadah, wisatawan yang berkunjung bida menyaksikan arsitektur masjid yang dipenuhi ukiran seni. kerapan sapi Kerapan sapi merupakan sebuah tradisi khas Madura yang sudah ada sejak zaman dahulu. Salah satu tempat menonton karapan sapi adalah lapangan R.P. Moch. Noer di Dusun Bajik, Kelurahan Bancaran, Kabupaten Bangkalan. Baca juga: Prabowo Ambil Keputusan soal Sengketa 4 Pulau Aceh ke Sumut Pekan Depan Masyarakat setempat menyebut tempat ini sebagai daerah skeep, berdasarkan informasi dari Tourist Information Center. Namanya diambil dari nama mantan Gubernur Jawa Timur serta penggagas Jembatan Suramadu. Wisatawan yang ingin menyaksikan karapan sapi di lapangan R.P. Moch. Noer harus lebih dulu mencari informasi mengenai jadwalnya, lantaran tidak digelar setiap hari.</p>', NULL, '#destinasi #tempat #madura', 2, 14);

-- --------------------------------------------------------

--
-- Table structure for table `bahasa`
--

CREATE TABLE `bahasa` (
  `id_bahasa` int NOT NULL,
  `nama_bahasa` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `bahasa`
--

INSERT INTO `bahasa` (`id_bahasa`, `nama_bahasa`) VALUES
(1, 'Indonesia'),
(2, 'Inggris'),
(3, 'Jepang'),
(4, 'Mandarin'),
(5, 'Belanda'),
(6, 'Jerman'),
(7, 'Prancis');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id_comment` int NOT NULL,
  `id_artikel` int NOT NULL,
  `comment_author_name` varchar(100) NOT NULL,
  `comment_author_email` varchar(100) DEFAULT NULL,
  `comment_text` text NOT NULL,
  `comment_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('pending','approved','spam') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id_comment`, `id_artikel`, `comment_author_name`, `comment_author_email`, `comment_text`, `comment_date`, `status`) VALUES
(1, 1, 'Tuhu Pangestu', 'tuhuwkwk@gmail.com', 'test', '2025-06-04 12:37:07', 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id_message` int NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(25) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `received_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('unread','read','replied') DEFAULT 'unread'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id_message`, `first_name`, `last_name`, `email`, `phone`, `subject`, `message`, `received_at`, `status`) VALUES
(5, 'Tuhu', 'Pangestu', 'tuhuwkwk@gmail.com', '+6281357742408', 'informasi-umum', 'hahahaha', '2025-06-07 11:50:49', 'read'),
(8, 'Intan', 'Aulia', 'intaaan741@gmail.com', '085706472290', 'informasi-umum', 'Bagaimana cara pemesanannya', '2025-06-16 03:25:54', 'unread'),
(9, 'Intan', 'Aulia', 'intaaan741@gmail.com', '085706472290', 'informasi-umum', 'Bagaimana cara pemesanannya', '2025-06-16 03:28:52', 'unread');

-- --------------------------------------------------------

--
-- Table structure for table `detail_peserta_pemesanan`
--

CREATE TABLE `detail_peserta_pemesanan` (
  `id_detail_peserta` int NOT NULL,
  `id_pemesanan` int NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `no_ktp` varchar(16) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` varchar(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faq`
--

CREATE TABLE `faq` (
  `id_faq` int NOT NULL,
  `pertanyaan` varchar(255) NOT NULL,
  `jawaban` text NOT NULL,
  `kategori_faq` varchar(100) DEFAULT 'Umum',
  `urutan_tampil` int DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `faq`
--

INSERT INTO `faq` (`id_faq`, `pertanyaan`, `jawaban`, `kategori_faq`, `urutan_tampil`, `is_active`) VALUES
(1, 'Bagaimana cara memesan paket wisata?', 'Anda dapat memesan paket wisata melalui website kami di halaman paket, menghubungi customer service kami melalui telepon atau email yang tertera, atau datang langsung ke kantor kami untuk konsultasi dan pemesanan.', 'Umum', 1, 1),
(2, 'Apakah tersedia tour guide yang berbahasa Indonesia?', 'Ya, semua tour guide kami adalah profesional yang fasih berbahasa Indonesia. Kami juga dapat menyediakan tour guide yang menguasai bahasa asing lainnya seperti Inggris atau Mandarin berdasarkan permintaan khusus dan ketersediaan.', 'Umum', 2, 1),
(3, 'Bagaimana kebijakan pembatalan dan refund?', 'Kebijakan pembatalan dan pengembalian dana (refund) bervariasi tergantung pada jenis paket wisata yang Anda pilih dan seberapa dekat pembatalan dilakukan dengan tanggal keberangkatan. Detail lengkap mengenai kebijakan ini dapat Anda temukan di halaman Syarat dan Ketentuan kami atau dapat ditanyakan langsung kepada tim customer service kami saat melakukan pemesanan.', 'Umum', 3, 1),
(4, 'Apakah asuransi perjalanan sudah termasuk dalam paket?', 'Asuransi perjalanan dasar umumnya sudah termasuk dalam sebagian besar paket wisata kami untuk memberikan perlindungan minimal. Namun, kami sangat menyarankan Anda untuk mempertimbangkan opsi upgrade ke asuransi perjalanan premium yang menawarkan cakupan perlindungan yang lebih komprehensif. Informasi detail mengenai cakupan asuransi akan diberikan saat pemilihan paket.', 'Umum', 4, 1),
(5, 'Apakah bisa custom paket wisata sesuai keinginan?', 'Tentu saja! Kami sangat senang membantu Anda merancang paket wisata yang sepenuhnya disesuaikan (custom) dengan preferensi, anggaran, dan jadwal Anda. Tim konsultan perjalanan kami akan bekerja sama dengan Anda untuk membuat itinerary yang sempurna dan tak terlupakan.', 'Umum', 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `galeri`
--

CREATE TABLE `galeri` (
  `id_galeri` int NOT NULL,
  `judul` varchar(255) NOT NULL,
  `kategori` varchar(100) DEFAULT NULL,
  `tipe_file` enum('gambar','video') NOT NULL DEFAULT 'gambar',
  `path_file` varchar(255) NOT NULL,
  `tanggal_upload` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `galeri`
--

INSERT INTO `galeri` (`id_galeri`, `judul`, `kategori`, `tipe_file`, `path_file`, `tanggal_upload`) VALUES
(3, 'GOA BLABAN', 'Goa', 'gambar', 'uploads/galeri/gambar_684ec45da69cb5.06677857.webp', '2025-06-15 13:02:21'),
(4, 'Taman Mini Indonesia Indah', 'Taman', 'gambar', 'uploads/galeri/gambar_684ec6a5d417e6.13235755.jpg', '2025-06-15 13:12:05'),
(5, 'Museum Nasional Indonesia', 'Museum', 'gambar', 'uploads/galeri/gambar_684ec718a53475.09851629.jpg', '2025-06-15 13:14:00'),
(6, 'Jakarta Aquarium', '', 'gambar', 'uploads/galeri/gambar_684ec7981303f6.24281719.jpg', '2025-06-15 13:16:08'),
(8, 'Monumen Nasional', '', 'gambar', 'uploads/galeri/gambar_684ec86db7d7b9.96810379.jpg', '2025-06-15 13:19:41'),
(9, 'Dunia Fantasi', '', 'gambar', 'uploads/galeri/gambar_684ec8e952f186.79878265.png', '2025-06-15 13:21:45'),
(10, 'Pantai Pasir Putih Tlangoh', 'Pantai', 'gambar', 'uploads/galeri/gambar_684ec9798f77c5.08420162.jpg', '2025-06-15 13:24:09'),
(11, 'Mercusuar Sembilangan', '', 'gambar', 'uploads/galeri/gambar_684ec9c0abaa85.97048246.jpg', '2025-06-15 13:25:20'),
(12, 'Labuhan Mangrove', 'pantai', 'gambar', 'uploads/galeri/gambar_684ecaa0164ff4.04413788.jpeg', '2025-06-15 13:29:04'),
(13, 'Monumen Nasional', '', 'video', 'uploads/videos/video_684eccb249a7f8.23180952.mp4', '2025-06-15 13:37:54'),
(16, 'Mercusuar Sembilangan', '', 'video', 'uploads/videos/video_684f8f6339d527.79056030.mp4', '2025-06-16 03:28:35');

-- --------------------------------------------------------

--
-- Table structure for table `gambar`
--

CREATE TABLE `gambar` (
  `id_gambar` int NOT NULL,
  `wisata_id` int DEFAULT NULL,
  `url` text,
  `caption` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `gambar`
--

INSERT INTO `gambar` (`id_gambar`, `wisata_id`, `url`, `caption`) VALUES
(48, 4, '../uploads/wisata/wisata_4_6842814f9c357_gunung pegat.png', ''),
(49, 4, '../uploads/wisata/wisata_4_6842821102f79_gunung pegat.png', ''),
(51, 10, '../uploads/wisata/wisata_10_6842b5011b140_tempat-wisata-di-jakarta-hits-murah.jpg', ''),
(52, 14, '../uploads/wisata/wisata_14_6842d961ac5a1_PAntai-watu-leter-760x428.jpg', ''),
(53, 3, '../uploads/wisata/wisata_3_6842da7fd98f0_Indonesian-Islamic-Art-Museum-600x396.webp', ''),
(54, 9, '../uploads/wisata/wisata_9_6842dad47e590_wisata-aquarium-di-jakarta.jpg', ''),
(55, 13, '../uploads/wisata/wisata_13_6842dd65547b7_whatsapp-image-2019-09-11-at-10.58.31-1.jpeg', ''),
(56, 12, '../uploads/wisata/wisata_12_6842de16d568d_Mercusuar-Sembilangan.jpg', ''),
(57, 7, '../uploads/wisata/wisata_7_6842de8584c89_Museum-Nasional-Indonesia-610x610.jpg', ''),
(58, 8, '../uploads/wisata/wisata_8_6842dee7a1925_Monumen-Nasional-610x406.jpg', ''),
(59, 2, '../uploads/wisata/wisata_2_6842df3e276a2_sunset-di-pantai-lorena.jpg', ''),
(60, 11, '../uploads/wisata/wisata_11_6842df7a4f56c_pantai-pasir-putih-tlongoh.jpg', ''),
(61, 1, '../uploads/wisata/wisata_1_6842e02e05986_67295967-346417262975578-1072998307841617827-n-0d8c92d554dceea1db568d6842735c66-d2fa2851491d4160764cda34cae65e61.jpg', ''),
(62, 5, '../uploads/wisata/wisata_5_6842e0e949cd5_image-10.png', ''),
(63, 6, '../uploads/wisata/wisata_6_6842e14cca224_Taman-Mini-Indonesia-Indah-610x407.jpg', ''),
(64, 16, '../uploads/wisata/wisata16_68430da2d25bc.jpeg', 'Dermaga  Rindu - Gambar Utama'),
(65, 17, '../uploads/wisata/wisata17_684310051c727.jpg', 'Surabaya Kota Lama - Gambar Utama'),
(66, 18, '../uploads/wisata/wisata18_684311464b4fd.jpg', 'Monumen Kapal Selam - Gambar Utama'),
(67, 19, '../uploads/wisata/wisata19_6843144b4241f.jpg', 'Monumen Nasional Tugu Pahlawan dan Museum 10 November - Gambar Utama'),
(68, 20, '../uploads/wisata/wisata20_6843acf759315.jpg', 'Kebun Binatang - Gambar Utama'),
(69, 21, '../uploads/wisata/wisata21_6843aea1d1f32.jpg', 'Atlantis Land - Gambar Utama'),
(71, 23, '../uploads/wisata/wisata23_6843b292bd711.jpg', 'Pantai Batu Kerbuy - Gambar Utama'),
(72, 24, '../uploads/wisata/wisata24_6843b40d555dd.jpg', 'Air Terjun Ahatan - Gambar Utama'),
(73, 25, '../uploads/wisata/wisata25_6843b4fa8b7e0.jpg', 'Goa Blaban - Gambar Utama'),
(74, 26, '../uploads/wisata/wisata26_6843d04c329fc.jpg', 'Bukit Kampung Toron Samalem - Gambar Utama'),
(75, 22, '../uploads/wisata/wisata_22_684e9521af74e_panjat-tebing maha waru.jpg', '');

-- --------------------------------------------------------

--
-- Table structure for table `gambar_artikel`
--

CREATE TABLE `gambar_artikel` (
  `id_gambar_artikel` int NOT NULL,
  `id_artikel` int DEFAULT NULL,
  `url` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `gambar_artikel`
--

INSERT INTO `gambar_artikel` (`id_gambar_artikel`, `id_artikel`, `url`) VALUES
(1, 1, 'https://images.unsplash.com/photo-1503220317375-aaad61436b1b'),
(2, 2, 'https://images.unsplash.com/photo-1506477331477-33d5d8b3dc85'),
(6, NULL, './uploads/artikel/68444dadb4148_pexels-suyashbatra-32338678.jpg'),
(7, NULL, 'http://localhost:8080/gotravel/uploads/artikel/artikel_68444dbf59c4e6.75981075.jpeg'),
(8, NULL, 'http://localhost:8080/gotravel/uploads/artikel/artikel_68444ec81957f9.79707637.jpg'),
(9, NULL, 'uploads/artikel/artikel_68444f7c567a99.11310581.png'),
(10, NULL, 'uploads/artikel/artikel_684ec14793f322.97397739.webp'),
(11, NULL, './uploads/artikel/684ec3fb37117_Cuplikan layar 2025-06-15 200011.png'),
(12, NULL, './uploads/artikel/684ec66fd6a19_gambar 2.jpeg'),
(13, NULL, './uploads/artikel/684ec7cb36676_rujak-pamekasan.jpg'),
(14, NULL, 'uploads/artikel/artikel_684ecac725fba9.35251328.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `gambar_paket`
--

CREATE TABLE `gambar_paket` (
  `id_gambar_paket` int NOT NULL,
  `id_paket_wisata` int NOT NULL,
  `url_gambar` varchar(255) NOT NULL,
  `caption_gambar` varchar(255) DEFAULT NULL,
  `is_thumbnail` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `gambar_paket`
--

INSERT INTO `gambar_paket` (`id_gambar_paket`, `id_paket_wisata`, `url_gambar`, `caption_gambar`, `is_thumbnail`) VALUES
(5, 27, 'paket_27_6842ba394693b.jpg', '', 0),
(15, 9, 'paket_9_6843d1ee42dce.png', '', 0),
(16, 10, 'paket_10_6843d3d34149a.png', '', 0),
(17, 14, 'paket_14_6843d422493ed.jpg', '', 0),
(18, 13, 'paket_13_6843d444d2a72.jpeg', '', 0),
(19, 12, 'paket_12_6843d4996c8c7.jpg', '', 0),
(20, 11, 'paket_11_6843d4b95b9d5.jpg', '', 0),
(21, 8, 'paket_8_6843d4dbea72b.jpg', '', 0),
(22, 7, 'paket_7_6843d532971c0.jpg', '', 0),
(23, 6, 'paket_6_6843d55931334.jpg', '', 0),
(24, 5, 'paket_5_6843d571cb9a9.jpg', '', 0),
(26, 3, 'paket_3_6843d5b97938b.jpg', '', 0),
(27, 2, 'paket_2_6843d5d830cc3.webp', '', 0),
(28, 1, 'paket_1_6843d658a7e8f.jpg', '', 0),
(29, 26, 'paket_26_6843d73327927.jpeg', '', 0),
(31, 24, 'paket_24_6843d8a8a9eb1.webp', '', 0),
(33, 35, 'paket_thumbnail_35_6843daee656d8.jpg', 'Monumen Kapal Selam 2D1N - Thumbnail', 1),
(34, 36, 'paket_thumbnail_36_6843db6c3340b.jpg', 'Kebun Binatang Surabaya - Thumbnail', 1),
(35, 37, 'paket_thumbnail_37_6843dc217f44e.jpg', 'Monumen Nasional Tugu Pahlawan dan Museum 10 November - Thumbnail', 1),
(36, 38, 'paket_thumbnail_38_6843dca71389a.jpg', 'Surabaya Kota Lama - Thumbnail', 1),
(37, 39, 'paket_thumbnail_39_6843de2bd3454.jpg', 'Air Terjun Ahatan 2D1N - Thumbnail', 1),
(38, 40, 'paket_thumbnail_40_6843debd09726.jpg', 'Bukit Kampung Toron Semalem 3D2N - Thumbnail', 1),
(39, 41, 'paket_thumbnail_41_6843e03862d5a.jpg', 'Goa Blaban 1D - Thumbnail', 1),
(40, 42, 'paket_thumbnail_42_6843e0c2d9ad6.jpg', 'Panjat Tebing Gunung Labeng Waru 2D1N - Thumbnail', 1),
(41, 43, 'paket_thumbnail_43_6843e13e3fd7f.jpg', 'Pantai Batu Kerbuy 1D - Thumbnail', 1);

-- --------------------------------------------------------

--
-- Table structure for table `jenis_artikel`
--

CREATE TABLE `jenis_artikel` (
  `id_jenis_artikel` int NOT NULL,
  `jenis_artikel` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `jenis_artikel`
--

INSERT INTO `jenis_artikel` (`id_jenis_artikel`, `jenis_artikel`) VALUES
(1, 'Tips Perjalanan'),
(2, 'Destinasi Populer'),
(3, 'Kuliner Lokal'),
(4, 'Budaya');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_paket`
--

CREATE TABLE `jenis_paket` (
  `id_jenis_paket` int NOT NULL,
  `jenis_paket` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `jenis_paket`
--

INSERT INTO `jenis_paket` (`id_jenis_paket`, `jenis_paket`) VALUES
(1, 'Standar'),
(2, 'Premium'),
(3, 'Keluarga');

-- --------------------------------------------------------

--
-- Table structure for table `kategori_wisata`
--

CREATE TABLE `kategori_wisata` (
  `id_kategori` int NOT NULL,
  `nama_kategori` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kategori_wisata`
--

INSERT INTO `kategori_wisata` (`id_kategori`, `nama_kategori`) VALUES
(1, 'Pantai'),
(2, 'Hiburan'),
(3, 'Budaya & Sejarah');

-- --------------------------------------------------------

--
-- Table structure for table `kendaraan`
--

CREATE TABLE `kendaraan` (
  `id_kendaraan` int NOT NULL,
  `jenis_kendaraan` varchar(100) DEFAULT NULL,
  `gambar` varchar(255) NOT NULL,
  `harga` decimal(12,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kendaraan`
--

INSERT INTO `kendaraan` (`id_kendaraan`, `jenis_kendaraan`, `gambar`, `harga`) VALUES
(1, 'Hiace Commuter', 'uploads/kendaraan/kendaraan_684e3e6012def4.36514240.jpg', '500000.00'),
(2, 'Avanza', 'uploads/kendaraan/kendaraan_684e3e2534d675.52932998.webp', '250000.00'),
(3, 'Elf Long', 'uploads/kendaraan/kendaraan_684e3e405d09f6.77720551.jpg', '500000.00'),
(4, 'Innova', 'uploads/kendaraan/kendaraan_684e3bf659ed45.58540134.jpg', '200000.00'),
(5, 'Alphard', 'uploads/kendaraan/kendaraan_684e3e06f059e5.87693279.jpg', '400000.00');

-- --------------------------------------------------------

--
-- Table structure for table `komentar_artikel`
--

CREATE TABLE `komentar_artikel` (
  `id_komentar_artikel` int NOT NULL,
  `judul_artikel` varchar(200) DEFAULT NULL,
  `tanggal_dipublish` date DEFAULT NULL,
  `isi_artikel` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kontak`
--

CREATE TABLE `kontak` (
  `id_kontak` int NOT NULL,
  `alamat_kantor` text,
  `telepon` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `website` varchar(100) DEFAULT NULL,
  `jam_operasional` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kuliner`
--

CREATE TABLE `kuliner` (
  `id_kuliner` int NOT NULL,
  `nama_kuliner` varchar(100) DEFAULT NULL,
  `ulasan` text,
  `wilayah` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lokasi`
--

CREATE TABLE `lokasi` (
  `id_lokasi` int NOT NULL,
  `nama_lokasi` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `lokasi`
--

INSERT INTO `lokasi` (`id_lokasi`, `nama_lokasi`) VALUES
(1, 'Lamongan'),
(2, 'jakarta'),
(3, 'Surabaya'),
(4, 'Bangkalan'),
(5, 'Pamekasan');

-- --------------------------------------------------------

--
-- Table structure for table `paket_wisata`
--

CREATE TABLE `paket_wisata` (
  `id_paket_wisata` int NOT NULL,
  `id_wisata` int DEFAULT NULL,
  `id_jenis_paket` int DEFAULT NULL,
  `id_wilayah` int DEFAULT NULL,
  `nama_paket` varchar(100) DEFAULT NULL,
  `durasi_paket` varchar(50) DEFAULT NULL,
  `id_pemandu_wisata` int DEFAULT NULL,
  `id_kendaraan` int DEFAULT NULL,
  `id_akomodasi_kuliner` int DEFAULT NULL,
  `id_akomodasi_penginapan` int DEFAULT NULL,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `denah_lokasi` text,
  `harga` int NOT NULL,
  `info_penting` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `paket_wisata`
--

INSERT INTO `paket_wisata` (`id_paket_wisata`, `id_wisata`, `id_jenis_paket`, `id_wilayah`, `nama_paket`, `durasi_paket`, `id_pemandu_wisata`, `id_kendaraan`, `id_akomodasi_kuliner`, `id_akomodasi_penginapan`, `deskripsi`, `denah_lokasi`, `harga`, `info_penting`) VALUES
(1, 10, 2, 2, 'Dunia Fantasi Ancol 2D1N', '2 Hari 1 Malam', 2, 1, 1, 3, 'Nikmati pengalaman lengkap berlibur di Ancol Taman Impian dengan paket 2 hari 1 malam yang sudah termasuk penginapan di hotel berbintang, makanan, dan akses ke semua wahana utama. Paket ini dirancang khusus untuk memberikan pengalaman liburan yang tak terlupakan bersama keluarga dengan kenyamanan maksimal tanpa perlu repot mengatur akomodasi dan transportasi.', '../uploads/denah/denah_1_684ece0b8df0c.jpg', 1440000, 'Harap membawa pakaian renang.'),
(2, 3, 2, 1, 'Indonesian Islamic Art Museum 2D1N', '2 Hari 1 Malam', 2, 1, 2, 2, 'Indonesian Islamic Art Museum (IIAM) merupakan destinasi wisata religi dan edukatif yang terletak di kawasan Wisata Bahari Lamongan (WBL), tepatnya di Jl. Raya Paciran, Lamongan, Jawa Timur. Diresmikan pada 28 Desember 2016, museum ini menjadi satu-satunya museum Islam di Indonesia yang menggabungkan koleksi sejarah dengan teknologi Augmented Reality (AR), menawarkan pengalaman interaktif dan mendalam bagi para pengunjung.', '../uploads/denah/denah_2_684eba46e9b9b.jpg', 3000000, 'Kenakan pakaian sopan dan alas kaki nyaman untuk menjelajahi koleksi seni dan budaya Islam yang kaya.'),
(3, 9, 3, 2, 'Jakarta Aquarium 3D2N', '3 Hari 2 Malam', 1, 1, 8, 4, 'Jakarta Aquarium & Safari (JAQS) adalah akuarium indoor terbesar di Indonesia yang terletak di dalam mal Neo Soho, Jakarta Barat. Dibuka pada Oktober 2017, JAQS merupakan hasil kolaborasi antara Taman Safari Indonesia dan Aquaria KLCC Malaysia. Tempat ini menyajikan lebih dari 3.500 spesies satwa akuatik dan non-akuatik dari berbagai belahan dunia, termasuk Asia, Afrika, dan Amerika Selatan.', 'https://imgv2-1-f.scribdassets.com/img/document/455071137/original/0279095a45/1682932194?v=1', 7000000, '1. Siapkan sepatu yang nyaman karena Anda akan banyak berjalan kaki di dalam area yang luas.\r\n2. Abadikan momen-momen menakjubkan bersama hewan-hewan unik dan pemandangan bawah laut yang indah.'),
(5, 7, 1, 2, 'Museum Nasional Indonesia 2D1N', '2 Hari 1 Malam', 2, 2, 9, 1, 'Monumen Nasional (Monas) adalah ikon kebanggaan Indonesia yang terletak di jantung Jakarta, dibangun sebagai simbol perjuangan bangsa dalam merebut kemerdekaan. Dengan tinggi 132 meter, monumen ini menjulang megah dan di puncaknya terdapat nyala api berlapis emas 24 karat yang melambangkan semangat kemerdekaan yang tak pernah padam. Di dalamnya, pengunjung dapat menjelajahi Museum Sejarah Nasional, Ruang Kemerdekaan, serta menikmati panorama Jakarta dari pelataran puncak. Dikelilingi taman luas dan akses mudah, Monas menjadi destinasi edukatif dan rekreatif yang wajib dikunjungi oleh wisatawan lokal maupun mancanegara.', 'https://asset-2.tstatic.net/tribunnewswiki/foto/bank/images/denah-museum-nasional.jpg', 1650000, '1. Nikmati koleksi artefak dan warisan budaya Indonesia yang sangat luas, dari prasejarah hingga masa kini.\r\n2. Siapkan sepatu yang nyaman karena Anda akan banyak berjalan kaki di dalam museum yang luas.\r\n'),
(6, 2, 1, 1, 'Pantai Lorena 2D1N', '2 Hari 1 Malam', 3, 4, 2, 6, 'Pantai Lorena adalah destinasi wisata alam yang menawan di Desa Penanjan, Kecamatan Paciran, Kabupaten Lamongan, Jawa Timur. Nama \"Lorena\" berasal dari singkatan bahasa Jawa \"LORE NAnjan,\" yang berarti \"sebelah utara Desa Penanjan,\" sesuai dengan letaknya. Pantai ini memiliki bentuk melengkung menyerupai laguna dengan pasir putih yang lembut dan air laut yang jernih, menciptakan suasana tenang dan cocok untuk relaksasi.', '../uploads/denah/denah_6_684eb6c3702b3.jpg', 500000, 'Siapkan sunblock, topi, dan pakaian renang/nyaman untuk menikmati suasana pantai berpasir hitam dan ombak yang relatif tenang.\r\n'),
(7, 1, 2, 1, 'Pantai Putri Klayar 2D1N', '2 Hari 1 Malam', NULL, 5, 7, 5, 'Pantai Putri Klayar adalah destinasi wisata bahari yang menawan di Dusun Klayar, Desa Sidokelar, Kecamatan Paciran, Kabupaten Lamongan, Jawa Timur. Pantai ini menawarkan suasana alami dengan pasir putih lembut, air laut jernih, dan deretan pohon bakau yang memberikan keteduhan. Keasrian lingkungan dan keindahan alamnya menjadikan pantai ini cocok untuk bersantai, berkemah, atau menikmati pemandangan matahari terbit dan terbenam. Meskipun akses jalan menuju pantai masih berupa jalan setapak dan fasilitas umum seperti toilet belum tersedia, keindahan alam yang ditawarkan membuat Pantai Putri Klayar menjadi pilihan menarik bagi wisatawan yang mencari ketenangan dan keindahan alam yang belum banyak terjamah.', '../gambar/pantai putri klayar.jpg', 2050000, 'Bawa sunblock dan kenakan alas kaki yang nyaman/aman untuk menjelajahi keindahan pantai, bebatuan unik, dan fenomena seruling samudra.'),
(8, 6, 2, 2, 'Taman Mini Indonesia Indah 3D2N', '3 Hari 2 Malam', 3, 1, 1, 4, 'Taman Mini Indonesia Indah (TMII) adalah taman budaya seluas 145 hektar di Jakarta Timur yang menampilkan miniatur kekayaan budaya dan alam Indonesia. Diresmikan pada 20 April 1975 atas gagasan Ibu Tien Soeharto, TMII bertujuan memperkenalkan dan melestarikan warisan budaya Indonesia kepada masyarakat luas.TMII menawarkan berbagai atraksi, termasuk anjungan daerah yang mewakili 34 provinsi dengan rumah adat, pakaian tradisional, dan seni pertunjukan khas. Terdapat pula danau miniatur kepulauan Indonesia, kereta gantung, dan menara pandang Saujana untuk menikmati pemandangan dari ketinggian. Berbagai museum seperti Museum Indonesia, Museum Purna Bhakti Pertiwi, dan Museum Fauna Indonesia Komodo menyajikan koleksi seni, sejarah, dan fauna Indonesia.', '../uploads/denah/denah_8_684ec932bf04d.png', 3100000, '1. Siapkan fisik dan kenakan alas kaki yang sangat nyaman untuk menjelajahi berbagai anjungan dan wahana yang tersebar luas.\r\n2. Jangan lupa sunblock, topi, dan kacamata hitam karena sebagian besar area adalah terbuka dan terpapar matahari.'),
(9, 5, 3, 1, 'Liburan Keluarga Seru: WBL dan MZG 3D2N', '3 Hari 2 Malam', 2, 3, 6, 2, 'Maharani Zoo & Goa (MZG) dan Wisata Bahari Lamongan (WBL) adalah dua destinasi wisata populer di Lamongan yang menawarkan pengalaman seru dan edukatif bagi pengunjung. MZG menggabungkan kebun binatang dengan koleksi satwa langka dan gua alami dengan formasi stalaktit-stalagmit yang memukau, sementara WBL adalah taman rekreasi dengan berbagai wahana permainan air, pantai cantik, dan fasilitas lengkap untuk keluarga. Keduanya buka setiap hari dengan harga tiket terjangkau, seringkali tersedia paket tiket terusan, menjadikan MZG dan WBL pilihan ideal untuk liburan keluarga yang menyenangkan sekaligus mendidik.', '../uploads/denah/denah_9_6843d25e9c89e.jpg', 3400000, 'Siapkan sunblock, topi, kacamata, dan pakaian nyaman.'),
(10, 4, 1, 1, 'Gunung Pegat 2D1N', '2 Hari 1 Malam', 1, 2, 2, 6, 'Gunung Pegat adalah sebuah bukit kapur yang terletak di Desa Karangkembang, Kecamatan Babat, Kabupaten Lamongan, Jawa Timur. Dengan ketinggian sekitar 60 meter di atas permukaan laut, gunung ini tidak seperti gunung pada umumnya. Nama \"Pegat\" dalam bahasa Jawa berarti \"cerai\", dan hal ini berkaitan dengan mitos yang berkembang di masyarakat setempat. Menurut mitos, pasangan yang hendak menikah dan melewati Gunung Pegat diyakini akan menghadapi perceraian jika tidak melakukan ritual tertentu, seperti melepaskan ayam hidup sebelum melewati gunung tersebut.', '../uploads/denah/denah_10_684eb1d6b526b.jpg', 1000000, '1. Jangan lupa membawa perlengkapan pribadi esensial seperti jaket tebal, topi/kupluk, sarung tangan, sepatu trekking yang nyaman, serta tabir surya (sunscreen) dan kacamata hitam untuk melindungi diri dari paparan matahari selama pendakian.\r\n2. Paket 2 Hari 1 Malam ini sudah termasuk semua kebutuhan dasar pendakian dan camping, meliputi tenda, logistik makanan (makan malam, sarapan), air minum yang cukup, serta perizinan dan tiket masuk area konservasi. '),
(11, 11, 1, 4, 'Pantai Pasir Putih Tlangoh 2D1N', '2 Hari 1 Malam', 2, 4, 5, 11, 'Pantai Pasir Putih Tlangoh adalah destinasi wisata bahari yang memukau di Desa Tlangoh, Kecamatan Tanjungbumi, Kabupaten Bangkalan, Madura. Terkenal dengan hamparan pasir putihnya yang bersih dan air laut biru jernih, pantai ini menawarkan suasana tenang dan alami, cocok untuk bersantai dan menikmati keindahan alam. Pengunjung dapat menikmati berbagai aktivitas seperti bermain air di tepi pantai dengan ombak yang relatif tenang, menjelajahi garis pantai sepanjang hampir 1 km dengan menyewa ATV, atau berswafoto di spot-spot menarik seperti ayunan dan bingkai estetis yang disediakan pengelola. Fasilitas yang tersedia mencakup area parkir luas, toilet, mushola, serta warung-warung yang menyajikan kuliner khas Madura seperti rujak dan bakso. Dengan harga tiket masuk yang terjangkau, sekitar Rp5.000–Rp10.000 per orang tergantung hari kunjungan, Pantai Tlangoh menjadi pilihan ideal untuk liburan keluarga atau sekadar melepas penat dari rutinitas sehari-hari.', '../uploads/denah/denah_11_684ec6de03f7d.jpg', 450000, '1. Jangan lupa sunblock, topi lebar, dan kacamata hitam karena pantulan sinar matahari dari pasir bisa sangat intens.'),
(12, 12, 2, 4, 'Mercusuar Sembilangan 2D1N', '2 Hari 1 Malam', 2, 4, 4, 12, 'Mercusuar Sembilangan, yang berlokasi di Desa Sembilangan, Kecamatan Socah, Kabupaten Bangkalan, adalah sebuah menara besi putih menjulang setinggi sekitar 65 hingga 78 meter yang dibangun pada tahun 1879 oleh pemerintah kolonial Belanda di masa Raja Z.M. Willem III. Berfungsi vital sebagai penuntun navigasi bagi kapal-kapal di Selat Madura, mercusuar bersejarah ini tak hanya menjadi simbol maritim yang kokoh dengan 17 lantai tangga spiralnya, tetapi juga menawarkan panorama laut lepas yang menakjubkan dan sering menjadi daya tarik bagi pecinta sejarah serta fotografi, meskipun akses ke puncaknya mungkin terbatas.', '../uploads/denah/denah_12_684ec3d6cf8ab.jpg', 2500000, '1. Jangan lupa sunblock, topi, dan kacamata karena lokasi terbuka dan paparan angin laut.\r\n2. Gunakan sepatu yang kokoh dan tidak licin untuk kenyamanan saat mendaki dan menjelajahi area sekitar.'),
(13, 13, 2, 4, 'Labuhan Mangrove Educational Park 3D2N', '3 Hari 2 Malam', 4, 5, 3, 10, 'Labuhan Mangrove Educational Park adalah sebuah destinasi wisata edukatif yang terletak di Desa Labuhan, Kecamatan Sepulu, Kabupaten Bangkalan, Madura. Taman ini menawarkan pengalaman unik untuk mengenal keindahan alam ekosistem mangrove sekaligus memperluas pengetahuan tentang pentingnya konservasi lingkungan. Berawal dari bekas kawasan tambak yang kemudian diubah menjadi area konservasi mangrove, tempat ini dikembangkan menjadi taman pendidikan oleh Kelompok Tani Mangrove \"Cemara Sejahtera\" dengan dukungan dari PT. Pertamina Hulu Energi West Madura Offshore (PHE WMO).', '../uploads/denah/denah_13_684ec24965dfb.jpg', 2350000, 'Jangan lupa sunblock, topi, dan semprotan antinyamuk untuk kenyamanan saat menjelajah area terbuka dan lembap.'),
(14, 14, 3, 4, 'Pantai Rongkang 2D1N', '2 Hari 1 Malam', 3, 3, 4, 11, 'Pantai Rongkang adalah destinasi alami di Desa Kwanyar Barat, Bangkalan, Madura, yang terkenal dengan perpaduan unik antara hamparan pasir dan area berkarang eksotis sepanjang sekitar 1 km, disokong oleh bukit-bukit hijau setinggi 20-25 meter. Air lautnya yang jernih dan pemandangan matahari terbenam yang memukau menjadi daya tarik utama, di mana pengunjung juga bisa menikmati kelap-kelip lampu Kota Surabaya dari kejauhan. \r\n\r\nMeskipun fasilitasnya masih minim, keaslian dan keindahan alami Pantai Rongkang menjadikannya pilihan ideal bagi mereka yang mencari ketenangan dan spot fotografi unik, terutama saat senja.', '../uploads/denah/denah_14_684ec01504d05.jpg', 2650000, '1. Jangan lupa sunblock, topi, dan alas kaki yang nyaman/aman untuk eksplorasi pantai dan bebatuan.\r\n2. Fasilitas di Pantai Rongkang sangat minim, bawa semua kebutuhan dasar Anda.'),
(24, 8, 1, 2, 'Jakarta Heritage Tour: Monas & Kota Tua 1D', '1 Hari', 1, 2, 8, 4, 'Nikmati perjalanan sehari menyusuri jejak sejarah Jakarta melalui paket Jakarta Heritage Tour: Monas & Kota Tua, yang mengajak Anda mengunjungi Monumen Nasional (Monas) sebagai simbol perjuangan kemerdekaan Indonesia dan kawasan Kota Tua yang kaya akan bangunan kolonial bersejarah. Dalam tur ini, Anda akan diajak menjelajahi museum, menikmati pemandangan kota dari puncak Monas, berfoto dengan sepeda ontel klasik, serta mencicipi kuliner khas Betawi, semuanya dengan kenyamanan transportasi ber-AC, pemandu wisata berpengalaman, dan makan siang di restoran lokal yang telah disiapkan khusus untuk melengkapi pengalaman budaya dan sejarah Anda.', '../uploads/denah/denah_24_684ec883201a3.jpg', 750000, 'Termasuk tiket masuk Monas dan museum di Kota Tua. Makan siang disediakan.'),
(26, 16, 2, 4, 'Dermaga Rindu 1D', '1 Hari', 3, 4, 3, 12, 'Nikmati momen tak terlupakan dengan Paket Wisata Dermaga Rindu, sebuah perjalanan santai yang memadukan keindahan alam, suasana romantis, dan pengalaman lokal yang autentik. Dalam paket ini, Anda akan diajak menyusuri keindahan pantai dari atas perahu tradisional, menikmati matahari terbenam di atas dermaga, hingga bersantai di gazebo sambil ditemani kudapan khas pesisir. Tak hanya itu, paket juga mencakup sesi foto di spot Instagramable, live music akustik saat senja, serta kesempatan berinteraksi langsung dengan masyarakat sekitar yang ramah. Cocok untuk pasangan, keluarga, maupun solo traveler yang ingin meresapi ketenangan dan keindahan alam secara utuh.', '../uploads/denah/denah_26_684ec7c62d346.jpg', 1200000, 'Termasuk transportasi, tiket masuk, dan makan siang Bebek Sinjay.'),
(27, NULL, 1, 3, 'Surabaya City Explorer & Culinary Journey 3D2N', '3 Hari 2 Malam', 4, 2, 11, 1, 'Jelajahi sudut-sudut menarik kota Surabaya, dari situs bersejarah hingga pusat kuliner ternama. Dapatkan pengalaman otentik Kota Pahlawan.', '../uploads/denah/denah_27_684ed4ad906bc.webp', 1950000, 'Mengunjungi Tugu Pahlawan, House of Sampoerna, dan sentra kuliner. Akomodasi dan sarapan termasuk.'),
(35, 18, 1, 3, 'Monumen Kapal Selam 2D1N', '2 hari 1 Malam', 2, 1, 12, 9, 'Monumen Kapal Selam (Monkasel) adalah museum unik di Surabaya yang menampilkan kapal selam asli KRI Pasopati 410, salah satu armada TNI AL yang pernah bertugas pada masa Operasi Trikora. Terletak di pusat kota, Monkasel memberikan pengalaman menarik bagi pengunjung untuk masuk dan menjelajahi bagian dalam kapal selam, melihat ruang torpedo, ruang kendali, serta panel-panel asli yang masih terawat. \r\n\r\nTempat ini menjadi destinasi edukatif sekaligus rekreasi keluarga, karena menyuguhkan informasi sejarah maritim Indonesia dan teknologi militer dalam suasana interaktif yang jarang ditemukan di tempat lain.', '../uploads/denah/denah_35_684c43df000f5.jpg', 1750000, '1. Area luar Monkasel cukup terbuka dan panas di siang hari, jadi disarankan memakai sunblock dan topi.\n2. Pakai Sepatu Nyaman.\n3. Bawa botol air untuk menjaga tubuh tetap segar, dan jangan lupa kamera atau ponsel untuk mengabadikan momen unik di dalam kapal selam asli!\n'),
(36, 20, 2, 3, 'Kebun Binatang Surabaya 1D', '1 Hari', 1, 2, 11, 8, 'Nikmati liburan seru dan edukatif bersama keluarga melalui Paket Wisata Kebun Binatang Surabaya, salah satu kebun binatang tertua dan terlengkap di Asia Tenggara. Dalam perjalanan ini, Anda akan diajak mengenal lebih dari 200 spesies satwa, mulai dari mamalia, burung, hingga reptil yang berasal dari dalam maupun luar negeri. \r\n\r\nSelain melihat satwa, pengunjung juga dapat menikmati area rekreasi dan edukasi yang ramah anak, menjadikan tur ini cocok untuk keluarga, pelajar, dan pecinta alam. Paket sudah termasuk transportasi nyaman, tiket masuk, makan siang, serta pendamping wisata yang siap memberikan pengalaman menyenangkan dan informatif.', '../uploads/denah/denah_36_684ed45f13327.jpg', 1600000, '1. Gunakan pakaian dan alas kaki yang nyaman, serta bawa topi atau payung untuk perlindungan dari panas matahari saat berjalan keliling area.\r\n2. Tersedia area bermain anak, pusat oleh-oleh, toilet, dan tempat makan, sehingga cocok untuk wisata keluarga dan rombongan edukatif.\r\n'),
(37, 19, 1, 3, 'Monumen Nasional Tugu Pahlawan dan Museum 10 November 1D', '1 Hari', 4, 4, 12, 9, 'Paket wisata Monumen Nasional Tugu Pahlawan dan Museum 10 November mengajak Anda menyusuri jejak heroik perjuangan rakyat Surabaya dalam mempertahankan kemerdekaan Indonesia. Monumen Tugu Pahlawan yang ikonik menjulang sebagai simbol keberanian arek-arek Suroboyo, sementara di bawahnya Museum 10 November menyimpan berbagai koleksi dokumentasi sejarah, diorama, dan rekaman pidato Bung Tomo yang menggugah semangat. \r\n\r\nCocok untuk wisata edukatif, ziarah nasional, dan mengenalkan semangat nasionalisme kepada generasi muda dalam suasana yang khidmat dan inspiratif.', '../uploads/denah/denah_37_684ed42209be2.webp', 700000, '1. Tersedia ruang audio visual, diorama perjuangan, dan koleksi arsip sejarah. Pengunjung disarankan mengikuti tur pemandu untuk pemahaman yang lebih mendalam.\r\n2. Dilarang membuat kebisingan berlebihan dan menyentuh koleksi. '),
(38, 17, 2, 3, 'Surabaya Kota Lama 2D1N', '2 hari 1 Malam', 1, 1, 10, 8, 'Paket Wisata Surabaya Kota Lama mengajak Anda menjelajahi sisi historis kota melalui bangunan ikonik peninggalan kolonial seperti Jembatan Merah, Gedung Internatio, dan kawasan Kya-Kya Kembang Jepun yang dulunya merupakan pusat perdagangan penting. \r\n\r\nPerjalanan dilengkapi dengan kunjungan ke Museum House of Sampoerna untuk menyelami sejarah industri kretek Indonesia, serta menikmati kuliner legendaris khas Surabaya di tempat makan tempo dulu. Cocok untuk pecinta sejarah, edukasi budaya, maupun wisata santai bernuansa klasik.', '../uploads/denah/denah_38_684ed39cd62c4.jpg', 1500000, '1. Disarankan berangkat pagi hari untuk menghindari kemacetan dan cuaca panas saat menjelajahi area pejalan kaki.\r\n2. Gunakan alas kaki nyaman\r\n3. Spot foto klasik'),
(39, 24, 3, 5, 'Air Terjun Ahatan 2D1N', '2 hari 1 Malam', 2, 3, 14, 15, 'Nikmati pengalaman menyegarkan menjelajahi keindahan alam tersembunyi di Pamekasan melalui Paket Wisata Air Terjun Ahatan. Terletak di Dusun Ahatan, paket ini dirancang untuk kamu yang menyukai petualangan alam dengan suasana tenang dan asri. Perjalanan akan ditempuh dengan kendaraan nyaman menuju area perbukitan Pasean, dilanjutkan dengan jalan kaki singkat ke lokasi air terjun.\r\n\r\nPeserta akan disuguhi panorama hutan alami, aliran air jernih, serta kolam alami yang cocok untuk berendam atau bersantai. Paket ini sudah termasuk transportasi pulang-pergi, tiket masuk, makan siang lokal, serta pendamping wisata berpengalaman yang siap memandu dan menjaga keselamatan selama eksplorasi.', '../uploads/denah/denah_39_684ed0fb8349d.jpg', 2500000, '1. Harap menggunakan sepatu yang nyaman dan anti selip karena akses menuju air terjun melibatkan jalan tanah dan bebatuan.\r\n2. Disarankan membawa air minum sendiri, pakaian ganti, handuk, serta sunblock karena tidak tersedia fasilitas lengkap di area wisata.\r\n3. Jaga kebersihan & alam sekitar.\r\n'),
(40, 26, 2, 5, 'Bukit Kampung Toron Semalem 3D2N', '3 Hari 2 Malam', 3, 5, 13, 12, 'Paket Wisata Bukit Kampung Toron menawarkan pengalaman liburan alam yang menyegarkan di atas perbukitan indah Pamekasan, Madura. Terkenal dengan pemandangan lanskap hijau dan spot-spot foto Instagramable, Bukit Kampung Toron cocok untuk kamu yang ingin bersantai, menikmati udara segar, dan mengeksplorasi keindahan alam sambil berfoto ria. \r\n\r\nDalam paket ini, peserta akan diajak menikmati panorama bukit, menjelajahi area spot selfie, beristirahat di gazebo, hingga menikmati kuliner lokal khas Madura. Semua sudah termasuk transportasi, tiket masuk, makan siang, dan pemandu wisata lokal.', '../uploads/denah/denah_40_684ed05bc81a3.jpg', 2550000, '1. Gunakan topi dan sunblock\r\n2. Siapkan kamera atau ponsel dengan baterai penuh\r\n3. Jalur menuju spot-spot di bukit bisa berbatu dan menanjak, jadi disarankan menggunakan sepatu yang mendukung aktivitas outdoor ringan.'),
(41, 25, 1, 5, 'Goa Blaban 1D', '1 Hari', 4, 3, 15, NULL, 'Paket Wisata Goa Blaban menghadirkan petualangan alam yang menakjubkan di tengah perbukitan karst Pamekasan, Madura. Goa Blaban dikenal dengan stalaktit dan stalagmit alaminya yang eksotis, menjadikannya destinasi menarik bagi pecinta alam dan fotografi. Dalam paket ini, peserta akan dipandu menyusuri keindahan gua, mendapatkan informasi geologi dan sejarah lokal, serta menikmati panorama alam sekitar. \r\n\r\nTermasuk dalam paket: transportasi, tiket masuk, pemandu wisata, dokumentasi, dan sesi makan siang khas Madura, menjadikan perjalanan ini tak hanya edukatif, tapi juga menyenangkan.', '../uploads/denah/denah_41_684ef53a03439.jpg', 400000, '1. Medan gua lembap dan berbatu, disarankan memakai sepatu antiselip dan pakaian outdoor.\r\n2. Lampu senter/headlamp akan disediakan, namun peserta dianjurkan membawa cadangan penerangan pribadi jika perlu.\r\n3. Demi keselamatan dan kelancaran eksplorasi gua, seluruh peserta wajib mengikuti arahan pemandu'),
(42, 22, 1, 5, 'Panjat Tebing Gunung Labeng Waru 2D1N', '2 hari 1 Malam', 2, 1, 14, 15, 'Nikmati pengalaman menantang dan menyegarkan di alam terbuka melalui paket wisata panjat tebing Gunung Labeng Waru, Pamekasan. Selama dua hari satu malam, Anda akan diajak menaklukkan tebing batu kapur yang unik, menikmati keindahan panorama perbukitan Madura, serta bersantai dengan sajian kuliner khas di Depot Podomoro. \r\n\r\nDilengkapi dengan penginapan nyaman di New Ramayana Hotel dan pendamping profesional, paket ini cocok untuk Anda yang ingin berpetualang sekaligus menikmati nuansa lokal Madura. Cocok untuk solo traveler, keluarga, atau komunitas pecinta alam!', '../uploads/denah/denah_42_684ece67468e5.jpg', 900000, '1. Gunakan alas kaki anti-selip dan pakaian yang nyaman untuk aktivitas alam dan tebing.\r\n2. Lokasi Terbuka, Hindari Musim Hujan.\r\n'),
(43, 23, 1, 5, 'Pantai Batu Kerbuy 1D', '1 Hari', 2, 4, 13, NULL, 'Paket wisata Pantai Batu Kerbuy menawarkan pengalaman liburan yang menenangkan di pesisir utara Pamekasan, Madura, dengan panorama alam yang masih asri, batu-batu karang unik, dan ombak yang tenang. Dalam paket ini, pengunjung akan menikmati berbagai fasilitas seperti tiket masuk, pemandu wisata lokal, dokumentasi, serta kesempatan untuk bersantai, berenang, atau berburu spot foto menarik di tepi pantai. \r\n\r\nCocok untuk keluarga, pasangan, maupun rombongan, wisata ini juga dilengkapi kunjungan ke kuliner khas Madura, menjadikan perjalanan sehari Anda tidak hanya menyegarkan, tetapi juga berkesan.', '../uploads/denah/denah_43_684ef4c8191b8.jpg', 500000, '1. Bawa perlengkapan pribadi: seperti topi, sunblock, dan baju ganti untuk kenyamanan saat bermain di pantai.\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `pemandu_bahasa`
--

CREATE TABLE `pemandu_bahasa` (
  `id_pemandu_wisata` int NOT NULL,
  `id_bahasa` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pemandu_bahasa`
--

INSERT INTO `pemandu_bahasa` (`id_pemandu_wisata`, `id_bahasa`) VALUES
(1, 1),
(4, 1),
(1, 2),
(4, 2),
(1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `pemandu_wisata`
--

CREATE TABLE `pemandu_wisata` (
  `id_pemandu_wisata` int NOT NULL,
  `nama_pemandu` varchar(100) DEFAULT NULL,
  `id_lokasi` int DEFAULT NULL,
  `biodata` text,
  `harga` decimal(10,2) DEFAULT NULL,
  `pengalaman` text,
  `spesialisasi` varchar(255) DEFAULT NULL,
  `paket_tur_yang_ditawarkan` text,
  `ulasan` text,
  `foto_url` varchar(255) DEFAULT NULL,
  `telepon` varchar(25) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `rating` decimal(2,1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pemandu_wisata`
--

INSERT INTO `pemandu_wisata` (`id_pemandu_wisata`, `nama_pemandu`, `id_lokasi`, `biodata`, `harga`, `pengalaman`, `spesialisasi`, `paket_tur_yang_ditawarkan`, `ulasan`, `foto_url`, `telepon`, `email`, `rating`) VALUES
(1, 'Agus Setiawan', 2, 'Pemandu wisata enerjik dan berpengetahuan luas tentang sejarah dan budaya Jakarta. Lulusan Pariwisata UI.', '400000.00', '5 tahun memandu tur di Jakarta, spesialisasi tur sejarah Kota Tua dan museum.', 'Tur Sejarah, Museum, Kuliner Betawi', NULL, NULL, 'uploads/pemandu/pemandu_684e3cce859f47.12638575.png', '+6281234567890', 'putu.aditya1@example.com', '4.8'),
(2, 'Rina Amelia', 1, 'Pemandu lokal asli Lamongan, sangat mengenal destinasi alam dan kuliner tersembunyi. Ramah dan komunikatif.', '350000.00', '7 tahun memandu di Lamongan dan sekitarnya. Fokus pada wisata bahari dan religi.', 'Wisata Bahari Lamongan, Wisata Religi, Kuliner Lokal', NULL, NULL, 'uploads/pemandu/pemandu_684e3c77edf8e1.12087792.jpg', '+6281298765432', 'rina@example.com', '4.9'),
(3, 'David Lee', 4, 'Pemandu multibahasa (Indonesia, Inggris, Mandarin), berpengalaman dengan turis mancanegara. Menguasai budaya Madura.', '500000.00', '6 tahun memandu di Madura, khususnya Bangkalan. Ahli dalam menjelaskan tradisi dan kerajinan lokal.', 'Tur Budaya Madura, Kerajinan Batik, Mercusuar', NULL, NULL, 'uploads/pemandu/pemandu_684e3d427af203.25980799.png', '+6281122334455', 'david@example.com', '4.7'),
(4, 'Siti Fatimah', 3, 'Pemandu wisata berpengalaman di Surabaya dengan fokus pada tur kuliner dan sejarah kota pahlawan.', '380000.00', '4 tahun memandu di Surabaya, spesialisasi kuliner malam dan spot foto instagramable.', 'Kuliner Surabaya, Tur Sejarah, Spot Instagramable', NULL, NULL, 'uploads/pemandu/pemandu_684e3da263b075.53291865.png', '085171743947', 'siti1@gmail.com', '4.6');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int NOT NULL,
  `id_pemesanan` int NOT NULL,
  `kode_pemesanan_lama` varchar(50) DEFAULT NULL,
  `metode_pembayaran` varchar(100) DEFAULT NULL,
  `status_pembayaran` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pemesanan`
--

CREATE TABLE `pemesanan` (
  `id_pemesanan` int NOT NULL,
  `kode_pemesanan` varchar(50) NOT NULL,
  `id_paket_wisata` int DEFAULT NULL,
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `no_telepon` varchar(20) DEFAULT NULL,
  `no_ktp` varchar(50) DEFAULT NULL,
  `alamat` text,
  `tanggal_keberangkatan` date DEFAULT NULL,
  `jumlah_peserta` int DEFAULT NULL,
  `catatan_tambahan` text,
  `total_harga` decimal(12,2) DEFAULT '0.00',
  `status_pemesanan` varchar(50) DEFAULT 'pending',
  `tanggal_pemesanan` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `payment_method` varchar(50) DEFAULT NULL,
  `midtrans_transaction_id` varchar(100) DEFAULT NULL,
  `gross_amount_paid` decimal(12,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pemesanan`
--

INSERT INTO `pemesanan` (`id_pemesanan`, `kode_pemesanan`, `id_paket_wisata`, `nama_lengkap`, `email`, `no_telepon`, `no_ktp`, `alamat`, `tanggal_keberangkatan`, `jumlah_peserta`, `catatan_tambahan`, `total_harga`, `status_pemesanan`, `tanggal_pemesanan`, `payment_method`, `midtrans_transaction_id`, `gross_amount_paid`) VALUES
(1, 'GT-E0C276C6BD', 42, 'intan aulia majid', 'intan@gmail.com', '085706472290', '4002783654982376', 'Jl.Raya karanggeneng, Kecamatan Karanggeneng, Kabupaten Lamongan, Jawa Timur', '2025-06-28', 1, NULL, '360000.00', 'completed', '2025-06-15 08:25:35', 'bank_transfer', 'e09a4dcd-d220-43f7-882d-cea534d6fec5', '360000.00'),
(2, 'GT-D156FDE9B7', 40, 'intan aulia majid', 'intan@gmail.com', '085706472290', '4002783654982376', 'Jl.karanggeneng', '2025-06-30', 1, NULL, '510000.00', 'cancelled', '2025-06-15 08:29:19', NULL, NULL, NULL),
(3, 'GT-B11467BE7C', 14, 'nur linda a', 'hahaah@gmail.com', '087678875432', '2345634987523452', 'jl. raya telang no 29 bangkalan jawa timur', '2025-06-29', 1, NULL, '2650000.00', 'completed', '2025-06-15 12:23:52', 'bank_transfer', '765c8ae7-c46f-446c-a562-03723babe372', '1560000.00'),
(4, 'GT-78224AAEFB', 24, 'faiqo noril laili', 'faiqo@gmail.com', '087877363663', '1723565346620004', 'jl. lagoa gg 1 c1 no 9 rt 003 rw 02 kelurahan lagoa kecamatan koja jakarta utara dki jakarta', '2025-06-30', 1, NULL, '750000.00', 'cancelled', '2025-06-15 13:43:54', 'qris', '09854232-41e8-43c7-abf9-b29e9d1fab2c', '1160000.00'),
(5, 'GT-48B491BFC3', 10, 'intan aulia majid', 'intan@gmail.com', '085706472290', '4002783654982376', 'lamongan', '2025-06-19', 1, NULL, '1310000.00', 'completed', '2025-06-16 02:13:04', 'qris', '91fbd1b2-d7ad-4f0d-aa9b-f5a5708a78bc', '1310000.00'),
(6, 'GT-B1D2D2E662', 42, 'faiqo noril laili', 'faiqo@gmail.com', '087877363663', '3172612546720004', 'jl. lafgoa gg1 c1 no 09 rt 003 rw 02 kelurahan lagoa kecamatan koja jakarta utara dki jakarta', '2025-06-25', 1, NULL, '710000.00', 'cancelled', '2025-06-16 04:33:19', 'qris', 'eba793ff-f0c0-4652-b6ed-793c68e67d91', '710000.00'),
(7, 'GT-653E8521AB', 38, 'faiqo noril laili', 'faiqo234@gmail.com', '087877363663', '1234567812345678', 'jl. raya telag bangkalan jawa timur', '2025-06-30', 1, NULL, '960000.00', 'completed', '2025-06-16 04:54:49', 'bank_transfer', '583f6302-6f17-4c20-9c95-c1344151053b', '960000.00'),
(8, 'GT-76A336EF5D', 43, 'intan aulia majid', 'intan@gmail.com', '085706472290', '4002783654982376', 'huhuhuhuhuhu', '2025-06-19', 1, NULL, '660000.00', 'cancelled', '2025-06-17 12:32:06', NULL, NULL, NULL),
(9, 'GT-69D984AC05', 39, 'intan aulia majid', 'intan@gmail.com', '085706472290', '4002783654982376', 'jkbjbhjb', '2025-06-19', 1, NULL, '710000.00', 'completed', '2025-06-17 12:37:42', 'bank_transfer', '78d25102-912b-461d-bdf3-84dca26e42c4', '710000.00'),
(10, 'GT-811F2EE0D2', 42, 'intan aulia majid', 'intan@gmail.com', '085706472290', '4002783654982376', 'jkbhasbdhsa', '2025-06-19', 1, NULL, '710000.00', 'cancelled', '2025-06-17 12:44:25', NULL, NULL, NULL),
(11, 'GT-6760076FE0', 43, 'intan aulia majid', 'intan@gmail.com', '085706472290', '4002783654982376', 'aslkfnklafn', '2025-06-19', 1, 'dsakmdlksa', '660000.00', 'cancelled', '2025-06-17 12:45:16', NULL, NULL, NULL),
(12, 'GT-40419F4968', 43, 'intan aulia majid', 'intan@gmail.com', '085706472290', '4002783654982376', 'asdsad', '2025-06-19', 1, NULL, '660000.00', 'cancelled', '2025-06-17 13:05:07', 'qris', '8be52291-61c0-4e54-a364-9b0ebfb5c0a3', '660000.00'),
(13, 'GT-8610A313CF', 9, 'intan aulia majid', 'intan@gmail.com', '085706472290', '4002783654982376', 'sumberwudi karanggeneng lamongan', '2025-06-20', 1, NULL, '3210000.00', 'pending', '2025-06-17 13:44:10', 'qris', '5be72731-57c9-4dfb-be6f-b5a399c43f73', '3210000.00');

-- --------------------------------------------------------

--
-- Table structure for table `pengunjung`
--

CREATE TABLE `pengunjung` (
  `id_pengunjung` int NOT NULL,
  `nama_depan` varchar(50) DEFAULT NULL,
  `nama_belakang` varchar(50) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `no_tlp` varchar(20) DEFAULT NULL,
  `deskripsi` text,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pengunjung`
--

INSERT INTO `pengunjung` (`id_pengunjung`, `nama_depan`, `nama_belakang`, `username`, `email`, `no_tlp`, `deskripsi`, `password`, `avatar`, `last_login`) VALUES
(6, 'intan', 'aulia', 'intanaulia', 'intan@gmail.com', '081357742408', '', '$2y$10$H07vQu9RcZsmOeAOi2BlwuUQN4ne57MjMPNQZWELbxdpxZsmrTUuS', './uploads/avatars/avatar_6_68431ea02bb93.jpg', '2025-06-17 20:49:27'),
(8, 'javier', 'saviola', 'javier97', 'javiersaviola97@gmail.com', NULL, NULL, '$2y$10$bt4MV0bxch2icbVvMyGza.yPigVqCp4BuvEInYv2k6fn1Z94I7Ao6', 'default_avatar.png', NULL),
(9, 'Faiqo ', 'Noril Laili', 'Faiqo NL', 'faiqo@gmail.com', NULL, NULL, '$2y$10$gIh4K7BfSRRgDCU9OR/gk.N.bwvnMAFZVhQixn.aK/bnsfzqegIm6', './uploads/avatars/avatar_9_684f9a6709ac5.jpeg', '2025-06-18 23:35:17'),
(10, 'intan', 'a', 'm', 'y@gmail.com', '', 'hh', '$2y$10$TRVl1CaDA04KlqLZaNcH5.7JRFOl.VEBqIYssK56ahIMyfU/ys2Ui', './uploads/avatars/avatar_10_684fafef493de.jpg', '2025-06-16 12:40:08');

-- --------------------------------------------------------

--
-- Table structure for table `pertanyaan`
--

CREATE TABLE `pertanyaan` (
  `id_pertanyaan` int NOT NULL,
  `isi_pertanyaan` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rencana_perjalanan`
--

CREATE TABLE `rencana_perjalanan` (
  `id_rencana_perjalanan` int NOT NULL,
  `hari` int NOT NULL,
  `perjalanan` varchar(255) NOT NULL,
  `id_paket` int NOT NULL,
  `jam` varchar(255) NOT NULL,
  `deskripsi_perjalanan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `rencana_perjalanan`
--

INSERT INTO `rencana_perjalanan` (`id_rencana_perjalanan`, `hari`, `perjalanan`, `id_paket`, `jam`, `deskripsi_perjalanan`) VALUES
(1, 1, 'Check-in Hotel Santika Jakarta', 1, '07:00', 'Tiba di hotel, proses check-in dan penyerahan kunci kamar. Sarapan pagi di restoran hotel.'),
(2, 1, 'Perjalanan ke Ancol', 1, '09:50', 'Berangkat menuju Ancol Taman Impian dengan transportasi yang telah disediakan.'),
(4, 1, 'Dunia Fantasi (Dufan)', 1, '10:00 - 12:30', 'Menjelajahi berbagai wahana seru di Dunia Fantasi seperti Halilintar, Niagara Gulungan, dan Istana Boneka.'),
(5, 1, 'Makan Siang - Bandar Djakarta', 1, '12:30 - 13:30', 'Menikmati hidangan seafood segar di Restoran Bandar Djakarta yang terkenal dengan cita rasa autentik.'),
(6, 1, 'SeaWorld & Ocean Dream Samudra', 1, '13:30 - 15:30', 'Mengunjungi SeaWorld untuk melihat berbagai biota laut dan menyaksikan pertunjukan lumba-lumba yang memukau.\r\n\r\n'),
(7, 1, 'Atlantis Water Adventure', 1, '15:30 - 17:30', 'Bersenang-senang di waterpark dengan berbagai kolam renang dan seluncuran air yang menyegarkan.'),
(8, 1, 'Makan Malam - Pantai Ancol', 1, '18:00 - 19:00', 'Menikmati makan malam buffet sambil menyaksikan pemandangan matahari terbenam di pantai.'),
(9, 1, 'Kembali ke Hotel', 1, '20:00', 'Kembali ke hotel untuk istirahat dan mempersiapkan kegiatan hari berikutnya.'),
(10, 2, 'Sarapan di Hotel', 1, '07:00 - 08:00', 'Menikmati sarapan buffet di restoran hotel dengan menu lengkap dan bergizi.'),
(11, 2, 'Wahana Bebas Pilihan', 1, '08:00 - 10:00', 'Waktu bebas untuk menikmati wahana favorit atau mengunjungi tempat yang belum dikunjungi.'),
(12, 2, 'Shopping & Oleh-oleh', 1, '10:00 - 11:00', 'Berbelanja cinderamata dan oleh-oleh khas Jakarta di area Ancol.'),
(13, 2, 'Kembali ke hotel & Melakukan Check-out', 1, '11:00 - 12:00', 'Perjalanan kembali ke hotel dan melakukan check-out.'),
(14, 1, 'Tiba di Lamongan & Check-in Hotel', 2, '14:00', 'Tiba di Lamongan, proses check-in di Arfina Residence Syariah Lamongan. Istirahat sejenak.'),
(15, 1, 'Makan Siang', 2, '15:00', 'Makan siang di Restoran Sunan Drajat Lamongan atau restoran lokal terdekat.'),
(16, 1, 'Kunjungan ke Indonesian Islamic Art Museum', 2, '16:00 - 18:00', 'Mengunjungi dan menjelajahi koleksi di Indonesian Islamic Art Museum, memahami seni dan sejarah Islam di Indonesia.'),
(17, 1, 'Makan Malam', 2, '19:00', 'Makan malam di area sekitar museum atau kembali ke hotel.'),
(18, 2, 'Sarapan & Check-out', 2, '08:00 - 09:00', 'Sarapan pagi di hotel dan proses check-out.'),
(19, 2, 'Kunjungan Lanjutan/Belanja Oleh-oleh (Opsional)', 2, '09:30 - 11:00', 'Waktu bebas untuk kunjungan singkat lainnya atau belanja oleh-oleh khas Lamongan.'),
(20, 2, 'Persiapan Kembali', 2, '11:30', 'Persiapan untuk kembali atau melanjutkan perjalanan berikutnya.'),
(21, 1, 'Tiba di Jakarta & Check-in Hotel', 3, '14:00', 'Tiba di Jakarta, proses check-in di The Langham Jakarta. Istirahat.'),
(22, 1, 'Makan Siang', 3, '15:00', 'Makan siang di Soto Betawi H. Ma’ruf Jakarta atau restoran di sekitar hotel.'),
(23, 1, 'Acara Bebas Sore Hari', 3, '16:30', 'Waktu bebas untuk bersantai di hotel atau menjelajahi area sekitar.'),
(24, 1, 'Makan Malam', 3, '19:00', 'Makan malam di restoran hotel atau pilihan kuliner Jakarta lainnya.'),
(25, 2, 'Sarapan di Hotel', 3, '08:00', 'Sarapan pagi di The Langham Jakarta.'),
(26, 2, 'Kunjungan ke Jakarta Aquarium & Safari', 3, '09:30 - 13:00', 'Menjelajahi keindahan bawah laut dan satwa di Jakarta Aquarium & Safari.'),
(27, 2, 'Makan Siang', 3, '13:00 - 14:00', 'Makan siang di area Neo Soho Mall atau sekitar Jakarta Aquarium.'),
(28, 2, 'Lanjutan Eksplorasi atau Belanja', 3, '14:30 - 17:00', 'Melanjutkan eksplorasi Jakarta Aquarium atau waktu bebas untuk berbelanja.'),
(29, 2, 'Makan Malam', 3, '19:00', 'Makan malam, menikmati kuliner malam Jakarta.'),
(30, 3, 'Sarapan & Check-out', 3, '08:00 - 10:00', 'Sarapan pagi di hotel dan proses check-out.'),
(31, 3, 'Belanja Oleh-oleh', 3, '10:30 - 12:00', 'Waktu untuk membeli oleh-oleh khas Jakarta.'),
(32, 3, 'Persiapan Kembali', 3, '12:30', 'Persiapan untuk kembali atau melanjutkan perjalanan berikutnya.'),
(40, 1, 'Tiba di Jakarta & Check-in Hotel', 5, '14:00', 'Tiba di Jakarta, proses check-in di Hotel Santika Jakarta.'),
(41, 1, 'Makan Siang', 5, '15:00', 'Makan siang di Gado-Gado Bonbin Cikini atau restoran terdekat.'),
(42, 1, 'Kunjungan ke Museum Nasional Indonesia', 5, '16:00 - 18:30', 'Menjelajahi koleksi sejarah dan budaya di Museum Nasional Indonesia (Museum Gajah).'),
(43, 1, 'Makan Malam', 5, '19:30', 'Makan malam di area Cikini atau kembali ke hotel.'),
(44, 2, 'Sarapan & Check-out', 5, '08:00 - 09:30', 'Sarapan pagi di hotel dan proses check-out.'),
(45, 2, 'Kunjungan Tambahan/Belanja (Opsional)', 5, '10:00 - 11:30', 'Waktu bebas untuk mengunjungi tempat lain atau belanja oleh-oleh.'),
(46, 2, 'Persiapan Kembali', 5, '12:00', 'Persiapan untuk kembali atau melanjutkan perjalanan.'),
(47, 1, 'Tiba di Lamongan & Check-in Hotel', 6, '14:00', 'Tiba di area Paciran, Lamongan, check-in di Hotel Boegenviel Syariah Lamongan.'),
(48, 1, 'Menuju Pantai Lorena', 6, '15:30', 'Perjalanan menuju Pantai Lorena.'),
(49, 1, 'Menikmati Pantai Lorena & Sunset', 6, '16:00 - 18:00', 'Bersantai, bermain air, dan menikmati pemandangan matahari terbenam di Pantai Lorena.'),
(50, 1, 'Makan Malam', 6, '19:00', 'Makan malam di Restoran Sunan Drajat Lamongan atau warung seafood sekitar pantai.'),
(51, 2, 'Sarapan & Check-out', 6, '08:00 - 09:00', 'Sarapan pagi di hotel dan proses check-out.'),
(52, 2, 'Eksplorasi Pagi di Pantai (Opsional)', 6, '09:30 - 11:00', 'Kesempatan untuk menikmati suasana pagi di Pantai Lorena atau mengunjungi pantai terdekat lainnya.'),
(53, 2, 'Persiapan Kembali', 6, '11:30', 'Persiapan untuk kembali atau melanjutkan perjalanan.'),
(54, 1, 'Tiba di Lamongan & Check-in Resort', 7, '14:00', 'Tiba di area Paciran, check-in di Tanjung Kodok Beach Resort Lamongan.'),
(55, 1, 'Menuju Pantai Putri Klayar', 7, '15:30', 'Perjalanan menuju Pantai Putri Klayar.'),
(56, 1, 'Menikmati Pantai Putri Klayar', 7, '16:00 - 18:00', 'Bersantai, menikmati keindahan alam, pasir putih, dan deretan pohon bakau.'),
(57, 1, 'Makan Malam', 7, '19:00', 'Makan malam di Taman Kuliner Paciran (TKP) Lamongan atau restoran resort.'),
(58, 2, 'Sarapan & Menikmati Sunrise (Opsional)', 7, '06:00 - 08:00', 'Sarapan pagi, kesempatan menikmati matahari terbit di pantai.'),
(59, 2, 'Check-out', 7, '09:00 - 10:00', 'Proses check-out dari resort.'),
(60, 2, 'Kunjungan Tambahan/Oleh-oleh', 7, '10:30 - 11:30', 'Waktu untuk mengunjungi tempat menarik lain atau membeli oleh-oleh.'),
(61, 2, 'Persiapan Kembali', 7, '12:00', 'Persiapan untuk kembali atau melanjutkan perjalanan.'),
(62, 1, 'Tiba di Jakarta & Check-in Hotel', 8, '14:00', 'Tiba di Jakarta, check-in di The Langham Jakarta atau hotel dekat TMII.'),
(63, 1, 'Makan Siang', 8, '15:00', 'Makan siang di restoran sekitar hotel.'),
(64, 1, 'Kunjungan Awal TMII (Zona Terdekat)', 8, '16:00 - 18:00', 'Pengenalan awal TMII, mengunjungi beberapa anjungan atau museum terdekat dari pintu masuk.'),
(65, 1, 'Makan Malam', 8, '19:00', 'Makan malam di area TMII atau kembali ke hotel.'),
(66, 2, 'Sarapan di Hotel', 8, '08:00', 'Sarapan pagi di hotel.'),
(67, 2, 'Eksplorasi TMII (Anjungan Daerah & Museum)', 8, '09:30 - 13:00', 'Mengunjungi berbagai anjungan daerah, museum (Museum Indonesia, Museum Purna Bhakti Pertiwi, dll).'),
(68, 2, 'Makan Siang di TMII', 8, '13:00 - 14:00', 'Makan siang di salah satu restoran yang tersedia di dalam area TMII.'),
(69, 2, 'Lanjutan Eksplorasi TMII (Kereta Gantung, Wahana)', 8, '14:30 - 17:30', 'Menikmati pemandangan dari kereta gantung, mengunjungi taman burung, atau wahana lainnya.'),
(70, 2, 'Makan Malam', 8, '19:00', 'Makan malam, mencoba kuliner khas Jakarta.'),
(71, 3, 'Sarapan & Check-out', 8, '08:00 - 09:30', 'Sarapan pagi di hotel dan proses check-out.'),
(72, 3, 'Kunjungan Terakhir TMII/Belanja Oleh-oleh', 8, '10:00 - 12:00', 'Mengunjungi bagian TMII yang belum sempat dikunjungi atau membeli oleh-oleh khas dari berbagai daerah Indonesia.'),
(73, 3, 'Persiapan Kembali', 8, '12:30', 'Persiapan untuk kembali atau melanjutkan perjalanan berikutnya.'),
(74, 1, 'Tiba di Lamongan & Check-in Hotel', 9, '14:00', 'Tiba di Lamongan, check-in di Arfina Residence Syariah Lamongan.'),
(75, 1, 'Makan Siang', 9, '15:00', 'Makan siang di Depot Asih Jaya Lamongan atau restoran lokal.'),
(76, 1, 'Kunjungan ke Maharani Zoo & Goa (MZG)', 9, '16:00 - 18:30', 'Menjelajahi keunikan Goa Maharani dan melihat koleksi satwa di kebun binatang.'),
(77, 1, 'Makan Malam', 9, '19:30', 'Makan malam di area sekitar WBL/MZG atau kembali ke hotel.'),
(78, 2, 'Sarapan di Hotel', 9, '08:00', 'Sarapan pagi di hotel.'),
(79, 2, 'Wisata Bahari Lamongan (WBL) - Sesi 1', 9, '09:30 - 13:00', 'Menikmati berbagai wahana permainan air dan atraksi di WBL.'),
(80, 2, 'Makan Siang di WBL', 9, '13:00 - 14:00', 'Makan siang di salah satu food court atau restoran di dalam area WBL.'),
(81, 2, 'Wisata Bahari Lamongan (WBL) - Sesi 2', 9, '14:30 - 17:30', 'Melanjutkan menikmati wahana atau bersantai di pantai area WBL.'),
(82, 2, 'Makan Malam', 9, '19:00', 'Makan malam, mencoba kuliner khas Lamongan.'),
(83, 3, 'Sarapan & Check-out', 9, '08:00 - 09:30', 'Sarapan pagi di hotel dan proses check-out.'),
(84, 3, 'Belanja Oleh-oleh Khas Lamongan', 9, '10:00 - 11:30', 'Waktu untuk membeli oleh-oleh khas Lamongan seperti wingko babat atau souvenir lainnya.'),
(85, 3, 'Persiapan Kembali', 9, '12:00', 'Persiapan untuk kembali atau melanjutkan perjalanan.'),
(86, 1, 'Tiba di Babat/Lamongan & Check-in Hotel', 10, '14:00', 'Tiba di area Babat, Lamongan, check-in di Hotel Boegenviel Syariah Lamongan atau penginapan terdekat.'),
(87, 1, 'Makan Siang', 10, '15:00', 'Makan siang di restoran lokal.'),
(88, 1, 'Menuju Gunung Pegat & Eksplorasi', 10, '16:00 - 18:00', 'Perjalanan menuju Gunung Pegat, menikmati pemandangan, trekking ringan, dan mempelajari mitos setempat.'),
(89, 1, 'Makan Malam', 10, '19:00', 'Makan malam di area Babat atau kembali ke hotel.'),
(90, 2, 'Sarapan & Check-out', 10, '08:00 - 09:00', 'Sarapan pagi di hotel dan proses check-out.'),
(91, 2, 'Kunjungan Tambahan/Belanja Oleh-oleh (Opsional)', 10, '09:30 - 11:00', 'Waktu bebas untuk kunjungan singkat lainnya atau belanja oleh-oleh.'),
(92, 2, 'Persiapan Kembali', 10, '11:30', 'Persiapan untuk kembali atau melanjutkan perjalanan.'),
(93, 1, 'Tiba di Bangkalan & Check-in Hotel', 11, '14:00', 'Tiba di Bangkalan, check-in di Hotel Prima Sejahtera Bangkalan.'),
(94, 1, 'Makan Siang Khas Madura', 11, '15:00', 'Makan siang, mencoba Bebek Sinjay atau kuliner khas Madura lainnya.'),
(95, 1, 'Menuju Pantai Pasir Putih Tlangoh', 11, '16:00 - 18:30', 'Menikmati keindahan pantai, bermain air, ATV (opsional), dan menunggu sunset.'),
(96, 1, 'Makan Malam Seafood', 11, '19:30', 'Makan malam di Suramadu Resto & Cafe Bangkalan atau warung seafood sekitar pantai.'),
(97, 2, 'Sarapan & Check-out', 11, '08:00 - 09:30', 'Sarapan pagi di hotel dan proses check-out.'),
(98, 2, 'Belanja Oleh-oleh Khas Madura', 11, '10:00 - 11:30', 'Membeli oleh-oleh seperti batik Madura, camilan khas, atau kerajinan tangan.'),
(99, 2, 'Persiapan Kembali', 11, '12:00', 'Persiapan untuk kembali atau melanjutkan perjalanan.'),
(100, 1, 'Tiba di Bangkalan & Check-in Hotel', 12, '14:00', 'Tiba di Bangkalan, check-in di Rose Hotel Bangkalan.'),
(101, 1, 'Makan Siang', 12, '15:00', 'Makan siang di Rumah Makan Lesehan Seafood Madurasa Bangkalan.'),
(102, 1, 'Kunjungan ke Mercusuar Sembilangan', 12, '16:00 - 18:00', 'Mengunjungi Mercusuar Sembilangan, menikmati arsitektur bersejarah dan pemandangan laut.'),
(103, 1, 'Makan Malam', 12, '19:00', 'Makan malam di area Socah atau kembali ke kota Bangkalan.'),
(104, 2, 'Sarapan & Check-out', 12, '08:00 - 09:00', 'Sarapan pagi di hotel dan proses check-out.'),
(105, 2, 'Kunjungan Budaya (Opsional)', 12, '09:30 - 11:00', 'Mengunjungi sentra batik atau situs budaya lainnya di Bangkalan.'),
(106, 2, 'Persiapan Kembali', 12, '11:30', 'Persiapan untuk kembali atau melanjutkan perjalanan.'),
(107, 1, 'Tiba di Bangkalan & Check-in Hotel', 13, '14:00', 'Tiba di Bangkalan, check-in di Hotel Ningrat Bangkalan.'),
(108, 1, 'Makan Siang', 13, '15:00', 'Makan siang, mencoba Warung Bebek Sinjay Bangkalan.'),
(109, 1, 'Perkenalan Area Sekitar Hotel', 13, '16:30', 'Waktu bebas untuk bersantai atau menjelajahi area sekitar hotel.'),
(110, 1, 'Makan Malam', 13, '19:00', 'Makan malam di restoran lokal.'),
(111, 2, 'Sarapan di Hotel', 13, '08:00', 'Sarapan pagi di hotel.'),
(112, 2, 'Kunjungan ke Labuhan Mangrove Educational Park', 13, '09:30 - 13:00', 'Eksplorasi taman mangrove, belajar tentang ekosistem dan konservasi, menikmati jalur trekking.'),
(113, 2, 'Makan Siang di Area Mangrove/Lokal', 13, '13:00 - 14:00', 'Makan siang di warung sekitar Labuhan atau kembali ke kota.'),
(114, 2, 'Aktivitas Tambahan (Opsional)', 13, '14:30 - 17:00', 'Mengunjungi desa sekitar atau kembali ke hotel untuk istirahat.'),
(115, 2, 'Makan Malam', 13, '19:00', 'Makan malam, menikmati kuliner Madura.'),
(116, 3, 'Sarapan & Check-out', 13, '08:00 - 09:30', 'Sarapan pagi di hotel dan proses check-out.'),
(117, 3, 'Belanja Oleh-oleh Khas Bangkalan', 13, '10:00 - 11:30', 'Membeli oleh-oleh khas Bangkalan.'),
(118, 3, 'Persiapan Kembali', 13, '12:00', 'Persiapan untuk kembali atau melanjutkan perjalanan.'),
(119, 1, 'Tiba di Bangkalan & Check-in Hotel', 14, '14:00', 'Tiba di Bangkalan, check-in di Hotel Prima Sejahtera Bangkalan.'),
(120, 1, 'Makan Siang', 14, '15:00', 'Makan siang di Rumah Makan Lesehan Seafood Madurasa Bangkalan.'),
(121, 1, 'Menuju Pantai Rongkang & Menikmati Sunset', 14, '16:30 - 18:30', 'Perjalanan ke Pantai Rongkang, menikmati keindahan pantai berkarang, bukit hijau, dan pemandangan matahari terbenam.'),
(122, 1, 'Makan Malam dengan Pemandangan', 14, '19:30', 'Makan malam di warung sekitar Pantai Rongkang atau kembali ke area Kwanyar.'),
(123, 2, 'Sarapan & Check-out', 14, '08:00 - 09:00', 'Sarapan pagi di hotel dan proses check-out.'),
(124, 2, 'Eksplorasi Pagi (Opsional)', 14, '09:30 - 11:00', 'Kesempatan untuk mengunjungi area lain di Kwanyar atau membeli oleh-oleh.'),
(125, 2, 'Persiapan Kembali', 14, '11:30', 'Persiapan untuk kembali atau melanjutkan perjalanan.'),
(126, 1, 'Penjemputan & Menuju Monas', 24, '08:00', 'Peserta dijemput di lokasi yang telah ditentukan (hotel/meeting point). Perjalanan menuju Monumen Nasional.'),
(127, 1, 'Kunjungan ke Monumen Nasional (Monas)', 24, '09:00 - 11:30', 'Mengunjungi Monas, melihat diorama sejarah di Museum Sejarah Nasional, dan naik ke pelataran puncak untuk menikmati panorama Jakarta.'),
(128, 1, 'Makan Siang Khas Betawi', 24, '12:00 - 13:00', 'Menikmati makan siang dengan hidangan khas Betawi, misalnya Soto Betawi H. Ma’ruf (sesuai info paket).'),
(129, 1, 'Eksplorasi Kawasan Kota Tua Jakarta', 24, '13:30 - 16:30', 'Mengunjungi area Kota Tua, termasuk Museum Fatahillah (Museum Sejarah Jakarta), Pelabuhan Sunda Kelapa (opsional, melihat suasana), dan spot foto menarik lainnya.'),
(130, 1, 'Kembali & Tur Selesai', 24, '17:00', 'Kembali ke meeting point awal atau lokasi pengantaran yang disepakati. Tur selesai.'),
(139, 1, 'Penjemputan & Menuju Mercusuar Sembilangan', 26, '08:30', 'Peserta dijemput di lokasi yang telah ditentukan. Perjalanan menuju Desa Sembilangan, Bangkalan.'),
(140, 1, 'Kunjungan ke Mercusuar Sembilangan', 26, '10:00 - 12:00', 'Mengunjungi dan menjelajahi Mercusuar Sembilangan yang bersejarah, menikmati arsitektur kolonial dan pemandangan laut dari area sekitar mercusuar.'),
(141, 1, 'Makan Siang Bebek Sinjay', 26, '12:30 - 13:30', 'Menikmati makan siang dengan hidangan khas Madura yang terkenal, Bebek Sinjay (termasuk dalam paket).'),
(142, 1, 'Kunjungan Budaya Madura (Opsional)', 26, '14:00 - 16:00', 'Mengunjungi pusat kerajinan batik Madura di Tanjungbumi atau Museum Cakraningrat untuk mengenal lebih dalam budaya Bangkalan (jika waktu dan kondisi memungkinkan, tiket masuk opsional mungkin berlaku).'),
(143, 1, 'Kembali & Tur Selesai', 26, '16:30', 'Perjalanan kembali ke titik penjemputan awal. Tur selesai.'),
(144, 1, 'Tiba di Surabaya & Check-in Hotel', 27, '13:00 - 14:00', 'Tiba di Surabaya, menuju Swiss-Belinn Tunjungan Surabaya untuk proses check-in. Istirahat sejenak.'),
(145, 1, 'Makan Siang', 27, '14:00 - 15:00', 'Makan siang di restoran sekitar hotel atau mencoba Ayam Bakar Primarasa (sesuai preferensi/detail paket).'),
(146, 1, 'Kunjungan ke Tugu Pahlawan & Museum Sepuluh Nopember', 27, '15:30 - 17:30', 'Mengunjungi Tugu Pahlawan dan Museum Sepuluh Nopember untuk mempelajari sejarah perjuangan Surabaya.'),
(147, 1, 'Wisata Kuliner Malam Surabaya', 27, '19:00', 'Menjelajahi sentra kuliner malam Surabaya untuk makan malam, mencicipi berbagai hidangan khas (biaya pribadi atau sesuai detail paket). Kembali ke hotel.'),
(148, 2, 'Sarapan di Hotel', 27, '07:30 - 08:30', 'Sarapan pagi di Swiss-Belinn Tunjungan Surabaya (termasuk dalam paket).'),
(149, 2, 'Kunjungan ke House of Sampoerna', 27, '09:00 - 11:00', 'Mengunjungi House of Sampoerna, melihat museum sejarah rokok dan proses pembuatan rokok kretek tangan.'),
(150, 2, 'Jelajah Area Kota Tua Surabaya & Oleh-oleh', 27, '11:30 - 13:00', 'Mengunjungi area Jembatan Merah atau Kya Kya Kembang Jepun (opsional), serta mencari oleh-oleh khas Surabaya.'),
(151, 2, 'Makan Siang', 27, '13:00 - 14:00', 'Makan siang di restoran lokal pilihan (biaya pribadi atau sesuai detail paket).'),
(152, 2, 'Check-out & Tur Selesai', 27, '14:30', 'Kembali ke hotel untuk proses check-out. Tur berakhir, pengantaran ke bandara/stasiun atau titik akhir yang disepakati.'),
(153, 1, 'Tiba di Pamekasan & Check-in Hotel', 42, '13:00-14:00', 'Tiba di Pamekasan (melalui terminal/bandara terdekat), menuju New Ramayana Hotel untuk proses check-in dan beristirahat sejenak'),
(163, 1, 'Makan Siang di Depot Podomoro', 42, '14:00 – 15:00', 'Menikmati makan siang di Depot Podomoro, yang terkenal dengan menu khas seperti sop empal dan empal goreng yang empuk dan lezat'),
(164, 1, 'Kegiatan Panjat Tebing di Gunung Labeng Waru', 42, '15:30 – 17:30', 'Menuju lokasi panjat tebing di Gunung Labeng Waru. Kegiatan dimulai dengan briefing keselamatan dan pengenalan medan, dilanjutkan dengan panjat tebing di tebing batu kapur yang menantang, sambil menikmati pemandangan alam Madura yang eksotis.'),
(165, 1, 'Kuliner Malam', 42, '19:00 - 19:30', 'Menikmati kuliner malam khas Madura, seperti sate laler atau nasi jagung, di warung lokal sekitar kota'),
(166, 1, 'Kembali ke Hotel', 42, '20:00 - 20:30', 'Kembali ke hotel untuk istirahat malam.'),
(167, 2, 'Sarapan Pagi di Hotel', 42, ' 07:00 – 08:00', 'Sarapan di restoran hotel (termasuk dalam paket), sambil menikmati suasana pagi kota Pamekasan.'),
(168, 2, 'Trekking Ringan di Sekitar Labeng Waru', 42, '08:30 – 10:00', 'Melakukan trekking ringan di area perbukitan sekitar Gunung Labeng Waru, mengabadikan pemandangan alam, serta mengenal ekosistem dan batuan karst khas Madura.'),
(169, 2, 'Wisata Oleh-oleh Khas Pamekasan', 42, '10:30 – 11:30', 'Mengunjungi pusat oleh-oleh seperti batik tulis Madura, makanan khas, dan souvenir lokal di pusat kota.'),
(170, 2, 'Makan Siang di Depot Podomoro', 42, '12:00 – 13:00', 'Kembali menikmati makan siang di Depot Podomoro, mencoba menu lain seperti nasi campur atau iga penyet, yang juga menjadi favorit pengunjung '),
(171, 2, 'Check-out & Tur Selesai', 42, '13:30 - 14:00', 'Kembali ke New Ramayana Hotel untuk proses check-out.'),
(172, 1, 'Check-in di Hotel Odaita Pamekasan', 43, '08:00 - 08:30', 'Peserta melakukan check-in di Hotel Odaita, briefing singkat, dan persiapan keberangkatan menggunakan kendaraan Toyota Innova.'),
(173, 1, 'Perjalanan menuju Pantai Batu Kerbuy', 43, '08:30 - 10:00', 'Menikmati perjalanan sambil melihat pemandangan khas Madura menuju lokasi wisata.'),
(174, 1, 'Eksplorasi Pantai Batu Kerbuy', 43, '10:00 - 12:00', 'Bermain pasir, berenang, berfoto di spot-spot batu karang unik, dan menikmati suasana pantai yang asri.'),
(175, 1, 'Makan Siang di Sewindu Café & Resto', 43, '12:00 - 13:30', 'Menikmati hidangan khas Madura dan menu favorit di restoran yang nyaman.'),
(176, 1, 'Kunjungan kuliner lokal atau waktu bebas di sekitar pantai', 43, '13:30 - 15:00', 'Menjelajahi kuliner tradisional atau santai sebelum kembali.'),
(177, 1, 'Perjalanan kembali ke Pamekasan', 43, '15:00 - 16:30', 'Kembali ke hotel dengan kendaraan Innova.'),
(178, 1, 'Check-in dan istirahat di Hotel Odaita Pamekasan', 43, '16:30 - 17:00', 'Peserta bisa mandi, ganti pakaian, dan beristirahat.'),
(179, 1, 'Paket wisata selesai', 43, '17:00 - 17:30', 'Paket Wisata selesai dan bisa meninggalkan hotel.'),
(180, 1, 'Titik Kumpul & Persiapan', 41, '07:30 – 08:00', 'Peserta berkumpul di Hotel Odaita Pamekasan. Briefing singkat dan persiapan perjalanan menggunakan Elf Long.'),
(181, 1, 'Perjalanan menuju Goa Blaban', 41, '08:00 – 09:30', 'Menikmati perjalanan menyusuri perbukitan dan pedesaan menuju lokasi Goa Blaban di Kecamatan Batu Marmar.'),
(182, 1, 'Eksplorasi Goa Blaban', 41, '09:30 – 11:30', 'Menjelajah gua bersama pemandu lokal. Menyusuri lorong-lorong alami, melihat formasi batu kapur, dan mendengarkan penjelasan sejarah serta geologi gua.'),
(183, 1, 'Makan Siang di Mie Gacoan Pamekasan', 41, '11:30 – 13:00', 'Istirahat makan siang dengan menu pilihan favorit khas Mie Gacoan (sudah termasuk dalam paket).'),
(184, 1, 'Waktu Bebas', 41, '13:00 – 14:00', 'Kegiatan bebas seperti belanja oleh-oleh khas Pamekasan atau kuliner ringan di sekitar kota.'),
(185, 1, 'Kembali ke Hotel Odaita Pamekasan', 41, '14:00 – 15:30', 'Perjalanan santai kembali ke hotel untuk beristirahat.'),
(186, 1, 'Day Use Hotel Odaita (Tanpa Menginap)', 41, '15:30 – 17:00', 'Penggunaan kamar hotel untuk mandi, ganti pakaian, dan istirahat ringan setelah seharian beraktivitas.'),
(187, 1, 'paket wisata selesai', 41, '17:00 - 17:30 ', 'paket wisata selesai dan bisa meninggalkan hotel.'),
(189, 1, 'Check-in dan penjemputan', 40, '09:00 – 10:00', 'Check-in dan penjemputan di rose hotelbangkalan menggunakan mobil alphard'),
(190, 1, 'Kunjungan ke Masjid Agung Bangkalan & Alun-alun Kota', 40, '10:00 – 12:00', 'Menjelajahi pusat kota Bangkalan dan menikmati arsitektur masjid bersejarah serta suasana alun-alun.'),
(191, 1, 'Makan Siang di Sewindu Café & Resto', 40, '12:00 – 13:30', 'Menikmati makan siang khas Madura dengan suasana nyaman dan estetik.'),
(193, 1, 'Istirahat', 40, '14:00 – 15:00', 'istirahat singkat di rose hotel bintang tiga yang nyaman dan strategis.'),
(194, 1, 'Kunjungan ke Bukit Jaddih', 40, '16:00 – 17:30', 'Melihat pemandangan bukit kapur yang unik dan danau biru yang fotogenik.'),
(195, 1, 'Makan malam di hotel', 40, '19:00 – 20:30', 'Pilihan makan malam sesuai preferensi peserta atau kembali bersantai di hotel.'),
(196, 2, 'Sarapan di hotel', 40, '07:00 – 08:00', 'Sarapan di restoran hotel (termasuk dalam paket), sambil menikmati suasana pagi kota Pamekasan.'),
(197, 2, 'Kunjungan ke Arosbaya Limestone Hills (Batu Kapur Arosbaya)', 40, '08:00 – 10:00', 'Menikmati keindahan pahatan alam dan sejarah batu kapur yang menjadi warisan budaya.'),
(198, 2, 'Explore Bukit Pelalangan', 40, '10:30 – 12:00', 'Spot foto populer dengan lanskap alami khas Madura.'),
(199, 2, 'Makan Siang di Sewindu Café & Resto', 40, '12:00 – 13:30', 'Istirahat dan makan siang dengan suasana modern klasik dan menu khas Madura.'),
(200, 2, 'Berbelanja oleh-oleh khas Bangkalan', 40, '14:00 – 16:00', 'Mengunjungi pusat batik tulis Madura, makanan ringan, dan kerajinan lokal.'),
(202, 2, 'Makan malam ', 40, '16:00 – 17:30', 'Makan malam di rose hotel'),
(203, 2, 'Istirahat', 40, '19:00 - selesai', 'Istirahat di rose hotel.'),
(204, 3, 'Sarapan Pagi di Hotel', 40, '07:00 – 08:00', 'Sarapan di restoran hotel (termasuk dalam paket), sambil menikmati suasana pagi kota Pamekasan.'),
(205, 3, 'Kunjungan ke Pantai Siring Kemuning', 40, '08:00 – 10:00', 'Menikmati suasana pantai pasir putih yang tenang dan cocok untuk bersantai.'),
(206, 3, 'Singgah di Jembatan Suramadu ', 40, '10:30 – 11:30', 'Foto-foto atau sekadar menikmati panorama jembatan penghubung pulau.'),
(207, 3, 'Makan siang', 40, '12:00 – 13:30', 'Makan Siang Penutup di Sewindu Café & Resto'),
(208, 3, 'Check-out & Tur Selesai', 40, '14:00 – 15:00', 'Tour selesai dan melakukan check-out hotel '),
(209, 1, 'Check-in', 39, '07:00 – 08:00', 'Check-in dan penjemputan di  new ramayana hotel menggunakan kendaraan elf long'),
(210, 1, 'Perjalanan ke Air Terjun Ahatan', 39, '08:00 – 10:30', 'Perjalanan menuju Dusun Ahatan, Kecamatan Pasean. '),
(211, 1, 'Eksplorasi & Aktivitas di Air Terjun Ahatan', 39, '10:30 – 12:00', 'Menikmati panorama air terjun, berendam, dan sesi foto alam bebas. Aktivitas dipandu oleh tour leader/pemandu lokal.'),
(212, 1, 'Makan Siang di Depot Podomoro', 39, '12:30 – 13:30', 'Menikmati makan siang dengan menu khas Madura seperti soto, rawon, atau nasi campur.'),
(213, 1, 'Istirahat', 39, '14:00 – 15:30', 'Istirahat di new ramayana hotel'),
(214, 1, 'Kegiatan bebas', 39, '16:00 - 17:00', 'Kegiatan bebas menikmati suasana hotel dan sekitarnya.'),
(215, 1, 'Makan Malam', 39, '17:30 – 18:30', 'Makan malam di depot podomoro Pamekasan.'),
(216, 1, 'Istirahat', 39, '19:00 - selesai', 'Kembali ke hotel dan istirahat '),
(217, 2, 'Sarapan di Hotel (termasuk dalam paket)', 39, '07:00 – 08:00', 'Sarapan pagi di New Ramayana Hotel.'),
(218, 2, 'Kunjungan ke Batik Tulis Klampar & Pusat Oleh-oleh Pamekasan', 39, '08:00 – 10:00', 'Melihat proses pembuatan batik tulis khas Madura, lalu belanja oleh-oleh.'),
(219, 2, 'Kunjungan Singkat ke Arek Lancor / Taman Monumen Pamekasan', 39, '10:30 – 11:30', 'Berfoto dan menikmati suasana taman kota sebelum perjalanan pulang.'),
(220, 2, 'Makan Siang Penutup di Depot Podomoro', 39, '12:00 – 13:00', 'Makan siang terakhir bersama peserta trip.'),
(221, 2, 'Check-out', 39, '13:30 – 15:00', 'Kembali ke hotel dan bisa meninggalkan hotel (check-out)'),
(222, 1, 'Check-in ', 38, '08:00 – 09:00', 'Check-in di hotel swiss-belinn tunjungan surabaya dengan kendaraan hiace commuter'),
(223, 1, 'Kunjungan ke Museum House of Sampoerna', 38, '09:00 – 11:00', 'Menyaksikan sejarah industri kretek, arsitektur kolonial, dan pameran interaktif.'),
(224, 1, 'Makan Siang di Resto Desoemantra 1910', 38, '11:30 – 13:00', 'Menikmati suasana tempo dulu dengan menu khas Jawa dan hidangan tradisional.'),
(225, 1, 'Wisata Belanja & Oleh-oleh', 38, '13:30 – 15:00', 'Berhenti di pusat oleh-oleh khas Surabaya (almond crispy, kerupuk udang, sambal Bu Rudy, dll).'),
(226, 1, 'Istirahat', 38, '17:00 – 18:00', 'Waktu istirahat dan bersantai di hotel.'),
(227, 1, 'Menikmati kuliner malam', 38, '19:00 – 20:00', 'Jelajah kuliner malam di sekitar Tunjungan atau Tunjungan Plaza.'),
(228, 1, 'Istirahat', 38, '21:00 - selesai', 'Kembali ke hotel dan istirahat'),
(229, 2, 'Sarapan di hotel', 38, '07:00 – 08:00', 'Sarapan di restoran hotel (termasuk dalam paket), sambil menikmati suasana pagi kota Pamekasan.'),
(230, 2, 'Kunjungan ke Tugu Pahlawan & Museum Sepuluh Nopember', 38, '08:30 – 10:00', 'Mengenal lebih dekat sejarah perjuangan arek-arek Suroboyo.'),
(231, 2, 'Waktu bebas', 38, '10:30 – 11:30', 'Waktu bebas dan dokumentasi.'),
(232, 2, 'Makan siang penutup', 38, '12:00 – 13:00', 'Makan iang sekaligus penutup di Resto Desoemantra 1910.'),
(233, 2, 'Check-out', 38, '13:30 – 14:30', 'Kembali ke hotel dan melakukan check-out'),
(234, 1, 'check-in dan penjemputan', 37, '07:30 – 08:00', 'Check-in dan penjemputan di My Studio Hotel Surabaya'),
(235, 1, 'Kunjungan ke Museum 10 November & Tugu Pahlawan', 37, '08:30 – 10:00', 'Menyaksikan monumen perjuangan rakyat Surabaya dan diorama sejarah pertempuran 10 November 1945.'),
(236, 1, 'House of Sampoerna', 37, '10:30 – 12:00', 'Melihat proses pembuatan rokok kretek secara tradisional, menjelajah museum kolonial, dan menikmati suasana bangunan tempo dulu.'),
(237, 1, 'Makan Siang di Sky 36 Restaurant Surabaya', 37, '12:30 – 14:00', 'Makan siang dengan panorama kota dari ketinggian. Menyajikan menu lokal dan internasional dengan suasana elegan.'),
(238, 1, 'Wisata oleh-oleh di Pasar Genteng / Pusat Oleh-Oleh Khas Surabaya', 37, '14:30 – 15:30', 'Berbelanja kerupuk udang, sambal Bu Rudy, almond crispy, dan camilan khas lainnya.'),
(239, 1, 'Foto Stop di Patung Suro & Boyo + Taman Surabaya', 37, '16:00 – 17:00', 'Berfoto di ikon kota dan taman kota untuk menutup perjalanan.'),
(240, 1, 'Check-out', 37, '17:30 - 18:00', 'Kembali ke My Studio Hotel dan melakukan check-out.'),
(241, 1, 'Check-in & Penjemputan', 36, '07:30 – 08:00', 'Penjemputan peserta di Swiss-Belinn Tunjungan Surabaya, dilanjutkan dengan briefing singkat sebelum keberangkatan.'),
(242, 1, 'Kunjungan ke Kebun Binatang Surabaya', 36, '08:30 – 11:00', 'Menjelajahi Kebun Binatang Surabaya yang kaya akan koleksi satwa lokal dan mancanegara. Nikmati pengalaman edukatif dan menyenangkan, cocok untuk semua usia.'),
(243, 1, 'Makan Siang di Ayam Bakar Primarasa', 36, '11:30 – 13:00', 'Santap siang dengan menu khas Jawa Timur seperti ayam bakar, sambal, dan lalapan segar di salah satu restoran legendaris Surabaya.'),
(244, 1, 'Wisata Belanja Oleh-Oleh di Pasar Genteng', 36, '13:30 – 14:30', 'Berbelanja oleh-oleh khas Surabaya seperti kerupuk, sambal, dan makanan ringan favorit wisatawan.'),
(245, 1, 'Foto Stop di Patung Suro & Boyo + Taman Bungkul', 36, '15:00 – 16:00', 'Berfoto di ikon kota Surabaya serta bersantai di taman kota yang asri dan ramah keluarga.'),
(246, 1, 'Kembali ke Hotel & Check-out', 36, '16:30 – 17:00', 'Perjalanan kembali ke Swiss-Belinn Tunjungan, istirahat sejenak, dan check-out untuk menutup wisata sehari penuh yang berkesan.');

-- --------------------------------------------------------

--
-- Table structure for table `termasuk_paket`
--

CREATE TABLE `termasuk_paket` (
  `id_termasuk_paket` int NOT NULL,
  `termasuk` varchar(255) NOT NULL,
  `harga_komponen` decimal(12,2) DEFAULT '0.00' COMMENT 'Harga untuk komponen paket ini',
  `id_paket` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `termasuk_paket`
--

INSERT INTO `termasuk_paket` (`id_termasuk_paket`, `termasuk`, `harga_komponen`, `id_paket`) VALUES
(1, 'Penginapan 1 Malam (Mercure Convention Center Ancol)', '450000.00', 1),
(2, 'Transportasi AC (Toyota Hiace/Bus)', '150000.00', 1),
(3, '3x Makan (Sarapan, Siang, Malam)', '150000.00', 1),
(4, 'Tiket Masuk Semua Wahana', '500000.00', 1),
(5, 'Tour Guide Berpengalaman', '100000.00', 1),
(6, 'Minuman & Snack', '25000.00', 1),
(7, 'Dokumentasi Foto', '50000.00', 1),
(8, 'Asuransi Perjalanan', '15000.00', 1),
(9, 'Penginapan 1 Malam (Arfina Residence Syariah Lamongan)', '350000.00', 2),
(10, 'Transportasi Lokal (Mobil)', '150000.00', 2),
(11, 'Makan 2x Sehari', '150000.00', 2),
(12, 'Tiket Masuk Indonesian Islamic Art Museum', '200000.00', 2),
(13, 'Pemandu Wisata Museum', '150000.00', 2),
(14, 'Asuransi Perjalanan Dasar', '50000.00', 2),
(15, 'Penginapan 1 Malam (Hotel Arfina Lamongan)', '350000.00', 2),
(16, 'Transportasi (Hiace Commuter)', '200000.00', 2),
(17, 'Makan 4x (2x Sarapan, 1x Siang, 1x Malam)', '200000.00', 2),
(18, 'Tiket Masuk Indonesian Islamic Art Museum', '100000.00', 2),
(19, 'Jasa Pemandu (Rina Amelia)', '350000.00', 2),
(20, 'Asuransi Perjalanan', '50000.00', 2),
(21, 'Penginapan 2 Malam (The Langham Jakarta)', '3000000.00', 3),
(22, 'Transportasi (Hiace Commuter)', '500000.00', 3),
(23, 'Makan 6x (Sesuai Program)', '450000.00', 3),
(24, 'Tiket Masuk Jakarta Aquarium & Safari', '250000.00', 3),
(25, 'Jasa Pemandu (Agus Setiawan)', '400000.00', 3),
(26, 'Asuransi Perjalanan', '50000.00', 3),
(27, 'Akomodasi Penginapan 1 Malam (Lamongan)', '350000.00', 2),
(28, 'Transportasi Lokal Selama Tur', '200000.00', 2),
(29, 'Makan Sesuai Program (2D1N)', '200000.00', 2),
(30, 'Tiket Masuk Indonesian Islamic Art Museum', '100000.00', 2),
(31, 'Jasa Pemandu Wisata Lokal', '100000.00', 2),
(32, 'Asuransi Perjalanan Dasar', '50000.00', 2),
(33, 'Akomodasi Penginapan 2 Malam (Jakarta)', '1800000.00', 3),
(34, 'Transportasi Lokal Selama Tur (3 Hari)', '600000.00', 3),
(35, 'Makan Sesuai Program (3D2N)', '500000.00', 3),
(36, 'Tiket Masuk Jakarta Aquarium & Safari', '250000.00', 3),
(37, 'Jasa Pemandu Wisata Profesional', '300000.00', 3),
(38, 'Asuransi Perjalanan', '50000.00', 3),
(39, 'Akomodasi Penginapan 1 Malam (Jakarta)', '200000.00', 4),
(40, 'Transportasi Publik/Hemat', '50000.00', 4),
(41, 'Makan Sesuai Program (2D1N)', '150000.00', 4),
(42, 'Tiket Masuk Monumen Nasional & Museum', '50000.00', 4),
(43, 'Jasa Pemandu Wisata (Opsional/Grup)', '50000.00', 4),
(44, 'Asuransi Perjalanan Dasar', '50000.00', 4),
(45, 'Penginapan 1 Malam (Hotel Santika Jakarta)', '470000.00', 5),
(46, 'Transportasi Lokal Nyaman', '300000.00', 5),
(47, 'Makan Sesuai Program (Termasuk 1x Makan Istimewa)', '300000.00', 5),
(48, 'Tiket Masuk Museum Nasional Indonesia', '100000.00', 5),
(49, 'Jasa Pemandu (Rina Amelia)', '350000.00', 5),
(50, 'Asuransi Perjalanan', '50000.00', 5),
(51, 'Penginapan 1 Malam (Hotel Boegenviel Syariah Lamongan)', '400000.00', 6),
(52, 'Transportasi Lokal (Motor/Mobil Sewa Sederhana)', '100000.00', 6),
(53, 'Makan Sederhana Sesuai Program', '100000.00', 6),
(54, 'Retribusi Masuk Pantai Lorena', '50000.00', 6),
(55, 'Perlengkapan Snorkeling Dasar (Jika Ada)', '50000.00', 6),
(56, 'Asuransi Perjalanan Dasar', '50000.00', 6),
(57, 'Penginapan 1 Malam (Tanjung Kodok Beach Resort Lamongan )', '750000.00', 7),
(58, 'Transportasi Pribadi Selama Tur', '400000.00', 7),
(59, 'Makan Seafood & Lokal (2D1N)', '350000.00', 7),
(60, 'Aktivitas Pantai & Perahu (Jika Ada)', '100000.00', 7),
(62, 'Asuransi Perjalanan', '50000.00', 7),
(63, 'Penginapan 2 Malam (The Langham Jakarta)', '3000000.00', 8),
(64, 'Transportasi Selama 3 Hari', '600000.00', 8),
(65, 'Makan Sesuai Program (3D2N)', '500000.00', 8),
(66, 'Tiket Masuk TMII & Beberapa Wahana Pilihan', '250000.00', 8),
(68, 'Asuransi Perjalanan', '50000.00', 8),
(69, 'Penginapan 2 Malam (Arfina Residence Syariah Lamongan)', '700000.00', 9),
(70, 'Transportasi Selama 3 Hari (Lamongan Area)', '700000.00', 9),
(71, 'Makan Sesuai Program (3D2N)', '600000.00', 9),
(72, 'Tiket Terusan WBL dan Maharani Zoo & Goa', '800000.00', 9),
(74, 'Asuransi Perjalanan', '50000.00', 9),
(75, 'Penginapan 1 Malam (Hotel Boegenviel Syariah Lamongan)', '400000.00', 10),
(76, 'Transportasi Lokal', '200000.00', 10),
(77, 'Makan Sesuai Program', '200000.00', 10),
(78, 'Perlengkapan Trekking Ringan & Air Mineral', '50000.00', 10),
(79, 'Jasa Pemandu (Agus Setiawan)', '400000.00', 10),
(80, 'Asuransi Perjalanan Dasar', '50000.00', 10),
(81, 'Penginapan 1 Malam (Hotel Prima Sejahtera Bangkalan)', '400000.00', 11),
(82, 'Transportasi Lokal (Umum/Sewa Motor)', '80000.00', 11),
(83, 'Makan Lokal Sederhana (2D1N)', '100000.00', 11),
(84, 'Retribusi Masuk Pantai Tlangoh', '20000.00', 11),
(85, 'Sewa ATV (Opsional/Sebagian)', '50000.00', 11),
(86, 'Asuransi Perjalanan Dasar', '50000.00', 11),
(87, 'Penginapan 1 Malam (Rose Hotel Bangkalan )', '300000.00', 12),
(88, 'Transportasi Pribadi Selama Tur', '500000.00', 12),
(89, 'Makan Sesuai Program (Termasuk Seafood)', '400000.00', 12),
(90, 'Donasi/Retribusi Mercusuar & Area Sekitar', '50000.00', 12),
(91, 'Jasa Pemandu (Rina Amelia)', '350000.00', 12),
(92, 'Asuransi Perjalanan', '50000.00', 12),
(93, 'Penginapan 2 Malam (Hotel Ningrat Bangkalan)', '1200000.00', 13),
(94, 'Transportasi Lokal Selama 3 Hari', '500000.00', 13),
(95, 'Makan Sesuai Program (Fokus Kuliner Lokal)', '400000.00', 13),
(96, 'Donasi & Program Edukasi Mangrove', '200000.00', 13),
(97, 'Jasa Pemandu (Siti Fatimah)', '380000.00', 13),
(98, 'Asuransi Perjalanan', '50000.00', 13),
(99, 'Penginapan 1 Malam (Hotel Prima Sejahtera Bangkalan)', '400000.00', 14),
(100, 'Transportasi (Elf Long)', '500000.00', 14),
(101, 'Makan Eksklusif (Termasuk Sunset Dinner)', '450000.00', 14),
(102, 'Retribusi & Akses Pantai Rongkang', '50000.00', 14),
(103, 'Jasa Pemandu (David Lee)', '500000.00', 14),
(104, 'Asuransi Perjalanan Premium', '50000.00', 14),
(105, 'Transportasi (Avanza)', '200000.00', 24),
(106, 'Tiket Masuk (Monas & Museum Kota Tua)', '150000.00', 24),
(107, 'Makan Siang (Kuliner Khas Betawi)', '100000.00', 24),
(108, 'Pemandu Wisata (Agus Setiawan)', '250000.00', 24),
(109, 'Asuransi Perjalanan', '50000.00', 24),
(110, 'Penginapan 1 Malam (Tanjung Kodok Beach Resort Lamongan ★★★★★)', '750000.00', 25),
(111, 'Transportasi (Hiace Commuter)', '500000.00', 25),
(112, 'Tiket Masuk Terusan (WBL & Maharani Zoo)', '700000.00', 25),
(113, 'Makan (1x Sarapan, 1x Makan Malam)', '400000.00', 25),
(114, 'Pemandu Wisata (Rina Amelia)', '350000.00', 25),
(115, 'Asuransi Perjalanan', '50000.00', 25),
(116, 'Transportasi (Innova)', '400000.00', 26),
(117, 'Tiket Masuk (Mercusuar Sembilangan)', '100000.00', 26),
(118, 'Makan Siang (Bebek Sinjay)', '150000.00', 26),
(119, 'Pemandu Wisata (David Lee)', '500000.00', 26),
(120, 'Asuransi Perjalanan', '50000.00', 26),
(122, 'Transportasi (Avanza)', '400000.00', 27),
(123, 'Makan (1x Sarapan, 1x Kuliner Malam)', '350000.00', 27),
(124, 'Tiket Masuk (Tugu Pahlawan & House of Sampoerna)', '120000.00', 27),
(126, 'Jasa Pemandu (Siti Fatimah)', '380000.00', 27),
(127, 'Penginapan 2 Malam (Hotel Santika Jakarta)', '940000.00', 27),
(128, 'Jasa Pemandu (Agus Setiawan)', '400000.00', 29),
(129, 'Penginapan 1 Malam (Odaita Hotel Pamekasan ★★★★)', '0.00', 29),
(130, 'Jasa Pemandu (Agus Setiawan)', '400000.00', 30),
(131, 'Penginapan 1 Malam (Odaita Hotel Pamekasan ★★★★)', '0.00', 30),
(132, 'Jasa Pemandu (Agus Setiawan)', '400000.00', 31),
(133, 'Penginapan 1 Malam (Tanjung Kodok Beach Resort Lamongan ★★★★★)', '750000.00', 31),
(134, 'termasuk makan batu', '100000.00', 31),
(135, 'Jasa Pemandu (Agus Setiawan)', '400000.00', 32),
(136, 'Jasa Pemandu (Rina Amelia)', '350000.00', 33),
(137, 'Penginapan 2 Malam (Odaita Hotel Pamekasan ★★★★)', '0.00', 33),
(138, 'Jasa Pemandu (Rina Amelia)', '350000.00', 9),
(139, 'Jasa Pemandu (David Lee)', '500000.00', 26),
(140, 'Jasa Pemandu (David Lee)', '500000.00', 34),
(141, 'Penginapan 2 Malam (Hotel Majapahit Surabaya ★★★★★)', '800000.00', 34),
(142, 'Jasa Pemandu (Rina Amelia)', '350000.00', 35),
(143, 'Penginapan 1 Malam (My Studio Hotel Surabaya ★★★★★)', '0.00', 35),
(144, 'Jasa Pemandu (Agus Setiawan)', '400000.00', 36),
(145, 'Jasa Pemandu (Siti Fatimah)', '380000.00', 37),
(146, 'Jasa Pemandu (Agus Setiawan)', '400000.00', 38),
(147, 'Penginapan 1 Malam (Swiss-Belinn Tunjungan Surabaya )', '550000.00', 38),
(148, 'Jasa Pemandu (Rina Amelia)', '350000.00', 39),
(149, 'Penginapan 1 Malam (New Ramayana Hotel Pamekasan)', '350000.00', 39),
(150, 'Jasa Pemandu (David Lee)', '500000.00', 40),
(151, 'Penginapan 2 Malam (Rose Hotel Bangkalan )', '600000.00', 40),
(152, 'Jasa Pemandu (Rina Amelia)', '350000.00', 25),
(153, 'Jasa Pemandu (Agus Setiawan)', '400000.00', 24),
(154, 'Jasa Pemandu (Siti Fatimah)', '380000.00', 41),
(155, 'Jasa Pemandu (Rina Amelia)', '350000.00', 42),
(156, 'Penginapan 1 Malam (New Ramayana Hotel Pamekasan)', '350000.00', 42),
(157, 'Jasa Pemandu (Rina Amelia)', '350000.00', 43),
(158, 'Jasa Pemandu (David Lee)', '500000.00', 6),
(159, 'Jasa Pemandu (Rina Amelia)', '350000.00', 11),
(160, 'Jasa Pemandu (David Lee)', '500000.00', 8),
(161, 'Jasa Pemandu (Rina Amelia)', '350000.00', 1),
(164, 'Kendaraan (Innova)', '200000.00', 43),
(165, 'Kuliner 1 Hari (Sewindu Cafe & Resto Pamekasan)', '100000.00', 43),
(166, 'Kendaraan (Elf Long)', '500000.00', 41),
(167, 'Kuliner 1 Hari (Mie Gacoan Pamekasan)', '35000.00', 41);

-- --------------------------------------------------------

--
-- Table structure for table `tips_berkunjung`
--

CREATE TABLE `tips_berkunjung` (
  `id_tips_berkunjung` int NOT NULL,
  `id_wisata` int NOT NULL,
  `tip_text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tips_berkunjung`
--

INSERT INTO `tips_berkunjung` (`id_tips_berkunjung`, `id_wisata`, `tip_text`) VALUES
(1, 1, 'Kenakan pakaian renang yang nyaman'),
(2, 1, 'Gunakan tabir surya'),
(3, 1, 'Bawa kacamata hitam'),
(4, 2, 'Siapkan perlengkapan snorkeling Anda'),
(5, 2, 'Sewa perahu untuk eksplorasi pulau'),
(6, 3, 'Ambil banyak foto'),
(7, 3, 'Hormati artefak sejarah'),
(8, 4, 'Bawa kamera'),
(9, 4, 'Siapkan fisik untuk trekking ringan'),
(10, 5, 'Datang pagi untuk menghindari keramaian'),
(11, 5, 'Coba semua wahana air'),
(12, 6, 'Sewa pakaian adat tradisional'),
(13, 6, 'Kunjungi museum di pagi hari'),
(14, 7, 'Ambil tur berpemandu'),
(15, 7, 'Pelajari sejarah di balik setiap artefak'),
(16, 8, 'Kunjungi Monas saat senja'),
(17, 8, 'Naik ke puncak untuk pemandangan kota'),
(18, 9, 'Bawa makanan ringan'),
(19, 9, 'Jangan lewatkan pertunjukan hewan'),
(20, 10, 'Datang lebih awal untuk menghindari antrean'),
(21, 10, 'Kenakan pakaian dan alas kaki yang nyaman'),
(22, 11, 'Nikmati pemandangan matahari terbenam'),
(23, 11, 'Cicipi kuliner khas Madura'),
(24, 12, 'Siapkan kamera'),
(25, 12, 'Kunjungi saat cuaca cerah'),
(26, 13, 'Ikuti jalur trekking'),
(27, 13, 'Ambil banyak foto'),
(28, 14, 'Nikmati matahari terbenam'),
(29, 14, 'Bawa perlengkapan piknik');

-- --------------------------------------------------------

--
-- Table structure for table `ulasan`
--

CREATE TABLE `ulasan` (
  `id_ulasan` int NOT NULL,
  `id_wisata` int DEFAULT NULL,
  `id_pengunjung` int DEFAULT NULL,
  `rating` int DEFAULT NULL,
  `komentar` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `ulasan`
--

INSERT INTO `ulasan` (`id_ulasan`, `id_wisata`, `id_pengunjung`, `rating`, `komentar`) VALUES
(1, 16, 6, 5, 'Wisata bagus sekali'),
(2, 24, 6, 5, 'bagussss'),
(3, 24, 10, 5, 'woww');

-- --------------------------------------------------------

--
-- Table structure for table `ulasan_kuliner`
--

CREATE TABLE `ulasan_kuliner` (
  `id_kuliner` int NOT NULL,
  `ulasan` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ulasan_pemandu`
--

CREATE TABLE `ulasan_pemandu` (
  `id_ulasan_pemandu` int NOT NULL,
  `id_pemandu_wisata` int NOT NULL,
  `id_pengunjung` int DEFAULT NULL,
  `nama_pengulas` varchar(100) DEFAULT NULL,
  `rating` tinyint NOT NULL COMMENT 'Rating dari 1 sampai 5',
  `komentar` text,
  `tanggal_ulasan` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `ulasan_pemandu`
--

INSERT INTO `ulasan_pemandu` (`id_ulasan_pemandu`, `id_pemandu_wisata`, `id_pengunjung`, `nama_pengulas`, `rating`, `komentar`, `tanggal_ulasan`) VALUES
(1, 1, 6, 'Intan Aulia', 5, 'Mas Agus sangat informatif dan sabar menjelaskan sejarah Kota Tua. Tur jadi sangat menyenangkan!', '2025-06-01 03:00:00'),
(2, 1, NULL, 'Michael B.', 4, 'Good tour guide, knowledgeable. Helped us find great local food too.', '2025-05-28 07:30:00'),
(3, 2, 6, 'Intan Aulia', 5, 'Mbak Rina asli Lamongan, jadi tau banget tempat-tempat bagus yang belum banyak orang tau. Seru banget!', '2025-06-02 04:00:00'),
(4, 2, NULL, 'Ahmad Prasetyo', 5, 'Pelayanannya sangat memuaskan, Mbak Rina sangat ramah dan menguasai materi wisata di Lamongan. Recommended!', '2025-06-03 08:00:00'),
(5, 3, NULL, 'Mr. Chen', 5, 'David was an excellent guide for our group. His Mandarin is fluent and he explained Madurese culture very well. Highly recommended.', '2025-05-30 09:00:00'),
(6, 3, 6, 'Intan Aulia', 4, 'Penjelasannya detail, terutama soal batik. Orangnya juga ramah dan sabar menjawab pertanyaan.', '2025-06-03 02:20:00'),
(7, 4, 6, 'Intan Aulia', 5, 'Mbak Siti asyik banget, diajak muter-muter Surabaya sambil kulineran enak. Spot fotonya juga oke-oke!', '2025-06-04 05:00:00'),
(8, 4, NULL, 'Rizky Pratama', 4, 'Tur kuliner malamnya mantap. Mbak Siti tahu tempat makan legendaris yang wajib dicoba.', '2025-06-01 15:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `wilayah`
--

CREATE TABLE `wilayah` (
  `id_wilayah` int NOT NULL,
  `nama_wilayah` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `wilayah`
--

INSERT INTO `wilayah` (`id_wilayah`, `nama_wilayah`) VALUES
(1, 'Lamongan'),
(2, 'Jakarta'),
(3, 'Surabaya'),
(4, 'Bangkalan'),
(5, 'Pamekasan');

-- --------------------------------------------------------

--
-- Table structure for table `wisata`
--

CREATE TABLE `wisata` (
  `id_wisata` int NOT NULL,
  `nama_wisata` varchar(100) DEFAULT NULL,
  `deskripsi_wisata` text,
  `todo` text,
  `Alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `id_lokasi` int DEFAULT NULL,
  `kategori_id` int DEFAULT NULL,
  `denah` varchar(255) DEFAULT NULL,
  `telepon` varchar(25) DEFAULT NULL,
  `info_aksesibilitas` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `wisata`
--

INSERT INTO `wisata` (`id_wisata`, `nama_wisata`, `deskripsi_wisata`, `todo`, `Alamat`, `id_lokasi`, `kategori_id`, `denah`, `telepon`, `info_aksesibilitas`) VALUES
(1, 'Pantai Putri Klayar', 'Pantai Putri Klayar adalah destinasi wisata bahari yang menawan di Dusun Klayar, Desa Sidokelar, Kecamatan Paciran, Kabupaten Lamongan, Jawa Timur. Pantai ini menawarkan suasana alami dengan pasir putih lembut, air laut jernih, dan deretan pohon bakau yang memberikan keteduhan. Keasrian lingkungan dan keindahan alamnya menjadikan pantai ini cocok untuk bersantai, berkemah, atau menikmati pemandangan matahari terbit dan terbenam. Meskipun akses jalan menuju pantai masih berupa jalan setapak dan fasilitas umum seperti toilet belum tersedia, keindahan alam yang ditawarkan membuat Pantai Putri Klayar menjadi pilihan menarik bagi wisatawan yang mencari ketenangan dan keindahan alam yang belum banyak terjamah.', 'Menikmati sunrise, berfoto, berenang, bersantai di tepi pantai', '', 1, 1, '../Gambar/pantai putri klayar.jpg', NULL, NULL),
(2, 'Pantai Lorena', 'Surga bawah laut dengan keanekaragaman hayati terkaya di dunia yang menawarkan pengalaman snorkeling dan diving terbaik. Pantai dengan sunset yang menawan.', 'Snorkeling, diving, menikmati sunset, berenang, eksplorasi bawah laut', 'https://maps.google.com/?q=Pantai+Lorena+Lamongan', 1, 1, '', NULL, NULL),
(3, 'Indonesian Islamic Art Museum', 'Sebuah jendela yang memukau untuk memahami kekayaan seni dan budaya Islam di Indonesia. Museum yang menampilkan koleksi seni Islam terlengkap.', 'Melihat koleksi seni Islam, belajar sejarah, tur museum, berfoto', 'https://maps.google.com/?q=Indonesian+Islamic+Art+Museum+Lamongan', 1, 3, '', NULL, NULL),
(4, 'Gunung Pegat', 'Gunung Pegat adalah sebuah bukit kapur yang terletak di Desa Karangkembang, Kecamatan Babat, Kabupaten Lamongan, Jawa Timur. Dengan ketinggian sekitar 60 meter di atas permukaan laut, gunung ini tidak seperti gunung pada umumnya. Nama \"Pegat\" dalam bahasa Jawa berarti \"cerai\", dan hal ini berkaitan dengan mitos yang berkembang di masyarakat setempat. Menurut mitos, pasangan yang hendak menikah dan melewati Gunung Pegat diyakini akan menghadapi perceraian jika tidak melakukan ritual tertentu, seperti melepaskan ayam hidup sebelum melewati gunung tersebut.', 'fotografi, eksplorasi alam, menikmati suasana santai di kedai kop, trekking ringan menjelajahi area perbukitan, rekreasi keluarga', 'https://maps.google.com/?q=Wisata+Bahari+Lamongan', 1, 2, '../uploads/denah/denah_4_6842812d24584_gunung pegat.png', '', ''),
(5, 'WBL dan MZG', 'Rasakan pengalaman liburan ganda yang tak terlupakan dengan mengunjungi dua destinasi unggulan Lamongan sekaligus: Wisata Bahari Lamongan (WBL) dan Maharani Zoo & Goa (MZG)!', 'Bermain wahana air, melihat satwa di zoo, eksplorasi goa, rekreasi keluarga', 'https://maps.google.com/?q=WBL+MZG+Lamongan', 1, 2, '', NULL, NULL),
(6, 'Taman Mini Indonesia Indah', 'Selamat datang di Taman Mini Indonesia Indah (TMII), sebuah miniatur megah yang menampilkan kekayaan budaya dan keindahan alam dari 34 provinsi di Indonesia.', 'Tur budaya, melihat rumah adat, museum, teater IMAX, naik kereta gantung', 'https://maps.google.com/?q=Taman+Mini+Indonesia+Indah+Jakarta', 2, 3, '', NULL, NULL),
(7, 'Museum Nasional Indonesia', 'Selamat datang di Museum Nasional Indonesia, yang juga dikenal sebagai Museum Gajah. Berlokasi di jantung Jakarta Pusat, museum ini adalah yang terbesar dan terlengkap di Indonesia, menyimpan khazanah tak ternilai dari warisan arkeologi, sejarah, etnografi, dan seni bangsa.', 'Tur museum, melihat koleksi arkeologi, belajar sejarah Indonesia, berfoto', 'https://maps.google.com/?q=Museum+Nasional+Indonesia+Jakarta', 2, 3, 'https://asset-2.tstatic.net/tribunnewswiki/foto/bank/images/denah-museum-nasional.jpg', NULL, NULL),
(8, 'Monumen Nasional Indonesia', 'Monumen Nasional (Monas) adalah simbol kebanggaan bangsa Indonesia yang megah. Berdiri kokoh di tengah Jakarta, monas menjadi saksi bisu perjuangan kemerdekaan Indonesia.', 'Naik ke puncak monas, melihat diorama sejarah, berfoto, jalan-jalan di taman', 'https://maps.google.com/?q=Monumen+Nasional+Jakarta', 2, 3, 'https://i.pinimg.com/originals/ba/d6/40/bad6407d1360de08c37ff86a6cb5964f.png', '', ''),
(9, 'Jakarta Aquarium', 'Selamat datang di Jakarta Aquarium & Safari, sebuah destinasi wisata yang memukau di tengah hiruk pikuk ibu kota! Di sini, Anda akan diajak dalam perjalanan yang menakjubkan untuk menjelajahi keindahan bawah laut Indonesia dan berbagai satwa eksotis dari seluruh dunia.', 'Melihat ikan dan satwa laut, pertunjukan lumba-lumba, feeding time, edukasi marine life', 'https://maps.google.com/?q=Jakarta+Aquarium+Safari', 2, 2, '', NULL, NULL),
(10, 'Dunia Fantasi Ancol', 'Dunia Fantasi (Dufan) adalah taman bermain terbesar di Indonesia yang menawarkan berbagai wahana seru dan menegangkan. Terletak di kawasan Ancol, destinasi ini menjadi favorit keluarga untuk berlibur.', 'Bermain wahana, roller coaster, istana boneka, parade, makan di food court,Berenang', 'Taman Impian Jaya Ancol\nJl. Lodan Timur No.7, RW.10, Ancol,\nKec. Pademangan, Kota Jakarta Utara,\nDaerah Khusus Ibukota Jakarta 14430, Indonesia', 2, 2, 'https://imgv2-1-f.scribdassets.com/img/document/670528216/original/3cc20ff43f/1696827565?v=1', '085171743947', NULL),
(11, 'Pantai Pasir Putih Tlangoh', 'Pantai Pasir Putih Tlangoh adalah destinasi wisata bahari yang memukau di Desa Tlangoh, Kecamatan Tanjungbumi, Kabupaten Bangkalan, Madura. Terkenal dengan hamparan pasir putihnya yang bersih dan air laut biru jernih, pantai ini menawarkan suasana tenang dan alami, cocok untuk bersantai dan menikmati keindahan alam. Pengunjung dapat menikmati berbagai aktivitas seperti bermain air di tepi pantai dengan ombak yang relatif tenang, menjelajahi garis pantai sepanjang hampir 1 km dengan menyewa ATV, atau berswafoto di spot-spot menarik seperti ayunan dan bingkai estetis yang disediakan pengelola. Fasilitas yang tersedia mencakup area parkir luas, toilet, mushola, serta warung-warung yang menyajikan kuliner khas Madura seperti rujak dan bakso. Dengan harga tiket masuk yang terjangkau, sekitar Rp5.000–Rp10.000 per orang tergantung hari kunjungan, Pantai Tlangoh menjadi pilihan ideal untuk liburan keluarga atau sekadar melepas penat dari rutinitas sehari-hari.', 'Bermain air dan berenang, Menjelajahi pantai dengan ATV, Bersantai dan piknik, Berfoto di spot estetik, Menikmati kuliner khas Madura, Melihat matahari terbenam (sunset)', NULL, 4, 1, '../gambar/pantai pasir putih tlangoh.jpg', NULL, NULL),
(12, 'Mercusuar Sembilangan', 'Mercusuar Sembilangan, yang berlokasi di Desa Sembilangan, Kecamatan Socah, Kabupaten Bangkalan, adalah sebuah menara besi putih menjulang setinggi sekitar 65 hingga 78 meter yang dibangun pada tahun 1879 oleh pemerintah kolonial Belanda di masa Raja Z.M. Willem III. Berfungsi vital sebagai penuntun navigasi bagi kapal-kapal di Selat Madura, mercusuar bersejarah ini tak hanya menjadi simbol maritim yang kokoh dengan 17 lantai tangga spiralnya, tetapi juga menawarkan panorama laut lepas yang menakjubkan dan sering menjadi daya tarik bagi pecinta sejarah serta fotografi, meskipun akses ke puncaknya mungkin terbatas.', 'Menikmati Keindahan Arsitektur dan Sejarah, Berfoto, Menikmati Pemandangan Laut dan Alam Sekitar, Piknik atau Bersantai di Area Sekitar, Menjelajahi Pantai', NULL, 4, 3, '../gambar/mercusuar.jpg', NULL, NULL),
(13, 'Labuhan Mangrove Educational Park', 'Labuhan Mangrove Educational Park adalah sebuah destinasi wisata edukatif yang terletak di Desa Labuhan, Kecamatan Sepulu, Kabupaten Bangkalan, Madura. Taman ini menawarkan pengalaman unik untuk mengenal keindahan alam ekosistem mangrove sekaligus memperluas pengetahuan tentang pentingnya konservasi lingkungan. Berawal dari bekas kawasan tambak yang kemudian diubah menjadi area konservasi mangrove, tempat ini dikembangkan menjadi taman pendidikan oleh Kelompok Tani Mangrove \"Cemara Sejahtera\" dengan dukungan dari PT. Pertamina Hulu Energi West Madura Offshore (PHE WMO).', 'Belajar tentang Ekosistem Mangrove, Mengamati Flora dan Fauna, Berpartisipasi dalam Program Konservasi, Berfoto, Belajar tentang Pemanfaatan Mangrove', NULL, 4, 2, 'https://ai2-s2-public.s3.amazonaws.com/figures/2017-08-08/9e5f101260726a3423a80d64a528368865df63b5/3-Figure1-1.png', NULL, NULL),
(14, 'Pantai Rongkang', 'Pantai Rongkang adalah destinasi alami di Desa Kwanyar Barat, Bangkalan, Madura, yang terkenal dengan perpaduan unik antara hamparan pasir dan area berkarang eksotis sepanjang sekitar 1 km, disokong oleh bukit-bukit hijau setinggi 20-25 meter. Air lautnya yang jernih dan pemandangan matahari terbenam yang memukau menjadi daya tarik utama, di mana pengunjung juga bisa menikmati kelap-kelip lampu Kota Surabaya dari kejauhan. Meskipun fasilitasnya masih minim, keaslian dan keindahan alami Pantai Rongkang menjadikannya pilihan ideal bagi mereka yang mencari ketenangan dan spot fotografi unik, terutama saat senja.', 'Menikmati Keindahan Alam, Berburu Momen Matahari Terbenam (Sunset), Melihat Pemandangan Kota Surabaya di Kejauhan, Fotografi, Bersantai dan Menikmati Ketenangan', '', 4, 1, '0', '', ''),
(16, 'Dermaga  Rindu', 'Wisata Kapal Rindu atau yang biasa disebut dermaga rindu di Bangkalan, Madura, adalah destinasi unik yang menghadirkan pengalaman wisata bahari dengan nuansa romantis dan Instagramable. Terletak di kawasan pesisir, tempat ini menampilkan replika kapal besar yang berdiri megah di tepi pantai, lengkap dengan dek, anjungan, dan ornamen laut yang menarik. Pengunjung dapat menikmati pemandangan laut yang menakjubkan, berfoto di berbagai spot estetik, serta bersantai di area kafe dan taman yang tersedia. Dengan suasana tenang dan angin laut yang sejuk, Wisata Kapal Rindu menjadi pilihan tepat untuk liburan keluarga maupun pasangan yang ingin menikmati keindahan alam Bangkalan.', '', 'Jl. Raya Sukolilo, Polasari (Desa Kesek), Sukolilo Barat, Kec. Labang, Kab. Bangkalan, Jawa Timur', 4, 1, '../uploads/wisata/denah_16_68430da2d0edc.jpg', '', ''),
(17, 'Surabaya Kota Lama', 'Surabaya Kota Lama adalah kawasan bersejarah yang menyimpan jejak masa kolonial Belanda, terletak di sekitar Jembatan Merah, Jalan Rajawali, dan sekitarnya. Kawasan ini dipenuhi bangunan-bangunan tua bergaya arsitektur Eropa klasik yang kini menjadi saksi bisu perkembangan kota Surabaya dari masa ke masa. Suasana tempo dulu masih kental terasa, menjadikan tempat ini menarik bagi pecinta sejarah, fotografi, maupun wisata budaya. Selain sebagai pusat perdagangan zaman dahulu, Kota Lama kini mulai direvitalisasi untuk menjadi destinasi wisata edukatif yang menggabungkan nilai sejarah, seni, dan kreativitas modern.', '', 'Jl. Rajawali Jl. Jembatan Merah, Kota Lama, Kec. Krembangan, Surabaya, Jawa Timur', 3, 3, '../uploads/wisata/denah_17_684310051bc7d.jpg', '', ''),
(18, 'Monumen Kapal Selam', 'Monumen Kapal Selam (Monkasel) adalah salah satu ikon wisata edukatif di Surabaya yang menampilkan kapal selam KRI Pasopati 410, bekas armada TNI AL yang kini dijadikan museum. Terletak di pusat kota, tepatnya di Jalan Pemuda, monumen ini memberikan pengalaman unik bagi pengunjung untuk menjelajahi bagian dalam kapal selam sungguhan, lengkap dengan ruang torpedo, ruang kendali, dan peralatan militer asli. Monkasel dibangun untuk mengenang perjuangan para prajurit laut Indonesia serta sebagai sarana pembelajaran maritim bagi masyarakat. Dikelilingi taman dan area rekreasi keluarga, tempat ini menjadi destinasi menarik untuk mengenal sejarah pertahanan laut Indonesia secara langsung dan interaktif.', '', 'Jl. Pemuda No.39, Embong Kaliasin, Kec. Genteng, Surabaya, Jawa Timur 60271', 3, 3, '../uploads/wisata/denah_18_684311464abbe.jpg', '', ''),
(19, 'Monumen Nasional Tugu Pahlawan dan Museum 10 November', 'Monumen Nasional Tugu Pahlawan di Surabaya adalah landmark megah setinggi 41,15 meter yang dirancang berbentuk “lingga” atau paku terbalik, dengan 10 lengkungan dan 11 ruas—simbol dari tanggal 10–11–1945, saat pertempuran heroik di Kota Pahlawan terjadi. Berdiri kokoh di tengah alun-alun Jalan Pahlawan, monumen ini diresmikan pada 10 November 1952 oleh Presiden Soekarno setelah peletakan batu pertama setahun sebelumnya pada 10 November 1951 surabaya. Di kompleks ini juga terdapat Museum Sepuluh November—berada di bawah tanah—yang menampilkan koleksi 400-an foto, senjata rampasan, artefak serta diorama interaktif tentang peristiwa 10 November 1945. Monumen dan museum ini menjadi tempat apel tahunan setiap Hari Pahlawan, sekaligus simbol semangat kepahlawanan dan nasionalisme arek‑arek Suroboyo.', '', 'Jl. Pahlawan, Alun-alun Contong, Kec. Bubutan, Surabaya, Jawa Timur.', 3, 3, '../uploads/wisata/denah_19_6843144b417e0.jpg', '', ''),
(20, 'Kebun Binatang', 'Kebun Binatang Surabaya (KBS) adalah salah satu kebun binatang tertua dan terbesar di Asia Tenggara yang terletak di pusat Kota Surabaya, Jawa Timur. Didirikan pada tahun 1916, KBS menjadi rumah bagi lebih dari 2.000 satwa dari ratusan spesies, baik dari dalam maupun luar negeri. Dengan luas sekitar 15 hektare, kebun binatang ini tidak hanya menjadi tempat rekreasi keluarga, tetapi juga pusat edukasi dan konservasi satwa langka. Pengunjung dapat melihat berbagai jenis hewan seperti harimau, gajah, komodo, orangutan, hingga burung eksotis dalam lingkungan yang menyerupai habitat aslinya.', '', 'Jl. Setail No.1, Darmo, Kec. Wonokromo, Surabaya, Jawa Timur.', 3, 2, '../uploads/wisata/denah_20_6843acf758097.jpg', '', ''),
(21, 'Atlantis Land', 'Atlantis Land Surabaya adalah taman hiburan keluarga yang terletak di dalam kawasan Kenjeran Park, Jalan Sukolilo No. 100, Surabaya. Dengan tema istana bawah laut, tempat ini menawarkan berbagai wahana menarik untuk semua usia, termasuk Istana Es bersuhu -15°C, Dino Land dengan replika dinosaurus, dan Istana Patung Lilin yang menampilkan figur tokoh terkenal. Pengunjung juga dapat menikmati berbagai wahana permainan darat dan air, seperti Tornado Slide dan Boomerang Slide, serta pertunjukan Air Mancur Menari setiap hari pukul 17.30 WIB. Atlantis Land buka setiap hari dari pukul 10.00 hingga 18.00 WIB, dengan harga tiket masuk Rp100.000 untuk hari biasa dan Rp125.000 untuk akhir pekan, yang sudah termasuk akses ke semua wahana dan area Kenjeran Park.', '', 'Jl. Sukolilo Lor No.100, Sukolilo Baru, Kec. Bulak, Surabaya, Jawa Timur.', 3, 2, '../uploads/wisata/denah_21_6843aea1d1635.jpg', '', ''),
(22, 'Panjat Tebing Gunung Labeng Waru', 'Gunung Labeng Waru adalah destinasi panjat tebing yang terletak di Kabupaten Pamekasan, Madura, Jawa Timur. Tebing ini menawarkan formasi batuan kapur yang unik dan menantang, menjadikannya tempat favorit bagi para pemanjat tebing, baik pemula maupun profesional. Dengan ketinggian tebing yang bervariasi dan jalur pemanjatan yang beragam, Gunung Labeng Waru menjadi lokasi ideal untuk melatih teknik dan stamina. Selain itu, pemandangan alam sekitar yang asri dan udara segar menambah daya tarik tempat ini sebagai lokasi petualangan dan rekreasi alam.', '', 'Desa Waru, Kecamatan Waru, Kabupaten Pamekasan.', 5, 2, '../uploads/wisata/denah_22_6843b11ebaae7.jpg', '', ''),
(23, 'Pantai Batu Kerbuy', 'Pantai Batu Kerbuy terletak di Desa Batu Kerbuy, Kecamatan Pasean, Kabupaten Pamekasan, Madura, sekitar 45 km dari pusat kota Pamekasan. Pantai ini menawarkan panorama laut biru jernih yang berpadu dengan hamparan pasir putih, serta formasi batu karang unik yang tersebar di sepanjang pantai, memberikan daya tarik tersendiri bagi pengunjung. Dikelilingi oleh pepohonan cemara yang rindang, suasana di pantai ini tetap sejuk meskipun di siang hari, menjadikannya tempat ideal untuk bersantai atau piknik bersama keluarga dan teman. Selain keindahan alamnya, Pantai Batu Kerbuy juga dikenal dengan legenda lokal tentang batu-batu yang konon merupakan manusia yang berubah menjadi kerbau dan kemudian menjadi batu, menambah nuansa mistis dan budaya pada destinasi ini. Dengan ombak yang tenang dan air yang jernih, pantai ini cocok untuk berenang, snorkeling, memancing, atau sekadar menikmati keindahan alam.', '', 'Jalan Raya Pasean, Pasean, Pamekasan, Kabupaten Pamekasan, Jawa Timur.', 5, 1, '../uploads/wisata/denah_23_6843b292bc199.jpg', '', ''),
(24, 'Air Terjun Ahatan', 'Air Terjun Ahatan adalah destinasi alam tersembunyi di Dusun Ahatan, Desa Tlonto Raja, Kecamatan Pasean, Kabupaten Pamekasan, Madura. Dikenal dengan keindahan alamnya yang masih asri, air terjun ini menawarkan suasana tenang dan udara sejuk, menjadikannya tempat ideal untuk melepas penat dari hiruk-pikuk kehidupan sehari-hari. Dengan ketinggian sekitar 30 meter, aliran airnya yang jernih dan dingin mengalir di antara bebatuan alami, menciptakan kolam alami yang cocok untuk berenang atau sekadar bermain air. Dikelilingi oleh pepohonan hijau yang rimbun, pengunjung dapat menikmati piknik sederhana sambil mendengarkan gemericik air yang menenangkan. Meskipun akses menuju lokasi cukup menantang karena medan yang curam, keindahan yang ditawarkan sepadan dengan usaha yang dikeluarkan. Menariknya, tidak ada biaya tiket masuk untuk menikmati keindahan Air Terjun Ahatan, menjadikannya destinasi wisata yang ramah di kantong.', '', '3HC9+W4H, Duko, Tlontoraja, Kec. Pasean, Kabupaten Pamekasan, Jawa Timur.', 5, 2, '../uploads/denah/denah_24_684ed601f38f4_air terjun ahatann.jpg', '', ''),
(25, 'Goa Blaban', 'Goa Blaban adalah destinasi wisata alam yang terletak di Dusun Rojing, Desa Blaban, Kecamatan Batumarmar, Kabupaten Pamekasan, Madura. Goa ini ditemukan secara tidak sengaja pada tahun 2016 oleh warga yang sedang menggali sumur dan menemukan rongga besar di bawah tanah. Di dalamnya, pengunjung akan disambut oleh stalaktit dan stalagmit berwarna putih yang berkilau saat terkena cahaya, menciptakan pemandangan yang memukau. Goa ini memiliki kedalaman sekitar 7 meter dan luas ruangan sekitar 50 meter persegi. Untuk memudahkan akses, telah dipasang tangga besi melingkar dan lampu penerangan warna-warni yang menambah keindahan suasana di dalam goa. Meskipun akses menuju lokasi cukup menantang, keindahan dan keunikan Goa Blaban menjadikannya destinasi yang layak dikunjungi bagi para pecinta alam dan petualangan.', '', 'Rojing Daya, Blaban, Kec. Batumarmar, Kabupaten Pamekasan, Jawa Timur.', 5, 2, '../uploads/wisata/denah_25_6843b4fa8a485.jpg', '', ''),
(26, 'Bukit Kampung Toron Samalem', 'Kampoeng Toron Samalem adalah destinasi wisata unik di Desa Blumbungan, Kecamatan Larangan, Kabupaten Pamekasan, Madura. Dibangun di atas bekas tambang batu kapur, tempat ini menawarkan suasana perkampungan ala Papua dengan replika rumah honai dan jembatan kayu yang estetik. Selain itu, pengunjung dapat menikmati kolam alami dengan air jernih kebiruan yang cocok untuk berenang dan bersantai. Fasilitas pendukung seperti gazebo, mushola, toilet, dan warung makan tersedia untuk kenyamanan pengunjung. Dengan tiket masuk sebesar Rp15.000, Kampoeng Toron Samalem menjadi pilihan wisata yang terjangkau dan menarik bagi keluarga maupun pecinta fotografi.', '', 'Toron Semalem, Blumbungan, Kec. Larangan, Kabupaten Pamekasan, Jawa Timur.', 5, 2, '../uploads/wisata/denah_26_6843d04c1e304.jpg', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id_wishlist` int NOT NULL,
  `user_id` int NOT NULL,
  `wisata_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`id_wishlist`, `user_id`, `wisata_id`, `created_at`) VALUES
(10, 9, 26, '2025-06-16 04:38:03'),
(11, 9, 7, '2025-06-16 04:39:20'),
(12, 9, 24, '2025-06-16 04:53:27'),
(13, 9, 16, '2025-06-16 04:53:31'),
(14, 9, 10, '2025-06-16 04:53:34');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `akomodasi_kuliner`
--
ALTER TABLE `akomodasi_kuliner`
  ADD PRIMARY KEY (`id_akomodasi_kuliner`);

--
-- Indexes for table `akomodasi_kuliner_detail`
--
ALTER TABLE `akomodasi_kuliner_detail`
  ADD KEY `id_akomodasi_kuliner` (`id_akomodasi_kuliner`);

--
-- Indexes for table `akomodasi_penginapan`
--
ALTER TABLE `akomodasi_penginapan`
  ADD PRIMARY KEY (`id_akomodasi_penginapan`);

--
-- Indexes for table `akomodasi_penginapan_detail`
--
ALTER TABLE `akomodasi_penginapan_detail`
  ADD KEY `id_akomodasi` (`id_akomodasi`);

--
-- Indexes for table `artikel`
--
ALTER TABLE `artikel`
  ADD PRIMARY KEY (`id_artikel`);

--
-- Indexes for table `bahasa`
--
ALTER TABLE `bahasa`
  ADD PRIMARY KEY (`id_bahasa`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id_comment`),
  ADD KEY `id_artikel` (`id_artikel`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id_message`);

--
-- Indexes for table `detail_peserta_pemesanan`
--
ALTER TABLE `detail_peserta_pemesanan`
  ADD PRIMARY KEY (`id_detail_peserta`),
  ADD KEY `id_pemesanan` (`id_pemesanan`);

--
-- Indexes for table `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`id_faq`);

--
-- Indexes for table `galeri`
--
ALTER TABLE `galeri`
  ADD PRIMARY KEY (`id_galeri`);

--
-- Indexes for table `gambar`
--
ALTER TABLE `gambar`
  ADD PRIMARY KEY (`id_gambar`),
  ADD KEY `wisata_id` (`wisata_id`);

--
-- Indexes for table `gambar_artikel`
--
ALTER TABLE `gambar_artikel`
  ADD PRIMARY KEY (`id_gambar_artikel`),
  ADD KEY `id_artikel` (`id_artikel`);

--
-- Indexes for table `gambar_paket`
--
ALTER TABLE `gambar_paket`
  ADD PRIMARY KEY (`id_gambar_paket`),
  ADD KEY `id_paket_wisata` (`id_paket_wisata`);

--
-- Indexes for table `jenis_artikel`
--
ALTER TABLE `jenis_artikel`
  ADD PRIMARY KEY (`id_jenis_artikel`);

--
-- Indexes for table `jenis_paket`
--
ALTER TABLE `jenis_paket`
  ADD PRIMARY KEY (`id_jenis_paket`);

--
-- Indexes for table `kategori_wisata`
--
ALTER TABLE `kategori_wisata`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `kendaraan`
--
ALTER TABLE `kendaraan`
  ADD PRIMARY KEY (`id_kendaraan`);

--
-- Indexes for table `komentar_artikel`
--
ALTER TABLE `komentar_artikel`
  ADD PRIMARY KEY (`id_komentar_artikel`);

--
-- Indexes for table `kontak`
--
ALTER TABLE `kontak`
  ADD PRIMARY KEY (`id_kontak`);

--
-- Indexes for table `kuliner`
--
ALTER TABLE `kuliner`
  ADD PRIMARY KEY (`id_kuliner`);

--
-- Indexes for table `lokasi`
--
ALTER TABLE `lokasi`
  ADD PRIMARY KEY (`id_lokasi`);

--
-- Indexes for table `paket_wisata`
--
ALTER TABLE `paket_wisata`
  ADD PRIMARY KEY (`id_paket_wisata`),
  ADD KEY `id_wisata` (`id_wisata`),
  ADD KEY `id_kategori_paket` (`id_jenis_paket`),
  ADD KEY `id_pemandu_wisata` (`id_pemandu_wisata`),
  ADD KEY `id_kendaraan` (`id_kendaraan`),
  ADD KEY `id_akomodasi_kuliner` (`id_akomodasi_kuliner`),
  ADD KEY `id_wilayah` (`id_wilayah`),
  ADD KEY `id_akomodasi_penginapan` (`id_akomodasi_penginapan`);

--
-- Indexes for table `pemandu_bahasa`
--
ALTER TABLE `pemandu_bahasa`
  ADD PRIMARY KEY (`id_pemandu_wisata`,`id_bahasa`),
  ADD KEY `id_bahasa` (`id_bahasa`);

--
-- Indexes for table `pemandu_wisata`
--
ALTER TABLE `pemandu_wisata`
  ADD PRIMARY KEY (`id_pemandu_wisata`),
  ADD KEY `fk_pemandu_lokasi` (`id_lokasi`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `id_pemesanan` (`id_pemesanan`);

--
-- Indexes for table `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD PRIMARY KEY (`id_pemesanan`),
  ADD UNIQUE KEY `kode_pemesanan` (`kode_pemesanan`),
  ADD UNIQUE KEY `midtrans_transaction_id` (`midtrans_transaction_id`),
  ADD KEY `id_paket_wisata` (`id_paket_wisata`);

--
-- Indexes for table `pengunjung`
--
ALTER TABLE `pengunjung`
  ADD PRIMARY KEY (`id_pengunjung`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `pertanyaan`
--
ALTER TABLE `pertanyaan`
  ADD PRIMARY KEY (`id_pertanyaan`);

--
-- Indexes for table `rencana_perjalanan`
--
ALTER TABLE `rencana_perjalanan`
  ADD PRIMARY KEY (`id_rencana_perjalanan`),
  ADD KEY `id_paket` (`id_paket`);

--
-- Indexes for table `termasuk_paket`
--
ALTER TABLE `termasuk_paket`
  ADD PRIMARY KEY (`id_termasuk_paket`);

--
-- Indexes for table `tips_berkunjung`
--
ALTER TABLE `tips_berkunjung`
  ADD PRIMARY KEY (`id_tips_berkunjung`),
  ADD KEY `id_wisata` (`id_wisata`);

--
-- Indexes for table `ulasan`
--
ALTER TABLE `ulasan`
  ADD PRIMARY KEY (`id_ulasan`),
  ADD KEY `id_wisata` (`id_wisata`),
  ADD KEY `id_pengunjung` (`id_pengunjung`);

--
-- Indexes for table `ulasan_kuliner`
--
ALTER TABLE `ulasan_kuliner`
  ADD PRIMARY KEY (`id_kuliner`);

--
-- Indexes for table `ulasan_pemandu`
--
ALTER TABLE `ulasan_pemandu`
  ADD PRIMARY KEY (`id_ulasan_pemandu`),
  ADD KEY `fk_ulasan_pemandu_pemandu` (`id_pemandu_wisata`),
  ADD KEY `fk_ulasan_pemandu_pengunjung` (`id_pengunjung`);

--
-- Indexes for table `wilayah`
--
ALTER TABLE `wilayah`
  ADD PRIMARY KEY (`id_wilayah`);

--
-- Indexes for table `wisata`
--
ALTER TABLE `wisata`
  ADD PRIMARY KEY (`id_wisata`),
  ADD KEY `id_lokasi` (`id_lokasi`),
  ADD KEY `kategori_id` (`kategori_id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id_wishlist`),
  ADD UNIQUE KEY `unique_wishlist` (`user_id`,`wisata_id`),
  ADD KEY `wisata_id` (`wisata_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `akomodasi_kuliner`
--
ALTER TABLE `akomodasi_kuliner`
  MODIFY `id_akomodasi_kuliner` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `akomodasi_penginapan`
--
ALTER TABLE `akomodasi_penginapan`
  MODIFY `id_akomodasi_penginapan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `artikel`
--
ALTER TABLE `artikel`
  MODIFY `id_artikel` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `bahasa`
--
ALTER TABLE `bahasa`
  MODIFY `id_bahasa` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id_comment` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id_message` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `detail_peserta_pemesanan`
--
ALTER TABLE `detail_peserta_pemesanan`
  MODIFY `id_detail_peserta` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `faq`
--
ALTER TABLE `faq`
  MODIFY `id_faq` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `galeri`
--
ALTER TABLE `galeri`
  MODIFY `id_galeri` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `gambar`
--
ALTER TABLE `gambar`
  MODIFY `id_gambar` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `gambar_artikel`
--
ALTER TABLE `gambar_artikel`
  MODIFY `id_gambar_artikel` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `gambar_paket`
--
ALTER TABLE `gambar_paket`
  MODIFY `id_gambar_paket` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `jenis_artikel`
--
ALTER TABLE `jenis_artikel`
  MODIFY `id_jenis_artikel` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `jenis_paket`
--
ALTER TABLE `jenis_paket`
  MODIFY `id_jenis_paket` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kategori_wisata`
--
ALTER TABLE `kategori_wisata`
  MODIFY `id_kategori` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kendaraan`
--
ALTER TABLE `kendaraan`
  MODIFY `id_kendaraan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `komentar_artikel`
--
ALTER TABLE `komentar_artikel`
  MODIFY `id_komentar_artikel` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kontak`
--
ALTER TABLE `kontak`
  MODIFY `id_kontak` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kuliner`
--
ALTER TABLE `kuliner`
  MODIFY `id_kuliner` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lokasi`
--
ALTER TABLE `lokasi`
  MODIFY `id_lokasi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `paket_wisata`
--
ALTER TABLE `paket_wisata`
  MODIFY `id_paket_wisata` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `pemandu_wisata`
--
ALTER TABLE `pemandu_wisata`
  MODIFY `id_pemandu_wisata` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pemesanan`
--
ALTER TABLE `pemesanan`
  MODIFY `id_pemesanan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `pengunjung`
--
ALTER TABLE `pengunjung`
  MODIFY `id_pengunjung` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `pertanyaan`
--
ALTER TABLE `pertanyaan`
  MODIFY `id_pertanyaan` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rencana_perjalanan`
--
ALTER TABLE `rencana_perjalanan`
  MODIFY `id_rencana_perjalanan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=247;

--
-- AUTO_INCREMENT for table `termasuk_paket`
--
ALTER TABLE `termasuk_paket`
  MODIFY `id_termasuk_paket` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=168;

--
-- AUTO_INCREMENT for table `tips_berkunjung`
--
ALTER TABLE `tips_berkunjung`
  MODIFY `id_tips_berkunjung` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `ulasan`
--
ALTER TABLE `ulasan`
  MODIFY `id_ulasan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ulasan_kuliner`
--
ALTER TABLE `ulasan_kuliner`
  MODIFY `id_kuliner` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ulasan_pemandu`
--
ALTER TABLE `ulasan_pemandu`
  MODIFY `id_ulasan_pemandu` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `wilayah`
--
ALTER TABLE `wilayah`
  MODIFY `id_wilayah` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `wisata`
--
ALTER TABLE `wisata`
  MODIFY `id_wisata` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id_wishlist` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `akomodasi_kuliner_detail`
--
ALTER TABLE `akomodasi_kuliner_detail`
  ADD CONSTRAINT `akomodasi_kuliner_detail_ibfk_1` FOREIGN KEY (`id_akomodasi_kuliner`) REFERENCES `akomodasi_kuliner` (`id_akomodasi_kuliner`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `akomodasi_penginapan_detail`
--
ALTER TABLE `akomodasi_penginapan_detail`
  ADD CONSTRAINT `akomodasi_penginapan_detail_ibfk_1` FOREIGN KEY (`id_akomodasi`) REFERENCES `akomodasi_penginapan` (`id_akomodasi_penginapan`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`id_artikel`) REFERENCES `artikel` (`id_artikel`) ON DELETE CASCADE;

--
-- Constraints for table `detail_peserta_pemesanan`
--
ALTER TABLE `detail_peserta_pemesanan`
  ADD CONSTRAINT `detail_peserta_pemesanan_ibfk_1` FOREIGN KEY (`id_pemesanan`) REFERENCES `pemesanan` (`id_pemesanan`) ON DELETE CASCADE;

--
-- Constraints for table `gambar`
--
ALTER TABLE `gambar`
  ADD CONSTRAINT `gambar_ibfk_1` FOREIGN KEY (`wisata_id`) REFERENCES `wisata` (`id_wisata`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `gambar_artikel`
--
ALTER TABLE `gambar_artikel`
  ADD CONSTRAINT `gambar_artikel_ibfk_1` FOREIGN KEY (`id_artikel`) REFERENCES `artikel` (`id_artikel`);

--
-- Constraints for table `gambar_paket`
--
ALTER TABLE `gambar_paket`
  ADD CONSTRAINT `gambar_paket_ibfk_1` FOREIGN KEY (`id_paket_wisata`) REFERENCES `paket_wisata` (`id_paket_wisata`) ON DELETE CASCADE;

--
-- Constraints for table `paket_wisata`
--
ALTER TABLE `paket_wisata`
  ADD CONSTRAINT `paket_wisata_ibfk_1` FOREIGN KEY (`id_wisata`) REFERENCES `wisata` (`id_wisata`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `paket_wisata_ibfk_2` FOREIGN KEY (`id_jenis_paket`) REFERENCES `jenis_paket` (`id_jenis_paket`),
  ADD CONSTRAINT `paket_wisata_ibfk_3` FOREIGN KEY (`id_wilayah`) REFERENCES `wilayah` (`id_wilayah`),
  ADD CONSTRAINT `paket_wisata_ibfk_4` FOREIGN KEY (`id_pemandu_wisata`) REFERENCES `pemandu_wisata` (`id_pemandu_wisata`),
  ADD CONSTRAINT `paket_wisata_ibfk_5` FOREIGN KEY (`id_kendaraan`) REFERENCES `kendaraan` (`id_kendaraan`),
  ADD CONSTRAINT `paket_wisata_ibfk_6` FOREIGN KEY (`id_akomodasi_kuliner`) REFERENCES `akomodasi_kuliner` (`id_akomodasi_kuliner`),
  ADD CONSTRAINT `paket_wisata_ibfk_8` FOREIGN KEY (`id_wilayah`) REFERENCES `wilayah` (`id_wilayah`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `paket_wisata_ibfk_9` FOREIGN KEY (`id_akomodasi_penginapan`) REFERENCES `akomodasi_penginapan` (`id_akomodasi_penginapan`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `pemandu_bahasa`
--
ALTER TABLE `pemandu_bahasa`
  ADD CONSTRAINT `pemandu_bahasa_ibfk_1` FOREIGN KEY (`id_pemandu_wisata`) REFERENCES `pemandu_wisata` (`id_pemandu_wisata`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pemandu_bahasa_ibfk_2` FOREIGN KEY (`id_bahasa`) REFERENCES `bahasa` (`id_bahasa`);

--
-- Constraints for table `pemandu_wisata`
--
ALTER TABLE `pemandu_wisata`
  ADD CONSTRAINT `fk_pemandu_lokasi` FOREIGN KEY (`id_lokasi`) REFERENCES `lokasi` (`id_lokasi`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`id_pemesanan`) REFERENCES `pemesanan` (`id_pemesanan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD CONSTRAINT `pemesanan_ibfk_1` FOREIGN KEY (`id_paket_wisata`) REFERENCES `paket_wisata` (`id_paket_wisata`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `rencana_perjalanan`
--
ALTER TABLE `rencana_perjalanan`
  ADD CONSTRAINT `rencana_perjalanan_ibfk_1` FOREIGN KEY (`id_paket`) REFERENCES `paket_wisata` (`id_paket_wisata`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `tips_berkunjung`
--
ALTER TABLE `tips_berkunjung`
  ADD CONSTRAINT `tips_berkunjung_ibfk_1` FOREIGN KEY (`id_wisata`) REFERENCES `wisata` (`id_wisata`) ON DELETE CASCADE;

--
-- Constraints for table `ulasan`
--
ALTER TABLE `ulasan`
  ADD CONSTRAINT `ulasan_ibfk_1` FOREIGN KEY (`id_wisata`) REFERENCES `wisata` (`id_wisata`),
  ADD CONSTRAINT `ulasan_ibfk_2` FOREIGN KEY (`id_pengunjung`) REFERENCES `pengunjung` (`id_pengunjung`);

--
-- Constraints for table `ulasan_pemandu`
--
ALTER TABLE `ulasan_pemandu`
  ADD CONSTRAINT `fk_ulasan_pemandu_pemandu` FOREIGN KEY (`id_pemandu_wisata`) REFERENCES `pemandu_wisata` (`id_pemandu_wisata`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ulasan_pemandu_pengunjung` FOREIGN KEY (`id_pengunjung`) REFERENCES `pengunjung` (`id_pengunjung`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `wisata`
--
ALTER TABLE `wisata`
  ADD CONSTRAINT `wisata_ibfk_2` FOREIGN KEY (`id_lokasi`) REFERENCES `lokasi` (`id_lokasi`),
  ADD CONSTRAINT `wisata_ibfk_3` FOREIGN KEY (`kategori_id`) REFERENCES `kategori_wisata` (`id_kategori`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`wisata_id`) REFERENCES `wisata` (`id_wisata`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlist_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `pengunjung` (`id_pengunjung`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
