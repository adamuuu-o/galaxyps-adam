<?php
date_default_timezone_set("Asia/Jakarta"); ?> // Atur zona waktu

<?php
$conn = new mysqli("localhost", "root", "", "rental_ps");

$id_ps = $_POST['id_ps'];
$id_operator = $_POST['id_operator'];
$durasi_jam = $_POST['durasi_jam'];
$jam_mulai = date("Y-m-d H:i:s");

// Simpan transaksi
$conn->query("INSERT INTO transaksi (id_ps, id_operator, jam_mulai, durasi_jam) 
              VALUES ('$id_ps', '$id_operator', '$jam_mulai', '$durasi_jam')");

// Ubah status PS jadi disewa
$conn->query("UPDATE ps_unit SET status = 'disewa' WHERE id_ps = '$id_ps'");

// Redirect
header("Location: index.php");
exit;
