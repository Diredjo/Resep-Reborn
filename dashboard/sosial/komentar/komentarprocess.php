<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../../../include/db.php';
include '../../../include/session.php';

$id_resep = intval($_POST['id_resep']);
$isi = trim($_POST['komentar']);

if ($id_resep && $isi !== '') {
    $id_user = $_SESSION['user_id'];
    $escaped_isi = mysqli_real_escape_string($koneksi, $isi);

    $query = "INSERT INTO tabel_komentar (id_resep, id_user, komentar) 
              VALUES ($id_resep, $id_user, '$escaped_isi')";
    
    if (mysqli_query($koneksi, $query)) {
        header("Location: ../../../resep/detail.php?id=$id_resep");
        exit;
    } else {
        echo "Error: " . mysqli_error($koneksi);
        exit;
    }
} else {
    header("Location: ../../../resep/detail.php?id=$id_resep");
    exit;
}
?>
