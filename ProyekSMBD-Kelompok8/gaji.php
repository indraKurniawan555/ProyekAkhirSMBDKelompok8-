<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Sistem INformasi</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.html">Sistem Informasi</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#!">Settings</a></li>
                        <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="#!">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">UTAMA</div>
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <a class="nav-link" href="karyawan.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                            Karyawan
                        </a>
                        <a class="nav-link" href="gaji.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-money-bill-wave"></i></div>
                            Gaji
                        </a>
                        <a class="nav-link" href="penjualan.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-line"></i></div>
                            Penjualan
                        </a>
                        <a class="nav-link" href="proyek.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-project-diagram"></i></div>
                            Proyek
                        </a>
                        <a class="nav-link" href="laporan.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-file-alt"></i></div>
                            Laporan
                        </a>
                        
                    </div>
                </div>
            </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Hitung Gaji Karyawan</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Hitung Gaji</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-header bg-primary text-white">
                                <i class="fas fa-calculator me-1"></i>
                                Form Hitung Gaji Karyawan
                            </div>
                            <div class="card-body">
                                <form id="hitungGajiForm" action="" method="POST">
                                    <div class="mb-3">
                                        <label for="idKaryawan" class="form-label">ID Karyawan</label>
                                        <input type="text" class="form-control" id="idKaryawan" name="id_karyawan" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="bulan" class="form-label">Bulan</label>
                                        <input type="number" class="form-control" id="bulan" name="bulan" min="1" max="12" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="tahun" class="form-label">Tahun</label>
                                        <input type="number" class="form-control" id="tahun" name="tahun" min="2000" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Hitung Gaji</button>
                                    <button type="button" class="btn btn-success" id="tambahGajiBtn">Tambahkan Gaji</button>
                                </form>
                                <div id="result" class="mt-3">
                                    <?php
                                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                        include 'php/koneksi.php'; 
                                        $id_karyawan = $_POST['id_karyawan'];
                                        $bulan = $_POST['bulan'];
                                        $tahun = $_POST['tahun'];
                                        
                                        $stmt = $koneksi->prepare("CALL hitung_gaji(?, ?, ?, @gaji_bersih)");
                                        $stmt->bind_param("iii", $id_karyawan, $bulan, $tahun);
                                        $stmt->execute();

                                        $result = $koneksi->query("SELECT @gaji_bersih as gaji_bersih");
                                        $row = $result->fetch_assoc();

                                        echo "<div class='card bg-light mt-3 p-3'>";
                                        echo "<h5 class='card-title'>Hasil Perhitungan Gaji</h5>";
                                        echo "<p class='card-text fs-3'>" . $row['gaji_bersih'] . "</p>";
                                        echo "</div>";
                                    }
                                    ?>
                                </div>
                                <div id="notification" class="mt-3" style="display:none;">
                                    <div class="alert alert-success" role="alert">
                                        Gaji telah berhasil ditambahkan!
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
                        <div class="card-header">
                            Filter Data
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="filterKaryawanId" class="form-label">ID Karyawan</label>
                                <input type="number" class="form-control" id="filterKaryawanId" required>
                            </div>
                            <button id="filterGajiBtn" class="btn btn-secondary">Filter Gaji</button>
                            <button id="filterKehadiranBtn" class="btn btn-secondary">Filter Kehadiran</button>
                        </div>
                        </div>
                        <button id="showGajiTableBtn" class="btn btn-secondary">Tampilkan Tabel Gaji</button>
                        <button id="showKehadiranTableBtn" class="btn btn-secondary">Tampilkan Tabel Kehadiran</button>
                        <div class="table-responsive mt-4" id="gajiTable" style="display:none;">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID Gaji</th>
                                        <th>ID Karyawan</th>
                                        <th>Bulan</th>
                                        <th>Tahun</th>
                                        <th>Gaji Pokok</th>
                                        <th>Tunjangan</th>
                                        <th>Potongan</th>
                                        <th>Gaji Bersih</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php include 'php/koneksi.php';
                                        $query = "SELECT * FROM penggajian";
                                            $result = mysqli_query($koneksi, $query);
                                            if ($result->num_rows > 0) {
                                                while($row = $result->fetch_assoc()) {
                                
                                                    echo "<tr>";
                                                    echo "<td>" . $row["Id_Penggajian"] . "</td>";
                                                    echo "<td>" . $row["Id_Karyawan"] . "</td>";
                                                    echo "<td>" . $row["Bulan"] . "</td>";
                                                    echo "<td>" . $row["Tahun"] . "</td>";
                                                    echo "<td>" . $row["Gaji_Pokok"] . "</td>";
                                                    echo "<td>" . $row["Tunjangan"] . "</td>";
                                                    echo "<td>" . $row["Potongan"] . "</td>";
                                                    echo "<td>" . $row["Gaji_Bersih"] . "</td>";
                                                    
                                
                                                    
                                                    echo "</tr>";
                                                }
                                            } else {
                                                echo "<tr><td colspan='7'>0 results</td></tr>";
                                            }
                                            
                                            ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive mt-4" id="kehadiranTable" style="display:none;">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID Kehadiran</th>
                                        <th>ID Karyawan</th>
                                        <th>Tanggal</th>
                                        <th>Jam Masuk</th>
                                        <th>Jam Keluar</th>
                                        <th>Kehadiran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php include 'php/koneksi.php';
                                        $query = "SELECT * FROM kehadiran";
                                            $result = mysqli_query($koneksi, $query);
                                            if ($result->num_rows > 0) {
                                                
                                                while($row = $result->fetch_assoc()) {
                                
                                                    echo "<tr>";
                                                    echo "<td>" . $row["Id_Kehadiran"] . "</td>";
                                                    echo "<td>" . $row["Id_Karyawan"] . "</td>";
                                                    echo "<td>" . $row["Tanggal"] . "</td>";
                                                    echo "<td>" . $row["Jam_Masuk"] . "</td>";
                                                    echo "<td>" . $row["Jam_Keluar"] . "</td>";
                                                    echo "<td>" . $row["Status_Kehadiran"] . "</td>";
                                
                                                    
                                                    echo "</tr>";
                                                }
                                            } else {
                                                echo "<tr><td colspan='7'>0 results</td></tr>";
                                            }
                                            
                                            ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Sistem Informasi 2024</div>
                            <div>   
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
        <script>
            function loadGajiTable() {
            fetch('php/loadgaji.php') 
                .then(response => response.text())
                .then(data => {
                    document.getElementById('gajiTable').innerHTML = data;
                    document.getElementById('gajiTable').style.display = 'block';
                    document.getElementById('kehadiranTable').style.display = 'none';
                })
                .catch(error => console.error('Error:', error));
        }

        
        function loadKehadiranTable() {
            fetch('php/loadkehadiran.php')
                .then(response => response.text())
                .then(data => {
                    document.getElementById('kehadiranTable').innerHTML = data;
                    document.getElementById('kehadiranTable').style.display = 'block';
                    document.getElementById('gajiTable').style.display = 'none';
                })
                .catch(error => console.error('Error:', error));
        }

        document.getElementById('showGajiTableBtn').addEventListener('click', function() {
            loadGajiTable();
        });

        document.getElementById('showKehadiranTableBtn').addEventListener('click', function() {
            loadKehadiranTable();
        });
            

            document.getElementById('tambahGajiBtn').addEventListener('click', function() {
                const idKaryawan = document.getElementById('idKaryawan').value;
                const bulan = document.getElementById('bulan').value;
                const tahun = document.getElementById('tahun').value;

                if (idKaryawan && bulan && tahun) {
                    fetch('php/tambahgaji.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: `id_karyawan=${idKaryawan}&bulan=${bulan}&tahun=${tahun}`
                    })
                    .then(response => response.text())
                    .then(data => {
                        if (data === 'sukses') {
                            showNotification('Gaji telah berhasil ditambahkan!', 'success');
                            window.location.reload(); 
                        } else {
                            showNotification(data, 'error'); 
                        }
                    })
                    .catch(error => {
                        showNotification('Terjadi kesalahan: ' + error, 'error');
                    });
                } else {
                    showNotification('Harap isi semua data.', 'warning');
                }
            });

            document.getElementById('filterGajiBtn').addEventListener('click', function() {
            const karyawanId = document.getElementById('filterKaryawanId').value;
            if (karyawanId) {
                fetch(`php/filtergaji.php?karyawan_id=${karyawanId}`)
                    .then(response => response.text())
                    .then(data => {
                        document.getElementById('gajiTable').style.display = 'block';
                        document.getElementById('gajiTable').innerHTML = data;
                        document.getElementById('kehadiranTable').style.display = 'none';
                    })
                    .catch(error => console.error('Error:', error));
            } else {
                alert('Please enter an ID Karyawan');
            }
        });

        document.getElementById('filterKehadiranBtn').addEventListener('click', function() {
            const karyawanId = document.getElementById('filterKaryawanId').value;
            if (karyawanId) {
                fetch(`php/filterkehadiran.php?karyawan_id=${karyawanId}`)
                    .then(response => response.text())
                    .then(data => {
                        document.getElementById('kehadiranTable').style.display = 'block';
                        document.getElementById('kehadiranTable').innerHTML = data;
                        document.getElementById('gajiTable').style.display = 'none';
                    })
                    .catch(error => console.error('Error:', error));
            } else {
                alert('Please enter an ID Karyawan');
            }
        });

            function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.classList.add('alert');

            switch (type) {
                case 'success':
                    notification.classList.add('alert-success');
                    break;
                case 'error':
                    notification.classList.add('alert-danger');
                    break;
                case 'warning':
                    notification.classList.add('alert-warning');
                    break;
                default:
                    notification.classList.add('alert-info');
            }

            notification.textContent = message;
            const notificationContainer = document.getElementById('notification');
            notificationContainer.innerHTML = '';
            notificationContainer.appendChild(notification);
            notificationContainer.style.display = 'block';

            setTimeout(() => {
                notificationContainer.style.display = 'none';
            }, 3000);
        }
        </script>
    </body>
</html>
