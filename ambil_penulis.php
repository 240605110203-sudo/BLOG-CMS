<?php
require 'koneksi.php';
header('Content-Type: application/json');

$sql = "SELECT id, nama_depan, nama_belakang, user_name, password, foto FROM penulis ORDER BY id ASC";
$result = $koneksi->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode(['status' => 'ok', 'data' => $data]);
