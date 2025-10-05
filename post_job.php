<?php
include "koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = $_POST['judul'];
    $gaji = $_POST['gaji'];
    $kategori = $_POST['kategori'];
    $laporan = $_POST['laporan'];
    $nohp = $_POST['nohp'];
    $email = $_POST['email'];
    $whatsapp = $_POST['whatsapp'];
    $email_contact = $_POST['email_contact'];
    $ewallet = $_POST['ewallet'];

    $sql = "INSERT INTO jobs (judul, gaji, kategori, laporan, nohp, email, whatsapp, email_contact, ewallet) 
            VALUES ('$judul','$gaji','$kategori','$laporan','$nohp','$email','$whatsapp','$email_contact','$ewallet')";

    if (mysqli_query($conn, $sql)) {
        echo "Job berhasil diposting! <a href='index.php'>Lihat Job</a>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Post Job</title>
</head>
<body>
    <h2>Tambah Job Baru</h2>
    <form method="POST">
        <label>Judul:</label><br>
        <input type="text" name="judul" required><br><br>

        <label>Gaji:</label><br>
        <input type="number" name="gaji" required><br><br>

        <label>Kategori:</label><br>
        <input type="text" name="kategori" placeholder="Proposal/Laporan/Coding" required><br><br>

        <label>Deskripsi / Laporan:</label><br>
        <textarea name="laporan" required></textarea><br><br>

        <label>No. HP:</label><br>
        <input type="text" name="nohp"><br><br>

        <label>Email:</label><br>
        <input type="email" name="email"><br><br>

        <label>No. WhatsApp:</label><br>
        <input type="text" name="whatsapp" required><br><br>

        <label>Email Kontak:</label><br>
        <input type="email" name="email_contact" required><br><br>

        <label>Pembayaran via E-Wallet (Dana/OVO/GoPay, dll):</label><br>
        <input type="text" name="ewallet"><br><br>

        <button type="submit">Posting</button>
    </form>
</body>
</html>