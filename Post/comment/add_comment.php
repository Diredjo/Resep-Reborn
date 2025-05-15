<?php
include '../../db.php';

$id_resep = $_POST['id_resep'];
$id_user = 1;
$komentar = $_POST['komentar'];

$conn->query("INSERT INTO tabel_komentar (id_resep, id_user, komentar) VALUES ('$id_resep', '$id_user', '$komentar')");

echo json_encode(["success" => true]);
?>
