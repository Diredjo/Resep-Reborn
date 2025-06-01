<?php
include '../include/db.php';
include '../include/session.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id_resep = intval($_POST['id']);

    $cek = mysqli_query($koneksi, "SELECT * FROM tabel_resep WHERE id_resep = $id_resep AND id_user = $user_id");

    if (mysqli_num_rows($cek) === 1) {
        
        mysqli_query($koneksi, "DELETE FROM tabel_resep WHERE id_resep = $id_resep AND id_user = $user_id");
        header("Location: ../dashboard/profil.php");
        exit;
    } else {
        echo "Akses ditolak. Resep tidak ditemukan atau bukan milik Anda.";
    }
} else {
    echo "Permintaan tidak valid.";
}
