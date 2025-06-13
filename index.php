<?php include 'include/animasiloding/loadingcss.php' ?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resep Reborn</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="shortcut icon" href="LogoPutih.ico" type="image/x-icon">
    <link rel="stylesheet" href="dashboard/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
    <div class="sidebar" id="sidebar">
        <button class="toggle-sidebar" onclick="toggleSidebar()"><i
                class="fa-solid fa-arrows-left-right-to-line"></i></button>
        <img src="Foto/Logoputih.png" alt="Resep Reborn" class="logo">
        <ul class="navigasi">
            <li><a href="dashboard/pencarian.php" class="<?= ($halaman == 'Pencarian.php') ? 'active' : '' ?>"><i
                        class="fa-solid fa-home"></i> Home</a></li>
            <li><a href="akun/login.php" class="<?= ($halaman == 'Pencarian.php') ? 'active' : '' ?>"><i
                        class="fa-solid fa-user"></i> Login</a></li>
            <a href="dashboard/about/SK.html" class="SK">Syarat & Ketentuan</a>
    </div>

    <div class="konten"  id="konten">
        <main class="main">
            <header class="header">
                <div class="header" style="margin-top: 20px;">
                    <a href="akun/login.php" class="tombol-upload" style="padding: 7px 30px;">Login</a>
            </header>

            <section class="hero">
                <video autoplay muted loop playsinline class="hero__video">
                    <source src="VideoLP.mp4" type="video/mp4">
                    Browser kamu tidak mendukung video HTML5.
                </video>
                <div class="hero__overlay">
                    <h1 class="hero__title">Selamat Datang di Resep Reborn</h1>
                    <p class="hero__subtitle">Temukan dan bagikan resep favoritmu</p>
                    <a href="dashboard/pencarian.php" class="hero__cta">Jelajahi Resep</a>
                </div>
            </section>



            <section class="about">
                <h2 class="section__title">Tentang Resep Reborn</h2>
                <p class="about__text">
                    Resep Reborn hadir dari semangat untuk menghidupkan kembali keajaiban dapur lokal — dari ladang dan
                    peternakan, langsung ke meja makan.
                    Kami percaya bahwa setiap panen memiliki cerita, dan setiap hasil bumi serta olahan ternak punya
                    potensi menjadi hidangan yang menginspirasi.
                    Di sini, kamu tidak hanya memasak — kamu menciptakan keajaiban. Jelajahi ribuan resep berbasis bahan
                    lokal, bagikan rahasia dapurmu, dan mari bersama kita <strong>Cook with Magic</strong>.
                    Karena keajaiban itu nyata, dan seringkali bermula dari wajan panas dan hati yang hangat.
                </p>
            </section>

            </divkonten>

            <?php include 'include/animasiloding/loadingjs.php' ?>
</body>

</html>