<?php
include 'koneksi.php';
// session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'user') {
    header("location:login.php");
    exit;
}

$username = $_SESSION['username'];
$u_id     = $_SESSION['user_id'];

$q_tiket_aktif = mysqli_query($conn, "SELECT COUNT(*) as total FROM bookings 
                                      JOIN events ON bookings.event_id = events.id 
                                      WHERE bookings.user_id = '$u_id' 
                                      AND events.tanggal >= CURDATE()");
$tiket_aktif = mysqli_fetch_assoc($q_tiket_aktif)['total'];

// Hitung total tiket yang pernah dibeli
$q_tiket_total = mysqli_query($conn, "SELECT COUNT(*) as total FROM bookings WHERE user_id = '$u_id'");
$tiket_total = mysqli_fetch_assoc($q_tiket_total)['total'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SMART2</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-[#f8f9fd] flex min-h-screen">

    <?php include 'sidebar.php'; ?>

    <main class="flex-1 p-10 overflow-y-auto">
        <div class="max-w-full">
            <?php
            $page_title    = "Dashboard";
            $page_subtitle = "Selamat datang, " . $_SESSION['username'] . ".";
            include 'header_user.php';
            ?>

            <?php
            $q_event = mysqli_query($conn, "SELECT * FROM events ORDER BY id DESC LIMIT 1");
            if(mysqli_num_rows($q_event) > 0) {
                $e = mysqli_fetch_assoc($q_event);
            ?>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-[3rem] p-10 border border-gray-100 shadow-sm h-full">
                            <p class="text-[10px] font-black text-blue-600 uppercase tracking-widest mb-4">Event Terkini</p>
                            <h3 class="text-3xl font-black text-gray-900 leading-tight mb-2"><?php echo htmlspecialchars($e['nama_event']); ?></h3>
                            <p class="text-[10px] font-black text-gray-300 uppercase tracking-widest mb-8"><?php echo htmlspecialchars($e['kategori']); ?></p>

                            <p class="text-sm font-medium text-gray-500 leading-relaxed mb-8">
                                <?php echo !empty($e['deskripsi']) ? htmlspecialchars($e['deskripsi']) : 'Tidak ada deskripsi untuk event ini.'; ?>
                            </p>

                            <div class="grid grid-cols-3 gap-4 mb-8">
                                <div class="bg-gray-50 p-5 rounded-2xl">
                                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Tanggal</p>
                                    <p class="text-sm font-black text-gray-900"><?php echo date('d M Y', strtotime($e['tanggal'])); ?></p>
                                </div>
                                <div class="bg-gray-50 p-5 rounded-2xl">
                                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Lokasi</p>
                                    <p class="text-sm font-black text-gray-900 truncate"><?php echo htmlspecialchars($e['lokasi']); ?></p>
                                </div>
                                <div class="bg-gray-50 p-5 rounded-2xl">
                                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Sisa Kuota</p>
                                    <p class="text-sm font-black <?php echo ($e['kuota'] <= 10) ? 'text-red-500' : 'text-blue-600'; ?>"><?php echo $e['kuota']; ?> Tiket</p>
                                </div>
                            </div>

                            <a href="booking_tiket.php?id=<?php echo $e['id']; ?>" class="inline-block bg-black text-white px-8 py-4 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] hover:bg-gray-800 transition">
                                Booking Sekarang →
                            </a>
                        </div>
                    </div>

                    
                    <div class="lg:col-span-1 flex flex-col gap-8">
                        <div class="bg-black rounded-[3rem] p-10 border border-gray-100 shadow-sm flex-1 flex flex-col justify-between">
                            <div>
                                <p class="text-[10px] font-black text-white opacity-40 uppercase tracking-widest mb-4">Tiket Aktif</p>
                                <p class="text-7xl font-black text-white leading-none mb-2"><?php echo $tiket_aktif; ?></p>
                                <p class="text-[10px] font-black text-white opacity-40 uppercase tracking-widest">Event belum selesai</p>
                            </div>
                            <a href="tiket_saya.php" class="mt-8 block text-center bg-white text-black px-6 py-4 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] hover:bg-gray-100 transition">
                                Lihat Tiket Saya →
                            </a>
                        </div>

                        <div class="bg-white rounded-[3rem] p-10 border border-gray-100 shadow-sm">
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Total Tiket Dibeli</p>
                            <p class="text-4xl font-black text-gray-900"><?php echo $tiket_total; ?></p>
                            <p class="text-[10px] font-black text-gray-300 uppercase tracking-widest mt-1">Sepanjang waktu</p>
                        </div>
                    </div>

                </div>

            <?php } else { ?>
                <div class="bg-white rounded-[3rem] p-20 text-center border-2 border-dashed border-gray-100">
                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="text-2xl">📭</span>
                    </div>
                    <h3 class="text-xl font-black text-gray-900 uppercase tracking-tight">Belum Ada Event Tersedia</h3>
                    <p class="text-sm text-gray-400 font-bold mt-2 uppercase tracking-widest">Pantau terus untuk info terbaru.</p>
                </div>
            <?php } ?>

        </div>
    </main>

</body>
</html>