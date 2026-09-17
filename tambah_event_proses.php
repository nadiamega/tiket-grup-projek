<?php
include 'koneksi.php';

$nama_event = mysqli_real_escape_string($conn, $_POST['nama_event']);
$kategori   = mysqli_real_escape_string($conn, $_POST['kategori']);
$tanggal    = $_POST['tanggal'];
$harga      = mysqli_real_escape_string($conn, $_POST['harga']);
$kuota      = $_POST['kuota'];
$lokasi     = mysqli_real_escape_string($conn, $_POST['lokasi']);
$deskripsi  = mysqli_real_escape_string($conn, $_POST['deskripsi']);

// Handle upload poster
$poster = '';
if (isset($_FILES['poster']) && $_FILES['poster']['error'] == 0) {
    $ext      = pathinfo($_FILES['poster']['name'], PATHINFO_EXTENSION);
    $filename = 'poster_' . time() . '.' . $ext;
    $target   = 'uploads/poster/' . $filename;
    if (move_uploaded_file($_FILES['poster']['tmp_name'], $target)) {
        $poster = $filename;
    }
}

$query = "INSERT INTO events (nama_event, kategori, tanggal, harga, kuota, lokasi, deskripsi, poster) 
          VALUES ('$nama_event', '$kategori', '$tanggal', '$harga', '$kuota', '$lokasi', '$deskripsi', '$poster')";

if (mysqli_query($conn, $query)) {
    $eventId = mysqli_insert_id($conn);

    // Simpan sponsor yang dicentang (kalau ada) ke tabel penghubung
    if (!empty($_POST['sponsor_id']) && is_array($_POST['sponsor_id'])) {
        foreach ($_POST['sponsor_id'] as $sponsorId) {
            $sponsorId = (int) $sponsorId;
            if ($sponsorId > 0) {
                mysqli_query($conn, "INSERT INTO event_sponsors (event_id, sponsor_id) VALUES ($eventId, $sponsorId)");
            }
        }
    }

    echo "<script>alert('Event berhasil ditambah!'); window.location='kelola_event.php';</script>";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>