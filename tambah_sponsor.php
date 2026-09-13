<?php
include 'koneksi.php';
// session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("location:login.php");
    exit;
}

if(isset($_POST['tambah'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $kat  = mysqli_real_escape_string($conn, $_POST['kategori']);
    $mail = mysqli_real_escape_string($conn, $_POST['email']);
    $telp = mysqli_real_escape_string($conn, $_POST['telp']);
    mysqli_query($conn, "INSERT INTO sponsors (nama_sponsor, kategori, email, telp) VALUES ('$nama', '$kat', '$mail', '$telp')");
    header("location:kelola_sponsor.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Sponsor - SMART2</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-[#f8f9fd] flex min-h-screen">

    <?php include 'sidebar.php'; ?>

    <main class="flex-1 p-10 overflow-y-auto">
        <div class="max-w-full">
            <?php
            $page_title  = "Tambah Sponsor Baru";
            include 'header_admin.php';
            ?>

            <form action="tambah_sponsor.php" method="POST" class="bg-white p-10 rounded-[2.5rem] shadow-sm border border-gray-100 space-y-6">
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2">Nama Perusahaan/Sponsor</label>
                        <input type="text" name="nama" required class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-black font-bold text-gray-900">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2">Kategori Sponsor</label>
                        <input type="text" name="kategori" required class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-black font-bold text-gray-900">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2">No. Telepon</label>
                        <input type="text" name="telp" required class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-black font-bold text-gray-900">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2">Email Sponsor</label>
                        <input type="email" name="email" required class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-black font-bold text-gray-900">
                    </div>
                </div>

                <div class="flex gap-4 pt-4">
                    <button type="submit" name="tambah" class="flex-1 bg-black text-white py-5 rounded-2xl font-black hover:bg-gray-800 transition-all shadow-lg shadow-gray-100 uppercase tracking-[0.2em] text-[10px]">
                        Simpan Sponsor
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