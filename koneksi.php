<?php
$host = "127.0.0.1";
$user = "root";
$pass = "";
$db   = "proweb";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi ke database proweb gagal: " . mysqli_connect_error());
}
?>