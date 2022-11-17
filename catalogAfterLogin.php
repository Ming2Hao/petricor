<?php
    require_once("connection.php");
    // $_SESSION["sukses"] = 'Data Berhasil Disimpan';
    if(isset($_SESSION['currentUser'])) $currentUser = $_SESSION['currentUser'];
    else $currentUser = [];
    if (!isset($_SESSION['currentUser'])) header("Location: index.php");
    
    $user = mysqli_query($conn, "SELECT * FROM users WHERE us_id = '$currentUser'");
    $curUser = mysqli_fetch_array($user);

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
            header('Location: catalogAfterLogin.php');
            // $tempquery="SELECT * FROM `items` WHERE `it_name` LIKE '%".$_POST["searchbar"]."%'";
            // while($row = $listItem -> fetch_assoc()){
            //     $daftarBarang[] = $row;
            // }
        }
    }
    if(isset($_POST["detaildiklik"])){
        $_SESSION["itemsekarang"]=$_POST["detaildiklik"];
        header('Location: detailSudahLogin.php');
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

    function rupiah($angka){
        return "IDR " . number_format($angka,2,',','.');
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
    </style>
</head>
<body style="background-color:#FFDECF;">
    <!-- <div class="container-fluid"> -->
        <nav class="navbar navbar-expand-lg sticky-top w-100" style="background-color:#3F4441;">
        <div class="container-fluid">
            <a class="navbar-brand" href="#" name="logodipencet">
                <img src="assets/img/logoFix.jpg" alt="Logo Petricor" width="120" height="40" class="me-2">
                <div class="text-white">CATALOG</div>
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
            <div class="container-fluid">
                <form action="" method="post">
                    <div class="input-group">
                        <input type="text" class="form-control ms-lg-2" placeholder="Cari barang" style="height:34px; margin-top:5px;" name="searchbar">
                        <button class="rounded-end me-lg-3 me-2" style="border:none; background-color:white; margin-top:5px;" name="search" type="submit">
                            <img src="assets/img/search.png" class="iconsearch" alt="Icon Search" style="width: 20px; height:20px;">
                        </button>   
                    </div>
                </form>
            </div>
            <form class="">
                <a href="cart.php" class="navbar-brand" style="margin-right: 80px;">
                    <img src="assets/img/cart.png" alt="iconCart" class="mt-lg-1" style="width:30px; height:30px;">
                    <div class="text-white mt-lg-2" style="font-size: 15px;">CART</div>
                </a>
            </form>  
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
        </nav>
                        
            <!-- munculin gambar -->
            <form action="" method="post">
            <div class="mt-3 tes">
                <div class="row row-cols-sm-1 row-cols-md-4 g-4 w-100">
                <?php
                // for($i=0; $i<sizeof($daftarBarang); $i++){
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
                                        <p class="text-danger" style="text-transform:capitalize;"><?=rupiah($row['it_price'])?> <span class="text-secondary" style="text-decoration:line-through">IDR <?=number_format(17187989, 0, "", ".")?></span></p>
                                    </div>
                                </button>
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
                                            <a class="page-link" href="catalogAfterLogin.php?page=<?=$now-1?>">Previous</a>
                                        </li>
                                    <?php
                                }
                            ?>
                            <?php
                                for($page = 1; $page<= $number_of_page; $page++) {
                                    if($page==$now){
                                        ?>
                                            <li class="page-item active d-flex" aria-current="page">
                                                <a class="page-link" href="catalogAfterLogin.php?page=<?=$page?>"><?=$page?></a>
                                            </li>
                                        <?php
                                    }
                                    else{
                                        ?>
                                            <li class="page-item d-flex">
                                                <a class="page-link" href="catalogAfterLogin.php?page=<?=$page?>"><?=$page?></a>
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
                                            <a class="page-link" href="catalogAfterLogin.php?page=<?=$now+1?>">Next</a>
                                        </li>
                                    <?php
                                }
                            ?>
                        </ul>
                    </nav>
            </div>
            
        </form>
        <footer class="text-center p-2" style="background-color:#5E6F64; height: 38px; font-size:12px; color:burlywood">
            &#169; 2022 Erefir Indonesia
        </footer>
    <!-- </div> -->


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