<?php
include '../../include/db.php';
include '../../include/session.php';

if (!isset($_GET['id_resep'])) exit("ID resep tidak valid.");
$id_resep = intval($_GET['id_resep']);
$id_user = $_SESSION['user_id'];

$cek = mysqli_query($koneksi, "SELECT * FROM tabel_suka WHERE id_user = $id_user AND id_resep = $id_resep");

if (mysqli_num_rows($cek) > 0) {
    mysqli_query($koneksi, "DELETE FROM tabel_suka WHERE id_user = $id_user AND id_resep = $id_resep");
} else {
    mysqli_query($koneksi, "INSERT INTO tabel_suka (id_user, id_resep) VALUES ($id_user, $id_resep)");
}

header("Location: ../../resep/detail.php?id=$id_resep");
exit;
?>
