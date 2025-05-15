<?php
session_start();
$message = isset($_SESSION['register_message']) ? $_SESSION['register_message'] : "";
unset($_SESSION['register_message']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="FotoDSB/LogoPutih.png" rel='shorcut icon'>
    <link rel="stylesheet" href="style.css">
    <script>
        function closeModal() {
            document.getElementById('successModal').style.display = 'none';
            window.location.href = 'login.php';
        }
        window.onload = function() {
            let modal = document.getElementById('successModal');
            if (modal) {
                modal.style.display = 'block';
                setTimeout(closeModal, 3000);
            }
        };
    </script>
</head>

<body>
    <div class="login-container">
        <img src="../Foto/LogoMiring.png" alt="Resep Reborn Logo" class="logo">
        <form action="register_process.php" method="POST">
            <input type="text" name="username" placeholder="Username" required value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>">
            <input type="email" name="email" placeholder="Email" required value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
            <input type="password" name="password" placeholder="Password" required>
            <select name="kategori" required>
                <option value="user" <?= isset($_POST['kategori']) && $_POST['kategori'] == "user" ? "selected" : "" ?>>User</option>
                <option value="admin" <?= isset($_POST['kategori']) && $_POST['kategori'] == "admin" ? "selected" : "" ?>>Admin</option>
            </select>
            <button type="submit">Register</button>
        </form>
        <p>Sudah memiliki akun? <a href="login.php">Login di sini</a></p>
    </div>

    <?php if ($message): ?>
        <div id="successModal" class="modal">
            <div class="modal-content">
                <p><?= $message; ?></p>
                <p>Anda akan dialihkan ke login...</p>
            </div>
        </div>
    <?php endif; ?>
</body>

</html>