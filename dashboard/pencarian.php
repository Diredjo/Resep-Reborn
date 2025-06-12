<?php
include '../include/session.php';
include '../include/db.php';
include '../include/animasiloding/loadingcss.php';

$resep = mysqli_query($koneksi, "
    SELECT r.*, h.label AS highlight_label, h.icon AS highlight_icon 
    FROM tabel_resep r 
    LEFT JOIN tabel_highlight h ON r.id_highlight = h.id_highlight 
    ORDER BY r.tanggal_posting DESC 
    LIMIT 10
");

$uploader = mysqli_query($koneksi, "SELECT * FROM tabel_user ORDER BY RAND() LIMIT 5");

$masakan = mysqli_query($koneksi, "
    SELECT r.*, h.label AS highlight_label, h.icon AS highlight_icon 
    FROM tabel_resep r 
    LEFT JOIN tabel_highlight h ON r.id_highlight = h.id_highlight 
    WHERE tipe = 'Makanan' 
    ORDER BY RAND() 
    LIMIT 10
");

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

$defaultAvatars = ['default.png', 'Koki.png', 'Petani.png', 'Ahli.png', 'Foodie.png'];
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
</head>

<body>
    <div class="sidebar" id="sidebar">
        <button class="toggle-sidebar" onclick="toggleSidebar()"><i
                class="fa-solid fa-arrows-left-right-to-line"></i></button>
        <a href="../index.php"><img src="../Foto/Logoputih.png" alt="Resep Reborn" class="logo"></a>
        <ul class="navigasi">
            <li><a href="Pencarian.php" class="<?= ($halaman == 'Pencarian.php') ? 'active' : '' ?>"><i
                        class="fa-solid fa-search"></i> Pencarian</a></li>
            <li><a href="Favorit.php" class="<?= ($halaman == 'Favorit.php') ? 'active' : '' ?>"><i
                        class="fa-solid fa-heart"></i> Favorit</a></li>
            <li><a href="Bookmark.php" class="<?= ($halaman == 'Bookmark.php') ? 'active' : '' ?>"><i
                        class="fa-solid fa-bookmark"></i> Bookmark</a></li>
            <li><a href="Profil.php" class="<?= ($halaman == 'Profil.php') ? 'active' : '' ?>"><i
                        class="fa-solid fa-user"></i> Profil</a></li>
            <?php if ($kategori === 'ADMIN'): ?>
                <li><a href="admin/data.php"><i class="fa-solid fa-chart-line"></i> Admin Panel</a></li>
            <?php endif; ?>
            <li><a href="../akun/logout.php"><i class="fa-solid fa-sign-out-alt"></i> Logout</a></li>
        </ul>
        <a href="about/SK.html" class="SK">Syarat & Ketentuan</a>
    </div>

    <div class="konten" id="konten">
        <div class="header" style="margin-top: 20px;">
            <a href="../resep/upload.php" class="tombol-upload">Tulis Resep <i class="fa-solid fa-feather"></i></a>
            <?php
            $userQuery = mysqli_query($koneksi, "SELECT * FROM tabel_user WHERE id_user = '$user_id' LIMIT 1");
            $user = mysqli_fetch_assoc($userQuery);
            $fotoProfil = !empty($user['fotoprofil']) ? $user['fotoprofil'] : getDefaultAvatar($user['id_user'], $defaultAvatars);
            ?>
            <a href="profil.php">
                <img src="../uploads/profil/<?= urlencode($fotoProfil) ?>" alt="Foto Profil" class="foto-profil-head">
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

        <h2 class="judulbagian"><i class="fa-solid fa-fire"></i> Terbaru</h2>
        <div class="bagian">
            <div class="kumpulan-kartu">
                <?php while ($row = mysqli_fetch_assoc($resep)):
                    $foto = urlencode($row['foto']);
                    $judul = htmlspecialchars($row['judul']);
                    $highlight = $row['highlight_label'];
                    $icon = $row['highlight_icon'];
                    ?>
                    <a href="../resep/detail.php?id=<?= $row['id_resep'] ?>" class="karturesep">
                        <img src="../uploads/<?= $foto ?>" alt="<?= $judul ?>">
                        <?php if ($highlight): ?>
                            <div class="label-highlight"><?= $icon ?>         <?= $highlight ?></div>
                        <?php endif; ?>
                        <div class="judulresep"><?= $judul ?></div>
                    </a>
                <?php endwhile; ?>
            </div>
        </div>

        <h2 class="judulbagian"><i class="fa-solid fa-user-check"></i> Rekomendasi Uploader</h2>
        <div class="bagian">
            <div class="kumpulan-profil">
                <?php while ($user = mysqli_fetch_assoc($uploader)):
                    $foto = !empty($user['fotoprofil']) ? $user['fotoprofil'] : getDefaultAvatar($user['id_user'], $defaultAvatars);
                    $fotoEncoded = urlencode($foto);
                    $username = htmlspecialchars($user['username']);
                    $bio = htmlspecialchars($user['bio']);
                    $link = $user['id_user'] == $_SESSION['user_id'] ? "profil.php" : "profil.php?id_user={$user['id_user']}";
                    ?>
                    <a href="<?= $link ?>" class="kartupengguna-link">
                        <div class="kartupengguna">
                            <img src="../uploads/profil/<?= $fotoEncoded ?>" class="kartupengguna-img"
                                alt="<?= $username ?>">
                            <div class="judulpengguna"><?= $username ?></div>
                            <p class="kartupengguna-bio"><?= $bio ?></p>
                        </div>
                    </a>
                <?php endwhile; ?>
            </div>
        </div>

        <h2 class="judulbagian"><i class="fa-solid fa-utensils"></i> Pilihan buat mu</h2>
        <div class="bagian">
            <div class="kumpulan-kartu">
                <?php while ($row = mysqli_fetch_assoc($masakan)):
                    $foto = urlencode($row['foto']);
                    $judul = htmlspecialchars($row['judul']);
                    $highlight = $row['highlight_label'];
                    $icon = $row['highlight_icon'];
                    ?>
                    <a href="../resep/detail.php?id=<?= $row['id_resep'] ?>" class="karturesep">
                        <img src="../uploads/<?= $foto ?>" alt="<?= $judul ?>">
                        <?php if ($highlight): ?>
                            <div class="label-highlight"><?= $icon ?>         <?= $highlight ?></div>
                        <?php endif; ?>
                        <div class="judulresep"><?= $judul ?></div>
                    </a>
                <?php endwhile; ?>
            </div>
        </div>

        <div class="bagian tentang">
            <h2>Ketahui lebih banyak tentang <br><strong>Resep Reborn</strong></h2>
            <div class="kumpulan-kotak">
                <div class="kotaktentang">
                    <i class="fa-solid fa-laptop-code"></i>
                    <h3>Tujuan Website</h3>
                    <p>Mengurangi pembuangan limbah panen lewat kreativitas resep.</p>
                    <a href="about/tujuanweb.html">Baca</a>
                </div>
                <div class="kotaktentang">
                    <img src="../foto/fotokreator.jpg" alt="Saqa Pandega">
                    <h3>Kreator</h3>
                    <p>Siswa SMK Telkom Sidoarjo jurusan SIJA, Jawa Timur.</p>
                    <a href="https://www.instagram.com/panndega_/">Kenalan Yuk!</a>
                </div>
                <div class="kotaktentang">
                    <i class="fa-solid fa-graduation-cap"></i>
                    <h3>Tujuan</h3>
                    <p>Proyek Ujian Kenaikan Level kelas 10.</p>
                    <a href="about/about.html">Baca</a>
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
                        <a href="https://www.figma.com/design/qnYTMMQTLc2etfFqeEDfnj/Resep-Reborn?node-id=0-1&t=Agfkp8wVXwh5nSZF-1"
                            class="icon"><i class="fab fa-figma"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <?php include '../include/animasiloding/loadingjs.php' ?>
</body>

</html>