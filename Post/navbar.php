<?php
include '../include/db.php';

$id_user = $_SESSION['user_id'] ?? null;

if ($id_user) {
    $result = mysqli_query($conn, "SELECT kategori FROM tabel_user WHERE id_user = $id_user");
    $data = mysqli_fetch_assoc($result);
}
?>

<header class="navbar">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <nav>
        <ul>
            <?php if ($_SESSION['role'] !== 'USER') { ?>
                <li><a href="../ADMIN/home.php"><i class="fas fa-arrow-left"></i></a></li>
                <?php } else { ?>
                    <li><a href="../USER/home.php"><i class="fas fa-home"></i></a></li>
           <?php } ?>
            <?php if ($_SESSION['role'] !== 'USER') { ?>
                <li><a href="../ADMIN/search.php"><i class="fas fa-compass"></i></a></li>
                <?php } else { ?>
                    <li><a href="../USER/search.php"><i class="fas fa-compass"></i></a></li>
           <?php } ?>
        </ul>
    </nav>
</header>

<style>
    .navbar {
        background: rgba(34, 34, 34, 0.91);
        backdrop-filter: blur(10px);
        z-index: 1000;
        padding: 10px;
        position: fixed;
        bottom: 0;
        width: 100%;
        text-align: center;
    }

    .navbar nav ul {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        justify-content: center;
        gap: 75px;
    }

    .navbar nav ul li {
        display: inline;
    }

    .navbar nav ul li a {
        color: white;
        font-size: 24px;
        text-decoration: none;
        padding: 10px;
        transition: 0.3s;
    }

    .navbar nav ul li a:hover {
        color: #f39c12;
    }
</style>