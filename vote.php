<?php
require 'includes/db.php';
require 'includes/auth.php';

redirectIfNotLoggedIn();

$meme_id = (int)$_GET['id'];
$type = $_GET['type'];

if ($type === 'upvote' || $type === 'downvote') {
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

header('Location: index.php');
exit();
?>
