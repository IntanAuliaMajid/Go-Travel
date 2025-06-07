<?php
require_once 'backend/koneksi.php'; // Ensure this provides $conn (mysqli object)
include 'Komponen/navbar.php';
$comment_submission_message = '';
$comment_submitted_values = ['name' => '', 'email' => '', 'message' => ''];

// --- Handle Comment Submission ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_comment'])) {
    $comment_article_id = isset($_POST['id_artikel']) ? (int)$_POST['id_artikel'] : 0;
    // Store submitted values to repopulate form
    $comment_submitted_values['name'] = trim($_POST['name']);
    $comment_submitted_values['email'] = trim($_POST['email']);
    $comment_submitted_values['message'] = trim($_POST['message']);

    // Basic server-side validation
    if ($comment_article_id > 0 && !empty($comment_submitted_values['name']) && !empty($comment_submitted_values['message'])) {
        // Optional: Validate email format more strictly if needed
        // $is_valid_email = filter_var($comment_submitted_values['email'], FILTER_VALIDATE_EMAIL);

        // For simplicity, we set comments to 'approved' directly. In production, use 'pending'.
        $status = 'approved'; // Or 'pending' for moderation

        $sql_insert_comment = "INSERT INTO comments (id_artikel, comment_author_name, comment_author_email, comment_text, status)
                               VALUES (?, ?, ?, ?, ?)";
        
        $stmt_insert = $conn->prepare($sql_insert_comment);
        if ($stmt_insert) {
            $stmt_insert->bind_param("issss", $comment_article_id, $comment_submitted_values['name'], $comment_submitted_values['email'], $comment_submitted_values['message'], $status);
            if ($stmt_insert->execute()) {
                // Success: Redirect to the same page with a success parameter (PRG Pattern)
                // This prevents form re-submission on refresh and clears POST data.
                header("Location: blog_detail.php?id=" . $comment_article_id . "&comment_success=1#comments-section-anchor");
                exit;
            } else {
                $comment_submission_message = "Terjadi kesalahan: " . $stmt_insert->error;
            }
            $stmt_insert->close();
        } else {
            $comment_submission_message = "Error preparing statement: " . $conn->error;
        }
    } else {
        $comment_submission_message = "Harap lengkapi nama dan pesan Anda.";
    }
}

// Check for comment submission success message from redirect
if (isset($_GET['comment_success']) && $_GET['comment_success'] == '1') {
    $comment_submission_message = "Komentar Anda telah berhasil dikirim!";
    if (isset($_COOKIE['comment_name'])) $comment_submitted_values['name'] = $_COOKIE['comment_name']; // Persist name/email if desired
    if (isset($_COOKIE['comment_email'])) $comment_submitted_values['email'] = $_COOKIE['comment_email'];
}


// Function to calculate approximate reading time
function calculate_reading_time($text, $wpm = 200) {
    $word_count = str_word_count(strip_tags($text));
    $minutes = floor($word_count / $wpm);
    return ($minutes < 1) ? "Kurang dari 1 menit" : $minutes . " menit";
}

// --- Get Article ID from URL ---
$article_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($article_id <= 0) {
    header("Location: blog.php");
    exit;
}

// --- Fetch Main Article Details ---
$sql_article = "SELECT
                    a.id_artikel, a.judul_artikel, a.tanggal_dipublish, a.isi_artikel, a.tag,
                    COALESCE(ga.url, 'https://images.unsplash.com/photo-1503220317375-aaad61436b1b') AS gambar_utama_url,
                    ja.jenis_artikel AS nama_kategori,
                    a.id_jenis_artikel
                FROM artikel a
                LEFT JOIN gambar_artikel ga ON a.id_gambar_artikel = ga.id_gambar_artikel
                LEFT JOIN jenis_artikel ja ON a.id_jenis_artikel = ja.id_jenis_artikel
                WHERE a.id_artikel = ?";

$stmt_article = $conn->prepare($sql_article);
if (!$stmt_article) { die("Error preparing article query: " . $conn->error); }
$stmt_article->bind_param("i", $article_id);
$stmt_article->execute();
$result_article = $stmt_article->get_result();
$article = $result_article->fetch_assoc();
$stmt_article->close();

if (!$article) { die("Artikel tidak ditemukan."); }

$reading_time = calculate_reading_time($article['isi_artikel']);
$article_views = rand(500, 2500); // Placeholder

// --- Fetch Approved Comments ---
$comments_list = [];
$approved_comments_count = 0;
$sql_comments = "SELECT comment_author_name, comment_text, comment_date
                 FROM comments
                 WHERE id_artikel = ? AND status = 'approved'
                 ORDER BY comment_date DESC";
$stmt_comments = $conn->prepare($sql_comments);
if ($stmt_comments) {
    $stmt_comments->bind_param("i", $article_id);
    $stmt_comments->execute();
    $result_comments = $stmt_comments->get_result();
    $comments_list = $result_comments->fetch_all(MYSQLI_ASSOC);
    $approved_comments_count = $result_comments->num_rows;
    $stmt_comments->close();
}


// --- Fetch Related Articles ---
$related_articles = [];
if ($article['id_jenis_artikel']) {
    $sql_related = "SELECT a.id_artikel, a.judul_artikel, a.tanggal_dipublish,
                           COALESCE(ga.url, 'https://via.placeholder.com/80x60.png?text=N/A') AS gambar_url
                    FROM artikel a
                    LEFT JOIN gambar_artikel ga ON a.id_gambar_artikel = ga.id_gambar_artikel
                    WHERE a.id_jenis_artikel = ? AND a.id_artikel != ?
                    ORDER BY a.tanggal_dipublish DESC LIMIT 3";
    $stmt_related = $conn->prepare($sql_related);
    if ($stmt_related) {
        $stmt_related->bind_param("ii", $article['id_jenis_artikel'], $article_id);
        $stmt_related->execute();
        $result_related = $stmt_related->get_result();
        $related_articles = $result_related->fetch_all(MYSQLI_ASSOC);
        $stmt_related->close();
    }
}

// --- Fetch Popular Articles ---
$popular_articles = [];
$sql_popular = "SELECT a.id_artikel, a.judul_artikel,
                       COALESCE(ga.url, 'https://via.placeholder.com/80x60.png?text=N/A') AS gambar_url
                FROM artikel a
                LEFT JOIN gambar_artikel ga ON a.id_gambar_artikel = ga.id_gambar_artikel
                WHERE a.id_artikel != ?
                ORDER BY a.tanggal_dipublish DESC LIMIT 3";
$stmt_popular = $conn->prepare($sql_popular);
if ($stmt_popular) {
    $stmt_popular->bind_param("i", $article_id);
    $stmt_popular->execute();
    $result_popular = $stmt_popular->get_result();
    $popular_articles_data = $result_popular->fetch_all(MYSQLI_ASSOC);
    foreach ($popular_articles_data as $pop_article) {
        $popular_articles[] = array_merge($pop_article, ['views' => rand(1000, 5000)]);
    }
    $stmt_popular->close();
}

// --- Fetch Previous and Next Articles ---
$prev_article = null;
$sql_prev = "SELECT id_artikel, judul_artikel FROM artikel WHERE tanggal_dipublish < ? OR (tanggal_dipublish = ? AND id_artikel < ?) ORDER BY tanggal_dipublish DESC, id_artikel DESC LIMIT 1";
$stmt_prev = $conn->prepare($sql_prev);
if($stmt_prev){
    $stmt_prev->bind_param("ssi", $article['tanggal_dipublish'], $article['tanggal_dipublish'], $article_id);
    $stmt_prev->execute();
    $result_prev = $stmt_prev->get_result();
    $prev_article = $result_prev->fetch_assoc();
    $stmt_prev->close();
}

$next_article = null;
$sql_next = "SELECT id_artikel, judul_artikel FROM artikel WHERE tanggal_dipublish > ? OR (tanggal_dipublish = ? AND id_artikel > ?) ORDER BY tanggal_dipublish ASC, id_artikel ASC LIMIT 1";
$stmt_next = $conn->prepare($sql_next);
if($stmt_next){
    $stmt_next->bind_param("ssi", $article['tanggal_dipublish'], $article['tanggal_dipublish'], $article_id);
    $stmt_next->execute();
    $result_next = $stmt_next->get_result();
    $next_article = $result_next->fetch_assoc();
    $stmt_next->close();
}

$tags_array = !empty($article['tag']) ? array_map('trim', explode(',', $article['tag'])) : [];

?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?php echo htmlspecialchars($article['judul_artikel']); ?> - Blog GoTravel</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; background-color: #f8f9fa; }
    .container { max-width: 1200px; margin: 0 auto; padding: 0 1rem; }
    .blog-header { background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('<?php echo htmlspecialchars($article['gambar_utama_url']); ?>') no-repeat center center/cover; min-height: 50vh; display: flex; align-items: center; color: white; position: relative; padding-top: 80px; }
    .header-content { max-width: 800px; }
    .breadcrumb { background: rgba(44, 122, 81, 0.7); padding: 0.5rem 1rem; border-radius: 25px; margin-bottom: 1.5rem; font-size: 0.9rem; display: inline-block; }
    .breadcrumb a { color: white; text-decoration: none; }
    .breadcrumb a:hover { text-decoration: underline; }
    .breadcrumb span { color: #e0e0e0; }
    .article-category { background-color: #2c7a51; color: white; padding: 0.5rem 1rem; border-radius: 25px; font-size: 0.9rem; display: inline-block; margin-bottom: 1rem; }
    .article-title { font-size: 2.5rem; font-weight: bold; margin-bottom: 1rem; line-height: 1.2; }
    .article-meta { display: flex; gap: 1.5rem; flex-wrap: wrap; align-items: center; color: #e0e0e0; font-size: 0.9rem; }
    .meta-item { display: flex; align-items: center; gap: 0.5rem; }
    .meta-item i { color: #f0f0f0; }
    .blog-detail-container { display: flex; gap: 2rem; padding: 3rem 0; }
    .article-content-wrapper { flex: 1; max-width: calc(100% - 320px); }
    .article-content { background: white; padding: 2.5rem; border-radius: 10px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08); }
    .article-body { font-size: 1.05rem; line-height: 1.8; color: #444; }
    .article-body h1, .article-body h2, .article-body h3, .article-body h4 { color: #2c7a51; margin: 2rem 0 1rem 0; line-height: 1.3; }
    .article-body h1 { font-size: 1.8rem; } .article-body h2 { font-size: 1.5rem; } .article-body h3 { font-size: 1.3rem; } .article-body h4 { font-size: 1.1rem; }
    .article-body p { margin-bottom: 1.5rem; text-align: justify; }
    .article-body ul, .article-body ol { margin: 1rem 0 1.5rem 1.5rem; padding-left: 1rem; }
    .article-body li { margin-bottom: 0.75rem; }
    .article-body img { max-width: 100%; height: auto; border-radius: 8px; margin: 2rem 0; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); display: block; }
    .article-body blockquote { background: #f0f4f8; border-left: 5px solid #2c7a51; padding: 1.5rem 2rem; margin: 2rem 0; font-style: italic; border-radius: 0 8px 8px 0; color: #555; }
    .article-body blockquote p { margin-bottom: 0; }
    .social-share { margin: 2.5rem 0; padding: 1.5rem; background: #f8f9fa; border-radius: 8px; text-align: center; }
    .social-share h4 { margin-bottom: 1.5rem; color: #333; font-size: 1.1rem; }
    .share-buttons { display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap; }
    .share-btn { padding: 0.6rem 1.2rem; border: none; border-radius: 25px; color: white; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; transition: opacity 0.3s ease, transform 0.2s ease; font-size: 0.9rem; }
    .share-btn:hover { opacity: 0.85; transform: translateY(-2px); }
    .share-btn.facebook { background: #3b5998; } .share-btn.twitter { background: #1da1f2; } .share-btn.whatsapp { background: #25d366; } .share-btn.linkedin { background: #0077b5; }
    .comments-section { margin-top: 3rem; padding: 2rem; background: white; border-radius: 10px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08); }
    .comments-section h3 { color: #2c7a51; margin-bottom: 1.5rem; font-size: 1.4rem; }
    .comment-form { margin-bottom: 2.5rem; padding: 1.5rem; background: #f8f9fa; border-radius: 8px; border: 1px solid #e9ecef; }
    .comment-form h4 { margin-bottom: 1.5rem; font-size: 1.2rem; color: #333; }
    .comment-submission-status { padding: 10px; margin-bottom: 15px; border-radius: 5px; }
    .comment-submission-status.success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb;}
    .comment-submission-status.error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb;}
    .form-group { margin-bottom: 1.25rem; }
    .form-group label { display: block; margin-bottom: 0.5rem; font-weight: 500; color: #495057; }
    .form-group input, .form-group textarea { width: 100%; padding: 0.85rem; border: 1px solid #ced4da; border-radius: 5px; font-size: 1rem; transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out; }
    .form-group input:focus, .form-group textarea:focus { border-color: #2c7a51; outline: 0; box-shadow: 0 0 0 0.2rem rgba(44, 122, 81, 0.25); }
    .form-group textarea { min-height: 120px; resize: vertical; }
    .submit-btn { background: #2c7a51; color: white; padding: 0.85rem 1.75rem; border: none; border-radius: 5px; cursor: pointer; font-size: 1rem; transition: background 0.3s ease; }
    .submit-btn:hover { background: #1f563a; }
    .comment { border-bottom: 1px solid #e9ecef; padding-bottom: 1.5rem; margin-bottom: 1.5rem; }
    .comment:last-child { border-bottom: none; margin-bottom: 0; }
    .comment-header { display: flex; align-items: center; gap: 1rem; margin-bottom: 0.75rem; }
    .comment-avatar { width: 45px; height: 45px; border-radius: 50%; background: #2c7a51; color: white; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1.1rem; }
    .comment-meta { flex: 1; }
    .comment-author { font-weight: 600; color: #343a40; }
    .comment-date { font-size: 0.85rem; color: #6c757d; }
    .comment-text { color: #495057; line-height: 1.7; padding-left: calc(45px + 1rem); }
    .sidebar { width: 300px; flex-shrink: 0; }
    .sidebar-widget { background: white; padding: 1.5rem; border-radius: 10px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08); margin-bottom: 2rem; }
    .sidebar-widget h3 { color: #2c7a51; margin-top:0; margin-bottom: 1.25rem; font-size: 1.25rem; padding-bottom: 0.75rem; border-bottom: 1px solid #eee; }
    .sidebar-widget ul { list-style: none; padding: 0; margin: 0; }
    .sidebar-widget ul li a { text-decoration: none; color: #333; display: block; padding: 0.5rem 0; border-bottom: 1px solid #f5f5f5; transition: color 0.2s ease; }
    .sidebar-widget ul li:last-child a { border-bottom: none; }
    .sidebar-widget ul li a:hover { color: #2c7a51; }
    .related-post { display: flex; gap: 1rem; margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #f0f0f0; }
    .related-post:last-child { border-bottom: none; margin-bottom: 0; }
    .related-post img { width: 80px; height: 60px; object-fit: cover; border-radius: 5px; flex-shrink: 0; }
    .related-post-content { flex: 1; }
    .related-post-title { font-size: 0.95rem; line-height: 1.4; margin-bottom: 0.25rem; font-weight: 500; }
    .related-post-title a { color: #333; text-decoration: none; }
    .related-post-title a:hover { color: #2c7a51; }
    .related-post-date { font-size: 0.8rem; color: #6c757d; }
    .sidebar-tags-container { display: flex; flex-wrap: wrap; gap: 0.5rem; }
    .sidebar-tag { background: #e9ecef; padding: 0.3rem 0.8rem; border-radius: 15px; font-size: 0.85rem; color: #495057; text-decoration: none; transition: background-color 0.2s ease, color 0.2s ease; }
    .sidebar-tag:hover { background: #2c7a51; color: white; }
    .article-navigation { display: flex; justify-content: space-between; margin-top: 3rem; gap: 1.5rem; }
    .nav-link { flex: 1; padding: 1.25rem; background: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.07); text-decoration: none; color: #333; transition: transform 0.2s ease, box-shadow 0.2s ease; border: 1px solid #e9ecef; }
    .nav-link:hover { transform: translateY(-3px); box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); }
    .nav-link.prev { text-align: left; } .nav-link.next { text-align: right; }
    .nav-label { font-size: 0.85rem; color: #6c757d; margin-bottom: 0.5rem; display: block; }
    .nav-title { font-weight: 500; color: #2c7a51; font-size: 1rem; }
    .reading-progress-bar { position: fixed; top: 0; left: 0; height: 4px; background: #2c7a51; width: 0%; z-index: 2000; transition: width 0.1s ease-out; }
    @media (max-width: 992px) { .blog-detail-container { flex-direction: column; } .sidebar { width: 100%; margin-top: 2rem; } .article-content-wrapper { max-width: 100%; } }
    @media (max-width: 768px) { .article-title { font-size: 2rem; } .article-meta { gap: 1rem; font-size: 0.85rem; } .article-navigation { flex-direction: column; } .nav-link.next { text-align: left; } .article-content { padding: 1.5rem; } }
  </style>
</head>
<body>

  <div class="reading-progress-bar" id="readingProgressBar"></div>

  <header class="blog-header">
    <div class="container">
      <div class="header-content">
        <?php if (!empty($article['nama_kategori'])): ?>
            <div class="article-category"><?php echo htmlspecialchars($article['nama_kategori']); ?></div>
        <?php endif; ?>
        <h1 class="article-title"><?php echo htmlspecialchars($article['judul_artikel']); ?></h1>
        <div class="article-meta">
          <div class="meta-item"><i class="fas fa-user"></i><span>GoTravel Admin</span></div>
          <div class="meta-item"><i class="fas fa-calendar"></i><span><?php echo htmlspecialchars(date("d F Y", strtotime($article['tanggal_dipublish']))); ?></span></div>
          <div class="meta-item"><i class="fas fa-clock"></i><span><?php echo htmlspecialchars($reading_time); ?> baca</span></div>
          <div class="meta-item"><i class="fas fa-eye"></i><span><?php echo htmlspecialchars(number_format($article_views)); ?> views</span></div>
        </div>
      </div>
    </div>
  </header>

  <main class="container blog-detail-container">
    <div class="article-content-wrapper">
        <article class="article-content">
            <div class="article-body">
                <?php echo $article['isi_artikel']; ?>
            </div>

            <div class="social-share">
                <h4>Bagikan Artikel Ini</h4>
                <div class="share-buttons">
                    <a href="#" class="share-btn facebook" aria-label="Bagikan ke Facebook"><i class="fab fa-facebook-f"></i> Facebook</a>
                    <a href="#" class="share-btn twitter" aria-label="Bagikan ke Twitter"><i class="fab fa-twitter"></i> Twitter</a>
                    <a href="#" class="share-btn whatsapp" aria-label="Bagikan ke WhatsApp"><i class="fab fa-whatsapp"></i> WhatsApp</a>
                    <a href="#" class="share-btn linkedin" aria-label="Bagikan ke LinkedIn"><i class="fab fa-linkedin-in"></i> LinkedIn</a>
                </div>
            </div>

            <section class="comments-section" id="comments-section-anchor">
                <h3><i class="fas fa-comments"></i> Komentar (<?php echo $approved_comments_count; ?>)</h3>
                
                <form class="comment-form" method="POST" action="blog_detail.php?id=<?php echo $article_id; ?>#comments-section-anchor">
                    <h4 class="mb-2">Tinggalkan Komentar</h4>
                    <?php if (!empty($comment_submission_message)): ?>
                        <p class="comment-submission-status <?php echo (isset($_GET['comment_success']) || strpos(strtolower($comment_submission_message), 'berhasil') !== false) ? 'success' : 'error'; ?>">
                            <?php echo htmlspecialchars($comment_submission_message); ?>
                        </p>
                    <?php endif; ?>
                    <input type="hidden" name="id_artikel" value="<?php echo $article_id; ?>">
                    <div class="form-group">
                        <label for="comment-name">Nama *</label>
                        <input type="text" id="comment-name" name="name" required value="<?php echo htmlspecialchars($comment_submitted_values['name']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="comment-email">Email</label>
                        <input type="email" id="comment-email" name="email" value="<?php echo htmlspecialchars($comment_submitted_values['email']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="comment-message">Pesan *</label>
                        <textarea id="comment-message" name="message" placeholder="Tulis komentar Anda..." required><?php echo htmlspecialchars($comment_submitted_values['message']); ?></textarea>
                    </div>
                    <button type="submit" name="submit_comment" class="submit-btn">
                        <i class="fas fa-paper-plane"></i> Kirim Komentar
                    </button>
                </form>

                <div class="comments-list">
                    <?php if (empty($comments_list)): ?>
                        <p>Belum ada komentar. Jadilah yang pertama berkomentar!</p>
                    <?php else: ?>
                        <?php foreach ($comments_list as $comment): ?>
                            <?php
                            $author_name_parts = explode(' ', trim($comment['comment_author_name']));
                            $initials = count($author_name_parts) >= 2 ? strtoupper(substr($author_name_parts[0], 0, 1) . substr(end($author_name_parts), 0, 1)) : (count($author_name_parts) == 1 && !empty($author_name_parts[0]) ? strtoupper(substr($author_name_parts[0], 0, 2)) : 'NA');
                            ?>
                            <div class="comment">
                                <div class="comment-header">
                                    <div class="comment-avatar"><?php echo htmlspecialchars($initials); ?></div>
                                    <div class="comment-meta">
                                        <div class="comment-author"><?php echo htmlspecialchars($comment['comment_author_name']); ?></div>
                                        <div class="comment-date"><?php echo htmlspecialchars(date("d F Y, H:i", strtotime($comment['comment_date']))); ?></div>
                                    </div>
                                </div>
                                <div class="comment-text">
                                    <?php echo nl2br(htmlspecialchars($comment['comment_text'])); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </section>

            <nav class="article-navigation">
                <?php if ($prev_article): ?>
                    <a href="blog_detail.php?id=<?php echo htmlspecialchars($prev_article['id_artikel']); ?>" class="nav-link prev">
                        <div class="nav-label"><i class="fas fa-chevron-left"></i> Artikel Sebelumnya</div>
                        <div class="nav-title"><?php echo htmlspecialchars($prev_article['judul_artikel']); ?></div>
                    </a>
                <?php else: ?><div class="nav-link prev" style="opacity:0.5; pointer-events:none; border-color:transparent;">&nbsp;</div><?php endif; ?>
                <?php if ($next_article): ?>
                    <a href="blog_detail.php?id=<?php echo htmlspecialchars($next_article['id_artikel']); ?>" class="nav-link next">
                        <div class="nav-label">Artikel Selanjutnya <i class="fas fa-chevron-right"></i></div>
                        <div class="nav-title"><?php echo htmlspecialchars($next_article['judul_artikel']); ?></div>
                    </a>
                <?php else: ?><div class="nav-link next" style="opacity:0.5; pointer-events:none; border-color:transparent;">&nbsp;</div><?php endif; ?>
            </nav>
        </article>
    </div>

    <aside class="sidebar">
        <?php if (!empty($related_articles)): ?>
        <div class="sidebar-widget">
            <h3><i class="fas fa-newspaper"></i> Artikel Terkait</h3>
            <?php foreach ($related_articles as $related): ?>
                <div class="related-post">
                    <img src="<?php echo htmlspecialchars($related['gambar_url']); ?>" alt="<?php echo htmlspecialchars($related['judul_artikel']); ?>">
                    <div class="related-post-content">
                        <div class="related-post-title"><a href="blog_detail.php?id=<?php echo htmlspecialchars($related['id_artikel']); ?>"><?php echo htmlspecialchars($related['judul_artikel']); ?></a></div>
                        <div class="related-post-date"><?php echo htmlspecialchars(date("d M Y", strtotime($related['tanggal_dipublish']))); ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        <?php if (!empty($popular_articles)): ?>
        <div class="sidebar-widget">
            <h3><i class="fas fa-fire"></i> Artikel Populer</h3>
            <?php foreach ($popular_articles as $popular): ?>
                <div class="related-post">
                    <img src="<?php echo htmlspecialchars($popular['gambar_url']); ?>" alt="<?php echo htmlspecialchars($popular['judul_artikel']); ?>">
                    <div class="related-post-content">
                        <div class="related-post-title"><a href="blog_detail.php?id=<?php echo htmlspecialchars($popular['id_artikel']); ?>"><?php echo htmlspecialchars($popular['judul_artikel']); ?></a></div>
                        <div class="related-post-date"><?php echo htmlspecialchars(number_format($popular['views'])); ?> views</div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        <?php if (!empty($tags_array)): ?>
        <div class="sidebar-widget">
            <h3><i class="fas fa-tags"></i> Tags</h3>
            <div class="sidebar-tags-container">
                <?php foreach ($tags_array as $tag_item): ?>
                    <a href="blog.php?search=<?php echo urlencode($tag_item); ?>" class="sidebar-tag">#<?php echo htmlspecialchars($tag_item); ?></a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </aside>
  </main>

  <?php include 'Komponen/footer.php'; ?>

  <script>
    // Remove comment form JS alert as PHP handles submission.
    // document.querySelector('.comment-form').addEventListener('submit', function(e) { ... });

    document.querySelectorAll('.share-btn').forEach(btn => {
      btn.addEventListener('click', function(e) {
        e.preventDefault();
        const platform = this.classList.value.match(/facebook|twitter|whatsapp|linkedin/)[0];
        const url = encodeURIComponent(window.location.href.split('?')[0] + '?id=<?php echo $article_id; ?>'); // Clean URL for sharing
        const title = encodeURIComponent(document.title);
        let shareUrl;
        switch(platform) {
          case 'facebook': shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`; break;
          case 'twitter': shareUrl = `https://twitter.com/intent/tweet?url=${url}&text=${title}`; break;
          case 'whatsapp': shareUrl = `https://api.whatsapp.com/send?text=${title} ${url}`; break;
          case 'linkedin': shareUrl = `https://www.linkedin.com/sharing/share-offsite/?url=${url}`; break;
        }
        if (shareUrl) window.open(shareUrl, '_blank', 'width=600,height=400');
      });
    });

    window.addEventListener('scroll', function() {
      const progressBar = document.getElementById('readingProgressBar');
      if (!progressBar) return;
      const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
      const scrollHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
      const scrollPercent = (scrollTop / scrollHeight) * 100;
      progressBar.style.width = scrollPercent + '%';
    });

    // If there was a comment submission message, scroll to it (optional)
    // For example, if a GET param 'comment_success' is set.
    if (window.location.search.includes('comment_success=1')) {
        const commentsSection = document.getElementById('comments-section-anchor');
        if (commentsSection) {
            commentsSection.scrollIntoView({ behavior: 'smooth' });
        }
    }
  </script>
</body>
</html>