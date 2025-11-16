<?php include 'inc/header.php'; ?>
<?php
$conn = new mysqli("localhost", "root", "", "rental_ps");

// Ambil unit PS yang tersedia
$result = $conn->query("SELECT * FROM ps_unit WHERE status = 'tersedia'");
?>

<link rel="stylesheet" href="style.css">
<div class="wrapper-center">
  <div class="container">

  <h2>Mulai Sewa</h2>

    <form action="mulai_sewa_proses.php" method="POST">
      <!-- Pilih PS -->
      <label for="id_ps">Pilih PS:</label><br>
      <select name="id_ps" required>
        <option value="">-- Pilih --</option>
        <?php while($row = $result->fetch_assoc()): ?>
          <option value="<?= $row['id_ps']; ?>">
            <?= $row['tipe']; ?> - Rp <?= number_format($row['harga_per_jam']); ?>/jam
          </option>
        <?php endwhile; ?>
      </select><br><br>

      <!-- Input ID Operator -->
      <label for="id_operator">ID Operator:</label><br>
        <select name="id_operator" required>
          <option value="">-- Pilih Operator --</option>
            <?php
              $operatorQuery = $conn->query("SELECT id_operator FROM operator");
              while($op = $operatorQuery->fetch_assoc()):
            ?>
          <option value="<?= $op['id_operator']; ?>"><?= $op['id_operator']; ?></option>
            <?php endwhile; ?>
        </select><br><br>

      <!-- Durasi Bermain -->
      <label for="durasi_jam">Durasi Bermain (Jam):</label><br>
      <select name="durasi_jam" required>
        <?php for ($i = 1; $i <= 8; $i++): ?>
          <option value="<?= $i; ?>"><?= $i; ?> jam</option>
        <?php endfor; ?>
      </select><br><br>

      <button type="submit">Mulai</button>
    </form>

  </div>
</div>

<?php include 'inc/footer.php'; ?>
