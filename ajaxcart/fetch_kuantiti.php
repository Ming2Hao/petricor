<?php
    require_once('../connection.php');
    $jumlah = $_REQUEST["qty"];
    function rupiah($angka){
        return "Rp " . number_format($angka,2,',','.');
    }
    $cek=0;
    $usersekarang=$_SESSION['currentUser'];
    $tempqty=$jumlah;
    $itemdipilih = $_SESSION["itemIni"];
    $_SESSION['qtyBarang'] = $tempqty;
    $hitungCart = null;
    $qtyCart = NULL;
    $cek = mysqli_num_rows(mysqli_query($conn,"SELECT ct_id FROM cart WHERE ct_it_id='$itemdipilih'"));
    if($cek==0){
        $nextinid = mysqli_query($conn,"SELECT MAX(CAST(SUBSTRING(ct_id,3,3) AS UNSIGNED)) FROM cart");
        $nextinid=mysqli_fetch_row($nextinid)[0];
        $nextinid=$nextinid+1;
        $nextinid="CT".str_pad($nextinid,3,"0",STR_PAD_LEFT);
        $qwery="INSERT INTO `cart`(`ct_id`, `ct_it_id`, `ct_us_id`, `ct_qty`) VALUES ('$nextinid','$itemdipilih','$usersekarang','$tempqty')";
        $result = mysqli_query($conn, $qwery);
        $hitungCart = mysqli_query($conn, "SELECT COUNT(ct_it_id) FROM cart WHERE ct_us_id = '$usersekarang'");
        $qtyCart = mysqli_fetch_row($hitungCart);
        $hitungTotal = mysqli_query($conn, "SELECT SUM(i.it_price * c.ct_qty) as 'ttl'
        FROM cart c 
        JOIN users u ON u.us_id = c.ct_us_id
        JOIN items i ON i.it_id = c.ct_it_id");
        $totalcost = mysqli_fetch_row($hitungTotal);
        $tempTotal = rupiah($totalcost[0]);
        echo "$jumlah|$qtyCart[0]|$tempTotal";
    }
    else{
        $update_query88 = "UPDATE cart SET `ct_qty`=ct_qty+$tempqty WHERE ct_us_id='$usersekarang' and ct_it_id='$itemdipilih'";
        $res88 = $conn->query($update_query88);
        $hitungCart = mysqli_query($conn, "SELECT COUNT(ct_it_id) FROM cart WHERE ct_us_id = '$usersekarang'");
        $qtyCart = mysqli_fetch_row($hitungCart);
        $hitungTotal = mysqli_query($conn, "SELECT SUM(i.it_price * c.ct_qty) as 'ttl'
        FROM cart c 
        JOIN users u ON u.us_id = c.ct_us_id
        JOIN items i ON i.it_id = c.ct_it_id");
        $totalcost = mysqli_fetch_row($hitungTotal);
        $tempTotal = rupiah($totalcost[0]);
        echo "$jumlah|$qtyCart[0]|$tempTotal";
    }
    
    
?>