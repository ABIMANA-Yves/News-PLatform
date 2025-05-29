<?php
include 'db.php';
include 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category = sanitize($_POST['category']);
    if (!empty($category)) {
        $stmt = $conn->prepare("INSERT INTO categories (name) VALUES (?)");
        $stmt->bind_param("s", $category);
        $stmt->execute();
        setMessage("Category added successfully!");
        header("Location: manage_categories.php");
        exit();
    } else {
        setMessage("Category name is required!");
    }
}

if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    setMessage("Category deleted.");
    header("Location: manage_categories.php");
    exit();
}

// Fetch categories
$categories = $conn->query("SELECT * FROM categories ORDER BY name ASC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Categories - CNews</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">📂 Manage Categories</h2>
        <a href="dashboard.php" class="btn btn-secondary">← Back to Dashboard</a>
    </div>

    <?php if ($msg = getMessage()): ?>
        <div class="alert alert-info"><?= $msg ?></div>
    <?php endif; ?>

    <form method="POST" class="mb-4">
        <div class="input-group">
            <input type="text" name="category" class="form-control" placeholder="Enter new category..." required>
            <button type="submit" class="btn btn-success">Add Category</button>
        </div>
    </form>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">📋 Existing Categories</div>
        <div class="card-body">
            <?php if ($categories->num_rows > 0): ?>
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Category Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; while ($cat = $categories->fetch_assoc()): ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= htmlspecialchars($cat['name']) ?></td>
                                <td>
                                    <a href="?delete=<?= $cat['id'] ?>" class="btn btn-danger btn-sm"
                                       onclick="return confirm('Are you sure you want to delete this category?')">
                                        Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-muted">No categories available.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
