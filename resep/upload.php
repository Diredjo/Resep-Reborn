<?php
include '../include/db.php';
include '../include/session.php';
include '../include/animasiloding/loadingcss.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    $bahan = mysqli_real_escape_string($koneksi, $_POST['bahan']);
    $alat = mysqli_real_escape_string($koneksi, $_POST['alat']);
    $tipe = 'Makanan'; // default
    $video = mysqli_real_escape_string($koneksi, $_POST['video']);

    // Bersihkan langkah tanpa angka
    $langkah_arr = $_POST['langkah'] ?? [];
    $langkah_arr_clean = array_filter(array_map('trim', $langkah_arr));
    $langkah = implode("\n", $langkah_arr_clean);

    // Upload gambar
    $foto = $_FILES['foto']['name'];
    $lokasi = $_FILES['foto']['tmp_name'];
    $tujuan = '../uploads/' . $foto;

    if (move_uploaded_file($lokasi, $tujuan)) {
        $query = "INSERT INTO tabel_resep 
        (id_user, judul, deskripsi, bahan, langkah, foto, video, tipe)
        VALUES (
            $user_id, 
            '$judul', 
            '$deskripsi', 
            '$bahan\n\nAlat: $alat', 
            '$langkah', 
            '$foto', 
            '$video', 
            '$tipe'
        )";

        $insert = mysqli_query($koneksi, $query);

        if ($insert) {
            header("Location: ../dashboard/profil.php");
            exit;
        } else {
            $error = "Gagal menyimpan resep. Error: " . mysqli_error($koneksi);
        }
    } else {
        $error = "Gagal upload foto.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Upload Resep</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="shortcut icon" href="../LogoPutih.ico" type="image/x-icon">
    <link rel="stylesheet" href="../dashboard/style.css">
    <link rel="stylesheet" href="resep.css">
</head>

<body>
    <div class="sidebar" id="sidebar">
        <button class="toggle-sidebar" onclick="toggleSidebar()"><i class="fa-solid fa-arrows-left-right-to-line"></i></button>
        <img src="../Foto/Logoputih.png" alt="Resep Reborn" class="logo">
        <ul class="navigasi">
            <li><a href="../dashboard/Pencarian.php" class="<?= ($halaman == 'Pencarian.php') ? 'active' : '' ?>"><i class="fa-solid fa-search" style="margin-right: 5px;"></i> Pencarian</a></li>
            <li><a href="../dashboard/Favorit.php" class="<?= ($halaman == 'Favorit.php') ? 'active' : '' ?>"><i class="fa-solid fa-heart" style="margin-right: 5px;"></i> Favorit</a></li>
            <li><a href="../dashboard/Bookmark.php" class="<?= ($halaman == 'Bookmark.php') ? 'active' : '' ?>"><i class="fa-solid fa-bookmark" style="margin-right: 5px;"></i> Bookmark</a></li>
            <li><a href="../dashboard/Profil.php" class="<?= ($halaman == 'Profil.php') ? 'active' : '' ?>"><i class="fa-solid fa-user" style="margin-right: 5px;"></i> Profil</a></li>

             <?php if ($kategori === 'ADMIN'): ?>
                <li><a href="admin/data.php" class="<?= ($halaman == 'data.php') ? 'active' : '' ?>"><i class="fa-solid fa-chart-line" style="margin-right: 5px;"></i> Admin Panel</a></li>
            <?php endif; ?>
            
            <li><a href="../akun/logout.php"><i class="fa-solid fa-sign-out-alt"></i> Logout</a></li>
        </ul>
        <a href="sk.html" class="SK">Baca soal Syarat & Ketentuan Kebijakaan Privasi</a>
    </div>

    <div class="konten" id="konten">
        <div class="header">
            <a href="pencarian.php" class="tombol-home"><i class="fa-solid fa-home"></i></a>
        </div>

        <h2>Upload Resep</h2>
        <form class="form-resep-fancy" method="post" enctype="multipart/form-data">
            <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>

            <input type="text" name="judul" placeholder="Tambahkan judul..." required>

            <div class="media-upload">
                <div class="upload-area">
                    <label style="margin-bottom: 5px;">Upload video atau foto:</label>
                    <label class="upload-label">
                        <i class="fas fa-upload upload-icon"></i> Upload foto
                        <input type="file" name="foto" accept="image/*" required>
                    </label>

                    <input type="text" name="video" placeholder="Link video (opsional)">
                </div>
                <div class="profil-placeholder">
                    <p>Profil kamu akan muncul di sini</p>
                </div>
            </div>

            <textarea name="deskripsi" rows="3" placeholder="Tambahkan deskripsi..."></textarea>

            <div class="kotak-bahan-alat">
                <div>
                    <textarea name="bahan" rows="4" placeholder="Tambahkan bahan..." required></textarea>
                </div>
                <div>
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
                <button type="button" id="tambah-langkah"><i class="fa-solid fa-plus"></i></button>
            </div>

            <button type="submit" class="tombol-simpan">Simpan Resep</button>
        </form>
    </div>

    <?php include '../include/animasiloding/loadingjs.php' ?>

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
                <button type="button" class="hapus-langkah" onclick="hapusLangkah(this)">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            `;
            container.appendChild(div);
            updatePlaceholderLangkah();
        });

        updatePlaceholderLangkah();
    </script>
</body>

</html>