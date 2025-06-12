<?php
include_once "../../include/session.php";
include_once "../../include/db.php";

$halaman = 'highlight_tambah.php';
$error = '';

if (isset($_POST['hapus_id'])) {
    $hapus_id = intval($_POST['hapus_id']);
    $delete = mysqli_query($koneksi, "DELETE FROM tabel_highlight WHERE id_highlight = $hapus_id");
    if ($delete) {
        header("Location: highlight_tambah.php");
        exit;
    } else {
        $error = "Gagal menghapus highlight.";
    }
}

// Proses tambah highlight baru
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['label'])) {
    $label = trim($_POST['label'] ?? '');
    $icon = trim($_POST['icon'] ?? '');

    if ($label === '') {
        $error = "Label tidak boleh kosong.";
    } else {
        $label_safe = mysqli_real_escape_string($koneksi, $label);
        $icon_safe = mysqli_real_escape_string($koneksi, $icon);
        $query = "INSERT INTO tabel_highlight (label, icon) VALUES ('$label_safe', '$icon_safe')";
        $result = mysqli_query($koneksi, $query);

        if ($result) {
            header("Location: highlight_tambah.php");
            exit;
        } else {
            $error = "Gagal menambahkan highlight: " . mysqli_error($koneksi);
        }
    }
}

$highlight_result = mysqli_query($koneksi, "SELECT * FROM tabel_highlight ORDER BY id_highlight ASC");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Tambah Highlight - Admin Panel</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="shortcut icon" href="../../LogoPutih.ico" type="image/x-icon">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="data.css">
    <style>
        .btn-hapus {
            background: transparent;
            border: none;
            color: #ff4d4d;
            font-size: 1.1rem;
            cursor: pointer;
        }

        .btn-hapus:hover {
            color: #ff0000;
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
                        class="fa-solid fa-star"></i> Highlight</a></li>
            <li><a href="../Pencarian.php" class="<?= ($halaman == 'Pencarian.php') ? 'active' : '' ?>"><i
                        class="fa-solid fa-arrow-left"></i> Kembali</a></li>
        </ul>
        <a href="sk.html" class="SK">Syarat & Ketentuan</a>
    </div>

    <div class="konten" id="konten">
        <h2 class="judul-form">Tambah Kategori Highlight Baru</h2>

        <?php if (!empty($error)): ?>
            <p class="error-msg"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="POST" class="form-highlight">
            <label for="label">Label Highlight</label>
            <input placeholder="Contoh: Rekomendasi" type="text" name="label" id="label" required>

            <label for="icon">Icon</label>
            <input placeholder="Contoh: 🔥" type="text" name="icon" id="icon">

            <button type="submit" class="btn-submit">Tambah Highlight</button>
        </form>

        <h3 class="judul-tabel">Daftar Highlight</h3>
        <table class="tabel-highlight">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Label</th>
                    <th>Icon</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($highlight_result)): ?>
                    <tr>
                        <td><?= $row['id_highlight'] ?></td>
                        <td><?= htmlspecialchars($row['label']) ?></td>
                        <td><?= htmlspecialchars($row['icon']) ?></td>
                        <td>
                            <form method="POST" onsubmit="return confirm('Yakin ingin menghapus highlight ini?')">
                                <input type="hidden" name="hapus_id" value="<?= $row['id_highlight'] ?>">
                                <button type="submit" class="btn-hapus" title="Hapus"><i
                                        class="fa-solid fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('collapsed');
        }
    </script>
    </