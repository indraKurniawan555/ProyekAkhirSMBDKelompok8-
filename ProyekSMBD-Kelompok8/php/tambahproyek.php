<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $Id_Department = $_POST['Id_Department'];
    $Id_Karyawan = $_POST['Id_Karyawan'];
    $Nama_Proyek = $_POST['Nama_Proyek'];
    $Deskripsi = $_POST['Deskripsi'];
    $Tanggal_Mulai = $_POST['Tanggal_Mulai'];
    $Tanggal_Selesai = $_POST['Tanggal_Selesai'];
    $Anggaran = $_POST['Anggaran'];

    $query = "INSERT INTO proyek (Id_Departemen, Id_Karyawan, Nama_Proyek, Deskripsi, Tanggal_Mulai, Tanggal_Selesai, Anggaran) 
            VALUES ('$Id_Department', '$Id_Karyawan', '$Nama_Proyek', '$Deskripsi', '$Tanggal_Mulai', '$Tanggal_Selesai', '$Anggaran')";

    if ($koneksi->query($query) === TRUE) {
        header("Location: ../proyek.php");
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }

    $koneksi->close();
}
?>
