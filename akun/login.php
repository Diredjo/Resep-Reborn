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
            $_SESSION['role']    = strtoupper($row_login['kategori']);
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Resep Reborn</title>
    <link rel="icon" href="../FotoDSB/LogoPutih.png">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login-container">
        <img src="../Foto/LogoMiring.png" alt="Logo" class="logo">
        <form action="login.php" method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>
        <?php if ($error): ?>
            <p class="error"><?= $error; ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
