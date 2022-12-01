<?php
    require_once('../connection.php');
    $dtrans = mysqli_query($conn,"SELECT * FROM d_transaksi where dt_ht_id='".$_SESSION["ditelshtrans"]."'");
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
    <h3>transaksi: <?=$_SESSION["ditelshtrans"]?></h3>
    <form action="#" method="post">
        <button type="submit" formaction="mastertransaksi.php">back</button>
        <table border="1" width="75%">
            <tr>
                <th>ID</th>
                <th>item id</th>
                <th>gambar</th>
                <th>item name</th>
                <th>jumlah</th>
                <th>harga satuan</th>
            </tr>
            <tr>
                <?php
                while($row=mysqli_fetch_assoc($dtrans)){
                    $rowitem = mysqli_query($conn,"SELECT * FROM items where it_id='".$row['dt_it_id']."'");
                    $rowitem=mysqli_fetch_assoc($rowitem);
                    $tempgambar=$rowitem['it_gambar'];
                    ?>
                    <tr>
                        <td><?=$row["dt_id"]?></td>
                        <td><?=$row["dt_it_id"]?></td>
                        <td><img src="../<?=$tempgambar?>" alt="" width="100px" height="100px"></td>
                        <td><?=$rowitem["it_name"]?></td>
                        <td><?=$row["dt_qty"]?></td>
                        <td><?=$row["dt_price"]?></td>
                    </tr>
                    <?php
                }
                ?>
            </tr>
        </table>
    </form>
</body>
</html>