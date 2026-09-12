<?php
include 'koneksi.php';
// session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("location:login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Event - SMART2</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#f8f9fd] flex min-h-screen">

    <?php include 'sidebar.php'; ?>

    <main class="flex-1 p-10 overflow-y-auto">
        <div class="max-w-full">
            <?php
            $page_title = "Tambah Event Baru";
            // $page_subtitle = "Buat pengumuman event baru untuk siswa SMK Antartika 2";
            // $back_link = "kelola_event.php";
            include 'header_admin.php';
            ?>

            <form action="tambah_event_proses.php" method="POST" enctype="multipart/form-data" class="bg-white p-10 rounded-[2.5rem] shadow-sm border border-gray-100 space-y-6">
                
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2">Nama Event</label>
                        <input type="text" name="nama_event" required placeholder="Contoh: Pentas Seni 2026" class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-black font-bold text-gray-900">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2">Kategori</label>
                        <input type="text" name="kategori" placeholder="Contoh: Hiburan / Olahraga" required class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-black font-bold text-gray-900">
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-6">
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2">Tanggal</label>
                        <input type="date" name="tanggal" required class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-black font-bold text-sm text-gray-900">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2">Harga Tiket</label>
                        <input type="text" name="harga" placeholder="Rp 50.000 / Gratis" required class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-black font-bold text-gray-900">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2">Kuota Tiket</label>
                        <input type="number" name="kuota" placeholder="Contoh: 100" required class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-black font-bold text-gray-900">
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2">Lokasi Pelaksanaan</label>
                    <input type="text" name="lokasi" required placeholder="Contoh: Aula Lt. 3" class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-black font-bold text-gray-900">
                </div>

                <div>
                    <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2">Deskripsi Detail Event</label>
                    <textarea name="deskripsi" rows="4" placeholder="Tuliskan detail acara di sini..." class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-black font-bold text-gray-900"></textarea>
                </div>

                <div>
                    <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2">Poster Event <span class="text-gray-300">(opsional)</span></label>
                    <input type="file" name="poster" accept="image/*" class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-black font-bold text-gray-900 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-black file:text-white hover:file:bg-gray-800">
                </div>

                <div class="flex gap-4 pt-4">
                    <button type="submit" class="flex-1 bg-black text-white py-5 rounded-2xl font-black hover:bg-gray-800 transition-all shadow-lg shadow-gray-100 uppercase tracking-[0.2em] text-[10px]">
                        Simpan & Publikasikan Event
                    </button>
                    <a href="kelola_event.php" class="px-10 flex items-center justify-center bg-gray-100 text-gray-400 py-5 rounded-2xl font-black uppercase tracking-[0.2em] text-[10px] hover:bg-gray-200 transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </main>
</body>
</html>