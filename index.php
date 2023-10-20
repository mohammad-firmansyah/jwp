<?php

    require_once("./config/index.php");
    session_start();

    

    $result = mysqli_query($mysqli, "SELECT * FROM products ORDER BY id DESC LIMIT 3");    

?>

<html>
    <head>
        <title>Homepage</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
        
        
        <style>
            
            *{
                font-family: 'Montserrat', sans-serif;
                padding: 0;
                margin: 0;
            }

            #main{
                max-width: 1024px;
                display: flex;

                margin: 0 auto;
                padding: 100px 30px;
            }


            .main-one{
                display: flex;
                flex-direction: column;
                margin-top: 100px;
            }
            
            .main-one h2{
                font-size: 36px;
            }
            .main-one p{
                margin: 30px 0;
                font-size: 16px;
            }

            .main-sec{

            }

            .cta {
                background-color: lightcoral;
                padding: 10px 20px;
                text-decoration: none;
                color: white;
                border-radius: 20px;
                flex-wrap: nowrap;
            }

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

            #goods{
                margin: 20px 0 0;
                background-color: rgb(252, 247, 247);
                padding: 100px 0;
            }
            .cards{
                width: 1024px;
                margin: 0 auto;
                display: flex;
            }
            .card{
                padding: 30px 20px;
                border: 1px solid black;
                display: inline-block;
                background-color: white;
                border-radius: 20px;
                font-size: 16px;
                margin: 0 20px;
            }

            .cta-card{
                margin: 20px 0;
                background-color: lightcoral;
                padding: 10px;
                text-decoration: none;
                color: white;
                border-radius: 10px;
            }
            .stock{

            }

            footer{
                text-align: center;
                padding: 20px;
                background-color: lightgray;
            }

            .cta_product{
                text-decoration: none;
                color: white;
                padding:10px 15px;
                border-radius:20px;
                background: lightcoral;
                

            }

            .cta_bg{
                width:1024px;
                height:50px;
                margin:15px auto;
                display:flex;
                flex-direction:column;
                justify-item:flex-end;
                align-items:end;
            }
        </style>   
    </head>
    <body>
        <header>
            <nav>
                <h1>ApotekOnline</h1>
                <ul>
                    <li><a href="#">Home</a></li>
                    <?php
                        if($_SESSION["USER_ID"]){

                            echo '<li > <a href="keranjang.php?user_id='.$_SESSION["USER_ID"].'">Keranjang</a></li>';
                        } else {
                            echo '<li > <a href="login.php">Keranjang</a></li>';
                        }
                    ?>
                    <?php 
                        if (!$_SESSION["USER_ID"]){
                            echo '<li><a href="login.php">Login</a> </li>';
                        } else {
                            echo '<li><a href="logout.php">Logout</a> </li>';

                        }
                    ?>
                    
                </ul>
            </nav>
        </header>

        <section id="main">
            <div class="main-one">
                <h2>Hello Kami Adalah <br> Apotek Online</h2>
                <p>
                    Lorem ipsum dolor sit amet consectetur, adipisicing elit. Accusamus tempora esse laboriosam eligendi.
                </p>
                <div>

                    <a href="#" class="cta">Beli Sesuatu</a>
                </div>
            </div>

            <div class="main-sec">
                <img src="img/hero.jpg" alt="hero" width="500px">
            </div>
        </section> 

        <section id="goods">

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

                        <a href="#" class="cta-card">Beli</a>
                        </div>
                    ';
                }?>
                

               

            </div>
             <div class="cta_bg">

                    <a href="/product.php" class="cta_product">Lihat semua </a>
                </div>
        </section>

        <footer>
            &copy 2023 Mohammad Firmansyah
        </footer>
    </body>
</html>