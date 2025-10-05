<?php
// config.php - koneksi database
$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'mahasiswa_job';

$conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if (!$conn) {
    die('Koneksi gagal: ' . mysqli_connect_error());
}
?>