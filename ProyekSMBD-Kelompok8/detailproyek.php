<?php
include 'php/koneksi.php';

$idProyek = $_GET['id'];
$query = "SELECT * FROM view_detail_proyek WHERE id_proyek = '$idProyek'";
$result = $koneksi->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>".$row['Id_Proyek']."</td>
                <td>".$row['Nama_Proyek']."</td>
                <td>".$row['Department']."</td>
                <td>".$row['Manager']."</td>
            </tr>";
    }
} else {
    echo "<tr><td colspan='6'>No data found</td></tr>";
}

$koneksi->close();
?>
