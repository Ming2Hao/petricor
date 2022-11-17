<?php
    require_once("connection.php");
    if(!isset($_SESSION['currentUser'])){
        header('Location: login.php');
    }
    if(isset($_SESSION['currentUser'])){
        $result = mysqli_query($conn,"SELECT * from cart where ct_us_id='".$_SESSION['currentUser']."'");
    }
    if(isset($_POST["cekout"])){
        $nextht = mysqli_query($conn,"SELECT MAX(CAST(SUBSTRING(ht_id,3,3) AS UNSIGNED)) FROM h_transaksi");
        $nextht=mysqli_fetch_row($nextht)[0];
        $nextht=$nextht+1;
        $nextht="HT".str_pad($nextht,3,"0",STR_PAD_LEFT);
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
    </style>
</head>
<body style="background-color:#FFDECF;" onload="load_ajax()">
    <div class="container-fluid px-0">
        
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
                        <a href="cart.php">
                            <img src="assets/img/cart.png" alt="iconCart" class="me-1 me-lg-5 mt-3 mt-lg-1 ms-lg-1" style="width:36px; height:36px;" id="lebar">
                        </a>
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

        <h1>Terimakasih telah memesan</h1>
        <h3>No Transaksi: <?=$_SESSION["notransaksi"]?></h3>
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
                    $('.<?=$row["ct_id"]?>idnumericupdown').html('<?=$row["ct_qty"]*$item["it_price"]?>');
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