<?php
require_once("connection.php");
function rupiah($angka){
    return "IDR " . number_format($angka,2,',','.');
}
// $_SESSION["sukses"] = 'Data Berhasil Disimpan';
// if(isset($_SESSION['currentUser'])) $currentUser = $_SESSION['currentUser'];
// else $currentUser = [];
// if (!isset($_SESSION['currentUser'])) header("Location: index.php");

// $user = mysqli_query($conn, "SELECT * FROM users WHERE us_id = '$currentUser'");
// $curUser = mysqli_fetch_array($user);

// $listItem = mysqli_query($conn,"SELECT * from items");
// $tempquery="SELECT * from items";
// if(!isset($_SESSION["querysekarang"])){
//     $_SESSION["querysekarang"]="SELECT * from items";
// }

if(isset($_POST["tambahkeranjang"])){
    if (!isset($_SESSION['currentUser'])) {
        header("Location: login.php");
    } else {
        $cek=0;
        $itemdipilih=$_SESSION["itemIni"];
        $usersekarang=$_SESSION['currentUser'];
        $tempqty=$_POST["quantiti"];
        $cek = mysqli_num_rows(mysqli_query($conn,"SELECT ct_id FROM cart WHERE ct_it_id='$itemdipilih'"));
        if($cek==0){
            $nextinid = mysqli_query($conn,"SELECT MAX(CAST(SUBSTRING(ct_id,3,3) AS UNSIGNED)) FROM cart");
            $nextinid=mysqli_fetch_row($nextinid)[0];
            $nextinid=$nextinid+1;
            $nextinid="CT".str_pad($nextinid,3,"0",STR_PAD_LEFT);
            $qwery="INSERT INTO `cart`(`ct_id`, `ct_it_id`, `ct_us_id`, `ct_qty`) VALUES ('$nextinid','$itemdipilih','$usersekarang','$tempqty')";
            $result = mysqli_query($conn, $qwery);
        }
        else{
            $update_query88 = "UPDATE cart SET `ct_qty`=ct_qty+$tempqty WHERE ct_us_id='$usersekarang' and ct_it_id='$itemdipilih'";
            $res88 = $conn->query($update_query88);
        }
        header('Location: detailBelumLogin.php');
    }
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
$listItem = mysqli_query($conn,"SELECT * from items where it_id='".$_SESSION["itemIni"]."'");
$row = mysqli_fetch_assoc($listItem);
// var_dump($row); die;
    // $_SESSION["message"] = "HAHAHA"
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DETAIL SUDAH LOGIN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.0/mdb.min.css" rel="stylesheet"/>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href='http://fonts.googleapis.com/css?family=Josefin Sans' rel='stylesheet' type='text/css'>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.0/mdb.min.css" rel="stylesheet"/> -->
    <!-- Font Awesome -->
    <!-- <link
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    rel="stylesheet"
    /> -->
    <!-- Google Fonts -->
    <!-- <link
    href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap"
    rel="stylesheet"
    /> -->
    <!-- MDB -->
    <!-- <link
    href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.0/mdb.min.css"
    rel="stylesheet"
    /> -->
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
<body style="background-color:#f5f5f5;">
<nav class="navbar navbar-expand-lg sticky-top w-100" style="background-color:#3F4441;">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php" name="logodipencet">
                <img src="assets/img/logoFix.jpg" alt="Logo Petricor" width="120" height="40" class="me-2">
                <div class="text-white">DETIL BARANG</div>
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
                            <a href="catalogue.php" class="link-light mt-4 ms-1 ms-lg-3 ms-5 mt-lg-0 me-lg-2" style="text-decoration:none;" id="lebar">KATALOG</a>
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
    <div class="row w-100">
        <div class="col-lg-4 col-sm-12 col-md-12">
            <div class="bg-image hover-zoom">
                <a href="catalogue.php"><img src="assets/img/return.png" alt="" style="width:25px; z-index:2;" class="mt-lg-2 ms-lg-3"></a>
                <img src="<?=$row['it_gambar']?>" class="card-img-top bg-image hover-zoom" alt="..." style="z-index:-1; margin-top:-90px; width:500px; top:0; margin-left:auto; margin-right:auto;">
                <div class="text-center" style="margin-top: -80px;">
                    <?php
                        $querykategori="select * from category where ca_id='".$row["it_ca_id"]."'";
                        $kat = mysqli_query($conn,$querykategori);
                        $rowss = mysqli_fetch_array($kat);
                        echo "Kategori: " . $rowss["ca_name"];
                    ?>
                    <br>
                    <?=$row['it_name']?> <br>
                    <p class="text-danger"><?=rupiah($row['it_price'])?></p>
                </div>
               
            </div>
        </div>
        <div class="col-lg-5 col-sm-12 col-md-12">
            <h4 class="mt-lg-4 mb-lg-3 fw-bolder" style="text-transform:uppercase; text-decoration:underline;">Deskripsi Produk <?=$row['it_name']?></h4>
            <?=$row["it_desc"]?>
            <form action="#" method="post" class="mt-lg-4 float-end">
                <input type="number" name="quantiti" id="" value="1" min="1" style="border-radius:8px; width: 72px;">
                <button type="submit" name="tambahkeranjang" style="border-radius: 8px; background-color:#555; color:#ffffff;">Masukkan ke Keranjang</button>
            </form>
        </div>
    </div>
   
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