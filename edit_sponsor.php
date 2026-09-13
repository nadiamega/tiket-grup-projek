<?php
include 'koneksi.php';
// session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("location:login.php");
    exit;
}

$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM sponsors WHERE id = '$id'");
$s = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Sponsor - SMART2</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-[#f8f9fd] flex min-h-screen">

    <?php include 'sidebar.php'; ?>

    <main class="flex-1 p-10 overflow-y-auto">
        <div class="max-w-full">
            <?php
            $page_title = "Edit Data Sponsor";
            include 'header_admin.php';
            ?>

            <form action="edit_sponsor_proses.php" method="POST" class="bg-white p-10 rounded-[2.5rem] shadow-sm border border-gray-100 space-y-6">
                <input type="hidden" name="id" value="<?php echo $s['id']; ?>">
                
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2">Nama Sponsor</label>
                        <input type="text" name="nama_sponsor" value="<?php echo htmlspecialchars($s['nama_sponsor']); ?>" required class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-black font-bold text-gray-900">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2">Kategori Sponsor</label>
                        <input type="text" name="kategori" value="<?php echo htmlspecialchars($s['kategori']); ?>" required class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-black font-bold text-gray-900">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2">Nomor Telepon</label>
                        <input type="text" name="telp" value="<?php echo htmlspecialchars($s['telp']); ?>" required class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-black font-bold text-gray-900">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2">Email</label>
                        <input type="email" name="email" value="<?php echo htmlspecialchars($s['email']); ?>" required class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-black font-bold text-gray-900">
                    </div>
                </div>

                <div class="flex gap-4 pt-4">
                    <button type="submit" class="flex-1 bg-black text-white py-5 rounded-2xl font-black hover:bg-gray-800 transition-all shadow-lg shadow-gray-100 uppercase tracking-[0.2em] text-[10px]">
                        Simpan Perubahan
                    </button>
                    <a href="kelola_sponsor.php" class="px-10 flex items-center justify-center bg-gray-100 text-gray-400 py-5 rounded-2xl font-black uppercase tracking-[0.2em] text-[10px] hover:bg-gray-200 transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </main>
</body>
</html>