<?php
require("connection.php");
$listItem = mysqli_query($conn,"SELECT * from items where it_id='".$_SESSION["itemsekarang"]."'");
$row = mysqli_fetch_assoc($listItem);
    // $_SESSION["message"] = "HAHAHA"
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href='http://fonts.googleapis.com/css?family=Josefin Sans' rel='stylesheet' type='text/css'>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.0/mdb.min.css" rel="stylesheet"/>
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
    <!-- <style>
        *{
            font-family: 'Oswald', sans-serif !important;
        }
        @media screen and (min-width:350px){
            #lebar{
                display: none;
            }
        }

        @media screen and (max-width:400px){
            #lebar{
                display: block;
            }
        }
    </style> -->
</head>
<body style="background-color:#FFDECF;">
    <nav class="navbar navbar-expand-lg sticky-top" style="background-color:#3F4441;">
        <div class="container-fluid d-flex">
            <div class="d-flex mb-0">
                <a class="navbar-brand" href="index.php">
                <img src="assets/img/Logo.jpg" alt="Logo Petricor" width="120" height="40" class="me-2">
                </a>
            
                <div class="float-start me-3 mt-2" id="lebar">
                    <ul class="navbar-nav d-flex flex-row">
                        <li class="nav-item me-3">
                            <a class="nav-link text-white me-3 fw-bold" aria-current="page" href="customer.php">HOME</a>
                        </li>
                        <li class="nav-item me-3">
                            <a class="nav-link text-white me-3" aria-current="page" href="customerCO.php">CHECKOUT</a>
                        </li>
                        <li class="nav-item me-3">
                            <a class="nav-link text-white me-3" aria-current="page" href="customerHist.php">HISTORY</a>
                        </li>
                    </ul>
                </div>
                <!-- <img src="assets/nahidah dp.jpg" style="width: 50px; height: 50px; border-radius:50%;" alt="DP Customer"> -->
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="justify-content-end d-flex">
                <!-- <div class="input-group">
                    <div class="form-outline">
                        <input id="search-input" type="search" id="form1" class="form-control" />
                        <label class="form-label" for="form1">Search</label>
                    </div>
                    <button id="search-button" type="button" class="btn btn-primary">
                        <i class="fas fa-search"></i>
                    </button>
                </div> -->
                <div class="input-group" id="lebar">
                    <input type="text" class="form-control" placeholder="Cari barang" style="height:36px; margin-top:2px;">
                    <button class="cari rounded-end" type="button" style="border:none; background-color:white; margin-top:2px;">
                        <img src="assets/img/search.png" class="iconsearch" alt="Icon Search" style="width: 20px; height:20px;">
                    </button>   
                    <!-- <div class="ikon">
                        <img src="assets/img/shopping-cart.png" alt="cart">
                        <img src="assets/img/bell.png" alt="bell">
                        <img src="assets/img/email.png" alt="email">
                    </div>
                    <div class="profil">
                        <a href="transaksi.html"><img src="assets/img/avatar.jpg" alt="avatar" class="avatar"></a>
                        <p>Felicia Pangestu</p>
                    </div> -->
                </div>
                <!-- <div class="col"> -->
                <div class="btn-group mx-3" id="lebar">
                    <button type="button" class="btn dropdown-toggle py-1 px-3 text-white" data-bs-toggle="dropdown" aria-expanded="false" style="background-color:#5E6F64;">
                        FILTERS
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Name : Ascending</a></li>
                        <li><a class="dropdown-item" href="#">Name : Descending</a></li>
                        <li><a class="dropdown-item" href="#">Price : Low to High</a></li>
                        <li><a class="dropdown-item" href="#">Price : High to Low</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">All Products</a></li>
                    </ul>
                </div>
                <img src="assets/img/cart.png" alt="iconCart" class="me-3" style="width:36px; height:36px;" id="lebar">
                <a href="login.php" class="link-light mt-2" style="text-decoration:none;" id="lebar">Login</a>
                <!-- </div> -->
                
            </div>
        </div>
    </nav>
    <div class="col">
        <div class="card" style="width: 300px; height: 280px; box-shadow: #3F4441 12px 15px 15px -20px; border-radius:15px">
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
            <?=$row["it_desc"]?>
        </div>
    </div>
    <!-- <div class="view overlay zoom">
    <img src="https://mdbootstrap.com/img/Photos/Horizontal/Nature/6-col/img%20(131).webp" class="img-fluid " alt="smaple image">
    <div class="mask flex-center">
        <p class="white-text">Zoom effect</p>
    </div> -->
</div>
    
        <!-- Lorem ipsum dolor sit amet consectetur adipisicing elit. Exercitationem iusto neque accusamus sit explicabo dolore aut voluptas blanditiis assumenda ullam. Recusandae aut maiores dignissimos perferendis incidunt ducimus quibusdam, iure veniam iste? Commodi neque doloribus nostrum deserunt laborum totam praesentium laboriosam quasi qui itaque, magnam dignissimos id beatae dicta. Iste assumenda placeat blanditiis quod. Error officia iste possimus harum! Quaerat minima neque quos esse non! Earum ducimus perferendis illum modi facere! Officia atque excepturi ipsum, deserunt deleniti dignissimos voluptate error. Laudantium necessitatibus incidunt enim assumenda fugit deserunt, laborum earum praesentium inventore voluptatibus illo voluptates, debitis similique nisi rem explicabo expedita voluptatum! -->
    <!-- <script
    type="text/javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.0/mdb.min.js"
    ></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
   
</body>
</html>