<?php
include '../../../include/db.php';
include '../../../include/session.php';

$id_komentar = intval($_POST['id_komentar']);
$id_resep = intval($_POST['id_resep']);
$id_user_login = $_SESSION['user_id'] ?? 0;

$cek = mysqli_query($koneksi, "SELECT * FROM tabel_komentar WHERE id_komentar = $id_komentar AND id_user = $id_user_login");
if (mysqli_num_rows($cek) > 0) {
    mysqli_query($koneksi, "DELETE FROM tabel_komentar WHERE id_komentar = $id_komentar");
}

header("Location: ../../../resep/detail.php?id=$id_resep");
exit;
?>
