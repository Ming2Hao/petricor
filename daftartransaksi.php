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
        return "Rp " . number_format($angka,2,',','.');
    }

    if(isset($_SESSION['currentUser'])){
        $result = mysqli_query($conn,"SELECT * from h_transaksi where ht_us_id='".$_SESSION['currentUser']."'");
        $kumpulanHistori = [];
        while($row = $result -> fetch_assoc()){
            $kumpulanHistori[] = $row;
        }
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

            .potrek{
                width: 110px;
                height: 150px;
                margin-top: 25px;
            }

            .profile{
                margin-right:60px;
            }
        }
        @media screen and (min-width:1000px){
            .kartu{
                height: 500px;
            }
            .hp{
                display: none;
            }

            .potrek{
                width: 180px;
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
    <nav class="navbar navbar-expand-lg sticky-top w-100" style="background-color:#3F4441;">
        <div class="container-fluid">
            <a class="navbar-brand" href="indexSudahLogin.php" name="logodipencet">
                <img src="assets/img/logoFix.jpg" alt="Logo Petricor" width="120" height="40" class="me-2">
            </a>
            <button class="navbar-toggler btn" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" style="border:none;">
                <img src="assets/img/burger.png" alt="" style="width:60px; height:30px;">
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
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
                    <div class="text-white fw-bold">TRANSAKSI</div>
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

    <!-- cart-->
    <div class="p-3 mx-5">
        <div class="row d-flex">
            <div class="col-12">
            <?php

                // while($row = mysqli_fetch_assoc($result)){
                for($i=sizeof($kumpulanHistori)-1; $i>=0; $i--){
            ?>
            <div class="px-0 mx-0">
                <div class="row pe-0 mb-3 w-100">
                    <div class="col-12 border-start mx-0 align-items-center py-3 mx-0" style="background-color:#f7f7f7;">
                        <h3 class="fw-bold"><?=$kumpulanHistori[$i]["ht_id"]?></h3>
                        <hr>
                    </div>
                    <?php
                        $resultdt = mysqli_query($conn,"SELECT * from d_transaksi where dt_ht_id='".$kumpulanHistori[$i]["ht_id"]."'");
                        $gt=0;
                        while($dt = mysqli_fetch_assoc($resultdt)){
                            $resultitem = mysqli_query($conn,"SELECT * from items where it_id='".$dt["dt_it_id"]."'");
                            $item = mysqli_fetch_assoc($resultitem);
                            $cat = mysqli_query($conn,"SELECT * from category where ca_id='".$item["it_ca_id"]."'");
                            $cat=mysqli_fetch_assoc($cat);
                            ?>
                            <div class="col-3 px-0 mx-0 rounded">
                                <img src="<?=$item["it_gambar"]?>" alt="" class="rounded-start w-100 col-1 px-0 mx-0 ">
                            </div>
                            <div class="col-9 border-start mx-0 align-items-center py-3 mx-0" style="background-color:#f7f7f7;">
                                <p class="w-100">
                                    <?=$item["it_name"]?><br><?=$cat["ca_name"]?>
                                </p>
                                <?=rupiah($item["it_price"])?> 
                                <br>Jumlah: <?=$dt["dt_qty"]?>
                                <b class="d-flex"> TOTAL : &nbsp; <p><?=rupiah($dt["dt_qty"]*$item["it_price"])?></p> </b>
                                <?php
                                    $gt=$gt+($dt["dt_qty"]*$item["it_price"]);
                                ?>
                            </div>
                            <!-- <div class="col-2 mx-0 rounded-end align-items-center d-flex align-items-center" style="background-color:#f7f7f7;">
                            
                            </div> -->
                            <?php
                        }
                    ?>
                    <div class="col-12 border-start mx-0 align-items-center py-3 mx-0" style="background-color:#f7f7f7;">
                        <p id="totalbelanja" class="p-0 m-0">
                            totalbelanja: <?=rupiah($gt)?>
                        </p>
                        <p class="p-0 m-0">
                            ongkir: <?=rupiah(10000)?>
                        </p>
                        <p id="grandtotal" class="p-0 m-0">
                            grandtotal: <?=rupiah($gt+10000)?>
                        </p>
                    </div>
                   
                </div>
            </div>
            <?php
                }
            ?>
            </div>
        </div>
    </div>



    <hr style="color:#BA7967">
    <div class="row container-fluid w-100 mb-4 mt-3 mx-0 container-fluid">
        <div class="col-lg-1 me-lg-5"></div>
        <div class="col-lg-2 mt-lg-3 gambar">
            <h5 class="fw-bold mb-2">Categories</h5>
            <ul style="list-style-type: none; margin: 0; padding: 0; font-size:12px;">
                <li><a href="catalogAfterLogin.php?fcategory=CA002" style="text-decoration:none; color:#57615b">Meja Nakas</a></li>
                <li><a href="catalogAfterLogin.php?fcategory=CA003" style="text-decoration:none; color:#57615b">Kursi Berlengan</a></li>
                <li><a href="catalogAfterLogin.php?fcategory=CA004" style="text-decoration:none; color:#57615b">Penyimpanan Sepatu</a></li>
                <li><a href="catalogAfterLogin.php?fcategory=CA005" style="text-decoration:none; color:#57615b">Kursi Sisi</a></li>
                <li><a href="catalogAfterLogin.php?fcategory=CA006" style="text-decoration:none; color:#57615b">Lemari Buku</a></li>
                <li><a href="catalogAfterLogin.php?fcategory=CA007" style="text-decoration:none; color:#57615b">Meja Lemari Aksen</a></li>
                <li><a href="catalogAfterLogin.php?fcategory=CA008" style="text-decoration:none; color:#57615b">Meja Tamu</a></li>
                <li><a href="catalogAfterLogin.php?fcategory=CA009" style="text-decoration:none; color:#57615b">Kursi Aksen</a></li>
                <li><a href="catalogAfterLogin.php?fcategory=CA017" style="text-decoration:none; color:#57615b">Lemari Pajangan</a></li>
                <li><a href="catalogAfterLogin.php?fcategory=CA018" style="text-decoration:none; color:#57615b">Meja Makan</a></li>
                <li><a href="catalogAfterLogin.php?fcategory=CA019" style="text-decoration:none; color:#57615b">Ruang Makan</a></li>
            </ul>
        </div>
        <div class="col-lg-2 mt-lg-5 gambar">
            <ul style="list-style-type: none; margin: 0; padding: 0; font-size:12px;">
                <li><a href="catalogAfterLogin.php?fcategory=CA020" style="text-decoration:none; color:#57615b">Kursi Bar</a></li>
                <li><a href="catalogAfterLogin.php?fcategory=CA021" style="text-decoration:none; color:#57615b">Meja Persegi Panjang</a></li>
                <li><a href="catalogAfterLogin.php?fcategory=CA022" style="text-decoration:none; color:#57615b">Bangku</a></li>
                <li><a href="catalogAfterLogin.php?fcategory=CA014" style="text-decoration:none; color:#57615b">Tempat Tidur</a></li>
                <li><a href="catalogAfterLogin.php?fcategory=CA023" style="text-decoration:none; color:#57615b">Meja Kerja</a></li>
                <li><a href="catalogAfterLogin.php?fcategory=CA010" style="text-decoration:none; color:#57615b">Sofa 3 Dudukan</a></li>
                <li><a href="catalogAfterLogin.php?fcategory=CA011" style="text-decoration:none; color:#57615b">Sofa 2 Dudukan</a></li>
                <li><a href="catalogAfterLogin.php?fcategory=CA012" style="text-decoration:none; color:#57615b">Kursi Ruang Kerja</a></li>
                <li><a href="catalogAfterLogin.php?fcategory=CA013" style="text-decoration:none; color:#57615b">Sofa Tempat Tidur</a></li>
                <li><a href="catalogAfterLogin.php?fcategory=CA014" style="text-decoration:none; color:#57615b">Tempat Tidur</a></li>
                <li><a href="catalogAfterLogin.php?fcategory=CA015" style="text-decoration:none; color:#57615b">Kursi Tulis</a></li>
            </ul>
        </div>
        <div class="col-lg-2 mt-lg-5 gambar">
            <ul style="list-style-type: none; margin: 0; padding: 0; font-size:12px;">
                <li><a href="catalogAfterLogin.php?fcategory=CA016" style="text-decoration:none; color:#57615b">Lemari Pakaian</a></li>
                <li><a href="catalogAfterLogin.php?fcategory=CA032" style="text-decoration:none; color:#57615b">Utilitas</a></li>
                <li><a href="catalogAfterLogin.php?fcategory=CA024" style="text-decoration:none; color:#57615b">Meja Rapat</a></li>
                <li><a href="catalogAfterLogin.php?fcategory=CA025" style="text-decoration:none; color:#57615b">Karpet</a></li>
                <li><a href="catalogAfterLogin.php?fcategory=CA026" style="text-decoration:none; color:#57615b">Lampu</a></li>
                <li><a href="catalogAfterLogin.php?fcategory=CA027" style="text-decoration:none; color:#57615b">Vas</a></li>
                <li><a href="catalogAfterLogin.php?fcategory=CA028" style="text-decoration:none; color:#57615b">Obyek Dekoratif</a></li>
                <li><a href="catalogAfterLogin.php?fcategory=CA029" style="text-decoration:none; color:#57615b">Anak-Anak</a></li>
                <li><a href="catalogAfterLogin.php?fcategory=CA030" style="text-decoration:none; color:#57615b">Pengharum Ruangan</a></li>
                <li><a href="catalogAfterLogin.php?fcategory=CA031" style="text-decoration:none; color:#57615b">Penahan Buku</a></li>
                <li><a href="catalogAfterLogin.php?fcategory=CA033" style="text-decoration:none; color:#57615b">Tempat Lilin</a></li>
            </ul>
        </div>
        <div class="col-lg-2 mt-lg-5 gambar">
            <ul style="list-style-type: none; margin: 0; padding: 0; font-size:12px;">
                <li><a href="catalogAfterLogin.php?fcategory=CA034" style="text-decoration:none; color:#57615b">Cermin Dinding</a></li>
                <li><a href="catalogAfterLogin.php?fcategory=CA035" style="text-decoration:none; color:#57615b">Keranjang</a></li>
                <li><a href="catalogAfterLogin.php?fcategory=CA036" style="text-decoration:none; color:#57615b">Aksesoris Penyimpanan</a></li>
                <li><a href="catalogAfterLogin.php?fcategory=CA037" style="text-decoration:none; color:#57615b">Penyimpanan</a></li>
                <li><a href="catalogAfterLogin.php?fcategory=CA038" style="text-decoration:none; color:#57615b">Linen</a></li>
                <li><a href="catalogAfterLogin.php?fcategory=CA039" style="text-decoration:none; color:#57615b">Hewan Peliharaan</a></li>
                <li><a href="catalogAfterLogin.php?fcategory=CA040" style="text-decoration:none; color:#57615b">Bingkai</a></li>
                <li><a href="catalogAfterLogin.php?fcategory=CA041" style="text-decoration:none; color:#57615b">Bunga Imitasi</a></li>
            </ul>
        </div>
        <div class="col-lg-2 mt-lg-3 col-sm-6 gambar">
            <h5 class="fw-bold mb-2">Legal</h5>
            <ul style="list-style-type: none; margin: 0; padding: 0; font-size:12px;">
                <li><a href="kebijakanSudahLogin.php" style="text-decoration:none; color:#57615b">Kebijakan Privasi</a></li>
                <li><a href="snkSudahLogin.php" style="text-decoration:none; color:#57615b">Syarat dan Ketentuan</a></li>
            </ul>
            <h5 class="fw-bold mb-2 mt-2">Support</h5>
            <ul style="list-style-type: none; margin: 0; padding: 0; font-size:12px;">
                <li><a href="contactUs.php" style="text-decoration:none; color:#57615b">Hubungi Kami</a></li>
            </ul> 
        </div>
        <div class="hp">
            <div class="row">
                <div class="col-6">
                    <h5 class="fw-bold mb-2">Legal</h5>
                    <ul style="list-style-type: none; margin: 0; padding: 0; font-size:12px;">
                        <li><a href="kebijakanSudahLogin.php" style="text-decoration:none; color:#57615b">Kebijakan Privasi</a></li>
                        <li><a href="snkSudahLogin.php" style="text-decoration:none; color:#57615b">Syarat dan Ketentuan</a></li>
                    </ul>
                </div>
                <div class="col-6">
                    <h5 class="fw-bold mb-2 mt-lg-2 mt-0">Support</h5>
                    <ul style="list-style-type: none; margin: 0; padding: 0; font-size:12px;">
                        <li><a href="contactUs.php" style="text-decoration:none; color:#57615b">Hubungi Kami</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <footer class="text-center p-2" style="background-color:#5E6F64; height: 38px; font-size:12px; color:burlywood">
        &#169; 2022 Erefir Indonesia
    </footer>
    <!-- </div> -->
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