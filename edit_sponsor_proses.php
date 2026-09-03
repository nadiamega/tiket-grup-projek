<?php
include 'koneksi.php';

$id        = $_POST['id'];
$nama      = $_POST['nama_sponsor'];
$kategori  = $_POST['kategori'];
$telp      = $_POST['telp'];
$email     = $_POST['email'];

$query = "UPDATE sponsors SET 
            nama_sponsor='$nama',
            kategori='$kategori',
            telp='$telp',
            email='$email'
          WHERE id='$id'";

if (mysqli_query($conn, $query)) {
    header("location:kelola_sponsor.php");
} else {
    echo "Gagal mengupdate data: " . mysqli_error($conn);
}
?>