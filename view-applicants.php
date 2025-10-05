<?php
include __DIR__ . '/config.php';
session_start();
if (!isset($_SESSION['user_id'])) { header('Location: login.php'); exit; }
if (!isset($_GET['job_id'])) { header('Location: dashboard.php'); exit; }

$job_id = (int) $_GET['job_id'];
// pastikan job milik user
$stmt = mysqli_prepare($conn, "SELECT id, judul FROM jobs WHERE id = ? AND user_id = ?");
mysqli_stmt_bind_param($stmt, 'ii', $job_id, $_SESSION['user_id']);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);
if (mysqli_stmt_num_rows($stmt) == 0) {
    $_SESSION['msg'] = 'Job tidak ditemukan atau bukan milik Anda.';
    header('Location: dashboard.php');
    exit;
}

// ambil pelamar
$stmt = mysqli_prepare($conn, "SELECT a.id, a.status, u.nama, u.email FROM applications a JOIN users u ON a.user_id = u.id WHERE a.job_id = ?");
mysqli_stmt_bind_param($stmt, 'i', $job_id);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);

// proses accept/reject
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['app_id'], $_POST['action'])) {
    $app_id = (int) $_POST['app_id'];
    $action = $_POST['action'] === 'accept' ? 'accepted' : 'rejected';
    $stmt = mysqli_prepare($conn, "UPDATE applications SET status = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'si', $action, $app_id);
    mysqli_stmt_execute($stmt);
    // jika accept, update job status menjadi in_progress
    if ($action === 'accepted') {
        $stmt2 = mysqli_prepare($conn, "UPDATE jobs SET status = 'in_progress' WHERE id = ?");
        mysqli_stmt_bind_param($stmt2, 'i', $job_id);
        mysqli_stmt_execute($stmt2);
    }
    header('Location: view-applicants.php?job_id=' . $job_id);
    exit;
}
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Pelamar</title><link rel="stylesheet" href="style.css"></head><body>
<div class="container">
  <h2>Pelamar untuk Job #<?= $job_id ?></h2>
  <p><a href="dashboard.php">Kembali</a></p>
  <?php while ($row = mysqli_fetch_assoc($res)): ?>
    <div class="card small">
      <strong><?=htmlspecialchars($row['nama'])?></strong> (<?=htmlspecialchars($row['email'])?>) | Status: <?= $row['status'] ?>
      <form method="post" style="display:inline">
        <input type="hidden" name="app_id" value="<?= $row['id'] ?>">
        <button name="action" value="accept" class="btn small">Accept</button>
        <button name="action" value="reject" class="btn small outline">Reject</button>
      </form>
    </div>
  <?php endwhile; ?>
</div>
</body></html>
