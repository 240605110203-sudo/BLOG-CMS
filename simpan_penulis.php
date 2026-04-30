<?php
require 'koneksi.php';
header('Content-Type: application/json');

$nama_depan   = trim($_POST['nama_depan'] ?? '');
$nama_belakang = trim($_POST['nama_belakang'] ?? '');
$user_name    = trim($_POST['user_name'] ?? '');
$password     = $_POST['password'] ?? '';

if (!$nama_depan || !$nama_belakang || !$user_name || !$password) {
    echo json_encode(['status' => 'error', 'pesan' => 'Semua field wajib diisi.']);
    exit;
}

// Handle foto upload
$foto = 'default.png';
if (!empty($_FILES['foto']['name'])) {
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime  = $finfo->file($_FILES['foto']['tmp_name']);
    $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

    if (!in_array($mime, $allowed)) {
        echo json_encode(['status' => 'error', 'pesan' => 'Tipe file tidak diizinkan. Gunakan JPG, PNG, GIF, atau WEBP.']);
        exit;
    }

    if ($_FILES['foto']['size'] > 2 * 1024 * 1024) {
        echo json_encode(['status' => 'error', 'pesan' => 'Ukuran file maksimal 2 MB.']);
        exit;
    }

    $ext  = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
    $foto = uniqid('foto_') . '.' . $ext;
    $dest = __DIR__ . '/uploads_penulis/' . $foto;

    if (!move_uploaded_file($_FILES['foto']['tmp_name'], $dest)) {
        echo json_encode(['status' => 'error', 'pesan' => 'Gagal menyimpan foto.']);
        exit;
    }
}

$hash = password_hash($password, PASSWORD_BCRYPT);

$stmt = $koneksi->prepare("INSERT INTO penulis (nama_depan, nama_belakang, user_name, password, foto) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param('sssss', $nama_depan, $nama_belakang, $user_name, $hash, $foto);

if ($stmt->execute()) {
    echo json_encode(['status' => 'ok', 'pesan' => 'Penulis berhasil ditambahkan.']);
} else {
    // Kemungkinan duplicate username
    echo json_encode(['status' => 'error', 'pesan' => 'Gagal menyimpan. Username mungkin sudah digunakan.']);
}
