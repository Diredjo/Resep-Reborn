<?php
include '../../include/db.php';
include '../../include/session.php';
include 'navbar.php';

$table = $_GET['table'];
$id = $_GET['id'];
$id_field = 'id_' . explode('_', $table)[1];

mysqli_query($conn, "DELETE FROM $table WHERE $id_field = $id");
header("Location: data.php");
exit;
?>
