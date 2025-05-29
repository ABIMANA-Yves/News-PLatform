<?php
include 'db.php';
include 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    $message = sanitize($_POST['message']);

    if (!$name || !$email || !$message) {
        setMessage('All fields are required.', 'danger');
        header('Location: about.php');
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO messages (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);
    if ($stmt->execute()) {
        setMessage('Your message has been sent successfully. Thank you!', 'success');
    } else {
        setMessage('Failed to send your message. Please try again later.', 'danger');
    }
    $stmt->close();

    header('Location: about.php');
    exit;
} else {
    header('Location: about.php');
    exit;
}
