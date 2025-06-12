<?php
include '../../../include/db.php';
include '../../../include/session.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../../../akun/login.php");
        exit();
    }

    $user_id = intval($_SESSION['user_id']);
    $id_diikuti = intval($_POST['id_diikuti'] ?? 0);
    $aksi = $_POST['aksi'] ?? '';

    if ($user_id > 0 && $id_diikuti > 0) {
        if ($aksi === 'follow') {
            mysqli_query($koneksi, "INSERT INTO tabel_follow (id_pengikut, id_diikuti) VALUES ($user_id, $id_diikuti)");
        } elseif ($aksi === 'unfollow') {
            mysqli_query($koneksi, "DELETE FROM tabel_follow WHERE id_pengikut = $user_id AND id_diikuti = $id_diikuti");
        }
    }

    header("Location: ../../profil.php?id_user=$id_diikuti");
    exit();
} else {
    echo "Invalid request.";
    exit();
}
