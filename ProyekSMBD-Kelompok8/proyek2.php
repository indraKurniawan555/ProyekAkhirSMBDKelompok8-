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
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css" />
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            <a class="nav-link" href="karyawan.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Karyawan
                            </a>
                            <a class="nav-link" href="gaji.php" >
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Gaji
                            </a>
                            <a class="nav-link" href="penjualan.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Penjualan
                            </a>
                            <a class="nav-link" href="proyek.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Proyek
                            </a>
                            <a class="nav-link" href="laporan.php">
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
                        <h1 class="mt-4">Karyawan</h1>
                        <div class="card mb-4">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-table me-1"></i>
                                    Daftar Proyek
                                </div>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal"><i class="fas fa-plus"></i> Tambah Karyawan</button>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                <thead>
                                        <tr>
                                            <th>ID Proyek</th>
                                            <th>Nama Proyek</th>
                                            <th>Departemen</th>
                                            <th>Manajer Proyek</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        include 'php/koneksi.php';
                                        // Check connection
                                        if ($koneksi->connect_error) {
                                            die("Connection failed: " . $koneksi->connect_error);
                                        }

                                        // Query to get project details
                                        $sql = "SELECT Id_Proyek, Nama_Proyek, Department, Manager FROM view_detail_proyek";
                                        $result = $koneksi->query($sql);

                                        if ($result->num_rows > 0) {
                                            // Output data of each row
                                            while($row = $result->fetch_assoc()) {
                                                echo "<tr>";
                                                echo "<td>" . $row["Id_Proyek"] . "</td>";
                                                echo "<td>" . $row["Nama_Proyek"] . "</td>";
                                                echo "<td>" . $row["Department"] . "</td>";
                                                echo "<td>" . $row["Manager"] . "</td>";
                                                if (isset($row['Id_Proyek'])) {
                                                    echo "<td><button class='btn btn-warning btn-sm editBtn' data-id='" . $row['Id_Proyek'] . "' data-nama='" . $row['Nama_Proyek'] . "' data-jabatan='" . $row['Department'] . "' data-departemen='" . $row['Manager'] . "'>Edit</button> <button class='btn btn-danger btn-sm deleteBtn' data-id='" . $row['Id_Proyek'] . "'>Hapus</button></td>";
                                                } else {
                                                    echo "<td>Error: No ID</td>";
                                                }
                                                
                                                echo "</tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='7'>0 results</td></tr>";
                                        }

                                        $koneksi->close();
                                        ?>
                                    </tbody>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2024</div>
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

        <!-- Modal for Edit Form -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Karyawan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editForm" action="php/updateproyek.php" method="POST">
                            <input type="hidden" name="Id_Karyawan" id="edit-id">
                            <div class="mb-3">
                                <label for="edit-nama" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="edit-nama" name="nama">
                            </div>
                            <div class="mb-3">
                                <label for="edit-jabatan" class="form-label">Jabatan</label>
                                <input type="text" class="form-control" id="edit-jabatan" name="jabatan">
                            </div>
                            <div class="mb-3">
                                <label for="edit-departemen" class="form-label">Departemen</label>
                                <input type="text" class="form-select" id="edit-departemen" name="departemen">
                                    
                                </input>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!--Tambah Karyawan  -->
        <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Karyawan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <form id="tambahForm" action="php/tambahkar.php" method="POST">
                    <div class="mb-3">
        <label for="tambah-nama" class="form-label">Id_Karyawan</label>
        <input type="number" class="form-control" id="id" name="id">
    </div>
    <div class="mb-3">
        <label for="tambah-nama" class="form-label">Nama</label>
        <input type="text" class="form-control" id="tambah-nama" name="nama">
    </div>
    <div class="mb-3">
        <label for="tambah-jabatan" class="form-label">Jabatan</label>
        <input type="text" class="form-control" id="tambah-jabatan" name="jabatan">
    </div>
    <div class="mb-3">
        <label for="tambah-departemen" class="form-label">Departemen</label>
        <select class="form-select" id="tambah-departemen" name="departemen">
            <option value="1">Mengelola Operasional</option>
            <option value="2">Mengelola HR</option>
            <option value="3">Mengelola IT</option>
            <option value="4">Mengelola Produksi</option>
            <option value="5">Mengelola Pemasaran</option>
            <option value="6">Mengelola Keuangan</option>
            <option value="7">Mengelola Penjualan</option>
            <option value="8">Mengelola Layanan Pelanggan</option>
            <option value="9">Mengelola Logisitik</option>
            <option value="10">Mengelola Pengembangan Produk</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="tambah-tanggal_bergabung" class="form-label">Tanggal Bergabung</label>
        <input type="date" class="form-control" id="tambah-tanggal_bergabung" name="tanggal_bergabung">
    </div>
    <div class="mb-3">
        <label for="tambah-gaji" class="form-label">Gaji</label>
        <input type="text" class="form-control" id="tambah-gaji" name="gaji">
    </div>
    <div class="mb-3">
        <label for="tambah-kontak" class="form-label">Kontak</label>
        <input type="text" class="form-control" id="tambah-kontak" name="kontak">
    </div>
    <button type="button" id="tambahBtn" class="btn btn-primary">Tambah</button>
</form>


                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
        
<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Get tambah button
    const tambahBtn = document.getElementById('tambahBtn');

    // Add click event to tambah button
    tambahBtn.addEventListener('click', function(event) {
        // Prevent default form submission
        event.preventDefault();

        // Submit form using AJAX
        const form = document.getElementById('tambahForm');
        const formData = new FormData(form);

        fetch('php/tambahkar.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            alert(data); // Show response message
            // Optional: Reload page or update data table
        })
        .catch(error => {
            console.error('Error:', error);
        });
        location.reload();
    });
});

</script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Get all edit buttons
                const editButtons = document.querySelectorAll('.editBtn');

                // Add click event to each edit button
                editButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        // Get data attributes
                        const id = this.getAttribute('data-id');
                        const nama = this.getAttribute('data-nama');
                        const jabatan = this.getAttribute('data-jabatan');
                        const departemen = this.getAttribute('data-departemen');
                        
                        // Set form values
                        document.getElementById('edit-id').value = id;
                        document.getElementById('edit-nama').value = nama;
                        document.getElementById('edit-jabatan').value = jabatan;
                        document.getElementById('edit-departemen').value = departemen;
                        
                        // Show modal
                        var editModal = new bootstrap.Modal(document.getElementById('editModal'), {});
                        editModal.show();
                    });
                });

                // Get all delete buttons
                const deleteButtons = document.querySelectorAll('.deleteBtn');

                // Add click event to each delete button
                deleteButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        // Get data attributes
                        const id = this.getAttribute('data-id');

                        if (confirm('Apakah anda yakin ingin menghapus data ini?')) {
                            // Redirect to delete PHP script
                            window.location.href = `php/deletekar.php?id=${id}`;    
                        }
                    });
                });
            });
        </script>
        <script>
    $(document).ready(function() {
        $('#btnNavbarSearch').click(function() {
            var searchText = $('input[type="text"]').val();
            $.ajax({
                url: 'php/searchkar.php',
                type: 'POST',
                data: {search: searchText},
                success: function(response) {
                    $('tbody').html(response);
                }
            });
        });
    });
        </script>
    </body>
</html>
