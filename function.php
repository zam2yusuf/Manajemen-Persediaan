<?php
session_start();

//konek ke database
$conn = mysqli_connect("localhost","root","","stockbarang");

//Tambah barang baru
if(isset($_POST['addnewbarang'])){
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];
    $stock = $_POST['stock'];

    //Soal gambar
    $allowed_extension = array('png','jpg');
    $nama = $_FILES['file']['name']; //ambil nama gambar
    $dot = explode('.',$nama);
    $ekstensi = strtolower(end($dot)); //ambil ekstensi
    $ukuran = $_FILES['file']['size']; //ambil size
    $file_tmp = $_FILES['file']['tmp_name']; //ambil lokasi file

    //penamaan file -> enkripsi
    $image = md5(uniqid($nama,true) . time()).'.'.$ekstensi; //menggabungkan nama file terenkripsi dan ekstensi 
 
    //validasi udah ada atau belum
    $cek = mysqli_query($conn,"select * from stock where namabarang='$namabarang'");
    $hitung = mysqli_num_rows($cek);

    if($hitung<1){
        //jika belum ada

        //proses upload gambar
        if(in_array($ekstensi, $allowed_extension) === true){
            //validasi ukuran filenya
            if($ukuran < 15000000){
                move_uploaded_file($file_tmp, 'images/'.$image);
                
                $addtotable = mysqli_query($conn,"insert into stock(namabarang, deskripsi, stock, image) values('$namabarang','$deskripsi','$stock','$image')");
                if($addtotable){
                    header('location:index.php');
                } else {
                    echo 'Gagal';
                    header('location:index.php');
                }
            } else {
                //kalau filenya lebih dari 15MB
                echo '
                <script>
                    alert("Ukuran gambar terlalu besar");
                    window.location.href="index.php";
                </script>
                ';
            }
        } else {
            //kalau file tidak png/jpg
            echo '
            <script>
                alert("Format file harus PNG/JPG");
                window.location.href="index.php";
            </script>
            ';
        }

    } else {
        //jika sudah ada
        echo '
        <script>
            alert("Nama barang sudah terdaftar");
            window.location.href="index.php";
        </script>
        ';
    }
};

//tambah barang masuk
if(isset($_POST['barangmasuk'])){
    $barangnya= $_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];
    $admin = $_POST['admin'];

    $cekstocksekarang = mysqli_query($conn,"select * from stock where idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];
    $tambahkanstocksekarangdenganqty = $stocksekarang+$qty;

    $addtomasuk = mysqli_query($conn,"insert into masuk(idbarang, keterangan, qty, admin) values('$barangnya','$penerima','$qty','$admin')");
    $updatestockmasuk = mysqli_query($conn,"update stock set stock='$tambahkanstocksekarangdenganqty' where idbarang='$barangnya'");
    if($addtomasuk&&$updatestockmasuk){
        header('location:masuk.php');
    } else {
        echo 'Gagal';
        header('location:masuk.php');
    }
}

//tambah barang keluar
if(isset($_POST['addbarangkeluar'])){
    $barangnya= $_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];
    $admin = $_POST['admin'];

    $cekstocksekarang = mysqli_query($conn,"select * from stock where idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];

    if($stocksekarang >= $qty){
        //Kalau barang cukup
        $tambahkanstocksekarangdenganqty = $stocksekarang-$qty;

        $addtokeluar = mysqli_query($conn,"insert into keluar(idbarang, penerima, qty, admin) values('$barangnya','$penerima','$qty','$admin')");
        $updatestockmasuk = mysqli_query($conn,"update stock set stock='$tambahkanstocksekarangdenganqty' where idbarang='$barangnya'");

        if($addtokeluar&&$updatestockmasuk){
            header('location:keluar.php');
        } else {
            echo 'Gagal';
            header('location:keluar.php');
        }
    } else {
        //Kalau barang tidak cukup
        echo '
        <script>
            alert("Stok saat ini tidak mencukupi");
            window.location.href="keluar.php";
        </script>
        ';
    }
}

//Update info barang
if(isset($_POST['updatebarang'])){
    $idb = $_POST['idb'];
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];
    $stock = $_POST['stock'];
    
    //Soal gambar
    $allowed_extension = array('png','jpg');
    $nama = $_FILES['file']['name']; //ambil nama gambar
    $dot = explode('.',$nama);
    $ekstensi = strtolower(end($dot)); //ambil ekstensi
    $ukuran = $_FILES['file']['size']; //ambil size
    $file_tmp = $_FILES['file']['tmp_name']; //ambil lokasi file

    //penamaan file -> enkripsi
    $image = md5(uniqid($nama,true) . time()).'.'.$ekstensi; //menggabungkan nama file terenkripsi dan ekstensi

    if($ukuran==0){
        //jika tidak ingin upload
        $update = mysqli_query($conn,"update stock set namabarang='$namabarang', deskripsi='$deskripsi', stock='$stock' where idbarang='$idb'");
        if($update){
            header('location:index.php');
        } else {
            echo 'Gagal';
            header('location:index.php');
        }
    } else {
        //jika ingin upload
        move_uploaded_file($file_tmp, 'images/'.$image);
        $update = mysqli_query($conn,"update stock set namabarang='$namabarang', deskripsi='$deskripsi', stock='$stock', image='$image' where idbarang='$idb'");
        if($update){
            header('location:index.php');
        } else {
            echo 'Gagal';
            header('location:index.php');
        }
    }
}

//Hapus barang
if(isset($_POST['hapusbarang'])){
    $idb = $_POST['idb']; //id barang

    $gambar = mysqli_query($conn,"select * from stock where idbarang='$idb'");
    $get = mysqli_fetch_array($gambar);
    $img = 'images/'.$get['image'];
    unlink($img);

    $hapus = mysqli_query($conn,"delete from stock where idbarang='$idb'");
    if($hapus){
        header('location:index.php');
    } else {
        echo 'Gagal';
        header('location:index.php');
    }
}

//Mengubah data barang masuk
if(isset($_POST['updatebarangmasuk'])){
    $idb = $_POST['idb'];
    $idm = $_POST['idm'];
    $keterangan = $_POST['keterangan'];
    $qty = $_POST['qty'];
    $admin = $_POST['admin'];

    $lihatstock = mysqli_query($conn,"select * from stock where idbarang='$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockskrg = $stocknya['stock'];

    $qtyskrg = mysqli_query($conn,"select * from masuk where idmasuk='$idm'");
    $qtynya = mysqli_fetch_array($qtyskrg);
    $qtyskrg = $qtynya['qty'];

    if($qty>$qtyskrg){
        $selisih = $qty-$qtyskrg;
        $kurangin = $stockskrg + $selisih;
        $kurangistocknya = mysqli_query($conn,"update stock set stock='$kurangin' where idbarang='$idb'");
        $updatenya = mysqli_query($conn,"update masuk set qty='$qty', keterangan='$keterangan', admin='$admin' where idmasuk='$idm'");

    if($kurangistocknya&&$updatenya){
        header('location:masuk.php');
    } else {
        echo 'Gagal';
        header('location:masuk.php');
    }
    } else {
        $selisih = $qtyskrg-$qty;
        $kurangin = $stockskrg - $selisih;
        $kurangistocknya = mysqli_query($conn,"update stock set stock='$kurangin' where idbarang='$idb'");
        $updatenya = mysqli_query($conn,"update masuk set qty='$qty', keterangan='$keterangan', admin='$admin' where idmasuk='$idm'");

    if($kurangistocknya&&$updatenya){
        header('location:masuk.php');
    } else {
        echo 'Gagal';
        header('location:masuk.php');
    }
    }
}

//Hapus barang masuk
if(isset($_POST['hapusbarangmasuk'])){
    $idb = $_POST['idb'];
    $idm = $_POST['idm'];
    $qty = $_POST['kty'];

    $getdatastock = mysqli_query($conn,"select * from stock where idbarang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stok = $data['$stock'];

    $selisih = $stok-$qty;

    $update = mysqli_query($conn,"update stock set stock='$selisih' where idbarang='$idb'");
    $hapusdata = mysqli_query($conn,"delete from masuk where idmasuk='$idm'");

    if($update&&$hapusdata){
        header('location:masuk.php');
    } else {
        echo 'Gagal';
        header('location:masuk.php');
    }
}

//Mengubah data barang keluar
if(isset($_POST['updatebarangkeluar'])){
    $idb = $_POST['idb'];
    $idk = $_POST['idk'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty']; //Jumlah baru inputan user
    $admin = $_POST['admin'];

    //Mengambil stock barang saat ini
    $lihatstock = mysqli_query($conn,"select * from stock where idbarang='$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockskrg = $stocknya['stock'];

    //Jumlah barang keluar saat ini
    $qtyskrg = mysqli_query($conn,"select * from keluar where idkeluar='$idk'");
    $qtynya = mysqli_fetch_array($qtyskrg);
    $qtyskrg = $qtynya['qty'];

    if($qty>$qtyskrg){
        $selisih = $qty-$qtyskrg;
        $kurangin = $stockskrg - $selisih;
        
        if($selisih <= $stockskrg){
            $kurangistocknya = mysqli_query($conn,"update stock set stock='$kurangin' where idbarang='$idb'");
            $updatenya = mysqli_query($conn,"update keluar set qty='$qty', penerima='$penerima', admin='$admin' where idkeluar='$idk'");
                if($kurangistocknya&&$updatenya){
                    header('location:keluar.php');
                } else {
                    echo 'Gagal';
                    header('location:keluar.php');
            }
        } else {
            echo '
            <script>alert("Stok tidak mencukupi");
            window.location.href="keluar.php";
            </script>
            ';
        }
    } else {
        $selisih = $qtyskrg-$qty;
        $kurangin = $stockskrg + $selisih;
        $kurangistocknya = mysqli_query($conn,"update stock set stock='$kurangin' where idbarang='$idb'");
        $updatenya = mysqli_query($conn,"update keluar set qty='$qty', penerima='$penerima', admin='$admin' where idkeluar='$idk'");

    if($kurangistocknya&&$updatenya){
        header('location:keluar.php');
    } else {
        echo 'Gagal';
        header('location:keluar.php');
    }
    }
}

//Hapus barang keluar
if(isset($_POST['hapusbarangkeluar'])){
    $idb = $_POST['idb'];
    $idk = $_POST['idk'];
    $qty = $_POST['kty'];

    $getdatastock = mysqli_query($conn,"select * from stock where idbarang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stok = $data['$stock'];

    $selisih = $stok + $qty;

    $update = mysqli_query($conn,"update stock set stock='$selisih' where idbarang='$idb'");
    $hapusdata = mysqli_query($conn,"delete from keluar where idkeluar='$idk'");

    if($update&&$hapusdata){
        header('location:keluar.php');
    } else {
        echo 'Gagal';
        header('location:keluar.php');
    }
}

//Tambah admin baru
if(isset($_POST['addadmin'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $queryinsert = mysqli_query($conn,"insert into login (username, password) values ('$username','$password')");
    
    if($queryinsert){
        //if berhasil
        header('location:admin.php');
    } else {
        //kalau gagal insert
        echo 'Gagal';
        header('location:masuk.php');
    }
}

//Update data admin
if(isset($_POST['updateadmin'])){
    $idnya = $_POST['id'];
    $usernamebaru = $_POST['usernameadmin'];
    $passwordbaru = $_POST['passwordbaru'];

    $queryupdate = mysqli_query($conn,"update login set username='$usernamebaru', password='$passwordbaru' where iduser='$idnya'");
    if($quaryupdate){
        header('location:admin.php');
    } else {
        echo 'Gagal';
        header('location:admin.php');
    }
}

//Hapus admin
if(isset($_POST['hapusadmin'])){
    $id = $_POST['id'];

    $querydelete = mysqli_query($conn,"delete from login where iduser='$id'");
    if($querydelete){
        header('location:admin.php');
    } else {
        echo 'Gagal';
        header('location:admin.php');
    }
}

?>