<?php
    require_once("../connection.php");
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
    $alamats=$_SESSION["alamats"];
    $iht_query = "INSERT INTO `h_transaksi`(`ht_id`, `ht_us_id`, `ht_date`, `ht_total`,`ht_alamat`) VALUES ('$nextht','$curruser','$tanggal','$total','$alamats')";
    $resht = $conn->query($iht_query);

    $result33 = mysqli_query($conn,"SELECT * from cart where ct_us_id='".$_SESSION['currentUser']."'");
    while($row = mysqli_fetch_assoc($result33)){
        $nextdt = mysqli_query($conn,"SELECT MAX(CAST(SUBSTRING(dt_id,3,3) AS UNSIGNED)) FROM d_transaksi");
        $nextdt=mysqli_fetch_row($nextdt)[0];
        $nextdt=$nextdt+1;
        $nextdt="DT".str_pad($nextdt,3,"0",STR_PAD_LEFT);
        $ctitid=$row["ct_it_id"];
        $ctqty=$row["ct_qty"];
        $dtprice = mysqli_query($conn,"SELECT * from items where it_id='$ctitid'");
        $dtprice2 = mysqli_fetch_assoc($dtprice);
        $dtpricefinal = $dtprice2["it_price"];
        $idt_query = "INSERT INTO `d_transaksi`(`dt_id`, `dt_it_id`, `dt_ht_id`, `dt_qty`,`dt_price`) VALUES ('$nextdt','$ctitid','$nextht','$ctqty','$dtpricefinal')";
        $resdt = $conn->query($idt_query);
    }
    $delet_query2 = "DELETE from cart where ct_us_id='".$_SESSION['currentUser']."'";
    $resdelet2= $conn->query($delet_query2);
    header('Location: terimakasih.php');
?>