<?php

require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/auth.php';

redirectIfNotLoggedIn();

$user_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ?? $_SESSION['user_id'];

// Ambil data pengguna termasuk avatar
$stmt = $pdo->prepare("SELECT username, avatar FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    http_response_code(404);
    die('User not found.');
}

// Ambil daftar meme pengguna
$stmt = $pdo->prepare("SELECT * FROM memes WHERE user_id = ?");
$stmt->execute([$user_id]);
$memes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Proses voting
$meme_id = filter_input(INPUT_GET, 'meme_id', FILTER_VALIDATE_INT);
$type = htmlspecialchars($_GET['type'] ?? '');

if ($meme_id && in_array($type, ['upvote', 'downvote'], true)) {
    $stmt = $pdo->prepare("SELECT * FROM votes WHERE user_id = ? AND meme_id = ?");
    $stmt->execute([$_SESSION['user_id'], $meme_id]);
    $existingVote = $stmt->fetch();

    if (!$existingVote) {
        $stmt = $pdo->prepare("INSERT INTO votes (user_id, meme_id, vote_type) VALUES (?, ?, ?)");
        $stmt->execute([$_SESSION['user_id'], $meme_id, $type]);

        $voteChange = ($type === 'upvote') ? 1 : -1;
        $stmt = $pdo->prepare("UPDATE memes SET votes = votes + ? WHERE id = ?");
        $stmt->execute([$voteChange, $meme_id]);
    }
}

require_once __DIR__ . '/templates/header.php';
?>

<title><?= htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8') ?> - LokalKu</title>
<div class="container mx-auto max-w-4xl py-10">
    <!-- Informasi Pengguna -->
    <div class="text-center mb-8">
        <?php if ($user['avatar']): ?>
            <img src="/<?= htmlspecialchars($user['avatar'], ENT_QUOTES, 'UTF-8') ?>" 
                 alt="<?= htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8') ?>" 
                 class="w-24 h-24 rounded-full mx-auto mb-4 border border-gray-300">
        <?php else: ?>
            <div class="w-24 h-24 rounded-full bg-gray-300 mx-auto mb-4 flex items-center justify-center">
                <i class="fas fa-user text-2xl text-gray-600"></i>
            </div>
        <?php endif; ?>
        <h1 class="text-4xl font-bold text-gray-800"><?= htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8') ?></h1>
        <div class="text-gray-600 mt-2">Total Memes: <?= count($memes) ?></div>
    </div>

    <!-- Daftar Meme -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php if (count($memes) > 0): ?>
            <?php foreach ($memes as $meme): ?>
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-transform transform hover:scale-105">
                    <div class="aspect-w-16 aspect-h-9 bg-gray-100">
                        <img 
                            src="/uploads/<?= htmlspecialchars($meme['image'], ENT_QUOTES, 'UTF-8') ?>" 
                            alt="<?= htmlspecialchars($meme['title'], ENT_QUOTES, 'UTF-8') ?>" 
                            class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <h2 class="text-lg font-semibold text-gray-800 truncate">
                            <?= htmlspecialchars($meme['title']) ?>
                        </h2>
                        <p class="mt-3 text-sm font-medium text-gray-600">Votes: 
                            <span id="votes-<?= $meme['id'] ?>"><?= htmlspecialchars($meme['votes']) ?></span>
                        </p>
                        <div class="mt-4 flex justify-between items-center">
                            <a href="javascript:void(0)" 
                               onclick="vote(<?= $meme['id'] ?>, 'upvote')" 
                               class="text-green-600 hover:text-green-800 flex items-center">
                                <i class="fas fa-thumbs-up mr-2"></i> Upvote
                            </a>
                            <a href="javascript:void(0)" 
                               onclick="vote(<?= $meme['id'] ?>, 'downvote')" 
                               class="text-red-600 hover:text-red-800 flex items-center">
                                <i class="fas fa-thumbs-down mr-2"></i> Downvote
                            </a>
                            <button 
                                onclick="openModal(<?= $meme['id'] ?>)" 
                                class="text-blue-600 hover:text-blue-800 flex items-center">
                                <i class="fas fa-comment mr-2"></i> Komentar
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="text-center text-gray-600 col-span-full">
                <p>Pengguna ini belum upload/memiliki meme.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    async function vote(memeId, type) {
        const response = await fetch(`/vote.php?meme_id=${memeId}&type=${type}`);
        const result = await response.json();
        if (result.success) {
            document.getElementById(`votes-${memeId}`).textContent = result.votes;
        } else {
            alert(result.message || 'Terjadi kesalahan.');
        }
    }

    async function openModal(memeId) {
        document.getElementById('meme_id').value = memeId;
        const modal = document.getElementById('commentModal');
        modal.classList.remove('hidden');

        const response = await fetch(`/comment.php?meme_id=${memeId}`);
        const comments = await response.json();

        const commentList = document.getElementById('comments-list');
        commentList.innerHTML = '';

        comments.forEach(comment => {
            const li = document.createElement('li');
            li.classList.add('text-sm', 'text-gray-600', 'mb-2');
            li.innerHTML = `<strong>${comment.username}</strong>: ${comment.content}`;
            commentList.appendChild(li);
        });
    }

    function closeModal() {
        document.getElementById('commentModal').classList.add('hidden');
    }
</script>

<?php require_once __DIR__ . '/templates/footer.php'; ?>