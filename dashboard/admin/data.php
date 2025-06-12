<?php
include_once "../../include/session.php";
include_once "../../include/db.php";

$userBaru = mysqli_query($koneksi, "SELECT username, tanggal_daftar FROM tabel_user ORDER BY tanggal_daftar DESC LIMIT 2");
$resepBaru = mysqli_query($koneksi, "SELECT judul, tanggal_posting FROM tabel_resep ORDER BY tanggal_posting DESC LIMIT 2");
$aktivitas = [];

while ($user = mysqli_fetch_assoc($userBaru)) {
    $aktivitas[] = [
        'waktu' => $user['tanggal_daftar'],
        'deskripsi' => "User baru: <strong>{$user['username']}</strong> bergabung"
    ];
}

while ($resep = mysqli_fetch_assoc($resepBaru)) {
    $aktivitas[] = [
        'waktu' => $resep['tanggal_posting'],
        'deskripsi' => "Resep baru: <strong>{$resep['judul']}</strong> diunggah"
    ];
}

usort($aktivitas, function ($a, $b) {
    return strtotime($b['waktu']) - strtotime($a['waktu']);
});

$aktivitas = array_slice($aktivitas, 0, 4);

$resepMingguan = mysqli_fetch_assoc(mysqli_query($koneksi, "
    SELECT COUNT(*) AS total FROM tabel_resep WHERE tanggal_posting >= DATE_SUB(NOW(), INTERVAL 7 DAY)
"))['total'];

$userMingguan = mysqli_fetch_assoc(mysqli_query($koneksi, "
    SELECT COUNT(*) AS total FROM tabel_user WHERE tanggal_daftar >= DATE_SUB(NOW(), INTERVAL 7 DAY)
"))['total'];


$halaman = 'data.php';

$userCount = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM tabel_user"))['total'];
$adminCount = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM tabel_user WHERE kategori='ADMIN'"))['total'];
$resepCount = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM tabel_resep"))['total'];

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>Admin Panel - Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="shortcut icon" href="../../LogoPutih.ico" type="image/x-icon">
    <link rel="stylesheet" href="../style.css" />
    <link rel="stylesheet" href="data.css" />
    <script src="https://kit.fontawesome.com/a81368914c.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="sidebar" id="sidebar">
        <button class="toggle-sidebar" onclick="toggleSidebar()"><i
                class="fa-solid fa-arrows-left-right-to-line"></i></button>
        <img src="../../Foto/Logoputih.png" alt="Resep Reborn" class="logo" />
        <ul class="navigasi">
            <li><a href="data.php" class="<?= ($halaman == 'data.php') ? 'active' : '' ?>"><i
                        class="fa-solid fa-chart-line"></i> Dashboard</a></li>
            <li><a href="user.php" class="<?= ($halaman == 'user.php') ? 'active' : '' ?>"><i
                        class="fa-solid fa-users"></i> User</a></li>
            <li><a href="resep.php" class="<?= ($halaman == 'resep.php') ? 'active' : '' ?>"><i
                        class="fa-solid fa-book"></i> Resep</a></li>
            <li><a href="highlight_tambah.php" class="<?= ($halaman == 'highlight_tambah.php') ? 'active' : '' ?>"><i
                        class="fa-solid fa-star"></i>Highlight</a></li>
            <li><a href="../Pencarian.php" class="<?= ($halaman == 'Pencarian.php') ? 'active' : '' ?>"><i
                        class="fa-solid fa-arrow-left" style="margin-right: 5px;"></i> Kembali</a></li>
        </ul>
        <a href="sk.html" class="SK">Syarat & Ketentuan</a>
    </div>

    <div class="konten" id="konten">
        <h2>Dashboard Statistik</h2>
        <div class="statistik-container">
            <a href="user.php" class="statistik-box">
                <p>Total User: <strong><?= $userCount ?></strong></p>
            </a>
            <a href="user.php" class="statistik-box">
                <p>Total Admin: <strong><?= $adminCount ?></strong></p>
            </a>
            <a href="resep.php" class="statistik-box">
                <p>Total Resep: <strong><?= $resepCount ?></strong></p>
            </a>
        </div>

        <div class="dashboard-bottom">
            <div class="aktivitas">
                <h3>Aktivitas Terbaru</h3>
                <ul>
                    <?php foreach ($aktivitas as $item): ?>
                        <li><?= $item['deskripsi'] ?> <small
                                style="color: gray;">(<?= date('d M', strtotime($item['waktu'])) ?>)</small></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="progress">
                <h3>Progress Mingguan</h3>
                <p>Resep Baru: <strong><?= $resepMingguan ?></strong></p>
                <p>User Baru: <strong><?= $userMingguan ?></strong></p>
            </div>
        </div>
    </div>




    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('collapsed');
        }
    </script>
</body>

</html>