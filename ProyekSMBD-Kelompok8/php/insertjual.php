<?php
include 'koneksi.php';

if(isset($_POST['tanggal']) && isset($_POST['produk']) && isset($_POST['jumlah']) && isset($_POST['nama']) && isset($_POST['total'])) {
    $tanggal = $_POST['tanggal'];
    $produk = $_POST['produk'];
    $jumlah = $_POST['jumlah'];
    $nama = $_POST['nama'];
    $total = $_POST['total'];

    $query = "INSERT INTO penjualan (Id_Karyawan, Tanggal_Penjualan, Produk_Penjualan, Jumlah, Total_Harga) VALUES ('$nama', '$tanggal', '$produk', '$jumlah', '$total')";
    $result = mysqli_query($koneksi, $query);

    if($result) {
        echo "Data Penjualan berhasil ditambahkan.";
    } else {
        echo "Gagal menambahkan data karyawan.";
    }
} else {
    echo "Gagal menambahkan data karyawan. Data tidak lengkap.";
}
?>
