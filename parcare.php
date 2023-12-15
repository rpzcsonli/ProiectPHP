<?php
session_start();
global $mysqli;
include("configurare.php");
$error = "";
$ID=$_SESSION['IDuser'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {


    if (isset($_POST['adaugare'])) {


        if (!empty($_POST['numar'])) {
            $numar = $_POST['numar'];

            $sql = "INSERT INTO masini (numar,IDuser) VALUES ('$numar','$ID')";
            if (mysqli_query($mysqli, $sql)) {
                $error = "<h5 style='color: #6610f2'>Masina a fost adaugata!</h5> </br>";
            }

        } else
            $error = "Introduce un numar!";


    }
    if (isset($_POST['inapoi'])) {
        header("location: meniu.php");
    }
}

echo $_SESSION['masina'];
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
        <h2>Numarul de inmatriculare</h2>
        <br><br>
        <form action="" method="post" class="login-form">

            <input type="text" name="numar" placeholder="Numar" />

            <div style="font-size:11px; color:#cc0000; margin-top:10px"><?php echo $error; ?></div>
            <button type="submit" name="adaugare" class="btn btn-primary">Adaugare</button>
            <br> <br>
            <button type="submit" name="inapoi" class='btn btn-primary'>Inapoi</button>



        </form>
    </div>
</div>
</body>
</html>