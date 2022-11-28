<?php
    require_once('../connection.php');

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
    <h2>TAMBAH BARANG</h2>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <button type="submit" formaction="masterbarang.php">master barang</button>
        <button type="submit" formaction="masteruser.php">master user</button>
        <button type="submit" formaction="mastertransaksi.php">master transaksi</button>
        <button type="submit" formaction="tambahbarang.php">tambah barang</button>
        <br>
        <input type="text" name="nama" id="" placeholder="nama barang">
        <br>
        <input type="number" min="1" name="harga" id="" placeholder="harga">
        <br>
        <input type="number" min="1" name="stok" id="" placeholder="stok">
        <br>
        <textarea name="deskripsi" cols="40" rows="5" placeholder="Deskripsi"></textarea>
        <br>
        <select name="kategori" id="">
            <?php
                $resultkategori = mysqli_query($conn, "select * from category"); 
                while($row = mysqli_fetch_assoc($resultkategori)){
                    ?>
                        <option value="<?=$row["ca_id"]?>"><?=$row["ca_name"]?></option>
                    <?php
                }
            ?>
        </select>
        <br>
        Select image to upload:
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Upload Image" name="submit">
    </form>
</body>
</html>