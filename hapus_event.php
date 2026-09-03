<?php
include 'koneksi.php';
session_start();

// Proteksi: Cek apakah yang akses beneran admin
if ($_SESSION['role'] != 'admin') {
    header("location:login.php");
    exit;
}

// Ambil ID dari URL
$id = $_GET['id'];

// Jalankan perintah hapus
$query = mysqli_query($conn, "DELETE FROM events WHERE id='$id'");

if ($query) {
    // Jika berhasil, balikkan ke halaman events
    header("location:kelola_event.php");
} else {
    echo "Gagal menghapus data: " . mysqli_error($conn);
}
?>