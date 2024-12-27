<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meme Indonesia</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<nav class="navbar">
    <div class="container">
        <div class="navbar-brand">
            <a href="index.php" class="navbar-item">Meme Indonesia</a>
        </div>
        <div class="navbar-end">
            <?php if (isLoggedIn()): ?>
                <a href="profile.php" class="navbar-item">Profil</a>
                <a href="upload.php" class="navbar-item">Upload Meme</a>
                <a href="logout.php" class="navbar-item">Keluar</a>
            <?php else: ?>
                <a href="login.php" class="navbar-item">Masuk</a>
                <a href="register.php" class="navbar-item">Daftar</a>
            <?php endif; ?>
        </div>
    </div>
</nav>
<section class="section">
    <div class="container">
