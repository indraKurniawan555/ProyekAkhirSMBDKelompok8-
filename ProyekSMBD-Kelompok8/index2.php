<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Dashboard - SB Admin</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <?php include 'php/koneksi.php'; 

// Memanggil prosedur tersimpan
$query = "CALL GetTotalPenjualanLast6Months()";
if (mysqli_multi_query($koneksi, $query)) {
    do {
        // Store first result set
        if ($result = mysqli_store_result($koneksi)) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
            mysqli_free_result($result);
        }
    } while (mysqli_next_result($koneksi));
}

// Menghitung jumlah karyawan dari view
$query = "SELECT Jumlah_Karyawan FROM View_JumlahKaryawan";
$result = mysqli_query($koneksi, $query);
$rowKaryawan = mysqli_fetch_assoc($result);
mysqli_free_result($result);

// Mengambil jumlah departemen dari view
$query = "SELECT Jumlah_Departemen FROM View_Jumlah_Departemen";
$result = mysqli_query($koneksi, $query);
$rowDepartemen = mysqli_fetch_assoc($result);
mysqli_free_result($result);

// Mengambil jumlah proyek aktif dari view
$query = "SELECT Jumlah_Proyek_Aktif FROM View_Jumlah_Proyek_Aktif";
$result = mysqli_query($koneksi, $query);
$rowProyek = mysqli_fetch_assoc($result);
mysqli_free_result($result);

// Mengambil total penjualan bulan ini dari view
$query = "SELECT Total_Penjualan_Bulan_Ini FROM View_Jumlah_Penjualan_Bulan_Ini";
$result = mysqli_query($koneksi, $query);
$rowPenjualan = mysqli_fetch_assoc($result);
mysqli_free_result($result);




        ?>

        
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.html">Sistem Informasi</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
                </div>
            </form>
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
                            <a class="nav-link" href="index.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            <a class="nav-link" href="karyawan.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Karyawan
                            </a>
                            <a class="nav-link" href="gaji.html" >
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Gaji
                            </a>
                            <a class="nav-link" href="penjualan.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Penjualan
                            </a>
                            <a class="nav-link" href="proyek.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Proyek
                            </a>
                            <a class="nav-link" href="laporan.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Laporan
                            </a>
                            <div class="sb-sidenav-menu-heading">Interface</div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Layouts
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="layout-static.html">Static Navigation</a>
                                    <a class="nav-link" href="layout-sidenav-light.html">Light Sidenav</a>
                                </nav>
                            </div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                                Pages
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                        Authentication
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="login.html">Login</a>
                                            <a class="nav-link" href="register.html">Register</a>
                                            <a class="nav-link" href="password.html">Forgot Password</a>
                                        </nav>
                                    </div>
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                                        Error
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="401.html">401 Page</a>
                                            <a class="nav-link" href="404.html">404 Page</a>
                                            <a class="nav-link" href="500.html">500 Page</a>
                                        </nav>
                                    </div>
                                </nav>
                            </div>
                            <div class="sb-sidenav-menu-heading">Addons</div>
                            <a class="nav-link" href="charts.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Charts
                            </a>
                            <a class="nav-link" href="tables.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Tables
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        Start Bootstrap
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Dashboard</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                        <div class="row">
                            <!-- Jumlah Karyawan -->
                            <div class="row">
                                <div class="col-xl-3 col-md-6 mb-4">
                                    <div class="card border-left-primary shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1" style="font-weight:bold ;">Jumlah Karyawan</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="jumlahKaryawan"></div>
                                                    <!-- <?php
                                                    // Menghitung jumlah karyawan dari view
                                                    $query = "SELECT Jumlah_Karyawan FROM View_JumlahKaryawan";
                                                    $result = mysqli_query($koneksi, $query);
                                                    $row = mysqli_fetch_assoc($result);
                                                    
                                            
                                                    ?> -->
                                                <span id="jumlahKaryawan"><?php echo $row['Jumlah_Karyawan']; ?></span>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-users fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6 mb-4">
                                    <div class="card border-left-warning shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1 " style="font-weight:bold ;">Jumlah Departemen</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="JumlahDepartemen"></div>

                    <!-- <?php
                    // Mengambil jumlah departemen dari view
                    $query = "SELECT Jumlah_Departemen FROM View_Jumlah_Departemen";
                    $result = mysqli_query($koneksi, $query);
                    $row = mysqli_fetch_assoc($result);
                    ?> -->
                    <span id="JumlahDepartemen"><?php echo $row['Jumlah_Departemen']; ?></span>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-building fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6 mb-4">
                                    <div class="card border-left-success shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1" style="font-weight:bold ;">Proyek Aktif</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="proyekAktif"></div>
                                                    <!-- <?php
                    // Mengambil jumlah departemen dari view
                    $query = "SELECT Jumlah_Proyek_Aktif FROM View_Jumlah_Proyek_Aktif";
                    $result = mysqli_query($koneksi, $query);
                    $row = mysqli_fetch_assoc($result);
                    ?> -->
                    <span id="JumlahProyekAktif"><?php echo $row['Jumlah_Proyek_Aktif']; ?></span>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-tasks fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6 mb-4">
                                    <div class="card border-left-danger shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1" style="font-weight:bold ;">Total Penjualan Bulan Ini</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="JumlahPenjualanBulanIni"></div>
                                                    <!-- <?php
                    // Mengambil jumlah departemen dari view
                    $query = "SELECT Total_Penjualan_Bulan_Ini FROM View_Jumlah_Penjualan_Bulan_Ini";
                    $result = mysqli_query($koneksi, $query);
                    $row = mysqli_fetch_assoc($result);
                    ?> -->
                    <span id="JumlahPenjualanBulanIni"><?php echo $row['Total_Penjualan_Bulan_Ini']; ?></span>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-area me-1"></i>
                                        Grafik
                                    </div>
                                    <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-bar me-1"></i>
                                        Penjualan
                                    </div>
                                    <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                DataTable Example
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Position</th>
                                            <th>Office</th>
                                            <th>Age</th>
                                            <th>Start date</th>
                                            <th>Salary</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Name</th>
                                            <th>Position</th>
                                            <th>Office</th>
                                            <th>Age</th>
                                            <th>Start date</th>
                                            <th>Salary</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2023</div>
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
        <canvas id="myChart" width="400" height="400"></canvas> 
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
        <canvas id="chartPenjualan" width="800" height="400"></canvas>
        <script src="chart.js"></script>
        <script>
    // Fungsi untuk mengubah angka secara animasi
    function animateValue(id, start, end, duration) {
        let range = end - start;
        let current = start;
        let increment = end > start ? 1 : -1;
        let stepTime = Math.abs(Math.floor(duration / range));
        let obj = document.getElementById(id);
        let timer = setInterval(function() {
            current += increment;
            obj.textContent = current;
            if (current == end) {
                clearInterval(timer);
            }
        }, stepTime);
    }

    animateValue("jumlahKaryawan", 0, <?php echo $row['Jumlah_Karyawan']; ?>, 1000);
    animateValue("JumlahDepartemen", 0, <?php echo $row['Jumlah_Departemen']; ?>, 1000);
</script>
    <script>
        var ctx = document.getElementById('myBarChart').getContext('2d');

// Buat data untuk chart (contoh data statis)
var data = {
    labels: ['January', 'February', 'March', 'April', 'May', 'June'],
    datasets: [{
        label: 'data penjualan',
        data: [12, 19, 3, 5, 2, 3], 
        backgroundColor: [
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(255, 159, 64, 0.2)'
        ],
        borderColor: [
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)'
        ],
        borderWidth: 1
    }]
};

// Buat chart baru menggunakan data di atas
var myChart = new Chart(ctx, {
    type: 'bar',
    data: data,
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Fungsi untuk mengubah data chart dengan data dari PHP
function updateChartWithDataFromPHP() {
    var newData = [];
    var labels = [];    

    <?php foreach ($data as $row): ?>
        newData.push(<?php echo $row['TotalPenjualan']; ?>);
        labels.push("<?php echo $row['Bulan']; ?>");
    <?php endforeach; ?>
    
    
    // Perbarui data chart dengan data baru
    myChart.data.datasets[0].data = newData;
    myChart.data.labels = labels;
    myChart.update();
}

// Panggil fungsi untuk mengupdate chart dengan data dari PHP
updateChartWithDataFromPHP();

    </script>
</script>
    </body>
</html>
