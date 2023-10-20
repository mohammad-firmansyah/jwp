<?php 

    include 'config/index.php';
    session_start();
    
    $product = $_REQUEST["product"];
    $user = $_SESSION["USER_ID"];
    $now = (int) $_REQUEST["now"];
    $now += 1;

    $stock = mysqli_query($mysqli,"SELECT stock FROM products WHERE id =".$product);
    if ($stock > $now){
        $result = mysqli_query($mysqli,"UPDATE carts set quantity = ". $now ." WHERE product_id =".$product);
        header("Location: keranjang.php");
        exit();
    }

    header("Location: keranjang.php");
    exit();



?>