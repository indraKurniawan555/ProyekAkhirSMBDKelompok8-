<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "CALL hapus_karyawan($id);";

    if (mysqli_query($koneksi, $query)) {
        header("Location: ../karyawan.php");
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
    }
} else {
    echo "Error: 'id' parameter is missing.";
}

mysqli_close($koneksi);
?>
