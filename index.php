<?php
    require_once("connection.php");
    function rupiah($angka){
        return "Rp " . number_format($angka,2,',','.');
    }
    // $_SESSION["sukses"] = 'Data Berhasil Disimpan';
    $listItem = mysqli_query($conn,"SELECT * from items");
    if (isset($_SESSION['currentUser'])) unset($_SESSION['currentUser']);
    if (isset($_SESSION['emailPassing'])) unset($_SESSION['emailPassing']);
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

        .btnHover:hover{
            border: 1px solid #3F4441;
        }

        *{
            /* font-family: 'Josefins Sans'; */
            font-family:'Montserrat';
            /* text-transform:capitalize; */
            box-sizing: border-box;
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
    </style>
</head>
<body style="background-color:#FFDECF;">
        <!-- <div class="container-fluid"> -->
        <nav class="navbar navbar-expand-lg sticky-top w-100" style="background-color:#3F4441;">
        <div class="container-fluid">
            <a class="navbar-brand" href="#" name="logodipencet">
                <img src="assets/img/logoFix.jpg" alt="Logo Petricor" width="120" height="40" class="me-2">
            </a>
            <button class="navbar-toggler btn" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" style="border:none;">
                <!-- <span class="navbar-toggler-icon"></span> -->
                <img src="assets/img/burger.png" alt="" style="width:60px; height:30px;">
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
                <div class="d-flex w-md-50 w-100">
                    <div class="input-group mt-1 mb-2 justify-content-end">
                        <input type="text" class="form-control ms-lg-2 w-100" autocomplete="off" placeholder="Cari barang" style="height:34px; margin-top:5px; display:none;" name="searchbar">
                        <!-- <a class="rounded me-lg-4 me-2 px-2" style="border:none; background-color:white; margin-top:5px;" href="catalogue.php" type="submit">
                            <img src="assets/img/search.png" class="iconsearch" alt="Icon Search" style="width: 20px; height:20px;">
                        </a>    -->
                    </div>
                
                <!-- <div class="d-lg-flex justify-content-end d-sm-block"> -->
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
                <!-- <div class="row"> -->
                    <!-- <div class="col-lg-3"> -->
                        <!-- <form action="">
                        <a hred="cart.php" class="d-flex">
                            <img src="assets/img/cart.png" alt="iconCart" class="me-1 mt-3 mt-lg-1 ms-lg-1" style="width:36px; height:36px;" id="lebar">
                            <div class="text-white mt-lg-2">CART</div>
                        </a>
                        </form> -->
                        <!-- <label for="cart" class="d-lg-none d-block text-white mt-4">Cart</label> -->
                    <!-- </div> -->
                    <!-- <div class="col-lg-12 mt-4 mt-lg-2"> -->
                        <!-- <div class="mt-sm-5"> -->
                            <!-- <span class="ms-lg-2 mx-0 mt-lg-2 text-white">|</span> -->
                            <!-- <div class="row-sm justify-content-center"> -->
                                
                                <a href="catalogue.php" class="link-light mt-2 ms-lg-3 mt-lg-2 me-2" style="text-decoration:none;" id="lebar">KATALOG</a>
                                <span class="mx-lg-2 mx-0 mt-2 mt-lg-2 text-white">|</span>
                                <a href="contactUsBelumLogin.php" class="link-light mt-2 ms-1 ms-lg-2 mt-lg-2 me-2" style="text-decoration:none;" id="lebar">BANTUAN</a>
                                <span class="mx-lg-2 mx-0 mt-2 mt-lg-2 text-white">|</span>
                                <a href="login.php" class="link-light mt-2 ms-1 ms-lg-2 mt-lg-2 me-2" style="text-decoration:none;" id="lebar">MASUK</a>
                            <!-- </div> -->
                        <!-- </div> -->
                    <!-- </div> -->
                <!-- </div> -->
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

        <div class="d-flex justify-content-center" style="height: 140px; background-color:#BA7967; color:#3F4441;">
            <form action="" method="post">
            <div class="row w-100 mx-0 d-flex">
                <div class="col-lg-1 col-sm-0"></div>
                <div class="col-lg-5 mt-lg-4 mt-2 me-lg-5 col-sm-12 text-white">
                    <h2 class="fw-bolder">DAFTAR SEKARANG UNTUK PENAWARAN KHUSUS</h2>
                </div>
                <!-- <div class="d-flex justify-content-end"> -->
                    <div class="col-lg-5 mt-lg-5 mt-2 d-flex">
                        <!-- <div class="mt-lg-2"> -->
                            <div class="form-field">
                                <label>Email <span class="text-danger">*</span></label>
                                <input type="email" name="passingEmail" class="input" autocomplete="off">
                                <div class="border-line">
                                </div>
                            </div>
                        <!-- </div> -->
                    
                    <!-- <div class="col-lg-1 m-lg-5"> -->
                        <button type="submit" class="mb-4" style="background:none; border: none;" name="passing">
                            <img src="assets/img/arrow.png" alt="" style="width: 25px; height:25px;">
                        </button>
                    </div>
                    <!-- </div> -->
                <!-- </div> -->
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
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
        function filterdiklik(){
            
        }
    </script>
    <script> 
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