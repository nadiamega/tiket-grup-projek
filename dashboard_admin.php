<?php
include 'koneksi.php';
// session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("location:login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - SMART2</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#f8f9fd] flex min-h-screen">

    <?php include 'sidebar.php'; ?>

    <main class="flex-1 p-10 overflow-y-auto">
        <div class="max-w-full">
            <?php
            $page_title    = "Dashboard";
            $page_subtitle = "Selamat datang kembali, " . $_SESSION['username'] . ".";
            include 'header_admin.php';
            ?>

            <?php
            $q_event = mysqli_query($conn, "SELECT * FROM events ORDER BY id DESC LIMIT 1");
            
            if(mysqli_num_rows($q_event) > 0) {
                $e = mysqli_fetch_assoc($q_event);
                $event_id = $e['id'];
            ?>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-[3rem] p-10 border border-gray-100 shadow-sm h-full">
                            <p class="text-[10px] font-black text-blue-600 uppercase tracking-widest mb-4">Event Terkini</p>
                            <h3 class="text-2xl font-black text-gray-900 leading-tight mb-6"><?php echo $e['nama_event']; ?></h3>
                            <div class="space-y-4">
                                <div class="bg-gray-50 p-4 rounded-2xl">
                                    <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Tanggal</p>
                                    <p class="text-sm font-bold"><?php echo date('d M Y', strtotime($e['tanggal'])); ?></p>
                                </div>
                                <div class="bg-gray-50 p-4 rounded-2xl">
                                    <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Sisa Kuota</p>
                                    <p class="text-sm font-bold text-blue-600"><?php echo $e['kuota']; ?> Tiket</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-[3rem] p-10 border border-gray-100 shadow-sm h-full">
                            <p class="text-[10px] font-black text-blue-600 uppercase tracking-widest mb-6">Pembeli Terakhir</p>
                            <div class="overflow-hidden">
                                <table class="w-full text-left">
                                    <tbody class="divide-y divide-gray-50">
                                        <?php
                                        // FIX: JOIN pakai user_id, filter role = 'user' biar admin tidak masuk
                                        $q_pembeli = mysqli_query($conn, "SELECT bookings.*, users.username 
                                                                           FROM bookings 
                                                                           JOIN users ON bookings.user_id = users.id 
                                                                           WHERE bookings.event_id = '$event_id' 
                                                                           AND users.role = 'user'
                                                                           ORDER BY bookings.id DESC LIMIT 5");
                                        if(mysqli_num_rows($q_pembeli) > 0) {
                                            while($p = mysqli_fetch_assoc($q_pembeli)) {
                                        ?>
                                            <tr class="group">
                                                <td class="py-4">
                                                    <p class="text-sm font-black text-gray-900"><?php echo strtoupper($p['nama_lengkap']); ?></p>
                                                    <p class="text-[10px] font-bold text-gray-400 uppercase"><?php echo $p['kelas']; ?></p>
                                                </td>
                                                <td class="py-4 text-right">
                                                    <span class="text-[10px] font-black text-gray-300 group-hover:text-black transition uppercase">Berhasil</span>
                                                </td>
                                            </tr>
                                        <?php 
                                            }
                                        } else { ?>
                                            <tr>
                                                <td colspan="2" class="py-10 text-center">
                                                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Belum ada pembeli untuk event ini</p>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            <?php } else { ?>
                <div class="bg-white rounded-[3rem] p-20 text-center border-2 border-dashed border-gray-100">
                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="text-2xl">⚙️</span>
                    </div>
                    <h3 class="text-xl font-black text-gray-900 uppercase tracking-tight">Belum Ada Data Terkini</h3>
                </div>
            <?php } ?>

        </div>
    </main>

</body>
</html>