<?php
include '../include/db.php';
include '../include/session.php';

$hasil = [];
$keyword = '';

if (isset($_GET['q']) && $_GET['q'] !== '') {
    $keyword = mysqli_real_escape_string($koneksi, $_GET['q']);
    $hasil = mysqli_query($koneksi, "
        SELECT * FROM tabel_resep 
        WHERE judul LIKE '%$keyword%' 
        OR deskripsi LIKE '%$keyword%' 
        OR bahan LIKE '%$keyword%'
        ORDER BY tanggal_posting DESC
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

?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Pencarian Resep</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="../css/dashboard.css">
</head>

<body>
    <div class="sidebar" id="sidebar">
        <button class="toggle-sidebar" onclick="toggleSidebar()"><i class="fa-solid fa-arrows-left-right-to-line"></i></button>
        <img src="../Foto/Logoputih.png" alt="Resep Reborn" class="logo">
        <ul class="navigasi">
            <li><a href="Pencarian.php" class="<?= ($halaman == 'Pencarian.php') ? 'active' : '' ?>"><i class="fa-solid fa-search"></i> Pencarian</a></li>
            <li><a href="Favorit.php" class="<?= ($halaman == 'Favorit.php') ? 'active' : '' ?>"><i class="fa-solid fa-heart"></i> Favorit</a></li>
            <li><a href="Bookmark.php" class="<?= ($halaman == 'Bookmark.php') ? 'active' : '' ?>"><i class="fa-solid fa-bookmark"></i> Bookmark</a></li>
            <li><a href="Profil.php" class="<?= ($halaman == 'Profil.php') ? 'active' : '' ?>"><i class="fa-solid fa-user"></i> Profil</a></li>
            <li><a href="../akun/logout.php"><i class="fa-solid fa-sign-out-alt"></i> Logout</a></li>
        </ul>
        <a href="sk.html" class="SK">Baca soal Syarat & Ketentuan Kebijakaan Privasi</a>
    </div>

    <div class="konten" id="konten">
        <div class="header">
            <a href="../Post/resep/upload.php" class="tombol-upload">+ Upload Resep</a>
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

        <form method="get" action="pencarian.php" class="searchcont" method="get">
            <img src="../Foto/LogoPutih.png" alt="Resep Reborn" class="logosearch">
            <input type="text" class="pencarian" placeholder="<?= $randomPlaceholder ?>" name="q" value="<?= htmlspecialchars($keyword) ?>" class="pencarian">
            <button class="tombol-cari" type="submit"><i class="fa-solid fa-wand-sparkles"></i></button>
        </form>

        <?php if ($keyword): ?>
            <h2>Ketemu!</h2>
            <div class="kumpulan-kartu-grid">
                <?php if (mysqli_num_rows($hasil) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($hasil)): ?>
                        <a href="../Post/resep/detailresep.php?id=<?= $row['id_resep'] ?>" class="karturesep-scroll">
                            <img src="../uploads/<?= $row['foto'] ?>" alt="<?= $row['judul'] ?>">
                            <div class="judulresep"><?= htmlspecialchars($row['judul']) ?></div>
                        </a>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p style="color:#aaa;">Kayanya mantra resep kamu kurang tepat deh...<br>"<?= htmlspecialchars($keyword) ?>"</p>
                <?php endif; ?>
            </div>

        <?php endif; ?>
    </div>

    <footer>
        <p>Olah bersama kami! | Customer Support: support@resepreborn.id</p>
    </footer>

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