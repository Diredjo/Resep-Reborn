<?php
include '../include/db.php';
include '../include/session.php';
include '../include/animasiloding/loadingcss.php';

$query = mysqli_query($koneksi, "SELECT * FROM tabel_user WHERE id_user = $user_id");
$user = mysqli_fetch_assoc($query);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = mysqli_real_escape_string($koneksi, $_POST['username']);
  $bio = mysqli_real_escape_string($koneksi, $_POST['bio']);

  if (!empty($_FILES['foto']['name'])) {
    $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
    $timestamp = date('Ymd_His');
    $nama_baru = "pp_" . strtolower(preg_replace("/[^a-zA-Z0-9]/", "", $username)) . "_" . $timestamp . "." . $ext;
    $target = "../uploads/profil/" . $nama_baru;

    if (move_uploaded_file($_FILES['foto']['tmp_name'], $target)) {
      if (!empty($user['fotoprofil']) && file_exists("../uploads/profil/" . $user['fotoprofil'])) {
        unlink("../uploads/profil/" . $user['fotoprofil']);
      }
      $update = mysqli_query($koneksi, "UPDATE tabel_user SET username='$username', bio='$bio', fotoprofil='$nama_baru' WHERE id_user=$user_id");
    } else {
      $error = "Gagal mengunggah foto.";
    }
  } else {
    $update = mysqli_query($koneksi, "UPDATE tabel_user SET username='$username', bio='$bio' WHERE id_user=$user_id");
  }

  if (isset($update) && $update) {
    header("Location: profil.php");
    exit;
  } else {
    $error = isset($error) ? $error : "Gagal memperbarui profil.";
  }
}

$halaman = 'profil.php';

?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Edit Profil</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="stylesheet" href="style.css">
  <link rel="shortcut icon" href="../LogoPutih.ico" type="image/x-icon">
  <style>
    .form-edit {
      background-color: #2a2a2a;
      padding: 30px;
      border-radius: 10px;
      max-width: 500px;
      margin: 40px auto;
    }

    .form-edit label {
      display: block;
      margin-bottom: 8px;
      font-weight: bold;
    }

    .form-edit input[type="text"],
    .form-edit textarea {
      width: 100%;
      padding: 10px;
      border: none;
      margin-bottom: 15px;
      border-radius: 5px;
      font-size: 14px;
    }

    .form-edit input[type="file"] {
      margin-bottom: 15px;
    }

    .form-edit button {
      background-color: #ff6f00;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 20px;
      cursor: pointer;
      font-size: 14px;
    }

    .form-edit .foto-preview {
      width: 80px;
      height: 80px;
      object-fit: cover;
      border-radius: 50%;
      margin-bottom: 10px;
    }

    .error {
      color: red;
      margin-bottom: 10px;
    }
  </style>
</head>

<body>
  <div class="sidebar" id="sidebar">
    <button class="toggle-sidebar" onclick="toggleSidebar()"><i class="fa-solid fa-arrows-left-right-to-line"></i></button>
    <img src="../Foto/Logoputih.png" alt="Resep Reborn" class="logo">
    <ul class="navigasi">
      <li><a href="Pencarian.php" class="<?= ($halaman == 'Pencarian.php') ? 'active' : '' ?>"><i class="fa-solid fa-search" style="margin-right: 5px;"></i> Pencarian</a></li>
      <li><a href="Favorit.php" class="<?= ($halaman == 'Favorit.php') ? 'active' : '' ?>"><i class="fa-solid fa-heart" style="margin-right: 5px;"></i> Favorit</a></li>
      <li><a href="Bookmark.php" class="<?= ($halaman == 'Bookmark.php') ? 'active' : '' ?>"><i class="fa-solid fa-bookmark" style="margin-right: 5px;"></i> Bookmark</a></li>
      <li><a href="Profil.php" class="<?= ($halaman == 'Profil.php') ? 'active' : '' ?>"><i class="fa-solid fa-user" style="margin-right: 5px;"></i> Profil</a></li>

       <?php if ($kategori === 'ADMIN'): ?>
                <li><a href="admin/data.php" class="<?= ($halaman == 'data.php') ? 'active' : '' ?>"><i class="fa-solid fa-chart-line" style="margin-right: 5px;"></i> Admin Panel</a></li>
            <?php endif; ?>
            
      <li><a href="../akun/logout.php"><i class="fa-solid fa-sign-out-alt"></i> Logout</a></li>
    </ul>
    <a href="sk.html" class="SK">Baca soal Syarat & Ketentuan Kebijakaan Privasi</a>
  </div>

  <div class="konten" id="konten">
    <h2>Edit Profil</h2>

    <form class="form-edit" method="post" enctype="multipart/form-data">
      <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>

      <label for="username">Username</label>
      <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>

      <label for="bio">Bio</label>
      <textarea name="bio" rows="4"><?= htmlspecialchars($user['bio']) ?></textarea>

      <label>Foto Profil</label>
      <?php if (!empty($user['fotoprofil'])): ?>
        <img src="../uploads/profil/<?= htmlspecialchars($user['fotoprofil']) ?>" class="foto-preview">
      <?php endif; ?>
      <input type="file" name="foto" accept="image/*">

      <button type="submit">Simpan Perubahan</button>
    </form>
  </div>

  <?php include '../include/animasiloding/loadingjs.php' ?>

</body>

</html>