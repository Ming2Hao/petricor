<?php
    require_once("connection.php");
    //PENTINGGGGGGGGG
    // if(isset($_SESSION['currentUser'])) $currentUser = $_SESSION['currentUser'];
    // else $currentUser = [];
    // if (!isset($_SESSION['currentUser'])) header("Location: index.php");
    // $user = mysqli_query($conn, "SELECT * FROM users WHERE us_id = '$currentUser'");
    // $curUser = mysqli_fetch_array($user);

    // function rupiah($angka){
    //     return "Rp " . number_format($angka,2,',','.');
    // }

    if(isset($_POST['passing'])){
        $_SESSION['emailPassing'] = $_POST['passingEmail'];
        header('Location: register.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.0/mdb.min.css" rel="stylesheet"/>
    <style>
         @media screen and (min-device-width: 300px) and (max-device-width: 500px) { 
            .kartu{
               height: 200px;
            }

            .gambar{
                display: none;
            }

            .hp{
                display: block;
            }

        }
        @media screen and (min-device-width: 600px) and (max-device-width: 950px) { 
            .kartu{
               height: 200px;
            }

            .gambar{
                display: none;
            }

            .hp{
                display: block;
            }

        }
        @media screen and (min-width:1000px){
            .kartu{
                height: 500px;
            }
            .hp{
                display: none;
            }
        }

        html, body{
            width: 100%;
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
            color:#ffff;
            transition: all .5s ease;
            pointer-events: none; 
        }

        form .form-field.active label{
            color:#ffff;
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
            color:#ffff;
            width: 100%;
            background-color: transparent;
            border:none;
            border-bottom:1px solid #3F4441;
        }
    </style>
</head>
<body style="background-color:#FFDECF;">
    <!-- <div class="container-fluid px-0"> -->
    <nav class="navbar navbar-expand-lg sticky-top w-100" style="background-color:#3F4441;">
        <div class="container-fluid d-flex">
            <a class="navbar-brand" href="index.php" name="logodipencet">
                <img src="assets/img/logoFix.jpg" alt="Logo Petricor" width="120" height="40" class="me-2">
                
            </a>
            <div class="d-lg-flex justify-content-end d-sm-block">
                <a href="catalogue.php" class="link-light mt-4 ms-0 ms-lg-2 mt-lg-0 me-lg-2" style="text-decoration:none;" id="lebar">KATALOG</a>
                <span class="mx-lg-2 mx-0 mt-lg-0 text-white">|</span>
                <a href="contactUsBelumLogin.php" class="link-light fw-bold mt-4 ms-1 ms-lg-2 mt-lg-0 me-lg-2" style="text-decoration:none;" id="lebar">BANTUAN</a>
                <span class="mx-lg-2 mx-0 mt-lg-0 text-white">|</span>
                <a href="login.php" class="link-light mt-4 ms-1 ms-lg-2 mt-lg-0 me-lg-2" style="text-decoration:none;" id="lebar">MASUK</a>
            </div>
        </div>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-2 col-12"></div>
            <div class="col-lg-8 col-12">
                <h2 class="fw-bold mt-2">Hubungi Kami</h2>
                <form action="" method="post">
                    <div class="mb-3 ">
                    <label for="exampleFormControlInput1" class="form-label">Subjek</label>
                        <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="">
                    </div>
                    <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Komentar</label>
                        <textarea class="form-control" name="comment" id="exampleFormControlTextarea1" rows="3" resize="none"></textarea>
                    </div>
                    <button type="submit" class="mt-2 btn px-5 fw-bold mb-3 text-center float-end" style="border-radius: 15px; background-color:#8c594f; color:white;" name="btnLogin" formaction="catalogAfterLogin.php">Kirim</button>
                </form>
            </div>
            <div class="col-2"></div>
        </div>
    </div>
        
       
        <div class="d-flex justify-content-center" style="height: 140px; background-color:#BA7967; color:#3F4441;">
            <form action="" method="post">
                <div class="row w-100 mx-0 d-flex">
                    <div class="col-lg-1 col-sm-0"></div>
                    <div class="col-lg-5 mt-lg-4 mt-2 me-lg-5 col-sm-12 text-white">
                        <h1 class="fw-bolder">DAFTAR SEKARANG UNTUK PENAWARAN KHUSUS</h1>
                    </div>
                    <div class="col-lg-5 mt-lg-5 mt-2 d-flex">
                        <div class="form-field">
                            <label>Email <span class="text-danger">*</span></label>
                            <input type="email" name="passingEmail" class="input" autocomplete="off">
                            <div class="border-line">
                            </div>
                        </div>
                        <button type="submit" class="mb-4" style="background:none; border: none;" name="passing">
                            <img src="assets/img/arrow.png" alt="" style="width: 25px; height:25px;">
                        </button>
                    </div>
                </div>
            </form>
        </div>
    
        <div class="row container-fluid w-100 mb-4 mt-3 mx-0 container-fluid">
        <div class="col-lg-1 me-lg-5 gambar"></div>
        <div class="col-lg-2 mt-lg-3 gambar">
            <h5 class="fw-bold mb-2">Kategori</h5>
            <ul style="list-style-type: none; margin: 0; padding: 0; font-size:12px;">
                <li><a href="catalogue.php?fcategory=CA002" style="text-decoration:none; color:#57615b">Meja Nakas</a></li>
                <li><a href="catalogue.php?fcategory=CA003" style="text-decoration:none; color:#57615b">Kursi Berlengan</a></li>
                <li><a href="catalogue.php?fcategory=CA004" style="text-decoration:none; color:#57615b">Penyimpanan Sepatu</a></li>
                <li><a href="catalogue.php?fcategory=CA005" style="text-decoration:none; color:#57615b">Kursi Sisi</a></li>
                <li><a href="catalogue.php?fcategory=CA006" style="text-decoration:none; color:#57615b">Lemari Buku</a></li>
                <li><a href="catalogue.php?fcategory=CA007" style="text-decoration:none; color:#57615b">Meja Lemari Aksen</a></li>
                <li><a href="catalogue.php?fcategory=CA008" style="text-decoration:none; color:#57615b">Meja Tamu</a></li>
                <li><a href="catalogue.php?fcategory=CA009" style="text-decoration:none; color:#57615b">Kursi Aksen</a></li>
                <li><a href="catalogue.php?fcategory=CA017" style="text-decoration:none; color:#57615b">Lemari Pajangan</a></li>
                <li><a href="catalogue.php?fcategory=CA018" style="text-decoration:none; color:#57615b">Meja Makan</a></li>
                <li><a href="catalogue.php?fcategory=CA019" style="text-decoration:none; color:#57615b">Ruang Makan</a></li>
            </ul>
        </div>
        <div class="col-lg-2 mt-lg-5 gambar">
            <ul style="list-style-type: none; margin: 0; padding: 0; font-size:12px;">
                <li><a href="catalogue.php?fcategory=CA020" style="text-decoration:none; color:#57615b">Kursi Bar</a></li>
                <li><a href="catalogue.php?fcategory=CA021" style="text-decoration:none; color:#57615b">Meja Persegi Panjang</a></li>
                <li><a href="catalogue.php?fcategory=CA022" style="text-decoration:none; color:#57615b">Bangku</a></li>
                <li><a href="catalogue.php?fcategory=CA014" style="text-decoration:none; color:#57615b">Tempat Tidur</a></li>
                <li><a href="catalogue.php?fcategory=CA023" style="text-decoration:none; color:#57615b">Meja Kerja</a></li>
                <li><a href="catalogue.php?fcategory=CA010" style="text-decoration:none; color:#57615b">Sofa 3 Dudukan</a></li>
                <li><a href="catalogue.php?fcategory=CA011" style="text-decoration:none; color:#57615b">Sofa 2 Dudukan</a></li>
                <li><a href="catalogue.php?fcategory=CA012" style="text-decoration:none; color:#57615b">Kursi Ruang Kerja</a></li>
                <li><a href="catalogue.php?fcategory=CA013" style="text-decoration:none; color:#57615b">Sofa Tempat Tidur</a></li>
                <li><a href="catalogue.php?fcategory=CA014" style="text-decoration:none; color:#57615b">Tempat Tidur</a></li>
                <li><a href="catalogue.php?fcategory=CA015" style="text-decoration:none; color:#57615b">Kursi Tulis</a></li>
            </ul>
        </div>
        <div class="col-lg-2 mt-lg-5 gambar">
            <ul style="list-style-type: none; margin: 0; padding: 0; font-size:12px;">
                <li><a href="catalogue.php?fcategory=CA016" style="text-decoration:none; color:#57615b">Lemari Pakaian</a></li>
                <li><a href="catalogue.php?fcategory=CA032" style="text-decoration:none; color:#57615b">Utilitas</a></li>
                <li><a href="catalogue.php?fcategory=CA024" style="text-decoration:none; color:#57615b">Meja Rapat</a></li>
                <li><a href="catalogue.php?fcategory=CA025" style="text-decoration:none; color:#57615b">Karpet</a></li>
                <li><a href="catalogue.php?fcategory=CA026" style="text-decoration:none; color:#57615b">Lampu</a></li>
                <li><a href="catalogue.php?fcategory=CA027" style="text-decoration:none; color:#57615b">Vas</a></li>
                <li><a href="catalogue.php?fcategory=CA028" style="text-decoration:none; color:#57615b">Obyek Dekoratif</a></li>
                <li><a href="catalogue.php?fcategory=CA029" style="text-decoration:none; color:#57615b">Anak-Anak</a></li>
                <li><a href="catalogue.php?fcategory=CA030" style="text-decoration:none; color:#57615b">Pengharum Ruangan</a></li>
                <li><a href="catalogue.php?fcategory=CA031" style="text-decoration:none; color:#57615b">Penahan Buku</a></li>
                <li><a href="catalogue.php?fcategory=CA033" style="text-decoration:none; color:#57615b">Tempat Lilin</a></li>
            </ul>
        </div>
        <div class="col-lg-2 mt-lg-5 gambar">
            <ul style="list-style-type: none; margin: 0; padding: 0; font-size:12px;">
                <li><a href="catalogue.php?fcategory=CA034" style="text-decoration:none; color:#57615b">Cermin Dinding</a></li>
                <li><a href="catalogue.php?fcategory=CA035" style="text-decoration:none; color:#57615b">Keranjang</a></li>
                <li><a href="catalogue.php?fcategory=CA036" style="text-decoration:none; color:#57615b">Aksesoris Penyimpanan</a></li>
                <li><a href="catalogue.php?fcategory=CA037" style="text-decoration:none; color:#57615b">Penyimpanan</a></li>
                <li><a href="catalogue.php?fcategory=CA038" style="text-decoration:none; color:#57615b">Linen</a></li>
                <li><a href="catalogue.php?fcategory=CA039" style="text-decoration:none; color:#57615b">Hewan Peliharaan</a></li>
                <li><a href="catalogue.php?fcategory=CA040" style="text-decoration:none; color:#57615b">Bingkai</a></li>
                <li><a href="catalogue.php?fcategory=CA041" style="text-decoration:none; color:#57615b">Bunga Imitasi</a></li>
            </ul>
        </div>
        <div class="col-lg-2 mt-lg-3 col-sm-6 gambar">
            <h5 class="fw-bold mb-2">Hukum</h5>
            <ul style="list-style-type: none; margin: 0; padding: 0; font-size:12px;">
                <li><a href="kebijakanBelumLogin.php" style="text-decoration:none; color:#57615b">Kebijakan Privasi</a></li>
                <li><a href="snkBelumLogin.php" style="text-decoration:none; color:#57615b">Syarat dan Ketentuan</a></li>
            </ul>
            <h5 class="fw-bold mb-2 mt-2">Mendukung</h5>
            <ul style="list-style-type: none; margin: 0; padding: 0; font-size:12px;">
                <li><a href="contactUsBelumLogin.php" style="text-decoration:none; color:#57615b">Hubungi Kami</a></li>
            </ul> 
        </div>
        <div class="hp">
            <div class="row">
                <div class="col-6">
                    <h5 class="fw-bold mb-2">Hukum</h5>
                    <ul style="list-style-type: none; margin: 0; padding: 0; font-size:12px;">
                        <li><a href="kebijakanBelumLogin.php" style="text-decoration:none; color:#57615b">Kebijakan Privasi</a></li>
                        <li><a href="snkBelumLogin.php" style="text-decoration:none; color:#57615b">Syarat dan Ketentuan</a></li>
                    </ul>
                </div>
                <div class="col-6">
                    <h5 class="fw-bold mb-2 mt-lg-2 mt-0">Mendukung</h5>
                    <ul style="list-style-type: none; margin: 0; padding: 0; font-size:12px;">
                        <li><a href="contactUsBelumLogin.php" style="text-decoration:none; color:#57615b">Hubungi Kami</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
        <footer class="text-center p-2" style="background-color:#5E6F64; height: 38px; font-size:12px; color:burlywood">
            &#169; 2022 Erefiv Indonesia
        </footer>
   

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>
    <script>
        // function menuToggle() {
        //     const toggleMenu = document.querySelector(".menu");
        //     toggleMenu.classList.toggle("active");
        // }
        
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