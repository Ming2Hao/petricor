<?php
    require_once("connection.php");
    if (isset($_SESSION['emailPassing'])) unset($_SESSION['emailPassing']);
    function rupiah($angka){
        return "IDR " . number_format($angka,2,',','.');
    }
    // $_SESSION["sukses"] = 'Data Berhasil Disimpan';
    $listItem = mysqli_query($conn,"SELECT * from items");
    // $tempquery="SELECT * from items";
    if(!isset($_SESSION["querysekarang"])){
        $_SESSION["querysekarang"]="SELECT * from items";
    }
    // while($row = $listItem -> fetch_assoc()){
    //     $daftarBarang[] = $row;
    // }
    if(isset($_POST["search"])){
        if(isset($_POST["searchbar"])){
            // echo "<script>alert('haha') </script>";
            $_SESSION["querysekarang"]="SELECT * FROM `items` WHERE `it_name` LIKE '%".$_POST["searchbar"]."%'";
            // $listItem = mysqli_query($conn,"SELECT * FROM `items` WHERE `it_name` LIKE '%".$_POST["searchbar"]."%'");
            header('Location: catalogue.php');
            // $tempquery="SELECT * FROM `items` WHERE `it_name` LIKE '%".$_POST["searchbar"]."%'";
            // while($row = $listItem -> fetch_assoc()){
            //     $daftarBarang[] = $row;
            // }
        }
    }
    if(isset($_POST["detaildiklik"])){
        $_SESSION["itemIni"]=$_POST["detaildiklik"];
        header('Location: detailBelumLogin.php');
    }
    if (!isset ($_GET['page'])) {  
        $page = 2;
    } else {  
        $page = $_GET['page'];  
    }
    $results_per_page = 18;  
    $page_first_result = ($page-1) * $results_per_page;
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
        @media screen and (min-device-width: 300px) and (max-device-width: 400px) { 
            .tes{
               margin-left: 38px;
            }
        }
        @media screen and (min-width:1000px){
            .tes{
                margin-left: 100px;
                margin-right: 100px;
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
    <nav class="navbar navbar-expand-lg sticky-top w-100" style="background-color:#3F4441;">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php" name="logodipencet">
                <img src="assets/img/logoFix.jpg" alt="Logo Petricor" width="120" height="40" class="me-2">
                <div class="text-white">KATALOG</div>
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
            <div class="d-flex w-md-50 w-75">
                <form action="" method="post" class="d-flex container-fluid">
                <div class="input-group">

                    <input type="text" class="form-control ms-lg-2 w-100" placeholder="Cari barang" style="height:34px; margin-top:5px;" name="searchbar">
                    
                    <button class="rounded-end me-lg-4 me-2" style="border:none; background-color:white; margin-top:5px;" name="search" type="submit">
                        <img src="assets/img/search.png" class="iconsearch" alt="Icon Search" style="width: 20px; height:20px;">
                    </button>   
                    
                </div>
                </form>
            </div>
            </form>
            <div class="d-lg-flex justify-content-end d-sm-block">
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
                            <a href="catalogue.php" class="link-light mt-4 ms-1 ms-lg-3 ms-5 mt-lg-0 me-lg-2 fw-bold" style="text-decoration:none;" id="lebar">KATALOG</a>
                            <span class="mx-lg-2 mx-0 mt-lg-0 text-white">|</span>
                            <a href="" class="link-light mt-4 ms-1 ms-lg-2 mt-lg-0 me-lg-2" style="text-decoration:none;" id="lebar">BANTUAN</a>
                            <span class="mx-lg-2 mx-0 mt-lg-0 text-white">|</span>
                            <a href="login.php" class="link-light mt-4 ms-1 ms-lg-2 mt-lg-0 me-lg-2" style="text-decoration:none;" id="lebar">MASUK</a>
                        <!-- </div> -->
                    <!-- </div> -->
                <!-- </div> -->
            </div>
        </div>
    </nav>

        <div class="container-fluid">
            <!-- munculin gambar -->
            <!-- <div class="mt-lg-3"> -->
                <div class="row">
                    <div class="col-lg-3 sm-d-none" style="background-color:#f7f3f2;">
                        <div class="accordion pt-3" id="accordionPanelsStayOpenExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                                    Filter Kategori
                                </button>
                                </h2>
                                <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingOne">
                                <div class="accordion-body">
                                <?php
                                    $resultkategori = mysqli_query($conn, "select * from category where ca_id != 'CA001'"); 
                                    while($row = mysqli_fetch_array($resultkategori)){
                                        ?>
                                            <!-- <li><a class="dropdown-item" href="#"></a></li> -->
                                            <input type="checkbox" name="" id="" class="me-3"> <?=$row["ca_name"]?> <br>
                                        <?php
                                    }
                                ?>
                                </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                                    Sort
                                </button>
                                </h2>
                                <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo">
                                <div class="accordion-body">
                                    <input type="radio" name="" id=""> Nama: A-Z <br>
                                    <input type="radio" name="" id=""> Nama: Z-A <br>
                                    <input type="radio" name="" id=""> Harga: Rendah-Tinggi <br>
                                    <input type="radio" name="" id=""> Harga: Tinggi-Rendah <br>
                                </div>
                                </div>
                            </div>
                        <!-- <div class="accordion-item">
                            <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                                Range
                            </button>
                            </h2>
                            <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingThree">
                            <div class="accordion-body">
                                <strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                            </div>
                            </div>
                        </div> -->
                        </div> 
                    </div>
                    <div class="col-lg-9 d-flex justify-content-center mt-lg-3">
                        <div class="row row-cols-sm-1 row-cols-md-2 row-cols-lg-3 g-3 w-100">
                            <?php
                            
                            // for($i=0; $i<sizeof($daftarBarang); $i++){
                            while($row = mysqli_fetch_assoc($result)){
                            ?>
                                <div class="col d-flex justify-content-center" style="width: 350px;">
                                    <div class="card" style="width: 300px; height: 280px; box-shadow: #3F4441 12px 15px 15px -20px; border-radius:15px; background-color:#f7f7f7;">
                                        <form action="" method="post">    
                                            <button class="btn p-1 btnHover" style="border-radius:15px; width: 300px; height:280px;" value="<?=$row["it_id"]?>" name="detaildiklik">
                                                <div class="bg-image hover-zoom">
                                                    <img src="<?=$row['it_gambar']?>" class="card-img-top bg-image hover-zoom" alt="..." style="width:200px; top:0; margin-left:auto; margin-right:auto;">
                                                </div>
                                                
                                                <div class="card-body p-0">
                                                    <p class="text-secondary mb-0">
                                                        <?php
                                                        $querykategori="select * from category where ca_id='".$row["it_ca_id"]."'";
                                                        $kat = mysqli_query($conn,$querykategori);
                                                        $rowss = mysqli_fetch_assoc($kat);
                                                        echo $rowss["ca_name"];
                                                        ?>
                                                    </p>
                                                    <p class="card-title mb-0" style="font-size:14px;"><?=$row['it_name']?></p>
                                                    <!-- <p class="text-danger"><?=number_format(1000000, 0, "", "."); ?> <span class="text-secondary" style="text-decoration:line-through">Rp <?=number_format(1221000, 0, "", ".")?></span></p> -->
                                                    <p class="text-danger"><?=rupiah($row['it_price'])?> <span class="text-secondary" style="text-decoration:line-through">IDR <?=number_format(17187989, 0, "", ".")?></span></p>
                                                </div>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            <?php
                                }
                            ?>
                        </div>
                    </div>
                </div>
                
            <!-- </div> -->
            <div class="row">
                <div class="col-lg-3 sm-d-none" style="background-color:#f7f3f2;">

                </div>
                <div class="col-lg-9">
                    <div class="row w-100">
                        <nav aria-label="..." class="w-100 d-flex justify-content-center mt-3">
                            <ul class="pagination" class="w-100 d-flex">
                                <?php
                                    if($now==1){
                                        ?>
                                            <li class="page-item disabled d-flex">
                                                <a class="page-link">Previous</a>
                                            </li>
                                        <?php
                                    }
                                    else{
                                        ?>
                                            <li class="page-item d-flex">
                                                <a class="page-link" href="catalogue.php?page=<?=$now-1?>">Previous</a>
                                            </li>
                                        <?php
                                    }
                                ?>
                                <?php
                                    for($page = 1; $page<= $number_of_page; $page++) {
                                        if($page==$now){
                                            ?>
                                                <li class="page-item active d-flex" aria-current="page">
                                                    <a class="page-link" href="catalogue.php?page=<?=$page?>"><?=$page?></a>
                                                </li>
                                            <?php
                                        }
                                        else{
                                            ?>
                                                <li class="page-item d-flex">
                                                    <a class="page-link" href="catalogue.php?page=<?=$page?>"><?=$page?></a>
                                                </li>
                                            <?php
                                        }
                                    }
                                ?>
                                <?php
                                    if($now==$number_of_page){
                                        ?>
                                            <li class="page-item disabled d-flex">
                                                <a class="page-link">Next</a>
                                            </li>
                                        <?php
                                    }
                                    else{
                                        ?>
                                            <li class="page-item d-flex">
                                                <a class="page-link" href="catalogue.php?page=<?=$now+1?>">Next</a>
                                            </li>
                                        <?php
                                    }
                                ?>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-center mb-lg-4" style="height: 130px; background-color:#BA7967; color:#3F4441;">
            <form action="" method="post">
            <div class="row w-100 mx-0">
                <div class="col-lg-1"></div>
                <div class="col-lg-5 mt-lg-3 me-lg-5 text-white">
                    <h1 class="fw-bolder">REGISTER NOW FOR SPECIAL OFFERS</h1>
                </div>
            
                <div class="col-lg-4 mt-5">
                    <div class="mt-2">
                        <div class="form-field">
                            <label>Email <span class="text-danger">*</span></label>
                            <input type="text" name="passingEmail" class="input" autocomplete="off">
                            <div class="border-line">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-1" style="margin-top:65px;">
                    <button type="submit" style="background:none; border: none;" name="passing">
                        <img src="assets/img/arrow.png" alt="" style="width: 25px; height:25px;">
                    </button>
                </div>
                
            </div>
            </form>
        </div>

        <div class="row container-fluid w-100 mb-4 mt-3 mx-0 container-fluid">
            <div class="col-lg-1 me-lg-5"></div>
            <div class="col-lg-2 mt-lg-3">
                <h5 class="fw-bold mb-2">Categories</h5>
                <ul style="list-style-type: none; margin: 0; padding: 0; font-size:12px;">
                    <li><a href="footerBelumLogin/mejanakas.php" style="text-decoration:none; color:#57615b">Meja Nakas</a></li>
                    <li><a href="footerBelumLogin/mejanakas.php" style="text-decoration:none; color:#57615b">Kursi Berlengan</a></li>
                    <li><a href="footerBelumLogin/mejanakas.php" style="text-decoration:none; color:#57615b">Penyimpanan Sepatu</a></li>
                    <li><a href="footerBelumLogin/mejanakas.php" style="text-decoration:none; color:#57615b">Kursi Sisi</a></li>
                    <li><a href="footerBelumLogin/mejanakas.php" style="text-decoration:none; color:#57615b">Lemari Buku</a></li>
                    <li><a href="footerBelumLogin/mejanakas.php" style="text-decoration:none; color:#57615b">Meja Lemari Aksen</a></li>
                    <li><a href="footerBelumLogin/mejanakas.php" style="text-decoration:none; color:#57615b">Meja Tamu</a></li>
                    <li><a href="footerBelumLogin/mejanakas.php" style="text-decoration:none; color:#57615b">Kursi Aksen</a></li>
                    <li><a href="footerBelumLogin/mejanakas.php" style="text-decoration:none; color:#57615b">Lemari Pajangan</a></li>
                    <li><a href="footerBelumLogin/mejanakas.php" style="text-decoration:none; color:#57615b">Meja Makan</a></li>
                    <li><a href="footerBelumLogin/mejanakas.php" style="text-decoration:none; color:#57615b">Ruang Makan</a></li>
                </ul>
            </div>
            <div class="col-lg-2 mt-lg-5">
                <ul style="list-style-type: none; margin: 0; padding: 0; font-size:12px;">
                    <li><a href="footerBelumLogin/mejanakas.php" style="text-decoration:none; color:#57615b">Kursi Bar</a></li>
                    <li><a href="footerBelumLogin/mejanakas.php" style="text-decoration:none; color:#57615b">Meja Persegi Panjang</a></li>
                    <li><a href="footerBelumLogin/mejanakas.php" style="text-decoration:none; color:#57615b">Bangku</a></li>
                    <li><a href="footerBelumLogin/mejanakas.php" style="text-decoration:none; color:#57615b">Tempat Tidur</a></li>
                    <li><a href="footerBelumLogin/mejanakas.php" style="text-decoration:none; color:#57615b">Meja Kerja</a></li>
                    <li><a href="footerBelumLogin/mejanakas.php" style="text-decoration:none; color:#57615b">Sofa 3 Dudukan</a></li>
                    <li><a href="footerBelumLogin/mejanakas.php" style="text-decoration:none; color:#57615b">Sofa 2 Dudukan</a></li>
                    <li><a href="footerBelumLogin/mejanakas.php" style="text-decoration:none; color:#57615b">Kursi Ruang Kerja</a></li>
                    <li><a href="footerBelumLogin/mejanakas.php" style="text-decoration:none; color:#57615b">Sofa Tempat Tidur</a></li>
                    <li><a href="footerBelumLogin/mejanakas.php" style="text-decoration:none; color:#57615b">Tempat Tidur</a></li>
                    <li><a href="footerBelumLogin/mejanakas.php" style="text-decoration:none; color:#57615b">Meja Tulis</a></li>
                </ul>
            </div>
            <div class="col-lg-2 mt-lg-5">
                <ul style="list-style-type: none; margin: 0; padding: 0; font-size:12px;">
                    <li><a href="footerBelumLogin/mejanakas.php" style="text-decoration:none; color:#57615b">Lemari Pakaian</a></li>
                    <li><a href="footerBelumLogin/mejanakas.php" style="text-decoration:none; color:#57615b">Utilitas</a></li>
                    <li><a href="footerBelumLogin/mejanakas.php" style="text-decoration:none; color:#57615b">Meja Rapat</a></li>
                    <li><a href="footerBelumLogin/mejanakas.php" style="text-decoration:none; color:#57615b">Karpet</a></li>
                    <li><a href="footerBelumLogin/mejanakas.php" style="text-decoration:none; color:#57615b">Lampu</a></li>
                    <li><a href="footerBelumLogin/mejanakas.php" style="text-decoration:none; color:#57615b">Vas</a></li>
                    <li><a href="footerBelumLogin/mejanakas.php" style="text-decoration:none; color:#57615b">Obyek Dekoratif</a></li>
                    <li><a href="footerBelumLogin/mejanakas.php" style="text-decoration:none; color:#57615b">Anak-Anak</a></li>
                    <li><a href="footerBelumLogin/mejanakas.php" style="text-decoration:none; color:#57615b">Pengharum Ruangan</a></li>
                    <li><a href="footerBelumLogin/mejanakas.php" style="text-decoration:none; color:#57615b">Penahan Buku</a></li>
                    <li><a href="footerBelumLogin/mejanakas.php" style="text-decoration:none; color:#57615b">Tempat Lilin</a></li>
                </ul>
            </div>
            <div class="col-lg-2 mt-lg-5">
                <ul style="list-style-type: none; margin: 0; padding: 0; font-size:12px;">
                    <li><a href="footerBelumLogin/mejanakas.php" style="text-decoration:none; color:#57615b">Cermin Dinding</a></li>
                    <li><a href="footerBelumLogin/mejanakas.php" style="text-decoration:none; color:#57615b">Keranjang</a></li>
                    <li><a href="footerBelumLogin/mejanakas.php" style="text-decoration:none; color:#57615b">Aksesoris Penyimpanan</a></li>
                    <li><a href="footerBelumLogin/mejanakas.php" style="text-decoration:none; color:#57615b">Penyimpanan</a></li>
                    <li><a href="footerBelumLogin/mejanakas.php" style="text-decoration:none; color:#57615b">Linen</a></li>
                    <li><a href="footerBelumLogin/mejanakas.php" style="text-decoration:none; color:#57615b">Hewan Peliharaan</a></li>
                    <li><a href="footerBelumLogin/mejanakas.php" style="text-decoration:none; color:#57615b">Bingkai</a></li>
                    <li><a href="footerBelumLogin/mejanakas.php" style="text-decoration:none; color:#57615b">Bunga Imitasi</a></li>
                </ul>
            </div>
            <div class="col-lg-2 mt-lg-3">
                <h5 class="fw-bold mb-2">Legal</h5>
                <ul style="list-style-type: none; margin: 0; padding: 0; font-size:12px;">
                    <li><a href="" style="text-decoration:none; color:#57615b">Privacy Policy</a></li>
                    <li><a href="" style="text-decoration:none; color:#57615b">Terms and Conditions</a></li>
                    <li><a href="" style="text-decoration:none; color:#57615b">Delivery Terms</a></li>
                </ul>
                <h5 class="fw-bold mb-2 mt-2">Support</h5>
                <ul style="list-style-type: none; margin: 0; padding: 0; font-size:12px;">
                    <li><a href="" style="text-decoration:none; color:#57615b">Contact Us</a></li>
                    <li><a href="" style="text-decoration:none; color:#57615b">Payment</a></li>
                </ul>
            </div>
        </div>
        <footer class="text-center p-2" style="background-color:#5E6F64; height: 38px; font-size:12px; color:burlywood">
            &#169; 2022 Erefir Indonesia
        </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>
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