<?php
// Inisialisasi session
session_start();

// Hapus semua variabel session
$_SESSION = array();

// Jika ingin menghapus session cookie, lakukan hal berikut:
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Hancurkan session secara total
session_destroy();

// Redirect ke halaman index/login dengan feedback (opsional)
header("location:index.php?pesan=logout_berhasil");
exit;
?>
