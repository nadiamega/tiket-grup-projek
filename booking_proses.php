<?php
include 'koneksi.php';
// session_start();

if (!isset($_SESSION['username'])) {
    header("location:login.php");
    exit;
}

$event_id     = $_POST['event_id'];
$u_id         = $_SESSION['user_id'];
$nama         = mysqli_real_escape_string($conn, $_SESSION['username']); // ambil dari session, bukan form
$kelas        = mysqli_real_escape_string($conn, $_POST['kelas']);
$telp         = mysqli_real_escape_string($conn, $_POST['telp']);
$metode_bayar = mysqli_real_escape_string($conn, $_POST['metode_bayar']);

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

// Ambil harga ASLI dari database (bukan dari form) supaya tidak bisa dimanipulasi user
$cek_event = mysqli_query($conn, "SELECT kuota, harga FROM events WHERE id='$event_id'");
$d = mysqli_fetch_assoc($cek_event);

if ($d && $d['kuota'] > 0) {

    // Parse harga varchar (mis. "Rp 5.000" / "Gratis") jadi angka murni
    $harga_raw = trim($d['harga']);
    if (stripos($harga_raw, 'gratis') !== false) {
        $total_bayar = 0;
    } else {
        $total_bayar = (int) preg_replace('/[^0-9]/', '', $harga_raw); // "Rp 5.000" -> 5000
    }

    // --- LOGIKA STATUS PEMBAYARAN ---
    // Kalau gratis: langsung Lunas & kuota langsung dikurangi (tidak perlu konfirmasi admin)
    // Kalau berbayar: status Pending, menunggu admin konfirmasi (kuota dikurangi nanti oleh admin)
    if ($total_bayar === 0) {
        $status_pembayaran = "Lunas";
    } else {
        $status_pembayaran = "Pending";
    }

    $query_bookings = "INSERT INTO bookings 
        (user_id, kode_tiket, nama_lengkap, event_id, kelas, telp, metode_bayar, total_bayar, status_pembayaran) 
        VALUES 
        ('$u_id', '$kode_tiket', '$nama', '$event_id', '$kelas', '$telp', '$metode_bayar', '$total_bayar', '$status_pembayaran')";

    if (mysqli_query($conn, $query_bookings)) {
        if ($status_pembayaran === "Lunas") {
            // Gratis: kuota langsung dikurangi saat ini juga
            mysqli_query($conn, "UPDATE events SET kuota = kuota - 1 WHERE id='$event_id'");
            echo "<script>alert('Booking Berhasil! Tiket kamu sudah aktif.'); window.location='tiket_saya.php';</script>";
        } else {
            echo "<script>alert('Booking berhasil dikirim! Menunggu konfirmasi admin.'); window.location='tiket_saya.php';</script>";
        }
    } else {
        echo "Error: " . mysqli_error($conn);
    }

} else {
    echo "<script>alert('Maaf, Kuota Habis!'); window.location='daftar_event.php';</script>";
}
?>