<?php

$host = '127.0.0.1';
$dbname = 'z_tech';
$dbusername = "root";
$dbpassword = '';

try{
    $pdo = new PDO("mysql:host=$host; dbname=$dbname", $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo 'sikeres csatlakozas';
}catch(PDOException $e){
    echo 'Csatlakozasi hiba: ' . $e->getMessage();
}





