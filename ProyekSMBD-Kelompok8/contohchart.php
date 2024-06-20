<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chart Penjualan</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <canvas id="chartPenjualan" width="800" height="400"></canvas>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            fetch('data.php')
                .then(response => response.json())
                .then(data => {
                    const bulan = data.map(item => item.Bulan);
                    const totalPenjualan = data.map(item => item.TotalPenjualan);
                    
                    const ctx = document.getElementById('chartPenjualan').getContext('2d');
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: bulan,
                            datasets: [{
                                label: 'Total Penjualan',
                                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1,
                                data: totalPenjualan,
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                })
                .catch(error => console.error('Error:', error));
        });
    </script>
    <?php
    include 'php/koneksi.php'; 
    $sql = "CALL GetTotalPenjualanLast6Months()";
    $result = $conn->query($sql);

    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    $conn->close();

    header('Content-Type: application/json');
    echo json_encode($data);
    ?>
</body>
</html>
