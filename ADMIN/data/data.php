<?php
include '../../include/db.php';
include '../../include/session.php';
include 'navbar.php';

function ambilSemua($query) {
    global $conn;
    $hasil = mysqli_query($conn, $query);
    $data = [];
    while ($baris = mysqli_fetch_assoc($hasil)) {
        $data[] = $baris;
    }
    return $data;
}

$pengguna = ambilSemua("SELECT * FROM tabel_user");
$resep = ambilSemua("SELECT tr.*, 
    (SELECT COUNT(*) FROM tabel_suka ts WHERE ts.id_resep = tr.id_resep) AS id_suka,
    (SELECT COUNT(*) FROM tabel_komentar tk WHERE tk.id_resep = tr.id_resep) AS komentar,
    (SELECT COUNT(*) FROM tabel_bookmark tb WHERE tb.id_resep = tr.id_resep) AS id_bookmark
FROM tabel_resep tr");
$suka = ambilSemua("SELECT ts.*, tu.username FROM tabel_suka ts JOIN tabel_user tu ON ts.id_user = tu.id_user");
$komentar = ambilSemua("SELECT * FROM tabel_komentar");
$bookmark = ambilSemua("SELECT * FROM tabel_bookmark");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resep Reborn</title>
    <link rel="stylesheet" href="../../css/data.css">
    <link rel="icon" href="/Resep_Reborn/LogoPutih.ico">
</head>


<body>
<div class="container">
    <h1>Data Pengguna</h1>
    <table>
        <tr>
            <th>ID</th><th>Username</th><th>Email</th><th>Role</th><th>Tanggal Join</th><th>Actions</th>
        </tr>
        <?php foreach ($pengguna as $p): ?>
        <tr>
            <td><?= $p['id_user'] ?></td>
            <td><?= $p['username'] ?></td>
            <td><?= $p['email'] ?></td>
            <td><?= $p['kategori'] ?></td>
            <td><?= $p['tanggal_daftar'] ?></td>
            <td>
                <a href="update.php?table=tabel_user&id=<?= $p['id_user'] ?>">Update</a> |
                <a href="delete.php?table=tabel_user&id=<?= $p['id_user'] ?>" onclick="return confirm('Are you sure to delete this data?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <h1>Data Resep</h1>
    <table>
        <tr>
            <th>ID Resep</th><th>Judul</th><th>ID Uploader</th><th>Tanggal</th><th>Jumlah Suka</th><th>Komentar</th><th>Bookmark</th><th>Actions</th>
        </tr>
        <?php foreach ($resep as $r): ?>
        <tr>
            <td><?= $r['id_resep'] ?></td>
            <td><?= $r['judul'] ?></td>
            <td><?= $r['id_user'] ?></td>
            <td><?= $r['tanggal_posting'] ?></td>
            <td><?= $r['id_suka'] ?></td>
            <td><?= $r['komentar'] ?></td>
            <td><?= $r['id_bookmark'] ?></td>
            <td>
                <a href="update.php?table=tabel_resep&id=<?= $r['id_resep'] ?>">Update</a> |
                <a href="delete.php?table=tabel_resep&id=<?= $r['id_resep'] ?>" onclick="return confirm('Are you sure to delete this data?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <h1>Data Suka</h1>
    <table>
        <tr>
            <th>ID Suka</th><th>ID Resep</th><th>ID User</th><th>Username</th><th>Actions</th>
        </tr>
        <?php foreach ($suka as $s): ?>
        <tr>
            <td><?= $s['id_suka'] ?></td>
            <td><?= $s['id_resep'] ?></td>
            <td><?= $s['id_user'] ?></td>
            <td><?= $s['username'] ?></td>
            <td>
                <a href="delete.php?table=tabel_suka&id=<?= $s['id_suka'] ?>" onclick="return confirm('Are you sure to delete this data?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <h1>Data Komentar</h1>
    <table>
        <tr>
            <th>ID Komentar</th><th>ID Resep</th><th>ID User</th><th>Isi</th><th>Tanggal</th><th>Actions</th>
        </tr>
        <?php foreach ($komentar as $k): ?>
        <tr>
            <td><?= $k['id_komentar'] ?></td>
            <td><?= $k['id_resep'] ?></td>
            <td><?= $k['id_user'] ?></td>
            <td><?= $k['komentar'] ?></td>
            <td><?= $k['tanggal'] ?></td>
            <td>
                <a href="delete.php?table=tabel_komentar&id=<?= $k['id_komentar'] ?>" onclick="return confirm('Are you sure to delete this data?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <h1>Data Bookmark</h1>
    <table>
        <tr>
            <th>ID Bookmark</th><th>ID Resep</th><th>ID User</th><th>Actions</th>
        </tr>
        <?php foreach ($bookmark as $b): ?>
        <tr>
            <td><?= $b['id_bookmark'] ?></td>
            <td><?= $b['id_resep'] ?></td>
            <td><?= $b['id_user'] ?></td>
            <td>
                <a href="delete.php?table=tabel_bookmark&id=<?= $b['id_bookmark'] ?>" onclick="return confirm('Are you sure to delete this data?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
</body>
</html>
