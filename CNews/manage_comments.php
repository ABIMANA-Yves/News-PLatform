<?php
include 'db.php';
include 'functions.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

// Handle comment deletion
if (isset($_GET['delete'])) {
    $commentId = (int) $_GET['delete'];
    $conn->query("DELETE FROM comments WHERE id = $commentId");
    header("Location: manage_comments.php");
    exit;
}

// Fetch all comments
$sql = "SELECT comments.*, news.title FROM comments JOIN news ON comments.news_id = news.id ORDER BY comments.created_at DESC";
$comments = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Comments - CNews Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-4">
    <h2>User Comments</h2>

    <?php if ($comments->num_rows === 0): ?>
        <div class="alert alert-info">No comments found.</div>
    <?php else: ?>
        <table class="table table-bordered table-hover">
            <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>Article</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Comment</th>
                    <th>Sent At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($comment = $comments->fetch_assoc()): ?>
                    <tr>
                        <td><?= $comment['id'] ?></td>
                        <td><?= htmlspecialchars($comment['title']) ?></td>
                        <td><?= htmlspecialchars($comment['name']) ?></td>
                        <td><?= htmlspecialchars($comment['email']) ?></td>
                        <td><?= nl2br(htmlspecialchars($comment['comment'])) ?></td>
                        <td><?= date("F j, Y, g:i a", strtotime($comment['created_at'])) ?></td>
                        <td>
                            <a href="?delete=<?= $comment['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this comment?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <a href="dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
