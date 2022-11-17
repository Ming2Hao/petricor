<?php
	require_once('../connection.php');
	$valbaru=$_REQUEST["valbaru"];
	$idcart=$_REQUEST["idcart"];

    $update_query = "UPDATE cart SET `ct_qty`='$valbaru' WHERE ct_id='$idcart'";
    $res = $conn->query($update_query);

    $cartnow = mysqli_query($conn,"SELECT * FROM cart WHERE ct_id='$idcart'");
    $cartnow=mysqli_fetch_assoc($cartnow);

    $temp=$cartnow["ct_it_id"];
    $itemnya = mysqli_query($conn,"SELECT * FROM items WHERE it_id='$temp'");
    $itemnya=mysqli_fetch_assoc($itemnya);



    $totals=$cartnow["ct_qty"]*$itemnya["it_price"];
    echo "<p>".$totals."</p>";
    ?>