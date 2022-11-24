<?php
    require_once("connection.php");
    function rupiah($angka){
        return "IDR " . number_format($angka,2,',','.');
    }
    // $_SESSION["sukses"] = 'Data Berhasil Disimpan';
    $listItem = mysqli_query($conn,"SELECT * from items");
    
    //PENTING BUAT DETEKSI USER
    if(isset($_SESSION['currentUser'])) $currentUser = $_SESSION['currentUser'];
    else $currentUser = [];
    if (!isset($_SESSION['currentUser'])) header("Location: index.php");

    $user = mysqli_query($conn, "SELECT * FROM users WHERE us_id = '$currentUser'");
    $curUser = mysqli_fetch_array($user);


    // $tempquery="SELECT * from items";


    //penting
    // if(!isset($_SESSION["querysekarang"])){
    //     $_SESSION["querysekarang"]="SELECT * from items";
    // }



    // while($row = $listItem -> fetch_assoc()){
    //     $daftarBarang[] = $row;
    // }

    //penting
    // if(isset($_POST["search"])){
    //     if(isset($_POST["searchbar"])){
    //         $_SESSION["querysekarang"]="SELECT * FROM `items` WHERE `it_name` LIKE '%".$_POST["searchbar"]."%'";
    //         $listItem = mysqli_query($conn,"SELECT * FROM `items` WHERE `it_name` LIKE '%".$_POST["searchbar"]."%'");
    //         header('Location: index.php');
    //         // $tempquery="SELECT * FROM `items` WHERE `it_name` LIKE '%".$_POST["searchbar"]."%'";
    //         // while($row = $listItem -> fetch_assoc()){
    //         //     $daftarBarang[] = $row;
    //         // }
    //     }
    // }



    if(isset($_POST["detaildiklik"])){
        $_SESSION["itemIni"]=$_POST["detaildiklik"];
        header('Location: detailBelumLogin.php');
    }
    if (!isset ($_GET['page'])) {  
        $page = 2;
    } else {  
        $page = $_GET['page'];  
    }
    $results_per_page = 4;  
    $page_first_result = ($page-1) * $results_per_page;
    $_SESSION["querysekarang"]="SELECT * FROM items ORDER BY RAND()";
    $query = $_SESSION["querysekarang"];
    $result = mysqli_query($conn, $query);  
    $number_of_result = mysqli_num_rows($result);
    $number_of_page = ceil ($number_of_result / $results_per_page);
    $page_first_result = ($page-1) * $results_per_page;   
    $query = $_SESSION["querysekarang"]." LIMIT " . $page_first_result . ',' . $results_per_page;  
    $result = mysqli_query($conn, $query);  
    $now=$page;

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
    <title>Document</title>
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

        .btnHover:hover{
            border: 1px solid #3F4441;
        }

        *{
            /* font-family: 'Josefins Sans'; */
            font-family:'Montserrat';
            /* text-transform:capitalize; */
            box-sizing: border-box;
        }

        html, body{
            width: 100%;
        }

        /* CAROUSEL THINGS */
        .drk:after {
            content: "";
            display: block;
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            background: black;
            opacity: 0.6;
            z-index: 1;
        }

        .carousel-caption {
        z-index: 2;
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
        <!-- <div class="container-fluid"> -->
        <nav class="navbar navbar-expand-lg sticky-top w-100" style="background-color:#3F4441;">
            <div class="container-fluid">
                <a class="navbar-brand" href="#" name="logodipencet">
                    <img src="assets/img/logoFix.jpg" alt="Logo Petricor" width="120" height="40" class="me-2">
                    <div class="text-white gambar">HOME</div>
                </a>
                <button class="navbar-toggler btn" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" style="border:none;">
                    <!-- <span class="navbar-toggler-icon"></span> -->
                    <img src="assets/img/burger.png" alt="" style="width:60px; height:30px;">
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item me-3">
                        <a class="nav-link text-white me-3 fw-bold" aria-current="page" href="#">HOME</a>
                    </li>
                    <li class="nav-item me-3">
                        <a class="nav-link text-white me-3" aria-current="page" href="#"></a>
                    </li> -->
                    <!-- <li class="nav-item me-3">
                        <a class="nav-link text-white me-3" aria-current="page" href="#">HISTORY</a>
                    </li> -->
                <!-- </ul> -->
                <!-- <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form> -->
                <div class="w-100 d-flex">
                    <div class="d-flex w-md-50 w-100">
                        <div class="input-group mt-1 mb-2 justify-content-end">
                            <input type="text" class="form-control ms-lg-2 w-100" autocomplete="off" placeholder="Cari barang" style="height:34px; margin-top:5px; display:none;" name="searchbar">
                            <a class="rounded me-lg-4 me-2 px-2" style="border:none; background-color:white; margin-top:5px;" href="catalogAfterLogin.php" type="submit">
                                <img src="assets/img/search.png" class="iconsearch" alt="Icon Search" style="width: 20px; height:20px;">
                            </a>   
                        </div>
                    </div>
                    <a class="mt-lg-2 me-lg-3" href="#">
                        <div class="text-white">KATALOG</div>
                    </a>
                    <!-- <div class="d-inline-block"> -->
                        <a href="cart.php" class="me-lg-5 pe-lg-4 mt-lg-2 mt-2">
                            <?php
                                $userIni = $curUser["us_id"];
                                $hitungCart = mysqli_query($conn, "SELECT COUNT(ct_it_id) FROM cart WHERE ct_us_id = '$userIni'");
                                $qtyCart = mysqli_fetch_row($hitungCart);
                            ?>
                            <i class="fa badge fa-lg p-0" value="<?=$qtyCart[0]?>">&#xf07a;</i>
                        </a>
                    <!-- </div> -->
                    
                    <div class="d-lg-flex d-sm-block">
                    <!-- <div class="dropdown me-2 me-lg-3 mt-3 mt-lg-2 ms-lg-0" id="lebar">
                        <button type="button" class="btn dropdown-toggle py-2 px-lg-3 text-white w-100" data-bs-toggle="dropdown" aria-expanded="false" style="background-color:#5E6F64;">
                            FILTERS
                        </button>
                        <ul class="dropdown-menu p-2">
                            <li><button class="dropdown-item" href="#">Name : Ascending</button></li>
                            <li><button class="dropdown-item" href="#">Name : Descending</button></li>
                            <li><button class="dropdown-item" href="#">Price : Low to High</button></li>
                            <li><button class="dropdown-item" href="#">Price : High to Low</button></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><button class="dropdown-item" href="#">All Products</button></li>
                        </ul>
                    </div> -->
                    <!-- <div class="dropdown me-2 me-lg-3 mt-3 mt-lg-2">
                        <a class="btn btn-secondary dropdown-toggle text-white py-2 px-lg-3 w-100" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false"  style="background-color:#5E6F64;">
                            KATEGORI
                        </a>

                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <?php
                                $resultkategori = mysqli_query($conn, "select * from category"); 
                                while($row = mysqli_fetch_array($resultkategori)){
                                    ?>
                                        <li><a class="dropdown-item" href="#"><?=$row["ca_name"]?></a></li>
                                    <?php
                                }
                            ?>
                        </ul>
                    </div> -->
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
                            <!-- <div class="printilan"><?=rupiah($curUser["us_saldo"])?> </div> -->
                            
                            <ul>
                            <!-- <li>
                                <img src="./assets/icons/user.png" /><a href="#">My profile</a>
                            </li>
                            <li>
                                <img src="./assets/icons/settings.png" /><a href="#">Setting</a>
                            </li>
                            <li>
                                <img src="./assets/icons/question.png" /><a href="#">Help</a>
                            </li> -->
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
    
        <!-- carousel jumbotron -->
        <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item drk active">
                    <img src="temp/bg1.jpg" class="d-block w-100 kartu" alt="..." style="z-index:-1;">
                    <div class="carousel-caption d-none d-md-block">
                        <h3 class="fw-bold">Selamat Datang di Erefiv</h3>
                        <p style="font-size:14px;">Kami siap untuk mempercantik rumah anda</p>
                    </div>
                </div>
                <div class="carousel-item drk">
                    <img src="temp/bg2.jpg" class="d-block w-100 kartu" alt="..." style="z-index:-1;">
                    <div class="carousel-caption d-none d-md-block">
                        <h3 class="fw-bold">Selamat Datang di Erefiv</h3>
                        <p style="font-size:14px;">Kami siap untuk membuat anda nyaman</p>
                    </div>    
                </div>
                <div class="carousel-item drk">
                    <img src="temp/bg3.jpg" class="d-block w-100 kartu" alt="..." style="z-index:-1;">
                    <div class="carousel-caption d-none d-md-block">
                        <h3 class="fw-bold">Selamat Datang di Erefiv</h3>
                        <p style="font-size:14px;">Kami siap untuk memperindah rumah Anda</p>
                    </div>    
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
                <img src="assets/img/previous.jpg" alt="prev" style="width: 30px; height:30px; opacity:50%; background:whitesmoke; border-radius:25px; padding: 0px 2px 0px 2px;">
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
                <img src="assets/img/next.png" alt="next" style="width: 30px; height:30px; opacity:50%; background:whitesmoke; border-radius:25px; padding: 0px 2px 0px 2px;">
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <!-- 4 REKOMENDASI TERBAIK-->
        <div class="my-lg-4 tes d-flex justify-content-center my-3 ms-lg-0 mx-lg-0 mx-5">
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
            <?php
            // for($i=0; $i<sizeof($daftarBarang); $i++){
            // $ctr = 1;
            while($row = mysqli_fetch_array($result)){
            ?>
                    <form action="" method="post">
                        <div class="col">
                            <div class="card" style="width: 300px; height: 280px; box-shadow: #3F4441 12px 15px 15px -20px; border-radius:15px; background-color:#f7f7f7;">
                                <button class="btn p-1 btnHover" style="border-radius:15px; width: 300px; height:280px;" value="<?=$row["it_id"]?>" name="detaildiklik">
                                    <div class="bg-image hover-zoom">
                                        <img src="<?=$row['it_gambar']?>" class="card-img-top bg-image hover-zoom" alt="..." style="width:200px; top:0; margin-left:auto; margin-right:auto;">
                                    </div>
                                    
                                    <div class="card-body p-0">
                                        <p class="text-secondary mb-0"><?php
                                            $querykategori="select * from category where ca_id='".$row["it_ca_id"]."'";
                                            $kat = mysqli_query($conn,$querykategori);
                                            $rowss = mysqli_fetch_array($kat);
                                            echo $rowss["ca_name"];
                                        ?></p>
                                        <p class="card-title mb-0" style="font-size:14px;"><?=$row['it_name']?></p>
                                        <!-- <p class="text-danger"><?=number_format(1000000, 0, "", "."); ?> <span class="text-secondary" style="text-decoration:line-through">Rp <?=number_format(1221000, 0, "", ".")?></span></p> -->
                                        <p class="text-danger"><?=rupiah($row['it_price'])?> <span class="text-secondary" style="text-decoration:line-through">IDR <?=number_format(17187989, 0, "", ".")?></span></p>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </form>
                    
            <?php
                    // $ctr++;
                }
            ?>
            </div>
        </div>

        <hr style="color:#BA7967">

        <div class="row container-fluid w-100 mb-4 mt-3 mx-0 container-fluid">
            <div class="col-lg-1 me-lg-5"></div>
            <div class="col-lg-2 mt-lg-3 gambar">
                <h5 class="fw-bold mb-2">Categories</h5>
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
                <h5 class="fw-bold mb-2">Legal</h5>
                <ul style="list-style-type: none; margin: 0; padding: 0; font-size:12px;">
                    <li><a href="kebijakanSudahLogin.php" style="text-decoration:none; color:#57615b">Kebijakan Privasi</a></li>
                    <li><a href="snkSudahLogin.php" style="text-decoration:none; color:#57615b">Syarat dan Ketentuan</a></li>
                </ul>
                <h5 class="fw-bold mb-2 mt-2">Support</h5>
                <ul style="list-style-type: none; margin: 0; padding: 0; font-size:12px;">
                    <li><a href="contactUsSudahLogin.php" style="text-decoration:none; color:#57615b">Hubungi Kami</a></li>
                </ul> 
            </div>
            <div class="hp">
                <div class="row">
                    <div class="col-6">
                        <h5 class="fw-bold mb-2">Legal</h5>
                        <ul style="list-style-type: none; margin: 0; padding: 0; font-size:12px;">
                            <li><a href="kebijakanSudahLogin.php" style="text-decoration:none; color:#57615b">Kebijakan Privasi</a></li>
                            <li><a href="snkSudahLogin.php" style="text-decoration:none; color:#57615b">Syarat dan Ketentuan</a></li>
                        </ul>
                    </div>
                    <div class="col-6">
                        <h5 class="fw-bold mb-2 mt-lg-2 mt-0">Support</h5>
                        <ul style="list-style-type: none; margin: 0; padding: 0; font-size:12px;">
                            <li><a href="contactUs.php" style="text-decoration:none; color:#57615b">Hubungi Kami</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <footer class="text-center p-2" style="background-color:#5E6F64; height: 38px; font-size:12px; color:burlywood">
            &#169; 2022 Erefir Indonesia
        </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
        function filterdiklik(){
            
        }
    </script>
    <script> 
        function menuToggle() {
            const toggleMenu = document.querySelector(".menu");
            toggleMenu.classList.toggle("active");
        }
    </script>
</body>
</html>