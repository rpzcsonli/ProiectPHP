<?php
include("configurare.php");

session_start();

if(isset($_SESSION['login_user']) && (isset($_SESSION['ramai']) )){
    $ramai = $_SESSION['ramai'];
    if($ramai == true)
        header("Location: meniu.php");
    else
    {if (session_destroy()) {
        header("Location: login.php");}
        exit();
    }
}
$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ramai =false;
    if (isset($_POST['logare'])) {
        $myusername = mysqli_real_escape_string($mysqli, $_POST['username']);
        $mypassword = mysqli_real_escape_string($mysqli, md5($_POST['password']));
        $sql = "SELECT IDuser FROM user WHERE (username like '$myusername' and password like binary '$mypassword')";
        $result = mysqli_query($mysqli, $sql);
        if (!is_null($result)) {
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            if (!is_null($row)) {
                $_SESSION['IDuser'] = $row["IDuser"];
                $active = $row['active'];
            } else {
                $error = "User sau parola gresita!";
            }
        } else {
            $error = "User sau parola gresita";
            header("location: login.php");
        }
        $count = mysqli_num_rows($result);
        if ($count == 1) {
            $_SESSION['login_user'] = $myusername;
            header("location: meniu.php");
        } else {
            $error = "User sau parola gresita";
        }
    }
    if (isset($_POST['inregistrare'])) {
        header("location: inregistrare.php");
    }
    if(isset($_POST['ramaiconectat']))
        $ramai=  true;
    $_SESSION['ramai']= $ramai;
}
?>

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<head>
    <title>Login Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body class="gradient">
<div class="login-page">
    <div class="form">
        <h2>Bine ati venit!</h2>
        </br></br>
        <form action="" method="post" class="login-form">
            <input type="text" name="username" placeholder="Username" />
            </br>
            <input type="password" name="password" placeholder="Password"/>
            <div style="white-space: nowrap;"> Ramai Conectat<input style="width: 20%;" type="checkbox" name="ramaiconectat" value="logat">    </div>
            <div style="font-size:11px; color:#cc0000; margin-top:10px"><?php echo $error; ?></div>
            <button type="submit" name="logare" class="btn btn-primary">Logare</button>
            </br> </br>
            <button type="submit" name="inregistrare" class='btn btn-primary'>Inregistrare</button>
        </form>
    </div>
</div>
</body>
