<?php
	require_once('../connection.php');
    function rupiah($angka){
        return "Rp " . number_format($angka,2,',','.');
    }


	$cart = mysqli_query($conn,"SELECT * from cart where ct_us_id='".$_SESSION['currentUser']."'");
    $temp=0;
    while($row = mysqli_fetch_assoc($cart)){
        $items = mysqli_query($conn,"SELECT * from items where it_id='".$row['ct_it_id']."'");
        $items = mysqli_fetch_assoc($items);
    
        $temp=$temp+($row["ct_qty"]*100000);
    }
    $temp=rupiah($temp);

    
    echo '<p id="ongkeer">ongkir: '.$temp.'</p>';
?>