<?php
// include 'koneksi.php';
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("location:login.php");
    exit;
}

$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

$where = '';
if (!empty($search)) {
    $where = "WHERE bookings.nama_lengkap LIKE '%$search%'
              OR bookings.kelas LIKE '%$search%'
              OR events.nama_event LIKE '%$search%'
              OR bookings.telp LIKE '%$search%'";
}

$per_page = 7;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $per_page;

$total_result = mysqli_query($conn, "SELECT COUNT(*) as total FROM bookings JOIN events ON bookings.event_id = events.id $where");
$total_row = mysqli_fetch_assoc($total_result);
$total_data = $total_row['total'];
$total_pages = ceil($total_data / $per_page);

$q_pembeli = mysqli_query($conn, "SELECT bookings.*, events.nama_event 
                                   FROM bookings 
                                   JOIN events ON bookings.event_id = events.id
                                   $where
                                   ORDER BY bookings.id ASC
                                   LIMIT $per_page OFFSET $offset");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pembeli - SMART2</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-[#f8f9fd] flex min-h-screen">

    <?php include 'sidebar.php'; ?>

    <main class="flex-1 p-10 overflow-y-auto">
        <div class="max-w-full">
            <?php
            $page_title = "Daftar Pembeli";
            $extra_button = '
                <form method="GET" action="daftar_pembeli.php" class="flex items-center gap-3">
                    <div class="relative">
                        <input 
                            type="text" 
                            name="search" 
                            value="' . htmlspecialchars($search) . '"
                            placeholder="Cari nama, kelas, event, telp..." 
                            class="pl-10 pr-4 py-2.5 bg-gray-50 border-2 border-black rounded-2xl text-xs font-bold text-gray-700 focus:outline-none w-72 placeholder:text-gray-300 placeholder:font-medium"
                        >
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-300" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
                        </svg>
                    </div>
                    ' . (!empty($search) ? '<a href="daftar_pembeli.php" class="text-[10px] font-black text-gray-400 uppercase tracking-widest hover:text-red-500 transition">✕ Reset</a>' : '') . '
                </form>
            ';
            include 'header_admin.php';
            ?>

            <div class="bg-white rounded-[3rem] shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full text-left border-collapse table-fixed">
                    <thead>
                        <tr class="border-b border-gray-50">
                            <th class="p-8 text-[10px] font-black uppercase tracking-widest text-gray-400 w-[5%]">No</th>
                            <th class="p-8 text-[10px] font-black uppercase tracking-widest text-gray-400 w-[25%]">Nama Siswa</th>
                            <th class="p-8 text-[10px] font-black uppercase tracking-widest text-gray-400 w-[11%]">Kelas</th>
                            <th class="p-8 text-[10px] font-black uppercase tracking-widest text-gray-400 w-[20%]">Event</th>
                            <th class="p-8 text-[10px] font-black uppercase tracking-widest text-gray-400 w-[15%]">No. Telp</th>
                            <th class="p-8 text-[10px] font-black uppercase tracking-widest text-gray-400 w-[15%]">Tanggal Beli</th>
                            <th class="p-8 text-[10px] font-black uppercase tracking-widest text-gray-400 w-[9%]">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        <?php if (mysqli_num_rows($q_pembeli) > 0) : ?>
                            <?php $no = $offset + 1; while($p = mysqli_fetch_assoc($q_pembeli)) : ?>
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="p-8 text-sm font-bold text-gray-900"><?php echo $no++; ?></td>
                                <td class="p-8">
                                    <p class="text-sm font-black text-gray-900"><?php echo strtoupper($p['nama_lengkap']); ?></p>
                                </td>
                                <td class="p-8 text-sm font-bold text-gray-600"><?php echo $p['kelas']; ?></td>
                                <td class="p-8 text-sm font-bold text-blue-600"><?php echo $p['nama_event']; ?></td>
                                <td class="p-8 text-sm font-bold text-gray-600"><?php echo $p['telp']; ?></td>
                                <td class="p-8 text-sm font-bold text-gray-400"><?php echo date('d M Y', strtotime($p['tanggal_beli'])); ?></td>
                                <td class="p-8">
                                    <a href="hapus_pembeli.php?id=<?php echo $p['id']; ?>" onclick="return confirm('Hapus data pembeli ini?')" class="text-[10px] font-black text-red-500 uppercase tracking-widest hover:text-red-700">Hapus</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="7" class="py-24 text-center">
                                    <p class="text-[10px] font-black text-gray-300 uppercase tracking-[0.3em]">
                                        <?php echo !empty($search) ? 'Tidak ada hasil untuk "' . htmlspecialchars($search) . '"' : 'Belum ada data pembeli'; ?>
                                    </p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if ($total_pages > 1) : ?>
            <div class="mt-6 flex items-center justify-between">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">
                    Halaman <?php echo $page; ?> dari <?php echo $total_pages; ?> &mdash; Total <?php echo $total_data; ?> pembeli
                </p>
                <div class="flex items-center gap-2">
                    <?php if ($page > 1) : ?>
                        <a href="daftar_pembeli.php?page=<?php echo $page - 1; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>" class="px-6 py-3 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 transition shadow-sm">← Sebelumnya</a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                        <a href="daftar_pembeli.php?page=<?php echo $i; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>" class="w-10 h-10 flex items-center justify-center rounded-2xl text-[10px] font-black uppercase tracking-widest transition
                            <?php echo ($i == $page) ? 'bg-black text-white shadow-lg' : 'bg-white border border-gray-200 text-gray-400 hover:bg-gray-50'; ?>">
                            <?php echo $i; ?>
                        </a>
                    <?php endfor; ?>

                    <?php if ($page < $total_pages) : ?>
                        <a href="daftar_pembeli.php?page=<?php echo $page + 1; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>" class="px-6 py-3 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] bg-black text-white hover:bg-gray-800 transition shadow-lg shadow-gray-100">Selanjutnya →</a>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>

        </div>
    </main>
</body>
</html>
