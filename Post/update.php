<?php
include '../db.php';
$id_resep = $_GET['id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul'];
    $bahan = $_POST['bahan'];
    $langkah = $_POST['langkah'];
    
    $sql = "UPDATE tabel_resep SET judul='$judul', bahan='$bahan', langkah='$langkah' WHERE id_resep='$id_resep'";
    if ($conn->query($sql) === TRUE) {
        header('Location: read.php');
    } else {
        echo "Error: " . $conn->error;
    }
}
$sql = "SELECT * FROM tabel_resep WHERE id_resep='$id_resep'";
$result = $conn->query($sql);
$resep = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Resep</title>
    <link href="FotoDSB/LogoPutih.png" rel='shorcut icon'>
</head>
<body>
    <h2>Edit Resep</h2>
    <form method="post">
        <input type="text" name="judul" value="<?php echo $resep['judul']; ?>" required>
        <textarea name="bahan" required><?php echo $resep['bahan']; ?></textarea>
        <textarea name="langkah" required><?php echo $resep['langkah']; ?></textarea>
        <button type="submit">Update</button>
    </form>
</body>
</html>