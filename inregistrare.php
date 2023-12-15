<?php
global $mysqli;
include("configurare.php");
$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['creare'])) {


        if (!empty($_POST['username'])) {
            $username = $_POST['username'];


            if (!empty($_POST['email'] && preg_match("/^[_a-z0-9-+]+(\.[_a-z0-9-+]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i",$_POST['email']))) {
                $email = $_POST['email'];


                if ((!empty($_POST['password'])) && ($_POST['password'] == $_POST['confirm'])) {

                    $password = md5($_POST['password']);
                    $sql = "INSERT INTO user (username,password,email) VALUES ('$username','$password','$email');";

                    $x = "SELECT * FROM user WHERE username= '$username';";
                    $z = "SELECT * FROM user WHERE email= '$email';";
                    $rezx = mysqli_query($mysqli, $x);
                    $rezz = mysqli_query($mysqli, $z);


                    if (!mysqli_num_rows($rezx) > 0) {
                        if(!mysqli_num_rows($rezz) > 0){

                            if (mysqli_query($mysqli, $sql)) {
                                $error = "<h5 style='color: #6610f2'>Contul a fost creat cu succes  !</h5> </br>";
                            }

                        }
                        else $error = "Username-ul Este Luat!";
                    }
                    else $error = "Email-ul Este Utilizat!";

                }
                else $error = "Parolele Nu Coincid!";
            }
            else $error = "Adresa De Email Invalida.";
        }
        else
            $error="Introduce-ti Un Username.";
    }
    if (isset($_POST['inapoi'])) {
        header("location: login.php");
    }
}
?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<html>
<head>
    <title>Inregistrare</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <link rel="stylesheet" href="style.css">

</head>
<body class="gradient">
<div class="login-page">

    <div class="form">
        <h2>Introduceti datele:</h2>
        <br><br>
        <form action="" method="post" class="login-form">

                <input type="text" name="username" placeholder="Username" />

                <input type="text" name="email" placeholder="Email" />

            <br>

                <input type="password" name="password" placeholder="Password"/>

                <input type="password" name="confirm" placeholder="Confirm Password"/>

            <div style="font-size:11px; color:#cc0000; margin-top:10px"><?php echo $error; ?></div>
            <button type="submit" name="creare" class="btn btn-primary">Creare</button>
            <br> <br>
            <button type="submit" name="inapoi" class='btn btn-primary'>Inapoi</button>



        </form>
    </div>
</div>
</body>
</html>