<?php
require 'includes/db.php';
require 'includes/auth.php';

redirectIfNotLoggedIn();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $image = $_FILES['image'];

    if ($image['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '.' . $ext;
        move_uploaded_file($image['tmp_name'], "uploads/$filename");

        $stmt = $pdo->prepare("INSERT INTO memes (user_id, title, image) VALUES (?, ?, ?)");
        $stmt->execute([$_SESSION['user_id'], $title, $filename]);
        header('Location: /dashboard');
        exit();
    } else {
        $error = 'Gagal mengunggah gambar.';
    }
}

require 'templates/header.php';
?>
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-center mb-6">Upload Meme</h1>
    <?php if ($error): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6" role="alert">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>
    <form method="POST" enctype="multipart/form-data" class="max-w-lg mx-auto bg-white shadow-md rounded px-8 py-6">
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2" for="title">Judul</label>
            <input 
                type="text" 
                name="title" 
                id="title" 
                class="border border-gray-300 rounded w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2" for="image">Gambar</label>
            <input 
                type="file" 
                name="image" 
                id="image" 
                accept="image/*" 
                class="border border-gray-300 rounded w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                required>
        </div>
        <div>
            <button 
                type="submit" 
                class="w-full bg-indigo-500 text-white font-semibold py-2 px-4 rounded hover:bg-blue-600 transition duration-300">
                Unggah
            </button>
        </div>
    </form>
</div>
<?php require 'templates/footer.php'; ?>