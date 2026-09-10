<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$query = mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id'");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    echo "Data user tidak ditemukan.";
    exit;
}

$username = $data['username'];
$role = $data['role'];
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Profile - <?php echo htmlspecialchars($username); ?></title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50">

    <div class="max-w-4xl mx-auto px-6 py-10">

        <!-- Header -->
        <div class="mb-10">

            <a href="javascript:history.back()"
               class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] hover:text-black transition">
                ← Kembali
            </a>

            <h1 class="text-[32px] font-black text-gray-900 tracking-tight mt-4">
                Profile
            </h1>

            <p class="text-sm text-gray-400 font-medium">
                Informasi akun kamu
            </p>

        </div>


        <!-- Profile Card -->
        <div class="bg-white rounded-2xl shadow-sm p-8">

            <!-- Avatar -->
            <div class="flex items-center gap-5 mb-8">

                <div class="w-20 h-20 bg-black rounded-full flex items-center justify-center text-white text-3xl font-bold uppercase">
                    <?php echo strtoupper(substr($username, 0, 1)); ?>
                </div>

                <div>

                    <h2 class="text-xl font-black text-gray-900">
                        <?php echo htmlspecialchars($username); ?>
                    </h2>

                    <p class="text-sm text-gray-400 capitalize">
                        <?php echo htmlspecialchars($role); ?>
                    </p>

                </div>

            </div>


            <!-- Data Profile -->
            <div class="border-t pt-6">

                <!-- Username -->
                <div class="mb-6">

                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">
                        Username
                    </p>

                    <p class="text-base font-semibold text-gray-900 mt-1">
                        <?php echo htmlspecialchars($username); ?>
                    </p>

                </div>


                <!-- Role -->
                <div class="mb-6">

                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">
                        Role
                    </p>

                    <p class="text-base font-semibold text-gray-900 mt-1 capitalize">
                        <?php echo htmlspecialchars($role); ?>
                    </p>

                </div>


                <!-- Status -->
                <div>

                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">
                        Status Akun
                    </p>

                    <p class="text-base font-semibold text-green-600 mt-1">
                        Aktif
                    </p>

                </div>

            </div>

        </div>

    </div>

</body>

</html>