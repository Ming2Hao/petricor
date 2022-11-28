<?php
    $password="dicarryfeli";
    if(isset($_POST["login"])){
        if($_POST["password"]==$password){
            header('location: masterbarang.php');
        }
        else{
            echo "<script>alert('kamu siapa?')</script>";
        }
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
    <form action="#" method="post">
        PASSWORD
        <input type="text" name="password" id="">
        <button type="submit" name="login">LOGIN</button>
    </form>
</body>
</html>