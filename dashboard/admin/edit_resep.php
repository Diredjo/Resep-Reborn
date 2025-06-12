<?php
include '../../include/db.php';
include '../../include/session.php';

$user_id = $_SESSION['user_id'];
$id_resep = intval($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = mysqli_real_escape_string($koneksi, $_POST['judul'] ?? '');
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi'] ?? '');
    $bahan = mysqli_real_escape_string($koneksi, $_POST['bahan'] ?? '');
    $langkah = mysqli_real_escape_string($koneksi, $_POST['langkah'] ?? '');
    $highlight = mysqli_real_escape_string($koneksi, $_POST['highlight'] ?? '');

    if (trim($judul) === '') {
        die("Judul tidak boleh kosong.");
    }

    $query = "
        UPDATE tabel_resep SET
            judul = '$judul',
            deskripsi = '$deskripsi',
            bahan = '$bahan',
            langkah = '$langkah',
            highlight_label = '$highlight'
        WHERE id_resep = $id_resep
    ";

    if (!mysqli_query($koneksi, $query)) {
        die("Gagal update resep: " . mysqli_error($koneksi));
    }

    header("Location: resep.php");
    exit;
}

$result = mysqli_query($koneksi, "SELECT * FROM tabel_resep WHERE id_resep = $id_resep");
$resep = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>Edit Resep - Admin Panel</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="shortcut icon" href="../../LogoPutih.ico" type="image/x-icon">
    <link rel="stylesheet" href="../style.css" />
    <link rel="stylesheet" href="data.css" />
    <script src="https://kit.fontawesome.com/a81368914c.js" crossorigin="anonymous"></script>
    <style>
        form {
            max-width: 600px;
            margin: auto;
        }

        input[type="text"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            margin-bottom: 20px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        button {
            padding: 10px 20px;
            border: none;
            background-color: #2a9d8f;
            color: white;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
        }

        button:hover {
            background-color: #21867a;
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
        <h2>Edit Resep</h2>
        <form method="POST">
            <label>Judul:</label>
            <input type="text" name="judul" value="<?= htmlspecialchars($resep['judul']) ?>" required>

            <label>Deskripsi:</label>
            <textarea name="deskripsi" rows="4"><?= htmlspecialchars($resep['deskripsi']) ?></textarea>

            <label>Bahan:</label>
            <textarea name="bahan" rows="4"><?= htmlspecialchars($resep['bahan']) ?></textarea>

            <label>Langkah-langkah:</label>
            <textarea name="langkah" rows="6"><?= htmlspecialchars($resep['langkah']) ?></textarea>

            <button type="submit">Simpan Perubahan</button>
        </form>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('collapsed');
        }
    </script>
</body>

</html>