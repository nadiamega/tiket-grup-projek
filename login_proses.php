<?php
include 'koneksi.php';
// session_start();

$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

$query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND password='$password'");
$data = mysqli_fetch_assoc($query);

if (mysqli_num_rows($query) > 0) {
    $_SESSION['username'] = $data['username'];
    $_SESSION['role']     = $data['role'];
    $_SESSION['user_id']  = $data['id'];

    if ($data['role'] == 'admin') {
        header("location:dashboard_admin.php");
    } else {
        header("location:dashboard_user.php");
    }
} else {
    echo "<script>alert('Username atau password salah!'); window.location='login.php';</script>";
}
?>
