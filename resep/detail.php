<?php
include '../include/db.php';
include '../include/session.php';
include '../include/animasiloding/loadingcss.php';

if (!isset($_GET['id'])) exit("Resep tidak ditemukan.");

$id_resep = intval($_GET['id']);
$query = mysqli_query($koneksi, "
    SELECT r.*, u.username, u.fotoprofil, u.id_user AS id_penulis 
    FROM tabel_resep r 
    JOIN tabel_user u ON r.id_user = u.id_user 
    WHERE r.id_resep = $id_resep
");

if (mysqli_num_rows($query) === 0) exit("Resep tidak ditemukan.");

$data = mysqli_fetch_assoc($query);
$id_login = $_SESSION['user_id'];
$lihat_id = $data['id_penulis'];
$saya_sendiri = ($id_login == $lihat_id);

$cek_follow = mysqli_query($koneksi, "SELECT 1 FROM tabel_follow WHERE id_pengikut = $id_login AND id_diikuti = $lihat_id");
$is_following = mysqli_num_rows($cek_follow) > 0;

$cek_like = mysqli_query($koneksi, "SELECT 1 FROM tabel_suka WHERE id_user = $id_login AND id_resep = $id_resep");
$is_liked = mysqli_num_rows($cek_like) > 0;

$cek_bookmark = mysqli_query($koneksi, "SELECT 1 FROM tabel_bookmark WHERE id_user = $id_login AND id_resep = $id_resep");
$is_bookmarked = mysqli_num_rows($cek_bookmark) > 0;

$jumlah_like_query = mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah FROM tabel_suka WHERE id_resep = $id_resep");
$jumlah_like = mysqli_fetch_assoc($jumlah_like_query)['jumlah'];

$isi_bahan = $data['bahan'];
$alat = '';
if (str_contains($isi_bahan, "Alat:")) {
    [$bahan, $alat] = explode("Alat:", $isi_bahan);
} else {
    $bahan = $isi_bahan;
}
$bahans = nl2br(trim($bahan));
$alat = nl2br(trim($alat));
$langkah_lines = explode("\n", trim($data['langkah']));

function convertToEmbedURL($url)
{
    if (empty($url)) return '';
    if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $url, $m)) {
        return "https://www.youtube.com/embed/" . $m[1];
    }
    return strpos($url, 'youtube.com/embed/') !== false ? $url : '';
}
$video_embed = convertToEmbedURL($data['video']);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($data['judul']) ?> - Resep Reborn</title>
    <link rel="stylesheet" href="resep.css">
    <link rel="stylesheet" href="../dashboard/style.css">
    <link rel="shortcut icon" href="../LogoPutih.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="sidebar" id="sidebar">
        <button class="toggle-sidebar" onclick="toggleSidebar()"><i class="fa-solid fa-arrows-left-right-to-line"></i></button>
        <img src="../Foto/Logoputih.png" alt="Resep Reborn" class="logo">
        <ul class="navigasi">
            <li><a href="../dashboard/pencarian.php"><i class="fa-solid fa-search" style="margin-right: 5px;"></i> Pencarian</a></li>
            <li><a href="../dashboard/Favorit.php"><i class="fa-solid fa-heart" style="margin-right: 5px;"></i> Favorit</a></li>
            <li><a href="../dashboard/Bookmark.php"><i class="fa-solid fa-bookmark" style="margin-right: 5px;"></i> Bookmark</a></li>
            <li><a href="../dashboard/Profil.php"><i class="fa-solid fa-user" style="margin-right: 5px;"></i> Profil</a></li>

             <?php if ($kategori === 'ADMIN'): ?>
                <li><a href="admin/data.php" class="<?= ($halaman == 'data.php') ? 'active' : '' ?>"><i class="fa-solid fa-chart-line" style="margin-right: 5px;"></i> Admin Panel</a></li>
            <?php endif; ?>


            <li><a href="../akun/logout.php"><i class="fa-solid fa-sign-out-alt"></i> Logout</a></li>
        </ul>
        <a href="sk.html" class="SK">Baca soal Syarat & Ketentuan Kebijakaan Privasi</a>
    </div>

    <div class="konten" id="konten">
        <h2 class="judul-resep"><?= htmlspecialchars($data['judul']) ?></h2>

        <div class="kontainer-resep">
            <div class="media-wrapper">
                <?php if ($video_embed && $data['foto']): ?>
                    <div class="media-switcher">
                        <button onclick="switchMedia('foto')">Lihat Foto</button>
                        <button onclick="switchMedia('video')">Tonton Video</button>
                    </div>
                <?php endif; ?>
                <div id="media-foto" class="media-responsif" style="display: <?= $video_embed ? 'none' : 'block' ?>;">
                    <img src="../uploads/<?= htmlspecialchars($data['foto']) ?>" alt="Foto Resep">
                </div>
                <div id="media-video" class="media-responsif" style="display: <?= $video_embed ? 'block' : 'none' ?>;">
                    <iframe src="<?= htmlspecialchars($video_embed) ?>" frameborder="0" allowfullscreen></iframe>
                </div>
                <p class="deskripsi"><?= nl2br(htmlspecialchars($data['deskripsi'])) ?></p>
            </div>

            <div class="profil-dan-aksi">
                <div class="profil-uploader">
                    <img src="../uploads/profil/<?= htmlspecialchars($data['fotoprofil'] ?: 'default.png') ?>" class="foto-profil">
                    <a href="../dashboard/Profil.php?id=<?= $lihat_id ?>" class="username-uploader">@<?= htmlspecialchars($data['username']) ?></a>
                </div>
                <div class="tombol-interaksi">
                    <?php if (!$saya_sendiri): ?>
                        <form method="post" action="../dashboard/sosial/followprocess.php">
                            <input type="hidden" name="id_diikuti" value="<?= $lihat_id ?>">
                            <input type="hidden" name="id_resep" value="<?= $id_resep ?>">
                            <input type="hidden" name="aksi" value="<?= $is_following ? 'unfollow' : 'follow' ?>">
                            <button type="submit" class="tombol-ikuti">
                                <?= $is_following ? 'Berhenti Ikuti' : 'Ikuti' ?>
                            </button>
                        </form>

                        <a href="../dashboard/sosial/likeprocess.php?id_resep=<?= $id_resep ?>" class="btn-suka">
                            <i class="fa<?= $is_liked ? 's' : 'r' ?> fa-heart" style="color: <?= $is_liked ? 'red' : 'inherit' ?>;"></i>
                            <?= $jumlah_like ?>
                        </a>

                        <a href="../dashboard/sosial/bookmarkprocess.php?id_resep=<?= $id_resep ?>" class="btn-bookmark">
                            <i class="fa<?= $is_bookmarked ? 's' : 'r' ?> fa-bookmark" style="color: <?= $is_bookmarked ? '#007BFF' : 'inherit' ?>;"></i>
                        </a>


                    <?php else: ?>
                        <a href="edit.php?id=<?= $id_resep ?>" class="btn-edit">Edit Resep</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="gradient-border">
            <div class="kotak-bahan-alat">
                <div class="kotak-bahan">
                    <h3>Bahan</h3>
                    <p><?= $bahans ?></p>
                </div>
                <div class="kotak-alat">
                    <h3>Alat</h3>
                    <p><?= $alat ?: '-' ?></p>
                </div>
            </div>
        </div>

        <div class="langkah-section">
            <h3>Langkah-langkah</h3>
            <ol>
                <?php foreach ($langkah_lines as $baris): ?>
                    <?php if (trim($baris)): ?>
                        <li><?= htmlspecialchars(trim($baris)) ?></li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ol>
        </div>

        <div class="blok-komentar" id="komentar">
            <h3>Komentar</h3>
            <form id="form-komentar" method="post" action="../dashboard/sosial/komentar/komentarprocess.php">
                <textarea name="komentar" placeholder="Tulis komentarmu..." required></textarea>
                <input type="hidden" name="id_resep" value="<?= $id_resep ?>">
                <button type="submit">Kirim</button>
            </form>
            <div id="daftar-komentar">
                <?php include '../dashboard/sosial/komentar/komentar.php'; ?>
            </div>
        </div>
    </div>

    <?php include '../include/animasiloding/loadingjs.php'; ?>

    <script>
        function switchMedia(type) {
            document.getElementById('media-foto').style.display = type === 'foto' ? 'block' : 'none';
            document.getElementById('media-video').style.display = type === 'video' ? 'block' : 'none';
        }
    </script>
</body>

</html>