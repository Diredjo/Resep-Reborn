<?php
$koneksi = mysqli_connect("localhost", "root", "", "reborn");
if (!$koneksi) {
  die("Koneksi gagal: " . mysqli_connect_error());
}
?>
