<?php
include '../../include/db.php';
include '../../include/session.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_diikuti = intval($_POST['id_diikuti']);
    $id_resep = intval($_POST['id_resep']); // ID resep yang dikirim dari form
    $aksi = isset($_POST['aksi']) ? $_POST['aksi'] : '';

    if ($aksi == 'follow') {
        $query = "INSERT INTO tabel_follow (id_pengikut, id_diikuti) VALUES ($user_id, $id_diikuti)";
        mysqli_query($koneksi, $query);
    } elseif ($aksi == 'unfollow') {
        $query = "DELETE FROM tabel_follow WHERE id_pengikut = $user_id AND id_diikuti = $id_diikuti";
        mysqli_query($koneksi, $query);
    }

    // Redirect ke halaman detail resep berdasarkan id
    header("Location: ../../resep/detail.php?id=$id_resep");
    exit();
} else {
    echo "Invalid request.";
    exit();
}
?>
