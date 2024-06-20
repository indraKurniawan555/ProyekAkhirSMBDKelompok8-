<?php
include 'koneksi.php';

$id = $_POST['Id_Karyawan'];
$nama = $_POST['nama'];
$departemen = $_POST['jabatan'];
$manager = $_POST['departemen'];

$query = "UPDATE proyek
        SET Nama_Proyek = '$nama', Id_Departemen = '$departemen', Id_Karyawan = '$manager'
        WHERE Id_Proyek = $id";

if (mysqli_query($koneksi, $query)) {
    header("Location: ../proyek.php");
} else {
    echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
}

mysqli_close($koneksi);
?>
