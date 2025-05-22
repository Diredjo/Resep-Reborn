<?php
include '../include/db.php';
include '../include/session.php';

$jumlah_bahan = isset($_GET['bahan']) ? max(1, (int) $_GET['bahan']) : 2;
$jumlah_langkah = isset($_GET['langkah']) ? max(1, (int) $_GET['langkah']) : 2;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $kategori = $_POST['kategori'];
    $tipe = $_POST['tipe'];
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

    $sql = "INSERT INTO tabel_resep (id_user, judul, deskripsi, bahan, langkah, kategori, foto, video, tipe)
            VALUES ('$id_user', '$judul', '$deskripsi', '', '', '$kategori', '$foto', '$video', '$tipe')";
    $query = mysqli_query($conn, $sql);

    if ($query) {
        $id_resep = mysqli_insert_id($conn);

        // Simpan bahan
        foreach ($_POST['bahan'] as $isi_bahan) {
            $isi_bahan = trim($isi_bahan);
            if (!empty($isi_bahan)) {
                $isi_bahan = mysqli_real_escape_string($conn, $isi_bahan);
                mysqli_query($conn, "INSERT INTO bahan_resep (id_resep, isi_bahan) VALUES ('$id_resep', '$isi_bahan')");
            }
        }

        // Simpan langkah
        $urutan = 1;
        foreach ($_POST['langkah'] as $isi_langkah) {
            $isi_langkah = trim($isi_langkah);
            if (!empty($isi_langkah)) {
                $isi_langkah = mysqli_real_escape_string($conn, $isi_langkah);
                mysqli_query($conn, "INSERT INTO langkah_resep (id_resep, urutan, isi_langkah) VALUES ('$id_resep', '$urutan', '$isi_langkah')");
                $urutan++;
            }
        }

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
    <meta charset="UTF-8">
    <title>Buat Resep Baru</title>
    <link rel="stylesheet" href="../css/post.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="shortcut icon" href="FotoDSB/LogoPutih.png">
</head>

<body class="create">
    <?php include "navbar.php"; ?>
    <h2 class="form-title">Buat Resep Baru</h2>

    <form action="create.php?bahan=<?= $jumlah_bahan ?>&langkah=<?= $jumlah_langkah ?>" method="POST"
        enctype="multipart/form-data" class="form-resep">
        <label class="form-label">Judul:</label>
        <input type="text" name="judul" required class="form-input">

        <label class="form-label">Deskripsi:</label>
        <input type="text" name="deskripsi" required class="form-input">


        <label class="form-label" id="form-bahan">Bahan:</label>
        <div id="input-bahan">
            <?php for ($i = 0; $i < $jumlah_bahan; $i++): ?>
                <input type="text" name="bahan[]" class="form-input" <?= $i == 0 ? "required" : "" ?>>
            <?php endfor; ?>
        </div>
        <div><button type="button" class="form-link" onclick="tambahBahan()">+ Tambah Bahan</button></div>

        <label class="form-label">Langkah-langkah:</label>
        <?php for ($i = 0; $i < $jumlah_langkah; $i++): ?>
            <input type="text" name="langkah[]" class="form-input" <?= $i == 0 ? "required" : "" ?>>
        <?php endfor; ?>
        <div><button href="?bahan=<?= $jumlah_bahan ?>&langkah=<?= $jumlah_langkah + 1 ?>" class="form-link">+ Tambah
                Langkah</button></div>

        <label class="form-label">Foto (Wajib):</label>
        <input type="file" name="foto" accept="image/*" required class="form-file">

        <label class="form-label">Video (Opsional):</label>
        <input type="file" name="video" accept="video/*" class="form-file">

        <label class="form-label">Tipe:</label><br>
        <div class="kategori-radio">
            <label><input type="radio" name="tipe" value="Makanan" required> Makanan</label><br>
            <label><input type="radio" name="tipe" value="Minuman"> Minuman</label><br>
            <label><input type="radio" name="tipe" value="Camilan"> Camilan</label><br>
        </div>

        <label class="form-label">Kategori:</label><br>
        <div class="kategori-checkbox">
            <label><input type="checkbox" name="kategori" value="Fermentasi"> Fermentasi</label><br>
            <label><input type="checkbox" name="kategori" value="Pengeringan"> Pengeringan</label><br>
            <label><input type="checkbox" name="kategori" value="Pemanisan"> Pemanisan</label><br>
            <label><input type="checkbox" name="kategori" value="Pengasapan"> Pengasapan</label><br>
            <label><input type="checkbox" name="kategori" value="Penepungan"> Penepungan</label><br>
            <label><input type="checkbox" name="kategori" value="Pembekuan"> Pembekuan</label><br>
            <label><input type="checkbox" name="kategori" value="Inovasi_limbah"> Inovasi Limbah</label><br>
            <label><input type="checkbox" name="kategori" value="Pengawetan"> Pengawetan</label><br>
        </div>

        <button type="submit" class="btn-submit">Simpan Resep</button>
    </form>

    <script>
        function tambahBahan() {
            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'langkah[]';
            input.className = 'form-input';
            input.required = true;

            const parentElement = document.getElementById('input-bahan');
            parentElement.insertBefore(input, parentElement.children[parentElement.children.length]);

            console.log(parentElement.children.length);

        }
    </script>
</body>

</html>