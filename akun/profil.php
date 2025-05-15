<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
include '../db.php';
$user_id = $_SESSION['user_id'];
$result = $conn->query("SELECT username, kategori FROM tabel_user WHERE id_user = $user_id");
$user = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="FotoDSB/LogoPutih.png" rel='shorcut icon'>
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>

<body>
    <div class="profile-container">
        <h1>Selamat datang, <?php echo $user['username']; ?>!</h1>
        <p>Anda login sebagai: <strong><?php echo ucfirst($user['kategori']); ?></strong></p>
        <br>
        <a href="logout.php">Logout</a>
        <a href="../ADMIN/home.php">Kembali</a>
        <a href="../post/bookmark.php">Bookmark</a>
    </div>
</body>

</html>