<?php
include '../../include/db.php';
include '../../include/session.php';

if (!isset($_GET['id'])) {
    exit("ID resep tidak ditemukan.");
}

$id_resep = intval($_GET['id']);
$user_id = $_SESSION['user_id'];
$is_admin = ($kategori === 'ADMIN');

$cek = mysqli_query($koneksi, "SELECT * FROM tabel_resep WHERE id_resep = $id_resep");
$resep = mysqli_fetch_assoc($cek);

if (!$resep) {
    exit("Resep tidak ditemukan.");
}

if ($resep['id_user'] != $user_id && !$is_admin) {
    exit("Kamu tidak berhak menghapus resep ini.");
}

mysqli_query($koneksi, "DELETE FROM tabel_suka WHERE id_resep = $id_resep");
mysqli_query($koneksi, "DELETE FROM tabel_bookmark WHERE id_resep = $id_resep");

mysqli_query($koneksi, "DELETE FROM tabel_resep WHERE id_resep = $id_resep");

header("Location: resep.php");
exit;
