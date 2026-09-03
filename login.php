<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SMART2</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#f8f9fd] flex items-center justify-center min-h-screen">
    <div class="bg-white p-10 rounded-[2.5rem] shadow-xl shadow-gray-100 border border-gray-100 w-full max-w-md">
        <div class="text-center mb-10">
            <h1 class="text-3xl font-black tracking-tighter">
                <span class="text-red-600">SMART</span><span class="text-blue-600">2</span>
            </h1>
            <p class="text-sm text-gray-400 font-bold mt-2 uppercase tracking-widest">Akses Tiket Event</p>
        </div>

        <form action="login_proses.php" method="POST" class="space-y-6">
            <div>
                <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Username</label>
                <input type="text" name="username" required class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-black transition font-semibold">
            </div>
            <div>
                <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Password</label>
                <input type="password" name="password" required class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:outline-none focus:ring-2 focus:ring-black transition font-semibold">
            </div>
            <button type="submit" class="w-full bg-black text-white py-4 rounded-2xl font-bold hover:bg-gray-800 transition-all shadow-lg shadow-gray-200">
                MASUK
            </button>
        </form>

        <div class="mt-8 text-center">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                Belum punya akun? <a href="register.php" class="text-blue-600 hover:underline">Register di sini</a>
            </p>
        </div>
    </div>
</body>

</html>