<?php
include 'db.php';
include 'functions.php';

checkLogin(); // Ensure only logged-in admin can access

$title = $category = $content = "";
$errors = [];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = sanitize($_POST["title"]);
    $category = sanitize($_POST["category"]);
    $content = sanitize($_POST["content"]);
    $imagePath = '';

    // Handle image upload
    if (!empty($_FILES['image']['name'])) {
        $upload = uploadImage($_FILES['image']);
        if ($upload !== false) {
            $imagePath = $upload;
        } else {
            $errors[] = "Invalid image. Please upload jpg, png, or gif.";
        }
    }

    if (!$errors) {
        $stmt = $conn->prepare("INSERT INTO news (title, category, content, image) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $title, $category, $content, $imagePath);
        $stmt->execute();
        setMessage("✅ Article created successfully.");
        header("Location: dashboard.php");
        exit();
    }
}

// Fetch categories
$categories = $conn->query("SELECT name FROM categories ORDER BY name ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Article - CNews</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body class="bg-light">

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-7 col-md-9">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="mb-4 text-center">📝 Create New Article</h4>

                    <?php showMessage(); ?>

                    <?php if ($errors): ?>
                        <div class="alert alert-danger">
                            <?php foreach ($errors as $error) echo "<div>$error</div>"; ?>
                        </div>
                    <?php endif; ?>

                    <form method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" value="<?= htmlspecialchars($title) ?>" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select name="category" class="form-select" required>
                                <option value="">-- Select Category --</option>
                                <?php while ($cat = $categories->fetch_assoc()): ?>
                                    <option value="<?= htmlspecialchars($cat['name']) ?>" <?= ($category == $cat['name']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($cat['name']) ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Content</label>
                            <textarea name="content" class="form-control" rows="6" required><?= htmlspecialchars($content) ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Image (optional)</label>
                            <input type="file" name="image" accept="image/*" class="form-control">
                        </div>

                        <button class="btn btn-success w-100">Publish Article</button>
                    </form>

                    <div class="text-center mt-3">
                        <a href="dashboard.php" class="btn btn-link">🔙 Back to Dashboard</a>
                    </div>
                </div>
            </div>

            <p class="text-center text-muted mt-3">CNews Admin Panel</p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
