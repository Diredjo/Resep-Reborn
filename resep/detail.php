<?php
include '../include/db.php';
include '../include/session.php';

if (!isset($_GET['id'])) {
    echo "Resep tidak ditemukan.";
    exit;
}

$id_resep = intval($_GET['id']);
$query = mysqli_query($koneksi, "
  SELECT r.*, u.username, u.fotoprofil 
  FROM tabel_resep r 
  JOIN tabel_user u ON r.id_user = u.id_user 
  WHERE r.id_resep = $id_resep
");

if (mysqli_num_rows($query) == 0) {
    echo "Resep tidak ditemukan.";
    exit;
}

$data = mysqli_fetch_assoc($query);

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

        <div class="media-view">
            <?php if (!empty($data['video'])): ?>
                <iframe width="100%" height="300" src="<?= htmlspecialchars($data['video']) ?>" frameborder="0" allowfullscreen></iframe>
            <?php else: ?>
                <img src="../uploads/<?= htmlspecialchars($data['foto']) ?>" alt="Foto Resep" class="foto-resep">
            <?php endif; ?>

            <div class="profil-view">
                <img src="../uploads/profil/<?= htmlspecialchars($data['fotoprofil'] ?: 'default.png') ?>" class="foto-profil">
                <p><?= htmlspecialchars($data['username']) ?></p>
                <div class="aksi-user">
                    <?php if ($data['id_user'] == $_SESSION['user_id']): ?>
                        <a href="hapus_resep.php?id=<?= $data['id_resep'] ?>" class="btn btn-danger">
                            <i class="fa fa-trash"></i> Hapus
                        </a>
                    <?php else: ?>
                        <button class="btn btn-primary"><i class="fa fa-user-plus"></i> Ikuti</button>
                        <button class="btn btn-like"><i class="fa fa-heart"></i></button>
                        <button class="btn btn-bookmark"><i class="fa fa-bookmark"></i></button>
                    <?php endif; ?>
                </div>
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
</body>

</html>
