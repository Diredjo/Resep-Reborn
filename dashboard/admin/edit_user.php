<?php
include_once "../../include/session.php";
include_once "../../include/db.php";

$id_user = $_GET['id'] ?? null;
if (!$id_user) {
    header("Location: user.php");
    exit;
}

$id_user = (int) $id_user;
$query = "SELECT * FROM tabel_user WHERE id_user = $id_user";
$result = mysqli_query($koneksi, $query);
$data = mysqli_fetch_assoc($result);
if (!$data) {
    header("Location: user.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $bio = mysqli_real_escape_string($koneksi, $_POST['bio']);
    $kategori_input = $_POST['kategori'] === 'Admin' ? 'Admin' : 'User';

    if (isset($_POST['save'])) {
        $update = "UPDATE tabel_user SET username = '$username', bio = '$bio', kategori = '$kategori_input' WHERE id_user = $id_user";
        mysqli_query($koneksi, $update);
        header("Location: user.php");
        exit;
    }

    if (isset($_POST['reset_password'])) {
        $password_baru = password_hash('user12345', PASSWORD_DEFAULT);
        $reset = "UPDATE tabel_user SET password = '$password_baru' WHERE id_user = $id_user";
        mysqli_query($koneksi, $reset);
        header("Location: user.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>Edit User - Admin Panel</title>
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
            overflow-x: hidden;
        }

        h2 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-top: 14px;
            margin-bottom: 6px;
            font-weight: 500;
        }

        input,
        textarea,
        select {
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        button {
            margin-top: 20px;
            padding: 10px 18px;
            background: linear-gradient(to right, #ffcc33, #f20069);
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
        }

        .danger {
            background: #e63946;
            margin-left: 10px;
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

    <div class="konten">
        <h2>Edit User</h2>
        <form method="POST">
            <label>Username:</label>
            <input type="text" name="username" value="<?= htmlspecialchars($data['username']) ?>" required>

            <label>Bio:</label>
            <textarea name="bio" rows="4"><?= htmlspecialchars($data['bio']) ?></textarea>

            <label>Kategori:</label>
            <select name="kategori" required>
                <option value="User" <?= $data['kategori'] === 'User' ? 'selected' : '' ?>>User</option>
                <option value="Admin" <?= $data['kategori'] === 'Admin' ? 'selected' : '' ?>>Admin</option>
            </select>

            <button type="submit" name="save">Simpan</button>
            <button type="submit" name="reset_password" class="danger"
                onclick="return confirm('Yakin reset password ke default (user12345)?')">Reset Password</button>
        </form>
    </div>
</body>

</html>