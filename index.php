<?php
require 'includes/db.php';
require 'includes/auth.php';

$stmt = $pdo->query("SELECT memes.*, users.username FROM memes JOIN users ON memes.user_id = users.id ORDER BY memes.created_at DESC");
$memes = $stmt->fetchAll();

require 'templates/header.php';
?>
<h1 class="text-3xl font-bold mb-6">Meme Terbaru</h1>
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <?php foreach ($memes as $meme): ?>
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <img src="uploads/<?= htmlspecialchars($meme['image']) ?>" alt="<?= htmlspecialchars($meme['title']) ?>" class="w-full h-64 object-cover">
            <div class="p-4">
                <h2 class="text-xl font-semibold"><?= htmlspecialchars($meme['title']) ?></h2>
                <p class="text-gray-500 text-sm">Oleh: <?= htmlspecialchars($meme['username']) ?></p>
                <p class="mt-2 text-sm">Votes: <?= $meme['votes'] ?></p>
                <div class="mt-4 flex justify-between items-center">
                    <a href="vote.php?id=<?= $meme['id'] ?>&type=upvote" class="text-green-600 hover:text-green-800"><i class="fas fa-thumbs-up"></i> Upvote</a>
                    <a href="vote.php?id=<?= $meme['id'] ?>&type=downvote" class="text-red-600 hover:text-red-800"><i class="fas fa-thumbs-down"></i> Downvote</a>
                    <a href="comment.php?id=<?= $meme['id'] ?>" class="text-blue-600 hover:text-blue-800"><i class="fas fa-comment"></i> Komentar</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php require 'templates/footer.php'; ?>