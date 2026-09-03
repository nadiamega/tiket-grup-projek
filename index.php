<?php

include 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Tiket SMART2 - SMK Antartika 2 Sidoarjo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .nav-link {
            transition: all 0.2s ease-in-out;
        }
    </style>
</head>
<body class="bg-white text-gray-900">

    <header class="w-full py-6 px-10 border-b border-gray-100 sticky top-0 bg-white/95 backdrop-blur-sm z-50">
        <div class="flex items-center justify-between">
            
            <div class="flex-1 flex justify-start">
                <img src="logo-sekolah.png" alt="Logo SMART2" class="h-10 w-auto">
            </div>

            <nav class="flex items-center space-x-1">
                <a href="login.php" class="nav-link px-5 py-2 rounded-lg text-sm font-bold text-gray-700 hover:bg-black hover:text-white">Jadwal Event</a>
                <a href="login.php" class="nav-link px-5 py-2 rounded-lg text-sm font-bold text-gray-700 hover:bg-black hover:text-white">Sponsor</a>
                <a href="login.php" class="nav-link px-5 py-2 rounded-lg text-sm font-bold text-gray-700 hover:bg-black hover:text-white">Cek Tiket</a>
            </nav>

            <div class="flex-1 flex justify-end items-center space-x-8">
                <a href="login.php" class="text-sm font-bold text-gray-600 hover:text-black transition">Masuk</a>
                <a href="register.php" class="border-2 border-gray-900 text-gray-900 px-6 py-2 rounded-full text-sm font-bold hover:bg-gray-900 hover:text-white transition shadow-sm">
                    Daftar
                </a>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6 pt-32 pb-32">
        <div class="text-center">
            
            <h1 class="text-6xl md:text-8xl font-extrabold tracking-tighter mb-8 leading-tight">
                Akses Tiket Seluruh Event <br>
                <span class="text-red-600">SMART</span><span class="text-blue-600">2</span> dalam Satu Klik.
            </h1>

            <p class="text-lg md:text-xl text-gray-600 max-w-3xl mx-auto mb-14 leading-relaxed font-semibold">
                Lupakan antrean panjang. Amankan kursi prioritasmu dalam <br class="hidden md:block">
                event-event kita sekarang juga!
            </p>

            <div class="flex justify-center">
                <a href="login.php" class="bg-black text-white px-14 py-5 rounded-2xl font-bold text-xl hover:bg-gray-800 transition-all hover:scale-105 shadow-2xl shadow-gray-200">
                    Cek Event Sekarang
                </a>
            </div>
        </div>
    </main>

    <footer class="py-12 border-t border-gray-50">
        <div class="max-w-7xl mx-auto px-6 text-center text-gray-400 text-[10px] font-bold tracking-[0.3em] uppercase">
            <p>&copy; 2026 SMK ANTARTIKA 2 SIDOARJO. ALL RIGHTS RESERVED.</p>
        </div>
    </footer>

</body>
</html>