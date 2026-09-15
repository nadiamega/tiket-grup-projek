<?php
/**
 * sponsors.php
 * -------------------------------------------------------
 * Halaman daftar sponsor untuk USER yang sudah login.
 *
 * CATATAN: saya belum punya isi header_user.php, jadi bagian
 * <?php include 'header_user.php'; ?> di bawah ini saya
 * asumsikan mirip header_admin.php (butuh variabel $page_title).
 * Kalau ternyata header_user.php punya nama variabel beda atau
 * strukturnya beda, kirim isinya dan saya sesuaikan lagi.
 * -------------------------------------------------------
 */
session_start();
require_once 'koneksi.php';

// Halaman ini hanya untuk yang sudah login
if (empty($_SESSION['role'])) {
    header('Location: login.php');
    exit;
}

$page_title = 'Daftar Sponsor';

$sql = "SELECT id, nama_sponsor, gambar_sponsor FROM sponsors ORDER BY nama_sponsor ASC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Sponsor - SMART2</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#f8f9fd] flex">

<?php include 'sidebar.php'; ?>

<main class="flex-1 p-10">
    <?php
    // Kalau header_user.php ternyata tidak butuh $page_title,
    // baris include ini tetap aman dijalankan, cuma judul di atas tidak muncul.
    if (file_exists('header_user.php')) {
        include 'header_user.php';
    } else {
        echo '<h2 class="text-[32px] font-black text-gray-900 tracking-tight mb-8">Daftar Sponsor</h2>';
    }
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

                    <p class="font-bold text-gray-800 text-lg">
                        <?= htmlspecialchars($row['nama_sponsor']) ?>
                    </p>
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