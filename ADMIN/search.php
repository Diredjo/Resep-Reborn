<?php
include '../include/db.php';
include '../include/session.php';
include 'navbar.php';

$user_id = $_SESSION['user_id'];
$user_result = mysqli_query($conn, "SELECT username FROM tabel_user WHERE id_user = $user_id");
$user = mysqli_fetch_assoc($user_result);

$search = '';
if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
}

$sql = "SELECT r.id_resep, r.judul, r.foto, r.deskripsi, r.tanggal_posting,
               (SELECT COUNT(*) FROM tabel_suka WHERE id_resep = r.id_resep) AS likes,
               (SELECT COUNT(*) FROM tabel_komentar WHERE id_resep = r.id_resep) AS comments
        FROM tabel_resep r";

if (!empty($search)) {
    $sql .= " WHERE r.judul LIKE '%$search%'";
}

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Resep</title>
    <link rel="stylesheet" href="../css/homeadmin.css">
    <link rel="icon" type="image/x-icon" href="/Resep_Reborn/LogoPutih.ico">
    <link rel="shortcut icon" href="/Resep_Reborn/LogoPutih.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<header class="navbaratas">
    <div class="navbarisi">
        <div class="logohome">
            <img src="../Foto/LogoMiring.png" alt="Logo" class="logofoto">
        </div>
        <div class="pencarian">
            <form action="search.php" method="GET">
                <input type="text" name="search" class="kotakpencarian" placeholder="Cari resep..."
                    value="<?= htmlspecialchars($search); ?>">
                <button type="submit" class="search-btn"><i class="fas fa-search"></i></button>
            </form>
        </div>
        <button class="tomboltoggle" onclick="toggleMenu()">☰</button>
    </div>
</header>

<div class="menu_overlay" id="overlayMenu">
    <div class="isi_overlay">
        <button class="tutup" onclick="toggleMenu()">&times;</button>
        <ul>
            <li><a href="home.php">Beranda</a></li>
            <li><a href="../about.php">Tentang</a></li>
            <li><a href="search.php">Jelajahi</a></li>
            <li><a href="profiladmin.php">Profil</a></li>
            <li><a href="../akun/logout.php">Logout</a></li>
        </ul>
    </div>
</div>

<body>

    <div class="gridresep" id="resepContainer">
        <h2>Jelajahi</h2>
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <?php
                $id_resep = $row['id_resep'];
                $cek = mysqli_query($conn, "SELECT * FROM tabel_bookmark WHERE id_resep = '$id_resep' AND id_user = '$user_id'");
                $bookmarked = mysqli_num_rows($cek) > 0;
                ?>
                <div class="kartu" data-title="<?= htmlspecialchars($row['judul']); ?>" data-like="<?= $row['likes']; ?>">
                    <div style="position: relative;">
                        <img src="../Post/uploads/<?= htmlspecialchars($row['foto']); ?>"
                            alt="<?= htmlspecialchars($row['judul']); ?>" class="foto_kartu">

                        <div class="tombolresep">
                            <form action="../Post/suka/like_unlike.php" method="POST" class="formaksi">
                                <input type="hidden" name="id_resep" value="<?= $id_resep; ?>">
                                <button type="submit" name="like" class="tombolsuka">
                                    <?php if ($bookmarked): ?>
                                        <i class="fas fa-heart"></i>
                                    <?php else: ?>
                                        <i class="far fa-heart"></i>
                                    <?php endif; ?>
                                    <span><?= $row['likes']; ?></span>
                                </button>
                            </form>
                            <form action="../Post/komentar/add_comment.php" method="POST" class="formaksi">
                                <input type="hidden" name="id_resep" value="<?= $id_resep; ?>">
                                <button type="submit" class="tombolkomentar">
                                    <i class="far fa-comment"></i>
                                    <span><?= $row['comments']; ?></span>
                                </button>
                            </form>
                            <form action="../Post/save/save_unsave.php" method="POST" class="formaksi">
                                <input type="hidden" name="id_resep" value="<?= $id_resep; ?>">
                                <button type="submit" name="save" class="tomboltandabuku">
                                    <?php if ($bookmarked): ?>
                                        <i class="fas fa-bookmark"></i>
                                    <?php else: ?>
                                        <i class="far fa-bookmark"></i>
                                    <?php endif; ?>
                                </button>
                            </form>
                        </div>
                    </div>

                    <a href="detail.php?id=<?= $row['id_resep']; ?>"
                        class="judul_kartu"><?= htmlspecialchars($row['judul']); ?></a>
                        <a href="detail.php?id=<?= $row['id_resep']; ?>" class="deskripsi_kartu">
                <span><?= htmlspecialchars($row['deskripsi']); ?></span>
                </a>
                <a href="detail.php?id=<?= $row['id_resep']; ?>" class="tanggal_kartu">
                <span><?= htmlspecialchars($row['tanggal_posting']); ?></span>
                </a>

                <div class="bawah_kartu">
                    <form action="resep.php" method="GET">
                        <input type="hidden" name="id_resep" value="<?= $id_resep; ?>">
                        <button type="submit" class="tombolrecook">
                            <i class="fas fa-utensils"></i> Recook
                        </button>
                    </form>
                    <form action="../Post/delete.php" method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus postingan ini?');">
                        <input type="hidden" name="id_resep" value="<?= $id_resep; ?>">
                        <button type="submit" class="tombolhapus">
                            <i class="fas fa-trash-alt"></i> Hapus
                        </button>
                    </form>
                </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Resep tidak ditemukan.</p>
        <?php endif; ?>
    </div>

</body>

</html>