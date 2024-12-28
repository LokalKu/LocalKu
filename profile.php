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
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-center mb-4"><?= htmlspecialchars($user['username']) ?>'s Profil</h1>
    <p class="text-lg mb-2"><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
    <p class="text-lg mb-6"><strong>Total Meme Dibuat:</strong> <?= count($memes) ?></p>

    <h2 class="text-xl font-semibold mb-4">Meme yang diunggah:</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        <?php foreach ($memes as $meme): ?>
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="relative pb-3/4">
                    <img src="uploads/<?= htmlspecialchars($meme['image']) ?>" alt="<?= htmlspecialchars($meme['title']) ?>" class="absolute inset-0 w-full h-full object-cover">
                </div>
                <div class="p-4">
                    <p class="text-center font-semibold"><?= htmlspecialchars($meme['title']) ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php require 'templates/footer.php'; ?>