<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id']) || !isset($_SESSION['kategori'])) {
    header("Location: ../akun/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$kategori = $_SESSION['kategori'];
?>
