<?php
    session_start();

    //Parameter untuk mysqli_connection -> host, user, password, db_name
    $conn = mysqli_connect("localhost", "root", "", "db_petricor");

    //Untuk melakukan check apabila ada error atau tidak
    if(mysqli_connect_errno()){
        echo mysqli_error($conn);
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.24/sweetalert2.all.js"></script>
</body>
</html>