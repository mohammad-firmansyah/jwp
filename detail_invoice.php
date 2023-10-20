<?php 

    include 'config/index.php';
    session_start();
    
    if (!isset($_SESSION['USER_ID'])) {
        header("Location: index.php");
        exit();
    }

    $user = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM users where id = ".$_SESSION["USER_ID"]));
    $transaction_id = mysqli_fetch_array(mysqli_query($mysqli,"SELECT id FROM transactions where user_id = " .$user["id"])); 


    $data =mysqli_query($mysqli,"SELECT * FROM product_transaction tp inner join transactions t on tp.transaction_id = t.id inner join products p on tp.product_id = p.id where t.id = ".$transaction_id["id"]);

    kirimEmail();

    function kirimEmail() {
        $to = "firmansmoh842@gmail.com"; // Alamat email penerima
        $subject = "Verifikasi Pesanan Anda"; // Subjek email
        
        $message = "Isi pesan email Anda."; // Isi pesan email
        $headers = "From: apotekOnline@example.com\r\n";
        $headers .= "Reply-To: apotekOnline@example.com\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

        // Mengirim email
        if (mail($to, $subject, $message, $headers)) {
            echo "Email telah berhasil terkirim.";
        } else {
            echo "Gagal mengirim email.";
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
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


        .center{
            margin:0 auto;
            text-align: center;
        }

        .flex{
            display: flex;
            width: 1024px;
            margin: 0 auto;
            text-align: center;
        }

        .col{
            width: 50%;
        }

        .ttd{
            margin: 100px 0;
            float: right;
            width: 10%;
            
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="center">
            <h1>Toko Alat Kesehatan</h1>
            <h2>Laporan Belanja Anda</h2>
        </div>

        <div class="flex">

            <div class="col col-1">
                <p>User id :  <?= $user["user_id"]?></p>
                <p>Nama : <?= $user["username"] ?> </p>
                <p>alamat : <?= $user["address"] ?></p>
            </div>
            
            <div class="col col-2">
                <p>Tanggal : <?= date("d-m-Y")?></p>
                <p>ID Paypal : <?= $user["paypal_id"] ?></p>
                <p>Nama Bank: BRI </p>
                <p>Cara Bayar: Pre Paid</p>
            </div>
        </div>


        <table>
            <thead>
                <td>No</td>
                <td>Nama dan Produk</td>
                <td>Harga</td>
            </thead>

            <tbody>
                <?php
                $total = 0;
                    while ($a = mysqli_fetch_assoc($data)) {
                        $total = $a["total"];
                        echo '
                            <tr>
                                <td>' . $a['id'] . '</td>
                                <td>' . $a['name'] . '</td>
                                <td>' . $a['price'] . '</td>
                            </tr>
                        ';
                    }

                    echo 'Total : RP.'.$total;
?>


                    
            </tbody>
        </table>

        <div class="ttd">

            <hr>
            <bold>
                ApotekOnline
            </bold>
        </div>
    </div>
</body>
</html>

