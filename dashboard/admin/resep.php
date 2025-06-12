<?php
include_once "../../include/session.php";
include_once "../../include/db.php";

$halaman = 'resep.php';

$query = "
SELECT 
    r.id_resep,
    r.judul,
    r.tanggal_posting,
    r.foto,
    r.id_highlight,
    u.id_user AS id_uploader,
    u.username AS uploader,
    h.label AS highlight_label,
    h.icon AS highlight_icon,
    COUNT(DISTINCT c.id_komentar) AS jml_komentar,
    SUM(CASE WHEN l.id_suka IS NOT NULL THEN 1 ELSE 0 END) AS jml_like,
    SUM(CASE WHEN b.id_bookmark IS NOT NULL THEN 1 ELSE 0 END) AS jml_bookmark
FROM tabel_resep r
JOIN tabel_user u ON r.id_user = u.id_user
LEFT JOIN tabel_highlight h ON r.id_highlight = h.id_highlight
LEFT JOIN tabel_komentar c ON c.id_resep = r.id_resep
LEFT JOIN tabel_suka l ON l.id_resep = r.id_resep
LEFT JOIN tabel_bookmark b ON b.id_resep = r.id_resep
GROUP BY r.id_resep
ORDER BY r.tanggal_posting DESC
";

$result = mysqli_query($koneksi, $query);

$highlight_list = [];
$highlight_query = mysqli_query($koneksi, "SELECT * FROM tabel_highlight ORDER BY label ASC");
while ($row = mysqli_fetch_assoc($highlight_query)) {
    $highlight_list[] = $row;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>Admin Panel - Data Resep</title>
    <script src="https://kit.fontawesome.com/a81368914c.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="shortcut icon" href="../../LogoPutih.ico" type="image/x-icon">
    <link rel="stylesheet" href="../style.css" />
    <style>
        html,
        body {
            max-width: 100%;
            overflow-x: hidden;
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }

        .konten {
            padding: 20px;
        }

        .table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        .data-resep-table {
            width: max-content;
            min-width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .data-resep-table th,
        .data-resep-table td {
            border: 1px #333;
            padding: 10px;
            text-align: center;
            white-space: nowrap;
        }

        .data-resep-table th {
            background-color: #ffcc33;
            font-weight: bold;
        }

        .data-resep-table img {
            width: 80px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
        }

        select[name="highlight"] {
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 14px;
            margin-top: 4px;
        }

        .aksi-links a {
            margin: 0 5px;
            text-decoration: none;
            color: #007bff;
        }

        .aksi-links a:hover {
            text-decoration: underline;
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
    </div>

    <div class="konten" id="konten">
        <h2>Data Resep & Statistik</h2>
        <div class="table-wrapper">
            <table class="data-resep-table">
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Judul</th>
                        <th>Uploader</th>
                        <th>Tanggal Upload</th>
                        <th>Komentar</th>
                        <th>Like</th>
                        <th>Bookmark</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($r = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td>
                                <?php if (!empty($r['foto'])): ?>
                                    <img src="../../uploads/<?= htmlspecialchars($r['foto']) ?>" alt="Foto Resep">
                                <?php else: ?>
                                    <span>Tidak ada</span>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($r['judul']) ?></td>
                            <td><?= htmlspecialchars($r['uploader']) ?></td>
                            <td><?= htmlspecialchars($r['tanggal_posting']) ?></td>
                            <td><?= htmlspecialchars($r['jml_komentar']) ?></td>
                            <td><?= htmlspecialchars($r['jml_like']) ?></td>
                            <td><?= htmlspecialchars($r['jml_bookmark']) ?></td>
                            <td class="aksi-links">
                                <a href="edit_resep.php?id=<?= $r['id_resep'] ?>">Edit</a> |
                                <a href="delete_resep.php?id=<?= $r['id_resep'] ?>"
                                    onclick="return confirm('Yakin mau hapus resep ini?')">Hapus</a>
                                <form action="highlight_process.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="id_resep" value="<?= htmlspecialchars($r['id_resep']) ?>">
                                    <select name="highlight" onchange="this.form.submit()">
                                        <option value="">-</option>
                                        <br>
                                        <?php foreach ($highlight_list as $h): ?>
                                            <option value="<?= $h['id_highlight'] ?>" <?= $r['id_highlight'] == $h['id_highlight'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($h['icon'] . ' ' . $h['label']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('collapsed');
        }
    </script>
</body>

</html>