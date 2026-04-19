<?php
// Pastikan session cuma dipanggil sekali
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fukocatto Shop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style> 
        html { scroll-behavior: smooth; } 
        /* Animasi goyang lucu khusus untuk paw */
        .wiggle-paw:hover i {
            animation: wiggle 0.5s ease-in-out infinite;
        }
        @keyframes wiggle {
            0% { transform: rotate(0deg); }
            25% { transform: rotate(-15deg); }
            50% { transform: rotate(0deg); }
            75% { transform: rotate(15deg); }
            100% { transform: rotate(0deg); }
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased">

<nav class="bg-white shadow-sm sticky top-0 z-50 border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            
            <a href="index.php" class="flex items-center gap-3 group">
                <div class="bg-orange-100 p-2.5 rounded-full group-hover:bg-orange-200 transition">
                    <i class="fa-solid fa-cat text-2xl text-orange-600"></i>
                </div>
                <span class="font-black text-2xl tracking-tight text-gray-900">Fukocatto<span class="text-orange-500">Shop</span></span>
            </a>

            <div class="hidden md:flex space-x-8">
                <a href="index.php#kucing" class="font-bold text-gray-500 hover:text-orange-600 transition border-b-2 border-transparent hover:border-orange-500 py-2">Adopsi Kucing</a>
                <a href="index.php#aksesoris" class="font-bold text-gray-500 hover:text-orange-600 transition border-b-2 border-transparent hover:border-orange-500 py-2">Aksesoris</a>
                <a href="index.php#grooming" class="font-bold text-gray-500 hover:text-orange-600 transition border-b-2 border-transparent hover:border-orange-500 py-2">Home Grooming</a>
                <a href="titip_adopsi.php" class="font-bold text-gray-500 hover:text-orange-600 transition border-b-2 border-transparent hover:border-orange-500 py-2">Titip Adopsi</a>
            </div>

            <div class="flex items-center gap-3">
                <?php if (!isset($_SESSION['id_user'])) : ?>
                    <a href="login.php" class="font-bold text-gray-600 hover:text-orange-600 transition px-3 py-2">Masuk</a>
                    <a href="register.php" class="bg-orange-500 hover:bg-orange-600 text-white font-bold px-6 py-2.5 rounded-full shadow-md transition transform hover:-translate-y-0.5">Daftar</a>
                
                <?php else : ?>
                    <div class="hidden sm:block text-right mr-2">
                        <p class="text-[10px] font-black tracking-wider text-gray-400 uppercase"><?= $_SESSION['role']; ?></p>
                        <p class="font-bold text-sm text-gray-800 leading-tight"><?= $_SESSION['username']; ?></p>
                    </div>

                    <?php if($_SESSION['role'] == 'pengguna'): ?>
                        
                        <a href="keranjang.php" class="bg-green-50 text-green-600 border border-green-200 hover:bg-green-100 hover:scale-105 font-bold px-4 py-2 rounded-full transition-all flex items-center gap-2 shadow-sm">
                            <i class="fa-solid fa-cart-shopping"></i>
                            <span class="hidden sm:inline">Keranjang</span>
                        </a>

                        <a href="pesanan_saya.php" class="bg-rose-50 text-rose-500 border border-rose-200 hover:bg-rose-100 hover:text-rose-600 hover:shadow-md font-bold px-4 py-2 rounded-full transition-all flex items-center gap-2 shadow-sm wiggle-paw">
                            <i class="fa-solid fa-paw text-xl"></i>
                            <span class="hidden sm:inline">Riwayatku</span>
                        </a>

                    <?php endif; ?>

                    <?php if($_SESSION['role'] == 'admin'): ?>
                        <a href="admin.php" class="bg-indigo-50 text-indigo-600 border border-indigo-200 hover:bg-indigo-100 font-bold px-4 py-2 rounded-full transition flex items-center gap-2 shadow-sm">
                            <i class="fa-solid fa-gauge-high"></i>
                            <span class="hidden sm:inline">Dashboard Panel</span>
                        </a>
                    <?php endif; ?>

                    <a href="logout.php" class="bg-red-50 text-red-500 hover:bg-red-500 hover:text-white border border-red-100 font-bold p-2.5 rounded-full transition shadow-sm ml-1" title="Keluar Akun">
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </a>
                <?php endif; ?>
            </div>

        </div>
    </div>
</nav>