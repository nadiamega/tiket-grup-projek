<?php
include 'koneksi.php';
// session_start();

if (!isset($_SESSION['username'])) {
    header("location:login.php");
    exit;
}

$username = $_SESSION['username'];
$u_id     = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiket Saya - SMART2</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .vertical-text { writing-mode: vertical-rl; transform: rotate(180deg); }
    </style>
</head>
<body class="bg-[#f8f9fd] flex min-h-screen">

    <?php include 'sidebar.php'; ?>

    <main class="flex-1 p-10 overflow-y-auto">
        <?php
        $page_title = "Tiket Saya";
        include 'header_user.php';
        ?>

        <div class="space-y-8 w-full max-full">
            <?php
            $q_tiket = mysqli_query($conn, "SELECT bookings.*, events.nama_event, events.tanggal, events.lokasi, events.kategori 
                                           FROM bookings 
                                           JOIN events ON bookings.event_id = events.id 
                                           WHERE bookings.user_id = '$u_id'
                                           ORDER BY bookings.id DESC");

            if(mysqli_num_rows($q_tiket) > 0) {
                while($t = mysqli_fetch_assoc($q_tiket)) {

                    // Teks harga & metode bayar
                    if ((int)$t['total_bayar'] > 0) {
                        $bayar_text = 'Rp ' . number_format($t['total_bayar'], 0, ',', '.') . ' · ' . htmlspecialchars($t['metode_bayar']);
                    } else {
                        $bayar_text = 'Gratis';
                    }
                    ?>
                    <div class="bg-white rounded-[3rem] border border-gray-100 shadow-sm flex overflow-hidden transition-transform hover:scale-[1.01]">
                        <div class="bg-black p-10 flex items-center justify-center text-white font-black text-2xl uppercase vertical-text tracking-[0.3em] opacity-90">
                            TICKET
                        </div>
                        
                        <div class="p-10 flex-1 flex flex-col justify-between">
                            <div>
                                <div class="flex justify-between items-start mb-4">
                                    <span class="px-4 py-1.5 bg-blue-50 text-blue-600 rounded-lg text-[10px] font-black uppercase tracking-widest">
                                        Confirmed
                                    </span>
                                </div>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-1"><?php echo htmlspecialchars($t['kategori']); ?></p>
                                <h3 class="text-2xl font-black text-gray-900 tracking-tight"><?php echo htmlspecialchars($t['nama_event']); ?></h3>
                            </div>

                            <div class="mt-8 grid grid-cols-3 gap-8 pt-8 border-t border-gray-50">
                                <div>
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Waktu Pelaksanaan</p>
                                    <p class="text-sm font-bold text-gray-700">🗓️ <?php echo date('d F Y', strtotime($t['tanggal'])); ?></p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Lokasi Event</p>
                                    <p class="text-sm font-bold text-gray-700">📍 <?php echo htmlspecialchars($t['lokasi']); ?></p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Pembayaran</p>
                                    <p class="text-sm font-bold text-gray-700">💳 <?php echo $bayar_text; ?></p>
                                </div>
                            </div>
                        </div>

                        <div class="w-48 p-10 border-l border-dashed border-gray-200 flex flex-col items-center justify-center bg-gray-50/50 relative">
                            <div class="absolute -top-4 -left-4 w-8 h-8 bg-[#f8f9fd] rounded-full border border-gray-100 shadow-inner"></div>
                            <div class="absolute -bottom-4 -left-4 w-8 h-8 bg-[#f8f9fd] rounded-full border border-gray-100 shadow-inner"></div>
                            
                            <p class="text-[11px] font-black text-gray-400 uppercase tracking-widest mb-3">Kode Tiket</p>
                            <div class="w-full bg-black rounded-2xl flex items-center justify-center p-5">
                                <span class="text-white text-[8px] font-black tracking-widest"><?php echo $t['kode_tiket']; ?></span>
                            </div>
                        </div>
                    </div>
            <?php }
            } else { ?>
                <div class="bg-white rounded-[3rem] p-32 text-center border-2 border-dashed border-gray-100">
                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl">🎫</div>
                    <h3 class="text-xl font-black text-gray-900 uppercase tracking-tight">Belum Ada Tiket</h3>
                    <a href="daftar_event.php" class="inline-block mt-10 bg-black text-white px-10 py-4 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] hover:bg-gray-800 transition shadow-lg shadow-gray-100">
                        Cari Event Sekarang
                    </a>
                </div>
            <?php } ?>
        </div>
        
    </main>
</body>
</html>