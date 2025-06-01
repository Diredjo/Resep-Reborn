<?php
include '../include/db.php';
include '../include/session.php';
include '../include/animasiloding/loadingcss.php';

$lihat_id = isset($_GET['id_user']) ? intval($_GET['id_user']) : $user_id;
$saya_sendiri = ($lihat_id === $user_id);
$pengguna_sendiri = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT fotoprofil FROM tabel_user WHERE id_user = $user_id"));
$defaultAvatars = ['default.png', 'Koki.png', 'Petani.png', 'Ahli.png', 'Foodie.png'];
$fotoProfilPengguna = !empty($pengguna_sendiri['fotoprofil']) ? $pengguna_sendiri['fotoprofil'] : getDefaultAvatar($user_id, $defaultAvatars);


$query_user = mysqli_query($koneksi, "SELECT * FROM tabel_user WHERE id_user = $lihat_id");

if (mysqli_num_rows($query_user) === 0) {
    echo "Pengguna tidak ditemukan.";
    exit;
}

$user_dilihat = mysqli_fetch_assoc($query_user);
$jumlah_followers = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM tabel_follow WHERE id_diikuti = $lihat_id"))['total'];
$jumlah_postingan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM tabel_resep WHERE id_user = $lihat_id"))['total'];

$tanggal_daftar = strtotime($user_dilihat['tanggal_daftar']);
$hari_bergabung = floor((time() - $tanggal_daftar) / (60 * 60 * 24));

$resep_user = mysqli_query($koneksi, "SELECT * FROM tabel_resep WHERE id_user = $lihat_id ORDER BY tanggal_posting DESC");

function getDefaultAvatar($id, $avatars)
{
    return $avatars[$id % count($avatars)];
}

$fotoProfil = !empty($user_dilihat['fotoprofil']) ? $user_dilihat['fotoprofil'] : getDefaultAvatar($lihat_id, $defaultAvatars);

$fotoProfilPengguna = !empty($user['fotoprofil']) ? $user['fotoprofil'] : getDefaultAvatar($user_id, $defaultAvatars);

$is_following = false;
if (!$saya_sendiri) {
    $cek_follow_query = mysqli_query($koneksi, "SELECT * FROM tabel_follow WHERE id_pengikut = $user_id AND id_diikuti = $lihat_id");
    $is_following = mysqli_num_rows($cek_follow_query) > 0;
}

$halaman = 'Profil.php';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Profil <?= htmlspecialchars($user_dilihat['username']) ?></title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
            <a href="pencarian.php" class="tombol-home"><i class="fa-solid fa-home"></i></a>
        </div>

        <h2><?= $saya_sendiri ? 'Profil Saya' : 'Profil Pengguna' ?></h2>

        <div class="bagian">
            <div class="kotak-profil">
                <img src="../uploads/profil/<?= urlencode($fotoProfil) ?>" alt="Foto Profil" class="foto-profil">
                <div class="info-profil">
                    <h2><?= htmlspecialchars($user_dilihat['username']) ?></h2>
                    <h5><?= htmlspecialchars($user_dilihat['id_user']) ?></h5>
                    <p><?= htmlspecialchars($user_dilihat['bio']) ?></p>
                </div>
                <?php if (!$saya_sendiri): ?>
                    <form action="sosial/followprocess.php" method="POST" style="display:inline;">
                        <input type="hidden" name="id_diikuti" value="<?= $lihat_id ?>">
                        <input type="hidden" name="aksi" value="<?= $is_following ? 'unfollow' : 'follow' ?>">
                        <button type="submit" class="tombol-follow" style="background:<?= $is_following ? '#aaa' : '#ff6f00' ?>;">
                            <?= $is_following ? 'Mengikuti' : 'Ikuti' ?>
                        </button>
                    </form>
                <?php else: ?>
                    <a href="edit-profil.php" class="tombol-edit">✎</a>
                <?php endif; ?>
            </div>

            <div class="statistik-profil">
                <div class="stat">
                    <a href="sosial/followers.php?id=<?= $lihat_id ?>">
                        <strong><?= number_format($jumlah_followers) ?></strong>
                        <span>Pengikut</span>
                    </a>
                </div>
                <div class="stat"><strong><?= $jumlah_postingan ?></strong><span>Postingan</span></div>
                <div class="stat"><strong><?= $hari_bergabung ?></strong><span>Hari bergabung</span></div>
            </div>
        </div>

        <div class="bagian">
            <h2>Postingan <?= $saya_sendiri ? 'saya' : 'pengguna' ?></h2>
            <div class="kumpulan-kartu-wrap">
                <?php while ($resep = mysqli_fetch_assoc($resep_user)): ?>
                    <div class='karturesep'>
                        <img src='../uploads/<?= urlencode($resep['foto']) ?>' alt='<?= htmlspecialchars($resep['judul']) ?>'>
                        <div class='judulresep'><?= htmlspecialchars($resep['judul']) ?></div>
                    </div>
                <?php endwhile; ?>
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
                            <a href="#" class="icon"><i class="fab fa-figma"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

    </div>

    <?php include '../include/animasiloding/loadingjs.php' ?>
</body>

</html>