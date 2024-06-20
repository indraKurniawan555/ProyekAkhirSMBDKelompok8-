<?php
include 'koneksi.php';

if (isset($_POST['search'])) {
    $search = mysqli_real_escape_string($koneksi, $_POST['search']);

    $query = "CALL SearchKaryawan('$search')";
    $result = mysqli_query($koneksi, $query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["Id_Karyawan"] . "</td>";
            echo "<td>" . $row["Nama"] . "</td>";
            echo "<td>" . $row["Jabatan"] . "</td>";
            echo "<td>" . $row["Id_Departemen"] . "</td>";
            echo "<td>" . $row["Tanggal_Bergabung"] . "</td>";
            echo "<td>" . $row["Gaji"] . "</td>";
            echo "<td>" . $row["Kontak"] . "</td>";
            echo "<td><button class='btn btn-warning btn-sm editBtn' data-id='" . $row['Id_Karyawan'] . "' data-nama='" . $row['Nama'] . "' data-jabatan='" . $row['Jabatan'] . "' data-departemen='" . $row['Departemen'] . "' data-tanggal_bergabung='" . $row['Tanggal_Bergabung'] . "' data-gaji='" . $row['Gaji'] . "' data-kontak='" . $row['Kontak'] . "'>Edit</button> <button class='btn btn-danger btn-sm deleteBtn' data-id='" . $row['Id_Karyawan'] . "'>Hapus</button></td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='7'>Tidak ada hasil ditemukan</td></tr>";
    }
}
?>