<?php
include_once "../../include/session.php";
include_once "../../include/db.php";
include_once "../../include/animasiloding/loadingcss.php";


$halaman = 'user.php';
$search = $_GET['q'] ?? '';

$defaultAvatars = ['default.png', 'Koki.png', 'Petani.png', 'Ahli.png', 'Foodie.png'];
function getDefaultAvatar($id, $defaults)
{
    return $defaults[$id % count($defaults)];
}

$whereClause = "";
if ($search !== '') {
    $safeSearch = mysqli_real_escape_string($koneksi, $search);
    $whereClause = "WHERE username LIKE '%$safeSearch%' OR email LIKE '%$safeSearch%' OR kategori LIKE '%$safeSearch%'";
}

$query = "SELECT id_user, username, email, kategori, fotoprofil, tanggal_daftar FROM tabel_user $whereClause ORDER BY id_user DESC";
$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>Admin Panel - User</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="shortcut icon" href="../../LogoPutih.ico" type="image/x-icon">
    <link rel="stylesheet" href="../style.css" />
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        .konten {
            padding: 30px;
        }

        .heading-user {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .search-bar {
            margin-bottom: 20px;
        }

        .search-bar input {
            padding: 8px 14px;
            border-radius: 6px;
            border: 1px solid #ccc;
            width: 300px;
        }

        .search-bar button {
            padding: 8px 16px;
            background: linear-gradient(to right, #ffcc33, #f20069);
            color: white;
            border: none;
            border-radius: 6px;
            margin-left: 8px;
            cursor: pointer;
        }

        .tabel-scroll {
            overflow-x: auto;
            max-width: 100%;
            scrollbar-width: thin;
            scrollbar-color: #ffcc33 #333;
        }

        /* Scrollbar untuk Chrome, Edge, Safari */
        .tabel-scroll::-webkit-scrollbar {
            height: 8px;
        }

        .tabel-scroll::-webkit-scrollbar-track {
            background: #333;
            border-radius: 10px;
        }

        .tabel-scroll::-webkit-scrollbar-thumb {
            background: #ffcc33;
            border-radius: 10px;
        }

        .tabel-scroll::-webkit-scrollbar-thumb:hover {
            background: #f2b300;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            min-width: 800px;
        }

        thead {
            background-color: #ffcc33;
            color: white;
        }

        th,
        td {
            padding: 12px 16px;
            text-align: left;
        }

        tbody tr:nth-child(even) {
            background-color: #444;
        }

        tbody tr:hover {
            background-color: #222;
        }

        .badge-admin {
            background-color: #f20069;
            color: white;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 13px;
        }

        .badge-user {
            background-color: #222;
            color: white;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 13px;
        }

        .action-link {
            color: white;
            background-color: #333;
            padding: 5px 8px;
            border-radius: 10px;
            text-decoration: none;
            margin: 1px 3px;
            font-weight: 500;
            font-size: 14px;
            text-align: center;
        }

        .action-link:hover {
            text-decoration: underline;
        }

        .avatar {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 50%;
        }

        .sidebar.collapsed {
            width: 60px;
        }
    </style>
</head>

<body>
    <div class="sidebar" id="sidebar">
        <button class="toggle-sidebar" onclick="toggleSidebar()"><i
                class="fa-solid fa-arrows-left-right-to-line"></i></button>
        <img src="../../Foto/Logoputih.png" alt="Resep Reborn" class="logo" />
        <ul class="navigasi">
            <li><a href="data.php" class="<?= ($halaman == 'data.php') ? 'active' : '' ?>"><i
                        class="fa-solid fa-chart-line" style="margin-right: 5px;"></i> Dashboard</a></li>
            <li><a href="user.php" class="<?= ($halaman == 'user.php') ? 'active' : '' ?>"><i
                        class="fa-solid fa-users" style="margin-right: 5px;"></i> User</a></li>
            <li><a href="resep.php" class="<?= ($halaman == 'resep.php') ? 'active' : '' ?>"><i
                        class="fa-solid fa-book" style="margin-right: 5px;"></i> Resep</a></li>
            <li><a href="highlight_tambah.php" class="<?= ($halaman == 'highlight_tambah.php') ? 'active' : '' ?>"><i
                        class="fa-solid fa-star" style="margin-right: 5px;"></i>Highlight</a></li>
            <li><a href="laporan.php" class="<?= ($halaman == 'laporan.php') ? 'active' : '' ?>"><i class="fa-solid fa-circle-exclamation" style="margin-right: 5px;"></i>Laporan</a></li>
            <li><a href="../Pencarian.php" class="<?= ($halaman == 'Pencarian.php') ? 'active' : '' ?>"><i
                        class="fa-solid fa-arrow-left" style="margin-right: 5px;"></i> Kembali</a></li>
        </ul>
        <a href="sk.html" class="SK">Syarat & Ketentuan</a>
    </div><div class="sidebar" id="sidebar">
        <button class="toggle-sidebar" onclick="toggleSidebar()"><i
                class="fa-solid fa-arrows-left-right-to-line"></i></button>
        <img src="../../Foto/Logoputih.png" alt="Resep Reborn" class="logo" />
        <ul class="navigasi">
            <li><a href="data.php" class="<?= ($halaman == 'data.php') ? 'active' : '' ?>"><i
                        class="fa-solid fa-chart-line" style="margin-right: 5px;"></i> Dashboard</a></li>
            <li><a href="user.php" class="<?= ($halaman == 'user.php') ? 'active' : '' ?>"><i
                        class="fa-solid fa-users" style="margin-right: 5px;"></i> User</a></li>
            <li><a href="resep.php" class="<?= ($halaman == 'resep.php') ? 'active' : '' ?>"><i
                        class="fa-solid fa-book" style="margin-right: 5px;"></i> Resep</a></li>
            <li><a href="highlight_tambah.php" class="<?= ($halaman == 'highlight_tambah.php') ? 'active' : '' ?>"><i
                        class="fa-solid fa-star" style="margin-right: 5px;"></i>Highlight</a></li>
            <li><a href="laporan.php" class="<?= ($halaman == 'laporan.php') ? 'active' : '' ?>"><i class="fa-solid fa-circle-exclamation" style="margin-right: 5px;"></i>Laporan</a></li>
            <li><a href="../Pencarian.php" class="<?= ($halaman == 'Pencarian.php') ? 'active' : '' ?>"><i
                        class="fa-solid fa-arrow-left" style="margin-right: 5px;"></i> Kembali</a></li>
        </ul>
        <a href="sk.html" class="SK">Syarat & Ketentuan</a>
    </div>

    <div class="konten" id="konten">
        <h2 class="heading-user">Daftar User</h2>

        <form class="search-bar" method="GET">
            <input type="text" name="q" placeholder="Cari username, email, atau kategori..."
                value="<?= htmlspecialchars($search) ?>">
            <button type="submit">Cari</button>
        </form>

        <div class="tabel-scroll">
            <table>
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Kategori</th>
                        <th>Tanggal Daftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <?php
                        $avatar = !empty($row['fotoprofil']) ? $row['fotoprofil'] : getDefaultAvatar($row['id_user'], $defaultAvatars);
                        ?>
                        <tr>
                            <td><img src="../../uploads/profil/<?= urlencode($avatar) ?>" class="avatar" alt="Avatar">
                            </td>
                            <td><?= htmlspecialchars($row['username']) ?></td>
                            <td><?= htmlspecialchars($row['email']) ?></td>
                            <td>
                                <?php if (strtoupper($row['kategori']) === 'ADMIN'): ?>
                                    <span class="badge-admin">ADMIN</span>
                                <?php else: ?>
                                    <span class="badge-user">USER</span>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($row['tanggal_daftar']) ?></td>
                            <td>
                                <a class="action-link" href="edit_user.php?id=<?= $row['id_user'] ?>">Edit</a>
                                <a class="action-link" href="delete_user.php?id=<?= $row['id_user'] ?>"
                                    onclick="return confirm('Yakin hapus user ini?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include '../../include/animasiloding/lodingjs.php' ?>
</body>

</html>