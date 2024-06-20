<!-- index.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Hitung Gaji Karyawan</title>
</head>
<body>
    <h1>Hitung Gaji Karyawan</h1>
    <form action="" method="POST">
        <label for="id_karyawan">ID Karyawan:</label><br>
        <input type="text" id="id_karyawan" name="id_karyawan"><br><br>

        <label for="bulan">Bulan:</label><br>
        <input type="text" id="bulan" name="bulan"><br><br>

        <label for="tahun">Tahun:</label><br>
        <input type="text" id="tahun" name="tahun"><br><br>

        <input type="submit" value="Hitung Gaji">
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        include 'php/koneksi.php'; // Include your database connection

        $id_karyawan = $_POST['id_karyawan'];
        $bulan = $_POST['bulan'];
        $tahun = $_POST['tahun'];

        $stmt = $koneksi->prepare("CALL hitung_gaji(?, ?, ?, @gaji_bersih)");
        $stmt->bind_param("iii", $id_karyawan, $bulan, $tahun);
        $stmt->execute();

        $result = $koneksi->query("SELECT @gaji_bersih as gaji_bersih");
        $row = $result->fetch_assoc();

        echo "<h2>Hasil Perhitungan Gaji</h2>";
        echo "Gaji Bersih: " . $row['gaji_bersih'];
    }
    ?>
</body>
</html>
