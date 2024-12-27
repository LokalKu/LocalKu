<?php
require 'includes/db.php';
require 'includes/auth.php';

redirectIfNotLoggedIn();

$user_id = $_GET['id'] ?? $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if (!$user) {
    http_response_code(404);
    die('Pengguna tidak ditemukan.');
}

$stmt = $pdo->prepare("SELECT * FROM memes WHERE user_id = ?");
$stmt->execute([$user_id]);
$memes = $stmt->fetchAll();

require 'templates/header.php';
?>
<h1 class="title"><?= htmlspecialchars($user['username']) ?>'s Profil</h1>
<p>Email: <?= htmlspecialchars($user['email']) ?></p>
<p>Total Meme Dibuat: <?= count($memes) ?></p>
<h2 class="subtitle">Meme yang diunggah:</h2>
<div class="columns is-multiline">
    <?php foreach ($memes as $meme): ?>
        <div class="column is-one-third">
            <div class="card">
                <div class="card-image">
                    <figure class="image is-4by3">
                        <img src="uploads/<?= htmlspecialchars($meme['image']) ?>" alt="<?= htmlspecialchars($meme['title']) ?>">
                    </figure>
                </div>
                <div class="card-content">
                    <p><?= htmlspecialchars($meme['title']) ?></p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php require 'templates/footer.php'; ?>
