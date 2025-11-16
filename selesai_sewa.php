<?php include 'inc/header.php'; ?>
<?php
$conn = new mysqli("localhost", "root", "", "rental_ps");
date_default_timezone_set("Asia/Jakarta");

// Ambil transaksi yang belum selesai
$query = "SELECT t.id_transaksi, t.jam_mulai, t.durasi_jam, p.id_ps, p.tipe 
          FROM transaksi t 
          JOIN ps_unit p ON t.id_ps = p.id_ps 
          WHERE t.jam_selesai IS NULL";
$result = $conn->query($query);
?>

<link rel="stylesheet" href="style.css">
<div class="wrapper-center">
  <div class="container">

<h2>Selesaikan Sewa</h2>

<?php if ($result->num_rows > 0): ?>
  <table border="1" cellpadding="10">
    <tr>
      <th>ID PS</th>
      <th>Tipe PS</th>
      <th>Durasi Dipilih</th>
      <th>Jam Mulai</th>
      <th>Estimasi Selesai</th>
      <th>Aksi</th>
    </tr>
    <?php while($row = $result->fetch_assoc()): ?>
      <?php
        $jam_mulai = strtotime($row['jam_mulai']);
        $durasi = $row['durasi_jam'];
        $estimasi_selesai = date("Y-m-d H:i:s", strtotime("+$durasi hour", $jam_mulai));
      ?>
      <tr>
        <td><?= $row['id_ps']; ?></td>
        <td><?= $row['tipe']; ?></td>
        <td><?= $row['durasi_jam']; ?> jam</td>
        <td><?= date("d-m-Y H:i", $jam_mulai); ?></td>
        <td><?= date("d-m-Y H:i", strtotime($estimasi_selesai)); ?></td>
        <td>
          <form action="selesai_sewa_proses.php" method="POST" style="display:inline;">
            <input type="hidden" name="id_transaksi" value="<?= $row['id_transaksi']; ?>">
            <button type="submit">Selesaikan</button>
          </form>
        </td>
      </tr>
    <?php endwhile; ?>
  </table>
<?php else: ?>
  <p>Tidak ada transaksi yang sedang berlangsung.</p>
<?php endif; ?>

</div>
</div>

<?php include 'inc/footer.php'; ?>
