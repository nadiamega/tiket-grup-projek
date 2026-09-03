<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<aside class="w-72 bg-white border-r border-gray-100 flex flex-col sticky top-0 h-screen">
    <div class="p-10">
        <h1 class="text-2xl font-black tracking-tighter">
            <span class="text-red-600">SMART</span><span class="text-blue-600">2</span>
        </h1>
    </div>
    
    <nav class="flex-1 px-6 space-y-2">
        <?php if ($_SESSION['role'] == 'admin') : ?>
            <a href="dashboard_admin.php" class="flex items-center px-6 py-4 rounded-2xl text-sm font-bold transition-all duration-200 
                <?php echo ($current_page == 'dashboard_admin.php') ? 'bg-black text-white shadow-lg' : 'text-gray-400 hover:bg-gray-50 hover:text-black'; ?>">
                Dashboard Admin
            </a>
        <?php else : ?>
            <a href="dashboard_user.php" class="flex items-center px-6 py-4 rounded-2xl text-sm font-bold transition-all duration-200 
                <?php echo ($current_page == 'dashboard_user.php') ? 'bg-black text-white shadow-lg' : 'text-gray-400 hover:bg-gray-50 hover:text-black'; ?>">
                Dashboard
            </a>
        <?php endif; ?>

        <?php if ($_SESSION['role'] == 'admin') : ?>
            <a href="kelola_event.php" class="flex items-center px-6 py-4 rounded-2xl text-sm font-bold transition-all duration-200 
                <?php echo ($current_page == 'kelola_event.php') ? 'bg-black text-white shadow-lg' : 'text-gray-400 hover:bg-gray-50 hover:text-black'; ?>">
                Kelola Event
            </a>
            <a href="kelola_sponsor.php" class="flex items-center px-6 py-4 rounded-2xl text-sm font-bold transition-all duration-200 
                <?php echo ($current_page == 'kelola_sponsor.php') ? 'bg-black text-white shadow-lg' : 'text-gray-400 hover:bg-gray-50 hover:text-black'; ?>">
                Kelola Sponsor
            </a>
            <a href="daftar_pembeli.php" class="flex items-center px-6 py-4 rounded-2xl text-sm font-bold transition-all duration-200 
                <?php echo ($current_page == 'daftar_pembeli.php') ? 'bg-black text-white shadow-lg' : 'text-gray-400 hover:bg-gray-50 hover:text-black'; ?>">
                Daftar Pembeli
            </a>
            <a href="kelola_user.php" class="flex items-center px-6 py-4 rounded-2xl text-sm font-bold transition-all duration-200 
                <?php echo ($current_page == 'kelola_user.php') ? 'bg-black text-white shadow-lg' : 'text-gray-400 hover:bg-gray-50 hover:text-black'; ?>">
                Kelola User
            </a>
        <?php endif; ?>

        <?php if ($_SESSION['role'] == 'user') : ?>
            <a href="daftar_event.php" class="flex items-center px-6 py-4 rounded-2xl text-sm font-bold transition-all duration-200 
                <?php echo ($current_page == 'daftar_event.php') ? 'bg-black text-white shadow-lg' : 'text-gray-400 hover:bg-gray-50 hover:text-black'; ?>">
                Daftar Event
            </a>
            <a href="tiket_saya.php" class="flex items-center px-6 py-4 rounded-2xl text-sm font-bold transition-all duration-200 
                <?php echo ($current_page == 'tiket_saya.php') ? 'bg-black text-white shadow-lg' : 'text-gray-400 hover:bg-gray-50 hover:text-black'; ?>">
                Tiket Saya
            </a>
            <a href="sponsors.php" class="flex items-center px-6 py-4 rounded-2xl text-sm font-bold transition-all duration-200 
                <?php echo ($current_page == 'sponsors.php') ? 'bg-black text-white shadow-lg' : 'text-gray-400 hover:bg-gray-50 hover:text-black'; ?>">
                Daftar Sponsor
            </a>
        <?php endif; ?>
    </nav>

    <div class="p-6 mt-auto">
        <a href="logout.php" class="flex items-center px-6 py-4 rounded-2xl text-sm font-bold text-red-500 hover:bg-red-50 transition-all duration-200 uppercase tracking-widest text-[10px]">
            Log Out
        </a>
        <p class="text-[10px] text-center text-gray-400 font-bold mt-4 uppercase">© 2026 SMK Antartika 2 Sidoarjo</p>
    </div>
</aside>

<!-- tambahan nadiamega -->