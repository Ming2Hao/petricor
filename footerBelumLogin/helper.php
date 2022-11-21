<?php
    session_start();

    //Parameter untuk mysqli_connection -> host, user, password, db_name
    $conn = mysqli_connect("localhost", "root", "", "db_petricor");

    //Untuk melakukan check apabila ada error atau tidak
    if(mysqli_connect_errno()){
        echo mysqli_error($conn);
    }

?>