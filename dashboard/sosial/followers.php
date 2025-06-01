<?php
include '../../include/db.php';
include '../../include/session.php';

$id_dilihat = isset($_GET['id']) ? intval($_GET['id']) : $user_id;

$query_user = mysqli_query($koneksi, "SELECT * FROM tabel_user WHERE id_user = $id_dilihat");
if (mysqli_num_rows($query_user) === 0) {
    echo "Pengguna tidak ditemukan.";
    exit;
}
$user_dilihat = mysqli_fetch_assoc($query_user);

$followers = mysqli_query($koneksi, "
    SELECT u.id_user, u.username, u.fotoprofil
    FROM tabel_follow f
    JOIN tabel_user u ON f.id_pengikut = u.id_user
    WHERE f.id_diikuti = $id_dilihat
    ORDER BY f.id DESC
");

$defaultAvatars = ['default.png', 'Koki.png', 'Petani.png', 'Ahli.png', 'Foodie.png'];
function getDefaultAvatar($id, $avatars)
{
    return $avatars[$id % count($avatars)];
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Pengikut <?= htmlspecialchars($user_dilihat['username']) ?></title>
    <link rel="stylesheet" href="../style.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="sidebar" id="sidebar">
        <button class="toggle-sidebar" onclick="toggleSidebar()"><i class="fa-solid fa-arrows-left-right-to-line"></i></button>
        <img src="../Foto/Logoputih.png" alt="Resep Reborn" class="logo">
        <ul class="navigasi">
            <li><a href="../Pencarian.php" class="<?= ($halaman == 'Pencarian.php') ? 'active' : '' ?>"><i class="fa-solid fa-search" style="margin-right: 5px;"></i> Pencarian</a></li>
            <li><a href="../Favorit.php" class="<?= ($halaman == 'Favorit.php') ? 'active' : '' ?>"><i class="fa-solid fa-heart" style="margin-right: 5px;"></i> Favorit</a></li>
            <li><a href="../Bookmark.php" class="<?= ($halaman == 'Bookmark.php') ? 'active' : '' ?>"><i class="fa-solid fa-bookmark" style="margin-right: 5px;"></i> Bookmark</a></li>
            <li><a href="../Profil.php" class="<?= ($halaman == 'Profil.php') ? 'active' : '' ?>"><i class="fa-solid fa-user" style="margin-right: 5px;"></i> Profil</a></li>
            <li><a href="../../akun/logout.php"><i class="fa-solid fa-sign-out-alt"></i> Logout</a></li>
        </ul>
        <a href="sk.html" class="SK">Baca soal Syarat & Ketentuan Kebijakaan Privasi</a>
    </div>

    <div class="konten" id="konten">
        <h2>Pengikut <?= htmlspecialchars($user_dilihat['username']) ?></h2>
        <div class="bagian">
            <div class="kumpulan-profil">
                <?php while ($f = mysqli_fetch_assoc($followers)): ?>
                    <?php
                    $foto = !empty($f['fotoprofil']) ? $f['fotoprofil'] : getDefaultAvatar($f['id_user'], $defaultAvatars);
                    ?>
                    <a href="profil.php?id=<?= $f['id_user'] ?>" class="kartupengguna">
                        <img src="../uploads/profil/<?= urlencode($foto) ?>" class="kartupengguna-img" alt="<?= htmlspecialchars($f['username']) ?>">
                        <div><?= htmlspecialchars($f['username']) ?></div>
                    </a>
                <?php endwhile; ?>
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