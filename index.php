<?php
    require_once("connection.php");
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
            $_SESSION["querysekarang"]="SELECT * FROM `items` WHERE `it_name` LIKE '%".$_POST["searchbar"]."%'";
            $listItem = mysqli_query($conn,"SELECT * FROM `items` WHERE `it_name` LIKE '%".$_POST["searchbar"]."%'");
            header('Location: index.php');
            // $tempquery="SELECT * FROM `items` WHERE `it_name` LIKE '%".$_POST["searchbar"]."%'";
            // while($row = $listItem -> fetch_assoc()){
            //     $daftarBarang[] = $row;
            // }
        }
    }
    if(isset($_POST["detaildiklik"])){
        $_SESSION["itemsekarang"]=$_POST["detaildiklik"];
        header('Location: tes.php');
    }
    if (!isset ($_GET['page'])) {  
        $page = 2;
    } else {  
        $page = $_GET['page'];  
    }
    $results_per_page = 4;  
    $page_first_result = ($page-1) * $results_per_page;
    $query = $_SESSION["querysekarang"];  
    $result = mysqli_query($conn, $query);  
    $number_of_result = mysqli_num_rows($result);
    $number_of_page = ceil ($number_of_result / $results_per_page);
    $page_first_result = ($page-1) * $results_per_page;   
    $query = $_SESSION["querysekarang"]." LIMIT " . $page_first_result . ',' . $results_per_page;  
    $result = mysqli_query($conn, $query);  
    $now=$page;
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
            text-transform:capitalize;
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
            <div class="d-flex w-75">
                <div class="input-group">
                    <input type="text" class="form-control ms-lg-2 w-100" placeholder="Cari barang" style="height:34px; margin-top:5px;" name="searchbar">
                    <button class="rounded-end me-lg-4 me-2" style="border:none; background-color:white; margin-top:5px;" name="search" type="submit">
                        <img src="assets/img/search.png" class="iconsearch" alt="Icon Search" style="width: 20px; height:20px;">
                    </button>   
                </div>
            </div>
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
                <div class="row">
                    <div class="col-1">
                        <img src="assets/img/cart.png" alt="iconCart" class="me-1 me-lg-5 mt-3 mt-lg-1 ms-lg-1" style="width:36px; height:36px;" id="lebar">
                        <!-- <label for="cart" class="d-lg-none d-block text-white mt-4">Cart</label> -->
                    </div>
                    <div class="col-11 mt-4 mt-lg-2">
                        <!-- <div class="mt-sm-5"> -->
                            <a href="catalogue.php" class="link-light mt-4 ms-1 ms-lg-4 ms-5 mt-lg-2 me-lg-2" style="text-decoration:none;" id="lebar">CATALOG</a>
                            <span class="mx-lg-2 mx-0 mt-lg-2 text-white">|</span>
                            <a href="" class="link-light mt-4 ms-1 ms-lg-2 mt-lg-2 me-lg-2" style="text-decoration:none;" id="lebar">ABOUT US</a>
                            <span class="mx-lg-2 mx-0 mt-lg-2 text-white">|</span>
                            <a href="login.php" class="link-light mt-4 ms-1 ms-lg-2 mt-lg-2 me-lg-2" style="text-decoration:none;" id="lebar">SIGN IN</a>
                        <!-- </div> -->
                    </div>
                </div>
                
                
                
            </div>
            <!-- <div class="d-flex float-end mt-0 mt-lg-3 mt-lg-0">-->
                
            </div>
        </div>
        </nav>
    
        <!-- carousel jumbotron -->
        <div id="carouselExampleFade" class="carousel slide carousel-fade px-lg-5 py-lg-3" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                <img src="temp/bg1.jpg" class="d-block w-100 kartu" alt="..." style="height: 450px;">
                </div>
                <div class="carousel-item">
                <img src="temp/bg2.jpg" class="d-block w-100 kartu" alt="..." style="height: 450px;">
                </div>
                <div class="carousel-item">
                <img src="temp/bg3.jpg" class="d-block w-100 kartu" alt="..." style="height: 450px;">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
                <img src="assets/img/previous.jpg" alt="prev" style="width: 30px; height:30px; background:whitesmoke;">
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
                <img src="assets/img/next.png" alt="next" style="width: 30px; height:30px; background:whitesmoke;">
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <!-- 4 REKOMENDASI TERBAIK-->
        <div class="my-4 tes">
            <div class="row row-cols-1 row-cols-md-4 g-4">
            <?php
            // for($i=0; $i<sizeof($daftarBarang); $i++){
            // $ctr = 1;
            while($row = mysqli_fetch_array($result)){
            ?>
                    <!-- <form action="tes.php"> -->
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
                                    <p class="text-danger"><?=$row['it_price'] ?> <span class="text-secondary" style="text-decoration:line-through">IDR <?=number_format(17187989, 0, "", ".")?></span></p>
                                </div>
                            </button>
                        </div>
                    </div>
                    <!-- </form> -->
                    
            <?php
                    // $ctr++;
                }
            ?>
            </div>
        </div>
        <div class="fw-bolder" style="height: 130px; background-color:#BA7967; color:#3F4441;">
            <div class="row w-100">
                <div class="col-lg-2"></div>
                <div class="col-lg-4 mt-lg-3">
                    <h1>REGISTER NOW FOR SPECIAL OFFERS</h1>
                </div>
                <div class="col-lg-1"></div>
                <div class="col-lg-3 mt-5">
                    <div class="mt-2">
                        <form action="" method="get">
                            <div class="form-field">
                                <label>Email <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="input">
                                <div class="border-line">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-2" style="margin-top:65px;">
                    <button type="submit" style="background:none; border: 1px white solid">
                        <img src="assets/img/arrow.png" alt="" style="width: 25px; height:25px;">
                    </button>
                </div>
            </div>
        </div>
        <div class="befooter2" style="height: 100px; background-color:#FFDECF;">
                
        </div>
        <footer class="text-center p-2" style="background-color:#5E6F64; height: 38px; font-size:12px; color:burlywood">
            &#169; 2022 Erefir Indonesia
        </footer>
    <!-- </div> -->


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script> //buat mata password
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
    <!-- <?php if(@$_SESSION['sukses']){ ?>
        <script>
            swal("Hore! Berhasil Register", {
                buttons: true,
                }    ); -->
            // swal("Good job!", "<?php echo $_SESSION['sukses']; ?>", "success");
            // Swal.fire({
            //     title: 'Batal Hapus',
            //     text: 'Data Anda batal dihapus!',
            //     icon: 'error',
            // })
        <!-- </script> -->
    <!-- jangan lupa untuk menambahkan unset agar sweet alert tidak muncul lagi saat di refresh -->
    <!-- <?php unset($_SESSION['sukses']); } ?> -->
    <!-- <script src="coba.js"></script> -->
</body>
</html>