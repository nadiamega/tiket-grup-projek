<?php
include 'koneksi.php';

if (isset($_POST['register'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // 1. Cek apakah username DAN password sudah ada yang sama persis di database
    $cek_data = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND password='$password'");
    
    if (mysqli_num_rows($cek_data) > 0) {
        // Jika data ditemukan, beri peringatan
        echo "<script>
                alert('Pendaftaran Gagal: Akun dengan kombinasi ini sudah ada!');
                window.location='register.php';
              </script>";
    } else {
        // 2. Jika data unik (baru), masukkan ke tabel users
        // Default role diset 'user' untuk pendaftaran mandiri
        $query = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', 'user')";
        
        if (mysqli_query($conn, $query)) {
            echo "<script>
                    alert('Pendaftaran Berhasil! Silakan Masuk.');
                    window.location='login.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Terjadi kesalahan teknis: " . mysqli_error($conn) . "');
                  </script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - SMART2</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">
    <!-- <style>body { font-family: 'Inter', sans-serif; }</style> -->
</head>
<body class="bg-[#f8f9fd] flex items-center justify-center min-h-screen">
    <div class="bg-white p-10 rounded-[2.5rem] shadow-xl shadow-gray-100 border border-gray-100 w-full max-w-md">
        <div class="text-center mb-10">
            <h1 class="text-3xl font-black tracking-tighter">
                <span class="text-red-600">SMART</span><span class="text-blue-600">2</span>
            </h1>
            <p class="text-sm text-gray-400 font-bold mt-2 uppercase tracking-widest">Buat Akun Baru</p>
        </div>

        <form action="" method="POST" class="space-y-6">
            <div>
                <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Username</label>
                <input type="text" name="username" required class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-black transition font-semibold">
            </div>
            <div>
                <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Password</label>
                <input type="password" name="password" required class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-black transition font-semibold">
            </div>
            <button type="submit" name="register" class="w-full bg-black text-white py-4 rounded-2xl font-bold hover:bg-gray-800 transition-all shadow-lg shadow-gray-200">
                DAFTAR
            </button>
        </form>

        <div class="mt-8 text-center">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                Sudah punya akun? <a href="login.php" class="text-blue-600 hover:underline">Masuk di sini</a>
            </p>
        </div>
        
    </div>
</body>
</html>