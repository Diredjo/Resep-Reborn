<?php
include '../../include/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $status = mysqli_real_escape_string($koneksi, $_POST['status']);

    $update = mysqli_query($koneksi, "UPDATE laporan_profil SET status = '$status' WHERE id = $id");

    if ($update) {
        echo json_encode(['success' => true, 'status' => $status]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Gagal memperbarui status']);
    }
}
?>
