<?php
include '../include/db.php';

$id_resep = intval($_GET['id']);
$komentar = mysqli_query($koneksi, "
    SELECT k.*, u.username, u.fotoprofil FROM tabel_komentar k 
    JOIN tabel_user u ON k.id_user = u.id_user 
    WHERE id_resep = $id_resep ORDER BY tanggal DESC
");

while ($row = mysqli_fetch_assoc($komentar)) {
    $foto = $row['fotoprofil'] ?: 'default.png';
    echo "<div class='komentar-item'>
        <img src='/uploads/profil/" . htmlspecialchars($foto) . "' alt='user'>
        <div>
            <strong>" . htmlspecialchars($row['username']) . "</strong><br>
            <span>" . nl2br(htmlspecialchars($row['komentar'])) . "</span>
        </div>
    </div>";
}
?>
