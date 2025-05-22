
<?php
session_start();
include '../include/db.php';
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query_login = "SELECT id_user, password, kategori FROM tabel_user WHERE username = '$username'";
    $result_login = mysqli_query($conn, $query_login);

    if ($row_login = mysqli_fetch_assoc($result_login)) {
        if (password_verify($password, $row_login['password'])) {
            $_SESSION['user_id'] = $row_login['id_user'];
            $_SESSION['kategori'] = strtoupper($row_login['kategori']);
            if ($row_login['kategori'] === 'admin') {
                header("Location: ../ADMIN/home.php");
            } else {
                header("Location: ../USER/home.php");
            }
            exit;
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Username tidak ditemukan!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Masuk - Resep Reborn</title>
    <link rel="stylesheet" href="../css/akun.css">
</head>
<body class="latar">
    <div class="overlay-darken"></div>
    <section class="bungkus-masuk">
        <div class="salam-masuk">
            <img src="../foto/logoputih.png" alt="Logo" class="logo">
            <h1>Selamat Datang!</h1>
            <p>Selamat datang kembali! Senang melihatmu lagi 😊</p>
        </div>
        <?php if (!empty($error)) : ?>
            <div class="notif-error"><?= $error ?></div>
        <?php endif; ?>
        <form action="login.php" method="POST" class="formulir">
            <input type="text" name="username" placeholder="Nama Pengguna" class="kotak-input" required>
            <input type="password" name="password" placeholder="Kata Sandi" class="kotak-input" required>
            <button type="submit" class="tombol-utama">Masuk</button>
            <p class="tautan">Belum punya akun? <a href="register.php">Daftar</a></p>
        </form>
    </section>
</body>
</html>

            