<?php
include __DIR__ . '/config.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
if (!isset($_GET['job_id'])) {
    header('Location: index.php');
    exit;
}
$job_id = (int) $_GET['job_id'];
$user_id = $_SESSION['user_id'];

$stmt = mysqli_prepare($conn, "SELECT id FROM applications WHERE job_id = ? AND user_id = ?");
mysqli_stmt_bind_param($stmt, 'ii', $job_id, $user_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);
if (mysqli_stmt_num_rows($stmt) > 0) {
    $_SESSION['msg'] = 'Anda sudah pernah apply.';
    header('Location: index.php');
    exit;
}

$stmt = mysqli_prepare($conn, "INSERT INTO applications (job_id, user_id) VALUES (?, ?)");
mysqli_stmt_bind_param($stmt, 'ii', $job_id, $user_id);
if (mysqli_stmt_execute($stmt)) {
    $_SESSION['msg'] = 'Berhasil apply job.';
}
header('Location: index.php');
