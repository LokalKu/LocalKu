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
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        header('Location: index.php');
        exit();
    } else {
        $error = 'Username atau password salah.';
    }
}

require 'templates/header.php';
?>
<h1 class="title">Masuk</h1>
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
        <label class="label">Password</label>
        <div class="control">
            <input type="password" name="password" class="input" required>
        </div>
    </div>
    <div class="field">
        <button class="button is-primary">Masuk</button>
    </div>
</form>
<?php require 'templates/footer.php'; ?>
