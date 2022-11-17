<?php
    require_once("connection.php");
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
        $_SESSION["itemsekarang"]=$_POST["detaildiklik"];
        header('Location: tes.php');
    }
    if (!isset ($_GET['page'])) {  
        $page = 1;
    } else {  
        $page = $_GET['page'];  
    }
    $results_per_page = 20;  
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
            /* text-transform:capitalize; */
            box-sizing: border-box;
        }

        html, body{
            width: 100%;
        }
    </style>
</head>
<body style="background-color:#FFDECF;">
    <!-- <div class="container-fluid"> -->
        <form action="" method="post">
        <nav class="navbar navbar-expand-lg sticky-top w-100" style="background-color:#3F4441;">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php" name="logodipencet">
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
            <div class="d-flex container-fluid">
                <div class="input-group">
                    <input type="text" class="form-control ms-lg-2 w-100" placeholder="Cari barang" style="height:34px; margin-top:5px;" name="searchbar">
                    <button class="rounded-end me-lg-4 me-2" style="border:none; background-color:white; margin-top:5px;" name="search" type="submit">
                        <img src="assets/img/search.png" class="iconsearch" alt="Icon Search" style="width: 20px; height:20px;">
                    </button>   
                </div>
            </div>
            <div class="d-lg-flex d-sm-block container-fluid">
               
                <div class="row">
                    <div class="col-1">
                        <img src="assets/img/cart.png" alt="iconCart" class="me-1 me-lg-5 mt-3 mt-lg-1 ms-lg-2" style="width:36px; height:36px;" id="lebar">
                        <!-- <label for="cart" class="d-lg-none d-block text-white mt-4">Cart</label> -->
                    </div>
                    <div class="col-11 mt-4 mt-lg-2">
                        <!-- <div class="mt-sm-5"> -->
                            <a href="" class="link-light mt-4 ms-1 ms-lg-4 ms-5 mt-lg-2 me-lg-2" style="text-decoration:none;" id="lebar">ABOUT US</a>
                            <span class="mx-lg-2 mx-0 mt-lg-2 text-white">|</span>
                            <a href="register.php" class="link-light mt-4 ms-1 ms-lg-2 mt-lg-2 me-lg-2" style="text-decoration:none;" id="lebar">SIGN UP</a>
                            <span class="mx-lg-2 mx-0 mt-lg-2 text-white">|</span>
                            <a href="login.php" class="link-light mt-4 ms-1 ms-lg-2 mt-lg-2 me-lg-2" style="text-decoration:none;" id="lebar">SIGN IN</a>
                        <!-- </div> -->
                    </div>
                </div>
            </div>
        </div>
        </nav>
        </form>
                        
            <!-- munculin gambar -->
            <div class="mt-3 container-fluid">
                <div class="d-flex justify-content-center row row-cols-sm-1 row-cols-md-4 g-4 w-100">
                <?php
                
                // for($i=0; $i<sizeof($daftarBarang); $i++){
                while($row = mysqli_fetch_assoc($result)){
                ?>
                        <!-- <form action="tes.php"> -->
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
                        <!-- </form> -->
                        
                <?php
                    }
                ?>
                </div>
            </div>
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
        <footer class="text-center p-2" style="background-color:#5E6F64; height: 38px; font-size:12px; color:burlywood">
            &#169; 2022 Erefir Indonesia
        </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>
</body>
</html>