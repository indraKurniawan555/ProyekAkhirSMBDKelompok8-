<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'koneksi.php';

    $id_karyawan = $_POST['id_karyawan'];
    $bulan = $_POST['bulan'];
    $tahun = $_POST['tahun'];

    // echo "ID Karyawan: " . $id_karyawan . "<br>";
    // echo "Bulan: " . $bulan . "<br>";
    // echo "Tahun: " . $tahun . "<br>";

    $stmt = $koneksi->prepare("CALL proses_penggajian_otomatis(?, ?, ?)");
    $stmt->bind_param("iii", $id_karyawan, $bulan, $tahun);
    if ($stmt->execute()) {
        echo 'sukses';
    } else {
        echo 'error: ' . $stmt->error;
    }
}
?>