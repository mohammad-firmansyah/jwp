<?php


    require_once("./config/index.php");

    $result = mysqli_query($mysqli, "SELECT * FROM products ORDER BY id DESC");    

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>products</title>

    <style>

        nav{
            display: flex;
            padding: 20px 10px;
            justify-content: space-around;
        }

        nav ul {
            list-style: none;
            display: flex;
        }

        nav ul li {
            padding: 10px;
        }


        .container{
            width: 1024px;
            height: 100vh;
            margin: 100px auto;
        }

        .cards{
            display: flex;
        }

        .cards{
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            row-gap: 30px;
        }
        .card{
            padding: 30px 20px;
            border: 1px solid black;
            display: inline-block;
            background-color: white;
            border-radius: 20px;
            font-size: 16px;
        }

        .cta-card{
            margin: 20px 0;
            background-color: lightcoral;
            padding: 10px;
            text-decoration: none;
            color: white;
            border-radius: 10px;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="cards">
            <?php while ($data = mysqli_fetch_array($result)) {
            
                       echo '
                    
                        <div class="card">
                
                        <div class="card-image">
                            <img src="img/'.$data['product_image'].'" alt="obat" width="250px" height="250px">
                        </div>
                        <div class="card-header">
                            <h3>'. $data["name"].'</h3>
                        </div>
                        <span class="stock">Stok : <span class="stock-change">'.$data["stock"].'</span> Box </span>
                        <br>
                        <span class="harga">Rp. '.$data["price"].' </span>
                        <br>
                        <br>
                        
                        <a href="#" class="cta-card">Lihat</a>
                        <a href="tambah_keranjang.php?product='.$data["id"].'" class="cta-card">Beli</a>
                        </div>
                    ';
                }?>
    </div>
</body>
</html>