<?php
include 'koneksi.php';

$id = $_POST['Id_Penjualan'];
$tanggal = $_POST['tanggal'];
$produk = $_POST['produk'];
$jumlah = $_POST['jumlah'];
$nama = $_POST['nama'];
$total = $_POST['total'];

$query = "UPDATE penjualan
SET Id_Karyawan = $nama,
    Produk_Penjualan = '$produk', 
    Tanggal_Penjualan = '$tanggal', 
    Jumlah = $jumlah, 
    Total_Harga = $total
WHERE Id_Penjualan = $id";

echo $id, $tanggal, $produk, $jumlah, $nama, $total;

if (mysqli_query($koneksi, $query)) {
    header("Location: ../penjualan.php");
} else {
    echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
}

mysqli_close($koneksi);
?>
