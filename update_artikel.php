<?php
require 'koneksi.php';
header('Content-Type: application/json');

$id          = intval($_POST['id'] ?? 0);
$judul       = trim($_POST['judul'] ?? '');
$id_penulis  = intval($_POST['id_penulis'] ?? 0);
$id_kategori = intval($_POST['id_kategori'] ?? 0);
$isi         = trim($_POST['isi'] ?? '');

if (!$id || !$judul || !$id_penulis || !$id_kategori || !$isi) {
    echo json_encode(['status' => 'error', 'pesan' => 'Field wajib tidak boleh kosong.']);
    exit;
}

// Ambil gambar lama
$stmt = $koneksi->prepare("SELECT gambar FROM artikel WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$lama = $stmt->get_result()->fetch_assoc();

if (!$lama) {
    echo json_encode(['status' => 'error', 'pesan' => 'Data tidak ditemukan.']);
    exit;
}

$gambar = $lama['gambar'];

// Handle gambar baru (opsional)
if (!empty($_FILES['gambar']['name'])) {
    $finfo   = new finfo(FILEINFO_MIME_TYPE);
    $mime    = $finfo->file($_FILES['gambar']['tmp_name']);
    $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

    if (!in_array($mime, $allowed)) {
        echo json_encode(['status' => 'error', 'pesan' => 'Tipe file tidak diizinkan.']);
        exit;
    }

    if ($_FILES['gambar']['size'] > 2 * 1024 * 1024) {
        echo json_encode(['status' => 'error', 'pesan' => 'Ukuran file maksimal 2 MB.']);
        exit;
    }

    $ext         = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
    $gambar_baru = uniqid('artikel_') . '.' . $ext;
    $dest        = __DIR__ . '/uploads_artikel/' . $gambar_baru;

    if (move_uploaded_file($_FILES['gambar']['tmp_name'], $dest)) {
        // Hapus gambar lama
        $old_path = __DIR__ . '/uploads_artikel/' . $lama['gambar'];
        if (file_exists($old_path)) unlink($old_path);
        $gambar = $gambar_baru;
    } else {
        echo json_encode(['status' => 'error', 'pesan' => 'Gagal menyimpan gambar.']);
        exit;
    }
}

$upd = $koneksi->prepare("UPDATE artikel SET id_penulis=?, id_kategori=?, judul=?, isi=?, gambar=? WHERE id=?");
$upd->bind_param('iisssi', $id_penulis, $id_kategori, $judul, $isi, $gambar, $id);

if ($upd->execute()) {
    echo json_encode(['status' => 'ok', 'pesan' => 'Artikel berhasil diperbarui.']);
} else {
    echo json_encode(['status' => 'error', 'pesan' => 'Gagal memperbarui artikel.']);
}
