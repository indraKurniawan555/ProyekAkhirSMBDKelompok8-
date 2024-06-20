<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Penjualan</title>
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
                        <h1 class="mt-4">Penjualan</h1>
                        <div class="card mb-4">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-table me-1"></i>
                                    Daftar Proyek
                                </div>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal"><i class="fas fa-plus"></i> Tambah Penjualan</button>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Tanggal Penjualan</th>
                                                <th>Produk</th>
                                                <th>Jumlah</th>
                                                <th>Nama</th>
                                                <th>Total Harga</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php include 'php/koneksi.php';
                                            $query = "SELECT p.Id_Penjualan, p.Tanggal_Penjualan, p.Produk_Penjualan, p.Jumlah, k.Nama, p.Total_Harga FROM karyawan k JOIN penjualan p ON p.Id_Karyawan=k.Id_Karyawan ORDER BY Tanggal_Penjualan DESC;";
                                            $result = mysqli_query($koneksi, $query);
                                            if ($result->num_rows > 0) {
                                                while($row = $result->fetch_assoc()) {
                                                    echo "<tr>";
                                                    echo "<td>" . $row["Tanggal_Penjualan"] . "</td>";
                                                    echo "<td>" . $row["Produk_Penjualan"] . "</td>";
                                                    echo "<td>" . $row["Jumlah"] . "</td>";
                                                    echo "<td>" . $row["Nama"] . "</td>";
                                                    echo "<td>" . $row["Total_Harga"] . "</td>";
                                                    
                                                    
                                                    if (isset($row['Id_Penjualan'])) {
                                                        echo "<td><button class='btn btn-warning btn-sm editBtn' data-id='" . $row['Id_Penjualan'] . "' data-tanggal='" . $row['Tanggal_Penjualan'] . "' data-produk='" . $row['Produk_Penjualan'] . "' data-jumlah='" . $row['Jumlah'] . "' data-nama='" . $row['Nama'] . "' data-total='" . $row['Total_Harga'] . "'>Edit</button> <button class='btn btn-danger btn-sm deleteBtn' data-id='" . $row['Id_Penjualan'] . "'>Hapus</button></td>";
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

        
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Data Penjualan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editForm" action="php/updatejual.php" method="POST">
                            <input type="hidden" name="Id_Penjualan" id="edit-id">
                            <div class="mb-3">
                                <label for="edit-nama" class="form-label">Tanggal Penjualan</label>
                                <input type="date" class="form-control" id="edit-tanggal" name="tanggal">
                            </div>
                            <div class="mb-3">
                                <label for="edit-jabatan" class="form-label">Produk</label>
                                <input type="text" class="form-control" id="edit-produk" name="produk">
                            </div>
                            <div class="mb-3">
                                <label for="edit-jabatan" class="form-label">Jumlah</label>
                                <input type="text" class="form-control" id="edit-jumlah" name="jumlah">
                            </div>
                            <div class="mb-3">
                                <?php
                            include 'php/koneksi.php';

                                
                                if ($koneksi->connect_error) {
                                    die("Connection failed: " . $koneksi->connect_error);
                                }

                                
                                $sql = "SELECT Id_Karyawan, Nama FROM karyawan WHERE Id_Departemen=7;";
                                $result = $koneksi->query($sql);

                                
                                if ($result->num_rows > 0) {
                                    echo "<label for='edit-nama' class='form-label'>Departemen</label>";
                                    echo "<select class='form-select' id='edit-nama' name='nama'>";
                                    
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value='" . $row["Id_Karyawan"] . "'>" . $row["Nama"] . "</option>";
                                    }
                                    echo "</select>";
                                } else {
                                    echo "<p>No departments found</p>";
                                }

                                $koneksi->close();
                                ?>
                            </div>
                            <div class="mb-3">
                                <label for="edit-gaji" class="form-label">Total Harga</label>
                                <input type="text" class="form-control" id="edit-total" name="total">
                            </div>
                            
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Tambah Penjualan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <form id="tambahForm" action="php/insertjual.php" method="POST">
                            <div class="mb-3">
                                <label for="edit-nama" class="form-label">Tanggal Penjualan</label>
                                <input type="date" class="form-control" id="tambah-tanggal" name="tanggal">
                            </div>
                            <div class="mb-3">
                                <label for="edit-jabatan" class="form-label">Produk</label>
                                <input type="text" class="form-control" id="tambah-produk" name="produk">
                            </div>
                            <div class="mb-3">
                                <label for="edit-jabatan" class="form-label">Jumlah</label>
                                <input type="text" class="form-control" id="tambah-jumlah" name="jumlah">
                            </div>
                            <div class="mb-3">
                                <?php
                            include 'php/koneksi.php';

                                
                                if ($koneksi->connect_error) {
                                    die("Connection failed: " . $koneksi->connect_error);
                                }

                                
                                $sql = "SELECT Id_Karyawan, Nama FROM karyawan WHERE Id_Departemen=7;";
                                $result = $koneksi->query($sql);

                                
                                if ($result->num_rows > 0) {
                                    echo "<label for='edit-nama' class='form-label'>Departemen</label>";
                                    echo "<select class='form-select' id='tambah-nama' name='nama'>";
                                    
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value='" . $row["Id_Karyawan"] . "'>" . $row["Nama"] . "</option>";
                                    }
                                    echo "</select>";
                                } else {
                                    echo "<p>No departments found</p>";
                                }

                                $koneksi->close();
                                ?>
                            </div>
                            <div class="mb-3">
                                <label for="edit-gaji" class="form-label">Total Harga</label>
                                <input type="text" class="form-control" id="tambah-total" name="total">
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

        fetch('php/insertjual.php', {
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
                        const tanggal = this.getAttribute('data-tanggal');
                        const produk = this.getAttribute('data-produk');
                        const jumlah = this.getAttribute('data-jumlah');
                        const nama = this.getAttribute('data-nama');
                        const total = this.getAttribute('data-total');
                    
                        
                        document.getElementById('edit-id').value = id;
                        document.getElementById('edit-tanggal').value = tanggal;
                        document.getElementById('edit-produk').value = produk;
                        document.getElementById('edit-jumlah').value = jumlah;
                        document.getElementById('edit-nama').value = nama;
                        document.getElementById('edit-total').value = total;
                        
                        var editModal = new bootstrap.Modal(document.getElementById('editModal'), {});
                        editModal.show();
                    });
                });

                
                const deleteButtons = document.querySelectorAll('.deleteBtn');

                
                deleteButtons.forEach(button => {
                    button.addEventListener('click', function() {
                
                        const id = this.getAttribute('data-id');
                        if (confirm('Apakah anda yakin ingin menghapus data ini?')) {
                            
                            window.location.href = `php/deletejual.php?id=${id}`;    
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
