<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>About Us - CNews</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">📰 CNews</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="about.php">About</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Admin Login</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container py-5">
    <h1>About CNews</h1>
    <p class="lead">
        Welcome to CNews! We are committed to bringing you the latest and most accurate news across a variety of categories including politics, health, entertainment, sports, technology, remembrance, and economy.
    </p>
    <p>
        Our goal is to keep you informed with trustworthy news, presented in a clean, user-friendly interface. This platform was developed as a simple PHP and MySQL project featuring an admin-managed news publishing system.
    </p>
    <p>
        Feel free to browse, read, and stay updated with current events.
    </p>

    <hr>

    <h3>Contact Us</h3>
    <p>If you have any problems, questions, or feedback, please fill out the form below and we will get back to you as soon as possible.</p>

    <form action="contact_process.php" method="post" class="mt-4 needs-validation" novalidate>
        <div class="mb-3">
            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="name" name="name" required>
            <div class="invalid-feedback">
                Please enter your name.
            </div>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
            <input type="email" class="form-control" id="email" name="email" required>
            <div class="invalid-feedback">
                Please enter a valid email address.
            </div>
        </div>

        <div class="mb-3">
            <label for="message" class="form-label">Message <span class="text-danger">*</span></label>
            <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
            <div class="invalid-feedback">
                Please enter your message.
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Send Message</button>
    </form>
</div>

<footer class="bg-primary text-white text-center py-3 mt-5">
    &copy; <?= date('Y') ?> CNews. All rights reserved.
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Bootstrap client-side validation
(() => {
  'use strict'
  const forms = document.querySelectorAll('.needs-validation')
  Array.from(forms).forEach(form => {
    form.addEventListener('submit', event => {
      if (!form.checkValidity()) {
        event.preventDefault()
        event.stopPropagation()
      }
      form.classList.add('was-validated')
    }, false)
  })
})()
</script>
</body>
</html>
