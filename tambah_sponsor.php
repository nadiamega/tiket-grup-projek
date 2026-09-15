<?php
/**
 * tambah_sponsor.php
 * -------------------------------------------------------
 * Form tambah sponsor + proses simpan digabung satu file.
 * -------------------------------------------------------
 */
session_start();
require_once 'koneksi.php';
require_once 'sponsor_helper.php';

if (($_SESSION['role'] ?? '') !== 'admin') {
    header('Location: login.php');
    exit;
}

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nama_sponsor = trim($_POST['nama_sponsor'] ?? '');

    if ($nama_sponsor === '') {
        $error = 'Nama sponsor wajib diisi.';
    } elseif (!isset($_FILES['gambar_sponsor']) || $_FILES['gambar_sponsor']['error'] === UPLOAD_ERR_NO_FILE) {
        $error = 'Logo/gambar sponsor wajib diupload.';
    } else {
        $hasilUpload = upload_gambar_sponsor($_FILES['gambar_sponsor']);

        if (!$hasilUpload['success']) {
            $error = $hasilUpload['error'];
        } else {
            $namaFile = $hasilUpload['filename'];

            $stmt = $conn->prepare("INSERT INTO sponsors (nama_sponsor, gambar_sponsor) VALUES (?, ?)");
            $stmt->bind_param('ss', $nama_sponsor, $namaFile);

            if ($stmt->execute()) {
                $stmt->close();
                $conn->close();
                $_SESSION['pesan_sukses'] = 'Sponsor berhasil ditambahkan.';
                header('Location: kelola_sponsor.php');
                exit;
            } else {
                hapus_file_gambar_sponsor($namaFile);
                $error = 'Gagal menyimpan data sponsor ke database.';
            }
        }
    }
}

$page_title = 'Tambah Sponsor';
$back_link  = 'kelola_sponsor.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Sponsor - SMART2</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#f8f9fd] flex">

<?php include 'sidebar.php'; ?>

<main class="flex-1 p-10">
    <?php include 'header_admin.php'; ?>

    <?php if ($error): ?>
        <div class="mb-6 rounded-2xl bg-red-100 text-red-700 px-5 py-4 font-bold text-sm">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form action="tambah_sponsor.php" method="POST" enctype="multipart/form-data"
          class="bg-white rounded-2xl shadow-sm p-6 space-y-5 max-w-xl">

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Sponsor</label>
            <input type="text" name="nama_sponsor" required
                   value="<?= htmlspecialchars($_POST['nama_sponsor'] ?? '') ?>"
                   class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Logo / Gambar Sponsor</label>
            <input type="file" name="gambar_sponsor" accept=".jpg,.jpeg,.png,.webp" required
                   class="w-full border border-gray-300 rounded-xl px-4 py-2.5">
            <p class="text-xs text-gray-400 mt-1">Format: JPG, JPEG, PNG, WEBP. Maks 2MB.</p>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2.5 rounded-xl shadow-sm transition">
                Simpan
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
<?php if (isset($conn) && $conn->ping()) { $conn->close(); } ?>