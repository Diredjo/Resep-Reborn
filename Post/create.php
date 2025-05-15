<?php
include '../include/db.php';
include '../include/session.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $bahan = $_POST['bahan'];
    $langkah = $_POST['langkah'];
    $kategori = $_POST['kategori'];

    $id_user = $_SESSION['user_id'];

    $foto = $_FILES['foto']['name'];
    $tmp_foto = $_FILES['foto']['tmp_name'];
    move_uploaded_file($tmp_foto, "uploads/" . $foto);

    if (!empty($_FILES['video']['name'])) {
        $video = $_FILES['video']['name'];
        $tmp_video = $_FILES['video']['tmp_name'];
        move_uploaded_file($tmp_video, "uploads/" . $video);
    } else {
        $video = "";
    }

    $sql = "INSERT INTO tabel_resep (id_user, judul, deskripsi, bahan, langkah, kategori, foto, video)
            VALUES ('$id_user', '$judul', '$deskripsi', '$bahan', '$langkah', '$kategori', '$foto', '$video')";

    $query = mysqli_query($conn, $sql);

    if ($query) {
        echo '<script>
            alert("Resep berhasil disimpan!");
            window.location.href = "../ADMIN/search.php";
        </script>';
    } else {
        echo "Gagal simpan data: " . mysqli_error($conn);
    }
}
?>


<!DOCTYPE html>
<html>

<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <title>Buat Resep Baru</title>
    <link rel="stylesheet" href="../css/post.css">
    <link href="FotoDSB/LogoPutih.png" rel='shorcut icon'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body class="create">
    <?php include "navbar.php" ?>
    <h2 class="form-title">Buat Resep Baru</h2>

    <form action="create.php" method="POST" enctype="multipart/form-data" class="form-resep">
        <label class="form-label">Judul:</label>
        <input type="text" name="judul" required class="form-input">

        <label class="form-label">Deskripsi:</label>
        <input type="text" name="deskripsi" required class="form-input">

        <label class="form-label">Bahan:</label>
        <textarea name="bahan" required class="form-textarea"></textarea>

        <label class="form-label">Langkah-langkah:</label>
        <textarea name="langkah" required class="form-textarea"></textarea>

        <label class="form-label">Foto (Wajib):</label>
        <input type="file" name="foto" accept="image/*" required class="form-file">

        <label class="form-label">Video (Opsional):</label>
        <input type="file" name="video" accept="video/*" class="form-file">

        <label class="form-label">Tipe:</label><br>
        <div class="kategori-radio">
            <label><input type="radio" name="tipe" value="Makanan" required> Makanan <a
                    href="Infomakanan">?</a></label><br>
            <label><input type="radio" name="tipe" value="Minuman"> Minuman <a href="Infominuman">?</a></label><br>
            <label><input type="radio" name="tipe" value="Camilan"> Camilan <a href="Infocamilan">?</a></label><br>
        </div>
        <input type="hidden" name="id_user" value="1">

        <label class="form-label">Kategori:</label><br>
        <div class="kategori-checkbox">
            <label><input type="checkbox" name="kategori" value="Fermentasi"> Fermentasi <a
                    href="Infofermentasi">?</a></label><br>
            <label><input type="checkbox" name="kategori" value="Pengeringan"> Pengeringan <a
                    href="Infopengeringan">?</a></label><br>
            <label><input type="checkbox" name="kategori" value="Pemanisan"> Pemanisan <a
                    href="Infopemanisan">?</a></label><br>
            <label><input type="checkbox" name="kategori" value="Pengasapan"> Pengasapan <a
                    href="Infopengasapan">?</a></label><br>
            <label><input type="checkbox" name="kategori" value="Penepungan"> Penepungan <a
                    href="Infopenepungan">?</a></label><br>
            <label><input type="checkbox" name="kategori" value="Pembekuan"> Pembekuan <a
                    href="Infopembekuan">?</a></label><br>
            <label><input type="checkbox" name="kategori" value="Inovasi_limbah"> Inovasi Limbah <a
                    href="Inovasi_limbah">?</a></label><br>
        </div>

        <input type="hidden" name="id_user" value="1">

        <button type="submit" class="btn-submit">Simpan Resep</button>
    </form>
</body>

</html>