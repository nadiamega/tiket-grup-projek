<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("location:login.php");
    exit;
}

$event_id = $_POST['event_id'];
$u_id     = $_SESSION['user_id'];
$nama     = mysqli_real_escape_string($conn, $_POST['nama']);
$kelas    = mysqli_real_escape_string($conn, $_POST['kelas']);
$telp     = mysqli_real_escape_string($conn, $_POST['telp']);

// Generate kode tiket unik
function generateKode($conn) {
    do {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $kode = 'TKT-';
        for ($i = 0; $i < 6; $i++) {
            $kode .= $chars[random_int(0, strlen($chars) - 1)];
        }
        $cek = mysqli_query($conn, "SELECT id FROM bookings WHERE kode_tiket='$kode'");
    } while (mysqli_num_rows($cek) > 0); // pastikan unik
    return $kode;
}
$kode_tiket = generateKode($conn);

$cek_event = mysqli_query($conn, "SELECT kuota FROM events WHERE id='$event_id'");
$d = mysqli_fetch_assoc($cek_event);

if($d['kuota'] > 0) {
    // FIX: tambahkan kolom nama ke INSERT
    $query_bookings = "INSERT INTO bookings (user_id, kode_tiket, nama_lengkap, event_id, kelas, telp) 
                      VALUES ('$u_id', '$kode_tiket', '$nama', '$event_id', '$kelas', '$telp')";
    
    if(mysqli_query($conn, $query_bookings)) {
        mysqli_query($conn, "UPDATE events SET kuota = kuota - 1 WHERE id='$event_id'");
        echo "<script>alert('Berhasil Booking!'); window.location='tiket_saya.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "<script>alert('Maaf, Kuota Habis!'); window.location='daftar_event.php';</script>";
}
?>