<?php

include 'db.php';
include 'functions.php';

// Check admin login
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Validate article ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    setMessage("Invalid article ID.");
    header("Location: manage_articles.php");
    exit();
}

$article_id = intval($_GET['id']);

// Fetch article data
$stmt = $conn->prepare("SELECT * FROM news WHERE id = ?");
$stmt->bind_param("i", $article_id);
$stmt->execute();
$result = $stmt->get_result();
$article = $result->fetch_assoc();

if (!$article) {
    setMessage("Article not found.");
    header("Location: manage_articles.php");
    exit();
}

// Load categories
$categories = $conn->query("SELECT * FROM categories ORDER BY name ASC");

// Update article
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = sanitize($_POST['title']);
    $content = sanitize($_POST['content']);
    $category = sanitize($_POST['category']);

    $image = $article['image'];

    if (!empty($_FILES['image']['name'])) {
        $image = time() . '_' . basename($_FILES['image']['name']);
        $target = "uploads/" . $image;
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
    }

    $stmt = $conn->prepare("UPDATE news SET title = ?, content = ?, category = ?, image = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $title, $content, $category, $image, $article_id);
    if ($stmt->execute()) {
        setMessage("Article updated successfully.");
        header("Location: manage_articles.php");
        exit();
    } else {
        $error = "Update failed: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Article - CNews</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="mb-4 text-center">✏️ Edit Article</h2>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data" class="card p-4 shadow-sm">
        <div class="mb-3">
            <label class="form-label">Title:</label>
            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($article['title']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Category:</label>
            <select name="category" class="form-select" required>
                <option value="">-- Select Category --</option>
                <?php while ($cat = $categories->fetch_assoc()): ?>
                    <option value="<?= htmlspecialchars($cat['name']) ?>" <?= ($article['category'] == $cat['name']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat['name']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Content:</label>
            <textarea name="content" rows="6" class="form-control" required><?= htmlspecialchars($article['content']) ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Current Image:</label><br>
            <?php if ($article['image']): ?>
                <img src="uploads/<?= $article['image'] ?>" width="200" class="img-thumbnail mb-2">
            <?php else: ?>
                <p>No image uploaded.</p>
            <?php endif; ?>
            <input type="file" name="image" class="form-control mt-2">
        </div>

        <button type="submit" class="btn btn-primary w-100">Update Article</button>
    </form>
</div>

</body>
</html>
