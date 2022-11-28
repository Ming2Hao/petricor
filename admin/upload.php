<?php
require_once('../connection.php');
$cek=0;
$cek = mysqli_num_rows(mysqli_query($conn,"SELECT it_id FROM items WHERE it_name='".$_POST['nama']."' and it_ca_id='".$_POST["kategori"]."'"));
if($cek==0){
    $nextitid = mysqli_query($conn,"SELECT MAX(CAST(SUBSTRING(it_id,3,3) AS UNSIGNED)) FROM items");
    $nextitid=mysqli_fetch_row($nextitid)[0];
    $nomorgambar=$nextitid;
    $nextitid=$nextitid+1;
    $nextitid="IT".str_pad($nextitid,3,"0",STR_PAD_LEFT);

    $target_dir = "../gambar/";
    $formatfile = strtolower(pathinfo(basename($_FILES["fileToUpload"]["name"]),PATHINFO_EXTENSION));
    $target_file = $target_dir . "logo". $nomorgambar ."." . $formatfile;
    $uploadOk = 1;
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        }
        else if($formatfile != "jpg" && $formatfile != "png" && $formatfile != "jpeg" ) {
        echo "Format salah";
        $uploadOk = 0;
        }
        else {
            echo "Bukan gambar";
            $uploadOk = 0;
        }
    }
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $nama=$_POST["nama"];
            $harga=$_POST["harga"];
            $deskripsi=$_POST["deskripsi"];
            $kategori=$_POST["kategori"];
            $stok=$_POST["stok"];
            $lokasigambar="gambar/". "logo". $nomorgambar ."." . $formatfile;
            $qwery="INSERT INTO `items`(`it_id`, `it_gambar`, `it_name`, `it_price`, `it_desc`, `it_ca_id`,`it_stok`) VALUES ('$nextitid','$lokasigambar','$nama','$harga','$deskripsi','$kategori','$stok')";
            $result = mysqli_query($conn, $qwery);
            echo "<script> alert ('sukses tambah barang'); </script>";
            header('location:masterbarang.php');
        } else {
            echo "GAGAL";
        }
    }
}
else{
    echo "<script> alert ('barang sudah ada'); </script>";
}

?>