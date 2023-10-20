<?php


    require_once("./config/index.php");
    session_start();

    
    if (!$_SESSION["USER_ID"]){
        header("Location: login.php");
        exit();
    }

    $user_id = $_SESSION["USER_ID"];
    $result = [];
    if($user_id) {

        $result = mysqli_query($mysqli, "SELECT * FROM carts c inner join products p on c.product_id = p.id WHERE c.user_id = " . $user_id);    
    } 


    // $data= mysqli_fetch_assoc($result);
    // print_r($data);
    $total = 0;
    



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang</title>

    <style>
        .container{
            width: 1024px;
            margin: 100px auto;
        }
        table{
            
            width: 100%;
            padding: 10px;
        }

        thead,th{
            color: white;
            border: 1px solid black;
            padding: 10px 20px;
            background-color: lightcoral;
        }

        td{
            border: 1px solid black;
            padding: 10px 20px;
        }

        .btn-cta{
            background: lightblue;
            padding: 5px 15px;
            text-decoration: none;
            color: black;
            font-weight: bold;
            font-size: 20px;
            
        }

        .btn-bayar{
            text-decoration: none;
            color: white;
            display: block;
            text-align:center;
            font-size: 18px;
            border: 0;
            font-weight: bold;
            padding: 10px 15px;
            background-color: lightcoral;
        }
    </style>
</head>
<body>
    
    <div class="container">

        <h1>
            keranjang Belanja
        </h1>
        <table>
        <thead>
            <th>No</th>
            <th>Nama Produk</th>
            <th>Jumlah</th>
            <th>harga</th>
            <th>action</th>
        </thead>
        
        <?php $i = 1; ?>
        <?php while ($data = mysqli_fetch_array($result)) {
        
        echo '<tr>
            <td>'.$i++.'</td>
            <td>'.$data["name"].'</td>
            <td>'.$data["quantity"].'</td>
            <td>'.$data["price"].'</td>
            <td>
                <a href="./add_cart.php?product='.$data["product_id"].'&now='.$data["quantity"].'" class="btn-cta">+</a>
                <a href="./min_cart.php?product='.$data["product_id"].'&now='.$data["quantity"].'" class="btn-cta">-</a>
            </td>
        </tr>';

        $total += $data["price"] * $data["quantity"];
        $_SESSION['total'] = $total;
        }
        ?>
    </table>

    <p>Total Belanja (Termasuk pajak) : RP. <?=$total?> </p>

    <a href="detail_invoice.php" class="btn-bayar">Bayar</a>
</div>
</body>
</html>