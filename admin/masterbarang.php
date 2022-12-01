<?php
    require_once('../connection.php');
    if(isset($_SESSION["sercsbarang"])){
        $tempsercbarang=$_SESSION["sercsbarang"];
        $barang = mysqli_query($conn,"SELECT * FROM items where it_name like'%$tempsercbarang%'");
    }
    else{
        $barang = mysqli_query($conn,"SELECT * FROM items");
    }
    $_SESSION["terp"]="";
    if(isset($_POST["edit"])){
        $_SESSION["terp"]=$_POST["edit"];
        header('location: detailmasterbarang.php');
    }
    if(isset($_POST["serc"])){
        $_SESSION["sercsbarang"]=$_POST["fieldsearch"];
        header('location:masterbarang.php');
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
    <h2>MASTER BARANG</h2>
    <form action="#" method="post">
        <button type="submit" formaction="masterbarang.php">master barang</button>
        <button type="submit" formaction="masteruser.php">master user</button>
        <button type="submit" formaction="mastertransaksi.php">master transaksi</button>
        <button type="submit" formaction="tambahbarang.php">tambah barang</button>
        <br>
        <br>
        search by nama barang: 
        <input type="text" name="fieldsearch">
        <button type="submit" name="serc">search</button>
        <br>
        <br>
        <table border="1" width="75%">
            <tr>
                <th>ID</th>
                <th>gambar</th>
                <th>nama</th>
                <th>harga</th>
                <th width="30%">deskripsi</th>
                <th>kategori</th>
                <th>stok</th>
                <th>status</th>
                <th>action</th>
            </tr>
            <tr>
                <?php
                while($row=mysqli_fetch_assoc($barang)){
                    ?>
                    <tr>
                        <td><?=$row["it_id"]?></td>
                        <td><img src='../<?=$row["it_gambar"]?>' width="100px" height="100px"></td>
                        <td><?=$row["it_name"]?></td>
                        <td><?=$row["it_price"]?></td>
                        <td><?=$row["it_desc"]?></td>
                        <?php
                            $kategori=mysqli_query($conn,"SELECT * FROM category where ca_id='".$row["it_ca_id"]."'");
                            $kategori=mysqli_fetch_assoc($kategori)
                        ?>
                        <td><?=$kategori["ca_name"]?></td>
                        <td><?=$row["it_stok"]?></td>
                        <td><?=$row["it_stat"]?></td>
                        <td><button type="submit" name="edit" value='<?=$row["it_id"]?>'>ACTION</button></td>
                    </tr>
                    <?php
                }
                ?>
            </tr>
        </table>
    </form>
</body>
</html>