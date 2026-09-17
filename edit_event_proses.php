<?php
include 'koneksi.php';

$id        = $_POST['id'];
$nama      = mysqli_real_escape_string($conn, $_POST['nama_event']);
$kategori  = mysqli_real_escape_string($conn, $_POST['kategori']);
$tanggal   = $_POST['tanggal'];
$harga     = mysqli_real_escape_string($conn, $_POST['harga']);
$kuota     = $_POST['kuota'];
$lokasi    = mysqli_real_escape_string($conn, $_POST['lokasi']);
$deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);

// Ambil poster lama
$q_old   = mysqli_query($conn, "SELECT poster FROM events WHERE id='$id'");
$old     = mysqli_fetch_assoc($q_old);
$poster  = $old['poster'];

// Handle hapus poster
if (isset($_POST['hapus_poster']) && $_POST['hapus_poster'] == 1) {
    if (!empty($poster) && file_exists('uploads/poster/' . $poster)) {
        unlink('uploads/poster/' . $poster);
    }
    $poster = '';
}

// Handle upload poster baru (kalau ada)
if (isset($_FILES['poster']) && $_FILES['poster']['error'] == 0) {
    $ext      = pathinfo($_FILES['poster']['name'], PATHINFO_EXTENSION);
    $filename = 'poster_' . time() . '.' . $ext;
    $target   = 'uploads/poster/' . $filename;
    if (move_uploaded_file($_FILES['poster']['tmp_name'], $target)) {
        // Hapus poster lama kalau ada
        if (!empty($poster) && file_exists('uploads/poster/' . $poster)) {
            unlink('uploads/poster/' . $poster);
        }
        $poster = $filename;
    }
}

$query = "UPDATE events SET 
            nama_event='$nama', 
            kategori='$kategori', 
            tanggal='$tanggal', 
            harga='$harga', 
            kuota='$kuota',
            lokasi='$lokasi', 
            deskripsi='$deskripsi',
            poster='$poster'
          WHERE id='$id'";

if (mysqli_query($conn, $query)) {

    // Update relasi sponsor: hapus dulu yang lama, lalu simpan pilihan yang baru dicentang
    mysqli_query($conn, "DELETE FROM event_sponsors WHERE event_id='$id'");

    if (!empty($_POST['sponsor_id']) && is_array($_POST['sponsor_id'])) {
        foreach ($_POST['sponsor_id'] as $sponsorId) {
            $sponsorId = (int) $sponsorId;
            if ($sponsorId > 0) {
                mysqli_query($conn, "INSERT INTO event_sponsors (event_id, sponsor_id) VALUES ($id, $sponsorId)");
            }
        }
    }

    header("location:kelola_event.php");
} else {
    echo "Gagal mengupdate data: " . mysqli_error($conn);
}
?>