<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

// Pastikan koneksi tersedia
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// =========================
// SEARCH
// =========================
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$search_safe = mysqli_real_escape_string($conn, $search);

$where = '';

if ($search !== '') {
    $where = "WHERE bookings.nama_lengkap LIKE '%$search_safe%'
              OR bookings.kelas LIKE '%$search_safe%'
              OR events.nama_event LIKE '%$search_safe%'
              OR bookings.telp LIKE '%$search_safe%'";
}

// =========================
// PAGINATION
// =========================
$per_page = 7;

$page = isset($_GET['page']) && is_numeric($_GET['page'])
    ? (int) $_GET['page']
    : 1;

if ($page < 1) {
    $page = 1;
}

$offset = ($page - 1) * $per_page;

// =========================
// TOTAL DATA
// =========================
$total_query = "
    SELECT COUNT(*) AS total
    FROM bookings
    JOIN events ON bookings.event_id = events.id
    $where
";

$total_result = mysqli_query($conn, $total_query);

if (!$total_result) {
    die("Query total data gagal: " . mysqli_error($conn));
}

$total_row = mysqli_fetch_assoc($total_result);
$total_data = (int) $total_row['total'];

$total_pages = max(1, (int) ceil($total_data / $per_page));

// Jika page melebihi halaman terakhir
if ($page > $total_pages) {
    $page = $total_pages;
    $offset = ($page - 1) * $per_page;
}

// =========================
// DATA PEMBELI
// =========================
$q_pembeli = mysqli_query(
    $conn,
    "SELECT bookings.*, events.nama_event
     FROM bookings
     JOIN events ON bookings.event_id = events.id
     $where
     ORDER BY bookings.id ASC
     LIMIT $per_page OFFSET $offset"
);

if (!$q_pembeli) {
    die("Query data pembeli gagal: " . mysqli_error($conn));
}

// Helper untuk URL pagination
function page_url($page, $search)
{
    $url = 'daftar_pembeli.php?page=' . (int) $page;

    if ($search !== '') {
        $url .= '&search=' . urlencode($search);
    }

    return $url;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Daftar Pembeli - SMART2</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap"
        rel="stylesheet"
    >

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
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
                            value="' . htmlspecialchars($search, ENT_QUOTES, 'UTF-8') . '"
                            placeholder="Cari nama, kelas, event, telp..."
                            class="pl-10 pr-4 py-2.5 bg-gray-50 border-2 border-black rounded-2xl text-xs font-bold text-gray-700 focus:outline-none w-72 placeholder:text-gray-300 placeholder:font-medium"
                        >

                        <svg
                            class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-300"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2.5"
                            viewBox="0 0 24 24"
                        >
                            <circle cx="11" cy="11" r="8"/>
                            <path d="m21 21-4.35-4.35"/>
                        </svg>

                    </div>

                    ' .
                    (
                        $search !== ''
                        ? '<a
                            href="daftar_pembeli.php"
                            class="text-[10px] font-black text-gray-400 uppercase tracking-widest hover:text-red-500 transition"
                        >✕ Reset</a>'
                        : ''
                    )
                    . '

                </form>
            ';

            include 'header_admin.php';
            ?>

            <!-- TABLE -->
            <div class="bg-white rounded-[3rem] shadow-sm border border-gray-100 overflow-hidden">

                <div class="overflow-x-auto">

                    <table class="w-full text-left border-collapse table-fixed">

                        <thead>

                            <tr class="border-b border-gray-50">

                                <th class="p-8 text-[10px] font-black uppercase tracking-widest text-gray-400 w-[5%]">
                                    No
                                </th>

                                <th class="p-8 text-[10px] font-black uppercase tracking-widest text-gray-400 w-[25%]">
                                    Nama Siswa
                                </th>

                                <th class="p-8 text-[10px] font-black uppercase tracking-widest text-gray-400 w-[11%]">
                                    Kelas
                                </th>

                                <th class="p-8 text-[10px] font-black uppercase tracking-widest text-gray-400 w-[20%]">
                                    Event
                                </th>

                                <th class="p-8 text-[10px] font-black uppercase tracking-widest text-gray-400 w-[15%]">
                                    No. Telp
                                </th>

                                <th class="p-8 text-[10px] font-black uppercase tracking-widest text-gray-400 w-[15%]">
                                    Tanggal Beli
                                </th>

                                <th class="p-8 text-[10px] font-black uppercase tracking-widest text-gray-400 w-[9%]">
                                    Aksi
                                </th>

                            </tr>

                        </thead>

                        <tbody class="divide-y divide-gray-50">

                            <?php if (mysqli_num_rows($q_pembeli) > 0): ?>

                                <?php
                                $no = $offset + 1;

                                while ($p = mysqli_fetch_assoc($q_pembeli)):
                                ?>

                                <tr class="hover:bg-gray-50/50 transition">

                                    <!-- NO -->
                                    <td class="p-8 text-sm font-bold text-gray-900">
                                        <?= $no++; ?>
                                    </td>

                                    <!-- NAMA -->
                                    <td class="p-8">

                                        <p class="text-sm font-black text-gray-900">
                                            <?= htmlspecialchars(
                                                strtoupper($p['nama_lengkap']),
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>
                                        </p>

                                    </td>

                                    <!-- KELAS -->
                                    <td class="p-8 text-sm font-bold text-gray-600">
                                        <?= htmlspecialchars(
                                            $p['kelas'],
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ); ?>
                                    </td>

                                    <!-- EVENT -->
                                    <td class="p-8 text-sm font-bold text-blue-600">
                                        <?= htmlspecialchars(
                                            $p['nama_event'],
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ); ?>
                                    </td>

                                    <!-- TELP -->
                                    <td class="p-8 text-sm font-bold text-gray-600">
                                        <?= htmlspecialchars(
                                            $p['telp'],
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ); ?>
                                    </td>

                                    <!-- TANGGAL -->
                                    <td class="p-8 text-sm font-bold text-gray-400">

                                        <?php
                                        if (!empty($p['tanggal_beli'])) {
                                            echo date(
                                                'd M Y',
                                                strtotime($p['tanggal_beli'])
                                            );
                                        } else {
                                            echo '-';
                                        }
                                        ?>

                                    </td>

                                    <!-- AKSI -->
                                    <td class="p-8">

                                        <a
                                            href="hapus_pembeli.php?id=<?= (int) $p['id']; ?>"
                                            onclick="return confirm('Hapus data pembeli ini?')"
                                            class="text-[10px] font-black text-red-500 uppercase tracking-widest hover:text-red-700"
                                        >
                                            Hapus
                                        </a>

                                    </td>

                                </tr>

                                <?php endwhile; ?>

                            <?php else: ?>

                                <tr>

                                    <td colspan="7" class="py-24 text-center">

                                        <p class="text-[10px] font-black text-gray-300 uppercase tracking-[0.3em]">

                                            <?php if ($search !== ''): ?>

                                                Tidak ada hasil untuk
                                                "<?= htmlspecialchars(
                                                    $search,
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ); ?>"

                                            <?php else: ?>

                                                Belum ada data pembeli

                                            <?php endif; ?>

                                        </p>

                                    </td>

                                </tr>

                            <?php endif; ?>

                        </tbody>

                    </table>

                </div>

            </div>

            <!-- PAGINATION -->
            <?php if ($total_data > 0 && $total_pages > 1): ?>

                <div class="mt-6 flex items-center justify-between">

                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">

                        Halaman <?= $page; ?>
                        dari <?= $total_pages; ?>

                        &mdash;

                        Total <?= $total_data; ?> pembeli

                    </p>

                    <div class="flex items-center gap-2">

                        <!-- SEBELUMNYA -->
                        <?php if ($page > 1): ?>

                            <a
                                href="<?= htmlspecialchars(
                                    page_url($page - 1, $search),
                                    ENT_QUOTES,
                                    'UTF-8'
                                ); ?>"
                                class="px-6 py-3 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 transition shadow-sm"
                            >
                                ← Sebelumnya
                            </a>

                        <?php endif; ?>


                        <!-- NOMOR HALAMAN -->
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>

                            <a
                                href="<?= htmlspecialchars(
                                    page_url($i, $search),
                                    ENT_QUOTES,
                                    'UTF-8'
                                ); ?>"
                                class="w-10 h-10 flex items-center justify-center rounded-2xl text-[10px] font-black uppercase tracking-widest transition
                                <?= ($i == $page)
                                    ? 'bg-black text-white shadow-lg'
                                    : 'bg-white border border-gray-200 text-gray-400 hover:bg-gray-50'; ?>"
                            >
                                <?= $i; ?>
                            </a>

                        <?php endfor; ?>


                        <!-- SELANJUTNYA -->
                        <?php if ($page < $total_pages): ?>

                            <a
                                href="<?= htmlspecialchars(
                                    page_url($page + 1, $search),
                                    ENT_QUOTES,
                                    'UTF-8'
                                ); ?>"
                                class="px-6 py-3 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] bg-black text-white hover:bg-gray-800 transition shadow-lg shadow-gray-100"
                            >
                                Selanjutnya →
                            </a>

                        <?php endif; ?>

                    </div>

                </div>

            <?php elseif ($total_data > 0): ?>

                <div class="mt-6">

                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">
                        Total <?= $total_data; ?> pembeli
                    </p>

                </div>

            <?php endif; ?>

        </div>

    </main>

</body>
</html>
