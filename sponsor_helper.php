<?php
/**
 * sponsor_helper.php
 * -------------------------------------------------------
 * Fungsi bantu khusus fitur sponsor: validasi & upload logo,
 * serta hapus file gambar lama.
 * Di-include di: tambah_sponsor.php dan edit_sponsor_proses.php
 * -------------------------------------------------------
 */

define('SPONSOR_UPLOAD_DIR', __DIR__ . '/assets/sponsors/');
define('SPONSOR_ALLOWED_EXT', ['jpg', 'jpeg', 'png', 'webp']);
define('SPONSOR_ALLOWED_MIME', ['image/jpeg', 'image/png', 'image/webp']);
define('SPONSOR_MAX_SIZE', 2 * 1024 * 1024); // 2 MB

/**
 * Validasi & simpan file gambar sponsor yang diupload.
 *
 * @param array $file  $_FILES['gambar_sponsor']
 * @return array ['success' => bool, 'filename' => string|null, 'error' => string|null]
 */
function upload_gambar_sponsor(array $file): array
{
    if (!isset($file['error']) || $file['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'filename' => null, 'error' => 'Terjadi kesalahan saat upload file.'];
    }

    if ($file['size'] > SPONSOR_MAX_SIZE) {
        return ['success' => false, 'filename' => null, 'error' => 'Ukuran file maksimal 2MB.'];
    }

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, SPONSOR_ALLOWED_EXT, true)) {
        return ['success' => false, 'filename' => null, 'error' => 'Format file harus JPG, JPEG, PNG, atau WEBP.'];
    }

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime  = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    if (!in_array($mime, SPONSOR_ALLOWED_MIME, true)) {
        return ['success' => false, 'filename' => null, 'error' => 'File yang diupload bukan gambar yang valid.'];
    }

    if (!is_dir(SPONSOR_UPLOAD_DIR)) {
        mkdir(SPONSOR_UPLOAD_DIR, 0755, true);
    }

    $namaFileBaru = 'sponsor_' . uniqid() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
    $tujuan = SPONSOR_UPLOAD_DIR . $namaFileBaru;

    if (!move_uploaded_file($file['tmp_name'], $tujuan)) {
        return ['success' => false, 'filename' => null, 'error' => 'Gagal menyimpan file ke server.'];
    }

    return ['success' => true, 'filename' => $namaFileBaru, 'error' => null];
}

/**
 * Hapus file gambar sponsor dari folder assets/sponsors/
 */
function hapus_file_gambar_sponsor(?string $namaFile): void
{
    if (!$namaFile) {
        return;
    }
    $path = SPONSOR_UPLOAD_DIR . $namaFile;
    if (is_file($path)) {
        unlink($path);
    }
}