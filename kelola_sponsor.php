<?php
include 'koneksi.php';
// session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("location:login.php");
    exit;
}

$per_page = 7;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $per_page;

$total_result = mysqli_query($conn, "SELECT COUNT(*) as total FROM sponsors");
$total_row = mysqli_fetch_assoc($total_result);
$total_data = $total_row['total'];
$total_pages = ceil($total_data / $per_page);

$q = mysqli_query($conn, "SELECT * FROM sponsors ORDER BY id ASC LIMIT $per_page OFFSET $offset");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Sponsor - SMART2</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-[#f8f9fd] flex min-h-screen">

    <?php include 'sidebar.php'; ?>

    <main class="flex-1 p-10 overflow-y-auto">
        <?php
        $page_title   = "Kelola Sponsor";
        $extra_button = '<a href="tambah_sponsor.php" class="bg-black text-white px-8 py-3 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] hover:bg-gray-800 transition shadow-lg shadow-gray-100">+ Tambah Sponsor</a>';
        include 'header_admin.php';
        ?>

        <div class="bg-white rounded-[2.5rem] overflow-hidden border border-gray-100 shadow-sm">
            <table class="w-full table-fixed text-left">
                <thead class="bg-gray-50 text-[10px] uppercase font-black text-gray-400 tracking-[0.2em]">
                    <tr>
                        <th class="p-8 w-[22%]">Nama Sponsor</th>
                        <th class="p-8 w-[22%]">Kategori</th>
                        <th class="p-8 w-[22%]">No. Telepon</th>
                        <th class="p-8 w-[22%]">Email</th>
                        <th class="p-8 w-[12%]">Aksi</th>
                    </tr>
                </thead>
                <tbody class="font-bold text-sm text-gray-700">
                    <?php
                    if(mysqli_num_rows($q) > 0) {
                        while($s = mysqli_fetch_assoc($q)) { ?>
                            <tr class="border-t border-gray-50 hover:bg-gray-50/50 transition">
                                <td class="p-8 text-gray-900 font-black truncate"><?php echo htmlspecialchars($s['nama_sponsor']); ?></td>
                                <td class="p-8">
                                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest bg-gray-50 px-4 py-2 rounded-lg">
                                        <?php echo htmlspecialchars($s['kategori']); ?>
                                    </span>
                                </td>
                                <td class="p-8 font-bold text-gray-600"><?php echo htmlspecialchars($s['telp']); ?></td>
                                <td class="p-8 font-bold text-blue-600 underline decoration-2 underline-offset-4 decoration-blue-100 truncate"><?php echo htmlspecialchars($s['email']); ?></td>
                                <td class="p-8">
                                    <div class="flex gap-6">
                                        <a href="edit_sponsor.php?id=<?php echo $s['id']; ?>" class="text-[10px] font-black text-blue-600 uppercase tracking-widest hover:underline">Edit</a>
                                        <a href="hapus_sponsor.php?id=<?php echo $s['id']; ?>" onclick="return confirm('Hapus sponsor ini?')" class="text-[10px] font-black text-red-600 uppercase tracking-widest hover:underline">Hapus</a>
                                    </div>
                                </td>
                            </tr>
                        <?php }
                    } else { ?>
                        <tr>
                            <td colspan="5" class="p-20 text-center">
                                <p class="text-[10px] font-black text-gray-300 uppercase tracking-[0.3em]">Belum ada data sponsor</p>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <?php if ($total_pages > 1) : ?>
        <div class="mt-6 flex items-center justify-between">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">
                Halaman <?php echo $page; ?> dari <?php echo $total_pages; ?> &mdash; Total <?php echo $total_data; ?> sponsor
            </p>
            <div class="flex items-center gap-2">
                <?php if ($page > 1) : ?>
                    <a href="kelola_sponsor.php?page=<?php echo $page - 1; ?>" class="px-6 py-3 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 transition shadow-sm">← Sebelumnya</a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                    <a href="kelola_sponsor.php?page=<?php echo $i; ?>" class="w-10 h-10 flex items-center justify-center rounded-2xl text-[10px] font-black uppercase tracking-widest transition
                        <?php echo ($i == $page) ? 'bg-black text-white shadow-lg' : 'bg-white border border-gray-200 text-gray-400 hover:bg-gray-50'; ?>">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>

                <?php if ($page < $total_pages) : ?>
                    <a href="kelola_sponsor.php?page=<?php echo $page + 1; ?>" class="px-6 py-3 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] bg-black text-white hover:bg-gray-800 transition shadow-lg shadow-gray-100">Selanjutnya →</a>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>

    </main>
</body>
</html>
