<?php
    include 'config/index.php';
    session_start();
    
    $product = $_REQUEST["product"];
    $user = $_SESSION["USER_ID"];
    $now = (int) $_REQUEST["now"];
    $now -= 1;

    if (!$now) {

        $result = mysqli_query($mysqli,"DELETE FROM carts WHERE product_id = ".$product);
        header("Location: keranjang.php");
        exit();
    }
    
    $result = mysqli_query($mysqli,"UPDATE carts set quantity = ". $now ." WHERE product_id =".$product);
    header("Location: keranjang.php");
    exit();
?>