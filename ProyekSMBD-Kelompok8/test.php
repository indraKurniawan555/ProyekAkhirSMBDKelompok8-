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
?>

<!DOCTYPE html>
<html>
<head>
    <title>Test Koneksi Database</title>
</head>
<body>
    <?php
    if ($koneksi && $buka) {
        echo "Database terhubung";
    } else {
        echo "Database tidak terhubung";
    }
    ?>
</body>
</html>
