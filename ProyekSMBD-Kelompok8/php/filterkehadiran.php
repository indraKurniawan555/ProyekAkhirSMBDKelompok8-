<?php
include 'koneksi.php';

if (isset($_GET['karyawan_id'])) {
    $karyawan_id = $_GET['karyawan_id'];

    $stmt = $koneksi->prepare("CALL Filter_Kehadiran_Karyawan(?)");
    $stmt->bind_param("i", $karyawan_id);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo '<table class="table table-bordered">';
        echo '<thead><tr><th>ID Kehadiran</th><th>ID Karyawan</th><th>Tanggal</th><th>Jam Masuk</th><th>Jam Keluar</th><th>Kehadiran</th></tr></thead>';
        echo '<tbody>';
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['Id_Kehadiran'] . '</td>';
            echo '<td>' . $row['Id_Karyawan'] . '</td>';
            echo '<td>' . $row['Tanggal'] . '</td>';
            echo '<td>' . $row['Jam_Masuk'] . '</td>';
            echo '<td>' . $row['Jam_Keluar'] . '</td>';
            echo '<td>' . $row['Status_Kehadiran'] . '</td>';
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
