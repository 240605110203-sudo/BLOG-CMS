<?php
require 'koneksi.php';
header('Content-Type: application/json');

$id            = intval($_POST['id'] ?? 0);
$nama_kategori = trim($_POST['nama_kategori'] ?? '');
$keterangan    = trim($_POST['keterangan'] ?? '');

if (!$id || !$nama_kategori) {
    echo json_encode(['status' => 'error', 'pesan' => 'ID dan nama kategori wajib diisi.']);
    exit;
}

$stmt = $koneksi->prepare("UPDATE kategori_artikel SET nama_kategori=?, keterangan=? WHERE id=?");
$stmt->bind_param('ssi', $nama_kategori, $keterangan, $id);

if ($stmt->execute()) {
    echo json_encode(['status' => 'ok', 'pesan' => 'Kategori berhasil diperbarui.']);
} else {
    echo json_encode(['status' => 'error', 'pesan' => 'Gagal memperbarui. Nama kategori mungkin sudah ada.']);
}
