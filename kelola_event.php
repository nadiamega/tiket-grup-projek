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
    <title>Daftar Event - SMART2</title>
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
        $page_title = "Kelola Event";
        $extra_button = '<a href="tambah_event.php" class="bg-black text-white px-8 py-3 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] hover:bg-gray-800 transition shadow-lg shadow-gray-100">+ Tambah Event</a>';
        include 'header_admin.php';
        ?>

        <div class="space-y-6 w-full">
            <?php
            $query = mysqli_query($conn, "SELECT * FROM events ORDER BY id DESC");
            
            if(mysqli_num_rows($query) > 0) {
                while($row = mysqli_fetch_assoc($query)) {
            ?>
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden transition-transform hover:scale-[1.005]">
                    <div class="bg-black p-8 text-white">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-[10px] font-black uppercase tracking-[0.3em] opacity-40 mb-1"><?php echo htmlspecialchars($row['kategori']); ?></p>
                                <h3 class="text-2xl font-black tracking-tight"><?php echo htmlspecialchars($row['nama_event']); ?></h3>
                            </div>
                            <div class="text-right">
                                <p class="text-[10px] font-black uppercase tracking-[0.3em] opacity-40 mb-1">Sisa Kuota</p>
                                <p class="text-xl font-black <?php echo ($row['kuota'] <= 10) ? 'text-red-500' : 'text-white'; ?>"><?php echo $row['kuota']; ?></p>
                            </div>
                        </div>
                        <p class="text-xs mt-4 font-bold opacity-60 uppercase tracking-widest"><?php echo date('d M Y', strtotime($row['tanggal'])); ?></p>
                    </div>
                    
                    <div class="p-8 bg-white border-b border-gray-50">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Deskripsi Event</p>
                        <p class="text-sm font-medium text-gray-600 leading-relaxed mb-6">
                            <?php echo !empty($row['deskripsi']) ? htmlspecialchars($row['deskripsi']) : 'Tidak ada deskripsi untuk event ini.'; ?>
                        </p>

                        <div class="flex justify-between items-center pt-6 border-t border-gray-50">
                            <div class="flex gap-12">
                                <div>
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Lokasi</p>
                                    <p class="text-sm font-bold text-gray-700">📍 <?php echo htmlspecialchars($row['lokasi']); ?></p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Harga Tiket</p>
                                    <p class="text-sm font-bold text-gray-700">💳 <?php echo htmlspecialchars($row['harga']); ?></p>
                                </div>
                            </div>

                            <div class="flex items-center gap-6">
                                <?php if($_SESSION['role'] == 'admin') : ?>
                                    <a href="edit_event.php?id=<?php echo $row['id']; ?>" class="text-[10px] font-black text-blue-600 uppercase tracking-widest hover:underline">Edit</a>
                                    <a href="hapus_event.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Hapus event ini?')" class="text-[10px] font-black text-red-600 uppercase tracking-widest hover:underline">Hapus</a>
                                <?php else : ?>
                                    <a href="booking_tiket.php?id=<?php echo $row['id']; ?>" class="bg-gray-50 px-8 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-black hover:text-white transition">Booking Tiket</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php 
                } 
            } else {
                echo "
                <div class='bg-white rounded-[3rem] p-32 text-center border-2 border-dashed border-gray-100'>
                    <div class='w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6'>
                        <span class='text-3xl'>⚙️</span>
                    </div>
                    <h3 class='text-xl font-black text-gray-900 uppercase tracking-tight'>Belum Ada Event Yang Ditambahkan</h3>
                </div>";
            }
            ?>
        </div>
    </main>
</body>
</html>