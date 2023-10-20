<?php 
    include 'config/index.php';
    session_start();
    
    if (isset($_SESSION['USER_ID'])) {
        header("Location: index.php");
        exit();
    }


    if (isset($_POST['username'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $dateofbirth  = $_POST['dateofbirth'];
    $gender  = $_POST['gender'];
    $address  = $_POST['address'];
    $city  = $_POST['city'];
    $password = hash('sha256', $_POST['password']); // Hash the input password using SHA-256
    $cpassword = hash('sha256', $_POST['cpassword']); // Hash the input confirm password using SHA-256
 
    if ($password == $cpassword) {
        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($mysqli, $sql);
        if (!$result->num_rows > 0) {
            $sql = "INSERT INTO users (username, email, password,date_of_birth,gender,address,city)
                    VALUES ('$username', '$email', '$password','$dateofbirth','$gender','$address','$city')";
            $result = mysqli_query($mysqli, $sql);
            if ($result) {
                echo "<script>alert('Selamat, registrasi berhasil!')</script>";
                header("Location: login.php");
                exit();
                $username = "";
                $email = "";
                $_POST['password'] = "";
                $_POST['cpassword'] = "";
            } else {
                echo "<script>alert('Woops! Terjadi kesalahan.')</script>";
            }
        } else {
            echo "<script>alert('Woops! Email Sudah Terdaftar.')</script>";
        }
    } else {
        echo "<script>alert('Password Tidak Sesuai')</script>";
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
        * {
            font-family: 'Montserrat', sans-serif;
            padding: 0;
            margin: 0;
        }

        .card {
            width: 600px;
            padding: 20px;
            margin: 100px auto;
            box-sizing: border-box;
        }

        label {
            margin: 20px 10px;
        }

        input {
            width: 100%;
            box-sizing: border-box;
            padding: 10px;
            margin: 20px 10px;
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
    <div class="card">
        <h1>Logo</h1>
        <br>
        <p> Selamat Datang di Toko alat kesehatan</p>

        <br>
        <br>
        <form action="./register.php" method="POST">
            <label for="username">username</label>
            <br>
            <input type="text" name="username" id="username" placeholder="Username">

            <label for="password">Password</label>
            <br>
            <input type="password" name="password" id="password" placeholder="Password">
            <br>
            <label for="cpassword">Retype Password</label>
            <br>
            <input type="password" name="cpassword" id="cpassword" placeholder="Retype Password">
            <br>
            <label for="email">Email</label>
            <br>
            <input type="text" name="email" id="email" placeholder="email">

            <br>
            <label for="dateofbirth">Date of Birth</label>
            <br>
            <input type="date" name="dateofbirth" id="dateofbirth" placeholder="dateofbirth">

            <br>
            <label for="gender">Gender</label>
            
            <select name="gender" id="gender">
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>

            <br>

            <br>
            <label for="address">Address</label>
            <br>
            <input  name="address" id="address" placeholder="address">

            <br>
            <label for="city">City</label>
            
            <select name="city" id="city">
                <option value="default">wajib pilih</option>
                <option value="surabaya">surabaya</option>
            </select>
            
            <br>


            <br>
            <input type="submit" value="Register" class="cta-login">
        </form>
    </div>
</body>

</html>