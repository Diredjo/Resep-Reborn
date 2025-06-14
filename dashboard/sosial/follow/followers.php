<?php
include '../../../include/db.php';
include '../../../include/session.php';
include '../../../include/animasiloding/loadingcss.php';

$lihat_id = isset($_GET['id']) ? intval($_GET['id']) : $user_id;
$saya_sendiri = ($lihat_id === $user_id);

$query_user = mysqli_query($koneksi, "SELECT * FROM tabel_user WHERE id_user = $lihat_id");
if (mysqli_num_rows($query_user) === 0) {
    echo "Pengguna tidak ditemukan.";
    exit;
}
$user_dilihat = mysqli_fetch_assoc($query_user);

$followers = mysqli_query($koneksi, "
    SELECT u.id_user, u.username, u.fotoprofil 
    FROM tabel_follow f 
    JOIN tabel_user u ON f.id_pengikut = u.id_user 
    WHERE f.id_diikuti = $lihat_id
");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Followers - <?= htmlspecialchars($user_dilihat['username']) ?></title>
    <link rel="stylesheet" href="followers.css">
    <link rel="stylesheet" href="../../style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap">
    <link rel="shortcut icon" href="../../../LogoPutih.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>

<body>
    <div class="sidebar" id="sidebar">
        <button class="toggle-sidebar" onclick="toggleSidebar()"><i
                class="fa-solid fa-arrows-left-right-to-line"></i></button>
        <a href="../index.php"><img src="../../../Foto/Logoputih.png" alt="Resep Reborn" class="logo"></a>
        <ul class="navigasi">
            <li><a href="../../Pencarian.php" class="<?= ($halaman == 'Pencarian.php') ? 'active' : '' ?>"><i
                        class="fa-solid fa-search"></i> Pencarian</a></li>
            <li><a href="../../Favorit.php" class="<?= ($halaman == 'Favorit.php') ? 'active' : '' ?>"><i
                        class="fa-solid fa-heart"></i> Favorit</a></li>
            <li><a href="../../Bookmark.php" class="<?= ($halaman == 'Bookmark.php') ? 'active' : '' ?>"><i
                        class="fa-solid fa-bookmark"></i> Bookmark</a></li>
            <li><a href=".././Profil.php" class="<?= ($halaman == 'Profil.php') ? 'active' : '' ?>"><i
                        class="fa-solid fa-user"></i> Profil</a></li>
            <?php if ($kategori === 'ADMIN'): ?>
                <li><a href="../admin/data.php"><i class="fa-solid fa-chart-line"></i> Admin Panel</a></li>
            <?php endif; ?>
            <li><a href="../../../akun/logout.php"><i class="fa-solid fa-sign-out-alt"></i> Logout</a></li>
        </ul>
        <a href="../about/SK.html" class="SK">Syarat & Ketentuan</a>
    </div>

    <div class="konten">
        <h2>Followers <?= $saya_sendiri ? 'Saya' : htmlspecialchars($user_dilihat['username']) ?></h2>
        <div class="daftar-followers">
            <?php if (mysqli_num_rows($followers) > 0): ?>
                <?php while ($f = mysqli_fetch_assoc($followers)): ?>
                    <?php
                    $defaultAvatars = ['default.png', 'Koki.png', 'Petani.png', 'Ahli.png', 'Foodie.png'];
                    $foto = !empty($f['fotoprofil']) ? $f['fotoprofil'] : $defaultAvatars[$f['id_user'] % count($defaultAvatars)];
                    ?>
                    <div class="follower-card">
                        <img src="../../../uploads/profil/<?= urlencode($foto) ?>"
                            alt="<?= htmlspecialchars($f['username']) ?>">
                        <div class="follower-info">
                            <a href="../../Profil.php?id_user=<?= $f['id_user'] ?>"
                                class="follower-username"><?= htmlspecialchars($f['username']) ?></a>

                            <?php if ($saya_sendiri): ?>
                                <form method="POST" action="hapus_follower.php" onsubmit="return confirm('Hapus follower ini?')"
                                    class="hapus-form">
                                    <input type="hidden" name="id_pengikut" value="<?= $f['id_user'] ?>">
                                    <button type="submit" class="hapus-btn">Hapus</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Belum ada followers.</p>
            <?php endif; ?>
        </div>
    </div>

    <?php include '../../../include/animasiloding/loadingjs.php' ?>
</body>

</html>