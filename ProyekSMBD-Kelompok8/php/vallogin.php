<?php 
$host = "localhost";
$user = "root";
$pass = "";
$database= "dbperusahaan";

$koneksi = mysqli_connect($host, $user, $pass);
if ($koneksi){
    $buka = mysqli_select_db($koneksi, $database);
    //echo "Database terhubung";
    if (!$buka){
        echo "database tidak terhubung";
    }
}else {
    echo "mysql tidak terhubung";
}

$us = $_POST['username'];
$pass = $_POST['password'];

$login = mysqli_query($koneksi,"SELECT * FROM login WHERE username ='$us' and password = '$pass'");
$cek = mysqli_num_rows ($login);
if($cek > 0){
	session_start();
	$_SESSION['username'] = $username;
	$_SESSION['status'] = "login ";
	header("location:../index.php");
}else {
    echo "
        <script>
            alert('Login gagal');
            document.location.href = '../login.php';
        </script>
        ";
    // header("location: index.php");
}
?>	
