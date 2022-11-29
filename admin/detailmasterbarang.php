<?php
    require_once('../connection.php');
    $barang = mysqli_query($conn,"SELECT * FROM items");
    if(isset($_POST["change"])){
        $barang2 = mysqli_query($conn,"SELECT * FROM items where it_id='".$_SESSION["terp"]."'");
        $barang2 = mysqli_fetch_assoc($barang2);
        if($barang2["it_stat"]==0){
            $editstat = mysqli_query($conn,"UPDATE `items` SET `it_stat`=1 WHERE it_id='".$_SESSION["terp"]."'");
        }
        else{
            $editstat = mysqli_query($conn,"UPDATE `items` SET `it_stat`=0 WHERE it_id='".$_SESSION["terp"]."'");
        }
        header('location: detailmasterbarang.php');
    }
    if(isset($_POST["apdet"])){
        $barang2 = mysqli_query($conn,"SELECT * FROM items where it_id='".$_SESSION["terp"]."'");
        $barang2 = mysqli_fetch_assoc($barang2);
        $editstat = mysqli_query($conn,"UPDATE `items` SET `it_name`='".$_POST["nama"]."',`it_price`='".$_POST["harga"]."',`it_desc`='".$_POST["deskripsi"]."',`it_stok`='".$_POST["setok"]."',`it_ca_id`='".$_POST["kategori"]."' WHERE it_id='".$_SESSION["terp"]."'");
        header('location: masterbarang.php');
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
                    if($row["it_id"]==$_SESSION["terp"]){
                        ?>
                        <tr>
                            <td><?=$row["it_id"]?></td>
                            <td><img src='../<?=$row["it_gambar"]?>' width="100px" height="100px"></td>
                            <td><input type="text" name="nama" id="" value='<?=$row["it_name"]?>'></td>
                            <td><input type="number" name="harga" id="" min="1" value='<?=$row["it_price"]?>'></td>
                            <td><textarea name="deskripsi" cols="40" rows="5" id=""><?=$row["it_desc"]?></textarea></td>
                            <?php
                                $kategori=mysqli_query($conn,"SELECT * FROM category where ca_id='".$row["it_ca_id"]."'");
                                $kategori=mysqli_fetch_assoc($kategori)
                            ?>
                            <td>
                                <select name="kategori">
                                    <?php
                                        $resultkategori = mysqli_query($conn, "select * from category"); 
                                        while($row2 = mysqli_fetch_assoc($resultkategori)){
                                            ?>
                                                <option value="<?=$row2["ca_id"]?>" <?php
                                                    if($row2["ca_id"]==$row["it_ca_id"]){
                                                        echo " selected ";
                                                    }
                                                ?>><?=$row2["ca_name"]?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                            </td>
                            <td><input type="number" name="setok" id="" min="1" value='<?=$row["it_stok"]?>'></td>
                            <td><?=$row["it_stat"]?></td>
                            <td><button type="submit" name="change">Change Status</button></td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </tr>
        </table>
        <button type="submit" name="apdet">UPDATE</button>
    </form>
</body>
</html>