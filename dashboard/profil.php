<?php
include '../include/db.php';
include '../include/session.php';

$query_user = mysqli_query($koneksi, "SELECT * FROM tabel_user WHERE id_user = $user_id");
$user = mysqli_fetch_assoc($query_user);

$jumlah_followers = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM tabel_follow WHERE id_diikuti = $user_id"))['total'];

$jumlah_postingan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM tabel_resep WHERE id_user = $user_id"))['total'];

$tanggal_daftar = strtotime($user['tanggal_daftar']);
$hari_bergabung = floor((time() - $tanggal_daftar) / (60 * 60 * 24));

$resep_saya = mysqli_query($koneksi, "SELECT * FROM tabel_resep WHERE id_user = $user_id ORDER BY tanggal_posting DESC");
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Profil Saya</title>
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
        <div class="bagian">
            <h2>Profil saya</h2>
            <div class="kotak-profil">
                <img src="../uploads/profil/$user['fotoprofil'] ?: 'default.png' ?>" class="foto-profil">
                <div class="info-profil">
                    <h2><?= htmlspecialchars($user['username']) ?></h2>
                    <p><?= htmlspecialchars($user['bio']) ?></p>
                </div>
                <a href="edit-profil.php" class="tombol-edit">✎</a>
            </div>

            <div class="statistik-profil">
                <div class="stat"><strong><?= number_format($jumlah_followers) ?></strong><span>Pengikut</span></div>
                <div class="stat"><strong><?= $jumlah_postingan ?></strong><span>Postingan</span></div>
                <div class="stat"><strong><?= $hari_bergabung ?></strong><span>Hari bergabung</span></div>
            </div>
        </div>

        <!-- Daftar Postingan -->
        <div class="bagian">
            <h2>Postingan saya</h2>
            <div class="kumpulan-kartu-wrap">
                <?php
                while ($resep = mysqli_fetch_assoc($resep_saya)) {
                    echo "<div class='karturesep'>
                  <img src='../uploads/{$resep['foto']}' alt='{$resep['judul']}'>
                  <div class='judulresep'>{$resep['judul']}</div>
                </div>";
                }
                ?>
            </div>
        </div>

        <footer style="margin-top:40px;">
            <p>Gabung bersama kami | Customer Support: support@resepreborn.id</p>
        </footer>
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