<?php
    require_once('../connection.php');
    $htrans = mysqli_query($conn,"SELECT * FROM h_transaksi order by ht_id desc");
    if(isset($_POST["ditel"])){
        $_SESSION["ditelshtrans"]=$_POST["ditel"];
        header('location:detailmastertransaksi.php');
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
    <h2>MASTER TRANSAKSI</h2>
    <form action="#" method="post">
        <button type="submit" formaction="masterbarang.php">master barang</button>
        <button type="submit" formaction="masteruser.php">master user</button>
        <button type="submit" formaction="mastertransaksi.php">master transaksi</button>
        <button type="submit" formaction="tambahbarang.php">tambah barang</button>
        <table border="1" width="75%">
            <tr>
                <th>ID</th>
                <th>pembeli</th>
                <th>tanggal</th>
                <th>total</th>
                <th>alamat</th>
                <th>action</th>
            </tr>
            <tr>
                <?php
                while($row=mysqli_fetch_assoc($htrans)){
                    ?>
                    <tr>
                        <td><?=$row["ht_id"]?></td>
                        <td><?=$row["ht_us_id"]?></td>
                        <td><?=$row["ht_date"]?></td>
                        <td><?=$row["ht_total"]?></td>
                        <td><?=$row["ht_alamat"]?></td>
                        <td><button type="submit" name="ditel" value='<?=$row["ht_id"]?>'>detail</button></td>
                    </tr>
                    <?php
                }
                ?>
            </tr>
        </table>
    </form>
</body>
</html>