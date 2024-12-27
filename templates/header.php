<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lokalku</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Pastikan menu mobile tersembunyi secara default */
        #mobile-menu {
            display: none;
        }
    </style>
</head>
<body class="bg-gray-100">
    <nav class="bg-blue-600 p-4 text-white">
        <div class="container mx-auto flex justify-between items-center">
            <a href="index.php" class="text-2xl font-bold"><i class="fas fa-smile"></i> Lokalku</a>
            
            <!-- Tombol Hamburger untuk Mobile -->
            <div class="lg:hidden">
                <button id="hamburger" class="text-white focus:outline-none">
                    <i class="fas fa-bars"></i>
                </button>
            </div>

            <!-- Menu Navigasi untuk Desktop -->
            <div class="hidden lg:flex items-center space-x-6" id="menu">
                <a href="leaderboard.php" class="hover:underline">Leaderboard</a>
                <?php if (isLoggedIn()): ?>
                    <a href="upload.php" class="hover:underline">Upload Meme</a>
                    <a href="profile.php?id=<?= $_SESSION['user_id'] ?>" class="hover:underline">Profil</a>
                    <?php if (isAdmin()): ?>
                        <a href="admin.php" class="hover:underline">Admin Panel</a>
                    <?php endif; ?>
                    <a href="settings.php" class="hover:underline">Pengaturan</a>
                    <a href="logout.php" class="hover:underline">Keluar</a>
                <?php else: ?>
                    <a href="login.php" class="hover:underline">Masuk</a>
                    <a href="register.php" class="hover:underline">Daftar</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Menu Mobile -->
    <div class="lg:hidden" id="mobile-menu">
        <div class="px-4 py-2 bg-blue-600">
            <a href="leaderboard.php" class="block py-2 px-4 text-white hover:bg-blue-700">Leaderboard</a>
            <?php if (isLoggedIn()): ?>
                <a href="upload.php" class="block py-2 px-4 text-white hover:bg-blue-700">Upload Meme</a>
                <a href="profile.php?id=<?= $_SESSION['user_id'] ?>" class="block py-2 px-4 text-white hover:bg-blue-700">Profil</a>
                <?php if (isAdmin()): ?>
                    <a href="admin.php" class="block py-2 px-4 text-white hover:bg-blue-700">Admin Panel</a>
                <?php endif; ?>
                <a href="settings.php" class="block py-2 px-4 text-white hover:bg-blue-700">Pengaturan</a>
                <a href="logout.php" class="block py-2 px-4 text-white hover:bg-blue-700">Keluar</a>
            <?php else: ?>
                <a href="login.php" class="block py-2 px-4 text-white hover:bg-blue-700">Masuk</a>
                <a href="register.php" class="block py-2 px-4 text-white hover:bg-blue-700">Daftar</a>
            <?php endif; ?>
        </div>
    </div>
    <!-- Script untuk Toggle Menu -->
    <script>
        const hamburger = document.getElementById('hamburger');
        const menu = document.getElementById('mobile-menu');
        
        hamburger.addEventListener('click', () => {
            // Toggle tampilan menu mobile
            if (menu.style.display === 'block') {
                menu.style.display = 'none';
            } else {
                menu.style.display = 'block';
            }
        });
    </script>
    <div class="container mx-auto my-8">
</body>
</html>