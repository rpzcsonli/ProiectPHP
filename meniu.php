<?php
include("configurare.php");
global $mysqli;
session_start();
$sql ="";
if(!isset($_SESSION['login_user']) && (!isset($_SESSION['ramai']) )){
    if (session_destroy())
    {
        header("Location: login.php");
        exit();
    }
}
$ID=$_SESSION['IDuser'];
$error = "";
$user=$_SESSION['login_user'];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['logout'])) {
        if (session_destroy()) {
            header("Location: login.php");
        }
    }
    if(isset($_POST['masini']))
    {
        $sql = "SELECT * FROM masini WHERE IDuser = '$ID'";
        $result = mysqli_query($mysqli, $sql);
        if(mysqli_num_rows($result)!=0){
        echo "<div id='divphp' class='form' style='margin-bottom=0'>";
        while ($z = mysqli_fetch_assoc($result))
        {
            echo "<button type='submit' class='masini' name='masina' value={$z["IDmasina"]} >{$z["numar"]} </button>";
        }
        echo"</div>";}
        else
            echo "<div id='divphp' class='form' style='margin-bottom=0'> <h5> Adaugati un autoturism!</h5> </div> ";
    }


    if(isset($_POST['masina']))
    {
        $_SESSION['masina'] = $_POST['masina'];
        header("Location: parcare.php");
    }
    if(isset($_POST['adaugare']))
    {
        header("Location: adaugareMasini.php");
    }


}
?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<html lang="en">
<head>
    <title>Meniu Principal</title>
    <link rel="stylesheet" href="bootstrap-5.3.2-dist/css/bootstrap.css">
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
</head>
<body class="gradient">

<div class="menu-page" style="padding: =1%" id="divP">
    <div class="form" >
        <?php
        echo"<h2 class='badge bg-primary' style='font-size:200% ;'>Utilizator</h2> </br>
        <h2 class='badge bg-primary' style='font-size:150% ;'>{$_SESSION['login_user']}</h2>";
        ?>
        </br></br>
        <form action="" method="post" class="login-form" id="form1">
            <div style="font-size:11px; color:#cc0000; margin-top:10px"><?php echo $error; ?></div>
            <button class="btn btn-primary" type ="submit" name="masini">Masini</button>
            </br></br>
            <button class="btn btn-primary" type ="submit" name="adaugare">Adaugare</button>
            </br>
        </form>

    </div>

    <form method="post" class="login-form" id="form2">

    </form>

    <script>
        var elementToMove = document.getElementById('divphp');
        var newParent = document.getElementById('form2');
        newParent.appendChild(elementToMove);
    </script>

    <form action="" method="post" class="login-form">
        <div class="form">
            <button  class='btn btn-primary logout' type="submit" name="logout" > Logout</button>
        </div>

    </form>


</body>
</html>

