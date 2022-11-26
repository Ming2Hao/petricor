<?php
    require_once("connection.php");
    if(!isset($_SESSION['currentUser'])){
        header('Location: login.php');
    }

    if(isset($_SESSION['currentUser'])) $currentUser = $_SESSION['currentUser'];
    else $currentUser = [];
    if (!isset($_SESSION['currentUser'])) header("Location: index.php");
    $user = mysqli_query($conn, "SELECT * FROM users WHERE us_id = '$currentUser'");
    $curUser = mysqli_fetch_array($user);

    function rupiah($angka){
        return "IDR " . number_format($angka,2,',','.');
    }

    if(isset($_SESSION['currentUser'])){
        $result = mysqli_query($conn,"SELECT * from h_transaksi where ht_us_id='".$_SESSION['currentUser']."'");
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
<body style="background-color:#FFDECF;" onload="load_ajax()">
    <div class="container-fluid px-0">
        
    <nav class="navbar navbar-expand-lg sticky-top w-100" style="background-color:#3F4441;">
            <div class="container-fluid">
                <a class="navbar-brand" href="indexSudahLogin.php" name="logodipencet">
                    <img src="assets/img/logoFix.jpg" alt="Logo Petricor" width="120" height="40" class="me-2">
                    <div class="text-white gambar">CART</div>
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
                    <div class="container-fluid">
                        <form action="" method="POST" class="">
                            <div class="input-group">
                                <input type="text" class="form-control ms-lg-2" placeholder="Cari barang" style="height:34px; margin-top:5px;" name="searchbar">
                                <button class="rounded-end me-lg-2" style="border:none; background-color:white; margin-top:5px;" name="search">
                                    <img src="assets/img/search.png" class="iconsearch" alt="Icon Search" style="width: 20px; height:20px;">
                                </button>   
                                
                            </div>
                        </form>
                    </div>
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

        <!-- cart-->
        <div class="p-3 mx-5">
            <div class="row d-flex">
                <div class="col-12">
                <?php
                    while($row = mysqli_fetch_assoc($result)){
                ?>
                <div class="px-0 mx-0">
                    <div class="row pe-0 mb-3 w-100">
                        <h1><?=$row["ht_id"]?></h1>
                        <?php
                            $resultdt = mysqli_query($conn,"SELECT * from d_transaksi where dt_ht_id='".$row["ht_id"]."'");
                            $gt=0;
                            while($dt = mysqli_fetch_assoc($resultdt)){
                                $resultitem = mysqli_query($conn,"SELECT * from items where it_id='".$dt["dt_it_id"]."'");
                                $item = mysqli_fetch_assoc($resultitem);
                                $cat = mysqli_query($conn,"SELECT * from category where ca_id='".$item["it_ca_id"]."'");
                                $cat=mysqli_fetch_assoc($cat);
                                ?>
                                <div class="col-1 px-0 mx-0 rounded">
                                    <img src="<?=$item["it_gambar"]?>" alt="" class="rounded-start w-100 h-100 col-1 px-0 mx-0 ">
                                </div>
                                <div class="col-9 border-start mx-0 align-items-center py-3 mx-0" style="background-color:#f7f7f7;">
                                    <p class="w-100"><?=$item["it_name"]?><br><?=$cat["ca_name"]?></p>
                                    <!-- <div class="p-0 m-0"> -->
                                        <?=rupiah($item["it_price"])?> X
                                        <?=$dt["dt_qty"]?>
                                        <br>
                                        <b class="d-flex"> TOTAL : &nbsp; <p><?=rupiah($dt["dt_qty"]*$item["it_price"])?></p> </b>
                                        <?php
                                            $gt=$gt+($dt["dt_qty"]*$item["it_price"]);
                                        ?>
                                        <!-- HARUS BISA BRUBAH TOTALNYA TANPA DIREFRESH -->
                                    <!-- </div> -->
                                </div>
                                <div class="col-2 mx-0 rounded-end align-items-center d-flex align-items-center" style="background-color:#f7f7f7;">
                                
                                </div>
                                <?php
                            }
                        ?>
                        <p id="totalbelanja" class="p-0 m-0">
                            totalbelanja: <?=rupiah($gt)?>
                        </p>
                        <p class="p-0 m-0">
                            ongkir: <?=rupiah(10000)?>
                        </p>
                        <p id="grandtotal">
                            grandtotal: 
                            
                            <?=rupiah($gt+10000)?>
                        </p>
                    </div>
                </div>
                <?php
                    }
                ?>
            </div>
        </div>
        <div class="befooter2" style="height: 100px; background-color:#FFDECF;">
                
        </div>
        <footer class="text-center p-2 fixed-bottom" style="background-color:#5E6F64; height: 38px; font-size:12px; color:burlywood">
            &#169; 2022 Erefir Indonesia
        </footer>
    </div>
    <!-- </div> -->


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
        // setInterval(fetch_cart, 500);
		function load_ajax() {
			// total =  document.getElementById("total");
			// updown =  document.getElementsByClass("updown");
		}
		
		function ajax_func(method, url, callback, data="") {
			r = new XMLHttpRequest();
			r.onreadystatechange = function() {callback(this);}
			r.open(method, url);
			if(method.toLowerCase() == "post") r.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			r.send(data);
		}
	</script>
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
    <script>
        function menuToggle() {
            const toggleMenu = document.querySelector(".menu");
            toggleMenu.classList.toggle("active");
        }
    </script>
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-9CaaIAOw-0qDQW_5"></script>
    <script type="text/javascript">
      document.getElementById('cekout').onclick = function(){
        // SnapToken acquired from previous step
        window.snap.pay('<?=$snapToken?>', {
          onSuccess: function(result){
            pembayaran_sukses();
            alert("payment success!"); console.log(result);
          },
          onPending: function(result){
            /* You may add your own implementation here */
            alert("wating your payment!"); console.log(result);
          },
          onError: function(result){
            /* You may add your own implementation here */
            alert("payment failed!"); console.log(result);
          },
          onClose: function(){
            /* You may add your own implementation here */
            alert('you closed the popup without finishing the payment');
          }
      });
      };
    </script>
</body>
</html>