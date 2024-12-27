<?php
require 'includes/db.php';
require 'includes/auth.php';
$stmt = $pdo->query("
    SELECT u.username, COUNT(m.id) AS total_memes, SUM(m.votes) AS total_votes
    FROM users u
    LEFT JOIN memes m ON u.id = m.user_id
    GROUP BY u.id
    ORDER BY total_votes DESC, total_memes DESC
");
$users = $stmt->fetchAll();

require 'templates/header.php';
?>
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-center mb-6">Leaderboard</h1>
    <div class="overflow-x-auto">
        <table class="min-w-full border-collapse border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border border-gray-300 px-4 py-2 text-left font-semibold">Rank</th>
                    <th class="border border-gray-300 px-4 py-2 text-left font-semibold">Username</th>
                    <th class="border border-gray-300 px-4 py-2 text-left font-semibold">Total Memes</th>
                    <th class="border border-gray-300 px-4 py-2 text-left font-semibold">Total Votes</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $rank => $user): ?>
                    <tr class="<?= $rank % 2 === 0 ? 'bg-white' : 'bg-gray-50' ?>">
                        <td class="border border-gray-300 px-4 py-2"><?= $rank + 1 ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?= htmlspecialchars($user['username']) ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?= $user['total_memes'] ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?= $user['total_votes'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php require 'templates/footer.php'; ?>