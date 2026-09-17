<?php
/**
 * edit_sponsor_proses.php
 * -------------------------------------------------------
 * Memproses data dari form edit_sponsor.php.
 * Tidak menampilkan HTML apapun — hanya proses lalu redirect.
 * -------------------------------------------------------
 */
session_start();
require_once 'koneksi.php';
require_once 'sponsor_helper.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: kelola_sponsor.php');
    exit;
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$nama_sponsor = trim($_POST['nama_sponsor'] ?? '');
$email = trim($_POST['email'] ?? '');

if ($id <= 0 || $nama_sponsor === '') {
    $_SESSION['pesan_error'] = 'Data tidak lengkap.';
    header('Location: edit_sponsor.php?id=' . $id);
    exit;
}

if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['pesan_error'] = 'Format email tidak valid.';
    header('Location: edit_sponsor.php?id=' . $id);
    exit;
}

$emailToSave = $email !== '' ? $email : null;

// Ambil data lama dulu (untuk tau nama file gambar lama)
$stmt = $conn->prepare("SELECT gambar_sponsor FROM sponsors WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$sponsorLama = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$sponsorLama) {
    header('Location: kelola_sponsor.php');
    exit;
}

$namaFileFinal = $sponsorLama['gambar_sponsor']; // default: gambar lama
$adaGambarBaru = isset($_FILES['gambar_sponsor']) && $_FILES['gambar_sponsor']['error'] !== UPLOAD_ERR_NO_FILE;

if ($adaGambarBaru) {
    $hasilUpload = upload_gambar_sponsor($_FILES['gambar_sponsor']);

    if (!$hasilUpload['success']) {
        $_SESSION['pesan_error'] = $hasilUpload['error'];
        header('Location: edit_sponsor.php?id=' . $id);
        exit;
    }
    $namaFileFinal = $hasilUpload['filename'];
}

$stmt = $conn->prepare("UPDATE sponsors SET nama_sponsor = ?, gambar_sponsor = ?, email = ? WHERE id = ?");
$stmt->bind_param('sssi', $nama_sponsor, $namaFileFinal, $emailToSave, $id);

if ($stmt->execute()) {
    $stmt->close();

    // Kalau gambar diganti, hapus file gambar lama supaya folder tidak menumpuk sampah
    if ($adaGambarBaru && $sponsorLama['gambar_sponsor'] !== $namaFileFinal) {
        hapus_file_gambar_sponsor($sponsorLama['gambar_sponsor']);
    }

    $conn->close();
    $_SESSION['pesan_sukses'] = 'Sponsor berhasil diperbarui.';
    header('Location: kelola_sponsor.php');
    exit;
} else {
    $_SESSION['pesan_error'] = 'Gagal memperbarui data sponsor.';
    header('Location: edit_sponsor.php?id=' . $id);
    exit;
}