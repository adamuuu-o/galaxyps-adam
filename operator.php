<?php include 'inc/header.php'; ?>
<?php
$conn = new mysqli("localhost", "root", "", "rental_ps");

// Tambah operator baru
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambah'])) {
    $nama = $_POST['nama'];
    $conn->query("INSERT INTO operator (nama) VALUES ('$nama')");
    header("Location: operator.php");
    exit;
}

// Hapus operator
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $conn->query("DELETE FROM operator WHERE id_operator = '$id'");
    header("Location: operator.php");
    exit;
}

// Ambil semua operator
$result = $conn->query("SELECT * FROM operator ORDER BY id_operator ASC");
?>

<link rel="stylesheet" href="style.css">
<div class="wrapper-center">
  <div class="container">

<h2>Kelola Operator</h2>

<!-- Form Tambah Operator -->
<form method="POST" style="margin-bottom: 20px;">
  <h4>Tambah Operator</h4>
  <label>Nama Operator:</label><br>
  <input type="text" name="nama" required><br><br>
  <button type="submit" name="tambah">Tambah</button>
</form>

<!-- Tabel Operator -->
<table border="1" cellpadding="10">
  <tr>
    <th>ID</th>
    <th>Nama</th>
    <th>Aksi</th>
  </tr>
  <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
      <td><?= $row['id_operator']; ?></td>
      <td><?= $row['nama']; ?></td>
      <td>
        <a href="operator.php?hapus=<?= $row['id_operator']; ?>" onclick="return confirm('Yakin ingin hapus?')">Hapus</a>
      </td>
    </tr>
  <?php endwhile; ?>
</table>

</div>
</div>

<?php include 'inc/footer.php'; ?>
