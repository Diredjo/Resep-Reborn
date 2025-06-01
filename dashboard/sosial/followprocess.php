<?php
include '../../include/db.php';
include '../../include/session.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Belum login']);
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_diikuti'], $_POST['aksi'])) {
    $id_diikuti = intval($_POST['id_diikuti']);
    $aksi = $_POST['aksi'];

    if ($id_diikuti === $user_id) {
        echo json_encode(['status' => 'error', 'message' => 'Tidak bisa mengikuti diri sendiri.']);
        exit;
    }

    if ($aksi === 'follow') {
        $query = "INSERT IGNORE INTO tabel_follow (id_pengikut, id_diikuti) VALUES ($user_id, $id_diikuti)";
        mysqli_query($koneksi, $query);
        echo json_encode(['status' => 'success', 'message' => 'Berhasil mengikuti']);
        exit;
    } elseif ($aksi === 'unfollow') {
        $query = "DELETE FROM tabel_follow WHERE id_pengikut = $user_id AND id_diikuti = $id_diikuti";
        mysqli_query($koneksi, $query);
        echo json_encode(['status' => 'success', 'message' => 'Berhenti mengikuti']);
        exit;
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Aksi tidak valid']);
        exit;
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Permintaan tidak valid']);
    exit;
}
