<?php
require 'includes/db.php';
require 'includes/auth.php';

if (isLoggedIn()) {
    header('Location: index.php');
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $password]);
        header('Location: login.php');
        exit();
    } catch (PDOException $e) {
        $error = 'Gagal mendaftar. Username atau email sudah digunakan.';
    }
}

require 'templates/header.php';
?>
<h1 class="title">Daftar</h1>
<?php if ($error): ?>
    <div class="notification is-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>
<form method="POST">
    <div class="field">
        <label class="label">Username</label>
        <div class="control">
            <input type="text" name="username" class="input" required>
        </div>
    </div>
    <div class="field">
        <label class="label">Email</label>
        <div class="control">
            <input type="email" name="email" class="input" required>
        </div>
    </div>
    <div class="field">
        <label class="label">Password</label>
        <div class="control">
            <input type="password" name="password" class="input" required>
        </div>
    </div>
    <div class="field">
        <button class="button is-primary">Daftar</button>
    </div>
</form>
<?php require 'templates/footer.php'; ?>
