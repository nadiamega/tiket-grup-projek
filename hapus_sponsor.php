<?php
include 'koneksi.php';
// session_start();
if($_SESSION['role'] != 'admin') exit;

$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM sponsors WHERE id='$id'");
header("location:kelola_sponsor.php");
?>

<!-- ap yak -->