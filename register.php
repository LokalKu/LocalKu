<?php
require 'includes/db.php';
require 'includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $password]);

        header('Location: login');
        exit();
    } catch (PDOException $e) {
        $error = 'Gagal mendaftar. Username atau email sudah digunakan.';
    }
}

require 'templates/header.php';
?>
<style>
/* Form styling */
.container {
    max-width: 600px;
    margin: 0 auto;
}

h1 {
    font-size: 2rem;
    font-weight: 600;
    text-align: center;
    margin-bottom: 1.5rem;
}

.form-wrapper {
    background-color: white;
    padding: 2rem;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.form-group {
    margin-bottom: 1rem;
}

.form-group label {
    display: block;
    font-size: 0.875rem;
    font-weight: 500;
    color: #333;
}

.form-group input {
    width: 100%;
    padding: 0.75rem;
    font-size: 1rem;
    border: 1px solid #ddd;
    border-radius: 5px;
    margin-top: 0.5rem;
    outline: none;
    transition: border-color 0.2s ease-in-out;
}

.form-group input:focus {
    border-color: #5a67d8;
}

.form-group button {
    width: 100%;
    padding: 1rem;
    background-color: #4c51bf;
    color: white;
    font-size: 1rem;
    border-radius: 5px;
    border: none;
    cursor: pointer;
    transition: background-color 0.2s ease;
}

.form-group button:hover {
    background-color: #434190;
}

.error-message {
    background-color: #e53e3e;
    color: white;
    padding: 0.75rem;
    margin-bottom: 1rem;
    border-radius: 5px;
    font-size: 0.875rem;
    text-align: center;
}
</style>
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-center mb-6">Daftar</h1>

    <?php if (isset($error)): ?>
        <div class="bg-red-500 text-white p-4 mb-4 rounded-md"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-md">
        <div class="mb-4">
            <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
            <input type="text" name="username" id="username" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
        </div>

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" id="email" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
        </div>

        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" name="password" id="password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
        </div>

        <div class="mb-4">
            <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                Daftar
            </button>
        </div>
    </form>
</div>

<?php require 'templates/footer.php'; ?>