<?php
include '../include/db.php';
include '../include/session.php';
include 'navbar.php';

$query = mysqli_query($conn, "SELECT * FROM tabel_resep WHERE id_resep='$id'");
$data = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <meta charset="UTF-8">
    <title><?= $data['judul'] ?></title>
    <link rel="stylesheet" href="style_detail.css">
</head>

<body>
    <div class="container">
        <div class="left">
            <img src="uploads/<?= $data['foto'] ?>" alt="Foto Resep" class="foto">
            <div class="video-container">
                <?php if (!empty($data['video'])): ?>
                    <video controls>
                        <source src="uploads/<?= $data['video'] ?>" type="video/mp4">
                        Browser Anda tidak mendukung video.
                    </video>
                <?php else: ?>
                    <p class="no-video">Video tidak tersedia</p>
                <?php endif; ?>
            </div>
        </div>
        <div class="right">
            <h1><?= $data['judul'] ?></h1>
            <p class="deskripsi"><?= nl2br($data['deskripsi']) ?></p>

            <h3>Bahan-Bahan</h3>
            <p><?= nl2br($data['bahan']) ?></p>

            <h3>Langkah-Langkah</h3>
            <p><?= nl2br($data['langkah']) ?></p>
        </div>
    </div>
</body>

</html>