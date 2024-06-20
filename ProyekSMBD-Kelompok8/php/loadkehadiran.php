<?php
include 'koneksi.php';

$query = "SELECT * FROM kehadiran";
$result = mysqli_query($koneksi, $query);

if ($result->num_rows > 0) {
    echo '<table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID Kehadiran</th>
                    <th>ID Karyawan</th>
                    <th>Tanggal</th>
                    <th>Jam Masuk</th>
                    <th>Jam Keluar</th>
                    <th>Kehadiran</th>
                </tr>
            </thead>
            <tbody>';
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $row["Id_Kehadiran"] . '</td>';
        echo '<td>' . $row["Id_Karyawan"] . '</td>';
        echo '<td>' . $row["Tanggal"] . '</td>';
        echo '<td>' . $row["Jam_Masuk"] . '</td>';
        echo '<td>' . $row["Jam_Keluar"] . '</td>';
        echo '<td>' . $row["Status_Kehadiran"] . '</td>';
        echo '</tr>';
    }
    echo '</tbody></table>';
} else {
    echo '<tr><td colspan="6">0 results</td></tr>';
}
?>
