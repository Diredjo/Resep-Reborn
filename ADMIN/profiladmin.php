<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include '../include/db.php';
$user_id = $_SESSION['user_id'];

$result = $conn->query("SELECT username, kategori FROM tabel_user WHERE id_user = $user_id");
$user = $result->fetch_assoc();

$fotoprofil = mysqli_query($conn, "SELECT fotoprofil FROM tabel_user WHERE id_user = $user_id");

$getKategori = $conn->prepare("SELECT kategori FROM tabel_user WHERE id_user = ?");
$getKategori->bind_param("i", $user_id);
$getKategori->execute();
$resultKategori = $getKategori->get_result();
$userData = $resultKategori->fetch_assoc();

$linkKembali = ($userData['kategori'] === 'admin') ? 'Home.php' : '../USER/Home.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="FotoDSB/LogoPutih.png" rel="shortcut icon">
    <link rel="stylesheet" href="../akun/style.css">
    <title>Profil User</title>
</head>

<body>
    <div class="profile-container">
        <h1>Selamat datang, 
            <?= htmlspecialchars($user['username']); ?>!</h1>
        <p>Anda login sebagai: <strong><?= ucfirst(htmlspecialchars($user['kategori'])); ?></strong></p>
        <br>
        <a href="../akun/logout.php">Logout</a>
        <a href="../post/resepsaved.php">Bookmark</a>
        <a href="data.php">Fitur Admin</a>
        <a href="<?= $linkKembali; ?>">Kembali</a>
    </div>
</body>

</html>