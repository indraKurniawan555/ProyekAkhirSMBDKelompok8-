<?php
include 'koneksi.php';

$query = "SELECT * FROM penggajian";
$result = mysqli_query($koneksi, $query);

if ($result->num_rows > 0) {
    echo '<table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID Gaji</th>
                    <th>ID Karyawan</th>
                    <th>Bulan</th>
                    <th>Tahun</th>
                    <th>Gaji Pokok</th>
                    <th>Tunjangan</th>
                    <th>Potongan</th>
                    <th>Gaji Bersih</th>
                </tr>
            </thead>
            <tbody>';
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $row["Id_Penggajian"] . '</td>';
        echo '<td>' . $row["Id_Karyawan"] . '</td>';
        echo '<td>' . $row["Bulan"] . '</td>';
        echo '<td>' . $row["Tahun"] . '</td>';
        echo '<td>' . $row["Gaji_Pokok"] . '</td>';
        echo '<td>' . $row["Tunjangan"] . '</td>';
        echo '<td>' . $row["Potongan"] . '</td>';
        echo '<td>' . $row["Gaji_Bersih"] . '</td>';
        echo '</tr>';
    }
    echo '</tbody></table>';
} else {
    echo '<tr><td colspan="8">0 results</td></tr>';
}
?>
