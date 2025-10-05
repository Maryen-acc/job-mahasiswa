<?php
include __DIR__ . '/config.php';
session_start();

$where = [];
if (!empty($_GET['keyword'])) {
    $k = mysqli_real_escape_string($conn, $_GET['keyword']);
    $where[] = "judul LIKE '%$k%'";
}
if (!empty($_GET['kategori'])) {
    $c = mysqli_real_escape_string($conn, $_GET['kategori']);
    $where[] = "kategori = '$c'";
}

$sql = 'SELECT j.*, u.nama as poster FROM jobs j JOIN users u ON j.user_id = u.id';
if (count($where) > 0) {
    $sql .= ' WHERE ' . implode(' AND ', $where);
}
$sql .= ' ORDER BY created_at DESC';
$res = mysqli_query($conn, $sql);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Job Mahasiswa</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<header class="topbar">
  <h1>Job Mahasiswa - Portal</h1>
  <nav>
    <?php if (!empty($_SESSION['nama'])): ?>
      <span>Halo, <?=htmlspecialchars($_SESSION['nama'])?></span>
      <a href="post-job.php">Post Job</a>
      <a href="dashboard.php">Dashboard</a>
      <a href="logout.php">Logout</a>
    <?php else: ?>
      <a href="login.php">Login</a>
      <a href="register.php">Register</a>
    <?php endif; ?>
  </nav>
</header>

<main class="container">
  <section class="filter">
    <form method="get">
      <input name="keyword" placeholder="Cari judul atau kata kunci...">
      <input name="kategori" placeholder="Kategori (Proposal/Laporan/Coding)">
      <button type="submit">Cari</button>
    </form>
  </section>

  <?php if (!empty($_SESSION['msg'])) { echo '<p class="msg">'. $_SESSION['msg'] .'</p>'; unset($_SESSION['msg']); } ?>

  <section class="jobs">
    <?php if (mysqli_num_rows($res) == 0): ?>
      <p>Tidak ada job ditemukan.</p>
    <?php endif; ?>
    <?php while ($row = mysqli_fetch_assoc($res)) : ?>
      <article class="job-card">
        <h2><?=htmlspecialchars($row['judul'])?></h2>
        <p class="meta">Poster: <?=htmlspecialchars($row['poster'])?> | Gaji: Rp <?=number_format($row['gaji'],0,',','.')?> | <?=htmlspecialchars($row['kategori'])?></p>
        <p><?=nl2br(htmlspecialchars($row['deskripsi']))?></p>
        <p><a class="btn" href="apply-job.php?job_id=<?= $row['id'] ?>">Apply</a></p>
      </article>
    <?php endwhile; ?>
  </section>
</main>

<footer class="footer">
  <p>&copy; <?=date('Y')?> Portal Job Mahasiswa</p>
</footer>
</body>
</html>
