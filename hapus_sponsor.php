<?php
/**
 * hapus_sponsor.php
 * -------------------------------------------------------
 * Menghapus data sponsor dari database + file gambarnya.
 * Konfirmasi sudah dilakukan di kelola_sponsor.php lewat
 * popup confirm() JavaScript sebelum link ini diakses.
 * -------------------------------------------------------
 */
session_start();
require_once 'koneksi.php';
require_once 'sponsor_helper.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header('Location: kelola_sponsor.php');
    exit;
}

$stmt = $conn->prepare("SELECT gambar_sponsor FROM sponsors WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$sponsor = $stmt->get_result()->fetch_assoc();
$stmt->close();

if ($sponsor) {
    $stmtDelete = $conn->prepare("DELETE FROM sponsors WHERE id = ?");
    $stmtDelete->bind_param('i', $id);

    if ($stmtDelete->execute()) {
        hapus_file_gambar_sponsor($sponsor['gambar_sponsor']);
        $_SESSION['pesan_sukses'] = 'Sponsor berhasil dihapus.';
    } else {
        $_SESSION['pesan_sukses'] = 'Gagal menghapus sponsor.';
    }
    $stmtDelete->close();
}

$conn->close();
header('Location: kelola_sponsor.php');
exit;