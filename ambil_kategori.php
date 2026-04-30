<?php
require 'koneksi.php';
header('Content-Type: application/json');

$result = $koneksi->query("SELECT id, nama_kategori, keterangan FROM kategori_artikel ORDER BY id ASC");
$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode(['status' => 'ok', 'data' => $data]);
