<?php
require 'koneksi.php';
header('Content-Type: application/json');

$id = intval($_POST['id'] ?? 0);
if (!$id) {
    echo json_encode(['status' => 'error', 'pesan' => 'ID tidak valid.']);
    exit;
}

// Ambil gambar sebelum hapus
$stmt = $koneksi->prepare("SELECT gambar FROM artikel WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();

if (!$row) {
    echo json_encode(['status' => 'error', 'pesan' => 'Data tidak ditemukan.']);
    exit;
}

$del = $koneksi->prepare("DELETE FROM artikel WHERE id = ?");
$del->bind_param('i', $id);

if ($del->execute()) {
    // Hapus file gambar dari server
    $path = __DIR__ . '/uploads_artikel/' . $row['gambar'];
    if (file_exists($path)) unlink($path);
    echo json_encode(['status' => 'ok', 'pesan' => 'Artikel berhasil dihapus.']);
} else {
    echo json_encode(['status' => 'error', 'pesan' => 'Gagal menghapus artikel.']);
}
