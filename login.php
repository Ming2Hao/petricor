<?php
    require_once("connection.php");
    $result = mysqli_query($conn,"SELECT * from users");
    if(isset($_SESSION['currentUser'])) $currentUser = $_SESSION['currentUser'];
    else $currentUser = [];
    if (isset($_SESSION['currentUser'])) unset($_SESSION['currentUser']);

    if (isset($_SESSION['adminLogin'])) unset($_SESSION['adminLogin']);
    if(isset($_SESSION['adminLogin'])) $currentUser = $_SESSION['adminLogin'];
    else $adminLogin = [];

    if(isset($_POST["btnLogin"])){
        $username = $_POST["username"]; //email jg bisa
        $pass = $_POST["password"];
        if($username == "admin@gmail.com" && $pass == "admin" || $username=="admin" && $pass=="admin"){
            $_SESSION['adminLogin'] = $adminLogin;
            header("Location: admin.php");
        }
        $ada = false;
        while($row = mysqli_fetch_array($result)){
            if($username == $row["us_email"] || $username == $row["us_username"]){
                $ada = true;
                if($pass == $row["us_password"]){
                    $_SESSION['currentUser'] = $row["us_id"];
                    header("Location: catalogAfterLogin.php");
                }else{
                    echo "<script>alert('Password Salah!')</script>";
                }
                break;
            }
        }

        if(!$ada){
            echo "<script>alert('Username/ Email belum terdaftar!')</script>";
        }
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
                <div class="text-white">MASUK</div>
            </a>
            <div class= "mt-2 mt-lg-0 text-lg-end">
                <a href="" class="link-light mt-4 ms-1 ms-lg-4 ms-2 mt-lg-2 me-lg-1" style="text-decoration:none;" id="lebar">BANTUAN</a>
                <span class="mx-lg-2 mx-2 mt-lg-2 text-white">|</span>
                <a href="register.php" class="link-light mt-4 ms-1 ms-lg-2 mt-lg-2 me-lg-2" style="text-decoration:none;" id="lebar">DAFTAR</a>
                <span class="mx-lg-2 mx-2 mt-lg-2 text-white">|</span>
                <a href="#" class="link-light mt-4 ms-1 ms-lg-2 mt-lg-2 me-lg-2 fw-bold" style="text-decoration:none;" id="lebar">MASUK</a>
            </div>
        </div>
    </nav>
    <div class="row w-100">
        <div class="col-lg-5 col-sm-12 col-md-12">
            <img src="assets/img/bgRegist.jpg" alt="" style="width: 625px; height:608px;" class="gambar">
        </div>
        <div class="col-lg-7 col-md-12 col-sm-12 p-3 mt-lg-2">
            <h1 class="fw-bolder px-lg-4">MASUK</h1>
            <form class="px-lg-4 pe-0 pt-2" method="POST">
                <div class="mt-2">
                    <div class="form-field">
                        <label>Username/ Email <span class="text-danger">*</span></label>
                        <input type="text" name="username" class="input" autocomplete="off">
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
                Belum punya akun? <a href="register.php">Daftar sekarang!</a>
                <div class="text-end mt-0">
                    <button type="submit" class="mt-2 btn ps-4 pe-4 fw-bold text-center" style="border-radius: 50px; background-color:#8c594f; color:white;" name="btnLogin">Masuk</button>
                </div>
            </form>
        </div>
    </div>
        
    <footer class="text-center p-2 fixed-bottom" style="background-color:#5E6F64; height: 38px; font-size:12px; color:burlywood">
        &#169; 2022 Erefir Indonesia
    </footer>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script> //buat mata password
        const passwordField = document.querySelector("#password");
        const eyeIcon= document.querySelector("#eye");
        eye.addEventListener("click", function(){
            this.classList.toggle("fa-eye-slash");
            const type = passwordField.getAttribute("type") === "password" ? "text" : "password";
            passwordField.setAttribute("type", type);
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