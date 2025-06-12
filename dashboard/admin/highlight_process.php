<?php
include_once "../../include/session.php";
include_once "../../include/db.php";

$kategori = $_SESSION['kategori'] ?? '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_POST['id_resep']) || !isset($_POST['highlight'])) {
        die("Data tidak lengkap.");
    }

    $id_resep = intval($_POST['id_resep']);
    $id_highlight = is_numeric($_POST['highlight']) && $_POST['highlight'] !== '' ? intval($_POST['highlight']) : 'NULL';

    $query = "UPDATE tabel_resep SET id_highlight = $id_highlight WHERE id_resep = $id_resep";

    if (!mysqli_query($koneksi, $query)) {
        die("Gagal update: " . mysqli_error($koneksi));
    }
}

header("Location: resep.php");
exit;
