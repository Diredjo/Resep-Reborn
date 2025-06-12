<?php
include '../include/db.php';
include '../include/session.php';

if (!isset($_GET['id'])) {
  echo "Resep tidak ditemukan.";
  exit;
}

$id_resep = intval($_GET['id']);
$query = mysqli_query($koneksi, "SELECT * FROM tabel_resep WHERE id_resep = $id_resep AND id_user = $user_id");

if (mysqli_num_rows($query) == 0) {
  echo "Resep tidak ditemukan atau bukan milik Anda.";
  exit;
}

$data = mysqli_fetch_assoc($query);

$isi_bahan = $data['bahan'];
$alat = '';
if (str_contains($isi_bahan, "Alat:")) {
  [$bahan, $alat] = explode("Alat:", $isi_bahan);
} else {
  $bahan = $isi_bahan;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $judul = mysqli_real_escape_string($koneksi, $_POST['judul']);
  $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
  $bahan_input = mysqli_real_escape_string($koneksi, $_POST['bahan']);
  $alat_input = mysqli_real_escape_string($koneksi, $_POST['alat']);
  $video = mysqli_real_escape_string($koneksi, $_POST['video']);
  $langkah = mysqli_real_escape_string($koneksi, $_POST['langkah']);
  $tipe = 'Makanan';

  $bahan_final = $bahan_input . "\n\nAlat: " . $alat_input;

  if (!empty($_FILES['foto']['name'])) {
    $foto = $_FILES['foto']['name'];
    $lokasi = $_FILES['foto']['tmp_name'];
    $tujuan = '../uploads/' . $foto;
    move_uploaded_file($lokasi, $tujuan);
    $update = mysqli_query($koneksi, "UPDATE tabel_resep SET judul='$judul', deskripsi='$deskripsi', bahan='$bahan_final', langkah='$langkah', video='$video', foto='$foto' WHERE id_resep=$id_resep AND id_user=$user_id");
  } else {
    $update = mysqli_query($koneksi, "UPDATE tabel_resep SET judul='$judul', deskripsi='$deskripsi', bahan='$bahan_final', langkah='$langkah', video='$video' WHERE id_resep=$id_resep AND id_user=$user_id");
  }

  if ($update) {
    header("Location: detail.php?id=$id_resep");
    exit;
  } else {
    $error = "Gagal memperbarui resep.";
  }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Edit Resep</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="shortcut icon" href="../LogoPutih.ico" type="image/x-icon">
  <link rel="stylesheet" href="../dashboard/style.css">
  <link rel="stylesheet" href="../resep/resep.css">
</head>

<body>
  <div class="sidebar" id="sidebar">
    <button class="toggle-sidebar" onclick="toggleSidebar()"><i
        class="fa-solid fa-arrows-left-right-to-line"></i></button>
    <img src="../Foto/Logoputih.png" alt="Resep Reborn" class="logo">
    <ul class="navigasi">
      <li><a href="../dashboard/Pencarian.php" class="<?= ($halaman == 'Pencarian.php') ? 'active' : '' ?>"><i
            class="fa-solid fa-search" style="margin-right: 5px;"></i> Pencarian</a></li>
      <li><a href="../dashboard/Favorit.php" class="<?= ($halaman == 'Favorit.php') ? 'active' : '' ?>"><i
            class="fa-solid fa-heart" style="margin-right: 5px;"></i> Favorit</a></li>
      <li><a href="../dashboard/Bookmark.php" class="<?= ($halaman == 'Bookmark.php') ? 'active' : '' ?>"><i
            class="fa-solid fa-bookmark" style="margin-right: 5px;"></i> Bookmark</a></li>
      <li><a href="../dashboard/Profil.php" class="<?= ($halaman == 'Profil.php') ? 'active' : '' ?>"><i
            class="fa-solid fa-user" style="margin-right: 5px;"></i> Profil</a></li>
      <li><a href="../akun/logout.php"><i class="fa-solid fa-sign-out-alt"></i> Logout</a></li>
    </ul>
    <a href="sk.html" class="SK">Baca soal Syarat & Ketentuan Kebijakaan Privasi</a>
  </div>

  <div class="konten">
    <h2>Edit Resep</h2>

    <form class="form-resep-fancy" method="post" enctype="multipart/form-data">
      <?php if (isset($error))
        echo "<div class='error'>$error</div>"; ?>

      <input type="text" name="judul" value="<?= htmlspecialchars($data['judul']) ?>" required>

      <?php if (!empty($data['foto'])): ?>
        <div class="preview-foto" style="margin-bottom: 10px;">
          <label>Foto saat ini:</label><br>
          <img src="../uploads/<?= htmlspecialchars($data['foto']) ?>" alt="Foto Resep"
            style="max-width: 200px; border-radius: 8px; display: block; margin-top: 5px;">
        </div>
      <?php endif; ?>

      <div class="form-group" style="margin-bottom: 15px;">
        <label for="foto">Ganti Foto (opsional)</label>
        <input type="file" name="foto" id="foto" accept="image/*" style="display: block; margin-top: 5px;">
      </div>


      <label for="video">Link Video YouTube (opsional)</label>
      <input type="text" name="video" id="video" value="<?= htmlspecialchars($data['video']) ?>"
        placeholder="https://www.youtube.com/watch?v=...">


      <textarea name="deskripsi" rows="3"
        placeholder="Deskripsi..."><?= htmlspecialchars($data['deskripsi']) ?></textarea>

      <div class="kotak-bahan-alat">
        <div>
          <label>Bahan</label>
          <textarea name="bahan" rows="4"><?= htmlspecialchars(trim($bahan)) ?></textarea>
        </div>
        <div>
          <label>Alat</label>
          <textarea name="alat" rows="4"><?= htmlspecialchars(trim($alat)) ?></textarea>
        </div>
      </div>

      <div class="langkah-section">
        <label>Langkah-langkah</label>
        <textarea name="langkah" rows="8"><?= htmlspecialchars($data['langkah']) ?></textarea>
      </div>

      <button type="submit" class="tombol-simpan">Simpan Perubahan</button>
    </form>

    <form method="post" action="hapus.php" onsubmit="return confirm('Yakin ingin menghapus resep ini?')">
      <input type="hidden" name="id" value="<?= $id_resep ?>">
      <button type="submit" class="hapus-resep">🗑️ Hapus Resep</button>
    </form>
  </div>
</body>

</html>