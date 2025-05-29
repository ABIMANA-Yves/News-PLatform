<?php

include 'db.php';
include 'functions.php';

// ✅ Admin authentication check
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$name = $_SESSION['admin_name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CNews Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- ✅ Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">📰 CNews Admin</a>
            <div class="d-flex">
                <span class="navbar-text text-white me-3">
                    👋 Welcome, <?= htmlspecialchars($name) ?>
                </span>
                <a href="logout.php" class="btn btn-outline-light">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h3 class="text-center mb-4">🛠 Admin Control Panel</h3>

        <div class="row g-4">
            <!-- 📝 Create News -->
            <div class="col-md-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body text-center">
                        <h5 class="card-title">📝 Create News</h5>
                        <p class="card-text">Write and publish a new article.</p>
                        <a href="create_article.php" class="btn btn-primary w-100">Create News</a>
                    </div>
                </div>
            </div>

            <!-- 📰 Manage Articles -->
            <div class="col-md-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body text-center">
                        <h5 class="card-title">📰 Manage Articles</h5>
                        <p class="card-text">Edit or delete published news.</p>
                        <a href="manage_articles.php" class="btn btn-success w-100">Manage Articles</a>
                    </div>
                </div>
            </div>

            <!-- 📂 Manage Categories -->
            <div class="col-md-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body text-center">
                        <h5 class="card-title">📂 Manage Categories</h5>
                        <p class="card-text">Organize news by category.</p>
                        <a href="manage_categories.php" class="btn btn-secondary w-100">Manage Categories</a>
                    </div>
                </div>
            </div>

             <!-- 📂 Manage messages -->
             <div class="col-md-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body text-center">
                        <h5 class="card-title">📂 Manage Messages</h5>
                        <p class="card-text">Organize messages</p>
                        <a href="manage_messages.php" class="btn btn-info mb-3 w-100">Manage Messages</a>
                    </div>
                </div>
            </div>

             <!-- 📂 Manage comments -->
             <div class="col-md-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body text-center">
                        <h5 class="card-title">📂 Manage Comments</h5>
                        <p class="card-text">Organize Comments</p>
                        <a href="manage_comments.php" class="btn btn-info mb-3 w-100">Manage Comments</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-5">
            <a href="index.php" class="btn btn-outline-dark">🔍 View Public Site</a>
        </div>
    </div>

    <!-- ✅ Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
