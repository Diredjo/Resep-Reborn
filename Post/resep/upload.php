<?php
include '../../include/db.php';
include '../../include/session.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    $bahan = mysqli_real_escape_string($koneksi, $_POST['bahan']);
    $alat = mysqli_real_escape_string($koneksi, $_POST['alat']);
    $tipe = 'Makanan'; // default
    $video = mysqli_real_escape_string($koneksi, $_POST['video']);

    // Gabung semua langkah jadi 1 teks dengan nomor urut
    $langkah_arr = $_POST['langkah'] ?? [];
    $langkah = '';
    foreach ($langkah_arr as $index => $isi) {
        $nomor = $index + 1;
        $langkah .= "$nomor. " . trim($isi) . "\n";
    }

    // Upload foto
    $foto = $_FILES['foto']['name'];
    $lokasi = $_FILES['foto']['tmp_name'];
    $tujuan = '../../uploads/' . $foto;
    move_uploaded_file($lokasi, $tujuan);

    $insert = mysqli_query($koneksi, "INSERT INTO tabel_resep 
        (id_user, judul, deskripsi, bahan, langkah, foto, video, tipe)
        VALUES ($user_id, '$judul', '$deskripsi', '$bahan\n\nAlat: $alat', '$langkah', '$foto', '$video', '$tipe')");

    if ($insert) {
        header("Location: ../../dashboard/profil.php");
        exit;
    } else {
        $error = "Gagal menyimpan resep.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Upload Resep</title>
    <link rel="stylesheet" href="../../css/dashboard.css">
    <link rel="stylesheet" href="../../css/resep.css">
</head>

<body>
    <div class="sidebar">
        <div class="logo">Resep<br>Reborn</div>
        <ul class="navigasi">
            <li><a href="../../dashboard/pencarian.php">Pencarian</a></li>
            <li><a href="favorit.php">Favorit</a></li>
            <li><a href="bookmark.php">Bookmark</a></li>
            <li><a href="profil.php">Profil</a></li>
            <li><a href="../akun/logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="konten">
        <h2>Upload Resep</h2>
        <form class="form-resep-fancy" method="post" enctype="multipart/form-data">
            <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>

            <input type="text" name="judul" placeholder="Tambahkan judul..." required>

            <div class="media-upload">
                <div class="upload-area">
                    <label>Upload video atau foto:</label>
                    <input type="file" name="foto" accept="image/*" required>
                    <input type="text" name="video" placeholder="Link video (opsional)">
                </div>
                <div class="profil-placeholder">
                    <p>Profil kamu akan muncul di sini</p>
                </div>
            </div>

            <textarea name="deskripsi" rows="3" placeholder="Tambahkan deskripsi..."></textarea>

            <div class="kotak-bahan-alat">
                <div>
                    <label>Bahan</label>
                    <textarea name="bahan" rows="4" placeholder="Tambahkan bahan..." required></textarea>
                </div>
                <div>
                    <label>Alat</label>
                    <textarea name="alat" rows="4" placeholder="Tambahkan alat..."></textarea>
                </div>
            </div>

            <div class="langkah-section">
                <label>Langkah-langkah</label>
                <div id="langkah-container">
                    <div class="langkah-item">
                        <input type="text" name="langkah[]" placeholder="Langkah 1">
                    </div>
                </div>
                <button type="button" id="tambah-langkah">+ Tambah urutan</button>
            </div>

            <button type="submit" class="tombol-simpan">Simpan Resep</button>
        </form>
    </div>

    <script>
        function updatePlaceholderLangkah() {
            const langkahInputs = document.querySelectorAll('#langkah-container .langkah-item input');
            langkahInputs.forEach((input, i) => {
                input.placeholder = `Langkah ${i + 1}`;
            });
        }

        function hapusLangkah(elem) {
            elem.parentElement.remove();
            updatePlaceholderLangkah();
        }

        document.getElementById('tambah-langkah').addEventListener('click', function() {
            const container = document.getElementById('langkah-container');
            const div = document.createElement('div');
            div.className = 'langkah-item';
            div.innerHTML = `
    <input type="text" name="langkah[]" placeholder="Langkah">
    <button type="button" class="hapus-langkah" onclick="hapusLangkah(this)">❌</button>
  `;
            container.appendChild(div);
            updatePlaceholderLangkah();
        });

        updatePlaceholderLangkah();
    </script>
</body>

</html>