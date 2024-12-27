<?php
require 'includes/db.php';

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
<h1 class="title">Leaderboard</h1>
<table class="table is-fullwidth is-striped">
    <thead>
        <tr>
            <th>Rank</th>
            <th>Username</th>
            <th>Total Memes</th>
            <th>Total Votes</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $rank => $user): ?>
            <tr>
                <td><?= $rank + 1 ?></td>
                <td><?= htmlspecialchars($user['username']) ?></td>
                <td><?= $user['total_memes'] ?></td>
                <td><?= $user['total_votes'] ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php require 'templates/footer.php'; ?>
