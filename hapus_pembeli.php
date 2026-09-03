<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("location:login.php");
    exit;
}

$id = $_GET['id'];

// Ambil event_id dulu buat naikin kuota balik
$q = mysqli_query($conn, "SELECT event_id FROM bookings WHERE id='$id'");
$booking = mysqli_fetch_assoc($q);

if ($booking) {
    // Kembalikan kuota
    mysqli_query($conn, "UPDATE events SET kuota = kuota + 1 WHERE id='{$booking['event_id']}'");
    // Hapus booking
    mysqli_query($conn, "DELETE FROM bookings WHERE id='$id'");
}

header("location:daftar_pembeli.php");
exit;
?>