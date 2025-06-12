<?php
include '../../include/db.php';
include '../../include/session.php';

$user_id = intval($_GET['id']);

mysqli_query($koneksi, "DELETE FROM tabel_follow WHERE id_pengikut = $user_id OR id_diikuti = $user_id");
mysqli_query($koneksi, "DELETE FROM tabel_suka WHERE id_user = $user_id");
mysqli_query($koneksi, "DELETE FROM tabel_bookmark WHERE id_user = $user_id");
mysqli_query($koneksi, "DELETE FROM tabel_resep WHERE id_user = $user_id");

mysqli_query($koneksi, "DELETE FROM tabel_user WHERE id_user = $user_id");

header("Location: user.php");
exit;
