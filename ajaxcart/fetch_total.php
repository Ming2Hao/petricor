<?php
	require_once('../connection.php');
    function rupiah($angka){
        return "IDR " . number_format($angka,2,',','.');
    }

	$idcart=$_REQUEST["idcart"];

	$cart = mysqli_query($conn,"SELECT * from cart where ct_id='".$idcart."'");
    $cart = mysqli_fetch_assoc($cart);

    $cartitem=$cart["ct_it_id"];
	$items = mysqli_query($conn,"SELECT * from items where it_id='".$cartitem."'");
    $items = mysqli_fetch_assoc($items);

    $temp=$cart["ct_qty"]*$items["it_price"];
    // $temp=rupiah($temp);
    echo $temp;
?>