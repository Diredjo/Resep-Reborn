<?php
$conn = mysqli_connect("localhost", "root", "", "reborn");
if (!$conn) {
    die("Gagal terhbung ke database");
}
