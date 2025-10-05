<?php
include __DIR__ . '/config.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = trim($_POST['judul']);
    $deskripsi = trim($_POST['deskripsi']);
    $kategori = trim($_POST['kategori']);
    $lokasi = trim($_POST['lokasi']);
    $tipe = $_POST['tipe'];
    $gaji = floatval($_POST['gaji']);

    if (!$judul || !$deskripsi) {
        $error = 'Judul dan deskripsi wajib diisi.';
    } else {
        $stmt = mysqli_prepare($conn, "INSERT INTO jobs (user_id, judul, deskripsi, kategori, lokasi, tipe, gaji) VALUES (?, ?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, 'isssssd', $_SESSION['user_id'], $judul, $deskripsi, $kategori, $lokasi, $tipe, $gaji);
        if (mysqli_stmt_execute($stmt)) {
            header('Location: index.php');
            exit;
        } else {
            $error = 'Gagal memposting job.';
        }
    }
}
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Post Job</title><link rel="stylesheet" href="style.css"></head><body>
<div class="card">
  <h2>Post Job</h2>
  <?php if (!empty($error)) echo "<p class='error'>{$error}</p>"; ?>
  <form method="post">
    <input name="judul" placeholder="Judul pekerjaan" required>
    <textarea name="deskripsi" placeholder="Deskripsi" required></textarea>
    <input name="kategori" placeholder="Kategori (Proposal/Laporan/Coding)">
    <input name="lokasi" placeholder="Lokasi (online/kampus)">
    <select name="tipe">
      <option value="once">Sekali</option>
      <option value="part-time">Part-time</option>
      <option value="full-time">Full-time</option>
    </select>
    <input name="gaji" type="number" step="0.01" placeholder="Gaji (Rp)">
    <button type="submit" class="btn">Post</button>
  </form>
  <p><a href="index.php">Kembali</a></p>
</div>
</body></html>
