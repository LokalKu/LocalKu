<?php
require 'includes/db.php';
require 'includes/auth.php';

redirectIfNotLoggedIn();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $image = $_FILES['image'];

    if ($image['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '.' . $ext;
        move_uploaded_file($image['tmp_name'], "uploads/$filename");

        $stmt = $pdo->prepare("INSERT INTO memes (user_id, title, image) VALUES (?, ?, ?)");
        $stmt->execute([$_SESSION['user_id'], $title, $filename]);
        header('Location: index.php');
        exit();
    } else {
        $error = 'Gagal mengunggah gambar.';
    }
}

require 'templates/header.php';
?>
<h1 class="title">Upload Meme</h1>
<?php if ($error): ?>
    <div class="notification is-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>
<form method="POST" enctype="multipart/form-data">
    <div class="field">
        <label class="label">Judul</label>
        <div class="control">
            <input type="text" name="title" class="input" required>
        </div>
    </div>
    <div class="field">
        <label class="label">Gambar</label>
        <div class="control">
            <input type="file" name="image" class="input" accept="image/*" required>
        </div>
    </div>
    <div class="field">
        <button class="button is-primary">Unggah</button>
    </div>
</form>
<?php require 'templates/footer.php'; ?>
