<?php
include __DIR__ . '/config.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (!$nama || !$email || !$password) {
        $error = 'Semua field wajib diisi.';
    } else {
        $stmt = mysqli_prepare($conn, "SELECT id FROM users WHERE email = ?");
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        if (mysqli_stmt_num_rows($stmt) > 0) {
            $error = 'Email sudah terdaftar.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = mysqli_prepare($conn, "INSERT INTO users (nama, email, password) VALUES (?, ?, ?)");
            mysqli_stmt_bind_param($stmt, 'sss', $nama, $email, $hash);
            if (mysqli_stmt_execute($stmt)) {
                header('Location: login.php');
                exit;
            } else {
                $error = 'Gagal mendaftar.';
            }
        }
    }
}
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Register</title><link rel="stylesheet" href="style.css"></head><body>
<div class="auth-card">
  <h2>Daftar Akun</h2>
  <?php if (!empty($error)) echo "<p class='error'>{$error}</p>"; ?>
  <form method="post">
    <input name="nama" placeholder="Nama lengkap" required>
    <input name="email" type="email" placeholder="Email" required>
    <input name="password" type="password" placeholder="Password" required>
    <button type="submit" class="btn">Daftar</button>
  </form>
  <p>Sudah punya akun? <a href="login.php">Login</a></p>
</div>
</body></html>
