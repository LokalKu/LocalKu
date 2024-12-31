<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Pastikan menu mobile tersembunyi secara default */
        #mobile-menu {
            display: none;
        }

        .logo {
          width: 150px;
        }
    </style>
</head>
<body class="bg-gray-100">
    <nav class="bg-blue-600 p-4 text-white">
        <div class="container mx-auto flex justify-between items-center">
            <a href="/" class="text-2xl font-bold"><i class="fas fa-smile"></i> LokalKu</a>
            
            <!-- Tombol Hamburger untuk Mobile -->
            <div class="lg:hidden">
                <button id="hamburger" class="text-white focus:outline-none">
                    <i class="fas fa-bars"></i>
                </button>
            </div>

            <!-- Menu Navigasi untuk Desktop -->
            <div class="hidden lg:flex items-center space-x-6" id="menu">
                <a href="/leaderboard" class="hover:underline">Leaderboard</a>
                <?php if (isLoggedIn()): ?>
                    <a href="/upload" class="hover:underline">Upload Meme</a>
                    <a href="/user/<?= $_SESSION['user_id'] ?>" class="hover:underline">Profil</a>
                    <?php if (isAdmin()): ?>
                        <a href="/admin" class="hover:underline">Admin Panel</a>
                    <?php endif; ?>
                    <a href="/settings" class="hover:underline">Pengaturan</a>
                    <a href="/logout" class="hover:underline">Keluar</a>
                <?php else: ?>
                    <a href="/login" class="hover:underline">Masuk</a>
                    <a href="/register" class="hover:underline">Daftar</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Menu Mobile -->
    <div class="lg:hidden" id="mobile-menu">
        <div class="px-4 py-2 bg-blue-600">
            <a href="/leaderboard" class="block py-2 px-4 text-white hover:bg-blue-700">Leaderboard</a>
            <?php if (isLoggedIn()): ?>
                <a href="/upload" class="block py-2 px-4 text-white hover:bg-blue-700">Upload Meme</a>
                <a href="/user/<?= $_SESSION['user_id'] ?>" class="block py-2 px-4 text-white hover:bg-blue-700">Profil</a>
                <?php if (isAdmin()): ?>
                    <a href="/admin" class="block py-2 px-4 text-white hover:bg-blue-700">Admin Panel</a>
                <?php endif; ?>
                <a href="/settings" class="block py-2 px-4 text-white hover:bg-blue-700">Pengaturan</a>
                <a href="/logout" class="block py-2 px-4 text-white hover:bg-blue-700">Keluar</a>
            <?php else: ?>
                <a href="/login" class="block py-2 px-4 text-white hover:bg-blue-700">Masuk</a>
                <a href="/register" class="block py-2 px-4 text-white hover:bg-blue-700">Daftar</a>
            <?php endif; ?>
        </div>
    </div>
    <script>const _0x4cdd9b=_0x567c;function _0x46a1(){const _0x4c3feb=['490vWQkGk','5761120moeyLZ','style','1055549iMOuGY','display','log','33165UoqbCQ','315909bIPYkY','block','addEventListener','mobile-menu','240776jqlbwb','841842ypTQty','getElementById','4ApEAlA','50NrVpyJ','8844654IWVfQd','click','Hello\x20World!','none','hamburger','1000aSokmK'];_0x46a1=function(){return _0x4c3feb;};return _0x46a1();}(function(_0x2f61b5,_0x35c514){const _0x3fed2c=_0x567c,_0xc6e0bf=_0x2f61b5();while(!![]){try{const _0x2b1a21=-parseInt(_0x3fed2c(0x15a))/0x1*(-parseInt(_0x3fed2c(0x157))/0x2)+parseInt(_0x3fed2c(0x153))/0x3+-parseInt(_0x3fed2c(0x163))/0x4+parseInt(_0x3fed2c(0x15b))/0x5*(-parseInt(_0x3fed2c(0x158))/0x6)+-parseInt(_0x3fed2c(0x15c))/0x7+-parseInt(_0x3fed2c(0x161))/0x8*(parseInt(_0x3fed2c(0x168))/0x9)+-parseInt(_0x3fed2c(0x162))/0xa*(-parseInt(_0x3fed2c(0x165))/0xb);if(_0x2b1a21===_0x35c514)break;else _0xc6e0bf['push'](_0xc6e0bf['shift']());}catch(_0x2ffd83){_0xc6e0bf['push'](_0xc6e0bf['shift']());}}}(_0x46a1,0xb01c5));function hi(){const _0x35268d=_0x567c;console[_0x35268d(0x167)](_0x35268d(0x15e));}function _0x567c(_0x256f84,_0x73fc2a){const _0x46a1f0=_0x46a1();return _0x567c=function(_0x567c17,_0x1d9953){_0x567c17=_0x567c17-0x153;let _0x1c0f45=_0x46a1f0[_0x567c17];return _0x1c0f45;},_0x567c(_0x256f84,_0x73fc2a);}hi();const hamburger=document[_0x4cdd9b(0x159)](_0x4cdd9b(0x160)),menu=document[_0x4cdd9b(0x159)](_0x4cdd9b(0x156));hamburger[_0x4cdd9b(0x155)](_0x4cdd9b(0x15d),()=>{const _0x395a67=_0x4cdd9b;menu[_0x395a67(0x164)][_0x395a67(0x166)]===_0x395a67(0x154)?menu[_0x395a67(0x164)]['display']=_0x395a67(0x15f):menu['style'][_0x395a67(0x166)]='block';});
    </script>
    <div class="container mx-auto my-8">