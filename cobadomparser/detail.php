<?php
// include('simple_html_dom.php');
// $html = file_get_html('https://sapporo.co.id/product-category/meja-makan/');

// // find all image
// foreach($html->find('.ast-woocommerce-container img') as $e)
//     echo $e->src . '<br>';
//     flush();ob_flush();

    session_start();
    set_time_limit(3600);

    //Parameter untuk mysqli_connection -> host, user, password, db_name
    $conn = mysqli_connect("localhost", "root", "", "cobaproyek");

    //Untuk melakukan check apabila ada error atau tidak
    if(mysqli_connect_errno()){
        echo mysqli_error($conn);
    }

    if(isset($_SESSION["message"])){
        echo "<script>alert('$_SESSION[message]')</script>";
        unset($_SESSION["message"]);
    }

    $result = mysqli_query($conn,"SELECT * from item where id='".$_SESSION["terpilih"]."'");
    $row = mysqli_fetch_row($result);
    
    // include('simple_html_dom.php');
    // $html = file_get_html('https://www.viverecollection.com/furniture/living-room-furniture/sofas?product_list_limit=all');
    
    // // find all image
    // $ctr=1;
    // foreach($html->find('.product-item') as $e){
    //     $tempgambar;
    //     $tempjudul;
    //     foreach ($e->find('.product-image-photo') as $f) {
    //         $tempgambar=$f->src;
    //     }
    //     foreach ($e->find('.product-item-link') as $f) {
    //         $tempjudul=$f->innertext;
    //     }
    //     foreach($e->find('a') as $f){
    //         $temphref=$f->href;
    //         // $temphref=$temphref;
    //         // $html2 = file_get_html($temphref);
    //         // $tempdesc="";
    //         // foreach ($html2->find('.value') as $g) {
    //         //     foreach ($g->find('p') as $h) {
    //         //         $tempdesc=$tempdesc.$h->innertext."<br>";
    //         //     }
    //         // }
    //     }

    //     $templist=[];
    //     $templist["gambar"]=$tempgambar;
    //     $templist["judul"]=$tempjudul;
    //     $templist["href"]=$temphref;
        
    //     $list[$ctr]=$templist;
    //     // echo $tempgambar .'  -  '.$tempjudul .'<br>';
    //     // mysqli_query($conn,"INSERT into item values('$tempgambar','$tempjudul','$ctr')");
    //     $ctr++;
    //     flush();ob_flush();
    // }
    // foreach ($list as $key => $data) {
    //     $html = file_get_html($data["href"]);
    //     $tempdesc="";
    //     foreach ($html->find('.value') as $g) {
    //         foreach ($g->find('p') as $h) {
    //             $tempdesc=$tempdesc.$h->innertext."<br>";
    //         }
    //     }
    //     $val2=$data["gambar"];
    //     $val3=$data["judul"];
    //     $val4=str_replace("'","",$tempdesc);
    //     mysqli_query($conn,"INSERT INTO `item`(`id`, `gambar`, `judul`, `deskripsi`) VALUES ('$key','$val2','$val3','$val4')");
    // }
    // echo "sukses";
    if(isset($_POST["silek"])){
        $_SESSION["terpilih"]=$_POST["silek"];
        header('Location: detail.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
    <form action="#" method="post">
        <div class="container-fluid">
            <img src="<?=$row[1]?>" alt="">
            <br>
            <?=$row[2]?>
            <br>
            <?=$row[3]?>
        </div>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>