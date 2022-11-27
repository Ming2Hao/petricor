<?php
require_once("connection.php");
function rupiah($angka){
    return "Rp " . number_format($angka,2,',','.');
}
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

if(isset($_SESSION['qtyBarang'])) $qtyBarang = $_SESSION['qtyBarang'];
else $qtyBarang = 0;

if(isset($_POST["tambahkeranjang"])){
    
    $cek=0;
    $itemdipilih=$_SESSION["itemIni"];
    $usersekarang=$_SESSION['currentUser'];
    $tempqty=$_POST["quantiti"];
    $_SESSION['qtyBarang'] = $tempqty;
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
    header('Location: detailSudahLogin.php');
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
    // $_SESSION["message"] = "HAHAHA"
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DETAIL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.0/mdb.min.css" rel="stylesheet"/>
    <link href="https://use.fontawesome.com/releases/v5.0.1/css/all.css" rel="stylesheet">
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
            .modal-header {
                padding: 15px 10px;
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

        /* PERMODALAN */
        /* The Modal (background) */
        .modal{
            position: fixed;
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            left: 0;
            /* visibility: hidden; */
            top: 0;
            padding-top: 100px; /* Location of the box */
            z-index: 3; /* Sit on top */
        }

        .a{
            display: none;
        }

        .b{
            display: block;
        }

        /* Modal Content */
        .modal-content {
            position: relative;
            background-color: #f5f5f5;
            margin: auto;
            padding: 0;
            border: 1px solid #888;
            width: 80%;
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
            -webkit-animation-name: animatetop;
            -webkit-animation-duration: 0.4s;
            animation-name: animatetop;
            animation-duration: 0.4s
        }

        /* Add Animation */
        @-webkit-keyframes animatetop {
            from {top:-300px; opacity:0} 
            to {top:0; opacity:1}
        }

        @keyframes animatetop {
            from {top:-300px; opacity:0}
            to {top:0; opacity:1}
        }

        /* The Close Button */
        .close {
            color: white;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }

        .modal-header {
            padding: 25px 20px;
            background-color: #f5f5f5;
            color: #000;
        }

        .modal-body {
            padding: 2px 16px;
            background-color: #f5f5f5;
            color: #000;
        }

        .modal-footer {
            padding: 2px 16px;
            background-color: #f5f5f5;
            color: #000;
        }
    </style>
</head>
<body style="background-color:#f5f5f5;">
    <nav class="navbar navbar-expand-lg sticky-top w-100" style="background-color:#3F4441;">
        <div class="container-fluid">
            <a class="navbar-brand" href="#" name="logodipencet">
                <img src="assets/img/logoFix.jpg" alt="Logo Petricor" width="120" height="40" class="me-2">
                <div class="text-white gambar">DETAIL</div>
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
                <a class="mt-2 me-3" href="catalogAfterLogin.php">
                    <div class="text-white">KATALOG</div>
                </a>
                <div class="text-white mt-2 me-3">|</div>
                <a class="mt-2 me-3" href="daftarTransaksi.php">
                    <div class="text-white">TRANSAKSI</div>
                </a>
                <a href="cart.php" class="me-lg-5 pe-lg-4 mt-lg-2 mt-2">
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
                        <img src="assets/img/displaypicture.png">
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
    <div class="row w-100">
        <div class="col-lg-4 col-sm-12 col-md-12">
            <!-- <div class="bg-image hover-zoom"> -->
                <a href="catalogAfterLogin.php"><img src="assets/img/return.png" alt="" style="width:25px; z-index:2;" class="mt-2 ms-3"></a>
                <img src="<?=$row['it_gambar']?>" class="card-img-top bg-image potrek" alt="..." style="z-index:1">
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
               
            <!-- </div> -->
        </div>
        <div class="col-lg-5 col-sm-12 col-md-12 ms-lg-0 ms-2">
            <h4 class="mt-lg-4 mt-1 mb-lg-3 fw-bolder" style="text-transform:uppercase; text-decoration:underline;">Deskripsi Produk <?=$row['it_name']?></h4>
            <?=$row["it_desc"]?>
            <form action="" method="post" class="mt-lg-4 mt-3 mb-4 mb-lg-0 float-end">
                <input type="number" name="quantiti" id="" value="1" min="1" style="border-radius:8px; width: 72px;">
                <button type="submit" name="tambahkeranjang" id="myBtn" style="border-radius: 8px; background-color:#555; color:#ffffff;">Masukkan ke Keranjang</button>
            </form>
        </div>
        
    </div>
    
    <div id="myModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bold">BERHASIL DITAMBAHKAN KE KERANJANG!</h2>
                <span class="close">&times;</span>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6 col-12">
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <img src="<?=$row['it_gambar']?>" class="potrek" alt="..." style="width:250px;">  
                            </div>
                            <div class="col-lg-6 mt-lg-5 col-12 mt-0">
                                <h4><?=$row['it_name']?></h4> 
                                <h5 style="font-size:18px;" class="fw-bold"><?=rupiah($row['it_price'])?>
                                </h5>
                                <p>Jumlah: <?=$qtyBarang?></p>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-1 gambar" style="width: 20px;">
                        <div class="h-100" style="border-left:1px solid black;"></div>
                    </div>
                    <div class="col-lg-5 col-12">
                        <h4 class="fw-bold">KERANJANG KAMU</h4>
                        <?=$qtyCart[0]?> item: <br>
                        <?php
                            $hitungTotal = mysqli_query($conn, "SELECT SUM(i.it_price * c.ct_qty) as 'ttl'
                            FROM cart c 
                            JOIN users u ON u.us_id = c.ct_us_id
                            JOIN items i ON i.it_id = c.ct_it_id");
                            $totalcost = mysqli_fetch_row($hitungTotal);
                        ?>
                        <div class="row gambar">
                            <div class="col-lg-7 col-4">
                                Total Biaya Produk:
                            </div>
                            <div class="col-lg-5 col-8">
                                <?=rupiah($totalcost[0])?>
                            </div>
                        </div>
                        <hr>
                        <b>
                            <div class="row">
                                <div class="col-lg-7 col-4">
                                    Total:
                                </div>
                                <div class="col-lg-5 col-8">
                                    <?=rupiah($totalcost[0])?>
                                </div>
                            </div>    
                        </b>
                        (sudah termasuk pajak) <br> <br>
                        <div class="d-flex justify-content-end">
                            <a class="btn text-white me-lg-5 me-2" style="background-color:#3f4441;" href="catalogAfterLogin.php">Kembali ke Katalog</a>
                            <a class="btn text-white ms-lg-5 me-lg-4" style="background-color:#888;" href="cart.php">Lihat Keranjang</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
               
            </div>
        </div>
    </div>

    <footer class="text-center p-2" style="background-color:#5E6F64; height: 38px; font-size:12px; color:burlywood">
        &#169; 2022 Erefir Indonesia
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        function menuToggle() {
            const toggleMenu = document.querySelector(".menu");
            toggleMenu.classList.toggle("active");
        }

        // PERMODALAN
        var modal = document.getElementById("myModal");
        var btn = document.getElementById("myBtn");
        var span = document.getElementsByClassName("close")[0];

        btn.onclick = function() {
            modal.classList.add("b")
            modal.classList.remove("a")
            // modal.style.visibility = "visible";
        }

        span.onclick = function() {
            modal.classList.remove("b")
            modal.classList.add("a")
            // modal.style.visibility = "hidden";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                // modal.style.visibility = "hidden";
                modal.classList.remove("b")
                modal.classList.add("a")
            }
        }
    </script>
</body>
</html>