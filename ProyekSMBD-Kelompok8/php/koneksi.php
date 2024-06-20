<?php
$host = "localhost";
$user = "root";
$pass = "";
$database= "dbperusahaan";

$koneksi = mysqli_connect($host, $user, $pass);
if ($koneksi){
    $buka = mysqli_select_db($koneksi, $database);
    // echo "Database terhubung";
    if (!$buka){
        echo "database tidak terhubung";
    }   
}else {
    echo "mysql tidak terhubung";
}
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
// $nama = $_POST['nama'];
// $alamat = $_POST['alamat'];
// $jumlah_pinjaman = $_POST['jumlah_pinjaman'];

    // Lakukan validasi dan proses penyimpanan data ke database
    // ...
    // $tambah = "INSERT INTO peminjam (Nama, Jumlah_Pinjaman) VALUES ('$nama', '$jumlah_pinjaman')";
    // // echo $nama, $jumlah_pinjaman;

    // // Setelah diproses, Anda dapat mengarahkan pengguna ke halaman yang sesuai
    // header("Location: output.php");
?>
