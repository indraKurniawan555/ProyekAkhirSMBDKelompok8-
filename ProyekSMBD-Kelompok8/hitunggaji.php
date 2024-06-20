<?php
include 'koneksi.php'; // This should include your database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_karyawan = $_POST['id_karyawan'];
    $bulan = $_POST['bulan'];
    $tahun = $_POST['tahun'];

    $stmt = $koneksi->prepare("CALL hitung_gaji(?, ?, ?, @gaji_bersih)");
    $stmt->bind_param("iii", $id_karyawan, $bulan, $tahun);
    $stmt->execute();

    $result = $koneksi->query("SELECT @gaji_bersih as gaji_bersih");
    $row = $result->fetch_assoc();

    echo json_encode(array('gaji_bersih' => $row['gaji_bersih']));
}

?>
