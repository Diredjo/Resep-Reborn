<?php
include '../../db.php';

$id_resep = $_GET['id_resep'];
$result = $conn->query("SELECT * FROM tabel_komentar WHERE id_resep='$id_resep' ORDER BY tanggal DESC");

$comments = [];
while ($row = $result->fetch_assoc()) {
    $comments[] = $row;
}

echo json_encode($comments);
?>
