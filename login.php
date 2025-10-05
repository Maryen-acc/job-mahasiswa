<?php
include __DIR__ . '/config.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = mysqli_prepare($conn, "SELECT id, nama, password, role FROM users WHERE email = ?");
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $id, $nama, $hash, $role);
    if (mysqli_stmt_fetch($stmt)) {
        if (password_verify($password, $hash)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['nama'] = $nama;
            $_SESSION['role'] = $role;
            header('Location: index.php');
            exit;
        } else {
            $error = 'Password salah.';
        }
    } else {
        $error = 'Email tidak ditemukan.';
    }
}
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Login</title><link rel="stylesheet" href="style.css"></head><body>
<div class="auth-card">
  <h2>Login</h2>
  <?php if (!empty($error)) echo "<p class='error'>{$error}</p>"; ?>
  <form method="post">
    <input name="email" type="email" placeholder="Email" required>
    <input name="password" type="password" placeholder="Password" required>
    <button type="submit" class="btn">Login</button>
  </form>
  <p>Belum punya akun? <a href="register.php">Daftar</a></p>
</div>
</body></html>
