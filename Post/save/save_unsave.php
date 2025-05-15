<?php
session_start();
include '../../include/db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_resep = $_POST['id_resep'] ?? null;
    $id_user = $_SESSION['user_id'] ?? null;

    if (!$id_resep || !$id_user) {
        die("ID resep atau user tidak ditemukan.");
    }

    $cek = mysqli_query($conn, "SELECT id_resep FROM tabel_resep WHERE id_resep = $id_resep");
    if (mysqli_num_rows($cek) === 0) {
        die("Gagal: Resep tidak ditemukan.");
    }

    $cekBookmark = mysqli_query($conn, "SELECT * FROM tabel_bookmark WHERE id_resep = $id_resep AND id_user = $id_user");

    if (mysqli_num_rows($cekBookmark) > 0) {
        mysqli_query($conn, "DELETE FROM tabel_bookmark WHERE id_resep = $id_resep AND id_user = $id_user");
    } else {
        mysqli_query($conn, "INSERT INTO tabel_bookmark (id_resep, id_user) VALUES ($id_resep, $id_user)");
    }

    $hasilsave = mysqli_query($conn, "SELECT kategori FROM tabel_user WHERE id_user = $id_user");
    $data = mysqli_fetch_assoc($hasilsave);

    if ($data && $data['kategori'] === 'admin') {
        header("Location: ../../ADMIN/home.php");
    } else {
        header("Location: ../../USER/home.php");
    }
    exit;
}
?>
