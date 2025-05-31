<?php
session_start();
include '../include/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $kategori = $_POST['kategori'];

    if (empty($username) || empty($email) || empty($password) || empty($kategori)) {
        $_SESSION['error'] = "Semua data harus diisi!";
        header("Location: register.php");
        exit;
    }

    $check = mysqli_query($koneksi, "SELECT * FROM tabel_user WHERE username='$username' OR email='$email'");
    if (mysqli_num_rows($check) > 0) {
        $_SESSION['error'] = "Username atau email sudah digunakan!";
        header("Location: register.php");
        exit;
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);

    $insert = mysqli_query($koneksi, "INSERT INTO tabel_user (username, email, password, kategori)
                                   VALUES ('$username', '$email', '$hash', '$kategori')");

    if ($insert) {
        $_SESSION['success'] = "Registrasi berhasil! Silakan login.";
        header("Location: login.php");
    } else {
        $_SESSION['error'] = "Gagal mendaftar: " . mysqli_error($koneksix);
        header("Location: register.php");
    }
    exit;
} else {
    header("Location: register.php");
    exit;
}
