<?php include 'inc/header.php'; ?>
<?php
$conn = new mysqli("localhost", "root", "", "rental_ps");

// Tambah unit baru (jika form disubmit)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambah'])) {
    $tipe = $_POST['tipe'];
    $harga = $_POST['harga_per_jam'];
    $conn->query("INSERT INTO ps_unit (tipe, harga_per_jam, status) VALUES ('$tipe', '$harga', 'tersedia')");
    header("Location: kelola_ps.php");
    exit;
}

// Hapus unit (jika tombol hapus diklik)
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $conn->query("DELETE FROM ps_unit WHERE id_ps = '$id'");
    header("Location: kelola_ps.php");
    exit;
}

// Ambil semua data PS
$result = $conn->query("SELECT * FROM ps_unit ORDER BY id_ps ASC");
?>

<link rel="stylesheet" href="style.css">
<div class="wrapper-center">
  <div class="container">

<h2>Kelola Unit PS</h2>

<!-- Form Tambah PS -->
<form method="POST" style="margin-bottom:20px;">
  <h4>Tambah Unit PS</h4>
  <label>Tipe PS:</label><br>
  <input type="text" name="tipe" required><br><br>

  <label>Harga per Jam:</label><br>
  <input type="number" name="harga_per_jam" required><br><br>

  <button type="submit" name="tambah">Tambah</button>
</form>

<!-- Tabel Data PS -->
<table border="1" cellpadding="10">
  <tr>
    <th>ID</th>
    <th>Tipe</th>
    <th>Harga per Jam</th>
    <th>Status</th>
    <th>Aksi</th>
  </tr>
  <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
      <td><?= $row['id_ps']; ?></td>
      <td><?= $row['tipe']; ?></td>
      <td>Rp <?= number_format($row['harga_per_jam']); ?></td>
      <td><?= ucfirst($row['status']); ?></td>
      <td>
        <a href="edit_ps.php?id=<?= $row['id_ps']; ?>">Edit</a> |
        <a href="kelola_ps.php?hapus=<?= $row['id_ps']; ?>" onclick="return confirm('Yakin ingin hapus?')">Hapus</a>
      </td>
    </tr>
  <?php endwhile; ?>
</table>

</div>
</div>

<?php include 'inc/footer.php'; ?>
