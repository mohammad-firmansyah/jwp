<?php 

     require_once("./config/index.php");
    session_start();

    

     $user = 0;
    if ($_SESSION["USER_ID"]){
        $user = $_SESSION["USER_ID"];
    } else {
        header("Location: login.php");
        exit();
    }

    $product = $_REQUEST["product"];
    $user = $_SESSION["USER_ID"];
    $now = date("Y-m-d");

    $product_from_db = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM carts WHERE product_id = " . $product . " AND user_id = " . $user));

    if ($product_from_db) {
        $amount = $product_from_db["quantity"];
        $amount++;
        $result = mysqli_query($mysqli,"UPDATE carts set quantity = ". $amount ." WHERE product_id =".$product);
        header("Location: keranjang.php");
        exit();
    } 

    $result = mysqli_query($mysqli, "INSERT INTO carts (user_id,product_id,created_at,quantity) values ('$user','$product','$now',1)");
    
    header("Location: keranjang.php?user_id=".$user);
    exit();

?>