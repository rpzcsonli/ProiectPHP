<?php
session_start();
if(!isset($_SESSION['login_user']) && (!isset($_SESSION['ramai']) )){
    if (session_destroy())
    {
        header("Location: login.php");
        exit();
    }
}
global $mysqli;
include("configurare.php");
$error = "";
$ID=$_SESSION['IDuser'];
$idmasina=$_SESSION['masina'];
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $zona = $_POST['radioZona'];

    if (isset($_POST['plateste'])) {
        $ore = (int)$_POST['ore'];
        if($ore >0) {

            $ore -= 1;

            $sql = "INSERT INTO parcare (IDmasina,ore,zona) VALUES ('$idmasina','$ore','$zona')";
            if (mysqli_query($mysqli, $sql)) {
                $error = "<h5 style='color: #6610f2'>Plata a avut succes !</h5> </br>";
            }
        }else $error ="Introduceti un numar pozitiv!";
    } else
        $error = "Introduce un numar!";


    if (isset($_POST['inapoi'])) {
        header("location: meniu.php");

    }
    if (isset($_POST['sterge'])) {

        $sql = "DELETE FROM masini WHERE IDmasina=$idmasina";

        if (mysqli_query($mysqli, $sql)) {
            header("location: meniu.php");
        }
        else
            $error = "<h5 style='color: #6610f2'>Masina a fost adaugata!</h5> </br>";

    }


}
?>


<meta name="viewport" content="width=device-width, initial-scale=1.0">
<html>
<head>
    <title>Inregistrare</title>
    <link rel="stylesheet" href="bootstrap-5.3.2-dist/css/bootstrap.css">
    <link rel="stylesheet" href="style.css">
</head>
<body class="gradient">
<div class="login-page">
    <div class="form">
        <?php
        $ID=$_SESSION['IDuser'];
        $idmasina=$_SESSION['masina'];
        $sql = "SELECT * FROM parcare WHERE IDmasina='$idmasina'";
        $result=mysqli_query($mysqli, $sql);
echo " <h5>Timp ramas: <br>zi/ora/min/sec </h5>";
        while ($z = mysqli_fetch_assoc($result))
        {
            $timp= new DateTime($z["dataI"]);
            $timpCurent= new DateTime();
            $timp->add(new DateInterval('PT' . $z["ore"] . 'H'));
            $diferenta = $timpCurent->diff($timp);
            if($timp<$timpCurent)
           {
                $idp=$z["IDparcare"];
                $sql="DELETE FROM parcare WHERE IDparcare = '$idp' ";
               mysqli_query($mysqli, $sql);
            }
            echo "
            <table style='width: 100% ; text-align: center ; font-size: 100%'>
                <tr>
                    <th>{$z["zona"]}</th>
                        
                </tr>
                <tr>
                         <td>{$diferenta->format('%d/%h/%i/%s')}</td>
                </tr>
            </table>
             ";
        }


        ?>
        <br><br>
        <h6>Zona</h6>

        <form action="" method="post" class="login-form">
            <table style="width: 100% ; text-align: center ; font-size: 100%">
                <tr>
                    <th>A <br>10 RON/Ora</th>
                    <th>B <br>6 RON/Ora</th>
                    <th>C <br>4 RON/Ora</th>
                    <th>D <br>2 RON/Ora</th>
                </tr>
                <tr>
                    <td><input class="radioZona"  type="radio" name="radioZona" value="A" /></td>
                    <td><input class="radioZona"  type="radio" name="radioZona" value="B" /></td>
                    <td><input class="radioZona"  type="radio" name="radioZona" value="C" /></td>
                    <td><input class="radioZona"  type="radio" name="radioZona" value="D" /></td>
                </tr>
            </table>
            <input type="number" name="ore" placeholder="Numarul de ore" />
            <div style="font-size:11px; color:#cc0000; margin-top:10px"><?php echo $error; ?></div>
            <button type="submit" name="plateste" class="btn btn-primary">Plateste</button>
            <br> <br>
            <button type="submit" name="inapoi" class='btn btn-primary'>Inapoi</button>
            <br> <br>
            <button type="submit" name="sterge" class='btn btn-primary'>Sterge Masina</button>
            <br> <br>
        </form>
    </div>
</div>
</body>
</html>