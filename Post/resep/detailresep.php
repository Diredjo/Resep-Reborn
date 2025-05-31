<?php
include '../../include/db.php';
include '../../include/session.php';

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

// Pisahkan bahan & alat (pakai format: bahan\n\nAlat: ...)
$isi_bahan = $data['bahan'];
$alat = '';
if (str_contains($isi_bahan, "Alat:")) {
    [$bahan, $alat] = explode("Alat:", $isi_bahan);
} else {
    $bahan = $isi_bahan;
}
$bahans = nl2br(trim($bahan));
$alat = nl2br(trim($alat));

// Langkah-langkah
$langkah_lines = explode("\n", trim($data['langkah']));
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($data['judul']) ?></title>
    <link rel="stylesheet" href="../../css/dashboard.css">
    <link rel="stylesheet" href="../../css/resep.css">
</head>

<body>
    <div class="sidebar">
        <div class="logo">Resep<br>Reborn</div>
        <ul class="navigasi">
            <li><a href="../../dashboard/pencarian.php">Pencarian</a></li>
            <li><a href="../../dashboard/favorit.php">Favorit</a></li>
            <li><a href="../../dashboard/bookmark.php">Bookmark</a></li>
            <li><a href="../../dashboard/profil.php">Profil</a></li>
            <li><a href="../../dashboard/logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="konten">
        <h2><?= htmlspecialchars($data['judul']) ?></h2>

        <div class="media-view">
            <?php if (!empty($data['video'])): ?>
                <iframe width="100%" height="300" src="<?= htmlspecialchars($data['video']) ?>" frameborder="0" allowfullscreen></iframe>
            <?php else: ?>
                <img src="../../uploads/<?= $data['foto'] ?>" alt="Foto Resep" class="foto-resep">
            <?php endif; ?>

            <div class="profil-view">
                <img src="../../uploads/profil/<?= $data['fotoprofil'] ?: 'default.png' ?>" class="foto-profil">
                <p><?= htmlspecialchars($data['username']) ?></p>
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