<?php
require 'includes/db.php';
require 'includes/auth.php';

redirectIfNotLoggedIn();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'] ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;

    try {
        $stmt = $pdo->prepare("UPDATE users SET email = ?, password = IFNULL(?, password) WHERE id = ?");
        $stmt->execute([$email, $password, $_SESSION['user_id']]);
        $success = 'Pengaturan berhasil diperbarui.';
    } catch (PDOException $e) {
        $error = 'Terjadi kesalahan saat memperbarui pengaturan.';
    }
}

$stmt = $pdo->prepare("SELECT email FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

require 'templates/header.php';
?>
<h1 class="title">Pengaturan</h1>
<?php if ($error): ?>
    <div class="notification is-danger"><?= htmlspecialchars($error) ?></div>
<?php elseif ($success): ?>
    <div class="notification is-success"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>
<form method="POST">
    <div class="field">
        <label class="label">Email</label>
        <div class="control">
            <input type="email" name="email" class="input" value="<?= htmlspecialchars($user['email']) ?>" required>
        </div>
    </div>
    <div class="field">
        <label class="label">Password Baru (Opsional)</label>
        <div class="control">
            <input type="password" name="password" class="input">
        </div>
    </div>
    <div class="field">
        <button class="button is-primary">Simpan</button>
    </div>
</form>
<?php require 'templates/footer.php'; ?>
