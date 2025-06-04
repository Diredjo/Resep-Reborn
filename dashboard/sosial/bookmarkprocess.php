<?php
include '../include/db.php';
include '../include/session.php';

$id_resep = intval($_POST['id']);
$id_user = $_SESSION['user_id'];

$cek = mysqli_query($koneksi, "SELECT * FROM tabel_bookmark WHERE id_resep = $id_resep AND id_user = $id_user");

if (mysqli_num_rows($cek) > 0) {
    mysqli_query($koneksi, "DELETE FROM tabel_bookmark WHERE id_resep = $id_resep AND id_user = $id_user");
    echo 'unsaved';
} else {
    mysqli_query($koneksi, "INSERT INTO tabel_bookmark (id_resep, id_user) VALUES ($id_resep, $id_user)");
    echo 'saved';
}
?>
