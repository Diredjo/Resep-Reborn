<?php
include '../include/session.php';
include '../include/db.php';
include '../include/animasiloding/loadingcss.php';

$resep = mysqli_query($koneksi, "SELECT * FROM tabel_resep ORDER BY tanggal_posting DESC LIMIT 10");
$uploader = mysqli_query($koneksi, "SELECT * FROM tabel_user ORDER BY RAND() LIMIT 9");
$masakan = mysqli_query($koneksi, "SELECT * FROM tabel_resep WHERE tipe = 'Makanan' ORDER BY RAND() LIMIT 10");

$placeholders = [
    "Abrakadabra, jadi resep!",
    "Cari resep ajaib?",
    "Sulap bahanmu yuk!",
    "Bahanmu = keajaiban!",
    "Mantra resep hari ini?",
    "Hokuspokus, jadi menu!",
    "Bahan sisa? Gass cari!",
    "Sim salabim... enak!",
    "Sulap dapurmu~",
    "Resep dari sihir!"
];
$randomPlaceholder = $placeholders[array_rand($placeholders)];

$halaman = 'Pencarian.php';

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
    <title>Dashboard - Resep Reborn</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="shortcut icon" href="../LogoPutih.ico" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <!-- <style>
        .kartupengguna-img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid orange;
        }
    </style> -->
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

            <?php if ($kategori === 'ADMIN'): ?>
                <li><a href="admin/data.php" class="<?= ($halaman == 'data.php') ? 'active' : '' ?>"><i class="fa-solid fa-chart-line" style="margin-right: 5px;"></i> Admin Panel</a></li>
            <?php endif; ?>

            <li><a href="../akun/logout.php"><i class="fa-solid fa-sign-out-alt"></i> Logout</a></li>
        </ul>
        <a href="sk.html" class="SK">Baca soal Syarat & Ketentuan Kebijakan Privasi</a>
    </div>
    \
    <div class="konten" id="konten">
        <div class="header">
            <a href="../resep/upload.php" class="tombol-upload">Tulis Resep <i class="fa-solid fa-feather" style="margin-left: 8px;"></i></a>
            <?php
            $userQuery = mysqli_query($koneksi, "SELECT * FROM tabel_user WHERE id_user = '$user_id' LIMIT 1");
            $user = mysqli_fetch_assoc($userQuery);
            if (!empty($user['fotoprofil'])) {
                $fotoProfil = $user['fotoprofil'];
            } else {
                $fotoProfil = getDefaultAvatar($user['id_user'], $defaultAvatars);
            }
            $fotoProfilEncoded = urlencode($fotoProfil);
            ?>
            <a href="profil.php">
                <img src="../uploads/profil/<?= $fotoProfilEncoded ?>" alt="Foto Profil" class="foto-profil-head">
            </a>
        </div>

        <form class="searchcont" action="search.php" method="get">
            <img src="../Foto/Logomiring.png" alt="Resep Reborn" class="logosearch">
            <p class="subtitel">From the field to your fork — let the magic begin. ✨</p>

            <div class="search-row">
                <input type="text" class="pencarian" placeholder="<?= $randomPlaceholder ?>" name="q" required>
                <button class="tombol-cari" type="submit"><i class="fa-solid fa-wand-sparkles"></i></button>
            </div>
        </form>



        <h2 class="judulbagian"><i class="fa-solid fa-fire" style="margin-right: 8px;"></i> Terbaru</h2>
        <div class="bagian">
            <div class="kumpulan-kartu">
                <?php
                while ($row = mysqli_fetch_assoc($resep)) {
                    $fotoEncoded = urlencode($row['foto']);
                    $judulSafe = htmlspecialchars($row['judul']);
                    $idResep = $row['id_resep']; // pastiin kolom id ada di tabel
                    echo "<a href='../resep/detail.php?id=$idResep' class='karturesep'>
                      <img src='../uploads/$fotoEncoded' alt='$judulSafe'>
                      <div class='judulresep'>$judulSafe</div>
                  </a>";
                }
                ?>
            </div>
        </div>


        <h2 class="judulbagian"><i class="fa-solid fa-user-check" style="margin-right: 8px;"></i> Rekomendasi Uploader</h2>
        <div class="bagian">
            <div class="kumpulan-profil">
                <?php
                while ($user = mysqli_fetch_assoc($uploader)) {
                    if (!empty($user['fotoprofil'])) {
                        $foto = $user['fotoprofil'];
                    } else {
                        $foto = getDefaultAvatar($user['id_user'], $defaultAvatars);
                    }

                    $fotoEncoded = urlencode($foto);
                    $usernameSafe = htmlspecialchars($user['username']);
                    $bioSafe = htmlspecialchars($user['bio']);
                    $userId = $user['id_user'];

                    // Cek apakah ini user yang sedang login
                    if ($userId == $_SESSION['user_id']) {
                        $link = "profil.php"; // Ke profil sendiri
                    } else {
                        $link = "profil.php?id_user=$userId"; // Ke profil orang lain
                    }

                    echo "<a href='$link' class='kartupengguna-link'>
                <div class='kartupengguna'>
                    <img src='../uploads/profil/$fotoEncoded' class='kartupengguna-img' alt='$usernameSafe'>
                    <div class='judulpengguna'>$usernameSafe</div>
                    <p class='kartupengguna-bio'>$bioSafe</p>
                </div>
            </a>";
                }
                ?>
            </div>
        </div>


        <h2 class="judulbagian"><i class="fa-solid fa-utensils" style="margin-right: 8px;"></i> Pilihan buat mu</h2>
        <div class="bagian">
            <div class="kumpulan-kartu">
                <?php
                while ($row = mysqli_fetch_assoc($masakan)) {
                    $fotoEncoded = urlencode($row['foto']);
                    $judulSafe = htmlspecialchars($row['judul']);
                    echo "<a href='../resep/detail.php?id=$idResep' class='karturesep'><div class='karturesep'>
                          <img src='../uploads/$fotoEncoded' alt='$judulSafe'>
                          <div class='judulresep'>$judulSafe</div>
                          </div></a>";
                }
                ?>
            </div>
        </div>

        <div class="bagian tentang">
            <h2>Ketahui lebih banyak tentang <br><strong>Resep Reborn</strong></h2>
            <div class="kumpulan-kotak">
                <div class="kotaktentang">
                    <i class="fa-solid fa-laptop-code"></i>
                    <h3>Tujuan Website</h3>
                    <p>Dibuat guna mengatasi dan menekan angka kasus pembuangan limbah hasil panen</p>
                    <a href="about/tujuanweb.html">Baca</a>
                </div>
                <div class="kotaktentang">
                    <img src="../foto/fotokreator.jpg" alt="Saqa Pandega">
                    <h3>Kreator</h3>
                    <p>Siswa kelas 10 SMK Telkom Sidoarjo kejuruan Sistem Informasi Jaringan dan Aplikasi. Jawa Timur Indonesia</p>
                    <a href="about/kreator.html">Kenalan Yuk!</a>
                </div>
                <div class="kotaktentang">
                    <i class="fa-solid fa-graduation-cap"></i>
                    <h3>Tujuan</h3>
                    <p>Dibuat guna memenuhi Ujian Kenaikan Level yang menjadi syarat kelulusan kenaikan kelas</p>
                    <a href="about/about.html">Baca</a>
                </div>
            </div>
        </div>

    </div>
    </div>

    <footer class="footer" id="footer">
        <div class="footer-wrapper">
            <div class="footer-content">
                <div class="footer-left">
                    <h2>Olah bersama kami</h2>
                    <p>© 1995 Resep Reborn. All rights reserved.</p>
                </div>
                <div class="footer-right">
                    <div class="social-icons">
                        <a href="#" class="icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="icon"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="icon"><i class="fab fa-instagram"></i></a>
                        <a href="https://www.figma.com/design/qnYTMMQTLc2etfFqeEDfnj/Resep-Reborn?node-id=0-1&t=Agfkp8wVXwh5nSZF-1" class="icon"><i class="fab fa-figma"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <?php include '../include/animasiloding/loadingjs.php' ?>

</body>

</html>