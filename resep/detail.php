<?php
include '../include/db.php';
include '../include/session.php';

if (!isset($_GET['id'])) {
    echo "Resep tidak ditemukan.";
    exit;
}

$id_resep = intval($_GET['id']);
$query = mysqli_query($koneksi, "
  SELECT r.*, u.username, u.fotoprofil, u.id_user AS id_penulis 
  FROM tabel_resep r 
  JOIN tabel_user u ON r.id_user = u.id_user 
  WHERE r.id_resep = $id_resep
");

if (mysqli_num_rows($query) == 0) {
    echo "Resep tidak ditemukan.";
    exit;
}

$data = mysqli_fetch_assoc($query);
$id_login = $_SESSION['user_id'];
$lihat_id = $data['id_penulis'];
$saya_sendiri = ($id_login == $lihat_id);

$cek_follow = mysqli_query($koneksi, "SELECT * FROM tabel_follow WHERE id_pengikut = $id_login AND id_diikuti = $lihat_id");
$is_following = mysqli_num_rows($cek_follow) > 0;

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

// Fungsi untuk konversi URL video jadi embed
function convertToEmbedURL($url)
{
    if (empty($url)) return '';
    // Extract video ID dari link Youtube biasa
    if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $url, $matches)) {
        return "https://www.youtube.com/embed/" . $matches[1];
    }
    // Jika sudah embed URL, return apa adanya
    if (strpos($url, 'youtube.com/embed/') !== false) {
        return $url;
    }
    // Boleh extend untuk platform lain jika perlu
    return '';
}

$video_embed = convertToEmbedURL($data['video']);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($data['judul']) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="shortcut icon" href="../LogoPutih.ico" type="image/x-icon">
    <link rel="stylesheet" href="../dashboard/style.css">
    <link rel="stylesheet" href="resep.css">
    <style>
        .media-toggle {
            margin-bottom: 10px;
            text-align: center;
        }

        .media-toggle label {
            cursor: pointer;
            padding: 8px 20px;
            border: 2px solid #ff6f00;
            border-radius: 30px;
            margin: 0 10px;
            font-weight: 600;
            user-select: none;
            transition: background 0.3s, color 0.3s;
        }

        .media-toggle input[type="radio"] {
            display: none;
        }

        .media-toggle input[type="radio"]:checked+label {
            background: #ff6f00;
            color: white;
        }

        .media-content {
            text-align: center;
        }

        .media-content img,
        .media-content iframe {
            max-width: 100%;
            max-height: 350px;
            border-radius: 10px;
            border: 2px solid #ccc;
        }

        .media-content iframe {
            border: none;
        }
    </style>
</head>

<body>
    <div class="sidebar" id="sidebar">
        <button class="toggle-sidebar" onclick="toggleSidebar()"><i class="fa-solid fa-arrows-left-right-to-line"></i></button>
        <img src="../Foto/Logoputih.png" alt="Resep Reborn" class="logo">
        <ul class="navigasi">
            <li><a href="../dashboard/Pencarian.php" class="<?= ($halaman == 'Pencarian.php') ? 'active' : '' ?>"><i class="fa-solid fa-search" style="margin-right: 5px;"></i> Pencarian</a></li>
            <li><a href="../dashboard/Favorit.php" class="<?= ($halaman == 'Favorit.php') ? 'active' : '' ?>"><i class="fa-solid fa-heart" style="margin-right: 5px;"></i> Favorit</a></li>
            <li><a href="../dashboard/Bookmark.php" class="<?= ($halaman == 'Bookmark.php') ? 'active' : '' ?>"><i class="fa-solid fa-bookmark" style="margin-right: 5px;"></i> Bookmark</a></li>
            <li><a href="../dashboard/Profil.php" class="<?= ($halaman == 'Profil.php') ? 'active' : '' ?>"><i class="fa-solid fa-user" style="margin-right: 5px;"></i> Profil</a></li>
            <li><a href="../akun/logout.php"><i class="fa-solid fa-sign-out-alt"></i> Logout</a></li>
        </ul>
        <a href="sk.html" class="SK">Baca soal Syarat & Ketentuan Kebijakaan Privasi</a>
    </div>

    <div class="konten">
        <h2><?= htmlspecialchars($data['judul']) ?></h2>

        <div class="media-toggle">
            <input type="radio" id="show-foto" name="media" checked>
            <label for="show-foto">Foto</label>

            <?php if ($video_embed): ?>
                <input type="radio" id="show-video" name="media">
                <label for="show-video">Video</label>
            <?php endif; ?>
        </div>

        <div class="media-content">
            <img src="../uploads/<?= htmlspecialchars($data['foto']) ?>" alt="Foto Resep" class="foto-resep" id="media-foto">

            <?php if ($video_embed): ?>
                <iframe id="media-video" width="560" height="315" src="<?= htmlspecialchars($video_embed) ?>" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen style="display:none;"></iframe>
            <?php endif; ?>
        </div>

        <div class="profil-view">
            <img src="../uploads/profil/<?= htmlspecialchars($data['fotoprofil'] ?: 'default.png') ?>" class="foto-profil">
            <p><?= htmlspecialchars($data['username']) ?></p>
            <div class="aksi-user">
                <?php if ($saya_sendiri): ?>
                    <a href="hapus_resep.php?id=<?= $data['id_resep'] ?>" class="btn btn-danger">
                        <i class="fa fa-trash"></i> Hapus
                    </a>
                    <a href="edit-profil.php" class="tombol-edit">✎</a>
                <?php else: ?>
                    <form action="../dashboard/sosial/followprocess.php" method="POST" style="display:inline;">
                        <input type="hidden" name="id_diikuti" value="<?= $lihat_id ?>">
                        <input type="hidden" name="aksi" value="<?= $is_following ? 'unfollow' : 'follow' ?>">
                        <button type="submit" class="tombol-follow" style="background:<?= $is_following ? '#aaa' : '#ff6f00' ?>;">
                            <?= $is_following ? 'Mengikuti' : 'Ikuti' ?>
                        </button>
                    </form>
                    <button class="btn btn-like"><i class="fa fa-heart"></i></button>
                    <button class="btn btn-bookmark"><i class="fa fa-bookmark"></i></button>
                <?php endif; ?>
            </div>
        </div>

        <p class="deskripsi"><?= nl2br(htmlspecialchars($data['deskripsi'])) ?></p>

        <div class="kotak-bahan-alat">
            <div>
                <h3>Bahan</h3>
                <p><?= $bahans ?></p>
            </div>
            <div>
                <h3>Alat</h3>
                <p><?= $alat ?: '-' ?></p>
            </div>
        </div>

        <div class="langkah-section">
            <h3>Langkah-langkah</h3>
            <ol>
                <?php foreach ($langkah_lines as $baris): ?>
                    <?php if (trim($baris)): ?>
                        <li><?= htmlspecialchars(trim(preg_replace('/^\d+\.\s*/', '', $baris))) ?></li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ol>
        </div>
    </div>

    <script>
        const fotoRadio = document.getElementById('show-foto');
        const videoRadio = document.getElementById('show-video');
        const fotoEl = document.getElementById('media-foto');
        const videoEl = document.getElementById('media-video');

        if (videoRadio) {
            fotoRadio.addEventListener('change', () => {
                if (fotoRadio.checked) {
                    fotoEl.style.display = 'block';
                    videoEl.style.display = 'none';
                    // stop video playing by resetting src to prevent refuse connect or audio running
                    videoEl.src = videoEl.src;
                }
            });

            videoRadio.addEventListener('change', () => {
                if (videoRadio.checked) {
                    fotoEl.style.display = 'none';
                    videoEl.style.display = 'block';
                }
            });
        }
    </script>
</body>

</html>