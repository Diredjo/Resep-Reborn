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
</head>

<body>
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
                            <a href="Profil.php?id_user=<?= $f['id_user'] ?>"
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