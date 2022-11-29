<?php
    require_once("connection.php");
    $result = mysqli_query($conn,"SELECT * from users");

    if(isset($_SESSION['emailPassing'])) $emailYangDipassing = $_SESSION['emailPassing'];
    else $emailYangDipassing = [];

    if(isset($_POST["btnRegister"])){
        $name = mysqli_real_escape_string($conn,strtolower(stripslashes($_POST['name'])));
        $username = mysqli_real_escape_string($conn,strtolower(stripslashes($_POST['username'])));
        $email = mysqli_real_escape_string($conn,strtolower(stripslashes($_POST['email'])));
        $password = mysqli_real_escape_string($conn,$_POST["password"]);
        $cpassword = mysqli_real_escape_string($conn,$_POST["cpassword"]);
        $tanggal = date('Y-m-d', strtotime($_POST['dob']));
        $ada = false;
        while($row = mysqli_fetch_array($result)){
            if($_POST["email"] == $row["us_email"]){
                $ada = true;
            }
            if($_POST["username"] == $row["us_username"]){
                $ada = true;
            }
        }
        if($name == "" || $username == "" || $email == "" || $password == "" || $cpassword == "" || $tanggal == ""){
            echo "<script>alert('Masih ada field yang kosong!')</script>";
        } else if($_POST["password"]!=$_POST['cpassword']){
            echo "<script>alert('Password dan Confirm Password harus sama!')</script>";
        } else if(!isset($_POST['agree'])){
            echo "<script>alert('Agree terlebih dahulu!')</script>";
        } else if(!$ada && isset($_POST['agree'])){
            $idUser = "US" . str_pad(generateIdUser($conn),3,"0", STR_PAD_LEFT);
            if(empty($_POST['gender'])){
                mysqli_query($conn,"INSERT into users (us_id, us_username, us_name, us_email, us_password, us_birth) values('$idUser', '$username','$name','$email','$password', '$tanggal')");
            } else {
                if($_POST['gender'] == "man"){
                    mysqli_query($conn,"INSERT into users (us_id, us_username, us_name, us_email, us_password, us_birth, us_gender) values('$idUser', '$username','$name','$email','$password', '$tanggal', 1)");
                } else if($_POST['gender'] == "woman"){
                    mysqli_query($conn,"INSERT into users (us_id, us_username, us_name, us_email, us_password, us_birth, us_gender) values('$idUser', '$username','$name','$email','$password', '$tanggal', 0)");
                }
            }
            echo "<script>alert('Berhasil Register!')</script>";
            header("Location: catalogAfterLogin.php");
        } else {
            echo "<script>alert('Username/ Email sudah terdaftar!')</script>";
        }
    }

    function generateIdUser($conn){
        $result = mysqli_query($conn, "SELECT MAX(SUBSTR(us_id,3,4)) FROM users");
        $now = mysqli_fetch_row($result);
        $angka = (int)$now[0];
        $angka += 1;
        return $angka;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.0/mdb.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <style>
        @media screen and (min-device-width: 300px) and (max-device-width: 500px) { 
            /* .tes{
               margin-left: 38px;
            } */

            .gambar{
                display: none;
            }
        }
        @media screen and (min-width:1000px){
            /* .tes{
                margin-left: 100px;
                margin-right: 100px;
            } */

            .gambar{
                display: block;
            }
        }

        .btnHover:hover{
            border: 1px solid #3F4441;
        }

        *{
            /* font-family: 'Josefins Sans'; */
            font-family:'Montserrat';
            /* text-transform:capitalize; */
            box-sizing: border-box;
        }

        .password-container{
            width: 400px;
            position: relative;
        }
        .password-container input[type="password"],
        .password-container input[type="text"]{
            width: 100%;
            padding: 12px 36px 12px 12px;
            box-sizing: border-box;
        }
        .fa-eye{
        position: absolute;
            top: 28%;
            right: 4%;
            cursor: pointer;
            color: lightgray;
        }

        form .form-field{
            margin-bottom:40px;
            width: 100%;
            position: relative;
        }

        form .form-field label{
            position: absolute;
            left:0;
            top:12px;
            color:#3F4441;
            transition: all .5s ease;
            pointer-events: none; 
        }

        form .form-field.active label{
            color:#3F4441;
            top:-25px;
        }

        form .form-field .border-line{
            position: absolute;
            left:0;
            bottom:0;
            width:0;
            height:2px;
            background-color:#3F4441;
            transition: all .5s ease;	
        }
        
        form .form-field.active .border-line{
            width:100%;
        }
        
        form .form-field input{
            height:40px;
            color:#3F4441;
            width: 100%;
            background-color: transparent;
            border:none;
            border-bottom:1px solid #3F4441;
        }

        html, body{
            width: 100%;
        }

    </style>
</head>
<body style="background-color:#FFDECF;">
    <nav class="navbar navbar-expand-lg sticky-top w-100" style="background-color:#3F4441;">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php" name="logodipencet">
                <img src="assets/img/logoFix.jpg" alt="Logo Petricor" width="120" height="40" class="me-2">
            </a>
            <div class="d-lg-flex justify-content-end d-sm-block mt-lg-0 mt-2">
                <a href="catalogue.php" class="link-light mt-4 ms-0 ms-lg-2 mt-lg-0 me-lg-2" style="text-decoration:none;" id="lebar">KATALOG</a>
                <span class="mx-lg-2 mx-0 mt-lg-0 text-white">|</span>
                <a href="contactUsBelumLogin.php" class="link-light mt-4 ms-0 ms-lg-2 mt-lg-0 me-lg-2" style="text-decoration:none;" id="lebar">BANTUAN</a>
                <span class="mx-lg-2 mx-0 mt-lg-0 text-white">|</span>
                <a href="login.php" class="link-light mt-4 ms-1 ms-lg-2 mt-lg-0 me-lg-2" style="text-decoration:none;" id="lebar">MASUK</a>
            </div>
        </div>
    </nav>
    <div class="row w-100">
        <div class="col-lg-5 col-sm-12 col-md-12">
            <img src="assets/img/bgRegist.jpg" alt="" style="width: 625px;" class="gambar h-100">
        </div>
        <div class="col-lg-7 col-md-12 col-sm-12 p-3 mt-lg-2">
            <h1 class="fw-bolder px-lg-4">DAFTAR</h1>
            <form class="px-lg-4 pe-0 pt-2" method="POST">
                <div class="mt-2">
                    <div class="form-field">
                        <label>Nama <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="input" autocomplete="off">
                        <div class="border-line">
                        </div>
                    </div>
                </div>
                <div class="mt-2">
                    <div class="form-field">
                        <label>Username <span class="text-danger">*</span></label>
                        <input type="text" name="username" class="input" autocomplete="off">
                        <div class="border-line">
                        </div>
                    </div>
                </div>
                <div class="mt-2">
                    <?php
                        if(isset($_SESSION['emailPassing'])){
                    ?>
                        <div class="form-field active">
                        <label>Email <span class="text-danger">*</span></label>
                        <input type='email' name='email' class='input' autocomplete='off' value='<?=$emailYangDipassing?>'>
                    <?php
                        } else {
                    ?>
                        <div class="form-field">
                        <label>Email <span class="text-danger">*</span></label>
                        <input type='email' name='email' class='input' autocomplete='off'>
                    <?php
                        }
                    ?>
                        <div class="border-line">
                        </div>
                    </div>
                </div>
                <div class="mt-2">
                    <div class="form-field">
                        <label>Password <span class="text-danger">*</span></label>
                        <input type="password" id="password" name="password" class="input" autocomplete="off">
                        <i class="fa-solid fa-eye" id="eye"></i>
                        <div class="border-line"></div>
                    </div>
                </div>
                <div class="mt-2">
                    <div class="form-field">
                        <label>Konfirmasi Password <span class="text-danger">*</span></label>
                        <input type="password" id="cpassword" name="cpassword" class="input" autocomplete="off">
                        <i class="fa-solid fa-eye" id="eyes"></i>
                        <div class="border-line"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <label>Tanggal Lahir <span class="text-danger">*</span></label>
                    <input id="startDate" class="form-control" type="date" style="background:transparent;" name="dob">
                </div>
                <div class="mb-1">
                    <label class="me-3">Jenis Kelamin (OPSIONAL)</label> <br>
                    <div class="form-check form-check-inline mt-1">
                        <input class="form-check-input" type="radio" name="gender" id="inlineRadio1" value="man">
                        <label class="form-check-label" for="inlineRadio1">Laki-laki</label>
                    </div>
                    <div class="form-check form-check-inline mt-1">
                        <input class="form-check-input" type="radio" name="gender" id="inlineRadio2" value="woman">
                        <label class="form-check-label" for="inlineRadio2">Perempuan</label>
                    </div>
                </div>
                <br>
                <h6 class="fw-bold mt-2">Kebijaksanaan Erefiv</h6>
                <span style="font-size:14px">
                Penggunaan Data Pribadi untuk Tujuan Pemasaran & Pesan Pemasaran Email oleh erefiv. Saya memahami erefiv akan menggunakan data pribadi saya untuk tujuan pemasaran dan promosi sebagaimana diatur dalam Kebijakan Privasi. Saya selanjutnya memahami bahwa alamat email saya, dan data pribadi lain yang diberikan akan digunakan untuk mengirimi saya informasi tentang merek erefiv dan produknya melalui pemberitahuan dalam aplikasi dan pesan pemasaran email ke email yang diberikan untuk membuat akun ini.
                </span>
                <br>
                <div class="row">
                    <div class="col-11">
                        <input type="checkbox" name="agree" id="">
                        <span style="font-size:14px;">
                            &emsp13; Dengan mencentang tombol "Daftar", saya setuju untuk menerima berita erefiv melalui email.
                        </span>
                    </div>
                </div> <br>
                Sudah punya akun? <a href="login.php">Masuk Sekarang!</a>
                <div class="text-end mt-3">
                    <button type="submit" class="mt-3 btn ps-4 pe-4 fw-bold text-center" style="border-radius: 50px; background-color:#8c594f; color:white;" name="btnRegister">Daftar</button>
                </div>
            </form>
        </div>
    </div>
        
    <footer class="text-center p-2" style="background-color:#5E6F64; height: 38px; font-size:12px; color:burlywood">
        &#169; 2022 Erefiv Indonesia
    </footer>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script> //buat mata password
        const passwordField = document.querySelector("#password");
        const eyeIcon= document.querySelector("#eye");
        const passwordFields = document.querySelector("#cpassword");
        const eyeIcons = document.querySelector("#eyes");
        eye.addEventListener("click", function(){
            this.classList.toggle("fa-eye-slash");
            const type = passwordField.getAttribute("type") === "password" ? "text" : "password";
            passwordField.setAttribute("type", type);
        })
        eyes.addEventListener("click", function(){
            this.classList.toggle("fa-eye-slash");
            const type = passwordFields.getAttribute("type") === "password" ? "text" : "password";
            passwordFields.setAttribute("type", type);
        })


        $(document).ready(function(){
            $(".input").focus(function(){
                $(this).parent(".form-field").addClass("active")
            })
            $(".input").blur(function(){
                if($(this).val()==""){
                    $(this).parent(".form-field").removeClass("active")
                } 
            })
       })
    </script>
</body>
</html>