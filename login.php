<?php 

    include 'config/index.php';
    session_start();
    
    if (isset($_SESSION['USER_ID'])) {
        header("Location: index.php");
        exit();
    }

    if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($mysqli, $_POST['email']);
    $password = hash('sha256', $_POST['password']); // Hash the input password using SHA-256
 
    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = mysqli_query($mysqli, $sql);
 
    if ($result->num_rows > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['USER_ID'] = $row['id'];
        header("Location: index.php");
        exit();
    } else {
        echo "<script>alert('Email atau password Anda salah. Silakan coba lagi!')</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <style>
         *{
                font-family: 'Montserrat', sans-serif;
                padding: 0;
                margin: 0;
            }

        .card{
            width: 600px;
            padding: 20px;
            margin: 100px auto;
            box-sizing: border-box;
        }
        
        label{
            margin: 20px 10px;
        }
        input{
            width: 100%;
            box-sizing: border-box;
            padding: 10px;
            margin: 20px 10px;
        }

        .cta-login{
            background-color: lightcoral;
            border: 0;
            font-size: 16px;
            font-weight: bold;
            color: white;
            padding: 20px ;
        }
    </style>
</head>
<body>
    <div class="card">
        <h1>Logo</h1>
        <br>
        <p> Selamat Datang di Toko alat kesehatan</p>

        <br>
        <br>
        <form action="./login.php" method="post">
            <label for="email">Email</label>
            <br>
            <input type="text" name="email" id="email" placeholder="email">
            
            <br>
            <label for="password">Password</label>
            <br>
            <input type="password" name="password" id="password" placeholder="Password">
            <br>
            <br>
            <input type="submit" name="submit"value="Login" class="cta-login">
            <br>
            <a href="register.php"  rel="noopener noreferrer">Register</a>
        </form>
    </div>
</body>
</html>