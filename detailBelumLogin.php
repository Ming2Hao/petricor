<?php
require_once("connection.php");
function rupiah($angka){
    return "Rp " . number_format($angka,2,',','.');
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
         @media screen and (min-device-width: 300px) and (max-device-width: 500px) { 
            .potrek{
                z-index:-1; margin-top:-35px;
            }
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
            .potrek{
                z-index:-1; margin-top:-90px; width:500px; top:0; margin-left:auto; margin-right:auto;
            }
            .kartu{
                height: 500px;
            }
            .hp{
                display: none;
            }
        }

        @media screen and (min-device-width: 600px) and (max-device-width: 950px) { 
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
                <div class="text-white">DETAIL</div>
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
                <div class="input-group mt-1 mb-2 justify-content-end">
                    <input type="text" class="form-control ms-lg-2 w-100" autocomplete="off" placeholder="Cari barang" style="height:34px; margin-top:5px; display:none;" name="searchbar">
                    <a class="rounded me-lg-4 me-2 px-2" style="border:none; background-color:white; margin-top:5px;" href="catalogue.php" type="submit">
                        <img src="assets/img/search.png" class="iconsearch" alt="Icon Search" style="width: 20px; height:20px;">
                    </a>   
                </div>
            </div>
            <div class="d-lg-flex justify-content-end d-sm-block mt-lg-0 mt-2">
                <a href="catalogue.php" class="link-light mt-4 ms-1 ms-lg-3 mt-lg-0 me-lg-2" style="text-decoration:none;" id="lebar">KATALOG</a>
                <span class="mx-lg-2 mx-0 mt-lg-0 text-white">|</span>
                <a href="contactUsBelumLogin.php" class="link-light mt-4 ms-1 ms-lg-2 mt-lg-0 me-lg-2" style="text-decoration:none;" id="lebar">BANTUAN</a>
                <span class="mx-lg-2 mx-0 mt-lg-0 text-white">|</span>
                <a href="login.php" class="link-light mt-4 ms-1 ms-lg-2 mt-lg-0 me-lg-2" style="text-decoration:none;" id="lebar">MASUK</a>
            </div>
        </div>
        </nav>
    <div class="row w-100">
        <div class="col-lg-4 col-sm-12 col-md-12">
            <div class="bg-image hover-zoom">
                <a href="catalogue.php"><img src="assets/img/return.png" alt="" style="width:25px; z-index:2;" class="mt-2 ms-3"></a>
                <img src="<?=$row['it_gambar']?>" class="card-img-top bg-image hover-zoom potrek" alt="...">
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
        <div class="col-lg-5 col-sm-12 col-md-12 ms-lg-0 ms-2">
            <h4 class="mt-lg-4 mt-1 mb-lg-3 fw-bolder" style="text-transform:uppercase; text-decoration:underline;">Deskripsi Produk <?=$row['it_name']?></h4>
            <?=$row["it_desc"]?>
            <form action="#" method="post" class="mt-lg-4 mt-3 float-end">
                <input type="number" name="quantiti" id="" value="1" min="1" style="border-radius:8px; width: 72px;">
                <button type="submit" name="tambahkeranjang" style="border-radius: 8px; background-color:#555; color:#ffffff;">Masukkan ke Keranjang</button>
            </form>
        </div>
    </div>
    <hr style="color:#cecece">
    <div class="row container-fluid w-100 mb-4 mt-3 mx-0 container-fluid">
        <div class="col-lg-1 me-lg-5 gambar"></div>
        <div class="col-lg-2 mt-lg-3 gambar">
            <h5 class="fw-bold mb-2">Kategori</h5>
            <ul style="list-style-type: none; margin: 0; padding: 0; font-size:12px;">
                <li><a href="catalogue.php?fcategory=CA002" style="text-decoration:none; color:#57615b">Meja Nakas</a></li>
                <li><a href="catalogue.php?fcategory=CA003" style="text-decoration:none; color:#57615b">Kursi Berlengan</a></li>
                <li><a href="catalogue.php?fcategory=CA004" style="text-decoration:none; color:#57615b">Penyimpanan Sepatu</a></li>
                <li><a href="catalogue.php?fcategory=CA005" style="text-decoration:none; color:#57615b">Kursi Sisi</a></li>
                <li><a href="catalogue.php?fcategory=CA006" style="text-decoration:none; color:#57615b">Lemari Buku</a></li>
                <li><a href="catalogue.php?fcategory=CA007" style="text-decoration:none; color:#57615b">Meja Lemari Aksen</a></li>
                <li><a href="catalogue.php?fcategory=CA008" style="text-decoration:none; color:#57615b">Meja Tamu</a></li>
                <li><a href="catalogue.php?fcategory=CA009" style="text-decoration:none; color:#57615b">Kursi Aksen</a></li>
                <li><a href="catalogue.php?fcategory=CA017" style="text-decoration:none; color:#57615b">Lemari Pajangan</a></li>
                <li><a href="catalogue.php?fcategory=CA018" style="text-decoration:none; color:#57615b">Meja Makan</a></li>
                <li><a href="catalogue.php?fcategory=CA019" style="text-decoration:none; color:#57615b">Ruang Makan</a></li>
            </ul>
        </div>
        <div class="col-lg-2 mt-lg-5 gambar">
            <ul style="list-style-type: none; margin: 0; padding: 0; font-size:12px;">
                <li><a href="catalogue.php?fcategory=CA020" style="text-decoration:none; color:#57615b">Kursi Bar</a></li>
                <li><a href="catalogue.php?fcategory=CA021" style="text-decoration:none; color:#57615b">Meja Persegi Panjang</a></li>
                <li><a href="catalogue.php?fcategory=CA022" style="text-decoration:none; color:#57615b">Bangku</a></li>
                <li><a href="catalogue.php?fcategory=CA014" style="text-decoration:none; color:#57615b">Tempat Tidur</a></li>
                <li><a href="catalogue.php?fcategory=CA023" style="text-decoration:none; color:#57615b">Meja Kerja</a></li>
                <li><a href="catalogue.php?fcategory=CA010" style="text-decoration:none; color:#57615b">Sofa 3 Dudukan</a></li>
                <li><a href="catalogue.php?fcategory=CA011" style="text-decoration:none; color:#57615b">Sofa 2 Dudukan</a></li>
                <li><a href="catalogue.php?fcategory=CA012" style="text-decoration:none; color:#57615b">Kursi Ruang Kerja</a></li>
                <li><a href="catalogue.php?fcategory=CA013" style="text-decoration:none; color:#57615b">Sofa Tempat Tidur</a></li>
                <li><a href="catalogue.php?fcategory=CA014" style="text-decoration:none; color:#57615b">Tempat Tidur</a></li>
                <li><a href="catalogue.php?fcategory=CA015" style="text-decoration:none; color:#57615b">Kursi Tulis</a></li>
            </ul>
        </div>
        <div class="col-lg-2 mt-lg-5 gambar">
            <ul style="list-style-type: none; margin: 0; padding: 0; font-size:12px;">
                <li><a href="catalogue.php?fcategory=CA016" style="text-decoration:none; color:#57615b">Lemari Pakaian</a></li>
                <li><a href="catalogue.php?fcategory=CA032" style="text-decoration:none; color:#57615b">Utilitas</a></li>
                <li><a href="catalogue.php?fcategory=CA024" style="text-decoration:none; color:#57615b">Meja Rapat</a></li>
                <li><a href="catalogue.php?fcategory=CA025" style="text-decoration:none; color:#57615b">Karpet</a></li>
                <li><a href="catalogue.php?fcategory=CA026" style="text-decoration:none; color:#57615b">Lampu</a></li>
                <li><a href="catalogue.php?fcategory=CA027" style="text-decoration:none; color:#57615b">Vas</a></li>
                <li><a href="catalogue.php?fcategory=CA028" style="text-decoration:none; color:#57615b">Obyek Dekoratif</a></li>
                <li><a href="catalogue.php?fcategory=CA029" style="text-decoration:none; color:#57615b">Anak-Anak</a></li>
                <li><a href="catalogue.php?fcategory=CA030" style="text-decoration:none; color:#57615b">Pengharum Ruangan</a></li>
                <li><a href="catalogue.php?fcategory=CA031" style="text-decoration:none; color:#57615b">Penahan Buku</a></li>
                <li><a href="catalogue.php?fcategory=CA033" style="text-decoration:none; color:#57615b">Tempat Lilin</a></li>
            </ul>
        </div>
        <div class="col-lg-2 mt-lg-5 gambar">
            <ul style="list-style-type: none; margin: 0; padding: 0; font-size:12px;">
                <li><a href="catalogue.php?fcategory=CA034" style="text-decoration:none; color:#57615b">Cermin Dinding</a></li>
                <li><a href="catalogue.php?fcategory=CA035" style="text-decoration:none; color:#57615b">Keranjang</a></li>
                <li><a href="catalogue.php?fcategory=CA036" style="text-decoration:none; color:#57615b">Aksesoris Penyimpanan</a></li>
                <li><a href="catalogue.php?fcategory=CA037" style="text-decoration:none; color:#57615b">Penyimpanan</a></li>
                <li><a href="catalogue.php?fcategory=CA038" style="text-decoration:none; color:#57615b">Linen</a></li>
                <li><a href="catalogue.php?fcategory=CA039" style="text-decoration:none; color:#57615b">Hewan Peliharaan</a></li>
                <li><a href="catalogue.php?fcategory=CA040" style="text-decoration:none; color:#57615b">Bingkai</a></li>
                <li><a href="catalogue.php?fcategory=CA041" style="text-decoration:none; color:#57615b">Bunga Imitasi</a></li>
            </ul>
        </div>
        <div class="col-lg-2 mt-lg-3 col-sm-6 gambar">
            <h5 class="fw-bold mb-2">Hukum</h5>
            <ul style="list-style-type: none; margin: 0; padding: 0; font-size:12px;">
                <li><a href="kebijakanBelumLogin.php" style="text-decoration:none; color:#57615b">Kebijakan Privasi</a></li>
                <li><a href="snkBelumLogin.php" style="text-decoration:none; color:#57615b">Syarat dan Ketentuan</a></li>
            </ul>
            <h5 class="fw-bold mb-2 mt-2">Mendukung</h5>
            <ul style="list-style-type: none; margin: 0; padding: 0; font-size:12px;">
                <li><a href="contactUsBelumLogin.php" style="text-decoration:none; color:#57615b">Hubungi Kami</a></li>
            </ul> 
        </div>
        <div class="hp">
            <div class="row">
                <div class="col-6">
                    <h5 class="fw-bold mb-2">Hukum</h5>
                    <ul style="list-style-type: none; margin: 0; padding: 0; font-size:12px;">
                        <li><a href="kebijakanBelumLogin.php" style="text-decoration:none; color:#57615b">Kebijakan Privasi</a></li>
                        <li><a href="snkBelumLogin.php" style="text-decoration:none; color:#57615b">Syarat dan Ketentuan</a></li>
                    </ul>
                </div>
                <div class="col-6">
                    <h5 class="fw-bold mb-2 mt-lg-2 mt-0">Mendukung</h5>
                    <ul style="list-style-type: none; margin: 0; padding: 0; font-size:12px;">
                        <li><a href="contactUsBelumLogin.php" style="text-decoration:none; color:#57615b">Hubungi Kami</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
        <footer class="text-center p-2" style="background-color:#5E6F64; height: 38px; font-size:12px; color:burlywood">
            &#169; 2022 Erefiv Indonesia
        </footer>

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