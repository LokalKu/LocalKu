<?php
require 'includes/db.php';
require 'templates/header.php';

$memes = $pdo->query("SELECT memes.*, users.username FROM memes JOIN users ON memes.user_id = users.id ORDER BY memes.created_at DESC")->fetchAll();
?>
<h1 class="title">Beranda Meme</h1>
<?php foreach ($memes as $meme): ?>
    <div class="card">
        <h2 class="card-title"><?= htmlspecialchars($meme['title']) ?></h2>
        <p>Oleh: <?= htmlspecialchars($meme['username']) ?></p>
        <img src="uploads/<?= htmlspecialchars($meme['image']) ?>" alt="<?= htmlspecialchars($meme['title']) ?>" class="image">
        <div>
            <a href="vote.php?id=<?= $meme['id'] ?>&type=upvote" class="button is-primary">
                <i class="fas fa-thumbs-up"></i>
            </a>
            <a href="vote.php?id=<?= $meme['id'] ?>&type=downvote" class="button is-danger">
                <i class="fas fa-thumbs-down"></i>
            </a>
            <span><?= $meme['votes'] ?> Votes</span>
        </div>
    </div>
<?php endforeach; ?>
<?php require 'templates/footer.php'; ?>
