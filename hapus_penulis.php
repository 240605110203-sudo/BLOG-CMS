<?php
require 'koneksi.php';
header('Content-Type: application/json');

$id = intval($_POST['id'] ?? 0);
if (!$id) {
    echo json_encode(['status' => 'error', 'pesan' => 'ID tidak valid.']);
    exit;
}

// Cek apakah penulis masih memiliki artikel
$cek = $koneksi->prepare("SELECT COUNT(*) AS jumlah FROM artikel WHERE id_penulis = ?");
$cek->bind_param('i', $id);
$cek->execute();
$jumlah = $cek->get_result()->fetch_assoc()['jumlah'];

if ($jumlah > 0) {
    echo json_encode(['status' => 'error', 'pesan' => 'Penulis tidak dapat dihapus karena masih memiliki artikel.']);
    exit;
}

// Ambil foto sebelum hapus
$stmt = $koneksi->prepare("SELECT foto FROM penulis WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();

if (!$row) {
    echo json_encode(['status' => 'error', 'pesan' => 'Data tidak ditemukan.']);
    exit;
}

$del = $koneksi->prepare("DELETE FROM penulis WHERE id = ?");
$del->bind_param('i', $id);

if ($del->execute()) {
    // Hapus file foto jika bukan default
    if ($row['foto'] !== 'default.png') {
        $path = __DIR__ . '/uploads_penulis/' . $row['foto'];
        if (file_exists($path)) unlink($path);
    }
    echo json_encode(['status' => 'ok', 'pesan' => 'Penulis berhasil dihapus.']);
} else {
    echo json_encode(['status' => 'error', 'pesan' => 'Gagal menghapus data.']);
}
