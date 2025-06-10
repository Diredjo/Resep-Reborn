<?php
include_once "../../include/session.php";
include_once "../../include/db.php";

if ($kategori !== 'ADMIN') {
    header("Location: ../Profil.php");
    exit;
}

$halaman = 'resep.php';

$sql = "
SELECT 
    r.id_resep,
    r.judul,
    r.tanggal_posting,
    u.username AS uploader,
    COUNT(DISTINCT c.id_komentar) AS jml_komentar,
    SUM(CASE WHEN l.id_suka='like' THEN 1 ELSE 0 END) AS jml_like,
    SUM(CASE WHEN b.id_bookmark IS NOT NULL THEN 1 ELSE 0 END) AS jml_bookmark
FROM tabel_resep r
JOIN tabel_user u ON r.id_user = u.id_user
LEFT JOIN tabel_komentar c ON c.id_resep = r.id_resep
LEFT JOIN tabel_suka l ON l.id_resep = r.id_resep
LEFT JOIN tabel_bookmark b ON b.id_resep = r.id_resep
GROUP BY r.id_resep
ORDER BY r.tanggal_posting DESC
";
$result = mysqli_query($koneksi, $sql);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>Admin Panel - Data Resep</title>
    <script src="https://kit.fontawesome.com/a81368914c.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="shortcut icon" href="../../LogoPutih.ico" type="image/x-icon">
    <link rel="stylesheet" href="../style.css" />
</head>

<body>
    <div class="sidebar" id="sidebar">
        <button class="toggle-sidebar" onclick="toggleSidebar()"><i class="fa-solid fa-arrows-left-right-to-line"></i></button>
        <img src="../../Foto/Logoputih.png" alt="Resep Reborn" class="logo" />
        <ul class="navigasi">
            <li><a href="data.php" class="<?= ($halaman == 'data.php') ? 'active' : '' ?>"><i class="fa-solid fa-chart-line"></i> Dashboard</a></li>
            <li><a href="user.php" class="<?= ($halaman == 'user.php') ? 'active' : '' ?>"><i class="fa-solid fa-users"></i> User</a></li>
            <li><a href="resep.php" class="<?= ($halaman == 'resep.php') ? 'active' : '' ?>"><i class="fa-solid fa-book"></i> Resep</a></li>
            <li><a href="../Pencarian.php" class="<?= ($halaman == 'Pencarian.php') ? 'active' : '' ?>"><i class="fa-solid fa-arrow-left" style="margin-right: 5px;"></i> Kembali</a></li>
        </ul>
        <a href="sk.html" class="SK">Syarat & Ketentuan</a>
    </div>

    <div class="konten" id="konten">
        <h2>Data Resep & Statistik</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Judul Resep</th>
                    <th>Uploader</th>
                    <th>Tanggal Upload</th>
                    <th>Jumlah Komentar</th>
                    <th>Jumlah Like</th>
                    <th>Jumlah Bookmark</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($r = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= htmlspecialchars($r['uploader']) ?></td>
                        <td><?= htmlspecialchars($r['judul']) ?></td>
                        <td><?= htmlspecialchars($r['uploader']) ?></td>
                        <td><?= htmlspecialchars($r['tanggal_posting']) ?></td>
                        <td><?= htmlspecialchars($r['jml_komentar']) ?></td>
                        <td><?= htmlspecialchars($r['jml_like']) ?></td>
                        <td><?= htmlspecialchars($r['jml_bookmark']) ?></td>
                        <td>
                            <a href="edit_resep.php?id=<?= $r['id_resep'] ?>">Edit</a>
                            <a href="delete_resep.php?id=<?= $r['id_resep'] ?>" onclick="return confirm('Yakin mau hapus resep ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('collapsed');
        }
    </script>
</body>

</html>