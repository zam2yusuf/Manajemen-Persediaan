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
    $img = '<img class="card-img-top" src="images/'.$gambar.'" alt="Card image" style="width:100%">';
}  
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.js">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <title>Menampilkan Barang</title>
</head>
<body>

<div class="container">
    <h3>Detail Barang:</h3>
    <div class="card mt-4" style="width:400px">
        <?=$img;?>
        <div class="card-body">
        <h4 class="card-title"><?=$namabarang;?></h4>
        <h2 class="card-text"><?=$deskripsi;?></h2>
        <h2 class="card-text">Stok : <?=$stock;?></h2>
        <a href="#" class="btn btn-primary">See Profile</a>
        </div>
    </div>
  <br>
</div>
</body>
</html>