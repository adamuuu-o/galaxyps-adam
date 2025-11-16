<?php include 'inc/header.php'; ?>
<?php
$conn = new mysqli("localhost", "root", "", "rental_ps");
date_default_timezone_set("Asia/Jakarta");

// Ambil transaksi yang sudah selesai, urutkan dari yang paling lama
$query = "SELECT t.*, p.tipe, o.nama AS operator_nama
          FROM transaksi t 
          JOIN ps_unit p ON t.id_ps = p.id_ps
          JOIN operator o ON t.id_operator = o.id_operator
          WHERE t.jam_selesai IS NOT NULL
          ORDER BY t.jam_mulai ASC";
$result = $conn->query($query);
?>

<link rel="stylesheet" href="style.css">
<div class="wrapper-center">
  <div class="container">

    <h2>Riwayat Transaksi</h2>

    <?php if ($result->num_rows > 0): ?>
      <table border="1" cellpadding="10">
        <tr>
          <th>No</th>
          <th>Tanggal</th>
          <th>PS</th>
          <th>Operator</th>
          <th>Jam Mulai</th>
          <th>Jam Selesai</th>
          <th>Durasi</th>
          <th>Total Bayar</th>
        </tr>
        <?php $no = 1; while($row = $result->fetch_assoc()): ?>
          <?php
            // Hitung durasi
            $mulai = strtotime($row['jam_mulai']);
            $selesai = strtotime($row['jam_selesai']);
            $selisih_detik = $selesai - $mulai;
            $total_menit = round($selisih_detik / 60);

            $jam = floor($total_menit / 60);
            $menit = $total_menit % 60;

            $durasi_tampil = "";
            if ($jam > 0) {
              $durasi_tampil .= $jam . " jam";
            }
            if ($menit > 0) {
              $durasi_tampil .= " " . $menit . " menit";
            }
            if ($durasi_tampil === "") {
              $durasi_tampil = "0 menit";
            }
          ?>
          <tr>
            <td><?= $no++; ?></td>
            <td><?= date('d-m-Y', strtotime($row['jam_mulai'])); ?></td>
            <td><?= $row['tipe']; ?></td>
            <td><?= $row['operator_nama']; ?></td>
            <td><?= date('H:i', strtotime($row['jam_mulai'])); ?></td>
            <td><?= date('H:i', strtotime($row['jam_selesai'])); ?></td>
            <td><?= $durasi_tampil; ?></td>
            <td>Rp <?= number_format($row['total_bayar']); ?></td>
          </tr>
        <?php endwhile; ?>
      </table>
    <?php else: ?>
      <p>Tidak ada transaksi yang selesai.</p>
    <?php endif; ?>

  </div>
</div>

<?php include 'inc/footer.php'; ?>
