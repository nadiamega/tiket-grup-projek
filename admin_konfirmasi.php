<?php
include 'koneksi.php';
// session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("location:login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Konfirmasi Pembayaran - SMART2</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-[#f8f9fd] flex min-h-screen">

    <?php include 'sidebar.php'; ?>

    <main class="flex-1 p-10">
        <h2 class="text-2xl font-black text-gray-900 uppercase tracking-tighter mb-8">
            Konfirmasi Pembayaran
        </h2>

        <div class="space-y-4">
            <?php
            $q = mysqli_query($conn, "SELECT bookings.*, events.nama_event, events.harga 
                                       FROM bookings 
                                       JOIN events ON bookings.event_id = events.id 
                                       WHERE bookings.status_pembayaran = 'Pending'
                                       ORDER BY bookings.tanggal_beli ASC");

            if (mysqli_num_rows($q) > 0) {
                while ($b = mysqli_fetch_assoc($q)) {

                    $bayar_text = ((int)$b['total_bayar'] > 0)
                        ? 'Rp ' . number_format($b['total_bayar'], 0, ',', '.') . ' · ' . htmlspecialchars($b['metode_bayar'])
                        : 'Gratis';
                    ?>
                    <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm flex items-center justify-between">
                        <div class="space-y-1">
                            <p class="text-[10px] font-black text-yellow-500 uppercase tracking-widest">Pending</p>
                            <h3 class="text-lg font-black text-gray-900"><?php echo htmlspecialchars($b['nama_event']); ?></h3>
                            <p class="text-sm text-gray-500">
                                <?php echo htmlspecialchars($b['nama_lengkap']); ?> ·
                                <?php echo htmlspecialchars($b['kelas']); ?> ·
                                <?php echo htmlspecialchars($b['telp']); ?>
                            </p>
                            <p class="text-sm font-bold text-gray-700">Kode: <?php echo htmlspecialchars($b['kode_tiket']); ?> — <?php echo $bayar_text; ?></p>
                            <p class="text-[10px] text-gray-400">Dipesan: <?php echo date('d M Y H:i', strtotime($b['tanggal_beli'])); ?></p>
                        </div>

                        <form action="admin_konfirmasi_proses.php" method="POST">
                            <input type="hidden" name="booking_id" value="<?php echo $b['id']; ?>">
                            <input type="hidden" name="event_id" value="<?php echo $b['event_id']; ?>">
                            <button type="submit" class="bg-black text-white px-6 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-gray-800 transition">
                                Konfirmasi
                            </button>
                        </form>
                    </div>
                <?php }
            } else { ?>
                <div class="bg-white rounded-[3rem] p-20 text-center border-2 border-dashed border-gray-100">
                    <p class="text-sm font-black text-gray-400 uppercase tracking-widest">Tidak ada pembayaran pending saat ini.</p>
                </div>
            <?php } ?>
        </div>
    </main>
</body>
</html>