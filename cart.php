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
        $result = mysqli_query($conn,"SELECT * from cart where ct_us_id='".$_SESSION['currentUser']."'");
    }
    if(isset($_POST["cekout"])){
        $tempuser=$_SESSION['currentUser'];
        $cek = mysqli_num_rows(mysqli_query($conn,"SELECT ct_id FROM cart WHERE ct_us_id='$tempuser'"));
        if($cek==0){
            
        }
        else{
            $nextht = mysqli_query($conn,"SELECT MAX(CAST(SUBSTRING(ht_id,3,3) AS UNSIGNED)) FROM h_transaksi");
            $nextht=mysqli_fetch_row($nextht)[0];
            $nextht=$nextht+1;
            $nextht="HT".str_pad($nextht,3,"0",STR_PAD_LEFT);
            $_SESSION["notransaksi"]=$nextht;
            $curruser=$_SESSION["currentUser"];
            $total=10000;
            $result22 = mysqli_query($conn,"SELECT * from cart where ct_us_id='".$_SESSION['currentUser']."'");
            while($row = mysqli_fetch_assoc($result22)){
                $item2 = mysqli_query($conn,"SELECT * from items where it_id='".$row["ct_it_id"]."'");
                $item2=mysqli_fetch_assoc($item2);
                $total=$total+($item2["it_price"]*$row["ct_qty"]);
            }
            $tanggal=date("Y-m-d");
            $iht_query = "INSERT INTO `h_transaksi`(`ht_id`, `ht_us_id`, `ht_date`, `ht_total`) VALUES ('$nextht','$curruser','$tanggal','$total')";
            $resht = $conn->query($iht_query);
    
            $result33 = mysqli_query($conn,"SELECT * from cart where ct_us_id='".$_SESSION['currentUser']."'");
            while($row = mysqli_fetch_assoc($result33)){
                $nextdt = mysqli_query($conn,"SELECT MAX(CAST(SUBSTRING(dt_id,3,3) AS UNSIGNED)) FROM d_transaksi");
                $nextdt=mysqli_fetch_row($nextdt)[0];
                $nextdt=$nextdt+1;
                $nextdt="DT".str_pad($nextdt,3,"0",STR_PAD_LEFT);
                $ctitid=$row["ct_it_id"];
                $ctqty=$row["ct_qty"];
                $idt_query = "INSERT INTO `d_transaksi`(`dt_id`, `dt_it_id`, `dt_ht_id`, `dt_qty`) VALUES ('$nextdt','$ctitid','$nextht','$ctqty')";
                $resdt = $conn->query($idt_query);
            }
            $delet_query2 = "DELETE from cart where ct_us_id='".$_SESSION['currentUser']."'";
            $resdelet2= $conn->query($delet_query2);
            
            header('Location: terimakasih.php');
        }
    }
    if(isset($_POST["delet"])){
        $delet_query = "DELETE from cart where ct_id='".$_POST["delet"]."'";
        $resdelet = $conn->query($delet_query);
        header('Location: cart.php');
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
    </style>
</head>
<body style="background-color:#FFDECF;" onload="load_ajax()">
    <div class="container-fluid px-0">
        
    <nav class="navbar navbar-expand-lg sticky-top w-100" style="background-color:#3F4441;">
        <div class="container-fluid">
            <a class="navbar-brand" href="catalogAfterLogin.php" name="logodipencet">
                <img src="assets/img/logoFix.jpg" alt="Logo Petricor" width="120" height="40" class="me-2">
                <div class="text-white">CART</div>
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
                <form action="">
                    <button class="d-flex" style="margin-right:80px; border:none; background:none;" formaction="cart.php">
                        <img src="assets/img/cart.png" alt="iconCart" class="mt-lg-1" style="width:30px; height:30px;">
                        <a class="text-white mt-lg-2">CART</a>
                    </button>
                </form>
                
                
            </div>
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
                        <div class="printilan" style="margin-bottom: -5px"><?=$curUser["us_username"]?> 
                        </div>
                        <!-- <div class="printilan"><?=rupiah($curUser["us_saldo"])?> 
                        </div> -->
                        
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

        <!-- cart-->
        <div class="px-3 mx-5">
            <div class="row d-flex">
                <div class="col-9" id="maincart">
                <?php
                    while($row = mysqli_fetch_assoc($result)){
                        $item = mysqli_query($conn,"SELECT * from items where it_id='".$row["ct_it_id"]."'");
                        $item=mysqli_fetch_assoc($item);
                        $cat = mysqli_query($conn,"SELECT * from category where ca_id='".$item["it_ca_id"]."'");
                        $cat=mysqli_fetch_assoc($cat);
                ?>
                <div class="px-0 mx-0">
                    <div class="row pe-0 mb-3 w-100">
                        <div class="col-1 px-0 mx-0 rounded">
                            <img src="<?=$item["it_gambar"]?>" alt="" class="rounded-start w-100 h-100 col-1 px-0 mx-0 ">
                        </div>
                        <div class="col-9 border-start border-end mx-0 align-items-center py-3 mx-0" style="background-color:#f7f7f7;">
                            <p class="w-100"><?=$item["it_name"]?><br><?=$cat["ca_name"]?></p>
                            <!-- <div class="p-0 m-0"> -->
                                <?=rupiah($item["it_price"])?>X
                                <input type="number" name="<?=$row["ct_id"]?>" class="idupdown" value="<?=$row["ct_qty"]?>" min="0">
                                <br>
                                <b class="d-flex"> TOTAL : &nbsp; <p class="<?=$row["ct_id"]?>idnumericupdown">asd</p> </b> 
                                <!-- HARUS BISA BRUBAH TOTALNYA TANPA DIREFRESH -->
                            <!-- </div> -->
                        </div>
                        <div class="col-2 border-start mx-0 rounded-end align-items-center d-flex align-items-center" style="background-color:#f7f7f7;">
                        <form action="#" method="post">
                            <button type="submit" value="<?=$row["ct_id"]?>" name="delet" class="btn w-100 bg-danger text-white">
                                Delete
                            </button>
                        </form>
                        </div>
                    </div>
                </div>
                <?php
                    }
                ?>
            </div>
                <div class="col-3" style="background-color:#f7f7f7;">
                ongkir: 10000
                <form action="#" method="post">
                    <button type="submit" class="mt-2 btn ps-4 pe-4 fw-bold text-center" name="cekout" style="border-radius: 50px; background-color:#8c594f; color:white;">Check Out
                    </button>
        
                </form>
                </div>
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
        setInterval(fetch_cart, 500);
		function load_ajax() {
			// total =  document.getElementById("total");
			// updown =  document.getElementsByClass("updown");
            fetch_cart();
		}
		
		function ajax_func(method, url, callback, data="") {
			r = new XMLHttpRequest();
			r.onreadystatechange = function() {callback(this);}
			r.open(method, url);
			if(method.toLowerCase() == "post") r.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			r.send(data);
		}

        function fetch_cart(){
            <?php
            $result2 = mysqli_query($conn,"SELECT * from cart where ct_us_id='".$_SESSION['currentUser']."'");
            $row="";
            while($row = mysqli_fetch_assoc($result2)){
                    $items = mysqli_query($conn,"SELECT * from items where it_id='".$row["ct_it_id"]."'");
                    $items=mysqli_fetch_assoc($items);
                    ?>
                    // alert("halo");
                    $('.<?=$row["ct_id"]?>idnumericupdown').html('<?=rupiah($row["ct_qty"]*$item["it_price"])?>');
                    <?php
                }    
            ?>
        }

		function refresh_table(xhttp) {
			if ((xhttp.readyState==4) && (xhttp.status==200)) {
				fetch_cart();
                
			}
		}
        $(".idupdown").bind('keyup mouseup',function () {
            var elements = $(".idupdown");
            for(var i = 0; i < elements.length; i++) {
                tempname=elements[i].name;
                tempqty=elements[i].value;
                // tempclass=`${tempname}${idnumericupdown}`;
                asd=elements[i];
                total=elements[i];
                // alert(tempname);
                r = new XMLHttpRequest();
                r.onreadystatechange = function() {
                    if ((this.readyState==4) && (this.status==200)) {
                        total.innerHTML = this.responseText;
                    }
                }
                r.open('GET', `ajaxcart/fetch_harga.php?valbaru=${tempqty}&idcart=${tempname}`);
                r.send();
            }
        });
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
   
</body>
</html>