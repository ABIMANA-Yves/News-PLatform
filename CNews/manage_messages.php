<?php
include 'db.php';
include 'functions.php';

// Check admin login
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

// Handle deletion
if (isset($_GET['delete'])) {
    $msgId = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM messages WHERE id = ?");
    $stmt->bind_param("i", $msgId);
    $stmt->execute();
    $stmt->close();

    header("Location: manage_messages.php?deleted=1");
    exit;
}

// Fetch messages
$result = $conn->query("SELECT * FROM messages ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Messages - CNews Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function confirmDelete(id) {
            if (confirm("Are you sure you want to delete this message?")) {
                window.location = "manage_messages.php?delete=" + id;
            }
        }
    </script>
</head>
<body>
<div class="container py-4">
    <h2>Messages from Users</h2>

    <?php if (isset($_GET['deleted'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            ✅ Message successfully deleted.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if ($result->num_rows == 0): ?>
        <div class="alert alert-info">No messages found.</div>
    <?php else: ?>
        <table class="table table-bordered table-hover">
            <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Sent At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($msg = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $msg['id'] ?></td>
                        <td><?= htmlspecialchars($msg['name']) ?></td>
                        <td><?= htmlspecialchars($msg['email']) ?></td>
                        <td><?= nl2br(htmlspecialchars($msg['message'])) ?></td>
                        <td><?= date("F j, Y, g:i a", strtotime($msg['created_at'])) ?></td>
                        <td>
                            <button onclick="confirmDelete(<?= $msg['id'] ?>)" class="btn btn-sm btn-danger">Delete</button>
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
