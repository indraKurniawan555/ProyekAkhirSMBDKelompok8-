<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM proyek WHERE Id_Proyek = '$id'";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        $data = mysqli_fetch_assoc($result);
        echo json_encode($data);
    } else {
        http_response_code(500);
        echo json_encode(['message' => 'Internal Server Error']);
    }
} else {
    http_response_code(400);
    echo json_encode(['message' => 'Bad Request']);
}
?>
