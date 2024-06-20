<?php
$host = "localhost";
$user = "root";
$pass = "";
$database = "dbperusahaan";

$koneksi = mysqli_connect($host, $user, $pass, $database);
if (!$koneksi) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    
    $check_query = "SELECT * FROM login WHERE username = '$username'";
    $check_result = mysqli_query($koneksi, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        echo "
        <script>
            alert('Username sudah ada. Gunakan username lain.');
            document.location.href = '../register.php';
        </script>
        ";
    } else {
        $query = "INSERT INTO login (username, password) VALUES ('$username', '$password')";
        if (mysqli_query($koneksi, $query)) {
            echo "
            <script>
                alert('Registration Successful');
                document.location.href = '../login.php';
            </script>
            ";
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
        }
    }
}

mysqli_close($koneksi);
?>
