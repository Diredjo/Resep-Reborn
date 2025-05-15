<?php
include '../../db.php';

$id_komentar = $_POST['id_komentar'];
$id_user = 1;

$check = $conn->query("SELECT * FROM tabel_komentar WHERE id_komentar='$id_komentar' AND id_user='$id_user'");

if ($check->num_rows > 0) {
    $conn->query("DELETE FROM tabel_komentar WHERE id_komentar='$id_komentar'");
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["error" => "Unauthorized"]);
}
?>
