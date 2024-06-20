<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Manajemen Pemasok dan Proyek</title>
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
                    <h1 class="mt-4">Manajemen Pemasok dan Proyek</h1>
                    
                    <!-- Lihat Proyek Section -->
                    <div id="lihatProyek" class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-table me-1"></i>
                                Daftar Proyek
                            </div>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahProyekModal"><i class="fas fa-plus"></i> Tambah Proyek</button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTableProyek" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID Proyek</th>
                                            <th>Nama Proyek</th>
                                            <th>Waktu Mulai</th>
                                            <th>Waktu Selesai</th>
                                            <th>Anggaran</th>
                                            <th>Deskripsi</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            include 'php/koneksi.php';
                                            $query = "SELECT * FROM proyek";
                                            $result = $koneksi->query($query);

                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    echo "<tr>
                                                        <td>".$row['Id_Proyek']."</td>
                                                        <td>".$row['Nama_Proyek']."</td>
                                                        <td>".$row['Tanggal_Mulai']."</td>
                                                        <td>".$row['Tanggal_Selesai']."</td>
                                                        <td>".$row['Anggaran']."</td>
                                                        <td>".$row['Deskripsi']."</td>
                                                        <td>
                                                            <button class='btn btn-info detailProyekBtn' data-id='".$row['Id_Proyek']."' data-bs-toggle='modal' data-bs-target='#detailProyekModal'><i class='fas fa-info-circle'></i> Detail</button>
                                                        </td>
                                                    </tr>";
                                                }
                                            }
                                            $koneksi->close();
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Tambah Proyek Modal -->
                    <div class="modal fade" id="tambahProyekModal" tabindex="-1" aria-labelledby="tambahProyekModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="tambahProyekModalLabel">Tambah Proyek Baru</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                <form action="php/tambahProyek.php" method="POST">
                                        <div class="mb-3">
                                            <label for="Id_Department" class="form-label">ID Department</label>
                                            <select class="form-control" id="Id_Department" name="Id_Department" required>
                                                <option value="">Pilih Departemen</option>
                                                <?php
                                                include 'php/koneksi.php';
                                                $queryKaryawan = "SELECT Id_Departemen, Nama_Departemen FROM departemen";
                                                $resultKaryawan = $koneksi->query($queryKaryawan);

                                                if ($resultKaryawan->num_rows > 0) {
                                                    while($rowKaryawan = $resultKaryawan->fetch_assoc()) {
                                                        echo "<option value='" . $rowKaryawan['Id_Departemen'] . "'>" . $rowKaryawan['Nama_Departemen'] . "</option>";
                                                    }
                                                }
                                                $koneksi->close();
                                                ?>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="Id_Karyawan" class="form-label">ID Karyawan</label>
                                            <select class="form-control" id="Id_Karyawan" name="Id_Karyawan" required>
                                                <option value="">Pilih Karyawan</option>
                                                <?php
                                                include 'php/koneksi.php';
                                                $queryKaryawan = "SELECT Id_Karyawan, Nama FROM karyawan";
                                                $resultKaryawan = $koneksi->query($queryKaryawan);

                                                if ($resultKaryawan->num_rows > 0) {
                                                    while($rowKaryawan = $resultKaryawan->fetch_assoc()) {
                                                        echo "<option value='" . $rowKaryawan['Id_Karyawan'] . "'>" . $rowKaryawan['Nama'] . "</option>";
                                                    }
                                                }
                                                $koneksi->close();
                                                ?>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="Nama_Proyek" class="form-label">Nama Proyek</label>
                                            <input type="text" class="form-control" id="Nama_Proyek" name="Nama_Proyek" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="Deskripsi" class="form-label">Deskripsi</label>
                                            <textarea class="form-control" id="Deskripsi" name="Deskripsi" rows="3" required></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="Tanggal_Mulai" class="form-label">Tanggal Mulai</label>
                                            <input type="date" class="form-control" id="Tanggal_Mulai" name="Tanggal_Mulai" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="Tanggal_Selesai" class="form-label">Tanggal Selesai</label>
                                            <input type="date" class="form-control" id="Tanggal_Selesai" name="Tanggal_Selesai" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="Anggaran" class="form-label">Anggaran</label>
                                            <input type="number" class="form-control" id="Anggaran" name="Anggaran" required>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Tambah Proyek</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div class="modal fade" id="detailProyekModal" tabindex="-1" aria-labelledby="detailProyekModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="detailProyekModalLabel">Detail Proyek</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nama</th>
                                                <th>Departemen</th>
                                                <th>Manager</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody id="detailProyekContent">
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
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
                            <a href="#">Terms & Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            $('.detailProyekBtn').on('click', function() {
                var idProyek = $(this).data('id');
                $.ajax({
                    url: 'detailproyek.php',
                    type: 'GET',
                    data: { id: idProyek },
                    success: function(response) {
                        $('#detailProyekContent').html(response);
                    },
                    error: function() {
                        alert('Failed to fetch data.');
                    }
                });
            });

            $('#tambahProyekForm').on('submit', function(event) {
                event.preventDefault();
                $.ajax({
                    url: 'php/tambahProyek.php',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        alert('Proyek berhasil ditambahkan.');
                        location.reload();
                    },
                    error: function() {
                        alert('Gagal menambahkan proyek.');
                    }
                });
            });
        });
    </script>
</body>
</html>
