<?php
    require_once("connection.php");
    //PENTINGGGGGGGGG
    if(isset($_SESSION['currentUser'])) $currentUser = $_SESSION['currentUser'];
    else $currentUser = [];
    if (!isset($_SESSION['currentUser'])) header("Location: index.php");
    $user = mysqli_query($conn, "SELECT * FROM users WHERE us_id = '$currentUser'");
    $curUser = mysqli_fetch_array($user);

    function rupiah($angka){
        return "Rp " . number_format($angka,2,',','.');
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
    <link href="https://use.fontawesome.com/releases/v5.0.1/css/all.css" rel="stylesheet">
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

          /* PROFILE */
          .action {
            position: fixed;
            top: 10px;
            right: 30px;
        }

        .action .profile {
            position: relative;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            overflow: hidden;
            cursor: pointer;
        }

        .action .profile img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .action .menu {
            position: absolute;
            top: 120px;
            right: -10px;
            background: #fff;
            width: 200px;
            box-sizing: 0 5px 25px rgba(0, 0, 0, 0.1);
            border-radius: 15px;
            transition: 0.5s;
            visibility: hidden;
            opacity: 0;
        }

        .action .menu.active {
            top: 50px;
            visibility: visible;
            opacity: 1;
        }

        .action .menu::before {
            content: "";
            position: absolute;
            top: 0px;
            right: 28px;
            width: 20px;
            height: 20px;
            background: #fff;
            transform: rotate(45deg);
        }

        .action .menu .username {
            width: 100%;
            text-align: center;
            font-size: 18px;
            padding: 15px 0px 0px 0px;
            font-weight: 500;
            color: #555;
        }

        .action .menu .printilan {
            width: 100%;
            text-align: center;
            font-size: 14px;
            color: #cecece;
        }

        /* .action .menu h3 span {
            font-size: 14px;
            color: #cecece;
            font-weight: 300;
        } */

        .action .menu ul li {
            list-style: none;
            padding: 16px 0;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
        }

        .action .menu ul li img {
            max-width: 20px;
            margin-right: 10px;
            opacity: 0.5;
            transition: 0.5s;
        }

        .action .menu ul li:hover img {
            opacity: 1;
        }

        .action .menu ul li a {
            display: inline-block;
            text-decoration: none;
            color: #555;
            font-weight: 500;
            transition: 0.5s;
        }

        .action .menu ul li:hover a {
            color: #ff5d94;
        }

        /* KERANJANG */
        .badge:after{
            content:attr(value);
            font-size:15px;
            color: #fff;
            background: red;
            border-radius:50%;
            padding: 0 5px;
            position:relative;
            left:-8px;
            top:-10px;
            opacity:0.9;
        }
    </style>
</head>
<body style="background-color:#FFDECF;">
    <div class="container-fluid px-0">
    <nav class="navbar navbar-expand-lg sticky-top w-100" style="background-color:#3F4441;">
        <div class="container-fluid">
            <a class="navbar-brand" href="indexSudahLogin.php" name="logodipencet">
                <img src="assets/img/logoFix.jpg" alt="Logo Petricor" width="120" height="40" class="me-2">
                <div class="text-white"></div>
            </a>
            <!-- <div class="collapse navbar-collapse" id="navbarSupportedContent"> -->
            <div class="d-flex justify-content-end">
                <a href="cart.php" class="me-5 pe-3 d-flex">
                    <?php
                        $userIni = $curUser["us_id"];
                        $hitungCart = mysqli_query($conn, "SELECT COUNT(ct_it_id) FROM cart WHERE ct_us_id = '$userIni'");
                        $qtyCart = mysqli_fetch_row($hitungCart);
                    ?>
                    <i class="fa badge fa-lg p-0" value="<?=$qtyCart[0]?>">&#xf07a;</i>
                </a>
                <div class="d-lg-flex d-sm-block">
                    <!-- PROFILEEEEEEEEEE USERRRRRRR -->
                    <div class="action">
                        <div class="profile" onclick="menuToggle();">
                            <img src="temp/nahida2.jpg">
                        </div>
                        <div class="menu">
                            <div class="username" style="margin-bottom: -5px">
                                <?=$curUser["us_name"]?>
                            </div>
                            <div class="printilan"><?=$curUser["us_username"]?> </div>
                            <ul>
                            <li>
                                <img src="assets/img/logout.png" /><a href="index.php">Logout</a>
                            </li>
                            </ul>
                        </div>  
                    </div>
                    
                </div>
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
        </div>
        <br><br>
        <hr style="color:#BA7967">
        <div class="row container-fluid w-100 mb-4 mt-3 mx-0 container-fluid">
            <div class="col-lg-1 me-lg-5"></div>
            <div class="col-lg-2 mt-lg-3 gambar">
                <h5 class="fw-bold mb-2">Kategori</h5>
                <ul style="list-style-type: none; margin: 0; padding: 0; font-size:12px;">
                    <li><a href="catalogAfterLogin.php?fcategory=CA002" style="text-decoration:none; color:#57615b">Meja Nakas</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA003" style="text-decoration:none; color:#57615b">Kursi Berlengan</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA004" style="text-decoration:none; color:#57615b">Penyimpanan Sepatu</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA005" style="text-decoration:none; color:#57615b">Kursi Sisi</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA006" style="text-decoration:none; color:#57615b">Lemari Buku</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA007" style="text-decoration:none; color:#57615b">Meja Lemari Aksen</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA008" style="text-decoration:none; color:#57615b">Meja Tamu</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA009" style="text-decoration:none; color:#57615b">Kursi Aksen</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA017" style="text-decoration:none; color:#57615b">Lemari Pajangan</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA018" style="text-decoration:none; color:#57615b">Meja Makan</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA019" style="text-decoration:none; color:#57615b">Ruang Makan</a></li>
                </ul>
            </div>
            <div class="col-lg-2 mt-lg-5 gambar">
                <ul style="list-style-type: none; margin: 0; padding: 0; font-size:12px;">
                    <li><a href="catalogAfterLogin.php?fcategory=CA020" style="text-decoration:none; color:#57615b">Kursi Bar</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA021" style="text-decoration:none; color:#57615b">Meja Persegi Panjang</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA022" style="text-decoration:none; color:#57615b">Bangku</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA014" style="text-decoration:none; color:#57615b">Tempat Tidur</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA023" style="text-decoration:none; color:#57615b">Meja Kerja</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA010" style="text-decoration:none; color:#57615b">Sofa 3 Dudukan</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA011" style="text-decoration:none; color:#57615b">Sofa 2 Dudukan</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA012" style="text-decoration:none; color:#57615b">Kursi Ruang Kerja</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA013" style="text-decoration:none; color:#57615b">Sofa Tempat Tidur</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA014" style="text-decoration:none; color:#57615b">Tempat Tidur</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA015" style="text-decoration:none; color:#57615b">Kursi Tulis</a></li>
                </ul>
            </div>
            <div class="col-lg-2 mt-lg-5 gambar">
                <ul style="list-style-type: none; margin: 0; padding: 0; font-size:12px;">
                    <li><a href="catalogAfterLogin.php?fcategory=CA016" style="text-decoration:none; color:#57615b">Lemari Pakaian</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA032" style="text-decoration:none; color:#57615b">Utilitas</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA024" style="text-decoration:none; color:#57615b">Meja Rapat</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA025" style="text-decoration:none; color:#57615b">Karpet</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA026" style="text-decoration:none; color:#57615b">Lampu</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA027" style="text-decoration:none; color:#57615b">Vas</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA028" style="text-decoration:none; color:#57615b">Obyek Dekoratif</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA029" style="text-decoration:none; color:#57615b">Anak-Anak</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA030" style="text-decoration:none; color:#57615b">Pengharum Ruangan</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA031" style="text-decoration:none; color:#57615b">Penahan Buku</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA033" style="text-decoration:none; color:#57615b">Tempat Lilin</a></li>
                </ul>
            </div>
            <div class="col-lg-2 mt-lg-5 gambar">
                <ul style="list-style-type: none; margin: 0; padding: 0; font-size:12px;">
                    <li><a href="catalogAfterLogin.php?fcategory=CA034" style="text-decoration:none; color:#57615b">Cermin Dinding</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA035" style="text-decoration:none; color:#57615b">Keranjang</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA036" style="text-decoration:none; color:#57615b">Aksesoris Penyimpanan</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA037" style="text-decoration:none; color:#57615b">Penyimpanan</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA038" style="text-decoration:none; color:#57615b">Linen</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA039" style="text-decoration:none; color:#57615b">Hewan Peliharaan</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA040" style="text-decoration:none; color:#57615b">Bingkai</a></li>
                    <li><a href="catalogAfterLogin.php?fcategory=CA041" style="text-decoration:none; color:#57615b">Bunga Imitasi</a></li>
                </ul>
            </div>
            <div class="col-lg-2 mt-lg-3 col-sm-6 gambar">
                <h5 class="fw-bold mb-2">Hukum</h5>
                <ul style="list-style-type: none; margin: 0; padding: 0; font-size:12px;">
                    <li><a href="#" style="text-decoration:none; color:#57615b">Kebijakan Privasi</a></li>
                    <li><a href="snkSudahLogin.php" style="text-decoration:none; color:#57615b">Syarat dan Ketentuan</a></li>
                </ul>
                <h5 class="fw-bold mb-2 mt-2">Mendukung</h5>
                <ul style="list-style-type: none; margin: 0; padding: 0; font-size:12px;">
                    <li><a href="contactUs.php" style="text-decoration:none; color:#57615b">Hubungi Kami</a></li>
                </ul> 
            </div>
            <div class="hp">
                <div class="row">
                    <div class="col-6">
                        <h5 class="fw-bold mb-2">Hukum</h5>
                        <ul style="list-style-type: none; margin: 0; padding: 0; font-size:12px;">
                            <li><a href="kebijakanSudahLogin.php" style="text-decoration:none; color:#57615b">Kebijakan Privasi</a></li>
                            <li><a href="snkSudahLogin.php" style="text-decoration:none; color:#57615b">Syarat dan Ketentuan</a></li>
                        </ul>
                    </div>
                    <div class="col-6">
                        <h5 class="fw-bold mb-2 mt-lg-2 mt-0">Mendukung</h5>
                        <ul style="list-style-type: none; margin: 0; padding: 0; font-size:12px;">
                            <li><a href="contactUs.php" style="text-decoration:none; color:#57615b">Hubungi Kami</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <footer class="text-center p-2 fixed-bottom" style="background-color:#5E6F64; height: 38px; font-size:12px; color:burlywood">
            &#169; 2022 Erefiv Indonesia
        </footer>
       
    
   

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>
    <script>
        function menuToggle() {
            const toggleMenu = document.querySelector(".menu");
            toggleMenu.classList.toggle("active");
        }
    </script>
</body>
</html>