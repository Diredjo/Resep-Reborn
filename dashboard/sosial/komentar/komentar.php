<?php
include '../include/db.php';
include '../include/session.php'; // <--- penting, biar bisa akses $_SESSION

$id_resep = intval($_GET['id']);
$id_user_login = $_SESSION['user_id'] ?? 0;

$komentar = mysqli_query($koneksi, "
    SELECT k.*, u.username, u.fotoprofil FROM tabel_komentar k 
    JOIN tabel_user u ON k.id_user = u.id_user 
    WHERE id_resep = $id_resep ORDER BY tanggal DESC
");

while ($row = mysqli_fetch_assoc($komentar)) {
    $foto = $row['fotoprofil'] ?: 'default.png';
    $id_user_komentar = $row['id_user'];
    $id_komentar = $row['id_komentar'];

    echo "<div style='display: flex; align-items: flex-start; margin-bottom: 15px; gap: 10px;'>
        <img src='../uploads/profil/" . htmlspecialchars($foto) . "' alt='user' 
             style='width: 30px; height: 30px; border-radius: 50%; object-fit: cover;'>
        <div style='flex: 1;'>
            <strong style='font-size: 14px;'>" . htmlspecialchars($row['username']) . "</strong><br>
            <span style='font-size: 13px; color: #ffffff;'>" . nl2br(htmlspecialchars($row['komentar'])) . "</span>";

    if ($id_user_komentar == $id_user_login) {
        echo "<form action='../dashboard/sosial/komentar/hapuskomentar.php' method='POST' style='margin-top: 5px;'>
                <input type='hidden' name='id_komentar' value='$id_komentar'>
                <input type='hidden' name='id_resep' value='$id_resep'>
                <button type='submit' style='font-size:12px; background:#e74c3c; color:white; border:none; padding:2px 6px; border-radius:4px; cursor:pointer;'>Hapus</button>
              </form>";
    }

    echo "</div>
    </div>";
}
