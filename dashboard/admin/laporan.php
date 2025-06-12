<?php
include_once "../../include/session.php";
include_once "../../include/db.php";
include '../../include/animasiloding/loadingcss.php';

$halaman = 'Laporan.php';

$laporan = mysqli_query($koneksi, "SELECT lp.*, u1.username AS pelapor, u2.username AS dilaporkan 
                                FROM laporan_profil lp
                                JOIN tabel_user u1 ON lp.id_pelapor = u1.id_user
                                JOIN tabel_user  u2 ON lp.id_dilaporkan = u2.id_user
                                ORDER BY lp.tanggal_lapor DESC");
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
    <h2>Daftar Laporan Profil</h2>
    <table class="tabel-laporan">
        <thead>
            <tr>
                <th>ID</th>
                <th>Pelapor</th>
                <th>Target</th>
                <th>Alasan</th>
                <th>Tambahan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($laporan)): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['pelapor'] ?></td>
                    <td><?= $row['dilaporkan'] ?></td>
                    <td><?= $row['alasan'] ?></td>
                    <td><?= $row['alasan_tambahan'] ?></td>
                    <td><span class="badge badge-<?= $row['status'] ?>"><?= $row['status'] ?></span></td>
                    <td>
                        <select class="status-dropdown" data-id="<?= $row['id'] ?>">
                            <option value="dikirim" <?= $row['status'] == 'dikirim' ? 'selected' : '' ?>>dikirim</option>
                            <option value="ditolak" <?= $row['status'] == 'ditolak' ? 'selected' : '' ?>>ditolak</option>
                            <option value="diterima" <?= $row['status'] == 'diterima' ? 'selected' : '' ?>>diterima</option>
                        </select>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<style>
    .tabel-laporan {
        width: 100%;
        border-collapse: collapse;
        background-color: #222;
        color: #fff;
        margin-top: 20px;
    }

    .tabel-laporan th, .tabel-laporan td {
        border: 1px solid #444;
        padding: 10px;
        text-align: left;
    }

    .tabel-laporan th {
        background-color: #ffcc33;
    }

    .badge {
        padding: 4px 8px;
        border-radius: 6px;
        font-weight: bold;
        text-transform: capitalize;
    }

    .badge-dikirim {
        background-color: #ffcc33;
        color: #000;
    }

    .badge-ditolak {
        background-color: #e74c3c;
    }

    .badge-diterima {
        background-color: #2ecc71;
    }

    .status-dropdown {
        padding: 6px 10px;
        border-radius: 4px;
        background-color: #2c2c3e;
        color: #fff;
        border: 1px solid #666;
    }
</style>


        <?php include '../../include/animasiloding/loadingjs.php' ?>

        <script>
    document.querySelectorAll('.status-dropdown').forEach(function(select) {
        select.addEventListener('change', function() {
            const id = this.getAttribute('data-id');
            const status = this.value;

            const formData = new FormData();
            formData.append('id', id);
            formData.append('status', status);

            fetch('ubah_status_laporan.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.text())
            .then(res => {
                location.reload();
            })
            .catch(err => console.error('Gagal update status:', err));
        });
    });
</script>

</body>

</html>