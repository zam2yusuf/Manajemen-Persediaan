<?php
require 'function.php';
require 'cek.php';

//mendapatkan id barang dari index
$idbarang = $_GET['id'];
//get info barang
$get = mysqli_query($conn,"select * from stock where idbarang='$idbarang'");
$fetch = mysqli_fetch_assoc($get);

//set variabel
$namabarang = $fetch['namabarang'];
$deskripsi = $fetch['deskripsi'];
$stock = $fetch['stock'];

//cek ada gambar atau tidak
$gambar = $fetch['image']; //ambil gambar
if($gambar==null){
    //jika tidak ada gambar
    $img = '(No Photo)';
} else {
    //jika ada gambar
    $img = '<img src="images/'.$gambar.'" class="zoomable">';
}

//generate QR
$urlview = 'https://localhost/stockbarang/stock/view.php?id='.$idbarang;
$qrcode = 'https://quickchart.io/qr?format=png&margin=3&size=200&text='.$urlview.'';
?>




<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Detail Barang - UKM Ngapak</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/2.3.4/css/dataTables.bootstrap5.min.css" crossorigin="anonymous"></script>
        <script src="sweetalert2.min.js"></script>
        <link rel="stylesheet" href="sweetalert2.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <style>
        .zoomable {
            width: 200px;      /* Beri lebar tetap (misal: 80px) */
            height: auto;     /* Beri tinggi tetap (misal: 80px) */
            object-fit: cover; /* Mencegah gambar gepeng/distorsi */
            border-radius: 5px; /* Opsional: agar sudutnya sedikit melengkung */
            
            /* Ini untuk animasi saat di-hover */
            transition: 0.3s ease; 
        }

        /* 2. Efek Zoom saat Hover */
        .zoomable:hover {
            transform: scale(1.5);  /* Perbesar 2.5x lipat */
            
            /* PENTING: Mencegah gambar tersembunyi di belakang elemen lain */
            position: relative;
            z-index: 10;
            
            cursor: zoom-in;
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
                            <a class="nav-link" href="logout.php">
                                Logout
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Detail Barang</h1>
                        <div class="card mb-4">
                            <div class="card-header">
                                <h2><?=$namabarang;?></h2>
                                <?=$img;?>
                                <img src="<?=$qrcode;?>">
                            </div>
                            <div class="card-body">

                            <div class="row">
                                <div class="col-md-3">Deskripsi</div>
                                <div class="col-md-9">: <?=$deskripsi;?></div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">Stock</div>
                                <div class="col-md-9">: <?=$stock;?></div>
                            </div>

                            <br><br>

                            <h3>Barang Masuk</h3>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="barangmasuk" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Keterangan</th>
                                            <th>Jumlah</th>
                                            <th>Admin</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        <?php
                                        $ambildatamasuk = mysqli_query($conn,"select * from masuk where idbarang='$idbarang'");
                                        $i = 1;
                                
                                        while($fetch=mysqli_fetch_array($ambildatamasuk)){
                                            $tanggal = $fetch['tanggal'];
                                            $keterangan = $fetch['keterangan'];
                                            $quantity = $fetch['qty'];
                                            $admin= $fetch['admin'];
                                        ?>

                                        <tr>
                                            <td><?=$i++;?></td>
                                            <td><?=$tanggal;?></td>
                                            <td><?=$keterangan;?></td>
                                            <td><?=$quantity;?></td>
                                            <td><?=$admin;?></td>
                                        </tr>                                            

                                        <?php
                                        };
                                        ?>
                                    </tbody>
                                </table>
                            </div>

                            <br><br>

                            <h3>Barang Keluar</h3>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="barangkeluar" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Kepada</th>
                                            <th>Jumlah</th>
                                            <th>Admin</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $ambildatakeluar = mysqli_query($conn,"select * from keluar where idbarang='$idbarang'");
                                        $i = 1;
                                
                                        while($fetch=mysqli_fetch_array($ambildatakeluar)){
                                            $tanggal = $fetch['tanggal'];
                                            $pembeli = $fetch['penerima'];
                                            $quantity = $fetch['qty'];
                                            $admin = $fetch['admin'];
                                        ?>

                                        <tr>
                                            <td><?=$i++;?></td>
                                            <td><?=$tanggal;?></td>
                                            <td><?=$pembeli;?></td>
                                            <td><?=$quantity;?></td>
                                            <td><?=$admin;?></td>
                                        </tr>                                            

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

    <!-- Modal tambah barang baru -->
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
        <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
            <h4 class="modal-title">Tambah Barang</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <!-- Modal body -->
        <form method="post" enctype="multipart/form-data">
        <div class="modal-body">
            <input type="text" name="namabarang" placeholder="Nama Barang" class="form-control" required>
            <br>
            <input type="text" name="deskripsi" placeholder="Deskripsi Barang" class="form-control" required>
            <br>
            <input type="number" name="stock" class="form-control" placeholder="Stok" required>
            <br>
            <input type="file" name="file" class="form-control">
            <br>
            <button type="submit" class="btn btn-primary" name="addnewbarang">Submit</button>
        </div>
        </form>

        </div>
        </div>
    </div>
</html>
