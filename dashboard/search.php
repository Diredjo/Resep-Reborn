<?php
include '../include/db.php';
include '../include/session.php';
include '../include/animasiloding/loadingcss.php';

$hasilResep = [];
$hasilUser = [];
$keyword = '';

if (isset($_GET['q']) && $_GET['q'] !== '') {
    $keyword = mysqli_real_escape_string($koneksi, $_GET['q']);

    $hasilResep = mysqli_query($koneksi, "
        SELECT * FROM tabel_resep 
        WHERE judul LIKE '%$keyword%' 
        OR deskripsi LIKE '%$keyword%' 
        OR bahan LIKE '%$keyword%'
        ORDER BY tanggal_posting DESC
    ");

    $hasilUser = mysqli_query($koneksi, "
        SELECT * FROM tabel_user 
        WHERE username LIKE '%$keyword%' 
        OR bio LIKE '%$keyword%'
        ORDER BY username ASC
    ");
}

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
    <title>Pencarian - Resep Reborn</title>
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

            <div class="search-row">
                <input type="text" class="pencarian" placeholder="<?= $randomPlaceholder ?>" name="q" required>
                <button class="tombol-cari" type="submit"><i class="fa-solid fa-wand-sparkles"></i></button>
            </div>
        </form>


        <?php if ($keyword): ?>
            <h2 class="judulbagian">Pengguna yang ditemukan:</h2>
            <div class="kumpulan-profil">
                <?php if (mysqli_num_rows($hasilUser) > 0): ?>
                    <?php while ($user = mysqli_fetch_assoc($hasilUser)): ?>
                        <?php
                        $foto = !empty($user['fotoprofil']) ? $user['fotoprofil'] : getDefaultAvatar($user['id_user'], $defaultAvatars);
                        $fotoEncoded = urlencode($foto);
                        $usernameSafe = htmlspecialchars($user['username']);
                        ?>
                        <div class="kartupengguna">
                            <img src="../uploads/profil/<?= $fotoEncoded ?>" class="kartupengguna-img" alt="<?= $usernameSafe ?>">
                            <div><?= $usernameSafe ?></div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p style="color:#aaa; margin-left: 10px;">Hmm... gak ada pengguna yang cocok buat “<strong><?= htmlspecialchars($keyword) ?></strong>” 😢</p>
                <?php endif; ?>
            </div>

            <h2 class="judulbagian">Resep yang ditemukan:</h2>
            <div class="kumpulan-kartu-grid">
                <?php if (mysqli_num_rows($hasilResep) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($hasilResep)): ?>
                        <a href="../resep/detail.php?id=<?= $row['id_resep'] ?>" class="karturesep-scroll">
                            <img src="../uploads/<?= $row['foto'] ?>" alt="<?= htmlspecialchars($row['judul']) ?>">
                            <div class="judulresep"><?= htmlspecialchars($row['judul']) ?></div>
                        </a>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p style="color:#aaa;">Kayanya mantra resep kamu kurang tepat deh...<br>"<?= htmlspecialchars($keyword) ?>"</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
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
                        <a href="#" class="icon"><i class="fab fa-figma"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <?php include '../include/animasiloding/loadingjs.php' ?>

</body>

</html>