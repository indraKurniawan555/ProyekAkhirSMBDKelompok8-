<?php
include 'koneksi.php';

if (isset($_GET['karyawan_id'])) {
    $karyawan_id = $_GET['karyawan_id'];

    $stmt = $koneksi->prepare("CALL Filter_Penggajian_Karyawan(?)");
    $stmt->bind_param("i", $karyawan_id);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo '<table class="table table-bordered">';
        echo '<thead><tr><th>ID Gaji</th><th>ID Karyawan</th><th>Bulan</th><th>Tahun</th><th>Gaji Pokok</th><th>Tunjangan</th><th>Potongan</th><th>Gaji Bersih</th></tr></thead>';
        echo '<tbody>';
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['Id_Penggajian'] . '</td>';
            echo '<td>' . $row['Id_Karyawan'] . '</td>';
            echo '<td>' . $row['Bulan'] . '</td>';
            echo '<td>' . $row['Tahun'] . '</td>';
            echo '<td>' . $row['Gaji_Pokok'] . '</td>';
            echo '<td>' . $row['Tunjangan'] . '</td>';
            echo '<td>' . $row['Potongan'] . '</td>';
            echo '<td>' . $row['Gaji_Bersih'] . '</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<p>No records found.</p>';
    }

    $stmt->close();
}
?>
