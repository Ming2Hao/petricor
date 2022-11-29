<?php
    require_once('../connection.php');
    $user = mysqli_query($conn,"SELECT * FROM users");
    if(isset($_POST["edit"])){
        $user2 = mysqli_query($conn,"SELECT * FROM users where us_id='".$_POST["edit"]."'");
        $user2 = mysqli_fetch_assoc($user2);
        if($user2["us_status"]==0){
            $editstat = mysqli_query($conn,"UPDATE `users` SET `us_status`=1 WHERE us_id='".$_POST["edit"]."'");
        }
        else{
            $editstat = mysqli_query($conn,"UPDATE `users` SET `us_status`=0 WHERE us_id='".$_POST["edit"]."'");
        }
        header('location: masteruser.php');
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
    <h1>Welcome, Admin</h1>
    <h2>MASTER USER</h2>
    <form action="#" method="post">
        <button type="submit" formaction="masterbarang.php">master barang</button>
        <button type="submit" formaction="masteruser.php">master user</button>
        <button type="submit" formaction="mastertransaksi.php">master transaksi</button>
        <button type="submit" formaction="tambahbarang.php">tambah barang</button>
        <table border="1" width="75%">
            <tr>
                <th>ID</th>
                <th>username</th>
                <th>nama</th>
                <th>email</th>
                <th>Password</th>
                <th>Tanggal Lahir</th>
                <th>gender</th>
                <th>status</th>
                <th>action</th>
            </tr>
            <tr>
                <?php
                while($row=mysqli_fetch_assoc($user)){
                    ?>
                    <tr>
                        <td><?=$row["us_id"]?></td>
                        <td><?=$row["us_username"]?></td>
                        <td><?=$row["us_name"]?></td>
                        <td><?=$row["us_email"]?></td>
                        <td><?=$row["us_password"]?></td>
                        <td><?=$row["us_birth"]?></td>
                        <td><?=$row["us_gender"]?></td>
                        <td><?=$row["us_status"]?></td>
                        <td><button type="submit" name="edit" value='<?=$row["us_id"]?>'>Ban/unban</button></td>
                    </tr>
                    <?php
                }
                ?>
            </tr>
        </table>
    </form>
</body>
</html>