<?php
/**
 * edit_sponsor.php
 * -------------------------------------------------------
 * Form edit sponsor. Proses simpan ada di edit_sponsor_proses.php.
 * -------------------------------------------------------
 */
session_start();
require_once 'koneksi.php';

if (($_SESSION['role'] ?? '') !== 'admin') {
    header('Location: login.php');
    exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header('Location: kelola_sponsor.php');
    exit;
}

$stmt = $conn->prepare("SELECT id, nama_sponsor, gambar_sponsor, email FROM sponsors WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$sponsor = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$sponsor) {
    header('Location: kelola_sponsor.php');
    exit;
}

$page_title = 'Edit Sponsor';
$back_link  = 'kelola_sponsor.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Sponsor - SMART2</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#f8f9fd] flex">

<?php include 'sidebar.php'; ?>

<main class="flex-1 p-10">
    <?php include 'header_admin.php'; ?>

    <?php if (isset($_SESSION['pesan_error'])): ?>
        <div class="mb-6 rounded-2xl bg-red-100 text-red-700 px-5 py-4 font-bold text-sm">
            <?= htmlspecialchars($_SESSION['pesan_error']) ?>
        </div>
        <?php unset($_SESSION['pesan_error']); ?>
    <?php endif; ?>

    <form action="edit_sponsor_proses.php" method="POST" enctype="multipart/form-data"
          class="bg-white rounded-2xl shadow-sm p-6 space-y-5 max-w-xl">

        <input type="hidden" name="id" value="<?= (int)$sponsor['id'] ?>">

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Sponsor</label>
            <input type="text" name="nama_sponsor" required
                   value="<?= htmlspecialchars($sponsor['nama_sponsor']) ?>"
                   class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Email Sponsor <span class="text-gray-400 font-normal">(opsional)</span></label>
            <input type="email" name="email"
                   value="<?= htmlspecialchars($sponsor['email'] ?? '') ?>"
                   placeholder="contoh@email.com"
                   class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Logo Saat Ini</label>
            <div class="w-32 h-32 flex items-center justify-center border border-gray-200 rounded-xl mb-3">
                <?php
                $pathGambar = 'assets/sponsors/' . $sponsor['gambar_sponsor'];
                if ($sponsor['gambar_sponsor'] && file_exists($pathGambar)):
                ?>
                    <img src="<?= htmlspecialchars($pathGambar) ?>" class="w-full h-full object-contain">
                <?php else: ?>
                    <span class="text-gray-400 text-sm">No Logo</span>
                <?php endif; ?>
            </div>

            <label class="block text-sm font-semibold text-gray-700 mb-1">Ganti Gambar (opsional)</label>
            <input type="file" name="gambar_sponsor" accept=".jpg,.jpeg,.png,.webp"
                   class="w-full border border-gray-300 rounded-xl px-4 py-2.5">
            <p class="text-xs text-gray-400 mt-1">Kosongkan jika tidak ingin mengganti gambar.</p>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2.5 rounded-xl shadow-sm transition">
                Simpan Perubahan
            </button>
            <a href="kelola_sponsor.php"
               class="px-6 py-2.5 rounded-xl border border-gray-300 text-gray-600 font-semibold hover:bg-gray-50 transition">
                Batal
            </a>
        </div>
    </form>
</main>

</body>
</html>
<?php $conn->close(); ?>