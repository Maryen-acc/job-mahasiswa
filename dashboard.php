<?php
include __DIR__ . '/config.php';
session_start();
if (!isset($_SESSION['user_id'])) { header('Location: login.php'); exit; }
$user_id = $_SESSION['user_id'];

// jobs yang diposting user
$stmt = mysqli_prepare($conn, "SELECT id, judul, status, created_at FROM jobs WHERE user_id = ? ORDER BY created_at DESC");
mysqli_stmt_bind_param($stmt, 'i', $user_id);
mysqli_stmt_execute($stmt);
$res_jobs = mysqli_stmt_get_result($stmt);
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Dashboard</title><link rel="stylesheet" href="style.css"></head><body>
<div class="container">
  <h2>Dashboard</h2>
  <p><a href="index.php">Kembali ke daftar job</a></p>

  <h3>Jobs yang kamu posting</h3>
  <?php while ($job = mysqli_fetch_assoc($res_jobs)): ?>
    <div class="card small">
      <strong><?=htmlspecialchars($job['judul'])?></strong> | <?= $job['status'] ?>
      <p><a href="view-applicants.php?job_id=<?= $job['id'] ?>">Lihat Pelamar</a></p>
    </div>
  <?php endwhile; ?>

  <h3>Jobs yang kamu apply</h3>
  <?php
  $stmt2 = mysqli_prepare($conn, "SELECT a.status AS app_status, j.judul, j.id FROM applications a JOIN jobs j ON a.job_id = j.id WHERE a.user_id = ? ORDER BY a.created_at DESC");
  mysqli_stmt_bind_param($stmt2, 'i', $user_id);
  mysqli_stmt_execute($stmt2);
  $res_apply = mysqli_stmt_get_result($stmt2);
  while ($r = mysqli_fetch_assoc($res_apply)): ?>
    <div class="card small">
      <strong><?=htmlspecialchars($r['judul'])?></strong> | Status apply: <?= $r['app_status'] ?>
    </div>
  <?php endwhile; ?>
</div>
</body></html>
