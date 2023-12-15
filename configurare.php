<?php

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'proiectphp');

$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if($mysqli == false){
    die("Eroare: Conexiunea nu functioneaza. " . $mysqli->connect_error);
}
?>