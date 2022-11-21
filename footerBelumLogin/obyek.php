<?php
    require_once("helper.php");
    function rupiah($angka){
        return "IDR " . number_format($angka,2,',','.');
    }
    // $_SESSION["sukses"] = 'Data Berhasil Disimpan';
    $listItem = mysqli_query($conn,"SELECT * from items");
    if (isset($_SESSION['currentUser'])) unset($_SESSION['currentUser']);
    if (isset($_SESSION['emailPassing'])) unset($_SESSION['emailPassing']);
    // $tempquery="SELECT * from items";
    // if(!isset($_SESSION["querysekarang"])){
        
    // }
    $_SESSION["queryFooter"]="SELECT * from items where it_ca_id='CA028'";
    if(isset($_POST["detaildiklik"])){
        $_SESSION["itemsekarang"]=$_POST["detaildiklik"];
        header('Location: ../detailBelumLogin.php');
    }
    if (!isset ($_GET['page'])) {  
        $page = 2;
    } else {  
        $page = $_GET['page'];  
    }
    $results_per_page = 20;  
    $page_first_result = ($page-1) * $results_per_page;
    $query = $_SESSION["queryFooter"];  
    $result = mysqli_query($conn, $query);  
    $number_of_result = mysqli_num_rows($result);
    $number_of_page = ceil ($number_of_result / $results_per_page);
    $page_first_result = ($page-1) * $results_per_page;   
    $query = $_SESSION["queryFooter"]." LIMIT " . $page_first_result . ',' . $results_per_page;  
    $result = mysqli_query($conn, $query);  
    // var_dump($result);
    $now=$page;

    if(isset($_POST['passing'])){
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
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.0/mdb.min.css" rel="stylesheet"/>
    <style>
        *{
            /* font-family: 'Josefins Sans'; */
            font-family:'Montserrat';
            /* text-transform:capitalize; */
            box-sizing: border-box;
        }

        html, body{
            width: 100%;
        }
    </style>
</head>
<body style="background-color:#FFDECF;">
        <!-- <div class="container-fluid"> -->
        <nav class="navbar navbar-expand-lg sticky-top w-100" style="background-color:#3F4441;">
            <div class="container-fluid">
                <a class="navbar-brand" href="../index.php" name="logodipencet">
                    <img src="../assets/img/logoFix.jpg" alt="Logo Petricor" width="120" height="40" class="me-2">
                    <div class="text-white">OBYEK DEKORATIF</div>
                </a>
                
            </div>
        </nav>
    
        <div class="container-fluid">
            <!-- <div class="row">
                <div class="col-lg-9 d-flex justify-content-center mt-lg-3"> -->
                    <div class="row d-flex justify-content-center row-cols-sm-1 row-cols-md-2 mt-lg-3 pb-lg-3 row-cols-lg-3 g-3 w-100">
                        <?php
                        
                        // for($i=0; $i<sizeof($daftarBarang); $i++){
                        while($row = mysqli_fetch_assoc($result)){
                        ?>
                            <div class="col d-flex justify-content-center" style="width: 350px;">
                                <div class="card" style="width: 300px; height: 280px; box-shadow: #3F4441 12px 15px 15px -20px; border-radius:15px; background-color:#f7f7f7;">
                                    <form action="" method="post">    
                                        <button class="btn p-1 btnHover" style="border-radius:15px; width: 300px; height:280px;" value="<?=$row["it_id"]?>" name="detaildiklik">
                                            <div class="bg-image hover-zoom">
                                                <img src="../<?=$row['it_gambar']?>" class="card-img-top bg-image hover-zoom" alt="..." style="width:200px; top:0; margin-left:auto; margin-right:auto;">
                                            </div>
                                            
                                            <div class="card-body p-0">
                                                <p class="text-secondary mb-0">
                                                    <?php
                                                    $querykategori="select * from category where ca_id='".$row["it_ca_id"]."'";
                                                    $kat = mysqli_query($conn,$querykategori);
                                                    $rowss = mysqli_fetch_assoc($kat);
                                                    echo $rowss["ca_name"];
                                                    ?>
                                                </p>
                                                <p class="card-title mb-0" style="font-size:14px;"><?=$row['it_name']?></p>
                                                <!-- <p class="text-danger"><?=number_format(1000000, 0, "", "."); ?> <span class="text-secondary" style="text-decoration:line-through">Rp <?=number_format(1221000, 0, "", ".")?></span></p> -->
                                                <p class="text-danger"><?=rupiah($row['it_price'])?> <span class="text-secondary" style="text-decoration:line-through">IDR <?=number_format(17187989, 0, "", ".")?></span></p>
                                            </div>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        <?php
                            }
                        ?>
                    </div>
                <!-- </div>
            </div> -->
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
                                    <a class="page-link" href="obyek.php?page=<?=$now-1?>">Previous</a>
                                </li>
                            <?php
                        }
                    ?>
                    <?php
                        for($page = 1; $page<= $number_of_page; $page++) {
                            if($page==$now){
                                ?>
                                    <li class="page-item active d-flex" aria-current="page">
                                        <a class="page-link" href="obyek.php?page=<?=$page?>"><?=$page?></a>
                                    </li>
                                <?php
                            }
                            else{
                                ?>
                                    <li class="page-item d-flex">
                                        <a class="page-link" href="obyek.php?page=<?=$page?>"><?=$page?></a>
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
                                    <a class="page-link" href="obyek.php?page=<?=$now+1?>">Next</a>
                                </li>
                            <?php
                        }
                    ?>
                </ul>
            </nav>
        </div>
        <hr>

        
        
        <footer class="text-center p-2" style="background-color:#5E6F64; height: 38px; font-size:12px; color:burlywood">
            &#169; 2022 Erefir Indonesia
        </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script> 
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
</body>
</html>