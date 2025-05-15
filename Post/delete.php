<?php
session_start();
include '../include/db.php';


if (isset($_POST['id_resep'])) {
    $id_resep = intval($_POST['id_resep']);
    
    $query = $conn->query("SELECT foto FROM tabel_resep WHERE id_resep = $id_resep");
    $data = $query->fetch_assoc();

    if ($data) {
        $filePath = "../Post/Uploads/" . $data['foto'];

        if (file_exists($filePath)) {
            unlink($filePath);
        }

        $delete = $conn->query("DELETE FROM tabel_resep WHERE id_resep = $id_resep");

        if ($delete) {
            echo "<script>alert('Postingan berhasil dihapus!'); window.location.href='../ADMIN/home.php';</script>";
        } else {
            echo "<script>alert('Gagal menghapus postingan.'); window.location.href='../ADMIN/homea.php';</script>";
        }
    } else {
        echo "<script>alert('Data tidak ditemukan.'); window.location.href='../ADMIN/home.php';</script>";
    }
} else {
    echo "<script>alert('ID resep tidak ditemukan.'); window.location.href='../ADMIN/home.php';</script>";
}
?>
