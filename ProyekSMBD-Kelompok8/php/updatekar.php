<?php
include 'koneksi.php';

$id = $_POST['Id_Karyawan'];
$nama = $_POST['nama'];
$jabatan = $_POST['jabatan'];
$departemen = $_POST['departemen'];
$tanggal_bergabung = $_POST['tanggal_bergabung'];
$gaji = $_POST['gaji'];
$kontak = $_POST['kontak'];

$query = "CALL update_karyawan($id, '$nama', '$jabatan', $departemen, '$tanggal_bergabung', $gaji, $kontak)";

if (mysqli_query($koneksi, $query)) {
    header("Location: ../karyawan.php");
} else {
    echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
}

mysqli_close($koneksi);
?>
