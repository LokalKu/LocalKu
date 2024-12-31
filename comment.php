<?php
require 'includes/db.php';
require 'includes/auth.php';

if (!isset($_GET['meme_id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Meme ID is required']);
    exit();
}

$meme_id = (int)$_GET['meme_id'];

$stmt = $pdo->prepare("SELECT comments.*, users.username, users.avatar 
                       FROM comments 
                       JOIN users ON comments.user_id = users.id 
                       WHERE comments.meme_id = ? 
                       ORDER BY comments.created_at DESC");
$stmt->execute([$meme_id]);
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($comments);