<?php

require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/auth.php';

$query = "
    SELECT u.username, u.avatar, COUNT(m.id) AS total_memes, COALESCE(SUM(m.votes), 0) AS total_votes
    FROM users u
    LEFT JOIN memes m ON u.id = m.user_id
    GROUP BY u.id
    ORDER BY total_votes DESC, total_memes DESC
";
$stmt = $pdo->prepare($query);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

require_once __DIR__ . '/templates/header.php';
?>

<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-center mb-6">Leaderboard</h1>
    <div class="overflow-x-auto">
        <table class="min-w-full border-collapse border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border border-gray-300 px-4 py-2 text-left font-semibold">Rank</th>
                    <th class="border border-gray-300 px-4 py-2 text-left font-semibold">Avatar</th>
                    <th class="border border-gray-300 px-4 py-2 text-left font-semibold">Username</th>
                    <th class="border border-gray-300 px-4 py-2 text-left font-semibold">Total Memes</th>
                    <th class="border border-gray-300 px-4 py-2 text-left font-semibold">Total Votes</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $rank => $user): ?>
                    <tr class="<?= $rank % 2 === 0 ? 'bg-white' : 'bg-gray-50' ?>">
                        <td class="border border-gray-300 px-4 py-2 text-center"><?= $rank + 1 ?></td>
                        <td class="border border-gray-300 px-4 py-2 text-center">
                            <?php if (!empty($user['avatar'])): ?>
                                <img src="<?= htmlspecialchars($user['avatar'], ENT_QUOTES, 'UTF-8') ?>" 
                                     alt="<?= htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8') ?>" 
                                     class="w-10 h-10 rounded-full mx-auto">
                            <?php else: ?>
                                <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center mx-auto">
                                    <i class="fas fa-user text-gray-500"></i>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td class="border border-gray-300 px-4 py-2">
                            <?= htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8') ?>
                        </td>
                        <td class="border border-gray-300 px-4 py-2 text-center">
                            <?= (int) $user['total_memes'] ?>
                        </td>
                        <td class="border border-gray-300 px-4 py-2 text-center">
                            <?= (int) $user['total_votes'] ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/templates/footer.php'; ?>