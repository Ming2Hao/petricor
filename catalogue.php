<?php
require_once("connection.php");
if (isset($_SESSION['emailPassing'])) unset($_SESSION['emailPassing']);
function rupiah($angka)
{
    return "Rp " . number_format($angka, 2, ',', '.');
}

$query = "SELECT * FROM items";
$filter = ["it_stat='1'"];
if (isset($_GET["fcategory"])) {
    $cat = $_GET["fcategory"];
    $filter[] = "`it_ca_id`='$cat'";
}
if (isset($_POST["terapkan"])) {
    echo $_POST["mengsorting"];
    $link="location:catalogue.php?sortmode=".$_POST["mengsorting"]; 
    if (isset($_GET["fcategory"])) {
        $cat = $_GET["fcategory"];
        $link .= "&fcategory=" . $cat;
    } 
    if (isset($_GET["searchget"])) {
        $link .= "&searchget=" . $_GET["searchget"];
    }
    header($link);

}
if (isset($_POST["search"])) {
    $link = "location:catalogue.php?searchget=" . mysqli_real_escape_string($conn, $_POST["searchbar"]);
    if (isset($_GET["fcategory"])) {
        $cat = $_GET["fcategory"];
        $link .= "&fcategory=" . $cat;
    }
    header($link);
}
if (isset($_GET["searchget"])) {
    $filter[] = "`it_name` LIKE '%" . mysqli_real_escape_string($conn, $_GET["searchget"]) . "%'";
}
// if (condition) {
//     # code...
// }
$sqlFilter = implode(" AND ", $filter);
$queryCount = "SELECT COUNT(*) AS HITUNG FROM items";
if ($sqlFilter != "") {
    $query .= " WHERE $sqlFilter";
}
if (isset($_GET["sortmode"])) {
    $query .=" ORDER BY ".$_GET["sortmode"];
}
if (isset($_POST["detaildiklik"])) {
    $_SESSION["itemIni"] = $_POST["detaildiklik"];
    header('Location: detailBelumLogin.php');
}
if (!isset($_GET['page'])) {
    $page = 1;
} else {
    $page = $_GET['page'];
}
if(isset($_GET["searchget"])){
    $queryCount.=" WHERE it_name like '%".$_GET["searchget"]."%'";
}
$res=mysqli_query($conn,$queryCount);
$rowCount=mysqli_fetch_assoc($res);
$hitungJumlahItem = $rowCount["HITUNG"];
$results_per_page = 18;
$page_first_result = ($page - 1) * $results_per_page;
// $query = $_SESSION["querysekarang"];  
$result = mysqli_query($conn, $query);
$number_of_result = mysqli_num_rows($result);
$number_of_page = ceil($number_of_result / $results_per_page);
$page_first_result = ($page - 1) * $results_per_page;
$query .= " LIMIT " . $page_first_result . ',' . $results_per_page;
$result = mysqli_query($conn, $query);
// echo $query;
$now = $page;

if (isset($_POST['passing'])) {
    $_SESSION['emailPassing'] = $_POST['passingEmail'];
    header('Location: register.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KATALOG</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.0/mdb.min.css" rel="stylesheet" />
    <style>
        @media screen and (min-device-width: 300px) and (max-device-width: 500px) {
            .kartu {
                height: 200px;
            }

            .gambar {
                display: none;
            }

            .futer {
                display: none;
            }

            .hp {
                display: block;
            }
        }

        @media screen and (min-device-width: 600px) and (max-device-width: 950px) {
            .kartu {
                height: 200px;
            }

            .gambar {
                display: none;
            }

            .hp {
                display: block;
            }

            .futer {
                display: none;
            }

        }

        @media screen and (min-width:1000px) {
            .gambar {
                display: block;
            }

            .futer {
                display: flex;
            }

            .kartu {
                height: 500px;
            }

            .hp {
                display: none;
            }
        }

        .btnHover:hover {
            border: 1px solid #3F4441;
        }

        * {
            /* font-family: 'Josefins Sans'; */
            font-family: 'Montserrat';
            /* text-transform:capitalize; */
            box-sizing: border-box;
        }

        html,
        body {
            width: 100%;
        }

        form .form-field {
            margin-bottom: 40px;
            width: 100%;
            position: relative;
        }

        form .form-field label {
            position: absolute;
            left: 0;
            top: 12px;
            color: #ffff;
            transition: all .5s ease;
            pointer-events: none;
        }

        form .form-field.active label {
            color: #ffff;
            top: -25px;
        }

        form .form-field .border-line {
            position: absolute;
            left: 0;
            bottom: 0;
            width: 0;
            height: 2px;
            background-color: #3F4441;
            transition: all .5s ease;
        }

        form .form-field.active .border-line {
            width: 100%;
        }

        form .form-field input {
            height: 40px;
            color: #ffff;
            width: 100%;
            background-color: transparent;
            border: none;
            border-bottom: 1px solid #3F4441;
        }
    </style>
</head>

<body style="background-color:#FFDECF;">
    <nav class="navbar navbar-expand-lg sticky-top w-100" style="background-color:#3F4441;">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php" name="logodipencet">
                <img src="assets/img/logoFix.jpg" alt="Logo Petricor" width="120" height="40" class="me-2">
            </a>
            <div class="text-white" style="font-size:18px">
                <?php
                // if ($sqlFilter!="") {
                //     $idKategori = substr($sqlFilter, 12, 5);
                //     $kategoriSekarang = mysqli_query($conn, "SELECT ca_name from category where ca_id='$idKategori'");
                //     $kategoriNow = mysqli_fetch_array($kategoriSekarang);
                //     echo "<div class='text-white' style='text-transform: uppercase;'>$kategoriNow[0]</div>";
                // } else {
                echo "KATALOG";
                // }
                ?>
            </div>
            <button class="navbar-toggler btn" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" style="border:none;">
                <!-- <span class="navbar-toggler-icon"></span> -->
                <img src="assets/img/burger.png" alt="" style="width:60px; height:30px;">
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="d-flex w-md-50 w-75">
                    <form action="" method="POST" class="d-flex container-fluid">
                        <div class="input-group">

                            <input type="text" class="form-control ms-lg-2 w-100" placeholder="Cari barang" style="height:34px; margin-top:5px;" name="searchbar">

                            <button class="rounded-end me-lg-4 me-2" style="border:none; background-color:white; margin-top:5px;" name="search">
                                <img src="assets/img/search.png" class="iconsearch" alt="Icon Search" style="width: 20px; height:20px;">
                            </button>

                        </div>
                    </form>
                </div>
                </form>
                <div class="d-lg-flex justify-content-end d-sm-block mt-lg-0 mt-2">
                    <a href="catalogue.php" class="link-light fw-bold mt-4 ms-2 ms-lg-3 mt-lg-0 me-lg-2 fw-bold" style="text-decoration:none;" id="lebar">KATALOG</a>
                    <span class="mx-lg-2 mx-0 mt-lg-0 text-white">|</span>
                    <a href="contactUsBelumLogin.php" class="link-light mt-4 ms-1 ms-lg-2 mt-lg-0 me-lg-2" style="text-decoration:none;" id="lebar">BANTUAN</a>
                    <span class="mx-lg-2 mx-0 mt-lg-0 text-white">|</span>
                    <a href="login.php" class="link-light mt-4 ms-1 ms-lg-2 mt-lg-0 me-lg-2" style="text-decoration:none;" id="lebar">MASUK</a>
                </div>
            </div>
    </nav>

    <div class="container-fluid w-100">
        <!-- munculin gambar -->
        <!-- <div class="mt-lg-3"> -->
        <div class="row">
            <div class="col-12 col-lg-3 pb-lg-0 pb-3" style="background-color:#f7f3f2;">
                <form action="" method="post">
                    <div class="accordion pt-3 " id="accordionPanelsStayOpenExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                                    Filter Kategori
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingOne">
                                <div class="accordion-body">
                                    <div><a href="catalogue.php?<?php if (isset($_GET["searchget"])) {
                                                                                                                $tempsearch = $_GET["searchget"];
                                                                                                                echo "&searchget=$tempsearch";
                                                                                                            } if (isset($_GET["sortmode"])) {
                                                                                                                // $query.= " ORDER BY ". $_GET["sortmode"];
                                                                                                                echo "&sortmode=".$_GET["sortmode"];
                                                                                                            } ?>">All (<?=$hitungJumlahItem?>)</a></div>
                                    <?php
                                    if(isset($_GET["searchget"])){
                                        $tempsearch2 = $_GET["searchget"];
                                        $query="select ca.ca_id as 'idcat', ca.ca_name as 'namecat' from category ca join items i on ca.ca_id=i.it_ca_id where i.it_name like '%$tempsearch2%' and ca_id!='CA001' and i.it_stat='1' GROUP BY ca.ca_id order by ca.ca_name";
                                        $resultkategori = mysqli_query($conn, $query);
                                        $countKategori = mysqli_query($conn, "SELECT COUNT(it_id) as 'hitungBarang'
                                        FROM items i JOIN category c ON i.it_ca_id = c.ca_id
                                        WHERE i.it_name like '%$tempsearch2%' and c.ca_id != 'CA001' and i.it_stat='1'
                                        GROUP BY c.ca_id order by c.ca_name");
                                    }
                                    else{
                                        $query="select ca.ca_id as 'idcat', ca.ca_name as 'namecat' from category as ca where ca_id!='CA001' order by ca.ca_name";
                                        $resultkategori = mysqli_query($conn, $query);
                                        $countKategori = mysqli_query($conn, "SELECT COUNT(it_id) as 'hitungBarang'
                                        FROM items i JOIN category c ON i.it_ca_id = c.ca_id
                                        WHERE c.ca_id != 'CA001' and i.it_stat='1'
                                        GROUP BY c.ca_id order by c.ca_name");
                                    }
                                    $daftarCount = [];
                                    $daftarKategori = [];

                                    
                                        
                                    while ($rowc = $countKategori->fetch_assoc()) {
                                        $daftarCount[] = $rowc;
                                    }
                                    while ($rowb = $resultkategori->fetch_assoc()) {
                                        $daftarKategori[] = $rowb;
                                    }
                                    for ($i = 0; $i < sizeof($daftarKategori); $i++) {
                                    ?>

                                        <!-- <li><a class="dropdown-item" href="#"></a></li> -->
                                        <!-- <input type="checkbox" name="" id="" class="me-2"> <br> -->
                                        <div><a href="catalogue.php?fcategory=<?= $daftarKategori[$i]['idcat'] ?><?php if (isset($_GET["searchget"])) {
                                                                                                                $tempsearch = $_GET["searchget"];
                                                                                                                echo "&searchget=$tempsearch";
                                                                                                            } if (isset($_GET["sortmode"])) {
                                                                                                                // $query.= " ORDER BY ". $_GET["sortmode"];
                                                                                                                echo "&sortmode=".$_GET["sortmode"];
                                                                                                            } ?>"><?= $daftarKategori[$i]['namecat'] ?> (<?= $daftarCount[$i]['hitungBarang'] ?>)</a></div>

                                       
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                                    Sort
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo">
                                <div class="accordion-body">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="3 ASC" name="mengsorting" id="flexRadioDefault1">
                                        <label class="form-check-label" for="flexRadioDefault1">
                                            Nama: A-Z
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="3 DESC" name="mengsorting" id="flexRadioDefault2">
                                        <label class="form-check-label" for="flexRadioDefault2">
                                            Nama: Z-A
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="4 ASC" name="mengsorting" id="flexRadioDefault3">
                                        <label class="form-check-label" for="flexRadioDefault3">
                                            Harga: Rendah-Tinggi
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="4 DESC" name="mengsorting" id="flexRadioDefault4">
                                        <label class="form-check-label" for="flexRadioDefault4">
                                            Harga: Tinggi-Rendah
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn text-white px-4 mt-3 float-end" name="terapkan" style="background-color:#BA7967;">Terapkan</button>
                    </div>
                </form>
            </div>
            <div class="col-lg-9 d-flex justify-content-center mt-3">
                <div class="row row-cols-sm-1 row-cols-md-2 row-cols-lg-3 g-3 w-100">
                    <?php

                    // for($i=0; $i<sizeof($daftarBarang); $i++){
                    while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                        <div class="col d-flex justify-content-center" style="width: 350px;">
                            <div class="card" style="width: 300px; height: 280px; box-shadow: #3F4441 12px 15px 15px -20px; border-radius:15px; background-color:#f7f7f7;">
                                <form action="" method="post">
                                    <button class="btn p-1 btnHover" style="border-radius:15px; width: 300px; height:280px;" value="<?= $row["it_id"] ?>" name="detaildiklik">
                                        <div class="bg-image hover-zoom">
                                            <img src="<?= $row['it_gambar'] ?>" class="card-img-top bg-image hover-zoom" alt="..." style="width:200px; top:0; margin-left:auto; margin-right:auto;">
                                        </div>

                                        <div class="card-body p-0">
                                            <p class="text-secondary mb-0">
                                                <?php
                                                $querykategori = "select * from category where ca_id='" . $row["it_ca_id"] . "'";
                                                $kat = mysqli_query($conn, $querykategori);
                                                $rowss = mysqli_fetch_assoc($kat);
                                                echo $rowss["ca_name"];
                                                ?>
                                            </p>
                                            <p class="card-title mb-0" style="font-size:14px;"><?= $row['it_name'] ?></p>
                                            <p class="text-danger"><?= rupiah($row['it_price']) ?> <span class="text-secondary" style="text-decoration:line-through"><?=rupiah($row['it_price']+1237898)?></span></p>
                                        </div>
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>

        <!-- </div> -->
        <div class="row">
            <div class="col-lg-3 col-12 sm-d-none" style="background-color:#f7f3f2;">

            </div>
            <div class="col-lg-9 col-12">
                <div class="row w-100 ms-lg-0 ms-3">
                    <nav aria-label="..." class="w-100 d-flex justify-content-center mt-3">
                        <ul class="pagination" class="w-100 d-flex">
                            <?php
                            if ($now == 1) {
                            ?>
                                <li class="page-item disabled d-flex">
                                    <a class="page-link">Previous</a>
                                </li>
                            <?php
                            } else {
                            ?>
                                <li class="page-item d-flex">
                                    <a class="page-link" href="catalogue.php?page=<?= $now - 1 ?><?php if (isset($_GET["fcategory"])) {
                                                                                                        echo "&fcategory=" . $_GET["fcategory"];
                                                                                                    }
                                                                                                    if (isset($_GET["searchget"])) {
                                                                                                        echo "&searchget=" . $_GET["searchget"];
                                                                                                    } if (isset($_GET["sortmode"])) {
                                                                                                        echo "&sortmode=" . $_GET["sortmode"];
                                                                                                    } ?>">Previous</a>
                                </li>
                            <?php
                            }
                            ?>
                            <?php
                            // $tempctr=0;
                            // for($page = $now-5; $page <= $now+5; $page++){
                            //     if($page>0){
                            //         $tempctr++;
                            //     }
                            // }
                            if ($now - 3 < 0) {
                                $start = 1;
                            } else if ($now - 3 == 0) {
                                $start = 1;
                            } else {
                                $start = $now - 3;
                            }
                            if ($now + 3 < $number_of_page) {
                                $end = $now + 3;
                            } else if ($now + 3 == $number_of_page) {
                                $end = $number_of_page;
                            } else {
                                $end = $number_of_page;
                            }
                            $kasihstart = false;
                            $kasihend = false;
                            if ($start > 1) {
                            ?>
                                <li class="page-item d-flex" aria-current="page">
                                    <a class="page-link" href="catalogue.php?page=1<?php if (isset($_GET["fcategory"])) {
                                                                                        echo "&fcategory=" . $_GET["fcategory"];
                                                                                    }
                                                                                    if (isset($_GET["searchget"])) {
                                                                                        echo "&searchget=" . $_GET["searchget"];
                                                                                    } if (isset($_GET["sortmode"])) {
                                                                                        echo "&sortmode=" . $_GET["sortmode"];
                                                                                    }
                                                                                    ?>">1</a>
                                </li>
                                <li class="page-item d-flex" aria-current="page">
                                    <a class="page-link">...</a>
                                </li>
                                <?php
                            }

                            for ($page = $start; $page <= $end; $page++) {
                                if ($page == $now) {
                                ?>
                                    <li class="page-item d-flex" aria-current="page" style="background-color:gainsboro; border-radius:5px;">
                                        <a class="page-link" href="catalogue.php?page=<?= $page ?><?php if (isset($_GET["fcategory"])) {
                                                                                                        echo "&fcategory=" . $_GET["fcategory"];
                                                                                                    }
                                                                                                    if (isset($_GET["searchget"])) {
                                                                                                        echo "&searchget=" . $_GET["searchget"];
                                                                                                    } if (isset($_GET["sortmode"])) {
                                                                                                        echo "&sortmode=" . $_GET["sortmode"];
                                                                                                    }  ?>"><?= $page ?></a>
                                    </li>
                                <?php
                                } else {
                                ?>
                                    <li class="page-item d-flex">
                                        <a class="page-link" href="catalogue.php?page=<?= $page ?><?php if (isset($_GET["fcategory"])) {
                                                                                                        echo "&fcategory=" . $_GET["fcategory"];
                                                                                                    }
                                                                                                    if (isset($_GET["searchget"])) {
                                                                                                        echo "&searchget=" . $_GET["searchget"];
                                                                                                    } if (isset($_GET["sortmode"])) {
                                                                                                        echo "&sortmode=" . $_GET["sortmode"];
                                                                                                    }
                                                                                                    ?>"><?= $page ?></a>
                                    </li>
                                <?php
                                }
                            }
                            if ($end < $number_of_page) {
                                ?>
                                <li class="page-item d-flex" aria-current="page">
                                    <a class="page-link">...</a>
                                </li>
                                <li class="page-item d-flex" aria-current="page">
                                    <a class="page-link" href="catalogue.php?page=<?= $number_of_page ?><?php if (isset($_GET["fcategory"])) {
                                                                                                            echo "&fcategory=" . $_GET["fcategory"];
                                                                                                        }
                                                                                                        if (isset($_GET["searchget"])) {
                                                                                                            echo "&searchget=" . $_GET["searchget"];
                                                                                                        } if (isset($_GET["sortmode"])) {
                                                                                                            echo "&sortmode=" . $_GET["sortmode"];
                                                                                                        }
                                                                                                        ?>"><?= $number_of_page ?></a>
                                </li>
                            <?php
                            }
                            ?>
                            <?php
                            if ($now == $number_of_page) {
                            ?>
                                <li class="page-item disabled d-flex">
                                    <a class="page-link">Next</a>
                                </li>
                            <?php
                            } else {
                            ?>
                                <li class="page-item d-flex">
                                    <a class="page-link" href="catalogue.php?page=<?= $now + 1 ?><?php
                                                                                                    if (isset($_GET["fcategory"])) {
                                                                                                        echo "&fcategory=".$_GET["fcategory"];
                                                                                                    }
                                                                                                    if (isset($_GET["searchget"])) {
                                                                                                        echo "&searchget=".$_GET["searchget"];
                                                                                                    } if (isset($_GET["sortmode"])) {
                                                                                                        echo "&sortmode=" . $_GET["sortmode"];
                                                                                                    }
                                                                                                    ?>">Next</a>
                                </li>
                            <?php
                            }
                            ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center" style="height: 140px; background-color:#BA7967; color:#3F4441;">
        <form action="" method="post">
            <div class="row w-100 mx-0 d-flex">
                <div class="col-lg-1 col-sm-0"></div>
                <div class="col-lg-5 mt-lg-4 mt-2 me-lg-5 col-sm-12 text-white">
                    <h2 class="fw-bolder">DAFTAR SEKARANG UNTUK PENAWARAN KHUSUS</H2>
                </div>
                <!-- <div class="d-flex justify-content-end"> -->
                <div class="col-lg-5 mt-lg-5 mt-2 d-flex">
                    <!-- <div class="mt-lg-2"> -->
                    <div class="form-field">
                        <label>Email <span class="text-danger">*</span></label>
                        <input type="email" name="passingEmail" class="input" autocomplete="off">
                        <div class="border-line">
                        </div>
                    </div>
                    <!-- </div> -->

                    <!-- <div class="col-lg-1 m-lg-5"> -->
                    <button type="submit" class="mb-4" style="background:none; border: none;" name="passing">
                        <img src="assets/img/arrow.png" alt="" style="width: 25px; height:25px;">
                    </button>
                </div>
                <!-- </div> -->
                <!-- </div> -->
            </div>
        </form>
    </div>

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
        $(document).ready(function() {
            $(".input").focus(function() {
                $(this).parent(".form-field").addClass("active")
            })
            $(".input").blur(function() {
                if ($(this).val() == "") {
                    $(this).parent(".form-field").removeClass("active")
                }
            })
        })
    </script>
</body>

</html>