<?php
include '../include/db.php';
include '../include/session.php';
include '../include/animasiloding/loadingcss.php';

$halaman = 'Favorit.php';

$defaultAvatars = [
  'default.png',
  'Koki.png',
  'Petani.png',
  'Ahli.png',
  'Foodie.png'
];


function getDefaultAvatar($userId, $defaultAvatars)
{
  $index = $userId % count($defaultAvatars);
  return $defaultAvatars[$index];
}


?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Favorit Saya - Resep Reborn</title>
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
    <h2>Akun yang Saya Ikuti</h2>
    <div class="bagian">
      <div class="kumpulan-profil">
        <?php
        $akun_diikuti = mysqli_query(
          $koneksi,
          "SELECT u.id_user, u.username, u.fotoprofil
   FROM tabel_follow f
   INNER JOIN tabel_user u ON u.id_user = f.id_diikuti
   WHERE f.id_pengikut = $user_id
   GROUP BY u.id_user"
        );

        if (mysqli_num_rows($akun_diikuti) > 0) {
          while ($akun = mysqli_fetch_assoc($akun_diikuti)) {
            $foto = !empty($akun['fotoprofil']) ? $akun['fotoprofil'] : getDefaultAvatar($akun['id_user'], $defaultAvatars);

            echo "<div class='kartupengguna'>
        <img src='../uploads/profil/{$foto}' alt='{$akun['username']}'>
        <div>{$akun['username']}</div>
      </div>";
          }
        } else {
          echo "<p style='color:#aaa; margin-left:100px;'>Belum ada akun yang kamu ikuti.</p>";
        }
        ?>

      </div>
    </div>


    <h2>Resep yang saya like</h2>
    <div class="bagian">
      <div class="kumpulan-kartu-wrap">
        <?php
        $resep_disukai = mysqli_query(
          $koneksi,
          "SELECT r.foto, r.judul
       FROM tabel_resep r
       INNER JOIN tabel_suka s ON r.id_resep = s.id_resep
       WHERE s.id_user = $user_id
       ORDER BY s.tanggal DESC"
        );

        if (mysqli_num_rows($resep_disukai) > 0) {
          while ($resep = mysqli_fetch_assoc($resep_disukai)) {
            echo "<div class='karturesep'>
                <img src='../uploads/{$resep['foto']}' alt='{$resep['judul']}'>
                <div class='judulresep'>{$resep['judul']}</div>
              </div>";
          }
        } else {
          echo "<p style='color:#aaa; margin-left:100px;'>Belum ada resep yang kamu sukai.</p>";
        }
        ?>
      </div>
    </div>

  </div>
  </div>
  </div>

  <?php include '../include/animasiloding/loadingjs.php' ?>

</body>

</html>