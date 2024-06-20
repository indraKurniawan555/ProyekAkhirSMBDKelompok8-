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
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Nama</th>
                                                <th>Jabatan</th>
                                                <th>Departemen</th>
                                                <th>Tanggal Bergabung</th>
                                                <th>Gaji</th>
                                                <th>Kontak</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php include 'php/koneksi.php';
                                            $query = "SELECT Id_Karyawan, Nama, Jabatan, Id_Departemen, Tanggal_Bergabung, Gaji, Kontak FROM karyawan";
                                            $result = mysqli_query($koneksi, $query);
                                            if ($result->num_rows > 0) {
                                                
                                                while($row = $result->fetch_assoc()) {
                                                    echo "<tr>";
                                                    echo "<td>" . $row["Id_Karyawan"] . "</td>";
                                                    echo "<td>" . $row["Nama"] . "</td>";
                                                    echo "<td>" . $row["Jabatan"] . "</td>";
                                                    echo "<td>" . $row["Id_Departemen"] . "</td>";
                                                    echo "<td>" . $row["Tanggal_Bergabung"] . "</td>";
                                                    echo "<td>" . $row["Gaji"] . "</td>";
                                                    echo "<td>" . $row["Kontak"] . "</td>";
                                                    
                                                    
                                                    if (isset($row['Id_Karyawan'])) {
                                                        echo "<td><button class='btn btn-warning btn-sm editBtn' data-id='" . $row['Id_Karyawan'] . "' data-nama='" . $row['Nama'] . "' data-jabatan='" . $row['Jabatan'] . "' data-departemen='" . $row['Id_Departemen'] . "' data-tanggal_bergabung='" . $row['Tanggal_Bergabung'] . "' data-gaji='" . $row['Gaji'] . "' data-kontak='" . $row['Kontak'] . "'>Edit</button> <button class='btn btn-danger btn-sm deleteBtn' data-id='" . $row['Id_Karyawan'] . "'>Hapus</button></td>";
                                                    } else {
                                                        echo "<td>Error: No ID</td>";
                                                    }
                                                    
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

        <
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Karyawan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editForm" action="php/updatekar.php" method="POST">
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
                            <?php
                            include 'php/koneksi.php';

                            
                            if ($koneksi->connect_error) {
                                die("Connection failed: " . $koneksi->connect_error);
                            }

                            
                            $sql = "SELECT Id_Departemen, Nama_Departemen FROM departemen";
                            $result = $koneksi->query($sql);

                            
                            if ($result->num_rows > 0) {
                                echo "<label for='edit-departemen' class='form-label'>Departemen</label>";
                                echo "<select class='form-select' id='edit-departemen' name='departemen'>";
                            
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row["Id_Departemen"] . "'>" . $row["Nama_Departemen"] . "</option>";
                                }
                                echo "</select>";
                            } else {
                                echo "<p>No departments found</p>";
                            }

                            $koneksi->close();
                            ?>
                            </div>
                            <div class="mb-3">
                                <label for="edit-tanggal_bergabung" class="form-label">Tanggal Bergabung</label>
                                <input type="date" class="form-control" id="edit-tanggal_bergabung" name="tanggal_bergabung">
                            </div>
                            <div class="mb-3">
                                <label for="edit-gaji" class="form-label">Gaji</label>
                                <input type="text" class="form-control" id="edit-gaji" name="gaji">
                            </div>
                            <div class="mb-3">
                                <label for="edit-kontak" class="form-label">Kontak</label>
                                <input type="text" class="form-control" id="edit-kontak" name="kontak">
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
            <?php
                include 'php/koneksi.php';

            
            if ($koneksi->connect_error) {
                die("Connection failed: " . $koneksi->connect_error);
            }

            
            $sql = "SELECT Id_Departemen, Nama_Departemen FROM departemen";
            $result = $koneksi->query($sql);

            
            if ($result->num_rows > 0) {
                echo "<label for='edit-departemen' class='form-label'>Departemen</label>";
                echo "<select class='form-select' id='tambah-departemen' name='departemen'>";
                
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row["Id_Departemen"] . "'>" . $row["Nama_Departemen"] . "</option>";
                }
                echo "</select>";
            } else {
                echo "<p>No departments found</p>";
            }

            $koneksi->close();
            ?>
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
    
    const tambahBtn = document.getElementById('tambahBtn');

    
    tambahBtn.addEventListener('click', function(event) {
        
        event.preventDefault();

        
        const form = document.getElementById('tambahForm');
        const formData = new FormData(form);

        fetch('php/tambahkar.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            alert(data); 
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
                
                const editButtons = document.querySelectorAll('.editBtn');

                
                editButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        
                        const id = this.getAttribute('data-id');
                        const nama = this.getAttribute('data-nama');
                        const jabatan = this.getAttribute('data-jabatan');
                        const departemen = this.getAttribute('data-departemen');
                        const tanggal_bergabung = this.getAttribute('data-tanggal_bergabung');
                        const gaji = this.getAttribute('data-gaji');
                        const kontak = this.getAttribute('data-kontak');

                        document.getElementById('edit-id').value = id;
                        document.getElementById('edit-nama').value = nama;
                        document.getElementById('edit-jabatan').value = jabatan;
                        document.getElementById('edit-departemen').value = departemen;
                        document.getElementById('edit-tanggal_bergabung').value = tanggal_bergabung;
                        document.getElementById('edit-gaji').value = gaji;
                        document.getElementById('edit-kontak').value = kontak;

                        var editModal = new bootstrap.Modal(document.getElementById('editModal'), {});
                        editModal.show();
                    });
                });

                const deleteButtons = document.querySelectorAll('.deleteBtn');

                deleteButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const id = this.getAttribute('data-id');

                        if (confirm('Apakah anda yakin ingin menghapus data ini?')) {
                            
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
