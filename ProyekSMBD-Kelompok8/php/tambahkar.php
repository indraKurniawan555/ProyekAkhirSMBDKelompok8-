<?php
include 'koneksi.php';

if(isset($_POST['nama']) && isset($_POST['jabatan']) && isset($_POST['departemen']) && isset($_POST['tanggal_bergabung']) && isset($_POST['gaji']) && isset($_POST['kontak'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $jabatan = $_POST['jabatan'];
    $departemen = $_POST['departemen'];
    $tanggal_bergabung = $_POST['tanggal_bergabung'];
    $gaji = $_POST['gaji'];
    $kontak = $_POST['kontak'];

    $query = "CALL tambah_karyawan('$id','$nama', '$jabatan', '$departemen', '$tanggal_bergabung', '$gaji', '$kontak')";
    $result = mysqli_query($koneksi, $query);

    if($result) {
        echo "Data karyawan berhasil ditambahkan.";
    } else {
        echo "Gagal menambahkan data karyawan.";
    }
} else {
    echo "Gagal menambahkan data karyawan. Data tidak lengkap.";
}
?>
