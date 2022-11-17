<?php
	require_once('../connection.php');
	$result = mysqli_query($conn,"SELECT * from cart where ct_us_id='".$_SESSION['currentUser']."'");

    echo '<div class="col-9" id="maincart">';
                    while($row = mysqli_fetch_assoc($result)){
                        $item = mysqli_query($conn,"SELECT * from items where it_id='".$row["ct_it_id"]."'");
                        $item=mysqli_fetch_assoc($item);
                        $cat = mysqli_query($conn,"SELECT * from category where ca_id='".$item["it_ca_id"]."'");
                        $cat=mysqli_fetch_assoc($cat);
                echo '<div class="px-0 mx-0">
                    <div class="row pe-0 mb-3 w-100">
                        <div class="col-1 px-0 mx-0 rounded">
                            <img src="'.$item["it_gambar"].'" alt="" class="rounded-start w-100 h-100 col-1 px-0 mx-0 ">
                        </div>
                        <div class="col-9 border-start border-end mx-0 align-items-center py-3 mx-0" style="background-color:#f7f7f7;">
                            <p class="w-100">'.$item["it_name"].'<br>'.$cat["ca_name"].'</p>'.
                                $item["it_price"].'X
                                <input type="number" name="'.$row["ct_id"].'" class="idupdown" value="'.$row["ct_qty"].'" min="0">
                                =
                                <p id="'.$row["ct_id"].'idnumericupdown" class="'.$row["ct_id"].' total">'.$row["ct_qty"]*$item["it_price"].'</p>
                        </div>
                        <div class="col-2 border-start mx-0 rounded-end align-items-center d-flex align-items-center" style="background-color:#f7f7f7;">
                            <button type="submit" value="'.$row["ct_id"].'" class="btn w-100 bg-danger text-white">
                                Delete
                            </button>
                        </div>
                    </div>
                </div>';}
?>