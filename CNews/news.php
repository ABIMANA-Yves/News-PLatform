<?php
include 'db.php';
include 'functions.php';

$newsId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch news article
$stmt = $conn->prepare("SELECT * FROM news WHERE id = ?");
$stmt->bind_param("i", $newsId);
$stmt->execute();
$result = $stmt->get_result();
$article = $result->fetch_assoc();

if (!$article) {
    die("Article not found.");
}

// Handle comment submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    $comment = sanitize($_POST['comment']);

    if ($name && $email && $comment) {
        $stmt = $conn->prepare("INSERT INTO comments (news_id, name, email, comment) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $newsId, $name, $email, $comment);
        $stmt->execute();
    }
}

// Fetch comments
$commentStmt = $conn->prepare("SELECT * FROM comments WHERE news_id = ? ORDER BY created_at DESC");
$commentStmt->bind_param("i", $newsId);
$commentStmt->execute();
$commentsResult = $commentStmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars($article['title']) ?> - CNews</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <h2><?= htmlspecialchars($article['title']) ?></h2>
    <p class="text-muted">📅 <?= date("F j, Y", strtotime($article['created_at'])) ?></p>
    <span class="badge bg-secondary"><?= htmlspecialchars($article['category']) ?></span>
    <?php if (!empty($article['image'])): ?>
        <img src="uploads/<?= htmlspecialchars($article['image']) ?>" class="img-fluid my-3">
    <?php endif; ?>
    <p><?= nl2br(htmlspecialchars($article['content'])) ?></p>

    <!-- Back to home button -->
    <a href="index.php" class="btn btn-outline-primary mb-4">← Back to Home</a>

    <hr>
    <h4>Comments</h4>

    <!-- Display comments -->
    <?php if ($commentsResult->num_rows == 0): ?>
        <p class="text-muted">No comments yet. Be the first to comment!</p>
    <?php else: ?>
        <?php while ($com = $commentsResult->fetch_assoc()): ?>
            <div class="border p-2 mb-2 bg-white shadow-sm">
                <strong><?= htmlspecialchars($com['name']) ?></strong> 
                (<?= htmlspecialchars($com['email']) ?>)
                <small class="text-muted float-end"><?= date("F j, Y, g:i a", strtotime($com['created_at'])) ?></small>
                <p class="mb-1"><?= nl2br(htmlspecialchars($com['comment'])) ?></p>
            </div>
        <?php endwhile; ?>
    <?php endif; ?>

    <!-- Comment form -->
    <form method="post" class="mt-4">
        <div class="mb-3">
            <label for="name" class="form-label">Your name:</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Your email:</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="comment" class="form-label">Your comment:</label>
            <textarea name="comment" id="comment" class="form-control" rows="3" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Post Comment</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
