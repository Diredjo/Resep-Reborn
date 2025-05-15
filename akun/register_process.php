<?php
session_start();
include '../include/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email    = $_POST['email'];
    $passHash = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $kategori = $_POST['kategori'];

    $_SESSION['register_data'] = $_POST;

    $query_cekusr    = "SELECT id_user FROM tabel_user WHERE username = '$username'";
    $result_cekusr   = mysqli_query($conn, $query_cekusr);

    if (mysqli_num_rows($result_cekusr) > 0) {
        $_SESSION['register_message'] = "Username sudah digunakan!";
        header("Location: register.php");
        exit;
    }

    $query_insert  = "INSERT INTO tabel_user (username, email, password, kategori) 
                      VALUES ('$username', '$email', '$passHash', '$kategori')";
    if (mysqli_query($conn, $query_insert)) {
        unset($_SESSION['register_data']);
        $_SESSION['register_message'] = "Registrasi berhasil!";
    } else {
        $_SESSION['register_message'] = "Registrasi gagal! Silakan coba lagi.";
    }
    header("Location: register.php");
    exit;
}
