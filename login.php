<?php
require 'function.php';

//cek login
if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    //cocokin dg database
    $cekdatabase = mysqli_query($conn,"SELECT * FROM login where username='$username' and password='$password'");
    //hitung jumlah data
    $hitung = mysqli_num_rows($cekdatabase);

    if($hitung>0){
        $_SESSION['log'] = 'True';
            header('location:index.php');
        } else {
            echo '
        <script>
            alert("Username atau Password salah");
            window.location.href="login.php";
        </script>
        ';
        }
}

if(!isset($_SESSION['log'])){

} else {
    header('location:index.php');
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Login - UKM Ngapak</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="img js-fullheight" style="background-image: url(images/contoh-gambar-scaled1.jpg);">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container vh-100 d-flex align-items-center">
        
                        <div class="row justify-content-center w-100">
                            <div class="col-lg-5">
                                
                                <div class="card shadow-lg border-0 rounded-lg" style="transform: translateY(-100px)">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
                                    <div class="card-body">
                                        <form method="post">
                                            <div class="form-floating mb-3">
                                                <input class="form-control" name="username" id="inputUsername" type="username" placeholder="username" />
                                                <label for="inputUsername">Username</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" name="password" id="inputPassword" type="password" placeholder="Password" />
                                                <label for="inputPassword">Password</label>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-center mt-4 mb-0">
                                                <button class="btn btn-primary" name="login">Login</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
