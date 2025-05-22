<?php
include '../include/db.php';
include '../include/session.php';

$id = $_SESSION['user_id'];

// Ambil data user
$ambil = mysqli_query($conn, "SELECT * FROM tabel_user WHERE id_user = $id");
$data = mysqli_fetch_assoc($ambil);

// Proses jika form disubmit
if (isset($_POST['simpan'])) {
    $username = $_POST['username'];
    $bio = $_POST['bio'];

    // Cek jika ada upload foto
    if ($_FILES['fotoprofil']['name'] != '') {
        $nama_file = time() . '-' . $_FILES['foto']['name'];
        $tmp = $_FILES['fotoprofil']['tmp_name'];
        move_uploaded_file($tmp, '../post/uploads/profil' . $nama_file);

        // Update semua termasuk foto
        mysqli_query($conn, "UPDATE tabel_user SET username='$username', bio='$bio', fotoprofil='$nama_file' WHERE id_user=$id");
    } else {
        // Update tanpa foto
        mysqli_query($conn, "UPDATE tabel_user SET username='$username', bio='$bio' WHERE id_user=$id");
    }

    header("Location: profil.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Profil</title>
    <link rel="stylesheet" href="../css/akun.css">
</head>
<body>

<div class="wadah">
    <form action="" method="POST" enctype="multipart/form-data" class="kotak_profil">

        <img src="../post/uploads/profil<?= $data['fotoprofil']; ?>" class="foto_profil" alt="foto lama">

        <div class="info_user">
            <h2>Edit Profil</h2>
            <label>Username:</label><br>
            <input type="text" name="username" value="<?= $data['username']; ?>"><br><br>

            <label>Bio:</label><br>
            <textarea name="bio"><?= $data['bio']; ?></textarea><br><br>

            <label>Foto Baru (opsional):</label><br>
            <input type="file" name="fotoprofil"><br><br>

            <button type="submit" name="simpan" class="tombol">💾 Simpan Perubahan</button>
        </div>

    </form>
</div>

</body>
</html>
