<?php
include '../include/db.php';
include '../include/session.php';

// Asumsi id_user dari sesi login
$id_user = 1; // Ganti ini sesuai sesi loginmu
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Favorit Saya - Resep Reborn</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="stylesheet" href="../css/dashboard.css">
</head>

<body>
  <div class="sidebar" id="sidebar">
    <button class="toggle-sidebar" onclick="toggleSidebar()"><i class="fa-solid fa-arrows-left-right-to-line"></i></button>
    <img src="../Foto/Logocompact.png" alt="Resep Reborn" class="logo">
    <ul class="navigasi">
      <li><a href="Pencarian.php" class="<?= ($halaman == 'Pencarian.php') ? 'active' : '' ?>"><i class="fa-solid fa-search"></i> Pencarian</a></li>
      <li><a href="Favorit.php" class="<?= ($halaman == 'Favorit.php') ? 'active' : '' ?>"><i class="fa-solid fa-heart"></i> Favorit</a></li>
      <li><a href="Bookmark.php" class="<?= ($halaman == 'Bookmark.php') ? 'active' : '' ?>"><i class="fa-solid fa-bookmark"></i> Bookmark</a></li>
      <li><a href="Profil.php" class="<?= ($halaman == 'Profil.php') ? 'active' : '' ?>"><i class="fa-solid fa-user"></i> Profil</a></li>
      <li><a href="../akun/logout.php"><i class="fa-solid fa-sign-out-alt"></i> Logout</a></li>
    </ul>
    <a href="sk.html" class="SK">Baca soal Syarat & Ketentuan Kebijakaan Privasi</a>
  </div>

  <div class="konten">
    <h2>Akun yang saya sukai</h2>
    <div class="bagian">
      <div class="kumpulan-profil">
        <?php
        $pengguna_disukai = mysqli_query(
          $koneksi,
          "SELECT DISTINCT u.id_user, u.username, u.fotoprofil
           FROM tabel_user u
           INNER JOIN tabel_resep r ON u.id_user = r.id_user
           INNER JOIN tabel_suka s ON s.id_resep = r.id_resep
           WHERE s.id_user = $id_user
           GROUP BY u.id_user
           LIMIT 5"
        );

        while ($akun = mysqli_fetch_assoc($pengguna_disukai)) {
          $foto = $akun['fotoprofil'] !== '' ? $akun['fotoprofil'] : 'default.png';
          echo "<div class='kartupengguna'>
                  <img src='../uploads/profil/{$foto}' alt='{$akun['username']}'>
                  <div>{$akun['username']}</div>
                </div>";
        }
        ?>
      </div>
    </div>

    <h2>Resep yang saya like</h2>
    <div class="bagian">
      <div class="kumpulan-kartu">
        <?php
        $resep_disukai = mysqli_query(
          $koneksi,
          "SELECT r.foto, r.judul
           FROM tabel_resep r
           INNER JOIN tabel_suka s ON r.id_resep = s.id_resep
           WHERE s.id_user = $id_user
           ORDER BY s.tanggal DESC"
        );

        while ($resep = mysqli_fetch_assoc($resep_disukai)) {
          echo "<div class='karturesep'>
                  <img src='../uploads/{$resep['foto']}' alt='{$resep['judul']}'>
                  <div class='judulresep'>{$resep['judul']}</div>
                </div>";
        }
        ?>
      </div>
    </div>
  </div>

  <script>
    const sidebar = document.getElementById("sidebar");
    const konten = document.getElementById("konten");

    function toggleSidebar() {
      sidebar.classList.toggle("collapsed");
      konten.classList.toggle("collapsed");
    }
  </script>

</body>

</html>