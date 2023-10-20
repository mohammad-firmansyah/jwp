<?php

    include 'config/index.php';
    session_start();

    error_reporting(0);

    $tgl_sekarang = date("Ymd");
    $today = date("Y-m-d");
    $tambah = date("Y-m-d",strtotime("+6 days",strtotime($today)));
    $exp = date("H:i:s");

    $client = "wtImhasbEqKb9jt62aMhIhvP0BpAG5ZU";
    $secret = "HEVq698qQX8dnVls";
    $timestamp = gmdate("Y-m-d\TH:i:s.00\z");
    $token = BrivaGenerateToken($client,$secret);
    
    if ($_POST['brivaNo']) {

        $institutionCode = $_POST['institutionCode'];
        $brivaNo = $_POST['brivaNo'];
        $custCode = $_POST['custCode'];
        $nama = $_POST['nama'];
        $amount = $_POST['amount'];
        $keterangan = $_POST['keterangan'];
        $expiredDate = $_POST['expiredDate'];
    

    $datas = array(
        "institutionCode" => $institutionCode,
        "brivaNo" => $brivaNo, 
        "custCode" => $custCode, 
        "nama" => $nama, 
        "amount" => $amount, 
        "keterangan" => $keterangan, 
        "expiredDate" => $expiredDate, 
    );

    $payload = json_encode($datas);
    $path = "/v1/briva";
    $verb  = "POST";
    $base64Sign = BrivaGenerateSignature($path,$verb,$token,$timestamp,$payload,$secret);
    
    // Set the endpoint URL
    $url = 'https://sandbox.partner.api.bri.co.id/v1/briva';

    $timestamp = gmdate("Y-m-d\TH:i:s.00\z");

    // Set the request headers
    $headers = array(
        'Content-Type: application/json',
        'BRI-Timestamp: '.$timestamp,
        'BRI-Signature: '.$base64Sign,
        'Authorization: Bearer '. $token
    );

    // Set the POST data as a JSON string
  

    // Initialize cURL session
    $ch = curl_init($url);

    // Set cURL options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $datas);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    // Execute cURL request and get the response
    $response = curl_exec($ch);

    // Check for cURL errors
    if (curl_errno($ch)) {
        echo 'cURL Error: ' . curl_error($ch);
    }

    // Close cURL session
    curl_close($ch);

    // Output the response
    echo $response;
    }


    function BrivaGenerateSignature($path,$verb,$token,$timestamp,$payload,$secret) {
        $payload = "path=$path&verb=$verb&token=Bearer $token&timestamp=$timestamp&body=$payload";
        $signPayload = hash_hmac('sha256',$payload,$secret,true);
        return base64_encode($signPayload); 
    }

    function BrivaGenerateToken($client,$secret){

        // Set the endpoint URL
        $url = 'https://sandbox.partner.api.bri.co.id/oauth/client_credential/accesstoken?grant_type=client_credentials';

        // Set the POST data
        $data = array(
            'client_id' => $client,
            'client_secret' => $secret,
            'grant_type' => 'client_credentials' // Include the grant_type parameter
        );

        // Initialize cURL session
        $ch = curl_init($url);

        // Set cURL options
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/x-www-form-urlencoded'
        ));

        // Execute cURL request and get the response
        $response = curl_exec($ch);

        // Check for cURL errors
        if (curl_errno($ch)) {
            echo 'cURL Error: ' . curl_error($ch);
        }

        // Close cURL session
        curl_close($ch);

        // Output the response
        
        $json = json_decode($response,true);
        $access_token = $json['access_token'];

        return $access_token;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <style>

        .container{
             font-family: 'Montserrat', sans-serif;
            width: 1024px;
            margin: 100px auto;
            padding: 30px;
            box-sizing: border-box;
            border: 1px solid black;
        }

        .btn-bayar{
            text-decoration: none;
            color: white;
            font-size: 18px;
            width: 100%;
            border: 0;
            font-weight: bold;
            padding: 10px 15px;
            background-color: lightcoral;
        }

        .label{
            font-size: 24px;
        }

        .input-method{
            margin: 10px;
            font-size: 20px;
        }
        
        

        .card {
            width: 600px;
            padding: 20px;
            margin: 100px auto;
            box-sizing: border-box;
        }


        input {
            width: 100%;
            box-sizing: border-box;
            padding: 10px;
            margin: 20px 0;
        }

        .cta-login {
            background-color: lightcoral;
            border: 0;
            font-size: 16px;
            font-weight: bold;
            color: white;
            padding: 20px;
        }

    </style>
</head>
<body>
    <div class="container">

        <h1 class="title">Pembayaran</h1>

        
        <form action="./bayar.php" method="post">
            
            <input type="text" name="institutionCode" placeholder="Institution Code">
            <input type="text" name="brivaNo" placeholder="Nomor Briva">
            <input type="text" name="custCode" placeholder="Customer Code">
            <input type="text" name="nama" placeholder="Nama">
            <input type="text" name="amount" placeholder="Amount">
            <input type="text" name="keterangan" placeholder="Keterangan">
            <input type="text" name="expiredDate" value="<?= $tambah?>" placeholder="expiredDate">

            <button type="submit" class="btn-bayar">PROSES</button>
        </form>
    </div>
</body>
</html>