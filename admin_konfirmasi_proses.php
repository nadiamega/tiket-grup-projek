<?php
include 'koneksi.php';
// session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("location:login.php");
    exit;
}

$booking_id = (int) $_POST['booking_id'];
$event_id   = (int) $_POST['event_id'];

// Pastikan booking ini masih Pending (hindari klik ganda / kuota berkurang dobel)
$cek = mysqli_query($conn, "SELECT status_pembayaran FROM bookings WHERE id='$booking_id'");
$b   = mysqli_fetch_assoc($cek);

if ($b && $b['status_pembayaran'] === 'Pending') {
    mysqli_query($conn, "UPDATE bookings SET status_pembayaran = 'Lunas' WHERE id = '$booking_id'");
    mysqli_query($conn, "UPDATE events SET kuota = kuota - 1 WHERE id = '$event_id'");
    echo "<script>alert('Pembayaran dikonfirmasi, kuota telah dikurangi.'); window.location='admin_konfirmasi.php';</script>";
} else {
    echo "<script>alert('Booking ini sudah diproses sebelumnya.'); window.location='admin_konfirmasi.php';</script>";
}
?>