<?php
include 'koneksi.php';
// session_start();

// FIX: uncomment proteksi dan ambil data
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("location:login.php");
    exit;
}

$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM events WHERE id='$id'");
$data = mysqli_fetch_assoc($query);

if (mysqli_num_rows($query) < 1) {
    die("Data tidak ditemukan...");
}

// Ambil sponsor yang sudah terhubung ke event ini
$selectedSponsors = [];
$q_sel = mysqli_query($conn, "SELECT sponsor_id FROM event_sponsors WHERE event_id='$id'");
while ($s = mysqli_fetch_assoc($q_sel)) {
    $selectedSponsors[] = (int)$s['sponsor_id'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event - SMART2</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#f8f9fd] flex min-h-screen">

    <?php include 'sidebar.php'; ?>

    <main class="flex-1 p-10 overflow-y-auto">
        <div class="max-w-full">
            <?php
            $page_title = "Edit Data Event";
            include 'header_admin.php';
            ?>

            <form action="edit_event_proses.php" method="POST" enctype="multipart/form-data" class="bg-white p-10 rounded-[2.5rem] shadow-sm border border-gray-100 space-y-6">
                <input type="hidden" name="id" value="<?php echo $data['id']; ?>">

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2">Nama Event</label>
                        <input type="text" name="nama_event" value="<?php echo htmlspecialchars($data['nama_event']); ?>" required class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-black font-bold">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2">Kategori</label>
                        <input type="text" name="kategori" value="<?php echo htmlspecialchars($data['kategori']); ?>" required class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-black font-bold">
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-6">
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2">Tanggal</label>
                        <input type="date" name="tanggal" value="<?php echo $data['tanggal']; ?>" required class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-black font-bold text-sm">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2">Harga Tiket</label>
                        <input type="text" name="harga" value="<?php echo htmlspecialchars($data['harga']); ?>" required class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-black font-bold">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2">Kuota Tiket</label>
                        <input type="number" name="kuota" value="<?php echo isset($data['kuota']) ? $data['kuota'] : 0; ?>" required class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-black font-bold">
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2">Lokasi</label>
                    <input type="text" name="lokasi" value="<?php echo htmlspecialchars($data['lokasi']); ?>" required class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-black font-bold">
                </div>

                <div>
                    <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2">Deskripsi Event</label>
                    <textarea name="deskripsi" rows="4" class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-black font-bold"><?php echo htmlspecialchars($data['deskripsi']); ?></textarea>
                </div>

                <div>
                    <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2">Sponsor <span class="text-gray-300 normal-case tracking-normal">(opsional, boleh pilih lebih dari satu)</span></label>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3 p-6 bg-gray-50 border border-gray-100 rounded-2xl">
                        <?php
                        $sponsorList = mysqli_query($conn, "SELECT id, nama_sponsor FROM sponsors ORDER BY nama_sponsor ASC");
                        if (mysqli_num_rows($sponsorList) > 0) {
                            while ($sp = mysqli_fetch_assoc($sponsorList)) {
                                $isChecked = in_array((int)$sp['id'], $selectedSponsors, true) ? 'checked' : '';
                        ?>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="sponsor_id[]" value="<?php echo (int)$sp['id']; ?>" <?php echo $isChecked; ?> class="w-4 h-4 rounded accent-black">
                                <span class="text-sm font-bold text-gray-700"><?php echo htmlspecialchars($sp['nama_sponsor']); ?></span>
                            </label>
                        <?php
                            }
                        } else {
                            echo '<p class="text-sm text-gray-400 col-span-full">Belum ada data sponsor. Tambahkan dulu lewat menu Kelola Sponsor.</p>';
                        }
                        ?>
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2">Poster Event <span class="text-gray-300">(kosongkan jika tidak ingin mengubah)</span></label>
                    <?php if (!empty($data['poster'])): ?>
                        <div class="mb-3 flex items-center gap-4">
                            <img src="uploads/poster/<?php echo $data['poster']; ?>" class="w-20 h-20 object-cover rounded-2xl border border-gray-100">
                            <div>
                                <p class="text-xs font-bold text-gray-400 mb-2">Poster saat ini</p>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" name="hapus_poster" value="1" class="w-4 h-4 rounded accent-black">
                                    <span class="text-[10px] font-black text-red-500 uppercase tracking-widest">Hapus poster ini</span>
                                </label>
                            </div>
                        </div>
                    <?php endif; ?>
                    <input type="file" name="poster" accept="image/*" class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-black font-bold text-gray-900 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-black file:text-white hover:file:bg-gray-800">
                </div>

                <div class="flex gap-4 pt-4">
                    <button type="submit" class="flex-1 bg-black text-white py-5 rounded-2xl font-black hover:bg-gray-800 transition-all shadow-lg shadow-gray-100 uppercase tracking-[0.2em] text-[10px]">
                        Simpan Perubahan
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