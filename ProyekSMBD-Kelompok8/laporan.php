<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Karyawan</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet" />
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
                <h1 class="mt-4">Laporan Bulanan</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Laporan</li>
                </ol>
                
                <form method="post" action="laporan.php">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="bulan" class="form-label">Bulan:</label>
                            <select name="bulan" id="bulan" class="form-select">
                                <option value="1">January</option>
                                <option value="2">February</option>
                                <option value="3">March</option>
                                <option value="4">April</option>
                                <option value="5">May</option>
                                <option value="6">June</option>
                                <option value="7">July</option>
                                <option value="8">August</option>
                                <option value="9">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="tahun" class="form-label">Tahun:</label>
                            <input type="number" class="form-control" id="tahun" name="tahun" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
                
                <?php
                include 'php/koneksi.php';

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $bulan = $_POST['bulan'];
                    $tahun = $_POST['tahun'];
                
                    
                    if ($koneksi->connect_error) {
                        die("Connection failed: " . $koneksi->connect_error);
                    }
                
                    
                    $sql = "CALL Persentase_Kehadiran('$bulan', '$tahun', @p_Persentase)";
                    $result = $koneksi->query($sql);
                
                    if ($result === TRUE) {
                    
                        $sql = "SELECT @p_Persentase AS persentase";
                        $result = $koneksi->query($sql);
                
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<div class="card mt-4">';
                                echo '<div class="card-body">';
                                echo '<h5 class="card-title">Persentase Kehadiran Bulanan</h5>';
                                echo '<p class="card-text">Persentase: ' . $row["persentase"] . '%</p>';
                                echo '</div>';
                                echo '</div>';
                            }
                        } else {
                            echo "0 results";
                        }
                
                        $result->free();
                    } else {
                        echo "Error calling Persentase_Kehadiran stored procedure: " . $koneksi->error;
                    }
                
                
                    $sql = "CALL Jumlah_Penjualan('$bulan', '$tahun', @p_JumlahPenjualan)";
                    $result = $koneksi->query($sql);
                
                    if ($result === TRUE) {
                        
                        $sql = "SELECT @p_JumlahPenjualan AS jumlah_penjualan";
                        $result = $koneksi->query($sql);
                
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<div class="card mt-4">';
                                echo '<div class="card-body">';
                                echo '<h5 class="card-title">Jumlah Penjualan Bulanan</h5>';
                                echo '<p class="card-text">Jumlah Penjualan: Rp. ' . $row["jumlah_penjualan"] . '</p>';
                                echo '</div>';
                                echo '</div>';
                            }
                        } else {
                            echo "0 results";
                        }
                
                        $result->free();
                    } else {
                        echo "Error calling Jumlah_Penjualan stored procedure: " . $koneksi->error;
                    }
                
                    
                    $sql = "CALL Jumlah_Proyek_Selesai('$bulan', '$tahun', @p_JumlahProyekSelesai)";
                    $result = $koneksi->query($sql);
                
                    if ($result === TRUE) {
                        
                        $sql = "SELECT @p_JumlahProyekSelesai AS jumlah_proyek_selesai";
                        $result = $koneksi->query($sql);
                
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<div class="card mt-4">';
                                echo '<div class="card-body">';
                                echo '<h5 class="card-title">Jumlah Proyek Selesai Bulanan</h5>';
                                echo '<p class="card-text">Jumlah Proyek Selesai: ' . $row["jumlah_proyek_selesai"] . '</p>';
                                echo '</div>';
                                echo '</div>';
                            }
                        } else {
                            echo "0 results";
                        }
                
                        $result->free();
                    } else {
                        echo "Error calling Jumlah_Proyek_Selesai stored procedure: " . $koneksi->error;
                    }
                
                    $koneksi->close();
                }
                ?>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="js/scripts.js"></script>
</body>
</html>
