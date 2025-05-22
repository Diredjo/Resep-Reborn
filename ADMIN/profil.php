<?php
session_start();
include '../include/db.php';
include '../include/session.php';

$id = $_SESSION['user_id'];

// Ambil data user
$ambil_user = mysqli_query($conn, "SELECT * FROM tabel_user WHERE id_user = $id");
$data_user = mysqli_fetch_assoc($ambil_user);

// Ambil resep yang dibookmark user
$bookmark = mysqli_query($conn, "
    SELECT r.* FROM tabel_bookmark b 
    JOIN tabel_resep r ON b.id_resep = r.id_resep 
    WHERE b.id_user = $id
");

// Ambil resep yang diposting oleh user
$postingan = mysqli_query($conn, "SELECT * FROM tabel_resep WHERE id_user = $id");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Profil Saya</title>
    <link rel="stylesheet" href="../css/akun.css">
</head>

<body>

    <div class="wadah">

        <div class="kotak_profil">
            <img src="../post/uploads/profil/<?= $data_user['fotoprofil']; ?>" class="foto_profil" alt="foto profil">
            <div class="info_user">
                <h2><?= $data_user['username']; ?></h2>
                <p><?= $data_user['bio']; ?></p>
            </div>
            <div class="tombol_edit">
                <a href="profiledit.php" class="tombol">✏️ Edit Profil</a>
            </div>
        </div>

        <h3 class="judul_bagian">❤️ Bookmark Saya</h3>
        <div class="kotak_grid">
            <?php while ($b = mysqli_fetch_assoc($bookmark)): ?>
                <div class="kartu_resep">
                    <img src="../Post/uploads/<?= $b['foto']; ?>" alt="gambar resep" class="gambar_resep">
                    <h4 class="judul_resep"><?= $b['judul']; ?></h4>
                    <p class="deskripsi_resep"><?= substr($b['deskripsi'], 0, 50); ?>...</p>
                </div>
            <?php endwhile; ?>
        </div>

        <h3 class="judul_bagian">📌 Postingan Saya</h3>
        <div class="kotak_grid">
            <?php while ($p = mysqli_fetch_assoc($postingan)): ?>
                <div class="kartu_resep">
                    <img src="../Post/uploads/<?= $p['foto']; ?>" alt="gambar resep" class="gambar_resep">
                    <h4 class="judul_resep"><?= $p['judul']; ?></h4>
                    <p class="deskripsi_resep"><?= substr($p['deskripsi'], 0, 50); ?>...</p>
                </div>
            <?php endwhile; ?>
        </div>

    </div>

</body>

</html>