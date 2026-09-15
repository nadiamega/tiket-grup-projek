<?php
/**
 * kelola_sponsor.php
 * -------------------------------------------------------
 * Halaman ADMIN untuk kelola sponsor.
 * Struktur mengikuti pola asli project: file ini sendiri yang
 * membuka <html>/<head>/Tailwind + <body class="flex">, lalu
 * include sidebar.php dan header_admin.php di dalamnya.
 * -------------------------------------------------------
 */
session_start();
require_once 'koneksi.php';

// Hanya admin yang boleh akses
if (($_SESSION['role'] ?? '') !== 'admin') {
    header('Location: login.php');
    exit;
}

$page_title   = 'Kelola Sponsor';
$extra_button = '<a href="tambah_sponsor.php" class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm px-6 py-3 rounded-2xl shadow-lg transition">+ Tambah Sponsor</a>';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Sponsor - SMART2</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#f8f9fd] flex">

<?php include 'sidebar.php'; ?>

<main class="flex-1 p-10">
    <?php include 'header_admin.php'; ?>

    <?php if (isset($_SESSION['pesan_sukses'])): ?>
        <div class="mb-6 rounded-2xl bg-green-100 text-green-700 px-5 py-4 font-bold text-sm">
            <?= htmlspecialchars($_SESSION['pesan_sukses']) ?>
        </div>
        <?php unset($_SESSION['pesan_sukses']); ?>
    <?php endif; ?>

    <?php
    $sql = "SELECT id, nama_sponsor, gambar_sponsor FROM sponsors ORDER BY nama_sponsor ASC";
    $result = $conn->query($sql);
    ?>

    <?php if ($result && $result->num_rows > 0): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="bg-white rounded-2xl shadow-sm p-6 flex flex-col items-center text-center">

                    <div class="w-32 h-32 mx-auto flex items-center justify-center mb-4">
                        <?php
                        $pathGambar = 'assets/sponsors/' . $row['gambar_sponsor'];
                        if ($row['gambar_sponsor'] && file_exists($pathGambar)):
                        ?>
                            <img src="<?= htmlspecialchars($pathGambar) ?>"
                                 alt="<?= htmlspecialchars($row['nama_sponsor']) ?>"
                                 class="w-full h-full object-contain">
                        <?php else: ?>
                            <div class="w-full h-full bg-gray-100 rounded-xl flex items-center justify-center text-gray-400 text-sm">
                                No Logo
                            </div>
                        <?php endif; ?>
                    </div>

                    <p class="font-bold text-gray-800 text-lg mb-4">
                        <?= htmlspecialchars($row['nama_sponsor']) ?>
                    </p>

                    <div class="flex gap-3 mt-auto">
                        <a href="edit_sponsor.php?id=<?= (int)$row['id'] ?>"
                           class="text-sm font-semibold text-blue-600 hover:underline">
                            Edit
                        </a>
                        <a href="hapus_sponsor.php?id=<?= (int)$row['id'] ?>"
                           onclick="return confirm('Yakin ingin menghapus sponsor \'<?= htmlspecialchars($row['nama_sponsor'], ENT_QUOTES) ?>\'? Gambar juga akan dihapus.');"
                           class="text-sm font-semibold text-red-600 hover:underline">
                            Hapus
                        </a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p class="text-gray-500">Belum ada sponsor yang ditambahkan.</p>
    <?php endif; ?>

</main>

</body>
</html>
<?php $conn->close(); ?>