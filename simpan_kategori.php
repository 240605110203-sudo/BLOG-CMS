<?php
require 'koneksi.php';
header('Content-Type: application/json');

$nama_kategori = trim($_POST['nama_kategori'] ?? '');
$keterangan    = trim($_POST['keterangan'] ?? '');

if (!$nama_kategori) {
    echo json_encode(['status' => 'error', 'pesan' => 'Nama kategori wajib diisi.']);
    exit;
}

$stmt = $koneksi->prepare("INSERT INTO kategori_artikel (nama_kategori, keterangan) VALUES (?, ?)");
$stmt->bind_param('ss', $nama_kategori, $keterangan);

if ($stmt->execute()) {
    echo json_encode(['status' => 'ok', 'pesan' => 'Kategori berhasil ditambahkan.']);
} else {
    echo json_encode(['status' => 'error', 'pesan' => 'Gagal menyimpan. Nama kategori mungkin sudah ada.']);
}
