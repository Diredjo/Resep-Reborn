<?php
include '../include/db.php';

$success = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $kategori = $_POST['kategori'];

    if (empty($username) || empty($email) || empty($password) || empty($kategori)) {
        $error = "Semua data harus diisi!";
    } else {
        $check_query = "SELECT * FROM tabel_user WHERE username = '$username' OR email = '$email'";
        $check_result = mysqli_query($koneksi, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            $error = "Username atau email sudah terdaftar!";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $insert_query = "INSERT INTO tabel_user (username, email, password, kategori)
                             VALUES ('$username', '$email', '$hashed_password', '$kategori')";
            if (mysqli_query($koneksi, $insert_query)) {
                $success = "Registrasi berhasil! Silakan login.";
            } else {
                $error = "Gagal mendaftar: " . mysqli_error($koneksi);
            }
        }
    }
}
?>

<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar - Resep Reborn</title>
    <link rel="stylesheet" href="akun.css">
    <link rel="shortcut icon" href="../LogoPutih.ico" type="image/x-icon">
</head>
<body class="latar">
    <div class="overlay-darken"></div>
    <section class="bungkus-daftar">
        <div class="salam-daftar">
            <img src="../foto/logomiring.png" alt="Logo" class="logomiring">
            <h1>Gabung Yuk!</h1>
            <p>Yuk, jadi bagian dari komunitas keren ini ✨</p>
        </div>
        <?php
        if (isset($_SESSION['error'])) {
            echo '<div class="notif-error">'.$_SESSION['error'].'</div>';
            unset($_SESSION['error']);
        }
        if (isset($_SESSION['success'])) {
            echo '<div class="notif-sukses">'.$_SESSION['success'].'</div>';
            unset($_SESSION['success']);
        }
        ?>
        <form action="register_process.php" method="POST" class="formulir">
            <input type="text" name="username" placeholder="Nama Pengguna" class="kotak-input" required>
            <input type="email" name="email" placeholder="Email" class="kotak-input" required>
            <input type="password" name="password" placeholder="Kata Sandi" class="kotak-input" required>
            <select name="kategori" class="kotak-input" required>
                <option value="user">User</option>
                <option value="admin" disabled>Admin</option>
            </select>
            <button type="submit" class="tombol-utama">Daftar</button>
            <p class="tautan">Sudah punya akun? <a href="login.php">Masuk</a></p>
        </form>
    </section>
</body>
</html>

