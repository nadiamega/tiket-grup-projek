<?php
include 'koneksi.php';
// session_start();

if (!isset($_SESSION['username'])) {
    header("location:login.php");
    exit;
}

$id_event = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM events WHERE id = '$id_event'");
$data = mysqli_fetch_assoc($query);

// Logika Warna Kuota
$bg_kuota = ($data['kuota'] <= 10) ? 'bg-[#ff0000]' : 'bg-[#2563eb]';

// Cek apakah event ini gratis atau berbayar
$harga_raw = trim($data['harga']); // contoh: "Rp 5.000" atau "Gratis"
$is_gratis = (stripos($harga_raw, 'gratis') !== false);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pembayaran Tiket - SMART2</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-[#f8f9fd] flex min-h-screen">

    <?php include 'sidebar.php'; ?>

    <main class="flex-1 p-10 flex flex-col items-center justify-center">
        <h2 class="text-2xl font-black text-gray-900 text-center uppercase tracking-tighter mb-8">
            PEMBAYARAN TIKET
        </h2>

        <div class="w-full max-w-md space-y-6">
            <div class="<?php echo $bg_kuota; ?> p-8 rounded-3xl text-center text-white shadow-xl">
                <p class="text-xs font-bold uppercase tracking-widest mb-1">Sisa Kuota Tersedia</p>
                <h1 class="text-6xl font-black mb-1"><?php echo $data['kuota']; ?></h1>
                <p class="text-[10px] font-medium opacity-80">Ayo daftar sebelum kuota habis!</p>
            </div>

            <!-- STRUK PEMBAYARAN -->
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4 text-center">Struk Pemesanan</p>

                <div class="space-y-3 border-b border-dashed border-gray-200 pb-4 mb-4">
                    <div class="flex justify-between items-start">
                        <span class="text-xs text-gray-400 font-bold">Nama Pembeli</span>
                        <span class="text-sm font-black text-gray-900 text-right uppercase"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                    </div>
                    <div class="flex justify-between items-start">
                        <span class="text-xs text-gray-400 font-bold">Nama Event</span>
                        <span class="text-sm font-black text-gray-900 text-right"><?php echo htmlspecialchars($data['nama_event']); ?></span>
                    </div>
                    <div class="flex justify-between items-start">
                        <span class="text-xs text-gray-400 font-bold">Kategori</span>
                        <span class="text-sm font-bold text-gray-700 text-right"><?php echo htmlspecialchars($data['kategori']); ?></span>
                    </div>
                    <div class="flex justify-between items-start">
                        <span class="text-xs text-gray-400 font-bold">Tanggal</span>
                        <span class="text-sm font-bold text-gray-700 text-right"><?php echo date('d F Y', strtotime($data['tanggal'])); ?></span>
                    </div>
                    <div class="flex justify-between items-start">
                        <span class="text-xs text-gray-400 font-bold">Lokasi</span>
                        <span class="text-sm font-bold text-gray-700 text-right"><?php echo htmlspecialchars($data['lokasi']); ?></span>
                    </div>
                </div>

                <div class="flex justify-between items-center mb-6">
                    <span class="text-xs text-gray-500 font-black uppercase tracking-widest">Total Harga</span>
                    <span class="text-2xl font-black text-gray-900"><?php echo htmlspecialchars($harga_raw); ?></span>
                </div>

                <form action="booking_proses.php" method="POST" class="space-y-4">
                    <input type="hidden" name="event_id" value="<?php echo $data['id']; ?>">

                    <div>
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Kelas</label>
                        <input type="text" name="kelas" class="w-full mt-1 p-4 uppercase bg-gray-50 border border-gray-100 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="CONTOH: XI RPL 3" required>
                    </div>

                    <div>
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Nomor Telepon (WhatsApp)</label>
                        <input type="text" name="telp" class="w-full mt-1 p-4 bg-gray-50 border border-gray-100 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="08xxxxxxxxxx" required>
                    </div>

                    <?php if ($is_gratis): ?>
                        <!-- Event gratis: tidak perlu metode bayar -->
                        <input type="hidden" name="metode_bayar" value="Gratis">
                        <div class="bg-green-50 border border-green-100 text-green-700 text-xs font-bold p-4 rounded-2xl text-center">
                            Tiket ini GRATIS, tidak perlu pembayaran.
                        </div>
                    <?php else: ?>
                        <!-- PILIH METODE BAYAR -->
                        <div>
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1 mb-2 block">Metode Pembayaran</label>
                            <div class="space-y-2">
                                <label class="flex items-center gap-3 p-4 bg-gray-50 border border-gray-100 rounded-2xl cursor-pointer">
                                    <input type="radio" name="metode_bayar" value="Transfer Bank" required class="accent-black">
                                    <span class="text-sm font-bold">Transfer Bank</span>
                                </label>
                                <label class="flex items-center gap-3 p-4 bg-gray-50 border border-gray-100 rounded-2xl cursor-pointer">
                                    <input type="radio" name="metode_bayar" value="QRIS" class="accent-black">
                                    <span class="text-sm font-bold">QRIS</span>
                                </label>
                                <label class="flex items-center gap-3 p-4 bg-gray-50 border border-gray-100 rounded-2xl cursor-pointer">
                                    <input type="radio" name="metode_bayar" value="Bayar di Tempat" class="accent-black">
                                    <span class="text-sm font-bold">Bayar di Tempat</span>
                                </label>
                            </div>
                        </div>
                    <?php endif; ?>

                    <button type="submit" class="w-full bg-black text-white p-4 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] mt-4 hover:bg-gray-800 transition">
                        <?php echo $is_gratis ? 'DAFTAR SEKARANG' : 'BAYAR & DAFTAR SEKARANG'; ?>
                    </button>

                    <a href="daftar_event.php" class="block text-center text-[10px] font-black text-gray-400 uppercase tracking-widest mt-4 hover:text-red-500 transition">← BATAL</a>
                </form>
            </div>
        </div>

        <footer class="mt-10"></footer>
    </main>
</body>
</html>