<?php
require 'function.php';
require 'cek.php';

//get data
//ambil data total
$get1 = mysqli_query($conn, "select * from masuk");
$count1 = mysqli_num_rows($get1); //menghitung seluruh kolom
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Barang Masuk</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/2.3.4/css/dataTables.bootstrap5.min.css" crossorigin="anonymous"></script>
        <script src="sweetalert2.min.js"></script>
        <link rel="stylesheet" href="sweetalert2.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <style>
        .zoomable {
            width: 100px;      /* Beri lebar tetap (misal: 80px) */
            height: auto;     /* Beri tinggi tetap (misal: 80px) */
            object-fit: cover; /* Mencegah gambar gepeng/distorsi */
            border-radius: 5px; /* Opsional: agar sudutnya sedikit melengkung */
            
            /* Ini untuk animasi saat di-hover */
            transition: 0.3s ease; 
        }

        /* 2. Efek Zoom saat Hover */
        .zoomable:hover {
            transform: scale(2.5);  /* Perbesar 2.5x lipat */
            
            /* PENTING: Mencegah gambar tersembunyi di belakang elemen lain */
            position: relative;
            z-index: 10;
            
            cursor: zoom-in;
        }
        a{
            text-decoration:none;
            color:black;
        }
        </style>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <div class="container-fluid">
            <!-- Navbar Brand-->
            <a class="navbar-brand" href="index.php">
            <img src="images/Logo-UNSOED.png" alt="" width="30" height="30"> UKM Ngapak
            </a>
        </div>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-boxes"></i></div>
                                Stok Barang
                            </a>
                            <a class="nav-link" href="masuk.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-dolly-flatbed"></i></div>
                                Barang Masuk
                            </a>
                            <a class="nav-link" href="keluar.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-truck"></i></div>
                                Barang Keluar
                            </a>
                            <a class="nav-link" href="admin.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-address-card"></i></div>
                                Kelola Admin
                            </a>
                            <a class="nav-link" href="#" onclick="confirmLogout()">
                            <div class="sb-nav-link-icon"><i class="fas fa-power-off"></i></div>
                            Log out
                            </a>

                            <script>
                                function confirmLogout() {
                                    Swal.fire({
                                        title: "Konfirmasi Logout",
                                        text: "Anda yakin ingin logout?",
                                        icon: "question",
                                        showCancelButton: true,
                                        confirmButtonColor: "#3085d6",
                                        cancelButtonColor: "#d33",
                                        confirmButtonText: "Logout"
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            // Jika dikonfirmasi, arahkan ke halaman logout
                                            window.location.href = "logout.php";
                                        }
                                    });
                                }
                            </script>
                        </div>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Barang Masuk</h1>


                        <div class="card mb-4">
                            <div class="card-header">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                                    Tambah Barang Masuk
                                </button>
                                <a href="exportmasuk.php" class="btn btn-info">Export Data</a>
                                <div class="row mt-4">
                                    <div class="col-auto">
                                        <div class="card bg-success text-white p-2"><h4>Total Sesi : <?=$count1;?></h4></div>
                                </div>
                                <br>
                                <div class="row mt-4">
                                    <div class="col">
                                        <form method="post" class="row g-2 align-items-center">
                                            
                                            <div class="col-auto">
                                                <label for="tgl_mulai" class="visually-hidden">Tanggal Mulai</label>
                                                <input type="date" name="tgl_mulai" id="tgl_mulai" class="form-control">
                                            </div>

                                            <div class="col-auto">
                                                <label for="tgl_selesai" class="visually-hidden">Tanggal Selesai</label>
                                                <input type="date" name="tgl_selesai" id="tgl_selesai" class="form-control">
                                            </div>

                                            <div class="col-auto">
                                                <button type="submit" name="filter_tgl" class="btn btn-info">Filter</button>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Gambar</th>
                                            <th>Nama Barang</th>
                                            <th>Jumlah</th>
                                            <th>keterangan</th>
                                            <th>Admin</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        if(isset($_POST['filter_tgl'])){
                                            $mulai = $_POST['tgl_mulai'];
                                            $selesai = $_POST['tgl_selesai'];
                                            if($mulai!=null || $selesai!=null){
                                                $ambilsemuadatastock = mysqli_query($conn, "select * from masuk m, stock s where s.idbarang = m.idbarang and tanggal BETWEEN '$mulai' and DATE_ADD('$selesai',INTERVAL 1 DAY) order by idmasuk DESC");
                                            } else{
                                                $ambilsemuadatastock = mysqli_query($conn, "select * from masuk m, stock s where s.idbarang = m.idbarang");
                                            }
                                        }else {
                                            $ambilsemuadatastock = mysqli_query($conn, "select * from masuk m, stock s where s.idbarang = m.idbarang");
                                        }

                                        $ambilsemuadatastock = mysqli_query($conn,"select * from masuk m, stock s where s.idbarang = m.idbarang");
                                        while($data=mysqli_fetch_array($ambilsemuadatastock)){
                                            $idb = $data['idbarang'];
                                            $idm = $data['idmasuk'];
                                            $tanggal = $data['tanggal'];
                                            $namabarang = $data['namabarang'];
                                            $qty = $data['qty'];
                                            $keterangan = $data['keterangan'];
                                            $admin = $data['admin'];

                                            //cek ada gambar atau tidak
                                            $gambar = $data['image']; //ambil gambar
                                            if($gambar==null){
                                                //jika tidak ada gambar
                                                $img = 'No Photo';
                                            } else {
                                                //jika ada gambar
                                                $img = '<img src="images/'.$gambar.'" class="zoomable">';
                                            }
                                        ?>
                                        <tr>
                                            <td><?=$tanggal;?></td>
                                            <td><?=$img;?></td>
                                            <td><strong><a href="detail.php?id=<?=$idb;?>"><?=$namabarang;?></a><strong></td>
                                            <td><?=$qty;?></td>
                                            <td><?=$keterangan;?></td>
                                            <td><?=$admin;?></td>
                                            <td>
                                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit<?=$idm;?>">
                                                    Edit
                                                </button>
                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?=$idm;?>">
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>

                                            <!-- Edit Modal -->
                                            <div class="modal fade" id="edit<?=$idm;?>">
                                                <div class="modal-dialog">
                                                <div class="modal-content">

                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Edit Barang</h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>

                                                <!-- Modal body -->
                                                <form method="post">
                                                <div class="modal-body">
                                                    <input type="text" name="keterangan" value="<?=$keterangan;?>" class="form-control" placeholder="Keterangan" required>
                                                    <br>
                                                    <input type="text" name="admin" value="<?=$admin;?>" class="form-control" placeholder="Admin" required>
                                                    <br>
                                                    <input type="number" name="qty" value="<?=$qty;?>" placeholder="Stok" required>
                                                    <br>
                                                    <br>
                                                    <input type="hidden" name="idb" value="<?=$idb;?>">
                                                    <input type="hidden" name="idm" value="<?=$idm;?>">
                                                    <button type="submit" class="btn btn-primary" name="updatebarangmasuk">Submit</button>
                                                </div>
                                                </form>

                                                </div>
                                                </div>
                                            </div>

                                            <!-- Delete Modal -->
                                            <div class="modal fade" id="delete<?=$idm;?>">
                                                <div class="modal-dialog">
                                                <div class="modal-content">

                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Hapus Barang</h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>

                                                <!-- Modal body -->
                                                <form method="post">
                                                <div class="modal-body">
                                                    Apakah Anda yakin ingin menghapus <?=$namabarang;?>?
                                                    <input type="hidden" name="idb" value="<?=$idb;?>">
                                                    <input type="hidden" name="idm" value="<?=$idm;?>">
                                                    <input type="hidden" name="kty" value="<?=$qty;?>">
                                                    <br>
                                                    <br>
                                                    <button type="submit" class="btn btn-danger" name="hapusbarangmasuk">Hapus</button>
                                                </div>
                                                </form>

                                                </div>
                                                </div>
                                            </div>


                                        <?php
                                        };
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; UKM Ngapak 2025</div>
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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>

    <!-- The Modal -->
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
        <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
            <h4 class="modal-title">Tambah Barang Masuk</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <!-- Modal body -->
        <form method="post">
        <div class="modal-body">
            
            <select name="barangnya" class="form-control">
                <?php
                    $ambilsemuadatanya = mysqli_query($conn, "select * from stock");
                    while($fetcharray = mysqli_fetch_array($ambilsemuadatanya)){
                        $namabarangnya = $fetcharray['namabarang'];
                        $idbarangnya = $fetcharray['idbarang'];
                ?>

                <option value="<?=$idbarangnya;?>"><?=$namabarangnya;?></option>


                <?php
                    }
                ?>
            </select>
            <br>
            <input type="number" name="qty" class="form-control" placeholder="Quantity" required>
            <br>
            <input type="text" name="penerima" class="form-control" placeholder="Penerima" required>
            <br>
            <input type="text" name="admin" class="form-control" placeholder="Admin" required>
            <br>
            <button type="submit" class="btn btn-primary" name="barangmasuk">Submit</button>
        </div>
        </form>

        </div>
        </div>
    </div>    
</html>
