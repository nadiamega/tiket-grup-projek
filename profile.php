<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$pesan = "";
$tipe_pesan = "";

// Ambil data user
$query = mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id'");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    echo "Data user tidak ditemukan.";
    exit;
}

$username = $data['username'];
$role = $data['role'];


// ===============================
// PROSES UPDATE PROFILE
// ===============================
if (isset($_POST['simpan'])) {

    $username_baru = trim($_POST['username']);
    $password_baru = $_POST['password'];
    $konfirmasi_password = $_POST['konfirmasi_password'];


    // Cek username kosong
    if ($username_baru == "") {

        $pesan = "Username tidak boleh kosong.";
        $tipe_pesan = "error";

    } else {

        // Cek apakah username sudah digunakan user lain
        $cek_username = mysqli_query(
            $conn,
            "SELECT id FROM users 
             WHERE username='$username_baru' 
             AND id != '$user_id'"
        );

        if (mysqli_num_rows($cek_username) > 0) {

            $pesan = "Username tersebut sudah digunakan.";
            $tipe_pesan = "error";

        } elseif ($password_baru != "" && $password_baru != $konfirmasi_password) {

            $pesan = "Konfirmasi password tidak sama.";
            $tipe_pesan = "error";

        } else {

            // Jika password tidak diisi,
            // hanya username yang diubah
            if ($password_baru == "") {

                $update = mysqli_query(
                    $conn,
                    "UPDATE users 
                     SET username='$username_baru'
                     WHERE id='$user_id'"
                );

            } else {

                // Jika password diisi,
                // username dan password ikut diubah
                $update = mysqli_query(
                    $conn,
                    "UPDATE users 
                     SET username='$username_baru',
                         password='$password_baru'
                     WHERE id='$user_id'"
                );
            }


            if ($update) {

                // Update session username
                $_SESSION['username'] = $username_baru;

                $username = $username_baru;

                $pesan = "Profile berhasil diperbarui.";
                $tipe_pesan = "success";

            } else {

                $pesan = "Profile gagal diperbarui.";
                $tipe_pesan = "error";
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Profile - <?php echo htmlspecialchars($username); ?></title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>


<body class="bg-[#f8f9fd] min-h-screen">


<div class="max-w-4xl mx-auto px-6 py-10">


    <!-- HEADER -->

    <div class="mb-10">

        <a href="javascript:history.back()"
           class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] hover:text-black transition">

            ← Kembali

        </a>


        <h1 class="text-[32px] font-black text-gray-900 tracking-tight mt-4">

            Profile

        </h1>


        <p class="text-sm text-gray-400 font-medium">

            Kelola informasi akun kamu

        </p>

    </div>



    <!-- PESAN -->

    <?php if ($pesan != "") : ?>

        <?php if ($tipe_pesan == "success") : ?>

            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl text-green-600 font-semibold">

                <?php echo $pesan; ?>

            </div>

        <?php else : ?>

            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-red-600 font-semibold">

                <?php echo $pesan; ?>

            </div>

        <?php endif; ?>

    <?php endif; ?>



    <!-- PROFILE CARD -->

    <div class="bg-white rounded-2xl shadow-sm p-8">


        <!-- AVATAR + INFO -->

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



        <div class="border-t border-gray-100 pt-8">


            <!-- FORM -->

            <form method="POST">


                <!-- USERNAME -->

                <div class="mb-6">

                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">

                        Username

                    </label>


                    <input
                        type="text"
                        name="username"
                        value="<?php echo htmlspecialchars($username); ?>"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl outline-none focus:border-black transition"
                        required
                    >

                </div>



                <!-- PASSWORD BARU -->

                <div class="mb-6">

                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">

                        Password Baru

                    </label>


                    <input
                        type="password"
                        name="password"
                        placeholder="Kosongkan jika tidak ingin mengganti"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl outline-none focus:border-black transition"
                    >

                    <p class="text-xs text-gray-400 mt-2">

                        Kosongkan jika hanya ingin mengganti username.

                    </p>

                </div>



                <!-- KONFIRMASI PASSWORD -->

                <div class="mb-8">

                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">

                        Konfirmasi Password Baru

                    </label>


                    <input
                        type="password"
                        name="konfirmasi_password"
                        placeholder="Ulangi password baru"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl outline-none focus:border-black transition"
                    >

                </div>



                <!-- BUTTON -->

                <button
                    type="submit"
                    name="simpan"
                    class="px-6 py-3 bg-black text-white rounded-xl font-bold text-sm hover:scale-105 transition">

                    Simpan Perubahan →

                </button>


            </form>

        </div>


    </div>

</div>


</body>

</html>