<?php
$servername = "localhost";
$username = "root"; // default XAMPP
$password = ""; // default XAMPP kosong
$dbname = "job_mahasiswa";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>