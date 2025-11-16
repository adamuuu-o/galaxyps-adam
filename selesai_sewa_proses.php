<?php
date_default_timezone_set("Asia/Jakarta");

$conn = new mysqli("localhost", "root", "", "rental_ps");

$id_transaksi = $_POST['id_transaksi'];
$jam_selesai = date("Y-m-d H:i:s");

// Ambil data transaksi dan harga
$q = "SELECT t.*, p.harga_per_jam, p.id_ps 
      FROM transaksi t 
      JOIN ps_unit p ON t.id_ps = p.id_ps 
      WHERE t.id_transaksi = '$id_transaksi'";
$result = $conn->query($q);
$data = $result->fetch_assoc();

// Hitung selisih menit
$mulai = strtotime($data['jam_mulai']);
$selesai = strtotime($jam_selesai);
$selisih_detik = $selesai - $mulai;
$menit_total = $selisih_detik / 60;

// Logika looping durasi otomatis dengan toleransi
$toleransi = 5; // toleransi 5 menit
$durasi_jam = 1;
$batas = 60 + $toleransi;

while ($menit_total > $batas) {
    $durasi_jam++;
    $batas += 60; // tambahkan jam berikutnya
}

$total_bayar = $durasi_jam * $data['harga_per_jam'];

// Update transaksi
$conn->query("UPDATE transaksi 
              SET jam_selesai = '$jam_selesai', total_bayar = '$total_bayar', durasi_jam = '$durasi_jam' 
              WHERE id_transaksi = '$id_transaksi'");

// Update status PS
$conn->query("UPDATE ps_unit SET status = 'tersedia' WHERE id_ps = '{$data['id_ps']}'");

// Redirect
header("Location: riwayat.php");
exit;
