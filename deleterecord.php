<?php
    require_once('connection.php');
    if($_REQUEST['delete'])
    {
        $delet_query = "DELETE from cart where ct_id='".$_REQUEST['delete']."'";
        $resdelet = $conn->query($delet_query);
        if($resdelet){
            header('Location: cart.php');
        }
        // if($resultset) 
        // {
        //     echo "Record Deleted Successfully";
        // }
    }
?>