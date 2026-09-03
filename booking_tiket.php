<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("location:login.php");
    exit;
}

$id_event = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM events WHERE id = '$id_event'");
$data = mysqli_fetch_assoc($query);

// Logika Warna Kuota
$bg_kuota = ($data['kuota'] <= 10) ? 'bg-[#ff0000]' : 'bg-[#2563eb]';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Booking Tiket - SMART2</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-[#f8f9fd] flex min-h-screen">

    <?php include 'sidebar.php'; ?>

    <main class="flex-1 p-10 flex flex-col items-center justify-center">
        <h2 class="text-2xl font-black text-gray-900 text-center uppercase tracking-tighter mb-8">
            PEMESANAN TIKET<br><?php echo strtoupper($data['nama_event']); ?>
        </h2>

        <div class="w-full max-w-md space-y-6">
            <div class="<?php echo $bg_kuota; ?> p-8 rounded-3xl text-center text-white shadow-xl">
                <p class="text-xs font-bold uppercase tracking-widest mb-1">Sisa Kuota Tersedia</p>
                <h1 class="text-6xl font-black mb-1"><?php echo $data['kuota']; ?></h1>
                <p class="text-[10px] font-medium opacity-80">Ayo daftar sebelum kuota habis!</p>
            </div>

            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
                <form action="booking_proses.php" method="POST" class="space-y-4">
                    <input type="hidden" name="event_id" value="<?php echo $data['id']; ?>">
                    
                    <div>
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Nama Lengkap</label>
                        <input type="text" name="nama" class="w-full mt-1 p-4 text-transform: uppercase bg-gray-50 border border-gray-100 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="CONTOH: SEKAR AYU" required>
                    </div>

                    <div>
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Kelas</label>
                        <input type="text" name="kelas" class="w-full mt-1 p-4 text-transform: uppercase bg-gray-50 border border-gray-100 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="CONTOH: XI RPL 3" required>
                    </div>

                    <div>
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Nomor Telepon (WhatsApp)</label>
                        <input type="text" name="telp" class="w-full mt-1 p-4 bg-gray-50 border border-gray-100 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="08xxxxxxxxxx" required>
                    </div>

                    <button type="submit" class="w-full bg-black text-white p-4 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] mt-4 hover:bg-gray-800 transition">
                        DAFTAR SEKARANG
                    </button>
                    
                    <a href="daftar_event.php" class="block text-center text-[10px] font-black text-gray-400 uppercase tracking-widest mt-4 hover:text-red-500 transition">← BATAL</a>
                </form>
            </div>
        </div>

        <footer class="mt-10">
        </footer>
    </main>
</body>
</html>