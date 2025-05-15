<?php
include '../../include/db.php';
include '../../include/session.php';
include 'navbar.php';

$table = $_GET['table'];
$id = $_GET['id'];
$id_field = 'id_' . explode('_', $table)[1];

$result = mysqli_query($conn, "SELECT * FROM $table WHERE $id_field = $id");
$data = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $updateFields = '';
    foreach ($_POST as $key => $value) {
        $value = mysqli_real_escape_string($conn, $value);
        $updateFields .= "$key='$value', ";
    }
    $updateFields = rtrim($updateFields, ', ');
    mysqli_query($conn, "UPDATE $table SET $updateFields WHERE $id_field = $id");
    header("Location: data.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Resep</title>
    <link rel="stylesheet" href="../../css/data.css">
</head>
<body>
    <form method="post">
        <?php foreach ($data as $key => $value): ?>
            <?php if ($key != $id_field): ?>
                <label><?= $key ?>:</label>
                <input type="text" name="<?= $key ?>" value="<?= $value ?>"><br>
            <?php endif; ?>
        <?php endforeach; ?>
        <button type="submit">Update</button>
    </form>
</body>
</html>
