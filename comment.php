<?php
require 'includes/db.php';
require 'includes/auth.php';

redirectIfNotLoggedIn();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $meme_id = (int)$_POST['meme_id'];
    $content = trim($_POST['content']);

    if ($content) {
        $stmt = $pdo->prepare("INSERT INTO comments (meme_id, user_id, content) VALUES (?, ?, ?)");
        $stmt->execute([$meme_id, $_SESSION['user_id'], $content]);
    }
}

header('Location: index.php');
exit();
?>
