<?php
include 'db.php';
include 'functions.php';

// Fetch categories
$categoriesResult = $conn->query("SELECT * FROM categories ORDER BY name ASC");

// Get selected category from URL
$selectedCategory = isset($_GET['category']) ? sanitize($_GET['category']) : '';

// Get search term from URL
$searchTerm = isset($_GET['search']) ? sanitize($_GET['search']) : '';

// Prepare articles query based on category or search
if ($searchTerm) {
    $stmt = $conn->prepare("SELECT * FROM news WHERE title LIKE CONCAT('%', ?, '%') OR content LIKE CONCAT('%', ?, '%') ORDER BY created_at DESC");
    $stmt->bind_param("ss", $searchTerm, $searchTerm);
} elseif ($selectedCategory) {
    $stmt = $conn->prepare("SELECT * FROM news WHERE category = ? ORDER BY created_at DESC");
    $stmt->bind_param("s", $selectedCategory);
} else {
    $stmt = $conn->prepare("SELECT * FROM news ORDER BY created_at DESC");
}
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>CNews - Latest News</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        .navbar-nav .nav-link {
            color: #fff !important;
        }
        .navbar-nav .nav-link.active {
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 0.25rem;
        }
        .card:hover {
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.15);
        }
        /* Make card images responsive with fixed height but cover */
        .card-img-top {
            height: 200px;
            object-fit: cover;
            width: 100%;
        }
        /* Smaller font on smaller devices */
        @media (max-width: 575.98px) {
            .card-title {
                font-size: 1.1rem;
            }
            .card-text {
                font-size: 0.9rem;
            }
            .form-control {
                font-size: 0.9rem;
            }
            .btn {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body class="bg-light">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">📰 CNews</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
                aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse flex-column flex-lg-row" id="navbarContent">
            <!-- First row: Home, Categories, About -->
            <ul class="navbar-nav me-auto mb-3 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?= empty($selectedCategory) && !$searchTerm ? 'active' : '' ?>" href="index.php">Home</a>
                </li>

                <?php while ($cat = $categoriesResult->fetch_assoc()): ?>
                    <li class="nav-item">
                        <a class="nav-link <?= ($selectedCategory === $cat['name']) ? 'active' : '' ?>"
                           href="index.php?category=<?= urlencode($cat['name']) ?>">
                            <?= htmlspecialchars($cat['name']) ?>
                        </a>
                    </li>
                <?php endwhile; ?>

                <li class="nav-item">
                    <a class="nav-link <?= (basename($_SERVER['PHP_SELF']) === 'about.php') ? 'active' : '' ?>" href="about.php">About</a>
                </li>
            </ul>

            <!-- Second row: Search form and Admin Login -->
            <div class="d-flex w-100 w-lg-auto justify-content-between align-items-center">
                <form class="d-flex me-3" method="get" action="index.php" role="search">
                    <input
                        class="form-control me-2"
                        type="search"
                        name="search"
                        placeholder="Search news..."
                        aria-label="Search"
                        value="<?= htmlspecialchars($searchTerm) ?>"
                        required
                    >
                    <button class="btn btn-light" type="submit">Search</button>
                </form>

                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Admin Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="container py-4">
    <?php if ($searchTerm): ?>
        <h3 class="text-secondary mb-4">Search results for: <strong><?= htmlspecialchars($searchTerm) ?></strong></h3>
    <?php elseif ($selectedCategory): ?>
        <h3 class="text-secondary mb-4">Showing news in: <strong><?= htmlspecialchars($selectedCategory) ?></strong></h3>
    <?php else: ?>
        <h3 class="mb-4 text-primary">Latest News Articles</h3>
    <?php endif; ?>

    <?php if ($result->num_rows === 0): ?>
        <div class="alert alert-info text-center">No articles found.</div>
    <?php else: ?>
        <div class="row g-4">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-12 col-md-6 col-lg-4">
                    <a href="news.php?id=<?= $row['id'] ?>" class="text-decoration-none text-dark">
                        <div class="card h-100 shadow-sm">
                            <?php if (!empty($row['image'])): ?>
                                <img src="uploads/<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['title']) ?>" class="card-img-top" />
                            <?php endif; ?>
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($row['title']) ?></h5>
                                <p class="text-muted mb-1">📅 <?= date("F j, Y", strtotime($row['created_at'])) ?></p>
                                <span class="badge bg-secondary mb-2"><?= htmlspecialchars($row['category']) ?></span>
                                <p class="card-text"><?= substr(strip_tags($row['content']), 0, 100) ?>...</p>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endwhile; ?>
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
