

<?php
session_start(); // Start session on all pages that include this file

// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Redirect to login if not logged in
function redirectIfNotLoggedIn() {
    if (!isLoggedIn()) {
        header("Location: login.php");
        exit();
    }
}

// Check if the current user is an admin
function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

// Show session messages (success/error)
function showMessage() {
    if (isset($_SESSION['message'])) {
        echo '<div class="message">' . $_SESSION['message'] . '</div>';
        unset($_SESSION['message']);
    }
}

// Sanitize input data
function sanitize($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

// function sanitize($data) {
//     return htmlspecialchars(trim($data));
// }

function setMessage($msg) {
    $_SESSION['message'] = $msg;
}

function getMessage() {
    if (isset($_SESSION['message'])) {
        $msg = $_SESSION['message'];
        unset($_SESSION['message']);
        return $msg;
    }
    return null;
}

function checkLogin() {
    if (!isset($_SESSION['admin_id'])) {
        $_SESSION['message'] = "You must log in first.";
        header("Location: login.php");
        exit();
    }
}

function uploadImage($file) {
    $targetDir = "uploads/";
    $filename = basename($file["name"]);
    $targetFile = $targetDir . uniqid() . "_" . $filename;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

    // Validate image file
    $check = getimagesize($file["tmp_name"]);
    if ($check === false) {
        return false;
    }

    // Validate extension
    if (!in_array($imageFileType, $allowedTypes)) {
        return false;
    }

    // Move file
    if (move_uploaded_file($file["tmp_name"], $targetFile)) {
        return $targetFile;
    }

    return false;
}


?>
