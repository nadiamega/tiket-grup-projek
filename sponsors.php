<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['username'])) { 
    header("location:login.php"); 
    exit; 
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Sponsor - SMART2</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#f8f9fd] flex min-h-screen">

    <?php include 'sidebar.php'; ?>

    <main class="flex-1 p-10 overflow-y-auto">
        <?php
        $page_title = "Daftar Sponsor";
        include 'header_user.php';
        ?>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php
            $q = mysqli_query($conn, "SELECT * FROM sponsors ORDER BY nama_sponsor ASC");
            
            if(mysqli_num_rows($q) > 0) {
                while($s = mysqli_fetch_assoc($q)) { ?>
                    <div class="bg-white p-12 rounded-[3rem] border border-gray-100 shadow-sm text-center transition-transform hover:scale-[1.02]">
                        <div class="w-20 h-20 bg-gray-50 rounded-full mx-auto mb-8 flex items-center justify-center text-3xl shadow-inner">
                            🤝
                        </div>
                        <h3 class="font-black text-xl text-gray-900 tracking-tight mb-3">
                            <?php echo htmlspecialchars($s['nama_sponsor']); ?>
                        </h3>
                        <div class="inline-block px-6 py-2 bg-gray-50 rounded-xl">
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">
                                <?php echo htmlspecialchars($s['kategori']); ?>
                            </p>
                        </div>
                        
                        <div class="mt-8 pt-8 border-t border-gray-50 space-y-2">
                            <p class="text-[10px] font-black text-gray-300 uppercase tracking-widest mb-1">Hubungi Kami</p>
                            <p class="text-sm font-bold text-blue-600 underline decoration-2 underline-offset-4 decoration-blue-100">
                                <?php echo htmlspecialchars($s['email']); ?>
                            </p>
                            <?php if (!empty($s['telp'])): ?>
                            <p class="text-sm font-bold text-gray-500">📞 <?php echo htmlspecialchars($s['telp']); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php } 
            } else { ?>
                <div class="col-span-full bg-white rounded-[3rem] p-32 text-center border-2 border-dashed border-gray-100">
                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl">
                        🏳️
                    </div>
                    <h3 class="text-xl font-black text-gray-900 uppercase tracking-tight">Belum Ada Sponsor</h3>
                </div>
            <?php } ?>
        </div>

    </main>
</body>
</html>