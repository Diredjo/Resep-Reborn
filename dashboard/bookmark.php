<?php
include '../include/db.php';
include '../include/session.php';
include '../include/animasiloding/loadingcss.php';

$halaman = 'Bookmark.php';

?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Bookmark Saya - Resep Reborn</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="../LogoPutih.ico" type="image/x-icon">

</head>

<body>
    <div class="sidebar" id="sidebar">
        <button class="toggle-sidebar" onclick="toggleSidebar()"><i class="fa-solid fa-arrows-left-right-to-line"></i></button>
        <img src="../Foto/Logoputih.png" alt="Resep Reborn" class="logo">
        <ul class="navigasi">
            <li><a href="Pencarian.php" class="<?= ($halaman == 'Pencarian.php') ? 'active' : '' ?>"><i class="fa-solid fa-search" style="margin-right: 5px;"></i> Pencarian</a></li>
            <li><a href="Favorit.php" class="<?= ($halaman == 'Favorit.php') ? 'active' : '' ?>"><i class="fa-solid fa-heart" style="margin-right: 5px;"></i> Favorit</a></li>
            <li><a href="Bookmark.php" class="<?= ($halaman == 'Bookmark.php') ? 'active' : '' ?>"><i class="fa-solid fa-bookmark" style="margin-right: 5px;"></i> Bookmark</a></li>
            <li><a href="Profil.php" class="<?= ($halaman == 'Profil.php') ? 'active' : '' ?>"><i class="fa-solid fa-user" style="margin-right: 5px;"></i> Profil</a></li>
            <li><a href="../akun/logout.php"><i class="fa-solid fa-sign-out-alt"></i> Logout</a></li>
        </ul>
        <a href="sk.html" class="SK">Baca soal Syarat & Ketentuan Kebijakaan Privasi</a>
    </div>

    <div class="konten" id="konten">
        <h2>Resep yang saya bookmark</h2>
        <div class="bagian">
            <div class="kumpulan-kartu">
                <?php
                $query = "
          SELECT r.judul, r.foto 
          FROM tabel_bookmark b
          JOIN tabel_resep r ON b.id_resep = r.id_resep
          WHERE b.id_user = $user_id
          ORDER BY b.tanggal DESC
        ";

                $hasil = mysqli_query($koneksi, $query);
                while ($resep = mysqli_fetch_assoc($hasil)) {
                    echo "<div class='karturesep'>
                  <img src='../uploads/{$resep['foto']}' alt='{$resep['judul']}'>
                  <div class='judulresep'>{$resep['judul']}</div>
                </div>";
                }

                if (mysqli_num_rows($hasil) == 0) {
                    echo "<p style='color:#aaa margin-left:100px;'>Belum ada resep yang dibookmark.</p>";
                }
                ?>
            </div>
        </div>
    </div>

    <?php include '../include/animasiloding/loadingjs.php' ?>

</body>

</html>