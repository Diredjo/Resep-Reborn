<?php
include '../../include/session.php';
include '../../include/db.php';

$id_pelapor = $_SESSION['user_id'];
$id_dilaporkan = $_POST['id_dilaporkan'];
$alasan = $_POST['alasan'];
$alasan_tambahan = !empty($_POST['alasan_tambahan']) ? $_POST['alasan_tambahan'] : null;

$query = "INSERT INTO laporan_profil (id_pelapor, id_dilaporkan, alasan, alasan_tambahan) 
          VALUES ('$id_pelapor', '$id_dilaporkan', '$alasan', " . ($alasan_tambahan ? "'$alasan_tambahan'" : "NULL") . ")";
mysqli_query($koneksi, $query);

echo "Laporan berhasil dikirim!";
