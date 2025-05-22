<?php
include '../include/session.php';
include '../include/db.php';

$user_id = $_SESSION['user_id'];
$user_result = mysqli_query($conn, "SELECT username, fotoprofil, kategori
                                    FROM tabel_user WHERE id_user = $user_id");
$user = mysqli_fetch_assoc($user_result);

$sqlTopResep = "SELECT * FROM tabel_resep ORDER BY RAND() LIMIT 3";
$topResepResult = mysqli_query($conn, $sqlTopResep);

$urutan = $_GET['urutan'] ?? 'baru';

$by = match ($urutan) {
    'baru' => 'ORDER BY r.id_resep DESC',
    'lama' => 'ORDER BY r.id_resep ASC',
    'suka' => 'ORDER BY s.jml DESC',
    'komen' => 'ORDER BY k.jml DESC',
    'tandai' => 'ORDER BY b.jml DESC',
    default => 'ORDER BY RAND()',
};

$query = "SELECT r.id_resep, r.judul, r.deskripsi, r.tanggal_posting, r.kategori, r.foto, r.bg, u.username, u.fotoprofil, 
                 COALESCE(s.jml, 0) AS likes,
                 COALESCE(k.jml, 0) AS comments,
                 COALESCE(b.jml, 0) AS bookmarks
          FROM tabel_resep r
          LEFT JOIN tabel_user u ON r.id_user = u.id_user
          LEFT JOIN (SELECT id_resep, COUNT(*) AS jml FROM tabel_suka GROUP BY id_resep) s ON r.id_resep = s.id_resep
          LEFT JOIN (SELECT id_resep, COUNT(*) AS jml FROM tabel_komentar GROUP BY id_resep) k ON r.id_resep = k.id_resep
          LEFT JOIN (SELECT id_resep, COUNT(*) AS jml FROM tabel_bookmark GROUP BY id_resep) b ON r.id_resep = b.id_resep
          $by";

$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resep Reborn</title>
    <link rel="stylesheet" href="../css/homeadmin.css">
    <link rel="icon" href="/Resep_Reborn/LogoPutih.ico">
</head>

<body>

    <header class="navbaratas">
        <div class="navbarisi">
            <div class="logohome">
                <img src="../Foto/LogoMiring.png" alt="Logo" class="logofoto">
            </div>
            <div class="pencarian">
                <form action="search.php" method="GET">

                    <input type="text" name="search" class="kotakpencarian" placeholder="Cari resep...">
                    <button type="submit" class="tombolcari"><i class="fas fa-search"></i></button>
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
                <li><a href="profil.php">Profil</a></li>
                <li><a href="../akun/logout.php">Logout</a></li>
            </ul>
        </div>
    </div>

    <input type="radio" name="slide-switch" id="slide1" checked hidden>
    <input type="radio" name="slide-switch" id="slide2" hidden>
    <input type="radio" name="slide-switch" id="slide3" hidden>

    <section class="slider">
        <div class="sliderisi">
            <div class="semuafoto">
                <div class="fotoslider"><img src="../Foto/GANDUM.jpg" alt="Gambar 1" class="gambar"></div>
                <div class="fotoslider"><img src="../Foto/SAAWAH1.jpg" alt="Gambar 2" class="gambar"></div>
                <div class="fotoslider"><img src="../Foto/backgroundlandpage.jpg" alt="Gambar 3" class="gambar"></div>
            </div>
        </div>
        <div class="nav_manual">
            <label for="slide1" class="tombolfoto"></label>
            <label for="slide2" class="tombolfoto"></label>
            <label for="slide3" class="tombolfoto"></label>
        </div>
    </section>

    <section class="hero">
        <h1>Your recipe <br> deserves a <span>place</span></h1>
        <p>Bagikan resep favoritmu dan temukan inspirasi kuliner baru dari para pecinta masak lainnya.</p>
        <div class="tombol">
            <a href="search.php" class="utama">Lihat Resep</a>
            <a href="../Post/create.php" class="kedua">Mulai Sekarang</a>
        </div>
    </section>

    <section class="atas_resep">
        <h2>Pilihan buat kamu</h2>
        <div class="topresep">
            <?php while ($row = mysqli_fetch_assoc($topResepResult)): ?>
                <div class="topkartu">
                    <img src="../Post/uploads/<?= htmlspecialchars($row['foto']); ?>"
                        alt="<?= htmlspecialchars($row['judul']); ?>" class="foto_kartu">
                    <a href="detail.php?id=<?= $row['id_resep']; ?>"
                        class="judul_kartu"><?= htmlspecialchars($row['judul']); ?></a>
                </div>
            <?php endwhile; ?>
        </div>
    </section>

    <div class="jelajahi-header">
        <h2>Jelajahi</h2>
        <form method="GET" class="sort-form">
            <label for="urut" class="sort-label">
                <i class="fas fa-sort"></i>
            </label>
            <select name="urutan" id="urut" onchange="this.form.submit()" class="sort-select">
                <option value="baru" <?= ($_GET['urutan'] ?? '') === 'baru' ? 'selected' : '' ?>>Terbaru</option>
                <option value="lama" <?= ($_GET['urutan'] ?? '') === 'lama' ? 'selected' : '' ?>>Terlama</option>
                <option value="acak" <?= ($_GET['urutan'] ?? '') === 'acak' ? 'selected' : '' ?>>Acak</option>
                <option value="suka" <?= ($_GET['urutan'] ?? '') === 'suka' ? 'selected' : '' ?>>Paling Disukai
                </option>
                <option value="komen" <?= ($_GET['urutan'] ?? '') === 'komen' ? 'selected' : '' ?>>Sering Dikomentari
                </option>
                <option value="tandai" <?= ($_GET['urutan'] ?? '') === 'tandai' ? 'selected' : '' ?>>Banyak Disimpan
                </option>
            </select>
        </form>
    </div>

    <div class="gridresep" id="resepContainer">
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <?php
            $id_resep = $row['id_resep'];

            $cek = mysqli_query($conn, "SELECT * FROM tabel_bookmark WHERE id_resep = '$id_resep' AND id_user = '$user_id'");
            $bookmarked = mysqli_num_rows($cek) > 0;

            $queryLike = mysqli_query($conn, "SELECT * FROM tabel_suka WHERE id_resep = $id_resep AND id_user = $user_id");
            $ceklike = mysqli_num_rows($queryLike) > 0;
            ?>
            <div class="kartu" data-title="<?= htmlspecialchars($row['judul']); ?>" data-like="<?= $row['likes']; ?>">
                <div style="position: relative;">
                    <img src="../Post/uploads/<?= htmlspecialchars($row['foto']); ?>"
                        alt="<?= htmlspecialchars($row['judul']); ?>" class="foto_kartu">

                    <div class="aksi_atas tombolresep">
                        <div class="kiri_tombol">
                            <form action="../Post/suka/like_unlike.php" method="POST" class="formaksi">
                                <input type="hidden" name="id_resep" value="<?= $id_resep; ?>">
                                <button type="submit" name="like" class="tombolsuka">
                                    <?php if ($ceklike): ?>
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
                                    <i class="fa-solid fa-comment"></i>
                                    <span><?= $row['comments']; ?></span>
                                </button>
                            </form>
                        </div>
                        <div class="kanan_tombol">
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
                </div>

                <div class="judul&desk">
                    <a href="detail.php?id=<?= $row['id_resep']; ?>" class="judul_kartu">
                        <span class="judul_inner"><?= htmlspecialchars($row['judul']); ?></span>
                    </a>
                    <a href="detail.php?id=<?= $row['id_resep']; ?>" class="deskripsi_kartu">
                        <span><?= htmlspecialchars($row['deskripsi']); ?></span>
                    </a>
                </div>

                <div class="ktg-tgl">
                    <a href="search.php?id=<?= $row['id_resep']; ?>" class="ktg_kartu">
                        <span><?= htmlspecialchars($row['kategori']); ?></span>
                    </a>
                    <a href="detail.php?id=<?= $row['id_resep']; ?>" class="tanggal_kartu">
                        <span><?= htmlspecialchars($row['tanggal_posting']); ?></span>
                    </a>
                </div>

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
    </div>


    <div class="spacerfooter"></div>
    <footer>
        <p>Follow us on:
            <a href="https://facebook.com" target="_blank">Facebook</a>
            <a href="https://twitter.com" target="_blank">Twitter</a>
            <a href="https://instagram.com" target="panndega_">Instagram</a>
        </p>
        <div class="copyright">&copy; 1995 Resep Reborn. All rights reserved.</div>
    </footer>

    <?php include 'navbar.php'; ?>

</body>

</html>