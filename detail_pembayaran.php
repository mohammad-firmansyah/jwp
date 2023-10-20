<?php
    require_once("./config/index.php");
    session_start();

    $now = date("Y-m-d");
    $total = $_SESSION['total'];
    $user_id = $_SESSION['USER_ID'];

    $keranjang = mysqli_query($mysqli, "SELECT * FROM carts c inner join products p on c.product_id = p.id WHERE c.user_id = " . $user_id); 



    
    $result = mysqli_query($mysqli, "INSERT INTO transactions (created_at,status,total,user_id) values ('$now','processed','$total','$user_id')");
 

    if($result){
         $lastInsertedId = mysqli_insert_id($mysqli);
         while ($data = mysqli_fetch_array($keranjang)) {
            $id = $data["id"];
            $input = mysqli_query($mysqli, "INSERT INTO product_transaction (product_id,transaction_id) values ('$id','$lastInsertedId')");
        }

    $delete = mysqli_query($mysqli,"delete from carts where user_id = ".$user_id);

    }

    header("Location: detail_invoice.php");
    exit();
?>
